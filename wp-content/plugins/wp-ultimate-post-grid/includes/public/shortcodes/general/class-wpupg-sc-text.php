<?php
/**
 * Handle the text shortcode.
 *
 * @link       https://bootstrapped.ventures
 * @since      3.8.0
 *
 * @package    WP_Ultimate_Post_Grid
 * @subpackage WP_Ultimate_Post_Grid/includes/public/shortcodes/item
 */

/**
 * Handle the text shortcode.
 *
 * @since      3.8.0
 * @package    WP_Ultimate_Post_Grid
 * @subpackage WP_Ultimate_Post_Grid/includes/public/shortcodes/item
 * @author     Brecht Vandersmissen <brecht@bootstrapped.ventures>
 */
class WPUPG_SC_Text extends WPUPG_Template_Shortcode {
	public static $shortcode = 'wpupg-text';

	public static function init() {
		self::$attributes = array(
			'text' => array(
				'default' => '',
				'type' => 'text',
			),
			'text_style' => array(
				'default' => 'normal',
				'type' => 'dropdown',
				'options' => 'text_styles',
			),
			'tag' => array(
				'default' => 'p',
				'type' => 'dropdown',
				'options' => array(
					'p' => 'p',
					'span' => 'span',
					'div' => 'div',
					'h1' => 'h1',
					'h2' => 'h2',
					'h3' => 'h3',
					'h4' => 'h4',
					'h5' => 'h5',
					'h6' => 'h6',
				),
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
                    array(
                        'id' => 'tag',
                        'value' => 'span',
                        'type' => 'inverse',
					),
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

		$text = $atts['text'];
		if ( ! $text ) {
			return '';
		}

		// Output.
		$classes = array(
			'wpupg-text',
			'wpupg-block-text-' . $atts['text_style'],
		);

		$output = '';
		$tag = WPUPG_Shortcode::sanitize_html_element( $atts['tag'] );

		// Alignment.
		if ( 'span' !== $tag && 'left' !== $atts['align'] ) {
			$classes[] = 'wpupg-align-' . esc_attr( $atts['align'] );
		}

		$output .= '<' . esc_attr( $tag ) . ' class="' . esc_attr( implode( ' ', $classes ) ) . '">' . WPUPG_Shortcode::sanitize_html( $text ) . '</' . esc_attr( $tag ) . '>';

		return apply_filters( parent::get_hook(), $output, $atts );
	}
}

WPUPG_SC_Text::init();