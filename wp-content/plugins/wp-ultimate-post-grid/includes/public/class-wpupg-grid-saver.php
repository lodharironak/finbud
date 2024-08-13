<?php
/**
 * Responsible for saving grids.
 *
 * @link       https://bootstrapped.ventures
 * @since      3.0.0
 *
 * @package    WP_Ultimate_Post_Grid
 * @subpackage WP_Ultimate_Post_Grid/includes/admin
 */

/**
 * Responsible for saving grids.
 *
 * @since      3.0.0
 * @package    WP_Ultimate_Post_Grid
 * @subpackage WP_Ultimate_Post_Grid/includes/admin
 * @author     Brecht Vandersmissen <brecht@bootstrapped.ventures>
 */
class WPUPG_Grid_Saver {
	/**
	 * Create a new grid.
	 *
	 * @since    3.0.0
	 * @param	 array $grid Grid fields to save.
	 */
	public static function create_grid( $grid ) {
		$post = array(
			'post_type' => WPUPG_POST_TYPE,
			'post_status' => 'publish',
		);

		$grid_id = wp_insert_post( $post );
		WPUPG_Grid_Saver::update_grid( $grid_id, $grid );

		return $grid_id;
	}

	/**
	 * Save grid fields.
	 *
	 * @since    3.0.0
	 * @param	 int   $id Post ID of the grid.
	 * @param	 array $grid Grid fields to save.
	 */
	public static function update_grid( $id, $grid ) {
		$meta = array();

		// Meta Fields.
		$allowed_meta = array(
			'version',
			// General.
			// Data Source.
			'type',
			'post_types',
			'post_status',
			'post_status_require_permission',
			'taxonomies',
			'password_protected',
			'language',
			'order_by',
			'order',
			'order_custom_key',
			'order_custom_key_numeric',
			'terms_order',
			'terms_order_by',
			// Limit Items.
			'limit_posts_offset',
			'limit_posts_number',
			'images_only',
			'terms_images_only',
			'terms_hide_empty',
			'limit_terms',
			'limit_terms_terms',
			'limit_terms_type',
			'limit_posts',
			'limit_rules',
			// Filters.
			'filters_enabled',
			'filters',
			'filters_style',
			'filters_relation',
			'responsive_toggle_style',
			'responsive_toggle_style_closed',
			'responsive_toggle_style_open',
			// Layout.
			'layout_mode',
			'centered',
			'rtl_mode',
			'layout_desktop_sizing',
			'layout_desktop_sizing_columns',
			'layout_desktop_sizing_fixed',
			'layout_desktop_sizing_margin',
			'layout_tablet_different',
			'layout_tablet_sizing',
			'layout_tablet_sizing_columns',
			'layout_tablet_sizing_fixed',
			'layout_tablet_sizing_margin',
			'layout_mobile_different',
			'layout_mobile_sizing',
			'layout_mobile_sizing_columns',
			'layout_mobile_sizing_fixed',
			'layout_mobile_sizing_margin',
			// Template.
			'template',
			'use_image',
			'link',
			'link_type',
			'link_target',
			// Pagination.
			'pagination_type',
			'pagination',
			// Other.
			'metadata',
			'metadata_name',
			'metadata_description',
			'deeplinking',
			'empty_message',
		);

		foreach ( $allowed_meta as $field ) {
			if ( isset( $grid[ $field ] ) ) {
				$meta[ 'wpupg_' . $field ] = $grid[ $field ];
			}
		}

		$meta = apply_filters( 'wpupg_grid_save_meta', $meta, $id, $grid );

		// Post Fields.
		$post = array(
			'ID' => $id,
			'post_status' => 'publish',
			'meta_input' => $meta,
		);

		if ( isset( $grid['name'] ) ) { $post['post_title'] = $grid['name']; }
		if ( isset( $grid['slug'] ) ) { $post['post_name'] = $grid['slug']; }

		WPUPG_Grid_Manager::invalidate_grid( $id );
		wp_update_post( $post );
	}
}
