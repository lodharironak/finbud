<?php
/**
 * Diviner functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Diviner
 */

if ( !defined( 'DIVINER_VERSION') ) {
	// Replace the version number of the theme on each release.
	define( 'DIVINER_VERSION', '1.6.4' );
}


/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function diviner_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'diviner_content_width', 640 );
}
add_action( 'after_setup_theme', 'diviner_content_width', 0 );


require get_template_directory() . '/framework/theme_functions/theme_setup.php';

require get_template_directory() . '/framework/theme_functions/register_sidebars.php';

require get_template_directory() . '/framework/theme_functions/enqueue_scripts.php';

require get_template_directory() . '/framework/theme_functions/enqueue_styles.php';

require get_template_directory() . '/framework/theme_functions/admin_scripts.php';

require get_template_directory() . '/framework/theme_functions/admin_styles.php';


/**
 *	File for Custom CSS
 */
 require get_template_directory() . '/inc/css-mods.php';


/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 *	Add Block Styles
 */
 require get_template_directory() . '/inc/block-styles.php';

/**
 *	Metabox for Pages
 */
require get_template_directory() . '/framework/metabox/display-options.php';
/**
 * Customizer additions.
 */
require get_template_directory() . '/framework/customizer/customizer.php';

/**
 *	Functions for getting masthead
 */
require get_template_directory() . '/framework/header/default.php';


/**
 *	Walker File for theme
 */
 require get_template_directory() . '/inc/walker.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
 *	Enqueue custom widget files
 */

 require get_template_directory() . '/framework/widgets/featured-posts-slider.php';

 require get_template_directory() . '/framework/widgets/featured-posts-slider-2.php';

 require get_template_directory() . '/framework/widgets/posts-slider.php';

 require get_template_directory() . '/framework/widgets/featured-posts.php';

  require get_template_directory() . '/framework/widgets/featured-posts-thumb.php';

  require get_template_directory() . '/framework/widgets/recent-posts.php';


  /**
   *	Add TGM Plugin Activation Class
   */

 	require_once get_template_directory() . '/inc/class-tgm-plugin-activation.php';

	require_once get_template_directory() . '/inc/tgmpa.php';