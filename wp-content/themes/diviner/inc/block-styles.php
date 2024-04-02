<?php
/**
 *	Custom Styles for Gutenberg core blocks
 */
 
function diviner_register_block_styles() {
	 
	wp_enqueue_script('diviner-block-styles', get_template_directory_uri() . '/js/block-styles.js', array('wp-blocks', 'wp-dom-ready', 'wp-edit-post', 'wp-i18n', 'wp-hooks'), DIVINER_VERSION );
 
}
add_action('enqueue_block_editor_assets', 'diviner_register_block_styles');