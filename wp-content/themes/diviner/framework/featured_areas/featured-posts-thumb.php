

<div class="featposts fp-thumb">
    <?php
    /* Start the Loop */

    $params = array( 'posts_per_page' =>  $post_count, 'cat' => $category, 'ignore_sticky_posts' => true );
    $featured   =   new WP_Query( $params );
    $count      =   0;
    
    if ( $featured->have_posts() ) {

        while ( $featured->have_posts() ) {
            $featured->the_post(); ?>

            <div class="featured-post row no-gutters">

                <?php
                    if ( $count == 0 ) :
                 ?>
                     <div class="fp_thumb col">
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
                     </div>

                     <div class="fp_title col">
                         <h4 class="title-font" title="<?php the_title_attribute(); ?>">
                         <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
                        </h4>

                         <div class="fp_cats">
                             <?php diviner_get_post_categories(); ?>
                         </div>
                     </div>

                 <?php
                    else :
                 ?>
                    <div class="fp_thumb col-3">
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
                    </div>

                    <div class="fp_title col-9">
                        <h4 class="title-font" title="<?php the_title_attribute(); ?>">
                            <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
                        </h4>

                        <div class="fp_cats">
                            <?php diviner_get_post_categories(); ?>
                        </div>
                    </div>
                <?php
                    endif;
                 ?>
            </div>
        <?php
        $count++;
        }
    }
    wp_reset_postdata(); ?>
</div>