<?php

return array(

	array(
		'type'		=> 'module',
		'title'		=> __('Title Style','cloudfw'),
		'data'		=> array(

			## Element
			array(
				'type'		=>	'select',
				'ui'		=>	true,
				'main_class'=>  'input input_250',
				'id'		=>	'title_type',
				'value'		=>	$that->get_value('title_type'),
				'source'	=>	array(
					'title' 			=> __('Title - Left/Right Line','cloudfw'),
					'title_bottom' 		=> __('Title - Bottom Line','cloudfw'),
					'title_bottom_alt' 	=> __('Title - Bottom Line Alternative','cloudfw'),

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
				'id'		=>	'titles_title',
				'value'		=>	$that->get_value('titles_title'),
				'_class'	=>  'bold',
				'editor'	=>	true
			), // #### element: 0

		)

	),

	array(
		'type'		=> 'module',
		'title'		=> __('Title Size','cloudfw'),
		'data'		=> array(

			## Element
			array(
				'type'		=>	'select',
				'ui'		=>	true,
				'main_class'=>  'input input_250',
				'id'		=>	'titles_element',
				'value'		=>	$that->get_value('titles_element', 'h3'),
				'source'	=>	array(
					'h1' 		=> __('H1','cloudfw'),
					'h2' 		=> __('H2','cloudfw'),
					'h3' 		=> __('H3','cloudfw'),
					'h4' 		=> __('H4','cloudfw'),
					'h5' 		=> __('H5','cloudfw'),
					'h6' 		=> __('H6','cloudfw'),
					'strong'	=> __('Strong','cloudfw'),
				)

			), // #### element: 0

		)

	),

	array(
		'type'		=> 'module',
		'title'		=> __('Align','cloudfw'),
		'data'		=> array(

			## Element
			array(
				'type'		=>	'select',
				'id'		=>	'titles_align',
				'value'		=>	$that->get_value('titles_align'),
				'source'	=>	array(
					'NULL' 		=> __('Left','cloudfw'),
					'center'	=> __('Center','cloudfw'),
					'right' 	=> __('Right','cloudfw'),
				),
				'main_class'=>  'input input_250',

			), // #### element: 0

		)

	),

	array(
		'type'		=> 'module',
		'title'		=> __('Title Color','cloudfw'),
		'data'		=> array(

			## Element
			array(
				'type'		=>	'color',
				'style'		=>	'horizontal',
				'id'		=>	'titles_color',
				'value'		=>	$that->get_value('titles_color'),
			), // #### element: 0

		)

	),

	array(
		'type'		=> 'module',
		'layout'	=> 'float',
		'title'		=> __('Line Style','cloudfw'),
		'data'		=> array(
		
			## Element
			array(
				'type'		=>	'color',
				'style'		=>	'horizontal',
				'title'		=>  __('Line Color','cloudfw'),
				'id'		=>	'titles_border_color',
				'value'		=>	$that->get_value('titles_border_color'),

			), // #### element: 0

			## Element
			array(
				'type'		=>	'select',
				'title'		=>  __('Line Style','cloudfw'),
				'id'		=>	'titles_border_style',
				'value'		=>	$that->get_value('titles_border_style'),
				'source'	=>	array(
					'NULL' 		=> __('Solid','cloudfw'),
					'dotted'	=> __('Dotted','cloudfw'),
					'dashed' 	=> __('Dashed','cloudfw'),
				),
				'main_class'=>  'input input_150',

			), // #### element: 0

			array(
				'type'		=>	'text',
				'title'		=>  __('Line Width','cloudfw'),
				'id'		=>	'titles_border_width',
				'value'		=>	$that->get_value('titles_border_width'),
				'width'		=>	70,
			), // #### element: 0

		)

	),

	array(
		'type'		=> 'module',
		'title'		=> __('Link','cloudfw'),
		'data'		=> array(

			## Element
			array(
				'type'		=>	'page-selector',
				'id'		=>	'titles_link',
				'value'		=>	$that->get_value('titles_link'),
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
		'title'		=> array(__('ID Tag','cloudfw'), __('Custom Class','cloudfw')),
		'layout'	=> 'split',
		'data'		=> array(

			array(
				'type'		=>	'text',
				'id'		=>	'titles_id',
				'value'		=>	$that->get_value('titles_id'),
				'width'		=>	70
			), // #### element: 0

			array(
				'type'		=>	'text',
				'id'		=>	'titles_class',
				'value'		=>	$that->get_value('titles_class'),
				'width'		=>	70
			), // #### element: 0

		)

	),


);