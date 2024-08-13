<?php

$group_general = array(
	'id' => 'general',
	'name' => __( 'General', 'wp-ultimate-post-grid' ),
	'icon' => 'cog',
	'subGroups' => array(
		array(
			'name' => __( 'Customize Link & Image', 'wp-ultimate-post-grid' ),
			'description' => __( 'You can set a custom link or image for every item in the grid by editing the individual post.', 'wp-ultimate-post-grid' ),
			'settings' => array(
				array(
					'id' => 'meta_box_post_types',
					'name' => __( 'Post Types', 'wp-ultimate-post-grid' ),
					'description' => __( 'Which post types do you want to enable this option for?', 'wp-ultimate-post-grid' ),
					'type' => 'dropdownMultiselect',
					'optionsCallback' => function() { return get_post_types( '', 'names' ); },
					'default' => array( 'post', 'page' ),
				),
				array(
					'id' => 'meta_box_taxonomies',
					'name' => __( 'Taxonomies', 'wp-ultimate-post-grid' ),
					'description' => __( 'Which taxonomies do you want to enable this option for?', 'wp-ultimate-post-grid' ),
					'type' => 'dropdownMultiselect',
					'optionsCallback' => function() { return get_taxonomies( '', 'names' ); },
					'default' => array( 'category', 'post_tag' ),
				),
			),
		),
		array(
			'name' => __( 'Compatibility', 'wp-ultimate-post-grid' ),
			'settings' => array(
				array(
					'id' => 'prevent_lazy_image_loading',
					'name' => __( 'Prevent Lazy Image Loading', 'wp-ultimate-post-grid' ),
					'description' => __( 'Enable to try to prevent lazy image loading for grid images, as that can mess with the grid layout.', 'wp-ultimate-post-grid' ),
					'type' => 'toggle',
					'default' => true,
				),
			),
		),
	),
);
