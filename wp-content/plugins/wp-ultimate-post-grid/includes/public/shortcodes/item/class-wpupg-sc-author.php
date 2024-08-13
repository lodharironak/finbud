<?php
/**
 * Handle the item author shortcode.
 *
 * @link       https://bootstrapped.ventures
 * @since      3.0.0
 *
 * @package    WP_Ultimate_Post_Grid
 * @subpackage WP_Ultimate_Post_Grid/includes/public/shortcodes/item
 */

/**
 * Handle the item author shortcode.
 *
 * @since      3.0.0
 * @package    WP_Ultimate_Post_Grid
 * @subpackage WP_Ultimate_Post_Grid/includes/public/shortcodes/item
 * @author     Brecht Vandersmissen <brecht@bootstrapped.ventures>
 */
class WPUPG_SC_Author extends WPUPG_Template_Shortcode {
	public static $shortcode = 'wpupg-item-author';

	public static function init() {
		$atts = array(
			'display' => array(
				'default' => 'inline',
				'type' => 'dropdown',
				'options' => 'display_options',
			),
			'align' => array(
				'default' => 'left',
				'type' => 'dropdown',
				'options' => array(
					'left' => 'Left',
					'center' => 'Center',
					'right' => 'Right',
				),
				'dependency' => array(
					'id' => 'display',
					'value' => 'block',
				),
			),
			'text_style' => array(
				'default' => 'normal',
				'type' => 'dropdown',
				'options' => 'text_styles',
			),
			'author_image' => array(
				'default' => '0',
				'type' => 'toggle',
			),
			'image_style' => array(
				'default' => 'circle',
				'type' => 'dropdown',
				'options' => array(
					'normal' => 'Normal',
					'rounded' => 'Rounded',
					'circle' => 'Circle',
				),
				'dependency' => array(
					'id' => 'author_image',
					'value' => '1',
				),
			),
			'rounded_radius' => array(
				'default' => '5px',
				'type' => 'size',
				'dependency' => array(
					array(
						'id' => 'author_image',
						'value' => '1',
					),
					array(
						'id' => 'image_style',
						'value' => 'rounded',
					),
				),
			),
			'image_size' => array(
				'default' => '30px',
				'type' => 'size',
				'dependency' => array(
					'id' => 'author_image',
					'value' => '1',
				),
			),
			'image_border_width' => array(
				'default' => '0px',
				'type' => 'size',
				'dependency' => array(
					'id' => 'author_image',
					'value' => '1',
				),
			),
			'image_border_style' => array(
				'default' => 'solid',
				'type' => 'dropdown',
				'options' => 'border_styles',
				'dependency' => array(
					array(
						'id' => 'author_image',
						'value' => '1',
					),
					array(
						'id' => 'image_border_width',
						'value' => '0px',
						'type' => 'inverse',
					),
				),
			),
			'image_border_color' => array(
				'default' => '#666666',
				'type' => 'color',
				'dependency' => array(
					array(
						'id' => 'author_image',
						'value' => '1',
					),
					array(
						'id' => 'image_border_width',
						'value' => '0px',
						'type' => 'inverse',
					),
				),
			),
		);

		$atts = array_merge( $atts, WPUPG_Template_Helper::get_label_container_atts() );

		self::$attributes = $atts;
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
		if ( ! $item ) {
			return '';
		}

		// Output.
		$classes = array(
			'wpupg-item-author',
			'wpupg-block-text-' . $atts['text_style'],
		);

		// Alignment.
		if ( 'block' === $atts['display'] && 'left' !== $atts['align'] ) {
			$classes[] = 'wpupg-align-' . $atts['align']; 
		}

		$author_output = $item->author();

		// Optional author image.
		$img = '';
		if ( (bool) $atts['author_image'] ) {
			$author_id = $item->author_id();

			if ( $author_id ) {
				$img = get_avatar( $author_id, $atts['image_size'] );

				// Image Style.
				$style = '';
				$style .= 'border-width: ' . $atts['image_border_width'] . ';';
				$style .= 'border-style: ' . $atts['image_border_style'] . ';';
				$style .= 'border-color: ' . $atts['image_border_color'] . ';';

				if ( 'rounded' === $atts['image_style'] ) {
					$style .= 'border-radius: ' . $atts['rounded_radius'] . ';';
				} elseif ( 'circle' === $atts['image_style'] ) {
					$style .= 'border-radius: 50%;';
				}

				if ( $style ) {
					if ( false !== stripos( $img, ' style="' ) ) {
						$img = str_ireplace( ' style="', ' style="' . esc_attr( $style ), $img );
					} else {
						$img = str_ireplace( '<img ', '<img style="' . esc_attr( $style ) . '" ', $img );
					}
				}
			}
		}

		if ( $img ) {
			$author_output = '<span class="wpupg-item-author-with-image"><span class="wpupg-item-author-image">' . $img . '</span>' . WPUPG_Shortcode::sanitize_html( $author_output ) . '</span>';
		}

		$label_container = WPUPG_Template_Helper::get_label_container( $atts, 'author' );
		$tag = 'block' === $atts['display'] ? 'div' : 'span';
		$output = '<' . esc_attr( $tag ) . ' class="' . esc_attr( implode( ' ', $classes ) ) . '">' . $label_container . $author_output . '</' . esc_attr( $tag ) . '>';
		return apply_filters( parent::get_hook(), $output, $atts, $item );
	}
}

WPUPG_SC_Author::init();