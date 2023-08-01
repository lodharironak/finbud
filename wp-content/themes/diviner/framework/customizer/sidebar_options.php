<?php
/**
 *  Customizer Controls for Theme Sidebar
 */

 function diviner_customize_register_sidebar( $wp_customize ) {

     $wp_customize->add_section(
         'diviner_sidebar_section', array(
             'title'    =>  esc_html__('Sidebar', 'diviner'),
             'description'	=>	__('General Sidebar Settings', 'diviner'),
             'priority' =>  28
         )
    );

    $wp_customize->add_setting(
        'diviner_sidebar_width', array(
            'default'    =>  25,
            'sanitize_callback'  =>  'absint'
        )
    );

    $wp_customize->add_control(
        new Customizer_Range_Value_Control(
            $wp_customize, 'diviner_sidebar_width', array(
             	'type'          => 'diviner-range-value',
             	'section'       => 'diviner_sidebar_section',
             	'settings'      => 'diviner_sidebar_width',
             	'label'         => esc_html__( 'Sidebar Width', 'diviner' ),
                'description'   =>  esc_html__('This setting works throughout the theme', 'diviner'),
                 'priority'     =>  5,
             	'input_attrs'   => array(
             		'min'            => 25,
             		'max'            => 40,
             		'step'           => 1,
             		'suffix'         => '%', //optional suffix
               	),
             )
         )
     );
     
     $wp_customize->add_setting(
	     'diviner_sidebar_sticky', array(
		     'default'				=>	'',
		     'sanitize_callback'	=>	'diviner_sanitize_checkbox'
	     )
     );
     
     $wp_customize->add_control(
	     'diviner_sidebar_sticky', array(
		     'label'		=>	__('Make Sidebars sticky', 'diviner' ),
		     'description'	=>	__('This setting will work throughout theme', 'diviner'),
		     'type'			=>	'checkbox',
		     'section'		=>	'diviner_sidebar_section',
	     )
     );
 }
 add_action('customize_register', 'diviner_customize_register_sidebar');