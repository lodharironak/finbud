<?php
/**
 * Fired during plugin activation.
 *
 * @link       https://bootstrapped.ventures
 * @since      3.0.0
 *
 * @package    WP_Ultimate_Post_Grid
 * @subpackage WP_Ultimate_Post_Grid/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      3.0.0
 * @package    WP_Ultimate_Post_Grid
 * @subpackage WP_Ultimate_Post_Grid/includes
 * @author     Brecht Vandersmissen <brecht@bootstrapped.ventures>
 */
class WPUPG_Activator {

	/**
	 * Execute this on activation of the plugin.
	 *
	 * @since    3.0.0
	 */
	public static function activate() {
		add_option( 'wpupg_activated', true );
		update_option( 'wpupg_flush', '1' );
	}
}
