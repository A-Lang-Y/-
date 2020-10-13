<?php

$scheme[ cloudfw_id_for_sequence( $scheme, $number ) ] = array(
	'type'			=>	'section',
	'title'			=>	__('Side Panel','cloudfw'),
	'data'			=>	array(

		array(
			'type'		=>	'module-set',
			'title'		=>	__('Side Panel','cloudfw'),
			'closable'	=>	true,
			'state'		=>	'opened',
			'data'		=>	array(


				## Module Item
				array(
					'type'		=>	'module',
					'ucode'		=>	'SIDEPANEL WIDGET',
					'title'		=>	__('Background','cloudfw'),
					'data'		=>	array( array(
							'type'		=>	'grid',
							'data'		=>	array(
								
								array(
									'type'		=>	'color',
									'title'		=>	__('Background-Color','cloudfw'),
									'id'		=>	cloudfw_sanitize('side_panel','background-color'),
									'value'		=>	$data['side_panel']['background-color'],
								),
								array(
									'type'		=>	'bg-set',
									'id'		=>	'side_panel',
									'id:pattern'=>	'side_panel',
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
					'ucode'		=>	'SIDEPANEL WIDGET',
					'layout'	=>	'split',
					'title'		=>	array(__('Title Color','cloudfw'), __('Text Color','cloudfw')),
					'data'		=>	array(
						
						array(
							'type'		=>	'color',
							'style'		=>	'horizontal',
							'id'		=>	cloudfw_sanitize('side_panel_title','color'),
							'value'		=>	$data['side_panel_title']['color'],
						),

						array(
							'type'		=>	'color',
							'style'		=>	'horizontal',
							'id'		=>	cloudfw_sanitize('side_panel_color','color'),
							'value'		=>	$data['side_panel_color']['color'],
						),
					
					)
							

				), 

				## Module Item
				array(
					'type'		=>	'module',
					'ucode'		=>	'SIDEPANEL WIDGET LINK',
					'title'		=>	__('Link Colors','cloudfw'),
					'data'		=>	array( 
							
						array(
							'type'		=>	'color',
							'style'		=>	'horizontal',
							'title'		=>	__('Normal','cloudfw'),
							'id'		=>	cloudfw_sanitize('side_panel_link','color'),
							'value'		=>	$data['side_panel_link']['color'],
						),
						array(
							'type'		=>	'color',
							'style'		=>	'horizontal',
							'title'		=>	__('Hover Color','cloudfw'),
							'id'		=>	cloudfw_sanitize('side_panel_link_hover','color'),
							'value'		=>	$data['side_panel_link_hover']['color'],
						),
						array(
							'type'		=>	'select',
							'ui'		=>	true,
							'width'		=>	120,
							'title'		=>	__('Text-Decoration','cloudfw'),
							'id'		=>	cloudfw_sanitize('side_panel_link','text-decoration'),
							'value'		=>	$data['side_panel_link']['text-decoration'],
							'source'	=>	$array_text_decorations,

						),
						array(
							
							'type'		=>	'select',
							'ui'		=>	true,
							'width'		=>	120,
							'title'		=>	__('Text-Decoration Hover','cloudfw'),
							'id'		=>	cloudfw_sanitize('side_panel_link_hover','text-decoration'),
							'value'		=>	$data['side_panel_link_hover']['text-decoration'],
							'source'	=>	$array_text_decorations,
							
						)

					)
					
				),

			)

		), 
	
	) 

);