<?php
/**
 * Handle the item custom field shortcode.
 *
 * @link       https://bootstrapped.ventures
 * @since      3.0.0
 *
 * @package    WP_Ultimate_Post_Grid
 * @subpackage WP_Ultimate_Post_Grid/includes/public/shortcodes/item
 */

/**
 * Handle the item custom field shortcode.
 *
 * @since      3.0.0
 * @package    WP_Ultimate_Post_Grid
 * @subpackage WP_Ultimate_Post_Grid/includes/public/shortcodes/item
 * @author     Brecht Vandersmissen <brecht@bootstrapped.ventures>
 */
class WPUPG_SC_Custom_Field extends WPUPG_Template_Shortcode {
	public static $shortcode = 'wpupg-item-custom-field';

	public static function init() {
		$atts = array(
			'key' => array(
				'default' => '',
				'type' => 'text',
				'help' => 'Key of the Custom Field you want to display.',
			),
			'type' => array(
				'default' => 'text',
				'type' => 'dropdown',
				'options' => array(
					'text' => 'Text',
					'acf_date' => 'ACF - Date',
					'acf_image' => 'ACF - Image',
					'acf_link' => 'ACF - Link',
					'acf_multiselect' => 'ACF - Multi-select',
				),
			),
			'date_format' => array(
				'default' => 'F j, Y',
				'type' => 'text',
				'help' => __( 'Use the PHP date format. Leave empty to use default WordPress date format from the Settings > General page.', 'wp-ultimate-post-grid' ),
				'dependency' => array(
					'id' => 'type',
					'value' => 'acf_date',
				),
			),
			'size' => array(
				'default' => 'thumbnail',
				'type' => 'image_size',
				'dependency' => array(
					'id' => 'type',
					'value' => 'acf_image',
				),
			),
			'separator' => array(
				'default' => ', ',
				'type' => 'text',
				'dependency' => array(
					'id' => 'type',
					'value' => 'acf_multiselect',
				),
			),
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
		);

		$atts = array_merge( $atts, WPUPG_Template_Helper::get_label_container_atts() );
		$atts = array_merge( $atts, WPUPG_Template_Helper::limit_text_atts() );

		// Only limit text if it's a text type.
		$atts['limit_text']['dependency'] = array(
			'id' => 'type',
			'value' => 'text',
		);

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
		$custom_field = $item->custom_field( $atts['key'] );
		if ( ! $item || ! $custom_field || ! is_string( $custom_field ) ) {
			return '';
		}

		// Output.
		$classes = array(
			'wpupg-item-custom-field',
			'wpupg-block-text-' . $atts['text_style'],
		);

		// Alignment.
		if ( 'block' === $atts['display'] && 'left' !== $atts['align'] ) {
			$classes[] = 'wpupg-align-' . $atts['align']; 
		}

		// Limit text if text type.
		if ( 'text' === $atts['type'] ) {
			$custom_field = WPUPG_Template_Helper::limit_text( $atts, $custom_field );
		} else {
			$custom_field = self::parse_acf( $custom_field, $atts );
		}

		// Allow filtering in code.
		$custom_field = apply_filters( 'wpupg_custom_field', $custom_field, $atts, $item );

		$label_container = WPUPG_Template_Helper::get_label_container( $atts, 'custom-field' );
		$tag = 'block' === $atts['display'] ? 'div' : 'span';
		$output = '<' . esc_attr( $tag ) . ' class="' . esc_attr( implode( ' ', $classes ) ) . '">' . $label_container . WPUPG_Shortcode::sanitize_html( $custom_field ) . '</' . esc_attr( $tag ) . '>';
		return apply_filters( parent::get_hook(), $output, $atts, $item );
	}

	/**
	 * Output for different ACF field types.
	 *
	 * @since	3.7.0
	 * @param	mixed $custom_field Current custom field value.
	 * @param	array $atts Options passed along with the shortcode.
	 */
	private static function parse_acf( $custom_field, $atts ) {
		$parsed = '';
		switch ( $atts['type'] ) {
			case 'acf_date':
				$format = $atts['date_format'];
				if ( ! $format ) {
					$format = get_option( 'date_format' );
				}

				$parsed = date_i18n( $format, strtotime( $custom_field ) );
				break;
			case 'acf_image':
				$image_id = intval( $custom_field );
				
				if ( $image_id ) {
					// Use explicit size if set.
					$size = $atts['size'] ? $atts['size'] : $atts['default'];

					// Check if size should be handled as array.
					preg_match( '/^(\d+)x(\d+)$/i', $size, $match );
					if ( ! empty( $match ) ) {
						$size = array( intval( $match[1] ), intval( $match[2] ) );
					}

					$parsed = wp_get_attachment_image( $image_id, $size );
				}
				break;
			case 'acf_link':
				$link = maybe_unserialize( $custom_field );

				if ( is_array( $link ) && isset( $link['url'] ) ) {
					$url = $link['url'];
					$text = isset( $link['title'] ) && $link['title'] ? $link['title'] : $url;
					$target = isset( $link['target'] ) && $link['target'] ? ' target="' . esc_attr( $link['target'] ) . '"' : '';
					
					$parsed = '<a href="' . esc_attr( $url ) . '"' . $target . '>' . esc_html( $text ) . '</a>';
				}
				break;
			case 'acf_multiselect':
				$values = maybe_unserialize( $custom_field );

				if ( is_array( $values ) ) {
					$separator = $atts['separator'];
					$parsed = implode( $separator, $values );
				}
				break;
		}

		return $parsed;
	}
}

WPUPG_SC_Custom_Field::init();