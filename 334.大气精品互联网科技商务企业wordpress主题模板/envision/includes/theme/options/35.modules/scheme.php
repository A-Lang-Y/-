<?php

$scheme[ cloudfw_id_for_sequence( $scheme, $number ) ] = array(
	'type'		=> 'page',
	'page' 		=> 'modules',
	'modules'			=> array(
		'page_title' 	=>	__('Modules & Plugins','cloudfw'),
		'page_nice_title'=>	__('modules','cloudfw'),
		'page_slug' 	=>	'modules',
		'page_css_id' 	=>	'cloud_nav_modules',
		'load_file'		=>	array( array(
				'type'		=>	'require',
				'path'		=>	TMP_PATH.'/cloudfw/core/engine.modules/source.modules.php'
			) ),

	),
	'data'	=> array(

		## Vertical Tab Item
		array(
			'type'		=>	'vertical_tabs',
			'tab_id' 	=>	'modules',
			'tab_title' =>	__('All Modules','cloudfw'),
			'form'	=> 	array(
				'enable'	=> true,
				'sending'	=> true,
				'ajax'		=> false,
				'shortcut'	=> true,
				'selector'	=> 'module',
			),		
			'data'		=>	array(

				## Container Item
				array(
					'type'			=>	'container',
					'title'			=>	__('Theme Modules','cloudfw'),
					'data'			=>	array(

						## Module Item
						1	=> array(
							'type'		=>	'message',
							'fill'		=>	true,
							'data'		=>	__('Select modules to activate.','cloudfw'),							
						),

						## Module Item
						5	=> array(
							'type'		=>	'module',
							'layout'	=>	'single',
							'class'		=>	'module_selector',
							'divider'	=>	false,
							'data'		=>	array(
								## Element
								array(
									'type'		=>	'checkbox',
									'id'		=>	PFIX.'_enabled_modules',
									'value'		=>	array(
										'type'		=>	'function',
										'function'	=>	'cloudfw_get_enabled_modules'
									),
									'source'	=>	array(
										'type'		=>	'function',
										'function'	=>	'cloudfw_admin_get_found_modules'
									),
									
								), // #### element: 0
								
							)
							
						), 


					)

				), ## container: 5

			)

		),

		## Tab Item
		array(
			'type'		=>	'vertical_tabs',
			'tab_id'	=>	'plugins',
			'tab_title'	=>	__('Plugin Packages','cloudfw'),
			'divider' 	=>	true,
			'data'		=>	array(
			
				## Container Item
				array(
					'type'		=>	'container',
					'title'		=>	__('Plugin Packages','cloudfw'),
					'footer'	=>	false,
					'data'		=>	array(

						## Module Item
						array(
							'type'		=>	'module',
							'title'		=>	__('Revolution Slider','cloudfw'),
							'data'		=>	array(

								array(
									'type'		=>	'html',
									'data'		=>	'<a data-type="all" class="small-button small-grey" href="'. TMP_URL . '/includes/plugins/revslider.zip' .'"><span>'. __('Download Revolution Slider','cloudfw') .'</span></a>'
								)
									
							)
						),

						## Module Item
						array(
							'type'		=>	'module',
							'title'		=>	__('Envision Custom Login Pages','cloudfw'),
							'data'		=>	array(

								array(
									'type'		=>	'html',
									'data'		=>	'<a data-type="all" class="small-button small-grey" href="'. TMP_URL . '/includes/plugins/wpt-login.zip' .'"><span>'. __('Download Envision - Custom Login Pages','cloudfw') .'</span></a>'
								)
									
							)
						),
							
					)

				),

			),
		
		),
		
	) // page -> data
	
);