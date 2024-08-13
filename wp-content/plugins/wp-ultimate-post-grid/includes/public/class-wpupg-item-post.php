<?php
/**
 * Represents a grid post item.
 *
 * @link       https://bootstrapped.ventures
 * @since      3.0.0
 *
 * @package    WP_Ultimate_Post_Grid
 * @subpackage WP_Ultimate_Post_Grid/includes/public
 */

/**
 * Represents a grid post item.
 *
 * @since      3.0.0
 * @package    WP_Ultimate_Post_Grid
 * @subpackage WP_Ultimate_Post_Grid/includes/public
 * @author     Brecht Vandersmissen <brecht@bootstrapped.ventures>
 */
class WPUPG_Item_Post extends WPUPG_Item {

	/**
	 * WP_Post object associated with this item.
	 *
	 * @since    3.0.0
	 * @access   private
	 * @var      object    $post	WP_Post object of this item.
	 */
	private $post;

	/**
	 * Metadata associated with this item.
	 *
	 * @since    3.0.0
	 * @access   private
	 * @var      array    $meta	Item metadata.
	 */
	private $meta = false;

	/**
	 * Get new grid item object from associated post.
	 *
	 * @since    3.0.0
	 * @param    mixed $post_or_post_id WP_Post object or post ID for this grid item.
	 */
	public function __construct( $post_or_post_id ) {
		$post = is_integer( $post_or_post_id ) ? get_post( $post_or_post_id ) : $post_or_post_id;
		$this->post = $post;
	}

	/**
	 * Get metadata value.
	 *
	 * @since    3.0.0
	 * @param    mixed $field   Metadata field to retrieve.
	 * @param	 mixed $default	Default to return if metadata is not set.
	 */
	public function meta( $field, $default = '' ) {
		if ( ! $this->meta ) {
			$this->meta = get_post_custom( $this->id() );
		}

		if ( isset( $this->meta[ $field ] ) && null !== $this->meta[ $field ][0] ) {
			return $this->meta[ $field ][0];
		}

		return $default;
	}

	/**
	 * Helper Functions.
	 */
	public function classes() {
		$classes = array(
			'wpupg-item',
			'wpupg-item-post',
			'wpupg-item-' . $this->id(),
			'wpupg-type-' . $this->post_type(),
		);

		if ( $this->has( 'image' ) ) {
			$classes[] = 'wpupg-item-has-image';
		} else {
			$classes[] = 'wpupg-item-no-image';
		}

		return $classes;
	}
	public function has( $field ) {
		switch ( $field ) {
			case 'image':
				return '' !== $this->image_url(); // Use URL and not ID because of custom image URL feature.
			default:
				return false !== $this->meta( $field, false );
		}

		return false;
	}
	/**
	 * Technical fields.
	 */
	public function id() {
		return $this->post->ID;
	}
	/**
	 * Item Fields.
	 */
	public function author_id() {
		return $this->post->post_author;
	}
	public function author() {
		$author_id = $this->author_id();

		if ( $author_id ) {
			$author = get_userdata( $author_id );

			if ( $author ) {
				return $author->data->display_name;
			}
		}
		
		return '';
	}
	public function comment_count() {
		return $this->post->comment_count;
	}
	public function content() {
		return $this->post->post_content;
	}
	public function custom_field( $key ) {
		return $this->meta( $key, '' );
	}
	public function date() {
		return $this->post->post_date;
	}
	public function date_modified() {
		return get_the_modified_date( 'Y-m-d H:i:s', $this->post );
	}
	public function excerpt() {
		return $this->post->post_excerpt;
	}
	public function image( $size = 'thumbnail' ) {
		$image_id = $this->image_id();

		if ( $image_id ) {
			return wp_get_attachment_image( $image_id, $size );
		} else {
			$image_url = $this->image_url();

			if ( $image_url ) {
				return '<img src="' . esc_attr( $image_url ) . '"/>';
			}
		}

		return '';
		
	}
	public function image_id() {
		$custom_image_id = $this->meta( 'wpupg_custom_image_id', false );

		if ( $custom_image_id ) {
			return $custom_image_id;
		} else {
			if ( 'attachment' === $this->post_type() ) {
				return $this->id();
			} else {
				return get_post_thumbnail_id( $this->id() );
			}
		}
	}
	public function image_url( $size = 'thumbnail' ) {
		$custom_image_url = $this->meta( 'wpupg_custom_image', false );

		if ( $custom_image_url ) {
			$custom_image_id = $this->meta( 'wpupg_custom_image_id', false );
			
			if ( $custom_image_id ) {
				$thumb = wp_get_attachment_image_src( $this->image_id(), $size );
			} else {
				$thumb = array( $custom_image_url );
			}
		} else {
			$thumb = wp_get_attachment_image_src( $this->image_id(), $size );
		}

		return $thumb && isset( $thumb[0] ) ? $thumb[0] : '';
	}
	public function menu_order() {
		return $this->post->menu_order;
	}
	public function post() {
		return $this->post;
	}
	public function post_type() {
		return $this->post->post_type;
	}
	public function terms( $key, $args = array() ) {
		return wp_get_post_terms( $this->post->ID, $key, $args );
	}
	public function title() {
		return $this->post->post_title;
	}
	public function url() {
		$custom_url = $this->meta( 'wpupg_custom_link', false );

		if ( $custom_url ) {
			return $custom_url;
		} else {
			return get_permalink( $this->id() );
		}
	}
}
