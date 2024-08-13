<?php
/**
 * Template for the FAQ page.
 *
 * @link       https://bootstrapped.ventures
 * @since      3.0.0
 *
 * @package    WP_Ultimate_Post_Grid
 * @subpackage WP_Ultimate_Post_Grid/templates/admin/menu
 */
// Active version.
$name = 'WP Ultimate Post Grid';
$version = WPUPG_VERSION;
$full_name = $name . ' ' . $version;

// Image directory.
$img_dir = WPUPG_URL . 'assets/images/faq';
?>

<div class="wrap about-wrap wpupg-faq">
	<h1><?php echo esc_html( $name ); ?></h1>
	<div class="about-text">Welcome to version <?php echo esc_html( $version ) ?>! Check out the <a href="https://help.bootstrapped.ventures/article/215-wp-ultimate-post-grid-changelog" target="_blank">changelog</a> now.</div>
	<div class="wpupg-badge">Version <?php echo esc_html( $version ); ?></div>

	<h3>Getting Started with WPUPG</h3>
	<p>
		Not sure how to get started with WP Ultimate Post Grid? Check out the <a href="https://help.bootstrapped.ventures/category/10-getting-started" target="_blank">Getting Started section of our documentation</a>!
	</p>

	<h3>I need more help</h3>
	<p>
		Check out <a href="https://help.bootstrapped.ventures/collection/7-wp-ultimate-post-grid" target="_blank">all documentation for WP Ultimate Post Grid</a> or contact us using the blue question mark in the bottom right of this page or by emailing <a href="mailto:support@bootstrapped.ventures">support@bootstrapped.ventures</a> directly.
	</p>
</div>