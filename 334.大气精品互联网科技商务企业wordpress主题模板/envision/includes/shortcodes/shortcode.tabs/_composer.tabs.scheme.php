<?php

return array(
	array(
		'type'		=> 'module',
		'title'		=> __('Tabs Type','cloudfw'),
		'data'		=> array(

			## Element
			array(
				'type'		=>	'select',
				'id'		=>	'tab_type',
				'value'		=>	$that->get_value('tab_type'),
				'main_class'=>  'input input_250',
				'ui'		=>	true,
				'source'	=>	array(
					'tabs' 			=> __('Mini Tabs - Horizontal','cloudfw'),
					'tabs_vertical' => __('Mini Tabs - Vertical','cloudfw'),
					'tabs_mega' 	=> __('Mega Tabs','cloudfw'),
				)							
			), // #### element: 0

		)

	),

	array(
		'type'		=> 'module',
		'related'	=> 'tabsAlignOptions',
		'title'		=> __('Tabs Title Align','cloudfw'),
		'data'		=> array(

			## Element
			array(
				'type'		=>	'select',
				'id'		=>	'tab_title_align',
				'value'		=>	$that->get_value('tab_title_align'),
				'main_class'=>  'input input_250',
				'ui'		=>	true,
				'source'	=>	array(
					'left' 		=> __('Left','cloudfw'),
					'center' 	=> __('Center','cloudfw'),
					'right' 	=> __('Right','cloudfw'),
				)							
			), // #### element: 0

		)

	),				

	array(
		'type'		=> 'module',
		'related'	=> 'tabsAlignOptions',
		'title'		=> __('Vertical Tabs Title Position','cloudfw'),
		'data'		=> array(

			## Element
			array(
				'type'		=>	'select',
				'id'		=>	'tab_position',
				'value'		=>	$that->get_value('tab_position'),
				'main_class'=>  'input input_250',
				'ui'		=>	true,
				'source'	=>	array(
					'left' 		=> __('Left','cloudfw'),
					'right' 	=> __('Right','cloudfw'),
				)							
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
		'type'		=> 'module',
		'title'		=> array(__('Margin Top','cloudfw'), __('Margin Bottom','cloudfw')),
		'layout'	=> 'split',
		'data'		=> array(

			## Element
			array(
				'type'		=>	'text',
				'id'		=>	'margin_top',
				'value'		=>	$that->get_value('margin_top'),
				'width'		=>	70
			), // #### element: 0

			## Element
			array(
				'type'		=>	'text',
				'id'		=>	'margin_bottom',
				'value'		=>	$that->get_value('margin_bottom'),
				'width'		=>	70
			), // #### element: 0

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