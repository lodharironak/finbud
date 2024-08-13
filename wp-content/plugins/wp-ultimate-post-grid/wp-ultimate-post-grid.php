<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://bootstrapped.ventures/
 * @since             3.0.0
 * @package           WP_Ultimate_Post_Grid
 *
 * @wordpress-plugin
 * Plugin Name:       WP Ultimate Post Grid
 * Plugin URI:        https://bootstrapped.ventures/wp-ultimate-post-grid/
 * Description:       Easily create filterable responsive grids for your posts, pages or custom post types.
 * Version:           3.9.3
 * Author:            Bootstrapped Ventures
 * Author URI:        https://bootstrapped.ventures/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wp-ultimate-post-grid
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wpupg-activator.php
 */
function activate_wp_ultimate_post_grid() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wpupg-activator.php';
	WPUPG_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wpupg-deactivator.php
 */
function deactivate_wp_ultimate_post_grid() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wpupg-deactivator.php';
	WPUPG_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_wp_ultimate_post_grid' );
register_deactivation_hook( __FILE__, 'deactivate_wp_ultimate_post_grid' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wp-ultimate-post-grid.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    3.0.0
 */
function run_wp_ultimate_post_grid() {
	$plugin = new WP_Ultimate_Post_Grid();
	add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ) , array( $plugin, 'plugin_action_links' ), 1 );
}
run_wp_ultimate_post_grid();
