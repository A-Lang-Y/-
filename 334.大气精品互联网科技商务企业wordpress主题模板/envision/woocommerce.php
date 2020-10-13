<?php
/**
 *	WooCommerce Page Layout
 *
 *	@since 1.0
 */
ob_start();
woocommerce_page_title();
$title = ob_get_contents();
ob_end_clean();

$post_type = cloudfw( 'get_post_type' ); 
$shop_page_id = woocommerce_get_page_id( 'shop' );

if ( $post_type !== 'product' ) {
	cloudfw( 'set_ID', $shop_page_id, false );
	cloudfw( 'set', 'woocommerce_is_page', 'shop');

	if ( is_product_category() ) {
		$description = '';  
	}

	
} else {
	cloudfw( 'set', 'woocommerce_is_page', 'product');
	$layout = cloudfw_get_option('woocommerce', 'post_page_layout');
	$sidebar = cloudfw_get_option('woocommerce', 'post_page_sidebar');

	$title = cloudfw( 'get_meta', 'titlebar_title' ) ? cloudfw( 'get_meta', 'titlebar_title' ) : $title;  


}

cloudfw( 'set_meta', 'titlebar_title', $title );
cloudfw( 'set', 'woocommerce', true);

if ( isset($description) ) {
	cloudfw( 'set_meta', 'titlebar_text', $description );
}

$layout = apply_filters( 'cloudfw_wc_shop_layout', isset($layout) ? $layout : '' );

if ( !empty($sidebar) ) {
	cloudfw( 'set', 'custom_sidebar', $sidebar);
}

if ( !empty($layout) ) {
	cloudfw('return_layout', $layout);
}

cloudfw('return_layout', 'page.php');