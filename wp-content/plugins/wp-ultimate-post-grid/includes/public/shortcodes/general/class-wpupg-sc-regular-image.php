<?php
/**
 * Handle the image shortcode.
 *
 * @link       https://bootstrapped.ventures
 * @since      3.8.0
 *
 * @package    WP_Ultimate_Post_Grid
 * @subpackage WP_Ultimate_Post_Grid/includes/public/shortcodes/item
 */

/**
 * Handle the image shortcode.
 *
 * @since      3.8.0
 * @package    WP_Ultimate_Post_Grid
 * @subpackage WP_Ultimate_Post_Grid/includes/public/shortcodes/item
 * @author     Brecht Vandersmissen <brecht@bootstrapped.ventures>
 */
class WPUPG_SC_Regular_Image extends WPUPG_Template_Shortcode {
	public static $shortcode = 'wpupg-image';

	public static function init() {
		self::$attributes = array(
			'image_id' => array(
				'default' => '0',
				'type' => 'image',
			),
			'style' => array(
				'default' => 'normal',
				'type' => 'dropdown',
				'options' => array(
					'normal' => 'Normal',
					'rounded' => 'Rounded',
					'circle' => 'Circle',
				),
			),
			'rounded_radius' => array(
				'default' => '5px',
				'type' => 'size',
				'dependency' => array(
					'id' => 'style',
					'value' => 'rounded',
				),
			),
			'size' => array(
				'default' => 'medium',
				'type' => 'image_size'
			),
			'border_width' => array(
				'default' => '0px',
				'type' => 'size',
			),
			'border_style' => array(
				'default' => 'solid',
				'type' => 'dropdown',
				'options' => 'border_styles',
			),
			'border_color' => array(
				'default' => '#666666',
				'type' => 'color',
			),
			'align' => array(
				'default' => 'left',
				'type' => 'dropdown',
				'options' => array(
					'left' => 'Left',
					'center' => 'Center',
					'right' => 'Right',
				),
			),
		);
		parent::init();
	}

	/**
	 * Output for the shortcode.
	 *
	 * @since	3.8.0
	 * @param	array $atts Options passed along with the shortcode.
	 */
	public static function shortcode( $atts ) {
		$atts = parent::get_attributes( $atts );

		$image_id = intval( $atts['image_id'] );
		if ( ! $image_id ) {
			return '';
		}

		$size = $atts['size'];

		// Check if size should be handled as array.
		preg_match( '/^(\d+)x(\d+)$/i', $size, $match );
		if ( ! empty( $match ) ) {
			$size = array( intval( $match[1] ), intval( $match[2] ) );
		}

		// Get image.
		$img = wp_get_attachment_image( $image_id, $size );

		if ( ! $img ) {
			return '';
		}

		// Output.
		$classes = array(
			'wpupg-image',
			'wpupg-block-image-' . $atts['style'],
		);

		// Align.
		if ( 'left' !== $atts['align'] ) {
			$classes[] = 'wpupg-align-' . esc_attr( $atts['align'] );
		}

		// Image Style.
		$style = '';
		$style .= 'border-width: ' . $atts['border_width'] . ';';
		$style .= 'border-style: ' . $atts['border_style'] . ';';
		$style .= 'border-color: ' . $atts['border_color'] . ';';

		if ( 'rounded' === $atts['style'] ) {
			$style .= 'border-radius: ' . $atts['rounded_radius'] . ';';
		}

		if ( $style ) {
			if ( false !== stripos( $img, ' style="' ) ) {
				$img = str_ireplace( ' style="', ' style="' . esc_attr( $style ), $img );
			} else {
				$img = str_ireplace( '<img ', '<img style="' . esc_attr( $style ) . '" ', $img );
			}
		}

		$output = '<div class="' . esc_attr( implode( ' ', $classes ) ) . '">' . $img . '</div>';
		return apply_filters( parent::get_hook(), $output, $atts );
	}
}

WPUPG_SC_Regular_Image::init();