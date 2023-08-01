<?php
/**
 * Template part for displaying results in search pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Diviner
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="entry-header">
		<?php the_title( sprintf( '<h2 class="entry-title title-font"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

		<div class="featured-thumb">
	        <?php do_action('diviner_featured_thumbnail', 'blog') ?>
	    </div>

		<?php if ( 'post' === get_post_type() ) : ?>
		<div class="entry-meta">
			<?php
				do_action('diviner_metadata');
			?>
		</div><!-- .entry-meta -->
		<?php endif; ?>
	</header><!-- .entry-header -->

	<div class="entry-summary">
		 <?php do_action('diviner_blog_excerpt', 50); ?>
	</div><!-- .entry-summary -->

	<?php diviner_read_more_link(); ?><!--- .read-more --->

	<footer class="entry-footer">
		<?php diviner_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-<?php the_ID(); ?> -->