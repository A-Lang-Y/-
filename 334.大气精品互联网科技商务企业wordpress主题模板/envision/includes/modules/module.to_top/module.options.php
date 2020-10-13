<?php
/**
 *	Register Options Map
 *
 *	@package 	CloudFw
 *	@subpackage WooCommerce
 *	@version 	1.0
 */
add_filter( 'cloudfw_maps_options_object', 'cloudfw_module_map_to_top' );
function cloudfw_module_map_to_top( $map ) {
     $map -> option	 ( 'to_top' )
          -> sub     ( 'enable', 'FALSE' )
          -> sub     ( 'button_color' )
     ;
	return $map;
}

if ( is_admin() && file_exists(dirname(__FILE__) . '/module.options.scheme.php') ) {
   require_once( dirname(__FILE__) . '/module.options.scheme.php' );
}