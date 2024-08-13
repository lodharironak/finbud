<?php
/**
 * Handle output for the Clear Filter.
 *
 * @link       https://bootstrapped.ventures
 * @since      3.0.0
 *
 * @package    WP_Ultimate_Post_Grid
 * @subpackage WP_Ultimate_Post_Grid/includes/public
 */

/**
 * Handle output for the Clear Filter.
 *
 * @since      3.0.0
 * @package    WP_Ultimate_Post_Grid
 * @subpackage WP_Ultimate_Post_Grid/includes/public
 * @author     Brecht Vandersmissen <brecht@bootstrapped.ventures>
 */
class WPUPG_Filter_Clear {

	/**
	 * Register actions and filters.
	 *
	 * @since    3.0.0
	 */
	public static function init() {
		add_filter( 'wpupg_filter_defaults', array( __CLASS__, 'defaults' ), 9 );
		add_filter( 'wpupg_filter_sanitize_options', array( __CLASS__, 'sanitize' ), 9, 2 );
		add_filter( 'wpupg_output_filter', array( __CLASS__, 'output' ), 9, 4 );
	}

	/**
	 * Default options for this filter.
	 *
	 * @since    3.0.0
	 * @param	 mixed $defaults Current defaults to filter.
	 */
	public static function defaults( $defaults ) {
		$defaults['clear'] = array(
			'inactive_opacity'				=> '30',
			'clear_button_text' => __( 'Clear All Selections', 'wp-ultimate-post-grid' ),
			'style' => array(
				'font_size'			        => '14',
				'background_color'          => '#FFFFFF',
				'background_hover_color'    => '#FFFFFF',
				'text_color'                => '#2E5077',
				'text_hover_color'          => '#1C3148',
				'border_color'              => '#FFFFFF',
				'border_hover_color'        => '#FFFFFF',
				'border_width'              => '0',
				'border_radius'             => '0',
				'margin_vertical'           => '3',
				'margin_horizontal'         => '0',
				'padding_vertical'          => '0',
				'padding_horizontal'        => '0',
				'alignment'                 => 'left',
			),
		);

		return $defaults;
	}

	/**
	 * Sanitize filter options when saving.
	 *
	 * @since    3.0.0
	 * @param	 mixed $sanitized_options Current sanitized options.
	 * @param	 mixed $filter Filter to sanitize.
	 */
	public static function sanitize( $sanitized_options, $filter ) {
		if ( 'clear' === $filter['type'] ) {
			$options = $filter['options'];

			// Special fields.
			if ( isset( $options['inactive_opacity'] ) ) { $sanitized_options['inactive_opacity'] = max( 0, min( 100, intval( $options['inactive_opacity'] ) ) ); }

			// Text fields.
			if ( isset( $options['clear_button_text'] ) ) { $sanitized_options['clear_button_text'] = sanitize_text_field( $options['clear_button_text'] ); }

			// Style.
			if ( isset( $options['style'] ) ) {
				$sanitized_style = array();
				$style = $options['style'];

				// Text fields.
				if ( isset( $style['background_color'] ) ) 			{ $sanitized_style['background_color'] = sanitize_text_field( $style['background_color'] ); }
				if ( isset( $style['background_hover_color'] ) ) 	{ $sanitized_style['background_hover_color'] = sanitize_text_field( $style['background_hover_color'] ); }
				if ( isset( $style['border_color'] ) ) 				{ $sanitized_style['border_color'] = sanitize_text_field( $style['border_color'] ); }
				if ( isset( $style['border_hover_color'] ) ) 		{ $sanitized_style['border_hover_color'] = sanitize_text_field( $style['border_hover_color'] ); }
				if ( isset( $style['text_color'] ) ) 				{ $sanitized_style['text_color'] = sanitize_text_field( $style['text_color'] ); }
				if ( isset( $style['text_hover_color'] ) ) 			{ $sanitized_style['text_hover_color'] = sanitize_text_field( $style['text_hover_color'] ); }

				// Number fields.
				if ( isset( $style['border_width'] ) )			{ $sanitized_style['border_width'] = intval( $style['border_width'] ); }
				if ( isset( $style['border_radius'] ) )			{ $sanitized_style['border_radius'] = intval( $style['border_radius'] ); }
				if ( isset( $style['font_size'] ) )				{ $sanitized_style['font_size'] = intval( $style['font_size'] ); }
				if ( isset( $style['margin_horizontal'] ) )		{ $sanitized_style['margin_horizontal'] = intval( $style['margin_horizontal'] ); }
				if ( isset( $style['margin_vertical'] ) )		{ $sanitized_style['margin_vertical'] = intval( $style['margin_vertical'] ); }
				if ( isset( $style['padding_horizontal'] ) )	{ $sanitized_style['padding_horizontal'] = intval( $style['padding_horizontal'] ); }
				if ( isset( $style['padding_vertical'] ) )		{ $sanitized_style['padding_vertical'] = intval( $style['padding_vertical'] ); }

				// Limited options fields.
				$field_options = array( 'left', 'center', 'right' );
				if ( isset( $style['alignment'] ) && in_array( $style['alignment'], $field_options, true ) ) {
					$sanitized_style['alignment'] = $style['alignment'];
				}

				$sanitized_options['style'] = $sanitized_style;
			}

			// Combine with defaults.
			$filter_defaults = WPUPG_Filter::get_defaults( 'clear' );
			$sanitized_options = array_replace_recursive( $filter_defaults, $sanitized_options );
		}

		return $sanitized_options;
	}

