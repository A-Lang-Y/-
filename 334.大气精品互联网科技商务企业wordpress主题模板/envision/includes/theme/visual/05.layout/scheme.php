<?php

$scheme[ cloudfw_id_for_sequence( $scheme, $number ) ] = array(
	'type'          =>  'section',
	'title'         =>  __('Site Layout','cloudfw'),
	'data'          =>  array(

		array(
			'type'      =>  'module-set',
			'title'     =>  __('Layout','cloudfw'),
			'closable'  =>  true,
			'state'     =>  'opened',
			'data'      =>  array(

				## Module Item
				array(
					'type'      =>  'module',
					'title'     =>  __('Site Layout','cloudfw'),
					'data'      =>  array(
						array(
							'type'      =>  'select',
							'id'        =>  cloudfw_sanitize('options','layout'),
							'value'     =>  $data['options']['layout'],
							'source'    =>  array(
								'NULL'      =>  __('Full Width Layout','cloudfw'),
								'boxed'     =>  __('Boxed Layout','cloudfw'),
							),
							'width'     =>  250,
						)

					),
					'js'        => array(
						## Script Item
						array(
							'type'          => 'toggle',
							'related'       => 'visualLayoutBoxedOptions',
							'conditions'    => array(
								array( 'val' => 'boxed', 'e' => '.visualLayoutBoxedOptions' ),
							)
						),

					)

				), 
		
			)

		), 

		array(
			'type'      =>  'module-set',
			'title'     =>  __('Boxed Layout','cloudfw'),
			'closable'  =>  true,
			'state'     =>  'opened',
			'related'   =>  'visualLayoutBoxedOptions',
			'data'      =>  array(

				## Module Item
				array(
					'type'      =>  'module',
					'ucode'     =>  'BOXED LAYOUT',
					'title'     =>  __('Background','cloudfw'),
					'data'      =>  array( array(
							'type'      =>  'grid',
							//'layout'  =>  'nospaced',
							'data'      =>  array(
								
								array(
									'type'      =>  'gradient',
									'title'     =>  __('Background-Color','cloudfw'),
									'id'        =>  cloudfw_sanitize('boxed_layout','gradient'),
									'value'     =>  $data['boxed_layout']['gradient'],
								),
								array(
									'type'      =>  'bg-set',
									'id'        =>  'boxed_layout',
									'id:pattern'=>  'boxed_layout',
									'value'     =>  $data,
								)
							
							)
							
						),
						
					)

				),

				## Module Item
				array(
					'type'      =>  'module',
					'ucode'     =>  'BOXED LAYOUT',
					'title'     =>  __('Background Attachment','cloudfw'),
					'data'      =>  array(

						array(
							'type'      => 'select',
							'id'        =>  cloudfw_sanitize('boxed_layout','background-attachment'),
							'value'     =>  $data['boxed_layout']["background-attachment"],
							'source'    => array(
								'type'		=>	'function',
								'function'  =>	'cloudfw_admin_loop_background_attachments',
							),
							'width'		=>	250,

						),

					)

				),

				## Module Item
				array(
					'type'      =>  'module',
					'ucode'     =>  'BOXED LAYOUT',
					'title'     =>  __('Background Size','cloudfw'),
					'data'      =>  array(

						array(
							'type'      => 'select',
							'id'        =>  cloudfw_sanitize('boxed_layout','background-size'),
							'value'     =>  $data['boxed_layout']["background-size"],
							'source'    => array(
								'type'		=>	'function',
								'function'  =>	'cloudfw_admin_loop_background_sizes',
							),
							'width'		=>	250,

						),

					)

				),

				## Module Item
				array(
					'type'      =>  'module',
					'ucode'     =>  'BOXED LAYOUT SHADOW',
					'title'     =>  __('Box Shadow','cloudfw'),
					'data'      =>  array(
						array(
							'type'      =>  'slider',
							'title'     =>  __('Size','cloudfw'),
							'id'        =>  cloudfw_sanitize('boxed_layout_page_wrap','box-shadow size'),
							'value'     =>  $data['boxed_layout_page_wrap']["box-shadow"]["size"],
							'class'     =>  'input_150',
							'default'   =>  10,
							'min'       =>  0,
							'max'       =>  100
						),
						array(
							'type'      =>  'slider',
							'title'     =>  __('Opacity','cloudfw'),
							'id'        =>  cloudfw_sanitize('boxed_layout_page_wrap','box-shadow opacity'),
							'value'     =>  $data['boxed_layout_page_wrap']["box-shadow"]["opacity"],
							'class'     =>  'input_150',
							'default'   =>  .4,
							'min'       =>  0,
							'max'       =>  1,
							'step'      =>  .05,
							'unit'      =>  false,
						)
					),
				
				),


				array(
					'type'		=> 'module',
					'title'		=> array(__('Margin Top','cloudfw'), __('Margin Bottom','cloudfw')),
					'layout'	=> 'split',
					'data'		=> array(

						## Element
						array(
							'type'		=>	'text',
							'id'        =>  cloudfw_sanitize('boxed_layout_page_wrap','margin-top'),
							'value'     =>  $data['boxed_layout_page_wrap']["margin-top"],
							'width'		=>	50,
							'unit'		=>	__('px','cloudfw')
						), // #### element: 0

						## Element
						array(
							'type'		=>	'text',
							'id'        =>  cloudfw_sanitize('boxed_layout_page_wrap','margin-bottom'),
							'value'     =>  $data['boxed_layout_page_wrap']["margin-bottom"],
							'width'		=>	50,
							'unit'		=>	__('px','cloudfw')
						), // #### element: 0

					)

				),


		
			)

		), 
	
	) 

);