<?php
/**
 * Responsible for returning items.
 *
 * @link       https://bootstrapped.ventures
 * @since      3.0.0
 *
 * @package    WP_Ultimate_Post_Grid
 * @subpackage WP_Ultimate_Post_Grid/includes/public
 */

/**
 * Responsible for returning items.
 *
 * @since      3.0.0
 * @package    WP_Ultimate_Post_Grid
 * @subpackage WP_Ultimate_Post_Grid/includes/public
 * @author     Brecht Vandersmissen <brecht@bootstrapped.ventures>
 */
class WPUPG_Item_Manager {

	/**
	 * Items that have already been requested for easy subsequent access.
	 *
	 * @since    3.0.0
	 * @access   private
	 * @var      array $items Array containing items that have already been requested for easy access.
	 */
	private static $items = array(
		'posts' => array(),
		'terms' => array(),
	);

	/**
	 * Get item object by ID.
	 *
	 * @since    3.0.0
	 * @param	 mixed $slug_id_post Slug, ID or Post Object for the item we want.
	 * @param	 mixed $grid_type Type of grid we want to get the item for.
	 */
	public static function get_item( $id, $grid_type = 'posts' ) {	
		$id = intval( $id );

		// Only get new item object if it hasn't been retrieved before.
		if ( ! array_key_exists( $id, self::$items[ $grid_type ] ) ) {
			if ( 'posts' === $grid_type ) {
				self::$items[ 'posts' ][ $id ] = new WPUPG_Item_Post( $id );
			} else {
				self::$items[ 'terms' ][ $id ] = class_exists( 'WPUPGP_Item_Term' ) ? new WPUPGP_Item_Term( $id ) : new WPUPG_Item( array() );
			}
		}

		return self::$items[ $grid_type ][ $id ];
	}

	/**
	 * Invalidate cached item.
	 *
	 * @since    3.0.0
	 * @param	 int $id ID of the item to invalidate.
	 * @param	 mixed $grid_type Type of grid we want to invalidate the item for.
	 */
	public static function invalidate_item( $id, $grid_type = 'posts' ) {
		$id = intval( $id );

		if ( array_key_exists( $id, self::$items[ $grid_type ] ) ) {
			unset( self::$items[ $grid_type ][ $id ] );
		}
	}
}
