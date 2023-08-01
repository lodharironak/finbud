<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Diviner
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('single'); ?>>
	<header class="entry-header">
		<?php
		if ( is_singular() ) :
			the_title( '<h1 class="entry-title title-font">', '</h1>' );
		else :
			the_title( '<h2 class="entry-title title-font"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
		endif;

		if ( 'post' === get_post_type() ) :
			?>
			<div class="entry-meta">
				<?php
				diviner_posted_on();
				diviner_posted_by();
				?>
			</div><!-- .entry-meta -->
		<?php endif; ?>
	</header><!-- .entry-header -->

	<?php diviner_post_thumbnail(); ?>

	<div class="entry-content">
		<?php
		the_content(
			sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'diviner' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				wp_kses_post( get_the_title() )
			)
		);

		wp_link_pages(
			array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'diviner' ),
				'after'  => '</div>',
			)
		);
		?>

		<?php if (has_post_format('image') ) : ?>
		<div id="diviner_img_links">

			<?php
				$thumb_id	=	get_post_thumbnail_id();
				$small		=	'diviner_small';
				$medium		=	'diviner_medium';
				$large		=	'diviner_large';
			?>

			<div class="download_button button-small"><a href="<?php echo esc_url( the_post_thumbnail_url($small) ); ?>" target="_blank"><div class="download_text"><?php esc_html_e('Download Small image', 'diviner') ?></div><div class="dim"><?php esc_html( diviner_thumb_dim( $thumb_id, $small)['width'] ) . ' x ' . esc_html( diviner_thumb_dim( $thumb_id, $small)['height'] ) ?></div></a></div>

			<div class="download_button button-medium"><a href="<?php echo the_post_thumbnail_url($medium); ?>" target="_blank"><div class="download_text"><?php esc_html_e('Download SD image', 'diviner'); ?></div><div class="dim"><?php diviner_thumb_dim( $thumb_id, $medium)['width'] . ' x ' . diviner_thumb_dim( $thumb_id, $medium)['height']; ?></div></a></div>

			<div class="download_button button-large"><a href="<?php echo esc_url(the_post_thumbnail_url($large)); ?>" target="_blank"><div class="download_text"><?php esc_html_e('Download HD image', 'diviner'); ?></div><div class="dim"><?php esc_html(diviner_thumb_dim( $thumb_id, $large)['width']) . ' x ' . esc_html(diviner_thumb_dim( $thumb_id, $large)['height']); ?></div></a></div>

			<div class="download_button button-full"><a href="<?php echo esc_url(the_post_thumbnail_url('full')); ?>" target="_blank"><div class="download_text"><?php esc_html_e('Download Full image', 'diviner'); ?></div><div class="dim"><?php esc_html(diviner_thumb_dim( $thumb_id, 'full')['width']) . ' x ' . esc_html(diviner_thumb_dim( $thumb_id, 'full')['height']); ?></div></a></div>
		</div>
	<?php endif; ?>

	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php diviner_entry_footer(); ?>
		<?php do_action( 'diviner_about_author', $post ); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-<?php the_ID(); ?> -->