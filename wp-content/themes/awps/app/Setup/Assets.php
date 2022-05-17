<?php

namespace Awps\Setup;

/**
 * Enqueue.
 */
class Assets {

	private string $css_uri;
	private string $css_dir;

	private string $js_uri;
	private string $js_dir;

	public function __construct() {
		$this->css_uri = get_template_directory_uri() . '/assets/css/';
		$this->css_dir = get_template_directory() . '/assets/css/';

		$this->js_uri = get_template_directory_uri() . '/assets/js/';
		$this->js_dir = get_template_directory() . '/assets/js/';
	}

	/**
	 * register default hooks and actions for WordPress
	 * @return
	 */
	public function register() {
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue' ] );
//		add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_admin' ] );

//		add_action( 'wp_enqueue_scripts', [ $this, 'remove_block_styles' ], 100 );
	}

	public function enqueue() {

		// CSS
		wp_enqueue_style( 'awps_main-style', $this->css_uri . 'main.css', [], filemtime( $this->css_dir . 'main.css' ),
			'all' );

		// JS
		wp_enqueue_script( 'awps_main-script', $this->js_uri . 'app.js', [], filemtime( $this->js_dir . 'app.js' ),
			true );
	}

	public function enqueue_admin() {
		// CSS
		wp_enqueue_style( 'awps_admin-style', $this->css_uri . 'admin.css', [], filemtime(
			$this->css_dir . 'admin.css' ), 'all' );
		// JS
		wp_enqueue_script( 'awps_admin-script', $this->js_uri . 'admin.js', [], filemtime(
			$this->js_dir . 'admin.js' ), true );
	}

	public function remove_block_styles() {
		wp_dequeue_style('wp-block-library');
		wp_dequeue_style('wp-block-library-theme');
		wp_dequeue_style('wp-block-style'); // Remove WooCommerce block CSS
	}
}
