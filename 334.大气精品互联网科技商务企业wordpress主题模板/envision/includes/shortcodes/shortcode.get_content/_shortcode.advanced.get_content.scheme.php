<?php
return	array(

	array(
		'type'		=>	'module',
		'condition'	=>	$that->is_widget,
		'title'		=>	__('Title','cloudfw'),
		'data'		=>	array(
			array(
				'type'		=>	'text',
				'id'		=>	$that->get_field_name('title'),
				'value'		=>	$that->get_value('title'),
				'_class'		=>	'widefat',
			)
		),
	),

	array(
		'type'		=> 'module',
		'title'		=> __('Page','cloudfw'),
		'data'		=> array(

			## Element
			array(
				'type'		=>	'select',
				'id'		=>	$that->get_field_name('the_content_id'),
				'value'		=>	$that->get_value('the_content_id'),
				'main_class'=>  'input input_350',
				'ui'		=>	true,
				'source'	=>	array(
					'type'		=>	'function',
					'function'	=>	'cloudfw_admin_loop_all_pages'
				)							
			), // #### element: 0

		)

	),

);