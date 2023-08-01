<?php
/**
 *  Customizer File for all the sanitization functions
 */


 function diviner_sanitize_text( $input ) {
     return wp_kses_post( force_balance_tags( $input ) );
 }


 function diviner_sanitize_checkbox( $input ) {
     if ( $input == 1 ) {
         return 1;
     } else {
         return '';
     }
 }


 function diviner_sanitize_float( $number, $setting ) {

    $atts = $setting->manager->get_control( $setting->id )->input_attrs;
    $min = ( isset( $atts['min'] ) ? $atts['min'] : $number );
    $max = ( isset( $atts['max'] ) ? $atts['max'] : $number );
    $step = ( isset( $atts['step'] ) ? $atts['step'] : 0.1 );
    $number = floor($number / $atts['step']) * $atts['step'];
    return ( $min <= $number && $number <= $max ) ? $number : $setting->default;
 }


 function diviner_sanitize_select( $input, $setting ){

        //input must be a slug: lowercase alphanumeric characters, dashes and underscores are allowed only
        $input = sanitize_key($input);

        //get the list of possible select options
        $choices = $setting->manager->get_control( $setting->id )->choices;

        //return input if valid or return default option
        return ( array_key_exists( $input, $choices ) ? $input : $setting->default );

    }


 function diviner_sanitize_radio( $input, $setting ) {

 	// Ensure input is a slug
 	$input = sanitize_key( $input );

 	// Get list of choices from the control
 	// associated with the setting
 	$choices = $setting->manager->get_control( $setting->id )->choices;

 	// If the input is a valid key, return it;
 	// otherwise, return the default
 	return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
 }
 
 
 function diviner_sanitize_link( $input ) {
	 $input = wp_kses( $input, array(
						'a' => array(
							'href'	=>	array(),
							'class'	=>	array()
						),
						'div'	=>	array(
							'id'	=>	array()
						),
						'label'		=>	array(),
						'p'			=>	array()
					) 
				);
				
	return $input;
 }


 function diviner_sanitize_category( $input ) {
     if ( term_exists(get_cat_name( $input ), 'category') )
         return $input;
     else
         return '';
 }