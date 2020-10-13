<?php

return array(
		array(
			'type'		=> 'module',
			'title'		=> __('Type','cloudfw'),
			'data'		=> array(

				## Element
				array(
					'type'		=>	'select',
					'ui'		=>	true,
					'main_class'=>  'input input_250',
					'id'		=>	'heading_type',
					'value'		=>	$that->get_value('heading_type', 'h3'),
					'source'	=>	array(
						'h1' 				=> __('H1','cloudfw'),
						'h2' 				=> __('H2','cloudfw'),
						'h3' 				=> __('H3','cloudfw'),
						'h4' 				=> __('H4','cloudfw'),
						'h5' 				=> __('H5','cloudfw'),
						'h6' 				=> __('H6','cloudfw'),
						'custom_heading'	=> __('Custom Size','cloudfw'),
					)

				), // #### element: 0

			)

		),

		array(
			'type'		=> 'module',
			'title'		=> __('Title','cloudfw'),
			'data'		=> array(

				## Element
				array(
					'type'		=>	'textarea',
					'id'		=>	'heading_title',
					'value'		=>	$that->get_value('heading_title'),
					'_class'	=>  'bold',
					'editor'	=>	true,
					'width'		=>	'90%',
					'line'		=>	5,
				), // #### element: 0

			)

		),

		array(
			'type'		=> 'module',
			'related'	=> 'headingElements',
			'layout'	=> 'split',
			'title'		=> array(__('Font Size','cloudfw'), __('Line Height','cloudfw')),
			'data'		=> array(

				## Element
				array(
					'type'		=>	'slider',
					'id'		=>	'heading_size',
					'value'		=>	$that->get_value('heading_size', 32),
					'min'		=>	8,
					'max'		=>	96,
					'step'		=>	1,
					'width'		=>	250
				), // #### element: 0

				## Element
				array(
					'type'		=>	'slider',
					'id'		=>	'heading_line_height',
					'value'		=>	$that->get_value('heading_line_height', 36),
					'min'		=>	8,
					'max'		=>	120,
					'step'		=>	1,
					'width'		=>	250
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
					'id'		=>	'heading_align',
					'value'		=>	$that->get_value('heading_align'),
					'source'	=>	array(
						'NULL'		=> __('Left','cloudfw'),
						'center'	=> __('Center','cloudfw'),
						'right'		=> __('Right','cloudfw'),
					),
					'ui'		=>	true,
					'main_class'=> 'input_150'
				), // #### element: 0

			)

		),

		array(
			'type'		=> 'module',
			'optional'	=> true,
			'title'		=> __('Custom Color','cloudfw'),
			'data'		=> array(

				## Element
				array(
					'type'		=>	'color',
					'id'		=>	'heading_color',
					'style'		=>	'horizontal',
					'value'		=>	$that->get_value('heading_color'),
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
					'id'		=>	'heading_link',
					'value'		=>	$that->get_value('heading_link'),
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
					'id'		=>	'heading_margin_top',
					'value'		=>	$that->get_value('heading_margin_top'),
					'width'		=>	70
				), // #### element: 0

				## Element
				array(
					'type'		=>	'text',
					'id'		=>	'heading_margin_bottom',
					'value'		=>	$that->get_value('heading_margin_bottom'),
					'width'		=>	70
				), // #### element: 0

			)

		),


		array(
			'type'		=> 'module',
			'layout'	=> 'split',
			'title'		=> array(__('ID Tag','cloudfw'), __('Class Tag','cloudfw')),
			'data'		=> array(

				## Element
				array(
					'type'		=>	'text',
					'id'		=>	'heading_id',
					'value'		=>	$that->get_value('heading_id'),
					'class'		=>  'input input_100',
				), // #### element: 0

				## Element
				array(
					'type'		=>	'text',
					'id'		=>	'heading_class',
					'value'		=>	$that->get_value('heading_class'),
					'class'		=>  'input input_100',
				), // #### element: 0

			)

		),
		
	);