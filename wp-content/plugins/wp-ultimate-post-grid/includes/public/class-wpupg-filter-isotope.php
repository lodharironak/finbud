<?php
/**
 * Handle output for the Isotope Filter.
 *
 * @link       https://bootstrapped.ventures
 * @since      3.0.0
 *
 * @package    WP_Ultimate_Post_Grid
 * @subpackage WP_Ultimate_Post_Grid/includes/public
 */

/**
 * Handle output for the Isotope Filter.
 *
 * @since      3.0.0
 * @package    WP_Ultimate_Post_Grid
 * @subpackage WP_Ultimate_Post_Grid/includes/public
 * @author     Brecht Vandersmissen <brecht@bootstrapped.ventures>
 */
class WPUPG_Filter_Isotope {

	/**
	 * Register actions and filters.
	 *
	 * @since    3.0.0
	 */
	public static function init() {
		add_filter( 'wpupg_filter_defaults', array( __CLASS__, 'defaults' ), 9 );
		add_filter( 'wpupg_filter_sanitize_options', array( __CLASS__, 'sanitize' ), 9, 2 );
		add_filter( 'wpupg_javascript_args_filter', array( __CLASS__, 'javascript_args' ), 9, 3 );
		add_filter( 'wpupg_output_filter', array( __CLASS__, 'output' ), 9, 4 );
	}

