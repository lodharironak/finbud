<?php
/**
 * Represents a grid.
 *
 * @link       https://bootstrapped.ventures
 * @since      3.0.0
 *
 * @package    WP_Ultimate_Post_Grid
 * @subpackage WP_Ultimate_Post_Grid/includes/public
 */

/**
 * Represents a grid.
 *
 * @since      3.0.0
 * @package    WP_Ultimate_Post_Grid
 * @subpackage WP_Ultimate_Post_Grid/includes/public
 * @author     Brecht Vandersmissen <brecht@bootstrapped.ventures>
 */
class WPUPG_Grid {

	/**
	 * WP_Post object associated with this grid post type.
	 *
	 * @since    3.0.0
	 * @access   private
	 * @var      object    $post	WP_Post object of this grid post type.
	 */
	private $post;

	/**
	 * Cached IDs to display in this grid.
	 *
	 * @since    3.0.0
	 * @access   private
	 * @var      array    $ids	Grid item IDs.
	 */
	private $ids = false;

	/**
	 * Cached total IDs to display in this grid.
	 *
	 * @since    3.3.0
	 * @access   private
	 * @var      array    $total_ids Total number of grid ids.
	 */
	private $total_ids = false;

	/**
	 * Cached terms to display in this grid.
	 *
	 * @since    3.0.0
	 * @access   private
	 * @var      array    $ids	Terms for this grid.
	 */
	private $terms = false;

	/**
	 * Metadata associated with this grid post type.
	 *
	 * @since    3.0.0
	 * @access   private
	 * @var      array    $meta	Grid metadata.
	 */
	private $meta = false;

	/**
	 * Get new grid object from associated post.
	 *
	 * @since    3.0.0
	 * @param    mixed $post Meta or WP_Post object for this grid post type.
	 */
	public function __construct( $post_or_meta ) {
		$post = is_object( $post_or_meta ) && $post_or_meta instanceof WP_Post ? $post_or_meta : false;
		$this->post = $post;

		// Not a WP_Post object, so just manually set the meta values.
		if ( ! $post ) {
			$this->meta = $post_or_meta;
		}
	}

	/**
	 * Get grid data.
	 *
	 * @since    3.0.0
	 */
	public function get_data() {
		$grid = array();

		// Technical Fields.
		$grid['id'] = $this->id();
		$grid['version'] = $this->version();

		// Grid General.
		$grid['name'] = $this->name();
		$grid['slug'] = $this->slug();

		// Grid Data Source.
		$grid['type'] = $this->type();
		$grid['post_types'] = $this->post_types();
		$grid['post_status'] = $this->post_status();
		$grid['post_status_require_permission'] = $this->post_status_require_permission();
		$grid['taxonomies'] = $this->taxonomies();
		$grid['password_protected'] = $this->password_protected();
		$grid['language'] = $this->language();
		$grid['order_by'] = $this->order_by();
		$grid['order'] = $this->order();
		$grid['order_custom_key'] = $this->order_custom_key();
		$grid['order_custom_key_numeric'] = $this->order_custom_key_numeric();
		$grid['terms_order_by'] = $this->terms_order_by();
		$grid['terms_order'] = $this->terms_order();

		// Grid Limit Items.
		$grid['limit_posts_offset'] = $this->limit_posts_offset();
		$grid['limit_posts_number'] = $this->limit_posts_number();
		$grid['images_only'] = $this->images_only();
		$grid['terms_images_only'] = $this->terms_images_only();
		$grid['terms_hide_empty'] = $this->terms_hide_empty();
		$grid['limit_terms'] = $this->limit_terms();
		$grid['limit_terms_terms'] = $this->limit_terms_terms();
		$grid['limit_terms_type'] = $this->limit_terms_type();
		$grid['limit_posts'] = $this->limit_posts();
		$grid['limit_rules'] = $this->limit_rules();

		// Grid Filters.
		$grid['filters'] = $this->filters();
		$grid['filters_enabled'] = $this->filters_enabled();
		$grid['filters_style'] = $this->filters_style();		
		$grid['filters_relation'] = $this->filters_relation();
		$grid['responsive_toggle_style'] = $this->responsive_toggle_style();
		$grid['responsive_toggle_style_closed'] = $this->responsive_toggle_style_closed();
		$grid['responsive_toggle_style_open'] = $this->responsive_toggle_style_open();

		// Grid Layout.
		$grid['layout_mode'] = $this->layout_mode();
		$grid['centered'] = $this->centered();
		$grid['rtl_mode'] = $this->rtl_mode();
		$grid['layout_desktop_sizing'] = $this->layout_desktop_sizing();
		$grid['layout_desktop_sizing_fixed'] = $this->layout_desktop_sizing_fixed();
		$grid['layout_desktop_sizing_columns'] = $this->layout_desktop_sizing_columns();
		$grid['layout_desktop_sizing_margin'] = $this->layout_desktop_sizing_margin();
		$grid['layout_tablet_different'] = $this->layout_tablet_different();
		$grid['layout_tablet_sizing'] = $this->layout_tablet_sizing();
		$grid['layout_tablet_sizing_fixed'] = $this->layout_tablet_sizing_fixed();
		$grid['layout_tablet_sizing_columns'] = $this->layout_tablet_sizing_columns();
		$grid['layout_tablet_sizing_margin'] = $this->layout_tablet_sizing_margin();
		$grid['layout_mobile_different'] = $this->layout_mobile_different();
		$grid['layout_mobile_sizing'] = $this->layout_mobile_sizing();
		$grid['layout_mobile_sizing_fixed'] = $this->layout_mobile_sizing_fixed();
		$grid['layout_mobile_sizing_columns'] = $this->layout_mobile_sizing_columns();
		$grid['layout_mobile_sizing_margin'] = $this->layout_mobile_sizing_margin();

		// Grid Item.
		$grid['template'] = $this->template();
		$grid['use_image'] = $this->use_image();
		$grid['link'] = $this->link();
		$grid['link_type'] = $this->link_type();
		$grid['link_target'] = $this->link_target();

		// Grid Pagination.
		$grid['pagination_type'] = $this->pagination_type();
		$grid['pagination'] = $this->pagination();

		// Grid Other.
		$grid['metadata'] = $this->metadata();
		$grid['metadata_name'] = $this->metadata_name();
		$grid['metadata_description'] = $this->metadata_description();
		$grid['deeplinking'] = $this->deeplinking();
		$grid['empty_message'] = $this->empty_message();

		return $grid;
	}

