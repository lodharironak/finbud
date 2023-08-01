
(function ($) {
	'use strict';

	$(document).ready(function () {

		jQuery('.wpgs img').removeAttr('srcset');

		$('.woocommerce-product-gallery__image img').load(function () {

			var imageObj = $('.woocommerce-product-gallery__image img');

			if (!(imageObj.width() == 1 && imageObj.height() == 1)) {

				$('.wpgs-thumb-main-image').attr('src', imageObj.attr('src'));
				$('.wpgs-thumb-main-image').trigger('click');

			}
		});

		// Check if have Fancybox
		if (typeof $.fn.fancybox == 'function') {
			// Customize icons

			$.fancybox.defaults = $.extend(true, {}, $.fancybox.defaults, {

				thumbs: false,
				afterShow: function (instance, current) {

					current.opts.$orig.closest(".slick-initialized").slick('slickGoTo', parseInt(current.index), true);
				}

			});

			var selector = '.wpgs-for .slick-slide:not(.slick-cloned) a';

			// Skip cloned elements
			$().fancybox({
				selector: selector,
				backFocus: false,



			});

			// Attach custom click event on cloned elements, 
			// trigger click event on corresponding link
			$(document).on('click', '.slick-cloned a', function (e) {
				$(selector)
					.eq(($(e.currentTarget).attr("data-slick-index") || 0) % $(selector).length)
					.trigger("click.fb-start", {
						$trigger: $(this)
					});
				return false;
			});
		}
		function ZoomIconApperce() {
			setTimeout(function () {
				$('.wpgs-lightbox-icon').css({ "position": "relative" });

			}, 500);

		}

		// On swipe event
		$('.wpgs-for').on('swipe', function (event, slick, direction) {
			$('.wpgs-lightbox-icon').css({ "position": "static" });
			ZoomIconApperce();
		});
		// On edge hit
		$('.wpgs-for').on('afterChange', function (event, slick, direction) {
			ZoomIconApperce();
		});
		$('.wpgs-for,.wpgs-nav').on('click', '.slick-arrow ,.slick-dots', function () {
			$('.wpgs-lightbox-icon').css({ "position": "static" });
			ZoomIconApperce();
		});
		$('.wpgs-nav').on('click', '.slick-slide', function () {
			$('.wpgs-lightbox-icon').css({ "position": "static" });
			ZoomIconApperce();
		});
		$('.wpgs-for').on('init', function (event, slick) {
			ZoomIconApperce();
		});
		if (typeof $.fn.zoom == 'function') {
			$('.wpgs-for img').each(function () {
				$(this).wrap("<div class='zoomtoo-container' data-zoom-image=" + $(this).data("zoom_src") + "></div>");
			});
			// var imgUrl = $(this).data("zoom-image");
			$('.zoomtoo-container').zoom({

				// Set zoom level from 1 to 5.
				magnify: 1,
				// Set what triggers the zoom. You can choose mouseover, click, grab, toggle.
				on: 'mouseover',
			})
		};
		// Change image on variation
		var get_thumb_first = $(document).find('.wpgs-thumb-main-image');
		var get_main_first = $(document).find('.woocommerce-product-gallery__image');
		get_main_first.find('img').removeAttr('srcset');


		jQuery(this).on('show_variation', function (event, variation) {
			get_thumb_first.removeAttr('srcset');
			var thumb_src = variation.image.gallery_thumbnail_src,
				variable_image_caption,
				first_thumb_src = get_main_first.find('img').attr("src");

			get_main_first.find('img').attr('src', variation.image.src);
			get_main_first.find('img').removeAttr('srcset');
			get_thumb_first.find('img').attr('src', thumb_src);

			// Reset Slider location to '0' when variation change
			$('.woocommerce-product-gallery__image .wp-post-image').on('load', function () {

				$('.wpgs-image').slick('slickGoTo', 0);

				$('.woocommerce-product-gallery__image').find('.zoomImg').attr('src', variation.image.url);

				if (get_main_first.find('.wp-post-image').data("o_img") == get_main_first.find('.wp-post-image').attr("src")) {

					get_main_first.find('.woocommerce-product-gallery__lightbox').data('caption', get_main_first.find('.wp-post-image').data('caption'));
					get_thumb_first.find('img').attr('src', get_thumb_first.find('img').data("thumb"));
					$('.woocommerce-product-gallery__image').find('.zoomImg').attr('src', get_main_first.find('.wp-post-image').data("large_image"));
				}


			});
		});
	});

})(jQuery);

// Other code using $ as an alias to the other library
