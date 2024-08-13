<?php

$group_permissions = array(
	'id' => 'permissions',
	'name' => __( 'Permissions', 'wp-ultimate-post-grid' ),
	'description' => __( 'Accepts one value only. Set the minimum capability required to access specific features. For example, set to edit_others_posts to provide access to editors and administrators.', 'wp-ultimate-post-grid' ),
	'documentation' => 'https://codex.wordpress.org/Roles_and_Capabilities',
	'icon' => 'lock',
	'settings' => array(
		array(
			'id' => 'features_manage_access',
			'name' => __( 'Access to Manage Page', 'wp-ultimate-post-grid' ),
			'type' => 'text',
			'default' => 'manage_options',
			'sanitize' => function( $value ) {
				return preg_replace( '/[,\s]/', '', $value );
			},
		),
	),
);
