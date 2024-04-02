<?php
/*
** Template to Render Social Icons on Top Bar
*/

for ($i = 1; $i < 7; $i++) :
	$social = get_theme_mod('diviner_social_'.$i);
	$social_url = get_theme_mod('diviner_social_url'.$i);
	if ( ($social != 'none') && ($social != '') && ($social_url !='' ) ) : ?>

            <div class="icon">
                <a class="hvr-sweep-to-bottom" href="<?php echo esc_url($social_url); ?>" target="_blank">
                    <i class="fab fa-fw fa-<?php echo esc_attr($social); ?>"></i>
                </a>
            </div>
	<?php endif;

endfor; ?>