<?php

if ( ! class_exists( 'Basic_Requirement_Checker' ) ) {
	require_once 'Basic_Requirement_Checker.php';
}

/**
 * Falicitates createion of requirement checker
 */
class WPDesk_Basic_Requirement_Checker_Factory {
	/**
	 * Creates a simplest possible version of requirement checker.
	 *
	 * @param string $plugin_file
	 * @param string $plugin_name
	 * @param string $text_domain
	 * @param string $php_version
	 * @param string $wp_version
	 *
	 * @return WPDesk_Requirement_Checker
	 */
	public function create_requirement_checker( $plugin_file, $plugin_name, $text_domain ) {
		return new WPDesk_Basic_Requirement_Checker( $plugin_file, $plugin_name, $text_domain, null, null );
	}

	/**
	 * Creates a requirement checker according to given requirements array info.
	 *
	 * @param string $plugin_file
	 * @param string $plugin_name
	 * @param string $plugin_text_domain
	 * @param array $requirements
	 *
	 * @return WPDesk_Requirement_Checker
	 */
	public function create_from_requirement_array( $plugin_file, $plugin_name, $plugin_text_domain, $requirements ) {
		$requirements_checker = new WPDesk_Basic_Requirement_Checker(
			$plugin_file,
			$plugin_name,
			$plugin_text_domain,
			$requirements['php'],
			$requirements['wp']
		);

	    if ( isset( $requirements['plugins'] ) ) {
		    foreach ( $requirements['plugins'] as $requirement ) {
			    $requirements_checker->add_plugin_require( $requirement['name'], $requirement['nice_name'] );
		    }
	    }

	    if ( isset( $requirements['modules'] ) ) {
		    foreach ( $requirements['modules'] as $requirement ) {
			    $requirements_checker->add_php_module_require( $requirement['name'], $requirement['nice_name'] );
		    }
	    }

	    return $requirements_checker;
    }
}
