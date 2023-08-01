<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package Diviner
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function diviner_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Adds a class of no-sidebar when there is no sidebar present.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	}

	return $classes;
}
add_filter( 'body_class', 'diviner_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function diviner_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'diviner_pingback_header' );


/**
 *	Pagination
 */
function diviner_get_pagination() {

	$args	=	array(
		'mid_size' => 2,
		'prev_text' => __( '<i class="fas fa-angle-left"></i>', 'diviner' ),
		'next_text' => __( '<i class="fas fa-angle-right"></i>', 'diviner' ),
	);

	the_posts_pagination($args);

}
add_action('diviner_pagination', 'diviner_get_pagination');


 /**
  *	Function to call Featured Image
	*/

	function diviner_get_featured_thumnail( $layout ) {

		if ( has_post_thumbnail() ) :
			?>
			<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'diviner_' . $layout ); ?></a>
			<?php
		else :
			$path = esc_url( get_template_directory_uri() ) . '/assets/images/ph_' . $layout . '.png';
			?>
			<a href="<?php the_permalink(); ?>"><img src="<?php echo $path; ?>" alt="Featured Thumbnail"></a>
		<?php
		endif;
	}
	add_action('diviner_featured_thumbnail', 'diviner_get_featured_thumnail', 10, 1);




	function diviner_get_post_categories() {

		$cats		=	wp_get_post_categories( get_the_ID() );
		$link_html	=	'<span class="cat-links"><i class="fas fa-folder"></i>';
		?>



		<?php
			foreach($cats as $cat) {
				$link_html	.=	'<a href=' . esc_url(get_category_link($cat)) . ' tabindex="0">' . esc_html(get_cat_name($cat)) . '</a>';
			}
			$link_html	.=	'</span>';
		echo $link_html;
		?>
		<?php
	}


	function diviner_get_comments() {
		
		if (empty(get_comments_number())) {
			return;
		}
		
		if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link"><i class="fas fa-comment"></i>';
			comments_popup_link('0', '1', '%', 'comments-link', 'Comments are disabled for this post');
			echo '</span>';
		}
	}


	/**
	 *	Function to generate meta data for the posts
	 */
function diviner_get_metadata() {
	if ( 'post' === get_post_type() ) :
		?>
			<div class="entry-meta">
				<?php
				diviner_posted_by();
				diviner_posted_on();
				diviner_get_comments();
				?>
			</div>
	<?php endif;
}
add_action('diviner_metadata', 'diviner_get_metadata');


/**
 *	Function to load Showcase Featured Area
 */
function diviner_get_showcase() {

	include_once get_template_directory() . '/framework/featured_areas/showcase.php';

}

 /**
  *	Function to load Featured Posts Area
  */
function diviner_get_featured_posts() {

	include_once get_template_directory() . '/framework/featured_areas/featured-posts.php';

}


/**
 *	Function for post content on Blog Page
 */
 function diviner_get_blog_excerpt( $length = 30 ) {

	 global $post;
	 $output	=	'';

	 if ( isset($post->ID) && has_excerpt($post->ID) ) {
		 $output = $post->post_excerpt;
	 }

	 elseif ( isset( $post->post_content ) ) {
		 if ( strpos($post->post_content, '<!--more-->') ) {
			 $output	=	get_the_content('');
		 }
		 else {
			 $output	=	wp_trim_words( strip_shortcodes( $post->post_content ), $length );
		 }
	 }

	 $output	=	apply_filters('diviner_excerpt', $output);

	 echo $output;
 }
 add_action('diviner_blog_excerpt', 'diviner_get_blog_excerpt', 10, 1);



function diviner_get_layout( $template = 'blog') {

	$layout	=	'framework/layouts/content';

	switch( $template ) {
		case 'blog':
			get_template_part( $layout, get_theme_mod('diviner_select_layout', 'blog') );
		break;
		case 'single':
			get_template_part( 'framework/layouts/content', 'single' );
		break;
		default:
			get_template_part( $layout, get_theme_mod('diviner_select_layout', 'blog') );
	}
}
add_action('diviner_layout', 'diviner_get_layout', 10, 1);


 /**
  *	Function for 'Read More' link
  */
  function diviner_read_more_link() {
	  ?>
	  <div class="read-more"><a href="<?php the_permalink() ?>"><?php _e('Read More', 'diviner'); ?></a></div>
	  <?php
  }


  /**
   *	Function to Enable Sidebar
   */
   function diviner_get_sidebar( $template = 'blog' ) {

	   global $post;

	   switch( $template ) {

		   case "front":
		   if ( is_front_page() ) {
			   get_sidebar('front');
		   }
		   break;
		   case "blog";
		   	if (strpos(get_theme_mod('diviner_select_layout', 'blog'), '_s') ) {
		   		get_sidebar();
			}
			break;
			case "wc":
			if ( class_exists('woocommerce') && "col_s" == get_theme_mod('diviner_wc_sidebar_layout', 'col_s') ) {
				get_sidebar('wc');
			}
		   break;
		   case "single":
		   		if (is_single() && strpos(get_theme_mod('diviner_post_sidebar_layout', 'col_s'), '_' ) ) {
					get_sidebar('single');
				}
			break;
			case "page":
				if ( "" == get_post_meta($post->ID, 'hide-sidebar', true) ) {
					get_sidebar('page');
				}
			break;
		   default:
		   	get_sidebar();
	   }
   }
   add_action('diviner_sidebar', 'diviner_get_sidebar', 10, 1);



 /**
  *	Function for Sidebar alignment
  */
