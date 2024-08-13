<?php
/**
 * API for loading grid items.
 *
 * @link       https://bootstrapped.ventures
 * @since      3.0.0
 *
 * @package    WP_Ultimate_Post_Grid
 * @subpackage WP_Ultimate_Post_Grid/includes/public/api
 */

/**
 * API for loading grid items.
 *
 * @since      3.0.0
 * @package    WP_Ultimate_Post_Grid
 * @subpackage WP_Ultimate_Post_Grid/includes/public/api
 * @author     Brecht Vandersmissen <brecht@bootstrapped.ventures>
 */
class WPUPG_API_Items {

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
			register_rest_route( 'wp-ultimate-post-grid/v1', '/items', array(
				'callback' => array( __CLASS__, 'api_items' ),
				'methods' => 'POST',
				'permission_callback' => '__return_true',
			) );
		}
	}

	/**
	 * Handle load items call to the REST API.
	 *
	 * @since    3.0.0
	 * @param    WP_REST_Request $request Current request.
	 */
	public static function api_items( $request ) {
		$data = array();

		// Parameters.
		$params = $request->get_params();
		$grid_id = isset( $params['id'] ) ? $params['id'] : false;
		$grid_args = isset( $params['args'] ) ? $params['args'] : array();
		$type = isset( $grid_args['type'] ) ? $grid_args['type'] : 'load';

		$items = array();
		$grid = $grid_id ? WPUPG_Grid_Manager::get_grid( $grid_id ) : false;

		if ( $grid ) {
			$grid_args = apply_filters( 'wpupg_grid_args', $grid_args, $grid );

			switch( $type ) {
				case 'load':
				case 'load_all':
					$data['items'] = WPUPG_Grid_Output::items( $grid, $grid_args );
					$data['count'] = count( $data['items']['ids'] );
					$data['count_loaded'] = $data['count'];
					$data['count_total'] = $grid->total_ids();
					break;
				case 'read':
					$data['ids'] = $grid->ids( $grid_args );
					$data['count'] = count( $data['ids'] );
					$data['count_loaded'] = 0;
					$data['count_total'] = $grid->total_ids();
					break;
				case 'count':
					$data['count'] = count( $grid->ids( $grid_args ) );
					$data['count_loaded'] = 0;
					$data['count_total'] = $grid->total_ids();
					break;
			}
		}

		return apply_filters( 'wpupg_api_items_data', $data, $grid, $grid_args );
	}
}

WPUPG_API_Items::init();
