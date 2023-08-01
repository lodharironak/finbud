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

	<div class="featured-thumb">
        <?php do_action('diviner_featured_thumbnail', 'blog') ?>
    </div>

	<header class="entry-header">
		<?php the_title( sprintf( '<h2 class="entry-title title-font"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

		<?php if ( 'post' === get_post_type() ) : ?>
			<?php
				do_action('diviner_metadata');
			?>
		<?php endif; ?>
	</header><!-- .entry-header -->

	<div class="entry-summary">
		<?php do_action('diviner_blog_excerpt', 30 ); ?>
	</div><!-- .entry-summary -->

	<footer class="entry-footer">
		<?php diviner_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-<?php the_ID(); ?> -->