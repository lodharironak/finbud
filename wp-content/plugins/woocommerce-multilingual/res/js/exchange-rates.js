jQuery( function($){

    WCMLExchangeRates = {

        init: function(){

            $('#online-exchange-rates').on( 'change', '#exchange-rates-automatic', WCMLExchangeRates.toggleManualAutomatic );
            $('#online-exchange-rates').on( 'click', '#update-rates-manually', WCMLExchangeRates.updateRatesManually);
            $('#online-exchange-rates').on( 'change', 'input[name=exchange-rates-service]', WCMLExchangeRates.selectService );
            $('#online-exchange-rates').on( 'change', 'input[name=update-schedule]', WCMLExchangeRates.updateFrequency );

            WCMLExchangeRates.selectedService = $('input[name=exchange-rates-service]:checked').val();
            $('#online-exchange-rates').on( 'change', 'input[name=exchange-rates-service]', WCMLExchangeRates.toggleUpdateManuallyButton );
            $('#online-exchange-rates').on( 'change', 'input[name=lifting_charge]', WCMLExchangeRates.toggleUpdateManuallyButton );

        },

        toggleManualAutomatic: function(){

            if($(this).prop('checked')){
                $('#exchange-rates-online-wrap').fadeIn();
                WCML_Tooltip && WCML_Tooltip.init(); // Re-init tooltips for the previously invisible ones.
            }else{
                $('#exchange-rates-online-wrap').fadeOut();
            }

        },

        updateRatesManually: function(){

            var updateButton = $(this);

            $('#exchange-rates-error').html('').hide();
            $('#update-rates-spinner').css({ visibility: 'visible' });
            $('.exchange-rates-sources .notice-error').html('').hide();
            updateButton.prop('disabled', true);

            $.ajax({
                type: "post",
                url: ajaxurl,
                dataType: 'json',
                data: {
                    action: "wcml_update_exchange_rates",
                    wcml_nonce: $('#update-exchange-rates-nonce').val()
                },
                success: function (response) {

                    if (response.success) {
                        $('#exchange-rates-success').fadeIn();
                        $('#update-rates-time .time').text( response.last_updated );
                    }else{
                        if( response.error ){
                            var serviceErrorWrap = $('#service-error-' + response.service.replace(/[^\w]/g, '') );
                            serviceErrorWrap.text( response.error ).fadeIn();
                        }
                    }

                    $('#update-rates-spinner').css({ visibility: 'hidden' });
                    updateButton.prop('disabled', false);

                    for( code in response.rates ){
                        $('#currency_row_' + code.replace(/[^\w]/g, '') + ' span.rate').hide().text( response.rates[code] ).fadeIn('slow');
                    }

                }
            })

        },

        /**
         * @todo remove when moving to auto-saving forms
         */
        toggleUpdateManuallyButton: function(){

            if( WCMLExchangeRates.selectedService == $(this).val() ){
                $('#update-rates-manually').prop( 'disabled', false );
                $('#update-rates-manually').next('.wcml-tip').hide();
            } else {
                $('#update-rates-manually').prop( 'disabled', true );
                $('#update-rates-manually').next('.wcml-tip').show().tipTip( WCML_Tooltip.default_args);
            }

        },

        selectService: function(){

            $('.service-details-wrap').hide();
            $(this).parent().find('.service-details-wrap').show();

        },

        updateFrequency: function(){

            $('[name="update-weekly-day"], [name="update-monthly-day"]').prop('disabled', true);
            $(this).parent().find('select').prop('disabled', false);

        }
    }



    WCMLExchangeRates.init();

});
