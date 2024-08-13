<?php
/**
 * Handle the item image shortcode.
 *
 * @link       https://bootstrapped.ventures
 * @since      3.0.0
 *
 * @package    WP_Ultimate_Post_Grid
 * @subpackage WP_Ultimate_Post_Grid/includes/public/shortcodes/item
 */

/**
 * Handle the item image shortcode.
 *
 * @since      3.0.0
 * @package    WP_Ultimate_Post_Grid
 * @subpackage WP_Ultimate_Post_Grid/includes/public/shortcodes/item
 * @author     Brecht Vandersmissen <brecht@bootstrapped.ventures>
 */
class WPUPG_SC_Image extends WPUPG_Template_Shortcode {
	public static $shortcode = 'wpupg-item-image';

	public static function init() {
		self::$attributes = array(
			'default' => array(
				'default' => '',
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
			'align' => array(
				'default' => 'center',
				'type' => 'dropdown',
				'options' => array(
					'left' => 'Left',
					'center' => 'Center',
					'right' => 'Right',
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
				'default' => '',
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
			'link' => array(
				'default' => '0',
				'type' => 'toggle',
			),
			'link_target' => array(
				'default' => '_self',
				'type' => 'dropdown',
				'options' => array(
					'_self' => 'Open in same tab',
					'_blank' => 'Open in new tab',
				),
				'dependency' => array(
					'id' => 'link',
					'value' => '1',
				),
			),
			'prevent_pinning' => array(
				'default' => '0',
				'type' => 'toggle',
			),
		);
		parent::init();
	}

	/**
	 * Output for the shortcode.
	 *
	 * @since	3.0.0
	 * @param	array $atts Options passed along with the shortcode.
	 */
	public static function shortcode( $atts ) {
		$atts = parent::get_attributes( $atts );

		$item = WPUPG_Template_Shortcodes::get_item();

		if ( ! $item || ! $item->has( 'image' ) ) {
			return '';
		}

		// Use explicit size if set.
		$size = $atts['size'] ? $atts['size'] : $atts['default'];

		// Check if size should be handled as array.
		preg_match( '/^(\d+)x(\d+)$/i', $size, $match );
		if ( ! empty( $match ) ) {
			$size = array( intval( $match[1] ), intval( $match[2] ) );
		}

		// Output.
		$classes = array(
			'wpupg-item-image',
			'wpupg-block-image-' . $atts['style'],
		);

		// Alignment.
		if ( 'left' !== $atts['align'] ) {
			$classes[] = 'wpupg-align-' . $atts['align']; 
		}

		$img = $item->image( $size );

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

		// Prevent lazy image loading.
		if ( WPUPG_Settings::get( 'prevent_lazy_image_loading' ) ) {
			$img = str_ireplace( ' class="', ' class="skip-lazy disable-lazyload ', $img );
			$img = str_ireplace( ' loading="lazy"', ' ', $img );
		}

		// Prevent pinning.
		if ( (bool) $atts['prevent_pinning'] ) {
			$img = str_ireplace( '<img ', '<img data-pin-nopin="true" ', $img );
		}

		// Link image.
		if ( $atts['link'] ) {
			$url = $item->url();

			if ( false !== stripos( $img, ' href="' ) ) {
				$img = preg_replace( '/\shref=\"[^\"]*"/', ' href="' . esc_url( $url ) . '" target="' . esc_attr( $atts['link_target'] ). '"', $img );
			} else {
				$img = '<a href="' . esc_url( $url ) . '" target="' . esc_attr( $atts['link_target'] ) . '">' . $img . '</a>';
			}
		}

		$output = '<div class="' . esc_attr( implode( ' ', $classes ) ) . '">' . $img . '</div>';
		return apply_filters( parent::get_hook(), $output, $atts, $item );
	}
}

WPUPG_SC_Image::init();