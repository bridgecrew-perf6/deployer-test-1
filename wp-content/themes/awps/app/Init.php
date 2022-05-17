<?php


namespace Awps;


final class Init {
	/**
	 * Store all the classes inside an array
	 * @return array Full list of classes
	 */
	public static function get_services() {
		return [
			Setup\Theme::class,
			Setup\Menus::class,
			Setup\Assets::class,
			Plugins\Plugins::class,
			Custom\GFPolylang::class,
			Models\Post::class,
			Core\Sidebar::class,
			// Widgets
			Widgets\LatestPosts::class,
			Widgets\Categories::class,
			// Post Types
//			Models\Book::class,
		];
	}

	/**
	 * Loop through the classes, initialize them, and call the register() method if it exists
	 * @return
	 */
	public static function register_services() {
		foreach ( self::get_services() as $class ) {
			$service = self::instantiate( $class );
			if ( method_exists( $service, 'register' ) ) {
				$service->register();
			}
		}
	}

	/**
	 * Initialize the class
	 *
	 * @param  class  $class  class from the services array
	 *
	 * @return class instance        new instance of the class
	 */
	private static function instantiate( $class ) {
		return new $class();
	}
}
