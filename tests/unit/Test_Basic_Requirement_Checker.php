<?php
	
	class Test_Basic_Requirement_Checker extends PHPUnit\Framework\TestCase {
		const RANDOM_PLUGIN_FILE = 'file';
		
		const RANDOM_PLUGIN_NAME = 'name';
		
		const RANDOM_PLUGIN_TEXTDOMAIN = 'text';
		
		const ALWAYS_VALID_PHP_VERSION = '5.2';
		
		const ALWAYS_NOT_VALID_PHP_VERSION = '100.100';
		
		const ALWAYS_VALID_WP_VERSION = '4.0';
		
		const HOOK_TYPE_ACTION = 'action';
		
		const ALWAYS_FUNCTION_EXISTS = 'function_exists';
		
		public function setUp() {
			WP_Mock::setUp();
			
			WP_Mock::wpFunction( 'get_bloginfo' )
			       ->andReturn( self::ALWAYS_VALID_WP_VERSION );
			
			WP_Mock::wpFunction( 'get_transient' )
			       ->andReturn( self::ALWAYS_FUNCTION_EXISTS );
			
			WP_Mock::wpFunction('set_transient')
					->andReturn( self::ALWAYS_FUNCTION_EXISTS );
			
			WP_Mock::wpFunction( 'delete_transient' )
					->andReturn( self::ALWAYS_FUNCTION_EXISTS );
		}
		
		public function tearDown() {
			WP_Mock::tearDown();
		}
		
		public function test_php_version_check() {
			$known_PHP_versions = array( '7.3', '7.2', '7.1', '7.0', '5.6', '5.5', '5.4', '5.3', '5.2' );
			
			$requirements = $this->create_requirements_for_php_wp(
				self::ALWAYS_VALID_PHP_VERSION,
				self::ALWAYS_VALID_WP_VERSION );
			
			foreach ( $known_PHP_versions as $version ) {
				$requirements->set_min_php_require( $version );
				if ( version_compare( PHP_VERSION, $version, '>=' ) ) {
					$this->assertTrue( $requirements->are_requirements_met(),
						'Should be ok because WP is OK and PHP is OK' );
				} else {
					$this->assertFalse( $requirements->are_requirements_met(),
						'Should fail because required PHP should be at least  ' . $version );
				}
			}
			$requirements->set_min_php_require( self::ALWAYS_NOT_VALID_PHP_VERSION );
			$requirements->are_requirements_met();
			$this->expectOutputRegex( "/PHP/" );
			$requirements->handle_render_notices_action();
		}
		
		/**
		 * @param string $php
		 * @param string $wp
		 *
		 * @return WPDesk_Basic_Requirement_Checker
		 */
		private function create_requirements_for_php_wp( $php, $wp ) {
			return new WPDesk_Basic_Requirement_Checker( self::RANDOM_PLUGIN_FILE, self::RANDOM_PLUGIN_NAME,
				self::RANDOM_PLUGIN_TEXTDOMAIN, $php, $wp );
		}
		
		public function test_wp_version_check() {
			$wp_version_fail = '4.1';
			
			$requirements = $this->create_requirements_for_php_wp(
				self::ALWAYS_VALID_PHP_VERSION,
				self::ALWAYS_VALID_WP_VERSION );
			
			$this->assertTrue( $requirements->are_requirements_met(), 'Should be ok because WP is OK and PHP is OK' );
			$requirements->set_min_wp_require( $wp_version_fail );
			$this->assertFalse( $requirements->are_requirements_met(),
				'Should fail because required WP should be at least ' . $wp_version_fail );
			
			$this->expectOutputRegex( "/WordPress/" );
			$requirements->handle_render_notices_action();
		}
		
		/**
		 * @requires extension curl
		 */
		public function test_module_check() {
			$requirements = $this->create_requirements_for_php_wp(
				self::ALWAYS_VALID_PHP_VERSION,
				self::ALWAYS_VALID_WP_VERSION );
			
			$requirements->add_php_module_require( 'curl' );
			$this->assertTrue( $requirements->are_requirements_met(), 'Curl should exists' );
			
			$this->expectOutputRegex( "/^$/" );
			$requirements->handle_render_notices_action();
		}
		
		public function test_plugin_check_with_multisite() {
			$multisite                     = true;
			$exising_plugin_name           = 'WooCommerce';
			$exising_multisite_plugin_name = 'Multisite';
			$not_existing_plugin_name      = 'Not exist';
			
			WP_Mock::wpFunction( 'get_option' )
			       ->withArgs( array( 'active_plugins', array() ) )
			       ->andReturn( array( $exising_plugin_name ) );
			
			WP_Mock::wpFunction( 'is_multisite' )
			       ->andReturn( $multisite );
			
			WP_Mock::wpFunction( 'get_site_option' )
			       ->withArgs( array( 'active_sitewide_plugins', array() ) )
			       ->andReturn( array( $exising_multisite_plugin_name ) );
			
			
			$requirements = $this->create_requirements_for_php_wp( self::ALWAYS_VALID_PHP_VERSION,
				self::ALWAYS_VALID_WP_VERSION );
			
			$requirements->add_plugin_require( $exising_plugin_name );
			$this->assertTrue( $requirements->are_requirements_met(), 'Plugin should exists' );
			
			$requirements->add_plugin_require( $exising_multisite_plugin_name );
			$this->assertTrue( $requirements->are_requirements_met(), 'Multisite plugin should exists' );
			
			$requirements->add_plugin_require( $not_existing_plugin_name );
			$this->assertFalse( $requirements->are_requirements_met(), 'Plugin should not exists' );
			
			$this->expectOutputRegex( "/$not_existing_plugin_name/" );
			$requirements->handle_render_notices_action();
		}
		
		/**
		 * @requires extension openssl
		 */
		public function test_existing_openssl_requirement() {
			$open_ssl_always_valid     = 1;
			$open_ssl_always_not_valid = 0x900905000; // 9.9.6
			
			$requirements = $this->create_requirements_for_php_wp( self::ALWAYS_VALID_PHP_VERSION,
				self::ALWAYS_VALID_WP_VERSION );
			
			$this->assertTrue( $requirements->is_open_ssl_at_least( $open_ssl_always_valid ),
				'OpenSSL should have at least 0.1 version if exists' );
			
			$this->assertFalse( $requirements->is_open_ssl_at_least( $open_ssl_always_not_valid ),
				'OpenSSL should fail for that high number' );
			
			$requirements->set_min_openssl_require( $open_ssl_always_not_valid );
			
			$this->assertFalse( $requirements->are_requirements_met(),
				'Requirement OpenSSL should fail for that high number' );
			
			$this->expectOutputRegex( '/without OpenSSL module/' );
			$requirements->handle_render_notices_action();
		}
		
		public function test_deactivate_plugin_notice() {
			$requirements = $this->create_requirements_for_php_wp( self::ALWAYS_NOT_VALID_PHP_VERSION,
				self::ALWAYS_VALID_WP_VERSION );
			
			WP_Mock::expectActionAdded( WPDesk_Basic_Requirement_Checker::HOOK_ADMIN_NOTICES_ACTION,
				array( $requirements, 'handle_render_notices_action' ) );
			
			$this->assertFalse( $requirements->are_requirements_met() );
			$requirements->disable_plugin();
			$requirements->render_notices();
			
			$this->expectOutputRegex( '/cannot run on PHP/' );
			$requirements->handle_render_notices_action();
		}
		
		public function test_add_plugin_repository_require_checks_for_activation_and_installs() {
			$random_version                = "1.0";
			$activated_plugin_name         = 'WooCommerce';
			$not_activated_plugin_name     = "some_other";
			$not_installed_plugin_name     = "not_installed";
			$installed_plugin_names        = array( $activated_plugin_name, $not_activated_plugin_name );
			
			
			WP_Mock::wpFunction( 'get_plugins' )
			       ->andReturn( array_flip( $installed_plugin_names ) );
			
			WP_Mock::wpFunction( 'get_option' )
			       ->withArgs( array( 'active_plugins', array() ) )
			       ->andReturn( array( $activated_plugin_name ) );
			
			WP_Mock::passthruFunction( 'self_admin_url' );
			WP_Mock::passthruFunction( 'wp_kses' );
			WP_Mock::passthruFunction( 'wp_nonce_url' );
			WP_Mock::passthruFunction( 'wp_create_nonce' );
			WP_Mock::passthruFunction( 'admin_url' );
			
			$requirements = $this->create_requirements_for_php_wp( self::ALWAYS_VALID_PHP_VERSION,
				self::ALWAYS_VALID_WP_VERSION );
			
			$requirements->add_plugin_repository_require( $activated_plugin_name, $random_version );
			$this->assertTrue( $requirements->are_requirements_met(), "Should be met for activated plugin" );
			
			$requirements->add_plugin_require( $activated_plugin_name, $random_version );
			$this->assertTrue( $requirements->are_requirements_met(), 'Should be met for required plugins' );
			
			$requirements->add_plugin_repository_require( $not_activated_plugin_name, $random_version );
			$this->assertFalse( $requirements->are_requirements_met(), "Should NOT be met for only installed plugin" );
			
			$requirements->add_plugin_require( $not_activated_plugin_name, $random_version );
			$this->assertFalse( $requirements->are_requirements_met(), "Should NOT be met for only installed plugin" );
			
			$this->expectOutputRegex( "/Activate $not_activated_plugin_name/" );
			$requirements->handle_render_notices_action();
			
			$requirements->add_plugin_repository_require( $not_installed_plugin_name, $random_version );
			$this->expectOutputRegex( "/Install $not_installed_plugin_name/" );
			$this->assertFalse( $requirements->are_requirements_met(),
				"Should NOT be met - uninstalled and unactive plugins are required" );
			$requirements->handle_render_notices_action();
		}
	}