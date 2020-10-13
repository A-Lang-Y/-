<?php

$option_field = $args[1]; 
$options = isset($args[2]) ? $args[2] : array();

return $scheme = array(
	array(
		'type'		=> 'module',
		'title'		=> __('Layout','cloudfw'),
		'data'		=> array(

			## Element
			array(
				'type'		=>	'select',
				'id'		=>	cloudfw_sanitize( PFIX.'_'. $option_field .' layout' ),
				'value'		=>	cloudfw_get_option( $option_field,  'layout' ),
				'source'	=>	array(
					'NULL' 				=> __('Classic Layout - Fullwidth Thumbnails','cloudfw'),
					'medium' 			=> __('Classic Layout - Medium Thumbnails','cloudfw'),
					'grid' 				=> __('Grid Layout','cloudfw'),
					'grid-masonry'		=> __('Grid Masonry Layout','cloudfw'),
				),
				'width'		=> 400,
			), // #### element: 0

		),
		'js' 		=> array(
			## Script Item
			array(
				'type' 			=> 'toggle',
				'related' 		=> $option_field,
				'conditions' 	=> array(
					array( 'val' => '', 'e' => '.'. $option_field .'-Standard, .'. $option_field .'-Standard-Fullwidth' ),
					array( 'val' => 'medium', 'e' => '.'. $option_field .'-Standard, .'. $option_field .'-Standard-Medium' ),
					array( 'val' => 'grid', 'e' => '.'. $option_field .'-Grid, .'. $option_field .'-Grid-Default' ),
					array( 'val' => 'grid-masonry', 'e' => '.'. $option_field .'-Grid, .'. $option_field .'-Grid-Masonry' ),
				)
			),

		)

	),

	array(
		'type'		=>	'module',
		'related'	=>	''. $option_field .' '. $option_field .'-Grid',
		'title'		=>	__('Columns','cloudfw'),
		'data'		=>	array(
			array(
				'type'		=>	'slider',
				'id'		=>	cloudfw_sanitize( PFIX.'_'. $option_field .' columns' ),
				'value'		=>	cloudfw_get_option( $option_field,  'columns' ),
				'class'		=>	'input_250',
				'min'		=>	1,
				'max'		=>	4,
				'unit'		=>	__('column(s)','cloudfw')
			)
		)
	), 


	array(
		'type'		=> 'module',
		'layout'	=> 'split',
		'title'		=> array(__('Thumbnail Image Aspect Ratio','cloudfw'), __('Video Aspect Ratio','cloudfw')),
		'data'		=> array(

			## Element
			array(
				'type'		=>	'select',
				'id'		=>	cloudfw_sanitize( PFIX.'_'. $option_field .' image_ratio' ),
				'value'		=>	cloudfw_get_option( $option_field,  'image_ratio', '16:9' ),
				'source'	=>	array(
					'type' 		=> 'function',
					'function'	=> 'cloudfw_admin_loop_aspect_ratio',
				),				
				'width'		=>  150,
			), // #### element: 0


			## Element
			array(
				'type'		=>	'select',
				'id'		=>	cloudfw_sanitize( PFIX.'_'. $option_field .' video_ratio' ),
				'value'		=>	cloudfw_get_option( $option_field,  'video_ratio', '16:9' ),
				'source'	=>	array(
					'type' 		=> 'function',
					'function'	=> 'cloudfw_admin_loop_aspect_ratio',
				),				
				'width'		=>  150,
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
				'id'		=>	cloudfw_sanitize( PFIX.'_'. $option_field .' title_size' ),
				'value'		=>	cloudfw_get_option( $option_field,  'title_size' ),
				'ui'		=>	true,
				'main_class'=>  'input input_250',
				'source'	=>	array(
					'NULL'		=> __('Default','cloudfw'),
					'h1'		=> 'H1',
					'h2'			=> 'H2',
					'h3'		=> 'H3',
					'h4'		=> 'H4',
					'h5'		=> 'H5',
					'h6'		=> 'H6',
				)

			), // #### element: 0

		)

	),


	array(
		'type'		=> 'mini-section',
		'related'	=>	''. $option_field .' '. $option_field .'-Standard',
		'title'		=> __('Blog Metas','cloudfw'),
		'data'		=> array(

			array(
				'type'		=>	'module',
				'layout'	=>	'split',
				'title'		=>	array(__('Author','cloudfw'), __('Date','cloudfw')),
				'data'		=>	array(
					array(
						'type'		=>	'onoff',
						'id'		=>	cloudfw_sanitize( PFIX.'_'. $option_field .' meta_author' ),
						'value'		=>	cloudfw_get_option( $option_field,  'meta_author' ),
					),

					array(
						'type'		=>	'onoff',
						'id'		=>	cloudfw_sanitize( PFIX.'_'. $option_field .' meta_date' ),
						'value'		=>	cloudfw_get_option( $option_field,  'meta_date' ),
					)
				)
			),

			array(
				'type'		=>	'module',
				'layout'	=>	'split',
				'title'		=>	array(__('Category','cloudfw'), __('Comments Count','cloudfw')),
				'data'		=>	array(
					array(
						'type'		=>	'onoff',
						'id'		=>	cloudfw_sanitize( PFIX.'_'. $option_field .' meta_category' ),
						'value'		=>	cloudfw_get_option( $option_field,  'meta_category' ),
					),

					array(
						'type'		=>	'onoff',
						'id'		=>	cloudfw_sanitize( PFIX.'_'. $option_field .' meta_comment' ),
						'value'		=>	cloudfw_get_option( $option_field,  'meta_comment' ),
					)
				)
			),

			array(
				'type'		=>	'module',
				'title'		=>	__('Likes','cloudfw'),
				'data'		=>	array(
					array(
						'type'		=>	'onoff',
						'id'		=>	cloudfw_sanitize( PFIX.'_'. $option_field .' meta_likes' ),
						'value'		=>	cloudfw_get_option( $option_field,  'meta_likes' ),
					)
				)
			),

		)

	),

	array(
		'type'		=> 'mini-section',
		'related'	=>	''. $option_field .' '. $option_field .'-Standard',
		'title'		=> __('List Style','cloudfw'),
		'data'		=> array(

			array(
				'type'		=>	'module',
				'title'		=>	__('List Style','cloudfw'),
				'data'		=>	array(
					array(
						'type'		=>	'select',
						'id'		=>	cloudfw_sanitize( PFIX.'_'. $option_field .' list_style' ),
						'value'		=>	cloudfw_get_option( $option_field,  'list_style' ),
						'source'	=>	array(
							'type'		=>	'function',
							'function'	=>	'cloudfw_admin_loop_blog_list_styles'
						),
						'width'		=>	250,
					)
				)
				
			),

		)

	),

	array(
		'type'		=> 'mini-section',
		'title'		=> __('Excerpt','cloudfw'),
		'data'		=> array(

			array(
				'type'		=>	'module',
				'title'		=>	__('Show Post Excerpt','cloudfw'),
				'data'		=>	array(
					array(
						'type'		=>	'onoff',
						'id'		=>	cloudfw_sanitize( PFIX.'_'. $option_field .' excerpt' ),
						'value'		=>	cloudfw_get_option( $option_field,  'excerpt' ),
					)
				)
				
			),

			array(
				'type'		=>	'module',
				'title'		=>	__('Excerpt Length','cloudfw'),
				'data'		=>	array(
					array(
						'type'		=>	'text',
						'id'		=>	cloudfw_sanitize( PFIX.'_'. $option_field .' excerpt_length' ),
						'value'		=>	cloudfw_get_option( $option_field,  'excerpt_length' ),
						'width'		=>	50,
						'unit'		=>	__('words','cloudfw')

					)
				)

			),

		)

	),

);