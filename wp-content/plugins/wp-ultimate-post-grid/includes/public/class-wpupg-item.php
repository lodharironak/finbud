<?php
/**
 * Represents a grid item.
 *
 * @link       https://bootstrapped.ventures
 * @since      3.0.0
 *
 * @package    WP_Ultimate_Post_Grid
 * @subpackage WP_Ultimate_Post_Grid/includes/public
 */

/**
 * Represents a grid item.
 *
 * @since      3.0.0
 * @package    WP_Ultimate_Post_Grid
 * @subpackage WP_Ultimate_Post_Grid/includes/public
 * @author     Brecht Vandersmissen <brecht@bootstrapped.ventures>
 */
class WPUPG_Item {

	/**
	 * Metadata associated with this item.
	 *
	 * @since    3.0.0
	 * @access   private
	 * @var      array    $meta	Item metadata.
	 */
	private $meta = false;

	/**
	 * Get new grid item object from meta.
	 *
	 * @since    3.0.0
	 * @param    mixed $meta Meta for this grid item.
	 */
	public function __construct( $meta ) {
		$this->meta = $meta;
	}

	/**
	 * Get metadata value.
	 *
	 * @since    3.0.0
	 * @param    mixed $field   Metadata field to retrieve.
	 * @param	 mixed $default	Default to return if metadata is not set.
	 */
	public function meta( $field, $default = '' ) {
		if ( isset( $this->meta[ $field ] ) ) {
			return $this->meta[ $field ];
		}

		return $default;
	}

	/**
	 * Helper Functions.
	 */
	public function classes() {
		$classes = array(
			'wpupg-item',
			'wpupg-item-meta',
		);

		// Optional classes if set.
		$id = $this->id();
		if ( $id ) {
			$classes[] = 'wpupg-item-' . $id;
		}
		$post_type = $this->post_type();
		if ( $post_type ) {
			$classes[] = 'wpupg-type-' . $post_type;
		}

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
		return $this->meta( 'id' );
	}
	/**
	 * Item Fields.
	 */
	public function author_id() {
		return $this->meta( 'author_id' );
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
		return $this->meta( 'comment_count', 0 );
	}
	public function content() {
		return $this->meta( 'content' );
	}
	public function custom_field( $key ) {
		return $this->meta( $key, '' );
	}
	public function date() {
		return $this->meta( 'date' );
	}
	public function date_modified() {
		return $this->meta( 'date_modified' );
	}
	public function excerpt() {
		return $this->meta( 'excerpt' );
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
			return get_post_thumbnail_id( $this->id() );
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
		return $this->meta( 'menu_order', 0 );
	}
	public function post_type() {
		return $this->meta( 'post_type' );
	}
	public function terms( $key ) {
		return $this->meta( $key );
	}
	public function title() {
		return $this->meta( 'title' );
	}
	public function url() {
		$custom_url = $this->meta( 'wpupg_custom_link', false );

		if ( $custom_url ) {
			return $custom_url;
		} else {
			return $this->meta( 'url' );
		}
	}

	/**
	 * Custom Item Fields.
	 */
	public function link( $grid ) {
		$custom_link = $this->meta( 'wpupg_custom_link_behaviour', 'default' );

		if ( 'default' === $custom_link ) {
			return $grid->link();
		} else {
			return 'none' === $custom_link ? false : true;
		}
	}
	public function link_target( $grid ) {
		$custom_link_target = $this->meta( 'wpupg_custom_link_behaviour', 'default' );

		if ( 'default' === $custom_link_target || 'none' === $custom_link_target ) {
			return $grid->link_target();
		} else {
			return $custom_link_target;
		}
	}
}
