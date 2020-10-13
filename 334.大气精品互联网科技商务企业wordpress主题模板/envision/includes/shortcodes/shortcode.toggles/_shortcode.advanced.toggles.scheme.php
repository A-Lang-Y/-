<?php

return array(

	array(
		'type'		=> 'module',
		'title'		=> __('State','cloudfw'),
		'data'		=> array(

			## Element
			array(
				'type'		=>	'select',
				'id'		=>	'toggle_state',
				'value'		=>	$that->get_value('toggle_state'),
				'main_class'=>  'input input_250',
				'ui'		=>	true,
				'source'	=>	array(
					'opened' 		=> __('Opened','cloudfw'),
					'closed' 		=> __('Closed','cloudfw'),
				)							
			), // #### element: 0

		)

	),

	array(
		'type'		=> 'module',
		'title'		=> __('Title','cloudfw'),
		'data'		=> array(

			## Element
			array(
				'type'		=>	'text',
				'id'		=>	'toggle_title',
				'value'		=>	$that->get_value('toggle_title'),
				'class'	=>	'input input_400 bold',
			), // #### element: 0

		)

	),

	array(
		'type'		=> 'module',
		'title'		=> __('Icons','cloudfw'),
		'data'		=> array(

			## Element
			array(
				'type'		=>	'select',
				'id'		=>	'toggle_icons',
				'value'		=>	$that->get_value('toggle_icons'),
				'main_class'=>  'input input_250',
				'ui'		=>	true,
				'source'	=>	array(
					'NULL'                            				                => __('Default','cloudfw'),
					'fontawesome-plus/fontawesome-minus'                            => __('Plus / Minus','cloudfw'),
					'fontawesome-caret-down/fontawesome-caret-up'                   => __('Caret Down / Up','cloudfw'),
					'fontawesome-chevron-down/fontawesome-chevron-up'               => __('Chevron Down / Up','cloudfw'),
					'fontawesome-circle-blank/fontawesome-circle'                   => __('Circles','cloudfw'),
					'fontawesome-check/fontawesome-check-sign'                      => __('Check','cloudfw'),
					'fontawesome-folder-close-alt/fontawesome-folder-close'         => __('Folders','cloudfw'),
					'fontawesome-bookmark-empty/fontawesome-bookmark'               => __('Bookmark','cloudfw'),
					'fontawesome-question/fontawesome-question-sign'                => __('Question','cloudfw'),
					'fontawesome-info/fontawesome-info'                             => __('Info','cloudfw'),
					'fontawesome-volume-off/fontawesome-volume-up'                  => __('Volume Off / On','cloudfw'),
					'fontawesome-ellipsis-horizontal/fontawesome-ellipsis-vertical' => __('Ellipsis','cloudfw'),
				)							
			), // #### element: 0

		)

	),

	array(
		'type'		=> 'module',
		'title'		=> __('Group Key','cloudfw'),
		'optional'	=> true,
		'data'		=> array(

			## Element
			array(
				'type'		=>	'text',
				'id'		=>	'toggle_group',
				'value'		=>	$that->get_value('toggle_group'),
				'class'		=>	'input input_100',
			), // #### element: 0

		)

	),


	array(
		'condition'	=> !$that->is_composer,
		'type'		=> 'module',
		'title'		=> __('Title','cloudfw'),
		'data'		=> array(

			## Element
			array(
				'type'		=>	'textarea',
				'id'		=>	'toggle_content',
				'value'		=>	$that->get_value('toggle_content'),
				'width'		=>	400,
				'line'		=>	5,
			), // #### element: 0

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