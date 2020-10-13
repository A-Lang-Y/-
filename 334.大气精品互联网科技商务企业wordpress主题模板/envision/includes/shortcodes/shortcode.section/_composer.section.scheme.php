<?php

return array(
	array(
		'type'		=> 'module',
		'condition'	=> !$that->is_composer,
		'title'		=> __('Content','cloudfw'),
		'data'		=> array(

			## Element
			array(
				'type'		=>	'textarea',
				'id'		=>	'content',
				'value'		=>	$that->get_value('content'),
			), // #### element: 0

		)

	),

	array(
		'type'      => 'module',
		'title'     => __('Section Style','cloudfw'),
		'data'      => array(

			## Element
			array(
				'type'      =>  'select',
				'id'		=>	'style_id',
				'value'		=>	$that->get_value('style_id'),
				'source'    =>  array(
					'type'          => 'function',
					'function'      => 'cloudfw_admin_loop_section_styles',
				),
				'width'		=>  400,
				'action_link'=> '<a class="cloudfw-ui-action-link" href="'. cloudfw_admin_url('visual') .'#section_styles" target="_blank"><i class="cloudfw-ui-icon cloudfw-ui-icon-plus"></i>'.__('Add New Style','cloudfw').'</a>'
			)

		)

	),


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
		'title'		=> array(__('Margin Top','cloudfw'), __('Margin Bottom','cloudfw')),
		'layout'	=> 'split',
		'data'		=> array(

			## Element
			array(
				'type'		=>	'text',
				'id'		=>	'margin_top',
				'value'		=>	$that->get_value('margin_top'),
				'width'		=>	50,
				'unit'		=>	__('px','cloudfw')
			), // #### element: 0

			## Element
			array(
				'type'		=>	'text',
				'id'		=>	'margin_bottom',
				'value'		=>	$that->get_value('margin_bottom'),
				'width'		=>	50,
				'unit'		=>	__('px','cloudfw')
			), // #### element: 0

		)

	),

	array(
		'type'		=> 'module',
		'title'		=> array(__('Padding Top','cloudfw'), __('Padding Bottom','cloudfw')),
		'layout'	=> 'split',
		'data'		=> array(

			## Element
			array(
				'type'		=>	'text',
				'id'		=>	'padding_top',
				'value'		=>	$that->get_value('padding_top'),
				'width'		=>	50,
				'unit'		=>	__('px','cloudfw')
			), // #### element: 0

			## Element
			array(
				'type'		=>	'text',
				'id'		=>	'padding_bottom',
				'value'		=>	$that->get_value('padding_bottom'),
				'width'		=>	50,
				'unit'		=>	__('px','cloudfw')
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