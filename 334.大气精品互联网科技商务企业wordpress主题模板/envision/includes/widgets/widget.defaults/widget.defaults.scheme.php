<?php

/** Skin scheme */
add_filter( 'cloudfw_schemes_skin', 'cloudfw_default_widgets_skin_scheme', 10, 2 );
function cloudfw_default_widgets_skin_scheme( $schemes, $data ){
	$schemes = cloudfw_add_skin_scheme( 'widget',
		$schemes,
		array(
			'type'		=>	'module-set',
			'title'		=>	__('Calendar Widget','cloudfw'),
			'closable'	=>	true,
			'state'		=>	'closed',
			'layout'	=>	'subtab',
			'data'		=>	array(

				## SubTab Item
				array(
					'type'		=>	'tabs',
					'tab_id' 	=>	'tab:calendar-widget',
					'tab_title' =>	__('In Content Area','cloudfw'),
					'icon'		=>	'layout-content',
					'data'		=>	array(

						## Module Item
						array(
							'type'		=>	'module',
							'ucode'		=>	'WIDGET CALENDAR',
							'title'		=>	__('Days','cloudfw'),
							'layout'	=>	'float',
							'data'		=>	array(
								## Element
								array(
									'type'		=>	'gradient',
									'title'		=>	__('Background','cloudfw'),
									'id'		=>	cloudfw_sanitize('wp_calendar','gradient'),
									'value'		=>	$data['wp_calendar']['gradient'],
								), // #### element: 0

								## Element
								array(
									'type'		=>	'color',
									'title'		=>	__('Text','cloudfw'),
									'style'		=>	'horizontal',
									'id'		=>	cloudfw_sanitize('wp_calendar','color'),
									'value'		=>	$data['wp_calendar']['color'],

								),

								## Element
								array(
									'type'		=>	'color',
									'style'		=>	'horizontal',
									'title'		=>	__('Text Shadow','cloudfw'),
									'id'		=>	cloudfw_sanitize('wp_calendar','text-shadow color'),
									'value'		=>	$data['wp_calendar']['text-shadow']['color'],

								),

								## Element
								array(
									'type'		=>	'select',
									'style'		=>	'horizontal',
									'title'		=>	__('Shadow Direction','cloudfw'),
									'id'		=>	cloudfw_sanitize('wp_calendar','text-shadow direction'),
									'value'		=>	$data['wp_calendar']['text-shadow']['direction'],
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
							'ucode'		=>	'WIDGET CALENDAR',
							'title'		=>	__('Days Hover','cloudfw'),
							'layout'	=>	'float',
							'data'		=>	array(
								## Element
								array(
									'type'		=>	'gradient',
									'title'		=>	__('Background','cloudfw'),
									'id'		=>	cloudfw_sanitize('wp_calendar_hover','gradient'),
									'value'		=>	$data['wp_calendar_hover']['gradient'],
								), // #### element: 0

								## Element
								array(
									'type'		=>	'color',
									'title'		=>	__('Text','cloudfw'),
									'style'		=>	'horizontal',
									'id'		=>	cloudfw_sanitize('wp_calendar_hover','color'),
									'value'		=>	$data['wp_calendar_hover']['color'],

								),

								## Element
								array(
									'type'		=>	'color',
									'style'		=>	'horizontal',
									'title'		=>	__('Text Shadow','cloudfw'),
									'id'		=>	cloudfw_sanitize('wp_calendar_hover','text-shadow color'),
									'value'		=>	$data['wp_calendar_hover']['text-shadow']['color'],

								),

								## Element
								array(
									'type'		=>	'select',
									'style'		=>	'horizontal',
									'title'		=>	__('Shadow Direction','cloudfw'),
									'id'		=>	cloudfw_sanitize('wp_calendar_hover','text-shadow direction'),
									'value'		=>	$data['wp_calendar_hover']['text-shadow']['direction'],
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
							'ucode'		=>	'WIDGET CALENDAR LINK',
							'title'		=>	__('Day Links','cloudfw'),
							'layout'	=>	'float',
							'data'		=>	array(

								## Element
								array(
									'type'		=>	'color',
									'title'		=>	__('Text','cloudfw'),
									'style'		=>	'horizontal',
									'id'		=>	cloudfw_sanitize('wp_calendar_link','color'),
									'value'		=>	$data['wp_calendar_link']['color'],

								),

								## Element
								array(
									'type'		=>	'color',
									'style'		=>	'horizontal',
									'title'		=>	__('Text Shadow','cloudfw'),
									'id'		=>	cloudfw_sanitize('wp_calendar_link','text-shadow color'),
									'value'		=>	$data['wp_calendar_link']['text-shadow']['color'],

								),

								## Element
								array(
									'type'		=>	'select',
									'style'		=>	'horizontal',
									'title'		=>	__('Shadow Direction','cloudfw'),
									'id'		=>	cloudfw_sanitize('wp_calendar_link','text-shadow direction'),
									'value'		=>	$data['wp_calendar_link']['text-shadow']['direction'],
									'source'	=>	array(
										'-1'		=>	__('Top','cloudfw'),
										'1'			=>	__('Bottom','cloudfw'),
									),
									'width'		=>	120

								),

								## Element
								array(
									'type'		=>	'select',
									'title'		=>	__('Text Decoration','cloudfw'),
									'id'		=>	cloudfw_sanitize('wp_calendar_link','text-decoration'),
									'value'		=>	$data['wp_calendar_link']['text-decoration'],
									'source'	=>	array(
										'type'		=> 'function',
										'function'		=> 'cloudfw_admin_array_text_decorations',
									),
									'width'		=>	120

								), // #### element: 0

							)

						),

						## Module Item
						array(
							'type'		=>	'module',
							'ucode'		=>	'WIDGET CALENDAR LINK',
							'title'		=>	__('Day Links Hover','cloudfw'),
							'layout'	=>	'float',
							'data'		=>	array(

								## Element
								array(
									'type'		=>	'color',
									'title'		=>	__('Text','cloudfw'),
									'style'		=>	'horizontal',
									'id'		=>	cloudfw_sanitize('wp_calendar_link_hover','color'),
									'value'		=>	$data['wp_calendar_link_hover']['color'],

								),

								## Element
								array(
									'type'		=>	'color',
									'style'		=>	'horizontal',
									'title'		=>	__('Text Shadow','cloudfw'),
									'id'		=>	cloudfw_sanitize('wp_calendar_link_hover','text-shadow color'),
									'value'		=>	$data['wp_calendar_link_hover']['text-shadow']['color'],

								),

								## Element
								array(
									'type'		=>	'select',
									'style'		=>	'horizontal',
									'title'		=>	__('Shadow Direction','cloudfw'),
									'id'		=>	cloudfw_sanitize('wp_calendar_link_hover','text-shadow direction'),
									'value'		=>	$data['wp_calendar_link_hover']['text-shadow']['direction'],
									'source'	=>	array(
										'-1'		=>	__('Top','cloudfw'),
										'1'			=>	__('Bottom','cloudfw'),
									),
									'width'		=>	120

								),


								## Element
								array(
									'type'		=>	'select',
									'title'		=>	__('Text Decoration','cloudfw'),
									'id'		=>	cloudfw_sanitize('wp_calendar_link_hover','text-decoration'),
									'value'		=>	$data['wp_calendar_link_hover']['text-decoration'],
									'source'	=>	array(
										'type'		=> 'function',
										'function'	=> 'cloudfw_admin_array_text_decorations',
									),
									'width'		=>	120

								), // #### element: 0

							)

						),
													
					)
						
				),

				array(
					'type'		=>	'tabs',
					'tab_id' 	=>	'tab:calendar-widget-footer',
					'tab_title'	=>	__('In Footer','cloudfw'),
					'icon'		=>	'layout-footer',
					'data'		=>	array(

						## Module Item
						array(
							'type'		=>	'module',
							'ucode'		=>	'WIDGET CALENDAR',
							'title'		=>	__('Days','cloudfw'),
							'layout'	=>	'float',
							'data'		=>	array(
								## Element
								array(
									'type'		=>	'gradient',
									'title'		=>	__('Background','cloudfw'),
									'id'		=>	cloudfw_sanitize('footer_wp_calendar','gradient'),
									'value'		=>	$data['footer_wp_calendar']['gradient'],
								), // #### element: 0

								## Element
								array(
									'type'		=>	'color',
									'title'		=>	__('Text','cloudfw'),
									'style'		=>	'horizontal',
									'id'		=>	cloudfw_sanitize('footer_wp_calendar','color'),
									'value'		=>	$data['footer_wp_calendar']['color'],

								),

								## Element
								array(
									'type'		=>	'color',
									'style'		=>	'horizontal',
									'title'		=>	__('Text Shadow','cloudfw'),
									'id'		=>	cloudfw_sanitize('footer_wp_calendar','text-shadow color'),
									'value'		=>	$data['footer_wp_calendar']['text-shadow']['color'],

								),

								## Element
								array(
									'type'		=>	'select',
									'style'		=>	'horizontal',
									'title'		=>	__('Shadow Direction','cloudfw'),
									'id'		=>	cloudfw_sanitize('footer_wp_calendar','text-shadow direction'),
									'value'		=>	$data['footer_wp_calendar']['text-shadow']['direction'],
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
							'ucode'		=>	'WIDGET CALENDAR',
							'title'		=>	__('Days Hover','cloudfw'),
							'layout'	=>	'float',
							'data'		=>	array(
								## Element
								array(
									'type'		=>	'gradient',
									'title'		=>	__('Background','cloudfw'),
									'id'		=>	cloudfw_sanitize('footer_wp_calendar_hover','gradient'),
									'value'		=>	$data['footer_wp_calendar_hover']['gradient'],
								), // #### element: 0

								## Element
								array(
									'type'		=>	'color',
									'title'		=>	__('Text','cloudfw'),
									'style'		=>	'horizontal',
									'id'		=>	cloudfw_sanitize('footer_wp_calendar_hover','color'),
									'value'		=>	$data['footer_wp_calendar_hover']['color'],

								),

								## Element
								array(
									'type'		=>	'color',
									'style'		=>	'horizontal',
									'title'		=>	__('Text Shadow','cloudfw'),
									'id'		=>	cloudfw_sanitize('footer_wp_calendar_hover','text-shadow color'),
									'value'		=>	$data['footer_wp_calendar_hover']['text-shadow']['color'],

								),

								## Element
								array(
									'type'		=>	'select',
									'style'		=>	'horizontal',
									'title'		=>	__('Shadow Direction','cloudfw'),
									'id'		=>	cloudfw_sanitize('footer_wp_calendar_hover','text-shadow direction'),
									'value'		=>	$data['footer_wp_calendar_hover']['text-shadow']['direction'],
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
							'ucode'		=>	'WIDGET CALENDAR LINK',
							'title'		=>	__('Day Links','cloudfw'),
							'layout'	=>	'float',
							'data'		=>	array(

								## Element
								array(
									'type'		=>	'color',
									'title'		=>	__('Text','cloudfw'),
									'style'		=>	'horizontal',
									'id'		=>	cloudfw_sanitize('footer_wp_calendar_link','color'),
									'value'		=>	$data['footer_wp_calendar_link']['color'],

								),

								## Element
								array(
									'type'		=>	'color',
									'style'		=>	'horizontal',
									'title'		=>	__('Text Shadow','cloudfw'),
									'id'		=>	cloudfw_sanitize('footer_wp_calendar_link','text-shadow color'),
									'value'		=>	$data['footer_wp_calendar_link']['text-shadow']['color'],

								),

								## Element
								array(
									'type'		=>	'select',
									'style'		=>	'horizontal',
									'title'		=>	__('Shadow Direction','cloudfw'),
									'id'		=>	cloudfw_sanitize('footer_wp_calendar_link','text-shadow direction'),
									'value'		=>	$data['footer_wp_calendar_link']['text-shadow']['direction'],
									'source'	=>	array(
										'-1'		=>	__('Top','cloudfw'),
										'1'			=>	__('Bottom','cloudfw'),
									),
									'width'		=>	120

								),

								## Element
								array(
									'type'		=>	'select',
									'title'		=>	__('Text Decoration','cloudfw'),
									'id'		=>	cloudfw_sanitize('footer_wp_calendar_link','text-decoration'),
									'value'		=>	$data['footer_wp_calendar_link']['text-decoration'],
									'source'	=>	array(
										'type'		=> 'function',
										'function'		=> 'cloudfw_admin_array_text_decorations',
									),
									'width'		=>	120

								), // #### element: 0

							)

						),

						## Module Item
						array(
							'type'		=>	'module',
							'ucode'		=>	'WIDGET CALENDAR LINK',
							'title'		=>	__('Day Links Hover','cloudfw'),
							'layout'	=>	'float',
							'data'		=>	array(

								## Element
								array(
									'type'		=>	'color',
									'title'		=>	__('Text','cloudfw'),
									'style'		=>	'horizontal',
									'id'		=>	cloudfw_sanitize('footer_wp_calendar_link_hover','color'),
									'value'		=>	$data['footer_wp_calendar_link_hover']['color'],

								),

								## Element
								array(
									'type'		=>	'color',
									'style'		=>	'horizontal',
									'title'		=>	__('Text Shadow','cloudfw'),
									'id'		=>	cloudfw_sanitize('footer_wp_calendar_link_hover','text-shadow color'),
									'value'		=>	$data['footer_wp_calendar_link_hover']['text-shadow']['color'],

								),

								## Element
								array(
									'type'		=>	'select',
									'style'		=>	'horizontal',
									'title'		=>	__('Shadow Direction','cloudfw'),
									'id'		=>	cloudfw_sanitize('footer_wp_calendar_link_hover','text-shadow direction'),
									'value'		=>	$data['footer_wp_calendar_link_hover']['text-shadow']['direction'],
									'source'	=>	array(
										'-1'		=>	__('Top','cloudfw'),
										'1'			=>	__('Bottom','cloudfw'),
									),
									'width'		=>	120

								),


								## Element
								array(
									'type'		=>	'select',
									'title'		=>	__('Text Decoration','cloudfw'),
									'id'		=>	cloudfw_sanitize('footer_wp_calendar_link_hover','text-decoration'),
									'value'		=>	$data['footer_wp_calendar_link_hover']['text-decoration'],
									'source'	=>	array(
										'type'		=> 'function',
										'function'	=> 'cloudfw_admin_array_text_decorations',
									),
									'width'		=>	120

								), // #### element: 0

							)

						),
													
					)
						
				),

			)

		),

		100 // seq
		
	);


	$schemes = cloudfw_add_skin_scheme( 'widget',
		$schemes,
		array(
			'type'		=>	'module-set',
			'title'		=>	__('Tags Cloud Widget','cloudfw'),
			'closable'	=>	true,
			'state'		=>	'closed',
			'layout'	=>	'subtab',
			'data'		=>	array(

				## SubTab Item
				array(
					'type'		=>	'tabs',
					'tab_id' 	=>	'tab:tags-widget',
					'tab_title' =>	__('In Content Area','cloudfw'),
					'icon'		=>	'layout-content',
					'data'		=>	array(

						## Module Item
						array(
							'type'		=>	'module',
							'ucode'		=>	'WIDGET TAGS',
							'title'		=>	__('Normal','cloudfw'),
							'layout'	=>	'float',
							'data'		=>	array(
								## Element
								array(
									'type'		=>	'gradient',
									'title'		=>	__('Background','cloudfw'),
									'id'		=>	cloudfw_sanitize('wp_tags','gradient'),
									'value'		=>	$data['wp_tags']['gradient'],
								),

								## Element
								array(
									'type'		=>	'color',
									'title'		=>	__('Text','cloudfw'),
									'style'		=>	'horizontal',
									'id'		=>	cloudfw_sanitize('wp_tags','color'),
									'value'		=>	$data['wp_tags']['color'],

								),

								## Element
								array(
									'type'		=>	'color',
									'style'		=>	'horizontal',
									'title'		=>	__('Text Shadow','cloudfw'),
									'id'		=>	cloudfw_sanitize('wp_tags','text-shadow color'),
									'value'		=>	$data['wp_tags']['text-shadow']['color'],

								),

								## Element
								array(
									'type'		=>	'select',
									'style'		=>	'horizontal',
									'title'		=>	__('Shadow Direction','cloudfw'),
									'id'		=>	cloudfw_sanitize('wp_tags','text-shadow direction'),
									'value'		=>	$data['wp_tags']['text-shadow']['direction'],
									'source'	=>	array(
										'-1'		=>	__('Top','cloudfw'),
										'1'			=>	__('Bottom','cloudfw'),
									),
									'width'		=>	120

								),


								## Element
								array(
									'type'		=>	'color',
									'title'		=>	__('Border','cloudfw'),
									'style'		=>	'horizontal',
									'id'		=>	cloudfw_sanitize('wp_tags','+border'),
									'value'		=>	$data['wp_tags']['+border'],

								),

							)

						),

						## Module Item
						array(
							'type'		=>	'module',
							'ucode'		=>	'WIDGET TAGS',
							'title'		=>	__('Hover','cloudfw'),
							'layout'	=>	'float',
							'data'		=>	array(
								## Element
								array(
									'type'		=>	'gradient',
									'title'		=>	__('Background','cloudfw'),
									'id'		=>	cloudfw_sanitize('wp_tags_hover','gradient'),
									'value'		=>	$data['wp_tags_hover']['gradient'],
								), // #### element: 0

								## Element
								array(
									'type'		=>	'color',
									'title'		=>	__('Text','cloudfw'),
									'style'		=>	'horizontal',
									'id'		=>	cloudfw_sanitize('wp_tags_hover','color'),
									'value'		=>	$data['wp_tags_hover']['color'],

								),

								## Element
								array(
									'type'		=>	'color',
									'style'		=>	'horizontal',
									'title'		=>	__('Text Shadow','cloudfw'),
									'id'		=>	cloudfw_sanitize('wp_tags_hover','text-shadow color'),
									'value'		=>	$data['wp_tags_hover']['text-shadow']['color'],

								),

								## Element
								array(
									'type'		=>	'select',
									'style'		=>	'horizontal',
									'title'		=>	__('Shadow Direction','cloudfw'),
									'id'		=>	cloudfw_sanitize('wp_tags_hover','text-shadow direction'),
									'value'		=>	$data['wp_tags_hover']['text-shadow']['direction'],
									'source'	=>	array(
										'-1'		=>	__('Top','cloudfw'),
										'1'			=>	__('Bottom','cloudfw'),
									),
									'width'		=>	120

								),

								## Element
								array(
									'type'		=>	'color',
									'title'		=>	__('Border','cloudfw'),
									'style'		=>	'horizontal',
									'id'		=>	cloudfw_sanitize('wp_tags_hover','+border'),
									'value'		=>	$data['wp_tags_hover']['+border'],

								),


							)

						),
					
					)
						
				),

				## SubTab Item
				array(
					'type'		=>	'tabs',
					'tab_id' 	=>	'tab:tags-widget-footer',
					'tab_title' =>	__('In Footer','cloudfw'),
					'icon'		=>	'layout-content',
					'data'		=>	array(

						## Module Item
						array(
							'type'		=>	'module',
							'ucode'		=>	'WIDGET TAGS',
							'title'		=>	__('Normal','cloudfw'),
							'layout'	=>	'float',
							'data'		=>	array(
								## Element
								array(
									'type'		=>	'gradient',
									'title'		=>	__('Background','cloudfw'),
									'id'		=>	cloudfw_sanitize('footer_wp_tags','gradient'),
									'value'		=>	$data['footer_wp_tags']['gradient'],
								),

								## Element
								array(
									'type'		=>	'color',
									'title'		=>	__('Text','cloudfw'),
									'style'		=>	'horizontal',
									'id'		=>	cloudfw_sanitize('footer_wp_tags','color'),
									'value'		=>	$data['footer_wp_tags']['color'],

								),

								## Element
								array(
									'type'		=>	'color',
									'style'		=>	'horizontal',
									'title'		=>	__('Text Shadow','cloudfw'),
									'id'		=>	cloudfw_sanitize('footer_wp_tags','text-shadow color'),
									'value'		=>	$data['footer_wp_tags']['text-shadow']['color'],

								),

								## Element
								array(
									'type'		=>	'select',
									'style'		=>	'horizontal',
									'title'		=>	__('Shadow Direction','cloudfw'),
									'id'		=>	cloudfw_sanitize('footer_wp_tags','text-shadow direction'),
									'value'		=>	$data['footer_wp_tags']['text-shadow']['direction'],
									'source'	=>	array(
										'-1'		=>	__('Top','cloudfw'),
										'1'			=>	__('Bottom','cloudfw'),
									),
									'width'		=>	120

								),

								## Element
								array(
									'type'		=>	'color',
									'title'		=>	__('Border','cloudfw'),
									'style'		=>	'horizontal',
									'id'		=>	cloudfw_sanitize('footer_wp_tags','+border'),
									'value'		=>	$data['footer_wp_tags']['+border'],

								),


							)

						),

						## Module Item
						array(
							'type'		=>	'module',
							'ucode'		=>	'WIDGET TAGS',
							'title'		=>	__('Hover','cloudfw'),
							'layout'	=>	'float',
							'data'		=>	array(
								## Element
								array(
									'type'		=>	'gradient',
									'title'		=>	__('Background','cloudfw'),
									'id'		=>	cloudfw_sanitize('footer_wp_tags_hover','gradient'),
									'value'		=>	$data['footer_wp_tags_hover']['gradient'],
								), // #### element: 0

								## Element
								array(
									'type'		=>	'color',
									'title'		=>	__('Text','cloudfw'),
									'style'		=>	'horizontal',
									'id'		=>	cloudfw_sanitize('footer_wp_tags_hover','color'),
									'value'		=>	$data['footer_wp_tags_hover']['color'],

								),

								## Element
								array(
									'type'		=>	'color',
									'style'		=>	'horizontal',
									'title'		=>	__('Text Shadow','cloudfw'),
									'id'		=>	cloudfw_sanitize('footer_wp_tags_hover','text-shadow color'),
									'value'		=>	$data['footer_wp_tags_hover']['text-shadow']['color'],

								),

								## Element
								array(
									'type'		=>	'select',
									'style'		=>	'horizontal',
									'title'		=>	__('Shadow Direction','cloudfw'),
									'id'		=>	cloudfw_sanitize('footer_wp_tags_hover','text-shadow direction'),
									'value'		=>	$data['footer_wp_tags_hover']['text-shadow']['direction'],
									'source'	=>	array(
										'-1'		=>	__('Top','cloudfw'),
										'1'			=>	__('Bottom','cloudfw'),
									),
									'width'		=>	120

								),

								## Element
								array(
									'type'		=>	'color',
									'title'		=>	__('Border','cloudfw'),
									'style'		=>	'horizontal',
									'id'		=>	cloudfw_sanitize('footer_wp_tags','+border'),
									'value'		=>	$data['footer_wp_tags']['+border'],

								),


							)

						),
					
					)
						
				),

			)

		),

		100 // seq
		
	);

	return $schemes;

}