<?php
/**
 * Handle the item title shortcode.
 *
 * @link       https://bootstrapped.ventures
 * @since      3.0.0
 *
 * @package    WP_Ultimate_Post_Grid
 * @subpackage WP_Ultimate_Post_Grid/includes/public/shortcodes/item
 */

/**
 * Handle the item title shortcode.
 *
 * @since      3.0.0
 * @package    WP_Ultimate_Post_Grid
 * @subpackage WP_Ultimate_Post_Grid/includes/public/shortcodes/item
 * @author     Brecht Vandersmissen <brecht@bootstrapped.ventures>
 */
class WPUPG_SC_Title extends WPUPG_Template_Shortcode {
	public static $shortcode = 'wpupg-item-title';

	public static function init() {
		$atts = array(
			'text_style' => array(
				'default' => 'bold',
				'type' => 'dropdown',
				'options' => 'text_styles',
			),
			'tag' => array(
				'default' => 'div',
				'type' => 'dropdown',
				'options' => 'header_tags',
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
					'id' => 'tag',
					'value' => 'span',
					'type' => 'inverse',
				),
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
		);
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
			'wpupg-item-title',
			'wpupg-block-text-' . $atts['text_style'],
		);

		// Alignment.
		if ( 'span' !== $atts['tag'] && 'left' !== $atts['align'] ) {
			$classes[] = 'wpupg-align-' . $atts['align']; 
		}

		$title = WPUPG_Template_Helper::limit_text( $atts, $item->title() );

		// Optionally add link.
		if ( $atts['link'] ) {
			$title = '<a href="' . esc_attr( $item->url() ) . '" target="' . $atts['link_target']. '">' . $title . '</a>';
		}

		$tag = WPUPG_Shortcode::sanitize_html_element( $atts['tag'] );
		$output = '<' . esc_attr( $tag ) . ' class="' . esc_attr( implode( ' ', $classes ) ) . '">' . WPUPG_Shortcode::sanitize_html( $title ) . '</' . esc_attr( $tag ) . '>';
		return apply_filters( parent::get_hook(), $output, $atts, $item );
	}
}

WPUPG_SC_Title::init();