	/**
	 * Get grid data for the manage page.
	 *
	 * @since    3.0.0
	 */
	public function get_data_manage() {
		$grid = $this->get_data();

		$grid['date'] = $this->date();

		return $grid;
	}

	/**
	 * Get isotope args for this grid.
	 *
	 * @since    3.0.0
	 */
	public function get_javascript_args() {
		$args = array();

		// Arguments for grid.
		$args['item_ids'] = $this->ids( array( 'type' => 'initial' ) );
		$args['total_ids'] = $this->total_ids();
		$args['order'] = array(
			array(
				'by' => $this->grid_order_by(),
				'type' => $this->grid_order(),
			),
		);
		$args['link'] = $this->link() ? $this->link_target() : false;
		$args['deeplinking'] = $this->deeplinking();

		// Arguments for Isotope JS.
		$args['isotope'] = array(
			'itemSelector' => '.wpupg-item',
			'layoutMode' => $this->layout_mode(),
			'transitionDuration' => intval( WPUPG_Settings::get( 'grid_animation_speed' ) ),
			'stagger' => intval( WPUPG_Settings::get( 'grid_animation_stagger' ) ),
			'hiddenStyle' => self::get_css_array( WPUPG_Settings::get( 'grid_animation_hide' ) ),
			'visibleStyle' => self::get_css_array( WPUPG_Settings::get( 'grid_animation_show' ) ),
		);

		// RTL Mode.
		if ( $this->rtl_mode() ) {
			$args['isotope']['originLeft'] = false;
		}

		// Force height layout mode.
		if ( 'fitRowsHeight' === $this->layout_mode() ) {
			$args['isotope']['layoutMode'] = 'fitRows';
			$args['force_height'] = true;
		}

		// CSS 
		if ( $this->can_use_centered() && $this->centered() ) {
			$args['isotope']['masonry'] = array(
				'isFitWidth' => true,
			);
		}

		// Arguments for filters.
		$args['filters_relation'] = $this->filters_relation();
		$args['filters'] = array();
		if ( $this->filters_enabled() ) {
			$filters = $this->filters();

			foreach ( $filters as $index => $filter ) {
				// Make sure filter ID is set.
				if ( ! $filter['id'] ) {
					$filter['id'] = $index + 1;
				}

				$filter_args = array(
					'id' => $filter['id'],
					'type' => $filter['type'],
				);

				$args['filters'][ $filter['id'] ] = apply_filters( 'wpupg_javascript_args_filter', $filter_args, $this, $filter );
			}
		}

		// Arguments for pagination.
		$args['pagination_type'] = $this->pagination_type();
		$args['pagination'] = apply_filters( 'wpupg_javascript_args_pagination', false, $this );

		return apply_filters( 'wpupg_javascript_args', $args, $this );
	}

