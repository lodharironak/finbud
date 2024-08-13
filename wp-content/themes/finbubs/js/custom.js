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
  } 
  else {
    $('.logout').hide();
    $('.sign-in').show();
    $('.registration').show();
  }

  $('#btn-new-user').click(function(event) {
    if (event.preventDefault) {
        event.preventDefault();
    }
    else {
        event.returnValue = false;
    }

  $('.indicator').show();
  $('.result-message').hide();

  var reg_nonce = $('#vb_new_user_nonce').val();
  var reg_user = $('#vb_username').val();
  var reg_pass = $('#vb_pass').val();
  var reg_mail = $('#vb_email').val();
  var reg_name = $('#vb_name').val();
  var reg_nick = $('#vb_nick').val();

  var ajax_url = ajax_posts.ajaxurl;

  data = {
    action: 'register_user',
    nonce: reg_nonce,
    user: reg_user,
    pass: reg_pass,
    mail: reg_mail,
    name: reg_name,
    nick: reg_nick,
  };

  $.post(ajax_url, data, function(response) {
    $('.indicator').hide();

    if(response === '1') {
      $('.result-message').html('Your submission is complete.');
      $('.result-message').addClass('alert-success');
      $('.result-message').show();

      // Redirect to sign-in page after successful registration
      window.location.href = 'http://192.168.0.28/finbud/signin'; // Replace 'your-sign-in-page-url' with the actual URL of your sign-in page
    } else {
      $('.result-message').html(response);
      $('.result-message').addClass('alert-danger');
      $('.result-message').show();
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




jQuery(document).ready(function($) {
    $('.variations_form').on('woocommerce_variation_select_change', function() {
        var variation_id = $('input[name="variation_id"]').val();
        if (variation_id) {
            var variation = $('input[name="variation_id"]').closest('form.variations_form').find('.variations select option:selected').data('variation_id');
            if (variation) {
                var price = $('input[name="variation_id"]').closest('form.variations_form').find('.variations select option:selected').data('price');
                if (price) {
                    $('.woocommerce-variation-price').html(price);
                }
            }
        }
    });
});

jQuery( function( $ ) {
  let timeout;
  $('.woocommerce').on('change', 'input.qty', function(){
    if ( timeout !== undefined ) {
      clearTimeout( timeout );
    }
    timeout = setTimeout(function() {
      $("[name='update_cart']").trigger("click"); // trigger cart update
    }, 1000 ); // 1 second delay, half a second (500) seems comfortable too
  });
} );
