<?php
/**
 * Handle the grid shortcodes.
 *
 * @link       https://bootstrapped.ventures
 * @since      3.0.0
 *
 * @package    WP_Ultimate_Post_Grid
 * @subpackage WP_Ultimate_Post_Grid/includes/public
 */

/**
 * Handle the grid shortcodes.
 *
 * @since      3.0.0
 * @package    WP_Ultimate_Post_Grid
 * @subpackage WP_Ultimate_Post_Grid/includes/public
 * @author     Brecht Vandersmissen <brecht@bootstrapped.ventures>
 */
class WPUPG_Template_Shortcodes {
	private static $current_item = false;
	public static $shortcodes = array();
	public static $defaults = array();
	private static $parsed = false;

	/**
	 * Register actions and filters.
	 *
	 * @since	3.0.0
	 */
	public static function init() {
		self::load_shortcodes();
	}

	/**
	 * Get item to output.
	 *
	 * @since	3.0.0
	 */
	public static function get_item() {
		return self::$current_item;
	}

	/**
	 * Set the current item.
	 *
	 * @since	3.0.0
	 * @param	mixed $item Current item to output.
	 */
	public static function set_current_item( $item ) {
		if ( false === $item ) {
			$item = apply_filters( 'wpupg_unset_current_item', $item );
		} else {
			$item = apply_filters( 'wpupg_set_current_item', $item );
		}
		self::$current_item = $item;
	}

	/**
	 * Load all available shortcodes from the /includes/public/shortcodes directory.
	 *
	 * @since	3.0.0
	 */
	private static function load_shortcodes() {
		$dirs = array(
			WPUPG_DIR . 'includes/public/shortcodes/general',
			WPUPG_DIR . 'includes/public/shortcodes/item',
			WPUPG_DIR . 'includes/public/shortcodes/special',
		);

		foreach ( $dirs as $dir ) {
			if ( ! is_dir( $dir ) ) {
				continue;
			}

			if ( $handle = opendir( $dir ) ) {
				while ( false !== ( $file = readdir( $handle ) ) ) {
					preg_match( '/^class-wpupg-sc-(.*?).php/', $file, $match );
					if ( isset( $match[1] ) ) {
						require_once( $dir . '/' . $match[0] );
					}
				}
			}
		}
	}

	/**
	 * Get all available shortcodes.
	 *
	 * @since	3.0.0
	 */
	public static function get_shortcodes() {
		if ( ! self::$parsed ) {
			self::parse_shortcodes();
		}

		return apply_filters( 'wpupg_template_editor_shortcodes', self::$shortcodes );
	}

	/**
	 * Get the defaults for a specific shortcode.
	 *
	 * @since	3.0.0
	 * @param	mixed $shortcode Shortcode to get the defaults for.
	 */
	public static function get_defaults( $shortcode ) {
		if ( ! self::$parsed ) {
			self::parse_shortcodes();
		}

		return isset( self::$defaults[ $shortcode ] ) ? self::$defaults[ $shortcode ] : array();
	}

	/**
	 * Parse all shortcodes.
	 *
	 * @since	3.0.0
	 */
	public static function parse_shortcodes() {
		$premium_only = class_exists( 'WPUPG_Addons' ) && WPUPG_Addons::is_active( 'premium' ) ? '' : ' (' . __( 'WP Ultimate Post Grid Premium only', 'wp-ultimate-post-grid' ) . ')';
		
		$shortcodes = self::$shortcodes;
		$defaults = array();

		foreach ( $shortcodes as $shortcode => $attributes ) {			
			$defaults[ $shortcode ] = array();
			foreach ( $shortcodes[ $shortcode ] as $attribute => $options ) {
				// Save defaults separately for easy access.
				$defaults[ $shortcode ][ $attribute ] = isset( $options['default'] ) ? $options['default'] : '';

				// Resueable option arrays.
				if ( isset( $options['type'] ) && 'dropdown' === $options['type'] && ! is_array( $options['options'] ) ) {
					switch ( $options['options'] ) {
						case 'display_options':
							$shortcodes[ $shortcode ][ $attribute ]['options'] = array(
								'inline' => 'Inline',
								'block' => 'On its own line',
							);
							break;
						case 'header_tags':
							$shortcodes[ $shortcode ][ $attribute ]['options'] = array(
								'span' => 'span',
								'div' => 'div',
								'h1' => 'h1',
								'h2' => 'h2',
								'h3' => 'h3',
								'h4' => 'h4',
								'h5' => 'h5',
								'h6' => 'h6',
							);
							break;
						case 'text_styles':
							$shortcodes[ $shortcode ][ $attribute ]['options'] = array(
								'normal' => 'Normal',
								'light' => 'Light',
								'bold' => 'Bold',
								'italic' => 'Italic',
								'uppercase' => 'Uppercase',
								'faded' => 'Faded',
								'uppercase-faded' => 'Uppercase & Faded',
								'smaller' => 'Smaller',
								'bigger' => 'Bigger',
							);
							break;
						case 'border_styles':
							$shortcodes[ $shortcode ][ $attribute ]['options'] = array(
								'solid' => 'Solid',
								'dashed' => 'Dashed',
								'dotted' => 'Dotted',
								'double' => 'Double',
								'groove' => 'Groove',
								'ridge' => 'Ridge',
								'inset' => 'Inset',
								'outset' => 'Outset'
							);
							break;
						default:
							$shortcodes[ $shortcode ][ $attribute ]['options'] = array();
					}
				}
			}
		}

		self::$parsed = true;
		self::$defaults = $defaults;
		self::$shortcodes = $shortcodes;
	}
}

WPUPG_Template_Shortcodes::init();
