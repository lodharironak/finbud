<?php
/**
 * Handle the condition shortcode.
 *
 * @link       https://bootstrapped.ventures
 * @since      3.2.1
 *
 * @package    WP_Ultimate_Post_Grid
 * @subpackage WP_Ultimate_Post_Grid/includes/public/shortcodes/special
 */

/**
 * Handle the condition shortcode.
 *
 * @since      3.2.1
 * @package    WP_Ultimate_Post_Grid
 * @subpackage WP_Ultimate_Post_Grid/includes/public/shortcodes/special
 * @author     Brecht Vandersmissen <brecht@bootstrapped.ventures>
 */
class WPUPG_SC_Condition {
	public static function init() {
		add_shortcode( 'wpupg-condition', array( __CLASS__, 'shortcode' ) );
	}

	/**
	 * Output for the shortcode.
	 *
	 * @since	3.2.1
	 * @param	array $atts Options passed along with the shortcode.
	 */
	public static function shortcode( $atts, $content ) {
		$atts = shortcode_atts( array(
			'type' => '',
			'key' => '',
			'values' => '',
			'match' => 'any',
			'inverse' => '0',
		), $atts, 'wpupg_condition' );
		
		$item = WPUPG_Template_Shortcodes::get_item();
		$type = in_array( $atts['type'], array( 'field', 'term_id', 'term_slug' ) ) ? $atts['type'] : false;
		if ( ! $item || ! $content || ! $type ) {
			return '';
		}

		$key = trim( $atts['key'] );
		$values = explode( ';', str_replace( ',', ';', trim( $atts['values'] ) ) );
		$match = in_array( $atts['match'], array( 'any', 'all' ) ) ? $atts['match'] : 'any';
		$inverse = (bool) $atts['inverse'];

		$matches_condition = false;

		switch ( $type ) {
			case 'field':
				$field_value = $item->custom_field( $key );
				$matches_condition = false !== $field_value && in_array( $field_value, $values );
				break;
			case 'term_id':
			case 'term_slug':
				$terms = $item->terms( $key );
				if ( is_wp_error( $terms ) || ! $terms ) {
					$terms = array();
				}

				if ( 'term_id' === $type ) {
					$terms_to_match = wp_list_pluck( $terms, 'term_id' );
					$values = array_map( 'intval', $values );
				} else {
					$terms_to_match = wp_list_pluck( $terms, 'slug' );
				}

				$matches = array_intersect( $values, $terms_to_match );

				if ( 'any' === $match ) {
					$matches_condition = 0 < count( $matches );
				} else {
					$matches_condition = count( $values ) === count( $matches );
				}
				break;
		}

		// Optional inverse match.
		if ( $inverse ) {
			$matches_condition = ! $matches_condition;
		}

		// Return content if it matches the condition, empty otherwise.
		if ( $matches_condition ) {
			return do_shortcode( $content );
		} else {
			return '';
		}
	}
}

WPUPG_SC_Condition::init();