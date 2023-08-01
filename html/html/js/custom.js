/* Script on ready
---------------------------------*/
jQuery(document).ready(function () {
    //jQuery('.error_valid').hide();
    /* Calculator result open */
    jQuery('.calc-btn').click(function(event) {
        
        jQuery('.error_valid').remove();

        var property_value_val = jQuery('#property_value').val();
        var outstanding_mortgage_val = jQuery('#outstanding_mortgage').val();
        var loan_amount = jQuery('#loan_amount').val();
        var term_month_val = jQuery('#term_month').val();
        var interest_rate_val = jQuery('#interest_rate').val();
        var lender_arrangement_val = jQuery('#lender_arrangement_fee').val();
        var lender_exit_val = jQuery('#lender_exit_fee').val();

        if(property_value_val == ''){
            jQuery('#property_value').after('<p class="error_valid"> Pleae enter Property Value </p>');
             return false;
        }

        if(outstanding_mortgage_val == ''){
            jQuery('#outstanding_mortgage').after('<p class="error_valid"> Pleae enter Outstanding mortgage </p>');
             return false;
        }

        if(loan_amount == ''){
            jQuery('#loan_amount').after('<p class="error_valid"> Pleae enter Loan Amount </p>');
             return false;
        }

        if(term_month_val == ''){
            jQuery('#term_month').after('<p class="error_valid"> Pleae enter Term Month </p>');
             return false;
        }

        if(interest_rate_val == ''){
            jQuery('#interest_rate').after('<p class="error_valid"> Pleae enter Interest Rate </p>');
             return false;
        }

        if(lender_arrangement_val == ''){
            jQuery('#lender_arrangement_fee').after('<p class="error_valid"> Pleae enter Lender Arrangement Fee </p>');
             return false;
        }

        if(lender_exit_val == ''){
            jQuery('#lender_exit_fee').after('<p class="error_valid"> Pleae enter Lender Exit </p>');
             return false;
        }

        var lender_arrangement_fee = parseFloat(lender_arrangement_val * loan_amount);
        jQuery('.lender-arrangement-fee span' ).html(lender_arrangement_fee);

        var lender_exit_fee = parseFloat(lender_exit_val * loan_amount);
        jQuery('.lender-exit-fee span' ).html(lender_exit_fee);

        var total_interest_rate = parseFloat(interest_rate_val * loan_amount * term_month_val);
        jQuery('.total-interest span' ).html(total_interest_rate);
        
        var loan_increase_val = parseFloat(outstanding_mortgage_val + loan_amount );
        var loan_to_value = parseFloat(loan_increase_val / property_value_val )
        jQuery('.loan_to_value span' ).html(loan_to_value);

        
        var loan_increase_val = parseFloat(lender_arrangement_fee + lender_exit_fee +total_interest_rate );
        jQuery('.total_finance span' ).html(loan_increase_val);
        
        jQuery('.calc-result').slideDown('slow');

    });


    jQuery('.calc-btn-finance').click(function(event) {
        
        jQuery('.error_valid').remove();

        var loan_amount = jQuery('#loan_amount').val();
        var lender_arrangement_val = jQuery('#lender_arrangement_fee').val();
        var interest_rate_val = jQuery('#interest_rate').val();
        var gdv = jQuery('#gdv').val();
        var term_month_val = jQuery('#term_month').val();
        var facility_fee_val = jQuery('#facility_fee').val();
        var lender_exit_val = jQuery('#lender_exit_fee').val();


        if(loan_amount == ''){
            jQuery('#loan_amount').after('<p class="error_valid"> Pleae enter Loan Amount </p>');
             return false;
        }

        if(term_month_val == ''){
            jQuery('#term_month').after('<p class="error_valid"> Pleae enter Term Month </p>');
             return false;
        }

        if(interest_rate_val == ''){
            jQuery('#interest_rate').after('<p class="error_valid"> Pleae enter Interest Rate </p>');
             return false;
        }

        if(gdv == ''){
            jQuery('#lender_arrangement_fee').after('<p class="error_valid"> Pleae enter GDV </p>');
             return false;
        }

        if(facility_fee_val == ''){
            jQuery('#lender_arrangement_fee').after('<p class="error_valid"> Pleae enter Facility Fee </p>');
             return false;
        }

        if(lender_exit_val == ''){
            jQuery('#lender_exit_fee').after('<p class="error_valid"> Pleae enter Lender Exit </p>');
             return false;
        }

        var lender_arrangement_fee = parseFloat(lender_arrangement_val * loan_amount);
        jQuery('.lender-arrangement-fee span' ).html(lender_arrangement_fee);

        var lender_exit_fee = parseFloat(lender_exit_val * loan_amount);
        jQuery('.lender-exit-fee span' ).html(lender_exit_fee);

        var total_interest_rate = parseFloat(interest_rate_val * loan_amount * term_month_val);
        jQuery('.total-interest span' ).html(total_interest_rate);

        var loan_gross = parseFloat(loan_amount / gdv )
        jQuery('.loan_gross_develp span' ).html(loan_gross);

        
        var loan_increase_val = parseFloat(lender_arrangement_fee + lender_exit_fee +total_interest_rate );
        jQuery('.total_finance span' ).html(loan_increase_val);
        
        jQuery('.calc-result').slideDown('slow');

    });

    /* End Calculator result open */


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
                breakpoint: 480,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
    }
  ]
    });
 jQuery(".logo-slider").slick({
        infinite: true,
        dots: true,
        arrows: false,
        slidesToShow: 5,
        slidesToScroll: 5,
        responsive: [
            {
                breakpoint: 1200,
                settings: {
                    slidesToShow: 4,
                    slidesToScroll: 4
                }
    },
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
                breakpoint: 480,
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
    jQuery('.bridging-icon-third h4').each(function () {
        if (jQuery(this).height() > highestBox) {
            highestBox = jQuery(this).height();
        }
    });
    jQuery('.bridging-icon-third h4').height(highestBox);

    // click to addclass
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