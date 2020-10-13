<?php

$scheme[ cloudfw_id_for_sequence( $scheme, $number ) ] = array(
	'type'			=>	'section',
	'title'			=>	__('Left / Right Sidebar','cloudfw'),
	'data'			=>	array(

		array(
			'type'		=>	'module-set',
			'title'		=>	__('Widget Titles','cloudfw'),
			'closable'	=>	true,
			'state'		=>	'opened',
			'data'		=>	array(


				## Module Item
				array(
					'type'		=>	'module',
					'ucode'		=>	'CONTENT',
					'title'		=>	__('Title Color','cloudfw'),
					'layout'	=>	'float',
					'data'		=>	array(
						## Element
						array(
							'type'		=>	'color',
							'style'		=>	'horizontal',
							'id'		=>	cloudfw_sanitize('sidebars_widget_titles','color'),
							'value'		=>	$data['sidebars_widget_titles']['color'],

						),

					)

				),

				## Module Item
				array(
					'type'		=>	'module',
					'ucode'		=>	'CONTENT',
					'title'		=>	array(__('Title Line','cloudfw'), __('Title Bold Line','cloudfw')),
					'layout'	=>	'split',
					'data'		=>	array(
						## Element
						array(
							'type'		=>	'color',
							'style'		=>	'horizontal',
							'id'		=>	cloudfw_sanitize('sidebars_widget_titles','border-color'),
							'value'		=>	$data['sidebars_widget_titles']['border-color'],
						),
						## Element
						array(
							'type'		=>	'color',
							'style'		=>	'horizontal',
							'id'		=>	cloudfw_sanitize('sidebars_widget_titles_border','border-color'),
							'value'		=>	$data['sidebars_widget_titles_border']['border-color'],
						),

					)

				),

			)

		),

		array(
			'type'		=>	'module-set',
			'title'		=>	__('Text & Link Colors','cloudfw'),
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
							'id'		=>	cloudfw_sanitize('sidebars','color'),
							'value'		=>	$data['sidebars']['color'],

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
							'id'		=>	cloudfw_sanitize('sidebars_link','color'),
							'value'		=>	$data['sidebars_link']['color'],

						),

						## Element
						array(
							'type'		=>	'color',
							'style'		=>	'horizontal',
							'title'		=>	__('Hover Color','cloudfw'),
							'id'		=>	cloudfw_sanitize('sidebars_link_hover','color'),
							'value'		=>	$data['sidebars_link_hover']['color'],

						),

						array(
							'type'		=>	'select',
							'ui'		=>	true,
							'width'		=>	120,
							'title'		=>	__('Text-Decoration','cloudfw'),
							'id'		=>	cloudfw_sanitize('sidebars_link','text-decoration'),
							'value'		=>	$data['sidebars_link']['text-decoration'],
							'source'	=>	$array_text_decorations,

						),
						array(
							
							'type'		=>	'select',
							'ui'		=>	true,
							'width'		=>	120,
							'title'		=>	__('Text-Decoration Hover','cloudfw'),
							'id'		=>	cloudfw_sanitize('sidebars_link_hover','text-decoration'),
							'value'		=>	$data['sidebars_link_hover']['text-decoration'],
							'source'	=>	$array_text_decorations,
							
						)

					)

				),


			)

		),
	
	) 

);