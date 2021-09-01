<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package fideline-theme
 */
get_header();
?>

<div class="content">
<a href="contact">Allez sur la page contact</a>
</div>

<?php echo do_shortcode("[welcome-form]"); ?>

<?php
get_footer();

?>
