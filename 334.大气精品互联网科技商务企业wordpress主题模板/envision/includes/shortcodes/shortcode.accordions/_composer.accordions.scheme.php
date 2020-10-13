<?php

return array(

	array(
		'type'		=> 'module',
		'title'		=> __('Visibility','cloudfw'),
		'data'		=> array(

			## Element
			array(
				'type'		=>	'select',
				'id'		=>	'the_device',
				'value'		=>	$that->get_value('the_device'),
	            'source'	=>	array(
	            	'type'		=>	'function',
	            	'function'	=>	'cloudfw_admin_get_visibility_options'
	            ),
				'width'		=>	250,
			), // #### element: 0

		)

	),

	array(
		'type'		=> 'module',
		'title'		=> __('Item Icons (Closed State)','cloudfw'),
		'data'		=> array(

			## Element
			array(
				'type'		=>	'icon-selector',
				'id'		=>	'accordion_icon',
				'value'		=>	$that->get_value('accordion_icon'),
			)

		)

	),

	array(
		'type'		=> 'module',
		'title'		=> __('Item Icons (Opened State)','cloudfw'),
		'data'		=> array(

			## Element
			array(
				'type'		=>	'icon-selector',
				'id'		=>	'accordion_icon_opened',
				'value'		=>	$that->get_value('accordion_icon_opened'),
			)

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