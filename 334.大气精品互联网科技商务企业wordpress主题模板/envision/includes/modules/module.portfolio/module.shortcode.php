<?php
/*
 * Plugin Name: Portfolio
 * Plugin URI: http://cloudfw.net
 * Description: 
 * Version: 1.0
 * Author: Orkun Gürsel
 * Author URI: http://orkungursel.com
 * Shortcode:  [portfolio]
 * Attributes: (int) id
 */

cloudfw_register_shortcode( 'CloudFw_Shortcode_Portfolio', 'portfolio', 'advanced', 25 );
if ( ! class_exists('CloudFw_Shortcode_Portfolio') ) {
	class CloudFw_Shortcode_Portfolio extends CloudFw_Shortcodes {
		function get_called_class(){ return get_class($this); }

		public $do_before = false; 

		/** Add the shortcode to the composer */
		function composer(){
			return array(
				'composer'		=> true,
				'droppable'		=> true,
				'ajax'			=> true,
				'icon'			=> 'portfolio',
				'group'			=> 'composer_post_list',
				'do_shortcode'	=> false,
				'line'			=> 200,
				'options'		=> array(
					'title'				=> __('Portfolio','cloudfw'),
					'column'			=> '1/1',
					'allow_columns'		=> false,
					'not_in'			=> array('CloudFw_Shortcode_Portfolio', 'CloudFw_Shortcode_Portfolio_Item'),
					'allow_only'		=> array('CloudFw_Shortcode_Portfolio_Item'),
					'error_messages'	=> array(
						'not_in'			=> array(
							'CloudFw_Shortcode_Portfolio' => array(
								'message' 	=> __('You must add a portfolio post instead of portfolio container here.','cloudfw')
							)
						),
					)
				)
			);
		}

		/** Run */
		function shortcode( $atts = array(), $content =  NULL ) {
			global $wp_query;

			do_shortcode($content);
			$post_ids = self::$shortcode_vars['portfolio']['ids'];
			unset(self::$shortcode_vars['portfolio']['ids']);

			if ( isset($atts['from']) && $atts['from'] == 'all' ){
				
			}
			elseif ( $atts['from'] == 'a category' && isset($atts['id_cat']) && $atts['id_cat'] ){
				$atts['id'] = $atts['id_cat'];
			}
			elseif ( $atts['from'] == 'a filter' && isset($atts['id_filter']) && $atts['id_filter'] ){
				$atts['id'] = $atts['id_filter'];
			}
			elseif ( $atts['from'] == 'selected posts' && $atts['id_selected'] ){
				$atts['id'] = $atts['id_selected'];
			}
			elseif ( $atts['from'] == 'a post gallery' && $atts['id_post'] ){
				$atts['id'] = $atts['id_post'];
			}

			if ( is_array($post_ids) && !empty($post_ids) ) {
				$atts['from'] = 'selected posts';
				$atts['id'] = $post_ids;
			}

			if ( $atts['from'] !== 'all' && $atts['from'] !== 'related' )
				if ( isset($atts['id']) && is_string($atts['id']) )
					if ( !isset( $atts['id'] ) || !preg_match("/^[0-9,]+$/", $atts['id'] ) )
						return cloudfw_error_message('<a href="'.get_edit_post_link( $wp_query->queried_object_id ).'">'.__('Please insert an correct ID key for the portfolio posts widget by editing this post.','cloudfw').'</a>');

			if ( isset($atts['pagination']) && $atts['pagination'] == 1 )
				if ( get_query_var('pagename') == cloudfw_get_option( 'portfolio',  'slug' )  )
					return cloudfw_error_message( sprintf( __('You cannot use pagination with the portfolio shortcode when the current page slug is <strong>/%s/</strong>. Please change the slug of the page to use pagination in portfolio.','cloudfw'), cloudfw_get_option( 'portfolio',  'slug' ) ) );
			
			$output = cloudfw_module( 'CloudFw_Page_Generator_Portfolio', 'portfolio', $atts );
			
			return "{$output}";
		}

		/** Scheme */
		function scheme() {
			return array(
				'title'		=>	__('Portfolio','cloudfw'),
				'ajax'		=>	true,
				'script'	=> array(
					'shortcode'  => 'portfolio',
					'tag_close'  => false,
					'attributes' =>	array( 
						'orderby' 			=> array( 'e' => 'portfolio_orderby'),
						'order' 			=> array( 'e' => 'portfolio_order'),
						'layout' 			=> array( 'e' => 'portfolio_layout'),
						'from' 				=> array( 'e' => 'portfolio_source', 'required' => __('Please select source type for portfolio','cloudfw') ),
						'id_cat'			=> array( 'attribute' => 'id', 'e' => 'portfolio_ids_cat', 'required' => __('Please select a category','cloudfw') ),
						'id_filter'			=> array( 'attribute' => 'id', 'e' => 'portfolio_ids_filter', 'required' => __('Please select a filter','cloudfw') ),
						'id_post' 			=> array( 'attribute' => 'id', 'e' => 'portfolio_ids_post', 'required' => __('Please select a portfolio post','cloudfw') ),

						'id_selected'		=> array( 'attribute' => 'id', 'e' => 'portfolio_ids_selected_posts', 'force' => true, 'multi' => 'portfolio_post_id', 'seperator' => ',', 'required' => array( 
																			'custom' 	=> '!jQuery(".portfolio_post_id").length > 0',
																			'message' 	=> __('Please select some post to add into the portfolio','cloudfw'),
																		) ),

						'filters'          	=> array( 'e' => 'portfolio_filters_ids', 'array' => false, 'check-null' => true, 'required' => __('Please select some filter','cloudfw') ),
						'filters_position' 	=> array( 'e' => 'portfolio_filters_position' ),
						'filters_style' 	=> array( 'e' => 'portfolio_filters_style' ),
						'filters_title' 	=> array( 'e' => 'portfolio_filters_title' ),
						'columns'          	=> array( 'e' => 'portfolio_columns' ),
						'limit'            	=> array( 'e' => 'portfolio_limit', 'check-default' => '0' ),
						'height'           	=> array( 'e' => 'portfolio_thumbnail_height' ),
						'pagination'       	=> array( 'e' => 'portfolio_pagination', 'onoff' => true, 'check-default' => 0 ),
						'title_element'     => array( 'e' => 'portfolio_title_size', 'onoff' => true ),
						'title_align'    	=> array( 'e' => 'portfolio_title_align', 'onoff' => true ),
						'default_icon' 		=> array( 'e' => 'portfolio_default_icon' ),
						'default_button_text'
											=> array( 'e' => 'portfolio_default_button_text' ),

						'show_desc' 		=> array( 'e' => 'portfolio_show_desc', 'onoff' => true ),
						'show_caption' 		=> array( 'e' => 'portfolio_show_caption', 'onoff' => true ),

						'image_ratio'     	=> array( 'e' => 'portfolio_image_ratio' ),
						'video_ratio'  		=> array( 'e' => 'portfolio_video_ratio' ),
						
						'link_target'     	=> array( 'e' => 'portfolio_link_target' ),

						'gallery_rotate'  	=> array( 'e' => 'portfolio_gallery_rotate' ),

						'shadow' 			=> array( 'e' => 'portfolio_shadow' ),
						'margin_top'     	=> array( 'e' => 'margin_top' ),
						'margin_bottom'  	=> array( 'e' => 'margin_bottom' ),

					),
					'if' =>	array(
						array( 
							'type' 	  => 'toggle',
							'e' 	  => 'portfolio_layout',
							'mode' 	  => 'same',
							'related' => 'porfolioLayoutOptions',
							'targets' => array( 
								array('', '.porfolioLayoutOptions'),
								array('manual', '.porfolioLayoutOptions'),
								array('masonry', '.porfolioLayoutOptions'),
							)
						),
						array( 
							'type' 	  => 'toggle',
							'e' 	  => 'portfolio_source',
							'related' => 'porfolioSources',
							'targets' => array( 
								array('a category', '#portfolio_ids_cat'),
								array('a filter', '#portfolio_ids_filter'),
								array('a post gallery', '#portfolio_ids_post'),
								array('selected posts', '#portfolio_ids_selected_posts') 
							)
						),
						array( 
							'type' 	  => 'toggle',
							'e' 	  => 'portfolio_filters',
							'related' => 'porfolioFilters',
							'targets' => array( 
								array('1', '#portfolio_filters_ids'),
								array('1', '#portfolio_filters_style'),
								array('1', '#portfolio_filters_position'),
								array('1', '#portfolio_filters_title'),
							)
						),
						array( 
							'type' 	  => 'toggle',
							'e' 	  => 'portfolio_limit',
							'related' => 'portfolioPaginationOptions',
							'!'		  => true,
							'targets' => array( 
								array('0', '#portfolio_pagination'),
							)
						)
					)
				),
				'data'		=>	array(

					array(
						'type'	=>	'include',
						'path'	=>	dirname(__FILE__) . '/module.source.php'

					),

					array(
						'type'		=> 'mini-section',
						'title'		=> __('Layout','cloudfw'),
						'data'		=> array(

							array(
								'type'		=> 'module',
								'title'		=> __('Layout','cloudfw'),
								'data'		=> array(

									## Element
									array(
										'type'		=>	'select',
										'id'		=>	'portfolio_layout',
										'value'		=>	$this->get_value('portfolio_layout'),
										'main_class'=>  'input input_250',
										'ui'		=>	true,
										'source'	=>	array(
											'NULL' 				=> __('Classic Layout','cloudfw'),
											'masonry' 			=> __('Masonry Layout','cloudfw'),
											'carousel' 			=> __('Carousel Layout','cloudfw'),
										)							
									), // #### element: 0

								)

							),

							array(
								'type'		=>	'module',
								'title'		=>	__('Columns','cloudfw'),
								'data'		=>	array(
									## Element
									array(
										'type'		=>	'select',
										'id'		=>	'portfolio_columns',
										'value'		=>	$this->get_value('portfolio_columns', 3),
										'source'	=>	array(
											'type'		=>	'function',
											'function'	=>	'cloudfw_admin_loop_columns',
										),
										'width'		=>	250,
									),
								)
							), 

							array(
								'type'		=>	'module',
								'title'		=>	__('Post Limit / Post Per Page','cloudfw'),
								'data'		=>	array(
									array(
										'type'		=>	'slider',
										'id'		=>	'portfolio_limit',
										'value'		=>	$this->get_value('portfolio_limit', 0),
										'class'		=>	'input_250',
										'min'		=>	0,
										'max'		=>	40,
										'step'		=>	1,
										'steps'		=>	array(
											'0'			=>	__('no limit','cloudfw')
										),
										'unit'		=>	'post(s)',
									)
								)

							),

							array(
								'type'		=>	'module',
								'related'	=>	'portfolioPaginationOptions',
								'title'		=>	__('Pagination','cloudfw'),
								'data'		=>	array(
									array(
										'type'		=>	'onoff',
										'id'		=>	'portfolio_pagination',
										'value'		=>	$this->get_value('portfolio_pagination', 'FALSE'),
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
										'id'		=>	'portfolio_image_ratio',
										'value'		=>	$this->get_value('portfolio_image_ratio', '16:9'),
										'source'	=>	array(
											'type' 		=> 'function',
											'function'	=> 'cloudfw_admin_loop_aspect_ratio',
										),				
										'width'		=>  150,
									), // #### element: 0


									## Element
									array(
										'type'		=>	'select',
										'id'		=>	'portfolio_video_ratio',
										'value'		=>	$this->get_value('portfolio_video_ratio', '16:9'),
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
								'title'		=> __('Box Shadow','cloudfw'),
								'data'		=> array(

									## Element
									array(
										'type'		=>	'select',
										'id'		=>	'portfolio_shadow',
										'value'		=>	$this->get_value('portfolio_shadow'),
										'source'	=>	array(
											'type'			=> 'function',
											'function'		=> 'cloudfw_admin_loop_shadows',
										),
										'width'		=>	250,

									), // #### element: 0

								)

							),

						)
					
					),

					array(
						'type'		=> 'mini-section',
						'title'		=> __('Portfolio Items','cloudfw'),
						'data'		=> array(

							array(
								'type'		=> 'module',
								'condition'	=> !$this->is_composer,
								'title'		=> __('Source','cloudfw'),
								'data'		=> array(

									## Element
									array(
										'type'		=>	'select',
										'id'		=>	'portfolio_source',
										'value'		=>	$this->get_value('portfolio_source'),
										'main_class'=>  'input input_250',
										'ui'		=>	true,
										'source'	=>	array(
											'all' 				=> __('Get all portfolio posts','cloudfw'),
											'a category' 		=> __('Get by a category','cloudfw'),
											'a filter' 			=> __('Get by filter','cloudfw'),
											'selected posts' 	=> __('Get by selected posts','cloudfw'),
										)							
									), // #### element: 0

								)

							),

							array(
								'type'		=> 'module',
								'condition'	=> $this->is_composer,
								'title'		=> __('Portfolio Source','cloudfw'),
								'data'		=> array(

									## Element
									array(
										'type'		=>	'select',
										'id'		=>	'portfolio_source',
										'value'		=>	$this->get_value('portfolio_source'),
										'main_class'=>  'input input_250',
										'ui'		=>	true,
										'source'	=>	array(
											'all' 				=> __('Get all portfolio posts','cloudfw'),
											'a category' 		=> __('Get by category','cloudfw'),
											'a filter' 			=> __('Get by filter','cloudfw'),
										)							
									), // #### element: 0

								)

							),

							array(
								'type'		=>	'module',
								'related'	=>	'porfolioSources',
								'hidden'	=>	true,
								'title'		=>	__('Source Categories','cloudfw'),
								'data'		=>	array(

									## Element
									array(
										'type'		=>	'select',
										'id'		=>	'portfolio_ids_cat',
										'value'		=>	$this->get_value('portfolio_ids_cat'),
										'main_class'=>  'input input_250',
										'ui'		=>	true,
										'source'	=>	array(
											'type'		=>	'function',
											'function'	=>	'cloudfw_admin_loop_portfolio_cats'
										)							
									), // #### element: 0

								)

							),

							array(
								'type'		=>	'module',
								'related'	=>	'porfolioSources',
								'hidden'	=>	true,
								'title'		=>	__('Source Filters','cloudfw'),
								'data'		=>	array(

									## Element
									array(
										'type'		=>	'select',
										'id'		=>	'portfolio_ids_filter',
										'value'		=>	$this->get_value('portfolio_ids_filter'),
										'main_class'=>  'input input_250',
										'ui'		=>	true,
										'source'	=>	array(
											'type'		=>	'function',
											'function'	=>	'cloudfw_admin_loop_terms',
											'vars'		=>	array('portfolio-filter')
										)							
									), // #### element: 0

								)

							),

							array(
								'type'		=>	'module',
								'condition' =>	!$this->is_composer,
								'related'	=>	'porfolioSources',
								'hidden'	=>	true,
								'title'		=>	__('Selected Posts','cloudfw'),
								'data'		=>	array(

									## Element
									array(
										'type'		=>	'select',
										'id'		=>	'portfolio_ids_selected_posts',
										'value'		=>	$this->get_value('portfolio_ids_selected_posts'),
										'multiple'	=>	true,
										'brackets'	=>	false,
										'height'	=>	250,
										'main_class'=>  'input input_400',
										'ui'		=>	true,
										'source'	=>	array(
											'type'		=>	'function',
											'function'	=>	'cloudfw_admin_loop_portfolio_posts_raw'
										),
										'after'		=>	array(

											array( 'type'=>'html', 'data'=>'<div class="clear"></div><a id="cloudfw_add_portfolio_post" class="small-button small-green" href="javascript:;"><span>Add Selected Posts</span></a><div class="clear"></div><ul id="selected_portfolio_items_2" class="sortable_sliders ui-sortable"></ul>' ),

											array(
												'type'		=>	'jquery',
												'source'	=>	array(
													'type'		=>	'function',
													'function'	=>	'cloudfw_admin_script_portfolio'
												)		
											),

											array(
												'type'		=>	'html',
												'source'	=>	array(
													'type'		=>	'function',
													'function'	=>	'cloudfw_admin_js_datas_portfolio'
												)	
											),

										)				
									), // #### element: 0

								)

							),

							array(
								'type'		=>	'module',
								'title'		=>	__('Order By','cloudfw'),
								'data'		=>	array(

									## Element
									array(
										'type'		=>	'select',
										'id'		=>	'portfolio_orderby',
										'value'		=>	$this->get_value('portfolio_orderby'),
										'width'		=>	250,
										'source'	=>	array(
											'type'		=>	'function',
											'function'	=>	'cloudfw_admin_loop_order_by',
											'exclude'	=>	array('menu_order')
										)							
									), // #### element: 0

								)

							),

							array(
								'type'		=>	'module',
								'title'		=>	__('Order','cloudfw'),
								'data'		=>	array(

									## Element
									array(
										'type'		=>	'select',
										'id'		=>	'portfolio_order',
										'value'		=>	$this->get_value('portfolio_order'),
										'width'		=>	250,
										'source'	=>	array(
											'type'		=>	'function',
											'function'	=>	'cloudfw_admin_loop_order',
										)							
									), // #### element: 0

								)

							),


						)

					),

					array(
						'type'		=> 'mini-section',
						'title'		=> __('Filters','cloudfw'),
						'related'	=> 'porfolioLayoutOptions',
						'data'		=> array(


							array(
								'type'		=>	'module',
								'title'		=>	__('Show Filter Bar','cloudfw'),
								'data'		=>	array(
									array(
										'type'		=>	'onoff',
										'id'		=>	'portfolio_filters',
										'value'		=>	$this->get_value('portfolio_filters', 'FALSE'),
									)
								)
							),

							array(
								'type'		=>	'module',
								'title'		=>	__('Filter Bar Title','cloudfw'),
								'related'	=>	'porfolioFilters',
								'data'		=>	array(

									## Element
									array(
										'type'		=>	'text',
										'id'		=>	'portfolio_filters_title',
										'value'		=>	$this->get_value('portfolio_filters_title'),
										'width'		=>	200
									), // #### element: 0
								)

							),	

							array(
								'type'		=>	'module',
								'title'		=>	__('Portfolio Filters','cloudfw'),
								'related'	=>	'porfolioFilters',
								'data'		=>	array(

									## Element
									array(
										'type'		=>	'select',
										'id'		=>	'portfolio_filters_ids',
										'value'		=>	$this->get_value('portfolio_filters_ids'),
										'main_class'=>  'input input_250',
										'ui'		=>	true,
										'source'	=>	array(
											'type'		=>	'function',
											'function'	=>	'cloudfw_admin_loop_portfolio_filters'
										),
										'multiple'	=>	true,
										'brackets'	=>	_if($this->is_composer, true, false),
										'height'	=>	200,
									), // #### element: 0
								)

							),

							array(
								'type'		=>	'module',
								'title'		=>	__('Filters Bar Style','cloudfw'),
								'related'	=>	'porfolioFilters',
								'data'		=>	array(

									## Element
									array(
										'type'		=>	'select',
										'id'		=>	'portfolio_filters_style',
										'value'		=>	$this->get_value('portfolio_filters_style'),
										'main_class'=>  'input input_250',
										'ui'		=>	true,
										'source'	=>	array(
											'NULL'		=> __('Fullwidth Style','cloudfw'),
											'boxed'		=> __('Boxed Style','cloudfw'),
										),
									), // #### element: 0
								)

							),

							array(
								'type'		=>	'module',
								'title'		=>	__('Position of the Filters','cloudfw'),
								'related'	=>	'porfolioFilters',
								'data'		=>	array(

									## Element
									array(
										'type'		=>	'select',
										'id'		=>	'portfolio_filters_position',
										'value'		=>	$this->get_value('portfolio_filters_position'),
										'main_class'=>  'input input_250',
										'ui'		=>	true,
										'source'	=>	array(
											'NULL'		=> __('Left','cloudfw'),
											'center'	=> __('Center','cloudfw'),
											'right'		=> __('Right','cloudfw'),
										),
									), // #### element: 0
								)

							),

						)

					),


					array(
						'type'		=> 'mini-section',
						'title'		=> __('Hover Thumbnail Overlay','cloudfw'),
						'data'		=> array(


							array(
								'type'		=>	'module',
								'title'		=>	__('Default Overlay Icon','cloudfw'),
								'data'		=>	array(
									array(
										'type'		=>	'icon-selector',
										'id'		=>	'portfolio_default_icon',
										'value'		=>	$this->get_value('portfolio_default_icon'),
										'desc'		=>	__('This may be overridden by posts.','cloudfw')
									)
								)
							),

							array(
								'type'		=>	'module',
								'title'		=>	__('Default Overlay Text','cloudfw'),
								'data'		=>	array(
									array(
										'type'		=>	'text',
										'id'		=>	'portfolio_default_button_text',
										'value'		=>	$this->get_value('portfolio_default_button_text'),
										'desc'		=>	__('This may be overridden by posts.','cloudfw')
									)
								)
							),


						)

					),


					array(
						'type'		=> 'mini-section',
						'title'		=> __('Post Titles','cloudfw'),
						'data'		=> array(

							array(
								'type'		=> 'module',
								'title'		=> __('Title Size','cloudfw'),
								'data'		=> array(

									## Element
									array(
										'type'		=>	'select',
										'id'		=>	'portfolio_title_size',
										'value'		=>	$this->get_value('portfolio_title_size', 'h5'),
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
											'strong'	=> __('Strong','cloudfw'),
										)

									), // #### element: 0

								)

							),

							array(
								'type'		=> 'module',
								'title'		=> __('Title Align','cloudfw'),
								'data'		=> array(

									## Element
									array(
										'type'		=>	'select',
										'id'		=>	'portfolio_title_align',
										'value'		=>	$this->get_value('portfolio_title_align', 'center'),
										'ui'		=>	true,
										'main_class'=>  'input input_250',
										'source'	=>	array(
											'left'		=> __('Left','cloudfw'),
											'center'	=> __('Center','cloudfw'),
											'right'		=> __('Right','cloudfw'),
										)

									), // #### element: 0

								)

							),

						)

					),


					array(
						'type'		=> 'mini-section',
						'title'		=> __('Contents','cloudfw'),
						'data'		=> array(

							array(
								'type'		=>	'module',
								'title'		=>	__('Show Post Descriptions','cloudfw'),
								'data'		=>	array(
									array(
										'type'		=>	'onoff',
										'id'		=>	'portfolio_show_desc',
										'value'		=>	$this->get_value('portfolio_show_desc', true),
									)
								)
							),

							array(
								'type'		=>	'module',
								'title'		=>	__('Show Post Captions','cloudfw'),
								'data'		=>	array(
									array(
										'type'		=>	'onoff',
										'id'		=>	'portfolio_show_caption',
										'value'		=>	$this->get_value('portfolio_show_caption', true),
									)
								)
							),

						)

					),

					array(
						'type'		=> 'mini-section',
						'title'		=> __('Galleries','cloudfw'),
						'data'		=> array(

							array(
								'type'		=>	'module',
								'title'		=>	__('Auto Rotate for Gallery Thumbnails?','cloudfw'),
								'data'		=>	array(
									array(
										'type'		=>	'onoff',
										'id'		=>	'portfolio_gallery_rotate',
										'value'		=>	$this->get_value('portfolio_gallery_rotate', 'FALSE'),
									)
								)
							),


						)

					),
				

					array(
						'type'		=> 'mini-section',
						'title'		=> __('Others','cloudfw'),
						'data'		=> array(


							array(
								'type'		=> 'module',
								'title'		=> __('Link Targets','cloudfw'),
								'data'		=> array(

									## Element
									array(
										'type'		=>	'select',
										'id'		=>	'portfolio_link_target',
										'value'		=>	$this->get_value('portfolio_link_target'),
										'ui'		=>	true,
										'main_class'=>  'input input_250',
										'source'	=>	array(
											'NULL'		=> __('Default','cloudfw'),
											'_blank'	=> __('New Page','cloudfw'),
										)

									), // #### element: 0

								)

							),

							array(
								'type'		=>	'global-scheme',
								'scheme'	=>	'margins',
								'this'		=>	$this
							),

						)

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
								'id'	=>	'CloudFw_Shortcode_Portfolio_Item',
								//'before'=>	'<div style="margin: 5px 0; color: #ccc; ">'.__('edit options or','cloudfw').'</div>',
								'title'	=>	__('+ Add portfolio post','cloudfw'),
							),
						)
					)
				)
			);
		}

	}

}