	/**
	 * Get CSS array from string.
	 *
	 * @since    3.0.0
	 * @param    mixed $string String to get the CSS from.
	 */
	public function get_css_array( $string ) {
		$css = array();

		if ( $string ) {
			$properties = explode( ';', $string );

			foreach( $properties as $property ) {
				$parts = explode( ':', $property );

				if ( 2 === count( $parts ) ) {
					$key = trim( $parts[0] );
					
					if ( $key ) {
						$css[ $key ] = trim( $parts[1] );
					}
				}
			}
		}

		return $css;
	}

	/**
	 * Get metadata value.
	 *
	 * @since    3.0.0
	 * @param    mixed $field   Metadata field to retrieve.
	 * @param	 mixed $default	Default to return if metadata is not set.
	 */
	public function meta( $field, $default = '' ) {
		if ( false === $this->post ) {
			if ( isset( $this->meta[ $field ] ) ) {
				return $this->meta[ $field ];
			}
		} else {
			// Use prefix when stored in actual meta.
			$field = 'wpupg_' . $field;

			if ( ! $this->meta ) {
				$this->meta = get_post_custom( $this->id() );
			}
	
			if ( isset( $this->meta[ $field ] ) && null !== $this->meta[ $field ][0] ) {
				return $this->meta[ $field ][0];
			}
		}

		return $default;
	}

	/**
	 * Try to unserialize as best as possible.
	 *
	 * @since    3.0.0
	 * @param	 mixed $maybe_serialized Potentially serialized data.
	 */
	public function unserialize( $maybe_serialized ) {
		$unserialized = @maybe_unserialize( $maybe_serialized );

		if ( false === $unserialized ) {
			$maybe_serialized = preg_replace('/\s+/', ' ', $maybe_serialized );
			$unserialized = unserialize( preg_replace_callback( '!s:(\d+):"(.*?)";!', array( $this, 'regex_replace_serialize' ), $maybe_serialized ) );
		}

		return $unserialized;
	}

	/**
	 * Callback for regex to fix serialize issues.
	 *
	 * @since    3.0.0
	 * @param	 mixed $match Regex match.
	 */
	public function regex_replace_serialize( $match ) {
		return ( $match[1] == strlen( $match[2] ) ) ? $match[0] : 's:' . strlen( $match[2] ) . ':"' . $match[2] . '";';
	}

	/**
	 * Grid Technical Fields.
	 */
	public function id() {
		return $this->post ? $this->post->ID : $this->meta( 'id' );
	}
	public function slug_or_id() {
		$slug = $this->slug();

		if ( ! $slug ) {
			$slug = $this->id();
		}

		return $slug;
	}
	public function date() {
		return $this->post ? $this->post->post_date : $this->meta( 'date' );
	}	
	public function version() {
		return $this->meta( 'version', '0.0.0' );
	}

	/**
	 * Grid General Fields.
	 */
	public function name() {
		return $this->post ? $this->post->post_title : $this->meta( 'name' );
	}
	public function slug() {
		return $this->post ? $this->post->post_name : $this->meta( 'slug' );
	}
	/**
	 * Grid Data Source Fields.
	 */
	public function type() {
		return $this->meta( 'type', 'posts' );
	}
	public function post_types() {
		return $this->unserialize( $this->meta( 'post_types', array( 'post' ) ) );
	}
	public function post_status() {
		$post_status = $this->unserialize( $this->meta( 'post_status', array( 'publish' ) ) );

		if ( in_array( 'attachment', $this->post_types() ) ) {
			$post_status[] = 'inherit';
		}

		return $post_status;
	}
	public function post_status_require_permission() {
		$bool = $this->meta( 'post_status_require_permission', true );
		return (bool) $bool;
	}
	public function taxonomies() {
		return $this->unserialize( $this->meta( 'taxonomies', array( 'category' ) ) );
	}
	public function password_protected() {
		return $this->meta( 'password_protected', 'all' );
	}
	public function language() {
		return $this->meta( 'language', false );
	}
	public function order_by() {
		return $this->meta( 'order_by', 'date' );
	}
	public function order() {
		return $this->meta( 'order', 'desc' );
	}
	public function order_custom_key() {
		return $this->meta( 'order_custom_key', '' );
	}
	public function order_custom_key_numeric() {
		$bool = $this->meta( 'order_custom_key_numeric', false );
		return (bool) $bool;
	}
	public function terms_order_by() {
		return $this->meta( 'terms_order_by', 'name' );
	}
	public function terms_order() {
		return $this->meta( 'terms_order', 'asc' );
	}
	public function grid_order_by() {
		if ( 'posts' === $this->type() ) {
			return $this->order_by();
		} else {
			return $this->terms_order_by();
		}
	}
	public function grid_order() {
		if ( 'posts' === $this->type() ) {
			return $this->order();
		} else {
			return $this->terms_order();
		}
	}
	/**
	 * Grid Limit Items Fields.
	 */
	public function limit_posts_offset() {
		return $this->meta( 'limit_posts_offset', 0 );
	}
	public function limit_posts_number() {
		return $this->meta( 'limit_posts_number', 0 );
	}
	public function images_only() {
		$bool = $this->meta( 'images_only', false );
		return (bool) $bool;
	}
	public function terms_images_only() {
		$bool = $this->meta( 'terms_images_only', false );
		return (bool) $bool;
	}
	public function terms_hide_empty() {
		$bool = $this->meta( 'terms_hide_empty', false );
		return (bool) $bool;
	}
	public function limit_terms() {
		$bool = $this->meta( 'limit_terms', false );
		return (bool) $bool;
	}
	public function limit_terms_terms() {
		return $this->unserialize( $this->meta( 'limit_terms_terms', array() ) );
	}
	public function limit_terms_type() {
		return $this->meta( 'limit_terms_type', 'restrict' );
	}
	public function limit_posts() {
		$bool = $this->meta( 'limit_posts', false );
		return (bool) $bool;
	}
	public function limit_rules() {
		return $this->unserialize( $this->meta( 'limit_rules', array() ) );
	}

