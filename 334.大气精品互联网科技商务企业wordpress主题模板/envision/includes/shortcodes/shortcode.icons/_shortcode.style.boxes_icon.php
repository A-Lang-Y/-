<?php
/*
 * Plugin Name: Icon Boxes
 * Plugin URI: http://cloudfw.net
 * Description:
 * Version: 1.0
 * Author: Orkun Gürsel
 * Author URI: http://orkungursel.com
 * Shortcode:
 * Attributes:
 */

cloudfw_register_shortcode( 'CloudFw_Shortcode_Icon_Boxes', 'text_block', 'style', 25 );
if ( ! class_exists('CloudFw_Shortcode_Icon_Boxes') ) {
	class CloudFw_Shortcode_Icon_Boxes extends CloudFw_Shortcodes {

		function get_called_class(){ return get_class($this); }


		/** Add the shortcode to the composer */
		function composer(){
			return array(
				'composer'		=> true,
				'ajax'			=> true,
				'icon'			=> 'icon-box',
				'group'			=> 'composer_widgets',
				'line'			=> 190,
				'options'		=> array(
					'title'				=> __('Text Block + Icon','cloudfw'),
					'sync_title'		=> 'icon_box_title',
					'column'			=> '1/1',
					'allow_columns'		=> true,
				)
			);
		}

		/** Run */
		function shortcode( $atts = array(), $content =  NULL, $case = NULL ) {
			extract(shortcode_atts(array(
				"icon"             => NULL,
				"title"            => NULL,
				"title_color"      => NULL,
				"link"             => NULL,
				"lightbox"         => 'FALSE',
				"position"         => NULL,
				"title_position"   => 'left',
				"content_align"    => 'left',
				"color"            => '',
				"tag"              => 'h3',
				"style_img"        => '',
				"style_title"      => '',

				'effect_icon'      => '',
				'effect_title'     => 'fx--no-effect',
				'effect_text'      => 'fx--no-effect',

				"margin_top"       => '',
				"margin_bottom"    => '',
			), _check_onoff_false($atts)));

			$parts = array(
				"icon"	=> "",
				"title"	=> "",
				"text"	=> "",
			);

			/**
			 *	Link
			 */
			if ( !empty($link) ) {
				$link = cloudfw_get_page_link($link);

				if (!$link) {
					$link = "#";
				} elseif( $link[0] == '/' ) {
					$link = cloudfw_home_url() . $link;
				}

				$title_element = array();
				$title_element[0] = '';
				$title_element[1] = '';

				$title_element[0] .= '<a href="'. $link .'"';

				if ( $lightbox ) {
					$title_element[0] .= ' data-rel="prettyPhoto"';
				}

				$title_element[0] .= '>';
				$title_element[1] .= '</a>';

				if ( !empty( $title ) ) {
					$title = $title_element[0] . $title . $title_element[1];
				}

			}

			/**
			 *	Icon
			 */
			$parts['icon'] = cloudfw_make_icon( $icon );

			if ( ! empty( $parts['icon'] ) ) {
				$parts['icon'] = "<span".
					cloudfw_make_class( array(
						'ui--icon-box-icon',
						'ui--animation',
					) ) .
					cloudfw_make_attribute( array(
						'data-fx' => $effect_icon,
						//'data-delay' => 1000,
					), false) .
				">". $parts['icon'] ."</span>";
			}

			/**
			 *	Title
			 */
			if ( ! empty( $title ) ) {
				$parts['title']  = ""; 

				$parts['title'] .= "<{$tag}" .
					cloudfw_make_class( array(
						'ui--icon-box-title',
						'ui--animation',
						 "text-" . $title_position,
					) ) .
					cloudfw_make_attribute( array(
						'data-fx' => $effect_title,
					), false) .
				">";
				
					$parts['title'] .= "<span " .
						cloudfw_make_style_attribute( array(
							'color'    => $title_color,
						), false ) .
					">";
						$parts['title'] .= $title;
					$parts['title'] .= "</span>";

				$parts['title'] .= "</{$tag}>";

			}

			/**
			 *	Text
			 */
			if ( !empty($content) ) {
				$content = do_shortcode( cloudfw_inline_format( $content ) );

				$parts['text']  = '';
				$parts['text'] .= "<div ".
					cloudfw_make_class(array(
						"ui--animation",
						"ui--icon-box-text",
						"text-" . $content_align,
					)) .
					cloudfw_make_attribute( array(
						'data-fx' => $effect_text
					), false) .
				">";
					$parts['text'] .= $content;
				$parts['text'] .= "</div>";

			}

			/**
			 *	
			 */
			$output_content  = '';
			$output_content .= $parts['icon'];
			$output_content .= "<div ".
				cloudfw_make_class(array(
					"ui--icon-box-content",
					"ui--animation",
				)) .
			">";
				$output_content .= $parts['title'];
				$output_content .= $parts['text'];
			$output_content .= "</div>";

			/**
			 *	Box Container
			 */
			$box_classes = array();
			$box_classes[] = 'ui--icon-box';

			if ( $position == 'top' ) {
				$box_classes[] = 'position--top';
			} else {
				$box_classes[] = 'position--left';
			}

			/**
			 *	Output
			 */
			$output  = '';
			$output .= "<div ".
				cloudfw_make_class( $box_classes ) .
				cloudfw_make_style_attribute( array(
					'margin-top'    => $margin_top,
					'margin-bottom' => $margin_bottom,
				), false ) .
			">";
				$output .= $output_content;
			$output .= "</div>";
			unset($parts);

			return $output;
		}

		/** Admin Scheme */
		function scheme() {
			return array(
				'title'		=>	__('Text Block + Icon','cloudfw'),
				'script'	=> array(
					'shortcode'		=> 'text_block',
					'tag_close'  	=> true,
					'attributes' 	=> array(
						'icon'             => array( 'e' => 'icon_box_pre_icon', 'required' => __('Please select an icon','cloudfw') ),
						'link'  	       => array( 'e' => 'icon_box_link'),
						'lightbox' 	       => array( 'e' => 'icon_box_lightbox', 'onoff' => true ),
						'position'         => array( 'e' => 'icon_box_position'),
						'title'            => array( 'e' => 'icon_box_title' ),
						'title_color'      => array( 'e' => 'icon_box_title_color'),
						'title_position'   => array( 'e' => 'icon_box_title_position'),
						'content_align'    => array( 'e' => 'icon_box_content_position'),
						'content'          => array( 'e' => 'icon_box_content', 'force' => true, 'default' => __('Content Text','cloudfw') ),
						'tag'              => array( 'e' => 'icon_box_element' ),
						'effect_icon'      => array( 'e' => 'icon_box_icon_custom_effect'),
						'effect_title'     => array( 'e' => 'icon_box_title_custom_effect'),
						'effect_text'      => array( 'e' => 'icon_box_text_custom_effect'),


						'margin_top'       => array( 'e' => 'margin_top' ),
						'margin_bottom'    => array( 'e' => 'margin_bottom' ),
					)
				),
				'data'		=>	array(


					array(
						'type'		=>	'mini-section',
						'title'		=>	__('Icon','cloudfw'),
						'data'		=>	array(

							array(
								'type'		=> 'module',
								'title'		=> __('Icon Position','cloudfw'),
								'data'		=> array(

									## Element
									array(
										'type'		=>	'select',
										'id'		=>	'icon_box_position',
										'value'		=>	$this->get_value('icon_box_position'),
										'ui'		=>	true,
										'main_class'=>  'input input_250',
										'source'	=>	array(
											'NULL'			=> __('Default - Left','cloudfw'),
											'top' 			=> __('Top','cloudfw'),
										)

									), // #### element: 0

								)

							),

							array(
								'type'		=> 'module',
								'title'		=> __('Icon','cloudfw'),
								'data'		=> array(

									## Element
									array(
										'type'		=>	'icon-selector',
										'id'		=>	'icon_box_pre_icon',
										'allow_custom' => true,
										'value'		=>	$this->get_value('icon_box_pre_icon'),
									), // #### element: 0

								)

							),

						)

					),


					array(
						'type'		=>	'mini-section',
						'title'		=>	__('Title','cloudfw'),
						'data'		=>	array(

							array(
								'type'		=> 'module',
								'title'		=> __('Title','cloudfw'),
								'data'		=> array(

									## Element
									array(
										'type'		=>	'text',
										'id'		=>	'icon_box_title',
										'value'		=>	$this->get_value('icon_box_title'),
										'_class'	=>  'bold',
										'editor'	=>  true,
									), // #### element: 0

								)

							),

							array(
								'type'		=> 'module',
								'title'		=> __('Title Size','cloudfw'),
								'data'		=> array(

									## Element
									array(
										'type'		=>	'select',
										'id'		=>	'icon_box_element',
										'value'		=>	$this->get_value('icon_box_element'),
										'ui'		=>	true,
										'width'		=>	150,
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
										'id'		=>	'icon_box_title_position',
										'value'		=>	$this->get_value('icon_box_title_position'),
										'ui'		=>	true,
										'main_class'=>  'input input_250',
										'source'	=>	array(
											'NULL'			=> __('Left','cloudfw'),
											'center' 		=> __('Center','cloudfw'),
											'right' 		=> __('Right','cloudfw'),
										)

									), // #### element: 0

								)

							),

							array(
								'type'		=> 'module',
								'title'		=> __('Title Color','cloudfw'),
								'data'		=> array(

									## Element
									array(
										'type'		=>	'color',
										'id'		=>	'icon_box_title_color',
										'value'		=>	$this->get_value('icon_box_title_color'),
										'style'		=>	'horizontal',

									), // #### element: 0

								)

							),

						)

					),


					array(
						'type'		=>	'mini-section',
						'title'		=>	__('Text','cloudfw'),
						'data'		=>	array(

							array(
								'type'		=> 'module',
								'title'		=> __('Content','cloudfw'),
								'data'		=> array(

									## Element
									array(
										'type'		=>	'textarea',
										'id'		=>	'icon_box_content',
										'value'		=>	$this->get_value('icon_box_content'),
										'_class'	=>  'textarea_400px_2line redactor',
										'editor'	=>  true,
										'width'		=>	'90%',
										'line'		=>	5,
									), // #### element: 0

								)

							),

							array(
								'type'		=> 'module',
								'title'		=> __('Content Align','cloudfw'),
								'data'		=> array(

									## Element
									array(
										'type'		=>	'select',
										'id'		=>	'icon_box_content_position',
										'value'		=>	$this->get_value('icon_box_content_position'),
										'ui'		=>	true,
										'main_class'=>  'input input_250',
										'source'	=>	array(
											'NULL'			=> __('Left','cloudfw'),
											'center' 		=> __('Center','cloudfw'),
											'right' 		=> __('Right','cloudfw'),
											'justify' 		=> __('Justify','cloudfw'),
										)

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
										'id'		=>	'icon_box_link',
										'value'		=>	$this->get_value('icon_box_link'),
									), // #### element: 0

								)

							),

							array(
								'type'		=> 'module',
								'title'		=> __('Show the link in Lightbox?','cloudfw'),
								'data'		=> array(

									## Element
									array(
										'type'		=>	'onoff',
										'id'		=>	'icon_box_lightbox',
										'value'		=>	$this->get_value('icon_box_lightbox', 'FALSE'),
									), // #### element: 0

								)

							),

						)

					),


					array(
						'type'		=>	'mini-section',
						'title'		=>	__('Custom Entrance Effects','cloudfw'),
						'data'		=>	array(

							array(
								'type'		=> 'module',
								'title'		=> __('For Icon','cloudfw'),
								'data'		=> array(

									## Element
									array(
										'type'		=>	'select',
										'id'		=>	'icon_box_icon_custom_effect',
										'value'		=>	$this->get_value('icon_box_icon_custom_effect'),
										'ui'		=>	true,
										'source'	=>	array(
											'type'		=>	'function',
											'function'	=>	'cloudfw_css_effect_list',
										),
										'width'		=>	400,
									),

								)

							),

							array(
								'type'		=> 'module',
								'title'		=> __('For Title','cloudfw'),
								'data'		=> array(

									## Element
									array(
										'type'		=>	'select',
										'id'		=>	'icon_box_title_custom_effect',
										'value'		=>	$this->get_value('icon_box_title_custom_effect'),
										'ui'		=>	true,
										'source'	=>	array(
											'type'		=>	'function',
											'function'	=>	'cloudfw_css_effect_list',
										),
										'width'		=>	400,
									),

								)

							),

							array(
								'type'		=> 'module',
								'title'		=> __('For Content','cloudfw'),
								'data'		=> array(

									## Element
									array(
										'type'		=>	'select',
										'id'		=>	'icon_box_text_custom_effect',
										'value'		=>	$this->get_value('icon_box_text_custom_effect'),
										'ui'		=>	true,
										'source'	=>	array(
											'type'		=>	'function',
											'function'	=>	'cloudfw_css_effect_list',
										),
										'width'		=>	400,
									),

								)

							),

						)

					),

					array(
						'type'		=>	'mini-section',
						'title'		=>	__('Margins','cloudfw'),
						'data'		=>	array(

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

	}

}