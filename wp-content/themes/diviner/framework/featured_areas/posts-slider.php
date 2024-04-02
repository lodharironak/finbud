<?php
/**
 *  Posts Slider File
 */
?>
    <div class="posts-slider featured-section">

        <div class="slider">
            <?php
            /* Start the Loop */

            $params = array( 'posts_per_page' =>  (int)$post_count, 'cat' => $category_slider );
            $featured   =   new WP_Query( $params );
            $count      =   0;
            if ( $featured->have_posts() ) {

                while ( $featured->have_posts() ) {
                    $featured->the_post(); ?>

                    <div class="slide-container no-gutters">
                        <div class="ps_slide">
                                <?php if ( has_post_thumbnail() ) { ?>
	                                <a class="post-thumbnail" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" aria-hidden="true">
                                    	<?php the_post_thumbnail('diviner_fp'); ?>
                                    </a>
                                <?php
                                }
                                else { ?>
	                                <a class="post-thumbnail" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" aria-hidden="true">
	                                    <img src="<?php echo esc_url( get_template_directory_uri() ) . '/assets/images/ph_ps.png'; ?>" alt="<?php the_title_attribute(); ?>">
	                                </a>
                                <?php
                                }
                            ?>
                            <div class="ps_title">
	                            <div class="ps_cats">
	                                <?php diviner_get_post_categories(); ?>
	                            </div>
	
	                            <h4 class="title-font" title="<?php the_title_attribute(); ?>">
	                                <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
	                                    <?php the_title(); ?>
	                                </a>
	                            </h4>
	                        </div>
                        </div>
                    </div>
                <?php
                $count++;
                }
            }
            wp_reset_postdata(); ?>
        </div>
    </div>