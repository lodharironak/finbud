<?php
/**
 * Handle the link shortcode.
 *
 * @link       https://bootstrapped.ventures
 * @since      3.8.0
 *
 * @package    WP_Ultimate_Post_Grid
 * @subpackage WP_Ultimate_Post_Grid/includes/public/shortcodes/item
 */

/**
 * Handle the link shortcode.
 *
 * @since      3.8.0
 * @package    WP_Ultimate_Post_Grid
 * @subpackage WP_Ultimate_Post_Grid/includes/public/shortcodes/item
 * @author     Brecht Vandersmissen <brecht@bootstrapped.ventures>
 */
class WPUPG_SC_Link extends WPUPG_Template_Shortcode {
	public static $shortcode = 'wpupg-link';

	public static function init() {
		self::$attributes = array(
			'link' => array(
				'default' => '',
				'type' => 'text',
			),
			'link_target' => array(
				'default' => '_blank',
				'type' => 'dropdown',
				'options' => array(
					'_self' => 'Open in same tab',
					'_blank' => 'Open in new tab',
				),
				'dependency' => array(
					'id' => 'link',
					'value' => '',
					'type' => 'inverse',
				),
			),
			'link_nofollow' => array(
				'default' => 'nofollow',
				'type' => 'dropdown',
				'options' => array(
					'dofollow' => 'Do not add nofollow attribute',
					'nofollow' => 'Add nofollow attribute',
				),
				'dependency' => array(
					'id' => 'link',
					'value' => '',
					'type' => 'inverse',
				),
			),
			'style' => array(
				'default' => 'text',
				'type' => 'dropdown',
				'options' => array(
					'text' => 'Text',
					'button' => 'Button',
					'inline-button' => 'Inline Button',
					'wide-button' => 'Full Width Button',
				),
			),
			'icon' => array(
				'default' => '',
				'type' => 'icon',
			),
			'text' => array(
				'default' => '',
				'type' => 'text',
			),
			'text_style' => array(
				'default' => 'normal',
				'type' => 'dropdown',
				'options' => 'text_styles',
			),
			'icon_color' => array(
				'default' => '#333333',
				'type' => 'color',
				'dependency' => array(
					'id' => 'icon',
					'value' => '',
					'type' => 'inverse',
				),
			),
			'text_color' => array(
				'default' => '#333333',
				'type' => 'color',
			),
			'horizontal_padding' => array(
				'default' => '5px',
				'type' => 'size',
				'dependency' => array(
					'id' => 'style',
					'value' => 'text',
					'type' => 'inverse',
				),
			),
			'vertical_padding' => array(
				'default' => '5px',
				'type' => 'size',
				'dependency' => array(
					'id' => 'style',
					'value' => 'text',
					'type' => 'inverse',
				),
			),
			'button_color' => array(
				'default' => '#ffffff',
				'type' => 'color',
				'dependency' => array(
					'id' => 'style',
					'value' => 'text',
					'type' => 'inverse',
				),
			),
			'border_color' => array(
				'default' => '#333333',
				'type' => 'color',
				'dependency' => array(
					'id' => 'style',
					'value' => 'text',
					'type' => 'inverse',
				),
			),
			'border_width' => array(
				'default' => '1px',
				'type' => 'size',
				'dependency' => array(
					'id' => 'style',
					'value' => 'text',
					'type' => 'inverse',
				),
			),
			'border_radius' => array(
				'default' => '0px',
				'type' => 'size',
				'dependency' => array(
					'id' => 'style',
					'value' => 'text',
					'type' => 'inverse',
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

		$link = esc_url_raw( $atts['link'] );
		if ( ! $link ) {
			return '';
		}

		// Get optional icon.
		$icon = '';
		if ( $atts['icon'] ) {
			$icon = WPUPG_Icon::get( $atts['icon'], $atts['icon_color'] );

			if ( $icon ) {
				$icon = '<span class="wpupg-icon wpupg-link-icon">' . $icon . '</span> ';
			}
		}

		// Use link as default text.
		$text = $atts['text'];
		if ( ! $text ) {
			$text = $link;
		}

		// Output.
		$classes = array(
			'wpupg-link',
			'wpupg-block-text-' . $atts['text_style'],
		);

		$style = 'color: ' . $atts['text_color'] . ';';
		if ( 'text' !== $atts['style'] ) {
			$classes[] = 'wpupg-link-' . $atts['style'];

			$style .= 'background-color: ' . $atts['button_color'] . ';';
			$style .= 'border-width: ' . $atts['border_width'] . ';';
			$style .= 'border-color: ' . $atts['border_color'] . ';';
			$style .= 'border-radius: ' . $atts['border_radius'] . ';';
			$style .= 'padding: ' . $atts['vertical_padding'] . ' ' . $atts['horizontal_padding'] . ';';
		}

		$nofollow = 'nofollow' === $atts['link_nofollow'] ? ' rel="nofollow"' : '';
		$output = '<a href="' . esc_attr( $link ) . '" target="' . esc_attr( $atts['link_target'] ) . '" class="' . esc_attr( implode( ' ', $classes ) ) . '"' . $nofollow . ' style="' . esc_attr( $style ) . '">' . $icon . WPUPG_Shortcode::sanitize_html( $text ) . '</a>';
		return apply_filters( parent::get_hook(), $output, $atts );
	}
}

WPUPG_SC_Link::init();