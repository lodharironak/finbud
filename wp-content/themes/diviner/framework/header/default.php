<?php

/**
 *	Search Form
 */
 function diviner_get_search() {

	get_template_part('framework/masthead/search/search');
 }
 add_action('diviner_search', 'diviner_get_search');


 /**
  *	Function for adding desktop Navigation via action
  */
  function diviner_navigation() {

 	 require get_template_directory() . '/framework/masthead/nav/navigation.php';

  }
  add_action('diviner_get_navigation', 'diviner_navigation');


 /**
  *	Function to add Mobile Navigation
  */
 function diviner_mobile_navigation() {

 	require get_template_directory() . '/framework/masthead/nav/navigation-mobile.php';

 }
  add_action('diviner_get_mobile_navigation', 'diviner_mobile_navigation');

 /**
  *	Function for adding Site Branding via action
  */

 function diviner_branding() {

 	require get_template_directory() . '/framework/masthead/branding/branding.php';

 }
 add_action('diviner_get_branding', 'diviner_branding');


 /**
  *	Function to add header image
  */
  function diviner_header_image() {
 ?>
 	 <div id="header-image">
 		 <?php the_header_image_tag(); ?>
 	 </div>
 <?php
  }
  add_action('diviner_get_header_image', 'diviner_header_image');


  /**
   *    Function to get the Advertisment Banner
   */

   function diviner_get_ad_banner() {
	   
		if (is_active_sidebar('sidebar-head')) :
			dynamic_sidebar('sidebar-head');
		endif;
            
   }
   add_action('diviner_ad_banner', 'diviner_get_ad_banner');


   function diviner_get_date_ticker() { ?>
       <div id="date-ticker">
           <div class="container">
               <div class="row no-gutters align-items-center">
	               <?php 
		               $local_time  = current_datetime();
					   $current_time = $local_time->getTimestamp() + $local_time->getOffset();
					?>
                   <div class="top_date col-md-2"><?php echo wp_date('j M, Y', $current_time); ?></div>
                   <div class="top_ticker col-md-7">
                   		<?php
                       $args = array(
                           'posts_per_page'        =>   4,
                           'ignore_sticky_posts'   =>   true
                       );

                       $ticker_query   =   new WP_Query( $args ); ?>
                        <div class="row">
                            <div class="col-2 align-items-center"><span><?php _e('LATEST: ', 'diviner' ); ?></span></div>
	                           <div class="col-10">
	                               <ul class="ticker-wrapper">
	
	                                   <?php
	                                   while( $ticker_query->have_posts() ) : $ticker_query->the_post();
	                                   ?>
	
	                                       <li class="ticker_post_title">
	                                               <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
	                                       </li>
	                                   <?php
	                                   endwhile;
	                                   wp_reset_postdata(); ?>
	
	                               </ul>
	                           </div>
                           </div>
                       </div>
                    <div id="social-icons" class="col-md-3">
                       <?php do_action("diviner_social_icons"); ?>
                   </div>
                </div>
           </div>
       </div>
    <?php
   }
   add_action('diviner_date_ticker', 'diviner_get_date_ticker');


