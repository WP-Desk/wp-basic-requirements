<?php


class Test_Basic_Requirement_Checker_Factory extends PHPUnit\Framework\TestCase {
	public function test_can_create_checker_withn_valid_requirements() {
		$existing_locale = 'pl_PL';
		$requirements = array(
			'php'          => '5.6',
			'wp'           => '4.5',
			'plugins'      => array(
				array(
					'name'      => 'woocommerce/woocommerce.php',
					'nice_name' => 'WooCommerce',
				),
			),
			'repo_plugins' => array(
				array(
					'name'      => 'flexible-checkout-fields/flexible-checkout-fields.php',
					'version'   => '1.0',
					'nice_name' => 'Flexible Checkout Fields',
				),
			),
		);

		WP_Mock::wpFunction( 'get_locale' )
		       ->andReturn( $existing_locale );

		$factory = new WPDesk_Basic_Requirement_Checker_Factory();
		$checker = $factory->create_from_requirement_array( 'whatever', 'whatever', $requirements );

		WP_Mock::wpFunction( 'get_plugins' )
		       ->andReturn( array() );

		WP_Mock::wpFunction( 'get_option' )
		       ->withArgs( array( 'active_plugins', array() ) )
		       ->andReturn( array() );

		WP_Mock::passthruFunction( 'self_admin_url' );
		WP_Mock::passthruFunction( 'wp_kses' );
		WP_Mock::passthruFunction( 'wp_nonce_url' );
		WP_Mock::passthruFunction( 'wp_create_nonce' );
		WP_Mock::passthruFunction( 'admin_url' );

		$this->assertFalse( $checker->are_requirements_met(), '2 plugins required and there should be none activated' );

		$this->expectOutputRegex( '/Flexible Checkout Fields/' );
		$this->expectOutputRegex( '/WooCommerce/' );
		$checker->handle_render_notices_action();
	}
}
