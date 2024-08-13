<?php
/**
 * Responsible for the grid meta box.
 *
 * @link       https://bootstrapped.ventures
 * @since      3.0.0
 *
 * @package    WP_Ultimate_Post_Grid
 * @subpackage WP_Ultimate_Post_Grid/includes/public
 */

/**
 * Responsible for the grid meta box.
 *
 * @since      3.0.0
 * @package    WP_Ultimate_Post_Grid
 * @subpackage WP_Ultimate_Post_Grid/includes/public
 * @author     Brecht Vandersmissen <brecht@bootstrapped.ventures>
 */
class WPUPG_Meta_Box {

	/**
	 * Register actions and filters.
	 *
	 * @since    3.0.0
	 */
	public static function init() {
		add_action( 'init', array( __CLASS__, 'meta_fields_in_rest' ) );
		add_action( 'admin_init', array( __CLASS__, 'add_meta_box' ) );

		add_action( 'edit_attachment', array( __CLASS__, 'save_attachment' ) );
		add_action( 'save_post', array( __CLASS__, 'save_post' ), 10, 2 );
	}

	/**
	 * Register meta fields for the REST API.
	 *
	 * @since    3.0.0
	 */
	public static function meta_fields_in_rest() {
		$post_types = WPUPG_Settings::get( 'meta_box_post_types' );
		$fields = array(
			'wpupg_custom_link' => 'string',
			'wpupg_custom_link_behaviour' => 'string',
			'wpupg_custom_image' => 'string',
			'wpupg_custom_image_id' => 'integer',
		);

		foreach( $post_types as $post_type ) {
			foreach ( $fields as $field => $type ) {
				register_meta( $post_type, $field, array( 'show_in_rest' => true, 'type' => $type ) );
			}
		}
    }

	/**
	 * Add the meta box.
	 *
	 * @since    3.0.0
	 */
	public static function add_meta_box() {
		$post_types = WPUPG_Settings::get( 'meta_box_post_types' );

        foreach( $post_types as $post_type ) {
			add_meta_box(
				'wpupg_meta_box_post',
				'WP Ultimate Post Grid',
				array( __CLASS__, 'meta_box' ),
				$post_type,
				'normal',
				'high',
				array(
                    '__back_compat_meta_box' => true,
                )
			);
        }
	}

	/**
	 * Meta box content.
	 *
	 * @since    3.0.0
	 */
	public static function meta_box() {
		$post = get_post();
		include( WPUPG_DIR . 'templates/admin/meta-box.php' );
	}

	/**
	 * Save meta box fields when saving attachment.
	 *
	 * @since    3.0.0
	 * @param	 int $post_id ID of the attachment getting saved.
	 */
	public static function save_attachment( $post_id ) {
		$post = get_post( $post_id );
        self::save_post( $post_id, $post );
	}

	/**
	 * Save meta box fields when saving post.
	 *
	 * @since    3.0.0
	 * @param	 int $post_id ID of the post getting saved.
	 * @param	 mixed $post Post object getting saved.
	 */
	public static function save_post( $post_id, $post ) {
		if ( $post->post_type !== WPUPG_POST_TYPE ) {
            if ( ! isset( $_POST['wpupg_nonce'] ) || ! wp_verify_nonce( $_POST['wpupg_nonce'], 'grid' ) ) {
                return;
            }

            // Meta fields.
            $fields = array(
                'wpupg_custom_link',
                'wpupg_custom_link_behaviour',
                'wpupg_custom_image',
                'wpupg_custom_image_id',
            );

            foreach ( $fields as $field ) {
                $old = get_post_meta( $post_id, $field, true );
                $new = isset( $_POST[$field] ) ? $_POST[$field] : null;

                // Update or delete meta data if changed.
                if ( isset( $new ) && $new !== $old ) {
                    update_post_meta( $post_id, $field, $new );
                } elseif ( $new == '' && $old ) {
                    delete_post_meta( $post_id, $field, $old );
                }
            }
        }
	}
}

WPUPG_Meta_Box::init();