	/**
	 * Grid Filters Fields.
	 */
	public function filter( $id ) {
		if ( ! $this->filters_enabled() || ! $id ) {
			return false;
		}

		$filters = $this->filters();

		// If identifier was found, return filter.
		$index = array_search( $id, array_column( $filters, 'id' ) );
		if ( false !== $index ) {
			return WPUPG_Filter::filter_with_defaults( $filters[ $index ] );
		}

		// Check if index + 1 was used as the ID if not found by identifier.
		$index = intval( $id ) - 1;
		if ( isset( $filters[ $index ] ) ) {
			$filter = $filters[ $index ];
			$filter['id'] = $id;
			return WPUPG_Filter::filter_with_defaults( $filter );
		}

		return false;
	}
	public function filters() {
		if ( version_compare( $this->version(), '3.0.0', '<' ) ) {
			return WPUPG_Migrations::single_filter_to_multiple( $this );
		}

		$filters_with_defaults = array();
		$filters = $this->unserialize( $this->meta( 'filters', array() ) );

		foreach ( $filters as $index => $filter ) {
			$filters_with_defaults[ $index ] = WPUPG_Filter::filter_with_defaults( $filter );
		}

		return $filters_with_defaults;
	}
	public function filters_enabled() {
		if ( version_compare( $this->version(), '3.0.0', '<' ) ) {
			return 0 < count( $this->filters() );
		}

		// No filters for a term grid.
		if ( 'terms' === $this->type() ) {
			return false;
		}

		$bool = $this->meta( 'filters_enabled', false );
		return (bool) $bool;
	}
	public function filters_style( $field = false ) {
		$defaults = WPUPG_Filter::get_general_style_defaults();
		$filters_style = $this->unserialize( $this->meta( 'filters_style', array() ) );
		$filters_style_with_defaults = array_replace_recursive( $defaults, $filters_style );

		if ( $field === false ) {
			return $filters_style_with_defaults;
		} else {
			return isset( $filters_style_with_defaults[ $field ] ) ? $filters_style_with_defaults[ $field ] : false;
		}
	}
	public function filters_relation() {
		return $this->meta( 'filters_relation', 'AND' );
	}
	public function responsive_toggle_style() {
		return $this->meta( 'responsive_toggle_style', 'custom' );
	}
	public function responsive_toggle_style_closed() {
		return $this->meta( 'responsive_toggle_style_closed', '+' );
	}
	public function responsive_toggle_style_open() {
		return $this->meta( 'responsive_toggle_style_open', '-' );
	}

