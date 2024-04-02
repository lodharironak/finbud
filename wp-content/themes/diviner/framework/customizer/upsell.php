<?php
/**
 *	Upsell Section in Customizer
**/

function diviner_upsell_customize_register( $wp_customize ) {
	
	$wp_customize->add_section(
		'diviner_upsell_pro', array(
			'title'		=>	__('Need More Features?', 'diviner'),
			'description'	=>	__('Liked Diviner and feel like you could do with a lot more features and functionality, give <b>Diviner Pro</b> a shot!', 'diviner'),
			'priority'	=>	60
		)
	);
	
	$wp_customize->add_setting(
		'diviner_upsell_pro_text', array(
			'default'			=>	'',
			'sanitize_callback'	=>	'sanitize_text_field'
		)
	);
	
	$wp_customize->add_control(
		new Diviner_Custom_Text_Control(
			$wp_customize, 'diviner_upsell_pro_text', array(
				'description'	=>	__('<h2>Features</h2><b>A lot more Features</b><br><br><b>More Custom Widgets<br></b><br><b>More Headers</b><br><br><b>Max Mega Menu Readiness</b><br><br><b>WooCommerce Readiness</b><br><br><b>and a lot more...</b>', 'diviner'),
				'section'	=>	'diviner_upsell_pro',
				'priority'	=>	10
			)
		)
	);
	
	$wp_customize->add_setting(
		'diviner_upsell_pro_button', array(
			'default'	=>	'',
			'sanitize_callback'	=>	'sanitize_text_field'
		)
	);
	
	$wp_customize->add_control(
		new Diviner_Upsell_Pro_Control(
			$wp_customize, 'diviner_upsell_pro_button', array(
				'type'		=>	'diviner-upsell-pro',
				'section'	=>	'diviner_upsell_pro',
				'priority'	=>	20
			)
		)
	);
	
	$wp_customize->add_section(
		'diviner_upsell_section', array(
			'title'		=>	__('Theme Docs', 'diviner'),
			'priority'	=>	35
		)
	);
	
	$wp_customize->add_setting(
	     'diviner_upsell_area', array(
		 	'default'	=> '',
		 	'sanitize_callback'	=>	'sanitize_text_field',
	     )
     );
     
     $wp_customize->add_control(
	     new Diviner_Upsell_Links_Control(
		     $wp_customize, 'diviner_upsell_area', array(
			     'type'		=>	'diviner-upsell',
			     'section'	=>	'diviner_upsell_section',
			     'priority'	=>	25
		     )
	     )
     );
}
add_action('customize_register', 'diviner_upsell_customize_register');