<?php
/**
 * Handle multilingual functionality.
 *
 * @link       https://bootstrapped.ventures
 * @since      3.9.0
 *
 * @package    WP_Ultimate_Post_Grid
 * @subpackage WP_Ultimate_Post_Grid/includes/public
 */

/**
 * Handle multilingual functionality.
 *
 * @since      3.9.0
 * @package    WP_Ultimate_Post_Grid
 * @subpackage WP_Ultimate_Post_Grid/includes/public
 * @author     Brecht Vandersmissen <brecht@bootstrapped.ventures>
 */
class WPUPG_Multilingual {

	/**
	 * Language to set for WPML
	 *
	 * @since    3.9.0
	 * @access   private
	 * @var      mixed $wpml_language Language to set for WPML.
	 */
	private static $wpml_language = false;

	/**
	 * Register actions and filters.
	 *
	 * @since    3.9.0
	 */
	public static function init() {
		add_action( 'pre_get_posts', array( __CLASS__, 'set_language_wpml' ) );
	}

	/**
	 * Check if and what multilingual plugin is getting used.
	 *
	 * @since	3.9.0
	 */
	public static function get() {
		$plugin = false;
		$languages = array();
		$current_language = false;
		$default_language = false;

		// WPML.
		$wpml_languages = apply_filters( 'wpml_active_languages', false );

		if ( $wpml_languages ) {
			$plugin = 'wpml';

			foreach ( $wpml_languages as $code => $options ) {
				$languages[ $code ] = array(
					'value' => $code,
					'label' => $options['native_name'],
				);
			}

			$current_language = ICL_LANGUAGE_CODE;
			$default_language = apply_filters( 'wpml_default_language', false );
		}

		// Return either false (no multilingual plugin) or an array with the plugin and activated languages.
		return ! $plugin ? false : array(
			'plugin' => $plugin,
			'languages' => $languages,
			'current' => $current_language,
			'default' => $default_language,
		);
	}

	/**
	 * Set the language to use.
	 *
	 * @since	3.9.0
	 * @param	mixed $language Language to set.
	 */
	public static function set_language( $language ) {
		if ( $language ) {
			$multilingual = self::get();

			if ( $multilingual ) {
				// WPML.
				if ( 'wpml' === $multilingual['plugin'] ) {
					self::$wpml_language = $language;
				}
			}
		}
	}

	/**
	 * Set the WPML language.
	 *
	 * @since	3.9.0
	 * @param	mixed $query Post query.
	 */
	public static function set_language_wpml( $query ) {
		if ( self::$wpml_language ) {
			do_action( 'wpml_switch_language', self::$wpml_language );
		}
	}

	/**
	 * Unset the language.
	 *
	 * @since	3.9.0
	 */
	public static function unset_language() {
		$multilingual = self::get();

		if ( $multilingual ) {
			// WPML.
			if ( 'wpml' === $multilingual['plugin'] ) {
				do_action( 'wpml_switch_language', null );
				self::$wpml_language = false;
			}
		}
	}
}

WPUPG_Multilingual::init();
