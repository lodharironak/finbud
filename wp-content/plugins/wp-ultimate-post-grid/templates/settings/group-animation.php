<?php

$group_animation = array(
	'id' => 'animation',
	'name' => __( 'Animation', 'wp-ultimate-post-grid' ),
	'icon' => 'sliders',
	'subGroups' => array(
		array(
			'name' => __( 'Grid Animation', 'wp-ultimate-post-grid' ),
			'settings' => array(
				array(
					'id' => 'grid_container_animation_speed',
					'name' => __( 'Container Animation Speed', 'wp-ultimate-post-grid' ),
					'description' => __( 'Duration of the container height adjustment.', 'wp-ultimate-post-grid' ),
					'type' => 'number',
					'suffix' => __( 'milliseconds', 'wp-ultimate-post-grid' ),
					'default' => 800,
				),
				array(
					'id' => 'grid_animation_speed',
					'name' => __( 'Item Animation Speed', 'wp-ultimate-post-grid' ),
					'description' => __( 'Duration of the item animation.', 'wp-ultimate-post-grid' ),
					'type' => 'number',
					'suffix' => __( 'milliseconds', 'wp-ultimate-post-grid' ),
					'default' => 800,
				),
				array(
					'id' => 'grid_animation_show',
					'name' => __( 'Animation on Show', 'wp-ultimate-post-grid' ),
					'description' => __('Example', 'wp-ultimate-post-grid') . ': opacity: 1, transform: scale(1)',
					'type' => 'text',
					'default' => 'opacity: 1',
				),
				array(
					'id' => 'grid_animation_hide',
					'name' => __( 'Animation on Hide', 'wp-ultimate-post-grid' ),
					'description' => __('Example', 'wp-ultimate-post-grid') . ': opacity: 1, transform: scale(1)',
					'type' => 'text',
					'default' => 'opacity: 0',
				),
				array(
					'id' => 'grid_animation_stagger',
					'name' => __( 'Item Animation Delay', 'wp-ultimate-post-grid' ),
					'description' => __( 'Staggers item transitions, so items transition incrementally after one another.', 'wp-ultimate-post-grid' ),
					'type' => 'number',
					'suffix' => __( 'milliseconds', 'wp-ultimate-post-grid' ),
					'default' => 0,
				),
			),
		),
	),
);
