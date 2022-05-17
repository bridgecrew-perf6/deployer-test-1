<?php

namespace Awps\Widgets;

use WP_Widget;

/**
 * Custom Widget.
 */
class Categories extends WP_Widget {
	public $widget_ID;

	public $widget_name;

	public $widget_options = [];

	public $control_options = [];

	function __construct() {

		$this->widget_ID = 'awps_categories';

		$this->widget_name = __( 'Awps | Categories', 'awps' );

		$this->widget_options = [
			'classname'                   => $this->widget_ID,
			'description'                 => $this->widget_name . ' Widget',
			'customize_selective_refresh' => true,
		];

		$this->control_options = [
			'width'  => 400,
			'height' => 350,
		];
	}

	/**
	 * register default hooks and actions for WordPress
	 * @return
	 */
	public function register() {
		parent::__construct( $this->widget_ID, $this->widget_name, $this->widget_options, $this->control_options );

		add_action( 'widgets_init', [ $this, 'widgetsInit' ] );
	}

	/**
	 * Register this widget
	 */
	public function widgetsInit() {
		register_widget( $this );
	}

	/**
	 * Outputs the content of the widget
	 *
	 * @param  array  $args
	 * @param  array  $instance
	 */
	public function widget( $args, $instance ) {
		$cats = get_categories( [
			'number' => isset( $instance[ 'cats_count' ] ) ? intval( $instance[ 'cats_count' ] ) : 4,
		] );
		get_template_part( '/views/widgets/categories', 'null', [
			'categories'  => $cats,
			'title' => $instance[ 'title' ],
		] );
		wp_reset_postdata();
	}

	/**
	 * Outputs the options form on admin
	 *
	 * @param  array  $instance  The widget options
	 */
	public function form( $instance ) {
		$title      = $instance[ 'title' ] ?? esc_html__( 'Categories', 'awps' );
		$cats_count = $instance[ 'cats_count' ] ?? 4;
		?>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>">
				<?php esc_attr_e( 'Title:', 'awps' ); ?>
            </label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"
                   name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text"
                   value="<?php echo esc_attr( $title ); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'cats_count' ) ); ?>">
				<?php esc_attr_e( 'Number of Posts:', 'awps' ); ?>
            </label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'cats_count' ) ); ?>"
                   name="<?php echo esc_attr( $this->get_field_name( 'cats_count' ) ); ?>"
                   type="number"
                   min="1"
                   value="<?php echo esc_attr( $cats_count ); ?>">
        </p>
		<?php
	}

	/**
	 * Processing widget options on save
	 *
	 * @param  array  $new_instance  The new options
	 * @param  array  $old_instance  The previous options
	 */
	public function update( $new_instance, $old_instance ) {
		$instance                  = $old_instance;
		$instance[ 'title' ]       = sanitize_text_field( $new_instance[ 'title' ] );
		$instance[ 'posts_count' ] = intval( $new_instance[ 'posts_count' ] );

		return $instance;
	}

	private function sanitize_sort_by( $input ) {
		$valid = [ 'date', 'random', 'comment_count' ];

		return in_array( $input, $valid, true ) ? $input : 'date';
	}
}
