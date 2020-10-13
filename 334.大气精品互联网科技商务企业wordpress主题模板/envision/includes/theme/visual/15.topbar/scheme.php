<?php

$scheme[ cloudfw_id_for_sequence( $scheme, $number ) ] = array(
	'type'			=>	'section',
	'title'			=>	__('Top Bar','cloudfw'),
	'data'			=>	array(

		array(
			'type'		=>	'module-set',
			'title'		=>	__('Top Bar','cloudfw'),
			'closable'	=>	true,
			'state'		=>	'opened',
			'data'		=>	array(


				## Module Item
				array(
					'type'		=>	'module',
					'ucode'		=>	'TOPBAR',
					'title'		=>	__('Background','cloudfw'),
					'data'		=>	array( 

						array(
							'type'		=>	'grid',
							'data'		=>	array(
								
								array(
									'type'		=>	'gradient',
									'title'		=>	__('Background-Color','cloudfw'),
									'id'		=>	cloudfw_sanitize('topbar_background','gradient'),
									'value'		=>	$data['topbar_background']['gradient'],
								),
								array(
									'type'		=>	'bg-set',
									'id'		=>	'topbar_background',
									'id:pattern'=>	'topbar_background',
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
					'ucode'		=>	'TOPBAR BORDER',
					'title'		=>	__('Border Bottom','cloudfw'),
					'layout'	=>	'float',
					'data'		=>	array( 

						array(
							'type'		=>	'color',
							'style'		=>	'horizontal',
							'id'		=>	cloudfw_sanitize('topbar_border_bottom','border-color'),
							'value'		=>	$data['topbar_border_bottom']['border-color'],
						),
							
					)
					
				),
				
				## Module Item
				array(
					'type'		=>	'module',
					'ucode'		=>	'TOPBAR',
					'title'		=>	__('Texts','cloudfw'),
					'layout'	=>	'float',
					'data'		=>	array(
						## Element
						array(
							'type'		=>	'color',
							'style'		=>	'horizontal',
							'title'		=>	__('Color','cloudfw'),
							'id'		=>	cloudfw_sanitize('topbar_text','color'),
							'value'		=>	$data['topbar_text']['color'],

						),

						## Element
						array(
							'type'		=>	'color',
							'style'		=>	'horizontal',
							'title'		=>	__('Text Shadow','cloudfw'),
							'id'		=>	cloudfw_sanitize('topbar_text','text-shadow color'),
							'value'		=>	$data['topbar_text']['text-shadow']['color'],

						),

						## Element
						array(
							'type'		=>	'select',
							'style'		=>	'horizontal',
							'title'		=>	__('Shadow Direction','cloudfw'),
							'id'		=>	cloudfw_sanitize('topbar_text','text-shadow direction'),
							'value'		=>	$data['topbar_text']['text-shadow']['direction'],
							'source'	=>	array(
								'-1'		=>	__('Top','cloudfw'),
								'1'			=>	__('Bottom','cloudfw'),
							),
							'width'		=>	120

						),

					)

				),
				## Module Item
				array(
					'type'		=>	'module',
					'ucode'		=>	'TOPBAR LINK',
					'title'		=>	__('Links','cloudfw'),
					'layout'	=>	'float',
					'data'		=>	array(
						## Element
						array(
							'type'		=>	'color',
							'style'		=>	'horizontal',
							'title'		=>	__('Color','cloudfw'),
							'id'		=>	cloudfw_sanitize('topbar_text_link','color'),
							'value'		=>	$data['topbar_text_link']['color'],

						),

						## Element
						array(
							'type'		=>	'color',
							'style'		=>	'horizontal',
							'title'		=>	__('Hover Color','cloudfw'),
							'id'		=>	cloudfw_sanitize('topbar_text_link_hover','color'),
							'value'		=>	$data['topbar_text_link_hover']['color'],

						),

						## Element
						array(
							'type'		=>	'color',
							'style'		=>	'horizontal',
							'title'		=>	__('Text Shadow','cloudfw'),
							'id'		=>	cloudfw_sanitize('topbar_text_link','text-shadow color'),
							'value'		=>	$data['topbar_text_link']['text-shadow']['color'],

						),

						## Element
						array(
							'type'		=>	'select',
							'style'		=>	'horizontal',
							'title'		=>	__('Shadow Direction','cloudfw'),
							'id'		=>	cloudfw_sanitize('topbar_text_link','text-shadow direction'),
							'value'		=>	$data['topbar_text_link']['text-shadow']['direction'],
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

		array(
			'type'		=>	'module-set',
			'title'		=>	__('Top Bar Widgets','cloudfw'),
			'closable'	=>	true,
			'state'		=>	'opened',
			'data'		=>	array(


				## Module Item
				array(
					'type'		=>	'module',
					'ucode'		=>	'TOPBAR WIDGETS',
					'title'		=>	__('Background','cloudfw'),
					'data'		=>	array( 

						array(
							'type'		=>	'grid',
							'data'		=>	array(
								
								array(
									'type'		=>	'gradient',
									'title'		=>	__('Background-Color','cloudfw'),
									'id'		=>	cloudfw_sanitize('topbar_widgets_background','gradient'),
									'value'		=>	$data['topbar_widgets_background']['gradient'],
								),
								array(
									'type'		=>	'bg-set',
									'id'		=>	'topbar_widgets_background',
									'id:pattern'=>	'topbar_widgets_background',
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
					'ucode'		=>	'TOPBAR WIDGETS SEPARATOR',
					'title'		=>	__('Separator Line Color','cloudfw'),
					'data'		=>	array(
						
						array(
							'type'		=>	'color',
							'style'		=>	'horizontal',
							'id'		=>	cloudfw_sanitize('topbar_widgets_separator','border-color'),
							'value'		=>	$data['topbar_widgets_separator']['border-color'],
						),

					
					)
							

				), 

				## Module Item
				array(
					'type'		=>	'module',
					'ucode'		=>	'TOPBAR LINK',
					'title'		=>	__('Links','cloudfw'),
					'layout'	=>	'float',
					'data'		=>	array(
						## Element
						array(
							'type'		=>	'color',
							'style'		=>	'horizontal',
							'title'		=>	__('Color','cloudfw'),
							'id'		=>	cloudfw_sanitize('topbar_widgets_link','color'),
							'value'		=>	$data['topbar_widgets_link']['color'],

						),

						## Element
						array(
							'type'		=>	'color',
							'style'		=>	'horizontal',
							'title'		=>	__('Hover Color','cloudfw'),
							'id'		=>	cloudfw_sanitize('topbar_widgets_link_hover','color'),
							'value'		=>	$data['topbar_widgets_link_hover']['color'],

						),

						## Element
						array(
							'type'		=>	'color',
							'style'		=>	'horizontal',
							'title'		=>	__('Text Shadow','cloudfw'),
							'id'		=>	cloudfw_sanitize('topbar_widgets_link','text-shadow color'),
							'value'		=>	$data['topbar_widgets_link']['text-shadow']['color'],

						),

						## Element
						array(
							'type'		=>	'select',
							'style'		=>	'horizontal',
							'title'		=>	__('Shadow Direction','cloudfw'),
							'id'		=>	cloudfw_sanitize('topbar_widgets_link','text-shadow direction'),
							'value'		=>	$data['topbar_widgets_link']['text-shadow']['direction'],
							'source'	=>	array(
								'-1'		=>	__('Top','cloudfw'),
								'1'			=>	__('Bottom','cloudfw'),
							),
							'width'		=>	120

						),

					)

				),

				## Module Item
				array(
					'type'		=>	'mini-section',
					'title'		=>	__('Drop-Down Menu','cloudfw'),				
					'data'		=>	array(		

						## Module Item
						array(
							'type'		=>	'module',
							'ucode'		=>	'TOPBAR DROPDOWN',
							'title'		=>	__('Link Colors','cloudfw'),
							'layout'	=>	'float',
							'data'		=>	array( 
									
								array(
									'type'		=>	'gradient',
									'title'		=>	__('Background Gradient','cloudfw'),
									'id'		=>	cloudfw_sanitize('topbar_widgets_fallout_link','gradient'),
									'value'		=>	$data['topbar_widgets_fallout_link']['gradient'],
								),

								array(
									'type'		=>	'color',
									'style'		=>	'horizontal',
									'title'		=>	__('Text Color','cloudfw'),
									'id'		=>	cloudfw_sanitize('topbar_widgets_fallout_link','color'),
									'value'		=>	$data['topbar_widgets_fallout_link']['color'],
								),

								## Element
								array(
									'type'		=>	'color',
									'style'		=>	'horizontal',
									'title'		=>	__('Text Shadow','cloudfw'),
									'id'		=>	cloudfw_sanitize('topbar_widgets_fallout_link','text-shadow color'),
									'value'		=>	$data['topbar_widgets_fallout_link']['text-shadow']['color'],

								),

								## Element
								array(
									'type'		=>	'select',
									'style'		=>	'horizontal',
									'title'		=>	__('Shadow Direction','cloudfw'),
									'id'		=>	cloudfw_sanitize('topbar_widgets_fallout_link','text-shadow direction'),
									'value'		=>	$data['topbar_widgets_fallout_link']['text-shadow']['direction'],
									'source'	=>	array(
										'-1'		=>	__('Top','cloudfw'),
										'1'			=>	__('Bottom','cloudfw'),
									),
									'width'		=>	120

								),


							)
							
						),

						## Module Item
						array(
							'type'		=>	'module',
							'ucode'		=>	'TOPBAR DROPDOWN',
							'title'		=>	__('Link Colors Hover','cloudfw'),
							'layout'	=>	'float',
							'data'		=>	array( 
									
								array(
									'type'		=>	'gradient',
									'title'		=>	__('Background Gradient','cloudfw'),
									'id'		=>	cloudfw_sanitize('topbar_widgets_fallout_link_hover','gradient'),
									'value'		=>	$data['topbar_widgets_fallout_link_hover']['gradient'],
								),

								array(
									'type'		=>	'color',
									'style'		=>	'horizontal',
									'title'		=>	__('Text Color','cloudfw'),
									'id'		=>	cloudfw_sanitize('topbar_widgets_fallout_link_hover','color'),
									'value'		=>	$data['topbar_widgets_fallout_link_hover']['color'],
								),

								## Element
								array(
									'type'		=>	'color',
									'style'		=>	'horizontal',
									'title'		=>	__('Text Shadow','cloudfw'),
									'id'		=>	cloudfw_sanitize('topbar_widgets_fallout_link_hover','text-shadow color'),
									'value'		=>	$data['topbar_widgets_fallout_link_hover']['text-shadow']['color'],

								),

								## Element
								array(
									'type'		=>	'select',
									'style'		=>	'horizontal',
									'title'		=>	__('Shadow Direction','cloudfw'),
									'id'		=>	cloudfw_sanitize('topbar_widgets_fallout_link_hover','text-shadow direction'),
									'value'		=>	$data['topbar_widgets_fallout_link_hover']['text-shadow']['direction'],
									'source'	=>	array(
										'-1'		=>	__('Top','cloudfw'),
										'1'			=>	__('Bottom','cloudfw'),
									),
									'width'		=>	120

								),


							)
							
						),

						## Module Item
						array(
							'type'		=>	'module',
							'ucode'		=>	'NAVIGATION SUB LINK',
							'title'		=>	__('Separator Color','cloudfw'),
							'layout'	=>	'float',
							'data'		=>	array( 

								array(
									'type'		=>	'color',
									'style'		=>	'horizontal',
									'id'		=>	cloudfw_sanitize('topbar_widgets_fallout_link','border-color'),
									'value'		=>	$data['topbar_widgets_fallout_link']['border-color'],
								),
									
							)
							
						),

					)

				),


			)

		), 




	) 

);