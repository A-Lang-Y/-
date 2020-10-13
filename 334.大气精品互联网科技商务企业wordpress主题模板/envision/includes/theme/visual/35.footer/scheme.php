<?php

$scheme[ cloudfw_id_for_sequence( $scheme, $number ) ] = array(
	'type'			=>	'section',
	'title'			=>	__('Footer','cloudfw'),
	'data'			=>	array(

		array(
			'type'		=>	'module-set',
			'title'		=>	__('Widgetized Area','cloudfw'),
			'closable'	=>	true,
			'state'		=>	'opened',
			'data'		=>	array(


				## Module Item
				array(
					'type'		=>	'module',
					'ucode'		=>	'FOOTER WIDGET',
					'title'		=>	__('Background','cloudfw'),
					'data'		=>	array( array(
							'type'		=>	'grid',
							//'layout'	=>	'nospaced',
							'data'		=>	array(
								
								array(
									'type'		=>	'color',
									'title'		=>	__('Background-Color','cloudfw'),
									'id'		=>	cloudfw_sanitize('footer','background-color'),
									'value'		=>	$data['footer']['background-color'],
								),
								array(
									'type'		=>	'bg-set',
									'id'		=>	'footer',
									'id:pattern'=>	'footer',
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
					'ucode'		=>	'FOOTER WIDGET ROW SEPARATOR',
					'title'		=>	__('Separator Line Color','cloudfw'),
					'data'		=>	array(
						
						array(
							'type'		=>	'color',
							'style'		=>	'horizontal',
							'id'		=>	cloudfw_sanitize('footer_widgetized_separator','background-color'),
							'value'		=>	$data['footer_widgetized_separator']['background-color'],
						),

					
					)
							

				), 

				## Module Item
				array(
					'type'		=>	'module',
					'ucode'		=>	'FOOTER WIDGET',
					'layout'	=>	'split',
					'title'		=>	array(__('Title Color','cloudfw'), __('Text Color','cloudfw')),
					'data'		=>	array(
						
						array(
							'type'		=>	'color',
							'style'		=>	'horizontal',
							'id'		=>	cloudfw_sanitize('footer_widgetized_title','color'),
							'value'		=>	$data['footer_widgetized_title']['color'],
						),

						array(
							'type'		=>	'color',
							'style'		=>	'horizontal',
							'id'		=>	cloudfw_sanitize('footer_widgetized','color'),
							'value'		=>	$data['footer_widgetized']['color'],
						),
					
					)
							

				), 

				## Module Item
				array(
					'type'		=>	'module',
					'ucode'		=>	'FOOTER WIDGET LINK',
					'title'		=>	__('Link Colors','cloudfw'),
					'data'		=>	array( 
							
						array(
							'type'		=>	'color',
							'style'		=>	'horizontal',
							'title'		=>	__('Normal','cloudfw'),
							'id'		=>	cloudfw_sanitize('footer_widgetized_link','color'),
							'value'		=>	$data['footer_widgetized_link']['color'],
						),
						array(
							'type'		=>	'color',
							'style'		=>	'horizontal',
							'title'		=>	__('Hover Color','cloudfw'),
							'id'		=>	cloudfw_sanitize('footer_widgetized_link_hover','color'),
							'value'		=>	$data['footer_widgetized_link_hover']['color'],
						),
						array(
							'type'		=>	'select',
							'ui'		=>	true,
							'width'		=>	120,
							'title'		=>	__('Text-Decoration','cloudfw'),
							'id'		=>	cloudfw_sanitize('footer_widgetized_link','text-decoration'),
							'value'		=>	$data['footer_widgetized_link']['text-decoration'],
							'source'	=>	$array_text_decorations,

						),
						array(
							
							'type'		=>	'select',
							'ui'		=>	true,
							'width'		=>	120,
							'title'		=>	__('Text-Decoration Hover','cloudfw'),
							'id'		=>	cloudfw_sanitize('footer_widgetized_link_hover','text-decoration'),
							'value'		=>	$data['footer_widgetized_link_hover']['text-decoration'],
							'source'	=>	$array_text_decorations,
							
						)

					)
					
				),

			)

		), 

		array(
			'type'		=>	'module-set',
			'title'		=>	__('Footer Bottom Bar','cloudfw'),
			'closable'	=>	true,
			'state'		=>	'opened',
			'data'		=>	array(


				## Module Item
				array(
					'type'		=>	'module',
					'ucode'		=>	'FOOTER BOTTOM',
					'title'		=>	__('Background','cloudfw'),
					'data'		=>	array( array(
							'type'		=>	'grid',
							//'layout'	=>	'nospaced',
							'data'		=>	array(
								
								array(
									'type'		=>	'color',
									'title'		=>	__('Background-Color','cloudfw'),
									'id'		=>	cloudfw_sanitize('footer_bottom','background-color'),
									'value'		=>	$data['footer_bottom']['background-color'],
								),
								array(
									'type'		=>	'bg-set',
									'id'		=>	'footer_bottom',
									'id:pattern'=>	'footer_bottom',
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
					'ucode'		=>	'FOOTER BOTTOM SEPARATOR',
					'title'		=>	__('Border Top','cloudfw'),
					'data'		=>	array(
						array(
							'type'		=>	'color',
							'style'		=>	'horizontal',
							'id'		=>	cloudfw_sanitize('footer_bottom','border-top-color'),
							'value'		=>	$data['footer_bottom']['border-top-color'],
						),
					)		

				), 

				## Module Item
				array(
					'type'		=>	'module',
					'ucode'		=>	'FOOTER BOTTOM TEXT',
					'layout'	=>	'split',
					'title'		=>	array(__('Text Color','cloudfw'), __('Text Highlight','cloudfw')),
					'data'		=>	array(
						
						array(
							'type'		=>	'color',
							'style'		=>	'horizontal',
							'id'		=>	cloudfw_sanitize('footer_bottom','color'),
							'value'		=>	$data['footer_bottom']['color'],
						),
						
						array(
							'type'		=>	'color',
							'style'		=>	'horizontal',
							'id'		=>	cloudfw_sanitize('footer_bottom','text-shadow color'),
							'value'		=>	$data['footer_bottom']['text-shadow']['color'],
						),

					)
							

				), 

				## Module Item
				array(
					'type'		=>	'module',
					'ucode'		=>	'FOOTER BOTTOM LINK',
					'title'		=>	__('Link Colors','cloudfw'),
					'data'		=>	array( 
							
						array(
							'type'		=>	'color',
							'style'		=>	'horizontal',
							'title'		=>	__('Normal','cloudfw'),
							'id'		=>	cloudfw_sanitize('footer_bottom_link','color'),
							'value'		=>	$data['footer_bottom_link']['color'],
						),
						array(
							'type'		=>	'color',
							'style'		=>	'horizontal',
							'title'		=>	__('Hover Color','cloudfw'),
							'id'		=>	cloudfw_sanitize('footer_bottom_link_hover','color'),
							'value'		=>	$data['footer_bottom_link_hover']['color'],
						),
						array(
							'type'		=>	'select',
							'ui'		=>	true,
							'width'		=>	120,
							'title'		=>	__('Text-Decoration','cloudfw'),
							'id'		=>	cloudfw_sanitize('footer_bottom_link','text-decoration'),
							'value'		=>	$data['footer_bottom_link']['text-decoration'],
							'source'	=>	$array_text_decorations,

						),
						array(
							
							'type'		=>	'select',
							'ui'		=>	true,
							'width'		=>	120,
							'title'		=>	__('Text-Decoration Hover','cloudfw'),
							'id'		=>	cloudfw_sanitize('footer_bottom_link_hover','text-decoration'),
							'value'		=>	$data['footer_bottom_link_hover']['text-decoration'],
							'source'	=>	$array_text_decorations,
							
						)

					)
					
				),

			)

		), 
	
	) 

);