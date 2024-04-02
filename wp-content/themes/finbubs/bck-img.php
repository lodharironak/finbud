<?php
/**
 *Template name: Background Image
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package finbubs
 */

get_header();
?>

	<main id="primary" class="site-main">

		<?php
		while ( have_posts() ) :
			the_post();

			$new 	= imagecreatetruecolor(320,320);
			$color 	= imagecolorallocatealpha($new, 0, 0, 127);
			imagefill($new, 0, 0, $color);
			imagesavealpha($new, TRUE);
			imagepng($new);
		endwhile; // End of the loop.

		?>

	</main><!-- #main -->

<?php
// get_sidebar();
get_footer();
