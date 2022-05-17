<?php

namespace Awps\Models;

class Post {

	public static function get_thumbnail( $post_id, $size = 'featured-image', $additional_attributes = [] ): string {
		$thumbnail = '';
		if ( $post_id === null ) {
			$post_id = get_the_ID();
		}

		$default_attributes = [];
		if ( has_post_thumbnail( $post_id ) ) {
			$default_attributes = [
				'loading' => 'lazy'
			];
		}

		$attributes = array_merge( $additional_attributes, $default_attributes );

		return wp_get_attachment_image(
			get_post_thumbnail_id( $post_id ),
			$size,
			false,
			$attributes
		);
	}

	public static function the_thumbnail( $post_id, $size = 'featured-image', $additional_attributes = [] ) {
		echo self::get_thumbnail( $post_id, $size, $additional_attributes );
	}

	public static function posted_on() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';

		// Post id modified (when post published time is not equal to post modified time).
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published visually-hidden" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf( $time_string,
			esc_attr( get_the_date( DATE_W3C ) ),
			esc_attr( get_the_date() ),
			esc_attr( get_the_modified_date( DATE_W3C ) ),
			esc_attr( get_the_modified_date() ),
		);

		$posted_on = sprintf(
			esc_html_x( 'Posted on %s', 'post date', 'awps' ),
			'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
		);

		echo '<span class="posted-on">' . $posted_on . '</span>';
	}

	/**
	 * Prints HTML with meta information for the current author.
	 *
	 * @return void
	 */
	public static function posted_by() {
		$byline = sprintf(
			esc_html_x( ' by %s', 'post author', 'awps' ),
			'<span class="author vcard">
						<a href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a>
					</span>'
		);

		echo '<span class="byline text-secondary">' . $byline . '</span>';
	}

	/**
	 * Get the trimmed version of post excerpt.
	 *
	 * This is for modifing manually entered excerpts,
	 * NOT automatic ones WordPress will grab from the content.
	 *
	 * It will display the first given characters ( e.g. 100 ) characters of a manually entered excerpt,
	 * but instead of ending on the nth( e.g. 100th ) character,
	 * it will truncate after the closest word.
	 *
	 * @param  int  $trim_character_count  Charter count to be trimmed
	 *
	 * @return bool|string
	 */
	public static function the_excerpt( $trim_character_count = 0 ) {
		$post_ID = get_the_ID();

		if ( empty( $post_ID ) ) {
			return null;
		}

		if ( has_excerpt() || 0 === $trim_character_count ) {
			the_excerpt();

			return null;
		}

		$excerpt = wp_html_excerpt( get_the_excerpt( $post_ID ), $trim_character_count, '[...]' );


		echo $excerpt;
	}

	/**
	 * Filter the "read more" excerpt string link to the post.
	 *
	 * @param  string  $more  "Read more" excerpt string.
	 *
	 * @return string (Maybe) modified "read more" excerpt string.
	 */
	public static function excerpt_more( $more = '' ): string {

		if ( ! is_single() ) {
			$more = sprintf( '<a class="read-more text-white mt-3 btn btn-info" href="%1$s">%2$s</a>',
				get_permalink( get_the_ID() ),
				__( 'Read more', 'awps' )
			);
		}

		return $more;
	}
}
