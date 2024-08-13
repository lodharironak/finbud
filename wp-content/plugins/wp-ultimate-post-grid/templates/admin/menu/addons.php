<?php
/**
 * Template for the addons page.
 *
 * @link       https://bootstrapped.ventures
 * @since      3.0.0
 *
 * @package    WP_Ultimate_Post_Grid
 * @subpackage WP_Ultimate_Post_Grid/templates/admin/menu
 */

?>

<div class="wrap wpupg-addons">
	<h1><?php echo esc_html_e( 'Upgrade WP Ultimate Post Grid', 'wp-ultimate-post-grid' ); ?></h1>
	<div class="wpupg-addons-bundle-container">
		<h2>Premium Bundle</h2>
		<?php if ( WPUPG_Addons::is_active( 'premium' ) ) : ?>
		<p>You already have these features!</p>
		<?php else : ?>
		<ul>
			<li>Limit your posts by any taxonomy, author, date or post ID</li>
			<li>Use a plain text filter for your grid</li>
			<li>Have dropdown filters for any taxonomy</li>
			<li>Allow for multiselect in the filters</li>
			<li>Show the post count for the filter terms</li>
			<li>Extensive Template Editor to create any grid you want</li>
			<li>Create a grid of your categories or tags</li>
			<li>A Load More button for pagination</li>
			<li>Load on filter pagination</li>
			<li>Infinite scroll pagination</li>
			<li>Easily clone your grids</li>
			<li>Order grid by custom field</li>
			<li>Dynamically filter grids in the shortcode</li>
			<li>...and more coming up!</li>
		</ul>
		<div class="wpupg-addons-button-container">
			<a class="button button-primary" href="https://bootstrapped.ventures/wp-ultimate-post-grid/get-the-plugin/" target="_blank">Learn More</a>
		</div>
		<?php endif; // Premium active. ?>
	</div>
</div>
