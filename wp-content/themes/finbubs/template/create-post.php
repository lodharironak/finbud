<?php
/**
 
 	Template name: Commerical_Page
 
 */
 	get_header();
 	?>
 	<?php
 	while ( have_posts() ) :
 		the_post();

 		?>
 		
 		
 		<section class="main-body">

 			<div class="banner-section bridging-section ">
 				<?php 
 				$banner_section = get_field('banner_section');
 				foreach ($banner_section as $value) {
 					$banner_img = $value['banner_imge'];?>
 					<div style="background-image: url(<?php echo $banner_img['url'];?>)">
 						<?php if(!empty($value)) { ?>
 							<div class="banner-contain ">
 								<h1><?php echo $value['banner_title'];?></h1>
 								<p><?php echo $value['banner_content'];?></p>
 								<h3><?php echo $value['banner_number'];?></h3>
 								<p><?php echo $value['banner_week'];?></p>
 								<a href="#" class="btn">Request a call back <i class="fa fa-angle-double-right" aria-hidden="true"></i></a>
 							</div>
 						<?php } ?>
 					</div>
 				<?php } ?>
 			</div>
 			<?php if( have_rows('content') ):
 				while ( have_rows('content') ) : the_row();?> 
 					<?php if( get_row_layout() == 'grey_background_content' ):
 						$grey_title = get_sub_field('grey_title');
 						$grey_content = get_sub_field('grey_content');?>

 						<div class="about-content-section bg-gray">
 							<div class="container">
 								<div class="about-content-inner">
 									<?php if(!empty($grey_title)): ?>
 										<div class="heading">
 											<h2><?php echo $grey_title; ?></h2>
 										</div>
 									<?php endif; ?>
 									<?php if(!empty($grey_content)): ?>
 										<?php echo $grey_content; ?>
 									<?php endif; ?>
 								</div>
 							</div>
 						</div>
 					<?php endif;?>
 					
 					<?php if( get_row_layout() == 'white_background_content' ):
 						$white_title = get_sub_field('white_title');
 						$white_content = get_sub_field('white_content');?>
 						<div class="about-content-section">
 							<div class="container">
 								<div class="about-content-inner">
 									<?php if (!empty($white_title)) {?>
 										<div class="heading">
 											<h2><?php echo $white_title;?></h2>
 										</div>
 									<?php } ?>
 									<?php if (!empty($white_content)) {?>
 										<?php echo $white_content; ?>
 									<?php } ?>
 								</div>
 							</div>
 						</div>
 					<?php endif;?>
 				<?php endwhile; ?>
 			<?php endif;?>
 		</section>
 	<?php endwhile;?> 
 	<?php 
 	get_footer();
 	?>