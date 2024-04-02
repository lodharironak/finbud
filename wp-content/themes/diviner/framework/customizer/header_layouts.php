<?php
/**
 *  Customizer Controls for Theme Header
 */

function diviner_customize_register_header_layouts( $wp_customize ) {

    // Header Panel
    $wp_customize->add_panel(
        'diviner_header_panel', array(
            'title'     =>  __('Header', 'diviner'),
            'priority'  =>  22
        )
    );


// Include 'Header Image' Section in Header Panel
    $wp_customize->get_section( 'header_image' )->panel     = 'diviner_header_panel';
    $wp_customize->get_section( 'header_image' )->priority  = 5;


// 'Header Settings' Section and its Controls
    $wp_customize->add_section(
        'diviner_header_settings', array(
            'title'         =>  __('Header Settings', 'diviner'),
            'description'   =>  __('<i>Header Settings for the theme</i>', 'diviner'),
            'priority'      =>  10,
            'panel'         =>  'diviner_header_panel'
        )
    );

    $wp_customize->add_setting(
        'diviner_ticker_enable', array(
            'default'   =>  1,
            'sanitize_callback' =>  'diviner_sanitize_checkbox'
        )
    );

    $wp_customize->add_control(
        'diviner_ticker_enable', array(
            'label'         =>  __('Enable the Date and Ticker Area', 'diviner'),
            'description'   =>  __('Works across the theme', 'diviner'),
            'type'          =>  'checkbox',
            'section'       =>  'diviner_header_settings',
            'priority'      =>  25
        )
    );

    $wp_customize->add_setting(
        'diviner_bg_parallax', array(
            'default'           =>  'scroll',
            'sanitize_callback' =>  'diviner_sanitize_radio'
        )
    );

    $wp_customize->add_control(
        'diviner_bg_parallax', array(
            'label' => __('Header Image Parallax', 'diviner'),
            'priority'  =>  30,
            'section'   =>  'diviner_header_settings',
            'type'      =>  'radio',
            'choices'       =>  array(
                'scroll'        =>  __('Normal Scroll', 'diviner'),
                'fixed'         =>  __('Fixed Image', 'diviner')
            )
        )
    );

    $wp_customize->add_setting(
        'diviner_default_header_height', array(
            'default'           => 500,
            'sanitize_callback' =>  'absint'
        )
    );

    $wp_customize->add_control(
        new Customizer_Range_Value_Control(
            $wp_customize, 'diviner_default_header_height', array(
             	'type'     => 'diviner-range-value',
             	'section'  => 'diviner_header_settings',
             	'settings' => 'diviner_default_header_height',
             	'label'    => __( 'Header Image Height', 'diviner' ),
                 'priority'  =>  35,
             	'input_attrs' => array(
             		'min'    => 300,
             		'max'    => 600,
             		'step'   => 10,
               	),
             )
         )
     );

    $wp_customize->add_setting(
        'diviner_full_header_nav_opacity', array(
            'default'           => 1,
            'sanitize_callback' =>  'diviner_sanitize_float'
        )
    );

    $wp_customize->add_control(
        new Customizer_Range_Value_Control(
            $wp_customize, 'diviner_full_header_nav_opacity', array(
             	'type'     => 'diviner-range-value',
             	'section'  => 'diviner_header_settings',
             	'settings' => 'diviner_full_header_nav_opacity',
             	'label'    => __( 'Navigation Opacity', 'diviner' ),
                'description'   => __('Background Opacity of the Navigation. This settings is for Full Window Header.', 'diviner'),
                 'priority'  =>  40,
             	'input_attrs' => array(
             		'min'    => 0,
             		'max'    => 1,
             		'step'   => .1,
               	),
             )
         )
     );

     $wp_customize->add_setting(
         'diviner_header_bg_size', array(
             'default'              =>  'cover',
             'sanitize_callback'    =>  'diviner_sanitize_radio'
         )
     );

     $wp_customize->add_control(
         'diviner_header_bg_size', array(
             'label'         =>  __('Header Background Size', 'diviner'),
             'section'       => 'diviner_header_settings',
             'priority'      =>  45,
             'type'          =>  'radio',
             'choices'       =>  array(
                 'cover'          =>  __('Cover', 'diviner'),
                 'contain'        =>  __('Contain', 'diviner')
             )
         )
     );

     $wp_customize->add_setting(
         'diviner_header_bg_position', array(
             'default'              =>  'center',
             'sanitize_callback'    =>  'diviner_sanitize_radio'
         )
     );

     $wp_customize->add_control(
         'diviner_header_bg_position', array(
             'label'         =>  __('Header Background Position', 'diviner'),
             'section'       => 'diviner_header_settings',
             'priority'      =>  45,
             'type'          =>  'radio',
             'choices'       =>  array(
                 'top'           =>  __('Top', 'diviner'),
                 'bottom'        =>  __('Bottom', 'diviner'),
                 'left'          =>  __('Left', 'diviner'),
                 'right'         =>  __('Right', 'diviner'),
                 'center'        =>  __('Center', 'diviner')
             )
         )
     );
     
     $wp_customize->add_setting(
	     'diviner_head_ad_widget_link', array(
		 	'default'	=> '',
		 	'sanitize_callback'	=>	'sanitize_text_field',
	     )
     );
     
    $wp_customize->add_control(
	     new Diviner_Custom_Link_Control(
		     $wp_customize, 'diviner_head_ad_widget_link', array(
			     'label'	=>	esc_html__('Go to Widget', 'diviner'),
			     'description'	=>	esc_html__('The advertisement image can be uploaded using \'Header Ad Area\' sidebar. Recommended dimension - 728 x 90', 'diviner'),
			     'type'		=>	'diviner-link',
			     'section'	=>	'diviner_header_settings',
			     'priority'	=>	50
		     )
	     )
     );

/*
        $wp_customize->add_setting(
            'diviner_ad_banner_url', array(
                'default'           =>  '',
                'sanitize_callback' =>  'esc_url_raw'
            )
        );

        $wp_customize->add_control(
            'diviner_ad_banner_url', array(
                'type'      =>'url',
                'label'     =>  __('Enter the Ad Banner URL', 'diviner'),
                'section'   =>  'diviner_header_settings',
                'priority'  =>  55,
            )
        );
*/

        $wp_customize->add_setting(
            'diviner_ad_header_img_enable', array(
                'default'               => '',
                'sanitize_callback'     =>  'diviner_sanitize_checkbox'
            )
        );

        $wp_customize->add_control(
            'diviner_ad_header_img_enable', array(
            'label'     =>  __('Enable Header Image for Ad Header', 'diviner'),
            'section'   =>  'diviner_header_settings',
            'type'      =>  'checkbox',
            'priority'  =>  60,
            )
        );


        //
        $wp_customize->add_section(
            'diviner_front_header_section', array(
                'title'     =>  __('Front Page', 'diviner'),
                'panel'     =>  'diviner_header_panel',
                'priority'  =>  10
            )
        );

        $wp_customize->add_setting(
            'diviner_front_header_layout_select', array(
                'default'           =>  'default',
                'sanitize_callback' =>  'diviner_sanitize_select'
            )
        );

        $wp_customize->add_control(
            'diviner_front_header_layout_select', array(
                'label'         =>  __('Header Layout', 'diviner'),
                'description'   =>  __('Select the Header Layout for the theme', 'diviner'),
                'section'       => 'diviner_front_header_section',
                'priority'      =>  25,
                'type'          =>  'select',
                'choices'       =>  array(
                    'default'        =>  __('Default Layout', 'diviner'),
                    'full'           =>  __('Full Screen Header', 'diviner'),
                    'simple'         =>  __('Header without Image', 'diviner'),
                    'ad'             =>  __('Header with Ad Support', 'diviner')
                )
            )
        );

    $wp_customize->add_section(
        'diviner_blog_header_section', array(
            'title'     =>  __('Blog Page', 'diviner'),
            'panel'     => 'diviner_header_panel',
            'priority'  => 20
        )
    );

    $wp_customize->add_setting(
        'diviner_header_layout_select', array(
            'default'           =>  'default',
            'sanitize_callback' =>  'diviner_sanitize_select'
        )
    );

    $wp_customize->add_control(
        'diviner_header_layout_select', array(
            'label'         =>  __('Header Layout', 'diviner'),
            'description'   =>  __('Select the Header Layout for the theme', 'diviner'),
            'section'       => 'diviner_blog_header_section',
            'priority'      =>  25,
            'type'          =>  'select',
            'choices'       =>  array(
                'default'        =>  __('Default Layout', 'diviner'),
                'full'           =>  __('Full Screen Header', 'diviner'),
                'simple'         =>  __('Header without Image', 'diviner'),
                'ad'             =>  __('Header with Ad Support', 'diviner')
            )
        )
    );



        // $header_controls    =   array_filter( array(
        //         $wp_customize->get_control( 'diviner_bg_parallax' ),
        //         $wp_customize->get_control( 'diviner_default_header_height' ),
        //         $wp_customize->get_control( 'diviner_full_header_nav_opacity'),
        //         $wp_customize->get_control( 'diviner_ad_banner'),
        //         $wp_customize->get_control( 'diviner_ad_banner_url')
        // ) );

        // foreach ( $header_controls as $control ) {
        //
        //     $control->active_callback = function( $control ) {
        //         $setting = $control->manager->get_setting( 'diviner_header_layout_select' );
        //
        //         switch ( $setting->value() ) {
        //             case "full":
        //                 return  $control->id == 'diviner_full_header_nav_opacity' ||
        //                         $control->id == 'diviner_bg_parallax';
        //                 break;
        //             case "simple":
        //                 return false;
        //                 break;
        //             case "ad":
        //                 return  $control->id == 'diviner_ad_banner' ||
        //                         $control->id == 'diviner_ad_banner_url';
        //                 break;
        //             default:
        //                 return  $control->id == 'diviner_default_header_height' ||
        //                         $control->id == 'diviner_bg_parallax';
        //         }
        //     };
        // }

    // $control    =   $wp_customize->get_control('diviner_full_header_nav_opacity');
    //
    // $control->active_callback = function( $control ) {
    //     $setting = $control->manager->get_setting( 'diviner_header_layout_select' );
    //     if ( 'full' == $setting->value() ) {
    //         return true;
    //     }
    //     else {
    //         return false;
    //     }
    // };
    //
    // $header_controls    =   array_filter( array(
    //     $wp_customize->get_control( 'diviner_default_header_height' ),
    //     $wp_customize->get_control( 'diviner_bg_parallax' ),
    // )   );
    // foreach ( $header_controls as $control ) {
    //     $control->active_callback = function( $control ) {
    //         $setting = $control->manager->get_setting( 'diviner_header_layout_select' );
    //         if ( 'simple' == $setting->value() ) {
    //             return false;
    //         } else {
    //             return true;
    //         }
    //     };
    // }
}
add_action('customize_register', 'diviner_customize_register_header_layouts');