<?php
/**
 * Register Front Page.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function diviner_widgets_init() {

	$layout	=	get_theme_mod('diviner_site_layout', 'box');

	if ( $layout == 'box') :
		$container	=	'container';
	else :
		$container	=	'';
	endif;

	register_sidebar(
		array(
			'name'          => esc_html__( 'Primary Sidebar', 'diviner' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'This is the general fallback Sidebar for the theme. Add widgets here.', 'diviner' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h3 class="widget-title title-font"><span>',
			'after_title'   => '</span></h3>',
		)
	);
	
	register_sidebar(
		array(
			'name'          => esc_html__( 'Header : Ad Area', 'diviner' ),
			'id'            => 'sidebar-head',
			'description'   => esc_html__( 'Sidebar Area in Header dedicated for Advertisement. Avoid using any other widgets here. Recommended dimension - 728 x 90', 'diviner' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h3 class="widget-title title-font"><span>',
			'after_title'   => '</span></h3>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__( 'Single Sidebar', 'diviner' ),
			'id'            => 'sidebar-2',
			'description'   => esc_html__( 'Sidebar for Single Posts. Add Widgets Here.', 'diviner' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s container">',
			'after_widget'  => '</section>',
			'before_title'  => '<h3 class="widget-title title-font"><span>',
			'after_title'   => '</span></h3>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__( 'Page Sidebar', 'diviner' ),
			'id'            => 'sidebar-page',
			'description'   => esc_html__( 'Sidebar for Pages. Add Widgets Here.', 'diviner' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s container">',
			'after_widget'  => '</section>',
			'before_title'  => '<h3 class="widget-title title-font"><span>',
			'after_title'   => '</span></h3>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__( 'WooCommerce Sidebar', 'diviner' ),
			'id'            => 'sidebar-wc',
			'description'   => esc_html__( 'Add Widgets to the WooCommerce Pages.', 'diviner' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s container">',
			'after_widget'  => '</section>',
			'before_title'  => '<h3 class="widget-title title-font"><span>',
			'after_title'   => '</span></h3>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__( 'Front Page Sidebar', 'diviner' ),
			'id'            => 'sidebar-front',
			'description'   => esc_html__( 'Sidebar for Front Page.', 'diviner' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s container">',
			'after_widget'  => '</section>',
			'before_title'  => '<h3 class="widget-title title-font"><span>',
			'after_title'   => '</span></h3>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__( 'Front Page : Before Content', 'diviner' ),
			'id'            => 'before-content',
			'description'   => esc_html__( 'Add Widgets before the Content Area.', 'diviner' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s ' . $container . '">',
			'after_widget'  => '</section>',
			'before_title'  => '<h3 class="widget-title title-font"><span>',
			'after_title'   => '</span></h3>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__( 'Front Page : After Content', 'diviner' ),
			'id'            => 'after-content',
			'description'   => esc_html__( 'Add Widgets After the Content Area.', 'diviner' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s ' . $container . '">',
			'after_widget'  => '</section>',
			'before_title'  => '<h3 class="widget-title title-font"><span>',
			'after_title'   => '</span></h3>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__( 'Front Page: Above Content', 'diviner' ),
			'id'            => 'above-content',
			'description'   => esc_html__( 'Add Widgets to the Area above Content Area.', 'diviner' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s container">',
			'after_widget'  => '</section>',
			'before_title'  => '<h3 class="widget-title title-font"><span>',
			'after_title'   => '</span></h3>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__( 'Front Page: Left Content', 'diviner' ),
			'id'            => 'left-content',
			'description'   => esc_html__( 'Add Widgets to the Left Column of Content Area.', 'diviner' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s container">',
			'after_widget'  => '</section>',
			'before_title'  => '<h3 class="widget-title title-font"><span>',
			'after_title'   => '</span></h3>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__( 'Front Page: Right Content', 'diviner' ),
			'id'            => 'right-content',
			'description'   => esc_html__( 'Add Widgets to the Right Column of Content Area.', 'diviner' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s container">',
			'after_widget'  => '</section>',
			'before_title'  => '<h3 class="widget-title title-font"><span>',
			'after_title'   => '</span></h3>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer Sidebar 1', 'diviner' ),
			'id'            => 'footer-1',
			'description'   => esc_html__( 'Footer Sidebar Column 1', 'diviner' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h3 class="widget-title title-font">',
			'after_title'   => '</h3>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer Sidebar 2', 'diviner' ),
			'id'            => 'footer-2',
			'description'   => esc_html__( 'Footer Sidebar Column 2', 'diviner' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h3 class="widget-title title-font">',
			'after_title'   => '</h3>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer Sidebar 3', 'diviner' ),
			'id'            => 'footer-3',
			'description'   => esc_html__( 'Footer Sidebar Column 3', 'diviner' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h3 class="widget-title title-font">',
			'after_title'   => '</h3>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer Sidebar 4', 'diviner' ),
			'id'            => 'footer-4',
			'description'   => esc_html__( 'Footer Sidebar Column 4', 'diviner' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h3 class="widget-title title-font">',
			'after_title'   => '</h3>',
		)
	);
}
add_action( 'widgets_init', 'diviner_widgets_init' );