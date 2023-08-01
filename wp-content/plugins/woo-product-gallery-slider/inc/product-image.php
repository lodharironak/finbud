<?php

/**
 * Single Product Image
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-image.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @version 3.5.1
 * @package WooCommerce\Templates
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 */

defined( 'ABSPATH' ) || exit;

// Note: `wc_get_gallery_image_html` was added in WC 3.3.2 and did not exist prior. This check protects against theme overrides being used on older versions of WC.
if ( !function_exists( 'wc_get_gallery_image_html' ) ) {
	return;
}

global $product;
$post_thumbnail_id = $product->get_image_id();
$gallery_options   = get_option( 'wpgs_form' );
$html              = '';
$wrapper_classes   = apply_filters( 'woocommerce_single_product_image_gallery_classes', array(
	'woo-product-gallery-slider',
	'woocommerce-product-gallery',
	'wpgs--' . ( has_post_thumbnail() ? 'with-images' : 'without-images' ),
	'images',

) );

$slider_rtl         = ( is_rtl() ) ? 'true' : 'false';
$lightbox_img_count = ( $gallery_options['lightbox_img_count'] == '1' ) ? 'true' : 'false';

do_action( 'wpgs_before_image_gallery' );

?>

<div class="<?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', $wrapper_classes ) ) ); ?>" <?php echo esc_attr( $slider_rtl == 'true' ? 'dir=rtl' : '' ); ?> >

		<?php

if ( has_post_thumbnail() ) {

	$image = wp_get_attachment_image( $post_thumbnail_id, $gallery_options['slider_image_size'], true, array(
		"class"            => "attachment-shop_single size-shop_single wp-post-image",
		"data-zoom_src"    => wp_get_attachment_image_src( $post_thumbnail_id, apply_filters( 'gallery_slider_zoom_image_size', 'full' ) )[0],
		'alt'              => trim( wp_strip_all_tags( get_post_meta( $post_thumbnail_id, '_wp_attachment_image_alt', true ) ) ),
		'data-o_img'       => wp_get_attachment_image_url( $post_thumbnail_id, apply_filters( 'wpgs_new_main_img_size', wpgs_get_option( 'slider_image_size' ) ) ),
		'data-large_image' => wp_get_attachment_image_url( $post_thumbnail_id, apply_filters( 'gallery_slider_zoom_image_size', 'large' ) ),
		'data-zoom-image'  => wp_get_attachment_image_url( $post_thumbnail_id, apply_filters( 'gallery_slider_zoom_image_size', 'large' ) ),
	) );

	echo '<div class="wpgs-for">';
	$attachment_ids = $product->get_gallery_image_ids();

	$lightbox_src = wc_get_product_attachment_props( $post_thumbnail_id );

	$img_caption = get_the_title( $post_thumbnail_id );

	if ( $gallery_options['lightbox_picker'] == '1' ) {
		$html .= '<div class="woocommerce-product-gallery__image single-product-main-image">';
		$html .= '<a class="wpgs-lightbox-icon" data-caption="' . $img_caption . '" data-fancybox="wpgs-lightbox"  href="' . $lightbox_src['url'] . '"     data-mobile=["clickContent:close","clickSlide:close"] 	data-click-slide="close" 	data-animation-effect="fade" 	data-loop="true"     data-infobar="' . $lightbox_img_count . '"     data-hash="false" >' . $image . '</a></div>';

		echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', $html, $post_thumbnail_id );

	} else {
		$html .= '<div class="woocommerce-product-gallery__image single-product-main-image">' . $image . '</div>';
		echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', $html, $post_thumbnail_id );
	}

	if ( $attachment_ids ) {
		foreach ( $attachment_ids as $attachment_id ) {
			$thumbnail_image = wp_get_attachment_image(
				$attachment_id, $gallery_options['slider_image_size'], true, [
					"class"         => "attachment-shop_single",
					"data-zoom_src" => wp_get_attachment_image_src( $attachment_id, apply_filters( 'gallery_slider_zoom_image_size', 'full' ) )[0],
					'alt'           => trim( wp_strip_all_tags( get_post_meta( $attachment_id, '_wp_attachment_image_alt', true ) ) ),
				]
			);
			$lightbox_src = wc_get_product_attachment_props( $attachment_id );

			$img_caption     = get_the_title( $attachment_id );
			$attachment_html = '';
			if ( $gallery_options['lightbox_picker'] == '1' ) {
				$attachment_html .= '<div><a class="wpgs-lightbox-icon" data-fancybox="wpgs-lightbox"                 data-caption="' . $img_caption . '"                 href="' . $lightbox_src['url'] . '"                                  data-mobile=["clickContent:close","clickSlide:close"] 				data-click-slide="close" 				data-animation-effect="fade" 				data-loop="true"                 data-hash="false"                 data-infobar="' . $lightbox_img_count . '"                 >' . $thumbnail_image . '</a></div>';
				echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', $attachment_html, $post_thumbnail_id );

			} else {
				$attachment_html .= '<div>' . $thumbnail_image . '</div>';
				echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', $attachment_html, $post_thumbnail_id );

			}

		}
	}
	echo "</div>";
} else {
	$html = '<div class="woocommerce-product-gallery__image--placeholder">';
	$html .= sprintf( '<img src="%s" alt="%s" class="wp-post-image" />', esc_url( wc_placeholder_img_src( 'woocommerce_single' ) ), esc_html__( 'Awaiting product image', 'woocommerce' ) );
	$html .= '</div>';
	echo $html;
}

//echo apply_filters('woocommerce_single_product_image_thumbnail_html', $html, $post_thumbnail_id);

do_action( 'woocommerce_product_thumbnails' );

$attachment_ids         = $product->get_gallery_image_ids();
$gallery_thumbnail_size = $gallery_options['thumbnail_image_size'];

if ( $attachment_ids && has_post_thumbnail() ) {
	echo '<div class="wpgs-nav">';
	$image = wp_get_attachment_image( $post_thumbnail_id, $gallery_thumbnail_size, true, [
		"class" => "wpgs-thumb-main-image",
		'alt'   => trim( wp_strip_all_tags( get_post_meta( $post_thumbnail_id, '_wp_attachment_image_alt', true ) ) ),
	] );
	echo '<div>' . $image . '</div>';

	foreach ( $attachment_ids as $attachment_id ) {
		$thumbnail_image = wp_get_attachment_image( $attachment_id, $gallery_thumbnail_size, true, [
			'alt' => trim( wp_strip_all_tags( get_post_meta( $attachment_id, '_wp_attachment_image_alt', true ) ) ),
		] );
		echo '<div>' . $thumbnail_image . '</div>';
	}
	echo "</div>";
}
do_action( 'wpgs_after_image_gallery' );

?>

</div>
