<?php
/**
 * Responsible for the grid template.
 *
 * @link       https://bootstrapped.ventures
 * @since      3.0.0
 *
 * @package    WP_Ultimate_Post_Grid
 * @subpackage WP_Ultimate_Post_Grid/includes/public
 */

/**
 * Responsible for the grid template.
 *
 * @since      3.0.0
 * @package    WP_Ultimate_Post_Grid
 * @subpackage WP_Ultimate_Post_Grid/includes/public
 * @author     Brecht Vandersmissen <brecht@bootstrapped.ventures>
 */
class WPUPG_Template_Manager {
	/**
	 * Cached version of all the available templates.
	 *
	 * @since    3.0.0
	 * @access   private
	 * @var      array    $templates    Array containing all templates that have been loaded.
	 */
	private static $templates = array();

	/**
	 * Templates used in the output.
	 *
	 * @since    3.0.0
	 * @access   private
	 * @var      array    $used_templates    Array containing all templates that have been used in the output.
	 */
	private static $used_templates = array();

	/**
	 * Register actions and filters.
	 *
	 * @since    3.0.0
	 */
	public static function init() {
		add_action( 'wp_footer', array( __CLASS__, 'templates_css' ), 99 );
	}

	/**
	 * Add CSS to footer for all grids on this page.
	 *
	 * @since    3.0.0
	 */
	public static function templates_css() {
		if ( count( self::$used_templates ) ) {
			$style = '';
			
			foreach ( self::$used_templates as $slug => $template ) {
				$style .= self::get_template_css( $template );
			}

			if ( $style ) {
				echo '<style>' . $style . '</style>';
			}
		}
	}

	/**
	 * Add template as being used on this page to output CSS for later.
	 *
	 * @since    3.0.0
	 */
	public static function add_used_template( $template ) {
		if ( ! array_key_exists( $template['slug'], self::$used_templates ) ) {
			self::$used_templates[ $template['slug'] ] = $template;
		}
	}

	/**
	 * Get template output.
	 *
	 * @since	3.0.0
	 * @param	mixed  $item Item to output the template for.
	 * @param	mixed  $slug Slug of the template we want.
	 */
	public static function get_template( $item, $slug = false ) {
		$template = self::get_template_by_slug( $slug );

		// Add template to array of used templats.
		self::add_used_template( $template );

		// Get HTML.
		WPUPG_Template_Shortcodes::set_current_item( $item );
		$html = self::replace_placeholders( $template['html'], $item );
		$output = do_shortcode( $html );
		WPUPG_Template_Shortcodes::set_current_item( false );

		return $output;
	}

	/**
	 * Replace placeholders in template HTML.
	 *
	 * @since	3.8.0
	 * @param	mixed  $html Template HTML.
	 * @param	mixed  $item Item to output the template for.
	 */
	public static function replace_placeholders( $html, $item = false ) {
		if ( $item ) {
			$html = str_ireplace( '%wpupg_id%', $item->id(), $html );
		}

		return $html;
	}

	/**
	 * Get template by slug.
	 *
	 * @since	3.0.0
	 * @param	mixed  $slug Slug of the template we want.
	 */
	public static function get_template_by_slug( $slug = false ) {
		$templates = self::get_templates();

		// Default to "Simple" if template is not found.
		return isset( $templates[ $slug ] ) ? $templates[ $slug ] : $templates[ 'simple' ];
	}

	/**
	 * Get CSS for a specific template.
	 *
	 * @since	3.0.0
	 * @param	object $template_or_slug Template to get the CSS for.
	 */
	public static function get_template_css( $template_or_slug ) {
		$css = '';

		if ( is_array( $template_or_slug ) ) {
			$template = $template_or_slug;
		} else {
			$template = self::get_template_by_slug( $template_or_slug );
		}

		if ( ! $template ) {
			return $css;
		}

		if ( 'file' === $template['location'] ) {

			if ( ! $template['custom'] ) {
				// Get default CSS.
				ob_start();
				include( WPUPG_DIR . 'templates/grid/default.css' );
				$css .= ob_get_contents();
				ob_end_clean();

				// Replace default classic with template specific one.
				$css = preg_replace( '/\.wpupg-template(\[|:|\s|\{)/im', '.wpupg-template-' . $template['slug'] . '$1', $css );
			}

			// Get CSS from stylesheet.
			if ( $template['stylesheet'] ) {
				ob_start();
				include( $template['dir'] . '/' . $template['stylesheet'] );
				$css .= ob_get_contents();
				ob_end_clean();
			}
		} else {
			// Get virtual CSS.
			$css = $template['css'];
		}

		return $css;
	}