	/**
	 * Grid Layout Fields.
	 */
	public function layout_mode() {
		return $this->meta( 'layout_mode', 'masonry' );
	}
	public function centered() {
		$bool = $this->meta( 'centered', false );
		return (bool) $bool;
	}
	public function rtl_mode() {
		$bool = $this->meta( 'rtl_mode', false );
		return (bool) $bool;
	}
	public function can_use_centered() {
		$can_use_centered = false;

		if ( 'masonry' === $this->layout_mode() ) {
			if ( ! $this->layout_tablet_different() && ! $this->layout_mobile_different() ) {
				$can_use_centered = true;
			}
		}

		return $can_use_centered;
	}
	public function layout_desktop_sizing() {
		if ( version_compare( $this->version(), '3.0.0', '<' ) ) {
			return 'ignore';
		}
		return $this->meta( 'layout_desktop_sizing', 'fixed' );
	}
	public function layout_desktop_sizing_fixed() {
		return $this->meta( 'layout_desktop_sizing_fixed', 300 );
	}
	public function layout_desktop_sizing_columns() {
		return $this->meta( 'layout_desktop_sizing_columns', 3 );
	}
	public function layout_desktop_sizing_margin() {
		return $this->meta( 'layout_desktop_sizing_margin', 10 );
	}
	public function layout_tablet_different() {
		$bool = $this->meta( 'layout_tablet_different', false );
		return (bool) $bool;
	}
	public function layout_tablet_sizing() {
		return $this->meta( 'layout_tablet_sizing', 'fixed' );
	}
	public function layout_tablet_sizing_fixed() {
		return $this->meta( 'layout_tablet_sizing_fixed', 300 );
	}
	public function layout_tablet_sizing_columns() {
		return $this->meta( 'layout_tablet_sizing_columns', 2 );
	}
	public function layout_tablet_sizing_margin() {
		return $this->meta( 'layout_tablet_sizing_margin', 10 );
	}
	public function layout_mobile_different() {
		$bool = $this->meta( 'layout_mobile_different', false );
		return (bool) $bool;
	}
	public function layout_mobile_sizing() {
		return $this->meta( 'layout_mobile_sizing', 'columns' );
	}
	public function layout_mobile_sizing_fixed() {
		return $this->meta( 'layout_mobile_sizing_fixed', 300 );
	}
	public function layout_mobile_sizing_columns() {
		return $this->meta( 'layout_mobile_sizing_columns', 1 );
	}
	public function layout_mobile_sizing_margin() {
		return $this->meta( 'layout_mobile_sizing_margin', 10 );
	}
	/**
	 * Grid Item Fields.
	 */
	public function template() {
		if ( version_compare( $this->version(), '3.0.0', '<' ) ) {
			return WPUPG_Migrations::template_mapping( $this );
		}
		return $this->meta( 'template', 'simple' );
	}
	public function use_image() {
		return $this->meta( 'use_image', 'default' );
	}
	public function link() {
		if ( version_compare( $this->version(), '3.0.0', '<' ) ) {
			return 'none' !== $this->meta( 'link_type' );
		}
		$bool = $this->meta( 'link', true );
		return (bool) $bool;
	}
	public function link_type() {
		if ( version_compare( $this->version(), '3.0.0', '<' ) ) {
			return $this->meta( 'link_target', 'post' );
		}
		return $this->meta( 'link_type', 'post' );
	}
	public function link_target() {
		if ( version_compare( $this->version(), '3.0.0', '<' ) ) {
			$target = $this->meta( 'link_type', '_self' );
			return 'none' === $target ? '_self' : $target;
		}
		return $this->meta( 'link_target', '_self' );
	}
	/**
	 * Grid Pagination Fields.
	 */
	public function pagination_type() {
		// No pagination for term grid at the moment.
		if ( 'terms' === $this->type() ) {
			return 'none';
		}

		$pagination_type = $this->meta( 'pagination_type', 'none' );

		if ( version_compare( $this->version(), '3.0.0', '<' ) ) {
			$pagination_type = str_replace( 'load_more_filter', 'load_more', $pagination_type );
		}

		return $pagination_type;
	}
	public function pagination( $type = false ) {
		if ( version_compare( $this->version(), '3.0.0', '<' ) ) {
			$pagination = WPUPG_Migrations::get_pagination_with_style( $this );
		} else {
			$pagination = $this->unserialize( $this->meta( 'pagination', array() ) );
		}

		$pagination_defaults = WPUPG_Pagination::get_defaults();
		$pagination = array_replace_recursive( $pagination_defaults, $pagination );

		if ( false === $type ) {
			return $pagination;
		} else {
			if ( isset( $pagination[ $type ] ) ) {
				return $pagination[ $type ];
			} else {
				return array();
			}
		}
	}
	/**
	 * Grid Other Fields.
	 */
	public function metadata() {
		$bool = $this->meta( 'metadata', false );
		return (bool) $bool;
	}
	public function metadata_name() {
		return $this->meta( 'metadata_name', '' );
	}
	public function metadata_description() {
		return $this->meta( 'metadata_description', '' ); 
	}
	public function deeplinking() {
		$bool = $this->meta( 'deeplinking', true );
		return (bool) $bool;
	}
	public function empty_message() {
		return $this->meta( 'empty_message', '' );
	}

