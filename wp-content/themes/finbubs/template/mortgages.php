<?php
/**
 
 	Template name: Mortgages
 
 */
get_header();
?>

	<main id="primary" class="site-main">
		<section class="main-body">
			<!-- Banner Section -->
			<div class="banner-section bridging-section ">
				<?php 
                       $banner = get_field('mortage-banner');
                       foreach( $banner as $image ){
                           ?>
					    	<?php 
						$img = $image['banner-img'];
                        if( !empty($img) ){
					    ?>
                <div style="background-image: url(<?php echo $img['url'];?>)">
                    <div class="banner-contain ">
                        <h1><?php echo $image['banner-head']; ?></h1>
                        <p><?php echo $image['banner-content']; ?></p>
                        <h3><?php echo $image['banner-no']; ?></h3>
                        <p><?php echo $image['banner-week']; ?></p>
                        <?php $btn = $image['banner-btn']; 
    							    $link_url = $btn['url'];
    							    $link_title = $btn['title'];
    					?>
                        <a class="btn" href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"><?php echo esc_html( $link_title ); ?><i class="fa fa-angle-double-right" aria-hidden="true"></i></a>
                    </div>
                </div>
            <?php }?>
        <?php }?>
            </div>
            	<?php
					if( have_rows('content') ):
				?>
   			<?php while ( have_rows('content') ) : the_row();?>	
   				
        	<?php if( get_row_layout() == 'add_content' ):?>

	        	<div class="about-content-section bad-content-section">
	                <div class="container">
	                    <div class="about-content-inner">
	                        <div class="heading">
	                            <h2><?php echo get_sub_field('bad_credit_head')?></h2>
	                        </div>
	                        <p><?php echo get_sub_field('bad-credit-content')?></p>
	                    </div>
	                </div>
	            </div>
	            <div class="bridging-icon-section bad-icon-section">
                	<div class="container">
                    	<div class="bridging-icon-inner">
                    		<?php 
                    		$bridgings = get_sub_field('bridging');
                    		foreach ($bridgings as $bridge) {
                    		?>
                    		<?php 
							$img = $bridge['bridging-icon-img'];
	                        if( !empty($img) ){
						    ?>
                    		<div class="bridging-icon-fourth">
	                            <div class="bridging-icon-content">
	                                <div class="bridging-icon-img">
	                                    <img src="<?php echo $img['url'];?> " alt="Icon">
	                                </div>
	                                <?php $btn = $bridge['bridging-link']; 
	                                	  $bridge_link = $btn['url']
	                                ?>
	                                	<h4><a href="<?php echo esc_url( $bridge_link ); ?>">
	                                		<?php echo $bridge['bridging-content']; ?>
	                                		<?php get_the_date();?>
	                                	</a></h4>
	                            </div>
                        	</div>
                    		<?php } ?>
                    		<?php }?>
                    	</div>
                    </div>
                </div>
            <?php endif; ?>

            <?php if( get_row_layout() == 'grey_background_with_content' ):
        	?>
	       		<div class="about-content-section bg-gray">
	                <div class="container">
	                    <div class="about-content-inner">
	                        <div class="heading">
	                            <h2><?php echo get_sub_field('grey_background_title')?></h2>
	                        </div>
	                        <?php echo get_sub_field('grey_background__content')?>
	                    </div>
	                </div>
	            </div>
            <?php endif;?>

            <?php if( get_row_layout() == 'white_background_with_content' ):
        	?>
	        	<div class="about-content-section">
	                <div class="container">
	                    <div class="about-content-inner">
	        				<div class="heading">
	                            <h2><?php echo get_sub_field('white_background_title')?></h2>
	                        </div>
	        				<?php echo get_sub_field('white_background_content')?>
	                    </div>
	                </div>
	            </div>
            <?php endif;?>
     <?php endwhile; ?>
  <?php endif;
?>
 
		</section>
	</main><!-- #main -->

<?php
// get_sidebar();
get_footer();