	/**
	 * Save a template.
	 *
	 * @since	3.0.0
	 * @param	mixed $template Template to save.
	 */
	public static function save_template( $template ) {
		$templates = self::get_templates();
		$slug = isset( $template['slug'] ) ? sanitize_title( $template['slug'] ) : false;
		$old_slug = isset( $template['oldSlug'] ) ? sanitize_title( $template['oldSlug'] ) : $slug;

		// New slug needed.
		if ( ! $slug || ( array_key_exists( $slug, $templates ) && 'file' === $templates[ $slug ]['location'] ) ) {
			$slug_base = sanitize_title( $template['name'], 'template' );

			$slug = $slug_base;
			$i = 2;
			while ( array_key_exists( $slug, $templates ) ) {
				$slug = $slug_base . '-' . $i;
				$i++;
			}

			if ( $old_slug ) {
				// Need to update CSS and HTML classes.
				$template['css'] = str_ireplace( '.wpupg-template-' . $old_slug, '.wpupg-template-' . $slug, $template['css'] );
				$template['html'] = str_ireplace( 'wpupg-template-' . $old_slug, 'wpupg-template-' . $slug, $template['html'] );
			}
		}		

		// Sanitize template.
		$sanitized_template['location'] = 'database';
		$sanitized_template['custom'] = true;
		$sanitized_template['dir'] = false;
		$sanitized_template['url'] = false;
		$sanitized_template['stylesheet'] = false;
		$sanitized_template['screenshot'] = false;

		$sanitized_template['premium'] = (bool) $template['premium'];
		$sanitized_template['slug'] = $slug;
		$sanitized_template['name'] = sanitize_text_field( $template['name'] );
		$sanitized_template['css'] = trim( $template['css'] );
		$sanitized_template['html'] = trim( $template['html'] );

		// Make sure list of templates is up to date.
		$templates = get_option( 'wpupg_templates', array() );
		if ( ! in_array( $slug, $templates ) ) {
			$templates[] = $slug;
			update_option( 'wpupg_templates', $templates );
		}

		// Save template in cache and database.
		self::$templates[$slug] = $sanitized_template;
		update_option( 'wpupg_template_' . $slug, $sanitized_template );

		return $sanitized_template;
	}

	/**
	 * Delete a template.
	 *
	 * @since	3.0.0
	 * @param	mixed $slug Slug of the template to delete.
	 */
	public static function delete_template( $slug ) {
		$slug = sanitize_title( $slug );

		// Make sure list of templates is up to date.
		$templates = get_option( 'wpupg_templates', array() );
		if ( false !== ( $index = array_search( $slug, $templates ) ) ) {
			unset( $templates[ $index ] );
		}
		update_option( 'wpupg_templates', $templates );
		delete_option( 'wpupg_template_' . $slug );

		return $slug;
	}

	/**
	 * Get all available templates.
	 *
	 * @since	3.0.0
	 */
	public static function get_templates() {
		if ( empty( self::$templates ) ) {
			self::load_templates();
		}

		return self::$templates;
	}

	/**
	 * Load all available templates.
	 *
	 * @since	3.0.0
	 */
	private static function load_templates() {
		$templates = array();

		$dirs = array_filter( glob( WPUPG_DIR . 'templates/grid/*' ), 'is_dir' );
		$url = WPUPG_URL . 'templates/grid/';

		foreach ( $dirs as $dir ) {
			$template = self::load_template( $dir, $url, false );
			$templates[ $template['slug'] ] = $template;
		}

		// Load custom templates from parent theme.
		$theme_dir = get_template_directory();

		if ( file_exists( $theme_dir . '/wpupg-templates' ) && file_exists( $theme_dir . '/wpupg-templates/grid' ) ) {
			$url = get_template_directory_uri() . '/wpupg-templates/grid/';

			$dirs = array_filter( glob( $theme_dir . '/wpupg-templates/grid/*' ), 'is_dir' );

			foreach ( $dirs as $dir ) {
				$template = self::load_template( $dir, $url, true );
				$templates[ $template['slug'] ] = $template;
			}
		}

		// Load custom templates from child theme (if present).
		if ( get_stylesheet_directory() !== $theme_dir ) {
			$theme_dir = get_stylesheet_directory();

			if ( file_exists( $theme_dir . '/wpupg-templates' ) && file_exists( $theme_dir . '/wpupg-templates/grid' ) ) {
				$url = get_stylesheet_directory_uri() . '/wpupg-templates/grid/';

				$dirs = array_filter( glob( $theme_dir . '/wpupg-templates/grid/*' ), 'is_dir' );

				foreach ( $dirs as $dir ) {
					$template = self::load_template( $dir, $url, true );
					$templates[ $template['slug'] ] = $template;
				}
			}
		}

		// Load templates from database.
		$db_templates = get_option( 'wpupg_templates', array() );

		foreach ( $db_templates as $slug ) {
			$template = get_option( 'wpupg_template_' . $slug, false );

			if ( $template ) {
				$templates[ $slug ] = $template;
			}
		}

		self::$templates = $templates;
	}

	/**
	 * Load template from directory.
	 *
	 * @since	3.0.0
	 * @param	mixed 	 $dir 	  Directory to load the template from.
	 * @param	mixed 	 $url 	  URL to load the template from.
	 * @param	boolean $custom  Wether or not this is a custom template included by the user.
	 * @param	boolean $premium Wether or not this is a premium template.
	 */
	private static function load_template( $dir, $url, $custom = false, $premium = false ) {
		$slug = basename( $dir );
		$name = ucwords( str_replace( '-', ' ', $slug ) );

		// Allow both .min.css and .css as extension.
		$stylesheet = file_exists( $dir . '/' . $slug . '.min.css' ) ? $slug . '.min.css' : $slug . '.css';

		// Check for HTML file.
		$html = file_exists( $dir . '/' . $slug . '.html' ) ? trim( file_get_contents( $dir . '/' . $slug . '.html' ) ) : false;

		return array(
			'location' => 'file',
			'custom' => $custom,
			'premium' => $premium,
			'name' => $name,
			'slug' => $slug,
			'dir' => $dir,
			'url' => $url . $slug,
			'stylesheet' => $stylesheet,
			'html' => $html,
		);
	}
}

WPUPG_Template_Manager::init();
