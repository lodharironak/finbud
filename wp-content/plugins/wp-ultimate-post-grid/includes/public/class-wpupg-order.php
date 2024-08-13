<?php
/**
 * Handle the grid order.
 *
 * @link       https://bootstrapped.ventures
 * @since      3.9.0
 *
 * @package    WP_Ultimate_Post_Grid
 * @subpackage WP_Ultimate_Post_Grid/includes/public
 */

/**
 * Handles the grid order.
 *
 * @since      3.9.0
 * @package    WP_Ultimate_Post_Grid
 * @subpackage WP_Ultimate_Post_Grid/includes/public
 * @author     Brecht Vandersmissen <brecht@bootstrapped.ventures>
 */
class WPUPG_Order {

	/**
	 * Register actions and filters.
	 *
	 * @since    3.9.0
	 */
	public static function init() {
		add_filter( 'wpupg_javascript_args', array( __CLASS__, 'javascript_args' ), 10, 2 );
		add_filter( 'wpupg_output_item_data', array( __CLASS__, 'item_data' ), 10, 4 );
	}

	/**
	 * JavaScript arguments for the grid order.
	 *
	 * @since    3.9.0
	 * @param	 mixed $args Current JavaScript arguments.
	 * @param	 mixed $grid Grid to output.
	 */
	public static function javascript_args( $args, $grid ) {
		$parsing = self::get_order_parsing( $grid );

		$args['isotope']['getSortData'] = array(
			'default' => '[data-order-default]' . $parsing,
		);
		$args['isotope']['sortBy'] = 'default';
		$args['isotope']['sortAscending'] = 'desc' === $grid->grid_order() ? false : true;

		return $args;
	}

	/**
	 * Add order data to a grid item.
	 *
	 * @since    3.9.0
	 */
	public static function item_data( $data, $grid, $item, $args ) {
		if ( $grid ) {
			$order_key = self::get_order_key( $grid, $item );

			if ( false !== $order_key ) {
				$data[ 'order-default' ] = $order_key;
			}
		}

		return $data;
	}

	/**
	 * Get order key for a specific grid item.
	 *
	 * @since    3.9.0
	 */
	public static function get_order_key( $grid, $item ) {
		$order_key = false;

		switch( $grid->grid_order_by() ) {
			case 'title':
			case 'name':
				$order_key = $item->title();
				break;
			case 'slug':
				$order_key = $item->slug();
				break;
			case 'description':
				$order_key = $item->description();
				break;
			case 'term_id':
				$order_key = $item->id();
				break;
			case 'date':
				$order_key = strtotime( $item->date() );
				break;
			case 'modified':
				$order_key = strtotime( $item->date_modified() );
				break;
			case 'author':
				$order_key = $item->author_id();
				break;
			case 'comment_count':
				$order_key = $item->comment_count();
				break;
			case 'count':
				$order_key = $item->count();
				break;
			case 'rand':
				break;
			case 'menu_order':
				$order_key = $item->menu_order();
				break;
			case 'custom':
				$meta_key = $grid->order_custom_key();
				$order_key = $item->meta( $meta_key );
				break;
		}

		return $order_key;
	}

	/**
	 * Get parsing for a specific grid.
	 *
	 * @since    3.9.0
	 */
	public static function get_order_parsing( $grid ) {
		$parsing = '';

		switch( $grid->grid_order_by() ) {
			case 'date':
			case 'modified':
			case 'comment_count':
			case 'count':
			case 'term_id':
			case 'rand':
			case 'author':
				$parsing = 'parseInt';
				break;
			case 'menu_order':
				$parsing = 'parseFloat';
				break;
			case 'custom':
				if ( $grid->order_custom_key_numeric() ) {
					$parsing = 'parseFloat';
				}
				break;
		}

		// Add space in front if parsing is needed.
		if ( $parsing ) {
			$parsing = ' ' . $parsing;
		}

		return $parsing;
	}
}

WPUPG_Order::init();
