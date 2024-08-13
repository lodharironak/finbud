<?php
/**
 * API for previewing a grid.
 *
 * @link       https://bootstrapped.ventures
 * @since      3.0.0
 *
 * @package    WP_Ultimate_Post_Grid
 * @subpackage WP_Ultimate_Post_Grid/includes/public/api
 */

/**
 * API for previewing a grid.
 *
 * @since      3.0.0
 * @package    WP_Ultimate_Post_Grid
 * @subpackage WP_Ultimate_Post_Grid/includes/public/api
 * @author     Brecht Vandersmissen <brecht@bootstrapped.ventures>
 */
class WPUPG_API_Preview_Grid {

	/**
	 * Register actions and filters.
	 *
	 * @since    3.0.0
	 */
	public static function init() {
		add_action( 'rest_api_init', array( __CLASS__, 'api_register_data' ) );
	}

	/**
	 * Register data for the REST API.
	 *
	 * @since    3.0.0
	 */
	public static function api_register_data() {
		if ( function_exists( 'register_rest_field' ) ) {
			register_rest_route( 'wp-ultimate-post-grid/v1', '/preview', array(
				'callback' => array( __CLASS__, 'api_preview_grid' ),
				'methods' => 'POST',
				'permission_callback' => array( __CLASS__, 'api_required_permissions' ),
			) );
		}
	}

	/**
	 * Required permissions for the API.
	 *
	 * @since    3.0.0
	 */
	public static function api_required_permissions() {
		return current_user_can( WPUPG_Settings::get( 'features_manage_access' ) );
	}

	/**
	 * Handle preview grid call to the REST API.
	 *
	 * @since    3.0.0
	 * @param    WP_REST_Request $request Current request.
	 */
	public static function api_preview_grid( $request ) {
		// Parameters.
		$params = $request->get_params();
		$grid_meta = isset( $params['grid'] ) ? $params['grid'] : array();

		// When previewing, grid is using the latest arguments.
		$grid_meta['version'] = WPUPG_VERSION;
		$grid = new WPUPG_Grid( $grid_meta );

		$grid_args = $grid->get_javascript_args();
		$grid_args['is_preview'] = true;

		return array(
			'html' => WPUPG_Grid_Output::entire( $grid, array( 'preview' => true ) ),
			'args' => $grid_args,
		);
	}
}

WPUPG_API_Preview_Grid::init();
