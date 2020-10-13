<?php

$that = $args[0];
$prefix = isset($args[1]) ? $args[1] : NULL;

return $scheme = array(

	array(
		'type'		=> 'module',
		'title'		=> __('Link','cloudfw'),
		'data'		=> array(

			## Element
			array(
				'type'		=>	'page-selector',
				'response'	=>	'URL',
				'id'		=>	$that->get_field_name( $prefix . 'link'),
				'value'		=>	$that->get_value( $prefix . 'link'),
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
				'id'		=>	$that->get_field_name( $prefix . 'target'),
				'value'		=>	$that->get_value( $prefix . 'target'),
				'source'	=>	array(
					'type'		=>	'function',
					'function'	=>	'cloudfw_admin_loop_link_targets'
				),
				'width'		=>  250,

			), // #### element: 0

		)

	),

);