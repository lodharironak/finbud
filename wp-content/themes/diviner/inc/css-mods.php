<?php
/**
 *  File for Custom CSS
 */

 function diviner_custom_css() {

     $primary_width     = 100 - get_theme_mod('diviner_sidebar_width', '25') . '%';
     $secondary_width   = get_theme_mod('diviner_sidebar_width', '25') . '%';

     $css = "";

     if ( get_option('show_on_front') == 'page' && is_front_page() ) {
         $css .= 'body.home #primary  {width: ' . $primary_width . ';}';
         $css .= 'body.home #secondary {width: ' . $secondary_width . ';}';
     }

     if (is_home() && strpos(get_theme_mod('diviner_select_layout', 'blog'), '_s') ) {
         $css .= 'body.blog #primary  {width: ' . $primary_width . ';}';
         $css .= 'body.blog #secondary {width: ' . $secondary_width . ';}';
     }

     if (is_single() && is_active_sidebar('sidebar-2') && strpos( get_theme_mod('diviner_post_sidebar_layout', 'col_s'), '_' ) ) {
         $css .= 'body.single-post #primary {width: ' . $primary_width . ';}';
         $css .= 'body.single-post #secondary {width: ' . $secondary_width . ';}';
     }

     if ( !is_front_page() && is_page() && "" == get_post_meta( get_the_ID(), 'hide-sidebar', true) ) {
         $css .= 'body.page #primary {width: ' . $primary_width . ';}';
         $css .= 'body.page #secondary {width: ' . $secondary_width . ';}';
     }

/*
     if ( ( class_exists('woocommerce') && ! is_woocommerce() && ( is_search() || is_post_type_archive('product') ) ) ||
     		( !class_exists('woocommerce') && ( is_search() || is_archive() ) ) ) {
         $css .= 'body.search #primary, body.archive #primary {width: ' . $primary_width . ';}';
         $css .= 'body.search #secondary, body.archive #secondary {width: ' . $secondary_width . ';}';
     }
*/
	if ( is_archive() || is_search() ) {
		$css .= 'body.search #primary, body.archive #primary {width: ' . $primary_width . ';}';
        $css .= 'body.search #secondary, body.archive #secondary {width: ' . $secondary_width . ';}';
	}

     if ( class_exists('woocommerce') && is_post_type_archive('product') && 'col_s' == get_theme_mod('diviner_wc_sidebar_layout', 'col_s') ) {
         $css .= 'body.post-type-archive-product #primary {width: ' . $primary_width . ';}';
         $css .= 'body.post-type-archive-product #secondary {width: ' . $secondary_width . ';}';
     }

     $css .= '#masthead.full #top-wrapper {background-color: rgba(255,255,255,' . get_theme_mod('diviner_full_header_nav_opacity', 1) . ')}';

     wp_add_inline_style( 'diviner-main-style', wp_strip_all_tags($css) );

 }
 add_action('wp_enqueue_scripts', 'diviner_custom_css');