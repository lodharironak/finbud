<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Diviner
 */

?>
</div><!--- .row --->
</div><!--- #content-wrapper --->

<?php do_action('diviner_after_content'); ?>

<?php do_action('diviner_footer_section'); ?>

	<footer id="colophon" class="site-footer">
		<div class="site-info">
			<?php printf(esc_html__('Theme Designed by %s', 'diviner'), '<a href="https://www.indithemes.com">IndiThemes</a>'); ?>
			<span class="sep"> | </span>
				<?php echo ( get_theme_mod('diviner_footer_text') == '' ) ? ('Copyright &copy; '.date_i18n( esc_html__( 'Y', 'diviner' ) ).' ' . esc_html( get_bloginfo('name') ) . esc_html__('. All Rights Reserved. ','diviner')) : esc_html(get_theme_mod('diviner_footer_text')); ?>
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<nav id="menu" class="panel" role="navigation">
	<button class="go-to-bottom"></button>
	<button id="close-menu" class="menu-link"><i class="fa fa-times"></i></button>
	
	<?php wp_nav_menu( array( 'menu_id'        => 'mobile-menu',
							  'container'		=> 'ul',
	                          'theme_location' => 'menu-mobile',
	                          'walker'         => has_nav_menu('menu-mobile') ? new Diviner_Mobile_Menu : '',
	                     ) ); ?>
	                     
	<button class="go-to-top"></button>
</nav>

<?php wp_footer(); ?>

</body>
</html>