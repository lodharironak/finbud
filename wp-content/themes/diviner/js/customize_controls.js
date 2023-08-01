//
//  JS File for Customizer Custom Controls Scripts
//

(function(jQuery) {
	
    wp.customize.bind('ready', function() {
        rangeSlider();
    });

    var rangeSlider = function() {
        var slider = jQuery('.range-slider'),
            range = jQuery('.range-slider__range'),
            value = jQuery('.range-slider__value');

        slider.each(function() {

            value.each(function() {
                var value = jQuery(this).prev().attr('value');
				var suffix = (jQuery(this).prev().attr('suffix')) ? jQuery(this).prev().attr('suffix') : '';
                jQuery(this).html(value + suffix);
            });

            range.on('input', function() {
				var suffix = (jQuery(this).attr('suffix')) ? jQuery(this).attr('suffix') : '';
                jQuery(this).next(value).html(this.value + suffix );
            });
        });
    };
    
    
    wp.customize.bind('ready', function() {
	    
		var frontPageWidgets = wp.customize.control('diviner_front_page_widget_link').container.find("a");   
		
		frontPageWidgets.on('click', function() {
			wp.customize.panel('widgets').expand();
		});
		
		var headerAd = wp.customize.control('diviner_head_ad_widget_link').container.find("a");   
		
		headerAd.on('click', function() {
			wp.customize.section('sidebar-widgets-sidebar-head').expand();
		});


    	wp.customize('diviner_select_layout', function( setting ) {
        var setupControl = function( control ) {
            var setActiveState, isDisplayed;
            isDisplayed = function() {
                return setting.get().includes('_s');
            };
            setActiveState = function() {
                control.active.set( isDisplayed() );
            };
            setActiveState();
            setting.bind( setActiveState );
            };
            wp.customize.control( 'diviner_sidebar_width', setupControl );
            wp.customize.control( 'diviner_blog_sidebar_align', setupControl );
        });
    });
        

        function media_upload(button_selector) {
            var _custom_media = true,
                _orig_send_attachment = wp.media.editor.send.attachment;
            jQuery('body').on('click', button_selector, function () {
              var button_id = jQuery(this).attr('id');
              wp.media.editor.send.attachment = function (props, attachment) {
                if (_custom_media) {
                  jQuery('.' + button_id + '_img').attr('src', attachment.url);
                  jQuery('.' + button_id + '_url').val(attachment.url);
                } else {
                  return _orig_send_attachment.apply(jQuery('#' + button_id), [props, attachment]);
                }
              }
              wp.media.editor.open(jQuery('#' + button_id));
              return false;
            });
          }
          media_upload('.js_custom_upload_media');
          

})(jQuery);