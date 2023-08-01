<?php

namespace CustomFacebookFeed\Helpers;

/**
 * Class Util.
 * Holds utility functions for the plugin.
 *
 * @package CustomFacebookFeed\Helpers
 */
class Util {

	/**
	 * Check if the plugin is page is Facebook page.
	 *
	 * @return bool
	 */
	public static function is_fb_page() {
		return get_current_screen() !== null && ! empty( $_GET['page'] ) && strpos( $_GET['page'], 'cff-' ) !== false;
	}

	/**
	 * Check if current page is a specific page.
	 *
	 * @return bool
	 */
	public static function current_page_is( $page ) {
		$current_screen = get_current_screen();
		return $current_screen !== null && ! empty( $current_screen ) && strpos( $current_screen->id, $page ) !== false;
	}
}