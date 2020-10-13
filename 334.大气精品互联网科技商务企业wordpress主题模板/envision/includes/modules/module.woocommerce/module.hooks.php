<?php

/** Translatable Strings */
//add_filter( 'woocommerce_variation_free_price_html', 'cloudfw_woocommerce_sale_price_html', 10, 2 );
//add_filter( 'woocommerce_variable_free_price_html', 'cloudfw_woocommerce_sale_price_html', 10, 2 );

/**
 * Gets Price HTML "From" Text
 * @param  string $price
 * @return string
 */
/*function cloudfw_woocommerce_get_price_html_from_text( $price ){
	return sprintf( cloudfw_translate( 'wc.price_from' ), $price);
}

add_filter( 'woocommerce_variable_sale_price_html', 'cloudfw_woocommerce_variable_sale_price_html', 10, 2 );
function cloudfw_woocommerce_variable_sale_price_html( $price, $that ){
	$price = $that->get_price_html_from_to( $that->min_variation_regular_price, $that->get_price() );

	if ( ! $that->min_variation_price || $that->min_variation_price !== $that->max_variation_price ) {
		$price = cloudfw_woocommerce_get_price_html_from_text( $price );
	}

	return $price;
}


add_filter( 'woocommerce_variable_free_sale_price_html', 'cloudfw_woocommerce_variable_free_sale_price_html', 10, 2 );
function cloudfw_woocommerce_variable_free_sale_price_html( $price, $that ){
	$price = $that->get_price_html_from_to( $that->min_variation_regular_price, cloudfw_translate( 'wc.price_free' ) );

	if ( $that->min_variation_price !== $that->max_variation_price ) {
		$price = cloudfw_woocommerce_get_price_html_from_text( $price );
	}

	return $price;
}


add_filter( 'woocommerce_free_price_html', 'cloudfw_woocommerce_sale_price_html', 10, 2 );
add_filter( 'woocommerce_variation_free_price_html', 'cloudfw_woocommerce_sale_price_html', 10, 2 );
function cloudfw_woocommerce_sale_price_html( $price, $that ){
	return cloudfw_translate( 'wc.price_free' );
}

add_filter( 'woocommerce_free_sale_price_html', 'cloudfw_woocommerce_free_sale_price_html', 10, 2 );
function cloudfw_woocommerce_free_sale_price_html( $price, $that ){
	return $that->get_price_html_from_to( $that->regular_price, cloudfw_translate( 'wc.price_free' ) );
}*/