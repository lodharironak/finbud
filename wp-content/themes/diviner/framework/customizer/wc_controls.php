<?php
/**
 *  Customizer Controls for WooCommerce Section
 */

if ( class_exists('woocommerce') ) {

    function diviner_wc_controls_register( $wp_customize ) {
        $wp_customize->add_section(
            'diviner_wc_section', array(
                'title'		=>  esc_html__('Custom Settings', 'diviner'),
                'panel'		=>	'woocommerce',
                'priority'	=>  35
            )
       );

       $wp_customize->add_setting(
           'diviner_wc_sidebar_layout', array(
               'default'               => 'col_s',
               'sanitize_callback'    => 'diviner_sanitize_select'
           )
       );

       $wp_customize->add_control(
           'diviner_wc_sidebar_layout', array(
               'label'    => esc_html__('Sidebar Layout for Product Archive Pages', 'diviner'),
               'type'     => 'select',
               'section'  => 'diviner_wc_section',
               'priority' =>  20,
               'choices'  => array(
                   'col_s'    =>  esc_html__('Content + Sidebar', 'diviner'),
                   'col'      => esc_html__('No Sidebar', 'diviner')
               )
           )
       );

       $wp_customize->add_setting(
           'diviner_wc_sidebar_align', array(
               'default'              => 'right',
               'sanitize_callback'    =>  'diviner_sanitize_radio'
           )
       );

       $wp_customize->add_control(
           'diviner_wc_sidebar_align', array(
               'label'         =>  esc_html__('Sidebar Alignment - WooCommerce', 'diviner'),
               'description'   =>  esc_html__('Works for the all WooCommerce Section','diviner'),
                   'section'   => 'diviner_wc_section',
                   'type'      => 'radio',
                   'priority'  =>  25,
                   'choices'   => array(
                       'right'     =>  esc_html__('Right Sidebar', 'diviner'),
                       'left'      => esc_html__('Left Sidebar', 'diviner')
               )
           )
       );
    }
    add_action('customize_register', 'diviner_wc_controls_register');
}