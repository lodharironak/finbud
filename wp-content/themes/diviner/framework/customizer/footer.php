<?php
/**
 *  Customizer Section for Footer
 */

 function diviner_customize_register_footer( $wp_customize ) {

     $wp_customize->add_section(
         'diviner_footer_section', array(
             'title'    => esc_html__('Footer', 'diviner'),
             'priority' => 30,
         )
     );

     $wp_customize->add_setting(
         'diviner_footer_cols', array(
             'default'  => 4,
             'sanitize_callback'    => 'absint'
         )
     );

     $wp_customize->add_control(
         'diviner_footer_cols', array(
             'label'    =>  esc_html__('Select the number of Footer Columns', 'diviner'),
             'section'  =>  'diviner_footer_section',
             'priority' => 5,
             'type'     => 'select',
             'choices'  =>  array(
                 1  => esc_html__('One Column', 'diviner'),
                 2  => esc_html__('Two Columns', 'diviner'),
                 3  => esc_html__('Three Columns', 'diviner'),
                 4  => esc_html__('Four Columns', 'diviner'),
             )
         )
     );

     $wp_customize->add_setting(
         'diviner_footer_text', array(
             'default'  => '',
             'sanitize_callback'    =>  'sanitize_text_field'
         )
     );

     $wp_customize->add_control(
         'diviner_footer_text', array(
             'label'    =>  esc_html__('Custom Footer Text', 'diviner'),
             'description'  =>  esc_html__('Will show Default Text if empty', 'diviner'),
             'priority' =>  10,
             'type'     =>  'text',
             'section'  => 'diviner_footer_section'
         )
     );
 }
 add_action('customize_register', 'diviner_customize_register_footer');