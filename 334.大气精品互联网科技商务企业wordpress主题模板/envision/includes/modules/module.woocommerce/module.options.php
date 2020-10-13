<?php


/**
 *	Register Options Map
 *
 *	@package 	CloudFw
 *	@subpackage WooCommerce
 *	@version 	1.0
 */
add_filter( 'cloudfw_maps_options_object', 'cloudfw_module_map_woocommerce' );
function cloudfw_module_map_woocommerce( $map ) {
     $map -> option	 ( 'woocommerce' )
          -> sub     ( 'cart_in_navigation' )
          -> sub     ( 'mini_cart_submit_button_color' )
          -> sub     ( 'mini_cart_secondary_button_color' )
          -> sub     ( 'catalog_mode', 'FALSE' )

          -> sub     ( 'catalog_layout' )
          -> sub     ( 'catalog_column' )
          -> sub     ( 'catalog_post_perpage', 24 )
          -> sub     ( 'catalog_hover' )
          -> sub     ( 'catalog_hover_effect' )
          -> sub     ( 'catalog_posts_per_page' )
          -> sub     ( 'catalog_media_ratio', '3:4' )
          -> sub     ( 'catalog_shadow', 0 )
          -> sub     ( 'catalog_effect' )

          -> sub     ( 'related_column' )
          -> sub     ( 'related_limit' )
          -> sub     ( 'related_layout' )
          -> sub     ( 'related_hover' )
          -> sub     ( 'related_hover_effect' )
          -> sub     ( 'related_posts_per_page' )
          -> sub     ( 'related_media_ratio' )
          -> sub     ( 'related_shadow', 0 )
          -> sub     ( 'related_effect' )

          -> sub  	 ( 'up_sells_column' )
          -> sub  	 ( 'up_sells_limit' )
          -> sub  	 ( 'up_sells_layout' )

          -> sub  	 ( 'cross_sells_column' )
          -> sub  	 ( 'cross_sells_limit' )
          -> sub  	 ( 'cross_sells_layout' )

          -> sub  	 ( 'post_page_layout' )
          -> sub     ( 'post_page_sidebar' )

          -> sub     ( 'login_message' )
          -> sub     ( 'register_message' )
          
          -> sub     ( 'code_single_before_content' )
          -> sub     ( 'code_single_after_content' )

     ;
	return $map;
}

cloudfw_translate_register( 'login_message', 'woocommerce' );
cloudfw_translate_register( 'register_message', 'woocommerce' );
cloudfw_translate_register( 'code_single_before_content', 'woocommerce' );
cloudfw_translate_register( 'code_single_after_content', 'woocommerce' );

if ( is_admin() && file_exists(dirname(__FILE__) . '/module.options.scheme.php') )
   require_once( dirname(__FILE__) . '/module.options.scheme.php' );
