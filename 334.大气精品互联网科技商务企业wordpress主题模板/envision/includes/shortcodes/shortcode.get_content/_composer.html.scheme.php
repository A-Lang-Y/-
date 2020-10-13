<?php

return array(
	array(
		'type'		=> 'module',
		'title'		=> __('Content','cloudfw'),
		'data'		=> array(

			## Element
			array(
				'type'		=>	'textarea',
				'id'		=>	'the_content',
				'value'		=>	$that->get_value('the_content'),
				'_class'	=>  'input textarea_95per_8line',
				'editor'	=>	true,
				'description'=> sprintf(__("Allows %s",'cloudfw'), '<code>[shortcodes]</code>')
			), // #### element: 0

		)

	),

	array(
		'type'		=> 'module',
		'title'		=> __('Auto-Format','cloudfw'),
		'data'		=> array(

			## Element
			array(
				'type'		=>	'onoff',
				'id'		=>	'format',
				'value'		=>	$that->get_value('format', true),
			), // #### element: 0

		)

	),

	array(
		'type'		=> 'module',
		'title'		=> __('Animatable?','cloudfw'),
		'data'		=> array(

			## Element
			array(
				'type'		=>	'onoff',
				'id'		=>	'animate',
				'value'		=>	$that->get_value('animate', true),
			), // #### element: 0

		)

	),

);