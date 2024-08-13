<?php

$group_layout = array(
	'id' => 'layout',
	'name' => __( 'Layout', 'wp-ultimate-post-grid' ),
	'icon' => 'brush',
	'subGroups' => array(
		array(
			'name' => __( 'Breakpoints', 'wp-ultimate-post-grid' ),
			'settings' => array(
				array(
					'id' => 'breakpoint_tablet',
					'name' => __( 'Tablet Breakpoint', 'wp-ultimate-post-grid' ),
					'description' => __( 'If the screen size is smaller than this, the tablet (or mobile) layout will be shown.', 'wp-ultimate-post-grid' ),
					'type' => 'number',
					'default' => 800,
				),
				array(
					'id' => 'breakpoint_mobile',
					'name' => __( 'Mobile Breakpoint', 'wp-ultimate-post-grid' ),
					'description' => __( 'If the screen size is smaller than this, the mobile layout will be shown.', 'wp-ultimate-post-grid' ),
					'type' => 'number',
					'default' => 400,
				),
			),
		),
	),
);
