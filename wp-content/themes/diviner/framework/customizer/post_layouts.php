<?php
/**
 *  Controls for Single Post Layout
 */

 function diviner_post_layouts( $wp_customize ) {

     $wp_customize->add_section(
         'diviner_post_layout', array(
             'title'    => esc_html__('Post Layout Settings', 'diviner'),
             'priority' => 30
         )
     );

 }
 add_action('customize_register', 'diviner_post_layouts');