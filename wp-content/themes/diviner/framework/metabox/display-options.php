<?php
/**
 * Adds a meta box to the post editing screen
 */
function diviner_custom_meta() {
    add_meta_box( 'diviner_meta', esc_html__( 'Display Options', 'diviner' ), 'diviner_meta_callback', 'page','side','high' );
}
add_action( 'add_meta_boxes', 'diviner_custom_meta' );

/**
 * Outputs the content of the meta box
 */

function diviner_meta_callback( $post ) {
    wp_nonce_field( basename( __FILE__ ), 'diviner_nonce' );

    $defaults = array(
        'hide-sidebar'  =>  [''],
        'align-sidebar' =>  ['right'],
        'page-head'     =>  ['default'],
    );

    $diviner_stored_meta = wp_parse_args( get_post_meta( $post->ID ), $defaults );

    ?>

    <p>
	    <div class="diviner-row-content">

		    <p><i><?php _e('These settings will not work if Page is Set as Static Front Page or', 'diviner') ?></i></p>
            <p><i><?php _e('In that case, use Customizer to customize the Static Front Page', 'diviner') ?></i></p>


		    <label for="hide-sidebar">
                <strong><?php _e( 'Hide the Sidebar', 'diviner' ) ?></strong>
	            <input type="checkbox" name="hide-sidebar" id="hide-sidebar" value="yes" <?php if ( isset ( $diviner_stored_meta['hide-sidebar'] ) ) checked( $diviner_stored_meta['hide-sidebar'][0], 'yes' ); ?> />
                <p><em><?php _e('Will not work in Elementor Template', 'diviner'); ?></em></p>
	        </label>
	        <br />

            <p>
                <h4> <?php _e('Sidebar Alignment', 'diviner'); ?></h4>
                <p><em><?php _e('Will not work in Elementor Template', 'diviner'); ?></em></p>
                <label for="align-sidebar">
					<input type="radio" name="align-sidebar" value="left" <?php if ( isset( $diviner_stored_meta['align-sidebar'] ) ) checked( $diviner_stored_meta['align-sidebar'][0], 'left' ); ?>>
					<?php esc_attr_e( 'Left Sidebar', 'diviner' ); ?>
				</label>
                <br/>
                <br/>
				<label for="align-sidebar">
					<input type="radio" name="align-sidebar" value="right" <?php if ( isset( $diviner_stored_meta['align-sidebar'] ) ) checked( $diviner_stored_meta['align-sidebar'][0], 'right' ); ?>>
					<?php esc_attr_e( 'Right Sidebar', 'diviner' ); ?>
				</label>
			</p>

	        <br />
            <label for="page-head">
            	<p><strong><?php _e('Select the header for the page', 'diviner') ?></strong></p>
            	<select name="page-head" id="page-header">
	            	<option value="default" <?php if ( isset ( $diviner_stored_meta['page-head'] ) ) selected($diviner_stored_meta['page-head'][0], 'default'); ?>><?php _e('Default Header', 'diviner'); ?></option>
	            	<option value="full" <?php if ( isset ( $diviner_stored_meta['page-head'] ) ) selected($diviner_stored_meta['page-head'][0], 'full'); ?> ><?php _e('Full Window Header', 'diviner'); ?></option>
	            	<option value="simple" <?php if ( isset ( $diviner_stored_meta['page-head'] ) ) selected($diviner_stored_meta['page-head'][0], 'simple'); ?> ><?php _e('Simple Header', 'diviner'); ?></option>
                    <option value="ad" <?php if ( isset ( $diviner_stored_meta['page-head'] ) ) selected($diviner_stored_meta['page-head'][0], 'ad'); ?> ><?php _e('Header with Ad Support', 'diviner'); ?></option>
            	</select>
            </label>

	    </div>
	</p>

    <?php
}


/**
 * Saves the custom meta input
 */
function diviner_meta_save( $post_id ) {

    // Checks save status
    $is_autosave = wp_is_post_autosave( $post_id );
    $is_revision = wp_is_post_revision( $post_id );
    $is_valid_nonce = ( isset( $_POST[ 'diviner_nonce' ] ) && wp_verify_nonce( $_POST[ 'diviner_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';

    // Exits script depending on save status
    if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
        return;
    }

    // Checks for input and saves
	if ( array_key_exists('hide-sidebar', $_POST) ) {
	    update_post_meta( $post_id, 'hide-sidebar', 'yes' );
	}
    else {
	    update_post_meta( $post_id, 'hide-sidebar', '' );
	}

	// Checks for input and saves
	if ( array_key_exists('align-sidebar', $_POST) ) {
	    update_post_meta( $post_id, 'align-sidebar', sanitize_text_field( $_POST['align-sidebar'] ) );
	}
    else {
	    update_post_meta( $post_id, 'align-sidebar', 'right' );
	}

    // Checks for input and saves
	if ( array_key_exists('page-head', $_POST) ) {
		update_post_meta( $post_id, 'page-head', esc_attr( $_POST['page-head'] ) );
	}
    else {
		update_post_meta( $post_id, 'page-head', 'default' );
	}
}
add_action( 'save_post', 'diviner_meta_save', 10, 2 );