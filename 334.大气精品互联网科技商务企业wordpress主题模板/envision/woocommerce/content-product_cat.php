<?php
/**
 * The template for displaying product category thumbnails within loops.
 *
 * Override this template by copying it to yourtheme/woocommerce/content-product_cat.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $product, $post, $woocommerce_loop;

$column = cloudfw_get_option( 'woocommerce', 'catalog_column' );
if ( !empty($column) ) {
	$woocommerce_loop['columns'] = $column;
}

$woocommerce_loop['shadow'] = cloudfw_get_option( 'woocommerce', 'catalog_shadow' );
$woocommerce_loop['effect'] = cloudfw_get_option( 'woocommerce', 'catalog_effect' );
$woocommerce_loop['show_hover'] = cloudfw_check_onoff( 'woocommerce', 'catalog_hover' );
$woocommerce_loop['hover_effect'] = cloudfw_get_option( 'woocommerce', 'catalog_hover_effect' );



// Store loop count we're currently on
if ( empty( $woocommerce_loop['loop'] ) ) {
	$woocommerce_loop['loop'] = 0;
}

// Store column count for displaying the grid
if ( empty( $woocommerce_loop['columns'] ) ) {
	$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 3 );
}

if ( $woocommerce_loop['columns'] > 4 ) {
	$woocommerce_loop['columns'] = 4;
}



// Increase loop count
$woocommerce_loop['loop']++;

$box = array();
$box['columns'] = $woocommerce_loop['columns']; 
$box['title'] = $category->name; 

if ( $category->count > 0 )
	$box['caption'] = apply_filters( 'woocommerce_subcategory_count_html', ' <span class="count">' . $category->count . ' Item(s)</span>', $category );


$box['class'] = 'product-category product'; 
$box['overlay'] = true; 
$box['lightbox'] = false; 
$box['link'] = get_term_link( $category->slug, 'product_cat' ); 

$item_content = '';

$box['button_text'] = __('Products','woocommerce');
$box['icon'] = ''; 
$box['shadow'] = isset($woocommerce_loop['shadow']) ? $woocommerce_loop['shadow'] : NULL;
$box['image_ratio'] = !empty($woocommerce_loop['image_ratio']) ? $woocommerce_loop['image_ratio'] : cloudfw_get_option( 'woocommerce', 'catalog_media_ratio' );



$thumbnail_id = get_woocommerce_term_meta( $category->term_id, 'thumbnail_id', true  );

if ( $thumbnail_id ) {
	$image = wp_get_attachment_image_src( $thumbnail_id, 'large' );
	$box['image'] = $image[0];
} else {
	$box['image'] = woocommerce_placeholder_img_src();
}


$column_array = array();
$column_array['class'] = array();
$column_array['_key'] = 'woocommerce';

$box_content = cloudfw_UI_box( $box, $item_content );

global $woocommerce_loop_output;
$woocommerce_loop_output .= cloudfw_UI_column( $column_array, $box_content, '1of' . $woocommerce_loop['columns'] . ( $woocommerce_loop['loop'] % $woocommerce_loop['columns'] == 0 ? '_last' : '' ) );
