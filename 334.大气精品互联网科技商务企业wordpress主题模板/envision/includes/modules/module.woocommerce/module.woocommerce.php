<?php

/*
 * Plugin Name: WooCommerce
 * Plugin URI: http://cloudfw.net
 * Description:  
 * Version: 1.0
 * Author: Orkun Gürsel
 * Author URI: http://orkungursel.com
 */


if ( cloudfw_woocommerce() ) {
	if ( file_exists(dirname(__FILE__) . '/woocommerce.php') )
	   include_once( dirname(__FILE__) . '/woocommerce.php' );

	if ( file_exists(dirname(__FILE__) . '/module.options.php') )
	   include_once( dirname(__FILE__) . '/module.options.php' );

	if ( file_exists(dirname(__FILE__) . '/module.shortcode.php') )
	   include_once( dirname(__FILE__) . '/module.shortcode.php' );

	if ( file_exists(dirname(__FILE__) . '/module.hooks.php') )
	   include_once( dirname(__FILE__) . '/module.hooks.php' );
	
	add_filter( 'woocommerce_enqueue_styles', '__return_false' );
}

/**
 *	Filter for Product per page
 */
add_filter( 'woocommerce_placeholder_img_src', 'cloudfw_wc_placeholder_img_src' );
function cloudfw_wc_placeholder_img_src( $size ) {

	return cloudfw_placeholder( 'shop', $size );

	return TMP_LIB . 'images/shop-placeholder.png';
}


/**
 *	Filter for Product per page
 */
add_filter( 'loop_shop_per_page', 'cloudfw_loop_shop_per_page', 20 );
function cloudfw_loop_shop_per_page( $cols ) {
	$default = cloudfw_get_option( 'woocommerce', 'catalog_post_perpage', 24 );

	if ( ! (int) $default > 0 ) {
		$default = 24;
	}

	$show_products = isset($_GET['show_products']) ? (int) $_GET['show_products'] : $default;
	return $show_products ? $show_products : $default;
}

/**
 *	Force login page for layout
 */
add_filter( 'cloudfw_check_type', 'cloudfw_wc_check_page' );
function cloudfw_wc_check_page( $that ) {

	if ( cloudfw_woocommerce() && ! is_user_logged_in() ) {
		$myaccount_page_id = (int) woocommerce_get_page_id( 'myaccount' );
		$current_page_id = (int) $that->get_ID(); 

		if ( $current_page_id > 0 && $current_page_id === $myaccount_page_id ) {
			$that->set( 'force_layout', 'page.php' );
			$that->return_layout( 'default' );
		}
	}

}

/**
 * Makes badge for Products
 * @param  string $location
 * @return string
 */
function cloudfw_wc_badge( $location = '' ) {
	global $post, $product;

	$badge = ''; 
	if ( ! $product->is_in_stock() ) {
		$badge = '<span class="out-of-stock-badge">'. cloudfw_translate( 'wc.loop.badge.out_of_stock' ) .'</span>';
	} elseif ( $product->price === '0' || $product->price === 0 ) {
		$badge = '<span class="free-badge">'. cloudfw_translate( 'wc.loop.badge.free' ) .'</span>';
	} elseif ($product->is_on_sale()) {
		$badge = apply_filters('woocommerce_sale_flash', '<span class="onsale">'. cloudfw_translate( 'wc.loop.badge.sale' ) .'</span>', $post, $product);
	}

	if ( !empty( $badge ) ) {
		if ( $location == 'loop' ) {
			$badge = '<span class="ui--wc-badge">'. $badge .'</span>';
		}
	}

	return $badge;

}


function cloudfw_wc_rating_icons( $before = '', $after = '', $product = NULL, $microdata = true ) {
	if ( ! $product ) {
		global $product;
	}

	$out = ''; 
	$count = $product->get_rating_count();
	if ( $count > 0 ) {

		$average = $product->get_average_rating();
		if ( $microdata ) {
			$out = '
				<div class="ui--star-rating" itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating" title="'.sprintf(__( 'Rated %s out of 5', 'woocommerce' ), $average ).'">
					<div class="ui--star-rating-text hidden"><strong itemprop="ratingValue" class="rating">'.$average.'</strong> '.__( 'out of 5', 'woocommerce' ).'</div>
					<meta itemprop="reviewCount" content="'. $count .'">
					<div class="ui--star-rating-background">
						<i class="ui--star icon fontawesome-star-empty"></i>
						<i class="ui--star icon fontawesome-star-empty"></i>
						<i class="ui--star icon fontawesome-star-empty"></i>
						<i class="ui--star icon fontawesome-star-empty"></i>
						<i class="ui--star icon fontawesome-star-empty"></i>
					</div>
					<div class="ui--star-rating-highlight" style="width:'.( ( $average / 5 ) * 100 ) . '%">
						<i class="ui--star icon fontawesome-star"></i>
						<i class="ui--star icon fontawesome-star"></i>
						<i class="ui--star icon fontawesome-star"></i>
						<i class="ui--star icon fontawesome-star"></i>
						<i class="ui--star icon fontawesome-star"></i>
					</div>
				</div>

			';
		} else {
			$out = '
				<div class="ui--star-rating" title="'.sprintf(__( 'Rated %s out of 5', 'woocommerce' ), $average ).'">
					<div class="ui--star-rating-text hidden"><strong class="rating">'.$average.'</strong> '.__( 'out of 5', 'woocommerce' ).'</div>
					<div class="ui--star-rating-background">
						<i class="ui--star icon fontawesome-star-empty"></i>
						<i class="ui--star icon fontawesome-star-empty"></i>
						<i class="ui--star icon fontawesome-star-empty"></i>
						<i class="ui--star icon fontawesome-star-empty"></i>
						<i class="ui--star icon fontawesome-star-empty"></i>
					</div>
					<div class="ui--star-rating-highlight" style="width:'.( ( $average / 5 ) * 100 ) . '%">
						<i class="ui--star icon fontawesome-star"></i>
						<i class="ui--star icon fontawesome-star"></i>
						<i class="ui--star icon fontawesome-star"></i>
						<i class="ui--star icon fontawesome-star"></i>
						<i class="ui--star icon fontawesome-star"></i>
					</div>
				</div>

			';		}

		$out = $before . $out . $after;

	}

	return $out;
}