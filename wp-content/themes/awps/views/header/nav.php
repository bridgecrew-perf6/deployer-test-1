<?php
/**
 * Header Navigation template.
 *
 * @package awps
 */

/** @var array $args */
?>

<nav class="menu <?php echo $args[ 'class' ]; ?>">
    <div class="container">
		<?php
		if ( function_exists( 'the_custom_logo' ) ) :
			the_custom_logo();
		else:
			?>
            <a class="logo" href="#"></a>
		<?php endif; ?>
        <button class="menu__burger burger">
            <span class="burger__line"></span>
        </button>

		<?php
		if ( has_nav_menu( 'awps_header_menu' ) ) {
			wp_nav_menu( [
				'theme_location' => 'awps_header_menu',
				'walker'         => new Awps\Core\WalkerNav(),
				'container'      => false
			] );
		}
		?>
    </div>
</nav>
