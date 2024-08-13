<?php
/**
 * Responsible for showing admin notices.
 *
 * @link       https://bootstrapped.ventures
 * @since      3.0.0
 *
 * @package    WP_Ultimate_Post_Grid
 * @subpackage WP_Ultimate_Post_Grid/includes/admin
 */

/**
 * Responsible for showing admin notices.
 *
 * @since      3.0.0
 * @package    WP_Ultimate_Post_Grid
 * @subpackage WP_Ultimate_Post_Grid/includes/admin
 * @author     Brecht Vandersmissen <brecht@bootstrapped.ventures>
 */
class WPUPG_Notices {

	/**
	 * Register actions and filters.
	 *
	 * @since    3.0.0
	 */
	public static function init() {
		add_filter( 'wpupg_admin_notices', array( __CLASS__, 'new_user_notice' ) );
		add_filter( 'wpupg_admin_notices', array( __CLASS__, 'version_3_notice' ) );
	}

	/**
	 * Get all notices to show.
	 *
	 * @since    3.0.0
	 */
	public static function get_notices() {
		$notices_to_display = array();
		$current_user_id = get_current_user_id();

		if ( $current_user_id ) {
			$notices = apply_filters( 'wpupg_admin_notices', array() );
			$dismissed_notices = get_user_meta( $current_user_id, 'wpupg_dismissed_notices', false );

			foreach ( $notices as $notice ) {
				// Set defaults.
				$notice = wp_parse_args( $notice, array(
					'dismissable' => true,
					'location' => false,
					'capability' => false,
				));
				
				// Check capability.
				if ( false !== $notice['capability'] && ! current_user_can( $notice['capability'] ) ) {
					continue;
				}

				// Only dismissable when ID is set.
				if ( ! isset( $notice['id'] ) ) {
					$notice['dismissable'] = false;
				}

				// Check if user has already dismissed notice.
				if ( false !== $notice['dismissable'] && in_array( $notice['id'], $dismissed_notices ) ) {
					continue;
				}

				$notices_to_display[] = $notice;
			}
		}

		return $notices_to_display;
	}

	/**
	 * Check if a specific notice has been dismissed.
	 *
	 * @since    3.0.0
	 */
	public static function is_dismissed( $id ) {
		$user_id = get_current_user_id();
		$dismissed_notices = get_user_meta( $user_id, 'wpupg_dismissed_notices', false );
		return in_array( $id, $dismissed_notices );
	}

	/**
	 * Show a notice to new users.
	 *
	 * @since    3.0.0
	 */
	public static function new_user_notice( $notices ) {
		$count = wp_count_posts( WPUPG_POST_TYPE )->publish;

		if ( 1 > intval( $count ) ) {
			$notices[] = array(
				'id' => 'new_user',
				'title' => __( 'Welcome to WP Ultimate Post Grid', 'wp-ultimate-post-grid' ),
				'text' => __( 'Not sure how to get started?', 'wp-ultimate-post-grid' ) . ' <a href="' . esc_url( admin_url( 'admin.php?page=wpupg_faq' ) ). '">' . __( 'Check out our documentation!', 'wp-ultimate-post-grid' ) . '</a>',
			);
		}

		return $notices;
	}

	/**
	 * Show a notice about version 3.0.0.
	 *
	 * @since    3.0.0
	 */
	public static function version_3_notice( $notices ) {
		$notice_id = 'version_3';

		if ( ! self::is_dismissed( $notice_id ) ) {
			$has_old_version_grids = false;

			// Check all grids for version.
			$args = array(
				'post_type' => WPUPG_POST_TYPE,
				'post_status' => 'any',
				'posts_per_page' => -1,
			);
			$query = new WP_Query( $args );

			$posts = $query->posts;
			foreach ( $posts as $post ) {
				$grid = WPUPG_Grid_Manager::get_grid( $post );

				if ( version_compare( $grid->version(), '3.0.0', '<' ) ) {
					$has_old_version_grids = true;
					break;
				}
			}

			if ( $has_old_version_grids ) {
				$notices[] = array(
					'id' => $notice_id,
					'title' => __( 'WARNING: WP Ultimate Post Grid 3.0.0+', 'wp-ultimate-post-grid' ),
					'text' => 'This is a major upgrade and we highly recommend you to test your grids. <a href="https://help.bootstrapped.ventures/article/218-wp-ultimate-post-grid-3-0-0" target="_blank">Learn more in our documentation!</a>',
				);
			} else {
				$user_id = get_current_user_id();
				add_user_meta( $user_id, 'wpupg_dismissed_notices', $notice_id );
			}
		}

		return $notices;
	}
}

WPUPG_Notices::init();
