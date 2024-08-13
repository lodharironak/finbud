<?php
/**
 * Template for the grid Meta Box.
 *
 * @link       https://bootstrapped.ventures
 * @since      3.0.0
 *
 * @package    WP_Ultimate_Post_Grid
 * @subpackage WP_Ultimate_Post_Grid/templates/admin
 */
?>
<input type="hidden" name="wpupg_nonce" value="<?php echo wp_create_nonce( 'grid' ); ?>" />
<table id="wpupg_form_post" class="wpupg_form">
    <tr>
        <td><label for="wpupg_custom_link"><?php _e( 'Custom Link', 'wp-ultimate-post-grid' ); ?></label></td>
        <td>
            <input type="text" name="wpupg_custom_link" id="wpupg_custom_link" value="<?php echo esc_attr( get_post_meta( $post->ID, 'wpupg_custom_link', true ) ); ?>"/>
        </td>
        <td><?php _e( 'Override the default link for this post.', 'wp-ultimate-post-grid' ); ?></td>
    </tr>
    <tr>
        <td><label for="wpugpg_"><?php _e( 'Custom Link Behaviour', 'wp-ultimate-post-grid' ); ?></label></td>
        <td>
            <select name="wpupg_custom_link_behaviour" id="wpupg_custom_link_behaviour">
                <?php
                $custom_link_behaviour_options = array(
                    'default' => __( 'Use grid default', 'wp-ultimate-post-grid' ),
                    '_self' => __( 'Open in same tab', 'wp-ultimate-post-grid' ),
                    '_blank' => __( 'Open in new tab', 'wp-ultimate-post-grid' ),
                    'none' => __( "Don't use links", 'wp-ultimate-post-grid' ),
                );

                foreach( $custom_link_behaviour_options as $custom_link_behaviour => $custom_link_behaviour_name ) {
                    $selected = $custom_link_behaviour == get_post_meta( $post->ID, 'wpupg_custom_link_behaviour', true ) ? ' selected="selected"' : '';
                    echo '<option value="' . esc_attr( $custom_link_behaviour ) . '"' . $selected . '>' . $custom_link_behaviour_name . '</option>';
                }
                ?>
            </select>
        </td>
        <td><?php _e( 'Override the link behaviour for this item.', 'wp-ultimate-post-grid' ); ?></td>
    </tr>
    <tr>
        <td><label for="wpupg_custom_image"><?php _e( 'Custom Image URL', 'wp-ultimate-post-grid' ); ?></label></td>
        <td>
            <input type="text" name="wpupg_custom_image" id="wpupg_custom_image" value="<?php echo esc_attr( get_post_meta( $post->ID, 'wpupg_custom_image', true ) ); ?>"/>
            <input type="hidden" name="wpupg_custom_image_id" id="wpupg_custom_image_id" value="<?php echo esc_attr( get_post_meta( $post->ID, 'wpupg_custom_image_id', true ) ); ?>"/>
        </td>
        <td><input type="button" id="wpupg_add_custom_image" class="button" value="<?php _e( 'Choose from Library', 'wp-ultimate-post-grid' )?>"></td>
    </tr>
</table>