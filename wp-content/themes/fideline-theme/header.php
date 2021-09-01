<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package fideline-theme
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
	<header id="masthead" class="site-header">
	<a href="#" class="logo"><img src="./wp-content/themes/fideline-theme/sass/img/logo.png" height="100%" width="100%" alt="logo IUM"></a>

	<nav id="site-navigation">
			<ul>
				<li><a href="#events">Events</a></li>
				<li><a href="#download" class="link2">Download</a></li>
				<li><a href="#apply" class="link3">Apply</a></li>
				<li class="lang"><a href="#">FR</a></li>
				<li class="lang active"><a href="#">EN</a></li>
			</ul>
		</nav><!-- #site-navigation -->
	</header><!-- #masthead -->
