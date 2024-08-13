<?php
/**
 * Handle the icon shortcode.
 *
 * @link       https://bootstrapped.ventures
 * @since      3.8.0
 *
 * @package    WP_Ultimate_Post_Grid
 * @subpackage WP_Ultimate_Post_Grid/includes/public/shortcodes/item
 */

/**
 * Handle the icon shortcode.
 *
 * @since      3.8.0
 * @package    WP_Ultimate_Post_Grid
 * @subpackage WP_Ultimate_Post_Grid/includes/public/shortcodes/item
 * @author     Brecht Vandersmissen <brecht@bootstrapped.ventures>
 */
class WPUPG_SC_Icon extends WPUPG_Template_Shortcode {
	public static $shortcode = 'wpupg-icon';

	public static function init() {
		self::$attributes = array(
			'icon' => array(
				'default' => '',
                'type' => 'icon',
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
			'icon_size' => array(
				'default' => '16px',
				'type' => 'size',
				'dependency' => array(
					'id' => 'icon',
					'value' => '',
					'type' => 'inverse',
				),
			),
			'style' => array(
				'default' => 'separate',
				'type' => 'dropdown',
				'options' => array(
					'inline' => 'Inline',
					'separate' => 'On its own line',
				),
				'dependency' => array(
					'id' => 'icon',
					'value' => '',
					'type' => 'inverse',
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
				'dependency' => array(
                    array(
                        'id' => 'icon',
                        'value' => '',
                        'type' => 'inverse',
					),
					array(
                        'id' => 'style',
                        'value' => 'separate',
                    ),
				),
			),
			'decoration' => array(
				'default' => 'line',
				'type' => 'dropdown',
				'options' => array(
					'none' => 'None',
					'line' => 'Line',
				),
				'dependency' => array(
                    array(
                        'id' => 'icon',
                        'value' => '',
                        'type' => 'inverse',
					),
					array(
                        'id' => 'style',
                        'value' => 'separate',
                    ),
				),
			),
			'line_color' => array(
				'default' => '#9B9B9B',
				'type' => 'color',
				'dependency' => array(
                    array(
                        'id' => 'icon',
                        'value' => '',
                        'type' => 'inverse',
					),
					array(
                        'id' => 'style',
                        'value' => 'separate',
					),
					array(
                        'id' => 'decoration',
                        'value' => 'line',
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

		$icon = '';
		if ( $atts['icon'] ) {
			$icon = WPUPG_Icon::get( $atts['icon'], $atts['icon_color'] );

			if ( $icon ) {
				$icon = '<span class="wpupg-icon" aria-hidden="true">' . $icon . '</span> ';
			}
		}

		if ( ! $icon ) {
			return '';
		}

		// Output.
		$classes = array(
			'wpupg-icon-shortcode',
			'wpupg-icon-shortcode-' . $atts['style'],
		);
		$before_icon = '';
		$after_icon = '';

		$style = '';
		if ( '16px' !== $atts['icon_size'] ) {
			$style .= 'font-size: ' . $atts['icon_size'] . ';';
			$style .= 'height: ' . $atts['icon_size'] . ';';
		}

		if ( 'separate' === $atts['style'] ) {
			$classes[] = 'wpupg-align-' . $atts['align'];
			$classes[] = 'wpupg-icon-decoration-' . $atts['decoration'];

			if ( 'line' === $atts['decoration'] ) {
				if ( 'left' === $atts['align'] || 'center' === $atts['align'] ) {
					$after_icon = '<div class="wpupg-decoration-line" style="border-color: ' . esc_attr( $atts['line_color'] ) . '"></div>';
				}
				if ( 'right' === $atts['align'] || 'center' === $atts['align'] ) {
					$before_icon = '<div class="wpupg-decoration-line" style="border-color: ' . esc_attr( $atts['line_color'] ) . '"></div>';
				}
			}
		}

		$output = '<div class="' . esc_attr( implode( ' ', $classes ) ) . '" style="' . esc_attr( $style ) .'">' . $before_icon . $icon . $after_icon . '</div>';
		return apply_filters( parent::get_hook(), $output, $atts );
	}
}

WPUPG_SC_Icon::init();