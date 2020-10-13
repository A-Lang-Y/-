<?php

$scheme[ cloudfw_id_for_sequence( $scheme, $number ) ] = array(
	'type'		=> 'page',
	'page' 		=> 'system',
	'system'	=> array(
		'page_title' 	=>	__('System','cloudfw'),
		'page_nice_title'=>	__('system','cloudfw'),
		'page_slug' 	=>	'system',
		'page_css_id' 	=>	'cloud_nav_system',
		
		'load_file'		=>	array( array(
				'type'		=>	'require',
				'path'		=>	TMP_PATH.'/cloudfw/core/others/source.system.php'
		) )
	),
	'data'	=> array(
	
		## Tab Item
		array(
			'type'		=>	'vertical_tabs',
			'tab_id'	=>	'framawork_options',
			'tab_title'	=>	__('Framework Options','cloudfw'),
			'form'		=>	array(
				'enable'	=> true,
				'ajax'		=> true,
				'shortcut'	=> true,
			),
			'data'		=>	array(
				
				## Container Item
				10	=> array(
					'type'		=>	'container',
					'title'		=>	__('Framework Options','cloudfw'),
					'data'		=>	array(
					
						## Module Item
						array(
							'type'		=>	'module',
							'title'		=>	__('Demo Content Importer','cloudfw'),
							'data'		=>	array(
									array(
										'type'		=>	'onoff',
										'id'		=>	cloudfw_sanitize(PFIX.'_cloudfw_actives dummy'),
										'value'		=>	$_opt[PFIX.'_cloudfw_actives']['dummy'],
										'description'=>	__('Demo content importer on the framework dashboard?','cloudfw'),
									)
							)
						),

						## Module Item
						array(
							'type'		=>	'module',
							'title'		=>	__('Configuration Wizard','cloudfw'),
							'data'		=>	array(
									array(
										'type'		=>	'onoff',
										'id'		=>	cloudfw_sanitize(PFIX.'_cloudfw_actives map'),
										'value'		=>	$_opt[PFIX.'_cloudfw_actives']['map'],
										'description'=>	__('Show configuration wizard on the framework dashboard?','cloudfw'),
									)
							)
						),

						## Module Item
						array(
							'type'		=>	'module',
							'title'		=>	__('Theme Updates','cloudfw'),
							'data'		=>	array(
									array(
										'type'		=>	'onoff',
										'id'		=>	cloudfw_sanitize(PFIX.'_cloudfw_actives autocheck'),
										'value'		=>	$_opt[PFIX.'_cloudfw_actives']['autocheck'],
										'description'=>	__('Check the theme updates automatically, and notify me?','cloudfw'),
									)
							)
						),
	
						## Module Item
						array(
							'type'		=>	'module',
							'title'		=>	__('Who can see the theme control panel?','cloudfw'),
							'data'		=>	array(
								array(
									'type'		=>	'user-select',
									'id'		=>	cloudfw_sanitize(PFIX.'_framework who_can_see'),
									'value'		=>	$_opt[PFIX.'_framework']['who_can_see'],
									'multi'		=>	false
								), // #### element: 0
							)
						),

						## Module Item
						array(
							'type'		=>	'module',
							'title'		=>	__('Who can see the theme slider manager?','cloudfw'),
							'data'		=>	array(
								array(
									'type'		=>	'user-select',
									'id'		=>	cloudfw_sanitize(PFIX.'_who_can_see slider_manager'),
									'value'		=>	cloudfw_get_option( 'who_can_see', 'slider_manager' ),
									'multi'		=>	false
								), // #### element: 0
							)
						),

						## Module Item
						array(
							'type'		=>	'module',
							'title'		=>	__('User capability for Save/Load Template buttons in the content composer','cloudfw'),
							'data'		=>	array(
								array(
									'type'		=>	'text',
									'id'		=>	cloudfw_sanitize(PFIX.'_caps save_load_template'),
									'value'		=>	cloudfw_get_option( 'caps', 'save_load_template' ),
								), // #### element: 0
							)
						),

						## Module Item
						array(
							'type'		=>	'module',
							'title'		=>	__('User capability for Pre-built Pages button in the content composer','cloudfw'),
							'data'		=>	array(
								array(
									'type'		=>	'text',
									'id'		=>	cloudfw_sanitize(PFIX.'_caps prebuilt_pages'),
									'value'		=>	cloudfw_get_option( 'caps', 'prebuilt_pages' ),
								), // #### element: 0
							)
						),
							
					)
				), // #### container: 10

					
				## Container Item
				15	=> array(
					'type'		=>	'container',
					'title'		=>	__('Branding Options','cloudfw'),
					'data'		=>	array(
					
						## Module Item
						5	=> array(
							'type'		=>	'module',
							'title'		=>	__('Framework Logo','cloudfw'),
							'data'		=>	array(
								array(
									'type'		=>	'upload',
									'id'		=>	cloudfw_sanitize(PFIX.'_framework', 'logo'),
									'value'		=>	$_opt[PFIX.'_framework']['logo'],
									'description'=>	__('Leave blank for default, Fixed Size: 70px x 70px','cloudfw'),
									'preview'	=> true,
									'removable'	=> true,
								)
							)
						), 
						## Module Item
						10	=> array(
							'type'		=>	'module',
							'title'		=>	__('Framework Menu Title','cloudfw'),
							'data'		=>	array(
								array(
									'type'		=>	'text',
									'id'		=>	cloudfw_sanitize(PFIX.'_framework', 'title'),
									'value'		=>	$_opt[PFIX.'_framework']['title'],
									'_class'	=>  'bold',
								), // #### element: 0
							)
						), 
				
					)
				), // #### container: 15	
								
			)

		),

		## Tab Item
		array(
			'type'		=>	'vertical_tabs',
			'tab_id'	=>	'updater',
			'tab_title'	=>	__('Theme Upgrading','cloudfw'),
			'form'		=>	array(
				'enable'	=> true,
				'ajax'		=> true,
				'shortcut'	=> true,
			),
			'data'		=>	array(
				
				## Container Item
				array(
					'type'		=>	'container',
					'title'		=>	__('Purchase Code','cloudfw'),
					'data'		=>	array(

						array(
							'type'		=>	'message',
							'fill'		=>	true,
							'title'		=>	__('Where can I find my Item Purchase Code?','cloudfw'),
							'data'		=>	__('You will find your Item Purchase Code contained within the License Certificate of your purchase. You can view your License Certificate at anytime by logging into your ThemeForest account and visiting your downloads section.','cloudfw') . ' <a href="http://cl.ly/7Ert" target="_blank">'. __('Click here for more instructions.','cloudfw').'</a>',
						),

						## Module Item
						array(
							'type'		=>	'module',
							'title'		=>	__('Item Purchase Code','cloudfw'),
							'data'		=>	array(
									array(
										'type'		=>	'text',
										'id'		=>	cloudfw_sanitize(PFIX.'_envato purchase_code'),
										'value'		=>	$_opt[PFIX.'_envato']['purchase_code'],
										'_class'	=>	'input_400',
										'description'=>	__('It will use for verifying before update','cloudfw'),
									)
							)
						),
							
					)

				),

				## Container Item
				array(
					'type'		=>	'container',
					'title'		=>	__('Check for New Version','cloudfw'),
					'footer'	=>	false,
					'data'		=>	array(


						## Module Item
						array(
							'type'		=>	'module',
							'title'		=>	__('Check for New Version','cloudfw'),
							'data'		=>	array(
								array(
									'type'		=>	'html',
									'data'		=>	'<a href="javascript:;" class="small-button small-green cloudfw-check-new-version" data-send-text="'. __('Checking...','cloudfw') .'" data-ok-text="'. __('Checked','cloudfw') .'"><span>'. __('Check for new version now','cloudfw') .'</span></a>',
								),

								array(
									'type'		=>	'jquery',
									'data'		=>	'

										jQuery(".cloudfw-check-new-version").click(function(){
											var __sending = jQuery(this).__sending({

											});

											var ajaxForm_vars = {
												action: "cloudfw_check_update",
												nonce: CloudFwOp.cloudfw_nonce,
											};


											jQuery.ajax({
												url: CloudFwOp.ajaxUrl,
												cache: false,
												type: "POST",
												data: (jQuery.param(ajaxForm_vars, true)),
												success: function(data) {

													try {
														__sending.success();
														var obj = jQuery.parseJSON(data);

														if ( obj.need ) {
															cloudfw_dialog("'. esc_attr( sprintf("There is a new version for %s", CLOUDFW_THEMENAME) ) .'", "", "ok");
															//window.location.href = "'. CloudFw_Notifier::$update_page .'";
															location.reload();
														} else {
															cloudfw_dialog("You have already the latest version.", "", "ok");
														}

													}
													catch (e) {
														__sending.error();
														console.log(data);
														
													}


												}  
																						
											});

										});

									',
								),



							)
						),
							
					)

				),
			
			)

		),

		## Tab Item
		array(
			'type'		=>	'vertical_tabs',
			'tab_id'	=>	'dummies',
			'tab_title'	=>	__('Demo Contents','cloudfw'),
			'condition'	=> array(
				'!'				=>	true,
				'type'			=>	'function',
				'function'		=>	'cloudfw_dummy_show_ui',
			),
			'data'		=>	array(
				
				array(
					'type'		=>	'render',
					'source'	=>	array(
						'type'			=>	'function',
						'function'		=>	'cloudfw_render_import_dummy',
					)
				),

				## Container Item
				array(
					'type'		=>	'container',
					'title'		=>	__('Export Demo Contents','cloudfw'),
					'condition'	=> array(
						'!'				=>	true,
						'type'			=>	'function',
						'function'		=>	'cloudfw_in_developing',
					),
					'footer'	=>	false,
					'data'		=>	array(
					
		
						## Module Item
						array(
							'type'		=>	'html',
							'data'		=>	'<div id="dummy-export-messages"></div>'
						),

						## Module Item
						array(
							'type'		=>	'jquery',
							'data'		=>	'
								/** Dummy Content Export Function */
								var cloudfw_export_dummies = function( args ){
									if (jQuery("body").hasClass("cloudfw-state-exporting")) {
										cloudfw_dialog("Please Wait", "Plase wait while an export action in proccess.", "error");
										return false;
									}

									jQuery("body").addClass("cloudfw-state-exporting");
									cloudfw_global_loading("show");

									var ajaxForm_vars = {
										action 	: "cloudfw_export_dummies",
										nonce 	: CloudFwOp.cloudfw_nonce,
										type 	: args.type,
									};

									jQuery.ajax({
										url: CloudFwOp.ajaxUrl,
										cache: false,
										type: "POST",
										data: (jQuery.param(ajaxForm_vars, true)),
										success: function(data) {
											try {
												var obj = jQuery.parseJSON(data);
												cloudfw_dialog(obj.messageTitle,obj.messageText,obj.messageCase);
												//alert(data);
												
											} catch (e) {
												//cloudfw_dialog("Fatal Error", "There was an error when the action in proccess.", "error");
												//alert(data);

												jQuery("#dummy-export-messages").html( "<div class=\"init\">"+ data +"</div>" );
												
											}
																						
											jQuery("body").removeClass("cloudfw-state-exporting");
											cloudfw_global_loading("hide");

										}  
																				
									});


								}

								jQuery(".dummy-export").click(function(){
									cloudfw_export_dummies({
										type:	jQuery(this).attr("data-type")
									});
								});

							'
						),

						## Module Item
						array(
							'type'		=>	'module',
							'title'		=>	__('Demo Contents','cloudfw'),
							'data'		=>	array( 
						
								array(
									'type'		=>	'html',
									'data'		=>	'<a data-type="all" class="small-button small-green dummy-export" href="javascript:;"><span>'. __('Export All','cloudfw').'</span></a>'
								)
								
							)
						),

						## Module Item
						array(
							'type'		=>	'module',
							'title'		=>	__('Export Options','cloudfw'),
							'data'		=>	array( 
						
								array(
									'type'		=>	'html',
									'data'		=>	'<a data-type="options" class="small-button small-green dummy-export" href="javascript:;"><span>'. __('Export Options','cloudfw').'</span></a>'
								)
								
							)
						),

						## Module Item
						array(
							'type'		=>	'module',
							'title'		=>	__('Export Widgets','cloudfw'),
							'data'		=>	array( 
						
								array(
									'type'		=>	'html',
									'data'		=>	'<a data-type="widgets" class="small-button small-green dummy-export" href="javascript:;"><span>'. __('Export Widgets','cloudfw').'</span></a>'
								)
								
							)
						),

						## Module Item
						array(
							'type'		=>	'module',
							'title'		=>	__('Export Widgets for Setup','cloudfw'),
							'data'		=>	array( 
						
								array(
									'type'		=>	'html',
									'data'		=>	'<a data-type="widgets_setup" class="small-button small-green dummy-export" href="javascript:;"><span>'. __('Export Widgets for Setup','cloudfw').'</span></a>'
								)
								
							)
						),

						## Module Item
						array(
							'type'		=>	'module',
							'title'		=>	__('Export Menus','cloudfw'),
							'data'		=>	array( 
						
								array(
									'type'		=>	'html',
									'data'		=>	'<a data-type="menus" class="small-button small-green dummy-export" href="javascript:;"><span>'. __('Export Menus','cloudfw').'</span></a>'
								)
								
							)
						),

						
									
					)

				),

				## Container Item
				array(
					'type'		=>	'container',
					'title'		=>	__('Export Pre-built Pages','cloudfw'),
					'condition'	=> array(
						'!'				=>	true,
						'type'			=>	'function',
						'function'		=>	'cloudfw_in_developing',
					),
					'footer'	=>	false,
					'data'		=>	array(
					
						array(
							'type'      =>  'html',
							'data'      =>  '<div id="prepages-export-messages" class="todolist" style="display: none;"></div>'
						),
		
						## Module Item
						array(
							'type'		=>	'module',
							'title'		=>	__('Pages','cloudfw'),
							'data'		=>	array(

								## Element
								array(
									'type'		=>	'select',
									'id'		=>	'prepages',
									'value'		=>	'',
									'source'	=>	array(
										'type'		=>	'function',
										'function'	=>	'cloudfw_admin_loop_all_pages'
									),
									'multiple'	=>	true,
									'brackets'	=>	true,
									'width'		=>	350,
									'height'	=>	500,

								),

							)

						),



						## Module Item
						array(
							'type'		=>	'jquery',
							'data'		=>	'
				
								/** Dummy Content Import Function */
								var cloudfw_export_prepages = function( args ){

									jQuery("body").addClass("cloudfw-state-importing");
									cloudfw_global_loading("show");

									var ajaxForm_vars = {
										action          : "cloudfw_save_composer_template",
										type            : "prepage",
										message_type    : "title",
										post_id         : args.post_id,
										nonce           : CloudFwOp.cloudfw_nonce
									};

									jQuery.ajax({
										url: CloudFwOp.ajaxUrl,
										cache: false,
										type: "POST",
										data: (jQuery.param(ajaxForm_vars, true)),
										success: (typeof args.callback == \'function\') ? args.callback : function(){}
									});

								}

								// Create a new queue.
								var queue = jQuery.jqmq({
									delay: -1,
									batch: 1,
									callback: function( post_id ) {
										cloudfw_export_prepages({
											post_id:   post_id,
											callback: function( data ){


												try {
													var obj = jQuery.parseJSON(data);
													obj.messageTitle = jQuery("<div/>").html(obj.messageTitle).text();

													jQuery( "<li class=\"donea\"><span class=\"guide\">"+ obj.messageTitle +"</span></li>" ).appendTo( jQuery("#prepages-export-messages") ).hide().slideDown();
													
												} catch (e) {
													jQuery( "<li class=\"donea\"><span class=\"guide\">"+ data +"</span></li>" ).appendTo( jQuery("#prepages-export-messages") ).hide().slideDown();
													
												}

												queue.next();

											}
										});
									},
									complete: function(){
										jQuery( "<li class=\"done\"><span class=\"guide\" style=\"color: #00A651 !important;\">'. __('Export process completed.','cloudfw') .'</span></li>" ).appendTo( jQuery("#prepages-export-messages") ).hide().slideDown();;

										jQuery("body").removeClass("cloudfw-state-importing");
										cloudfw_global_loading("hide");
									}

								});


								jQuery(".prepages-export").click(function(){
									if (jQuery("body").hasClass("cloudfw-state-importing")) {
										cloudfw_dialog("Please Wait", "Plase wait while an import action in proccess.", "error");
										return false;
									}

									CloudFw_UI.sure.init({
										id           : "cloudfw-box-sure-prepages-export",
										texts        : { sure: "'. __('Export','cloudfw') .'" },
										button_color : { sure: \'green\' },
										overlay      : true,
										resume       : function(){

											var ids = jQuery("#prepages").val();
											
											if (ids.length) {
												jQuery("#prepages-export-messages").show().html("");

												jQuery.each( ids, function(){
													queue.add( this );
												});

											}

										}

									});

								});

							'
						),

						## Module Item
						array(
							'type'		=>	'module',
							'title'		=>	__('Export','cloudfw'),
							'data'		=>	array( 
						
								array(
									'type'		=>	'html',
									'data'		=>	'<a class="small-button small-green prepages-export" href="javascript:;"><span>'. __('Export','cloudfw').'</span></a>'
								)
								
							)
						),					
									
					)

				),

			)

		),

	
		## Tab Item
		array(
			'type'		=>	'vertical_tabs',
			'tab_id'	=>	'import_export',
			'tab_title'	=>	__('Import / Export','cloudfw'),
			'data'		=>	array(
				
				## Container Item
				5	=> array(
					'type'		=>	'container',
					'title'		=>	'Theme Options',
					'footer'	=>	false,
					'data'		=>	array(
			
						## Module Item
						5	=> array(
							'type'		=>	'module',
							'title'		=>	__('Export','cloudfw'),
							'data'		=>	array( 
							
									5	=>  array(
										'type'		=>	'html',
										'data'		=>	'<a class="small-button small-green" href="'.admin_url('admin.php').'?do=CloudFw_Export&nonce='.wp_create_nonce('cloudfw').'&amp;case=export-all-options"><span>'. __('Export The Option File','cloudfw').'</span></a>'
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
									'function'	=>	'cloudfw_get_form_import_all_options'
								)
							)
						),


									
					)
				), // #### container: 5
				

				## Container Item
				10	=> array(
					'type'		=>	'container',
					'title'		=>	'Color Skins',
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
				), // #### container: 10	

				## Container Item
				15	=> array(
					'type'		=>	'container',
					'title'		=>	'Sliders',
					'footer'	=>	false,
					'data'		=>	array(
					
						## Module Item
						5	=> array(
							'type'		=>	'module',
							'title'		=>	__('Export','cloudfw'),
							'data'		=>	array( 
								5	=>  array(
									'type'		=>	'run',
									'function'	=>	'cloudfw_get_form_export_slider'
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
									'function'	=>	'cloudfw_get_form_import_slider'
								)
							)
						),

									
					)
				), // #### container: 15				

				## Container Item
				20	=> array(
					'type'		=>	'container',
					'title'		=>	'Icon Set',
					'footer'	=>	false,
					'data'		=>	array(
						
						## Module Item
						5	=> array(
							'type'		=>	'module',
							'title'		=>	__('Import','cloudfw'),
							'data'		=>	array( 
								5	=>  array(
									'type'		=>	'run',
									'function'	=>	'cloudfw_get_form_import_iconset'
								)
							)
						),

									
					)
				), // #### container: 20					
					
			)

		), // #### vertical_tabs: 15

	)
		
);