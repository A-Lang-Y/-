<?php

$scheme[ cloudfw_id_for_sequence( $scheme, $number ) ] = array(
	'type'			=>	'section',
	'title'			=>	__('Content Area','cloudfw'),
	'data'			=>	array(


		array(
			'type'		=>	'module-set',
			'title'		=>	__('Content Area Background','cloudfw'),
			'closable'	=>	true,
			'state'		=>	'opened',
			'data'		=>	array(

				## Module Item
				array(
					'type'      =>  'module',
					'ucode'		=>	'CONTENT BACKGROUND',
					'title'		=>	__('Background','cloudfw'),
					'data'      =>  array( array(
							'type'      =>  'grid',
							//'layout'  =>  'nospaced',
							'data'      =>  array(
								
								array(
									'type'      =>  'gradient',
									'title'     =>  __('Background-Color','cloudfw'),
									'id'        =>  cloudfw_sanitize('page_content_background','gradient'),
									'value'     =>  $data['page_content_background']['gradient'],
								),
								array(
									'type'      =>  'bg-set',
									'id'        =>  'page_content_background',
									'id:pattern'=>  'page_content_background',
									'value'     =>  $data,
								)
							
							)
							
						),
						
					)

				),				

			)

		),

		array(
			'type'		=>	'module-set',
			'title'		=>	__('Content Text & Link Colors','cloudfw'),
			'closable'	=>	true,
			'state'		=>	'opened',
			'data'		=>	array(


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
							'id'		=>	cloudfw_sanitize('page_content','color'),
							'value'		=>	$data['page_content']['color'],

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
							'id'		=>	cloudfw_sanitize('link','color'),
							'value'		=>	$data['link']['color'],

						),

						## Element
						array(
							'type'		=>	'color',
							'style'		=>	'horizontal',
							'title'		=>	__('Hover Color','cloudfw'),
							'id'		=>	cloudfw_sanitize('link_hover','color'),
							'value'		=>	$data['link_hover']['color'],

						),

						array(
							'type'		=>	'select',
							'ui'		=>	true,
							'width'		=>	120,
							'title'		=>	__('Text-Decoration','cloudfw'),
							'id'		=>	cloudfw_sanitize('link','text-decoration'),
							'value'		=>	$data['link']['text-decoration'],
							'source'	=>	$array_text_decorations,

						),
						array(
							
							'type'		=>	'select',
							'ui'		=>	true,
							'width'		=>	120,
							'title'		=>	__('Text-Decoration Hover','cloudfw'),
							'id'		=>	cloudfw_sanitize('link_hover','text-decoration'),
							'value'		=>	$data['link_hover']['text-decoration'],
							'source'	=>	$array_text_decorations,
							
						)

					)

				),


			)

		),

		array(
			'type'		=>	'module-set',
			'title'		=>	__('Headings','cloudfw'),
			'closable'	=>	true,
			'state'		=>	'opened',
			'data'		=>	array(


				## Module Item
				array(
					'type'		=>	'module',
					'ucode'		=>	'HEADING',
					'title'		=>	__('Headings','cloudfw'),
					'layout'	=>	'float',
					'data'		=>	array(
						## Element
						array(
							'type'		=>	'color',
							'style'		=>	'horizontal',
							'title'		=>	__('Color','cloudfw'),
							'id'		=>	cloudfw_sanitize('headings','color'),
							'value'		=>	$data['headings']['color'],

						),

					)

				),

			)

		),
	
	) 

);