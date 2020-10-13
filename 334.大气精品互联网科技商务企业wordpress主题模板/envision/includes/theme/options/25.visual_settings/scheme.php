<?php

$scheme[ cloudfw_id_for_sequence( $scheme, $number ) ] = array(
	'type'		=> 'page',
	'page' 		=> 'visual',
	'visual'	=> array(
		'page_title' 	=>	__('Visual Settings','cloudfw'),
		'page_nice_title'=>	__('visual settings','cloudfw'),
		'page_slug' 	=>	'visual',
		'page_css_id' 	=>	'cloud_nav_colors',
		
		'load_file'		=>	array( 
			array(
				'type'		=>	'require',
				'path'		=>	TMP_PATH.'/cloudfw/core/engine.skin/source.skin.engine_layouts.php'
			),
			array(
				'type'		=>	'require',
				'path'		=>	TMP_PATH.'/cloudfw/core/others/source.system.php'
			)
		),
			
	),
	'data'	=> array( 
		1000 => array(
			'type'			=>	'include',
			'path'			=>	TMP_PATH.'/cloudfw/core/engine.skin/source.skin.create_form.php',
			'before'		=>	'<span style="display: none; height: auto;" id="mb_create_skin"><div style="padding: 20px 20px 0;">',
			'after'			=>	'</div><div class="clear"></div></span>'
		),
		1001 => array(
			'type'			=>	'include',
			'path'			=>	TMP_PATH.'/cloudfw/core/engine.skin/source.skin.import_form.php',
			'before'		=>	'<span style="display: none; height: auto;" id="mb_import_skin"><div style="padding: 20px 20px 0;">',
			'after'			=>	'</div><div class="clear"></div></span>'
		),
		1002 => array(
			'type'			=>	'include',
			'path'			=>	TMP_PATH.'/cloudfw/core/engine.skin/source.skin.duplicate_form.php',
			'before'		=>	'<span style="display: none; height: auto;" id="mb_duplicate_skin"><div style="padding: 20px 20px 0;">',
			'after'			=>	'</div><div class="clear"></div></span>'
		),

		## Tab Item
		5	=>  array(
			'type'		=>	'vertical_tabs',
			'tab_id' 	=>	'all_visual_sets',
			'tab_title' =>	__('All Visual Sets','cloudfw'),
			'form'	=> 	array(
				'enable'	=> true,
				'ajax'		=> false,
				'sending'	=> true,
				'shortcut'	=> true,
				'selector'	=> PFIX.'_colors',
				'comeback'	=> true
			),		
			'data'		=>	array(
			
				## Container Item
				5	=> array(
					'type'			=>	'container',
					'footer'		=>	false,
					'title'			=>	__('All Visual Sets','cloudfw'),
					'prepend_head'	=>	'
								<div style="float:right; margin-left:20px;">
										<a href="javascript:void(0);" title="'. __('Import','cloudfw') .'" width="m" rel="mb_import_skin" class="small-button small-green help">
											<span>'. __('Import','cloudfw') .'</span>
										</a>
										<a href="#" title="'. __('Create A New Set','cloudfw') .'" width="m" rel="mb_create_skin" class="small-button small-brown help">
											<span>'. __('Create','cloudfw') .'</span>
										</a>
								</div>
					',
					'data'			=>	array(
					
						## Module Item
						5	=> array(
							'type'		=>	'blank',
							'data'		=>	array(
									## Element
									array(
										'type'		=>	'radio',
										'id'		=>	cloudfw_sanitize(PFIX.'_skin'),
										'value'		=>	array(
												'type'		=>	'function',
												'function'	=>	'cloudfw_get_current_skin_ID'
										),
										'source'	=>	array(
												'type'		=>	'function',
												'function'	=>	'cloudfw_admin_get_all_skins_array',
												'send_data'	=>	true,
												'send_args'	=>	true,
										),
										'prepend_results' => array( array(
											'type'		=>	'html',
											'data'		=>	'<div id="cloudfw-skin-sorting" class="cloudfw-ui-list cloudfw-ui-sortable cloudfw-ui-list-labelized">',
										)),
										'append_results' => array( array(
											'type'		=>	'html',
											'data'		=>	'</div>',
										)),
										'no_result'	=>  '<div class="thereisno">'.__('There is no any visual set','cloudfw').'. <a class="help" rel="mb_create_skin" width="m" title="'.esc_attr(__('Create New One','cloudfw')).'" href="javascript:;"><span>'.__('Create New One','cloudfw').'</span></a></div>',
										'prepend_no_result' => '',
										'append_no_result' => '',
										'class'	=>  ' ',
									), // #### element: 0
									
							)

						), 

						100	=> array(
							'type'		=>	'jquery',
							'data'		=>	'

								var skin_sorting = jQuery("#cloudfw-skin-sorting"),
									skin_sorting_button = jQuery("#cloudfw-skin-sort-button");

								skin_sorting.on("sortupdate", function( event, ui ) {
									skin_sorting_button.show();
								});

								skin_sorting_button.click(function(){
									
									// sending button
									var __sending = jQuery(this).__sending();

									var ajaxForm_vars = {
										action: "cloudfw_sort_skins",
										nonce: CloudFwOp.cloudfw_nonce,
									};

									var form_elements 	= skin_sorting.find( "input, textarea, select" ),
										serialized_data = form_elements.serialize();

									cloudfw_global_loading("show");
									jQuery.ajax({
										url: CloudFwOp.ajaxUrl,
										cache: false,
										type: "POST",
										data: (jQuery.param(ajaxForm_vars, true) + "&" + serialized_data),
										success: function(data) {
											try {
												var obj = jQuery.parseJSON(jQuery.trim( data ));									
												cloudfw_dialog(obj.messageTitle,obj.messageText,obj.messageCase);
												
												__sending.success();
												
											} catch (e) {
												//alert(data);
												cloudfw_dialog("Couldn\'t be saved", "An error occurred when saving changes", "error");
												
												__sending.error();
											}
											
											
											skin_sorting_button.hide();
											cloudfw_global_loading("hide");
											cloudfw_destroy();
											
										}  
																				
									});
									
									
									return false;


								});
								
							'

						),
			
					)

				),


				## Module Item
				100	=> array(
					'condition'	=> array(
						'!'				=>	true,
						'type'			=>	'function',
						'function'		=>	'cloudfw_get_all_skins',
					),
					'type'		=>	'submit',
					'layout'	=>	'fixed',
					'text'		=>	__('Set selected one as default','cloudfw'),
					'nomargin'	=> 	true,
					'append'	=>	'<a id="cloudfw-skin-sort-button" class="small-button small-green" style="display:none;" href="javascript:;"><span>'. __('Save sorting','cloudfw') .'</span></a>'
				), 


			)
		), // #### tabs: 5
		
		## Tab Item
		10	=>  array(
			'type'		=>	'vertical_tabs',
			'tab_id' 	=>	'edit_set',
			'tab_title' =>	cloudfw_skin_get_skin_name(),
			'form'	=> 	array(
				'enable'	=> true,
				'id'		=> 'add_skin_form',
				'ajax'		=> true,
				'shortcut'	=> true,
				'selector'	=> PFIX.'_add_skin'
			),		
			'data'		=>	array(
	
				0	=> array(
					'type'	=>	'include',
					'path'	=>	TMP_PATH.'/cloudfw/core/others/source.js.section.php'

				),
				
				## Container Item
				5	=> array(
					'type'			=>	'container',
					'width'			=>	940,

					//'title'			=>	__('Skin Editor','cloudfw'),
					'class'			=>	'framework_container skinApp overflow-visible',
					'header'		=>  false,
					'footer'		=>  false,
					'data'			=>	array(
					
						5	=>  array(
							'type'		=>	'require',
							'path'		=>	TMP_PATH.'/cloudfw/core/engine.skin/source.skin_forms.php'
						)																		
			
					)
				),
	
			)
		),

		array(
			'type'		=>	'vertical_tabs',
			'tab_id' 	=>	'import_export_skins',
			'tab_title' =>	__('Import / Export Skin','cloudfw'),
			'divider'	=>	true,
			'data'			=>	array(		

				## Container Item
				array(
					'type'		=>	'container',
					'title'		=>	__('Import / Export Visual Sets - Color Skins','cloudfw'),
					'footer'	=>	false,
					'data'		=>	array(
					
						## Module Item
						5	=> array(
							'type'		=>	'module',
							'title'		=>	__('Export','cloudfw'),
							'data'		=>	array( 
								5	=>  array(
									'type'		=>	'run',
									'function'	=>	'cloudfw_get_form_export_skin'
								)									
							)
						),
						
						## Module Item
						10	=> array(
							'type'		=>	'module',
							'title'		=>	__('Import','cloudfw'),
							'data'		=>	array( 
								5	=>  array(
									'type'		=>	'run',
									'function'	=>	'cloudfw_get_form_import_skin'
								)
							)
						),
			
					)

				),

			)

		),

		array(
			'type'		=>	'vertical_tabs',
			'tab_id' 	=>	'titlebar_styles',
			'tab_title' =>	__('Title Bar Styles','cloudfw'),
			'form'	=> 	array(
				'enable'	=> true,
				'ajax'		=> true,
				'shortcut'	=> true,
			),
			'data'			=>	array(		

				## Container Item
				array(
					'type'		=>	'container',
					'title'		=>	__('Title Bar Styles','cloudfw'),
					'footer'	=>	false,
					'data'		=>	array(


	                    array(
	                        'type'      => 'module',
	                        'title'     => __('Default Style','cloudfw'),
	                        'data'      => array(

	                            ## Element
	                            array(
	                                'type'      =>  'select',
									'id'		=>	cloudfw_sanitize(PFIX.'_titlebar_default'),
									'value'		=>	cloudfw_get_option('titlebar_default'),
	                                'source'    =>  array(
	                                    'type'          => 'function',
	                                    'function'      => 'cloudfw_admin_loop_titlebar_styles',
	                                    'vars'			=> array( __('- Not Set -','cloudfw') )
	                                ),
	                                'width'     =>  300,
	                            )

	                        )

	                    ),

	                    array(
	                        'type'      => 'divider',
	                    ),


						array(
							'type'		=>	'sorting',
							'id'		=>	'topbar_widget_social_sorting',
							'data'		=>  

								cloudfw_core_loop_multi_option( 
									
									array(
										'indicator' => cloudfw_get_option('titlebar_styles', 'indicator'),
										'data' 		=> 
											array(
												'type'		=>	'module-set',
												'id'		=>	'',
												'title'		=>	'<span class="font-title"></span>',
												'closable'	=>	true,
												'state'		=>	'closed',
												'title_right'=>	'
													<a class="small-button small-grey cloudfw-action-only-duplicate" data-to-reset="'. cloudfw_sanitize(PFIX.'_titlebar_styles indicator') .'" href="javascript:;"><span>'.__('Duplicate','cloudfw').'</span></a>
													<a class="small-button small-grey cloudfw-action-remove" data-target="li" href="javascript:;"><span>'.__('Delete','cloudfw').'</span></a>
												',
												'data'		=>	array(

													array(
														'type'		=>	'randomizer',
														'id'		=>	cloudfw_sanitize(PFIX.'_titlebar_styles indicator'),
														'value'		=>	cloudfw_get_option('titlebar_styles', 'indicator'),
														'brackets'	=> 	true,
														'prefix'	=>	'titlebar-',
														'chars'		=>	'09-az',
														'length'	=>	5,
														'reset'		=>	'',
													),


													## Module Item
													array(
														'type'		=>	'module',
														'title'		=>	__('Style Name','cloudfw'),
														'data'		=>	array(
															## Element
															array(
																'type'		=>	'text',
																'id'		=>	cloudfw_sanitize(PFIX.'_titlebar_styles name'),
																'value'		=>	cloudfw_get_option('titlebar_styles', 'name'),
																'reset'		=>	'',
																'class'		=>	'input bold',
																'width'		=>	300,
																'brackets'	=>	true

															), // #### element: 0

														)

													),

													## Section
													array(
														'type'		=>	'mini-section',
														'title'		=>	__('Background','cloudfw'),
														'data'		=>	array(
														
															## Module Item
															array(
																'type'		=>	'module',
																'title'		=>	__('Background Image','cloudfw'),
																'data'		=>	array(
																	## Element
																	array(
																		'type'		=>	'upload',
																		'id'		=>	cloudfw_sanitize(PFIX.'_titlebar_styles background_image'),
																		'value'		=>	cloudfw_get_option('titlebar_styles', 'background_image'),
																		'reset'		=>	'',
																		'hide_input'=>	true,
																		'removable'	=>	true,
																		'store'		=>	true,
																		'library'	=>	true,
																		'brackets'	=>	true,

																	), // #### element: 0

																)

															),

															## Module Item
															array(
																'type'		=>	'module',
																'title'		=>	array( __('Background Color','cloudfw'), __('Background Style','cloudfw') ),
																'layout'	=>	'split',
																'data'		=>	array(
																	## Element
																	array(
																		'type'		=>	'color',
																		'style'		=>	'horizontal',
																		'id'		=>	cloudfw_sanitize(PFIX.'_titlebar_styles background_color'),
																		'value'		=>	cloudfw_get_option('titlebar_styles', 'background_color'),
																		'reset'		=>	'',
																		'brackets'	=>	true,

																	), // #### element: 0

																	## Element
																	array(
																		'type'		=>	'select',
																		'id'		=>	cloudfw_sanitize(PFIX.'_titlebar_styles background_style'),
																		'value'		=>	cloudfw_get_option('titlebar_styles', 'background_style'),
																		'source'	=>	array(
																			'NULL'		=>	__('Cover','cloudfw'),
																			'repeat'	=>	__('Repeated Image','cloudfw'),
																		),
																		'reset'		=>	'',
																		'brackets'	=>	true,
																		'width'		=>	200

																	), // #### element: 0

																)

															),

															## Module Item
															array(
																'type'		=>	'module',
																'title'		=>	array( __('Background Position','cloudfw'), __('Parallax Effect','cloudfw')),
																'layout'	=>	'split',
																'data'		=>	array(

																	## Element
																	array(
																		'type'		=>	'select',
																		'id'		=>	cloudfw_sanitize(PFIX.'_titlebar_styles background_position'),
																		'value'		=>	cloudfw_get_option('titlebar_styles', 'background_position'),
																		'source'	=>	array(
																			'type'		=>	'function',
																			'function'	=>	'cloudfw_admin_loop_background_positions',
																		),
																		'reset'		=>	'',
																		'brackets'	=>	true,
																		'width'		=>	160

																	), // #### element: 0
									

																	## Element
																	array(
																		'type'		=>	'select',
																		'id'		=>	cloudfw_sanitize(PFIX.'_titlebar_styles parallax'),
																		'value'		=>	cloudfw_get_option('titlebar_styles', 'parallax'),
																		'source'	=>	array(
																			'NULL'		=>	__('No','cloudfw'),
																			'yes'		=>	__('Yes','cloudfw'),
																		),
																		'reset'		=>	'',
																		'brackets'	=>	true,
																		'width'		=>	200

																	), // #### element: 0

																)

															),

														)

													),

													## Section
													array(
														'type'		=>	'mini-section',
														'title'		=>	__('Border','cloudfw'),
														'data'		=>	array(

															## Module Item
															array(
																'type'		=>	'module',
																'title'		=>	 __('Border Bottom','cloudfw'),
																'data'		=>	array(
																	## Element
																	array(
																		'type'		=>	'color',
																		'style'		=>	'horizontal',
																		'id'		=>	cloudfw_sanitize(PFIX.'_titlebar_styles border_bottom'),
																		'value'		=>	cloudfw_get_option('titlebar_styles', 'border_bottom'),
																		'reset'		=>	'',
																		'brackets'	=>	true,

																	), // #### element: 0

																)

															),

														)

													),

													## Section
													array(
														'type'		=>	'mini-section',
														'title'		=>	__('Texts','cloudfw'),
														'data'		=>	array(

															## Module Item
															array(
																'type'		=>	'module',
																'title'		=>	array( __('Title Color','cloudfw'), __('Text Color','cloudfw') ),
																'layout'	=>	'split',
																'data'		=>	array(
																	## Element
																	array(
																		'type'		=>	'color',
																		'style'		=>	'horizontal',
																		'id'		=>	cloudfw_sanitize(PFIX.'_titlebar_styles title_color'),
																		'value'		=>	cloudfw_get_option('titlebar_styles', 'title_color'),
																		'reset'		=>	'',
																		'brackets'	=>	true,

																	), // #### element: 0

																	## Element
																	array(
																		'type'		=>	'color',
																		'style'		=>	'horizontal',
																		'id'		=>	cloudfw_sanitize(PFIX.'_titlebar_styles color'),
																		'value'		=>	cloudfw_get_option('titlebar_styles', 'color'),
																		'reset'		=>	'',
																		'brackets'	=>	true,

																	), // #### element: 0

																)

															),

														)

													),

													## Section
													array(
														'type'		=>	'mini-section',
														'title'		=>	__('Links','cloudfw'),
														'data'		=>	array(

															## Module Item
															array(
																'type'		=>	'module',
																'title'		=>	array( __('Link Color','cloudfw'), __('Link Decoration','cloudfw') ),
																'layout'	=>	'split',
																'data'		=>	array(
																	## Element
																	array(
																		'type'		=>	'color',
																		'style'		=>	'horizontal',
																		'id'		=>	cloudfw_sanitize(PFIX.'_titlebar_styles link_color'),
																		'value'		=>	cloudfw_get_option('titlebar_styles', 'link_color'),
																		'reset'		=>	'',
																		'brackets'	=>	true,

																	), // #### element: 0

																	## Element
																	array(
																		'type'		=>	'select',
																		'id'		=>	cloudfw_sanitize(PFIX.'_titlebar_styles link_decoration'),
																		'value'		=>	cloudfw_get_option('titlebar_styles', 'link_decoration'),
																		'source'	=>	array(
																			'type'		=> 'function',
																			'function'		=> 'cloudfw_admin_array_text_decorations',
																		),
																		'reset'		=>	'',
																		'brackets'	=>	true,
																		'width'		=>	200

																	), // #### element: 0

																)

															),

															## Module Item
															array(
																'type'		=>	'module',
																'title'		=>	array( __('Link Hover Color','cloudfw'), __('Link Hover Decoration','cloudfw') ),
																'layout'	=>	'split',
																'data'		=>	array(
																	## Element
																	array(
																		'type'		=>	'color',
																		'style'		=>	'horizontal',
																		'id'		=>	cloudfw_sanitize(PFIX.'_titlebar_styles link_hover_color'),
																		'value'		=>	cloudfw_get_option('titlebar_styles', 'link_hover_color'),
																		'reset'		=>	'',
																		'brackets'	=>	true,

																	), // #### element: 0

																	## Element
																	array(
																		'type'		=>	'select',
																		'id'		=>	cloudfw_sanitize(PFIX.'_titlebar_styles link_hover_decoration'),
																		'value'		=>	cloudfw_get_option('titlebar_styles', 'link_hover_decoration'),
																		'source'	=>	array(
																			'type'		=> 'function',
																			'function'		=> 'cloudfw_admin_array_text_decorations',
																		),
																		'reset'		=>	'',
																		'brackets'	=>	true,
																		'width'		=>	200

																	), // #### element: 0


																)

															),

														)

													),


													## Section
													array(
														'type'		=>	'mini-section',
														'title'		=>	__('BreadCrumb','cloudfw'),
														'data'		=>	array(


															## Module Item
															array(
																'type'		=>	'module',
																'title'		=>	array( __('BreadCrumb Background','cloudfw'), __('BreadCrumb Border Color','cloudfw') ),
																'layout'	=>	'split',
																'data'		=>	array(
																	## Element
																	array(
																		'type'		=>	'color',
																		'style'		=>	'horizontal',
																		'id'		=>	cloudfw_sanitize(PFIX.'_titlebar_styles bc_background_color'),
																		'value'		=>	cloudfw_get_option('titlebar_styles', 'bc_background_color'),
																		'reset'		=>	'',
																		'brackets'	=>	true,

																	), // #### element: 0

																	## Element
																	array(
																		'type'		=>	'color',
																		'style'		=>	'horizontal',
																		'id'		=>	cloudfw_sanitize(PFIX.'_titlebar_styles bc_border_color'),
																		'value'		=>	cloudfw_get_option('titlebar_styles', 'bc_border_color'),
																		'reset'		=>	'',
																		'brackets'	=>	true,

																	), // #### element: 0

																)

															),


															## Module Item
															array(
																'type'		=>	'module',
																'title'		=>	array( __('BreadCrumb Link Color','cloudfw'), __('BreadCrumb Link Hover Color','cloudfw') ),
																'layout'	=>	'split',
																'data'		=>	array(
																	## Element
																	array(
																		'type'		=>	'color',
																		'style'		=>	'horizontal',
																		'id'		=>	cloudfw_sanitize(PFIX.'_titlebar_styles bc_link_color'),
																		'value'		=>	cloudfw_get_option('titlebar_styles', 'bc_link_color'),
																		'reset'		=>	'',
																		'brackets'	=>	true,

																	), // #### element: 0

																	## Element
																	array(
																		'type'		=>	'color',
																		'style'		=>	'horizontal',
																		'id'		=>	cloudfw_sanitize(PFIX.'_titlebar_styles bc_link_hover_color'),
																		'value'		=>	cloudfw_get_option('titlebar_styles', 'bc_link_hover_color'),
																		'reset'		=>	'',
																		'brackets'	=>	true,

																	), // #### element: 0

																)

															),


														)

													),


													## Section
													array(
														'type'		=>	'mini-section',
														'title'		=>	__('Paddings','cloudfw'),
														'data'		=>	array(

															## Module Item
															array(
																'type'		=>	'module',
																'title'		=>	array( __('Padding Top','cloudfw'), __('Padding Bottom','cloudfw') ),
																'layout'	=>	'split',
																'data'		=>	array(

																	## Element
																	array(
																		'type'		=>	'text',
																		'id'		=>	cloudfw_sanitize(PFIX.'_titlebar_styles padding_top'),
																		'value'		=>	cloudfw_get_option('titlebar_styles', 'padding_top'),
																		'unit'		=>	'px',
																		'width'		=>	50,
																		'reset'		=>	'',
																		'brackets'	=>	true

																	), // #### element: 0

																	## Element
																	array(
																		'type'		=>	'text',
																		'id'		=>	cloudfw_sanitize(PFIX.'_titlebar_styles padding_bottom'),
																		'value'		=>	cloudfw_get_option('titlebar_styles', 'padding_bottom'),
																		'unit'		=>	'px',
																		'width'		=>	50,
																		'reset'		=>	'',
																		'brackets'	=>	true


																	), // #### element: 0


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
							'type'		=>	'module',
							'layout'	=>	'raw',
							'divider'	=>	false,
							'data'		=>	array(
											
								## Element
								array(
									'type'		=>	'html',
									'data'		=>	'<a data-target="#topbar_widget_social_sorting" class="cloudfw-action-duplicate cloudfw-ui-button cloudfw-ui-button-metro cloudfw-ui-button-metro-green" href="javascript:;"><span>'.__('+ Add New Style','cloudfw').'</span></a>',
								), // #### element: 0

							)
						),

						array(
							'type'		=> 'jquery',
							'data'		=> '

								/** Add event listener for font titles */
								jQuery(document).delegate("[name=\''. cloudfw_sanitize(PFIX.'_titlebar_styles name') .'[]\']", "keyup keydown" ,function(e){
									var element 	= jQuery(this),
										container 	= element.parents(".module-set"),
										title 		= container.find(".font-title"),
										value 		= element.val();

									if ( value == "" )
										value = "<span>'. esc_attr(__('Unnamed Title Bar Style','cloudfw')) .'</span>"; 

									title.html( value );

								});

								jQuery("[name=\''. cloudfw_sanitize(PFIX.'_titlebar_styles name') .'[]\']").keyup();

							'
						)
					
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


		array(
			'type'		=>	'vertical_tabs',
			'tab_id' 	=>	'section_styles',
			'tab_title' =>	__('Section Styles','cloudfw'),
			'form'	=> 	array(
				'enable'	=> true,
				'ajax'		=> true,
				'shortcut'	=> true,
			),
			'data'			=>	array(		

				## Container Item
				array(
					'type'		=>	'container',
					'title'		=>	__('Section Styles','cloudfw'),
					'footer'	=>	false,
					'data'		=>	array(

						array(
							'type'		=>	'sorting',
							'id'		=>	'section_styles_sorting',
							'data'		=>  

								cloudfw_core_loop_multi_option( 
									
									array(
										'indicator' => cloudfw_get_option('section_styles', 'indicator'),
										'data' 		=> 
											array(
												'type'		=>	'module-set',
												'id'		=>	'',
												'title'		=>	'<span class="font-title"></span>',
												'closable'	=>	true,
												'state'		=>	'closed',
												'title_right'=>	'
													<a class="small-button small-grey cloudfw-action-only-duplicate" href="javascript:;"><span>'.__('Duplicate','cloudfw').'</span></a>
													<a class="small-button small-grey cloudfw-action-remove" data-target="li" href="javascript:;"><span>'.__('Delete','cloudfw').'</span></a>
												',
												'data'		=>	array(

													array(
														'type'		=>	'randomizer',
														'id'		=>	cloudfw_sanitize(PFIX.'_section_styles indicator'),
														'value'		=>	cloudfw_get_option('section_styles', 'indicator'),
														'brackets'	=> 	true,
														'prefix'	=>	'section-',
														'chars'		=>	'09-az',
														'length'	=>	5,
														'reset'		=>	'',
													),


													## Module Item
													array(
														'type'		=>	'module',
														'title'		=>	__('Style Name','cloudfw'),
														'data'		=>	array(
															## Element
															array(
																'type'		=>	'text',
																'id'		=>	cloudfw_sanitize(PFIX.'_section_styles name'),
																'value'		=>	cloudfw_get_option('section_styles', 'name'),
																'reset'		=>	'',
																'class'		=>	'input bold',
																'width'		=>	300,
																'brackets'	=>	true

															), // #### element: 0

														)

													),

													## Section
													array(
														'type'		=>	'mini-section',
														'title'		=>	__('Background','cloudfw'),
														'data'		=>	array(
														
															## Module Item
															array(
																'type'		=>	'module',
																'title'		=>	__('Background Image','cloudfw'),
																'data'		=>	array(
																	## Element
																	array(
																		'type'		=>	'upload',
																		'id'		=>	cloudfw_sanitize(PFIX.'_section_styles background_image'),
																		'value'		=>	cloudfw_get_option('section_styles', 'background_image'),
																		'reset'		=>	'',
																		'hide_input'=>	true,
																		'removable'	=>	true,
																		'store'		=>	true,
																		'library'	=>	true,
																		'brackets'	=>	true,

																	), // #### element: 0

																)

															),

															## Module Item
															array(
																'type'		=>	'module',
																'title'		=>	array( __('Background Color','cloudfw'), __('Background Style','cloudfw') ),
																'layout'	=>	'split',
																'data'		=>	array(
																	## Element
																	array(
																		'type'		=>	'gradient',
																		'id'		=>	cloudfw_sanitize(PFIX.'_section_styles gradient'),
																		'value'		=>	array(
																			cloudfw_get_option('section_styles', 'gradient_0'), 
																			cloudfw_get_option('section_styles', 'gradient_1')
																		),
																		'reset'		=>	'',
																		'brackets'	=>	true,

																	), // #### element: 0

																	## Element
																	array(
																		'type'		=>	'select',
																		'id'		=>	cloudfw_sanitize(PFIX.'_section_styles background_style'),
																		'value'		=>	cloudfw_get_option('section_styles', 'background_style'),
																		'source'	=>	array(
																			'type'		=>	'function',
																			'function'	=>	'cloudfw_admin_array_bg_styles',
																		),
																		'reset'		=>	'',
																		'brackets'	=>	true,
																		'width'		=>	200

																	), // #### element: 0

																)

															),

															## Module Item
															array(
																'type'		=>	'module',
																'title'		=>	array( __('Background Position','cloudfw'), __('Parallax Effect','cloudfw')),
																'layout'	=>	'split',
																'data'		=>	array(

																	## Element
																	array(
																		'type'		=>	'select',
																		'id'		=>	cloudfw_sanitize(PFIX.'_section_styles background_position'),
																		'value'		=>	cloudfw_get_option('section_styles', 'background_position'),
																		'source'	=>	array(
																			'type'		=>	'function',
																			'function'	=>	'cloudfw_admin_loop_background_positions',
																		),
																		'reset'		=>	'',
																		'brackets'	=>	true,
																		'width'		=>	160

																	), // #### element: 0
									

																	## Element
																	array(
																		'type'		=>	'select',
																		'id'		=>	cloudfw_sanitize(PFIX.'_section_styles parallax'),
																		'value'		=>	cloudfw_get_option('section_styles', 'parallax'),
																		'source'	=>	array(
																			'NULL'		=>	__('No','cloudfw'),
																			'yes'		=>	__('Yes','cloudfw'),
																		),
																		'reset'		=>	'',
																		'brackets'	=>	true,
																		'width'		=>	200

																	), // #### element: 0

																)

															),

														)
													),

													## Section
													array(
														'type'		=>	'mini-section',
														'title'		=>	__('Borders','cloudfw'),
														'data'		=>	array(

															## Module Item
															array(
																'type'		=>	'module',
																'title'		=>	array( __('Border Top Color','cloudfw'), __('Border Bottom Color','cloudfw') ),
																'layout'	=>	'split',
																'data'		=>	array(
																	## Element
																	array(
																		'type'		=>	'color',
																		'style'		=>	'horizontal',
																		'id'		=>	cloudfw_sanitize(PFIX.'_section_styles border_top'),
																		'value'		=>	cloudfw_get_option('section_styles', 'border_top'),
																		'reset'		=>	'',
																		'brackets'	=>	true,

																	), // #### element: 0

																	## Element
																	array(
																		'type'		=>	'color',
																		'style'		=>	'horizontal',
																		'id'		=>	cloudfw_sanitize(PFIX.'_section_styles border_bottom'),
																		'value'		=>	cloudfw_get_option('section_styles', 'border_bottom'),
																		'reset'		=>	'',
																		'brackets'	=>	true,

																	), // #### element: 0

																)

															),

														)

													),



													## Section
													array(
														'type'		=>	'mini-section',
														'title'		=>	__('Texts','cloudfw'),
														'data'		=>	array(

															## Module Item
															array(
																'type'		=>	'module',
																'title'		=>	array( __('Heading Color','cloudfw'), __('Text Color','cloudfw') ),
																'layout'	=>	'split',
																'data'		=>	array(
																	## Element
																	array(
																		'type'		=>	'color',
																		'style'		=>	'horizontal',
																		'id'		=>	cloudfw_sanitize(PFIX.'_section_styles heading_color'),
																		'value'		=>	cloudfw_get_option('section_styles', 'heading_color'),
																		'reset'		=>	'',
																		'brackets'	=>	true,

																	), // #### element: 0

																	## Element
																	array(
																		'type'		=>	'color',
																		'style'		=>	'horizontal',
																		'id'		=>	cloudfw_sanitize(PFIX.'_section_styles color'),
																		'value'		=>	cloudfw_get_option('section_styles', 'color'),
																		'reset'		=>	'',
																		'brackets'	=>	true,

																	), // #### element: 0

																)

															),

														)

													),

													## Section
													array(
														'type'		=>	'mini-section',
														'title'		=>	__('Links','cloudfw'),
														'data'		=>	array(

															## Module Item
															array(
																'type'		=>	'module',
																'title'		=>	array( __('Link Color','cloudfw'), __('Link Decoration','cloudfw') ),
																'layout'	=>	'split',
																'data'		=>	array(
																	## Element
																	array(
																		'type'		=>	'color',
																		'style'		=>	'horizontal',
																		'id'		=>	cloudfw_sanitize(PFIX.'_section_styles link_color'),
																		'value'		=>	cloudfw_get_option('section_styles', 'link_color'),
																		'reset'		=>	'',
																		'brackets'	=>	true,

																	), // #### element: 0

																	## Element
																	array(
																		'type'		=>	'select',
																		'id'		=>	cloudfw_sanitize(PFIX.'_section_styles link_decoration'),
																		'value'		=>	cloudfw_get_option('section_styles', 'link_decoration'),
																		'source'	=>	array(
																			'type'		=> 'function',
																			'function'		=> 'cloudfw_admin_array_text_decorations',
																		),
																		'reset'		=>	'',
																		'brackets'	=>	true,
																		'width'		=>	200

																	), // #### element: 0

																)

															),

															## Module Item
															array(
																'type'		=>	'module',
																'title'		=>	array( __('Link Hover Color','cloudfw'), __('Link Hover Decoration','cloudfw') ),
																'layout'	=>	'split',
																'data'		=>	array(
																	## Element
																	array(
																		'type'		=>	'color',
																		'style'		=>	'horizontal',
																		'id'		=>	cloudfw_sanitize(PFIX.'_section_styles link_hover_color'),
																		'value'		=>	cloudfw_get_option('section_styles', 'link_hover_color'),
																		'reset'		=>	'',
																		'brackets'	=>	true,

																	), // #### element: 0

																	## Element
																	array(
																		'type'		=>	'select',
																		'id'		=>	cloudfw_sanitize(PFIX.'_section_styles link_hover_decoration'),
																		'value'		=>	cloudfw_get_option('section_styles', 'link_hover_decoration'),
																		'source'	=>	array(
																			'type'		=> 'function',
																			'function'		=> 'cloudfw_admin_array_text_decorations',
																		),
																		'reset'		=>	'',
																		'brackets'	=>	true,
																		'width'		=>	200

																	), // #### element: 0


																)

															),

														)

													),


													## Section
													array(
														'type'		=>	'mini-section',
														'title'		=>	__('Shadow','cloudfw'),
														'data'		=>	array(

															## Module Item
															array(
																'type'		=>	'module',
																'title'		=>	__('Shadow Style','cloudfw'),
																'data'		=>	array(
																	## Element
																	array(
																		'type'		=>	'select',
																		'id'		=>	cloudfw_sanitize(PFIX.'_section_styles shadow_style'),
																		'value'		=>	cloudfw_get_option('section_styles', 'shadow_style'),
																		'source'	=>	array(
																			'NULL'				=> __('No Shadow','cloudfw'),
																			'inner-shadow-1'	=> __('Inner Shadow 1','cloudfw'),
																			'inner-shadow-2'		=> __('Inner Shadow 2','cloudfw'),
																			'inner-shadow-3'	=> __('Inner Shadow 3','cloudfw'),
																			'outer-shadow-1'	=> __('Outer Shadow 1','cloudfw'),
																			'outer-shadow-2'		=> __('Outer Shadow 2','cloudfw'),
																			'outer-shadow-3'	=> __('Outer Shadow 3','cloudfw'),
																		),
																		'width'		=>	250,
																		'reset'		=>	'',
																		'brackets'	=>	true,
																		'desc'		=>	__('Only works on modern browsers.','cloudfw')

																	), // #### element: 0

																)

															),

														)

													),

													## Section
													array(
														'type'		=>	'mini-section',
														'title'		=>	__('Other Options','cloudfw'),
														'data'		=>	array(

															## Module Item
															array(
																'type'		=>	'module',
																'title'		=>	__('Overflow','cloudfw'),
																'data'		=>	array(
																	## Element
																	array(
																		'type'		=>	'select',
																		'id'		=>	cloudfw_sanitize(PFIX.'_section_styles overflow'),
																		'value'		=>	cloudfw_get_option('section_styles', 'overflow'),
																		'source'	=>	array(
																			'type'				=> 'function',
																			'function'			=> 'cloudfw_admin_loop_overflow',
																		),
																		'width'		=>	250,
																		'reset'		=>	'',
																		'brackets'	=>	true,

																	), // #### element: 0

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
							'type'		=>	'module',
							'layout'	=>	'raw',
							'divider'	=>	false,
							'data'		=>	array(
											
								## Element
								array(
									'type'		=>	'html',
									'data'		=>	'<a data-target="#section_styles_sorting" class="cloudfw-action-duplicate cloudfw-ui-button cloudfw-ui-button-metro cloudfw-ui-button-metro-green" href="javascript:;"><span>'.__('+ Add New Style','cloudfw').'</span></a>',
								), // #### element: 0

							)
						),

						array(
							'type'		=> 'jquery',
							'data'		=> '

								/** Add event listener for font titles */
								jQuery(document).delegate("[name=\''. cloudfw_sanitize(PFIX.'_section_styles name') .'[]\']", "keyup keydown" ,function(e){
									var element 	= jQuery(this),
										container 	= element.parents(".module-set"),
										title 		= container.find(".font-title"),
										value 		= element.val();

									if ( value == "" )
										value = "<span>'. esc_attr(__('Unnamed Section Style','cloudfw')) .'</span>"; 

									title.html( value );

								});

								jQuery("[name=\''. cloudfw_sanitize(PFIX.'_section_styles name') .'[]\']").keyup();

							'
						)
					
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


		array(
			'type'		=>	'vertical_tabs',
			'tab_id' 	=>	'button_colors',
			'tab_title' =>	__('Button Colors','cloudfw'),
			'form'	=> 	array(
				'enable'	=> true,
				'ajax'		=> true,
				'shortcut'	=> true,
			),
			'data'			=>	array(		

				## Container Item
				array(
					'type'		=>	'container',
					'title'		=>	__('Button Colors','cloudfw'),
					'footer'	=>	false,
					'data'		=>	array(


						array(
							'type'		=>	'sorting',
							'id'		=>	'button_colors_sorting',
							'data'		=>  

								cloudfw_core_loop_multi_option( 
									
									array(
										'indicator' => cloudfw_get_option('button_colors', 'indicator'),
										'data' 		=> 
											array(
												'type'		=>	'module-set',
												'title'		=>	'<span class="button-color-title"></span>',
												'closable'	=>	true,
												'state'		=>	'closed',
												'title_right'=>	'
													<a class="small-button small-grey cloudfw-action-only-duplicate" href="javascript:;"><span>'.__('Duplicate','cloudfw').'</span></a>
													<a class="small-button small-grey cloudfw-action-remove" data-target="li" href="javascript:;"><span>'.__('Delete','cloudfw').'</span></a>
												',
												'data'		=>	array(

													array(
														'type'		=>	'randomizer',
														'id'		=>	cloudfw_sanitize(PFIX.'_button_colors indicator'),
														'value'		=>	cloudfw_get_option('button_colors', 'indicator'),
														'brackets'	=> 	true,
														'prefix'	=>	'btn-',
														'chars'		=>	'09-az',
														'length'	=>	10,
														'reset'		=>	'',
													),


													## Module Item
													array(
														'type'		=>	'module',
														'title'		=>	__('Color Name','cloudfw'),
														'data'		=>	array(
															## Element
															array(
																'type'		=>	'text',
																'id'		=>	cloudfw_sanitize(PFIX.'_button_colors name'),
																'value'		=>	cloudfw_get_option('button_colors', 'name'),
																'reset'		=>	'',
																'class'		=>	'input bold',
																'width'		=>	300,
																'brackets'	=>	true

															), // #### element: 0

														)

													),


													## Module Item
													array(
														'type'		=>	'mini-section',
														'title'		=>	__('Background','cloudfw'),
														'data'		=>	array(

															## Module Item
															array(
																'type'		=>	'module',
																'title'		=>	__('Background Gradient','cloudfw'),
																'data'		=>	array(
																	## Element
																	array(
																		'type'		=>	'gradient',
																		'id'		=>	cloudfw_sanitize(PFIX.'_button_colors gradient'),
																		'value'		=>	array(
																			cloudfw_get_option('button_colors', 'gradient_0'), 
																			cloudfw_get_option('button_colors', 'gradient_1')
																		),
																		'reset'		=>	'',
																		'brackets'	=>	true
																	), // #### element: 0

																)

															),

														)

													),

													## Module Item
													array(
														'type'		=>	'mini-section',
														'title'		=>	__('Normal','cloudfw'),
														'data'		=>	array(

															## Module Item
															array(
																'type'		=>	'module',
																'title'		=>	array( __('Text Color','cloudfw'), __('Border Color','cloudfw')),
																'layout'	=>	'split',
																'data'		=>	array(
																	## Element
																	array(
																		'type'		=>	'color',
																		'style'		=>	'horizontal',
																		'id'		=>	cloudfw_sanitize(PFIX.'_button_colors color'),
																		'value'		=>	cloudfw_get_option('button_colors', 'color'),
																		'reset'		=>	'',
																		'brackets'	=>	true,

																	),

																	## Element
																	array(
																		'type'		=>	'color',
																		'style'		=>	'horizontal',
																		'id'		=>	cloudfw_sanitize(PFIX.'_button_colors border_color'),
																		'value'		=>	cloudfw_get_option('button_colors', 'border_color'),
																		'reset'		=>	'',
																		'brackets'	=>	true,

																	),

																)

															),


															## Module Item
															array(
																'type'		=>	'module',
																'title'		=>	array( __('Text Shadow Color','cloudfw'), __('Text Shadow Direction','cloudfw')),
																'layout'	=>	'split',
																'data'		=>	array(
																	## Element
																	array(
																		'type'		=>	'color',
																		'style'		=>	'horizontal',
																		'id'		=>	cloudfw_sanitize(PFIX.'_button_colors shadow_color'),
																		'value'		=>	cloudfw_get_option('button_colors', 'shadow_color'),
																		'reset'		=>	'',
																		'brackets'	=>	true,

																	),

																	## Element
																	array(
																		'type'		=>	'select',
																		'style'		=>	'horizontal',
																		'id'		=>	cloudfw_sanitize(PFIX.'_button_colors shadow_direction'),
																		'value'		=>	cloudfw_get_option('button_colors', 'shadow_direction'),
																		'source'	=>	array(
																			'-1'		=>	__('Top','cloudfw'),
																			'1'			=>	__('Bottom','cloudfw'),
																		),
																		'reset'		=>	'',
																		'brackets'	=>	true,
																		'width'		=>	120,

																	),

																)

															),

														)

													),

													## Module Item
													array(
														'type'		=>	'mini-section',
														'title'		=>	__('Hover','cloudfw'),
														'data'		=>	array(

															## Module Item
															array(
																'type'		=>	'module',
																'title'		=>	__('Background Gradient','cloudfw'),
																'data'		=>	array(
																	## Element
																	array(
																		'type'		=>	'gradient',
																		'id'		=>	cloudfw_sanitize(PFIX.'_button_colors gradient_hover'),
																		'value'		=>	array(
																			cloudfw_get_option('button_colors', 'gradient_hover_0'), 
																			cloudfw_get_option('button_colors', 'gradient_hover_1')
																		),
																		'reset'		=>	'',
																		'brackets'	=>	true
																	), // #### element: 0

																)

															),

															## Module Item
															array(
																'type'		=>	'module',
																'title'		=>	array( __('Text Color','cloudfw'), __('Border Color','cloudfw')),
																'layout'	=>	'split',
																'data'		=>	array(
																	## Element
																	array(
																		'type'		=>	'color',
																		'style'		=>	'horizontal',
																		'id'		=>	cloudfw_sanitize(PFIX.'_button_colors color_hover'),
																		'value'		=>	cloudfw_get_option('button_colors', 'color_hover'),
																		'reset'		=>	'',
																		'brackets'	=>	true,

																	),

																	## Element
																	array(
																		'type'		=>	'color',
																		'style'		=>	'horizontal',
																		'id'		=>	cloudfw_sanitize(PFIX.'_button_colors border_color_hover'),
																		'value'		=>	cloudfw_get_option('button_colors', 'border_color_hover'),
																		'reset'		=>	'',
																		'brackets'	=>	true,

																	),

																)

															),


															## Module Item
															array(
																'type'		=>	'module',
																'title'		=>	array( __('Text Shadow Color','cloudfw'), __('Text Shadow Direction','cloudfw')),
																'layout'	=>	'split',
																'data'		=>	array(
																	## Element
																	array(
																		'type'		=>	'color',
																		'style'		=>	'horizontal',
																		'id'		=>	cloudfw_sanitize(PFIX.'_button_colors shadow_color_hover'),
																		'value'		=>	cloudfw_get_option('button_colors', 'shadow_color_hover'),
																		'reset'		=>	'',
																		'brackets'	=>	true,

																	),

																	## Element
																	array(
																		'type'		=>	'select',
																		'style'		=>	'horizontal',
																		'id'		=>	cloudfw_sanitize(PFIX.'_button_colors shadow_direction_hover'),
																		'value'		=>	cloudfw_get_option('button_colors', 'shadow_direction_hover'),
																		'source'	=>	array(
																			'-1'		=>	__('Top','cloudfw'),
																			'1'			=>	__('Bottom','cloudfw'),
																		),
																		'reset'		=>	'',
																		'brackets'	=>	true,
																		'width'		=>	120,

																	),

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
							'type'		=>	'module',
							'layout'	=>	'raw',
							'divider'	=>	false,
							'data'		=>	array(
											
								## Element
								array(
									'type'		=>	'html',
									'data'		=>	'<a data-target="#button_colors_sorting" class="cloudfw-action-duplicate cloudfw-ui-button cloudfw-ui-button-metro cloudfw-ui-button-metro-green" href="javascript:;"><span>'.__('+ Add New Button Color','cloudfw').'</span></a>',
								), // #### element: 0

							)
						),

						array(
							'type'		=> 'jquery',
							'data'		=> '

								/** Add event listener for font titles */
								jQuery(document).delegate("[name=\''. cloudfw_sanitize(PFIX.'_button_colors name') .'[]\']", "keyup keydown" ,function(e){
									var element 	= jQuery(this),
										container 	= element.parents(".module-set"),
										title 		= container.find(".button-color-title"),
										value 		= element.val();

									if ( value == "" )
										value = "<span>'. esc_attr(__('Unnamed Color','cloudfw')) .'</span>"; 

									title.html( value );

								});

								jQuery("[name=\''. cloudfw_sanitize(PFIX.'_button_colors name') .'[]\']").keyup();

							'
						)
					
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
	
	) // page -> data
	
);