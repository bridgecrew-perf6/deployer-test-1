<?php
/**
 * Content template
 *
 * @package awps
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'post__item' ); ?>>
	<?php
	get_template_part( 'views/components/blog/entry-header' );
	get_template_part( 'views/components/blog/entry-meta' );
	get_template_part( 'views/components/blog/entry-content' );
	get_template_part( 'views/components/blog/entry-footer' );
	?>
</article>
