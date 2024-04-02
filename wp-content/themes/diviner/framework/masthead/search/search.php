<?php
/**
 *  PHP file for Top Search
 */
?>

<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
   <label>
       <span class="screen-reader-text"><?php _ex( 'Search for:', 'label', 'diviner' ); ?></span>
       <button type="button" id="go-to-close"></button>
       <input type="text" class="search-field top_search_field" placeholder="<?php echo esc_attr_e( 'Search...', 'diviner' ); ?>" value="<?php echo esc_attr( get_search_query() ); ?>" name="s">
       <button type="button" class="btn btn-default cancel_search"><i class="fas fa-times"></i></button>
       <button type="button" id="go-to-field"></button>
   </label>
</form>