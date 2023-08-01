<?php
/**
 *	Customizer Controls for the Front Page
 */
 
 function diviner_front_page_customize_register( $wp_customize ) {
	 
	 
	$wp_customize->add_setting(
	    'diviner_front_template_not_set', array(
			'default'	=> '',
			'sanitize_callback'	=>	'sanitize_text_field',
	    )
    );

	 
	$wp_customize->add_control(
	     new Diviner_Custom_Text_Control(
		     $wp_customize, 'diviner_front_template_not_set', array(
			     'description'	=>	esc_html__('Looks like Front Page Template is not set for current page, set it in \'Edit Page\' area, come back and refresh the Customizer.', 'diviner'),
			     'type'		=>	'diviner-custom-text',
			     'section'	=>	'static_front_page',
			     'priority'	=>	11,
		     )
	     )
     );
     	 
	 $wp_customize->add_setting(
         'diviner_front_sidebar_align', array(
             'default'   => 'right',
             'sanitize_callback' =>  'diviner_sanitize_radio'
         )
     );

     $wp_customize->add_control(
         'diviner_front_sidebar_align', array(
             'label'        =>  __('Sidebar Alignment - Front Page', 'diviner'),
             'description'  =>  __('Layout Settings can be changed from \'Widgets\' Section.', 'diviner'),
             'section'      => 'static_front_page',
             'type'         => 'radio',
             'priority'     =>  12,
             'choices'      => array(
                 'right'       =>  __('Right Sidebar', 'diviner'),
                 'left'        =>  __('Left Sidebar', 'diviner')
             )
         )
     );
     
     $wp_customize->add_setting(
	     'diviner_front_page_widget_link', array(
		 	'default'	=> '',
		 	'sanitize_callback'	=>	'sanitize_text_field',
	     )
     );
     
     $wp_customize->add_control(
	     new Diviner_Custom_Link_Control(
		     $wp_customize, 'diviner_front_page_widget_link', array(
			     'label'	=>	esc_html__('Go to Widgets', 'diviner'),
			     'description'	=>	esc_html__('The Content on Front Page is controlled using widgets. You can change it in Widgets section.', 'diviner'),
			     'type'		=>	'diviner-link',
			     'section'	=>	'static_front_page',
			     'priority'	=>	25,
			     'input_attrs'	=>	array(
				     'class'	=>	'custom_link'
			    )
		    )
	    )
    );
    
    
    $front_page_controls = array_filter( array(
        $wp_customize->get_control( 'diviner_front_template_not_set' ),
        $wp_customize->get_control( 'diviner_front_sidebar_align' ),
        $wp_customize->get_control( 'diviner_front_page_widget_link' ),
    ) );
  
    
    foreach( $front_page_controls as $control ) {
	    $control->active_callback = function( $control ) {
		    
		    $show_on_front = $control->manager->get_setting( 'show_on_front' );
            $page_on_front = $control->manager->get_setting( 'page_on_front' );
            $template_slug	=	get_page_template_slug( $page_on_front->value() );
            
            if ( 'posts' === $show_on_front->value() ) {
	            return false;
            } else {
	            if ( empty($template_slug) ) {
		            return $control->id == 'diviner_front_template_not_set';
	            } else {
		            return	$control->id == 'diviner_front_sidebar_align' ||
		            		$control->id == 'diviner_front_page_widget_link';
	            }
            }
        };
    }
	
    
    
    
 }
 
add_action('customize_register', 'diviner_front_page_customize_register');