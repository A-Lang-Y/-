<?php

return array(
	
		array(
			'type'      => 'module',
			'title'     => __('Visibility','cloudfw'),
			'data'      => array(

				## Element
				array(
					'type'      =>  'select',
					'id'        =>  'the_device',
					'value'     =>  $that->get_value('the_device'),
					'source'    =>  array(
						'type'      =>  'function',
						'function'  =>  'cloudfw_admin_get_visibility_options'
					),
					'width'     =>  250,
				), // #### element: 0

			)

		),


		array(
			'type'      =>  'module',
			'title'     =>  __('Columns','cloudfw'),
			'data'      =>  array(
				array(
					'type'      =>  'slider',
					'id'        =>  $that->get_field_name('gallery_columns'),
					'value'     =>  $that->get_value('gallery_columns', '3'),
					'min'       =>  1,
					'max'       =>  12,
					'step'      =>  1,
					'width'     =>  '250',
					'unit'      =>  __('column(s)','cloudfw'),
				)
			),
		),

		array(
			'type'      =>  'module',
			'title'     =>  array(__('Custom Thumbnail Width','cloudfw'), __('Custom Thumbnail Height','cloudfw')),
			'layout'    =>  'split',
			'data'      =>  array(
	
				## Element
				array(
					'type'      =>  'text',
					'id'        =>  $that->get_field_name('gallery_width'),
					'value'     =>  $that->get_value('gallery_width'),
					'width'     =>  70,
				),
	
				## Element
				array(
					'type'      =>  'text',
					'id'        =>  $that->get_field_name('gallery_height'),
					'value'     =>  $that->get_value('gallery_height'),
					'width'     =>  70,
				),

			)

		),

		array(
			'type'      =>  'module',
			'title'     =>  __('Carousel Gallery?','cloudfw'),
			'data'      =>  array(
				array(
					'type'      =>  'onoff',
					'id'        =>  $that->get_field_name('gallery_carousel'),
					'value'     =>  $that->get_value('gallery_carousel', 'FALSE'),
				)
			),
		),

		array(
			'type'      =>  'module',
			'title'     =>  __('Enable Lightbox?','cloudfw'),
			'data'      =>  array(
				array(
					'type'      =>  'onoff',
					'id'        =>  $that->get_field_name('gallery_lightbox'),
					'value'     =>  $that->get_value('gallery_lightbox', true),
				)
			),
		),


		array(
			'type'      =>  'module',
			'layout'    =>  'raw',
			'data'      =>  array(


				array(
					'type'      =>  'sorting',
					'id'        =>  'gallery',
					'item:id'   =>  'gallery_clone',
					'axis'      =>  'both',
					'data'      => 

						cloudfw_core_loop_multi_option( 
							
							array(
								'start'     => 5,
								'indicator' => $that->get_value('indicator'),
								'dummy'     => true,
								'data'      => 


									array(
										'type'      =>  'gallery',
										'class'     =>  'gallery_clone_class',
										'sync'      =>  $that->get_field_name('gallery_image'),
										'data'      =>  array(
						
											## Module Item
											array(
												'type'      =>  'remove',
											),

											## Module Item
											array(
												'type'      =>  'indicator',
												'id'        =>  $that->get_field_name('indicator'),
											),

											## Module Item
											array(
												'type'      =>  'module',
												'title'     =>  __('Image','cloudfw'),
												'data'      =>  array(

													## Element
													array(
														'type'      =>  'upload',
														'id'        =>  $that->get_field_name('gallery_image'),
														'value'     =>  $that->get_value('gallery_image'),
														'reset'     =>  '',
														'brackets'  =>  true,
														'store'     =>  true,
														'removable' =>  true,
														'library'   =>  true,

													),
												)

											),

											## Module Item
											array(
												'type'      =>  'module',
												'title'     =>  __('Custom Link','cloudfw'),
												'data'      =>  array(

													## Element
													array(
														'type'      =>  'page-selector',
														'id'        =>  $that->get_field_name('gallery_link'),
														'value'     =>  $that->get_value('gallery_link'),
														'reset'     =>  '',
														'_class'    =>  'input_150',
														'brackets'  =>  true,

													),

												)

											),

											array(
												'type'      =>  'module',
												'title'     =>  __('Title for Lightbox','cloudfw'),
												'data'      =>  array(

													## Element
													array(
														'type'      =>  'text',
														'id'        =>  $that->get_field_name('gallery_title'),
														'value'     =>  $that->get_value('gallery_title'),
														'width'     =>  400,
														'reset'     =>  '',
														'brackets'  =>  true,


													),

												)

											),

											array(
												'type'      =>  'module',
												'title'     =>  __('Description for Lightbox','cloudfw'),
												'data'      =>  array(

													## Element
													array(
														'type'      =>  'textarea',
														'id'        =>  $that->get_field_name('gallery_desc'),
														'value'     =>  $that->get_value('gallery_desc'),
														'width'     =>  400,
														'line'      =>  2,
														'reset'     =>  '',
														'brackets'  =>  true,


													),

												)

											),

										)

									),

							)

						)

				),

				## Element
				array(
					'type'      =>  'html',
					'data'      =>  '
						<a data-target="" class="cloudfw-action-duplicate cloudfw-ui-button cloudfw-ui-button-metro cloudfw-ui-button-metro-green" href="javascript:;" style="margin-bottom: 5px;"><span>'.__('+ Add New Gallery Item','cloudfw').'</span></a>
						<a data-target="" class="cloudfw-action-gallery-from-library cloudfw-ui-button cloudfw-ui-button-metro cloudfw-ui-button-metro-grey" href="javascript:;"><span>'.__('Insert from Media Library','cloudfw').'</span></a>
					',
				), // #### element: 0

			)
		
		),

);