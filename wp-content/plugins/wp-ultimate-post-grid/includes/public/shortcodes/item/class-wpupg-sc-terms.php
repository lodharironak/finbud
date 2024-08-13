<?php
/**
 * Handle the item terms shortcode.
 *
 * @link       https://bootstrapped.ventures
 * @since      3.0.0
 *
 * @package    WP_Ultimate_Post_Grid
 * @subpackage WP_Ultimate_Post_Grid/includes/public/shortcodes/item
 */

/**
 * Handle the item terms shortcode.
 *
 * @since      3.0.0
 * @package    WP_Ultimate_Post_Grid
 * @subpackage WP_Ultimate_Post_Grid/includes/public/shortcodes/item
 * @author     Brecht Vandersmissen <brecht@bootstrapped.ventures>
 */
class WPUPG_SC_Terms extends WPUPG_Template_Shortcode {
	public static $shortcode = 'wpupg-item-terms';

	public static function init() {
		$atts = array(
			'key' => array(
				'default' => '',
				'type' => 'text',
				'help' => 'Key of the taxonomy you want to display. Use "category" for regular categories and "post_tag" for regular tags.',
			),
			'orderby' => array(
				'default' => 'name',
				'type' => 'dropdown',
				'options' => array(
					'id' => 'ID',
					'name' => 'Name',
					'slug' => 'Slug',
					'count' => 'Count',
					'description' => 'Description',
					'parent' => 'Parent',
					'term_group' => 'Term Group',
					'term_id' => 'Term ID',
				),
			),
			'order' => array(
				'default' => 'asc',
				'type' => 'dropdown',
				'options' => array(
					'asc' => 'Ascending',
					'desc' => 'Descending',
				),
			),
			'links' => array(
				'type' => 'toggle',
				'default' => '0',
			),
			'display' => array(
				'default' => 'inline',
				'type' => 'dropdown',
				'options' => 'display_options',
			),
			'align' => array(
				'default' => 'left',
				'type' => 'dropdown',
				'options' => array(
					'left' => 'Left',
					'center' => 'Center',
					'right' => 'Right',
				),
				'dependency' => array(
					'id' => 'display',
					'value' => 'block',
				),
			),
			'term_style' => array(
				'default' => 'text',
				'type' => 'dropdown',
				'options' => array(
					'text' => __( 'Text', 'wp-ultimate-post-grid' ),
					'block' => __( 'Block', 'wp-ultimate-post-grid' ),
				),
			),
			'block_horizontal_padding' => array(
				'default' => '5px',
				'type' => 'size',
				'dependency' => array(
					'id' => 'term_style',
					'value' => 'block',
				),
			),
			'block_vertical_padding' => array(
				'default' => '2px',
				'type' => 'size',
				'dependency' => array(
					'id' => 'term_style',
					'value' => 'block',
				),
			),
			'block_color' => array(
				'default' => '#333333',
				'type' => 'color',
				'dependency' => array(
					'id' => 'term_style',
					'value' => 'block',
				),
			),
			'block_text_color' => array(
				'default' => '#ffffff',
				'type' => 'color',
				'dependency' => array(
					'id' => 'term_style',
					'value' => 'block',
				),
			),
			'text_style' => array(
				'default' => 'normal',
				'type' => 'dropdown',
				'options' => 'text_styles',
			),
			'term_separator' => array(
				'default' => ', ',
				'type' => 'text',
			),
		);

		$atts = array_merge( $atts, WPUPG_Template_Helper::get_label_container_atts() );

		self::$attributes = $atts;
		parent::init();
	}

	/**
	 * Output for the shortcode.
	 *
	 * @since	3.0.0
	 * @param	array $atts Options passed along with the shortcode.
	 */
	public static function shortcode( $atts ) {
		$atts = parent::get_attributes( $atts );

		$item = WPUPG_Template_Shortcodes::get_item();

		$args = array(
			'orderby' => $atts['orderby'],
			'order' => $atts['order'],
		);

		$terms = $item->terms( $atts['key'], $args );
		if ( ! $item || ! $terms || ! is_array( $terms ) ) {
			return '';
		}

		// Output.
		$classes = array(
			'wpupg-item-terms',
			'wpupg-block-text-' . $atts['text_style'],
		);

		// Alignment.
		if ( 'block' === $atts['display'] && 'left' !== $atts['align'] ) {
			$classes[] = 'wpupg-align-' . $atts['align']; 
		}
		
		// Term Output.
		$term_output = '';
		foreach ( $terms as $index => $term ) {
			if ( 0 !== $index ) {
				$term_output .= $atts['term_separator'];
			}

			$style = '';

			if ( 'block' === $atts['term_style'] ) {
				$style = ' style="display: inline-block;padding:' . esc_attr( $atts['block_vertical_padding'] ) . ' ' . esc_attr( $atts['block_horizontal_padding'] ) . ';background-color:' . esc_attr( $atts['block_color'] ) . ';color:' . esc_attr( $atts['block_text_color'] ) . ';"';
			}

			if ( is_object( $term ) ) {
				$link = (bool) $atts['links'] ? get_term_link( $term ) : false;
				$name = apply_filters( 'wpupg_term_name', $term->name, $term->term_id, $atts['key'] );

				if ( $link && ! is_wp_error( $link ) ) {
					$term_output .= '<a href="' . esc_attr( $link ) . '" class="wpupg-item-term"' . $style . '>' . WPUPG_Shortcode::sanitize_html( $name ) . '</a>';
				} else {
					$term_output .= '<span class="wpupg-item-term"' . $style . '>' . WPUPG_Shortcode::sanitize_html( $name ) . '</span>';
				}
			} else {
				$term_output .= '<span class="wpupg-item-term"' . $style . '>' . WPUPG_Shortcode::sanitize_html( $term ) . '</span>';
			}
		}

		$label_container = WPUPG_Template_Helper::get_label_container( $atts, 'terms' );
		$tag = 'block' === $atts['display'] ? 'div' : 'span';
		$output = '<' . esc_attr( $tag ) . ' class="' . esc_attr( implode( ' ', $classes ) ) . '">' . $label_container . $term_output . '</' . esc_attr( $tag ) . '>';
		return apply_filters( parent::get_hook(), $output, $atts, $item );
	}
}

WPUPG_SC_Terms::init();