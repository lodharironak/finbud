<?php
/**
 * Handle the item date shortcode.
 *
 * @link       https://bootstrapped.ventures
 * @since      3.0.0
 *
 * @package    WP_Ultimate_Post_Grid
 * @subpackage WP_Ultimate_Post_Grid/includes/public/shortcodes/item
 */

/**
 * Handle the item date shortcode.
 *
 * @since      3.0.0
 * @package    WP_Ultimate_Post_Grid
 * @subpackage WP_Ultimate_Post_Grid/includes/public/shortcodes/item
 * @author     Brecht Vandersmissen <brecht@bootstrapped.ventures>
 */
class WPUPG_SC_Date extends WPUPG_Template_Shortcode {
	public static $shortcode = 'wpupg-item-date';

	public static function init() {
		$atts = array(
			'date' => array(
				'default' => 'published',
				'type' => 'dropdown',
				'options' => array(
					'published' => 'Published Date',
					'modified' => 'Modified Date',
				),
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
			'text_style' => array(
				'default' => 'normal',
				'type' => 'dropdown',
				'options' => 'text_styles',
			),
			'date_format' => array(
				'default' => 'F j, Y',
				'type' => 'text',
				'help' => __( 'Use the PHP date format. Leave empty to use default WordPress date format from the Settings > General page.', 'wp-ultimate-post-grid' ),
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
		if ( ! $item ) {
			return '';
		}

		// Output.
		$classes = array(
			'wpupg-item-date',
			'wpupg-block-text-' . $atts['text_style'],
		);

		// Alignment.
		if ( 'block' === $atts['display'] && 'left' !== $atts['align'] ) {
			$classes[] = 'wpupg-align-' . $atts['align']; 
		}

		// Date format.
		$format = $atts['date_format'];
		if ( ! $format ) {
			$format = get_option( 'date_format' );
		}

		// Date to use.
		switch( $atts['date'] ) {
			case 'modified':
				$date = $item->date_modified();
				break;
			default:
				$date = $item->date();
		}

		$formatted_date = date_i18n( $format, strtotime( $date ) );

		$label_container = WPUPG_Template_Helper::get_label_container( $atts, 'date' );
		$tag = 'block' === $atts['display'] ? 'div' : 'span';
		$output = '<' . esc_attr( $tag ) . ' class="' . esc_attr( implode( ' ', $classes ) ) . '">' . $label_container . $formatted_date . '</' . esc_attr( $tag ) . '>';
		return apply_filters( parent::get_hook(), $output, $atts, $item );
	}
}

WPUPG_SC_Date::init();