<?php

class Test_Basic_Requirement_Checker_With_Update_Disable extends PHPUnit\Framework\TestCase {
	const RANDOM_PLUGIN_FILE = 'file';
	const RANDOM_PLUGIN_NAME = 'name';
	const ALWAYS_VALID_PHP_VERSION = '5.2';
	const ALWAYS_VALID_WP_VERSION = '4.0';
	const RANDOM_PLUGIN_TEXTDOMAIN = 'text';

	public function setUp(): void {
		WP_Mock::setUp();

		WP_Mock::wpFunction( 'get_bloginfo' )
		       ->andReturn( self::ALWAYS_VALID_WP_VERSION );
	}

	public function tearDown(): void {
		WP_Mock::tearDown();
	}

	public function test_requirements_are_not_met_when_plugin_update() {
		$checker = new WPDesk_Basic_Requirement_Checker_With_Update_Disable( self::RANDOM_PLUGIN_FILE,
			self::RANDOM_PLUGIN_NAME,
			self::RANDOM_PLUGIN_TEXTDOMAIN, self::ALWAYS_VALID_PHP_VERSION, self::ALWAYS_VALID_WP_VERSION );

		$this->assertTrue( $checker->are_requirements_met(), 'Initial php and wp version should be met' );

		$valid_plugin_name = 'woocommerce/woocommerce.php';

		WP_Mock::wpFunction( 'get_option' )
		       ->withArgs( array( 'active_plugins', array() ) )
		       ->andReturn( array( $valid_plugin_name ) );

		$checker->add_plugin_require( $valid_plugin_name );
		$this->assertTrue( $checker->are_requirements_met(), 'Plugin is activated so initial requirements should be met' );

		$real_woocommerce_upgrade_url = '/wp-admin/update.php?action=upgrade-plugin&plugin=woocommerce%2Fwoocommerce.php&_wpnonce=263d805825';
		$url                     = parse_url( $real_woocommerce_upgrade_url );
		parse_str( $url['query'], $_GET );
		$this->assertFalse( $checker->are_requirements_met(), 'Info about upgrade should switch result' );
	}
}
