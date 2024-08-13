<?php
/**
 * Responsible for the grid template editor.
 *
 * @link       https://bootstrapped.ventures
 * @since      3.0.0
 *
 * @package    WP_Ultimate_Post_Grid
 * @subpackage WP_Ultimate_Post_Grid/includes/public
 */

/**
 * Responsible for the grid template editor.
 *
 * @since      3.0.0
 * @package    WP_Ultimate_Post_Grid
 * @subpackage WP_Ultimate_Post_Grid/includes/public
 * @author     Brecht Vandersmissen <brecht@bootstrapped.ventures>
 */
class WPUPG_Template_Editor {
	/**
	 * Register actions and filters.
	 *
	 * @since	3.0.0
	 */
	public static function init() {
		add_action( 'admin_menu', array( __CLASS__, 'add_submenu_page' ), 20 );
	}

	/**
	 * Add the template editor submenu to the WPUPG menu.
	 *
	 * @since	3.0.0
	 */
	public static function add_submenu_page() {
		add_submenu_page( 'wpultimatepostgrid', __( 'WPUPG Template Editor', 'wp-ultimate-post-grid' ), __( 'Template Editor', 'wp-ultimate-post-grid' ), 'manage_options', 'wpupg_template_editor', array( __CLASS__, 'template_editor_page_template' ) );
	}

	/**
	 * Get the template for the template editor page.
	 *
	 * @since	3.0.0
	 */
	public static function template_editor_page_template() {
		self::localize_admin_template();
		echo '<div id="wpupg-template" class="wrap">Loading...</div>';
	}

	/**
	 * Localize JS for the template editor page.
	 *
	 * @since	5.8.0
	 */
	public static function localize_admin_template() {
		// Get all modern templates.
		$modern_templates = array();
		$templates = WPUPG_Template_Manager::get_templates();

		foreach ( $templates as $template ) {
			$modern_templates[ $template['slug'] ] = self::prepare_template_for_editor( $template );
		}

		wp_localize_script( 'wpupg-admin-template', 'wpupg_admin_template', array(
			'templates' => $modern_templates,
			'shortcodes' => WPUPG_Template_Shortcodes::get_shortcodes(),
			'icons' => WPUPG_Icon::get_all(),
			'thumbnail_sizes' => get_intermediate_image_sizes(),
			'preview_item' => self::get_default_preview_item(),
		) );
	}

	/**
	 * Get the default preview item for the template editor.
	 *
	 * @since	3.4.0
	 */
	private static function get_default_preview_item() {
		$preview_item = false;

		// Get the latest published post that as a featured image set.
		$args = array(
			'post_type' => 'post',
			'post_status' => 'publish',
			'posts_per_page' => 1,
			'ignore_sticky_posts' => true,
			'order_by' => 'date',
			'order' => 'DESC',
			'meta_query' => array(
				array(
					'key' => '_thumbnail_id',
					'value' => '0',
					'compare' => '>'
				),
			),
		);
		
		$query = new WP_Query( $args );
		$posts = $query->have_posts() ? $query->posts : array();

		$post = isset( $posts[0] ) ? $posts[0] : false;

		if ( $post ) {
			$item = WPUPG_Item_Manager::get_item( $post->ID );

			if ( $item ) {
				$post_type = get_post_type_object( $post->post_type );
	
				$preview_item = array(
					'value' => $post->ID,
					'label' => $post_type->labels->singular_name . ' - ' . $post->ID . ' - ' . $post->post_title,
					'classes' => $item->classes(),
				);
			}
		}

		return $preview_item;
	}

	/**
	 * Prepare a template for the template editor.
	 *
	 * @since	3.0.0
	 * @param	mixed $template Template to prepare.
	 */
	public static function prepare_template_for_editor( $template ) {
		$template['style'] = self::extract_style_with_properties( $template );
		return $template;
	}

	/**
	 * Extract the style and optional properties from a template stylesheet.
	 *
	 * @since	3.0.0
	 * @param	mixed $template Template to extract from.
	 */
	private static function extract_style_with_properties( $template ) {
		$css = WPUPG_Template_Manager::get_template_css( $template );

		// Find properties in CSS.
		$properties = array();

		preg_match_all( "/:([^:;]+);\s*\/\*([^*]*)\*+([^\/*][^*]*\*+)*\//im", $css, $matches );
		foreach ( $matches[2] as $index => $comment ) {
			$value = trim( $matches[1][ $index ] );
			$comment = trim( $comment );
			
			// Check if it's one of our comments.
			if ( 'wpupg_' === substr( $comment, 0, 6 ) ) {
				$parts = explode( ' ', $comment );

				// First part should be variable name.
				$id = substr( $parts[0], 6 );
				unset( $parts[0] );

				if ( $id ) {
					$property = array(
						'id' => $id,
						'name' => ucwords( str_replace( '_', ' ', $id ) ),
						'default' => $value,
						'value' => $value,
					);

					// Check if there are any parts left.
					foreach ( $parts as $part ) {
						$pieces = explode( '=', $part );

						if ( 2 === count( $pieces ) ) {
							if ( ! array_key_exists( $pieces[0], $property ) ) {
								$property[ $pieces[0] ] = $pieces[1];
							}
						}
					}

					// Add to properties.
					$properties[ $id ] = $property;

					// Replace with variable in CSS.
					$css = str_ireplace( $matches[0][ $index ], ': %wpupg_' . $id .'%;', $css );
				}
			}
		}

		return array(
			'properties' => $properties,
			'css' => $css,
		);
	}
}

WPUPG_Template_Editor::init();
