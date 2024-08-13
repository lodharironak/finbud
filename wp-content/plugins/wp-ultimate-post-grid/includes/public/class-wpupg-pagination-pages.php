<?php
/**
 * Handle output for the pages pagination.
 *
 * @link       https://bootstrapped.ventures
 * @since      3.0.0
 *
 * @package    WP_Ultimate_Post_Grid
 * @subpackage WP_Ultimate_Post_Grid/includes/public
 */

/**
 * Handle output for the pages pagination.
 *
 * @since      3.0.0
 * @package    WP_Ultimate_Post_Grid
 * @subpackage WP_Ultimate_Post_Grid/includes/public
 * @author     Brecht Vandersmissen <brecht@bootstrapped.ventures>
 */
class WPUPG_Pagination_Pages {

	/**
	 * Register actions and filters.
	 *
	 * @since    3.0.0
	 */
	public static function init() {
		add_filter( 'wpupg_pagination_defaults', array( __CLASS__, 'defaults' ), 9 );
		add_filter( 'wpupg_pagination_sanitize_options', array( __CLASS__, 'sanitize' ), 9, 2 );
		add_filter( 'wpupg_javascript_args_pagination', array( __CLASS__, 'javascript_args' ), 9, 2 );
		add_filter( 'wpupg_query_post_args', array( __CLASS__, 'query_args' ), 10, 3 );
		add_filter( 'wpupg_grid_ids', array( __CLASS__, 'ids' ), 9, 3 );
		add_filter( 'wpupg_output_item_classes', array( __CLASS__, 'classes' ), 9, 4 );
		add_filter( 'wpupg_output_pagination', array( __CLASS__, 'output' ), 9, 3 );
	}

