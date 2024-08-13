<?php
/**
 * Open up grid templates in the WordPress REST API.
 *
 * @link       https://bootstrapped.ventures
 * @since      3.0.0
 *
 * @package    WP_Ultimate_Post_Grid
 * @subpackage WP_Ultimate_Post_Grid/includes/public/api
 */

/**
 * Open up grid templates in the WordPress REST API.
 *
 * @since      3.0.0
 * @package    WP_Ultimate_Post_Grid
 * @subpackage WP_Ultimate_Post_Grid/includes/public/api
 * @author     Brecht Vandersmissen <brecht@bootstrapped.ventures>
 */
class WPUPG_Api_Templates {

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
		if ( function_exists( 'register_rest_field' ) ) { // Prevent issue with Jetpack.
			register_rest_route( 'wp-ultimate-post-grid/v1', '/template', array(
				'callback' => array( __CLASS__, 'api_get_templates' ),
				'methods' => 'GET',
				'permission_callback' => array( __CLASS__, 'api_required_permissions' ),
			));
			register_rest_route( 'wp-ultimate-post-grid/v1', '/template', array(
				'callback' => array( __CLASS__, 'api_update_template' ),
				'methods' => 'POST',
				'permission_callback' => array( __CLASS__, 'api_required_permissions' ),
			));
			register_rest_route( 'wp-ultimate-post-grid/v1', '/template', array(
				'callback' => array( __CLASS__, 'api_delete_template' ),
				'methods' => 'DELETE',
				'permission_callback' => array( __CLASS__, 'api_required_permissions' ),
			));
			register_rest_route( 'wp-ultimate-post-grid/v1', '/template/preview', array(
				'callback' => array( __CLASS__, 'api_preview_template' ),
				'methods' => 'POST',
				'permission_callback' => array( __CLASS__, 'api_required_permissions' ),
			));
			register_rest_route( 'wp-ultimate-post-grid/v1', '/template/preview-item', array(
				'callback' => array( __CLASS__, 'api_preview_template_items' ),
				'methods' => 'POST',
				'permission_callback' => array( __CLASS__, 'api_required_permissions' ),
			));
		}
	}

	/**
	 * Required permissions for the API.
	 *
	 * @since 3.0.0
	 */
	public static function api_required_permissions() {
		return current_user_can( 'manage_options' );
	}

	/**
	 * Handle get template call to the REST API.
	 *
	 * @since 3.0.0
	 * @param WP_REST_Request $request Current request.
	 */
	public static function api_get_templates( $request ) {
		return WPUPG_Template_Manager::get_templates();
	}

	/**
	 * Handle update template call to the REST API.
	 *
	 * @since 3.0.0
	 * @param WP_REST_Request $request Current request.
	 */
	public static function api_update_template( $request ) {
		$params = $request->get_params();
		$template = isset( $params['template'] ) ? $params['template'] : array();
		return WPUPG_Template_Editor::prepare_template_for_editor( WPUPG_Template_Manager::save_template( $template ) );
	}
	
	/**
	 * Handle delete template call to the REST API.
	 *
	 * @since 3.0.0
	 * @param WP_REST_Request $request Current request.
	 */
	public static function api_delete_template( $request ) {
		$params = $request->get_params();
		$slug = isset( $params['slug'] ) ? $params['slug'] : false;
		return WPUPG_Template_Manager::delete_template( $slug );
	}

	/**
	 * Handle preview template call to the REST API.
	 *
	 * @since 4.0.3
	 * @param WP_REST_Request $request Current request.
	 */
	public static function api_preview_template( $request ) {
		$params = $request->get_params();
		$item_id = isset( $params['item'] ) ? $params['item'] : false;
		$shortcodes = isset( $params['shortcodes'] ) ? (array) $params['shortcodes'] : array();

		$preview = array();
		$item = WPUPG_Item_Manager::get_item( $item_id );

		if ( $item ) {
			WPUPG_Template_Shortcodes::set_current_item( $item );

			foreach ( $shortcodes as $uid => $shortcode ) {
				$preview[ $uid ] = do_shortcode( $shortcode );
			}
		}

		return array(
			'preview' => (object) $preview,
		);
	}

	/**
	 * Handle preview template items call to the REST API.
	 *
	 * @since 4.0.3
	 * @param WP_REST_Request $request Current request.
	 */
	public static function api_preview_template_items( $request ) {
		$params = $request->get_params();
		$input = isset( $params['input'] ) ? $params['input'] : false;

		$items = array();

		if ( $input ) {
			$post_types = get_post_types();

			unset( $post_types[WPUPG_POST_TYPE] );
			unset( $post_types['revision'] );
			unset( $post_types['nav_menu_item'] );

			$args = array(
				'post_type' => $post_types,
				'post_status' => 'any',
				'posts_per_page' => 20,
				'ignore_sticky_posts' => true,
				's' => $input,
			);
			
			$query = new WP_Query( $args );
			$posts = $query->have_posts() ? $query->posts : array();

			foreach ( $posts as $post ) {
				$item = WPUPG_Item_Manager::get_item( $post->ID );
				$post_type = get_post_type_object( $post->post_type );

				$items[] = array(
					'value' => $post->ID,
					'label' => $post_type->labels->singular_name . ' - ' . $post->ID . ' - ' . $post->post_title,
					'classes' => $item->classes(),
				);
			}
		}

		return $items;
	}
}

WPUPG_Api_Templates::init();
