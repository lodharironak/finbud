<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Diviner
 */

get_header('page');
if ( class_exists('woocommerce') ) :
	$wc = class_exists('woocommerce') && ( is_woocommerce() || is_checkout() || is_cart() || is_account_page() ) == true ? 'wc' : 'page';
else :
	$wc = 'page';
endif;
?>


	<main id="primary" class="site-main <?php echo diviner_sidebar_align( 'page' )[0]; ?>">

		<?php
		while ( have_posts() ) :
			the_post();

			get_template_part( 'template-parts/content', 'page' );

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;

		endwhile; // End of the loop.
		?>

	</main><!-- #main -->

<?php
do_action('diviner_sidebar', $wc );
get_footer();