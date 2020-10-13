<?php
/*
 * Plugin Name: Price Table
 * Plugin URI: http://cloudfw.net
 * Description: 
 * Version: 1.0
 * Author: Orkun Gürsel
 * Author URI: http://orkungursel.com
 * Shortcode:  
 * Attributes:
 */

cloudfw_register_shortcode( 'CloudFw_Composer_Price_Table' );
if ( ! class_exists('CloudFw_Composer_Price_Table') ) {
	class CloudFw_Composer_Price_Table extends CloudFw_Shortcodes {

		function get_called_class(){ return get_class($this); }


		/** Add the shortcode to the composer */
		function composer(){
			return array(
				'composer'		=> true,
				'droppable'		=> true,
				'ajax'			=> true,
				'icon'			=> 'price',
				'group'			=> 'composer_widgets',
				'do_shortcode'	=> false,
				'line'			=> 260,
				'options'		=> array(
					'title'				=> __('Pricing Table','cloudfw'),
					'column'			=> '1/1',
					'allow_columns'		=> false,
					'limit'				=> 5,
					'not_in'			=> array('CloudFw_Composer_Price_Table', 'CloudFw_Composer_Price_Table_Column'),
					'allow_only'		=> array('CloudFw_Composer_Price_Table_Column'),
					'error_messages'	=> array(
						'not_in'			=> array(
							'CloudFw_Composer_Price_Table' => array(
								'message' 	=> __('You must add a price table column instead of price table container.','cloudfw')
							)
						),
					)
				)
			);
		}

		/** Run */
		function shortcode( $atts = array(), $content =  NULL ) {
			return cloudfw_transfer_shortcode_attributes( 'price_table', $atts, $content, true, true );
		}

		/** Scheme */
		function scheme() {
			return array(
				'title'		=>	__('Pricing Table','cloudfw'),
				'ajax'		=>	true,
				'script'	=> array(
					'shortcode'  => 'price_table',
					'attributes' =>	array( 
						'style' 			=> array( 'e' => 'pt_style' ),
						'feature_align' 	=> array( 'e' => 'pt_row_align' ),
						'shadow' 			=> array( 'e' => 'pt_shadow' ),
						'titles'			=> array( 'e' => 'pt_feature_titles' ),
						'margin_top'     	=> array( 'e' => 'margin_top' ),
						'margin_bottom'  	=> array( 'e' => 'margin_bottom' ),

					),
					'if'		 =>	array(
						array( 
							'type'    => 'toggle',
							'e' 	  => 'pt_style',
							'related' => 'ptRowsOptions',
							'targets' => array( 
								array('style2', '#pt_feature_title_sorting'),
							)
						)
					
					)
				),
				'data'		=>	array(

					array(
						'type'		=> 'module',
						'title'		=> __('Table Style','cloudfw'),
						'data'		=> array(

							## Element
							array(
								'type'		=>	'select',
								'id'		=>	'pt_style',
								'value'		=>	$this->get_value('pt_style'),
								'source'	=>	array(
									'NULL'		=>	__('Style 1','cloudfw'),
									'style2'		=>	__('Style 2','cloudfw'),
								),
								'width'		=>	250

							)

						)

					),

					array(
						'type'		=>	'group',
						'related'	=>	'ptRowsOptions',
						'data'		=>  array(

							array(
								'type'		=>	'sorting',
								'id'		=>	'pt_feature_title_sorting',
								'item:id'	=>	'pt_feature_title_clone',
								'data'		=> 

									cloudfw_core_loop_multi_option( 
										
										array(
											'start' 	=> 5,
											'indicator' => $this->get_value('indicator'),
											'dummy'		=> true,
											'data' 		=> 

												array(
													'type'		=>	'module',
													'layout'	=>	'vertical',
													'title'		=>	__('Feature Row','cloudfw'),
													'_class'	=>  'pt_feature_title_clone_class',
													'data'		=>	array(
									
														## Module Item
														array(
															'type'		=>	'remove',
														),

														## Module Item
														array(
															'type'		=>	'indicator',
															'id'		=>	$this->get_field_name('indicator'),
														),

														## Element
														array(
															'type'		=>	'textarea',
															'id'		=>	$this->get_field_name('pt_feature_titles'),
															'value'		=>	$this->get_value('pt_feature_titles'),
															'reset'		=>	'',
															'brackets'	=>	true,
															'width'		=>	'90%',
															'line'		=>	2

														), // #### element: 0

													)

												),

										)

									)

							),

							## Element
							array(
								'type'		=>	'html',
								'data'		=>	'<a data-target="" class="cloudfw-action-duplicate cloudfw-ui-button cloudfw-ui-button-metro cloudfw-ui-button-metro-green" href="javascript:;"><span>'.__('+ Add Row Title','cloudfw').'</span></a>',
							), // #### element: 0

						)

					),

					array(
						'type'		=> 'module',
						'title'		=> __('Text align for rows','cloudfw'),
						'data'		=> array(

							## Element
							array(
								'type'		=>	'select',
								'id'		=>	'pt_row_align',
								'value'		=>	$this->get_value('pt_row_align'),
								'source'	=>	array(
									'NULL'		=>	__('Left','cloudfw'),
									'center'	=>	__('Center','cloudfw'),
									'right'		=>	__('Right','cloudfw'),
								),
								'width'		=>	250

							)

						)

					),

					array(
						'type'		=> 'module',
						'title'		=> __('Shadow for Columns','cloudfw'),
						'data'		=> array(

							## Element
							array(
								'type'		=>	'select',
								'id'		=>	'pt_shadow',
								'value'		=>	$this->get_value('pt_shadow'),
								'source'	=>	array(
									'type'			=> 'function',
									'function'		=> 'cloudfw_admin_loop_shadows',
								),
								'width'		=>	250

							)

						)

					),


					array(
						'type'		=>	'global-scheme',
						'scheme'	=>	'margins',
						'this'		=>	$this
					),

				)

			);

		}


		/** Scheme */
		function composer_scheme() {
			return array(
				'data'		=>	array(
					cloudfw_composer_default_dropped_area(
						array(
							array(
								'id'	=>	'CloudFw_Composer_Price_Table_Column',
								'title'	=>	__('+ Add new column','cloudfw'),
							),
						)
					)
				)
			);
		}

		/** Typo map */
		function typo_map( $map ){
			cloudfw_add_typo_setting( $map, 'pricing_table_titles', '.ui--pricing-table-item-title');
			cloudfw_add_typo_setting( $map, 'pricing_table_titles_feaured', '.ui--pricing-table-column.featured .ui--pricing-table-item-title');
			cloudfw_add_typo_setting( $map, 'pricing_table_prices', '.ui--pricing-table-item-price');

		    return $map;
		}


		/** Typo Scheme */
		function typo_scheme( $scheme, $data, $number ){

			$scheme[ cloudfw_id_for_sequence( $scheme, $number ) ] = array(
				'type'			=>	'container',
				'width'			=>	940,
				'footer'		=>	false,
				'title'			=>	__('Pricing Table','cloudfw'),
				'data'			=>	array(
				
					array(
						'type'		=>	'typo-set',
						'title'		=>	__('Pricing Table Column Title','cloudfw'),
						'id'		=>	cloudfw_sanitize('pricing_table_titles'),
						'value'		=>	$data['pricing_table_titles'],
						'data'		=>	array()
						
					),

					array(
						'type'		=>	'typo-set',
						'title'		=>	__('Pricing Table Highligted Column Title','cloudfw'),
						'id'		=>	cloudfw_sanitize('pricing_table_titles_feaured'),
						'value'		=>	$data['pricing_table_titles_feaured'],
						'data'		=>	array()
						
					),

					array(
						'type'		=>	'typo-set',
						'title'		=>	__('Pricing Table Price Text','cloudfw'),
						'id'		=>	cloudfw_sanitize('pricing_table_prices'),
						'value'		=>	$data['pricing_table_prices'],
						'data'		=>	array()
						
					),

				
				) 


			);

			return $scheme;


		}

	}

}

