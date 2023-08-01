(function ($) {
    'use strict';
    $(document).ready(function ($) {
        $(".rn-dismiss-btn").on("click", function () {
            $(this).closest(".notice").fadeOut();
            $.post(wpi_ran.ajax_url, {
                action: "dismissnotice",
                dismiss: 1,
                notice_id: $(this).attr("data-notice_id"),
                nonce: wpi_ran.ajax_nonce
            }, function (data) {

            });
        });

        // Hook into the heartbeat-send
        $(document).on('heartbeat-send', function (e, data) {
            data['rdn_maybe_fetch'] = wpi_ran.maybe_fetch;
        });

        // Listen for the custom event "heartbeat-tick" on $(document).
        $(document).on('heartbeat-tick', function (e, data) {

            if (data.rdn_fetch !== '') {
                /*Ajax request URL being stored*/
                $.post(wpi_ran.ajax_url, {
                    //action name (must be consistent with your php callback)
                    action: 'rdn_fetch_notifications',
                    notices: data.rdn_fetch,
                    nonce: wpi_ran.ajax_nonce
                }, function (data) {
                    //    console.log(data);  // Enable it for Debug
                });




            }

        });
    });
})(jQuery);

// Other code using $ as an alias to the other library