cloudfw_register_shortcode( 'CloudFw_Shortcode_Portfolio_Item');
if ( ! class_exists('CloudFw_Shortcode_Portfolio_Item') ) {
	class CloudFw_Shortcode_Portfolio_Item extends CloudFw_Shortcodes {

		function get_called_class(){ return get_class($this); }


		/** Add the shortcode to the composer */
		function composer(){
			return array(
				'composer'		=> true,
				'ajax'			=> true,
				'list'			=> false,
				'icon'			=> 'portfolio-post',
				'group'			=> 'composer_post_list',
				'do_shortcode'	=> false,
				'line'			=> 200,
				'options'		=> array(
					'title'				=> __('Portfolio Post','cloudfw'),
					'column'			=> '1/1',
					'allow_columns'		=> false,

					'sync_title'		=> 'the_content_id',
					'in'				=> 'CloudFw_Shortcode_Portfolio',
					'not_in'			=> 'CloudFw_Shortcode_Portfolio_Item',
					'not_allow'			=> array('CloudFw_Composer_Container'),
					'error_messages'	=> array(
						'in'				=> array(
							'CloudFw_Shortcode_Portfolio' => array(
								'message' 	=> __('You can only add a portfolio post into a portfolio container.','cloudfw')
							)
						)
					)

				)
			);
		}

		/** Run */
		function shortcode( $atts = array(), $content =  NULL ) {
			extract(shortcode_atts(array(
				"id" 		=> NULL
			), $atts));
			
			self::$shortcode_vars['portfolio']['ids'][] = $id;
		}

		/** Scheme */
		function scheme() {
			return array(
				'script'	=> array(
					'shortcode'		=> 'the_content',
					'tag_close'  	=> false,
					'attributes' 	=> array( 
						'id' 		=> array( 'e' => 'the_content_id' ),
					)
				),
				'data'		=>	array(

					array(
						'type'	=>	'include',
						'path'	=>	dirname(__FILE__) . '/module.source.php'

					),

					array(
						'type'		=> 'module',
						'title'		=> __('Portfolio Posts','cloudfw'),
						'data'		=> array(

							## Element
							array(
								'type'		=>	'select',
								'id'		=>	'the_content_id',
								'value'		=>	$this->get_value('the_content_id'),
								'main_class'=>  'input input_350',
								'ui'		=>	true,
								'source'	=>	array(
									'type'		=>	'function',
									'function'	=>	'cloudfw_admin_loop_portfolio_posts_raw'
								)							
							), // #### element: 0

						)

					),
				
				)

			);

		}



		/** Typo map */
		function typo_map( $map ){
			cloudfw_add_typo_setting( $map, 'portfolio_post_titles', '.portfolio-container .ui--content-box-title-text', array( 'font-weight' => 600 ));
			cloudfw_add_typo_setting( $map, 'portfolio_post_caption', '.portfolio-container .ui--content-box-title-caption');
		    return $map;
		}


		/** Typo Scheme */
		function typo_scheme( $scheme, $data, $number ){

			$scheme[ cloudfw_id_for_sequence( $scheme, $number ) ] = array(
				'type'			=>	'container',
				'width'			=>	940,
				'footer'		=>	false,
				'title'			=>	__('Portfolio','cloudfw'),
				'data'			=>	array(
				
					array(
						'type'		=>	'typo-set',
						'title'		=>	__('Portfolio Shortcode - Post Titles','cloudfw'),
						'id'		=>	cloudfw_sanitize('portfolio_post_titles'),
						'value'		=>	$data['portfolio_post_titles'],
						'data'		=>	array()
						
					),

					array(
						'type'		=>	'typo-set',
						'title'		=>	__('Portfolio Shortcode - Post Captions','cloudfw'),
						'id'		=>	cloudfw_sanitize('portfolio_post_caption'),
						'value'		=>	$data['portfolio_post_caption'],
						'data'		=>	array()
						
					),



				
				) 


			);

			return $scheme;

		}

	}

}


/**
 *	Add a shortcode for Related Portfolios
 *
 *	@since 1.0
 */
cloudfw_register_shortcode( 'CloudFw_Shortcode_Related_Portfolios', 'related_portfolios' );
if ( ! class_exists('CloudFw_Shortcode_Related_Portfolios') ) {
	class CloudFw_Shortcode_Related_Portfolios extends CloudFw_Shortcodes {

		function get_called_class(){ return get_class($this); }


		/** Run */
		function shortcode( $atts = array(), $content =  NULL ) {
			global $wp_query;

			ob_start();	cloudfw_module( 'CloudFw_Page_Generator_Portfolio', 'related_portfolios', $atts, $content ); 
			$output = ob_get_contents(); ob_end_clean();
			
			return "{$output}";
		}

	}

}