	/**
	 * Get the IDs that are displayed in this grid for the current page.
	 *
	 * @since    3.0.0
	 * @param	 mixed $grid_args Optional arguments.
	 */
	public function ids( $grid_args = array() ) {
		$all_ids = $this->all_ids( $grid_args );
		$ids = apply_filters( 'wpupg_grid_ids', $all_ids, $this, $grid_args );

		// Prevent already loaded IDs from loading again.
		$already_loaded_ids = isset( $grid_args['loaded_ids'] ) ? $grid_args['loaded_ids'] : array();
		return array_filter( $ids, function( $id ) use ( $already_loaded_ids ) { return ! in_array( $id, $already_loaded_ids ); } );
	}

	/**
	 * Get the total number of IDs for this grid.
	 *
	 * @since    3.4.0
	 */
	public function total_ids() {
		$total_ids = $this->total_ids;
		return false !== $total_ids ? intval( $total_ids ) : false;
	}

	/**
	 * Get the query post arguments for getting all IDs.
	 *
	 * @since    3.0.0
	 * @param	 mixed $grid_args Optional arguments.
	 */
	public function all_ids_query_post_args( $grid_args = array() ) {
		$post_types = $this->post_types();

		$args = array(
			'post_type' => $post_types,
			'post_status' => $this->post_status(),
			'order' => $this->order(),
			'orderby' => $this->order_by(),
			'posts_per_page' => -1,
			'fields' => 'ids',
		);

		// Read permission for private posts.
		if ( in_array( 'private', $this->post_status() ) && $this->post_status_require_permission() ) {
			$args['perm'] = 'readable';	
		}

		// Password protected.
		switch ( $this->password_protected() ) {
			case 'exclude':
				$args['has_password'] = false;
				break;
			case 'only':
				$args['has_password'] = true;
				break;
			default:
				$args['has_password'] = null;
		}

		// Images Only
		if ( $this->images_only() ) {
			if ( in_array( 'attachment', $post_types ) ) {
				$args['post_mime_type'] = 'image/jpeg,image/gif,image/jpg,image/png';
			} else {
				$args['meta_query'] = array(
					array(
						'relation' => 'OR',
						array(
							'key' => '_thumbnail_id',
							'value' => '0',
							'compare' => '>'
						),
						array(
							'key' => 'wpupg_custom_image_id',
							'value' => '0',
							'compare' => '>'
						),
					)
				);
			}
		}

		// Exclude specific ids.
		if ( isset( $grid_args['loaded_ids'] ) ) {
			$args['post__not_in'] = $grid_args['loaded_ids'];
		}

		// Apply filters.
		$tax_query = array(
			'relation' => 'AND',
		);

		$meta_query = isset( $args['meta_query'] ) ? $args['meta_query'] : array();
		$meta_query['relation'] = 'AND';

		$filters = isset( $grid_args['filters'] ) ? $grid_args['filters'] : array();
		foreach ( $filters as $filter ) {
			switch ( $filter['type'] ) {
				case 'search':
					$args['s'] = $filter['text'];
					break;
				case 'terms':
					foreach ( $filter['terms'] as $taxonomy => $terms ) {
						if ( $terms ) {
							$tax_query[] = array(
								'taxonomy' => $taxonomy,
								'field' => 'slug',
								'terms' => $terms,
								'operator' => $filter['terms_inverse'] ? 'NOT IN' : 'IN',
							);
						}
					}

					if ( 'AND' !== $filter['terms_relation'] ) {
						$tax_query['relation'] = $filter['terms_relation'];
					}
					break;
				case 'custom_field':
					foreach ( $filter['values'] as $value ) {
						if ( $value ) {
							switch ( $value['type'] ) {
								case 'string':
									$meta_query[] = array(
										'key' => $filter['custom_field'],
										'value' => $value['value'],
										'compare' => $filter['values_inverse'] ? '!=' : '=',
									);
									break;
								case 'fuzzy':
									$meta_query[] = array(
										'key' => $filter['custom_field'],
										'value' => $value['value'],
										'compare' => $filter['values_inverse'] ? 'NOT LIKE' : 'LIKE',
									);
									break;
								case 'number':
									$meta_query[] = array(
										'key' => $filter['custom_field'],
										'value' => $value['value'],
										'type' => 'NUMERIC',
										'compare' => $filter['values_inverse'] ? '!=' : '=',
									);
									break;
								case 'range':
									$meta_query[] = array(
										'key' => $filter['custom_field'],
										'value' => $value['value'],
										'type' => 'NUMERIC',
										'compare' => $filter['values_inverse'] ? 'NOT BETWEEN' : 'BETWEEN',
									);
									break;
							}
						}
					}
	
					if ( 'AND' !== $filter['values_relation'] ) {
						$meta_query['relation'] = $filter['values_relation'];
					}
					break;
			}
		}

		if ( 1 < count( $tax_query ) ) {
			$args['tax_query'] = $tax_query;
		}
		if ( 1 < count( $meta_query ) ) {
			$args['meta_query'] = $meta_query;
		}
		
		return apply_filters( 'wpupg_query_post_args', $args, $this, $grid_args );
	}

