<?php

$that = $args[0];

return $scheme = array(

	array(
		'type'		=> 'module',
		'title'		=> array(__('Margin Top','cloudfw'), __('Margin Bottom','cloudfw')),
		'layout'	=> 'split',
		'data'		=> array(

			## Element
			array(
				'type'		=>	'text',
				'id'		=>	$that->get_field_name('margin_top'),
				'value'		=>	$that->get_value('margin_top'),
				'width'		=>	50,
				'unit'		=>	__('px','cloudfw')
			), // #### element: 0

			## Element
			array(
				'type'		=>	'text',
				'id'		=>	$that->get_field_name('margin_bottom'),
				'value'		=>	$that->get_value('margin_bottom'),
				'width'		=>	50,
				'unit'		=>	__('px','cloudfw')
			), // #### element: 0

		)

	),

);