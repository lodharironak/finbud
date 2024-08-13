<?php
/**
 * Handle the assets for manage and modal.
 *
 * @link       https://bootstrapped.ventures
 * @since      3.0.0
 *
 * @package    WP_Ultimate_Post_Grid
 * @subpackage WP_Ultimate_Post_Grid/includes/admin/manage
 */

/**
 * Handle the assets for manage and modal.
 *
 * @since      3.0.0
 * @package    WP_Ultimate_Post_Grid
 * @subpackage WP_Ultimate_Post_Grid/includes/admin/manage
 * @author     Brecht Vandersmissen <brecht@bootstrapped.ventures>
 */
class WPUPG_Manage_Modal {

	/**
	 * Register actions and filters.
	 *
	 * @since    3.0.0
	 */
	public static function init() {
		add_action( 'admin_menu', array( __CLASS__, 'add_manage_page' ), 11 );
		add_action( 'admin_footer', array( __CLASS__, 'add_modal_content' ) );

		add_action( 'admin_enqueue_scripts', array( __CLASS__, 'enqueue' ) );
	}

	/**
	 * Add the manage submenu to the WPUPG menu.
	 *
	 * @since    3.0.0
	 */
	public static function add_manage_page() {
		add_submenu_page( 'wpultimatepostgrid', __( 'Manage', 'wp-ultimate-post-grid' ), __( 'Manage', 'wp-ultimate-post-grid' ), WPUPG_Settings::get( 'features_manage_access' ), 'wpultimatepostgrid', array( __CLASS__, 'manage_page_template' ) );
	}

	/**
	 * Get the template for this submenu.
	 *
	 * @since    3.0.0
	 */
	public static function manage_page_template() {
		echo '<div class="wrap"><div id="wpupg-admin-manage">Loading...</div></div>';
	}

	/**
	 * Check compatibility with other plugins.
	 *
	 * @since    3.0.0
	 */
	public static function do_not_load_here() {
		$screen = get_current_screen();
		if ( 'toplevel_page_et_bloom_options' === $screen->id
			|| 'et_theme_builder' === substr( $screen->id, -16 )
			|| 'bulletproof-security' === substr( $screen->id, 0, 20 )
			|| 'hustle' === $screen->parent_base
			|| 'admin_page_newsletter' === substr( $screen->id, 0, 21 )
			|| 'bookly-menu' === $screen->parent_base
			|| 'WishListMember' === $screen->parent_base ) {
			return true;
		}

		return false;
	}

	/**
	 * Add modal template to edit screen.
	 *
	 * @since    3.0.0
	 */
	public static function add_modal_content() {
		if ( self::do_not_load_here() ) {
			return;
		}

		echo '<div id="wpupg-admin-modal"></div>';
		echo '<div id="wpupg-admin-modal-tinymce-placeholder" style="display: none">';
		wp_editor( '', 'wpupg-admin-modal-tinymce' );
		echo '</div>';
	}

	/**
	 * Enqueue stylesheets and scripts.
	 *
	 * @since    3.0.0
	 */
	public static function enqueue() {
		if ( self::do_not_load_here() ) {
			return;
		}

		// Enqueue public assets as well for preview.
		WPUPG_Assets::enqueue();
		WPUPG_Assets::load();

		wp_enqueue_style( 'wpupg-admin-manage-modal', WPUPG_URL . 'dist/admin-manage-modal.css', array(), WPUPG_VERSION, 'all' );
		wp_enqueue_script( 'wpupg-admin-manage-modal', WPUPG_URL . 'dist/admin-manage-modal.js', array( 'wpupg-public', 'wpupg-admin' ), WPUPG_VERSION, true );

		wp_localize_script( 'wpupg-admin-manage-modal', 'wpupg_admin_manage_modal', array(
			'grid' => self::get_new_grid(),
			'notices' => WPUPG_Notices::get_notices(),
			'post_types' => self::get_post_types(),
			'taxonomies' => self::get_taxonomies(),
			'authors' => self::get_authors(),
			'filters' => WPUPG_Filter::get_defaults(),
			'templates' => self::get_templates(),
			'multilingual' => WPUPG_Multilingual::get(),
		) );
	}

	/**
	 * Get new link.
	 *
	 * @since    3.0.0
	 */
	public static function get_new_grid() {
		$grid = new WPUPG_Grid( array(
			'version' => WPUPG_VERSION,
		) );
		return $grid->get_data();
	}

	/**
	 * Get post types.
	 *
	 * @since    3.0.0
	 */
	private static function get_post_types() {
		$post_types = array();
		$all_post_types = get_post_types( '', 'objects' );

		unset( $all_post_types[WPUPG_POST_TYPE] );
		unset( $all_post_types['revision'] );
		unset( $all_post_types['nav_menu_item'] );

		foreach ( $all_post_types as $key => $options ) {
			$post_types[ $key ] = array(
				'value' => $key,
				'label' => $options->labels->name,
				'taxonomies' => get_object_taxonomies( $key ),
			);
		}

		return $post_types;
	}

	/**
	 * Get taxonomies.
	 *
	 * @since    3.0.0
	 */
	private static function get_taxonomies() {
		$taxonomies = array();
		$all_taxonomies = get_taxonomies( '', 'objects' );

		foreach ( $all_taxonomies as $key => $options ) {
			$terms = array();
			$all_terms = get_terms( array(
				'taxonomy' => $key,
				'hide_empty' => false,
				'fields' => 'id=>name',
			) );

			foreach( $all_terms as $id => $name ) {
				$terms[] = array(
					'value' => $id,
					'label' => $name,
				);
			}

			$taxonomies[ $key ] = array(
				'value' => $key,
				'label' => $options->labels->name,
				'terms' => $terms,
			);
		}

		return $taxonomies;
	}

	/**
	 * Get authors.
	 *
	 * @since    3.0.0
	 */
	private static function get_authors() {
		$authors = array();

		$args = array(
			'fields' => array(
				'ID', 'display_name'
			)
		);

		// Prevent deprecation warning.
		if ( version_compare( $GLOBALS['wp_version'], '5.9', '<' ) ) {
			$args['who'] = 'authors';
		} else {
			$args['capability'] = ['edit_posts'];
		}

		$users = get_users( $args );
		foreach ( $users as $user ) {
			$authors[] = array(
				'value' => $user->ID,
				'label' => $user->ID . ' - ' . $user->display_name,
			);
		}

		return $authors;
	}

	/**
	 * Get templates.
	 *
	 * @since    3.0.0
	 */
	private static function get_templates() {
		$templates = WPUPG_Template_Manager::get_templates();

		return array_values( array_map( function( $template ) {
			return array(
				'value' => $template['slug'],
				'label' => $template['name'],
			);
		}, $templates ) );
	}
}

WPUPG_Manage_Modal::init();
