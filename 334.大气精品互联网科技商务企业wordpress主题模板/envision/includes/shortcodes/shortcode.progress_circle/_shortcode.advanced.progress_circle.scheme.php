<?php

return array(

	array(
		'type'		=> 'module',
		'title'		=> __('Progress Level','cloudfw'),
		'data'		=> array(

			## Element
			array(
				'type'		=>	'slider',
				'id'		=>	'progress_circle_percent',
				'value'		=>	$that->get_value('progress_circle_percent', 50),
				'step'		=>	1,
				'min'		=>	1,
				'max'		=>	100,
				'unit'		=>	'%',
				'width'		=>	400,
			), // #### element: 0

		)

	),

	array(
		'type'		=> 'module',
		'title'		=> __('Circle Size','cloudfw'),
		'data'		=> array(

			## Element
			array(
				'type'		=>	'text',
				'id'		=>	'progress_circle_size',
				'value'		=>	$that->get_value('progress_circle_size', 200),
				'width'		=>	35,
				'unit'		=>	'px',
			), // #### element: 0

		)

	),


	array(
		'type'		=> 'module',
		'title'		=> __('Bar Width','cloudfw'),
		'data'		=> array(

			## Element
			array(
				'type'		=>	'slider',
				'id'		=>	'progress_circle_bar_width',
				'value'		=>	$that->get_value('progress_circle_bar_width', 15),
				'step'		=>	1,
				'min'		=>	1,
				'max'		=>	100,
				'unit'		=>	'px',
				'width'		=>	400,
			), // #### element: 0

		)

	),

	array(
		'type'		=> 'module',
		'layout'	=> 'split',
		'title'		=> array(__('Bar Color','cloudfw'), __('Track Color','cloudfw')),
		'data'		=> array(

			## Element
			array(
				'type'		=>	'color',
				'style'		=>	'horizontal',
				'id'		=>	'progress_circle_bar_color',
				'value'		=>	$that->get_value('progress_circle_bar_color'),
			), // #### element: 0

			## Element
			array(
				'type'		=>	'color',
				'style'		=>	'horizontal',
				'id'		=>	'progress_circle_track_color',
				'value'		=>	$that->get_value('progress_circle_track_color'),
			), // #### element: 0

		)

	),

	array(
		'type'		=> 'module',
		'title'		=> __('Rotate','cloudfw'),
		'data'		=> array(

			## Element
			array(
				'type'		=>	'slider',
				'id'		=>	'progress_circle_rotate',
				'value'		=>	$that->get_value('progress_circle_rotate', -90),
				'step'		=>	1,
				'min'		=>	-180,
				'max'		=>	180,
				'unit'		=>	__('degrees','cloudfw'),
				'width'		=>	250,
			), // #### element: 0

		)

	),


	array(
		'type'		=> 'module',
		'title'		=> __('Live Counter Text','cloudfw'),
		'data'		=> array(

			## Element
			array(
				'type'		=>	'textarea',
				'id'		=>	'progress_circle_content',
				'value'		=>	$that->get_value('progress_circle_content', '<strong>{{percent}}</strong>%'),
				'width'		=>  400,	
				'line'		=>  3,
				'editor'	=>  true,
				'desc'		=>	__('<code>{{percent}}</code>: Dynamic Progress Level','cloudfw')
			), // #### element: 0

		)

	),


	array(
		'type'		=> 'module',
		'title'		=> __('Label','cloudfw'),
		'data'		=> array(

			## Element
			array(
				'type'		=>	'text',
				'id'		=>	'progress_circle_label',
				'value'		=>	$that->get_value('progress_circle_label'),
				'width'		=>  400,	
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


	
);