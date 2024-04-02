/* Script on ready
---------------------------------*/
jQuery(document).ready(function () {
    //  The menu
    jQuery('#menu12').mmenu({
        extensions: ['effect-slide-menu', 'pageshadow'],
        searchfield: false,
        counters: false,
        offCanvas: {
            position: 'right',
        }
    });
    var API = jQuery('#menu12').data('mmenu');
    jQuery('#nav-icon1').click(function () {
        API.close();
    });
    //  The menu End

    //    slider
    jQuery(".lazy").slick({
        lazyLoad: 'ondemand', // ondemand progressive anticipated
        infinite: true,
        arrows: false,
        dots: true,
        speed: 500,
    });
    jQuery(".services-slider").slick({
        infinite: true,
        dots: false,
        arrows: true,
        slidesToShow: 4,
        slidesToScroll: 4,
        responsive: [
            {
                breakpoint: 992,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 3
                }
    },
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2
                }
    },
            {
                breakpoint: 479,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
    }
  ]
    });
    //equalheight Start
    var highestBox = 0;
    jQuery('.services-des p').each(function () {
        if (jQuery(this).height() > highestBox) {
            highestBox = jQuery(this).height();
        }
    });
    jQuery('.services-des p').height(highestBox);

    //equalheight Start
    var highestBox = 0;
    jQuery('.blog-des p').each(function () {
        if (jQuery(this).height() > highestBox) {
            highestBox = jQuery(this).height();
        }
    });
    jQuery('.blog-des p').height(highestBox);

    //equalheight Start
    var highestBox = 0;
    jQuery('.bridging-icon-content h4').each(function () {
        if (jQuery(this).height() > highestBox) {
            highestBox = jQuery(this).height();
        }
    });
    jQuery('.bridging-icon-content h4').height(highestBox);

    // click to addclass
    
//    jQuery(".header-btn .btn").click(function () {
//        jQuery(".resources-menu").slideToggle("resource-open");
//    });
//    
  jQuery(".header-btn .btn").click(function (e) {
      jQuery(".resources-menu").slideToggle();
      e.stopPropagation();
  });

  jQuery(".resources-menu").click(function (e) {
      e.stopPropagation();
  });

  jQuery(document).click(function () {
      jQuery(".resources-menu").slideUp();
  });
    
    
});