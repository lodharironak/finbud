<?php
/**
 * Handle the item excerpt shortcode.
 *
 * @link       https://bootstrapped.ventures
 * @since      3.0.0
 *
 * @package    WP_Ultimate_Post_Grid
 * @subpackage WP_Ultimate_Post_Grid/includes/public/shortcodes/item
 */

/**
 * Handle the item excerpt shortcode.
 *
 * @since      3.0.0
 * @package    WP_Ultimate_Post_Grid
 * @subpackage WP_Ultimate_Post_Grid/includes/public/shortcodes/item
 * @author     Brecht Vandersmissen <brecht@bootstrapped.ventures>
 */
class WPUPG_SC_Excerpt extends WPUPG_Template_Shortcode {
	public static $shortcode = 'wpupg-item-excerpt';

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
		);
		$atts = array_merge( $atts, WPUPG_Template_Helper::get_label_container_atts() );
		$atts = array_merge( $atts, WPUPG_Template_Helper::limit_text_atts() );

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
			'wpupg-item-excerpt',
			'wpupg-block-text-' . $atts['text_style'],
		);

		// Alignment.
		if ( 'block' === $atts['display'] && 'left' !== $atts['align'] ) {
			$classes[] = 'wpupg-align-' . $atts['align']; 
		}

		$label_container = WPUPG_Template_Helper::get_label_container( $atts, 'excerpt' );
		$tag = 'block' === $atts['display'] ? 'div' : 'span';

		$text = WPUPG_Template_Helper::limit_text( $atts, $item->excerpt() );
		
		$output = '<' . esc_attr( $tag ) . ' class="' . esc_attr( implode( ' ', $classes ) ) . '">' . $label_container . $text . '</' . esc_attr( $tag ) . '>';
		return apply_filters( parent::get_hook(), $output, $atts, $item );
	}
}

WPUPG_SC_Excerpt::init();