<?php
/**
 * Provide information about WP Ultimate Post Grid addons.
 *
 * @link       https://bootstrapped.ventures
 * @since      3.0.0
 *
 * @package    WP_Ultimate_Post_Grid
 * @subpackage WP_Ultimate_Post_Grid/includes/public
 */

/**
 * Provide information about WP Ultimate Post Grid addons.
 *
 * @since      3.0.0
 * @package    WP_Ultimate_Post_Grid
 * @subpackage WP_Ultimate_Post_Grid/includes/public
 * @author     Brecht Vandersmissen <brecht@bootstrapped.ventures>
 */
class WPUPG_Addons {

	/**
	 * Register actions and filters.
	 *
	 * @since    3.0.0
	 */
	public static function init() {
	}

	/**
	 * Check if a particular addon is active.
	 *
	 * @since    3.0.0
	 * @param	 	 mixed $addon Addon to check.
	 */
	public static function is_active( $addon ) {
		return apply_filters( 'wpupg_addon_active', false, $addon );
	}
}

WPUPG_Addons::init();
