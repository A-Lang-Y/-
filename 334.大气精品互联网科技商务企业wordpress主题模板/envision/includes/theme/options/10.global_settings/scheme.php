<?php

$scheme[ cloudfw_id_for_sequence( $scheme, $number ) ] = array(
	'type'      => 'page',
	'page'      => 'global',
	'global'    =>  array(
		'page_title'    =>  __('Global Settings','cloudfw'),
		'page_slug'     =>  'global',
		'page_css_id'   =>  'cloud_nav_general'
	),
	'form'  =>  array(
		'enable'    => true,
	//  'method'    => 'post',
		'ajax'      => true,
		'shortcut'  => true,
		'id'        => '',
		'class'     => '',
		'action'    => '',
		'before'    => '',
		'prepend'   => '',
		'append'    => '',
		'after'     => '',
		'message'   => 1000
	),
	'data'  =>  array(


		## Tab Item
		array(
			'type'      =>  'vertical_tabs',
			'tab_id'    =>  'global_settings',
			'tab_title' =>  __('General Options','cloudfw'),
			'data'      =>  array(

				## Container Item
				array(
					'type'      =>  'container',
					'title'     =>  __('General','cloudfw'),
					'footer'    =>  false,
					'data'      =>  array(


						## Module Item
						array(
							'type'      =>  'module',
							'condition'	=>	false,
							'title'     =>  __('Enable Responsive Layout','cloudfw'),
							'data'      =>  array(
								array(
									'type'      =>  'onoff',
									'__'        =>  array( 'global', 'responsive' ),
								)
							),
						),

						array(
							'type'		=> 'module',
							'title'		=>	__('Default Page Layout','cloudfw'),
							'data'		=> array(

								## Element
								array(
									'type'		=>	'select',
									'__'        =>  array( 'global', 'default_page_layout' ),
									'source'	=>	array(
										'type'		=>	'function',
										'function'	=>	'cloudfw_admin_loop_page_templates',
									),
									'width'		=>	250
								)

							)

						),

						## Module Item
						array(
							'type'      =>  'module',
							'title'     =>  __('Enable image preloader for all pages?','cloudfw'),
							'data'      =>  array(
								array(
									'type'      =>  'onoff',
									'__'        =>  array( 'global', 'preloader' ),
								)
							)
						),

						## Module Item
						array(
							'type'      =>  'module',
							'title'     =>  __('Enable smooth scrolling for all pages?','cloudfw'),
							'data'      =>  array(
								array(
									'type'      =>  'onoff',
									'__'        =>  array( 'global', 'smoothscroll' ),
								)
							)
						),

						## Module Item
						array(
							'type'      =>  'module',
							'title'     =>  __('Global Page Width','cloudfw'),
							'data'      =>  array(
								array(
									'type'      =>  'select',
									'__'        =>  array( 'global', 'width' ),
									'width'     =>  250,
									'source'    =>  array(
										'1170'      =>  __('1170px','cloudfw'),
										'980'       =>  __('980px','cloudfw'),
									)
								)

							),

						),

						## Module Item
						array(
							'type'      =>  'module',
							'title'     =>  __('Thumbnail Resizer Script','cloudfw'),
							'data'      =>  array(
								array(
									'type'      =>  'select',
									'__'        =>  array( 'global', 'thumb_resizer' ),
									'width'     =>  250,
									'source'    =>  array(
										'aqua_resizer'  =>  __('Aqua Resize','cloudfw'),
										//'freshizer'       =>  __('Freshizer','cloudfw'),
										//'vt_resizer'  =>  __('VT Resize','cloudfw'),
									)
								)

							),

						),

						## Module Item
						array(
							'type'      =>  'module',
							'title'     =>  __('Hide page sidebars on Phones?','cloudfw'),
							'data'      =>  array(
								array(
									'type'      =>  'onoff',
									'__'        =>  array( 'global', 'hide_sidebar_on_phones' ),
									'width'     =>  250,
								)

							),

						),

					)

				),

				## Container Item
				array(
					'type'      =>  'container',
					'title'     =>  __('Form Elements','cloudfw'),
					'footer'    =>  false,
					'data'      =>  array(


						## Module Item
						array(
							'type'      =>  'module',
							'title'     =>  __('Enable Custom Form Elements','cloudfw'),
							'data'      =>  array(
								array(
									'type'      =>  'onoff',
									'__'        =>  array( 'global', 'uniform' ),
								)
							),
						),

					)

				),

				## Module Item
				100 => array(
					'type'      =>  'submit',
					'layout'    =>  'fixed',
				),

			) // vertical_tabs -> data

		),


		## Tab Item
		array(
			'type'      =>  'vertical_tabs',
			'tab_id'    =>  'logo_favicon',
			'tab_title' =>  __('Logo & Favicon','cloudfw'),
			'data'      =>  array(

				## Container Item
				array(
					'type'          =>  'container',
					'title'         =>  __('Logo','cloudfw'),
					'before_head'   =>  '',
					'append_head'   =>  '',
					'after_head'    =>  '',
					'before_title'  =>  '',
					'after_title'   =>  '',
					'footer'        =>  false,
					'data'          =>  array(

						## Module Item
						/*array(
							'type'      =>  'message',
							'data'      =>  '
								<ul>
									<li>'.sprintf(__('You can adjust the logo position from %s page.','cloudfw'), '<a href="'. cloudfw_admin_url('visual', '0') .'">'. __('Visual Settings','cloudfw') .'</a>').'</li>
									<li>'.sprintf(__('The logo image may overriden by %s. If your logo image doesn\'t display on your page, please check %s page.','cloudfw'), '<a href="'. cloudfw_admin_url('visual', '0') .'">'. __('primary or custom visual set/skin','cloudfw') .'</a>', '<a href="'. cloudfw_admin_url('visual', '0') .'">'. __('Visual Settings','cloudfw') .'</a>').'</li>
								</ul>',
							'fill'      =>  true,
							'space'     =>  true,
						),*/

						array(
							'type'      =>  'module-set',
							'title'     =>  __('Logo Image','cloudfw'),
							'closable'  =>  false,
							'state'     =>  'opened',
							'layout'    =>  'subtab',
							'data'      =>  array(

								## SubTab Item
								array(
									'type'      =>  'tabs',
									'tab_id'    =>  'tab:logo-primary',
									'tab_title' =>  __('Primary Logo','cloudfw'),
									'icon'      =>  'widescreen',
									'data'      =>  array(

										## Module Item
										array(
											'type'      =>  'module',
											'title'     =>  __('Primary Logo','cloudfw'),
											'data'      =>  array(
												array(
													'type'      => 'upload',
													'__'        =>  array( 'logo', 'image' ),
													'removable' => true,
													'hide_input'=> true,
													'store'     => true,
													'library'   => true,
												)
											)
										),

										## Module Item
										array(
											'type'      =>  'module',
											'title'     =>  __('Primary Logo for Retina Screens','cloudfw'),
											'data'      =>  array(
												array(
													'type'      => 'upload',
													'__'        =>  array( 'logo', 'image@2x' ),
													'removable' => true,
													'hide_input'=> true,
													'store'     => true,
													'library'   => true,
												)
											)
										),

										## Module Item
										array(
											'type'      =>  'module',
											'title'     =>  __('Top Margin','cloudfw'),
											'data'      =>  array(
												array(
													'type'      =>  'slider',
													'__'        =>  array( 'logo', 'margin-top' ),
													'width'     =>  430,
													'min'       =>  0,
													'max'       =>  300,
												)

											)
										),

										## Module Item
										array(
											'type'      =>  'module',
											'title'     =>  __('Bottom Margin','cloudfw'),
											'data'      =>  array(
												array(
													'type'      =>  'slider',
													'__'        =>  array( 'logo', 'margin-bottom' ),
													'width'     =>  430,
													'min'       =>  0,
													'max'       =>  300,
												)

											)
										),

									)

								),

								## SubTab Item
								array(
									'type'      =>  'tabs',
									'tab_id'    =>  'tab:logo-tablet',
									'tab_title' =>  __('For Tablets','cloudfw'),
									'icon'      =>  'tablet',
									'data'      =>  array(



										## Module Item
										array(
											'type'      =>  'module',
											'title'     =>  __('Logo for Tablets','cloudfw'),
											'data'      =>  array(
												array(
													'type'      => 'upload',
													'__'        =>  array( 'logo-tablet', 'image' ),
													'removable' => true,
													'hide_input'=> true,
													'store'     => true,
													'library'   => true,
												)
											)
										),

										## Module Item
										array(
											'type'      =>  'module',
											'title'     =>  __('Retina Logo for Tablets','cloudfw'),
											'data'      =>  array(
												array(
													'type'      => 'upload',
													'__'        =>  array( 'logo-tablet', 'image@2x' ),
													'removable' => true,
													'hide_input'=> true,
													'store'     => true,
													'library'   => true,
												)
											)
										),

										## Module Item
										array(
											'type'      =>  'message',
											'data'      =>  sprintf(__('If you don\'t set the logo image and margin settings, the primary logo will be displayed on %s.','cloudfw'), __('tablets','cloudfw')),
											'fill'      =>  true,
											'color'     =>  '',
										),

										## Module Item
										array(
											'type'      =>  'module',
											'title'     =>  __('Top Margin','cloudfw'),
											'data'      =>  array(
												array(
													'type'      =>  'slider',
													//'__'      =>  array( 'logo-tablet', 'margin-top' ),
													'id'        =>  cloudfw_sanitize(PFIX.'_logo-tablet margin-top'),
													'value'     =>  cloudfw_get_option('logo-tablet', 'margin-top'),
													'width'     =>  300,
													'min'       =>  -1,
													'max'       =>  300,
													'default'   =>  -1,
													'steps'     =>  array('-1' => __('The same with primary setting','cloudfw'))
												)

											)
										),

										## Module Item
										array(
											'type'      =>  'module',
											'title'     =>  __('Bottom Margin','cloudfw'),
											'data'      =>  array(
												array(
													'type'      =>  'slider',
													'__'        =>  array( 'logo-tablet', 'margin-bottom' ),
													'width'     =>  300,
													'min'       =>  -1,
													'max'       =>  300,
													'default'   =>  -1,
													'steps'     =>  array('-1' => __('The same with primary setting','cloudfw'))
												)

											)
										),

									)
								),

								## SubTab Item
								array(
									'type'      =>  'tabs',
									'tab_id'    =>  'tab:logo-phone',
									'tab_title' =>  __('For Phones','cloudfw'),
									'icon'      =>  'phone',
									'data'      =>  array(

										## Module Item
										array(
											'type'      =>  'module',
											'title'     =>  __('Logo for Phones','cloudfw'),
											'data'      =>  array(
												array(
													'type'      => 'upload',
													'__'        =>  array( 'logo-phone', 'image' ),
													'removable' => true,
													'hide_input'=> true,
													'store'     => true,
													'library'   => true,
												)
											)
										),

										## Module Item
										array(
											'type'      =>  'module',
											'title'     =>  __('Retina Logo for Phones','cloudfw'),
											'data'      =>  array(
												array(
													'type'      => 'upload',
													'__'        =>  array( 'logo-phone', 'image@2x' ),
													'removable' => true,
													'hide_input'=> true,
													'store'     => true,
													'library'   => true,
												)
											)
										),

										## Module Item
										array(
											'type'      =>  'message',
											'data'      =>  sprintf(__('If you don\'t set the logo image and margin settings, the primary logo will be displayed on %s.','cloudfw'), __('phones','cloudfw')),
											'fill'      =>  true,
											'color'     =>  '',
										),

										## Module Item
										array(
											'type'      =>  'module',
											'title'     =>  __('Top Margin','cloudfw'),
											'data'      =>  array(
												array(
													'type'      =>  'slider',
													'__'        =>  array( 'logo-phone', 'margin-top' ),
													'width'     =>  300,
													'min'       =>  -1,
													'max'       =>  300,
													'default'   =>  -1,
													'steps'     =>  array('-1' => __('The same with primary setting','cloudfw'))
												)

											)
										),

										## Module Item
										array(
											'type'      =>  'module',
											'title'     =>  __('Bottom Margin','cloudfw'),
											'data'      =>  array(
												array(
													'type'      =>  'slider',
													'__'        =>  array( 'logo-phone', 'margin-bottom' ),
													'width'     =>  300,
													'min'       =>  -1,
													'max'       =>  300,
													'default'   =>  -1,
													'steps'     =>  array('-1' => __('The same with primary setting','cloudfw'))
												)

											)
										),

									)
								),

							)

						),

						array(
							'type'      =>  'module-set',
							'title'     =>  __('Logo Link','cloudfw'),
							'closable'  =>  false,
							'state'     =>  'opened',
							'data'      =>  array(

								## Module Item
								array(
									'type'      =>  'module',
									'divider'	=>	false,
									'title'     =>  __('Custom Logo Link','cloudfw'),
									'data'      =>  array(
										array(
											'type'      => 'text',
											'__'        =>  array( 'logo', 'link' ),
											'width'     => 400,
											'holder'    => 'http://',
										)
									)

								),

							)

						),
					)

				),

				## Container Item
				array(
					'type'      =>  'container',
					'title'     =>  __('Favicons','cloudfw'),
					'footer'    =>  false,
					'data'      =>  array(

						## Module Item
						array(
							'type'      =>  'module',
							'title'     =>  sprintf(__('Favicon (%s)','cloudfw'), '16x16'),
							'data'      =>  array(
								array(
									'type'      =>  'upload',
									'__'        =>  array( 'favicon', '16' ),
									'removable' =>  true,
									'hide_input'=>  true,
								)
							)
						),

						## Module Item
						array(
							'type'      =>  'module',
							'title'     =>  sprintf(__('Favicon for Apple iPhone (%s)','cloudfw'), '57x57'),
							'data'      =>  array(
								array(
									'type'      =>  'upload',
									'__'        =>  array( 'favicon', '57' ),
									'removable' =>  true,
									'hide_input'=>  true,
								)
							)
						),

						## Module Item
						array(
							'type'      =>  'module',
							'title'     =>  sprintf(__('Favicon for Apple iPhone Retina (%s)','cloudfw'), '114x114'),
							'data'      =>  array(
								array(
									'type'      =>  'upload',
									'__'        =>  array( 'favicon', '114' ),
									'removable' =>  true,
									'hide_input'=>  true,
								)
							)
						),

						## Module Item
						array(
							'type'      =>  'module',
							'title'     =>  sprintf(__('Favicon for Apple iPad (%s)','cloudfw'), '72x72'),
							'data'      =>  array(
								array(
									'type'      =>  'upload',
									'__'        =>  array( 'favicon', '72' ),
									'removable' =>  true,
									'hide_input'=>  true,
								)
							)
						),

						## Module Item
						array(
							'type'      =>  'module',
							'title'     =>  sprintf(__('Favicon for Apple iPad Retina (%s)','cloudfw'), '144x144'),
							'data'      =>  array(
								array(
									'type'      =>  'upload',
									'__'        =>  array( 'favicon', '144' ),
									'removable' =>  true,
									'hide_input'=>  true,
								)
							)
						),

					)
				),



				## Module Item
				100 => array(
					'type'      =>  'submit',
					'layout'    =>  'fixed',
				),

			)
		),


		## Tab Item
		array(
			'type'      =>  'vertical_tabs',
			'tab_id'    =>  'topbar',
			'tab_title' =>  __('Top Bar','cloudfw'),
			'data'      =>  array(


				## Tab Item
				array(
					'type'      =>  'tabs',
					'tab_id'    =>  'topbar_options',
					'tab_title' =>  __('Top Bar','cloudfw'),
					'data'      =>  array(

						## Container Item
						array(
							'type'      =>  'container',
							'title'     =>  __('Top Bar','cloudfw'),
							'footer'    =>  false,
							'data'      =>  array(

								## Module Item
								array(
									'type'      =>  'module',
									'title'     =>  __('Show Top Bar','cloudfw'),
									'data'      =>  array(
										## Element
										array(
											'type'      =>  'onoff',
											'id'        =>  cloudfw_sanitize(PFIX.'_topbar enable'),
											'value'     =>  cloudfw_get_option('topbar', 'enable'),
										), // #### element: 0

									)
								),

								## Module Item
								array(
									'type'      =>  'module',
									'title'     =>  __('Enable sticky Top bar?','cloudfw'),
									'data'      =>  array(
										array(
											'type'      =>  'onoff',
											'id'        =>  cloudfw_sanitize(PFIX.'_topbar sticky'),
											'value'     =>  cloudfw_get_option('topbar', 'sticky'),
											'desc'		=>	__('It works if the sticky option is enabled for the header','cloudfw'),

										),
									),

								),

								## Module Item
								array(
									'type'      =>  'module',
									'title'     =>  __('Top Bar Layout','cloudfw'),
									'data'      =>  array(
										## Element
										array(
											'type'      =>  'select',
											'id'        =>  cloudfw_sanitize(PFIX.'_topbar layout'),
											'value'     =>  cloudfw_get_option('topbar', 'layout'),
											'source'    =>  array(
												'widgets-right' => __('Text / Widgets','cloudfw'),
												'widgets-left'  => __('Widgets / Text','cloudfw')
											),
											'width'     => 250
										), // #### element: 0

									)
								),

							)

						),

						## Container Item
						array(
							'type'      =>  'container',
							'title'     =>  __('Top Bar Text','cloudfw'),
							'footer'    =>  false,
							'data'      =>  array(

								## Module Item
								array(
									'type'      =>  'module',
									'title'     =>  __('Top Bar Text','cloudfw'),
									'data'      =>  array(

										## Element
										array(
											'type'      =>  'textarea',
											'id'        =>  cloudfw_sanitize(PFIX.'_topbar text'),
											'value'     =>  cloudfw_get_option('topbar', 'text'),
											'_class'    =>  'input tab-textfields tabtext',
											'wrap'      =>  'off',
											'editor'    =>  true,
											'width'     =>  500,
											'line'      =>  5,
											'description'=> __("Allows <code>[shortcode]</code> and HTML Code",'cloudfw'),
										), // #### element: 0

									)
								),

							)

						),


						## Container Item
						array(
							'type'      =>  'container',
							'title'     =>  __('Top Bar Widgets','cloudfw'),
							'prepend_head'=>    '
								<div style="float:right; margin-left:20px;">
									<a id="link-goto-widget-options" class="small-button small-grey" href="#topbar_widget_options"><span>'.__('Widget Options','cloudfw').'</span></a>
								</div>
							',
							'footer'    =>  false,
							'data'      =>  array(

								array(
									'type'      =>  'sorting',
									'id'        =>  'topbar_widgets_sorting',
									'item:id'   =>  'topbar_widgets_clone',
									'data'      =>

										cloudfw_core_loop_multi_option(

											array(
												'indicator' => cloudfw_get_option('topbar_widgets', 'indicator'),
												'data'      =>
													array(
														'type'      =>  'module-set',
														'id'        =>  'topbar-widgets-handler',
														'title'     =>  '<span class="font-title"></span>',
														'closable'  =>  true,
														'state'     =>  'closed',
														'title_right'=> '
															<a class="small-button small-grey cloudfw-action-remove remove_topbar_widget" data-target="li" href="javascript:;"><span>'.__('Delete','cloudfw').'</span></a>
														',
														'data'      =>  array(

															array(
																'type'      =>  'indicator',
																'id'        =>  cloudfw_sanitize(PFIX.'_topbar_widgets indicator'),
															),


															## Module Item
															array(
																'type'      =>  'module',
																'title'     =>  __('Widget','cloudfw'),
																'data'      =>  array(
																	array(
																		'type'      =>  'select',
																		'id'        =>  cloudfw_sanitize(PFIX.'_topbar_widgets widget'),
																		'value'     =>  cloudfw_get_option('topbar_widgets', 'widget'),
																		'source'    =>  array(
																			'type'      =>  'function',
																			'function'  =>  'cloudfw_admin_get_topbar_widget_list'
																		),
																		'reset'     =>  '',
																		'brackets'  =>  true,
																		'width'     =>  400,
																	)
																)

															),

															## Module Item
															array(
																'type'      =>  'module',
																'title'     =>  __('Visibility','cloudfw'),
																'data'      =>  array(
																	array(
																		'type'      =>  'select',
																		'id'        =>  cloudfw_sanitize(PFIX.'_topbar_widgets device'),
																		'value'     =>  cloudfw_get_option('topbar_widgets', 'device'),
																		'source'    =>  array(
																			'type'      =>  'function',
																			'function'  =>  'cloudfw_admin_get_visibility_options'
																		),
																		'reset'     =>  '',
																		'brackets'  =>  true,
																		'width'     =>  250,
																	)
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
											'data'      =>  '<a data-target="#topbar_widgets_sorting" class="cloudfw-action-duplicate cloudfw-ui-button cloudfw-ui-button-metro cloudfw-ui-button-metro-green" href="javascript:;"><span>'.__('+ Add a Widget to Top Bar','cloudfw').'</span></a>',
										), // #### element: 0

									)
								),


								array(
									'type'      => 'jquery',
									'data'      => '

										jQuery(document).delegate("#link-goto-widget-options", "click", function(){
											jQuery(".ui-tabs-nav").find(\'a[href=#topbar_widget_options]\').click();
										});

										/** Add event listener for font titles */
										jQuery(document).delegate("[name=\''. cloudfw_sanitize(PFIX.'_topbar_widgets widget') .'[]\']", "change" ,function(e){
											var element     = jQuery(this),
												container   = element.parents(".module-set"),
												title       = container.find(".font-title"),
												value       = element.find(":selected").first().text();

											if ( value == "" )
												value = "<span style=\"color:red\">'. esc_attr(__('Select a Widget','cloudfw')) .'</span>";

											title.html( value );

										});

										jQuery("[name=\''. cloudfw_sanitize(PFIX.'_topbar_widgets widget') .'[]\']").change();

									'
								)

							)

						),


						## Module Item
						array(
							'type'      =>  'submit',
							'layout'    =>  'fixed',
							'nomargin'  =>  true,
						),


					)

				), // #### tabs


				## Tab Item
				array(
					'type'      =>  'tabs',
					'tab_id'    =>  'topbar_widget_options',
					'tab_title' =>  __('Top Bar Widget Options','cloudfw'),
					'data'      =>  array(




						## Container Item
						array(
							'type'      =>  'container',
							'title'     =>  __('Social Icons Widget','cloudfw'),
							'footer'    =>  false,
							'data'      =>  array(


								array(
									'type'      =>  'module',
									'title'     =>  __('Icon Set','cloudfw'),
									'data'      =>  array(
										array(
											'type'      =>  'select',
											'id'        =>  cloudfw_sanitize(PFIX.'_topbar_widget_social_icons color'),
											'value'     =>  cloudfw_get_option('topbar_widget_social_icons', 'color'),
											'source'    =>  array(
												'type'      =>  'function',
												'function'  =>  'cloudfw_socialbar_sprites',
											),
											'width'     =>  '250',
										)
									),
								),


								## Module Item
								array(
									'type'      =>  'module',
									'title'     =>  __('Hover Effect','cloudfw'),
									'data'      =>  array(
										## Element
										array(
											'type'      =>  'select',
											'id'        =>  cloudfw_sanitize(PFIX.'_topbar_widget_social_icons effect'),
											'value'     =>  cloudfw_get_option('topbar_widget_social_icons', 'effect'),
											'source'    =>  array(
												'fade'      =>  __('Fade Effect','cloudfw'),
												'slide'     =>  __('Slide Effect','cloudfw'),
											),
											'width'     =>  250,
										), // #### element: 0

									)
								),

								array(
									'type'      =>  'divider',
								),

								array(
									'type'      =>  'sorting',
									'id'        =>  'topbar_widget_social_sorting',
									'item:id'   =>  'topbar_widget_social_clone',
									'data'      =>

										cloudfw_core_loop_multi_option(

											array(
												'indicator' => cloudfw_get_option('topbar_widget_social_icons', 'indicator'),
												'data'      =>
													array(
														'type'      =>  'module-set',
														'id'        =>  'topbar-widget-social-icons-handler',
														'title'     =>  '<span class="font-title"></span>',
														'closable'  =>  true,
														'state'     =>  'closed',
														'title_right'=> '
															<a class="small-button small-grey cloudfw-action-remove" data-target="li" href="javascript:;"><span>'.__('Delete','cloudfw').'</span></a>
														',
														'data'      =>  array(

															array(
																'type'      =>  'indicator',
																'id'        =>  cloudfw_sanitize(PFIX.'_topbar_widget_social_icons indicator'),
															),


															## Module Item
															array(
																'type'      =>  'module',
																'title'     =>  __('Service','cloudfw'),
																'data'      =>  array(
																	array(
																		'type'      =>  'select',
																		'id'        =>  cloudfw_sanitize(PFIX.'_topbar_widget_social_icons service'),
																		'value'     =>  cloudfw_get_option('topbar_widget_social_icons', 'service'),
																		'source'    =>  array(
																			'type'      =>  'function',
																			'function'  =>  'cloudfw_admin_get_socialbar_services'
																		),
																		'reset'     =>  '',
																		'brackets'  =>  true,
																		'width'     =>  200,
																	)
																)

															),

															## Module Item
															array(
																'type'      =>  'module',
																'title'     =>  __('URL','cloudfw'),
																'data'      =>  array(
																	## Element
																	array(
																		'type'      =>  'text',
																		'id'        =>  cloudfw_sanitize(PFIX.'_topbar_widget_social_icons url'),
																		'value'     =>  cloudfw_get_option('topbar_widget_social_icons', 'url'),
																		'reset'     =>  '',
																		'width'     =>  300,
																		'brackets'  =>  true

																	), // #### element: 0

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
											'data'      =>  '<a data-target="#topbar_widget_social_sorting" class="cloudfw-action-duplicate cloudfw-ui-button cloudfw-ui-button-metro cloudfw-ui-button-metro-green" href="javascript:;"><span>'.__('+ Add New Social Service','cloudfw').'</span></a>',
										), // #### element: 0

									)
								),

								array(
									'type'      => 'jquery',
									'data'      => '

										/** Add event listener for font titles */
										jQuery(document).delegate("[name=\''. cloudfw_sanitize(PFIX.'_topbar_widget_social_icons service') .'[]\']", "change" ,function(e){
											var element     = jQuery(this),
												container   = element.parents(".module-set"),
												title       = container.find(".font-title"),
												value       = element.find(":selected").first().text();

											if ( value == "" )
												value = "<span style=\"color:red\">'. esc_attr(__('Select a Service','cloudfw')) .'</span>";

											title.html( value );

										});

										jQuery("[name=\''. cloudfw_sanitize(PFIX.'_topbar_widget_social_icons service') .'[]\']").change();

									'
								)

							)

						),

						## Container Item
						array(
							'type'      =>  'container',
							'title'     =>  __('Custom Menu Widget','cloudfw'),
							'footer'    =>  false,
							'data'      =>  array(

								## Module Item
								array(
									'type'      =>  'module',
									'title'     =>  __('Custom Menu for Top Bar','cloudfw'),
									'data'      =>  array(
										## Element
										array(
											'type'      =>  'select',
											'id'        =>  cloudfw_sanitize(PFIX.'_topbar_widget_custom_menu menu_id'),
											'value'     =>  cloudfw_get_option('topbar_widget_custom_menu', 'menu_id'),
											'source'    =>  array(
												'type'          =>  'function',
												'function'      =>  'cloudfw_admin_get_all_menus',
											),
											'width'     =>  250,
											'action_link' =>    '<a target="_blank" href="'. admin_url('nav-menus.php') .'" class="cloudfw-ui-action-link cloudfw-tooltip"><i class="cloudfw-ui-icon cloudfw-ui-icon-plus"></i>'. __('Create Menu','cloudfw') .'</a>',
								), // #### element: 0

									)
								),

							)
						),

						## Container Item
						array(
							'type'      =>  'container',
							'title'     =>  __('User Login Widget for WooCommerce','cloudfw'),
							'footer'    =>  false,
							'data'      =>  array(

								## Module Item
								array(
									'type'      =>  'module',
									'title'     =>  __('Custom Menu for User Login Widget','cloudfw'),
									'data'      =>  array(
										## Element
										array(
											'type'      =>  'select',
											'id'        =>  cloudfw_sanitize(PFIX.'_login_widget_custom_menu menu_id'),
											'value'     =>  cloudfw_get_option('login_widget_custom_menu', 'menu_id'),
											'source'    =>  array(
												'type'          =>  'function',
												'function'      =>  'cloudfw_admin_get_all_menus',
											),
											'width'     =>  250,
											'action_link' =>    '<a target="_blank" href="'. admin_url('nav-menus.php') .'" class="cloudfw-ui-action-link cloudfw-tooltip"><i class="cloudfw-ui-icon cloudfw-ui-icon-plus"></i>'. __('Create Menu','cloudfw') .'</a>',
										), // #### element: 0

									)
								),


								## Module Item
								array(
									'type'      =>  'module',
									'title'     =>  __('Show Sub Level Menu','cloudfw'),
									'data'      =>  array(
										## Element
										array(
											'type'      =>  'onoff',
											'id'        =>  cloudfw_sanitize(PFIX.'_login_widget_custom_menu show_sub_level'),
											'value'     =>  cloudfw_get_option('login_widget_custom_menu', 'show_sub_level'),
										),
									)
								),

								## Module Item
								array(
									'type'      =>  'module',
									'title'     =>  __('Show User Avatar','cloudfw'),
									'data'      =>  array(
										## Element
										array(
											'type'      =>  'onoff',
											'id'        =>  cloudfw_sanitize(PFIX.'_login_widget_custom_menu show_avatar'),
											'value'     =>  cloudfw_get_option('login_widget_custom_menu', 'show_avatar'),
										),
									)
								),

							)
						),


						## Container Item
						array(
							'type'      =>  'container',
							'condition'	=>	cloudfw_woocommerce(),
							'title'     =>  __('Mini Shopping Cart Widget','cloudfw'),
							'footer'    =>  false,
							'data'      =>  array(

								## Module Item
								array(
									'type'      =>  'module',
									'title'     =>  __('Open Shoping Cart on the Side Panel when clicked?','cloudfw'),
									'data'      =>  array(
										## Element
										array(
											'type'      =>  'onoff',
											'id'        =>  cloudfw_sanitize(PFIX.'_topbar_widget_shoping_cart show_side_panel'),
											'value'     =>  cloudfw_get_option('topbar_widget_shoping_cart', 'show_side_panel'),
										),
									)
								),

							)

						),


						## Container Item
						array(
							'type'      =>  'container',
							'title'     =>  __('Language Switcher Widget','cloudfw'),
							'footer'    =>  false,
							'data'      =>  array(

								array(
									'type'		=>	'message',
									'color'		=>	'yellow',
									'fill'		=>	true,
									'data'		=>	__('The <strong>WPML Multilingual CMS</strong> and <strong>WPML String Translation</strong> plugins should be installed to add the language switcher widget to the top bar.','cloudfw')
								),

								## Module Item
								array(
									'type'      =>  'module',
									'title'     =>  __('Show Language Flags','cloudfw'),
									'data'      =>  array(
										## Element
										array(
											'type'      =>  'select',
											'id'        =>  cloudfw_sanitize(PFIX.'_topbar_widget_language_switcher link_type'),
											'value'     =>  cloudfw_get_option('topbar_widget_language_switcher', 'link_type'),
											'source'    =>  array(
												'NULL'      => __('Go to current page','cloudfw'),
												'home'      => __('Go to homepage','cloudfw'),
											),
											'width'     =>  250,
										), // #### element: 0
									)
								),

								## Module Item
								array(
									'type'      =>  'module',
									'title'     =>  __('Show Language Flags','cloudfw'),
									'data'      =>  array(
										## Element
										array(
											'type'      =>  'onoff',
											'id'        =>  cloudfw_sanitize(PFIX.'_topbar_widget_language_switcher flag'),
											'value'     =>  cloudfw_get_option('topbar_widget_language_switcher', 'flag'),
										),
									)
								),

							)
						),

						## Module Item
						array(
							'type'      =>  'submit',
							'layout'    =>  'fixed',
							'nomargin'  =>  true,
						),

					)

				), // #### tabs

			)

		), // #### vertical_tabs: 10


		## Tab Item
		array(
			'type'      =>  'vertical_tabs',
			'tab_id'    =>  'header',
			'tab_title' =>  __('Header','cloudfw'),
			'data'      =>  array(


				## Container Item
				array(
					'type'      =>  'container',
					'title'     =>  __('Header','cloudfw'),
					'footer'    =>  false,
					'data'      =>  array(

						## Module Item
						array(
							'type'      =>  'module',
							'title'     =>  __('Header Type','cloudfw'),
							'data'      =>  array(


								array(
									'type'      =>  'select',
									'id'        =>  cloudfw_sanitize(PFIX.'_header type'),
									'value'     =>  cloudfw_get_option('header', 'type'),
									'source'    =>  array(
										'NULL'      =>  __('Default','cloudfw'),
										'1'      	=>  __('Logo on the Left','cloudfw'),
										'2'      	=>  __('Centered Logo','cloudfw'),
									),
									'width'     =>  400,
								),


							),

						),


						## Module Item
						array(
							'type'      =>  'module',
							'title'     =>  __('Enable Sticky Header?','cloudfw'),
							'data'      =>  array(
								array(
									'type'      =>  'onoff',
									'id'        =>  cloudfw_sanitize(PFIX.'_header sticky'),
									'value'     =>  cloudfw_get_option('header', 'sticky'),

								),
							),
							'js'        => array(
								## Script Item
								array(
									'type'          => 'toggle',
									'related'       => 'stickyLogoOption',
									'conditions'    => array(
										array( 'val' => '1', 'e' => '.stickyLogoOption' ),
									)
								),

							)

						),

						## Module Item
						array(
							'type'      =>  'module',
							'title'     =>  __('Sticky Header Offset','cloudfw'),
							'data'      =>  array(
								array(
									'type'      =>  'slider',
									'id'        =>  cloudfw_sanitize(PFIX.'_header sticky_offset'),
									'value'     =>  cloudfw_get_option('header', 'sticky_offset'),
									'min'		=>	0,
									'max'		=>	200,
									'width'		=>	400,

								),
							)
						),

						array(
							'type'      =>  'group',
							'related'   =>  'stickyLogoOption',
							'data'      =>  array(

								array(
									'type'      =>  'module-set',
									'title'     =>  __('Specific Logo for Sticky Header','cloudfw'),
									'closable'  =>  false,
									'state'     =>  'opened',
									'data'      =>  array(


										## Module Item
										array(
											'type'      =>  'module',
											'title'     =>  __('Specific Logo for Sticky Header','cloudfw'),
											'data'      =>  array(
												array(
													'type'      => 'upload',
													'__'        =>  array( 'logo-sticky', 'image' ),
													'removable' => true,
													'hide_input'=> true,
													'store'     => true,
													'library'   => true,
												)
											)
										),

										## Module Item
										array(
											'type'      =>  'module',
											'title'     =>  __('Specific Retina Logo for Sticky Header','cloudfw'),
											'data'      =>  array(
												array(
													'type'      => 'upload',
													'__'        =>  array( 'logo-sticky', 'image@2x' ),
													'removable' => true,
													'hide_input'=> true,
													'store'     => true,
													'library'   => true,
												)
											)
										),


										## Module Item
										array(
											'type'      =>  'module',
											'title'     =>  __('Height','cloudfw'),
											'data'      =>  array(
												array(
													'type'      =>  'slider',
													'__'        =>  array( 'logo-sticky', 'height' ),
													'width'     =>  430,
													'min'       =>  0,
													'max'       =>  1000,
													'steps'     =>  array( array( '0' => __('Not set','cloudfw') ) )
												)

											)
										),

										## Module Item
										array(
											'type'      =>  'module',
											'title'     =>  __('Top Margin','cloudfw'),
											'data'      =>  array(
												array(
													'type'      =>  'slider',
													'__'        =>  array( 'logo-sticky', 'margin-top' ),
													'width'     =>  430,
													'min'       =>  0,
													'max'       =>  300,
												)

											)
										),

										## Module Item
										array(
											'type'      =>  'module',
											'title'     =>  __('Bottom Margin','cloudfw'),
											'data'      =>  array(
												array(
													'type'      =>  'slider',
													'__'        =>  array( 'logo-sticky', 'margin-bottom' ),
													'width'     =>  430,
													'min'       =>  0,
													'max'       =>  300,
												)

											)
										),

									)

								),

								## Module Item
								array(
									'type'      =>  'space',
								),

							)

						),

						## Module Item
						array(
							'type'      =>  'module',
							'title'     =>  __('Add home link to the navigation menu?','cloudfw'),
							'data'      =>  array(
								array(
									'type'      =>  'onoff',
									'__'        =>  array( 'global', 'homeitem' ),
								)
							)

						),

					)

				),

				## Module Item
				array(
					'type'      =>  'submit',
					'layout'    =>  'fixed',
					'nomargin'  =>  true,
				),

			)

		),

		## Tab Item
		array(
			'type'      =>  'vertical_tabs',
			'tab_id'    =>  'titlebar',
			'tab_title' =>  __('Title Bar','cloudfw'),
			'data'      =>  array(


				## Container Item
				array(
					'type'      =>  'container',
					'title'     =>  __('Title Bar','cloudfw'),
					'footer'    =>  false,
					'data'      =>  array(

						## Module Item
						array(
							'type'      =>  'module',
							'title'     =>  __('Title Bar Heading Element','cloudfw'),
							'data'      =>  array(


								array(
									'type'      =>  'select',
									'id'        =>  cloudfw_sanitize(PFIX.'_titlebar title_element'),
									'value'     =>  cloudfw_get_option('titlebar', 'title_element'),
									'source'    =>  array(
										'source'	=>	array(
											'NULL'		=> __('Default','cloudfw'),
											'h1'		=> 'H1',
											'h2'			=> 'H2',
											'h3'		=> 'H3',
											'h4'		=> 'H4',
											'h5'		=> 'H5',
											'h6'		=> 'H6',
										)
									),
									'width'     =>  150,
								),


							),

						),

					)

				),

				## Module Item
				array(
					'type'      =>  'submit',
					'layout'    =>  'fixed',
					'nomargin'  =>  true,
				),

			)

		),


		## Tab Item
		array(
			'type'      =>  'vertical_tabs',
			'tab_id'    =>  'footer',
			'tab_title' =>  __('Footer','cloudfw'),
			'data'      =>  array(

				## Container Item
				array(
					'type'      =>  'container',
					'title'     =>  __('Footer','cloudfw'),
					'footer'    =>  false,
					'data'      =>  array(

						## Module Item
						array(
							'type'      =>  'module',
							'title'     =>  __('Show Widgetized Areas on the Footer?','cloudfw'),
							'data'      =>  array(
								array(
									'type'      =>  'onoff',
									'id'        =>  cloudfw_sanitize(PFIX.'_footer widgetized_enable'),
									'value'     =>  cloudfw_get_option('footer', 'widgetized_enable'),
								),
							),
							'js'        => array(
								## Script Item
								array(
									'type'          => 'toggle',
									'related'       => 'footerOptions',
									'conditions'    => array(
										array( 'val' => '1', 'e' => '.footerOptions' ),
									)
								),

							)

						),



						array(
							'type'      =>  'group',
							'related'   =>  'footerOptions',
							'data'      =>  array(

								array(
									'type'      =>  'module-set',
									'title'     =>  __('Footer Widgets Row #1','cloudfw'),
									'state'     =>  'opened',
									'data'      =>  array(

										array(
											'type'      =>  'module',
											'title'     =>  sprintf(__('Enable Row %s?','cloudfw'), '#1'),
											'data'      =>  array(
												array(
													'type'      =>  'onoff',
													'id'        =>  cloudfw_sanitize(PFIX.'_footer row1_enable'),
													'value'     =>  cloudfw_get_option('footer', 'row1_enable'),
												),
											),
											'js'        => array(
												## Script Item
												array(
													'type'          => 'toggle',
													'related'       => 'footerRow1Options',
													'conditions'    => array(
														array( 'val' => '1', 'e' => '.footerRow1Options' ),
													)
												),

											)

										),

										array(
											'type'      =>  'group',
											'related'   =>  'footerRow1Options',
											'data'      =>  array(

												## Module Item
												array(
													'type'      =>  'module',
													'title'     =>  __('Layout','cloudfw'),
													'data'      =>  array(
														array(
															'type'      =>  'select',
															'id'        =>  cloudfw_sanitize(PFIX.'_footer row1'),
															'value'     =>  cloudfw_get_option('footer', 'row1'),
															'source'    =>  array(
																'1 Column Layouts' =>  array(
																	'span12'       		=> '1/1',
																),
																'2 Columns Layouts' =>  array(
																	'span6/span6'       => '1/2 - 1/2',
																),
																'3 Columns Layouts' =>  array(
																	'span4/span4/span4' => '1/3 - 1/3 - 1/3',
																	'span4/span8'       => '1/3 - 2/3',
																	'span8/span4'       => '2/3 - 1/3',
																),
																'4 Columns Layouts' =>  array(
																	'span3/span3/span3/span3' => '1/4 - 1/4 - 1/4 - 1/4',
																	'span3/span3/span6'       => '1/4 - 1/4 - 2/4',
																	'span6/span3/span3'       => '2/4 - 1/4 - 1/4',
																	'span3/span6/span3'       => '1/4 - 2/4 - 1/4',
																	'span3/span9'             => '1/4 - 3/4',
																	'span9/span3'             => '3/4 - 1/4',
																)
															),
															'width'     =>  400,
														),
													),
													'js'        => array(
														## Script Item
														array(
															'type'          => 'toggle',
															'related'       => 'footerWidgetizedColumnOptions_row1',
															'effect'        => 'none',
															'conditions'    => array(
																//array( 'val' => '1', 'e' => '.footerWidgetizedColumn_1_row1' ),
																array( 'val' => 'span12',      'e' => '.footerWidgetizedColumn_1_row1' ),
																array( 'val' => 'span6/span6', 'e' => '.footerWidgetizedColumn_1_row1, .footerWidgetizedColumn_2_row1' ),
																array( 'val' => 'span4/span8', 'e' => '.footerWidgetizedColumn_1_row1, .footerWidgetizedColumn_2_row1' ),
																array( 'val' => 'span8/span4', 'e' => '.footerWidgetizedColumn_1_row1, .footerWidgetizedColumn_2_row1' ),
																array( 'val' => 'span3/span9', 'e' => '.footerWidgetizedColumn_1_row1, .footerWidgetizedColumn_2_row1' ),
																array( 'val' => 'span9/span3', 'e' => '.footerWidgetizedColumn_1_row1, .footerWidgetizedColumn_2_row1' ),

																array( 'val' => 'span4/span4/span4', 'e' => '.footerWidgetizedColumn_1_row1, .footerWidgetizedColumn_2_row1, .footerWidgetizedColumn_3_row1' ),
																array( 'val' => 'span3/span3/span3/span3', 'e' => '.footerWidgetizedColumn_1_row1, .footerWidgetizedColumn_2_row1, .footerWidgetizedColumn_3_row1' ),
																array( 'val' => 'span3/span3/span6', 'e' => '.footerWidgetizedColumn_1_row1, .footerWidgetizedColumn_2_row1, .footerWidgetizedColumn_3_row1' ),
																array( 'val' => 'span6/span3/span3', 'e' => '.footerWidgetizedColumn_1_row1, .footerWidgetizedColumn_2_row1, .footerWidgetizedColumn_3_row1' ),
																array( 'val' => 'span3/span6/span3', 'e' => '.footerWidgetizedColumn_1_row1, .footerWidgetizedColumn_2_row1, .footerWidgetizedColumn_3_row1' ),

																array( 'val' => 'span3/span3/span3/span3', 'e' => '.footerWidgetizedColumn_1_row1, .footerWidgetizedColumn_2_row1, .footerWidgetizedColumn_3_row1, .footerWidgetizedColumn_4_row1' ),

															)
														),

													)

												),

												array(
													'type'      =>  'module',
													'title'     =>  sprintf(__('Column %s Sidebar','cloudfw'), '#1'),
													'related'   =>  'footerWidgetizedColumnOptions_row1 footerWidgetizedColumn_1_row1',
													'data'      =>  array(

														array(
															'type'      =>  'select',
															'id'        =>  cloudfw_sanitize(PFIX.'_footer widget_column_row1_1'),
															'value'     =>  cloudfw_get_option('footer', 'widget_column_row1_1'),
															'source'    =>  array(
																'type'      =>  'function',
																'function'  =>  'cloudfw_admin_loop_custom_sidebars'
															),
															'width'     =>  250,
														),

													)

												),

												array(
													'type'      =>  'module',
													'title'     =>  sprintf(__('Column %s Sidebar','cloudfw'), '#2'),
													'related'   =>  'footerWidgetizedColumnOptions_row1 footerWidgetizedColumn_2_row1',
													'data'      =>  array(

														array(
															'type'      =>  'select',
															'id'        =>  cloudfw_sanitize(PFIX.'_footer widget_column_row1_2'),
															'value'     =>  cloudfw_get_option('footer', 'widget_column_row1_2'),
															'source'    =>  array(
																'type'      =>  'function',
																'function'  =>  'cloudfw_admin_loop_custom_sidebars'
															),
															'width'     =>  250,
														),

													)

												),

												array(
													'type'      =>  'module',
													'title'     =>  sprintf(__('Column %s Sidebar','cloudfw'), '#3'),
													'related'   =>  'footerWidgetizedColumnOptions_row1 footerWidgetizedColumn_3_row1',
													'data'      =>  array(

														array(
															'type'      =>  'select',
															'id'        =>  cloudfw_sanitize(PFIX.'_footer widget_column_row1_3'),
															'value'     =>  cloudfw_get_option('footer', 'widget_column_row1_3'),
															'source'    =>  array(
																'type'      =>  'function',
																'function'  =>  'cloudfw_admin_loop_custom_sidebars'
															),
															'width'     =>  250,
														),

													)

												),

												array(
													'type'      =>  'module',
													'title'     =>  sprintf(__('Column %s Sidebar','cloudfw'), '#4'),
													'related'   =>  'footerWidgetizedColumnOptions_row1 footerWidgetizedColumn_4_row1',
													'data'      =>  array(

														array(
															'type'      =>  'select',
															'id'        =>  cloudfw_sanitize(PFIX.'_footer widget_column_row1_4'),
															'value'     =>  cloudfw_get_option('footer', 'widget_column_row1_4'),
															'source'    =>  array(
																'type'      =>  'function',
																'function'  =>  'cloudfw_admin_loop_custom_sidebars'
															),
															'width'     =>  250,
														),

													)

												),

											)

										),

									)
								),

								array(
									'type'      =>  'module-set',
									'title'     =>  __('Footer Widgets Row #2','cloudfw'),
									'state'     =>  'opened',
									'data'      =>  array(

										array(
											'type'      =>  'module',
											'title'     =>  sprintf(__('Enable Row %s?','cloudfw'), '#2'),
											'data'      =>  array(
												array(
													'type'      =>  'onoff',
													'id'        =>  cloudfw_sanitize(PFIX.'_footer row2_enable'),
													'value'     =>  cloudfw_get_option('footer', 'row2_enable'),
												),
											),
											'js'        => array(
												## Script Item
												array(
													'type'          => 'toggle',
													'related'       => 'footerRow2Options',
													'conditions'    => array(
														array( 'val' => '1', 'e' => '.footerRow2Options' ),
													)
												),

											)

										),

										array(
											'type'      =>  'group',
											'related'   =>  'footerRow2Options',
											'data'      =>  array(

												## Module Item
												array(
													'type'      =>  'module',
													'title'     =>  __('Layout','cloudfw'),
													'data'      =>  array(
														array(
															'type'      =>  'select',
															'id'        =>  cloudfw_sanitize(PFIX.'_footer row2'),
															'value'     =>  cloudfw_get_option('footer', 'row2'),
															'default'   =>  'span4/span4/span4',
															'source'    =>  array(
																'1 Column Layouts' =>  array(
																	'span12'       		=> '1/1',
																),
																'2 Columns Layouts' =>  array(
																	'span6/span6'       => '1/2 - 1/2',
																),
																'3 Columns Layouts' =>  array(
																	'span4/span4/span4' => '1/3 - 1/3 - 1/3',
																	'span4/span8'       => '1/3 - 2/3',
																	'span8/span4'       => '2/3 - 1/3',
																),
																'4 Columns Layouts' =>  array(
																	'span3/span3/span3/span3' => '1/4 - 1/4 - 1/4 - 1/4',
																	'span3/span3/span6'       => '1/4 - 1/4 - 2/4',
																	'span6/span3/span3'       => '2/4 - 1/4 - 1/4',
																	'span3/span6/span3'       => '1/4 - 2/4 - 1/4',
																	'span3/span9'             => '1/4 - 3/4',
																	'span9/span3'             => '3/4 - 1/4',
																)
															),
															'width'     =>  400,
														),
													),
													'js'        => array(
														## Script Item
														array(
															'type'          => 'toggle',
															'related'       => 'footerWidgetizedColumnOptions_row2',
															'effect'        => 'none',
															'conditions'    => array(
																array( 'val' => 'span12',      'e' => '.footerWidgetizedColumn_1_row2' ),
																array( 'val' => 'span6/span6', 'e' => '.footerWidgetizedColumn_1_row2, .footerWidgetizedColumn_2_row2' ),
																array( 'val' => 'span4/span8', 'e' => '.footerWidgetizedColumn_1_row2, .footerWidgetizedColumn_2_row2' ),
																array( 'val' => 'span8/span4', 'e' => '.footerWidgetizedColumn_1_row2, .footerWidgetizedColumn_2_row2' ),
																array( 'val' => 'span3/span9', 'e' => '.footerWidgetizedColumn_1_row2, .footerWidgetizedColumn_2_row2' ),
																array( 'val' => 'span9/span3', 'e' => '.footerWidgetizedColumn_1_row2, .footerWidgetizedColumn_2_row2' ),

																array( 'val' => 'span4/span4/span4', 'e' => '.footerWidgetizedColumn_1_row2, .footerWidgetizedColumn_2_row2, .footerWidgetizedColumn_3_row2' ),
																array( 'val' => 'span3/span3/span3/span3', 'e' => '.footerWidgetizedColumn_1_row2, .footerWidgetizedColumn_2_row2, .footerWidgetizedColumn_3_row2' ),
																array( 'val' => 'span3/span3/span6', 'e' => '.footerWidgetizedColumn_1_row2, .footerWidgetizedColumn_2_row2, .footerWidgetizedColumn_3_row2' ),
																array( 'val' => 'span6/span3/span3', 'e' => '.footerWidgetizedColumn_1_row2, .footerWidgetizedColumn_2_row2, .footerWidgetizedColumn_3_row2' ),
																array( 'val' => 'span3/span6/span3', 'e' => '.footerWidgetizedColumn_1_row2, .footerWidgetizedColumn_2_row2, .footerWidgetizedColumn_3_row2' ),

																array( 'val' => 'span3/span3/span3/span3', 'e' => '.footerWidgetizedColumn_1_row2, .footerWidgetizedColumn_2_row2, .footerWidgetizedColumn_3_row2, .footerWidgetizedColumn_4_row2' ),

															)
														),

													)

												),

												array(
													'type'      =>  'module',
													'title'     =>  sprintf(__('Column %s Sidebar','cloudfw'), '#1'),
													'related'   =>  'footerWidgetizedColumnOptions_row2 footerWidgetizedColumn_1_row2',
													'data'      =>  array(

														array(
															'type'      =>  'select',
															'id'        =>  cloudfw_sanitize(PFIX.'_footer widget_column_row2_1'),
															'value'     =>  cloudfw_get_option('footer', 'widget_column_row2_1'),
															'source'    =>  array(
																'type'      =>  'function',
																'function'  =>  'cloudfw_admin_loop_custom_sidebars'
															),
															'width'     =>  250,
														),

													)

												),

												array(
													'type'      =>  'module',
													'title'     =>  sprintf(__('Column %s Sidebar','cloudfw'), '#2'),
													'related'   =>  'footerWidgetizedColumnOptions_row2 footerWidgetizedColumn_2_row2',
													'data'      =>  array(

														array(
															'type'      =>  'select',
															'id'        =>  cloudfw_sanitize(PFIX.'_footer widget_column_row2_2'),
															'value'     =>  cloudfw_get_option('footer', 'widget_column_row2_2'),
															'source'    =>  array(
																'type'      =>  'function',
																'function'  =>  'cloudfw_admin_loop_custom_sidebars'
															),
															'width'     =>  250,
														),

													)

												),

												array(
													'type'      =>  'module',
													'title'     =>  sprintf(__('Column %s Sidebar','cloudfw'), '#3'),
													'related'   =>  'footerWidgetizedColumnOptions_row2 footerWidgetizedColumn_3_row2',
													'data'      =>  array(

														array(
															'type'      =>  'select',
															'id'        =>  cloudfw_sanitize(PFIX.'_footer widget_column_row2_3'),
															'value'     =>  cloudfw_get_option('footer', 'widget_column_row2_3'),
															'source'    =>  array(
																'type'      =>  'function',
																'function'  =>  'cloudfw_admin_loop_custom_sidebars'
															),
															'width'     =>  250,
														),

													)

												),

												array(
													'type'      =>  'module',
													'title'     =>  sprintf(__('Column %s Sidebar','cloudfw'), '#4'),
													'related'   =>  'footerWidgetizedColumnOptions_row2 footerWidgetizedColumn_4_row2',
													'data'      =>  array(

														array(
															'type'      =>  'select',
															'id'        =>  cloudfw_sanitize(PFIX.'_footer widget_column_row2_4'),
															'value'     =>  cloudfw_get_option('footer', 'widget_column_row2_4'),
															'source'    =>  array(
																'type'      =>  'function',
																'function'  =>  'cloudfw_admin_loop_custom_sidebars'
															),
															'width'     =>  250,
														),

													)

												),

											)

										),

									)

								),

								array(
									'type'      =>  'space',
								),


							)

						),

					)

				),

				## Container Item
				array(
					'type'      =>  'container',
					'title'     =>  __('Footer Bottom Bar','cloudfw'),
					'footer'    =>  false,
					'data'      =>  array(

						## Module Item
						array(
							'type'      =>  'module',
							'title'     =>  __('Show the Footer Bottom Bar?','cloudfw'),
							'data'      =>  array(
								array(
									'type'      =>  'onoff',
									'id'        =>  cloudfw_sanitize(PFIX.'_footer_bottom enable'),
									'value'     =>  cloudfw_get_option('footer_bottom', 'enable'),
								),
							),
							'js'        => array(
								## Script Item
								array(
									'type'          => 'toggle',
									'related'       => 'footerBottomOptions',
									'conditions'    => array(
										array( 'val' => '1', 'e' => '.footerBottomOptions' ),
									)
								),

							)

						),


						## Module Item
						array(
							'type'      =>  'group',
							'related'   =>  'footerBottomOptions',
							'data'      =>  array(


								## Module Item
								array(
									'type'      =>  'module',
									'title'     =>  __('Footer Bottom Layout','cloudfw'),
									'data'      =>  array(
										array(
											'type'      =>  'select',
											'id'        =>  cloudfw_sanitize(PFIX.'_footer_bottom layout'),
											'value'     =>  cloudfw_get_option('footer_bottom', 'layout'),
											'source'    =>  array(
												'text/menu'     =>  __('Text / Menu','cloudfw'),
												'menu/text'     =>  __('Menu / Text','cloudfw'),
												'vertical'      =>  __('Vertical & Centered Layout','cloudfw'),
											),
											'width'     =>  300

										)
									)
								),

								## Module Item
								array(
									'type'      =>  'module',
									'title'     =>  __('Footer Bottom Bar Text','cloudfw'),
									'data'      =>  array(
										array(
											'type'      =>  'textarea',
											'id'        =>  cloudfw_sanitize(PFIX.'_footer_bottom text'),
											'value'     =>  cloudfw_get_option('footer_bottom', 'text'),
											'editor'    =>  true,
											'width'     =>  500,
											'line'      =>  3
										)
									)
								),

							)
						),

					)

				),


				## Container Item
				array(
					'type'      =>  'container',
					'title'     =>  __('Others','cloudfw'),
					'footer'    =>  false,
					'data'      =>  array(

						## Module Item
						array(
							'type'      =>  'group',
							'data'      =>  array(

								## Module Item
								array(
									'type'      =>  'module',
									'title'     =>  __('The Footer Before Page Content','cloudfw'),
									'data'      =>  array(

										## Element
										array(
											'type'      	=>  'page-selector',
												'id'        =>  cloudfw_sanitize(PFIX.'_called_pages before_footer'),
												'value'     =>  $_opt[PFIX.'_called_pages']['before_footer'],
											'response'  	=>  'ID',
											'hide_input'	=>  true,
										),

									),
									'desc'		=>	__('If you select a page for this option, the content of the selected page will be displated before the footer on all pages.','cloudfw')

								),

							)

						),


					)

				),

				## Module Item
				array(
					'type'      =>  'submit',
					'layout'    =>  'fixed',
					'nomargin'  =>  true,
				),

			) // vertical_tabs -> data

		), // ####


		## Tab Item
		array(
			'type'      =>  'vertical_tabs',
			'tab_id'    =>  'add_code',
			'tab_title' =>  __('Add Code','cloudfw'),
			'data'      =>  array(

				## Container Item
				10  => array(
					'type'      =>  'container',
					'title'     =>  __('Add Code','cloudfw'),
					'footer'    =>  false,
					'data'      =>  array(

						## Module Item
						array(
							'type'      =>  'module',
							'title'     =>  __('Google Analytics Tracking Code','cloudfw'),
							'description'=> __('Only Tracking ID, Ex: <code>UA-XXXXXX-X</code>','cloudfw'),
							'data'      =>  array(

								## Element
								array(
									'type'      =>  'text',
									'id'        =>  cloudfw_sanitize(PFIX.'_custom_codes tracking'),
									'value'     =>  $_opt[PFIX.'_custom_codes']['tracking'],
									'_class'    =>  'bold',
								), // #### element: 0

							)
						),

						## Module Item
						array(
							'type'      =>  'module',
							'title'     =>  __('Custom CSS Code','cloudfw'),
							'data'      =>  array(

								## Element
								array(
									'type'      =>  'textarea',
									'id'        =>  cloudfw_sanitize(PFIX.'_custom_codes css'),
									'value'     =>  $_opt[PFIX.'_custom_codes']['css'],
									'_class'    =>  'input textarea_500px_8line code tab-textfields tabtext',
									'wrap'      =>  'off',
									'description'=> sprintf(__("Do not use %s tag",'cloudfw'), '<code>&lt;style&gt;</code>'),
								), // #### element: 0

							)
						),

						## Module Item
						array(
							'type'      =>  'module',
							'title'     =>  __('Into The Header','cloudfw'),
							'data'      =>  array(

									## Element
									array(
										'type'      =>  'textarea',
										'id'        =>  cloudfw_sanitize(PFIX.'_custom_codes header'),
										'value'     =>  $_opt[PFIX.'_custom_codes']['header'],
										'_class'    =>  'input textarea_500px_8line code tab-textfields redactor',
										'wrap'      =>  'off',
									), // #### element: 0

							)
						),

						## Module Item
						array(
							'type'      =>  'module',
							'title'     =>  __('The Footer Before Custom Code','cloudfw'),
							'data'      =>  array(

									## Element
									array(
										'type'      =>  'textarea',
										'id'        =>  cloudfw_sanitize(PFIX.'_custom_codes before_footer'),
										'value'     =>  $_opt[PFIX.'_custom_codes']['before_footer'],
										'_class'    =>  'input textarea_500px_8line code tab-textfields redactor',
										'wrap'      =>  'off',
									), // #### element: 0

							)
						),


						## Module Item
						array(
							'type'      =>  'module',
							'title'     =>  __('After The Footer Custom Code','cloudfw'),
							'data'      =>  array(

									## Element
									array(
										'type'      =>  'textarea',
										'id'        =>  cloudfw_sanitize(PFIX.'_custom_codes footer'),
										'value'     =>  $_opt[PFIX.'_custom_codes']['footer'],
										'_class'    =>  'input textarea_500px_8line code tab-textfields redactor',
										'wrap'      =>  'off',
									), // #### element: 0

							)
						),

					)

				),

				## Module Item
				100 => array(
					'type'      =>  'submit',
					'layout'    =>  'fixed',
					'nomargin'  =>  true,
				),


			)
		), // #### vertical_tabs: 10

		## Tab Item
		array(
			'type'      =>  'vertical_tabs',
			'tab_id'    =>  'defined_pages',
			'tab_title' =>  __('Custom Pages','cloudfw'),
			'data'      =>  array(

				## Container Item
				array(
					'type'      =>  'container',
					'title'     =>  __('Custom Pages','cloudfw'),
					'footer'    =>  false,
					'data'      =>  array(

							## Module Item
							array(
								'type'      =>  'module',
								'title'     =>  __('Custom 404 Page','cloudfw'),
								'optional'  =>  true,
								'data'      =>  array(

									## Element
									array(
										'type'      =>  'page-selector',
										'id'        =>  cloudfw_sanitize( PFIX.'_page_defines 404' ),
										'value'     =>  cloudfw_get_option( 'page_defines',  '404' ),
										'response'  =>  'ID',
										'hide_input'=>  true,
									)

								)

							),

					)

				),


				## Module Item
				100 => array(
					'type'      =>  'submit',
					'layout'    =>  'fixed',
					'nomargin'  =>  true,
				),


			)
		),


		## Tab Item
		array(
			'type'      =>  'vertical_tabs',
			'tab_id'    =>  'side_panel_content',
			'tab_title' =>  __('Side Panels','cloudfw'),
			'data'      =>  array(

				## Container Item
				array(
					'type'      =>  'container',
					'title'     =>  __('Global Side Panel Settings','cloudfw'),
					'footer'    =>  false,
					'data'      =>  array(

						## Module Item
						array(
							'type'      =>  'module',
							'title'     =>  __('Show close button?','cloudfw'),
							'data'      =>  array(

								## Element
								array(
									'type'      =>  'onoff',
									'id'        =>  cloudfw_sanitize( PFIX.'_side_panel close_button' ),
									'value'     =>  cloudfw_get_option( 'side_panel',  'close_button' ),
								)

							)

						),


						## Module Item
						array(
							'type'      =>  'module',
							'title'     =>  __('Close Button Style','cloudfw'),
							'data'      =>  array(

								## Element
								array(
									'type'		=>	'select',
									'id'        =>  cloudfw_sanitize( PFIX.'_side_panel_1 close_button_style' ),
									'value'     =>  cloudfw_get_option( 'side_panel_1',  'close_button_style' ),
									'source'	=>	array(
										'type'		=>	'function',
										'function'	=>	'cloudfw_admin_loop_button_colors'
									),
									'width'		=>	250,
								), // #### element: 0

							)

						),

					)

				),


				## Container Item
				array(
					'type'      =>  'container',
					'title'     =>  __('Side Panel','cloudfw') . ' #1',
					'footer'    =>  false,
					'data'      =>  array(
						array(
							'type'		=>	'global-scheme',
							'scheme'	=>	'sidepanel_settings',
							'vars'		=>	array( 'side_panel_1', '1' ),
						),
					)
				),

				## Container Item
				array(
					'type'      =>  'container',
					'title'     =>  __('Side Panel','cloudfw') . ' #2',
					'footer'    =>  false,
					'data'      =>  array(
						array(
							'type'		=>	'global-scheme',
							'scheme'	=>	'sidepanel_settings',
							'vars'		=>	array( 'side_panel_2', '2' ),
						),
					)
				),

				## Container Item
				array(
					'type'      =>  'container',
					'title'     =>  __('Side Panel','cloudfw') . ' #3',
					'footer'    =>  false,
					'data'      =>  array(
						array(
							'type'		=>	'global-scheme',
							'scheme'	=>	'sidepanel_settings',
							'vars'		=>	array( 'side_panel_3', '3' ),
						),
					)
				),


				## Module Item
				100 => array(
					'type'      =>  'submit',
					'layout'    =>  'fixed',
					'nomargin'  =>  true,
				),


			)
		),



		## Tab Item
		array(
			'type'      =>  'vertical_tabs',
			'tab_id'    =>  'api_keys',
			'tab_title' =>  __('API Keys','cloudfw'),
			'data'      =>  array(

				## Container Item
				array(
					'type'      =>  'container',
					'title'     =>  __('Twitter oAuth API Keys','cloudfw'),
					'footer'    =>  false,
					'data'      =>  array(


							## Module Item
							array(
								'type'      =>  'message',
								'data'      =>  '' .
									sprintf(__('Most of this configuration can found on the application overview page on the %s website.','cloudfw'), '<a href="http://dev.twitter.com" target="_blank">http://dev.twitter.com</a>') . '<br/><br/>' .
									__('When creating an application for <strong>the twitter widget</strong>, you don\'t need to set a callback location and you only need read access.','cloudfw') . '<br/><br/>' .
									__('You will need to generate an oAuth token once you\'ve created the application. The button for that is on the bottom of the application overview page.','cloudfw') . '<br/><br/>' .
									__('Once configured, you then can add the twitter widget into your pages by using the content composer.','cloudfw') . '',
								'fill'      =>  true,
								'color'     =>  'yellow',
							),


							## Module Item
							array(
								'type'      =>  'module',
								'title'     =>  __('Consumer Key','cloudfw'),
								'data'      =>  array(

									## Element
									array(
										'type'      =>  'text',
										'id'        =>  cloudfw_sanitize( PFIX.'_twitter consumer_key' ),
										'value'     =>  cloudfw_get_option( 'twitter',  'consumer_key' ),
										'width'     =>  400,
									)

								)

							),

							## Module Item
							array(
								'type'      =>  'module',
								'title'     =>  __('Consumer Secret','cloudfw'),
								'data'      =>  array(

									## Element
									array(
										'type'      =>  'text',
										'id'        =>  cloudfw_sanitize( PFIX.'_twitter consumer_secret' ),
										'value'     =>  cloudfw_get_option( 'twitter',  'consumer_secret' ),
										'width'     =>  400,
									)

								)

							),

							## Module Item
							array(
								'type'      =>  'module',
								'title'     =>  __('Access Token','cloudfw'),
								'data'      =>  array(

									## Element
									array(
										'type'      =>  'text',
										'id'        =>  cloudfw_sanitize( PFIX.'_twitter access_token' ),
										'value'     =>  cloudfw_get_option( 'twitter',  'access_token' ),
										'width'     =>  400,
									)

								)

							),

							## Module Item
							array(
								'type'      =>  'module',
								'title'     =>  __('Access Token Secret','cloudfw'),
								'data'      =>  array(

									## Element
									array(
										'type'      =>  'text',
										'id'        =>  cloudfw_sanitize( PFIX.'_twitter access_token_secret' ),
										'value'     =>  cloudfw_get_option( 'twitter',  'access_token_secret' ),
										'width'     =>  400,
									)

								)

							),

							## Module Item
							array(
								'type'      =>  'module',
								'title'     =>  __('Debug','cloudfw'),
								'data'      =>  array(

									## Element
									array(
										'type'      =>  'html',
										'data'      =>  get_option( PFIX. '_twitter_last_error'),
									)

								)

							),

					)

				),

				## Container Item
				array(
					'type'      =>  'container',
					'title'     =>  __('Google Maps API Key','cloudfw'),
					'footer'    =>  false,
					'data'      =>  array(

						## Module Item
						array(
							'type'      =>  'message',
							'data'      =>  '<a href="https://developers.google.com/maps/documentation/javascript/tutorial#api_key" target="_blank">'.__('How to create an API Key for Google Maps','cloudfw').'</a>',
							'fill'      =>  true,
							'color'     =>  'yellow',
						),

						## Module Item
						array(
							'type'      =>  'module',
							'title'     =>  __('Google Maps API Key','cloudfw'),
							'data'      =>  array(

								## Element
								array(
									'type'      =>  'text',
									'id'        =>  cloudfw_sanitize( PFIX.'_apis gmap' ),
									'value'     =>  cloudfw_get_option( 'apis',  'gmap' ),
									'width'     =>  400,
								)

							)

						),

					)

				),



				## Module Item
				100 => array(
					'type'      =>  'submit',
					'layout'    =>  'fixed',
					'nomargin'  =>  true,
				),


			)
		),

		## Tab Item
		array(
			'type'      =>  'vertical_tabs',
			'tab_id'    =>  'troubleshooting',
			'tab_title' =>  __('Troubleshooting','cloudfw'),
			'data'      =>  array(

				## Container Item
				array(
					'type'      =>  'container',
					'title'     =>  __('General Troubleshooting','cloudfw'),
					'footer'    =>  false,
					'data'      =>  array(


						## Module Item
						array(
							'type'      =>  'module',
							'title'     =>  __('Disable the lightbox links on mobile devices?','cloudfw'),
							'data'      =>  array(
								array(
									'type'      =>  'onoff',
									'__'        =>  array( 'troubleshooting', 'disable_prettyphoto_on_mobile' ),
								)
							),
						),

					)

				),

				## Container Item
				array(
					'condition'	=>	cloudfw_woocommerce(),
					'type'      =>  'container',
					'title'     =>  __('WooCommerce','cloudfw'),
					'footer'    =>  false,
					'data'      =>  array(


						## Module Item
						array(
							'type'      =>  'module',
							'title'     =>  __('Auto Refresh Carts via Ajax?','cloudfw'),
							'data'      =>  array(

								## Element
								array(
									'type'      =>  'onoff',
									'__'        =>  array( 'troubleshooting', 'refresh_carts' ),
									'desc'		=>	__('If the page caching is enabled on your website, switch this option on.','cloudfw')
								)

							)

						),


					)

				),



				## Container Item
				array(
					'condition'	=>	class_exists('GFForms'),
					'type'      =>  'container',
					'title'     =>  __('Gravity Forms','cloudfw'),
					'footer'    =>  false,
					'data'      =>  array(


						## Module Item
						array(
							'type'      =>  'module',
							'title'     =>  __('Disable Custom &lt;select&gt; Elements on Gravity Forms?','cloudfw'),
							'data'      =>  array(
								array(
									'type'      =>  'onoff',
									'__'        =>  array( 'troubleshooting', 'disable_gravity_uniform_select' ),
								)
							),
						),

					)

				),

				## Module Item
				100 => array(
					'type'      =>  'submit',
					'layout'    =>  'fixed',
					'nomargin'  =>  true,
				),


			)
		),

		## Tab Item
		array(
			'type'      =>  'vertical_tabs',
			'tab_id'    =>  'sidebar_manager',
			'tab_title' =>  __('Sidebar Manager','cloudfw'),
			'data'      =>  array(


				## Container Item
				array(
					'type'          =>  'container',
					'footer'        =>  false,
					'title'         =>  'Custom Sidebars',
					'data'          =>
						cloudfw_core_loop_multi_option(
							array(
								'start'     => 5,
								'indicator' => $_opt[PFIX.'_custom_sidebars']['id'],
								'data'      =>
									array(
										'type'      =>  'module-set',
										'id'        =>  'webfonts-handler',
										'title'     =>  '<span class="font-title"></span>',
										'closable'  =>  true,
										'state'     =>  'closed',
										'title_right'=> '
											<a class="small-button small-grey remove_sidebar" href="javascript:;"><span>'.__('Delete','cloudfw').'</span></a>
										',
										'data'      =>  array(

											array(
												'type'      =>  'randomizer',
												'id'        =>  cloudfw_sanitize(PFIX.'_custom_sidebars id'),
												'value'     =>  $_opt[PFIX.'_custom_sidebars']['id'],
												'brackets'  =>  true,
												'prefix'    =>  'sidebar-',
												'chars'     =>  '09-az',
												'length'    =>  5,
											),

											## Module Item
											array(
												'type'      =>  'module',
												'title'     =>  __('Sidebar Name','cloudfw'),
												'data'      =>  array(
													array(
														'type'      =>  'text',
														'class'     =>  'input bold input_200',
														'id'        =>  cloudfw_sanitize(PFIX.'_custom_sidebars name'),
														'value'     =>  $_opt[PFIX.'_custom_sidebars']['name'],
														'reset'     =>  '',
														'brackets'  =>  true,
													)
												)

											),

											## Module Item
											array(
												'type'      =>  'module',
												'title'     =>  __('Description','cloudfw'),
												'data'      =>  array(
													array(
														'type'      =>  'text',
														'id'        =>  cloudfw_sanitize(PFIX.'_custom_sidebars desc'),
														'value'     =>  $_opt[PFIX.'_custom_sidebars']['desc'],
														'reset'     =>  '',
														'brackets'  =>  true,
													)
												)

											),

										)

								),

								'append' => array(
									array(
										'type'      => 'module',
										'layout'    => 'raw',
										'divider'   =>  false,
										'data'      => array(

											## Element
											array(
												'type'      =>  'html',
												'data'      =>  '<a data-target="" id="add_new_sidebar" class="cloudfw-ui-button cloudfw-ui-button-metro cloudfw-ui-button-metro-green" href="javascript:;"><span>'.__('+ Add New Sidebar','cloudfw').'</span></a>',
											), // #### element: 0

										)
									)

								),

								'before'    =>  array(
									'type'      =>  'html',
									'data'      =>  '<div id="custom-sidebars">',
								),
								'after' =>  array(
									'type'      =>  'html',
									'data'      =>  '</div>',
								),
							)

					)

				),

				## Module Item
				99  => array(
					'type'      =>  'submit',
					'layout'    =>  'fixed',
					'nomargin'  =>  true
				),


				100 => array(
					'type'      => 'jquery',
					'data'      => '

						/** Add New Layer */
						jQuery("#add_new_sidebar").click(function(){
							var item = jQuery("#custom-sidebars").children(".module-set").first().clone().removeClass("first").attr("id", "");
							jQuery("#custom-sidebars").append( item );

								item.hide().slideDown();


							cloudfw_reset_elements( item );
							item.find("[name=\''. cloudfw_sanitize(PFIX.'_custom_sidebars name') .'[]\']", item).keyup();
							item.find("[name=\''. cloudfw_sanitize(PFIX.'_custom_sidebars id') .'[]\']").val(cloudfw_randomizer(5, "sidebar-", "09-az"));


							cloudfw_main();
							cloudfw_destroy();
						});

						/** Remove Layer */
						jQuery(document).delegate(".remove_sidebar", "click" ,function(e){

							var element = jQuery(this);

							if ( ! element.hasClass("apply") ) {
								CloudFw_UI.sure.init({
									resume: function(){ element.addClass("apply").click(); },
									cancel: function(Mo){ element.removeClass("apply"); Mo.close(); },
								});

								event.preventDefault();
								return false;
							}

							element.removeClass("apply");

							var container   = element.parents(".module-set"),
								items       = container.parents("div").first().children();

							if ( items.length < 2 )
								jQuery("#add_new_sidebar").click();

							container.slideUp(function(){
								jQuery(this).remove();
								cloudfw_destroy();
							});


						});

						/** Add event listener for font titles */
						jQuery(document).delegate("[name=\''. cloudfw_sanitize(PFIX.'_custom_sidebars name') .'[]\']", "keyup keydown blur" ,function(e){
							var element     = jQuery(this),
								container   = element.parents(".module-set"),
								title       = container.find(".font-title"),
								value       = element.val();

							if ( value == "" )
								value = "'. esc_attr(__('Unnamed Sidebar','cloudfw')) .'";

							title.html( value );

						});

						jQuery("[name=\''. cloudfw_sanitize(PFIX.'_custom_sidebars name') .'[]\']").keyup();

					'
				)

			)

		), // #### tabs: 30

	) // page -> data

);