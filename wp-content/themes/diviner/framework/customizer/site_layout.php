<?php
/**
 *  Customizer Controls for Site layout Section
 */

 function diviner_site_layout_control( $wp_customize ) {

     $wp_customize->add_section(
         'diviner_site_layout_section', array(
             'title'    =>  esc_html__('Site Layout', 'diviner' ),
             'priority' =>  15
         )
     );

     $wp_customize->add_setting(
         'diviner_site_layout', array(
             'default'  =>  'box',
             'sanitize_callback'    =>  'diviner_sanitize_select'
         )
     );

     $wp_customize->add_control(
         'diviner_site_layout', array(
             'label'    =>  esc_html__('Site Layout', 'diviner'),
             'type'     =>  'select',
             'section'  =>  'diviner_site_layout_section',
             'choices'  =>  array(
                    'box'   => esc_html__('Boxed Layout', 'diviner'),
                    'full'  => esc_html__('Full Width Layout', 'diviner')
             )
         )
     );
 }

 add_action('customize_register', 'diviner_site_layout_control');