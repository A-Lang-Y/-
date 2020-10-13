<?php
/**
 * The template for displaying product content within loops.
 *
 * Override this template by copying it to yourtheme/woocommerce/content-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $product, $post, $woocommerce_loop;

$woocommerce_is_page = cloudfw( 'get', 'woocommerce_is_page' ) == 'shop';
if ( $woocommerce_is_page ) {
	$column = cloudfw_get_option( 'woocommerce', 'catalog_column' );
	if ( !empty($column) ) {
		$woocommerce_loop['columns'] = $column;
	}

	$woocommerce_loop['shadow'] = cloudfw_get_option( 'woocommerce', 'catalog_shadow' );
	$woocommerce_loop['effect'] = cloudfw_get_option( 'woocommerce', 'catalog_effect' );
	$woocommerce_loop['show_hover'] = cloudfw_check_onoff( 'woocommerce', 'catalog_hover' );
	$woocommerce_loop['hover_effect'] = cloudfw_get_option( 'woocommerce', 'catalog_hover_effect' );
}


// Store loop count we're currently on
if ( empty( $woocommerce_loop['loop'] ) ) {
	$woocommerce_loop['loop'] = 0;
}

// Store column count for displaying the grid
if ( empty( $woocommerce_loop['columns'] ) ) {
	$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 3 );
}

if ( $woocommerce_loop['columns'] > 6 ) {
	$woocommerce_loop['columns'] = 6;
}

$woocommerce_loop['columns'] = apply_filters( 'cloudfw_wc_shop_columns', $woocommerce_loop['columns'] );

// Ensure visibility
if ( ! $product->is_visible() )
	return;


// Increase loop count
$woocommerce_loop['loop']++;

	$box = array();
	$box['title'] = get_the_title(); 
	$box['columns'] = $woocommerce_loop['columns']; 

	$box['overlay'] = true; 
	$box['lightbox'] = false; 
	$box['link'] = get_permalink(); 
	$item_content = '';
	$box['button_text'] = cloudfw_translate( 'wc.loop.details' );
	$box['icon'] = ''; 
	$box['shadow'] = isset($woocommerce_loop['shadow']) ? $woocommerce_loop['shadow'] : NULL;
	$box['image_ratio'] = !empty($woocommerce_loop['image_ratio']) ? $woocommerce_loop['image_ratio'] : cloudfw_get_option( 'woocommerce', 'catalog_media_ratio' );

	
	if ( has_post_thumbnail() ) {
		$thumbnail_id = get_post_thumbnail_id( $post->ID );
		$large_image = wp_get_attachment_image_src( $thumbnail_id, 'large');
		$box['image'] = $large_image[0];

		if ( isset($woocommerce_loop['show_hover']) && $woocommerce_loop['show_hover'] ) {
			$attachment_ids = $product->get_gallery_attachment_ids();
			if ( !empty($attachment_ids ) && is_array($attachment_ids ) && !empty($attachment_ids[0]) ) {


				$image_hover = wp_get_attachment_image_src( $attachment_ids[0], 'large');
		
				$box['image_hover'] = $image_hover[0];
				$box['hover_effect'] = isset($woocommerce_loop['hover_effect']) ? $woocommerce_loop['hover_effect'] : NULL;
			}
		}

	} else {
		$box['image'] = woocommerce_placeholder_img_src();
	}


	$add_to_cart_link = ''; 
	if ( ! $product->is_in_stock() ) :

		$add_to_cart_link = '<a href="'. apply_filters( 'out_of_stock_add_to_cart_url', get_permalink( $product->id ) ) .'" class="btn btn-small btn-grey">'. apply_filters( 'out_of_stock_add_to_cart_text', __( 'Read More', 'woocommerce' ) ) .'</a>';

	else :

		$add_to_cart = array(
			'url'   => '',
			'label' => '',
			'class' => ''
		);

		$handler = apply_filters( 'woocommerce_add_to_cart_handler', $product->product_type, $product );

		switch ( $handler ) {
			case "variable" :
				$add_to_cart['url'] 	= apply_filters( 'variable_add_to_cart_url', get_permalink( $product->id ) );
				$add_to_cart['label'] 	= apply_filters( 'variable_add_to_cart_text', __('Select options','woocommerce') );
			break;
			case "grouped" :
				$add_to_cart['url'] 	= apply_filters( 'grouped_add_to_cart_url', get_permalink( $product->id ) );
				$add_to_cart['label'] 	= apply_filters( 'grouped_add_to_cart_text', __( 'View options', 'woocommerce' ) );
			break;
			case "external" :
				$add_to_cart['url'] 	= apply_filters( 'external_add_to_cart_url', get_permalink( $product->id ) );
				$add_to_cart['label'] 	= apply_filters( 'external_add_to_cart_text', __( 'Read More', 'woocommerce' ) );
			break;
			default :
				if ( $product->is_purchasable() ) {
					$add_to_cart['url'] 	= apply_filters( 'add_to_cart_url', esc_url( $product->add_to_cart_url() ) );
					$add_to_cart['label'] 	= apply_filters( 'add_to_cart_text', __('Add to cart','woocommerce') );
					$add_to_cart['class']  = apply_filters( 'add_to_cart_class', 'add_to_cart_button' );
				} else {
					$add_to_cart['url'] 	= apply_filters( 'not_purchasable_url', get_permalink( $product->id ) );
					$add_to_cart['label'] 	= apply_filters( 'not_purchasable_text', __( 'Read More', 'woocommerce' ) );
				}
			break;
		}

		$add_to_cart_link =  apply_filters( 'woocommerce_loop_add_to_cart_link', sprintf('<a href="%s" rel="nofollow" data-product_id="%s" data-product_sku="%s" class="%s btn btn-small btn-grey product_type_%s">%s</a>', esc_url( $add_to_cart['url'] ), esc_attr( $product->id ), esc_attr( $product->get_sku() ), esc_attr( $add_to_cart['class'] ), esc_attr( $product->product_type ), esc_html( $add_to_cart['label'] ) ), $product, $add_to_cart );

 endif;

	$box['footer'] = '';
		if ( $price_html = $product->get_price_html() ) {
			$box['footer'] .= '<div class="woocommerce-actions text-center">';
				$box['footer'] .= '<a href="'. $box['link'] .'" class="btn btn-small btn-primary" style="">'. $price_html .'</a>';
				$box['footer'] .= ' ';
				$box['footer'] .= '<div class="woocommerce-loading-wrap">';
				if ( ! cloudfw_check_onoff( 'woocommerce', 'catalog_mode' ) ) {
					$box['footer'] .= $add_to_cart_link;
				}
					$box['footer'] .= '<a class="added_to_cart btn btn-small btn-green" data-i18n-view-cart="'. esc_attr( __('View Cart','woocommerce') ) .'" style="display:none;"><i class="fontawesome-ok"></i> '. cloudfw_translate( 'wc.loop.ajax_added' ) .'</a>';
				$box['footer'] .= '</div>';
			$box['footer'] .= '</div>';
		}

	if ( function_exists('cloudfw_wc_badge') ) {
		$badge = cloudfw_wc_badge( 'loop' );
		if ( $badge ) {
			$box['media_link_append'] = $badge;
		}
	}

	$column_array = array();
	$column_array['class'] = array();
	$column_array['_key'] = 'woocommerce';

	$box_content = cloudfw_UI_box( $box, $item_content );

	global $woocommerce_loop_output;
	$woocommerce_loop_output .= cloudfw_UI_column( $column_array, $box_content, '1of' . $woocommerce_loop['columns'] . ( $woocommerce_loop['loop'] % $woocommerce_loop['columns'] == 0 ? '_last' : '' ) );
?>