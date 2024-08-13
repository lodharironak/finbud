<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package finbubs
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
  <?php wp_body_open(); ?>
  <div id="page" class="site">
   <!-- Header start  -->
   <header>
    <div class="header-top">
      <div class="container">
        <div class="logo">
          <?php 
          $image = get_field('logo', 'option');
          if( !empty( $image ) ): ?>
           <a href="<?php echo esc_url( home_url( '/' ) );?>" rel="home_url"><img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>">
           </a>
         <?php endif; 
         ?>
       </div>
       <?php 
       $save_output_here = custom_search_popup();
       ?>
       <div class="header-btn">
        <button>
          <div id="ex1" class="modal">
            <form autocomplete="off" action="">
              <div class="autocomplete" style="width:300px;">
                <input id="myInput" type="text" name="myCountry" placeholder="Search">
              </div>
            </form>
            <a href="#" rel="modal:close">Close</a>
          </div>
          <a href="#ex1" rel="modal:open">Search</a>
        </button>
      </div> 
      
      <div class="tele-div">
        <?php 
        $image = get_field('tele-img', 'option');
        if( !empty( $image ) ): ?>
         <a href="<?php echo esc_url( home_url( '/' ) );?>" rel="home_url"><img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>">
         </a>
       <?php endif; 
       ?>
       <div class="tele-des">
         <p><?php echo get_field('Call-us','option'); ?></p>
         <h3><a><?php echo get_field('tele-no','option'); ?></a></h3>
         <p><span><?php echo get_field('week','option'); ?></span></p>
       </div>
     </div>
   </div>
 </div>
 <!-- Header top menu end -->
 <!-- Main menu Start -->
 <div class="header-main">
  <div class="container">
    <a class="menu-btn sb-toggle-right" id="nav-icon1" href="#menu12"></a>
    <div class="menu menu-desktop">
      <?php
      wp_nav_menu(
        array(
         'theme_location' => 'menu-1',
         'menu_id'        => 'primary-menu',)
      ); 
      ?>
    </div> 
  </div>
</div>

<!-- Main menu End -->
</header>