<?php
/**
 * Responsible for showing the WPUPG menu in the WP backend.
 *
 * @link       https://bootstrapped.ventures
 * @since      3.0.0
 *
 * @package    WP_Ultimate_Post_Grid
 * @subpackage WP_Ultimate_Post_Grid/includes/admin/menu
 */

/**
 * Responsible for showing the WPUPG menu in the WP backend.
 *
 * @since      3.0.0
 * @package    WP_Ultimate_Post_Grid
 * @subpackage WP_Ultimate_Post_Grid/includes/admin/menu
 * @author     Brecht Vandersmissen <brecht@bootstrapped.ventures>
 */
class WPUPG_Admin_Menu {

	/**
	 * Register actions and filters.
	 *
	 * @since    3.0.0
	 */
	public static function init() {
		add_action( 'admin_menu', array( __CLASS__, 'add_menu_page' ) );
	}

	/**
	 * Add WPUPG to the wordpress menu.
	 *
	 * @since    3.0.0
	 */
	public static function add_menu_page() {
		add_menu_page( 'WP Ultimate Post Grid', 'Grids', WPUPG_Settings::get( 'features_manage_access' ), 'wpultimatepostgrid', array( 'WPUPG_Manage_Modal', 'manage_page_template' ), 'dashicons-grid-view', 20 );
	}
}

WPUPG_Admin_Menu::init();
