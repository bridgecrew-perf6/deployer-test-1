<?php
/**
 * Main template file.
 *
 * @package awps
 */

use Awps\Models\Pagination;

get_header();
?>

    <main class="main-content" role="main">
		<?php if ( have_posts() ) : ?>
        <div class="main-content__container">

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

            <div class="main-content__grid">
				<?php while ( have_posts() ) : the_post(); ?>
					<?php get_template_part( 'views/content' ); ?>
				<?php endwhile; ?>
            </div>

			<?php else : ?>
				<?php get_template_part( 'views/content', 'none' ); ?>
			<?php endif; ?>

            <?php Pagination::render(); ?>
        </div>
    </main>

<?php
get_footer();

