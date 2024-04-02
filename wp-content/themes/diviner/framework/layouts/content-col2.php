<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Diviner
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('col col-md-6 col2'); ?>>

	<div class="featured-thumb">
	  <?php do_action('diviner_featured_thumbnail', 'blog') ?>
	</div>

	<header class="entry-header">

		<h3 class="entry-title title-font">
			<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute() ?>">
				<?php the_title(); ?>
			</a>
		</h3>
		
	    <?php
	    do_action('diviner_metadata');
	  	?>
	  	
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php
		    do_action('diviner_blog_excerpt', get_theme_mod('diviner_excerpt_length', 50) );
		?>
	</div><!-- .entry-content -->

  <?php edit_post_link(); ?>

</article><!-- #post-<?php the_ID(); ?> -->