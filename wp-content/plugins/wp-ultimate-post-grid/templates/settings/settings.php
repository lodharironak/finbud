<?php
/**
 * Template for the plugin settings structure.
 *
 * @link       https://bootstrapped.ventures
 * @since      3.0.0
 *
 * @package    WP_Ultimate_Post_Grid
 * @subpackage WP_Ultimate_Post_Grid/templates/settings
 */

require_once 'group-general.php';
require_once 'group-layout.php';
require_once 'group-animation.php';
require_once 'group-permissions.php';
require_once 'group-custom-code.php';
require_once 'group-debugging.php';

$settings_structure = array(
	array(
		'id'            => 'documentation',
		'name'          => __( 'Documentation', 'wp-ultimate-post-grid' ),
		'description'   => __( 'All documentation can be found in our Knowledge Base.', 'wp-ultimate-post-grid' ),
		'documentation' => 'https://help.bootstrapped.ventures/collection/7-wp-ultimate-post-grid',
		'icon'          => 'support',
	),
	$group_general,
	$group_layout,
	$group_animation,
	array( 'header' => __( 'Advanced', 'wp-ultimate-post-grid' ) ),
	$group_permissions,
	$group_custom_code,
	$group_debugging,
);
