<?php
/**
 * Responsible for loading the WPUPG assets.
 *
 * @link       https://bootstrapped.ventures
 * @since      3.0.0
 *
 * @package    WP_Ultimate_Post_Grid
 * @subpackage WP_Ultimate_Post_Grid/includes/public
 */

/**
 * Responsible for loading the WPUPG assets.
 *
 * @since      3.0.0
 * @package    WP_Ultimate_Post_Grid
 * @subpackage WP_Ultimate_Post_Grid/includes/public
 * @author     Brecht Vandersmissen <brecht@bootstrapped.ventures>
 */
class WPUPG_Assets {

	/**
	 * Data to pass along to JS.
	 *
	 * @since    3.8.0
	 * @access   private
	 * @var      array $js_data Data to pass along to JS.
	 */
	private static $js_data = array();

	/**
	 * Register actions and filters.
	 *
	 * @since    3.0.0
	 */
	public static function init() {
		add_action( 'wp_enqueue_scripts', array( __CLASS__, 'enqueue' ) );
		add_action( 'admin_enqueue_scripts', array( __CLASS__, 'enqueue_admin' ), 1 );
		add_action( 'wp_head', array( __CLASS__, 'custom_css' ) );
		add_action( 'enqueue_block_editor_assets', array( __CLASS__, 'block_assets' ) );
		add_action( 'wp_footer', array( __CLASS__, 'output_js_data' ) );
	}

	/**
	 * Enqueue stylesheets and scripts.
	 *
	 * @since    3.0.0
	 */
	public static function enqueue() {
		$dependencies = apply_filters( 'wpupg_assets_public_js_dependencies', array() );

		wp_register_style( 'wpupg-public', WPUPG_URL . 'dist/public.css', array(), WPUPG_VERSION, 'all' );
		wp_register_script( 'wpupg-public', WPUPG_URL . 'dist/public.js', $dependencies, WPUPG_VERSION, true );

		wp_localize_script( 'wpupg-public', 'wpupg_public', array(
			'api_nonce' => wp_create_nonce( 'wp_rest' ),
			'api_endpoint' => get_rest_url( null, 'wp-ultimate-post-grid/v1/items' ),
			'debugging' => WPUPG_Settings::get( 'enable_debug_messages' ),
			'breakpoints' => array(
				'tablet' => WPUPG_Settings::get( 'breakpoint_tablet' ),
				'mobile' => WPUPG_Settings::get( 'breakpoint_mobile' ),
			),
		));
	}

	/**
	 * Actually load the public assets.
	 *
	 * @since	3.0.0
	 */
	public static function load() {
		wp_enqueue_style( 'wpupg-public' );
		wp_enqueue_script( 'wpupg-public' );

		do_action( 'wpupg_load_assets' );
	}

	/**
	 * Enqueue admin stylesheets and scripts.
	 *
	 * @since    3.0.0
	 */
	public static function enqueue_admin() {
		// Load shared JS first.
		wp_enqueue_script( 'wpupg-shared', WPUPG_URL . 'dist/shared.js', array(), WPUPG_VERSION, true );

		// Add Premium JS to dependencies when active.
		$dependencies = array( 'wpupg-shared' );
		if ( WPUPG_Addons::is_active( 'premium' ) ) {
			$dependencies[] = 'wpupgp-admin';
		}

		wp_enqueue_style( 'wpupg-admin', WPUPG_URL . 'dist/admin.css', array(), WPUPG_VERSION, 'all' );
		wp_enqueue_script( 'wpupg-admin', WPUPG_URL . 'dist/admin.js', $dependencies, WPUPG_VERSION, true );

		// Template Editor.
		$screen = get_current_screen();
		if ( 'grids_page_wpupg_template_editor' === $screen->id ) {
			wp_enqueue_media();
			wp_enqueue_style( 'wpupg-admin-template', WPUPG_URL . 'dist/admin-template.css', array(), WPUPG_VERSION, 'all' );
			wp_enqueue_script( 'wpupg-admin-template', WPUPG_URL . 'dist/admin-template.js', array( 'wpupg-admin' ), WPUPG_VERSION, true );
		}

		// Translations.
		include( WPUPG_DIR . 'templates/admin/translations.php' );

		$wpupg_admin = array(
			'wpupg_url' => WPUPG_URL,
			'api_nonce' => wp_create_nonce( 'wp_rest' ),
			'ajax_url' => admin_url( 'admin-ajax.php' ),
			'nonce' => wp_create_nonce( 'wpupg' ),
			'endpoints' => array(
				'grid' => get_rest_url( null, 'wp/v2/' . WPUPG_POST_TYPE ),
				'manage' => get_rest_url( null, 'wp-ultimate-post-grid/v1/manage' ),
				'notices' => get_rest_url( null, 'wp-ultimate-post-grid/v1/notice' ),
				'preview' => get_rest_url( null, 'wp-ultimate-post-grid/v1/preview' ),
				'template' => get_rest_url( null, 'wp-ultimate-post-grid/v1/template' ),
			),
			'addons' => array(
				'premium' => WPUPG_Addons::is_active( 'premium' ),
			),
			'translations' => $translations ? $translations : array(),
			'grids' => WPUPG_Grid_Manager::get_grids(),
		);

		// Shared loads first, so localize then.
		wp_localize_script( 'wpupg-shared', 'wpupg_admin', $wpupg_admin );
	}

	/**
	 * Enqueue Gutenberg block assets.
	 *
	 * @since    3.0.0
	 */
	public static function block_assets() {
		wp_enqueue_style( 'wpupg-blocks', WPUPG_URL . 'dist/blocks.css', array(), WPUPG_VERSION, 'all' );
		wp_enqueue_script( 'wpupg-blocks', WPUPG_URL . 'dist/blocks.js', array( 'wp-i18n', 'wp-element', 'wp-blocks', 'wp-edit-post', 'wp-components', 'wp-format-library'  ), WPUPG_VERSION );
	}

	/**
	 * Output the custom CSS.
	 *
	 * @since    3.0.0
	 */
	public static function custom_css() {
		$css = '';

		// Grid height animation CSS.
		$animation_speed = intval( WPUPG_Settings::get( 'grid_container_animation_speed' ) );

		if ( 0 < $animation_speed ) {
			$animation_speed = $animation_speed / 1000;
			$css .= '.wpupg-grid { transition: height ' . $animation_speed . 's; }';
		}

		// Custom CSS from settings.
		$css .= WPUPG_Settings::get( 'public_css' );

		$css = trim( $css );
		if ( $css ) {
			echo '<style>' . $css . '</style>';
		}
	}

	/**
	 * Add data to pass along to JS.
	 *
	 * @since	3.8.0
	 * @param	mixed $variable	Variable to use in JS.
	 * @param	mixed $data		Data to pass along.
	 */
	public static function add_js_data( $variable, $data ) {
		$variable = sanitize_key( $variable );
		self::$js_data[ $variable ] = $data;
	}

	/**
	 * Output data to pass along to JS.
	 *
	 * @since	3.8.0
	 */
	public static function output_js_data() {
		$js = '';

		foreach ( self::$js_data as $variable => $data ) {
			if ( $data ) {
				$js .= 'var ' . $variable . ' = ' . wp_json_encode( $data ) . ';';
			}
		}

		if ( $js ) {
			echo '<script type="text/javascript">' . $js . '</script>';
		}
	}

}

WPUPG_Assets::init();
