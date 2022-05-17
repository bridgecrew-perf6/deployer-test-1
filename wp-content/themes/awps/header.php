<?php
/**
 * Header template.
 *
 * @package awps
 */
?>

<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php
if ( function_exists( 'wp_body_open' ) ) {
	wp_body_open();
}
?>

<div class="wrapper">

    <header class="header" role="banner">
        <div class="header__container">
			<?php get_template_part( 'views/header/nav', '', [ 'class' => 'header__menu' ] ); ?>
        </div>
    </header>
