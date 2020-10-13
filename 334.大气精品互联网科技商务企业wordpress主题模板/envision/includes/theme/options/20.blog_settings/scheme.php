<?php

$scheme[ cloudfw_id_for_sequence( $scheme, $number ) ] = array(
	'type'		=> 'page',
	'page' 		=> 'system',
	'system'	=> array(
		'page_title' 	=>	__('Blog Settings','cloudfw'),
		'page_nice_title'=>	__('blog','cloudfw'),
		'page_slug' 	=>	'blog',
		'page_css_id' 	=>	'cloud_nav_blog',
	),
	'form'		=>	array(
		'enable'	=> true,
		'ajax'		=> true,
		'shortcut'	=> true,
	),
	'data'	=> array(
	
		## Tab Item
		array(
			'type'		=>	'vertical_tabs',
			'tab_id'	=>	'blog_general',
			'tab_title'	=>	__('Blog General','cloudfw'),
			'data'		=>	array(
				
				## Container Item
				array(
					'type'		=>	'container',
					'footer'	=>	false,
					'title'		=>	__('Blog General','cloudfw'),
					'data'		=>	array(
					

						array(
							'type'		=> 'module',
							'title'		=>	__('Blog Page for the BreadCrumbs Trailer','cloudfw'),
							'data'		=> array(

								## Element
								array(
									'type'		=>	'page-selector',
									'id'		=>	cloudfw_sanitize( PFIX.'_blog page' ),
									'value'		=>	cloudfw_get_option( 'blog',  'page' ),
									'response'	=>	'ID',
									'hide_input'=>	true,
								)

							)

						),

					)

				),

				## Container Item
				array(
					'type'		=>	'container',
					'footer'	=>	false,
					'title'		=>	__('Blog Lists Layout Options','cloudfw'),
					'data'		=>	array(
					

						array(
							'type'		=>	'mini-section',
							'title'		=>	__('Mini Layout','cloudfw'),
							'data'		=>	array(

								## Module Item
								array(
									'type'      =>  'module',
									'title'     =>  __('Mini Layout Button Color','cloudfw'),
									'data'      =>  array(

										## Element
										array(
											'type'		=>	'select',
											'id'		=>	cloudfw_sanitize( PFIX.'_blog_template_mini button_color' ),
											'value'		=>	cloudfw_get_option( 'blog_template_mini',  'button_color' ),
											'source'	=>	array(
												'type'		=>	'function',
												'function'	=>	'cloudfw_admin_loop_button_colors',
												'prepend'	=>	__('Default','cloudfw'),
											),
											'width'		=>	250,
										), // #### element: 0

									)

								),


						)

					),

					)

				),

				array(
					'type'		=>	'submit',
					'layout'	=>	'fixed',
					'nomargin'	=> 	true
				), 

			)

		),
	
		## Tab Item
		array(
			'type'		=>	'vertical_tabs',
			'tab_id'	=>	'blog_main',
			'tab_title'	=>	__('Main Blog Page','cloudfw'),
			'data'		=>	array(
			
				## Container Item
				array(
					'type'		=>	'container',
					'footer'	=>	false,
					'title'		=>	__('Main Blog Page','cloudfw'),
					'data'		=>	array(


						array(
							'type'		=>	'global-scheme',
							'scheme'	=>	'blog_settings',
							'vars'		=>	array( 'blog_page' )
						),

					)

				),

				array(
					'type'		=>	'submit',
					'layout'	=>	'fixed',
					'nomargin'	=> 	true
				), 

			)

		),

		## Tab Item
		array(
			'type'		=>	'vertical_tabs',
			'tab_id'	=>	'blog_single',
			'tab_title'	=>	__('Single Blog Pages','cloudfw'),
			'data'		=>	array(
				
				## Container Item
				array(
					'type'		=>	'container',
					'footer'	=>	false,
					'title'		=>	__('Single Blog Pages','cloudfw'),
					'data'		=>	array(
					
						array(
							'type'		=>	'global-scheme',
							'scheme'	=>	'page_settings',
							'vars'		=>	array( 'blog_single' )
						),

						array(
							'type'		=> 'module',
							'title'		=>	__('Display Featured Images on Single Blog Post Pages?','cloudfw'),
							'data'		=> array(

								## Element
								array(
									'type'      =>  'select',
									'id'		=>	cloudfw_sanitize( PFIX.'_blog_single display_featured' ),
									'value'		=>	cloudfw_get_option( 'blog_single',  'display_featured' ),
									'source'    =>  array(
										'NULL'      =>  __('Default','cloudfw'),
										'show'      =>  __('Display','cloudfw'),
										'hide'      =>  __('Don\'t Display','cloudfw'),
									),
									'class'     =>  'select',
									'width'     =>  300,
							   ), // #### element: 0


							)

						),

						array(
							'type'		=> 'module',
							'title'		=>	__('Display Post Title on Single Blog Post Pages?','cloudfw'),
							'data'		=> array(

								## Element
								array(
									'type'      =>  'select',
									'id'		=>	cloudfw_sanitize( PFIX.'_blog_single display_title' ),
									'value'		=>	cloudfw_get_option( 'blog_single',  'display_title' ),
									'source'    =>  array(
										'NULL'      =>  __('Default','cloudfw'),
										'show'      =>  __('Display','cloudfw'),
										'hide'      =>  __('Don\'t Display','cloudfw'),
									),
									'class'     =>  'select',
									'width'     =>  300,
							   ), // #### element: 0


							)

						),

						array(
							'type'		=> 'module',
							'title'		=>	__('Title Element on Single Blog Post Pages','cloudfw'),
							'data'		=> array(

								## Element
								array(
									'type'      =>  'select',
									'id'		=>	cloudfw_sanitize( PFIX.'_blog_single title_element' ),
									'value'		=>	cloudfw_get_option( 'blog_single',  'title_element' ),
									'source'	=>	array(
										'NULL'		=> __('Default','cloudfw'),
										'h1'		=> 'H1',
										'h2'			=> 'H2',
										'h3'		=> 'H3',
										'h4'		=> 'H4',
										'h5'		=> 'H5',
										'h6'		=> 'H6',
									),
									'class'     =>  'select',
									'width'     =>  300,
							   ), // #### element: 0


							)

						),



					)

				),
				
				## Container Item
				array(
					'type'		=>	'container',
					'footer'	=>	false,
					'title'		=>	__('Metas','cloudfw'),
					'data'		=>	array(
					

						array(
							'type'		=> 'module',
							'title'		=>	__('Display post date on single blog pages?','cloudfw'),
							'data'		=> array(

								## Element
								array(
									'type'		=>	'onoff',
									'id'		=>	cloudfw_sanitize( PFIX.'_blog_single_metas date' ),
									'value'		=>	cloudfw_get_option( 'blog_single_metas',  'date' ),
								)

							)

						),

						array(
							'type'		=> 'module',
							'title'		=>	__('Display post categories on single blog pages?','cloudfw'),
							'data'		=> array(

								## Element
								array(
									'type'		=>	'onoff',
									'id'		=>	cloudfw_sanitize( PFIX.'_blog_single_metas category' ),
									'value'		=>	cloudfw_get_option( 'blog_single_metas',  'category' ),
								)

							)

						),


					)

				),

				## Container Item
				array(
					'type'		=>	'container',
					'footer'	=>	false,
					'title'		=>	__('Social Services','cloudfw'),
					'data'		=>	array(
					

						array(
							'type'		=> 'module',
							'title'		=>	__('Display share the post widget on single blog pages?','cloudfw'),
							'data'		=> array(

								## Element
								array(
									'type'		=>	'onoff',
									'id'		=>	cloudfw_sanitize( PFIX.'_blog_single_share enable' ),
									'value'		=>	cloudfw_get_option( 'blog_single_share',  'enable' ),
								)

							)

						),

						array(
							'type'		=> 'module',
							'title'		=>	__('Active Sharing Services','cloudfw'),
							'data'		=> array(

									## Element
									array(
										'type'		=>	'select',
										'id'		=>	cloudfw_sanitize( PFIX.'_blog_single_share services' ),
										'value'		=>	cloudfw_get_option( 'blog_single_share',  'services' ),
										'main_class'=>  'input input_250',
										'source'	=>	array(
											'type'		=>	'function',
											'function'	=>	'cloudfw_sharrre_services'
										),
										'multiple'	=>	true,
										'brackets'	=>	true,
										'height'	=>	200,
									), // #### element: 0

							)

						),




					)

				),


				## Container Item
				array(
					'type'		=>	'container',
					'footer'	=>	false,
					'title'		=>	__('Like this post! Widget','cloudfw'),
					'data'		=>	array(
					

						array(
							'type'		=> 'module',
							'title'		=>	__('Display the "Like this post!" widget on single blog pages?','cloudfw'),
							'data'		=> array(

								## Element
								array(
									'type'		=>	'onoff',
									'id'		=>	cloudfw_sanitize( PFIX.'_blog_single_like enable' ),
									'value'		=>	cloudfw_get_option( 'blog_single_like',  'enable' ),
								)

							)

						),


					)

				),

				## Container Item
				array(
					'type'		=>	'container',
					'footer'	=>	false,
					'title'		=>	__('Author Bio','cloudfw'),
					'data'		=>	array(
					

						array(
							'type'		=> 'module',
							'title'		=>	__('Display the author on single blog pages?','cloudfw'),
							'data'		=> array(

								## Element
								array(
									'type'		=>	'onoff',
									'id'		=>	cloudfw_sanitize( PFIX.'_blog_single_author enable' ),
									'value'		=>	cloudfw_get_option( 'blog_single_author',  'enable' ),
								)

							)

						),


					)

				),

				## Container Item
				array(
					'type'		=>	'container',
					'footer'	=>	false,
					'title'		=>	__('Comments','cloudfw'),
					'data'		=>	array(
					

						array(
							'type'		=> 'module',
							'title'		=>	__('Show comments on single blog pages?','cloudfw'),
							'data'		=> array(

								## Element
								array(
									'type'		=>	'onoff',
									'id'		=>	cloudfw_sanitize( PFIX.'_blog_single_comments enable' ),
									'value'		=>	cloudfw_get_option( 'blog_single_comments',  'enable' ),
								)

							)

						),


					)

				),

				## Container Item
				array(
					'type'		=>	'container',
					'footer'	=>	false,
					'title'		=>	__('Related Blog Posts','cloudfw'),
					'data'		=>	array(
					

						array(
							'type'		=> 'module',
							'title'		=>	__('Display related blog posts on single blog pages?','cloudfw'),
							'data'		=> array(

								## Element
								array(
									'type'		=>	'onoff',
									'id'		=>	cloudfw_sanitize( PFIX.'_blog_single_related enable' ),
									'value'		=>	cloudfw_get_option( 'blog_single_related',  'enable' ),
								),

							)

						),

						array(
							'type'		=> 'module',
							'title'		=>	__('Columns','cloudfw'),
							'data'		=> array(

								## Element
								array(
									'type'		=>	'select',
									'id'		=>	cloudfw_sanitize( PFIX.'_blog_single_related columns' ),
									'value'		=>	cloudfw_get_option( 'blog_single_related',  'columns' ),
									'source'	=>	array(
										'type'		=>	'function',
										'function'	=>	'cloudfw_admin_loop_columns',
									),
									'width'		=>	250,
								)

							)

						),

						array(
							'type'		=> 'module',
							'title'		=>	__('Post Limit','cloudfw'),
							'data'		=> array(

								## Element
								array(
									'type'		=>	'text',
									'id'		=>	cloudfw_sanitize( PFIX.'_blog_single_related limit' ),
									'value'		=>	cloudfw_get_option( 'blog_single_related',  'limit' ),
									'width'		=>	70,
								)

							)

						),



						array(
							'type'		=> 'module',
							'title'		=> __('Title Size','cloudfw'),
							'data'		=> array(

								## Element
								array(
									'type'		=>	'select',
									'id'		=>	cloudfw_sanitize( PFIX.'_blog_single_related title_element' ),
									'value'		=>	cloudfw_get_option( 'blog_single_related',  'title_element' ),
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

					)

				),

				## Container Item
				array(
					'type'		=>	'container',
					'footer'	=>	false,
					'title'		=>	__('Blog Posts Navigation','cloudfw'),
					'data'		=>	array(
					

						array(
							'type'		=> 'module',
							'title'		=>	__('Blog Post Navigation Position','cloudfw'),
							'data'		=> array(

								## Element
								array(
									'type'		=>	'select',
									'id'		=>	cloudfw_sanitize( PFIX.'_blog_single_navigation position' ),
									'value'		=>	cloudfw_get_option( 'blog_single_navigation',  'position' ),
									'source'	=>	array(
										'none'		=>	__('Don\'t show the post navigation','cloudfw'),
										'both'		=>	__('The Top & Bottom of Posts','cloudfw'),
										'top'		=>	__('The Top of Post','cloudfw'),
										'bottom'	=>	__('The Bottom of Posts','cloudfw'),
									),
									'width'		=> 400,

								)

							)

						),


					)

				),

				array(
					'type'		=>	'submit',
					'layout'	=>	'fixed',
					'nomargin'	=> 	true
				), 

			)

		),

		## Tab Item
		array(
			'type'		=>	'vertical_tabs',
			'tab_id'	=>	'blog_category',
			'tab_title'	=>	__('Blog Category & Tag Pages','cloudfw'),
			'data'		=>	array(
			
				## Container Item
				array(
					'type'		=>	'container',
					'footer'	=>	false,
					'title'		=>	__('Blog Category & Tag Pages','cloudfw'),
					'data'		=>	array(

						array(
							'type'		=>	'global-scheme',
							'scheme'	=>	'page_settings',
							'vars'		=>	array( 'blog_category_page', array(
								'layout' 		 => 'page_layout',
								'sidebar' 		 => 'page_sidebar',
								'titlebar_style' => 'page_titlebar_style',
								'skin' 			 => 'page_skin',
							) )
						),

					)

				),

				## Container Item
				array(
					'type'		=>	'container',
					'footer'	=>	false,
					'title'		=>	__('Blog Post Lists in Category & Tag Pages','cloudfw'),
					'data'		=>	array(

						array(
							'type'		=>	'global-scheme',
							'scheme'	=>	'blog_settings',
							'vars'		=>	array( 'blog_category_page' )
						),

					)

				),

				## Container Item
				array(
					'type'		=>	'container',
					'footer'	=>	false,
					'title'		=>	__('Specific Options for the Blog Category Pages','cloudfw'),
					'data'		=>	array(

						array(
							'type'		=>	'global-scheme',
							'scheme'	=>	'blog_category_settings',
							'vars'		=>	array( 'category' )
						),

					)

				),

				array(
					'type'		=>	'submit',
					'layout'	=>	'fixed',
					'nomargin'	=> 	true
				), 

			)

		),

		## Tab Item
		array(
			'type'		=>	'vertical_tabs',
			'tab_id'	=>	'blog_archives',
			'tab_title'	=>	__('Blog Archive Pages','cloudfw'),
			'data'		=>	array(
			
				## Container Item
				array(
					'type'		=>	'container',
					'footer'	=>	false,
					'title'		=>	__('Blog Archive Pages','cloudfw'),
					'data'		=>	array(

						array(
							'type'		=>	'global-scheme',
							'scheme'	=>	'page_settings',
							'vars'		=>	array( 'blog_archive_page', array(
								'layout' 		 => 'page_layout',
								'sidebar' 		 => 'page_sidebar',
								'titlebar_style' => 'page_titlebar_style',
								'skin' 			 => 'page_skin',
							) )
						),

					)

				),

				## Container Item
				array(
					'type'		=>	'container',
					'footer'	=>	false,
					'title'		=>	__('Posts in the Archive Pages','cloudfw'),
					'data'		=>	array(

						array(
							'type'		=>	'global-scheme',
							'scheme'	=>	'blog_settings',
							'vars'		=>	array( 'blog_archive_page' )
						),

					)

				),

				array(
					'type'		=>	'submit',
					'layout'	=>	'fixed',
					'nomargin'	=> 	true
				), 

			)

		),

		## Tab Item
		array(
			'type'		=>	'vertical_tabs',
			'tab_id'	=>	'blog_search',
			'tab_title'	=>	__('Search Pages','cloudfw'),
			'data'		=>	array(
			
				## Container Item
				array(
					'type'		=>	'container',
					'footer'	=>	false,
					'title'		=>	__('Search Pages','cloudfw'),
					'data'		=>	array(

						array(
							'type'		=>	'global-scheme',
							'scheme'	=>	'page_settings',
							'vars'		=>	array( 'blog_search_page', array(
								'layout' 		 => 'page_layout',
								'sidebar' 		 => 'page_sidebar',
								'titlebar_style' => 'page_titlebar_style',
								'skin' 			 => 'page_skin',
							) )
						),

					)

				),

				## Container Item
				array(
					'type'		=>	'container',
					'footer'	=>	false,
					'title'		=>	__('Posts in the Search Page','cloudfw'),
					'data'		=>	array(

						array(
							'type'		=>	'global-scheme',
							'scheme'	=>	'blog_settings',
							'vars'		=>	array( 'blog_search_page' )
						),

					)

				),

				array(
					'type'		=>	'submit',
					'layout'	=>	'fixed',
					'nomargin'	=> 	true
				), 

			)

		),

		## Tab Item
		array(
			'type'		=>	'vertical_tabs',
			'tab_id'	=>	'blog_custom_codes',
			'tab_title'	=>	__('Custom Codes','cloudfw'),
			'data'		=>	array(

				## Container Item
				array(
					'type'		=>	'container',
					'footer'	=>	false,
					'title'		=>	__('Custom Codes on Single Blog Pages','cloudfw'),
					'data'		=>	array(

						## Module Item
						array(
							'type'      =>  'module',
							'title'     =>  __('Before Post','cloudfw'),
							'data'      =>  array(

								## Element
								array(
									'type'      =>  'textarea',
									'id'        =>  cloudfw_sanitize(PFIX.'_blog_custom_codes before_post'),
									'value'     =>  $_opt[PFIX.'_blog_custom_codes']['before_post'],
									'_class'    =>  'input textarea_500px_8line code tab-textfields tabtext',
									'wrap'      =>  'off',
								), // #### element: 0

							)
						),

						## Module Item
						array(
							'type'      =>  'module',
							'title'     =>  __('Before Post Content','cloudfw'),
							'data'      =>  array(

								## Element
								array(
									'type'      =>  'textarea',
									'id'        =>  cloudfw_sanitize(PFIX.'_blog_custom_codes before_post_content'),
									'value'     =>  $_opt[PFIX.'_blog_custom_codes']['before_post_content'],
									'_class'    =>  'input textarea_500px_8line code tab-textfields tabtext',
									'wrap'      =>  'off',
								), // #### element: 0

							)
						),

						## Module Item
						array(
							'type'      =>  'module',
							'title'     =>  __('After Post','cloudfw'),
							'data'      =>  array(

								## Element
								array(
									'type'      =>  'textarea',
									'id'        =>  cloudfw_sanitize(PFIX.'_blog_custom_codes after_post'),
									'value'     =>  $_opt[PFIX.'_blog_custom_codes']['after_post'],
									'_class'    =>  'input textarea_500px_8line code tab-textfields tabtext',
									'wrap'      =>  'off',
								), // #### element: 0

							)
						),

						## Module Item
						array(
							'type'      =>  'module',
							'title'     =>  __('After Post Content','cloudfw'),
							'data'      =>  array(

								## Element
								array(
									'type'      =>  'textarea',
									'id'        =>  cloudfw_sanitize(PFIX.'_blog_custom_codes after_post_content'),
									'value'     =>  $_opt[PFIX.'_blog_custom_codes']['after_post_content'],
									'_class'    =>  'input textarea_500px_8line code tab-textfields tabtext',
									'wrap'      =>  'off',
								), // #### element: 0

							)
						),

					)

				),

				array(
					'type'		=>	'submit',
					'layout'	=>	'fixed',
					'nomargin'	=> 	true
				), 

			)

		),

	)
		
);