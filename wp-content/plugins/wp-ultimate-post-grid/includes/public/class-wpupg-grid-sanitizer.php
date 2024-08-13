<?php
/**
 * Sanitize grid input fields.
 *
 * @link       https://bootstrapped.ventures
 * @since      3.0.0
 *
 * @package    WP_Ultimate_Post_Grid
 * @subpackage WP_Ultimate_Post_Grid/includes/public
 */

/**
 * Sanitize grid input fields.
 *
 * @since      3.0.0
 * @package    WP_Ultimate_Post_Grid
 * @subpackage WP_Ultimate_Post_Grid/includes/public
 * @author     Brecht Vandersmissen <brecht@bootstrapped.ventures>
 */
class WPUPG_Grid_Sanitizer {

	/**
	 * Sanitize grid array.
	 *
	 * @since    3.0.0
	 * @param	 array $grid Array containing all grid input data.
	 */
	public static function sanitize( $grid ) {
		$sanitized_grid = array();

		// Always set version to version of save.
		$sanitized_grid['version'] = WPUPG_VERSION;

		// Boolean fields.
		if ( isset( $grid['post_status_require_permission'] ) )			{ $sanitized_grid['post_status_require_permission'] = $grid['post_status_require_permission'] ? true : false; }
		if ( isset( $grid['order_custom_key_numeric'] ) )				{ $sanitized_grid['order_custom_key_numeric'] = $grid['order_custom_key_numeric'] ? true : false; }
		if ( isset( $grid['centered'] ) ) 								{ $sanitized_grid['centered'] = $grid['centered'] ? true : false; }
		if ( isset( $grid['rtl_mode'] ) ) 								{ $sanitized_grid['rtl_mode'] = $grid['rtl_mode'] ? true : false; }
		if ( isset( $grid['filters_enabled'] ) ) 						{ $sanitized_grid['filters_enabled'] = $grid['filters_enabled'] ? true : false; }
		if ( isset( $grid['images_only'] ) ) 							{ $sanitized_grid['images_only'] = $grid['images_only'] ? true : false; }
		if ( isset( $grid['terms_images_only'] ) ) 						{ $sanitized_grid['terms_images_only'] = $grid['terms_images_only'] ? true : false; }
		if ( isset( $grid['terms_hide_empty'] ) ) 						{ $sanitized_grid['terms_hide_empty'] = $grid['terms_hide_empty'] ? true : false; }
		if ( isset( $grid['limit_terms'] ) ) 							{ $sanitized_grid['limit_terms'] = $grid['limit_terms'] ? true : false; }
		if ( isset( $grid['limit_posts'] ) ) 							{ $sanitized_grid['limit_posts'] = $grid['limit_posts'] ? true : false; }
		if ( isset( $grid['layout_mobile_different'] ) ) 				{ $sanitized_grid['layout_mobile_different'] = $grid['layout_mobile_different'] ? true : false; }
		if ( isset( $grid['layout_tablet_different'] ) ) 				{ $sanitized_grid['layout_tablet_different'] = $grid['layout_tablet_different'] ? true : false; }
		if ( isset( $grid['link'] ) ) 									{ $sanitized_grid['link'] = $grid['link'] ? true : false; }
		if ( isset( $grid['deeplinking'] ) ) 							{ $sanitized_grid['deeplinking'] = $grid['deeplinking'] ? true : false; }
		if ( isset( $grid['metadata'] ) ) 								{ $sanitized_grid['metadata'] = $grid['metadata'] ? true : false; }

		// Number fields.
		if ( isset( $grid['layout_desktop_sizing_columns'] ) )	{ $sanitized_grid['layout_desktop_sizing_columns'] = intval( $grid['layout_desktop_sizing_columns'] ); }
		if ( isset( $grid['layout_desktop_sizing_fixed'] ) )	{ $sanitized_grid['layout_desktop_sizing_fixed'] = intval( $grid['layout_desktop_sizing_fixed'] ); }
		if ( isset( $grid['layout_desktop_sizing_margin'] ) )	{ $sanitized_grid['layout_desktop_sizing_margin'] = intval( $grid['layout_desktop_sizing_margin'] ); }
		if ( isset( $grid['layout_mobile_sizing_columns'] ) )	{ $sanitized_grid['layout_mobile_sizing_columns'] = intval( $grid['layout_mobile_sizing_columns'] ); }
		if ( isset( $grid['layout_mobile_sizing_fixed'] ) )		{ $sanitized_grid['layout_mobile_sizing_fixed'] = intval( $grid['layout_mobile_sizing_fixed'] ); }
		if ( isset( $grid['layout_mobile_sizing_margin'] ) )	{ $sanitized_grid['layout_mobile_sizing_margin'] = intval( $grid['layout_mobile_sizing_margin'] ); }
		if ( isset( $grid['layout_tablet_sizing_columns'] ) )	{ $sanitized_grid['layout_tablet_sizing_columns'] = intval( $grid['layout_tablet_sizing_columns'] ); }
		if ( isset( $grid['layout_tablet_sizing_fixed'] ) )		{ $sanitized_grid['layout_tablet_sizing_fixed'] = intval( $grid['layout_tablet_sizing_fixed'] ); }
		if ( isset( $grid['layout_tablet_sizing_margin'] ) )	{ $sanitized_grid['layout_tablet_sizing_margin'] = intval( $grid['layout_tablet_sizing_margin'] ); }
		if ( isset( $grid['limit_posts_number'] ) )				{ $sanitized_grid['limit_posts_number'] = intval( $grid['limit_posts_number'] ); }
		if ( isset( $grid['limit_posts_offset'] ) )				{ $sanitized_grid['limit_posts_offset'] = intval( $grid['limit_posts_offset'] ); }

		// Text fields.
		if ( isset( $grid['name'] ) ) 							{ $sanitized_grid['name'] = sanitize_text_field( $grid['name'] ); }
		if ( isset( $grid['slug'] ) ) 							{ $sanitized_grid['slug'] = sanitize_title( $grid['slug'] ); }
		if ( isset( $grid['order_custom_key'] ) ) 				{ $sanitized_grid['order_custom_key'] = sanitize_text_field( $grid['order_custom_key'] ); }
		if ( isset( $grid['template'] ) ) 						{ $sanitized_grid['template'] = sanitize_key( $grid['template'] ); }
		if ( isset( $grid['metadata_name'] ) ) 					{ $sanitized_grid['metadata_name'] = sanitize_text_field( $grid['metadata_name'] ); }
		if ( isset( $grid['metadata_description'] ) ) 			{ $sanitized_grid['metadata_description'] = sanitize_text_field( $grid['metadata_description'] ); }

		// HTML.
		if ( isset( $grid['empty_message'] ) ) 					{ $sanitized_grid['empty_message'] = self::sanitize_html( $grid['empty_message'] ); }
		if ( isset( $grid['responsive_toggle_style_closed'] ) ) { $sanitized_grid['responsive_toggle_style_closed'] = self::sanitize_html( $grid['responsive_toggle_style_closed'] ); }
		if ( isset( $grid['responsive_toggle_style_open'] ) ) 	{ $sanitized_grid['responsive_toggle_style_open'] = self::sanitize_html( $grid['responsive_toggle_style_open'] ); }

		// Post types.
		if ( isset( $grid['post_types'] ) ) {
			$sanitized_grid['post_types'] = array_map( function( $post_type ) {
				return sanitize_key( $post_type );
			}, $grid['post_types'] );
		}

		// Taxonomies.
		if ( isset( $grid['taxonomies'] ) ) {
			$sanitized_grid['taxonomies'] = array_map( function( $taxonomy ) {
				return sanitize_key( $taxonomy );
			}, $grid['taxonomies'] );
		}

		if ( isset( $grid['post_status'] ) ) {
			$sanitized_grid['post_status'] = array_map( function( $post_status ) {
				return sanitize_key( $post_status );
			}, $grid['post_status'] );
		}

		// Language.
		if ( isset( $grid['language'] ) ) {
			$sanitized_grid['language'] = false === $grid['language'] ? $grid['language'] : sanitize_text_field( $grid['language'] );
		}

		// Limited options fields.	
		$options = array( 'restrict', 'exclude' );
		if ( isset( $grid['limit_terms_type'] ) && in_array( $grid['limit_terms_type'], $options, true ) ) {
			$sanitized_grid['limit_terms_type'] = $grid['limit_terms_type'];
		}

		$options = array( 'masonry', 'fitRows', 'fitRowsHeight' );
		if ( isset( $grid['layout_mode'] ) && in_array( $grid['layout_mode'], $options, true ) ) {
			$sanitized_grid['layout_mode'] = $grid['layout_mode'];
		}
		
		$options = array( 'fixed', 'columns', 'ignore' );
		if ( isset( $grid['layout_desktop_sizing'] ) && in_array( $grid['layout_desktop_sizing'], $options, true ) ) {
			$sanitized_grid['layout_desktop_sizing'] = $grid['layout_desktop_sizing'];
		}
		if ( isset( $grid['layout_mobile_sizing'] ) && in_array( $grid['layout_mobile_sizing'], $options, true ) ) {
			$sanitized_grid['layout_mobile_sizing'] = $grid['layout_mobile_sizing'];
		}
		if ( isset( $grid['layout_tablet_sizing'] ) && in_array( $grid['layout_tablet_sizing'], $options, true ) ) {
			$sanitized_grid['layout_tablet_sizing'] = $grid['layout_tablet_sizing'];
		}

		$options = array( 'AND', 'OR' );
		if ( isset( $grid['filters_relation'] ) && in_array( $grid['filters_relation'], $options, true ) ) {
			$sanitized_grid['filters_relation'] = $grid['filters_relation'];
		}

		$options = array( 'arrow', 'triangle', 'plus', 'custom' );
		if ( isset( $grid['responsive_toggle_style'] ) && in_array( $grid['responsive_toggle_style'], $options, true ) ) {
			$sanitized_grid['responsive_toggle_style'] = $grid['responsive_toggle_style'];
		}



		$options = array( 'all', 'exclude', 'only' );
		if ( isset( $grid['password_protected'] ) && in_array( $grid['password_protected'], $options, true ) ) {
			$sanitized_grid['password_protected'] = $grid['password_protected'];
		}

		$options = array( 'desc', 'asc' );
		if ( isset( $grid['order'] ) && in_array( $grid['order'], $options, true ) ) {
			$sanitized_grid['order'] = $grid['order'];
		}

		$options = array( 'title', 'date', 'modified', 'author', 'comment_count', 'rand', 'menu_order', 'custom' );
		if ( isset( $grid['order_by'] ) && in_array( $grid['order_by'], $options, true ) ) {
			$sanitized_grid['order_by'] = $grid['order_by'];
		}

		$options = array( 'desc', 'asc' );
		if ( isset( $grid['terms_order'] ) && in_array( $grid['terms_order'], $options, true ) ) {
			$sanitized_grid['terms_order'] = $grid['terms_order'];
		}

		$options = array( 'name', 'slug', 'term_id', 'description', 'count' );
		if ( isset( $grid['terms_order_by'] ) && in_array( $grid['terms_order_by'], $options, true ) ) {
			$sanitized_grid['terms_order_by'] = $grid['terms_order_by'];
		}

		$options = array( 'posts', 'terms' );
		if ( isset( $grid['type'] ) && in_array( $grid['type'], $options, true ) ) {
			$sanitized_grid['type'] = $grid['type'];
		}
		
		$options = array( 'none', 'pages', 'infinite_load', 'load_more', 'load_filter' );
		if ( isset( $grid['pagination_type'] ) && in_array( $grid['pagination_type'], $options, true ) ) {
			$sanitized_grid['pagination_type'] = $grid['pagination_type'];
		}

		$options = array( 'post', 'image' );
		if ( isset( $grid['link_type'] ) && in_array( $grid['link_type'], $options, true ) ) {
			$sanitized_grid['link_type'] = $grid['link_type'];
		}

		$options = array( '_self', '_blank' );
		if ( isset( $grid['link_target'] ) && in_array( $grid['link_target'], $options, true ) ) {
			$sanitized_grid['link_target'] = $grid['link_target'];
		}

		$options = array( 'default', 'latest_post', 'oldest_post', 'random_post' );
		if ( isset( $grid['use_image'] ) && in_array( $grid['use_image'], $options, true ) ) {
			$sanitized_grid['use_image'] = $grid['use_image'];
		}

		// Limit terms.
		if ( isset( $grid['limit_terms_terms'] ) ) {
			$sanitized_grid['limit_terms_terms'] = array_map( 'intval', $grid['limit_terms_terms'] );
		}

		// Limit posts.
		if ( isset( $grid['limit_rules'] ) && is_array( $grid['limit_rules'] ) ) {
			$sanitized_rules = array();

			foreach ( $grid['limit_rules'] as $limit_rule ) {
				$sanitized_rules[] = array(
					'field' => sanitize_text_field( $limit_rule['field'] ),
					'values' => array_map( 'sanitize_text_field', $limit_rule['values'] ),
					'type' => sanitize_key( $limit_rule['type'] ),
				);
			}

			$sanitized_grid['limit_rules'] = $sanitized_rules;
		}

		// Filter options.
		if ( isset( $grid['filters'] ) && is_array( $grid['filters'] ) ) {
			$sanitized_grid['filters'] = array();
			
			foreach ( $grid['filters'] as $filter ) {
				$sanitized_grid['filters'][] = array(
					'id' => isset( $filter['id'] ) ? sanitize_title( $filter['id'] ) : '',
					'label' => isset( $filter['label'] ) ? sanitize_text_field( $filter['label'] ) : '',
					'type' => isset( $filter['type'] ) ? sanitize_key( $filter['type'] ) : '',
					'options' => apply_filters( 'wpupg_filter_sanitize_options', array(), $filter, $grid ),
				);
			}
		}

		// Filters style options.
		if ( isset( $grid['filters_style'] ) && is_array( $grid['filters_style'] ) ) {
			$filters_style = $grid['filters_style'];
			$sanitized_filters_style = array();
			
			$options = array( 'block', 'inline', 'left', 'right' );
			if ( isset( $filters_style['display'] ) && in_array( $filters_style['display'], $options, true ) ) {
				$sanitized_filters_style['display'] = $filters_style['display'];
			}
			$options = array( 'left', 'center', 'right', 'spaced' );
			if ( isset( $filters_style['alignment'] ) && in_array( $filters_style['alignment'], $options, true ) ) {
				$sanitized_filters_style['alignment'] = $filters_style['alignment'];
			}
			$options = array( 'block', 'inline' );
			if ( isset( $filters_style['label_display'] ) && in_array( $filters_style['label_display'], $options, true ) ) {
				$sanitized_filters_style['label_display'] = $filters_style['label_display'];
			}
			$options = array( 'normal', 'bold', 'underline', 'italic' );
			if ( isset( $filters_style['label_style'] ) && in_array( $filters_style['label_style'], $options, true ) ) {
				$sanitized_filters_style['label_style'] = $filters_style['label_style'];
			}
			$options = array( 'left', 'center', 'right' );
			if ( isset( $filters_style['label_alignment'] ) && in_array( $filters_style['label_alignment'], $options, true ) ) {
				$sanitized_filters_style['label_alignment'] = $filters_style['label_alignment'];
			}

			if ( isset( $filters_style['spacing_vertical'] ) )		{ $sanitized_filters_style['spacing_vertical'] = intval( $filters_style['spacing_vertical'] ); }
			if ( isset( $filters_style['spacing_horizontal'] ) )	{ $sanitized_filters_style['spacing_horizontal'] = intval( $filters_style['spacing_horizontal'] ); }
			if ( isset( $filters_style['width'] ) )					{ $sanitized_filters_style['width'] = intval( $filters_style['width'] ); }
			if ( isset( $filters_style['label_font_size'] ) )		{ $sanitized_filters_style['label_font_size'] = intval( $filters_style['label_font_size'] ); }

			$sanitized_grid['filters_style'] = $sanitized_filters_style;
		}

		// Pagination options.
		if ( isset( $grid['pagination'] ) ) {
			$sanitized_grid['pagination'] = apply_filters( 'wpupg_pagination_sanitize_options', array(), $grid['pagination'], $grid );
		}


		return apply_filters( 'wpupg_grid_sanitize', $sanitized_grid, $grid );
	}

	/**
	 * Sanitize HTML content.
	 *
	 * @since   1.0.0
	 * @param	mixed $text Text to sanitize.
	 */
	public static function sanitize_html( $text ) {
		$allowed_tags = wp_kses_allowed_html( 'post' );

		// Remove blank lines from HTML.
		$text = str_replace( '<p></p>', '', $text );
		$text = str_replace( '<p><br></p>', '', $text );
		$text = str_replace( '<p><br/></p>', '', $text );

		// Allow administrators to use any html they want.
		if ( current_user_can( 'unfiltered_html' ) ) {
			return $text;
		}

		return wp_kses( $text, $allowed_tags );
	}
}
