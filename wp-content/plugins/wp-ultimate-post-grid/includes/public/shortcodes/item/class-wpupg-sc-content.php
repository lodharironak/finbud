<?php
/**
 * Handle the item content shortcode.
 *
 * @link       https://bootstrapped.ventures
 * @since      3.0.0
 *
 * @package    WP_Ultimate_Post_Grid
 * @subpackage WP_Ultimate_Post_Grid/includes/public/shortcodes/item
 */

/**
 * Handle the item content shortcode.
 *
 * @since      3.0.0
 * @package    WP_Ultimate_Post_Grid
 * @subpackage WP_Ultimate_Post_Grid/includes/public/shortcodes/item
 * @author     Brecht Vandersmissen <brecht@bootstrapped.ventures>
 */
class WPUPG_SC_Content extends WPUPG_Template_Shortcode {
	public static $shortcode = 'wpupg-item-content';

	public static function init() {
		$atts = WPUPG_Template_Helper::limit_text_atts();

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
			'wpupg-item-content',
		);

		// Parse content before limitting.
		$content = apply_filters( 'the_content', $item->content() );

		$text = WPUPG_Template_Helper::limit_text( $atts, $content );
		$output = '<div class="' . esc_attr( implode( ' ', $classes ) ) . '">' . $text . '</div>';
		return apply_filters( parent::get_hook(), $output, $atts, $item );
	}
}

WPUPG_SC_Content::init();