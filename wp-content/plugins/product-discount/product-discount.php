<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://http://192.168.0.28/finbud/
 * @since             1.0.0
 * @package           Product_Discount
 *
 * @wordpress-plugin
 * Plugin Name:       Product Discount 
 * Plugin URI:        https://192.168.0.28/finbud/wp-admin/product
 * Description:       Product discount work
 * Version:           1.0.0
 * Author:            Ronak 
 * Author URI:        https://http://192.168.0.28/finbud/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       product-discount
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'PRODUCT_DISCOUNT_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-product-discount-activator.php
 */
function activate_product_discount() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-product-discount-activator.php';
	Product_Discount_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-product-discount-deactivator.php
 */
function deactivate_product_discount() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-product-discount-deactivator.php';
	Product_Discount_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_product_discount' );
register_deactivation_hook( __FILE__, 'deactivate_product_discount' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-product-discount.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_product_discount() {

	$plugin = new Product_Discount();
	$plugin->run();

}
run_product_discount();

