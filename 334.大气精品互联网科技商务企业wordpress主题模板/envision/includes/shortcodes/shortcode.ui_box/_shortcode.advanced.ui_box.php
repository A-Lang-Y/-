<?php
/*
 * Plugin Name: UI Boxes 
 * Plugin URI: http://cloudfw.net
 * Description: 
 * Version: 1.0
 * Author: Orkun Gürsel
 * Author URI: http://orkungursel.com
 * Shortcode:  [ui_box]
 */

cloudfw_register_shortcode( 'CloudFw_Shortcode_UI_Box', 'ui_box' );
if ( ! class_exists('CloudFw_Shortcode_UI_Box') ) {

	class CloudFw_Shortcode_UI_Box extends CloudFw_Shortcodes {

		function get_called_class(){ return get_class($this); }

		/** Add the shortcode to the composer */
		function composer(){
			return array(
				'composer'      => true,
				'ajax'          => true,
				'icon'          => 'rich-content-box',
				'group'         => 'composer_widgets',
				'line'          => 200,
				'options'       => array(
					'title'             => __('Boxed Media + Content','cloudfw'),
					'sync_title'        => 'box_title',
					'column'            => '1/1',
					'allow_columns'     => true,
				)
			);
		}

		/** Run */
		function shortcode( $atts = array(), $content =  NULL ) {
			$media = isset($atts['media']) ? $atts['media'] : 'image'; 
			$ratio = isset($atts['ratio']) ? $atts['ratio'] : NULL;

			$atts['media'] = $media; 
			$atts['image_ratio'] = $ratio; 
			$atts['video_ratio'] = $ratio; 

			if ( $media == 'gallery' ) {
				if ( !empty($atts['images']) && is_array($atts['images']) ) {
					$images = array();
					foreach ( (array) $atts['images'] as $i => $src ) {
						$images[ $i ]['src'] = $src;
					}
					$atts['images'] = $images;
				}
				unset($atts['video']);
			} elseif ( $media == 'video' ) {
				unset($atts['image']);
				unset($atts['images']);
			} else {
				unset($atts['images']);
			}

			unset($atts['indicator']);

			return '<div class="ui--box-widget">' . cloudfw_UI_box( $atts, $content ) . '</div>';
		}

		/** Scheme */
		function scheme() {
			return array(
				'title'     => __('Boxed Media + Content','cloudfw'),
				'ajax'      => true,
				'script'    => array(
					'shortcode'     => 'ui_box',
					'tag_close'     => true,
					'attributes'    => array( 
						'name'          => array( 'e' => 'testimonial_name' ),
						'caption'       => array( 'e' => 'testimonial_caption' ),
						'image'         => array( 'e' => 'testimonial_avatar' ),
						'content'       => array( 'e' => 'testimonial_text' ),

						'id'              => array( 'e' => 'box_id' ),
						'class'           => array( 'e' => 'box_class' ),
						'style'           => array( 'e' => 'box_style' ),
						'margin_top'      => array( 'e' => 'margin_top' ),
						'margin_bottom'   => array( 'e' => 'margin_bottom' ),
						
						'media'           => array( 'e' => 'box_media' ),
						'ratio'           => array( 'e' => 'box_ratio' ),
						'image'           => array( 'e' => 'box_image' ),
						'image_hover'     => array( 'e' => 'box_image_hover' ),
						'images'          => array( 'e' => 'box_images' ),
						'video'           => array( 'e' => 'box_video' ),
						
						'title'           => array( 'e' => 'box_title' ),
						'title_element'   => array( 'e' => 'box_title_element' ),
						'title_size'      => array( 'e' => 'box_title_size' ),
						'title_height'    => array( 'e' => 'box_title_height' ),
						'title_align'     => array( 'e' => 'box_title_align' ),

						'caption'         => array( 'e' => 'box_caption' ),
						'caption_element' => array( 'e' => 'box_caption_element' ),

						'link'            => array( 'e' => 'box_link' ),
						'link_style'      => array( 'e' => 'box_link_style' ),
						'target'          => array( 'e' => 'box_link_target' ),

						'hover_effect'    => array( 'e' => 'box_hover_effect' ),
						'hover_text'      => array( 'e' => 'box_hover_text' ),
						'hover_icon'      => array( 'e' => 'box_hover_icon' ),

						'footer'          => array( 'e' => 'box_footer' ),
						'footer_align'    => array( 'e' => 'box_footer_align' ),
						
						'content'         => array( 'e' => 'box_content' ),
						
						'lightbox'        => array( 'e' => 'box_lightbox', 'onoff' => true ),
						'shadow'          => array( 'e' => 'box_shadow' ),
						
						'overlay'         => array( 'e' => 'box_overlay', 'onoff' => true ),
						'button_text'     => array( 'e' => 'box_overlay_text' ),
						'overlay_bg'      => array( 'e' => 'box_overlay_bg' ),
						'icon'            => array( 'e' => 'box_icon' ),

						'attr_alt'        => array( 'e' => 'box_attr_alt' ),
						'attr_title'      => array( 'e' => 'box_attr_title' ),
					),
					'if'         => array(
						array( 
							'type'    => 'toggle',
							'e'       => 'box_media',
							'related' => 'boxMediaOptions',
							'mode'    => 'same',
							'targets' => array( 
								array('', '.boxMediaImage'),
								array('gallery', '.boxMediaGallery'),
								array('video', '.boxMediaVideo'),
							)
						)
					
					)
				),
				'data'      =>  array(


					array(
						'type'		=> 'module',
						'title'		=> __('Title Size','cloudfw'),
						'data'		=> array(

							## Element
							array(
								'type'		=>	'select',
								'id'        =>  'box_title_element',
								'value'     =>  $this->get_value('box_title_element'),
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
						'type'      => 'module',
						'title'     => __('Title','cloudfw'),
						'data'      => array(

							## Element
							array(
								'type'      =>  'textarea',
								'id'        =>  'box_title',
								'value'     =>  $this->get_value('box_title'),
								'_class'    =>  'bold',
								'editor'    =>  true,
								'autogrow'  =>  true,
								'width'     =>  400,
								'line'      =>  1,
							),

						)

					),

					array(
						'type'      => 'module',
						'title'     => __('Caption Text','cloudfw'),
						'data'      => array(

							## Element
							array(
								'type'      =>  'textarea',
								'id'        =>  'box_caption',
								'value'     =>  $this->get_value('box_caption'),
								'editor'    =>  true,
								'autogrow'  =>  true,
								'width'     =>  400,
								'line'      =>  1,
							),

						)

					),

					array(
						'type'      => 'module',
						'title'     => __('Title & Caption Align','cloudfw'),
						'data'      => array(

							## Element
							array(
								'type'      =>  'select',
								'id'        =>  'box_title_align',
								'value'     =>  $this->get_value('box_title_align'),
								'source'    =>  array(
									'type'          => 'function',
									'function'      => 'cloudfw_admin_loop_text_aligns',
								),
								'width'     =>  250,

							), // #### element: 0


						)

					),

					array(
						'type'      => 'mini-section',
						'title'     => __('Media','cloudfw'),
						'data'      => array(

							array(
								'type'      => 'module',
								'title'     => __('Media Ratio','cloudfw'),
								'data'      => array(

									array(
										'type'		=>	'select',
										'id'        =>  'box_ratio',
										'value'     =>  $this->get_value('box_ratio'),
										'source'	=>	array(
											'type' 		=> 'function',
											'function'	=> 'cloudfw_admin_loop_aspect_ratio',
										),				
										'width'		=>  150,
									),

								)

							),

							array(
								'type'      => 'module',
								'title'     => __('Media Type','cloudfw'),
								'data'      => array(

									## Element
									array(
										'type'      =>  'select',
										'id'        =>  'box_media',
										'value'     =>  $this->get_value('box_media'),
										'source'    =>  array(
											'NULL'      =>  __('Image','cloudfw'),
											'gallery'   =>  __('Image Gallery','cloudfw'),
											'video'     =>  __('Video','cloudfw'),
										),
										'width'     =>  250,
									),

								)

							),


							array(
								'type'      => 'module',
								'related'   => 'boxMediaOptions boxMediaImage',
								'title'     => __('Image','cloudfw'),
								'data'      => array(

									## Element
									array(
										'type'      =>  'upload',
										'id'        =>  'box_image',
										'value'     =>  $this->get_value('box_image'),
										'removable' =>  true,
										'hide_input'=>  true,
										'library'   =>  true,
										'store'     =>  true,
									)

								)

							),

							array(
								'type'      => 'module',
								'related'   => 'boxMediaOptions boxMediaImage',
								'title'     => __('Hover Image','cloudfw'),
								'data'      => array(

									## Element
									array(
										'type'      =>  'upload',
										'id'        =>  'box_image_hover',
										'value'     =>  $this->get_value('box_image_hover'),
										'removable' =>  true,
										'hide_input'=>  true,
										'library'   =>  true,
										'store'     =>  true,
									)

								)

							),

							array(
								'type'      => 'module',
								'related'   => 'boxMediaOptions boxMediaImage',
								'title'     => __('Hover Image Transition','cloudfw'),
								'data'      => array(

									## Element
									array(
										'type'      =>  'select',
										'id'        =>  'box_hover_effect',
										'value'     =>  $this->get_value('box_hover_effect'),
										'source'    =>  array(
											'type'          => 'function',
											'function'      => 'cloudfw_UI_box_hover_effects',
										),
										'width'     =>  400,

									), // #### element: 0

								)

							),

							array(
								'type'      =>  'module',
								'related'   => 'boxMediaOptions boxMediaGallery',
								'layout'    =>  'raw',
								'data'      =>  array(


									array(
										'type'      =>  'sorting',
										'id'        =>  'gallery',
										'item:id'   =>  'gallery_clone',
										'axis'      =>  'both',
										'data'      => 

											cloudfw_core_loop_multi_option( 
												
												array(
													'start'     => 5,
													'indicator' => $this->get_value('indicator'),
													'dummy'     => true,
													'data'      => 

														array(
															'type'      =>  'gallery',
															'class'     =>  'gallery_clone_class',
															'sync'      =>  $this->get_field_name('box_images'),
															'data'      =>  array(
											
																## Module Item
																array(
																	'type'      =>  'remove',
																),

																## Module Item
																array(
																	'type'      =>  'indicator',
																	'id'        =>  $this->get_field_name('indicator'),
																),

																## Module Item
																array(
																	'type'      =>  'module',
																	'title'     =>  __('Image','cloudfw'),
																	'data'      =>  array(

																		## Element
																		array(
																			'type'      =>  'upload',
																			'id'        =>  $this->get_field_name('box_images'),
																			'value'     =>  $this->get_value('box_images'),
																			'reset'     =>  '',
																			'brackets'  =>  true,
																			'store'     =>  true,
																			'removable' =>  true,
																			'library'   =>  true,

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
										'type'      =>  'html',
										'data'      =>  '
											<a data-target="" class="cloudfw-action-duplicate cloudfw-ui-button cloudfw-ui-button-metro cloudfw-ui-button-metro-green" href="javascript:;" style="margin-bottom: 5px;"><span>'.__('+ Add New Gallery Item','cloudfw').'</span></a>
											<a data-target="" class="cloudfw-action-gallery-from-library cloudfw-ui-button cloudfw-ui-button-metro cloudfw-ui-button-metro-grey" href="javascript:;"><span>'.__('Insert from Media Library','cloudfw').'</span></a>
										',
									),

								)

							),



							array(
								'type'      => 'module',
								'related'   => 'boxMediaOptions boxMediaVideo',
								'title'     => __('Video','cloudfw'),
								'data'      => array(

									## Element
									array(
										'type'      =>  'text',
										'id'        =>  'box_video',
										'value'     =>  $this->get_value('box_video'),
										'width'     =>  400,
									),

								)

							),


							array(
								'type'		=> 'module',
								'layout'	=> 'split',
								'related'   => 'boxMediaOptions boxMediaImage boxMediaGallery',
								'title'		=> array(__('Alt Attribute','cloudfw'), __('Title Attribute','cloudfw')),
								'data'		=> array(

									## Element
									array(
										'type'		=>	'text',
										'id'		=>	'box_attr_alt',
										'value'		=>	$this->get_value('box_attr_alt'),
										'width'		=>	200,
							
									), // #### element: 0

									## Element
									array(
										'type'		=>	'text',
										'id'		=>	'box_attr_title',
										'value'		=>	$this->get_value('box_attr_title'),
										'width'		=>	200,
							
									), // #### element: 0

								)

							),

						)
					),


					array(
						'type'      => 'mini-section',
						'title'     => __('Content','cloudfw'),
						'data'      => array(

							array(
								'type'      => 'module',
								'title'     => __('Content/Description Text','cloudfw'),
								'data'      => array(

									## Element
									array(
										'type'      =>  'textarea',
										'id'        =>  'box_content',
										'value'     =>  $this->get_value('box_content'),
										'editor'    =>  true,
										'autogrow'  =>  true,
										'width'     =>  '90%',
										'line'      =>  5,

									),

								)

							), 

						)

					), 
					array(
						'type'      => 'mini-section',
						'title'     => __('Link','cloudfw'),
						'data'      => array(

							array(
								'type'      => 'module',
								'title'     => __('Link URL','cloudfw'),
								'data'      => array(

									## Element
									array(
										'type'      =>  'page-selector',
										'id'        =>  'box_link',
										'value'     =>  $this->get_value('box_link'),
									), // #### element: 0

								)

							), 

							array(
								'type'      => 'module',
								'title'     => __('Link Target','cloudfw'),
								'data'      => array(

									## Element
									array(
										'type'      =>  'select',
										'id'        =>  'box_link_target',
										'value'     =>  $this->get_value('box_link_target'),
										'source'    =>  array(
											'type'          => 'function',
											'function'      => 'cloudfw_admin_loop_link_targets',
										),
										'width'     =>  250,

									), // #### element: 0


								)

							),

							array(
								'type'      => 'module',
								'title'     => __('Show lightbox when clicked','cloudfw'),
								'data'      => array(

									## Element
									array(
										'type'      =>  'onoff',
										'id'        =>  'box_lightbox',
										'value'     =>  $this->get_value('box_lightbox', 'FALSE'),

									), // #### element: 0


								)

							),

						)

					), 
				

					array(
						'type'      => 'mini-section',
						'title'     => __('Shadow','cloudfw'),
						'data'      => array(

							array(
								'type'      => 'module',
								'title'     => __('Shadow','cloudfw'),
								'data'      => array(

									## Element
									array(
										'type'      =>  'select',
										'id'        =>  'box_shadow',
										'value'     =>  $this->get_value('box_shadow'),
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
						'type'      => 'mini-section',
						'title'     => __('Overlay','cloudfw'),
						'data'      => array(
							
							array(
								'type'      => 'module',
								'title'     => __('Show overlay over the image when hover','cloudfw'),
								'data'      => array(

									## Element
									array(
										'type'      =>  'onoff',
										'id'        =>  'box_overlay',
										'value'     =>  $this->get_value('box_overlay'),

									),

								)

							),

							array(
								'type'      => 'module',
								'title'     => __('Overlay Icon','cloudfw'),
								'data'      => array(

									## Element
									array(
										'type'      =>  'icon-selector',
										'id'        =>  'box_icon',
										'value'     =>  $this->get_value('box_icon'),

									),

								)

							),

							array(
								'type'      => 'module',
								'title'     => __('Overlay Button Text','cloudfw'),
								'data'      => array(

									## Element
									array(
										'type'      =>  'text',
										'id'        =>  'box_overlay_text',
										'value'     =>  $this->get_value('box_overlay_text'),
										'width'		=>	250,
									),

								)

							),

						)

					), 

					array(
						'type'      => 'mini-section',
						'title'     => __('Box Footer','cloudfw'),
						'data'      => array(

							array(
								'type'      => 'module',
								'title'     => __('Box Footer Codes','cloudfw'),
								'data'      => array(

									## Element
									array(
										'type'      =>  'textarea',
										'id'        =>  'box_footer',
										'value'     =>  $this->get_value('box_footer'),
										'editor'    =>  true,
										'autogrow'  =>  true,
										'width'     =>  '90%',
										'line'      =>  3,

									),

								)

							), 

							array(
								'type'      => 'module',
								'title'     => __('Footer Content Align','cloudfw'),
								'data'      => array(

									## Element
									array(
										'type'      =>  'select',
										'id'        =>  'box_footer_align',
										'value'     =>  $this->get_value('box_footer_align'),
										'source'    =>  array(
											'type'          => 'function',
											'function'      => 'cloudfw_admin_loop_text_aligns',
										),
										'width'     =>  250,

									), // #### element: 0


								)

							),

						)

					),                  
				
				)

			);

		}

		/** Skin map */
		function skin_map( $map ){
			$map  -> push    ( 'link_hover', '#page-wrap .ui--content-box-link .ui--content-box-title:hover .ui--content-box-title-text, #page-wrap .ui--content-box-link .ui--content-box-title:hover .ui--content-box-title-caption' );

			return cloudfw_UI_box_skin_map( $map, 'ui_box_widget', '.ui--box-widget' );

		}

		/** Skin scheme */
		function skin_scheme( $schemes, $data ){

			return cloudfw_add_skin_scheme( 'shortcode',
				$schemes,
				array(
					'type'		=>	'module-set',
					'title'		=>	__('Boxed Media + Content','cloudfw'),
					'closable'	=>	true,
					'state'		=>	'closed',
					'data'		=>	cloudfw_UI_box_skin_scheme( $data, 'ui_box_widget', 'BOXED MEDIA' ),
				),
				6 //seq

			);

		}


	}

}