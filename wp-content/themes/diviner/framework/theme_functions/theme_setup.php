<?php

if ( ! function_exists( 'diviner_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function diviner_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Diviner, use a find and replace
		 * to change 'diviner' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'diviner', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(
			array(
				'menu-1' 		=> esc_html__( 'Primary Navigation', 'diviner' ),
				'menu-mobile'	=>	esc_html__( 'Mobile Navigation', 'diviner')
			)
		);

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'widgets',
				'style',
				'script',
			)
		);


		// Add support for image post format
		add_theme_support('post-formats', array('image') );


		// Set up the WordPress core custom background feature.
		add_theme_support(
			'custom-background',
			apply_filters(
				'diviner_custom_background_args',
				array(
					'default-color' => 'ffffff',
					'default-image' => '',
				)
			)
		);

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 *	Add different sizes for featured images
		 */
		 add_image_size('diviner_blog', 1000, 600, true);
		 add_image_size('diviner_grid', 600, 600, true);
		 add_image_size('diviner_fp', 1000, 700, true);
		 add_image_size('diviner_small', 640, 0, false);
	  	 add_image_size('diviner_medium', 1280, 0, false);
		 add_image_size('diviner_large', 1920, 0, false);


		 /**
	 	 *	Add Stylesheet for Editor
	 	 */
	 	 add_theme_support( 'editor-styles');
	 	add_editor_style( 'assets/theme-styles/css/editor-style.css');


		/**
		 *	Add Support for WooCommerce
		 */
		 add_theme_support('woocommerce');
		 add_theme_support( 'wc-product-gallery-zoom' );
		add_theme_support( 'wc-product-gallery-lightbox' );
		add_theme_support( 'wc-product-gallery-slider' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 100,
				'width'       => 300,
				'flex-width'  => true,
				'flex-height' => true,
			)
		);
	}


endif;
add_action( 'after_setup_theme', 'diviner_setup' );