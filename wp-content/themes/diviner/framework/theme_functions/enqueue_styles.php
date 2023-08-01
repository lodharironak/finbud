<?php
function diviner_enqueue_styles() {

    wp_enqueue_style( 'diviner-style', get_stylesheet_uri(), array(), DIVINER_VERSION );
    wp_style_add_data( 'diviner-style', 'rtl', 'replace' );

    wp_enqueue_style( 'bootstrap', esc_url( get_template_directory_uri() ) . '/assets/bootstrap/bootstrap.css', array(), NULL );

  	wp_enqueue_style( 'font-awesome', esc_url( get_template_directory_uri() ) . '/assets/font-awesome/all.css', array(), NULL );

    wp_enqueue_style( 'diviner-main-style', esc_url( get_template_directory_uri() ) . '/assets/theme-styles/css/default.css', 'diviner-style' );

    wp_enqueue_style( 'slider', esc_url( get_template_directory_uri() ) . '/assets/bxslider/jquery.bxslider.css', 'diviner-slider', DIVINER_VERSION );

    wp_enqueue_style( 'lightbox', esc_url( get_template_directory_uri() ) . '/assets/lightbox/simple-lightbox.css', 'diviner-lightbox', DIVINER_VERSION );

    wp_enqueue_style( 'diviner-fonts', 'https://fonts.googleapis.com/css2?family=Oswald:wght@300;400;500&family=Roboto:wght@400;700&display=swap', array(), NULL );
}
add_action('wp_enqueue_scripts', 'diviner_enqueue_styles');