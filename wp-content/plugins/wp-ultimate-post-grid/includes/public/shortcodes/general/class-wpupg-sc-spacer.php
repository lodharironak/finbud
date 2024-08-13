<?php
/**
 * Handle the spacer shortcode.
 *
 * @link       https://bootstrapped.ventures
 * @since      3.5.0
 *
 * @package    WP_Ultimate_Post_Grid
 * @subpackage WP_Ultimate_Post_Grid/includes/public/shortcodes/item
 */

/**
 * Handle the spacer shortcode.
 *
 * @since      3.5.0
 * @package    WP_Ultimate_Post_Grid
 * @subpackage WP_Ultimate_Post_Grid/includes/public/shortcodes/item
 * @author     Brecht Vandersmissen <brecht@bootstrapped.ventures>
 */
class WPUPG_SC_Spacer extends WPUPG_Template_Shortcode {
	public static $shortcode = 'wpupg-spacer';

	public static function init() {
		self::$attributes = array(
			'size' => array(
				'default' => '10px',
				'type' => 'size',
			),
		);
		parent::init();
	}

	/**
	 * Output for the shortcode.
	 *
	 * @since	4.0.0
	 * @param	array $atts Options passed along with the shortcode.
	 */
	public static function shortcode( $atts ) {
		$atts = parent::get_attributes( $atts );

		$style = '10px' === $atts['size'] ? '' : ' style="height: ' . esc_attr( $atts['size'] ) . '"';
		$output = '<div class="wpupg-spacer"' . $style . '></div>';

		return apply_filters( parent::get_hook(), $output, $atts );
	}
}

WPUPG_SC_Spacer::init();