	/**
	 * Output a specific filter for a specific grid.
	 *
	 * @since    3.0.0
	 * @param	 mixed $output Current filter output.
	 * @param	 mixed $grid Grid to output.
	 * @param	 mixed $filter Filter to output.
	 * @param	 mixed $args Optional arguments.
	 */
	public static function output( $output, $grid, $filter, $args ) {
		if ( 'clear' === $filter['type'] ) {
			$output = '';
			$output .= self::style( $grid, $filter, $args );
			$output .= self::html( $grid, $filter, $args );
		}

		return $output;
	}

	/**
	 * Output HTML for a filter.
	 *
	 * @since    3.0.0
	 * @param	 mixed $grid Grid to output.
	 * @param	 mixed $filter Filter to output.
	 * @param	 mixed $args Optional arguments.
	 */
	public static function html( $grid, $filter, $args ) {
		$output = '';
		$options = $filter['options'];

		$output .= '<div class="wpupg-filter-item wpupg-filter-clear-button" role="button" tabindex="0">' . $options['clear_button_text'] . '</div>';

		return $output;
	}

	 /**
	 * Output styling for a filter.
	 *
	 * @since    3.0.0
	 * @param	 mixed $grid Grid to output.
	 * @param	 mixed $filter Filter to output.
	 * @param	 mixed $args Optional arguments.
	 */
	public static function style( $grid, $filter, $args ) {
		$options = $filter['options'];
		$style = $options['style'];

		$output = '<style>';

		// Filter styling.
		$filter_selector = '#wpupg-grid-' . $grid->slug_or_id() . '-filter-' . $filter['id'];
		$output .= $filter_selector . ' {';
		$output .= 'text-align: ' . $style['alignment'] . ';';
		$output .= 'margin: 0 -' . $style['margin_horizontal'] . 'px;';
		$output .= '}';

		// Default Item styling.
		$item_selector = $filter_selector . ' .wpupg-filter-item';

		$output .= $item_selector . ' {';

		if ( $options['inactive_opacity'] < 100 ) {
			$output .= 'opacity: ' . $options['inactive_opacity'] / 100 . ';';
		}
		if ( $style['border_width'] ) {
			$output .= 'border: ' . $style['border_width'] . 'px solid ' . $style['border_color'] . ';';
		}
		if ( $style['border_radius'] ) {
			$output .= 'border-radius: ' . $style['border_radius'] . 'px;';
		}
		$output .= 'background-color: ' . $style['background_color'] . ';';
		$output .= 'color: ' . $style['text_color'] . ';';

		$output .= 'font-size: ' . $style['font_size'] . 'px;';
		$output .= 'margin: ' . $style['margin_vertical'] . 'px ' . $style['margin_horizontal'] . 'px;';
		$output .= 'padding: ' . $style['padding_vertical'] . 'px ' . $style['padding_horizontal'] . 'px;';
		$output .= '}';

		// Focus Item styling.
		$hover_styles = '';
		$hover_styles .= 'outline: none;';
		$hover_styles .= 'border-color: ' . $style['border_hover_color'] . ';';
		$hover_styles .= 'background-color: ' . $style['background_hover_color'] . ';';
		$hover_styles .= 'color: ' . $style['text_hover_color'] . ';';

		$output .= $item_selector . ':focus {' . $hover_styles . '}';

		// Hover Item, only with mouse pointer.
		$output .= '@media (hover: hover) and (pointer: fine) {';
		$output .= $item_selector . ':hover {' . $hover_styles . '}';
		$output .= '}';

		$output .= '</style>';

		return $output;
	}
}

WPUPG_Filter_Clear::init();
