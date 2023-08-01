<?php
/**
 * The template for displaying the Front Page
 *
 *	Template Name: Front Page Template
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Diviner
 */

get_header('front');
?>

	<main id="primary" class="site-main <?php echo diviner_sidebar_align( 'front' )[0]; ?>">

		<?php
		while ( have_posts() ) :
			the_post();

			do_action('diviner_front_page_content');

		endwhile; // End of the loop.
		?>

	</main><!-- #main -->

<?php
do_action('diviner_sidebar', 'front');
get_footer();