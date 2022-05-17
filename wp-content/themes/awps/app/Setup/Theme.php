<?php
/**
 * Bootstraps the Theme
 *
 * @package awps
 */

namespace Awps\Setup;


class Theme {
	/**
	 * register default hooks and actions for WordPress
	 * @return
	 */
	public function register() {
		add_action( 'after_setup_theme', [ $this, 'setup' ] );
		add_action( 'after_setup_theme', [ $this, 'content_width' ], 0 );

		add_action( 'acf/init', [ $this, 'theme_settings' ] );
	}

	public function setup() {
		/*
		 * You can activate this if you're planning to build a multilingual theme
		 */
		// load_theme_textdomain( 'awps', get_template_directory() . '/languages' );

		/*
		 * Default Theme Support options better have
		 */
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'customize-selective-refresh-widgets' );
		add_theme_support( 'custom-logo', [
			'header-text' => [
				'site-title',
				'site-description',
			],
			'height'      => 100,
			'width'       => 400,
			'flex-height' => true,
			'flex-width'  => true,
		] );

		/**
		 * Add woocommerce support and woocommerce override
		 */
		// add_theme_support( 'woocommerce' );

		add_theme_support( 'html5', [
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'script',
			'style'
		] );

		add_theme_support( 'custom-background', [
			'default-color'  => 'ffffff',
			'default-image'  => '',
			'default-repeat' => 'no-repeat'
		] );

		/*
		 * Activate Post formats if you need
		 */
		add_theme_support( 'post-formats', [
			'aside',
			'gallery',
			'link',
			'image',
			'quote',
			'status',
			'video',
			'audio',
			'chat',
		] );

		/**
		 * Adds callback for custom TinyMCE editor stylesheets.
		 */
		// add_editor_style();

		/**
		 * Remove Core Block Patterns
		 */
		// remove_theme_support('core-block-patterns');

		/**
		 * The block editor allows themes to opt-in to slightly more opinionated styles for the front end.
		 */
		// add_theme_support('wp-block-styles');

		add_theme_support( 'align-wide' );

		/**
		 * Image sizes
		 */
		add_image_size( 'awps-featured-thumbnail', 460, 307, true );
	}

	/**
	 * Define a max content width to allow WordPress to properly resize your images
	 */
	public function content_width() {
		$GLOBALS[ 'content_width' ] = apply_filters( 'content_width', 1440 );
	}

	public function theme_settings() {
		if ( function_exists( 'acf_add_options_page' ) ) {

			acf_add_options_page( array(
				'page_title' => __( 'Theme General Settings', 'awps' ),
				'menu_title' => __( 'Theme Settings', 'awps' ),
				'menu_slug'  => 'theme-settings',
				'capability' => 'edit_posts',
				'redirect'   => false
			) );

			acf_add_options_sub_page( array(
				'page_title'  => __( 'Theme Header Settings', 'awps' ),
				'menu_title'  => __( 'Header', 'awps' ),
				'parent_slug' => 'theme-settings',
			) );

			acf_add_options_sub_page( array(
				'page_title'  => __( 'Theme Footer Settings', 'awps' ),
				'menu_title'  => __( 'Footer', 'awps' ),
				'parent_slug' => 'theme-settings',
			) );

		}
	}
}
