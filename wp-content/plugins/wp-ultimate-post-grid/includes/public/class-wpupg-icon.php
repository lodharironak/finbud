<?php
/**
 * Handle icons.
 *
 * @link       https://bootstrapped.ventures
 * @since      3.0.0
 *
 * @package    WP_Ultimate_Post_Grid
 * @subpackage WP_Ultimate_Post_Grid/includes/public
 */

/**
 * Handle icons.
 *
 * @since      3.0.0
 * @package    WP_Ultimate_Post_Grid
 * @subpackage WP_Ultimate_Post_Grid/includes/public
 * @author     Brecht Vandersmissen <brecht@bootstrapped.ventures>
 */
class WPUPG_Icon {

	/**
	 * Get the icon.
	 *
	 * @since	3.3.0
	 * @param	mixed $keyword_or_url Keyword or URL for the icon.
	 * @param	mixed $color Color to return the icon in.
	 */
	public static function get( $keyword_or_url, $color = false ) {
		$icon = false;

		if ( ! $keyword_or_url ) {
			return $icon;
		}

		$keyword = sanitize_key( $keyword_or_url ); // Prevent directory traversal.

		if ( file_exists( WPUPG_DIR . 'assets/icons/shortcode/' . $keyword . '.svg' ) ) {
			ob_start();
			include( WPUPG_DIR . 'assets/icons/shortcode/' . $keyword . '.svg' );
			$icon = ob_get_contents();
			ob_end_clean();
		} else {
			// No keyword match? Use as URL.
			$icon = '<img src="' . esc_attr( $keyword_or_url ) . '" data-pin-nopin="true"/>';
		}

		if ( $color ) {
			$color = esc_attr( $color ); // Prevent misuse of color attribute.
			$icon = preg_replace( '/#[0-9a-f]{3,6}/mi', $color, $icon );
		}

		return $icon;
	}
	
	/**
	 * Get all icons.
	 *
	 * @since	4.0.0
	 */
	public static function get_all() {
		$icons = array();

		$dir = WPUPG_DIR . 'assets/icons/shortcode';

		if ( $handle = opendir( $dir ) ) {
			while ( false !== ( $file = readdir( $handle ) ) ) {
				preg_match( '/(.*?).svg$/', $file, $match );
				if ( isset( $match[1] ) ) {
					$id = $match[1];

					$icons[ $id ] = array(
						'id' => $id,
						'name' => ucwords( str_replace( '-', ' ', $id ) ),
						'url' => WPUPG_URL . 'assets/icons/shortcode/' . $match[0],
					);
				}
			}
		}

		return $icons;
	}
}
