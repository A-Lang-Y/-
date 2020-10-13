<?php
/*
 * Plugin Name: Icon & Text
 * Plugin URI: http://cloudfw.net
 * Description: 
 * Version: 1.0
 * Author: Orkun Gürsel
 * Author URI: http://orkungursel.com
 * Shortcode: 
 * Attributes:
 */

cloudfw_register_shortcode( 'CloudFw_Shortcode_Icon_Text' );
if ( ! class_exists('CloudFw_Shortcode_Icon_Text') ) {
	class CloudFw_Shortcode_Icon_Text extends CloudFw_Shortcodes {

		function get_called_class(){ return get_class($this); }



		/** Add the shortcode to the composer */
		function composer(){
			return array(
				'composer'		=> true,
				'droppable'		=> false,
				'ajax'			=> true,
				'icon'			=> 'icon-text',
				'group'			=> 'composer_widgets',
				'line'			=> 300,
				'options'		=> array(
					'title'				=> __('Icon & Text','cloudfw'),
					'column'			=> '1/1',
					'sync_title'		=> 'icon_text_content',
					'allow_columns'		=> true,
				)
			);
		}

		function shortcode( $atts, $content =  NULL, $case = NULL ) {
			extract(shortcode_atts(array(
				"icon"         => NULL,
				"block"        => 'FALSE',
				"margin_top"   => NULL,
				"margin_left"  => NULL,
				"margin_right" => NULL,
				"style"        => '',
			), _check_onoff_false($atts)));

			$content = do_shortcode($content);
			$icon = cloudfw_make_icon($icon);

			$classes = array();
			$classes[] = 'icontext';
			$classes[] = 'ui--animation';

			if ( !$block ) {
				$classes[] = 'inline';
			} else {
				$classes[] = 'block';
				$classes[] = 'clearfix';
			}

			if (!empty($icon)) 
				$_e_icon = "<span class=\"icontext-icon\" style=\"".
								cloudfw_style( 'margin-top', $margin_top ) .
								cloudfw_style( 'margin-left', $margin_left ) .
								cloudfw_style( 'margin-right', $margin_right ) .
								$style .
							"\">{$icon}</span>";
			
			$_e_content = "<div class=\"icontext-content\">{$content}</div>";

			$output  = "<div ". cloudfw_make_class( $classes ) .">";
			$output .= $_e_icon;
			$output .= $_e_content;

			if ( $block )
				$output .= "<div class=\"cf\"></div>";

			$output .= "</div>";
			return $output;
		}

		/** Admin Scheme */
		function scheme() {
			return array(
				'title'		=>	__('Icon & Text','cloudfw'),
				'script'	=> array(
					'shortcode'		=> 'icon_text',
					'tag_close'  	=> true,
					'attributes' 	=> array( 
						'icon'         => array( 'e' => 'icon_text_icon' ),
						'block'        => array( 'e' => 'icon_text_block', 'onoff' => true ),
						'style'        => array( 'e' => 'icon_text_style' ),
						'margin_top'   => array( 'e' => 'icon_margin_top' ),
						'margin_left'  => array( 'e' => 'icon_margin_left' ),
						'margin_right' => array( 'e' => 'icon_margin_right' ),
						'content'      => array( 'e' => 'icon_text_content'),
					),
				),
				'data'		=>	array(

					array(
						'type'		=> 'module',
						'title'		=> __('Icon','cloudfw'),
						'data'		=> array(

							## Element
							array(
								'type'			=>	'icon-selector',
								'id'			=>	'icon_text_icon',
								'value'			=>	$this->get_value('icon_text_icon'),
								'allow_custom'  => true,
							), // #### element: 0

						)

					),

					array(
						'type'		=> 'module',
						'title'		=> __('Text','cloudfw'),
						'data'		=> array(
							## Element
							array(
								'type'		=>	'textarea',
								'id'		=>	'icon_text_content',
								'value'		=>	$this->get_value('icon_text_content'),
								'_class'	=>  'textarea_95per_3line textarea_block',
							), // #### element: 0

						)

					),

					array(
						'type'		=> 'module',
						'title'		=> __('Block Style?','cloudfw'),
						'data'		=> array(

							## Element
							array(
								'type'		=>	'onoff',
								'id'		=>	'icon_text_block',
								'value'		=>	$this->get_value('icon_text_block', 'FALSE'),
							), // #### element: 0

						)

					),

					array(
						'type'		=> 'module',
						'title'		=> __('Icon Margin-Top','cloudfw'),
						'data'		=> array(

							## Element
							array(
								'type'		=>	'slider',
								'id'		=>	'icon_margin_top',
								'value'		=>	$this->get_value('icon_margin_top', 0),
								'min'		=>	-50,
								'max'		=>	50,
								'step'		=>	1,
								'steps'		=>	array(
									0 			=>	__('no margin','cloudfw'),
								),
								'width'		=>	250,
								'min_range'	=>	false
							), // #### element: 0

						)

					),

					array(
						'type'		=> 'module',
						'title'		=> __('Icon Margin-Left','cloudfw'),
						'data'		=> array(

							## Element
							array(
								'type'		=>	'slider',
								'id'		=>	'icon_margin_left',
								'value'		=>	$this->get_value('icon_margin_left', 5),
								'min'		=>	-50,
								'max'		=>	50,
								'step'		=>	1,
								'steps'		=>	array(
									0 			=>	__('no margin','cloudfw'),
									5 			=>	__('default','cloudfw'),
								),
								'width'		=>	250,
								'min_range'	=>	false
							), // #### element: 0

						)

					),

					array(
						'type'		=> 'module',
						'title'		=> __('Icon Margin-Right','cloudfw'),
						'data'		=> array(

							## Element
							array(
								'type'		=>	'slider',
								'id'		=>	'icon_margin_right',
								'value'		=>	$this->get_value('icon_margin_right', 5),
								'min'		=>	-50,
								'max'		=>	50,
								'step'		=>	1,
								'steps'		=>	array(
									0 			=>	__('no margin','cloudfw'),
									5 			=>	__('default','cloudfw'),
								),
								'width'		=>	250,
								'min_range'	=>	false
							), // #### element: 0

						)

					),

					array(
						'type'		=> 'module',
						'title'		=> __('Custom CSS Style','cloudfw'),
						'data'		=> array(
							## Element
							array(
								'type'		=>	'text',
								'id'		=>	'icon_text_style',
								'value'		=>	$this->get_value('icon_text_style'),
								'width'		=>	'90%',
							), // #### element: 0

						)

					),
					
				)

			);

		}

	}

}