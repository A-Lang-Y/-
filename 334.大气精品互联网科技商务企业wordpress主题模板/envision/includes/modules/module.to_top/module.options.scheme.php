<?php

/**
 *	Register Options Scheme
 *
 *	@package 	CloudFw
 *	@subpackage Portfolio
 *	@version 	1.0
 */
add_filter( 'cloudfw_schemes_options', 'cloudfw_module_option_to_top' );
function cloudfw_module_option_to_top( $schemes ) {
	return cloudfw_add_option_scheme( 'module',
		$schemes,

		 array(
			'type'		=>	'vertical_tabs',
			'tab_id' 	=>	'to_top_button',
			'tab_title' =>	__('To Top Button','cloudfw'),
			'form'  =>  array(
				'enable'    => true,
				'ajax'      => true,
				'shortcut'  => true,
			),
			'data'		=>	array(

				array(
					'type'			=>	'container',
					'title'			=>	__('To Top Button','cloudfw'),
					'footer'		=>	false,
					'data'			=>	array(

						array(
							'type'		=> 'module',
							'title'		=>	__('Button Color','cloudfw'),
							'data'		=> array(

								## Element
								array(
									'type'		=>	'select',
									'id'		=>	cloudfw_sanitize( PFIX.'_to_top button_color' ),
									'value'		=>	cloudfw_get_option( 'to_top',  'button_color' ),
									'source'	=>	array(
										'type'		=>	'function',
										'function'	=>	'cloudfw_admin_loop_button_colors',
										'prepend'	=>	__('Default','cloudfw'),
									),
									'width'		=>	250,
								)

							)

						),

					)

				),
			
				## Module Item
				array(
					'type'		=>	'submit',
					'layout'	=>	'fixed',
					'nomargin'	=> 	true,
				), 

			)

		)
	);

	return $schemes;
}