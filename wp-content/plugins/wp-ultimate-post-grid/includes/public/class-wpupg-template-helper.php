<?php
/**
 * Helper functions for the item template.
 *
 * @link       https://bootstrapped.ventures
 * @since      3.0.0
 *
 * @package    WP_Ultimate_Post_Grid
 * @subpackage WP_Ultimate_Post_Grid/includes/public
 */

/**
 * Helper functions for the item template.
 *
 * @since      3.0.0
 * @package    WP_Ultimate_Post_Grid
 * @subpackage WP_Ultimate_Post_Grid/includes/public
 * @author     Brecht Vandersmissen <brecht@bootstrapped.ventures>
 */
class WPUPG_Template_Helper {

	/**
	 * Get attributes for the label container.
	 *
	 * @since	3.0.0
	 */
	public static function get_label_container_atts() {
		return array( 
			'icon' => array(
				'default' => '',
				'type' => 'icon',
			),
			'icon_color' => array(
				'default' => '#333333',
				'type' => 'color',
				'dependency' => array(
					'id' => 'icon',
					'value' => '',
					'type' => 'inverse',
				),
			),
			'label' => array(
				'default' => '',
				'type' => 'text',
			),
			'label_separator' => array(
				'default' => ' ',
				'type' => 'text',
				'dependency' => array(
					'id' => 'label',
					'value' => '',
					'type' => 'inverse',
				),
			),
			'label_style' => array(
				'default' => 'normal',
				'type' => 'dropdown',
				'options' => 'text_styles',
				'dependency' => array(
					'id' => 'label',
					'value' => '',
					'type' => 'inverse',
				),
			),
			'label_on_own_line' => array(
				'default' => '0',
				'type' => 'toggle',
				'dependency' => array(
					'id' => 'label',
					'value' => '',
					'type' => 'inverse',
				),
			),
		);
	}

	/**
	 * Get label container.
	 *
	 * @since	3.0.0
	 * @param	mixed $atts Attributes for the shortcode.
	 * @param	string $field Field to get the container for.
	 */
	public static function get_label_container( $atts, $field ) {
		$field = str_replace( ' ', '', $field );

		// Get optional icon.
		$icon = '';
		if ( $atts['icon'] ) {
			$icon = WPUPG_Icon::get( $atts['icon'], $atts['icon_color'] );

			if ( $icon ) {
				$icon = '<span class="wpupg-icon wpupg-item-' . esc_attr( $field ) . '-icon">' . $icon . '</span> ';
			}
		}

		// Get optional label.
		$label = '';
		if ( $atts['label'] ) {
			$label = '<span class="wpupg-item-label wpupg-block-text-' . esc_attr( $atts['label_style'] ) . ' wpupg-item-' . esc_attr( $field ) . '-label">' . WPUPG_Shortcode::sanitize_html( __( $atts['label'], 'wp-ultimate-post-grid' ) . $atts['label_separator'] ) . '</span>';
		}

		$label_container = '';
		if ( $icon || $label ) {
			$tag = $atts['label_on_own_line'] ? 'div' : 'span';
			$label_container = '<' . $tag . ' class="wpupg-item-label-container">' . $icon . $label . '</' . $tag . '>';
		}

		return $label_container;
	}

	/**
	 * Get attributes for limit text.
	 *
	 * @since	3.0.0
	 */
	public static function limit_text_atts() {
		return array(
			'limit_text' => array(
				'default' => '0',
				'type' => 'toggle',
			),
			'limit_type' => array(
				'default' => 'characters',
				'type' => 'dropdown',
				'options' => array(
					'characters' => 'Limit to X characters',
					'words' => 'Limit to X words',
				),
				'dependency' => array(
					'id' => 'limit_text',
					'value' => '1',
				),
			),
			'limit_number' => array(
				'default' => '20',
				'type' => 'number',
				'dependency' => array(
					'id' => 'limit_text',
					'value' => '1',
				),
			),
			'limit_suffix' => array(
				'default' => '&hellip;',
				'type' => 'text',
				'dependency' => array(
					'id' => 'limit_text',
					'value' => '1',
				),
			),
			'limit_ignore_html' => array(
				'default' => '0',
				'type' => 'toggle',
				'dependency' => array(
					'id' => 'limit_text',
					'value' => '1',
				),
			),
		);
	}

	/**
	 * Limit text length.
	 *
	 * @since	3.0.0
	 * @param	mixed $atts Attributes for the shortcode.
	 * @param	string $text Text to limit.
	 */
	public static function limit_text( $atts, $text ) {
		if ( $atts['limit_text'] ) {
			$limited = false;
			$limit = intval( $atts['limit_number'] );

			if ( 0 < $limit ) {
				if ( (bool) $atts['limit_ignore_html'] ) {
					$text = wp_strip_all_tags( $text );
				}

				if ( 'words' === $atts['limit_type'] && $limit < str_word_count( $text, 0 ) ) {
					// Limit to X words.
					$words = str_word_count( $text, 2 );
					$pos = array_keys( $words );
					$text = substr( $text, 0, $pos[ $limit ] );
	
					$limited = true;
				} elseif ( 'characters' === $atts['limit_type'] && $limit < strlen( $text ) ) {
					// Limit to X characters.
					$text = substr( $text, 0, $limit );
	
					$limited = true;
				}
	
				if ( $limited ) {
					$text = self::limit_text_clean_html( $text );
					$text = rtrim( $text ) . $atts['limit_suffix'];
				}
			}
		}

		return $text;
	}

	/**
	 * Clean limited text HTML. Should make sure any tags are closed again.
	 *
	 * @since	3.0.0
	 * @param	mixed $html HTML to clean.
	 */
	private static function limit_text_clean_html( $html ) {
        $doc = new DOMDocument();
        libxml_use_internal_errors( true );
        $doc->loadHTML( '<?xml version="1.0" encoding="UTF-8"?><html_tags>' . $html . '</html_tags>' );
		libxml_clear_errors();

        return substr( $doc->saveXML( $doc->getElementsByTagName( 'html_tags' )->item( 0 ) ), strlen( '<html_tags>' ), -strlen( '</html_tags>' ) );
	}
}
