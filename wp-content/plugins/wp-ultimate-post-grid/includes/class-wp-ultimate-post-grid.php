<?php
/**
 * The core plugin class.
 *
 * @link       https://bootstrapped.ventures
 * @since      3.0.0
 *
 * @package    WP_Ultimate_Post_Grid
 * @subpackage WP_Ultimate_Post_Grid/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      3.0.0
 * @package    WP_Ultimate_Post_Grid
 * @subpackage WP_Ultimate_Post_Grid/includes
 * @author     Brecht Vandersmissen <brecht@bootstrapped.ventures>
 */
class WP_Ultimate_Post_Grid {

	/**
	 * Define any constants to be used in the plugin.
	 *
	 * @since    3.0.0
	 */
	private function define_constants() {
		define( 'WPUPG_VERSION', '3.9.3' );
		define( 'WPUPG_PREMIUM_VERSION_REQUIRED', '3.0.0' );
		define( 'WPUPG_POST_TYPE', 'wpupg_grid' );
		define( 'WPUPG_DIR', plugin_dir_path( dirname( __FILE__ ) ) );
		define( 'WPUPG_URL', plugin_dir_url( dirname( __FILE__ ) ) );
	}

	/**
	 * Make sure all is set up for the plugin to load.
	 *
	 * @since    3.0.0
	 */
	public function __construct() {
		$this->define_constants();
		$this->load_dependencies();
		add_action( 'plugins_loaded', array( $this, 'wpupg_init' ), 1 );
		add_action( 'admin_notices', array( $this, 'admin_notice_required_version' ) );
	}

	/**
	 * Init WPUPG for Premium add-ons.
	 *
	 * @since	3.0.0
	 */
	public function wpupg_init() {
		do_action( 'wpupg_init' );
	}

