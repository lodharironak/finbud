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
 * @package catprotectioncenter
 */

get_header();
?>

	<main id="primary" class="site-main">
		<?php
		if ( have_posts() ) :
			if ( is_home() && ! is_front_page() ) :
				?>
				<header>
					<h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
				</header>
				<?php
			endif;
			/* Start the Loop */
            ?>
            <div class="blog-main">
            <?php 
			while ( have_posts() ) :
				the_post(); 
                get_template_part( 'template-parts/content', get_post_type() );
            ?>
            <?php endwhile; ?>
            </div>
            <?php
			//   the_posts_navigation();

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif;
         global $wp_the_query;
        $count = $wp_the_query->found_posts; 
        // echo $count;
		?>
        <div class="blog-btn text-center">
            <a href="javascript:;" class="btn btn-transparent" id="load-more" data-total=<?php echo $count; ?>>
            <div id="display_loading"><img src="https://miro.medium.com/max/1400/1*CsJ05WEGfunYMLGfsT2sXA.gif" height="100%" width="100%"></div>
                <?php esc_html_e( 'View All News', 'finbubs' ); ?></a>
        </div> 
	</main><!-- #main -->
<?php  
// get_sidebar();
get_footer();