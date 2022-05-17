<?php
/** @var array $args */
$i = 1;
?>

<?php
if ( $args[ 'post' ]->have_posts() ): ?>
    <ul class="widget-latest-posts">
		<?php while ( $args[ 'post' ]->have_posts() ): $args[ 'post' ]->the_post(); ?>
            <li class="last-post">
				<?php if ( get_the_post_thumbnail_url() ): ?>
                    <div class="image">
                        <a href="<?php the_permalink(); ?>">
                            <img src="<?php echo get_the_post_thumbnail_url() ?>"
                                 alt="<?php echo get_the_title(); ?>">
                        </a>
                    </div>
				<?php endif; ?>
                <div class="nb"><?php echo $i; ?></div>
                <div class="content">
                    <p>
                        <a href="<?php the_permalink(); ?>"
                           title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
                    </p>
					<?php if ( isset( $args[ 'include_date' ] ) && $args[ 'include_date' ] ): ?>
                        <small>
                            <span class="icon_clock_alt"></span> <?php echo get_the_date(); ?>
                        </small>
					<?php endif; ?>
                </div>
            </li>
			<?php $i ++; endwhile; ?>
    </ul>
<?php endif; ?>