	/**
	 * Get all the IDs that are displayed in this grid.
	 *
	 * @since    3.0.0
	 * @param	 mixed $grid_args Optional arguments.
	 */
	public function all_ids( $grid_args = array() ) {
		if ( false === $this->ids ) {
			$ids = array();
			$total_ids = false;

			if ( 'posts' === $this->type() ) {
				$args = $this->all_ids_query_post_args( $grid_args );

				// Optionally set specific language.
				WPUPG_Multilingual::set_language( $this->language() );

				// Query IDs.
				$query = new WP_Query( $args );
				$posts = $query->have_posts() ? $query->posts : array();
				$ids = array_map( 'intval', $posts );
				$total_ids = $query->found_posts;

				// Unset language.
				WPUPG_Multilingual::unset_language();
				
				// Offset posts
				if ( $this->limit_posts_offset() ) {
					$ids = array_slice( $ids, $this->limit_posts_offset() );
				}
		
				// Limit Total # Posts
				if ( $this->limit_posts_number() ) {
					$ids = array_slice( $ids, 0, $this->limit_posts_number() );
				}
			}

			$this->ids = apply_filters( 'wpupg_grid_all_ids', $ids, $this, $grid_args );
			$this->total_ids = $total_ids;
		}

		return $this->ids;
	}

	/**
	 * Get the terms to display in this grid.
	 *
	 * @since    3.0.0
	 * @param	 mixed $grid_args Optional arguments.
	 */
	public function terms( $grid_args = array() ) {
		if ( false === $this->terms ) {
			$terms = array(
				'per_item' => array(),
				'per_taxonomy' => array(),
			);
			$taxonomies = $this->filters_taxonomies();
	
			// Only need to get terms if there actually are taxonomies.
			if ( count( $taxonomies ) ) {
				$post_ids = $this->all_ids( $grid_args );

				// Build sanitized query.
				global $wpdb;

				$where_taxonomies = implode( '","', array_map( 'sanitize_key', $taxonomies ) );
				$where_post_ids = implode( ',', array_map( 'intval', $post_ids ) );

				$query = 'SELECT tr.object_id, tt.taxonomy, tt.parent, t.term_id, t.slug, t.name FROM ' . $wpdb->prefix . 'term_relationships tr JOIN ' . $wpdb->prefix . 'term_taxonomy tt ON tr.term_taxonomy_id = tt.term_taxonomy_id JOIN ' . $wpdb->prefix . 'terms t on tt.term_id = t.term_id WHERE tt.taxonomy IN ("' . $where_taxonomies . '")';

				if ( $where_post_ids ) {
					$query .= ' AND tr.object_id IN (' . $where_post_ids . ')';
				}
				
				$results = $wpdb->get_results( $query, ARRAY_A );

				// Loop over all results.
				$terms = $this->handle_terms( $terms, $results );
			}

			$this->terms = $terms;
		}

		return $this->terms;
	}
	
