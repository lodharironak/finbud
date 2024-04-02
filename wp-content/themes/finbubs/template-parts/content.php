<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package finbubs
 */

?>
<div class="blog-third">
	<div class="blog-content">
		<!-- <div class="blog-img"> -->
			<?php finbubs_post_thumbnail(); 
			?>
		<!-- </div> -->
		<div class="blog-des">
			<?php 
				the_title( '<h5><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h5>' );
			?>
			<div class="blog-date">
	            <i class="fa fa-calendar" aria-hidden="true"></i>
	            <?php echo '<span class="pub-date">'.get_the_date( 'Y/m/d g:i:s A').'</span>';?>
	        </div>
	        <?php
				the_excerpt();
			?>
			<?php $btn = get_field('get-btn'); 
					    $link_url = $btn['url'];
						$link_title = $btn['title'];
			?>
			<a class="btn btn-transparent" href="<?php echo esc_url( get_permalink() ); ?>" target="<?php echo esc_attr( $link_target ); ?>"><?php esc_html_e( 'Read More', 'finbubs' ); ?><i class="fa fa-angle-double-right" aria-hidden="true"></i></a>
		</div>	
	</div>
</div>

