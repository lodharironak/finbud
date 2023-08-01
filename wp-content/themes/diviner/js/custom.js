/**
 *  JS File for custom JS Code for the theme
**/

jQuery(document).ready(function() {
	
	// Desktop Search
	var searchBar = jQuery('#top-search label');
	searchBar.hide();
	
	jQuery('#search-btn, #mobile-search-btn').on('click', function() {
		searchBar.slideDown();
		jQuery('body').css('overflow', 'hidden').prepend("<div id='body_disable'></div>");
		searchBar.find('input[type="text"]').focus();
	});
	
	var cancelSearch = jQuery('.cancel_search');
	
	cancelSearch.on('click', function() {
		searchBar.slideUp();
		jQuery('body').css('overflow', 'visible').find('#body_disable').hide();
		jQuery('#search-btn, #mobile-search-btn').focus();
	});
	
	jQuery('#go-to-field').on('focus', function() {
		jQuery(this).siblings('input[type="text"]').focus();
	});
	
	jQuery('#go-to-close').on('focus', function() {
		jQuery(this).siblings('button.cancel_search').focus();
	});
		
	// Navigation
	jQuery('.panel_hide_button').hide();

	jQuery('.menu-link').bigSlide({
		easyClose	: true,
		width		: '25em',
		side		: 'right',
		afterOpen	: function() {
				      jQuery('#close-menu').focus();
			      },
      afterClose: function() {
				      jQuery('#mobile-nav-btn').focus();
			      }
  });
  
  jQuery('.go-to-top').on('focus', function() {
		jQuery('#close-menu').focus();
	});
	
	jQuery('.go-to-bottom').on('focus', function() {
		jQuery('ul#mobile-menu > li:last-child > a').focus();
	});


  var parentElement =	jQuery('.panel li.menu-item-has-children'),
      dropdown		=	jQuery('.panel li.menu-item-has-children span');
	  
	parentElement.children('ul').hide();
	dropdown.on({
		'click': function(e) {
			jQuery(this).siblings('ul').slideToggle().toggleClass('expanded');
			e.stopPropagation();
		},
		'keydown': function(e) {
			if( e.keyCode == 32 || e.keyCode == 13 ) {
				e.preventDefault();
				jQuery(this).siblings('ul').slideToggle().toggleClass('expanded');
				e.stopPropagation();
			}
		}
	});
	
	jQuery('.is-style-carousel .blocks-gallery-grid').bxSlider({
	    mode		: 'horizontal',
	    speed		: 500,
	    slideMargin	: 10,
	    auto		: true,
	    infiniteLoop: true,
        adaptiveHeight: true,
        minSlides	: 2,
        maxSlides	: 4,
        slideWidth	: 300
	});
	

   jQuery('.posts-slider .slider').bxSlider({
	    wrapperClass: 'post-slider-wrapper',
	    mode		: 'horizontal',
	    preloadImages: 'all',
	    speed		: 5000,
	    auto		: true,
	    controls	: false,
        pager		: false
    });

   jQuery('.ticker-wrapper').bxSlider({
       'ticker': true,
       'tickerHover': true,
       'pager': false,
       'speed': 30000,
       'wrapperClass': 'ticker-wrapper'
   });

   jQuery('figure.gallery-item a').simpleLightbox({
	   widthRatio: 0.7,
	   heightRatio: 0.8
   });
   
   if ( "" !== diviner_params.sidebar_sticky ) {
	   jQuery('#secondary').stickySidebar({
			topSpacing: 20,
			bottomSpacing: 20,
			containerSelector: '#content-wrapper .row',
		});
   }
	
	var stickySidebar = jQuery.fn.stickySidebar.noConflict();
	jQuery.fn.stickySidebar = stickySidebar;
});