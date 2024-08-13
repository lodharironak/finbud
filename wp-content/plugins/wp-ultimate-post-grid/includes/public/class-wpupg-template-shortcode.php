<?php
/**
 * Parent class for the template shortcodes.
 *
 * @link       https://bootstrapped.ventures
 * @since      3.0.0
 *
 * @package    WP_Ultimate_Post_Grid
 * @subpackage WP_Ultimate_Post_Grid/includes/public
 */

/**
 * Parent class for the template shortcodes.
 *
 * @since      3.0.0
 * @package    WP_Ultimate_Post_Grid
 * @subpackage WP_Ultimate_Post_Grid/includes/public
 * @author     Brecht Vandersmissen <brecht@bootstrapped.ventures>
 */
class WPUPG_Template_Shortcode {
	public static $attributes = array();
	public static $shortcode = '';

	public static function init() {
		$shortcode = static::$shortcode;

		if ( $shortcode ) {
			// Register shortcode in WordPress.
			add_shortcode( $shortcode, array( get_called_class(), 'shortcode' ) );

			// Add to list of all shortcodes.
			WPUPG_Template_Shortcodes::$shortcodes[ $shortcode ] = static::$attributes;
		}
	}

	public static function get_hook() {		
		return str_replace( '-', '_', static::$shortcode ) . '_shortcode';
	}

	protected static function get_attributes( $atts ) {
		$atts = shortcode_atts( WPUPG_Template_Shortcodes::get_defaults( static::$shortcode ), $atts, str_replace( '-', '_', static::$shortcode ) );

		return $atts;
	}
}
