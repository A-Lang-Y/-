<?php

$scheme[ cloudfw_id_for_sequence( $scheme, $number ) ] = array(
	'type'			=>	'section',
	'title'			=>	__('Header','cloudfw'),
	'data'			=>	array(

		array(
			'type'		=>	'module-set',
			'title'		=>	__('Header','cloudfw'),
			'closable'	=>	true,
			'state'		=>	'opened',
			'data'		=>	array(

				## Module Item
				array(
					'type'		=>	'module',
					'ucode'		=>	'HEADER BACKGROUND',
					'title'		=>	__('Background','cloudfw'),
					'data'		=>	array( 

						array(
							'type'		=>	'grid',
							'data'		=>	array(
								
								array(
									'type'		=>	'gradient',
									'title'		=>	__('Background-Color','cloudfw'),
									'id'		=>	cloudfw_sanitize('header','gradient'),
									'value'		=>	$data['header']['gradient'],
								),
								array(
									'type'		=>	'bg-set',
									'id'		=>	'header',
									'id:pattern'=>	'header',
									'value'		=>	$data,
									'attachment'=>	false
								)
							
							)
							
						),
						
					)

				),


				## Module Item
				array(
					'type'		=>	'module',
					'ucode'		=>	'HEADER BORDER',
					'title'		=>	__('Border Bottom','cloudfw'),
					'data'		=>	array(
						
						array(
							'type'		=>	'color',
							'style'		=>	'horizontal',
							'id'		=>	cloudfw_sanitize('header','+border-bottom'),
							'value'		=>	$data['header']['+border-bottom'],
						),

					
					)
							

				), 

				## Module Item
				array(
					'type'		=>	'module',
					'ucode'		=>	'CONTENT',
					'title'		=>	__('Text Color','cloudfw'),
					'layout'	=>	'float',
					'data'		=>	array(
						## Element
						array(
							'type'		=>	'color',
							'style'		=>	'horizontal',
							'title'		=>	__('Color','cloudfw'),
							'id'		=>	cloudfw_sanitize('header_text','color'),
							'value'		=>	$data['header_text']['color'],

						),

					)

				),


				## Module Item
				array(
					'type'		=>	'module',
					'ucode'		=>	'CONTENT LINK',
					'title'		=>	__('Link Colors','cloudfw'),
					'layout'	=>	'float',
					'data'		=>	array(
						## Element
						array(
							'type'		=>	'color',
							'style'		=>	'horizontal',
							'title'		=>	__('Color','cloudfw'),
							'id'		=>	cloudfw_sanitize('header_link','color'),
							'value'		=>	$data['header_link']['color'],

						),

						## Element
						array(
							'type'		=>	'color',
							'style'		=>	'horizontal',
							'title'		=>	__('Hover Color','cloudfw'),
							'id'		=>	cloudfw_sanitize('header_link_hover','color'),
							'value'		=>	$data['header_link_hover']['color'],

						),

						array(
							'type'		=>	'select',
							'ui'		=>	true,
							'width'		=>	120,
							'title'		=>	__('Text-Decoration','cloudfw'),
							'id'		=>	cloudfw_sanitize('header_link','text-decoration'),
							'value'		=>	$data['header_link']['text-decoration'],
							'source'	=>	$array_text_decorations,

						),
						array(
							
							'type'		=>	'select',
							'ui'		=>	true,
							'width'		=>	120,
							'title'		=>	__('Text-Decoration Hover','cloudfw'),
							'id'		=>	cloudfw_sanitize('header_link_hover','text-decoration'),
							'value'		=>	$data['header_link_hover']['text-decoration'],
							'source'	=>	$array_text_decorations,
							
						)

					)

				),

			)

		),
	
	) 

);