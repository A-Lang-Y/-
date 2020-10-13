<?php
/**
 *	Register Skin Options Map
 *
 *	@package CloudFw
 *	@since 	 1.0
 */
add_filter( 'cloudfw_skin_map_object', 'cloudfw_module_skin_map_portfolio' );
function cloudfw_module_skin_map_portfolio( $map ) {
	return cloudfw_UI_box_skin_map( $map, 'portfolio', '.portfolio-container' );
}

/**
 *	Register Skin Map Scheme
 *
 *	@package CloudFw
 *	@since 	 1.0
 */
add_filter( 'cloudfw_schemes_skin', 'cloudfw_module_skin_option_portfolio', 10, 2 );
function cloudfw_module_skin_option_portfolio( $schemes, $data ) {
	return cloudfw_add_skin_scheme( 'shortcode',
		$schemes,
		array(
			'type'		=>	'module-set',
			'title'		=>	__('Portfolio Posts Grid','cloudfw'),
			'closable'	=>	true,
			'state'		=>	'closed',
			'data'		=>	cloudfw_UI_box_skin_scheme( $data, 'portfolio', 'PORTFOLIO' ),
		),
		5 //seq

	);

}

