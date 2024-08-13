<?php
/**
 * Handle Gutenberg Blocks.
 *
 * @link       https://bootstrapped.ventures
 * @since      3.0.0
 *
 * @package    WP_Ultimate_Post_Grid
 * @subpackage WP_Ultimate_Post_Grid/includes/public
 */

/**
 * Handle Gutenberg Blocks.
 *
 * @since      3.0.0
 * @package    WP_Ultimate_Post_Grid
 * @subpackage WP_Ultimate_Post_Grid/includes/public
 * @author     Brecht Vandersmissen <brecht@bootstrapped.ventures>
 */
class WPUPG_Blocks {
	
	/**
	 * Register actions and filters.
	 *
	 * @since	3.0.0
	 */
	public static function init() {
		add_action( 'init', array( __CLASS__, 'register_blocks' ) );

		// Deprecation notice after 5.8.0.
		global $wp_version;
		if ( $wp_version && version_compare( $wp_version, '5.8', '<' ) ) {
			add_filter( 'block_categories', array( __CLASS__, 'block_categories' ) );
		} else {
			add_filter( 'block_categories_all', array( __CLASS__, 'block_categories' ) );
		}
	}

	/**
	 * Register block categories.
	 *
	 * @since	3.0.0
	 * @param	array $categories Existing block categories.
	 */
	public static function block_categories( $categories ) {
		return array_merge(
			$categories,
			array(
				array(
					'slug' => 'wp-ultimate-post-grid',
					'title' => 'WP Ultimate Post Grid',
				),
			)
		);
	}

	/**
	 * Register all blocks.
	 *
	 * @since	3.0.0
	 */
	public static function register_blocks() {
		if ( function_exists( 'register_block_type' ) ) {
			$block_settings = array(
				'attributes' => array(
					'id' => array(
						'type' => 'string',
						'default' => '',
					),
					'align' => array(
						'type' => 'string',
						'default' => '',
					),
					'dynamic' => array(
						'type' => 'string',
						'default' => '',
					),
					'updated' => array(
						'type' => 'number',
						'default' => 0,
					),
				),
				'render_callback' => array( __CLASS__, 'render_grid_with_filters_block' ),
			);
			register_block_type( 'wp-ultimate-post-grid/grid-with-filters', $block_settings );

			$block_settings['render_callback'] = array( __CLASS__, 'render_grid_block' );
			register_block_type( 'wp-ultimate-post-grid/grid', $block_settings );

			$block_settings['attributes']['filter'] = array(
				'type' => 'string',
				'default' => '',
			);
			$block_settings['render_callback'] = array( __CLASS__, 'render_filter_block' );
			register_block_type( 'wp-ultimate-post-grid/filter', $block_settings );
		}
	}

	/**
	 * Parse block attributes.
	 *
	 * @since	3.0.0
	 * @param	mixed $atts Block attributes.
	 */
	public static function parse_atts( $atts ) {
		if ( isset( $atts['dynamic'] ) ) {
			$dynamic = trim( $atts['dynamic'] );

			if ( $dynamic ) {
				$dynamic_atts = shortcode_parse_atts( $dynamic );

				if ( $dynamic_atts ) {
					$atts = array_merge( $atts, $dynamic_atts );
				}
			}
		}

		unset( $atts['dynamic'] );
		return $atts;
	}

	/**
	 * Render the grid with filters block.
	 *
	 * @since	3.0.0
	 * @param	mixed $atts Block attributes.
	 */
	public static function render_grid_with_filters_block( $atts ) {
		$atts = self::parse_atts( $atts );
		$output = '';

		// Only do this for the Gutenberg Preview.
		if ( isset( $GLOBALS['wp']->query_vars['rest_route'] ) && '/wp/v2/block-renderer/wp-ultimate-post-grid/grid-with-filters' === $GLOBALS['wp']->query_vars['rest_route'] ) {
			$grid = WPUPG_Grid_Manager::get_grid( $atts['id'] );

			if ( $grid ) {
				$template_css = WPUPG_Template_Manager::get_template_css( $grid->template() );
				$output .= '<style>' . $template_css . '</style>';
			}
		}

		$output .= WPUPG_Shortcode::grid_with_filters_shortcode( $atts );

		return $output;
	}

	/**
	 * Render the grid block.
	 *
	 * @since	3.0.0
	 * @param	mixed $atts Block attributes.
	 */
	public static function render_grid_block( $atts ) {
		$atts = self::parse_atts( $atts );
		$output = '';

		// Only do this for the Gutenberg Preview.
		if ( isset( $GLOBALS['wp']->query_vars['rest_route'] ) && '/wp/v2/block-renderer/wp-ultimate-post-grid/grid' === $GLOBALS['wp']->query_vars['rest_route'] ) {
			$grid = WPUPG_Grid_Manager::get_grid( $atts['id'] );

			if ( $grid ) {
				$template_css = WPUPG_Template_Manager::get_template_css( $grid->template() );
				$output .= '<style>' . $template_css . '</style>';
			}
		}

		$output .= WPUPG_Shortcode::grid_shortcode( $atts );

		return $output;
	}

	/**
	 * Render the filter block.
	 *
	 * @since	3.0.0
	 * @param	mixed $atts Block attributes.
	 */
	public static function render_filter_block( $atts ) {
		$atts = self::parse_atts( $atts );
		return WPUPG_Shortcode::filter_shortcode( $atts );
	}
}

WPUPG_Blocks::init();
