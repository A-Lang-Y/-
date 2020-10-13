<?php

$scheme[ cloudfw_id_for_sequence( $scheme, $number ) ] = array(
	'type'			=>	'section',
	'title'			=>	__('Accent Color','cloudfw'),
	'data'			=>	array(

		array(
			'type'		=>	'module-set',
			'title'		=>	__('Accent Colors','cloudfw'),
			'closable'	=>	true,
			'state'		=>	'opened',
			'data'		=>	array(

				## Module Item
				array(
					'type'		=>	'module',
					'ucode'		=>	'ACCENT',
					'title'		=>	__('Accent Colors','cloudfw'),
					'layout'	=>	'float',
					'data'		=>	array(
						## Element
						array(
							'type'		=>	'gradient',
							'title'		=>	__('Background Gradient','cloudfw'),
							'id'		=>	cloudfw_sanitize('accent','gradient'),
							'value'		=>	$data['accent']['gradient'],
						),

						## Element
						array(
							'type'		=>	'color',
							'style'		=>	'horizontal',
							'title'		=>	__('Text Color','cloudfw'),
							'id'		=>	cloudfw_sanitize('accent','color'),
							'value'		=>	$data['accent']['color'],

						),

						## Element
						array(
							'type'		=>	'color',
							'style'		=>	'horizontal',
							'title'		=>	__('Text Shadow','cloudfw'),
							'id'		=>	cloudfw_sanitize('accent','text-shadow color'),
							'value'		=>	$data['accent']['text-shadow']['color'],

						),

						## Element
						array(
							'type'		=>	'select',
							'style'		=>	'horizontal',
							'title'		=>	__('Shadow Direction','cloudfw'),
							'id'		=>	cloudfw_sanitize('accent','text-shadow direction'),
							'value'		=>	$data['accent']['text-shadow']['direction'],
							'source'	=>	array(
								'-1'		=>	__('Top','cloudfw'),
								'1'			=>	__('Bottom','cloudfw'),
							),
							'width'		=>	120

						),

					)

				),

		
			)

		), 
	
	) 

);