cloudfw_register_shortcode( 'CloudFw_Composer_Price_Table_Column');
if ( ! class_exists('CloudFw_Composer_Price_Table_Column') ) {
	class CloudFw_Composer_Price_Table_Column extends CloudFw_Shortcodes {

		function get_called_class(){ return get_class($this); }


		/** Add the shortcode to the composer */
		function composer(){
			return array(
				'composer'		=> true,
				'ajax'			=> true,
				'list'			=> false,
				'group'			=> 'composer_widgets',
				'do_shortcode'	=> false,
				'line'			=> 38,
				'options'		=> array(
					'title'				=> __('Price Table Column','cloudfw'),
					'column'			=> '1/1',
					'allow_columns'		=> false,

					'sync_title'		=> 'pt_title',
					'in'				=> 'CloudFw_Composer_Price_Table',
					'not_in'			=> 'CloudFw_Composer_Price_Table_Column',
					'not_allow'			=> array('CloudFw_Composer_Container'),
					'error_messages'	=> array(
						'in'				=> array(
							'CloudFw_Composer_Price_Table' => array(
								'message' 	=> __('You can only add a price table column into a price table container.','cloudfw')
							)
						)
					)

				)
			);
		}

		/** Run */
		function shortcode( $atts = array(), $content =  NULL ) {

			$content = '';
			foreach ( (array) $atts['indicator'] as $i => $dummy )
				$content .= cloudfw_transfer_shortcode_attributes( 
					'price_table_feature', 
					array( 
						//'align' => $atts['pt_feature_align'][ $i ],
					),
					$atts['content'][ $i ]
				);

			$out = cloudfw_transfer_shortcode_attributes( 'price_table_column', $atts, $content, true, true );
			return $out;
		}

		/** Scheme */
		function scheme() {
			return array(
				'script'	=> array(
					'shortcode'		=> 'price_table_column',
					'attributes' 	=> array( 
						'height' 		=> array( 'e' => 'pt_height' ),
						'title' 		=> array( 'e' => 'pt_title' ),
						'title_size'	=> array( 'e' => 'pt_title_size' ),
						'value' 		=> array( 'e' => 'pt_value' ),
						'value_size' 	=> array( 'e' => 'pt_value_size' ),
						'caption' 		=> array( 'e' => 'pt_caption' ),
						'link' 			=> array( 'e' => 'pt_link' ),
						'featured' 		=> array( 'e' => 'pt_featured' ),
						'html_after' 	=> array( 'e' => 'pt_html_after' ),
						'content'		=> array( 'e' => 'pt_feature_content' ),
						'custom_effect' => array( 'e' => 'pt_custom_effect' ),
					)
				),
				'data'		=>	array(


					array(
						'type'		=> 'module',
						'title'		=> __('Highlight this column?','cloudfw'),
						'data'		=> array(

							## Element
							array(
								'type'		=>	'onoff',
								'id'		=>	'pt_featured',
								'value'		=>	$this->get_value('pt_featured', 'FALSE'),
							)

						)

					),


					array(
						'type'		=> 'module',
						'title'		=> __('Title','cloudfw'),
						'data'		=> array(

							## Element
							array(
								'type'		=>	'textarea',
								'id'		=>	'pt_title',
								'value'		=>	$this->get_value('pt_title'),
								'editor'	=>	true,
								'autogrow'	=>	true,
								'line'		=>	2,
								'width'		=>	400
							)

						)

					),

					array(
						'type'		=> 'module',
						'title'		=> __('Title Font Size','cloudfw'),
						'data'		=> array(

							## Element
							array(
								'type'		=>	'slider',
								'id'		=>	'pt_title_size',
								'value'		=>	$this->get_value('pt_title_size'),
								'min'		=>	9,
								'max'		=>	120,
								'step'		=>	1,
								'steps'		=>	array( '9'	=>	__('Default','cloudfw') ),
							)

						)

					),

					array(
						'type'		=> 'module',
						'title'		=> __('Value / Price','cloudfw'),
						'data'		=> array(

							## Element
							array(
								'type'		=>	'textarea',
								'id'		=>	'pt_value',
								'value'		=>	$this->get_value('pt_value'),
								'editor'	=>	true,
								'autogrow'	=>	true,
								'line'		=>	1,
								'width'		=>	400
							)

						)

					),

					array(
						'type'		=> 'module',
						'title'		=> __('Value / Price Font Size','cloudfw'),
						'data'		=> array(

							## Element
							array(
								'type'		=>	'slider',
								'id'		=>	'pt_value_size',
								'value'		=>	$this->get_value('pt_value_size'),
								'min'		=>	9,
								'max'		=>	120,
								'step'		=>	1,
								'steps'		=>	array( '9'	=>	__('Default','cloudfw') ),
							)

						)

					),

					array(
						'type'		=> 'module',
						'title'		=> __('Caption','cloudfw'),
						'data'		=> array(

							## Element
							array(
								'type'		=>	'text',
								'id'		=>	'pt_caption',
								'value'		=>	$this->get_value('pt_caption'),
							)

						)

					),

					array(
						'type'		=>	'sorting',
						'id'		=>	'socialbar_sorting',
						'item:id'	=>	'pt_feature_clone',
						'data'		=> 

							cloudfw_core_loop_multi_option( 
								
								array(
									'start' 	=> 5,
									'indicator' => $this->get_value('indicator'),
									'dummy'		=> true,
									'data' 		=> 

										array(
											'type'		=>	'module',
											'layout'	=>	'vertical',
											'title'		=>	__('Feature Row','cloudfw'),
											'_class'	=>  'pt_feature_clone_class',
											'data'		=>	array(
							
												## Module Item
												array(
													'type'		=>	'remove',
												),

												## Module Item
												array(
													'type'		=>	'indicator',
													'id'		=>	$this->get_field_name('indicator'),
												),

												## Element
												array(
													'type'		=>	'textarea',
													'id'		=>	$this->get_field_name('pt_feature_content'),
													'value'		=>	$this->get_value('pt_feature_content'),
													'reset'		=>	'',
													'brackets'	=>	true,
													'width'		=>	'90%',
													'line'		=>	2

												), // #### element: 0

											)

										),

								)

							)

					),

					## Element
					array(
						'type'		=>	'html',
						'data'		=>	'<a data-target="" class="cloudfw-action-duplicate cloudfw-ui-button cloudfw-ui-button-metro cloudfw-ui-button-metro-green" href="javascript:;"><span>'.__('+ Add Feature','cloudfw').'</span></a>',
					), // #### element: 0

					array(
						'type'		=> 'module',
						'title'		=> __('Html code after the feature rows','cloudfw'),
						'data'		=> array(

							## Element
							array(
								'type'		=>	'textarea',
								'id'		=>	'html_after',
								'value'		=>	$this->get_value('html_after'),
								'width'		=>	'90%',
								'line'		=>	2,
								'desc'		=>	__('Allows <code>[shortcodes]</code>. You may add a button shortcode here.','cloudfw')
							)

						)

					),

					array(
						'type'		=> 'module',
						'title'		=> __('Custom Effect for Feature Rows','cloudfw'),
						'data'		=> array(

							## Element
							array(
								'type'		=>	'select',
								'id'		=>	'pt_custom_effect',
								'value'		=>	$this->get_value('pt_custom_effect'),
								'source'	=>	array(
									'type'		=>	'function',
									'function'	=>	'cloudfw_css_effect_list',
								),
								'width'		=>	400,
							),

						)

					),

				
				)

			);

		}

	}

}