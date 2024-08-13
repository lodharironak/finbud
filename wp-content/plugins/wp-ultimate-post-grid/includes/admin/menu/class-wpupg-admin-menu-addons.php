<?php
/**
 * Show addons in the backend menu.
 *
 * @link       https://bootstrapped.ventures
 * @since      3.0.0
 *
 * @package    WP_Ultimate_Post_Grid
 * @subpackage WP_Ultimate_Post_Grid/includes/admin
 */

/**
 * Show addons in the backend menu.
 *
 * @since      3.0.0
 * @package    WP_Ultimate_Post_Grid
 * @subpackage WP_Ultimate_Post_Grid/includes/admin
 * @author     Brecht Vandersmissen <brecht@bootstrapped.ventures>
 */
class WPUPG_Admin_Menu_Addons {

	/**
	 * Register actions and filters.
	 *
	 * @since    3.0.0
	 */
	public static function init() {
		add_action( 'admin_menu', array( __CLASS__, 'add_submenu_page' ), 99 );
	}

	/**
	 * Add the FAQ & Support submenu to the WPUPG menu.
	 *
	 * @since    3.0.0
	 */
	public static function add_submenu_page() {
		add_submenu_page( 'wpultimatepostgrid', __( 'Upgrade WPUPG', 'wp-ultimate-post-grid' ), __( 'Upgrade WPUPG', 'wp-ultimate-post-grid' ), 'manage_options', 'wpupg_addons', array( __CLASS__, 'page_template' ) );
	}

	/**
	 * Get the template for this submenu.
	 *
	 * @since    3.0.0
	 */
	public static function page_template() {
		require_once( WPUPG_DIR . 'templates/admin/menu/addons.php' );
	}
}

WPUPG_Admin_Menu_Addons::init();