	/**
	 * Default options for this filter.
	 *
	 * @since    3.0.0
	 * @param	 mixed $defaults Current defaults to filter.
	 */
	public static function defaults( $defaults ) {
		$defaults['isotope'] = array(
			'source' => 'taxonomies',
			'custom_field' => '',
			'custom_field_numeric' => false,
			'custom_field_fuzzy' => false,
			'custom_field_options' => array(),
			'taxonomies' => array(),
			'match_parents' => false,
			'inverse' => false,
			'show_empty' => false,
			'count' => false,
			'multiselect' => false,
			'multiselect_type' => 'match_all',
			'limit' => false,
			'limit_exclude' => false,
			'limit_terms' => array(),
			'all_button_text' => __( 'All', 'wp-ultimate-post-grid' ),
			'term_order' => 'alphabetical',
			'custom_term_order' => array(),
			'style' => array(
				'font_size'			        => '14',
				'background_color'          => '#2E5077',
				'background_active_color'   => '#1C3148',
				'background_hover_color'    => '#1C3148',
				'text_color'                => '#FFFFFF',
				'text_active_color'         => '#FFFFFF',
				'text_hover_color'          => '#FFFFFF',
				'border_color'              => '#1C3148',
				'border_active_color'       => '#1C3148',
				'border_hover_color'        => '#1C3148',
				'border_width'              => '1',
				'border_radius'             => '0',
				'margin_vertical'           => '5',
				'margin_horizontal'         => '5',
				'padding_vertical'          => '5',
				'padding_horizontal'        => '10',
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
		if ( 'isotope' === $filter['type'] ) {
			$options = $filter['options'];

			// Boolean fields.
			if ( isset( $options['count'] ) ) { $sanitized_options['count'] = $options['count'] ? true : false; }
			if ( isset( $options['inverse'] ) ) { $sanitized_options['inverse'] = $options['inverse'] ? true : false; }
			if ( isset( $options['limit'] ) ) { $sanitized_options['limit'] = $options['limit'] ? true : false; }
			if ( isset( $options['limit_exclude'] ) ) { $sanitized_options['limit_exclude'] = $options['limit_exclude'] ? true : false; }
			if ( isset( $options['match_parents'] ) ) { $sanitized_options['match_parents'] = $options['match_parents'] ? true : false; }
			if ( isset( $options['multiselect'] ) ) { $sanitized_options['multiselect'] = $options['multiselect'] ? true : false; }
			if ( isset( $options['show_empty'] ) ) { $sanitized_options['show_empty'] = $options['show_empty'] ? true : false; }

			// Custom Field.
			if ( isset( $options['custom_field'] ) ) { $sanitized_options['custom_field'] = sanitize_key( $options['custom_field'] ); }
			if ( isset( $options['custom_field_numeric'] ) ) { $sanitized_options['custom_field_numeric'] = $options['custom_field_numeric'] ? true : false; }
			if ( isset( $options['custom_field_fuzzy'] ) ) { $sanitized_options['custom_field_fuzzy'] = $options['custom_field_fuzzy'] ? true : false; }
			if ( isset( $options['custom_field_options'] ) ) {
				$sanitized_options['custom_field_options'] = array_map( function( $custom_field_option ) {
					return array(
						'value' => sanitize_text_field( $custom_field_option['value'] ),
						'label' => sanitize_text_field( $custom_field_option['label'] ),
					);
				}, $options['custom_field_options'] );
			}

			// Text fields.
			if ( isset( $options['all_button_text'] ) ) { $sanitized_options['all_button_text'] = sanitize_text_field( $options['all_button_text'] ); }

			// Limited options fields.
			$field_options = array( 'taxonomies', 'custom_field' );
			if ( isset( $options['source'] ) && in_array( $options['source'], $field_options, true ) ) {
				$sanitized_options['source'] = $options['source'];
			}

			$field_options = array( 'match_all', 'match_one' );
			if ( isset( $options['multiselect_type'] ) && in_array( $options['multiselect_type'], $field_options, true ) ) {
				$sanitized_options['multiselect_type'] = $options['multiselect_type'];
			}

			$field_options = array( 'alphabetical', 'reverse_alphabetical', 'alphabetical_taxonomies', 'reverse_alphabetical_taxonomies', 'alphabetical_taxonomies_grouped', 'reverse_alphabetical_taxonomies_grouped', 'count_asc', 'count_desc', 'custom' );
			if ( isset( $options['term_order'] ) && in_array( $options['term_order'], $field_options, true ) ) {
				$sanitized_options['term_order'] = $options['term_order'];
			}

			// Taxonomies.
			if ( isset( $options['taxonomies'] ) ) {
				$sanitized_options['taxonomies'] = array_map( function( $taxonomy ) {
					return sanitize_key( $taxonomy );
				}, $options['taxonomies'] );
			}

			// Terms.
			if ( isset( $options['limit_terms'] ) ) {
				$sanitized_options['limit_terms'] = array();
				
				foreach ( $options['limit_terms'] as $taxonomy => $terms ) {
					$taxonomy = sanitize_key( $taxonomy );
					$sanitized_options['limit_terms'][ $taxonomy ] = array_map( 'intval', $terms ); 
				}
			}

			if ( isset( $options['custom_term_order'] ) ) {
				$sanitized_options['custom_term_order'] = array();
				
				foreach ( $options['custom_term_order'] as $taxonomy => $terms ) {
					$taxonomy = sanitize_key( $taxonomy );
					$sanitized_options['custom_term_order'][ $taxonomy ] = array_map( 'intval', $terms ); 
				}
			}

			// Style.
			if ( isset( $options['style'] ) ) {
				$sanitized_style = array();
				$style = $options['style'];

				// Text fields.
				if ( isset( $style['background_active_color'] ) )	{ $sanitized_style['background_active_color'] = sanitize_text_field( $style['background_active_color'] ); }
				if ( isset( $style['background_color'] ) ) 			{ $sanitized_style['background_color'] = sanitize_text_field( $style['background_color'] ); }
				if ( isset( $style['background_hover_color'] ) ) 	{ $sanitized_style['background_hover_color'] = sanitize_text_field( $style['background_hover_color'] ); }
				if ( isset( $style['border_active_color'] ) ) 		{ $sanitized_style['border_active_color'] = sanitize_text_field( $style['border_active_color'] ); }
				if ( isset( $style['border_color'] ) ) 				{ $sanitized_style['border_color'] = sanitize_text_field( $style['border_color'] ); }
				if ( isset( $style['border_hover_color'] ) ) 		{ $sanitized_style['border_hover_color'] = sanitize_text_field( $style['border_hover_color'] ); }
				if ( isset( $style['text_active_color'] ) ) 		{ $sanitized_style['text_active_color'] = sanitize_text_field( $style['text_active_color'] ); }
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
			$filter_defaults = WPUPG_Filter::get_defaults( 'isotope' );
			$sanitized_options = array_replace_recursive( $filter_defaults, $sanitized_options );
		}

		return $sanitized_options;
	}

	/**
	 * JavaScript arguments for this type of filter.
	 *
	 * @since    3.0.0
	 * @param	 mixed $args Current JavaScript arguments.
	 * @param	 mixed $grid Grid to output.
	 * @param	 mixed $filter Filter to output.
	 */
	public static function javascript_args( $args, $grid, $filter ) {
		if ( 'isotope' === $filter['type'] ) {
			$args['source'] = $filter['options']['source'];
			$args['custom_field'] = $filter['options']['custom_field'];
			$args['custom_field_numeric'] = $filter['options']['custom_field_numeric'];
			$args['custom_field_fuzzy'] = $filter['options']['custom_field_fuzzy'];
			$args['inverse'] = $filter['options']['inverse'];
			$args['match_parents'] = $filter['options']['match_parents'];
			$args['multiselect'] = $filter['options']['multiselect'];
			$args['multiselect_type'] = $filter['options']['multiselect_type'];
		}

		return $args;
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
		if ( 'isotope' === $filter['type']
			&& (
				( 'taxonomies' === $filter['options']['source'] && 0 < count( $filter['options']['taxonomies'] ) )
				|| ( 'custom_field' === $filter['options']['source'] && 0 < count( $filter['options']['custom_field_options'] ) )
			)
		 ) {
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

		// Output all button if set.
		if ( $options['all_button_text'] ) {
			$output .= '<div class="wpupg-filter-item wpupg-filter-isotope-term wpupg-filter-isotope-all wpupg-filter-tag- active" role="button" tabindex="0">' . $options['all_button_text'] . '</div>';
		}

		// Get the output for each button.
		if ( 'custom_field' === $options['source'] ) {
			$button_output = self::button_output_custom_field( $grid, $options );
		} else {
			$button_output = self::button_output_taxonomies( $grid, $options );
		}

		// Allow order and output to get altered.
		$button_output = apply_filters( 'wpupg_filter_isotope_buttons', $button_output, $filter, $grid, $args );

		// Output buttons.
		$current_group = false;
		foreach ( $button_output as $sort_key => $button_output ) {
			if ( 'taxonomies' === $options['source'] && in_array( $options['term_order'], array( 'alphabetical_taxonomies_grouped', 'reverse_alphabetical_taxonomies_grouped' ) ) ) {
				$sort_key_parts = explode( ';', $sort_key );

				if ( $current_group !== $sort_key_parts[0] ) {
					if ( false !== $current_group ) {
						$output .= '</div>';
					}
					$current_group = $sort_key_parts[0];
					$output .= '<div class="wpupg-filter-tax-container wpupg-filter-tax-' . $sort_key_parts[0] . '">';
				}

			}

			$output .= $button_output;
		}

		// Make sure to add closing div if buttons were grouped.
		if ( false !== $current_group ) {
			$output .= '</div>';
		}

		return $output;
	}

	/**
	 * Get taxonomy buttons.
	 *
	 * @since    3.3.0
	 * @param	 mixed $grid Grid to output.
	 * @param	 mixed $options Filter options.
	 */
	private static function button_output_taxonomies( $grid, $options ) {
		$button_output = array();
		foreach ( $options['taxonomies'] as $taxonomy_order => $taxonomy ) {
			$taxonomy_terms = $grid->get_terms_for_taxonomy( $taxonomy );
			
			// Show empty terms.
			if ( $options['show_empty'] ) {
				$all_terms = get_terms( array(
					'taxonomy' => $taxonomy,
					'hide_empty' => false,
				) );

				if ( $all_terms && ! is_wp_error( $all_terms ) ) {
					foreach( $all_terms as $term ) {
						$slug = urldecode( $term->slug );
						$name = apply_filters( 'wpupg_term_name', $term->name, $term->term_id, $taxonomy );

						if ( ! array_key_exists( $slug, $taxonomy_terms ) ) {
							$taxonomy_terms[ $slug ] = array(
								'id' => $term->term_id,
								'name' => $name,
								'posts' => array(),
								'child_posts' => array(),
							);
						}
					}
				}
			}
			
			// Optionally limit the terms to output.
			if ( $options['limit'] ) {
				$limit_term_ids = isset( $options['limit_terms'][ $taxonomy ] ) ? $options['limit_terms'][ $taxonomy ] : array();
				$exclude_term_ids = $options['limit_exclude'];

				if ( 0 < count( $limit_term_ids ) ) {
					$taxonomy_terms = array_filter( $taxonomy_terms, function( $term ) use ( $limit_term_ids, $exclude_term_ids ) {
						$in_array = in_array( $term['id'], $limit_term_ids );
						return $exclude_term_ids ? ! $in_array : $in_array;
					});
				}
			}

			// Get button output for all terms;
			foreach ( $taxonomy_terms as $slug => $term ) {
				$filter_terms = array( $slug );
				
				// Optionally add count label.
				$count_number = 0;
				$count_label = '';
				if ( $options['count'] || in_array( $options['term_order'], array( 'count_desc', 'count_asc' ) ) ) {
					if ( $options['match_parents'] ) {
						$count_number = count( $term['posts'] ) + count( $term['child_posts'] );
					} else {
						$count_number = count( $term['posts'] );
					}

					if ( $options['count'] ) {
						$count_label = ' (<span class="wpupg-term-count">' . $count_number . '</span>)';
					}
				}

				// Need to skip terms that don't have a direct match when not showing empty.
				if ( ! $options['show_empty'] ) {
					if ( $options['match_parents'] ) {
						if ( 0 === count( $term['posts'] ) + count( $term['child_posts'] ) ) {
							continue;
						}
					} else {
						if ( 0 === count( $term['posts'] ) ) {
							continue;
						}
					}
				}

				// Construct sort key.
				$sort_key = strtolower( $term['name'] ) . ';' . str_pad( $term['id'], 10, '0', STR_PAD_LEFT );

				// Sort by count.
				if ( in_array( $options['term_order'], array( 'count_desc', 'count_asc' ) ) ) {
					$sort_key = str_pad( $count_number, 10, '0', STR_PAD_LEFT ) . ';' . $sort_key;
				} elseif ( ! in_array( $options['term_order'], array( 'alphabetical', 'reverse_alphabetical' ) ) ) {
					if ( 'custom' === $options['term_order'] ) {
						$index = isset( $options['custom_term_order'][ $taxonomy ] ) ? array_search( $term['id'], $options['custom_term_order'][ $taxonomy ] ) : false;

						if ( false !== $index ) {
							$sort_key = str_pad( $index, 10, '0', STR_PAD_LEFT );
						} else {
							// Last, ordered by ID.
							$sort_key = str_pad( $term['id'], 10, '1', STR_PAD_LEFT );
						}
					}

					// Grouped by taxonomy.
					$sort_key = str_pad( $taxonomy_order, 10, '0', STR_PAD_LEFT ) . ';' . $sort_key;
				}

				$button_output[ $sort_key ] = '<div class="wpupg-filter-item wpupg-filter-isotope-term wpupg-filter-isotope-term-' . $taxonomy .' wpupg-filter-tag-' . $slug .'" data-taxonomy="' . $taxonomy . '" data-terms="' . implode( ';', $filter_terms ) . '" role="button" tabindex="0">' . $term['name'] . $count_label . '</div>';
			}
		}

		// Sort buttons (reverse) alphabetically.
		if ( in_array( $options['term_order'], array( 'alphabetical', 'alphabetical_taxonomies', 'alphabetical_taxonomies_grouped', 'count_asc', 'custom' ) ) ) {
			ksort( $button_output );
		} else {
			krsort( $button_output );
		}

		return $button_output;
	}

	/**
	 * Get custom field buttons.
	 *
	 * @since    3.3.0
	 * @param	 mixed $grid Grid to output.
	 * @param	 mixed $options Filter options.
	 */
	private static function button_output_custom_field( $grid, $options ) {
		$button_output = array();
		$custom_field = $options['custom_field'];

		foreach ( $options['custom_field_options'] as $index => $custom_field_option ) {
			$value = $custom_field_option['value'];
			$label = $custom_field_option['label'];

			if ( $value && $label ) {
				$button_output[] = '<div class="wpupg-filter-item wpupg-filter-isotope-term wpupg-filter-isotope-custom-field wpupg-filter-isotope-custom-field-' . $custom_field . '" data-value="' . esc_attr( $value ) . '" role="button" tabindex="0">' . $label . '</div>';
			}
		}

		return $button_output;
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
		$style = $filter['options']['style'];

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

		// Active Item styling.
		$output .= $item_selector . '.active {';
		$output .= 'border-color: ' . $style['border_active_color'] . ';';
		$output .= 'background-color: ' . $style['background_active_color'] . ';';
		$output .= 'color: ' . $style['text_active_color'] . ';';
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

WPUPG_Filter_Isotope::init();
