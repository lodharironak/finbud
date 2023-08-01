<?php

function diviner_customize_register_fp( $wp_customize ) {

    $wp_customize->add_section(
        'diviner_featposts',
        array(
            'title'     => esc_html__('Featured Posts Area','diviner'),
            'priority'  => 10,
        )
    );

    $wp_customize->add_setting(
            'diviner_featposts_heading',
            array(
                'sanitize_callback' => 'diviner_sanitize_text'
        )
    );

    $wp_customize->add_control(
        'adivos_featposts_heading',
        array(
            'settings' => 'diviner_featposts_heading',
            'section' => 'diviner_featposts',
            'label' => esc_html__('Heading For Featured Category', 'diviner'),
            'type' => 'text',
            'priority'	=> 5
        )
    );

    $wp_customize->add_setting(
        'diviner_featposts_enable',
        array(
            'sanitize_callback' => 'diviner_sanitize_checkbox',
            'default' => false
        )
    );

    $wp_customize->add_control(
        'diviner_featposts_enable',
        array(
            'label'     =>  esc_html__('Enable on Blog Page', 'diviner'),
            'section'   =>  'diviner_featposts',
            'priority'  =>  10,
            'type'      =>  'checkbox'
        )
    );

    $wp_customize->add_setting(
        'diviner_featposts_enable_front',
        array(
            'sanitize_callback' => 'diviner_sanitize_checkbox',
            'default' => false
        )
    );

    $wp_customize->add_control(
        'diviner_featposts_enable_front',
        array(
            'label'     =>  esc_html__('Enable on Front Page', 'diviner'),
            'section'   =>  'diviner_featposts',
            'priority'  =>  15,
            'type'      =>  'checkbox'
        )
    );

    $wp_customize->add_setting(
        'diviner_featposts_cat',
        array( 'sanitize_callback' => 'diviner_sanitize_category' )
    );

    $wp_customize->add_control(
        new Diviner_WP_Customize_Category_Control(
            $wp_customize,
            'diviner_featposts_cat',
            array(
                'label'    => esc_html__('Select the Category','diviner'),
                'settings' => 'diviner_featposts_cat',
                'section'  => 'diviner_featposts',
                'priority'	=> 20
            )
        )
    );
}
add_action( 'customize_register', 'diviner_customize_register_fp', 15 );