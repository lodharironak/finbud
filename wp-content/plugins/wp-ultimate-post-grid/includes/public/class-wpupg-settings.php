<?php
/**
 * Responsible for the plugin settings.
 *
 * @link       https://bootstrapped.ventures
 * @since      3.0.0
 *
 * @package    WP_Ultimate_Post_Grid
 * @subpackage WP_Ultimate_Post_Grid/includes/public
 */

/**
 * Responsible for the plugin settings.
 *
 * @since      3.0.0
 * @package    WP_Ultimate_Post_Grid
 * @subpackage WP_Ultimate_Post_Grid/includes/public
 * @author     Brecht Vandersmissen <brecht@bootstrapped.ventures>
 */
class WPUPG_Settings {
	private static $bvs;

	/**
	 * Register actions and filters.
	 *
	 * @since    3.0.0
	 */
	public static function init() {
		require_once WPUPG_DIR . 'templates/settings/settings.php';
		require_once WPUPG_DIR . 'vendor/bv-settings/bv-settings.php';

		self::$bvs = new BV_Settings(
			array(
				'uid'           	=> 'wpupg',
				'menu_parent'   	=> 'wpultimatepostgrid',
				'menu_title'    	=> __( 'Settings', 'wp-ultimate-post-grid' ),
				'menu_priority' 	=> 20,
				'settings'      	=> $settings_structure,
				'required_addons' 	=> array(),
			)
		);

		add_filter( 'wpupg_settings_required_addons', array( __CLASS__, 'required_addons' ) );
	}

	/**
	 * Set required addons for settings.
	 *
	 * @since    3.0.0
	 * @param    mixed $required_addons Required addons for the settings.
	 */
	public static function required_addons( $required_addons ) {
		$required_addons['premium'] = array(
			'active' => WPUPG_Addons::is_active( 'premium' ),
			'label' => 'WP Ultimate Post Grid Premium Required',
			'url' => 'https://bootstrapped.ventures/wp-ultimate-post-grid/get-the-plugin/',
		);

		return $required_addons;
	}

	/**
	 * Get the value for a specific setting.
	 *
	 * @since    3.0.0
	 * @param    mixed $setting Setting to get the value for.
	 */
	public static function get( $setting ) {
		return self::$bvs->get( $setting );
	}

	/**
	 * Update the plugin settings.
	 *
	 * @since    3.0.0
	 * @param    array $settings_to_update Settings to update.
	 */
	public static function update_settings( $settings_to_update ) {
		return self::$bvs->update_settings( $settings_to_update );
	}
}

WPUPG_Settings::init();
