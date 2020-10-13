<?php
/**
 *	Register Setup Options Map
 *
 *	@package 	CloudFw
 *	@subpackage Portfolio
 *	@version 	1.0
 */
add_filter( 'cloudfw_maps_setup_object', 'cloudfw_module_setup_map_portfolio' );
function cloudfw_module_setup_map_portfolio( $map ) {
    $map  -> option	 ( 'portfolio' )
          -> sub  	 ( 'related_layout', "[section style_id='section-related-posts' margin_bottom='-12px']\r\n\t[related_portfolios]\r\n\t\t{{results}}\r\n\t[/related_portfolios]\r\n[/section]" )
          -> sub  	 ( 'related_layout_sidebar', "[related_portfolios title_element='h6']\r\n\t{{results}}\r\n[/related_portfolios]" )
    ;

	return $map;
}