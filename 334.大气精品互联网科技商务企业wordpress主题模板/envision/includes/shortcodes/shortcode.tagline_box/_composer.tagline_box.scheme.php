<?php

return array(
	array(
		'type'		=> 'module',
		'condition'	=> !$that->is_composer,
		'title'		=> __('Content','cloudfw'),
		'data'		=> array(

			## Element
			array(
				'type'		=>	'textarea',
				'id'		=>	'content',
				'value'		=>	$that->get_value('content'),
			), // #### element: 0

		)

	),

	array(
		'type'		=> 'module',
		'title'		=> __('Visibility','cloudfw'),
		'data'		=> array(

			## Element
			array(
				'type'		=>	'select',
				'id'		=>	'the_device',
				'value'		=>	$that->get_value('the_device'),
	            'source'	=>	array(
	            	'type'		=>	'function',
	            	'function'	=>	'cloudfw_admin_get_visibility_options'
	            ),
				'width'		=>	250,
			), // #### element: 0

		)

	),


	array(
		'type'		=> 'mini-section',
		'title'		=> __('Layout','cloudfw'),
		'data'		=> array(
			
			array(
				'type'		=> 'module',
				'title'		=> __('Minimum Box Height','cloudfw'),
				'data'		=> array(

					## Element
					array(
						'type'		=>	'text',
						'id'		=>	'box_height',
						'value'		=>	$that->get_value('box_height'),
						'width'		=>	50,
						'unit'		=>	__('px','cloudfw'),
						'desc'		=>	__('Leave blank for auto.','cloudfw'),

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
						'id'		=>	'shadow',
						'value'		=>	$that->get_value('shadow'),
						'source'	=>	array(
							'type'			=> 'function',
							'function'		=> 'cloudfw_admin_loop_shadows',
						),
						'width'		=>	250,

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
						'id'		=>	'box_radius',
						'value'		=>	$that->get_value('box_radius', 'radius-3px'),
						'ui'		=>	true,
						'source'	=>	array(
							'NULL'			=> __('Default','cloudfw'),
							'radius-3px'	=> __('3px Radius','cloudfw'),
							'radius-6px'	=> __('6px Radius','cloudfw'),
							'radius-30px'	=> __('30px Radius','cloudfw'),
							'no-radius'		=> __('No Radius','cloudfw'),
						),
						'width'		=>	250

					), // #### element: 0

				)

			),			


		)

	),



	array(
		'type'		=> 'mini-section',
		'title'		=> __('Background','cloudfw'),
		'data'		=> array(

			array(
				'type'		=> 'module',
				'title'		=> __('Background Color','cloudfw'),
				'data'		=> array(

					## Element
					array(
						'type'		=>	'gradient',
						'id'		=>	'box_gradient',
						'value'		=>	array( $that->get_value('box_gradient_0'), $that->get_value('box_gradient_1') ),
					), // #### element: 0

				)

			),

		)

	),

	array(
		'type'		=> 'mini-section',
		'title'		=> __('Border','cloudfw'),
		'data'		=> array(

			array(
				'type'		=>	'global-scheme',
				'scheme'	=>	'border',
				'this'		=>	$that,
				'vars'		=>	array( )
			),

		)

	),

	array(
		'type'		=> 'mini-section',
		'title'		=> __('Colors','cloudfw'),
		'data'		=> array(

			array(
				'type'		=> 'module',
				'title'		=> __('Text Color','cloudfw'),
				'data'		=> array(

					## Element
					array(
						'type'		=>	'color',
						'style'		=>	'horizontal',
						'id'		=>	'box_color',
						'value'		=>	$that->get_value('box_color'),
					), // #### element: 0

				)

			),

			array(
				'type'		=>	'global-scheme',
				'scheme'	=>	'text_shadow',
				'this'		=>	$that,
				'vars'		=>	array( )
			),

			array(
				'type'		=> 'module',
				'layout'	=> 'split',
				'title'		=> array(__('Link Color','cloudfw'), __('Link Hover Color','cloudfw')),
				'data'		=> array(

					## Element
					array(
						'type'		=>	'color',
						'style'		=>	'horizontal',
						'id'		=>	'box_link_color',
						'value'		=>	$that->get_value('box_link_color'),
					), // #### element: 0

					## Element
					array(
						'type'		=>	'color',
						'style'		=>	'horizontal',
						'id'		=>	'box_link_hover_color',
						'value'		=>	$that->get_value('box_link_hover_color'),
					), // #### element: 0

				)

			),			

		)

	),

	array(
		'type'		=> 'mini-section',
		'title'		=> __('Link','cloudfw'),
		'data'		=> array(


			array(
				'type'		=>	'global-scheme',
				'scheme'	=>	'link',
				'this'		=>	$that
			),


		)

	),


	array(
		'type'		=> 'mini-section',
		'title'		=> __('Margins','cloudfw'),
		'data'		=> array(


			array(
				'type'		=>	'global-scheme',
				'scheme'	=>	'margins',
				'this'		=>	$that
			),

			array(
				'type'		=>	'global-scheme',
				'scheme'	=>	'paddings',
				'this'		=>	$that
			),

		)

	),

	array(
		'type'		=> 'module',
		'layout'	=> 'split',
		'title'		=> array(__('Custom ID','cloudfw'), __('Custom Class','cloudfw')),
		'data'		=> array(

			## Element
			array(
				'type'		=>	'text',
				'id'		=>	'custom_id',
				'value'		=>	$that->get_value('custom_id'),
				'width'		=>	150,
			), // #### element: 0

			## Element
			array(
				'type'		=>	'text',
				'id'		=>	'custom_class',
				'value'		=>	$that->get_value('custom_class'),
				'width'		=>	150,
			), // #### element: 0

		)

	),

);