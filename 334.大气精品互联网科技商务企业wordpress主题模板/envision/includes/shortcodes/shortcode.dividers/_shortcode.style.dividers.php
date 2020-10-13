<?php
/*
 * Plugin Name: Dividers
 * Plugin URI: http://cloudfw.net
 * Description: 
 * Version: 1.0
 * Author: Orkun Gürsel
 * Author URI: http://orkungursel.com
 * Shortcode:  
 * Attributes:
 */
cloudfw_register_shortcode( 'CloudFw_Shortcode_Dividers', NULL, 'style', 1 );
	if ( ! class_exists('CloudFw_Shortcode_Dividers') ) {
	class CloudFw_Shortcode_Dividers extends CloudFw_Shortcodes {

		function get_called_class(){ return get_class($this); }


		/** Add the shortcode to the composer */
		function composer(){
			return array(
				'composer'		=> true,
				'ajax'			=> false,
				'icon'			=> 'divider',
				'group'			=> 'composer_layouts',
				'line'			=> 30,
				'options'		=> array(
					'title'				=> __('Divider','cloudfw'),
					'sync_title'		=> 'divider_type',
					'column'			=> '1/1',
					'allow_columns'		=> false,
					'allow_edit'		=> true,
				)
			);
		}

		/** Register */
		function register() {
			return array(
				'divider',
				'dotted_divider',
				'dashed_divider',
				'mini_divider',
			);
		}

		/** Run */
		function shortcode( $atts = array(), $content =  NULL, $case = NULL ) {
			extract(shortcode_atts(array(
				'color'         => '',
				'device'        => '',
				'fullwidth'     => 'FALSE',
				'margin_top'    => '',
				'margin_bottom' => '',
				'width' 		=> '',
			), _check_onoff_false($atts)));

			$out = ''; 
			$classes = array();
			$classes[] = 'ui--divider'; 
			$classes[] = 'ui--animation'; 
			$classes[] = 'clearfix'; 
			$classes[] = cloudfw_visible( $device ); 


			switch ($case) {
				case 'divider':
					
					$classes[] = 'ui--divider-solid-line'; 
					if ( $fullwidth ) {
						$classes[] = 'fullwidth-content'; 
					}

					$out = "<div ". 
						cloudfw_make_class($classes, true) .
						cloudfw_make_style_attribute( array(
							'margin-top'        => $margin_top,
							'margin-bottom'     => $margin_bottom,
							'width'     		=> $width,
							'!background-color' => $color,
						), FALSE, TRUE )
					."></div>";
				
					break;

				case 'mini_divider':
					
					$classes[] = 'ui--divider-mini'; 
					$out = "<div ". 
						cloudfw_make_class($classes, true) .
						cloudfw_make_style_attribute( array(
							'margin-top'        => $margin_top,
							'margin-bottom'     => $margin_bottom,
							'width'     		=> $width,
							'!background-color' => $color,
						), FALSE, TRUE )
					."></div>";
				
					break;
				case 'dotted_divider':			
				case 'dashed_divider':			
					
					if ( $case == 'dotted_divider' ) {
						$classes[] = 'ui--divider-dotted-line'; 
					} else {
						$classes[] = 'ui--divider-dashed-line'; 
					}

					if ( $fullwidth ) {
						$classes[] = 'fullwidth-content'; 
					}

					$out = "<div ". 
						cloudfw_make_class($classes, true) .
						cloudfw_make_style_attribute( array(
							'margin-top'    => $margin_top,
							'margin-bottom' => $margin_bottom,
							'width' 		=> $width,
							'!border-color' => $color,
						), FALSE, TRUE )
					."></div>";
				
					break;
				case 'fade_divider':			
				case 'fade_dotted_divider':			
					
					if ( $case == 'fade_divider' ) {
						$classes[] = 'ui--divider-fade-line';
					}
					elseif ( $case == 'fade_dotted_divider' ) {
						$classes[] = 'ui--divider-fade-dotted';
					}

					$out = "<div ". 
						cloudfw_make_class($classes, true) .
						cloudfw_make_style_attribute( array(
							'margin-top'    => $margin_top,
							'margin-bottom' => $margin_bottom,
						), FALSE, TRUE )
					.">
						<div class=\"ui--divider-inner-wrap\">
							<div class=\"ui--divider-part ui--divider-part-left\"></div>
							<div class=\"ui--divider-part ui--divider-part-right\"></div>
						</div>
					</div>";
				
					break;
			}
			
			return $out;

		}

		/** Admin Scheme */
		function scheme() {
			return array(
				'title'		=>	__('Divider','cloudfw'),
				'script'	=> array(
					'shortcode:sync'=> 'divider_type',
					'tag_close'  	=> false,
					'attributes' 	=> array( 
						'color'         => array( 'e' => 'divider_color' ),
						'fullwidth'     => array( 'e' => 'divider_fullwidth' ),
						'device'        => array( 'e' => 'divider_device' ),
						'margin_top'    => array( 'e' => 'divider_margin_top' ),
						'margin_bottom' => array( 'e' => 'divider_margin_bottom' ),
					),
					'if' 	=>	array(
						array( 
							'type' 	  => 'toggle',
							'e' 	  => 'divider_type',
							'related' => 'dividerColorOptions',
							'targets' => array( 
								array('divider', '#divider_color'),
								array('mini_divider', '#divider_color'),
								array('dotted_divider', '#divider_color'),
								array('dashed_divider', '#divider_color'),
							)
						),
						array( 
							'type' 	  => 'toggle',
							'e' 	  => 'divider_type',
							'related' => 'dividerFullwidthOption',
							'targets' => array( 
								array('divider', '#divider_fullwidth'),
								array('dotted_divider', '#divider_fullwidth'),
								array('dashed_divider', '#divider_fullwidth'),
							)
						)
					)
				),
				'data'		=>	array(

					array(
						'type'		=> 'module',
						'title'		=> __('Type','cloudfw'),
						'data'		=> array(

							## Element
							array(
								'type'		=>	'select',
								'id'		=>	'divider_type',
								'value'		=>	$this->get_value('divider_type', 'divider'),
								'ui'		=>	true,
								'main_class'=>  'input input_250',
								'source'	=>	array(
									'divider'             => __('Divider','cloudfw'),
									'mini_divider'        => __('Mini Divider','cloudfw'),
									'dotted_divider'      => __('Dotted Divider','cloudfw'),
									'dashed_divider'      => __('Dashed Divider','cloudfw'),
									'fade_divider'        => __('Fade Divider','cloudfw'),
									'fade_dotted_divider' => __('Fade Dotted Divider','cloudfw'),
								)

							),

						)

					),

					array(
						'type'		=> 'module',
						'related'	=> 'dividerColorOptions',
						'title'		=> __('Custom Color','cloudfw'),
						'data'		=> array(

							## Element
							array(
								'type'		=>	'color',
								'style'		=>	'horizontal',
								'id'		=>	'divider_color',
								'value'		=>	$this->get_value('divider_color'),

							),

						)

					),

					array(
						'type'		=> 'module',
						'related'	=> 'dividerFullwidthOption',
						'title'		=> __('Fullpage Width?','cloudfw'),
						'data'		=> array(

							## Element
							array(
								'type'		=>	'onoff',
								'id'		=>	'divider_fullwidth',
								'value'		=>	$this->get_value('divider_fullwidth', 'FALSE'),

							),

						)

					),


					array(
						'type'		=> 'module',
						'title'		=> __('Visibility','cloudfw'),
						'data'		=> array(

							## Element
							array(
								'type'		=>	'select',
								'id'		=>	'divider_device',
								'value'		=>	$this->get_value('divider_device'),
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
						'title'		=> array(__('Margin Top','cloudfw'), __('Margin Bottom','cloudfw')),
						'layout'	=> 'split',
						'data'		=> array(

							## Element
							array(
								'type'		=>	'text',
								'id'		=>	'divider_margin_top',
								'value'		=>	$this->get_value('divider_margin_top'),
								'width'		=>	70
							), // #### element: 0

							## Element
							array(
								'type'		=>	'text',
								'id'		=>	'divider_margin_bottom',
								'value'		=>	$this->get_value('divider_margin_bottom'),
								'width'		=>	70
							), // #### element: 0

						)

					),
					
				)

			);

		}

	}

}