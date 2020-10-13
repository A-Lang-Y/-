<?php

$option_field = $args[1];
$options = isset($args[2]) ? $args[2] : array();

$args = array(
	'type'                     => 'post',
	'child_of'                 => 0,
	'parent'                   => '',
	'orderby'                  => 'name',
	'order'                    => 'ASC',
	'hide_empty'               => 1,
	'hierarchical'             => 0,
	'taxonomy'                 => 'category',
	'pad_counts'               => false
);

$categories = get_categories( $args );

/*echo '<pre>';
 print_r($categories);
echo '</pre>';*/

return $scheme = array(

	array(
		'type'      =>  'sorting',
		'id'        =>  'category_options_sorting',
		'data'      =>

			cloudfw_core_loop_multi_option(
			array(
			'indicator' => cloudfw_get_option('category_options', 'indicator'),
			'data'      =>
				array(
					'type'      =>  'module-set',
					'title'     =>  '<span class="category-option-title"></span>',
					'closable'  =>  true,
					'state'     =>  'closed',
					'title_right'=> '
						<a class="small-button small-grey cloudfw-action-only-duplicate" href="javascript:;"><span>'.__('Duplicate','cloudfw').'</span></a>
						<a class="small-button small-grey cloudfw-action-remove" data-target="li" href="javascript:;"><span>'.__('Delete','cloudfw').'</span></a>
					',
					'data'      =>  array(

						## Module Item
						array(
							'type'      =>  'module',
							'title'     =>  __('Category','cloudfw'),
							'data'      =>  array(
								## Element
								array(
									'type'      =>  'select',
									'id'        =>  cloudfw_sanitize(PFIX.'_category_options indicator'),
									'value'     =>  cloudfw_get_option('category_options', 'indicator'),
									'source'    =>  array(
										'type'      =>  'function',
										'function'  =>  'cloudfw_admin_loop_terms',
										'vars'      =>  array('category', __('Select category','cloudfw'), '%s')
									),
									'reset'     =>  '',
									'width'     =>  300,
									'brackets'  =>  true

								), // #### element: 0

							)

						),
						array(
							'type'      =>  'mini-section',
							'title'     =>  __('Category Page Options','cloudfw'),
							'data'      =>  array(


								array(
									'type'		=> 'module',
									'title'		=>	__('Page Layout','cloudfw'),
									'data'		=> array(

										## Element
										array(
											'type'		=>	'select',
											'id'		=>	cloudfw_sanitize(PFIX.'_category_options layout' ),
											'value'		=>	cloudfw_get_option( 'category_options', 'layout' ),
											'source'	=>	array(
												'type'		=>	'function',
												'function'	=>	'cloudfw_admin_loop_page_templates',
											),
											'width'		=>	250,
											'reset'		=>	'',
											'brackets'	=>	true,
										)

									)

								),


								array(
									'type'		=> 'module',
									'title'		=>	__('Sidebar','cloudfw'),
									'data'		=> array(

							            ## Element
							            array(
							                'type'      =>  'select',
											'id'		=>	cloudfw_sanitize(PFIX.'_category_options sidebar' ),
											'value'		=>	cloudfw_get_option( 'category_options',  'sidebar' ),
							                'source'    =>  array(
							                    'type'      =>  'function',
							                    'function'  =>  'cloudfw_admin_loop_custom_sidebars'
							                ),
							                'width'     =>  400,
											'reset'		=>	'',
											'brackets'	=>	true,
							            ), // #### element: 0

									)

								),

								array(
									'type'		=> 'module',
									'title'		=>	__('Page Skin','cloudfw'),
									'data'		=> array(

							            ## Element
							            array(
							                'type'      =>  'select',
											'id'		=>	cloudfw_sanitize(PFIX.'_category_options skin' ),
											'value'		=>	cloudfw_get_option( 'category_options',  'skin' ),
							                'source'    =>  array(
							                    'type'          => 'function',
							                    'function'      => 'cloudfw_module_admin_gel_all_skins_array',
												'send_data'	=>	true,
												'send_args'	=>	true,
							                ),
							                'ui'        =>  true,
							                'main_class'=>  'input input_400',
											'reset'		=>	'',
											'brackets'	=>	true,
							            )

									)

								),

								array(
									'type'		=> 'module',
									'title'		=>	__('Title Bar Style','cloudfw'),
									'data'		=> array(

							            ## Element
							            array(
							                'type'      =>  'select',
											'id'		=>	cloudfw_sanitize(PFIX.'_category_options titlebar_style' ),
											'value'		=>	cloudfw_get_option( 'category_options',  'titlebar_style' ),
							                'source'    =>  array(
							                    'type'          => 'function',
							                    'function'      => 'cloudfw_admin_loop_titlebar_styles',
							                ),
							                'ui'        =>  true,
							                'main_class'=>  'input input_300',
											'reset'		=>	'',
											'brackets'	=>	true,
							            )

									)

								),

								array(
									'type'      => 'module',
									'title'     => __('Titlebar Heading','cloudfw'),
									'data'      => array(

										## Element
										array(
											'type'      =>  'text',
											'id'        =>  cloudfw_sanitize(PFIX.'_category_options titlebar_title'),
											'value'     =>  cloudfw_get_option('category_options', 'titlebar_title'),
											'reset'     =>  '',
											'width'     =>  400,
											'brackets'  =>  true
										), // #### element: 0

									)

								),

								array(
									'type'      => 'module',
									'title'     => __('Titlebar Description','cloudfw'),
									'data'      => array(

										## Element
										array(
											'type'      =>  'textarea',
											'id'        =>  cloudfw_sanitize(PFIX.'_category_options titlebar_desc'),
											'value'     =>  cloudfw_get_option('category_options', 'titlebar_desc'),
											'reset'     =>  '',
											'width'     =>  400,
											'line'      =>  2,
											'brackets'  =>  true
										), // #### element: 0

									)

								),

							)
						),

						array(
							'type'      =>  'mini-section',
							'title'     =>  __('Category Posts Lists','cloudfw'),
							'data'      =>  array(

								array(
									'type'      => 'module',
									'title'     => __('Layout','cloudfw'),
									'data'      => array(

										## Element
										array(
											'type'      =>  'select',
											'id'        =>  cloudfw_sanitize(PFIX.'_category_options post_list_layout'),
											'value'     =>  cloudfw_get_option('category_options', 'post_list_layout'),
											'source'    =>  array(
												'NULL'              => __('Use Global Layout','cloudfw'),
												'standard'          => __('Classic Layout - Fullwidth Thumbnails','cloudfw'),
												'medium'            => __('Classic Layout - Medium Thumbnails','cloudfw'),
												'grid'              => __('Grid Layout','cloudfw'),
												'grid-masonry'      => __('Grid Masonry Layout','cloudfw'),
											),
											'reset'     =>  '',
											'width'     =>  400,
											'brackets'  =>  true
										), // #### element: 0

									)

								),

							)

						),





						array(
							'type'		=>	'module',
							'title'		=>	__('Columns','cloudfw'),
							'data'		=>	array(
								array(
									'type'		=>	'slider',
									'id'		=>	cloudfw_sanitize( PFIX.'_category_options columns' ),
									'value'		=>	cloudfw_get_option( 'category_options',  'columns' ),
									'class'		=>	'input_250',
									'min'		=>	1,
									'max'		=>	4,
									'unit'		=>	__('column(s)','cloudfw'),
									'reset'		=>	'',
									'brackets'	=>	true,
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
									'id'		=>	cloudfw_sanitize( PFIX.'_category_options image_ratio' ),
									'value'		=>	cloudfw_get_option( 'category_options',  'image_ratio' ),
									'source'	=>	array(
										'type' 		=> 'function',
										'function'	=> 'cloudfw_admin_loop_aspect_ratio',
									),
									'width'		=>  150,
									'reset'		=>	'',
									'brackets'	=>	true,
								), // #### element: 0


								## Element
								array(
									'type'		=>	'select',
									'id'		=>	cloudfw_sanitize( PFIX.'_category_options video_ratio' ),
									'value'		=>	cloudfw_get_option( 'category_options',  'video_ratio' ),
									'source'	=>	array(
										'type' 		=> 'function',
										'function'	=> 'cloudfw_admin_loop_aspect_ratio',
									),
									'width'		=>  150,
									'reset'		=>	'',
									'brackets'	=>	true,
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
									'id'		=>	cloudfw_sanitize( PFIX.'_category_options title_size' ),
									'value'		=>	cloudfw_get_option( 'category_options',  'title_size' ),
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
									),
									'reset'		=>	'',
									'brackets'	=>	true,

								), // #### element: 0

							)

						),


						array(
							'type'		=> 'mini-section',
							'title'		=> __('Blog Metas','cloudfw'),
							'data'		=> array(

								array(
									'type'		=>	'module',
									'layout'	=>	'split',
									'title'		=>	array(__('Author','cloudfw'), __('Date','cloudfw')),
									'data'		=>	array(
										array(
											'type'		=>	'select',
											'id'		=>	cloudfw_sanitize( PFIX.'_category_options meta_author' ),
											'value'		=>	cloudfw_get_option( 'category_options',  'meta_author' ),
											'source'	=>	array(
												'true'		=>	__('Show','cloudfw'),
												'false'		=>	__('Hide','cloudfw'),
											),
											'reset'		=>	'',
											'brackets'	=>	true,
											'width'		=>	150,
										),

										array(
											'type'		=>	'select',
											'id'		=>	cloudfw_sanitize( PFIX.'_category_options meta_date' ),
											'value'		=>	cloudfw_get_option( 'category_options',  'meta_date' ),
											'source'	=>	array(
												'true'		=>	__('Show','cloudfw'),
												'false'		=>	__('Hide','cloudfw'),
											),
											'reset'		=>	'',
											'brackets'	=>	true,
											'width'		=>	150,
										)
									),
								),

								array(
									'type'		=>	'module',
									'layout'	=>	'split',
									'title'		=>	array(__('Category','cloudfw'), __('Comments Count','cloudfw')),
									'data'		=>	array(
										array(
											'type'		=>	'select',
											'id'		=>	cloudfw_sanitize( PFIX.'_category_options meta_category' ),
											'value'		=>	cloudfw_get_option( 'category_options',  'meta_category' ),
											'source'	=>	array(
												'true'		=>	__('Show','cloudfw'),
												'false'		=>	__('Hide','cloudfw'),
											),
											'reset'		=>	'',
											'brackets'	=>	true,
											'width'		=>	150,
										),

										array(
											'type'		=>	'select',
											'id'		=>	cloudfw_sanitize( PFIX.'_category_options meta_comment' ),
											'value'		=>	cloudfw_get_option( 'category_options',  'meta_comment' ),
											'source'	=>	array(
												'true'		=>	__('Show','cloudfw'),
												'false'		=>	__('Hide','cloudfw'),
											),
											'reset'		=>	'',
											'brackets'	=>	true,
											'width'		=>	150,
										)
									)
								),

								array(
									'type'		=>	'module',
									'title'		=>	__('Likes','cloudfw'),
									'data'		=>	array(
										array(
											'type'		=>	'select',
											'id'		=>	cloudfw_sanitize( PFIX.'_category_options meta_likes' ),
											'value'		=>	cloudfw_get_option( 'category_options',  'meta_likes' ),
											'source'	=>	array(
												'true'		=>	__('Show','cloudfw'),
												'false'		=>	__('Hide','cloudfw'),
											),
											'reset'		=>	'',
											'brackets'	=>	true,
											'width'		=>	150,
										)
									)
								),

							)

						),

						array(
							'type'		=> 'mini-section',
							'title'		=> __('List Style','cloudfw'),
							'data'		=> array(

								array(
									'type'		=>	'module',
									'title'		=>	__('List Style','cloudfw'),
									'data'		=>	array(
										array(
											'type'		=>	'select',
											'id'		=>	cloudfw_sanitize( PFIX.'_category_options list_style' ),
											'value'		=>	cloudfw_get_option( 'category_options',  'list_style' ),
											'source'	=>	array(
												'type'		=>	'function',
												'function'	=>	'cloudfw_admin_loop_blog_list_styles'
											),
											'width'		=>	250,
											'reset'		=>	'',
											'brackets'	=>	true,
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
									'title'		=>	__('Post Excerpt','cloudfw'),
									'data'		=>	array(
										array(
											'type'		=>	'select',
											'id'		=>	cloudfw_sanitize( PFIX.'_category_options excerpt' ),
											'value'		=>	cloudfw_get_option( 'category_options',  'excerpt' ),
											'source'	=>	array(
												'true'		=>	__('Show','cloudfw'),
												'false'		=>	__('Hide','cloudfw'),
											),
											'reset'		=>	'',
											'brackets'	=>	true,
											'width'		=>	150,
										)

									)

								),

								array(
									'type'		=>	'module',
									'title'		=>	__('Excerpt Length','cloudfw'),
									'data'		=>	array(
										array(
											'type'		=>	'text',
											'id'		=>	cloudfw_sanitize( PFIX.'_category_options excerpt_length' ),
											'value'		=>	cloudfw_get_option( 'category_options',  'excerpt_length' ),
											'width'		=>	50,
											'unit'		=>	__('words','cloudfw'),
											'reset'		=>	'',
											'brackets'	=>	true,

										)
									)

								),

							)

						),






					)

				),

			)

		),

	),


	## Module Item
	array(
		'type'      =>  'module',
		'layout'    =>  'raw',
		'divider'   =>  false,
		'data'      =>  array(

			## Element
			array(
				'type'      =>  'html',
				'data'      =>  '<a data-target="#category_options_sorting" class="cloudfw-action-duplicate cloudfw-ui-button cloudfw-ui-button-metro cloudfw-ui-button-metro-green" href="javascript:;"><span>'.__('+ Add New Specific Category Options','cloudfw').'</span></a>',
			), // #### element: 0

		)
	),

	array(
		'type'      => 'jquery',
		'data'      => '

			/** Add event listener for font titles */
			jQuery(document).delegate("[name=\''. cloudfw_sanitize(PFIX.'_category_options indicator') .'[]\']", "change" ,function(e){
				var element     = jQuery(this),
					container   = element.parents(".module-set"),
					title       = container.find(".category-option-title"),
					value       = element.find("option:selected").text();

				title.html( value );

			});

			jQuery("[name=\''. cloudfw_sanitize(PFIX.'_category_options indicator') .'[]\']").change();

		'
	),

);

return $schemes;