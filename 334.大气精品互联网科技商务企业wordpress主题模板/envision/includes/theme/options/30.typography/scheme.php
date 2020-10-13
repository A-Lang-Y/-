<?php

$scheme[ cloudfw_id_for_sequence( $scheme, $number ) ] = array(
	'type'		=> 'page',
	'page' 		=> 'typography',
	'typography'		=> array(
		'page_title' 	=>	__('Typography','cloudfw'),
		'page_nice_title'=>	__('typography','cloudfw'),
		'page_slug' 	=>	'typography',
		'page_css_id' 	=>	'cloud_nav_fonts',
		'load_file'		=>	array( array(
				'type'		=>	'require',
				'path'		=>	TMP_PATH.'/cloudfw/core/engine.typo/source.typography.php'
			) ),

	),
	'data'	=> array(
		0	=> array(
			'type'	=>	'include',
			'path'	=>	TMP_PATH.'/cloudfw/core/engine.typo/source.js.typo.php'
		),

		1	=>  array(
			'type'		=>	'run',
			'function'	=>	'cloudfw_fontface_get_fonts'
		),

		## Tab Item
		5	=>  array(
			'type'		=>	'vertical_tabs',
			'tab_id' 	=>	'typography_options',
			'tab_title' =>	__('Customize','cloudfw'),
			'form'	=> 	array(
				'enable'	=> true,
				'ajax'		=> true,
				'selector'	=> PFIX.'_font_settings_customize',
				'shortcut'	=> true
			),		
			'data'		=>	array(
			
				5	=>  array(
					'type'		=>	'run',
					'function'	=>	'cloudfw_run_typo_modules'
				)			

			)
		), // #### tabs: 5

		
		## Tab Item
		10	=>  array(
			'type'		=>	'vertical_tabs',
			'tab_id' 	=>	'fontface',
			'tab_title' =>	__('@Font-Face','cloudfw'),
			'form'	=> 	array(
				'enable'	=> true,
				'ajax'		=> false,
				'sending'	=> true,
				'shortcut'	=> true,
				'selector'	=> PFIX.'_font_settings'
			),		
			'data'		=>	array(

				## Container Item
				5	=> array(
					'type'			=>	'container',
					'title'			=>	__('@Font-Face','cloudfw'),
					'footer'		=>	false,
					'data'			=>	array(
						
						## Module Item
						5	=> array(
							'type'		=>	'module',
							'title'		=>	__('Enable @font-face?','cloudfw'),
							'data'		=>	array(
								array(
									'type'		=>	'onoff',
									'id'		=>	cloudfw_sanitize(PFIX.'_webfonts enable'),
									'value'		=>	$_opt[PFIX.'_webfonts']['enable'],
								)

							)

						), 

						## Module Item
						10	=> array(
							'type'		=>	'module',
							'title'		=>	__('Custom @font-face Code','cloudfw'),
							'condition' 	=>  ( _check_onoff( cloudfw_get_option('webfonts', 'enable') ) ),
							'data'		=>	array(
								array(
									'type'		=>	'textarea',
									'id'		=>	cloudfw_sanitize(PFIX.'_webfonts codes'),
									'value'		=>	$_opt[PFIX.'_webfonts']['codes'],
									'_class'	=>  'input textarea_500px_4line code tab-textfields tabtext',		
									'desc'		=>	"E.g.: <code>h1,h2,h3,h4,h5,h6 { font-family:'Font Name'; }</code>",								
								)

							)

						), 

					)

				), ## container: 5
			
				## Container Item
				10	=> array(
					'type'			=>	'container',
					'footer'		=>	false,
					'title'			=>	'Fonts List',
					'condition' 	=>  ( _check_onoff( cloudfw_get_option('webfonts', 'enable') ) ),
					'class'			=>	'framework_container skinApp overflow-visible',
					'data'			=>	array(
					
						0	=> array(
							'type'	=>	'include',
							'path'	=>	TMP_PATH.'/cloudfw/core/others/source.js.section.php'

						),

						## Module Item
						1	=> array(
							'type'		=>	'message',
							'fill'		=>	true,
							'title'		=>	__('How to install custom @font-face fonts into the theme?','cloudfw'),
							'data'		=>	'
								<ul>
									<li>'.sprintf(__('All @font-face fonts are located in "<strong>%s</strong>" folder.','cloudfw'), cloudfw_only_folder_url(FONTS_DIR)).'</li>
									<li>'.sprintf(__('Create your @font-face kit by using %s and then extract the font kit(with folder in the kit) into the fonts folder to install.','cloudfw'), '<a href="http://www.fontsquirrel.com/fontface/generator" target="_blank">Fontsquirrel @font-face Generator</a>').'</li>
								</ul>',
						),

						## Module Item
						2	=> array(
							'type'		=>	'message',
							'fill'		=>	true,
							'color'		=>	'yellow',
							'data'		=>	__('Select your font(s) from the list below to load the fonts on your pages. Then go to <strong>customize</strong> tab and select the fonts for the page elements.','cloudfw'),
						),


						## Module Item
						3	=> array(
							'condition' =>  ( ($selected_fonts_count = @count(cloudfw_get_fonts())) > 2 ),
							'type'		=>	'growl',
							'title'		=>	sprintf(__('Warning: You selected %d @font-face fonts','cloudfw'), $selected_fonts_count),
							'message'	=>	__('You selected more than 2 fonts to install. This may occur some performance problems when loading the pages. We would recommend that you select maximum 2 fonts for @font-face.','cloudfw'),
							'case'		=>	'notice',
							'timeout'	=>	0
						),
						
						## Section Item
						5	=> array(
							'type'			=>	'section-title',
							'title'			=>	__('@Font-Face','cloudfw'),
							'id'			=>	'section-name',
							'status'		=>	'opened',
							'data'			=>	array(
							
								## Module Item
								5	=> array(
									'type'		=>	'module',
									'layout'	=>	'single',
									'data'		=>	array(
										## Element
										array(
											'type'		=>	'checkbox',
											'id'		=>	PFIX.'_loaded_fonts',
											'class'		=>	'font_selector',
											'no_result'	=>  '<div style="padding:0" class="thereisno">'.__('There is no any @font-face font','cloudfw').'</div>',
											'no_result_callback'	
														=>	array( array(
																'type'		=>	'growl',
																'title'		=>	__('There is no any @font-face font','cloudfw'),
																'message'	=>	sprintf(__('There is no any font in the font face folder: <br/><strong>%s</strong>','cloudfw'), cloudfw_only_folder_url( FONTS_DIR )),
																'case'		=>	'notice',
																'timeout'	=>	0
															) ),
											'value'		=>	array(
													'type'		=>	'function',
													'function'	=>	'cloudfw_get_fonts'
											),
											'source'	=>	array(
													'type'		=>	'function',
													'function'	=>	'cloudfw_admin_get_custom_fonts_array'
											),
											
										), // #### element: 0
											
									)

								), 
						
							)

						), // #### section: 5
								

						## Module Item

					)
				),

				100	=> array(
					'type'		=>	'submit',
					'layout'	=>	'fixed',
				), 
	
			)

		), // #### vertical_tabs: 10

		## Tab Item
		15	=>  array(
			'type'		=>	'vertical_tabs',
			'condition'	=>	false,
			'tab_id' 	=>	'cufon',
			'tab_title' =>	__('Cufon','cloudfw'),
			'form'	=> 	array(
				'enable'	=> true,
				'sending'	=> true,
				'ajax'		=> false,
				'shortcut'	=> true,
			),		
			'data'		=>	array(

				## Container Item
				5	=> array(
					'type'			=>	'container',
					'footer'		=>	false,
					'title'			=>	__('Cufon','cloudfw'),
					'data'			=>	array(

						## Module Item
						5	=> array(
							'type'		=>	'module',
							'title'		=>	__('Enable Cufon?','cloudfw'),
							'data'		=>	array(
								array(
									'type'		=>	'onoff',
									'id'		=>	cloudfw_sanitize(PFIX.'_cufon enable'),
									'value'		=>	$_opt[PFIX.'_cufon']['enable'],
								)

							)

						), 

						## Module Item
						6	=> array(
							'type'		=>	'module',
							'title'		=>	__('Enable Cufon on Mobile Devices?','cloudfw'),
							'condition' =>  ( _check_onoff( cloudfw_get_option('cufon', 'enable') ) ),
							'data'		=>	array(
								array(
									'type'		=>	'onoff',
									'id'		=>	cloudfw_sanitize(PFIX.'_cufon enable_mobile'),
									'value'		=>	$_opt[PFIX.'_cufon']['enable_mobile'],
								)

							)

						), 

						## Module Item
						10	=> array(
							'type'		=>	'module',
							'title'		=>	__('Cufon Script','cloudfw'),
							'condition' 	=>  ( _check_onoff( cloudfw_get_option('cufon', 'enable') ) ),
							'data'		=>	array(
								array(
									'type'		=>	'textarea',
									'id'		=>	cloudfw_sanitize(PFIX.'_cufon codes'),
									'value'		=>	$_opt[PFIX.'_cufon']['codes'],
									'class'		=>  'input textarea_500px_6line code tab-textfields tabtext',		
									'desc'		=>	'E.g.: <code>Cufon.replace("h1,h2,h3,h4,h5", {fontFamily : "Font Name", hover: true});</code><br/><br/>' . __(' For more code tips go to official <a href="https://github.com/sorccu/cufon/wiki/styling" target="_blank">Cufon\'s site</a>','cloudfw'),								
								)

							)

						), 


						## Module Item
						15	=> array(
							'type'		=>	'module',
							'condition' 	=>  ( _check_onoff( cloudfw_get_option('cufon', 'enable') ) ),
							'title'		=>	__('Primary Font','cloudfw'),
							'data'		=>	array(

								## Element
								array(
									'type'		=>	'select',
									'id'		=>	cloudfw_sanitize(PFIX.'_cufon primary'),
									'value'		=>	$_opt[PFIX.'_cufon']['primary'],
									'source'	=>	array(
											'type'		=>	'function',
											'function'	=>	'cloudfw_admin_get_installed_cufon_array'
									),
									'ui'		=>	true,
									'main_class'=>  'input input_250',

								), // #### element: 0


							)

						), 

						## Module Item
						20	=> array(
							'type'		=>	'module',
							'condition' 	=>  ( _check_onoff( cloudfw_get_option('cufon', 'enable') ) ),
							'title'		=>	__('Apply to Heading Elements?','cloudfw'),
							'data'		=>	array(

								## Element
								array(
									'type'		=>	'onoff',
									'id'		=>	cloudfw_sanitize(PFIX.'_cufon applytoHeadings'),
									'value'		=>	$_opt[PFIX.'_cufon']['applytoHeadings'],
									'desc'		=>	__('Apply cufon script to <code>Heading elements</code>','cloudfw'),

								), // #### element: 0

								## Element
								array(
									'type'		=>	'select',
									'title'		=>	__('Font Type','cloudfw'),
									'id'		=>	cloudfw_sanitize(PFIX.'_cufon fontTypeHeadings'),
									'value'		=>	$_opt[PFIX.'_cufon']['fontTypeHeadings'],
									'source'	=>	array(
											'type'		=>	'function',
											'function'	=>	'cloudfw_admin_get_installed_cufon_array',
											'vars' 		=> array( true )

									),
									'ui'		=>	true,
									'main_class'=>  'input input_250',

								), // #### element: 0

							)

						), 

						## Module Item
						25	=> array(
							'type'		=>	'module',
							'condition' 	=>  ( _check_onoff( cloudfw_get_option('cufon', 'enable') ) ),
							'title'		=>	__('Apply to the Navigation?','cloudfw'),
							'data'		=>	array(

								## Element
								array(
									'type'		=>	'onoff',
									'id'		=>	cloudfw_sanitize(PFIX.'_cufon applytoNavigation'),
									'value'		=>	$_opt[PFIX.'_cufon']['applytoNavigation'],
									'desc'		=>	__('Apply cufon script to <code>the navigation</code>','cloudfw'),

								), // #### element: 0

								## Element
								array(
									'type'		=>	'select',
									'title'		=>	__('Font Type','cloudfw'),
									'id'		=>	cloudfw_sanitize(PFIX.'_cufon fontTypeNavigation'),
									'value'		=>	$_opt[PFIX.'_cufon']['fontTypeNavigation'],
									'source'	=>	array(
											'type'		=>	'function',
											'function'	=>	'cloudfw_admin_get_installed_cufon_array',
											'vars' 		=> array( true )

									),
									'ui'		=>	true,
									'main_class'=>  'input input_250',

								), // #### element: 0

							)

						), 

						## Module Item
						30	=> array(
							'type'		=>	'module',
							'condition' 	=>  ( _check_onoff( cloudfw_get_option('cufon', 'enable') ) ),
							'title'		=>	__('Apply to the Buttons?','cloudfw'),
							'data'		=>	array(

								## Element
								array(
									'type'		=>	'onoff',
									'id'		=>	cloudfw_sanitize(PFIX.'_cufon applytoButtons'),
									'value'		=>	$_opt[PFIX.'_cufon']['applytoButtons'],
									'desc'		=>	__('Apply cufon script to <code>button</code> elements','cloudfw'),

								), // #### element: 0

								## Element
								array(
									'type'		=>	'select',
									'title'		=>	__('Font Type','cloudfw'),
									'id'		=>	cloudfw_sanitize(PFIX.'_cufon fontTypeButtons'),
									'value'		=>	$_opt[PFIX.'_cufon']['fontTypeButtons'],
									'source'	=>	array(
											'type'		=>	'function',
											'function'	=>	'cloudfw_admin_get_installed_cufon_array',
											'vars' 		=>  array( true )

									),
									'ui'		=>	true,
									'main_class'=>  'input input_250',

								), // #### element: 0

							)

						), 

						## Module Item
						40	=> array(
							'type'		=>	'module',
							'condition' 	=>  ( _check_onoff( cloudfw_get_option('cufon', 'enable') ) ),
							'title'		=>	__('Apply to the Dropcaps?','cloudfw'),
							'data'		=>	array(

								## Element
								array(
									'type'		=>	'onoff',
									'id'		=>	cloudfw_sanitize(PFIX.'_cufon applytoDropcaps'),
									'value'		=>	$_opt[PFIX.'_cufon']['applytoDropcaps'],

								), // #### element: 0

								## Element
								array(
									'type'		=>	'select',
									'title'		=>	__('Font Type','cloudfw'),
									'id'		=>	cloudfw_sanitize(PFIX.'_cufon fontTypeDropcaps'),
									'value'		=>	$_opt[PFIX.'_cufon']['fontTypeDropcaps'],
									'source'	=>	array(
											'type'		=>	'function',
											'function'	=>	'cloudfw_admin_get_installed_cufon_array',
											'vars' 		=>  array( true )

									),
									'ui'		=>	true,
									'main_class'=>  'input input_250',

								), // #### element: 0

							)

						), 

					)

				), ## container: 5

				## Container Item
				10	=> array(
					'type'			=>	'container',
					'footer'		=> 	false,
					'condition' 	=>  ( _check_onoff( cloudfw_get_option('cufon', 'enable') ) ),
					'title'			=>	__('Install Cufon Fonts','cloudfw'),
					'data'			=>	array(


						## Module Item
						1	=> array(
							'type'		=>	'message',
							'fill'		=>	true,
							'title'		=>	__('How to install a cufon font into the theme?','cloudfw'),
							'data'		=>	'
								<ul>
									<li>'.sprintf(__('All cufon fonts are located in "<strong>%s</strong>" folder.','cloudfw'), cloudfw_only_folder_url(CUFON_DIR)).'</li>
									<li>'. __('Upload your cufon font file into the folder to install into the theme.','cloudfw') .'</li>
								</ul>',
						),

						## Module Item
						2	=> array(
							'type'		=>	'message',
							'fill'		=>	true,
							'data'		=>	__('Select your font(s) from the list below to load the font on your pages.','cloudfw'),
						),

						## Module Item
						3	=> array(
							'condition' =>  ( ($selected_fonts_count = @count(cloudfw_cufon_get_installed_fonts())) > 1 ),
							'type'		=>	'growl',
							'title'		=>	sprintf(__('Warning: You selected %d cufon fonts','cloudfw'), $selected_fonts_count),
							'message'	=>	__('You selected more than 1 fonts to install. This may occur some performance problems when loading the pages. We would recommend that you select maximum 1 fonts for cufon.','cloudfw'),
							'case'		=>	'notice',
							'timeout'	=>	0
						),

						## Module Item
						5	=> array(
							'type'		=>	'module',
							'title'		=>	__('Cufon','cloudfw'),
							'layout'	=>	'single',
							'data'		=>	array(

								## Element
								array(
									'type'		=>	'checkbox',
									'id'		=>	cloudfw_sanitize(PFIX.'_cufon fonts'),
									'class'		=>	'font_selector',
									'no_result'	=>  '<div style="padding:0" class="thereisno">'.__('There is no any cufon font','cloudfw').'</div>',
									'no_result_callback'	
												=>	array( array(
														'type'		=>	'growl',
														'title'		=>	__('There is no any cufon font','cloudfw'),
														'message'	=>	sprintf(__('There is no any font in the cufon folder: <br/><strong>%s</strong>','cloudfw'), cloudfw_only_folder_url( CUFON_DIR )),
														'case'		=>	'notice',
														'timeout'	=>	0
													) ),
									'value'		=>	array(
											'type'		=>	'function',
											'function'	=>	'cloudfw_cufon_get_installed_fonts'
									),
									'source'	=>	array(
											'type'		=>	'function',
											'function'	=>	'cloudfw_admin_get_cufon_array'
									),
									
								), // #### element: 0


							)

						), 

					)

				), ## container: 10

				101	=> array(
					'type'		=>	'submit',
					'layout'	=>	'fixed',
					'nomargin'	=>	true
				), 

			)

		), // #### vertical_tabs: 10

		## Tab Item
		array(
			'type'		=>	'vertical_tabs',
			'tab_id' 	=>	'service_fonts',
			'tab_title' =>	__('External Font Services','cloudfw'),
			'data'		=>	array(

				## Container Item
				array(
					'type'			=>	'container',
					'title'			=>	__('External Font Services','cloudfw'),
					'form'	=> 	array(
						'enable'	=> true,
						'sending'	=> true,
						'shortcut'	=> true,
						'message'	=> 8013,
					),	
					'data'			=> array(

						array(
							'type'		=>	'message',
							'fill'		=>	true,
							'color'		=>	'yellow',
							'data'		=>	__('<em>Font Embed Codes</em> will be added inside the <code>&lt;head&gt;&lt;/head&gt;</code> tag.','cloudfw'),
						),

						array(
							'type'		=>	'sorting',
							'id'		=>	'service_fonts_sorting',
							'data'		=>  					
						
								cloudfw_core_loop_multi_option( 
									array(
										'start' 	=> 5,
										'indicator' => $_opt[PFIX.'_servicefonts']['indicator'],
										'data' 		=> 
											array(
												'type'		=>	'module-set',
												'title'		=>	'<span class="font-title"></span>',
												'closable'	=>	true,
												'title_right'=>	'
													<a class="small-button small-grey cloudfw-action-remove" data-target="li" href="javascript:;"><span>'.__('Delete','cloudfw').'</span></a>
												',
												'data'		=>	array(

													array(
														'type'		=>	'indicator',
														'id'		=>	cloudfw_sanitize(PFIX.'_servicefonts indicator'),
													),

													## Module Item
													array(
														'type'		=>	'module',
														'title'		=>	__('Font Name','cloudfw'),
														'data'		=>	array(
															array(
																'type'		=>	'text',
																'class'		=>	'input bold input_300',
																'id'		=>	cloudfw_sanitize(PFIX.'_servicefonts fontname'),
																'value'		=>	$_opt[PFIX.'_servicefonts']['fontname'],
																'reset'		=>	'',
																'brackets'	=> 	true,
															)
														)

													),

													## Module Item
													array(
														'type'		=>	'module',
														'title'		=>	__('Font Family','cloudfw'),
														'data'		=>	array(
															array(
																'type'		=>	'text',
																'class'		=>	'input input_300',
																'id'		=>	cloudfw_sanitize(PFIX.'_servicefonts fontfamily'),
																'value'		=>	$_opt[PFIX.'_servicefonts']['fontfamily'],
																'reset'		=>	'',
																'brackets'	=> 	true,
																'desc'		=>	'E.g: <code>museo-sans-condensed</code>',
															)
														)

													),

													## Module Item
													array(
														'type'		=>	'module',
														'title'		=>	__('Font Embed Code','cloudfw'),
														'data'		=>	array(
															array(
																'type'		=>	'textarea',
																'id'		=>	cloudfw_sanitize(PFIX.'_servicefonts embed_code'),
																'value'		=>	$_opt[PFIX.'_servicefonts']['embed_code'],
																'brackets'	=> 	true,
																'width'		=>	400,
																'line'		=>	5,
																'desc'		=>	'<pre><code>&lt;script type="text/javascript" src="//use.typekit.net/XXXX.js"&gt;&lt;/script&gt;</code></pre>',
																'reset'		=>	'',
															)
														)

													),

												)

										),

									)

								)

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
									'data'		=>	'<a data-target="#service_fonts_sorting" class="cloudfw-action-duplicate cloudfw-ui-button cloudfw-ui-button-metro cloudfw-ui-button-metro-green" href="javascript:;"><span>'.__('+ Add New Service Font','cloudfw').'</span></a>',
								), // #### element: 0

							)
						),

						array(
							'type'		=> 'jquery',
							'data'		=> '

								/** Add event listener for font titles */
								jQuery(document).delegate("[name=\''. cloudfw_sanitize(PFIX.'_servicefonts fontname') .'[]\']", "keyup keydown blur" ,function(e){
									var element 	= jQuery(this),
										container 	= element.parents(".module-set"),
										title 		= container.find(".font-title"),
										value 		= element.val();

									if ( value == "" )
										value = jQuery("[name=\''. cloudfw_sanitize(PFIX.'_servicefonts fontfamily') .'[]\']", container).find(":selected").text();

									if ( value == "" )
										value = "'. esc_attr(__('Unnamed Service Font','cloudfw')) .'";

									title.html( value );


								});

								jQuery(document).delegate("[name=\''. cloudfw_sanitize(PFIX.'_servicefonts fontfamily') .'[]\']", "change" ,function(e){
									var element 	= jQuery(this),
										container 	= element.parents(".module-set");

									jQuery("[name=\''. cloudfw_sanitize(PFIX.'_servicefonts fontname') .'[]\']", container).keyup();
								});

								jQuery("[name=\''. cloudfw_sanitize(PFIX.'_servicefonts fontname') .'[]\']").keyup();


							'
						)
					
					)

				),


			)

		), // #### vertical_tabs: 10

		## Tab Item
		array(
			'type'		=>	'vertical_tabs',
			'tab_id' 	=>	'webfonts',
			'tab_title' =>	__('Google Web Fonts','cloudfw'),
			'data'		=>	array(

				## Container Item
				array(
					'type'			=>	'container',
					'title'			=>	'Google Web Fonts',
					'form'	=> 	array(
						'enable'	=> true,
						'sending'	=> true,
						'shortcut'	=> true,
						'message'	=> 8012,
					),	
					'data'			=> array(

						array(
							'type'		=>	'sorting',
							'id'		=>	'google_webfonts_sorting',
							'item:id'	=>	'webfonts_clone',
							'data'		=>  					
						
								cloudfw_core_loop_multi_option( 
									array(
										'start' 	=> 5,
										'indicator' => $_opt[PFIX.'_webfonts']['indicator'],
										'data' 		=> 
											array(
												'type'		=>	'module-set',
												'id'		=>	'webfonts-handler',
												'title'		=>	'<span class="font-title"></span>',
												'closable'	=>	true,
												'title_right'=>	'
													<a class="small-button small-grey cloudfw-action-remove" data-target="li" href="javascript:;"><span>'.__('Delete','cloudfw').'</span></a>
												',
												'data'		=>	array(

													array(
														'type'		=>	'indicator',
														'id'		=>	cloudfw_sanitize(PFIX.'_webfonts indicator'),
													),

													## Module Item
													array(
														'type'		=>	'module',
														'title'		=>	__('Font Name','cloudfw'),
														'data'		=>	array(
															array(
																'type'		=>	'text',
																'class'		=>	'input bold input_300',
																'id'		=>	cloudfw_sanitize(PFIX.'_webfonts fontname'),
																'value'		=>	$_opt[PFIX.'_webfonts']['fontname'],
																'reset'		=>	'',
																'brackets'	=> 	true,
																'desc'		=>	'E.g: <code>Open Sans</code>',
															)
														)

													),

													## Module Item
													array(
														'type'		=>	'module',
														'title'		=>	__('Font Family','cloudfw'),
														'data'		=>	array(
															array(
																'type'		=>	'select',
																'id'		=>	cloudfw_sanitize(PFIX.'_webfonts fontfamily'),
																'value'		=>	$_opt[PFIX.'_webfonts']['fontfamily'],
																'source'	=>	array(
																	'type'		=>	'function',
																	'function'	=>	'cloudfw_admin_get_google_font_list'
																),
																'brackets'	=> 	true,
																'reset'		=>	'',
																'width'		=>	350

															)
														)

													),

													## Module Item
													array(
														'type'		=>	'module',
														'title'		=>	__('Custom Font Family','cloudfw'),
														'data'		=>	array(
															array(
																'type'		=>	'text',
																'id'		=>	cloudfw_sanitize(PFIX.'_webfonts custom_fontfamily'),
																'value'		=>	$_opt[PFIX.'_webfonts']['custom_fontfamily'],
																'brackets'	=> 	true,
																'desc'		=>	'E.g: <code>Open+Sans+Condensed:300,700:latin</code>',
																'reset'		=>	'',
															)
														)

													),

												)

										),

									)

								)

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
									'data'		=>	'<a data-target="#google_webfonts_sorting" class="cloudfw-action-duplicate cloudfw-ui-button cloudfw-ui-button-metro cloudfw-ui-button-metro-green" href="javascript:;"><span>'.__('+ Add New Google Web Font','cloudfw').'</span></a>',
								), // #### element: 0

							)
						),

						array(
							'type'		=> 'jquery',
							'data'		=> '

								/** Add event listener for font titles */
								jQuery(document).delegate("[name=\''. cloudfw_sanitize(PFIX.'_webfonts fontname') .'[]\']", "keyup keydown blur" ,function(e){
									var element 	= jQuery(this),
										container 	= element.parents(".module-set"),
										title 		= container.find(".font-title"),
										value 		= element.val();

									if ( value == "" )
										value = jQuery("[name=\''. cloudfw_sanitize(PFIX.'_webfonts fontfamily') .'[]\']", container).find(":selected").text();

									if ( value == "" )
										value = "'. esc_attr(__('Unnamed Google Web Font','cloudfw')) .'";

									title.html( value );


								});

								jQuery(document).delegate("[name=\''. cloudfw_sanitize(PFIX.'_webfonts fontfamily') .'[]\']", "change" ,function(e){
									var element 	= jQuery(this),
										container 	= element.parents(".module-set");

									jQuery("[name=\''. cloudfw_sanitize(PFIX.'_webfonts fontname') .'[]\']", container).keyup();
								});

								jQuery("[name=\''. cloudfw_sanitize(PFIX.'_webfonts fontname') .'[]\']").keyup();


							'
						)
					
					)

				),

					
			)

		), // #### vertical_tabs: 20

	) // page -> data
	
);