	/**
	 * Load all plugin dependencies.
	 *
	 * @since    3.0.0
	 */
	private function load_dependencies() {
		// General.
		require_once( WPUPG_DIR . 'includes/class-wpupg-i18n.php' );

		// Priority.
		require_once( WPUPG_DIR . 'includes/public/class-wpupg-settings.php' );

		// Api.
		require_once( WPUPG_DIR . 'includes/public/api/class-wpupg-api-grids.php' );
		require_once( WPUPG_DIR . 'includes/public/api/class-wpupg-api-items.php' );
		require_once( WPUPG_DIR . 'includes/public/api/class-wpupg-api-manage-grids.php' );
		require_once( WPUPG_DIR . 'includes/public/api/class-wpupg-api-notices.php' );
		require_once( WPUPG_DIR . 'includes/public/api/class-wpupg-api-preview-grid.php' );
		require_once( WPUPG_DIR . 'includes/public/api/class-wpupg-api-templates.php' );

		// // Public.
		require_once( WPUPG_DIR . 'includes/public/class-wpupg-addons.php' );
		require_once( WPUPG_DIR . 'includes/public/class-wpupg-assets.php' );
		require_once( WPUPG_DIR . 'includes/public/class-wpupg-blocks.php' );
		require_once( WPUPG_DIR . 'includes/public/class-wpupg-button.php' );
		require_once( WPUPG_DIR . 'includes/public/class-wpupg-filter.php' );
		require_once( WPUPG_DIR . 'includes/public/class-wpupg-filter-clear.php' );
		require_once( WPUPG_DIR . 'includes/public/class-wpupg-filter-isotope.php' );
		require_once( WPUPG_DIR . 'includes/public/class-wpupg-grid.php' );
		require_once( WPUPG_DIR . 'includes/public/class-wpupg-grid-layout.php' );
		require_once( WPUPG_DIR . 'includes/public/class-wpupg-grid-manager.php' );
		require_once( WPUPG_DIR . 'includes/public/class-wpupg-grid-output.php' );
		require_once( WPUPG_DIR . 'includes/public/class-wpupg-grid-sanitizer.php' );
		require_once( WPUPG_DIR . 'includes/public/class-wpupg-grid-saver.php' );
		require_once( WPUPG_DIR . 'includes/public/class-wpupg-icon.php' );
		require_once( WPUPG_DIR . 'includes/public/class-wpupg-item.php' );
		require_once( WPUPG_DIR . 'includes/public/class-wpupg-item-manager.php' );
		require_once( WPUPG_DIR . 'includes/public/class-wpupg-item-post.php' );
		require_once( WPUPG_DIR . 'includes/public/class-wpupg-meta-box.php' );
		require_once( WPUPG_DIR . 'includes/public/class-wpupg-migrations.php' );
		require_once( WPUPG_DIR . 'includes/public/class-wpupg-multilingual.php' );
		require_once( WPUPG_DIR . 'includes/public/class-wpupg-order.php' );
		require_once( WPUPG_DIR . 'includes/public/class-wpupg-pagination.php' );
		require_once( WPUPG_DIR . 'includes/public/class-wpupg-pagination-pages.php' );
		require_once( WPUPG_DIR . 'includes/public/class-wpupg-post-type.php' );
		require_once( WPUPG_DIR . 'includes/public/class-wpupg-shortcode-takeover.php' );
		require_once( WPUPG_DIR . 'includes/public/class-wpupg-shortcode.php' );
		require_once( WPUPG_DIR . 'includes/public/class-wpupg-template-editor.php' );
		require_once( WPUPG_DIR . 'includes/public/class-wpupg-template-helper.php' );
		require_once( WPUPG_DIR . 'includes/public/class-wpupg-template-manager.php' );
		require_once( WPUPG_DIR . 'includes/public/class-wpupg-template-shortcode.php' );
		require_once( WPUPG_DIR . 'includes/public/class-wpupg-template-shortcodes.php' );

		// Admin.
		if ( is_admin() ) {
			require_once( WPUPG_DIR . 'includes/admin/class-wpupg-manage-modal.php' );
			require_once( WPUPG_DIR . 'includes/admin/class-wpupg-marketing.php' );
			require_once( WPUPG_DIR . 'includes/admin/class-wpupg-notices.php' );

			// Menu.
			require_once( WPUPG_DIR . 'includes/admin/menu/class-wpupg-admin-menu.php' );
			require_once( WPUPG_DIR . 'includes/admin/menu/class-wpupg-admin-menu-addons.php' );
			require_once( WPUPG_DIR . 'includes/admin/menu/class-wpupg-admin-menu-faq.php' );
		}
	}

	/**
	 * Admin notice to show when the required version is not met.
	 *
	 * @since	3.0.0
	 */
	public function admin_notice_required_version() {
		if ( defined( 'WPUPGP_VERSION' ) && version_compare( WPUPGP_VERSION, WPUPG_PREMIUM_VERSION_REQUIRED ) < 0 ) {
			echo '<div class="notice notice-error"><p>';
			echo '<strong>WP Ultimate Post Grid</strong></br>';
			esc_html_e( 'Please update to at least the following plugin versions:', 'wp-ultimate-post-grid-premium' );
			echo '<br/>WP Ultimate Post Grid Premium ' . esc_html( WPUPG_PREMIUM_VERSION_REQUIRED );
			echo '</p><p>';
			echo '<a href="https://help.bootstrapped.ventures/article/214-updating-wp-ultimate-post-grid" target="_blank">';
			esc_html_e( 'More information on updating the plugin', 'wp-ultimate-post-grid' );
			echo '</a>';
			echo '</p></div>';
		}
	}

	/**
	 * Adjust action links on the plugins page.
	 *
	 * @since	3.0.0
	 * @param	array $links Current plugin action links.
	 */
	public function plugin_action_links( $links ) {
		if ( ! WPUPG_Addons::is_active( 'premium' ) ) {
			return array_merge( array( '<a href="https://bootstrapped.ventures/wp-ultimate-post-grid/get-the-plugin/" target="_blank">Upgrade to Premium</a>' ), $links );
		} else {
			return $links;
		}
	}
}
