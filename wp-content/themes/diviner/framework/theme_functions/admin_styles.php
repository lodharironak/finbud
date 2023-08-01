<?php
/**
* Enqueue Scripts for Admin
*/
function diviner_custom_wp_admin_style() {

    //wp_enqueue_style( 'admin-bootstrap', esc_url( get_template_directory_uri() ) . '/assets/bootstrap/bootstrap.css', array(), NULL );

    wp_enqueue_style( 'diviner-admin_css', esc_url( get_template_directory_uri() ) . '/assets/theme-styles/css/admin.css', array(), true );
}
add_action( 'customize_controls_print_styles', 'diviner_custom_wp_admin_style' );
add_action( 'admin_head', 'diviner_custom_wp_admin_style' );