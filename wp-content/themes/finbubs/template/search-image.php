<?php
/**
 * Template name: Image S
 */

get_header();
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
<style type="text/css">
  #gallery {
   padding-top: 40px;
}
 @media screen and (min-width: 991px) {
   #gallery {
     padding: 60px 30px 0 30px;
  }
}
 .img-wrapper {
   position: relative;
   margin-top: 15px;
}
 .img-wrapper img {
   /*width: 100%;*/
}
 .img-overlay {
   background: rgba(0, 0, 0, 0.7);
   width: 100%;
   height: 100%;
    width: 100%;
    max-width: 100%;
   position: absolute;
   top: 0;
   left: 0;
   display: flex;
   justify-content: center;
   align-items: center;
   opacity: 0;
}
.img-wrapper a img {
    margin: 0 auto;
}
.img-wrapper a img {
    margin: 0 auto;
    min-height: 200px;
    object-fit: cover;
}
 .img-overlay i {
   color: #fff;
   font-size: 3em;
}
 #overlay {
   background: rgba(0, 0, 0, 0.7);
   width: 100%;
   /*height: 100%;*/
   position: fixed;
   top: 0;
   left: 0;
   display: flex;
   justify-content: center;
   align-items: center;
   z-index: 999;
   -webkit-user-select: none;
   -moz-user-select: none;
   -ms-user-select: none;
   user-select: none;
}
div#image-gallery >.row {
    display: flex;
    flex-wrap: wrap;
    grid-column-gap: 0px;
    grid-row-gap: 30px;
}
 #overlay img {
   margin: 0;
   width: 80%;
   height: auto;
   object-fit: contain;
   padding: 5%;
}
 @media screen and (min-width: 768px) {
   #overlay img {
     width: 60%;
  }
}
 @media screen and (min-width: 1200px) {
   #overlay img {
     width: 50%;
  }
}
 #nextButton {
   color: #fff;
   font-size: 2em;
   transition: opacity 0.8s;
}
 #nextButton:hover {
   opacity: 0.7;
}
 @media screen and (min-width: 768px) {
   #nextButton {
     font-size: 3em;
  }
}
 #prevButton {
   color: #fff;
   font-size: 2em;
   transition: opacity 0.8s;
}
 #prevButton:hover {
   opacity: 0.7;
}
 @media screen and (min-width: 768px) {
   #prevButton {
     font-size: 3em;
  }
}
 #exitButton {
   color: #fff;
   font-size: 2em;
   transition: opacity 0.8s;
   position: absolute;
   top: 15px;
   right: 15px;
}
 #exitButton:hover {
   opacity: 0.7;
}
 @media screen and (min-width: 768px) {
   #exitButton {
     font-size: 3em;
  }
}
 
</style>
<main id="primary" class="site-main">
    <section id="gallery">
        <div class="container">
          <div id="image-gallery">
              <div class="row">
            <?php 
            $query = new WP_Query( array( 'post_type' => 'service') );
            if ( $query->have_posts() ) :
                while ( $query->have_posts() ) : $query->the_post();
                    // Use the global $post object to get the current post ID
                    global $post;
                    $post_id = $post->ID;
            ?>
                
                        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12 image">
                            <div class="img-wrapper">
                               
                                <a href="<?php echo get_the_post_thumbnail_url( $post_id, 'thumbnail'); ?>">
                                    <img src='<?php echo get_the_post_thumbnail_url( $post_id, 'thumbnail');?>' class="img-responsive">
                                </a>
                                <div class="img-overlay">
                                    <i class="fa fa-plus-circle" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                   
            <?php endwhile;
            wp_reset_postdata(); // Reset post data after the loop
            endif; ?>
             </div><!-- End row -->
                </div><!-- End image gallery -->
        </div><!-- End container --> 
    <br>
    
    </section>
</main><!-- main -->
<?php
// get_sidebar();
get_footer();?>
<script type="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script type="text/javascript">
  
  // Gallery image hover
jQuery( ".img-wrapper" ).hover(
  function() {
    jQuery(this).find(".img-overlay").animate({opacity: 1}, 600);
  }, function() {
    jQuery(this).find(".img-overlay").animate({opacity: 0}, 600);
  }
);

// Lightbox
var $overlay = jQuery('<div id="overlay"></div>');
var $image = jQuery("<img>");
var $prevButton = jQuery('<div id="prevButton"><i class="fa fa-chevron-left"></i></div>');
var $nextButton = jQuery('<div id="nextButton"><i class="fa fa-chevron-right"></i></div>');
var $exitButton = jQuery('<div id="exitButton"><i class="fa fa-times"></i></div>');

// Add overlay
$overlay.append($image).prepend($prevButton).append($nextButton).append($exitButton);
jQuery("#gallery").append($overlay);

// Hide overlay on default
$overlay.hide();

// When an image is clicked
jQuery(".img-overlay").click(function(event) {
  // Prevents default behavior
  event.preventDefault();
  // Adds href attribute to variable
  var imageLocation = jQuery(this).prev().attr("href");
  // Add the image src to $image
  $image.attr("src", imageLocation);
  // Fade in the overlay
  $overlay.fadeIn("slow");
});

// When the overlay is clicked
$overlay.click(function() {
  // Fade out the overlay
  jQuery(this).fadeOut("slow");
});

// When next button is clicked
$nextButton.click(function(event) {
  // Hide the current image
  jQuery("#overlay img").hide();
  // Overlay image location
  var $currentImgSrc = jQuery("#overlay img").attr("src");
  // Image with matching location of the overlay image
  var $currentImg = jQuery('#image-gallery img[src="' + $currentImgSrc + '"]');
  // Finds the next image
  var $nextImg = jQuery($currentImg.closest(".image").next().find("img"));
  // All of the images in the gallery
  var $images = jQuery("#image-gallery img");
  // If there is a next image
  if ($nextImg.length > 0) { 
    // Fade in the next image
    jQuery("#overlay img").attr("src", $nextImg.attr("src")).fadeIn(800);
  } else {
    // Otherwise fade in the first image
    jQuery("#overlay img").attr("src", jQuery($images[0]).attr("src")).fadeIn(800);
  }
  // Prevents overlay from being hidden
  event.stopPropagation();
});

// When previous button is clicked
$prevButton.click(function(event) {
  // Hide the current image
  jQuery("#overlay img").hide();
  // Overlay image location
  var $currentImgSrc = jQuery("#overlay img").attr("src");
  // Image with matching location of the overlay image
  var $currentImg = jQuery('#image-gallery img[src="' + $currentImgSrc + '"]');
  // Finds the next image
  var $nextImg = jQuery($currentImg.closest(".image").prev().find("img"));
  // Fade in the next image
  jQuery("#overlay img").attr("src", $nextImg.attr("src")).fadeIn(800);
  // Prevents overlay from being hidden
  event.stopPropagation();
});

// When the exit button is clicked
$exitButton.click(function() {
  // Fade out the overlay
  jQuery("#overlay").fadeOut("slow");
});
</script>