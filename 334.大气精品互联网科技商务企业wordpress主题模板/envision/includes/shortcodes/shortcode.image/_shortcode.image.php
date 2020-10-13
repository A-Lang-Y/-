<?php
/*
 * Plugin Name: Image
 * Plugin URI: http://cloudfw.net
 * Description:
 * Version: 1.0
 * Author: Orkun Gürsel
 * Author URI: http://orkungursel.com
 * Shortcode:
 * Attributes:
 */

cloudfw_register_shortcode( 'CloudFw_Shortcode_Image', 'image', 'advanced', 20 );
if( ! class_exists('CloudFw_Shortcode_Image') ) {
	class CloudFw_Shortcode_Image extends CloudFw_Shortcodes {

		function get_called_class(){ return get_class($this); }


		/** Add the shortcode to the composer */
		function composer(){
			return array(
				'composer'		=> true,
				'ajax'			=> true,
				'icon'			=> 'image',
				'group'			=> 'composer_widgets',
				'line'			=> 160,
				'options'		=> array(
					'title'				=> __('Single Image','cloudfw'),
					'column'			=> '1/1',
					'allow_columns'		=> true,
				)
			);
		}

		/** Run */
		function shortcode( $atts = array(), $content =  NULL ) {

			extract(cloudfw_make_var(array(
				'id'            => '',
				'class'         => '',
				'device'        => '',
				'margin_top'    => '',
				'margin_bottom' => '',
				'margin_left'   => '',
				'margin_right'  => '',
				'floating' 		=> '',
				'src'           => NULL,
				'retina'        => NULL,
				'link'          => NULL,
				'position'      => NULL,
				'radius'        => NULL,
				'style'         => NULL,
				'title'         => NULL,
				'alt'           => NULL,

				'resize'        => NULL,
				'resize_width'  => NULL,
				'resize_height' => NULL,

				'shadow'        => NULL,
				'lightbox'      => FALSE,
				'lightbox_group'=> NULL,
			), _check_onoff_false($atts)));

			if ( !$src ) {
				return '';
			}

			$image_src = $src;

			if ( !$id ) {
				$id = cloudfw_id('ui--image');
			}

			$out  = '';
			$classes = array();
			$wrap_classes = array();

			$wrap_classes[] = 'ui--image-wrap';
			$wrap_classes[] = 'clearfix';
			$wrap_classes[] = cloudfw_visible( $device );

			if ( ! empty( $floating ) ) {
				if ( $floating == 'right' ) {
					$wrap_classes[] = 'alignright';
				} elseif ( $floating == 'left' ) {
					$wrap_classes[] = 'alignleft';
				}
			}

			$classes[] = 'ui--image';
			$classes[] = $class;

			if ( $shadow ) {
				$wrap_classes[] = 'ui--animation';
			} else {
				$classes[] = 'ui--animation';
			}

			if ( $resize && ((int) $resize_width > 0 || (int) $resize_height > 0) ) {
				$src = cloudfw_thumbnail( array( 'src' => $image_src, 'w' => (int) $resize_width, 'h' => (int) $resize_height ) );
				//$retina = cloudfw_thumbnail( array( 'src' => $image_src, 'w' => (int) $resize_width, 'h' => (int) $resize_height, 'retina' => true ) );
			}

			if ( ! cloudfw_is_retina() ) {
				$retina = '';
			}


			/** Image */
			$out .= "<img ".
				cloudfw_make_id( $id ) .
				cloudfw_make_class($classes, true) .
				cloudfw_make_attribute( array(
					'src'		=> $src,
					'alt'		=> $alt,
					'title'		=> $title,
					'data-at2x'	=> !empty($retina) ? $retina : NULL,
					'width'     => $resize_width,
					'height'    => $resize_height,
				), FALSE ) .
				cloudfw_make_style_attribute( array(
					'style'     => $style,
				), FALSE, TRUE )

			."/>";

			/** Lightbox */
			if ( $lightbox && empty( $link ) ) {
				$link = $image_src;
			}

			/** Link */
			if ( $link ) {
				$lightbox_attr = ''; 

				if ( $lightbox ) {
					$lightbox_attr = empty($lightbox_group) ? 'prettyPhoto' : "prettyPhoto[{$lightbox_group}]"; 
				}


				$out = "<a" .
					cloudfw_make_class( $wrap_classes, true) .
					cloudfw_make_attribute( array(
						'href' 		=> cloudfw_get_page_link( $link ),
						'data-rel' 	=> $lightbox_attr,
					), FALSE) .
				">{$out}</a>";

			}

			/** Add position class */
			if( $position ) {
				$wrap_classes[] = "text-" . $position;
				$wrap_classes[] = "ui--block";
			}

			$out = cloudfw_UI_shadow( $shadow, $out, 'ui--shadow-abs', '<div class="ui--image-inline-block">', '</div>' );

			$out = "<div" .
				cloudfw_make_class( $wrap_classes, true) .
				cloudfw_make_style_attribute( array(
					'margin-top'    => $margin_top,
					'margin-bottom' => $margin_bottom,
					'margin-left'   => $margin_left,
					'margin-right'  => $margin_right,
				), FALSE, TRUE ) .
			">{$out}</div>";

			return $out;
		}

		/** Scheme */
		function scheme() {
			return array(
				'type'		=>	'shortcode:sub',
				'id'		=>	'image',
				'ajax'		=>	true,
				'title'		=>	__('Single Image','cloudfw'),
				'script'	=> array(
					'shortcode'  => 'image',
					'tag_close'  => false,
					'attributes' =>	array(
						'id'            => array( 'e' => 'custom_id' ),
						'class'         => array( 'e' => 'custom_class' ),
						'floating'      => array( 'e' => 'image_floating' ),
						'device'        => array( 'e' => 'the_device' ),
						'margin_top'    => array( 'e' => 'margin_top' ),
						'margin_bottom' => array( 'e' => 'margin_bottom' ),
						'margin_left'   => array( 'e' => 'margin_left' ),
						'margin_right'  => array( 'e' => 'margin_right' ),

						'src'           => array( 'e' => 'image_src', 'required' => __('Please upload an image','cloudfw') ),
						'retina'        => array( 'e' => 'image_retina' ),
						'link'          => array( 'e' => 'image_link' ),
						'position'      => array( 'e' => 'image_position' ),
						'style'         => array( 'e' => 'image_style' ),
						'alt'           => array( 'e' => 'image_alt' ),
						'title'         => array( 'e' => 'image_title' ),
						'resize'        => array( 'e' => 'image_auto_resize', 'onoff' => true ),
						'lightbox'      => array( 'e' => 'image_lightbox', 'onoff' => true ),
						'lightbox_group'=> array( 'e' => 'image_lightbox_group' ),
						'resize_width'  => array( 'e' => 'resize_width' ),
						'resize_height' => array( 'e' => 'resize_height' ),
						'shadow'        => array( 'e' => 'image_shadow' ),
					),
					'if'		 =>	array(
						array(
							'type'    => 'toggle',
							'e' 	  => 'image_auto_resize',
							'related' => 'imageWidgetAutoResizeOptions',
							'targets' => array(
								array('1', '#resize_width'),
							)
						)

					)

				),
				'data'		=>	array(

					array(
						'type'		=> 'module',
						'title'		=> __('Visibility','cloudfw'),
						'data'		=> array(

							## Element
							array(
								'type'		=>	'select',
								'id'		=>	'the_device',
								'value'		=>	$this->get_value('the_device'),
					            'source'	=>	array(
					            	'type'		=>	'function',
					            	'function'	=>	'cloudfw_admin_get_visibility_options'
					            ),
								'width'		=>	250,
							), // #### element: 0

						)

					),

					array(
						'type'		=> 'module',
						'title'		=> __('Image','cloudfw'),
						'data'		=> array(

							## Element
							array(
								'type'		=>	'upload',
								'id'		=>	'image_src',
								'value'		=>	$this->get_value('image_src'),
								'removable'	=>	true,
								'hide_input'=>	false,
								'library'	=>	true,
								'store'		=>	true,

							), // #### element: 0

						)

					),

					array(
						'type'		=> 'module',
						'title'		=> __('Image for Retina Screens','cloudfw'),
						'optional'	=>	true,
						'data'		=> array(

							## Element
							array(
								'type'		=>	'upload',
								'id'		=>	'image_retina',
								'value'		=>	$this->get_value('image_retina'),
								'removable'	=>	true,
								'hide_input'=>	false,
								'library'	=>	true,
								'store'		=>	true,
								//'desc'	=>	''

							),

						)

					),

					array(
						'type'		=>	'mini-section',
						'title'		=>	__('Resize','cloudfw'),
						'data'		=> 	array(


							array(
								'type'		=> 'module',
								'title'		=> __('Auto Resize','cloudfw'),
								'data'		=> array(

									## Element
									array(
										'type'		=>	'onoff',
										'id'		=>	'image_auto_resize',
										'value'		=>	$this->get_value('image_auto_resize', 'FALSE'),

									), // #### element: 0

								)

							),

							array(
								'type'		=> 'module',
								'related'	=> 'imageWidgetAutoResizeOptions',
								'layout'	=> 'split',
								'title'		=> array(__('Resize Width','cloudfw'), __('Resize Height','cloudfw')),
								'data'		=> array(

									## Element
									array(
										'type'		=>	'text',
										'id'		=>	'resize_width',
										'value'		=>	$this->get_value('resize_width'),
										'width'		=>	70,
										'unit'		=>	'px',
									), // #### element: 0

									## Element
									array(
										'type'		=>	'text',
										'id'		=>	'resize_height',
										'value'		=>	$this->get_value('resize_height'),
										'width'		=>	70,
										'unit'		=>	'px',
									), // #### element: 0

								)

							),


						)

					),


					array(
						'type'		=>	'mini-section',
						'title'		=>	__('Link','cloudfw'),
						'data'		=>	array(

							
							array(
								'type'		=> 'module',
								'title'		=> __('Link','cloudfw'),
								'data'		=> array(

									## Element
									array(
										'type'		=>	'page-selector',
										'id'		=>	'image_link',
										'value'		=>	$this->get_value('image_link'),
									), // #### element: 0

								)

							),

						)

					),

					array(
						'type'		=>	'mini-section',
						'title'		=>	__('Lightbox','cloudfw'),
						'data'		=>	array(

									array(
								'type'		=> 'module',
								'layout'	=> 'split',
								'title'		=> array(__('Open link in the Lightbox?','cloudfw'), __('Lightbox Group Alias (optional)','cloudfw')),
								'data'		=> array(

									## Element
									array(
										'type'		=>	'onoff',
										'id'		=>	'image_lightbox',
										'value'		=>	$this->get_value('image_lightbox', 'FALSE'),

									), // #### element: 0

									## Element
									array(
										'type'		=>	'text',
										'id'		=>	'lightbox_group',
										'value'		=>	$this->get_value('lightbox_group'),
										'width'		=>	200,

									), // #### element: 0

								)

							),



						)

					),


					array(
						'type'		=>	'mini-section',
						'title'		=>	__('Style / Layout','cloudfw'),
						'data'		=>	array(
					

							array(
								'type'		=> 'module',
								'title'		=> __('Align','cloudfw'),
								'data'		=> array(

									## Element
									array(
										'type'		=>	'select',
										'id'		=>	'image_position',
										'value'		=>	$this->get_value('image_position'),
										'source'	=>	array(
											'NULL'		=>	__('Default','cloudfw'),
											'left'		=>	__('Left','cloudfw'),
											'center'	=>	__('Center','cloudfw'),
											'right'		=>	__('Right','cloudfw'),
										),
										'width'		=>	200

									), // #### element: 0

								)

							),

							array(
								'type'		=> 'module',
								'title'		=> __('Floating','cloudfw'),
								'data'		=> array(

									## Element
									array(
										'type'		=>	'select',
										'id'		=>	'image_floating',
										'value'		=>	$this->get_value('image_floating'),
										'source'	=>	array(
											'NULL'		=>	__('No Floating','cloudfw'),
											'left'		=>	__('Left','cloudfw'),
											'right'		=>	__('Right','cloudfw'),
										),
										'width'		=>	200

									), // #### element: 0

								)

							),
							
							array(
								'type'		=> 'module',
								'title'		=> __('Shadow','cloudfw'),
								'data'		=> array(

									## Element
									array(
										'type'		=>	'select',
										'id'		=>	'image_shadow',
										'value'		=>	$this->get_value('image_shadow'),
										'source'	=>	array(
											'type'			=> 'function',
											'function'		=> 'cloudfw_admin_loop_shadows',
										),
										'width'		=>	250,

									), // #### element: 0

								)

							),


							array(
								'type'		=> 'module',
								'title'		=> __('Margins','cloudfw'),
								'layout'	=> 'float',
								'data'		=> array(

									## Element
									array(
										'type'		=>	'text',
										'id'		=>	'margin_top',
										'title'		=>	__('Top','cloudfw'),
										'value'		=>	$this->get_value('margin_top'),
										'width'		=>	50,
										'unit'		=>	'px'
									), // #### element: 0

									## Element
									array(
										'type'		=>	'text',
										'title'		=>	__('Bottom','cloudfw'),
										'id'		=>	'margin_bottom',
										'value'		=>	$this->get_value('margin_bottom'),
										'width'		=>	50,
										'unit'		=>	'px'
									), // #### element: 0

									## Element
									array(
										'type'		=>	'text',
										'title'		=>	__('Left','cloudfw'),
										'id'		=>	'margin_left',
										'value'		=>	$this->get_value('margin_left'),
										'width'		=>	50,
										'unit'		=>	'px'
									), // #### element: 0

									## Element
									array(
										'type'		=>	'text',
										'title'		=>	__('Right','cloudfw'),
										'id'		=>	'margin_right',
										'value'		=>	$this->get_value('margin_right'),
										'width'		=>	50,
										'unit'		=>	'px'
									), // #### element: 0

								)


							),



							array(
								'type'		=> 'module',
								'title'		=> __('Custom Style Code','cloudfw'),
								'data'		=> array(

									## Element
									array(
										'type'		=>	'textarea',
										'id'		=>	'image_style',
										'value'		=>	$this->get_value('image_style'),
										'width'		=>	'90%',
										'line'		=>	'2',
										'wrap'		=>	'true',

									), // #### element: 0

								)

							),
					
						)
					
					),
					
					
					array(
						'type'		=>	'mini-section',
						'title'		=>	__('Other Options','cloudfw'),
						'data'		=>	array(

							array(
								'type'		=> 'module',
								'layout'	=> 'split',
								'title'		=> array(__('Custom ID','cloudfw'), __('Custom Class','cloudfw')),
								'data'		=> array(

									## Element
									array(
										'type'		=>	'text',
										'id'		=>	'custom_id',
										'value'		=>	$this->get_value('custom_id'),
										'width'		=>	150,
									), // #### element: 0

									## Element
									array(
										'type'		=>	'text',
										'id'		=>	'custom_class',
										'value'		=>	$this->get_value('custom_class'),
										'width'		=>	150,
									), // #### element: 0

								)

							),


							array(
								'type'		=> 'module',
								'layout'	=> 'split',
								'title'		=> array(__('Alt Attribute','cloudfw'), __('Title Attribute','cloudfw')),
								'data'		=> array(

									## Element
									array(
										'type'		=>	'text',
										'id'		=>	'image_alt',
										'value'		=>	$this->get_value('image_alt'),
										'width'		=>	200,

									), // #### element: 0

									## Element
									array(
										'type'		=>	'text',
										'id'		=>	'image_title',
										'value'		=>	$this->get_value('image_title'),
										'width'		=>	200,

									), // #### element: 0

								)

							),

						)
					
					),

				)


			);

		}


	}

}