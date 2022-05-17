<?php

namespace Awps\Widgets;

use WP_Query;
use WP_Widget;

/**
 * Custom Widget.
 */
class LatestPosts extends WP_Widget {
	public $widget_ID;

	public $widget_name;

	public $widget_options = [];

	public $control_options = [];

	function __construct() {

		$this->widget_ID = 'awps_latest_posts';

		$this->widget_name = __( 'Awps | Latest Posts', 'awps' );

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
		$recent_posts = new WP_Query( [
			'ignore_sticky_posts' => true,
			'post_type'           => 'post',
			'posts_per_page'      => isset( $instance[ 'posts_count' ] ) ? intval( $instance[ 'posts_count' ] ) : 4,
			'orderby'             => isset( $instance[ 'sort_by' ] ) ? $this->sanitize_sort_by( $instance[ 'sort_by' ] ) : 'date'
		] );
		echo $args[ 'before_widget' ];
		if ( ! empty( $instance[ 'title' ] ) ) {
			echo $args[ 'before_title' ] . apply_filters( 'widget_title',
					$instance[ 'title' ] ) . $args[ 'after_title' ];
		}
		get_template_part( '/views/widgets/latest-posts', 'null', [
			'post'         => $recent_posts,
			'include_date' => $instance[ 'include_date' ]
		] );
		wp_reset_postdata();
		echo $args[ 'after_widget' ];
	}

	/**
	 * Outputs the options form on admin
	 *
	 * @param  array  $instance  The widget options
	 */
	public function form( $instance ) {
		$title        = $instance[ 'title' ] ?? esc_html__( 'Latest Posts', 'awps' );
		$posts_count  = $instance[ 'posts_count' ] ?? 4;
		$include_date = $instance[ 'include_date' ] ?? false;
		$sort_by      = $instance[ 'sort_by' ] ?? 'date';
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
            <label for="<?php echo esc_attr( $this->get_field_id( 'posts_count' ) ); ?>">
				<?php esc_attr_e( 'Number of Posts:', 'awps' ); ?>
            </label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'posts_count' ) ); ?>"
                   name="<?php echo esc_attr( $this->get_field_name( 'posts_count' ) ); ?>"
                   type="number"
                   min="1"
                   value="<?php echo esc_attr( $posts_count ); ?>">
        </p>
        <p>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'include_date' ) ); ?>"
                   name="<?php echo esc_attr( $this->get_field_name( 'include_date' ) ); ?>"
                   type="checkbox"
				<?php checked( $include_date ); ?>>
            <label for="<?php echo esc_attr( $this->get_field_id( 'include_date' ) ); ?>">
				<?php esc_attr_e( 'Include Date', 'awps' ); ?>
            </label>
        </p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'sort_by' ) ); ?>">
				<?php esc_attr_e( 'Sort by', 'awps' ); ?>
            </label>
            <select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'sort_by' ) ); ?>"
                    name="<?php echo esc_attr( $this->get_field_name( 'sort_by' ) ); ?>"
                    type="checkbox">
                <option <?php selected( $include_date, 'date' ); ?> value="date"><?php esc_html_e( 'Most Recent',
						'awps' );
					?></option>
                <option <?php selected( $include_date, 'rand' ); ?> value="rand"><?php esc_html_e( 'Random', 'awps' );
					?></option>
                <option <?php selected( $include_date, 'comment_count' ); ?>
                        value="comment_count"><?php esc_html_e( 'Number of Comments',
						'awps' ); ?></option>
            </select>
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
		$instance                   = $old_instance;
		$instance[ 'title' ]        = sanitize_text_field( $new_instance[ 'title' ] );
		$instance[ 'posts_count' ]  = intval( $new_instance[ 'posts_count' ] );
		$instance[ 'include_date' ] = boolval( $new_instance[ 'include_date' ] );
		$instance[ 'sort_by' ]      = $this->sanitize_sort_by( $new_instance[ 'sort_by' ] );

		return $instance;
	}

	private function sanitize_sort_by( $input ) {
		$valid = [ 'date', 'random', 'comment_count' ];

		return in_array( $input, $valid, true ) ? $input : 'date';
	}
}
