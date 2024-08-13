<?php
/**
 * Responsible for the grid layout.
 *
 * @link       https://bootstrapped.ventures
 * @since      3.0.0
 *
 * @package    WP_Ultimate_Post_Grid
 * @subpackage WP_Ultimate_Post_Grid/includes/public
 */

/**
 * Responsible for the grid layout.
 *
 * @since      3.0.0
 * @package    WP_Ultimate_Post_Grid
 * @subpackage WP_Ultimate_Post_Grid/includes/public
 * @author     Brecht Vandersmissen <brecht@bootstrapped.ventures>
 */
class WPUPG_Grid_Layout {

	/**
	 * Get styling for the grid.
	 *
	 * @since    3.0.0
	 * @param	 mixed 		$grid 		Grid to output.
	 * @param	 boolean 	$is_preview Wether or not this is styling for a grid preview.
	 */
	public static function get_style( $grid, $is_preview = false ) {
		$output = '';

		// Desktop.
		$style = self::get_item_sizing( $grid, 'desktop' );
		$tablet_style = self::get_item_sizing( $grid, 'tablet' );
		$mobile_style = self::get_item_sizing( $grid, 'mobile' );

		$tablet_breakpoint = WPUPG_Settings::get( 'breakpoint_tablet' );
		$mobile_breakpoint = WPUPG_Settings::get( 'breakpoint_mobile' );

		// Add styling.
		if ( count( $style ) ) {
			$selector = '#wpupg-grid-' . $grid->slug_or_id();

			$output .= '<style>';
			$output .= $selector . ' ';
			$output .= implode( ' ' . $selector . ' ', $style );

			if ( $tablet_style ) {
				$tablet_selector = $is_preview ? '.wpupg-admin-modal-grid-preview-tablet ' . $selector : $selector;

				if ( ! $is_preview ) {
					$output .= ' @media (min-width: ' . $mobile_breakpoint . 'px) and (max-width: ' . $tablet_breakpoint . 'px) {';
				}
				$output .= $tablet_selector . ' ';
				$output .= implode( ' ' . $tablet_selector . ' ', $tablet_style );
				if ( ! $is_preview ) {
					$output .= '}';
				}
			}

			if ( $mobile_style ) {
				$mobile_selector = $is_preview ? '.wpupg-admin-modal-grid-preview-mobile ' . $selector : $selector;

				if ( ! $is_preview ) {
					$output .= ' @media (max-width: ' . $mobile_breakpoint . 'px) {';
				}
				$output .= $mobile_selector . ' ';
				$output .= implode( ' ' . $mobile_selector . ' ', $mobile_style );
				if ( ! $is_preview ) {
					$output .= '}';
				}
			}

			$output .= '</style>';
		}

		return $output;
	}

	/**
	 * Get item sizing styling for the grid.
	 *
	 * @since    3.0.0
	 * @param	 mixed $grid Grid to get the styling for.
	 * @param	 mixed $device Device to get the sizing for.
	 */
	private static function get_item_sizing( $grid, $device ) {
		$style = array();
		$different = 'layout_' . $device . '_different';

		if ( 'desktop' === $device || $grid->$different() ) {
			$sizing = 'layout_' . $device . '_sizing';

			if ( 'ignore' !== $grid->$sizing() ) {
				$sizing_fixed = 'layout_' . $device . '_sizing_fixed';
				$sizing_margin = 'layout_' . $device . '_sizing_margin';
				$sizing_columns = 'layout_' . $device . '_sizing_columns';

				if ( 'fixed' === $grid->$sizing() ) {
					$style[] = '.wpupg-item { width: 100%; max-width: ' . $grid->$sizing_fixed() . 'px; margin: ' . $grid->$sizing_margin() . 'px; }';
				} elseif ( 'columns' === $grid->$sizing() ) {
					$width = floor( 10000 / $grid->$sizing_columns() ) / 100;
					$style[] = '.wpupg-item { width: calc(' . $width . '% - ' . 2 * $grid->$sizing_margin() . 'px); max-width: none; margin: ' . $grid->$sizing_margin() . 'px; }';
				}

				if ( 'masonry' !== $grid->layout_mode() || ! $grid->centered() ) {
					$style[] = '{ margin: 0 -' . $grid->$sizing_margin() . 'px;}';
				}
			}
		}

		return $style;
	}
}
