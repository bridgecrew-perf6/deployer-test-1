<?php
/** @var array $args */
?>

<nav class="pagination">
    <ul class="pagination__list">
		<?php foreach ( $args as $item ) : ?>
			<?php
			if ( $item[ 'text' ] ):
				$href = $item[ 'link' ] ? ' href="' . $item[ 'link' ] . '"' : '';
				$modifier = $item[ 'type' ] === 'page' ? '' : ' pagination__item--' . $item[ 'type' ];
				?>
                <li class="pagination__list-item">
	                <?php
                    printf(
                        '<a%1$s class="pagination__item%2$s">%3$s</a>',
                        $href,
                        $modifier,
                        $item[ 'text' ]
                    );
                    ?>
                </li>
			<?php endif; ?>
		<?php endforeach; ?>
    </ul>
</nav>
