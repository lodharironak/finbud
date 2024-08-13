<?php
/**
 * Responsible for version migrations.
 *
 * @link       https://bootstrapped.ventures
 * @since      3.0.0
 *
 * @package    WP_Ultimate_Post_Grid
 * @subpackage WP_Ultimate_Post_Grid/includes/public
 */

/**
 * Responsible for version migrations.
 *
 * @since      3.0.0
 * @package    WP_Ultimate_Post_Grid
 * @subpackage WP_Ultimate_Post_Grid/includes/public
 * @author     Brecht Vandersmissen <brecht@bootstrapped.ventures>
 */
class WPUPG_Migrations {

	/**
	 * Register actions and filters.
	 *
	 * @since    3.0.0
	 */
	public static function init() {
		add_action( 'admin_init', array( __CLASS__, 'check_if_migration_needed' ) );
	}


	/**
	 * Check if a plugin migration is needed.
	 *
	 * @since    3.0.0
	 */
	public static function check_if_migration_needed() {
		// Version Migrations.
		$migrated_to_version = get_option( 'wpupg_migrated_to_version', '0.0.0' );

		if ( version_compare( $migrated_to_version, WPUPG_VERSION ) < 0 ) {
			if ( version_compare( $migrated_to_version, '3.0.0' ) < 0 ) {
				require_once( WPUPG_DIR . 'includes/public/migrations/wpupg-3-0-0-settings.php' );
			}

			update_option( 'wpupg_migrated_to_version', WPUPG_VERSION );
		}
	}

	/**
	 * Single filter (pre 3.0.0) to multiple filters per grid.
	 *
	 * @since    3.0.0
	 * @param    mixed $grid Grid to migrate.
	 */
	public static function single_filter_to_multiple( $grid ) {
		$filters = array();
		$filter_type = $grid->meta( 'filter_type', 'none' );

		if ( 'text_isotope' === $filter_type || 'isotope' === $filter_type ) {
			$filter_defaults = WPUPG_Filter::get_defaults();

			$filter_style = $grid->unserialize( $grid->meta( 'filter_style', array() ) );
	
			$options = array_replace_recursive( $filter_defaults['isotope'], array(
				'taxonomies' => $grid->unserialize( $grid->meta( 'filter_taxonomies', array() ) ),
				'match_parents' => $grid->meta( 'filter_match_parents', false ),
				'inverse' => $grid->meta( 'filter_inverse', false ),
				'show_empty' => $grid->meta( 'filter_show_empty', false ),
				'count' => $grid->meta( 'filter_count', false ),
				'multiselect' => $grid->meta( 'filter_multiselect', false ),
				'multiselect_type' => $grid->meta( 'filter_multiselect_type', 'match_all' ),
				'limit' => $grid->meta( 'filter_limit', false ),
				'limit_exclude' => $grid->meta( 'filter_limit_exclude', false ),
				'limit_terms' => $grid->unserialize( $grid->meta( 'filter_limit_terms', array() ) ),
				'all_button_text' => $filter_style['isotope']['all_button_text'],
				'term_order' => $filter_style['isotope']['term_order'],
				'style' => $filter_style['isotope'],
			) );

			$filters[] = array(
				'id' => '',
				'type' => 'isotope',
				'options' => $options,
			);
		}

		return apply_filters( 'wpupg_migration_single_filter_to_multiple', $filters, $grid, $filter_type );
	}

	/**
	 * Get pagination style (pre 3.0.0) combined with pagination.
	 *
	 * @since    3.0.0
	 * @param    mixed $grid Grid to migrate.
	 */
	public static function get_pagination_with_style( $grid ) {
		$pagination = $grid->unserialize( $grid->meta( 'pagination', array() ) );
		$pagination_type = $grid->meta( 'pagination_type', 'none' );

		if ( in_array( $pagination_type, array( 'pages', 'load_more', 'load_more_filter' ) ) ) {
			$pagination_style = $grid->unserialize( $grid->meta( 'pagination_style', array() ) );

			$pagination[ $pagination_type ]['style'] = $pagination_style;

			if ( 'load_more_filter' === $pagination_type ) {
				$pagination[ $pagination_type ]['load_on_filter'] = true;

				// Not a separate pagination type anymore.
				$pagination['load_more'] = $pagination['load_more_filter'];
				unset( $pagination['load_more_filter'] );
			}
		}

		return $pagination;
	}

	/**
	 * Get correct template from template id (pre 3.0.0).
	 *
	 * @since    3.0.0
	 * @param    mixed $grid Grid to migrate.
	 */
	public static function template_mapping( $grid ) {
		$mapping = array(
			0 => 'simple',
			1 => 'simple-with-excerpt',
			2 => 'overlay',
			3 => 'hover-with-date',
		);

		$id = intval( $grid->meta( 'template', 0 ) );

		return isset( $mapping[ $id ] ) ? $mapping[ $id ] : $mapping[ 0 ];
	}
}

WPUPG_Migrations::init();