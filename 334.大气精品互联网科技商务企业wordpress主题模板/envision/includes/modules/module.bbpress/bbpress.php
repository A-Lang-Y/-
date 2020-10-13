<?php
add_filter ('bbp_no_breadcrumb', '__return_true');

/**
 *	Register Options Map
 *
 *	@package 	CloudFw
 *	@version 	1.0
 */
add_filter( 'cloudfw_maps_options_object', 'cloudfw_module_map_bbpress' );
function cloudfw_module_map_bbpress( $map ) {
    $map  -> option	 ( 'bbpress' )
          -> sub  	 ( 'layout' )
          -> sub  	 ( 'sidebar' )
	      -> sub     ( 'skin' )
	      -> sub     ( 'titlebar_style' )

          -> sub  	 ( 'single_layout' )
          -> sub  	 ( 'single_sidebar' )
	      -> sub     ( 'single_skin' )
	      -> sub     ( 'single_titlebar_style' );

	return $map;
}

/**
 *	Register Options Scheme
 *
 *	@package 	CloudFw
 *	@version 	1.0
 */
add_filter( 'cloudfw_schemes_options', 'cloudfw_module_option_bbpress' );
function cloudfw_module_option_bbpress( $schemes ) {
	$schemes[ cloudfw_id_for_sequence( $schemes, 21 ) ] = array(
		'type'		=> 'page',
		'page' 		=> 'portfolio',
		'portfolio'	=> array(
			'page_title' 	=>	__('BBPress','cloudfw'),
			'page_nice_title'=>	__('bbpress','cloudfw'),
			'page_slug' 	=>	'bbpress',
			'page_css_id' 	=>	'cloud_nav_bbpress',
		),
		'form'	=> 	array(
			'enable'	=> true,
			'ajax'		=> true,
			'shortcut'	=> true,
		),	

		'data'	=> array(
		
			## Tab Item
			array(
				'type'		=>	'vertical_tabs',
				'tab_id' 	=>	'bbpress_page',
				'tab_title' =>	__('Layout','cloudfw'),
				'data'		=>	array(
							
					## Container Item
					array(
						'type'			=>	'container',
						'title'			=>	__('BBPress General','cloudfw'),
						'footer'	=>	false,
						'data'			=>	array(

							array(
								'type'		=>	'global-scheme',
								'scheme'	=>	'page_settings',
								'vars'		=>	array( 'bbpress', array(
									'layout' 		 => 'layout',
									'sidebar' 		 => 'sidebar',
									'titlebar_style' => 'titlebar_style',
									'skin' 			 => 'skin',
								) )
							),
																							
						)

					),

					## Container Item
					array(
						'type'			=>	'container',
						'title'			=>	__('BBPress Single Topic Pages','cloudfw'),
						'data'			=>	array(
							
							array(
								'type'		=>	'global-scheme',
								'scheme'	=>	'page_settings',
								'vars'		=>	array( 'bbpress', array(
									'layout' 		 => 'single_layout',
									'sidebar' 		 => 'single_sidebar',
									'titlebar_style' => 'single_titlebar_style',
									'skin' 			 => 'single_skin',
								) )
							),

																		
						)

					),
						
				)

			), // #### tab: 5			
		
		)
	);

	return $schemes;
}