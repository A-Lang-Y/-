<?php

return array(
	array(
		'type'		=> 'module',
		'title'		=> __('Text Align','cloudfw'),
		'data'		=> array(

			## Element
			array(
				'type'		=>	'select',
				'id'		=>	'column_align',
				'value'		=>	$that->get_value('column_align'),
				'source'	=>	array(
					'type'		=> 'function',
					'function'	=> 'cloudfw_admin_loop_text_aligns',

				),
				'ui'		=>	true,
				'width'		=>	250,
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