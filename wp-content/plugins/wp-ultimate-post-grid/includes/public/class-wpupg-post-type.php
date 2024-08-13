<?php
/**
 * Register the Grid post type.
 *
 * @link       https://bootstrapped.ventures
 * @since      3.0.0
 *
 * @package    WP_Ultimate_Post_Grid
 * @subpackage WP_Ultimate_Post_Grid/includes/public
 */

/**
 * Register the Grid post type.
 *
 * @since      3.0.0
 * @package    WP_Ultimate_Post_Grid
 * @subpackage WP_Ultimate_Post_Grid/includes/public
 * @author     Brecht Vandersmissen <brecht@bootstrapped.ventures>
 */
class WPUPG_Post_Type {

	/**
	 * Register actions and filters.
	 *
	 * @since    3.0.0
	 */
	public static function init() {
		add_action( 'init', array( __CLASS__, 'register_post_type' ), 1 );
	}

	/**
	 * Register the Link post type.
	 *
	 * @since    3.0.0
	 */
	public static function register_post_type() {
		$labels = array(
			'name'               => _x( 'Grids', 'post type general name', 'wp-ultimate-post-grid' ),
			'singular_name'      => _x( 'Grid', 'post type singular name', 'wp-ultimate-post-grid' ),
		);

		$args = apply_filters( 'wpupg_register_post_type', array(
			'labels' => $labels,
			'public'             => false,
			'rewrite'            => false,
			'capability_type'    => 'post',
			'query_var'          => false,
			'has_archive'        => false,
			'show_in_rest' => true,
			'rest_base' => WPUPG_POST_TYPE,
			'rest_controller_class' => 'WP_REST_Posts_Controller',
		));

		register_post_type( WPUPG_POST_TYPE, $args );
	}
}

WPUPG_Post_Type::init();
