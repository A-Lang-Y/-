<?php

$that = $args[0];
$prefix = isset($args[1]) ? $args[1] : NULL;

return $scheme = array(

	array(
		'type'		=> 'module',
		'layout'	=> 'float',
		'title'		=> __('Border','cloudfw'),
		'data'		=> array(
		
			## Element
			array(
				'type'		=>	'color',
				'style'		=>	'horizontal',
				'title'		=>  __('Color','cloudfw'),
				'id'		=>	$that->get_field_name( $prefix . 'border_color'),
				'value'		=>	$that->get_value( $prefix . 'border_color'),

			), // #### element: 0

			## Element
			array(
				'type'		=>	'select',
				'title'		=>  __('Style','cloudfw'),
				'id'		=>	$that->get_field_name( $prefix . 'border_style'),
				'value'		=>	$that->get_value( $prefix . 'border_style'),
				'source'	=>	array(
					'solid' 	=> __('Solid','cloudfw'),
					'dotted'	=> __('Dotted','cloudfw'),
					'dashed' 	=> __('Dashed','cloudfw'),
				),
				'width'		=>	150,

			), // #### element: 0

			array(
				'type'		=>	'text',
				'title'		=>  __('Width','cloudfw'),
				'id'		=>	$that->get_field_name( $prefix . 'border_width'),
				'value'		=>	$that->get_value( $prefix . 'border_width'),
				'width'		=>	50,
				'unit'		=>	__('px','cloudfw'),

			), // #### element: 0

		)

	),

);