function diviner_get_masthead( $layout = 'default') {

    switch ($layout) {
        case 'default':
        ?>
        <header id="masthead" class="site-header default">
	        
	        <div id="top-search">
    			<?php do_action( 'diviner_search' ); ?>
    		</div>
	        
	        <?php do_action('diviner_get_mobile_navigation'); ?>
	        
            <?php
            if ( !empty( get_theme_mod('diviner_ticker_enable', 1) ) ) :
                do_action('diviner_date_ticker');
            endif;
            ?>

    		<div class="container">

    			<div id="top-wrapper" class="row align-items-center">

                    <div class="site-branding col-md-3">
    					<?php do_action('diviner_get_branding'); ?>
                    </div>

                    <nav id="site-navigation" class="main-navigation col-md-8">
                            <?php do_action('diviner_get_navigation'); ?>
                        </nav>
                    <div id="search-icon" class="col-md-1">
			    		<button id="search-btn"><i class="fas fa-search"></i></button>
		    		</div>
    			</div>
    		</div>

    		<div id="header-image"></div>

    	</header><!-- #masthead -->
    <?php
        break;
        case 'full': ?>
        <header id="masthead" class="site-header full">
	        
	        <div id="top-search">
                <?php do_action( 'diviner_search' ); ?>
            </div>
	        
	        <?php do_action('diviner_get_mobile_navigation'); ?>

            <?php
            if ( !empty(get_theme_mod('diviner_ticker_enable', 1) ) ) :
                do_action('diviner_date_ticker');
            endif;
            ?>

            <div id="header-image">
	            
                <div id="top-wrapper">

                    <div class="container">

                        <div class="row align-items-center">

                            <div class="site-branding col-md-3">
            					<?php do_action('diviner_get_branding'); ?>
                            </div>

							<nav id="site-navigation" class="main-navigation col-md-8">
                            <?php do_action('diviner_get_navigation'); ?>
                        </nav>
	                        <div id="search-icon" class="col-md-1">
					    		<button id="search-btn"><i class="fas fa-search"></i></button>
				    		</div>

                        </div>

                    </div>
                    
                </div>
                
            </div>

        </header><!-- #masthead -->
        <?php
        break;
        case 'simple': ?>
        <header id="masthead" class="site-header simple">
	        
	        <?php do_action('diviner_get_mobile_navigation'); ?>

            <?php
            if ( !empty(get_theme_mod('diviner_ticker_enable', 1) ) ) :
                do_action('diviner_date_ticker');
            endif;
            ?>

            <div id="top-search">

                <?php

                	do_action( 'diviner_search' );

                //do_action('diviner_social_icons');

                ?>
            </div>

    		<div class="container">

    			<div id="top-wrapper" class="row align-items-center">

                    <div class="site-branding col-md-3">
                        <?php do_action('diviner_get_branding'); ?>
                    </div>

                    <nav id="site-navigation" class="main-navigation col-md-8">
                            <?php do_action('diviner_get_navigation'); ?>
                        </nav>
                    <div id="search-icon" class="col-md-1">
			    		<button id="search-btn"><i class="fas fa-search"></i></button>
		    		</div>

    			</div>

    		</div>
    		
    	</header><!-- #masthead -->
        <?php
        break;
        
        case 'ad': ?>
        <header id="masthead" class="site-header ad">
	        
	        <div id="top-search">
                <?php do_action( 'diviner_search' ); ?>
            </div>
	        
	        <?php do_action('diviner_get_mobile_navigation'); ?>

            <?php
            if ( !empty(get_theme_mod('diviner_ticker_enable', 1) ) ) :
                do_action('diviner_date_ticker');
            endif;
            ?>

            <div id="top-wrapper">
                <div class="container">
                    <div class="row align-items-center">

						<?php if ( is_active_sidebar('sidebar-head') ) : ?>
	                        <div class="site-branding col-md-4">
	                            <?php do_action('diviner_get_branding'); ?>
	                        </div>
							
							<div class="header-banner col-md-8">
	                        	<?php do_action('diviner_ad_banner'); ?>
	                        </div>
	                    <?php else : ?>
	                    	<div class="site-branding">
	                            <?php do_action('diviner_get_branding'); ?>
	                        </div>
	                    <?php endif; ?>

                    </div>
                </div>
                
                <div class="container">
	                <div class="row">
		                <nav id="site-navigation" class="main-navigation col-md-11">
                            <?php do_action('diviner_get_navigation'); ?>
                        </nav>
		                <div id="search-icon" class="col-md-1">
					    	<button id="search-btn"><i class="fas fa-search"></i></button>
				    	</div>
			    	</div>
                </div>
                
            </div>

            <?php if (has_header_image() && get_theme_mod('diviner_ad_header_img_enable') ) : ?>
                <div id="header-image"></div>
            <?php endif; ?>

        </header><!-- #masthead -->
        <?php
        break;
        default: ?>
        <header id="masthead" class="site-header default">
	        
	        <?php do_action('diviner_get_mobile_navigation'); ?>

            <?php
            if ( !empty(get_theme_mod('diviner_ticker_enable', 1) ) ) :
                do_action('diviner_date_ticker');
            endif;
            ?>

    		<div class="container">

    			<div id="top-wrapper" class="row align-items-center">

                        <div class="site-branding col-md-3">
        					<?php do_action('diviner_get_branding'); ?>
                        </div>

                        <nav id="site-navigation" class="main-navigation col-md-9">
                            <?php do_action('diviner_get_navigation'); ?>
                        </nav>

    			</div>

    		</div>

    		<div id="header-image">
                <div id="top-search">
        			<?php do_action( 'diviner_search' ); ?>
        		</div>
            </div>

    	</header><!-- #masthead -->
        <?php
    }
}
add_action('diviner_masthead', 'diviner_get_masthead', 10, 1);