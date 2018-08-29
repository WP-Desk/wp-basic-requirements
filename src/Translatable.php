<?php

/**
 * Have info about textdomain - how to translate texts
 *
 * have to be compatible with PHP 5.2.x
 */
interface WPDesk_Translatable  {
	/** @return string */
	public function get_text_domain();
}