function diviner_sidebar_align( $template = 'blog' ) {

	// switch ( $template ) :
		// case "page":
		// $align 		= get_post_meta( get_the_ID(), 'align-sidebar', true );
		// break;
	if ( in_array( $template, ['page'] ) ) {
		$align 		=	get_post_meta( get_the_ID(), 'align-sidebar', true );
	}
	else {
		$align 		=	get_theme_mod('diviner_' . $template . '_sidebar_align', 'right');
	}

	$align_arr	=	['order-1', 'order-2'];

	if ( in_array( $template, ['front', 'single', 'blog', 'page', 'wc'] ) ) {
		return 'right' == $align ? $align_arr : array_reverse($align_arr);
	}
	else {
		return $align_arr;
	}
}



/**
 *	Function for footer section
 */
 function diviner_get_footer_section() {

	$path 	=	'/framework/footer/footer';
	get_template_part( $path, get_theme_mod( 'diviner_footer_cols', 4 ) );
 }
 add_action('diviner_footer_section', 'diviner_get_footer_section');


 /**
  *	Function to get Social icons
  */
 function diviner_get_social_icons() {
 	get_template_part('social');
 }
 add_action('diviner_social_icons', 'diviner_get_social_icons');


 /**
  *	Get Custom sizes for 'image' post format
  */
  function diviner_thumb_dim( $id, $size ) {

	$img_array	=	wp_get_attachment_image_src( $id, $size );

	$dim	=	[];
	$dim['width']	= $img_array[1];
	$dim['height']	= $img_array[2];

	return $dim;

}

function diviner_get_site_layout() {

	echo esc_html( get_theme_mod('diviner_site_layout', 'box') ) == 'box' ? 'container' : '';

}
add_action('diviner_site_layout', 'diviner_get_site_layout');


/**
 *	The About Author Section
 */
function diviner_get_about_author( $post ) { ?>
	<div id="author_box" class="row no-gutters">
		<div class="author_avatar col-2">
			<?php echo get_avatar( intval($post->post_author), 96 ); ?>
		</div>
		<div class="author_info col-10">
			<h4 class="author_name title-font">
				<?php echo get_the_author_meta( 'display_name', intval($post->post_author) ); ?>
			</h4>
			<div class="author_bio">
				<?php echo get_the_author_meta( 'description', intval($post->post_author) ); ?>
			</div>
		</div>
	</div>
<?php
}
add_action('diviner_about_author', 'diviner_get_about_author', 10, 1);

/**
 *	Function to add featured Areas before Content
 */
function diviner_get_before_content() {

	if ( is_front_page() && !is_home() && is_active_sidebar('before-content') ) :
		dynamic_sidebar('before-content');
	endif;

}
add_action('diviner_before_content', 'diviner_get_before_content');


  /**
   *	Function to add Content to the front page area
   */
   function diviner_get_front_page_content() { ?>
	   <div class="col">
		   <?php if ( is_active_sidebar('above-content' ) ) :
			   dynamic_sidebar('above-content');
		   endif; ?>
		   <div class="row no-gutters">
			   <div class="col-md-6">
				   <?php if ( is_active_sidebar('left-content' ) ) :
					   dynamic_sidebar('left-content');
				   endif; ?>
			   </div>
			   <div class="col-md-6">
				   <?php if ( is_active_sidebar('right-content' ) ) :
					   dynamic_sidebar('right-content');
				   endif; ?>
			   </div>
		   </div>
	   </div>
	<?php
   }
   add_action('diviner_front_page_content', 'diviner_get_front_page_content');


  /**
   *	Function to add Featured Areas After Content
   */
   function diviner_get_after_content() {

	    if ( is_front_page() && is_active_sidebar('after-content') ) :
			dynamic_sidebar('after-content');
		endif;
   }
   add_action('diviner_after_content', 'diviner_get_after_content');
   
   
/**
 *	Function for AJAX request to get meta data of page set as Front Page
**/

add_action('wp_ajax_front_page_meta', 'diviner_front_page_ajax');
function diviner_front_page_ajax() {
	
	$page_id	=	intval( $_POST['id'] );
	$path		=	get_page_template_slug($page_id);

	echo $path;
	
	wp_die();
	
}