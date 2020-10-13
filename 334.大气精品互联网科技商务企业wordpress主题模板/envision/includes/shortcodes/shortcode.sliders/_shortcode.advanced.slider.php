<?php
/*
 * Plugin Name: Slider
 * Plugin URI: http://cloudfw.net
 * Description: 
 * Version: 1.0
 * Author: Orkun Gürsel
 * Author URI: http://orkungursel.com
 * Shortcode:  [slider]
 * Attributes: (string) id
 */

cloudfw_register_shortcode( 'CloudFw_Shortcode_Slider', NULL, 'advanced', 20 );
if( ! class_exists('CloudFw_Shortcode_Slider') ) {
	class CloudFw_Shortcode_Slider extends CloudFw_Shortcodes {

		function get_called_class(){ return get_class($this); }

		public $do_before = false;
		var $atts	= array();
		var $content= array();
		var $parent_shortcode 	= 'slider'; 
		var $children_shortcode = 'slider_item'; 

		/** Add the shortcode to the composer */
		function composer(){
			return array(
				'composer'		=> true,
				'ajax'			=> true,
				'icon'			=> 'slider',
				'group'			=> 'composer_widgets',
				'line'			=> 310,
				'options'		=> array(
					'title'				=> __('Slider','cloudfw'),
					'sync_title'		=> 'slider_ids',
					'column'			=> '1/1',
					'allow_columns'		=> false,
					'instant_edit'		=> true
				)
			);
		}

		/** Add */
		function add() {
			return array(
				$this->parent_shortcode 	=> array( &$this, 'parent' ),
				$this->children_shortcode 	=> array( &$this, 'item' ),
			);
		}


		/*
		 *	Shortcode via Composer
		 */
		function shortcode($atts, $content =  NULL, $case = NULL){
			$content = '';

			if ( !empty($atts['indicator']) && is_array($atts['indicator']) ) {
				
				foreach ( (array) $atts['indicator'] as $i => $dummy )
					$content .= cloudfw_transfer_shortcode_attributes( 
						$this->children_shortcode, 
						array( 
							'title'		=> $atts['slider_title'][ $i ],
							'image' 	=> $atts['slider_image'][ $i ],
							'link' 		=> $atts['slider_link'][ $i ],
						),
						$atts['slider_content'][ $i ],
						TRUE
					);

			}
			return cloudfw_transfer_shortcode_attributes( $this->parent_shortcode, $atts, $content );
		}

		/*
		 *	Shortcode via Manual Code
		 */
		function parent($atts, $content =  NULL, $case = NULL){
			$this->atts = shortcode_atts(array(
				//'columns' 	=> 3,
			), _check_onoff_false($atts)); 
			extract( $this->atts );

			$this->contents = array();
			do_shortcode($content);

			return cloudfw_get_the_slider( $atts, $this->contents );

		}

		/**
		 *	Items
		 */
		function item($atts, $content =  NULL, $case = NULL){
			extract(shortcode_atts(array(
				'image'			=> '',
				'link'			=> '',
				'title'			=> '',
			), $atts)); 

			if ( !$image )
				return;

			$out 					= array();
			$out['slider_image'] 	= $image;
			$out['slider_url'] 		= $link;
			$out['slider_title'] 	= $title;
			$out['slider_caption'] 	= $content;

			$this->contents[] = $out;
		}

		/** Scheme */
		function scheme() {

			return array(
				'title'		=>	__('Slider','cloudfw'),
				'script'	=> array(
					'shortcode'		=> $this->parent_shortcode,
					'tag_close'  	=> true,
					'tag_newline' 	=> false,
					'attributes' 	=> array( 
						'id' 				=> array( 'e' => 'slider_ids', 'required' => __('Please select a slider','cloudfw') ),
						'content' 			=> array( 
							'e'       			=> 'slider_all', 
							'multi'   			=> 'slider_clone_class',
							'check_visiblity'   => false,
							'tag_newline'   	=> false,
							'data' 	 			=> array(

								array(
									'id' 	  => $this->children_shortcode,
									'script'  => array(
										'shortcode' 	=> $this->children_shortcode,
										'tag_close'  	=> true,
										'tag_newline_default' => true,
										'prepend' 		=> '\'+$tb+\'',
										'attributes' 	=> array(
											'title' 		=> array( 'e' => 'slider_title', 'check_visiblity' => false ),
											'image' 		=> array( 'e' => 'slider_image', 'check_visiblity' => false ),
											'link' 			=> array( 'e' => 'slider_link', 'check_visiblity' => false ),
											'content' 		=> array( 'e' => 'slider_content', 'check_visiblity' => false ),
										)
									),
								)

							)

						),
					),

				),
				'data'		=>	$this->global_scheme()

			);

		}

		/**
		 *	Global Render Scheme
		 */
		function global_scheme(){

			return array(

					array(
						'type'		=> 'module',
						'title'		=> __('Slider','cloudfw'),
						'data'		=> array(

							## Element
							array(
								'type'		=>	'select',
								'id'		=>	'slider_ids',
								'value'		=>	$this->get_value('slider_ids'),
								'main_class'=>  'input input_350',
								'ui'		=>	true,
								'source'	=>	array(
									'type'		=>	'function',
									'function'	=>	'cloudfw_admin_loop_sliders'
								)							
							), // #### element: 0

						)

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
								'data'		=> 

									cloudfw_core_loop_multi_option( 
										
										array(
											'start' 	=> 5,
											'indicator' => $this->get_value('indicator'),
											'dummy'		=> true,
											'data' 		=> 

												array(
		                                            'type'      =>  'gallery',
		                                            'class'     =>  'slider_clone_class',
		                                            'sync'      =>  $this->get_field_name('slider_image'),
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

		                                                ## Module Item
		                                                array(
		                                                    'type'      =>  'module',
		                                                    'title'     =>  __('Image','cloudfw'),
		                                                    'data'      =>  array(
													
																## Element
																array(
																	'type'		=>	'upload',
																	'id'		=>	$this->get_field_name('slider_image'),
																	'value'		=>	$this->get_value('slider_image'),
																	'reset'		=>	'',
																	'brackets'	=>	true,
																	'store'		=>	true,
																	'removable'	=>  true,
																	'library' 	=>  true,

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
																	'type'		=>	'page-selector',
																	'title'		=>	__('Custom Link','cloudfw'),
																	'id'		=>	$this->get_field_name('slider_link'),
																	'value'		=>	$this->get_value('slider_link'),
																	'reset'		=>	'',
																	'_class'	=>  'input_150',
																	'brackets'	=>	true,

																),

															)

														),

		                                                ## Module Item
		                                                array(
		                                                    'type'      =>  'module',
		                                                    'title'     =>  __('Title','cloudfw'),
		                                                    'data'      =>  array(
																## Element
																array(
																	'type'		=>	'text',
																	'id'		=>	$this->get_field_name('slider_title'),
																	'value'		=>	$this->get_value('slider_title'),
																	'reset'		=>	'',
																	'brackets'	=>	true,

																),

															)

														),

		                                                ## Module Item
		                                                array(
		                                                    'type'      =>  'module',
		                                                    'title'     =>  __('Caption','cloudfw'),
		                                                    'data'      =>  array(

																## Element
																array(
																	'type'		=>	'textarea',
																	'id'		=>	$this->get_field_name('slider_content'),
																	'value'		=>	$this->get_value('slider_content'),
																	'reset'		=>	'',
																	'brackets'	=>	true,
																	'width'		=>	'90%',
																	'line'		=>	2

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
									'type'		=>	'html',
									'data'		=>	'<a data-target="" class="cloudfw-action-duplicate cloudfw-ui-button cloudfw-ui-button-metro cloudfw-ui-button-metro-green" href="javascript:;"><span>'.__('+ Add Slider Item','cloudfw').'</span></a>',
								),

						)

					)

			);


		}


	}

}