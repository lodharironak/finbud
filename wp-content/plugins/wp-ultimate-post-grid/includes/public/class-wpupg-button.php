<?php
/**
 * Responsible for the grid button in the classic editor.
 *
 * @link       https://bootstrapped.ventures
 * @since      3.0.0
 *
 * @package    WP_Ultimate_Post_Grid
 * @subpackage WP_Ultimate_Post_Grid/includes/public
 */

/**
 * Responsible for the grid button in the classic editor.
 *
 * @since      3.0.0
 * @package    WP_Ultimate_Post_Grid
 * @subpackage WP_Ultimate_Post_Grid/includes/public
 * @author     Brecht Vandersmissen <brecht@bootstrapped.ventures>
 */
class WPUPG_Button {

	/**
	 * Register actions and filters.
	 *
	 * @since    3.0.0
	 */
	public static function init() {
		add_filter( 'mce_external_plugins', array( __CLASS__, 'add_button' ) );
		add_filter( 'mce_buttons', array( __CLASS__, 'register_button' ) );
	}

	/**
	 * Add the button to the TinyMCE editor.
	 *
	 * @since    3.0.0
	 * @param    mixed $plugin_array TinyMCE plugins.
	 */
	public static function add_button( $plugin_array ) {
		$plugin_array['wp_ultimate_post_grid'] = WPUPG_URL . 'assets/js/other/tinymce-toolbar-icon.js';
		return $plugin_array;
	}

	/**
	 * Register the button for the TinyMCE editor.
	 *
	 * @since    3.0.0
	 * @param    mixed $buttons TinyMCE buttons.
	 */
	public static function register_button( $buttons ) {
		array_push( $buttons, 'wp_ultimate_post_grid' );
		return $buttons;
	}
}

WPUPG_Button::init();
