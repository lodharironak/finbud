<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Diviner
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('col col-md-6 grid2_s'); ?>>
	
	<div class="featured-thumb">
	  <?php do_action('diviner_featured_thumbnail', 'grid') ?>
	
	  <header class="entry-header">
		  <h3 class="entry-title title-font">
		      <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute() ?>">
		        <?php the_title(); ?>
		      </a>
		  </h3>
	  </header><!-- .entry-header -->
	</div>
	
</article><!-- #post-<?php the_ID(); ?> -->
