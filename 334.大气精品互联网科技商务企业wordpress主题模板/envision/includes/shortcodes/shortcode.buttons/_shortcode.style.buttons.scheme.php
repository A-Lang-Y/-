<?php

return array(

		array(
			'type'		=> 'module',
			'title'		=> __('Button Text','cloudfw'),
			'data'		=> array(

				## Element
				array(
					'type'		=>	'text',
					'id'		=>	'button_title',
					'value'		=>	$that->get_value('button_title'),
					'_class'	=>  'bold',
				), // #### element: 0

			)

		),

		array(
			'type'		=> 'module',
			'title'		=> __('Link','cloudfw'),
			'data'		=> array(

				## Element
				array(
					'type'		=>	'page-selector',
					'id'		=>	'button_link',
					'response'	=>	'URL',
					'value'		=>	$that->get_value('button_link')
				)

			)

		),

		array(
			'type'		=> 'module',
			'title'		=> __('Link Target','cloudfw'),
			'data'		=> array(

				## Element
				array(
					'type'		=>	'select',
					'ui'		=>	true,
					'id'		=>	'button_target',
					'value'		=>	$that->get_value('button_target'),
					'source'	=>	array(
						'type'		=>	'function',
						'function'	=>	'cloudfw_admin_loop_link_targets'
					),
					'width'		=>  250,

				), // #### element: 0

			)

		),

		array(
			'type'		=> 'mini-section',
			'title'		=> __('Style','cloudfw'),
			'data'		=> array(

				array(
					'type'		=> 'module',
					'title'		=> __('Size','cloudfw'),
					'data'		=> array(

						## Element
						array(
							'type'		=>	'select',
							'ui'		=>	true,
							'main_class'=>  'input input_250',
							'id'		=>	'button_size',
							'value'		=>	$that->get_value('button_size'),
							'source'	=>	array(
								'mini' 		=> __('Mini','cloudfw'),
								'small' 	=> __('Small','cloudfw'),
								'NULL' 		=> __('Normal','cloudfw'),
								'medium'	=> __('Medium','cloudfw'),
								'large' 	=> __('Large','cloudfw'),
							),
						), // #### element: 0

					)

				),

				array(
					'type'		=> 'module',
					'title'		=> __('Color','cloudfw'),
					'data'		=> array(

						## Element
						array(
							'type'		=>	'select',
							'ui'		=>	true,
							'main_class'=>  'input input_250',
							'id'		=>	'button_color',
							'value'		=>	$that->get_value('button_color', 'primary'),
							'source'	=>	array(
								'type'		=>	'function',
								'function'	=>	'cloudfw_admin_loop_button_colors'
							),


						), // #### element: 0

					)

				),

				array(
					'type'		=> 'module',
					'title'		=> __('Align','cloudfw'),
					'data'		=> array(

						## Element
						array(
							'type'		=>	'select',
							'id'		=>	'button_align',
							'value'		=>	$that->get_value('button_align'),
							'source'	=>	array(
								'type'		=> 'function',
								'function'	=> 'cloudfw_admin_loop_text_aligns',

							),
							'ui'		=>	true,
							'main_class'=> 'input_150'
						), // #### element: 0

					)

				),

				array(
					'type'		=> 'module',
					'title'		=> __('Border Radius','cloudfw'),
					'data'		=> array(

						## Element
						array(
							'type'		=>	'select',
							'id'		=>	'button_radius',
							'value'		=>	$that->get_value('button_radius'),
							'ui'		=>	true,
							'main_class'=>  'input input_150',
							'source'	=>	array(
								'NULL'			=> __('Default','cloudfw'),
								'radius-3px'	=> __('3px Radius','cloudfw'),
								'radius-30px'	=> __('30px Radius','cloudfw'),
								'no-radius'		=> __('No Radius','cloudfw'),
							)

						), // #### element: 0

					)

				),

				array(
					'type'		=> 'module',
					'title'		=> __('Block Style?','cloudfw'),
					'data'		=> array(

						## Element
						array(
							'type'		=>	'onoff',
							'id'		=>	'button_block',
							'value'		=>	$that->get_value('button_block', 'FALSE'),
						), // #### element: 0

					)

				),

				array(
					'type'		=> 'module',
					'title'		=> __('Shadow','cloudfw'),
					'data'		=> array(

						## Element
						array(
							'type'		=>	'select',
							'id'		=>	'button_shadow',
							'value'		=>	$that->get_value('button_shadow'),
							'source'	=>	array(
								'type'			=> 'function',
								'function'		=> 'cloudfw_admin_loop_shadows',
							),
							'width'		=>	250,

						), // #### element: 0

					)

				),


			)

		),
		

		array(
			'type'		=> 'mini-section',
			'title'		=> __('Icon','cloudfw'),
			'data'		=> array(

				array(
					'type'		=> 'module',
					'title'		=> __('Icon','cloudfw'),
					'data'		=> array(

						## Element
						array(
							'type'		=>	'icon-selector',
							'id'		=>	'button_icon_pre',
							'value'		=>	$that->get_value('button_icon_pre'),
						), // #### element: 0

					)

				),

				array(
					'type'		=> 'module',
					'title'		=> __('Icon Position','cloudfw'),
					'data'		=> array(

						## Element
						array(
							'type'		=>	'select',
							'id'		=>	'button_icon_icon_position',
							'value'		=>	$that->get_value('button_icon_icon_position'),
							'ui'		=>	true,
							'main_class'=>  'input input_150',
							'source'	=>	array(
								'NULL'			=> __('Left','cloudfw'),
								'right' 		=> __('Right','cloudfw'),
							)

						), // #### element: 0

					)

				),

			)

		),

		array(
			'type'		=> 'mini-section',
			'title'		=> __('Effect','cloudfw'),
			'data'		=> array(

				array(
					'type'		=> 'module',
					'title'		=> __('Custom Transition Effect','cloudfw'),
					'data'		=> array(

						## Element
						array(
							'type'		=>	'select',
							'id'		=>	'button_custom_effect',
							'value'		=>	$that->get_value('button_custom_effect'),
							'ui'		=>	true,
							'source'	=>	array(
								'type'		=>	'function',
								'function'	=>	'cloudfw_css_effect_list',
							),
							'width'		=>	400,
						),

					)

				),

			)

		),
		
		
		array(
			'type'		=> 'mini-section',
			'title'		=> __('Other Options','cloudfw'),
			'data'		=> array(

				array(
					'type'		=>	'global-scheme',
					'scheme'	=>	'margins',
					'this'		=>	$that
				),


				array(
					'type'		=> 'module',
					'title'		=> __('Title Attribute','cloudfw'),
					'data'		=> array(

						## Element
						array(
							'type'		=>	'text',
							'id'		=>	'button_title_attr',
							'value'		=>	$that->get_value('button_title_attr'),
							'width'	    =>  250,
						), // #### element: 0

					)

				),

			)

		),
		
	);