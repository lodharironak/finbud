<?php

/**
 * @wordpress-plugin
 * Plugin Name:       Product Gallery Slider for WooCommerce
 * Plugin URI:        https://wordpress.org/plugins/woo-product-gallery-slider/
 * Description:       Customizable image gallery slider for the single product page
 * Version:           2.2.8
 * Author:            Codeixer
 * Author URI:        http://codeixer.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       woo-product-gallery-slider
 * Domain Path:       /languages
 * Tested up to: 6.1
 * WC requires at least: 3.9
 * WC tested up to: 7.4
 */

// If this file is called directly, abort.
if ( !defined( 'WPINC' ) ) {
	die;
}
require __DIR__ . '/vendor/autoload.php';

define( 'WPGS_NAME', 'Product Gallery Slider for Woocommerce' );
define( 'WPGS_INC', plugin_dir_path( __FILE__ ) . 'inc/' );
define( 'WPGS_ROOT', plugin_dir_path( __FILE__ ) . '' );
define( 'WPGS_ROOT_URL', plugin_dir_url( __FILE__ ) . '' );
define( 'WPGS_INC_URL', plugin_dir_url( __FILE__ ) . 'inc/' );
define( 'WPGS_PLUGIN_BASE', plugin_basename( __FILE__ ) );

/**
 * Initialize the plugin tracker
 *
 * @return void
 */
function appsero_init_tracker_woo_product_gallery_slider() {

	if ( !class_exists( 'Appsero\Client' ) ) {
		require_once __DIR__ . '/appsero/src/Client.php';
	}

	$client = new Appsero\Client( '862a2d3f-9bbf-42f4-a1ae-89a36cde4e79', 'Product Gallery Slider for WooCommerce', __FILE__ );

	// Active insights
	$client->insights()->init();

}

// appsero_init_tracker_woo_product_gallery_slider();
require_once __DIR__ . '/remote-admin-notification-client/class-remote-notification-client.php';

if ( function_exists( 'wpi_rdnc_add_notification' ) ) {
	wpi_rdnc_add_notification( 72, 'a9873a6e608e946e', 'https://www.codeixer.com' );
}

final class CI_WPGS {

	/**
	 * Plugin version
	 * @var string
	 */
	const version = '2.2.8';

	private function __construct() {
		register_activation_hook( __FILE__, array( $this, 'plugin_activation' ) );

		$this->define_constants();
		add_action( 'admin_init', array( 'PAnD', 'init' ) );
		add_action( 'woocommerce_loaded', [$this, 'init_plugin'], 30 );
		add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ) . '', [$this, 'wpgs_plugin_row_meta'] );
	}

	/**
	 * Add Pro version link into the plugin row meta
	 *
	 * @param  [type] $links
	 * @return void
	 */
	public function wpgs_plugin_row_meta( $links ) {
		$row_meta = array(
			'settings' => '<a href="' . admin_url( 'admin.php?page=cix-gallery-settings' ) . '">Settings</a>',
			'docs'     => '<a href="' . esc_url( 'https://www.codeixer.com/product-gallery-slider-for-woocommerce?utm_source=freemium&utm_medium=plugin-page&utm_campaign=upgrade_pro' ) . '" target="_blank" aria-label="' . esc_attr__( 'PRO Version', 'woo-product-gallery-slider' ) . '" style="color:#1da867;font-weight:600;">' . esc_html__( 'Get Pro', 'woo-product-gallery-slider' ) . '</a>',
			
		);

		return array_merge( $links, $row_meta );
	}

	/**
	 * Initialize the plugin
	 *
	 * @return void
	 */
	public function init_plugin() {
		new \Product_Gallery_Sldier\Bootstrap;

	}

	/**
	 * Run Codes on Plugin activation
	 *
	 * @return void
	 */
	public function plugin_activation() {
		$installed = get_option( 'ciwpgs_installed' );

		if ( !$installed ) {
			update_option( 'ciwpgs_installed', date( "Y/m/d" ) );
		}
	}
	/**
	 * Define the required plugin constants
	 * @return void
	 */
	public function define_constants() {
		define( 'CIPG_VERSION', self::version );
		define( 'CIPG_FILE', __FILE__ );
		define( 'CIPG_PATH', __DIR__ );
		define( 'CIPG_URL', plugins_url( '', CIPG_FILE ) );
		define( 'CIPG_ASSETS', CIPG_URL . '/assets' );
	}

	/**
	 * Initializes a singleton instance
	 *
	 * @return $instance
	 */
	public static function init() {
		/**
		 * @var mixed
		 */
		static $instance = false;

		if ( !$instance ) {
			$instance = new self();
		}

		return $instance;
	}
}

if ( !function_exists( 'cix_get_wp_image_sizes' ) ) {
	/**
	 * @param $value
	 */
	function cix_get_wp_image_sizes() {
		// Get the image sizes.
		global $_wp_additional_image_sizes;
		$sizes = array();

		foreach ( get_intermediate_image_sizes() as $_size ) {
			if ( in_array( $_size, array( 'thumbnail', 'medium', 'medium_large', 'large' ), true ) ) {

				$width  = get_option( "{$_size}_size_w" );
				$height = get_option( "{$_size}_size_h" );
				$crop   = (bool) get_option( "{$_size}_crop" ) ? 'hard' : 'soft';

				$sizes[$_size] = ucfirst( "{$_size} - $crop:{$width}x{$height}" );

			} elseif ( isset( $_wp_additional_image_sizes[$_size] ) ) {

				$width  = $_wp_additional_image_sizes[$_size]['width'];
				$height = $_wp_additional_image_sizes[$_size]['height'];
				$crop   = $_wp_additional_image_sizes[$_size]['crop'] ? 'hard' : 'soft';

				$sizes[$_size] = ucfirst( "{$_size} - $crop:{$width}X{$height}" );
			}
		}
		return $sizes;
	}
}

// kick-off the plugin
CI_WPGS::init();

// add_action( 'admin_notices', 'twistgetpro_admin_notice__sdssuccess' );
/**
 * @return null
 */
function twistgetpro_admin_notice__sdssuccess() {
	if ( !\PAnD::is_admin_notice_active( 'twist-getpro-notice-30' ) ) {
		return;
	}

	?>
			<div data-dismissible="twist-getpro-notice-30" class="info notice notice-info is-dismissible">

				<p class="exclusive-txt">Limited time offer for only those who have downloaded <b>Product Gallery Slider for WooCommerce</b> and want to go <a target="_blank"  href="https://www.codeixer.com/product-gallery-slider-for-woocommerce?utm_source=freemium&utm_medium=admin_notice&utm_campaign=upgrade_pro" >PRO.</a> <br>
				Use coupon code <span class="wpgs-coupon">welcome20</span> and get 20% discount.</p>

			</div>
			<?php
}