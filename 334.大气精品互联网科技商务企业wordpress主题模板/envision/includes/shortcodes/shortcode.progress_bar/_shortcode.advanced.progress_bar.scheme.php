<?php

return array(


	array(
		'type'		=> 'module',
		'title'		=> __('Title','cloudfw'),
		'data'		=> array(

			## Element
			array(
				'type'		=>	'text',
				'id'		=>	'progress_content',
				'value'		=>	$that->get_value('progress_content'),
				'class'		=>	'input input_400 bold',
			), // #### element: 0

		)

	),

	array(
		'type'		=> 'module',
		'title'		=> __('Progress Level','cloudfw'),
		'data'		=> array(

			## Element
			array(
				'type'		=>	'slider',
				'id'		=>	'progress_percent',
				'value'		=>	$that->get_value('progress_percent'),
				'step'		=>	1,
				'min'		=>	0,
				'max'		=>	100,
				'unit'		=>	'%',
				'width'		=>	400,
			), // #### element: 0

		)

	),

	array(
		'type'		=> 'module',
		'title'		=> __('Value','cloudfw'),
		'data'		=> array(

			## Element
			array(
				'type'		=>	'text',
				'id'		=>	'progress_value',
				'value'		=>	$that->get_value('progress_value'),
				'class'		=>	'input input_200',
			), // #### element: 0

		)

	),

	array(
		'type'		=> 'module',
		'title'		=> __('Bar Height','cloudfw'),
		'data'		=> array(

			## Element
			array(
				'type'		=>	'text',
				'id'		=>	'progress_height',
				'value'		=>	$that->get_value('progress_height'),
				'width'		=>	70
			), // #### element: 0

		)

	),

	array(
		'type'		=> 'module',
		'title'		=> __('Bar Color','cloudfw'),
		'data'		=> array(

			## Element
			array(
				'type'		=>	'gradient',
				'id'		=>	'progress_gradient',
				'value'		=>	array( $that->get_value('progress_gradient_0'), $that->get_value('progress_gradient_1') ),
			), // #### element: 0

		)

	),

	array(
		'type'		=> 'module',
		'title'		=> __('Bar Stripe Effect','cloudfw'),
		'data'		=> array(

			## Element
			array(
				'type'		=>	'onoff',
				'id'		=>	'progress_stripe',
				'value'		=>	$that->get_value('progress_stripe', 'FALSE'),
				'desc'		=>	__('Only works on modern browsers.','cloudfw'),
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