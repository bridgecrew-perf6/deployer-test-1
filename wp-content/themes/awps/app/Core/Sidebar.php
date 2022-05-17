<?php


namespace Awps\Core;


class Sidebar {

	/**
	 * register default hooks and actions for WordPress
	 * @return
	 */
	public function register() {
		add_action( 'widgets_init', [ $this, 'widgets_init' ] );
	}

	/*
		Define the sidebar
	*/
	public function widgets_init() {
		register_sidebar( [
			'id'            => 'awps-primary-sidebar',
			'name'          => __( 'Sidebar', 'awps' ),
			'description'   => __( 'Default sidebar to add all your widgets.', 'awps' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget__title">',
			'after_title'   => '</h2>',
		] );
	}
}
