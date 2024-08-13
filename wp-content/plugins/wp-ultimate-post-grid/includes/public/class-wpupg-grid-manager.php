<?php
/**
 * Responsible for returning grids.
 *
 * @link       https://bootstrapped.ventures
 * @since      3.0.0
 *
 * @package    WP_Ultimate_Post_Grid
 * @subpackage WP_Ultimate_Post_Grid/includes/public
 */

/**
 * Responsible for returning grids.
 *
 * @since      3.0.0
 * @package    WP_Ultimate_Post_Grid
 * @subpackage WP_Ultimate_Post_Grid/includes/public
 * @author     Brecht Vandersmissen <brecht@bootstrapped.ventures>
 */
class WPUPG_Grid_Manager {

	/**
	 * Grids that have already been requested for easy subsequent access.
	 *
	 * @since    3.0.0
	 * @access   private
	 * @var      array $grids Array containing grids that have already been requested for easy access.
	 */
	private static $grids = array();

	/**
	 * Slugs that have already been requested for easy subsequent access.
	 *
	 * @since    3.0.0
	 * @access   private
	 * @var      array $slugs Array containing slugs that have already been requested for easy access.
	 */
	private static $slugs = array();

	/**
	 * Get all grid IDs.
	 *
	 * @since    3.0.0
	 */
	public static function get_grid_ids() {
		$args = array(
			'post_type' => WPUPG_POST_TYPE,
			'post_status' => 'any',
			'nopaging' => true,
			'fields' => 'ids',
		);

		$query = new WP_Query( $args );

		return $query->posts;
	}

	/**
	 * Get grids with their filters.
	 *
	 * @since    3.0.0
	 */
	public static function get_grids() {
		$grids = array();

		$args = array(
				'post_type' => WPUPG_POST_TYPE,
				'post_status' => 'any',
				'orderby' => 'date',
				'order' => 'DESC',
				'posts_per_page' => -1,
				'offset' => 0,
		);

		$query = new WP_Query( $args );

		if ( $query->have_posts() ) {
			$posts = $query->posts;

			foreach ( $posts as $post ) {
				$slug = $post->post_name;
				$grids[] = array(
					'id' => $post->ID,
					'name' => $post->post_title,
					'slug' => $slug ? $slug : $post->ID,
				);
			}
		}

		return $grids;
	}

	/**
	 * Get grid object by ID.
	 *
	 * @since    3.0.0
	 * @param	 mixed $slug_id_post Slug, ID or Post Object for the grid we want.
	 */
	public static function get_grid( $slug_id_or_post ) {	
		if ( is_object( $slug_id_or_post ) && $slug_id_or_post instanceof WP_Post ) {
			$post = $slug_id_or_post;
			$grid_id = $post->ID;
		} else {
			// Check if it's a slug.
			$post = false;
			$grid_id = self::get_grid_id_from_slug( $slug_id_or_post );

			if ( ! $grid_id ) {
				$grid_id = intval( $slug_id_or_post );
			}
		}

		// Only get new grid object if it hasn't been retrieved before.
		if ( ! array_key_exists( $grid_id, self::$grids ) ) {
			if ( ! $post ) {
				$post = get_post( $grid_id );
			}

			if ( $post instanceof WP_Post && WPUPG_POST_TYPE === $post->post_type ) {
				$grid = new WPUPG_Grid( $post );
			} else {
				$grid = false;
			}

			self::$grids[ $grid_id ] = $grid;
		}

		return self::$grids[ $grid_id ];
	}

	/**
	 * Get grid ID by its slug.
	 *
	 * @since    3.0.0
	 * @param	 mixed $slug Slug of the grid we want.
	 */
	public static function get_grid_id_from_slug( $slug ) {
		if ( ! array_key_exists( $slug, self::$slugs ) ) {
			$post = get_page_by_path( $slug, OBJECT, WPUPG_POST_TYPE );

			if ( ! is_null( $post ) ) {
				$grid_id = $post->ID;
			} else {
				$grid_id = false;
			}

			self::$slugs[ $slug ] = $grid_id;
		}

		return self::$slugs[ $slug ];
	}

	/**
	 * Invalidate cached grid.
	 *
	 * @since    3.0.0
	 * @param	 int $grid_id ID of the grid to invalidate.
	 */
	public static function invalidate_grid( $grid_id ) {
		if ( array_key_exists( $grid_id, self::$grids ) ) {
			unset( self::$grids[ $grid_id ] );
		}
	}
}