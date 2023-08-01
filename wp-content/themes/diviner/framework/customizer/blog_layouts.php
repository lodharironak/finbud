<?php
/**
 *  Customzier Controls for Blog Layouts in the theme
 */

 function diviner_customize_register_blog_layouts( $wp_customize ) {

   $wp_customize->add_section(
     'diviner_layout_section', array(
       'title'          => esc_html__('Blog Page', 'diviner'),
       'description'    => esc_html__('Controls for the Blog Page in the theme', 'diviner'),
       'priority'       => 25
     )
   );

   $wp_customize->add_setting(
       'diviner_blog_title', array(
           'default'            =>  '',
           'sanitize_callback'  =>  'sanitize_text_field'
       )
   );

   $wp_customize->add_control(
       'diviner_blog_title', array(
           'label'          =>  esc_html__('Blog Page Title', 'diviner'),
           'description'    =>  esc_html__('Will be disabled if left empty', 'diviner'),
           'type'           =>  'text',
           'section'        =>  'diviner_layout_section',
           'priority'       =>  '2'
       )
   );

   $wp_customize->add_setting(
       'diviner_excerpt_length', array(
           'default'    => 30,
           'sanitize_callback'  => 'absint'
       )
   );

   $wp_customize->add_control(
       'diviner_excerpt_length', array(
           'label'  => esc_html__('Length of excerpt for blog (Default - 30)', 'diviner'),
           'description'    => esc_html__('Works only if post doesn\'t have a Custom excerpt', 'diviner'),
           'priority'       => 3,
           'section'        => 'diviner_layout_section',
           'type'           => 'number'
       )
   );

   $wp_customize->add_setting(
     'diviner_select_layout', array(
       'default'  => 'blog',
       'sanitize_callback'  => 'diviner_sanitize_select',
     )
   );

   $wp_customize->add_control(
     'diviner_select_layout',
     array(
       'label'  => esc_html__('Select the Layout for the Blog Page', 'diviner'),
       'type'   => 'select',
       'section'  =>  'diviner_layout_section',
       'Priority' => 5,
       'choices'  => array(
         'blog'     => esc_html__('1 Column', 'diviner'),
         'blog_s'   => esc_html__('1 Column + Sidebar', 'diviner'),
         'col2'     => esc_html__('2 Columns', 'diviner'),
         'col2_s'   => esc_html__('2 Columns + Sidebar', 'diviner'),
         'grid2'    => esc_html__('2 Column Photography Grid', 'diviner'),
         'grid2_s'  => esc_html__('2 Column Photography Grid + Sidebar', 'diviner'),
         'grid3'    => esc_html__('3 Column Photography Grid', 'diviner'),
         'grid3_s'  => esc_html__('3 Column Photography Grid + Sidebar', 'diviner')
       )
     )
   );
   
   $wp_customize->add_setting(
         'diviner_blog_sidebar_align', array(
             'default'   => 'right',
             'sanitize_callback' =>  'diviner_sanitize_radio'
         )
     );

     $wp_customize->add_control(
         'diviner_blog_sidebar_align', array(
             'label'        =>  esc_html__('Sidebar Alignment - Blog Page', 'diviner'),
             'section'      => 'diviner_layout_section',
             'type'         => 'radio',
             'priority'     =>  15,
             'choices'      => array(
                 'right'        =>  esc_html__('Right Sidebar', 'diviner'),
                 'left'         => esc_html__('Left Sidebar', 'diviner')
             )
         )
     );


    $sidebar_controls = array_filter( array(
        $wp_customize->get_control( 'diviner_blog_sidebar_align' ),
    ) );
    foreach ( $sidebar_controls as $control ) {
        $control->active_callback = function( $control ) {
            $setting = $control->manager->get_setting( 'diviner_select_layout' );
            if ( strpos( $setting->value(), '_s' ) ) {
                return true;
            } else {
                return false;
            }
        };
    }
 }
 add_action('customize_register','diviner_customize_register_blog_layouts');