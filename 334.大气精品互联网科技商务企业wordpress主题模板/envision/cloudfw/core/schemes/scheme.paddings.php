<?php

$that = $args[0]; 

return $scheme = array(

	array(
		'type'		=> 'module',
		'title'		=> array(__('Padding Top','cloudfw'), __('Padding Bottom','cloudfw')),
		'layout'	=> 'split',
		'data'		=> array(

			## Element
			array(
				'type'		=>	'text',
				'id'		=>	$that->get_field_name('padding_top'),
				'value'		=>	$that->get_value('padding_top'),
				'width'		=>	50,
				'unit'		=>	__('px','cloudfw')
			), // #### element: 0

			## Element
			array(
				'type'		=>	'text',
				'id'		=>	$that->get_field_name('padding_bottom'),
				'value'		=>	$that->get_value('padding_bottom'),
				'width'		=>	50,
				'unit'		=>	__('px','cloudfw')
			), // #### element: 0

		)

	),

);