	/**
	 * Default options for this filter.
	 *
	 * @since    3.0.0
	 * @param	 mixed $defaults Current defaults to filter.
	 */
	public static function defaults( $defaults ) {
		$defaults['pages'] = array(
			'posts_per_page' => 20,
			'adaptive_pages' => true,
			'max_buttons' => 0,
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
	 * Sanitize pagination options when saving.
	 *
	 * @since    3.0.0
	 * @param	 mixed $sanitized_options Current sanitized options.
	 * @param	 mixed $pagination Pagination to sanitize.
	 */
	public static function sanitize( $sanitized_pagination, $pagination ) {
		if ( isset( $pagination['pages'] ) ) {
			$options = $pagination['pages'];
			$sanitized_options = array();

			// Number fields.
			if ( isset( $options['posts_per_page'] ) ) { $sanitized_options['posts_per_page'] = intval( $options['posts_per_page'] ); }
			if ( isset( $options['max_buttons'] ) ) { $sanitized_options['max_buttons'] = intval( $options['max_buttons'] ); }

			// Boolean fields.
			if ( isset( $options['adaptive_pages'] ) ) { $sanitized_options['adaptive_pages'] = $options['adaptive_pages'] ? true : false; }

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
			$pagination_defaults = WPUPG_Pagination::get_defaults( 'pages' );
			$sanitized_options = array_replace_recursive( $pagination_defaults, $sanitized_options );

			$sanitized_pagination['pages'] = $sanitized_options;
		}

		return $sanitized_pagination;
	}

	/**
	 * JavaScript arguments for this type of pagination.
	 *
	 * @since    3.0.0
	 * @param	 mixed $args Current JavaScript arguments.
	 * @param	 mixed $grid Grid to output.
	 */
	public static function javascript_args( $args, $grid ) {
		if ( 'pages' === $grid->pagination_type() ) {
			$options = $grid->pagination( 'pages' );

			$args = array(
				'posts_per_page' => $options['posts_per_page'],
				'max_buttons' => $options['max_buttons'],
				'adaptive_pages' => $options['adaptive_pages'],
				'load_on_filter' => $options['adaptive_pages'], // Load on filter when using adaptive pages.
			);
		}

		return $args;
	}

	/**
	 * Filter the grid query args.
	 *
	 * @since    3.0.0
	 * @param	 mixed $args Current arguments.
	 * @param	 mixed $grid Current grid.
	 * @param	 mixed $grid_args Optional arguments.
	 */
	public static function query_args( $args, $grid, $grid_args ) {
		if ( 'pages' === $grid->pagination_type() ) {
			$options = $grid->pagination( 'pages' );

			// Don't paginate when loading all on filter, using adaptive pages.
			if ( $options['adaptive_pages'] && isset( $grid_args['type'] ) && 'load_all' === $grid_args['type'] ) {
				return $args;
			}

			// Don't exclude loaded items unless using random ordering. Otherwise we don't always get the same items for the same page.
			if ( 'rand' !== $grid->grid_order_by() ) {
				unset( $args['post__not_in'] );
			}

			// Only filter by page, basically.
			unset( $args['tax_query'] );
			unset( $args['s'] );
		}

		return $args;
	}

	/**
	 * Filter the IDs that are displayed in this grid page.
	 *
	 * @since    3.0.0
	 * @param	 mixed $ids Current list of IDs.
	 * @param	 mixed $grid Current grid.
	 * @param	 mixed $grid_args Optional arguments.
	 */
	public static function ids( $ids, $grid, $grid_args ) {
		if ( 'pages' === $grid->pagination_type() ) {
			$options = $grid->pagination( 'pages' );

			// Don't paginate when loading all on filter, using adaptive pages.
			if ( $options['adaptive_pages'] && isset( $grid_args['type'] ) && 'load_all' === $grid_args['type'] ) {
				return $ids;
			}

			$posts_per_page = $options['posts_per_page'];

			// Get page from args (or default to 0).
			$page = isset( $grid_args['page'] ) ? $grid_args['page'] : 0;

			// Always use first page if random ordering.
			if ( 'rand' === $grid->grid_order_by() ) {
				$page = 0;
			}

			if ( -1 !== $page ) {
				$ids = array_slice( $ids, $page * $posts_per_page, $posts_per_page );	
			}
		}

		return $ids;
	}

	/**
	 * Filter grid output classes.
	 *
	 * @since    3.0.0
	 * @param	 array $classes Current item classes.
	 * @param	 mixed $grid 	Grid the item is in.
	 * @param	 mixed $item 	Item getting output.
	 * @param	 mixed $args 	Optional arguments.
	 */
	public static function classes( $classes, $grid, $item, $args = array() ) {
		if ( 'pages' === $grid->pagination_type() ) {
			$page = isset( $args['page'] ) ? $args['page'] : 0;

			$classes[] = 'wpupg-page-' . $page;
		}

		return $classes;
	}

	/**
	 * Output grid pagination.
	 *
	 * @since    3.0.0
	 * @param	 array $output 	Current pagination output.
	 * @param	 mixed $grid 	Grid to output the pagination for.
	 * @param	 mixed $args 	Optional arguments.
	 */
	public static function output( $output, $grid, $args = array() ) {
		if ( 'pages' === $grid->pagination_type() ) {
			$options = $grid->pagination( 'pages' );
			$nbr_posts = count( $grid->all_ids( $args ) );

			if ( $options['posts_per_page'] < $nbr_posts ) {
				$output = '';
				$output .= self::style( $grid, $args, $options );
				$output .= self::html( $grid, $args, $options );
			}
		}

		return $output;
	}

	/**
	 * Output HTML for the pagination.
	 *
	 * @since    3.0.0
	 * @param	 mixed $grid Grid to output.
	 * @param	 mixed $args Optional arguments.
	 * @param	 mixed $options Pagination options.
	 */
	public static function html( $grid, $args, $options ) {
		$output = '';

		$nbr_posts = count( $grid->all_ids( $args ) );
		$nbr_pages = 0 < $options['posts_per_page'] ? ceil( $nbr_posts / floatval( $options['posts_per_page'] ) ) : 1;

		for ( $page = 0; $page < $nbr_pages; $page++ ) {
			$active = $page == 0 ? ' active' : '';
			$output .= '<div class="wpupg-pagination-term wpupg-page-' . $page . $active . '" data-page="' . $page . '" role="button" tabindex="0">' . ( $page + 1 ) . '</div>';
		}

		return $output;
	}

	 /**
	 * Output styling for the pagination.
	 *
	 * @since    3.0.0
	 * @param	 mixed $grid Grid to output.
	 * @param	 mixed $args Optional arguments.
	 * @param	 mixed $options Pagination options.
	 */
	public static function style( $grid, $args, $options ) {
		$style = $options['style'];

		$output = '<style>';

		// Pagination styling.
		$pagination_selector = '#wpupg-grid-' . $grid->slug_or_id() . '-pagination';
		$output .= $pagination_selector . ' {';
		$output .= 'text-align: ' . $style['alignment'] . ';';
		$output .= 'margin: 0 -' . $style['margin_horizontal'] . 'px;';
		$output .= '}';

		// Default Item styling.
		$item_selector = $pagination_selector . ' .wpupg-pagination-term';

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

		// Gap Item styling.
		$gap_margin = max( array( 5 * $style['margin_horizontal'], 20 ) ); // At least 20px.

		$output .= $item_selector . '.wpupg-pagination-button-gap {';
		$output .= 'margin-left: ' . $gap_margin . 'px;';
		$output .= '}';

		$output .= '</style>';

		return $output;
	}
}

WPUPG_Pagination_Pages::init();
