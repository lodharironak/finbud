<?php
/*
Theme Name:   Finbud Child
Theme URI:    http://underscores.me/
Description:  Finbud child theme
Author:       Underscores.me
Author URI:   http://underscores.me/
Template:     finbuds
Version:      1.0.0
Text Domain:  finbuds
*/


add_action( 'wp_enqueue_scripts', 'hubspot_blog_theme_enqueue_styles' );
function hubspot_blog_theme_enqueue_styles() {
	wp_enqueue_style( 'parent-style', get_template_directory_uri() . 'style.css' );
}
?>