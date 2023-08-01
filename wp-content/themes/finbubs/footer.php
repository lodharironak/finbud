<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package finbubs
 */

?>
<footer id="colophon" class="site-footer" style="float: left; width: 100%">
		<div class="footer-top">
            <div class="container">
                <div class="footer-top-inner">
                    <div class="footer-four">
                        <h4><?php echo get_field('footer-about', 'option')?></h4>
                        <p><?php echo get_field('about-details', 'option')?></p>
                    </div>
                    <div class="footer-four">
                      	<ul>
                            <li>
                                <?php 
                                    wp_nav_menu( 
                                    array('menu'=>'menuname')); 
                                ?>
                            </li>
                      	</ul> 
                    </div>
                     <div class="footer-four">
                        <ul>
                            <li>
                                <?php 
                                wp_nav_menu(
                                array(
                                'theme_location' => 'new-menu',
                            )
                            );
                                ?>
                            </li>
                        </ul> 
                    </div> 
                    <div class="footer-four">
                        <h4><?php echo get_field('Address-head', 'option')?></h4>
                        <p><?php echo get_field('Address-txt', 'option') ?></p>
                        <p><span><?php echo get_field('Address-tel', 'option') ?></span> <a href="tel:02077886627"><?php echo get_field('Address-no', 'option') ?></a></p>
                        <p><span><?php echo get_field('Address-email', 'option') ?></span> <a href="mailto:hello@finbud.co.uk"><?php echo get_field('Address-email-id', 'option') ?></a></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-middle">
            <div class="container">
                <div class="footer-middle-inner">
                    <div class="footer-half">
                        <p><?php echo get_field('copyright', 'option') ?></p>
                    </div>
                    <div class="footer-half">
                       <ul>
                        	<li><a href="#"><?php echo get_field('Cookies', 'option') ?></a></li>
                        	<li><a href="#"><?php echo get_field('policy', 'option') ?></li>
                       </ul>
                    </div>
                </div>
            </div>
        </div>
	</footer><!-- #colophon -->
    <nav class="sb-slidebar" id="menu12">
        <div class="menu">
            <ul>
                <li><a href="#">Mortgage</a>
                    <ul class="sub-menu">
                        <li><a href="#">submen</a></li>
                        <li><a href="#">submen</a></li>
                        <li><a href="#">submen</a></li>
                    </ul>
                </li>
                <li><a href="#">Development Finance</a></li>
                <li><a href="#"> Bridging Loans</a></li>
                <li><a href="#"> Commercial Finance</a></li>
            </ul>
        </div>
    </nav>
</div><!-- #page -->
<?php wp_footer(); ?>

</body>
</html>
