<?php
/**
 
 	Template name: development
 
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
 					$banner_img = $value['banner_image'];
 					$banner_btn = $value['banner_link'];
 					if (!empty($value)) {
 						?> 
 						<div style="background-image: url(<?php echo $banner_img['url'];?>)">
 							<div class="banner-contain ">
 								<h1><?php echo $value['banner_title'];?></h1>
 								<p><?php echo $value['banner_content'];?></p>
 								<h3><?php echo $value['banner_phn'];?></h3>
 								<p><?php echo $value['banner_week'];?></p>
 								<a href="<?php echo $banner_btn['url'];?>" class="btn" target="<?php echo esc_attr($banner_btn['target'])?>" ><?php echo $banner_btn['title'];?><i class="fa fa-angle-double-right" aria-hidden="true"></i></a>
 							</div>
 						</div>
 					<?php } ?>
 				<?php } ?>
 			</div>
 			<div class="bridging-icon-section">
 				<div class="container">
 					<div class="bridging-icon-inner">
 						<?php 
 						$icon = get_field('icon');
 						foreach ($icon as $icon_values) {
 							$icon_img = $icon_values['icon_image'];?>
 							<div class="bridging-icon-third">
 								<div class="bridging-icon-content">
 									<div class="bridging-icon-img">
 										<img src="<?php echo $icon_img['url']; ?>" alt="icon">
 									</div>
 									<h4><a herf="#"><?php echo $icon_values['icon_title']; ?></a></h4>
 								</div>
 							</div>
 						<?php } ?>
 					</div>
 				</div>
 			</div>
 			<?php if(have_rows('content')):
 				while (have_rows('content')) : the_row();?>
 					
 					<?php if(get_row_layout() == 'white_background_content'):

 						$white_title = get_sub_field('white_title');
 						$white_content = get_sub_field('white_content');
 						?>
 						<div class="about-content-section">
 							<div class="container">
 								<div class="about-content-inner">
 									<?php if(!empty($white_title)) { ?>
 										<div class="heading">
 											<h2><?php echo $white_title; ?></h2>
 										</div>
 									<?php } ?>
 									<?php if(!empty($white_content)) { ?><?php echo $white_content; ?><?php } ?>
 								</div>
 							</div>
 						</div>
 					<?php endif; ?>
 					<?php if(get_row_layout() == 'grey_background_content'): ?> 
 						<?php 
 						$grey_title = get_sub_field('grey_title'); 
 						$grey_content = get_sub_field('grey_content');
 						?>
 						<div class="about-content-section bg-gray">
 							<div class="container">
 								<div class="about-content-inner">
 									<?php if ($grey_title) { ?>
 										<h5>
 											<?php echo $grey_title; ?>
 											</h5><?php } ?>
 											<?php if ($grey_content) { ?>
 												<?php echo $grey_content; ?>
 											<?php } ?>
 										</div>
 									</div>
 								</div>
 							<?php endif; ?>
 							<?php if(get_row_layout() == 'grey_background_content_center'): ?>
 								<?php
 								$grey_title_center = get_sub_field('grey_title_center');
 								$grey_content_center = get_sub_field('grey_content_center');
 								?>
 								<div class="about-content-section bg-gray text-center">
 									<div class="container">
 										<div class="about-content-inner">
 											<?php if (!empty($grey_title_center)) { ?> 
 												<div class="heading"> 
 													<h2><?php echo $grey_title_center; ?></h2>
 												</div>
 											<?php } ?>
 											<?php if (!empty($grey_content_center)) { ?>
 												<p><?php echo $grey_content_center; ?> </p>
 											<?php } ?>
 										</div>
 									</div>
 								</div> 			
 							<?php endif; ?>
 						<?php endwhile; ?>
 					<?php endif; ?>
 				</section>
 			<?php endwhile; ?>
 			<?php
 			get_footer();
 			?>