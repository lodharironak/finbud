<?php
/**
 * Responsible for grid pagination.
 *
 * @link       https://bootstrapped.ventures
 * @since      3.0.0
 *
 * @package    WP_Ultimate_Post_Grid
 * @subpackage WP_Ultimate_Post_Grid/includes/public
 */

/**
 * Responsible for grid pagination.
 *
 * @since      3.0.0
 * @package    WP_Ultimate_Post_Grid
 * @subpackage WP_Ultimate_Post_Grid/includes/public
 * @author     Brecht Vandersmissen <brecht@bootstrapped.ventures>
 */
class WPUPG_Pagination {
	/**
	 * Get pagination defaults.
	 *
	 * @since    3.0.0
	 * @param	 mixed $type Optional pagination type to get the defaults for.
	 */
	public static function get_defaults( $type = false ) {
		$defaults = apply_filters( 'wpupg_pagination_defaults', array() );

		if ( false === $type ) {
			return $defaults;
		} else {
			if ( isset( $defaults[ $type ] ) ) {
				return $defaults[ $type ];
			} else {
				return false;
			}
		}
	}
}
