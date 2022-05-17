<?php
/**
 * Template for displaying a message that posts cannot be found
 *
 * @package awps
 */
?>

<section>
    <header class="page-header">
        <h1 class="page-title"><?php esc_html_e( 'Nothing Found', 'awps' ); ?></h1>
    </header>

    <div class="page-content">
		<?php
		if ( is_home() && current_user_can( 'publish_posts' ) ) :
			?>
            <p>
				<?php
				printf(
					wp_kses(
						__( 'Ready to publish your first post? <a href="%s">Get started here</a>', 'awps' ),
						[
							'a' => [
								'href' => []
							]
						]
					),
					esc_url( admin_url( 'post-new.php' ) )
				);
				?>
            </p>
		<?php
        elseif ( is_search() ) :
			?>
            <p>
				<?php
				esc_html_e( 'Sorry but nothing matched your search item. Please try again with some different words',
					'awps' );
				?>
				<?php get_search_form(); ?>
            </p>
		<?php else: ?>
			<?php
			esc_html_e( 'Sorry but nothing matched your search item. Perhaps search can help.', 'awps' );
			?>
			<?php get_search_form(); ?>
		<?php endif; ?>
    </div>
</section>

