/* Script on ready
---------------------------------*/
//$=jQuery;
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

// AJAX load more button
let currentPage = 1;
$('#load-more').on('click', function() {

  $("#display_loading").show();
  currentPage++;
  var totalPost = jQuery(this).data('total');
  var currentPost = currentPage * 3;
    $.ajax({
    type: 'POST',
    url: ajax_posts.ajaxurl,
    dataType: 'html',
    data: {
      action: 'weichie_load_more',
      paged: currentPage,
    },
    afterSend: function() {
        $("#load-more").show();
    },
    success: function (res) {
       $('.blog-main').append(res);
       if (totalPost == currentPost) 
       {
         $("#load-more").hide();
       }
       $("#display_loading").hide();
    },
    error: function(data) {
         // test to see what you get back on error
         console.log(data);
        }
  });
  
});
 // Categories Checkbox

 $('.cat_nm').on('click', function() {

    $("#display_loading").show();
    currentPage++;
    console.log();
    var totalPost = jQuery(this).data('total');
    var currentPost = currentPage * 3;
    
    selcategory = [];

    $("input:checkbox[class=cat_nm]:checked").each(function(){
        selcategory.push($(this).val());
    });
    

    var pricing = jQuery( "#slider-range" ).slider( "values");

    var min = pricing[0];
    var max = pricing[1];

        $.ajax({
          type: 'POST',
          url: ajax_posts.ajaxurl,
          dataType: 'html',
          data: {
            action: 'woocommerce_product_get',
            selcategory: selcategory, 
            min: min,
            max: max,
          },
         afterSend: function() {
              $(".cat_nm").show();
          },
          success: function (res) {
             $('.products').html("");
             $('.products').append(res);
             console.log(res);
             if (totalPost == currentPost) 
             {
               $(".cat_nm").show();
             }
             $("#display_loading").hide();
          },
          error: function(data) {
               // test to see what you get back on error
               console.log(data);
          }
        });
});
//-----JS for Price Range slider-----

$(function(){
  currentPage++;
  var totalPost = jQuery(this).data('total');
  var currentPost = currentPage * 3;
 
  $( "#slider-range" ).slider({
      range: true,
      min: 0,
      max: 100000,
      values: [ 0, 100000 ],
      slide: function( event, ui ) {
      $( "#amount" ).val( "₹" + ui.values[ 0 ] + " - ₹" + ui.values[ 1 ] );
      },
      change: function( event, ui ) {
      if (event) {
         selcategory = [];
        $("input:checkbox[class=cat_nm]:checked").each(function(){
        selcategory.push($(this).val());
    });
        var min = ui.values[0];
        var max = ui.values[1];
        
      $.ajax ({
        type: 'POST',
        url: ajax_posts.ajaxurl,
        dataType: 'html',
        data: {
          action: 'woocommerce_product_get',
          min: min,
          max: max,
          selcategory: selcategory,
        },
        beforeSend: function()
        {
          jQuery('#display_loading').show();
        },
        complete: function(){
          jQuery('#display_loading').hide();
        },
        success: function(resp)
        {
          $('.products').html("");
          $('.products').append(resp);
          if (totalPost == currentPost) 
          {
           $("#slider-range").show();
           $('#slider-range').attr('data-totpost', totalPost);
          }
          else
          {
            $("#display_loading").hide();
          }
        }
      }); 
          }
          // console.log(ui.values);
          // console.log(ui.values[0]);
          // console.log(ui.values[1]);
        }
  });
  $( "#amount" ).val( "₹" + $( "#slider-range" ).slider( "values", 0 ) +
    " - ₹" + $( "#slider-range" ).slider( "values", 1 ) );
}); 

// Single product page slider

$(function(){
  $('.flex-control-thumbs').on('click', '.flex-active', function(){
    activeBook($(this).index());
  });
    
  function activeBook(i){
    $('.flex-active').removeClass('active');
    var active = $('.flex-active').eq(i).addClass('active');
    var left = active.position().left;
    var currScroll= $(".flex-control-thumbs").scrollLeft(); 
    var contWidth = $('.flex-control-thumbs').width()/2; 
    var activeOuterWidth = active.outerWidth(); 
    left = left + currScroll - contWidth + activeOuterWidth;
    $('.flex-control-thumbs').animate( { 
      scrollLeft: left
    },'slow');
  }
});

/**** Register Form ****/
jQuery(document).ready(function($) {


var loginn = $('body').hasClass('loggedin');
console.log(loginn);
  if (loginn == true) {
      $('.logout').show();
      $('.sign-in').hide();
      $('.registration').hide();
  }else{
      $('.logout').hide();
      $('.sign-in').show();
      $('.registration').show();
  }
  /**
   * When user clicks on button...
   *
   */
  $('#btn-new-user').click( function(event) {
 
    /**
     * Prevent default action, so when user clicks button he doesn't navigate away from page
     *
     */
    if (event.preventDefault) {
        event.preventDefault();
    } else {
        event.returnValue = false;
    }
 
    // Show 'Please wait' loader to user, so she/he knows something is going on
    $('.indicator').show();
 
    // If for some reason result field is visible hide it
    $('.result-message').hide();
 
    // Collect data from inputs
    var reg_nonce = $('#vb_new_user_nonce').val();
    var reg_user  = $('#vb_username').val();
    var reg_pass  = $('#vb_pass').val();
    var reg_mail  = $('#vb_email').val();
    var reg_name  = $('#vb_name').val();
    var reg_nick  = $('#vb_nick').val();
 
    /**
     * AJAX URL where to send data
     * (from localize_script)
     */
    var ajax_url = ajax_posts.ajaxurl;
 
    // Data to send
    data = {
      action: 'register_user',
      nonce: reg_nonce,
      user: reg_user,
      pass: reg_pass,
      mail: reg_mail,
      name: reg_name,
      nick: reg_nick,
    };
 
    // Do AJAX request
    $.post( ajax_url, data, function(response) {
 
      // If we have response
      if( response ) {
 
        // Hide 'Please wait' indicator
        $('.indicator').hide();
 
        if( response === '1' ) {
          // If user is created
          $('.result-message').html('Your submission is complete.'); // Add success message to results div
          $('.result-message').addClass('alert-success'); // Add class success to results div
          $('.result-message').show(); // Show results div
        } else {
          $('.result-message').html( response ); // If there was an error, display it in results div
          $('.result-message').addClass('alert-danger'); // Add class failed to results div
          $('.result-message').show(); // Show results div
        }
      }
    });
  });
});

/***** Log In *****/

jQuery('#bt-new-user').on('click', function(e) {
    e.preventDefault(); 
    var username = jQuery('#vb_username').val();
    var password = jQuery('#vb_pass').val();
    // console.log('username' + username);
    // console.log('password' + password);
   
    // console.log(currentPage);
    jQuery.ajax({
        type: 'POST',
        dataType: 'JSON',
        url: ajax_posts.ajaxurl,
        data: {
            action: 'user_sign_in',
            usr: username,
            pwd: password
        },
        success: function (data) {
          $('#rsUserRegistration').text(data.message);
            if (data.loggedin == true){
              window.location.href = ajax_posts.redirecturl;
            }
        }
    });
});


