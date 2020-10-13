<?php

$that = $args[0];
$prefix = isset($args[1]) ? $args[1] : NULL;

return $scheme = array(

	array(
		'type'		=> 'module',
		'layout'	=> 'float',
		'title'		=> __('Text Shadow','cloudfw'),
		'data'		=> array(

			## Element
			array(
				'type'		=>	'color',
				'style'		=>	'horizontal',
				'title'		=>	__('Color','cloudfw'),
				'id'		=>	$that->get_field_name( $prefix . 'shadow_color'),
				'value'		=>	$that->get_value( $prefix . 'shadow_color'),

			),

			## Element
			array(
				'type'		=>	'select',
				'style'		=>	'horizontal',
				'title'		=>	__('Direction','cloudfw'),
				'id'		=>	$that->get_field_name( $prefix . 'shadow_direction'),
				'value'		=>	$that->get_value( $prefix . 'shadow_direction'),
				'source'	=>	array(
					'-1'		=>	__('Top','cloudfw'),
					'1'			=>	__('Bottom','cloudfw'),
				),
				'width'		=>	120

			),

		)

	),

);