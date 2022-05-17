<?php
/**
 * Template for post entry header
 *
 * @package awps
 */

use Awps\Models\Post;

$post_id            = get_the_ID();
$has_post_thumbnail = get_the_post_thumbnail( $post_id );
?>

<header class="entry-header">
	<?php
	if ( $has_post_thumbnail ):
		?>
        <div class="entry-image">
            <a href="<?php echo esc_url( get_permalink() ); ?>">
				<?php Post::the_thumbnail(
					$post_id,
					'awps-featured-thumbnail',
					[
						'sizes' => '(max-width: 460px) 460px, 307px',
						'class' => 'attachment-featured-large size-featured-image'
					]
				); ?>
            </a>
        </div>
	<?php else: ?>
        <div class="entry-image">
            <img src="https://via.placeholder.com/460x306.png" alt="">
        </div>
	<?php endif; ?>

	<?php
	// title
	if ( is_single() || is_page() ):
		printf(
			'<h1 class="page-title %1$s">%2$s</h1>',
			esc_attr( 'page-title--modifier' ),
			wp_kses_post( get_the_title() )
		);
	else:
		printf(
			'<h2 class="entry-title"><a href="%1$s">%2$s</a></h2>',
			esc_url( get_the_permalink() ),
			wp_kses_post( get_the_title() )
		);
	endif;
	?>
</header>
