<?php
/**
 * Product Loop End
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

global $woocommerce_loop_output, $woocommerce_loop_layout, $woocommerce_loop;
$layout = ''; 

if( isset($woocommerce_loop_layout) && $woocommerce_loop_layout ) {
	$layout = $woocommerce_loop_layout; 
}

$woocommerce_loop_output .= cloudfw_UI_column_close( 'woocommerce' ); 

$is_page = cloudfw( 'get', 'woocommerce_is_page'); 

if ( $is_page == 'shop' ) {
	$layout = cloudfw_get_option('woocommerce', 'catalog_layout');
}

if ( $layout ) {
	$woocommerce_loop_output = cloudfw_make_layout( $layout, $woocommerce_loop_output );
}

if ( !empty($woocommerce_loop['effect']) ) {
	$woocommerce_loop_output = cloudfw_do_shortcode( 'fx', array( 'effect' => $woocommerce_loop['effect'], 'delay' => 300 ), $woocommerce_loop_output );
}

echo $woocommerce_loop_output;
unset($woocommerce_loop_output); 
unset($woocommerce_loop_layout); 
unset($woocommerce_loop); 

?>

</div>
