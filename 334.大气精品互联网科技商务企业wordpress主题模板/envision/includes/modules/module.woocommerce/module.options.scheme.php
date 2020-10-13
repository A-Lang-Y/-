<?php

/**
 *	Register Options Scheme
 *
 *	@package 	CloudFw
 *	@subpackage Portfolio
 *	@version 	1.0
 */
add_filter( 'cloudfw_schemes_options', 'cloudfw_module_option_woocommerce' );
function cloudfw_module_option_woocommerce( $schemes ) {
	$schemes[ cloudfw_id_for_sequence( $schemes, 21 ) ] = array(
		'type'		=> 'page',
		'page' 		=> 'portfolio',
		'portfolio'	=> array(
			'page_title' 	=>	__('Woo Commerce','cloudfw'),
			'page_nice_title'=>	__('woocommerce','cloudfw'),
			'page_slug' 	=>	'woocommerce',
			'page_css_id' 	=>	'cloud_nav_woocommerce',
		),
		'form'	=> 	array(
			'enable'	=> true,
			'ajax'		=> true,
			'shortcut'	=> true,
		),	

		'data'	=> array(
		
			## Tab Item
			array(
				'type'		=>	'vertical_tabs',
				'tab_id' 	=>	'woocommerce_catalog',
				'tab_title' =>	__('Shop / Catalog Pages','cloudfw'),
				'data'		=>	array(

					## Container Item
					array(
						'type'			=>	'container',
						'footer'		=>	false,
						'title'			=>	__('WooCommerce General','cloudfw'),
						'data'			=>	array(

							array(
								'type'		=> 'module',
								'title'		=>	__('Catalog Mode','cloudfw'),
								'data'		=> array(

									## Element
									array(
										'type'		=>	'onoff',
										'id'		=>	cloudfw_sanitize( PFIX.'_woocommerce catalog_mode' ),
										'value'		=>	cloudfw_get_option( 'woocommerce',  'catalog_mode' ),
									)

								)

							),

						)

					),
							
					## Container Item
					array(
						'type'			=>	'container',
						'footer'		=>	false,
						'title'			=>	__('Shop / Catalog Pages','cloudfw'),
						'data'			=>	array(
						
							array(
								'type'		=>	'mini-section',
								'title'		=>	__('Layout Options','cloudfw'),
								'data'		=>	array(

									array(
										'type'		=> 'module',
										'title'		=>	__('Layout','cloudfw'),
										'data'		=> array(

											## Element
											array(
												'type'		=>	'select',
												'id'		=>	cloudfw_sanitize( PFIX.'_woocommerce catalog_layout' ),
												'value'		=>	cloudfw_get_option( 'woocommerce',  'catalog_layout' ),
												'source'	=>	array(
													'type'		=>	'function',
													'function'	=>	'cloudfw_admin_loop_content_layouts',
													'exclude'	=>	array( 'carousel' ),
												),
												'width'		=>	250,
											)

										)

									),

				
									array(
										'type'		=> 'module',
										'title'		=>	__('Columns','cloudfw'),
										'data'		=> array(

											## Element
											array(
												'type'		=>	'select',
												'id'		=>	cloudfw_sanitize( PFIX.'_woocommerce catalog_column' ),
												'value'		=>	cloudfw_get_option( 'woocommerce',  'catalog_column' ),
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
										'title'		=>	__('Product Number Per Pages','cloudfw'),
										'data'		=> array(

											## Element
											array(
												'type'		=>	'text',
												'id'		=>	cloudfw_sanitize( PFIX.'_woocommerce catalog_post_perpage' ),
												'value'		=>	cloudfw_get_option( 'woocommerce',  'catalog_post_perpage' ),
												'width'		=>	50,
												'unit'		=>	__('product(s)','cloudfw')
											)

										)

									),


									array(
										'type'      => 'module',
										'title'     => __('Product Images Aspect Ratio','cloudfw'),
										'data'      => array(

											array(
												'type'		=>	'select',
												'id'		=>	cloudfw_sanitize( PFIX.'_woocommerce catalog_media_ratio' ),
												'value'		=>	cloudfw_get_option( 'woocommerce',  'catalog_media_ratio' ),
												'source'	=>	array(
													'type' 		=> 'function',
													'function'	=> 'cloudfw_admin_loop_aspect_ratio',
												),				
												'width'		=>  250,
											),

										)

									),

								)

							),

							array(
								'type'		=>	'mini-section',
								'title'		=>	__('Shadow','cloudfw'),
								'data'		=>	array(

									array(
										'type'      => 'module',
										'title'     => __('Box Shadows','cloudfw'),
										'data'      => array(

											## Element
											array(
												'type'      =>  'select',
												'id'		=>	cloudfw_sanitize( PFIX.'_woocommerce catalog_shadow' ),
												'value'		=>	cloudfw_get_option( 'woocommerce',  'catalog_shadow' ),
												'source'    =>  array(
													'type'          => 'function',
													'function'      => 'cloudfw_admin_loop_shadows',
												),
												'width'     =>  250,

											), // #### element: 0

										)

									),
									

								)

							),


							array(
								'type'		=>	'mini-section',
								'title'		=>	__('Effects','cloudfw'),
								'data'		=>	array(
							
									array(
										'type'      => 'module',
										'title'     => __('Entrance Effect for Products','cloudfw'),
										'data'      => array(

											## Element
											array(
												'type'		=>	'select',
												'id'		=>	cloudfw_sanitize( PFIX.'_woocommerce catalog_effect' ),
												'value'		=>	cloudfw_get_option( 'woocommerce',  'catalog_effect' ),
												'ui'		=>	true,
												'source'	=>	array(
													'type'		=>	'function',
													'function'	=>	'cloudfw_css_effect_list',
													'vars'		=>	array(''),
												),
												'width'		=>	400,
											),

										)

									),
									

									array(
										'type'		=> 'module',
										'title'		=>	__('Gallery Effect on Hover?','cloudfw'),
										'data'		=> array(

											## Element
											array(
												'type'		=>	'onoff',
												'id'		=>	cloudfw_sanitize( PFIX.'_woocommerce catalog_hover' ),
												'value'		=>	cloudfw_get_option( 'woocommerce',  'catalog_hover' ),
											)

										)

									),


									array(
										'type'      => 'module',
										'title'     => __('Hover Transition Effect','cloudfw'),
										'data'      => array(

											## Element
											array(
												'type'      =>  'select',
												'id'		=>	cloudfw_sanitize( PFIX.'_woocommerce catalog_hover_effect' ),
												'value'		=>	cloudfw_get_option( 'woocommerce',  'catalog_hover_effect' ),
												'source'    =>  array(
													'type'          => 'function',
													'function'      => 'cloudfw_UI_box_hover_effects',
												),
												'width'     =>  250,

											), // #### element: 0

										)

									),

							
								)
							
							),


																		
						)

					),

					## Module Item
					array(
						'type'		=>	'submit',
						'layout'	=>	'fixed',
						'nomargin'	=>	true,
					), 

						
				)

			),
		
			## Tab Item
			array(
				'type'		=>	'vertical_tabs',
				'tab_id' 	=>	'woocommerce_product_pages',
				'tab_title' =>	__('Product Details Pages','cloudfw'),
				'data'		=>	array(
							
					## Container Item
					array(
						'type'			=>	'container',
						'footer'		=>	false,
						'title'			=>	__('Product Pages','cloudfw'),
						'data'			=>	array(
						

							array(
								'type'		=> 'module',
								'title'		=>	__('Product Details Page Layout','cloudfw'),
								'data'		=> array(

									## Element
									array(
										'type'		=>	'select',
										'id'		=>	cloudfw_sanitize( PFIX.'_woocommerce post_page_layout' ),
										'value'		=>	cloudfw_get_option( 'woocommerce',  'post_page_layout' ),
										'source'	=>	array(
											'type'		=>	'function',
											'function'	=>	'cloudfw_admin_loop_page_templates',
										),
										'width'		=>	250,
										'desc'		=>	__('It\'s the same with the shop page by default.','cloudfw')
									)

								)

							),

							array(
								'type'		=> 'module',
								'title'		=>	__('Product Details Page Sidebar','cloudfw'),
								'data'		=> array(

				                    ## Element
				                    array(
				                        'type'      =>  'select',
												'id'		=>	cloudfw_sanitize( PFIX.'_woocommerce post_page_sidebar' ),
												'value'		=>	cloudfw_get_option( 'woocommerce',  'post_page_sidebar' ),
				                        'source'    =>  array(
				                                'type'      =>  'function',
				                                'function'  =>  'cloudfw_admin_loop_custom_sidebars'
				                        ),
				                        'width'     =>  400
				                    ), // #### element: 0

								)

							),

																		
						)

					),

					## Container Item
					array(
						'type'			=>	'container',
						'footer'		=>	false,
						'title'			=>	__('Up-Sells Products','cloudfw'),
						'data'			=>	array(
						

							array(
								'type'		=> 'module',
								'title'		=>	__('Up-Sells Products List Columns','cloudfw'),
								'data'		=> array(

									## Element
									array(
										'type'		=>	'select',
										'id'		=>	cloudfw_sanitize( PFIX.'_woocommerce up_sells_column' ),
										'value'		=>	cloudfw_get_option( 'woocommerce',  'up_sells_column' ),
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
								'title'		=>	__('Up-Sells Products Limit','cloudfw'),
								'data'		=> array(

									## Element
									array(
										'type'		=>	'text',
										'id'		=>	cloudfw_sanitize( PFIX.'_woocommerce up_sells_limit' ),
										'value'		=>	cloudfw_get_option( 'woocommerce',  'up_sells_limit' ),
										'width'		=>	50,
										'unit'		=>	__('product(s)','cloudfw')
									)

								)

							),

							array(
								'type'		=> 'module',
								'title'		=>	__('Up-Sells Products Layout','cloudfw'),
								'data'		=> array(

									## Element
									array(
										'type'		=>	'select',
										'id'		=>	cloudfw_sanitize( PFIX.'_woocommerce up_sells_layout' ),
										'value'		=>	cloudfw_get_option( 'woocommerce',  'up_sells_layout' ),
										'source'	=>	array(
											'type'		=>	'function',
											'function'	=>	'cloudfw_admin_loop_content_layouts',
										),
										'width'		=>	250,
									)

								)

							),
																		
						)

					),

					## Container Item
					array(
						'type'			=>	'container',
						'footer'		=>	false,
						'title'			=>	__('Related Products','cloudfw'),
						'data'			=>	array(
						

							array(
								'type'		=>	'mini-section',
								'title'		=>	__('Layout Options','cloudfw'),
								'data'		=>	array(

									array(
										'type'		=> 'module',
										'title'		=>	__('Layout','cloudfw'),
										'data'		=> array(

											## Element
											array(
												'type'		=>	'select',
												'id'		=>	cloudfw_sanitize( PFIX.'_woocommerce related_layout' ),
												'value'		=>	cloudfw_get_option( 'woocommerce',  'related_layout' ),
												'source'	=>	array(
													'type'		=>	'function',
													'function'	=>	'cloudfw_admin_loop_content_layouts',
												),
												'width'		=>	250,
											)

										)

									),

				
									array(
										'type'		=> 'module',
										'title'		=>	__('Columns','cloudfw'),
										'data'		=> array(

											## Element
											array(
												'type'		=>	'select',
												'id'		=>	cloudfw_sanitize( PFIX.'_woocommerce related_column' ),
												'value'		=>	cloudfw_get_option( 'woocommerce',  'related_column' ),
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
										'title'		=>	__('Product Number to Show','cloudfw'),
										'data'		=> array(

											## Element
											array(
												'type'		=>	'text',
												'id'		=>	cloudfw_sanitize( PFIX.'_woocommerce related_limit' ),
												'value'		=>	cloudfw_get_option( 'woocommerce',  'related_limit' ),
												'width'		=>	50,
												'unit'		=>	__('product(s)','cloudfw')
											)

										)

									),


									array(
										'type'      => 'module',
										'title'     => __('Product Images Aspect Ratio','cloudfw'),
										'data'      => array(

											array(
												'type'		=>	'select',
												'id'		=>	cloudfw_sanitize( PFIX.'_woocommerce related_media_ratio' ),
												'value'		=>	cloudfw_get_option( 'woocommerce',  'related_media_ratio' ),
												'source'	=>	array(
													'type' 		=> 'function',
													'function'	=> 'cloudfw_admin_loop_aspect_ratio',
												),				
												'width'		=>  250,
											),

										)

									),

								)

							),

							array(
								'type'		=>	'mini-section',
								'title'		=>	__('Shadow','cloudfw'),
								'data'		=>	array(

									array(
										'type'      => 'module',
										'title'     => __('Box Shadows','cloudfw'),
										'data'      => array(

											## Element
											array(
												'type'      =>  'select',
												'id'		=>	cloudfw_sanitize( PFIX.'_woocommerce related_shadow' ),
												'value'		=>	cloudfw_get_option( 'woocommerce',  'related_shadow' ),
												'source'    =>  array(
													'type'          => 'function',
													'function'      => 'cloudfw_admin_loop_shadows',
												),
												'width'     =>  250,

											), // #### element: 0

										)

									),
									

								)

							),


							array(
								'type'		=>	'mini-section',
								'title'		=>	__('Effects','cloudfw'),
								'data'		=>	array(
							
									array(
										'type'      => 'module',
										'title'     => __('Entrance Effect for Products','cloudfw'),
										'data'      => array(

											## Element
											array(
												'type'		=>	'select',
												'id'		=>	cloudfw_sanitize( PFIX.'_woocommerce related_effect' ),
												'value'		=>	cloudfw_get_option( 'woocommerce',  'related_effect' ),
												'ui'		=>	true,
												'source'	=>	array(
													'type'		=>	'function',
													'function'	=>	'cloudfw_css_effect_list',
													'vars'		=>	array(''),
												),
												'width'		=>	400,
											),

										)

									),
									

									array(
										'type'		=> 'module',
										'title'		=>	__('Gallery Effect on Hover?','cloudfw'),
										'data'		=> array(

											## Element
											array(
												'type'		=>	'onoff',
												'id'		=>	cloudfw_sanitize( PFIX.'_woocommerce related_hover' ),
												'value'		=>	cloudfw_get_option( 'woocommerce',  'related_hover' ),
											)

										)

									),


									array(
										'type'      => 'module',
										'title'     => __('Hover Transition Effect','cloudfw'),
										'data'      => array(

											## Element
											array(
												'type'      =>  'select',
												'id'		=>	cloudfw_sanitize( PFIX.'_woocommerce related_hover_effect' ),
												'value'		=>	cloudfw_get_option( 'woocommerce',  'related_hover_effect' ),
												'source'    =>  array(
													'type'          => 'function',
													'function'      => 'cloudfw_UI_box_hover_effects',
												),
												'width'     =>  250,

											), // #### element: 0

										)

									),

							
								)
							
							),
							
																		
						)



					),


					## Module Item
					array(
						'type'		=>	'submit',
						'layout'	=>	'fixed',
						'nomargin'	=>	true,
					), 

						
				)

			),

			## Tab Item
			array(
				'type'		=>	'vertical_tabs',
				'tab_id' 	=>	'woocommerce_cart_page',
				'tab_title' =>	__('Cart Page','cloudfw'),
				'data'		=>	array(
							
					## Container Item
					array(
						'type'			=>	'container',
						'footer'		=>	false,
						'title'			=>	__('Cross-Sells Products','cloudfw'),
						'data'			=>	array(
						

							array(
								'type'		=> 'module',
								'title'		=>	__('Cross-Sells Products List Columns','cloudfw'),
								'data'		=> array(

									## Element
									array(
										'type'		=>	'select',
										'id'		=>	cloudfw_sanitize( PFIX.'_woocommerce cross_sells_column' ),
										'value'		=>	cloudfw_get_option( 'woocommerce',  'cross_sells_column' ),
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
								'title'		=>	__('Cross-Sells Products Limit','cloudfw'),
								'data'		=> array(

									## Element
									array(
										'type'		=>	'text',
										'id'		=>	cloudfw_sanitize( PFIX.'_woocommerce cross_sells_limit' ),
										'value'		=>	cloudfw_get_option( 'woocommerce',  'cross_sells_limit' ),
										'width'		=>	50,
										'unit'		=>	__('product(s)','cloudfw')
									)

								)

							),

							array(
								'type'		=> 'module',
								'title'		=>	__('Cross-Sells Products Layout','cloudfw'),
								'data'		=> array(

									## Element
									array(
										'type'		=>	'select',
										'id'		=>	cloudfw_sanitize( PFIX.'_woocommerce cross_sells_layout' ),
										'value'		=>	cloudfw_get_option( 'woocommerce',  'cross_sells_layout' ),
										'source'	=>	array(
											'type'		=>	'function',
											'function'	=>	'cloudfw_admin_loop_content_layouts',
										),
										'width'		=>	250,
									)

								)

							),
																		
						)

					),


					## Module Item
					array(
						'type'		=>	'submit',
						'layout'	=>	'fixed',
						'nomargin'	=>	true,
					), 

						
				)

			),

			## Tab Item
			array(
				'type'		=>	'vertical_tabs',
				'tab_id' 	=>	'woocommerce_login_page',
				'tab_title' =>	__('Login/Register Page','cloudfw'),
				'data'		=>	array(
							
					## Container Item
					array(
						'type'			=>	'container',
						'footer'		=>	false,
						'title'			=>	__('Login / Register Form','cloudfw'),
						'data'			=>	array(
						

							array(
								'type'		=> 'module',
								'title'		=>	__('Login Form Custom Message','cloudfw'),
								'data'		=> array(

									## Element
									array(
										'type'		=>	'textarea',
										'id'		=>	cloudfw_sanitize( PFIX.'_woocommerce login_message' ),
										'value'		=>	cloudfw_get_option( 'woocommerce',  'login_message' ),
										'width'		=>	'90%',
										'line'		=>	5,
										'editor'	=>	true,
										'desc'		=>	__('allows <code>[shortcodes]</code>','cloudfw'),
									)

								)

							),

							array(
								'type'		=> 'module',
								'title'		=>	__('Register Form Custom Message','cloudfw'),
								'data'		=> array(

									## Element
									array(
										'type'		=>	'textarea',
										'id'		=>	cloudfw_sanitize( PFIX.'_woocommerce register_message' ),
										'value'		=>	cloudfw_get_option( 'woocommerce',  'register_message' ),
										'width'		=>	'90%',
										'line'		=>	5,
										'editor'	=>	true,
										'desc'		=>	__('allows <code>[shortcodes]</code>','cloudfw'),
									)

								)

							),
																		
						)

					),


					## Module Item
					array(
						'type'		=>	'submit',
						'layout'	=>	'fixed',
						'nomargin'	=>	true,
					), 

						
				)

			),

			## Tab Item
			array(
				'type'		=>	'vertical_tabs',
				'tab_id' 	=>	'woocommerce_custom_codes',
				'tab_title' =>	__('Custom Codes','cloudfw'),
				'data'		=>	array(
							
					## Container Item
					array(
						'type'			=>	'container',
						'footer'		=>	false,
						'title'			=>	__('Single Product Pages','cloudfw'),
						'data'			=>	array(
						

							array(
								'type'		=> 'module',
								'title'		=>	__('Before Content','cloudfw'),
								'data'		=> array(

									## Element
									array(
										'type'		=>	'textarea',
										'id'		=>	cloudfw_sanitize( PFIX.'_woocommerce code_single_before_content' ),
										'value'		=>	cloudfw_get_option( 'woocommerce',  'code_single_before_content' ),
										'width'		=>	'90%',
										'line'		=>	5,
										'editor'	=>	true,
										'desc'		=>	__('allows <code>[shortcodes]</code>','cloudfw'),
									)

								)

							),

							array(
								'type'		=> 'module',
								'title'		=>	__('After Content','cloudfw'),
								'data'		=> array(

									## Element
									array(
										'type'		=>	'textarea',
										'id'		=>	cloudfw_sanitize( PFIX.'_woocommerce code_single_after_content' ),
										'value'		=>	cloudfw_get_option( 'woocommerce',  'code_single_after_content' ),
										'width'		=>	'90%',
										'line'		=>	5,
										'editor'	=>	true,
										'desc'		=>	__('allows <code>[shortcodes]</code>','cloudfw'),
									)

								)

							),


																		
						)

					),


					## Module Item
					array(
						'type'		=>	'submit',
						'layout'	=>	'fixed',
						'nomargin'	=>	true,
					), 

						
				)

			),

			## Tab Item
			array(
				'type'		=>	'vertical_tabs',
				'tab_id' 	=>	'woocommerce_others',
				'tab_title' =>	__('Other Options','cloudfw'),
				'data'		=>	array(
							
					## Container Item
					array(
						'type'			=>	'container',
						'footer'		=>	false,
						'title'			=>	__('Other Options','cloudfw'),
						'data'			=>	array(
						

							array(
								'type'		=> 'module',
								'title'		=>	__('Show Mini Cart Link in Sticky Navigation Menu?','cloudfw'),
								'data'		=> array(

									## Element
									array(
										'type'		=>	'onoff',
										'id'		=>	cloudfw_sanitize( PFIX.'_woocommerce cart_in_navigation' ),
										'value'		=>	cloudfw_get_option( 'woocommerce',  'cart_in_navigation' ),
									)

								)

							),
																		
						)

					),


					## Module Item
					array(
						'type'		=>	'submit',
						'layout'	=>	'fixed',
						'nomargin'	=>	true,
					), 

						
				)

			),
		
		)

	);

	return $schemes;
}