<?php
/**
 *  Template for 1-Column Footer
 */
 ?>
 <div id="footer-sidebar" class="widget-area">
     <div class="container">
         <div class="row">
            <?php
            if ( is_active_sidebar( 'footer-1' ) ) : ?>
                <div class="footer-column col">
                    <?php dynamic_sidebar( 'footer-1'); ?>
                </div>
            <?php endif; ?>
        </div>
     </div>
 </div>