	/**
	 * Get terms from query reults.
	 *
	 * @since	3.5.0
	 */
	public function handle_terms( $terms, $results, $depth = 0 ) {
		$parents = array();

		foreach ( $results as $result ) {
			$item_id = intval( $result['object_id'] );
			$taxonomy = $result['taxonomy'];
			$term_id = intval( $result['term_id'] );
			$parent = intval( $result['parent'] );
			$slug = rawurldecode( $result['slug'] );
			$name = apply_filters( 'wpupg_term_name', $result['name'], $term_id, $taxonomy );

			// Make sure arrays exist.
			if ( ! isset( $terms['per_taxonomy'][ $taxonomy ] ) ) 			{ $terms['per_taxonomy'][ $taxonomy ] = array(); }
			if ( ! isset( $terms['per_item'][ $item_id ] ) ) 				{ $terms['per_item'][ $item_id ] = array(); }
			if ( ! isset( $terms['per_item'][ $item_id ][ $taxonomy ] ) ) {
				$terms['per_item'][ $item_id ][ $taxonomy ] = array(
					'terms' => array(),
					'parent_terms' => array(),
				);
			}
			if ( !isset( $terms['per_taxonomy'][ $taxonomy ][ $slug ] ) ) {
				$terms['per_taxonomy'][ $taxonomy ][ $slug ] = array(
					'id' => $term_id,
					'parent' => $parent,
					'name' => $name,
					'posts' => array(),
					'child_posts' => array(),
				);
			}

			// Add in correct category.
			if ( 0 === $depth ) {
				$terms['per_item'][ $item_id ][ $taxonomy ]['terms'][] = $slug;
				$terms['per_taxonomy'][ $taxonomy ][ $slug ]['posts'][] = $item_id;
			} else {
				$terms['per_item'][ $item_id ][ $taxonomy ]['parent_terms'][] = $slug;
				$terms['per_taxonomy'][ $taxonomy ][ $slug ]['child_posts'][] = $item_id;
			}

			// Check if there are further parents we need to get.
			if ( $parent ) {
				$parents[] = array(
					'object_id' => $item_id,
					'taxonomy' => $taxonomy,
					'term_id' => $parent,
				);
			}
		}

		// Check if there are any parents we need to associate as well.
		if ( count( $parents ) ) {
			$parent_results = array();

			$parent_ids = wp_list_pluck( $parents, 'term_id' );
			$parent_terms = get_terms( array(
				'include' => $parent_ids,
			) );

			if ( $parent_terms && ! is_wp_error( $parent_terms ) ) {
				// Set term_id as key.
				$keyed_parent_terms = array();
				foreach ( $parent_terms as $parent_term ) {
					$keyed_parent_terms[ $parent_term->term_id ] = $parent_term; 
				}

				foreach( $parents as $index => $parent ) {
					if ( isset( $keyed_parent_terms[ $parent['term_id'] ] ) ) {
						$parent_term = $keyed_parent_terms[ $parent['term_id'] ];

						$parent_results[] = array(
							'object_id' => $parent['object_id'],
							'taxonomy' => $parent['taxonomy'],
							'term_id' => $parent['term_id'],
							'parent' => $parent_term->parent,
							'slug' => $parent_term->slug,
							'name' => $parent_term->name,
						);
					}
				}
			}

			// Recursive loop.
			if ( count( $parent_results ) ) {
				$terms = $this->handle_terms( $terms, $parent_results, $depth + 1 );
			}
		}

		return $terms;
	}

	/**
	 * Get the terms for a specific item.
	 *
	 * @since    3.0.0
	 * @param	 int $item_id Item to get the terms for.
	 */
	public function get_terms_for_item( $item_id ) {
		$terms = $this->terms();

		return isset( $terms['per_item'][ $item_id ] ) ? $terms['per_item'][ $item_id ] : array();
	}

	/**
	 * Get the terms for a specific taxonomy.
	 *
	 * @since    3.0.0
	 * @param	 string 	$taxonomy Taxonomy to get the terms for.
	 */
	public function get_terms_for_taxonomy( $taxonomy ) {
		$terms = $this->terms();

		return isset( $terms['per_taxonomy'][ $taxonomy ] ) ? $terms['per_taxonomy'][ $taxonomy ] : array();
	}

	/**
	 * Get the taxonomies filtered by in this grid.
	 *
	 * @since    3.0.0
	 */
	public function filters_taxonomies() {
		$taxonomies = array();

		if ( $this->filters_enabled() ) {
			$filters = $this->filters();

			foreach ( $filters as $filter ) {
				if ( ! isset( $filter['options']['source'] ) || 'taxonomies' === $filter['options']['source'] ) {
					if ( isset( $filter['options']['taxonomies'] ) ) {
						$taxonomies = array_merge( $taxonomies, $filter['options']['taxonomies'] );
					}
				}
			}
		}

		return array_unique( $taxonomies );
	}

	/**
	 * Get the custom fields filtered by in this grid.
	 *
	 * @since    3.3.0
	 */
	public function filters_custom_fields() {
		$custom_fields = array();

		if ( $this->filters_enabled() ) {
			$filters = $this->filters();

			foreach ( $filters as $filter ) {
				if ( ! isset( $filter['options']['source'] ) || 'custom_field' === $filter['options']['source'] ) {
					if ( isset( $filter['options']['custom_field'] ) ) {
						$custom_fields[] = $filter['options']['custom_field'];
					}
				}
			}
		}

		return array_unique( $custom_fields );
	}
}
