<?php
	/**
	 *
	 *	Customizer Controls for Single Post Page
	 *
	 */
	 
	 function diviner_single_post_customize_register( $wp_customize ) {
		 
		 $wp_customize->add_section(
			 'diviner_single_post_section', array(
				 'title'		=>	__('Single Post Page', 'diviner'),
				 'description'	=>	__('Controls for Single Post Page', 'diviner'),
				 'priority'		=>	27,
			 )
		 );
		 
		$wp_customize->add_setting(
			'diviner_post_sidebar_layout', array(
				 'default'               => 'col_s',
				 'sanitize_callback'    => 'diviner_sanitize_radio'
			)
		);
		 
		 $wp_customize->add_control(
	         'diviner_post_sidebar_layout', array(
	             'label'    => esc_html__('Sidebar Layout for Single Posts', 'diviner'),
	             'type'     => 'select',
	             'section'  => 'diviner_single_post_section',
	             'priority' =>  20,
	             'choices'  => array(
	                 'col_s'    =>  esc_html__('Content + Sidebar', 'diviner'),
	                 'col'      => esc_html__('No Sidebar', 'diviner')
	             )
	         )
	     );
	
	     $wp_customize->add_setting(
	         'diviner_single_sidebar_align', array(
	             'default'              => 'right',
	             'sanitize_callback'    =>  'diviner_sanitize_radio'
	         )
	     );
	
	     $wp_customize->add_control(
	         'diviner_single_sidebar_align', array(
	             'label'     =>  esc_html__('Sidebar Alignment - Posts', 'diviner'),
	             'section'   => 'diviner_single_post_section',
	             'type'      => 'radio',
	             'priority'  =>  25,
	             'choices'   => array(
	                 'right'     =>  esc_html__('Right Sidebar', 'diviner'),
	                 'left'      => esc_html__('Left Sidebar', 'diviner')
	             )
	         )
	     );
	}
	add_action('customize_register', 'diviner_single_post_customize_register');