<?php
function diviner_customize_register_social( $wp_customize ) {
		// Social Icons
	$wp_customize->add_section('diviner_social_section', array(
			'title' 	=> esc_html__('Social Icons','diviner'),
			'priority' 	=> 44 ,
	));

	$social_networks = array( //Redefinied in Sanitization Function.
					'none' 			=> esc_html__('-','diviner'),
					'facebook-f' 	=> esc_html__('Facebook','diviner'),
					'twitter' 		=> esc_html__('Twitter','diviner'),
					'instagram' 	=> esc_html__('Instagram','diviner'),
					'rss' 			=> esc_html__('RSS Feeds','diviner'),
					'pinterest-p' 	=> esc_html__('Pinterest','diviner'),
					'vimeo-square' 	=> esc_html__('Vimeo','diviner'),
					'youtube' 		=> esc_html__('Youtube','diviner'),
					'flickr' 		=> esc_html__('Flickr','diviner'),
				);


    $social_count = count($social_networks);

	for ($x = 1 ; $x <= ($social_count - 3) ; $x++) :

		$wp_customize->add_setting(
			'diviner_social_'.$x, array(
				'sanitize_callback' => 'diviner_sanitize_social',
				'default' 			=> 'none',
				'transport'			=> 'postMessage'
			));

		$wp_customize->add_control( 'diviner_social_'.$x, array(
					'settings' 	=> 'diviner_social_'.$x,
					'label' 	=> esc_html__('Icon ','diviner').$x,
					'section' 	=> 'diviner_social_section',
					'type' 		=> 'select',
					'choices' 	=> $social_networks,
		));

		$wp_customize->add_setting(
			'diviner_social_url'.$x, array(
				'sanitize_callback' => 'esc_url_raw'
			));

		$wp_customize->add_control( 'diviner_social_url'.$x, array(
					'settings' 		=> 'diviner_social_url'.$x,
					'description' 	=> esc_html__('Icon ','diviner').$x.__(' Url','diviner'),
					'section' 		=> 'diviner_social_section',
					'type' 			=> 'url',
					'choices' 		=> $social_networks,
		));

	endfor;

	function diviner_sanitize_social( $input ) {
		$social_networks = array(
					'none' ,
					'facebook-f',
					'twitter',
					'instagram',
					'rss',
					'pinterest-p',
					'vimeo-square',
					'youtube',
					'flickr'
				);
		if ( in_array($input, $social_networks) )
			return $input;
		else
			return 'diviner';
	}
}
add_action( 'customize_register', 'diviner_customize_register_social' );