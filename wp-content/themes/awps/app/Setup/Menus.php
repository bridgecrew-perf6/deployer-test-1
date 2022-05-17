<?php

namespace Awps\Setup;

/**
 * Menus
 */
class Menus {
	/**
	 * register default hooks and actions for WordPress
	 * @return
	 */
	public function register() {
		add_action( 'after_setup_theme', [ $this, 'menus' ] );
	}

	public function menus() {
		/*
			Register all your menus here
		*/
		register_nav_menus( [
			'awps_header_menu' => esc_html__( 'Header Menu', 'awps' ),
		] );
	}
}
