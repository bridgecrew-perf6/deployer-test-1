<?php
/**
 * Single Post template file.
 *
 * @package awps
 */

use Awps\Models\Pagination;

get_header();
?>

    <main class="main-content" role="main">
        <div class="main-content__container">
			<?php if ( have_posts() ) : ?>
				<?php
				if ( is_home() && ! is_front_page() ):
					?>
                    <header>
                        <h1 class="page-title">
							<?php single_post_title(); ?>
                        </h1>
                    </header>
				<?php
				endif;
				?>

				<?php while ( have_posts() ) : the_post(); ?>
					<?php get_template_part( 'views/content' ); ?>
				<?php endwhile; ?>

			<?php else : ?>
				<?php get_template_part( 'views/content', 'none' ); ?>
			<?php endif; ?>

	        <?php get_sidebar(); ?>

			<?php Pagination::render(); ?>
        </div>
    </main>

<?php
get_footer();

