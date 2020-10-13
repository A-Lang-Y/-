<?php

$scheme[ cloudfw_id_for_sequence( $scheme, $number ) ] = array(
	'type'			=>	'section',
	'title'			=>	__('Other Elements','cloudfw'),
	'data'			=>	array(

		array(
			'type'		=>	'module-set',
			'title'		=>	__('Page Preloader','cloudfw'),
			'closable'	=>	true,
			'state'		=>	'opened',
			'data'		=>	array(

				## Module Item
				array(
					'type'		=>	'module',
					'ucode'		=>	'PRELOADER',
					'layout'	=>	'split',
					'title'		=>	array(__('Background Color','cloudfw'), __('Text Color','cloudfw')),
					'data'		=>	array(
						
						array(
							'type'		=>	'color',
							'style'		=>	'horizontal',
							'id'		=>	cloudfw_sanitize('preloader_background','background-color'),
							'value'		=>	$data['preloader_background']['background-color'],
						),

						array(
							'type'		=>	'color',
							'style'		=>	'horizontal',
							'id'		=>	cloudfw_sanitize('preloader_text','color'),
							'value'		=>	$data['preloader_text']['color'],
						),
					
					)
							

				), 

			)

		), 
	
	) 

);