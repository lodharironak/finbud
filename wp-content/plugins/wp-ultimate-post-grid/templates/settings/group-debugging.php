<?php

$group_debugging = array(
	'id' => 'debugging',
	'name' => __( 'Debugging', 'wp-ultimate-post-grid' ),
	'icon' => 'search',
	'settings' => array(
		array(
			'id' => 'enable_debug_messages',
			'name' => __( 'Enable Debug Messages', 'wp-ultimate-post-grid' ),
			'description' => __( 'When enabled the plugin will output debug messages in the JavaScript console.', 'wp-ultimate-post-grid' ),
			'type' => 'toggle',
			'code' => 'css',
			'default' => false,
		),
	),
);
