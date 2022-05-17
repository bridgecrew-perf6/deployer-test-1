<?php
/**
 * Template for entry content.
 *
 * To be used inside WordPress The Loop.
 *
 * @package awps
 */

use Awps\Models\Post;

?>

<div class="entry-content">
	<?php
	if ( is_single() ):
		the_content(
			sprintf(
				wp_kses(
				/* translators: %s: Name of current post. */
					__( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'aquila' ),
					[
						'span' => [
							'class' => [],
						],
					]
				),
				the_title( '<span class="screen-reader-text">"', '"</span>', false )
			)
		);

		wp_link_pages(
			[
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'awps' ),
				'after'  => '</div>',
			]
		);

	else:
		?>
        <div class="truncate-4">
			<?php Post::the_excerpt( 200 ); ?>
        </div>
		<?php
		echo Post::excerpt_more();
	endif;

	?>
</div>
