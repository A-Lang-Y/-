<?php

$that = $args[0]; 
$vars = $args[1]; 

return $scheme = array(

	array(
		'type'		=>	'module',
		'condition' =>	isset($vars['carousel']) && $vars['carousel'] === true,
		'title'		=>	__('Enable Carousel?','cloudfw'),
		'data'		=>	array(

			## Element
			array(
				'type'		=>	'onoff',
				'id'		=>	$that->get_field_name('carousel'),
				'value'		=>	$that->get_value('carousel'),
			), // #### element: 0

		)

	),	

	array(
		'type'		=>	'module',
		'condition' =>	!isset($vars['effect']) || $vars['effect'] !== false,
		'title'		=>	__('Transition Effect','cloudfw'),
		'data'		=>	array(

			## Element
			array(
				'type'		=>	'select',
				'id'		=>	$that->get_field_name('effect'),
				'value'		=>	$that->get_value('effect'),
				'main_class'=>  'widefat',
				'source'	=>	array(
					'NULL'		=>	__('Slide','cloudfw'),
					'fade'		=>	__('Fade','cloudfw')
				),
				'width'		=>	350
			), // #### element: 0

		)

	),


	array(
		'type'		=>	'module',
		'title'		=>	__('Auto Rotate?','cloudfw'),
		'data'		=>	array(
			array(
				'type'		=>	'onoff',
				'id'		=>	$that->get_field_name('auto_rotate'),
				'value'		=>	$that->get_value('auto_rotate'),
			)
		),
	),

	array(
		'type'		=>	'module',
		'title'		=>	__('Loop Animation?','cloudfw'),
		'data'		=>	array(
			array(
				'type'		=>	'onoff',
				'id'		=>	$that->get_field_name('animation_loop'),
				'value'		=>	$that->get_value('animation_loop', 'FALSE'),
			)
		),
	),

	array(
		'type'		=>	'module',
		'title'		=>	__('Auto Rotate Time','cloudfw'),
		'data'		=>	array(
			array(
				'type'		=>	'slider',
				'id'		=>	$that->get_field_name('rotate_time'),
				'value'		=>	$that->get_value('rotate_time'),
				'min'		=>	0,
				'max'		=>	120,
				'step'		=>	.5,
				'steps'		=>	array( 0 => __('Default','cloudfw') ),
				'unit'		=>	__('seconds','cloudfw'),
				'desc'		=>	__('Leave blank for default','cloudfw'),
				'width'		=>	250
			)
		),
	),


);