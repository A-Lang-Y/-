<?php
/**
 * Single Product Image
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.14
 * 
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $post, $woocommerce, $product;

?>
<div class="images">

	<?php

	$attachment_ids = (array) $product->get_gallery_attachment_ids();
	$attachment_ids = array_merge( array( get_post_thumbnail_id() ), $attachment_ids);
	$attachment_ids = array_filter( $attachment_ids ); 
	$attachment_ids_count = count($attachment_ids); 


	if ( $attachment_ids ) {

			$gallery = array();
			foreach ( $attachment_ids as $attachment_id ) {

				$image_link = wp_get_attachment_url( $attachment_id );

				if ( ! $image_link )
					continue;

				$image 		 = wp_get_attachment_image_src( $attachment_id, 'large');
				$image_class = esc_attr( implode( ' ', isset($classes) ? $classes : array() ) );
				$image_title = esc_attr( get_the_title( $attachment_id ) );

				$gallery[] 	 = array( 'src' => $image[0], 'width' => $image[1], 'height' => $image[2], 'link' => $image_link, 'alt' => $image_title );

			}


			$image_width = 200;  
			$image_height = cloudfw_match_ratio( $image_width, '1:1' );

			$slider_class = array();  
			$slider_class[] = 'ui--shop-gallery';
			if ( $attachment_ids_count > 1 ) {
				$slider_class[] = 'ui--shop-gallery-multi';  
			}


			$gallery_content = cloudfw_UI_gallery() 
					-> set('id', 'ui--shop-slider')
					-> set('class', $slider_class)
					-> set('alt', !empty($image_title) ? $image_title : get_the_title())
					-> set('slides_element', 'ul')
					-> set('item_element', 'li')
					-> set('slides_class', 'slides')
					-> set('link_class', 'zoom')
					-> set('item_class', 'ui--shop-gallery-item')
					-> set('image_class', 'ui--shop-gallery-image')
					-> set('lightbox_group', 'prettyPhoto[shop_gallery]')
					//-> set('width', $image_width)
					//-> set('height', $image_height)
					-> items( $gallery )
					-> render();

			echo apply_filters( 'woocommerce_single_product_image_html', $gallery_content );

	} else {
		echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<img class="ui--shop-gallery-image" src="%s" alt="Placeholder" />', woocommerce_placeholder_img_src() ), $post->ID );
	}

	if ( $attachment_ids_count > 1 ): ?>

	<script type="text/javascript">

		jQuery(window).load(function() {
			var carousel = jQuery('#ui--shop-slider-carousel'); 
			var slider = jQuery('#ui--shop-slider'); 

			carousel.show().flexslider({
				animation: "slide",
				controlNav: false,
				animationLoop: false,
				slideshow: false,
				itemWidth: 150,
				itemMargin: 18,
				animationSpeed: 500,
				asNavFor: '#ui--shop-slider'
			});

			slider.flexslider({
				animation: "slide",
				controlNav: false,
				animationLoop: false,
				slideshow: false,
				smoothHeight: true,
				animationSpeed: 500,
				sync: "#ui--shop-slider-carousel"
			}).css({'visibility': 'visible'});

			carousel.find('.flex-prev').remove();
			carousel.find('.flex-next').remove();
			slider.find('.flex-prev').html('<span class=\"arr arr-large arr-left ui--carosuel-prev\"><span></span><i class=\"fontawesome-chevron-left px18\"></i></span>');
			slider.find('.flex-next').html('<span class=\"arr arr-large ui--carosuel-next\"><span></span><i class=\"fontawesome-chevron-right px18\"></i></span>');

			jQuery('form.variations_form .variations select').change(function(){
				
	            setTimeout(function () {
	                jQuery(window).resize();
	            }, 100)
			});

		});

	</script>

	<?php endif; ?>

	<?php do_action( 'woocommerce_product_thumbnails' ); ?>

</div>
