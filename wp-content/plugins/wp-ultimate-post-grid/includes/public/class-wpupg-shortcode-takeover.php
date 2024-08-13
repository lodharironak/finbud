<?php
/**
 * Handle the grid shortcode takeover.
 *
 * @link       https://bootstrapped.ventures
 * @since      3.8.0
 *
 * @package    WP_Ultimate_Post_Grid
 * @subpackage WP_Ultimate_Post_Grid/includes/public
 */

/**
 * Handle the grid shortcode takeover.
 *
 * @since      3.8.0
 * @package    WP_Ultimate_Post_Grid
 * @subpackage WP_Ultimate_Post_Grid/includes/public
 * @author     Brecht Vandersmissen <brecht@bootstrapped.ventures>
 */
class WPUPG_Shortcode_Takeover {

	/**
	 * Register actions and filters.
	 *
	 * @since    3.0.0
	 */
	public static function init() {		
		add_filter( 'shortcode_atts_wpupg_grid_with_filters', array( __CLASS__, 'shortcode_atts' ), 2, 3 );
		add_filter( 'shortcode_atts_wpupg_grid', array( __CLASS__, 'shortcode_atts' ), 2, 3 );
	}

	/**
	 * Filter the grid shortcode attributes.
	 *
	 * @since    3.8.0
	 * @param 	array  $out       The output array of shortcode attributes.
     * @param 	array  $pairs     The supported attributes and their defaults.
     * @param 	array  $atts      The user defined shortcode attributes.
	 */
	public static function shortcode_atts( $out, $pairs, $atts ) {
		if ( isset( $atts['takeover'] ) ) {
			switch ( $atts['takeover'] ) {
				case 'query':
					$out = self::takeover_query( $out );
					break;
				case 'archive':
					$out = self::takeover_archive( $out );
					break;
				case 'search':
					$out = self::takeover_search( $out );
					break;
			}
		}

		return $out;
	}

	/**
	 * Takeover a generic query page.
	 *
	 * @since    3.8.0
     * @param 	array  $atts The shortcode attributes.
	 */
	public static function takeover_query( $atts ) {
		global $wp_query;

		if ( $wp_query && isset( $wp_query->posts ) && is_array( $wp_query->posts ) ) {
			$post_ids = wp_list_pluck( $wp_query->posts, 'ID' );
			
			if ( $post_ids ) {
				$atts[ 'post_id' ] = implode( ';', $post_ids );
			}
		}
		
		return $atts;
	}

	/**
	 * Takeover an archive page.
	 *
	 * @since    3.8.0
     * @param 	array  $atts The shortcode attributes.
	 */
	public static function takeover_archive( $atts ) {
		$term = get_queried_object();

		if ( $term && 'WP_Term' === get_class( $term ) ) {
			$atts[ $term->taxonomy ] = $term->term_id;
		}
		
		return $atts;
	}

	/**
	 * Takeover a search page.
	 *
	 * @since    3.8.0
     * @param 	array  $atts The shortcode attributes.
	 */
	public static function takeover_search( $atts ) {
		global $wp_query;

		if ( $wp_query && isset( $wp_query->is_search ) && $wp_query->is_search ) {
			$search = isset( $wp_query->query_vars ) && isset( $wp_query->query_vars['s'] ) ? $wp_query->query_vars['s'] : false;

			if ( $search ) {
				$slug = strtolower( trim( $atts['id'] ) );
				$grid = WPUPG_Grid_Manager::get_grid( $slug );

				if ( $grid ) {
					$args = array(
						'post_type' => $grid->post_types(),
						'post_status' => $grid->post_status(),
						'nopaging' => true,
						'posts_per_page' => -1,
						'ignore_sticky_posts' => true,
						'fields' => 'ids',
						's' => $search,
					);

					$query = new WP_Query( $args );
					$post_ids = $query->have_posts() ? $query->posts : array();

					if ( $post_ids ) {
						$atts[ 'post_id' ] = implode( ';', $post_ids );
					}
				}
			}
		}

		return $atts;
	}
}

WPUPG_Shortcode_Takeover::init();
