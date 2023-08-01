<div class="featposts fp-thumb-2">
    <div class="row no-gutters">
        <?php
        /* Start the Loop */

        $params = array( 'posts_per_page' =>  4, 'cat' => $category );
        $featured   =   new WP_Query( $params );
        $count      =   0;
        
        if ( $featured->have_posts() ) {

            while ( $featured->have_posts() ) {
                $featured->the_post(); ?>

                <div class="featured-post col-md-6 row no-gutters">
                    <div class="fp_thumb">
                            <?php if ( has_post_thumbnail() ) { ?>
                                <a class="post-thumbnail" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" aria-hidden="true">
                                <?php
                                    the_post_thumbnail('diviner_fp');
                                ?>
                                </a>
                            <?php
                            }
                            else { ?>
                            <a class="post-thumbnail" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" aria-hidden="true">
                                <img src="<?php echo esc_url( get_template_directory_uri() ) . '/assets/images/ph_ps.png'; ?>">
                            </a>
                            <?php } ?>

                            <div class="fp_title">
                                <div class="fp_cats">
                                    <?php diviner_get_post_categories(); ?>
                                </div>
                                <h4 class="title-font" title="<?php the_title_attribute(); ?>">
                                    <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
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