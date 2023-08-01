<?php

if ( !function_exists( 'wpgs_get_option' ) ) {
	/**
	 * Get Setting option
	 *
	 * @param  [string] $option
	 * @param  [string] $section
	 * @param  string   $default
	 * @return void
	 */
	function wpgs_get_option( $option, $default = '' ) {
		$options = get_option( 'wpgs_form' );

		if ( isset( $options[$option] ) ) {
			return $options[$option];
		}

		return $default;
	}
}

if ( !function_exists( 'cix_only_pro' ) ) {
	/**
	 * @param $value
	 */
	function cix_only_pro( $value ) {
		if ( $value == 'only_pro' || $value == 'ondemand' || $value == 'progressive' || $value == true || $value == false || $value == 'x' ) {
			return esc_html__( 'Available in PRO', 'wpgs-td' );
		}
	}
}

if ( !function_exists( 'cix_get_wp_image_sizes' ) ) {
	/**
	 * @param $value
	 */
	function cix_get_wp_image_sizes() {
		// Get the image sizes.
		global $_wp_additional_image_sizes;
		$sizes = array();

		foreach ( get_intermediate_image_sizes() as $_size ) {
			if ( in_array( $_size, array( 'thumbnail', 'medium', 'large' ), true ) ) {

				$width  = get_option( "{$_size}_size_w" );
				$height = get_option( "{$_size}_size_h" );
				$crop   = (bool) get_option( "{$_size}_crop" ) ? 'hard' : 'soft';

				$sizes[$_size] = ucfirst( "{$_size} - $crop:{$width}x{$height}" );

			} elseif ( isset( $_wp_additional_image_sizes[$_size] ) ) {

				$width  = $_wp_additional_image_sizes[$_size]['width'];
				$height = $_wp_additional_image_sizes[$_size]['height'];
				$crop   = $_wp_additional_image_sizes[$_size]['crop'] ? 'hard' : 'soft';

				$sizes[$_size] = ucfirst( "{$_size} - $crop:{$width}X{$height}" );
			}
		}
		return $sizes;
	}
}

add_filter( 'plugin_row_meta', 'wpgs_plugin_meta_links', 10, 2 );
/**
 * Add links to plugin's description in plugins table
 *
 * @param array  $links Initial list of links.
 * @param string $file  Basename of current plugin.
 */
function wpgs_plugin_meta_links( $links, string $file ) {
	if ( $file !== WPGS_PLUGIN_BASE ) {
		return $links;
	}

	$support_link = '<a style="color:red;" target="_blank" href="https://codeixer.com/contact-us/" title="' . __( 'Get help', 'woo-product-gallery-slider' ) . '">' . __( 'Support', 'woo-product-gallery-slider' ) . '</a>';
	$rate_twist   = '<a target="_blank" href="https://wordpress.org/support/plugin/woo-product-gallery-slider/reviews/?filter=5"> Rate this plugin » </a>';

	$links[] = $support_link;
	$links[] = $rate_twist;

	return $links;
} // plugin_meta_links

add_filter( 'wc_get_template', 'wpgs_get_template', 10, 5 );

if ( !function_exists( 'wpgs_get_template' ) ) {
	/**
	 * @param $located
	 * @param $template_name
	 * @param $args
	 * @param $template_path
	 * @param $default_path
	 */
	function wpgs_get_template( $located, $template_name, $args, $template_path, $default_path ) {
		if ( 'single-product/product-image.php' == $template_name ) {
			$located = WPGS_INC . 'product-image.php';
		}

		return $located;
	}
}