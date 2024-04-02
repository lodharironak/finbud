<?php
/**
 	Template name:home
 */

    get_header();
    ?>

    <main id="primary" class="site-main">

      <?php
      while ( have_posts() ) :
         the_post();

         ?>
         <!-- Banner Start -->
         <section class="main-body">
            <div class="banner-section">
                <div class="lazy slider" data-sizes="50vw">
                    <?php 
                    $banner = get_field('banner');
                    foreach( $banner as $image ){
                      $img = $image['banner-img'];
                      if( !empty($img) ){
                       ?>
                       <div style="background-image: url(<?php echo $img['url']; ?>); width:  1351px; background-repeat: no-repeat; background-position: center; background-size: cover;">

                        <?php if(!empty($image)) { ?>
                           <div class="banner-contain">
                               <h1><?php echo $image['banner-title']; ?></h1>
                               <p><?php echo $image['banner-txt']; ?></p>
                               <h4><?php echo $image['save-money']; ?></h4>
                               <h3><?php echo $image['banner-no']; ?></h3>
                               <p><?php echo $image['banner-txt']; ?></p>
                               <?php $btn = $image['banner-btn']; 
                               $link_url = $btn['url'];
                               $link_title = $btn['title'];
                               ?>
                               <a class="btn" href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"><?php echo esc_html( $link_title ); ?><i class="fa fa-angle-double-right" aria-hidden="true"></i></a>
                           </div>
                       <?php } ?>
                   </div>
               <?php }?> 
           <?php } ?>
       </div>          
   </div>
   <!-- Banner end -->

   <!-- SERVICE SECTION START-->
   <div class="services-section">
    <div class="container">
        <?php 
        $query = new WP_Query( array( 'post_type' => 'service') );
        if ( $query->have_posts() ) : ?>
            <div class="services-slider slider" data-sizes="50vw">
                <?php while ( $query->have_posts() ) : $query->the_post();?>
                    <div class="services-inner">
                        <div class="services-img">
                            <?php echo get_the_post_thumbnail( $post_id, 'thumbnail');?>
                        </div>
                        <div class="services-des">
                            <h5><?php echo get_the_title($post_id->ID); ?></h5>
                            <?php $excerpt = get_the_excerpt($post_id->ID); ?>
                            <p><?php echo $excerpt; ?></p>
                            <a href="<?php echo esc_url( get_permalink() ); ?>" class="btn btn-transparent"><?php esc_html_e( 'Learn More', 'finbubs' ); ?><i class="fa fa-angle-double-right" aria-hidden="true"></i></a>
                        </div>
                    </div>
                <?php endwhile; wp_reset_postdata(); ?>
            </div>
            <?php else : ?>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- SERVICE SECTION END-->
    <!-- about Start -->
    
    <div class="about-section">
        <div class="about-inner">
            <?php
            global $post;
            $pid = $post->ID;
            $image = wp_get_attachment_image_src( get_post_thumbnail_id( $pid ), 'single-post-thumbnail' );
            ?>
            <div class="about-half bg-img" style="background-image: url(<?php echo $image['0']; ?>)">
                <h2><?php esc_html_e( 'HOME BUYERS GUIDE', 'finbubs' ); ?></h2>
            </div>
            <div class="about-half">
                <div class="about-content">
                    <div class="heading">
                        <?php echo get_the_content($pid);  ?>
                    </div>
                </div>
            </div>  
        </div>
    </div>
    <!-- Lastest news sec -->
    <div class="blog-section">
        <div class="container">
            <div class="heading text-center">
                <h2><?php esc_html_e('LATEST NEWS' , 'finbubs')?></h2>
            </div>
            <div class="blog-inner">
                <?php
                $lastest_news = get_field('news_post');
                if(!empty($lastest_news)): ?>
                    <?php foreach( $lastest_news as $lastest_news ): ?>
                        <div class="blog-third">
                        	<div class="blog-content">
                                <div class="blog-img">
                                    <?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $lastest_news->ID ), 'single-post-thumbnail' );?>
                                    <img src="<?php echo $image['0']; ?>" alt="News">
                                </div>
                                <div class="blog-des">
                                   <h5><?php echo get_the_title($lastest_news->ID); ?></h5>
                                   <div class="blog-date">
                                    <i class="fa fa-calendar" aria-hidden="true"></i>
                                    <?php echo '<span class="pub-date">'.get_the_date( 'Y/m/d g:i:s A', $lastest_news->ID).'</span>';?>
                                </div>
                                <?php $excerpt = get_the_excerpt($lastest_news->ID); ?>
                                <p><?php echo $excerpt; ?></p>
                                <?php $btn = get_field('get-btn'); 
                                $link_url = $btn['url'];
                                $link_title = $btn['title'];
                                ?>
                                <a class="btn btn-transparent" href="<?php echo esc_url( get_permalink() ); ?>"target="<?php echo esc_attr( $link_target ); ?>"><?php esc_html_e( 'Read More', 'finbubs' ); ?><i class="fa fa-angle-double-right" 
                                    aria-hidden="true"></i></a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif;?>
            </div>
            
            <div class="blog-btn text-center"> 
                <?php $btn = get_field('get-btn'); 
                $link_url = $btn['url'];
                $link_title = $btn['title'];
                ?>
                <a class="btn btn-transparent" href="<?php echo esc_url( get_permalink() ); ?>"target="<?php echo esc_attr( $link_target ); ?>"><?php esc_html_e( 'View All News', 'finbubs' ); ?><i class="fa fa-angle-double-right" aria-hidden="true"></i></a>
            </div>
        </div>
    </div>
    <!-- blog end -->

    <!-- Get in touch section -->
    
    <div class="advisors-section">
        <div class="container fluid">
            <div class="heading">
                <h2><?php echo get_field('get-head'); ?></h2>
            </div>
            <div class="advisors-inner">
                <?php 
                $image = get_field('get-tel-img');
                if( !empty( $image ) ): ?>
                  <a href="<?php echo esc_url( home_url( '/' ) );?>" rel="home_url"><img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>">
                  </a>
              <?php endif; 
              ?>
              <h3><?php echo get_field('get-no'); ?></h3>
              <p><?php echo get_field('get-week'); ?></p>
              <?php $btn = get_field('get-btn');
              $link_url = $btn['url'];
              $link_title = $btn['title'];
              ?>
              <a class="btn btn-transparent" href="<?php echo esc_url( get_permalink() ); ?>" target="<?php echo esc_attr( $link_target ); ?>"><?php echo esc_html( $link_title ); ?><i class="fa fa-angle-double-right" aria-hidden="true"></i></a>
          </div>
      </div>
  </div>
</section>
<?php endwhile; // End of the loop.?>
</main><!-- main -->
<?php
// get_sidebar();
get_footer();


