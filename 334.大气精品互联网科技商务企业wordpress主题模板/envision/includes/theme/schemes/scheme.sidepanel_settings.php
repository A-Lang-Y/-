<?php

$option_field = $args[1];
$number = $args[2];
$options = isset($args[3]) ? $args[3] : array();

return $scheme = array(

	## Module Item
	array(
		'type'      =>  'module',
		'title'     =>  __('Enable?','cloudfw'),
		'data'      =>  array(

			## Element
			array(
				'type'      =>  'onoff',
				'id'        =>  cloudfw_sanitize( PFIX.'_'. $option_field .' enable' ),
				'value'     =>  cloudfw_get_option( $option_field,  'enable' ),
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
				'id'        =>  cloudfw_sanitize( PFIX.'_'. $option_field .' visibility' ),
				'value'     =>  cloudfw_get_option( $option_field,  'visibility' ),
	            'source'	=>	array(
	            	'type'		=>	'function',
	            	'function'	=>	'cloudfw_admin_get_visibility_options'
	            ),
				'width'		=>	250,
			), // #### element: 0

		)

	),

	array(
		'type'		=>	'mini-section',
		'title'		=>	__('Content','cloudfw'),
		'data'		=>	array(


			## Module Item
			array(
				'type'      =>  'module',
				'title'     =>  __('Panel Content Title','cloudfw'),
				'data'      =>  array(

					## Element
					array(
						'type'      =>  'text',
						'id'        =>  cloudfw_sanitize( PFIX.'_'. $option_field .' title' ),
						'value'     =>  cloudfw_get_option( $option_field,  'title' ),
						'width'		=>	250,
					)

				)

			),


			## Module Item
			array(
				'type'      =>  'module',
				'title'     =>  __('Page for Panel Content','cloudfw'),
				'data'      =>  array(

					## Element
					array(
						'type'      =>  'page-selector',
						'id'        =>  cloudfw_sanitize( PFIX.'_'. $option_field .' page_id' ),
						'value'     =>  cloudfw_get_option( $option_field,  'page_id' ),
						'response'  =>  'ID',
						'hide_input'=>  true,
					)

				)

			),

		)

	),


	array(
		'type'		=>	'mini-section',
		'title'		=>	__('Handler Button','cloudfw'),
		'data'		=>	array(

			## Module Item
			array(
				'type'      =>  'module',
				'title'     =>  __('Button Position','cloudfw'),
				'data'      =>  array(

					## Element
					array(
						'type'      =>  'select',
						'id'        =>  cloudfw_sanitize( PFIX.'_'. $option_field .' position' ),
						'value'     =>  cloudfw_get_option( $option_field,  'position' ),
						'source'	=>	array(
							'NULL'		=>	__('Default','cloudfw'),
							'left'		=>	__('Bottom Left','cloudfw'),
							'right'		=>	__('Bottom Right','cloudfw'),
							'left top'	=>	__('Top Left','cloudfw'),
							'right top'	=>	__('Top Right','cloudfw'),
						),
						'width'		=>	250,

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
						'id'        =>  cloudfw_sanitize( PFIX.'_'. $option_field .' margin_top' ),
						'value'     =>  cloudfw_get_option( $option_field,  'margin_top' ),
						'width'		=>	50,
						'unit'		=>	__('px','cloudfw')
					), // #### element: 0

					## Element
					array(
						'type'		=>	'text',
						'id'        =>  cloudfw_sanitize( PFIX.'_'. $option_field .' margin_bottom' ),
						'value'     =>  cloudfw_get_option( $option_field,  'margin_bottom' ),
						'width'		=>	50,
						'unit'		=>	__('px','cloudfw')
					), // #### element: 0

				)

			),


			## Module Item
			array(
				'type'      =>  'module',
				'title'     =>  __('Button Style','cloudfw'),
				'data'      =>  array(

					## Element
					array(
						'type'		=>	'select',
						'id'        =>  cloudfw_sanitize( PFIX.'_'. $option_field .' button_style' ),
						'value'     =>  cloudfw_get_option( $option_field,  'button_style' ),
						'source'	=>	array(
							'type'		=>	'function',
							'function'	=>	'cloudfw_admin_loop_button_colors'
						),
						'width'		=>	250,
					), // #### element: 0

				)

			),

			## Module Item
			array(
				'type'      =>  'module',
				'title'     =>  __('Button Icon','cloudfw'),
				'data'      =>  array(

					## Element
					array(
						'type'      =>  'icon-selector',
						'id'        =>  cloudfw_sanitize( PFIX.'_'. $option_field .' icon' ),
						'value'     =>  cloudfw_get_option( $option_field,  'icon' ),
					)

				)

			),

		)

	),

);