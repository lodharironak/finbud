<?php
/**
 * Migration to the new settings system.
 *
 * @link       https://bootstrapped.ventures
 * @since      3.0.0
 *
 * @package    WP_Ultimate_Post_Grid
 * @subpackage WP_Ultimate_Post_Grid/includes/public/migrations
 */

// Migrate settings.
$old = get_option( 'wpupg_option', array() );

$settings = array();

// Simple.
if ( isset( $old['grid_animation_show'] ) ) { $settings['grid_animation_show'] = $old['grid_animation_show']; }
if ( isset( $old['grid_animation_hide'] ) ) { $settings['grid_animation_hide'] = $old['grid_animation_hide']; }
if ( isset( $old['custom_code_public_css'] ) ) { $settings['public_css'] = $old['custom_code_public_css']; }

// Seconds to milliseconds.
if ( isset( $old['grid_container_animation_speed'] ) ) {
    $settings['grid_container_animation_speed'] = 1000 * floatval( $old['grid_container_animation_speed'] ); 
}
if ( isset( $old['grid_animation_speed'] ) ) {
    $settings['grid_animation_speed'] = 1000 * floatval( $old['grid_animation_speed'] ); 
}

// Meta Box setting.
if ( isset( $old['meta_box_hide'] ) ) {
    $post_types = get_post_types( '', 'objects' );

    unset( $post_types[WPUPG_POST_TYPE] );
    unset( $post_types['revision'] );
    unset( $post_types['nav_menu_item'] );

    foreach ( $old['meta_box_hide'] as $post_type ) {
        unset( $post_types[ $post_type ] );
    }

    $settings['meta_box_post_types'] = array_keys( $post_types );
}

WPUPG_Settings::update_settings( $settings );