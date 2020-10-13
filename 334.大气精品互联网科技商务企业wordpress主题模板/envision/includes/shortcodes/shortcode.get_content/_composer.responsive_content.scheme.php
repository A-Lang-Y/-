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
				'ui'		=>	true,
				'main_class'=>	'input input_250',
			), // #### element: 0

		)

	),

	array(
		'type'		=> 'module',
		'condition'	=> !$that->is_composer,
		'title'		=> __('Content','cloudfw'),
		'data'		=> array(

			## Element
			array(
				'type'		=>	'textarea',
				'id'		=>	'responsive_content',
				'value'		=>	$that->get_value('responsive_content'),
			), // #### element: 0

		)

	),

);