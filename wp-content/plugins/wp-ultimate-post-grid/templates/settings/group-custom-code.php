<?php

$group_custom_code = array(
	'id' => 'custom_code',
	'name' => __( 'Custom Code', 'wp-ultimate-post-grid' ),
	'icon' => 'code',
	'settings' => array(
		array(
			'id' => 'public_css',
			'name' => __( 'Public CSS', 'wp-ultimate-post-grid' ),
			'description' => __( 'This custom styling will be output on your website.', 'wp-ultimate-post-grid' ),
			'type' => 'code',
			'code' => 'css',
			'default' => '',
		),
	),
);
