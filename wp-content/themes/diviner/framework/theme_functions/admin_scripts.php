<?php
  function diviner_customize_controls_js() {

    wp_enqueue_script( 'diviner-extend-customizer', get_theme_file_uri( '/js/customize_controls.js' ), array(), DIVINER_VERSION, true );
    
  }
  add_action( 'customize_controls_enqueue_scripts', 'diviner_customize_controls_js' );