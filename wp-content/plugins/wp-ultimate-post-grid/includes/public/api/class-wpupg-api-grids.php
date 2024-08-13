<?php
/**
 * REST API for grids.
 *
 * @link       https://bootstrapped.ventures
 * @since      3.0.0
 *
 * @package    WP_Ultimate_Post_Grid
 * @subpackage WP_Ultimate_Post_Grid/includes/public/api
 */

/**
 * REST API for grids.
 *
 * @since      3.0.0
 * @package    WP_Ultimate_Post_Grid
 * @subpackage WP_Ultimate_Post_Grid/includes/public/api
 * @author     Brecht Vandersmissen <brecht@bootstrapped.ventures>
 */
class WPUPG_API_Grids {

	/**
	 * Register actions and filters.
	 *
	 * @since    3.0.0
	 */
	public static function init() {
		add_action( 'rest_api_init', array( __CLASS__, 'api_register_data' ) );
		add_action( 'rest_insert_' . WPUPG_POST_TYPE, array( __CLASS__, 'api_insert_update_grid' ), 10, 3 );
	}

	/**
	 * Register data for the REST API.
	 *
	 * @since    3.0.0
	 */
	public static function api_register_data() {
		if ( function_exists( 'register_rest_field' ) ) {
			register_rest_field( WPUPG_POST_TYPE, 'grid', array(
				'get_callback'    => array( __CLASS__, 'api_get_grid_data' ),
				'update_callback' => null,
				'schema'          => null,
			));
		}
	}

	/**
	 * Handle get calls to the REST API.
	 *
	 * @since    3.0.0
	 * @param    array           $object Details of current post.
	 * @param    mixed           $field_name Name of field.
	 * @param    WP_REST_Request $request Current request.
	 */
	public static function api_get_grid_data( $object, $field_name, $request ) {
		$grid = WPUPG_Grid_Manager::get_grid( $object['id'] );
		return $grid ? $grid->get_data() : false;
	}

	/**
	 * Handle grid calls to the REST API.
	 *
	 * @since    3.0.0
	 * @param    WP_Post         $post     Inserted or updated post object.
	 * @param    WP_REST_Request $request  Request object.
	 * @param    bool            $creating True when creating a post, false when updating.
	 */
	public static function api_insert_update_grid( $post, $request, $creating ) {
		$params = $request->get_params();
		$grid = isset( $params['grid'] ) ? WPUPG_Grid_Sanitizer::sanitize( $params['grid'] ) : array();
		$grid_id = $post->ID;

		WPUPG_Grid_Saver::update_grid( $grid_id, $grid );
		
		$grid = WPUPG_Grid_Manager::get_grid( $grid_id );
		return $grid ? $grid->get_data() : false;
	}
}

WPUPG_API_Grids::init();
