<?php
/**
 * Single Product Thumbnails
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.3
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $post, $product, $woocommerce;

$attachment_ids = (array) $product->get_gallery_attachment_ids();
$attachment_ids = array_merge( array( get_post_thumbnail_id() ), $attachment_ids);
$attachment_ids = array_filter( $attachment_ids ); 

if ( $attachment_ids ) {
	?>

	<?php


		$gallery = array();
		foreach ( $attachment_ids as $attachment_id ) {

			$image_link = wp_get_attachment_url( $attachment_id );

			if ( ! $image_link )
				continue;

			$image 		 = wp_get_attachment_image_src( $attachment_id, 'large');
			//$image_class = esc_attr( implode( ' ', isset($classes) ? $classes : array() ) );
			//$image_title = esc_attr( get_the_title( $attachment_id ) );

			$gallery[] 	 = array( 'src' => $image[0], 'link' => $image_link );

		}


		$image_width = 200;  
		$image_height = cloudfw_match_ratio( $image_width, '1:1' );

		$gallery_content = cloudfw_UI_gallery() 
				-> set('id', 'ui--shop-slider-carousel')
				-> set('class', 'ui--shop-gallery')
				-> set('slides_element', 'ul')
				-> set('item_element', 'li')
				-> set('slides_class', 'slides')
				-> set('item_class', 'ui--shop-gallery-item')
				-> set('image_class', 'ui--shop-gallery-image')
				-> set('width', $image_width)
				-> set('height', $image_height)
				-> items( $gallery )
				-> render();

		echo $gallery_content;


	?>

	<?php
}