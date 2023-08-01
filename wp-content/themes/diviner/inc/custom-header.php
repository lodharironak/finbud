<?php
/**
 * Sample implementation of the Custom Header feature
 *
 * You can add an optional custom header image to header.php like so ...
 *
	<?php the_header_image_tag(); ?>
 *
 * @link https://developer.wordpress.org/themes/functionality/custom-headers/
 *
 * @package Diviner
 */

/**
 * Set up the WordPress core custom header feature.
 *
 * @uses diviner_header_style()
 */
function diviner_custom_header_setup() {
	add_theme_support(
		'custom-header',
		apply_filters(
			'diviner_custom_header_args',
			array(
				'default-image'      => get_template_directory_uri() . '/assets/images/header.jpg',
				'default-text-color' => '000000',
				'width'              => 1920,
				'height'             => 1080,
				'flex-height'        => true,
				'wp-head-callback'   => 'diviner_header_style',
			)
		)
	);
}
add_action( 'after_setup_theme', 'diviner_custom_header_setup' );

if ( ! function_exists( 'diviner_header_style' ) ) :
	/**
	 * Styles the header image and text displayed on the blog.
	 *
	 * @see diviner_custom_header_setup().
	 */
	function diviner_header_style() {
		$header_text_color = get_header_textcolor();
		// If we get this far, we have custom styles. Let's do this.
		?>
		<style type="text/css">
		<?php
				?>
				#header-image {
						height: <?php echo absint( get_theme_mod('diviner_default_header_height', 500) ); ?>px;
						background-image: url(<?php echo esc_url( get_header_image() ) ?>);
						background-size: <?php echo esc_html( get_theme_mod('diviner_header_bg_size', 'cover') ); ?>;
						background-repeat: repeat;
						background-position: <?php echo esc_html( get_theme_mod('diviner_header_bg_position', 'center') ); ?>;
						background-attachment: <?php echo esc_html( get_theme_mod('diviner_bg_parallax', 'scroll') ); ?>;
				}
				<?php


		 /*
 		 * If no custom options for text are set, let's bail.
 		 * get_header_textcolor() options: Any hex value, 'blank' to hide text. Default: add_theme_support( 'custom-header' ).
 		 */


		// Has the text been hidden?
		if ( ! display_header_text() ) :
			?>
			.site-title,
			.site-description {
				position: absolute;
				clip: rect(1px, 1px, 1px, 1px);
				}
			<?php
			// If the user has set a custom color for the text use that.
		else :
			?>
			.site-title a,
			.site-description {
				color: #<?php echo esc_attr( $header_text_color ); ?>;
			}
		<?php endif; ?>
		</style>
		<?php
	}
endif;