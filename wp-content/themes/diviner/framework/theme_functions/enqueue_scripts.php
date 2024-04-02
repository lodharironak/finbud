<?php
function diviner_enqueue_scripts() {

    wp_enqueue_script( 'jquery' );

    wp_enqueue_script( 'diviner-navigation', esc_url( get_template_directory_uri() ) . '/js/navigation.js', array(), DIVINER_VERSION, true );

    wp_enqueue_script( 'diviner-skip-link-focus-fix', esc_url( get_template_directory_uri() ) . '/js/skip-link-focus-fix.js', array(), DIVINER_VERSION, true );

    wp_enqueue_script( 'diviner-slider-js', esc_url( get_template_directory_uri() ) . '/js/jquery.bxslider.js', array('jquery') , DIVINER_VERSION, true );

    wp_enqueue_script( 'diviner-mobile-nav', esc_url( get_template_directory_uri() ) . '/js/bigSlide.js', array('jquery') , DIVINER_VERSION );

     wp_enqueue_script( 'diviner-sticky-sidebar-js', esc_url( get_template_directory_uri() ) . '/js/jquery.sticky-sidebar.js', array('jquery'), DIVINER_VERSION, true );

    wp_enqueue_script( 'diviner-lightbox-js', esc_url( get_template_directory_uri() ) . '/js/simple-lightbox.jquery.js', array('jquery') , DIVINER_VERSION );

    wp_enqueue_script( 'diviner-custom-js', esc_url( get_template_directory_uri() ) . '/js/custom.js', array('jquery', 'diviner-sticky-sidebar-js'), DIVINER_VERSION, true );

    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
      wp_enqueue_script( 'comment-reply' );
  }

  wp_localize_script(
	  'diviner-custom-js', 'diviner_params', array(
		  'sidebar_sticky'	=> diviner_sanitize_checkbox( get_theme_mod('diviner_sidebar_sticky', false ) )
	  )
  );
}
add_action('wp_enqueue_scripts', 'diviner_enqueue_scripts');