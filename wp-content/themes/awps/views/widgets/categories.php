<?php
/** @var array $args */
?>

<?php if ( $args[ 'categories' ] ): ?>
    <ul class="widget-categories">
		<?php foreach ( $args[ 'categories' ] as $category ): ?>
            <li>
                <a href="<?php echo esc_url( get_category_link( $category->term_id ) ); ?>" class="categorie"><?php
					esc_html_e
					( $category->name );
					?></a>
                <span class="ml-auto">
                        <?php
                        echo sprintf(
	                        _n( '%s Post', '%s Posts', $category->category_count, 'awps' ),
	                        $category->category_count
                        );
                        ?>
                    </span>
            </li>
		<?php endforeach; ?>
    </ul>
<?php endif; ?>
