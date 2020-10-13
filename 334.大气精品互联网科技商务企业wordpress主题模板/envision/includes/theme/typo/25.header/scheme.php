<?php

$scheme[ cloudfw_id_for_sequence( $scheme, $number ) ] = array(
	'type'			=>	'container',
	'width'			=>	940,
	'footer'		=>	false,
	'title'			=>	__('Header','cloudfw'),
	'data'			=>	array(
	
		array(
			'type'		=>	'typo-set',
			'title'		=>	__('Top Bar','cloudfw'),
			'id'		=>	cloudfw_sanitize('topbar'),
			'value'		=>	$data['topbar'],
			'data'		=>	array( 
				'line-height' => false
			)
		),

		array(
			'type'		=>	'mini-section',
			'title'		=>	__('Title Bar','cloudfw'),
			'data'		=>	array( 

				array(
					'type'		=>	'typo-set',
					'title'		=>	__('Title Bar Title','cloudfw'),
					'id'		=>	cloudfw_sanitize('titlebar_title'),
					'value'		=>	$data['titlebar_title'],
					'data'		=>	array( 
					)
					
				),

				array(
					'type'		=>	'typo-set',
					'title'		=>	__('Title Bar Title (Strong Style)','cloudfw'),
					'id'		=>	cloudfw_sanitize('titlebar_title_strong'),
					'value'		=>	$data['titlebar_title_strong'],
					'data'		=>	array(
						'line-height' => false
					)
					
				),

				array(
					'type'		=>	'typo-set',
					'title'		=>	__('Title Bar Text','cloudfw'),
					'id'		=>	cloudfw_sanitize('titlebar_text'),
					'value'		=>	$data['titlebar_text'],
					'data'		=>	array( 
					)
					
				),

				array(
					'type'		=>	'typo-set',
					'title'		=>	__('Breadcrumb','cloudfw'),
					'id'		=>	cloudfw_sanitize('breadcrumb'),
					'value'		=>	$data['breadcrumb'],
					'data'		=>	array( 
					)
					
				),

			)
		),

	
	) 


);