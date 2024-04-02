<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Diviner
 */

if ( ! is_active_sidebar( 'sidebar-wc' ) ) {
	return;
}
?>


<aside id="secondary" class="widget-area <?php echo diviner_sidebar_align( 'wc' )[1]; ?>">
	<?php dynamic_sidebar( 'sidebar-wc' ); ?>
</aside><!-- #secondary -->