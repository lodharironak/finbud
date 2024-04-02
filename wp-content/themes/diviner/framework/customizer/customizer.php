<?php
/**
 * Diviner Theme Customizer
 *
 * @package Diviner
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function diviner_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
	$wp_customize->get_section( 'title_tagline' )->priority 	= 15;

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial(
			'blogname',
			array(
				'selector'        => '.site-title a',
				'render_callback' => 'diviner_customize_partial_blogname',
			)
		);
		$wp_customize->selective_refresh->add_partial(
			'blogdescription',
			array(
				'selector'        => '.site-description',
				'render_callback' => 'diviner_customize_partial_blogdescription',
			)
		);
	}
}
add_action( 'customize_register', 'diviner_customize_register' );

/**
 *	Add Customizer files for different sections
 */
 require_once get_template_directory() . '/framework/customizer/sanitization.php';
 require_once get_template_directory() . '/framework/customizer/header_layouts.php';
 require_once get_template_directory() . '/framework/customizer/blog_layouts.php';
 require_once get_template_directory() . '/framework/customizer/post_layouts.php';
 require_once get_template_directory() . '/framework/customizer/custom_controls.php';
 require_once get_template_directory() . '/framework/customizer/footer.php';
 require_once get_template_directory() . '/framework/customizer/social_icons.php';
 require_once get_template_directory() . '/framework/customizer/sidebar_options.php';
 require_once get_template_directory() . '/framework/customizer/site_layout.php';
 require_once get_template_directory() . '/framework/customizer/front_page_layout.php';
 require_once get_template_directory() . '/framework/customizer/single_post_layout.php';
 require_once get_template_directory() . '/framework/customizer/wc_controls.php';
 require_once get_template_directory() . '/framework/customizer/upsell.php';

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function diviner_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function diviner_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function diviner_customize_preview_js() {
	wp_enqueue_script( 'diviner-customizer', esc_url( get_template_directory_uri() ) . '/js/customizer.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'diviner_customize_preview_js' );