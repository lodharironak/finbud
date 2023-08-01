<?php
	the_custom_logo();
?>
	<h1 class="site-title title-font"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
	<?php
$diviner_description = get_bloginfo( 'description', 'display' );
if ( $diviner_description || is_customize_preview() ) :
	?>
	<p class="site-description"><?php echo esc_html($diviner_description); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
<?php endif; ?>