<?php
/*
 * Plugin Name: Blank Spaces
 * Plugin URI: http://cloudfw.net
 * Description: 
 * Version: 1.0
 * Author: Orkun Gürsel
 * Author URI: http://orkungursel.com
 * Shortcode:  
 * Attributes:
 */

cloudfw_register_shortcode( 'CloudFw_Shortcode_Spaces', NULL, 'style', 1 );
	if ( ! class_exists('CloudFw_Shortcode_Spaces') ) {
	class CloudFw_Shortcode_Spaces extends CloudFw_Shortcodes {

		function get_called_class(){ return get_class($this); }


		/** Add the shortcode to the composer */
		function composer(){
			return array(
				'composer'		=> true,
				'icon'			=> 'gap',
				'group'			=> 'composer_layouts',
				'line'			=> 20,
				'options'		=> array(
					'title'				=> __('Blank Space','cloudfw'),
					'sync_title'		=> 'space_type',
					'column'			=> '1/1',
					'allow_columns'		=> false,
					'allow_edit'		=> true,
				)
			);
		}

		/** Register */
		function register() {
			return array(
				'space',
			);
		}

		/** Run */
		function shortcode( $atts = array(), $content =  NULL, $case = NULL ) {
			extract(shortcode_atts(array(
				'height' => '',
				'height_tablets' => '',
				'height_phones' => '',
			), $atts));
			
			switch ($case) {
				case 'down':			
				case 'space':			

					$classes = array();
					$classes[] = 'ui--space'; 
					$classes[] = 'clearfix'; 

					$out = "<div ". 
						cloudfw_make_class($classes, true) .
						cloudfw_make_style_attribute( array(
							'height' => $height,
						), FALSE, TRUE ).
						cloudfw_responsive_options(array( 
	                        'css' => array(
	                            'height' => array( 
	                                'phone'         => cloudfw_format_css_int($height_phones),
	                                'tablet'        => cloudfw_format_css_int($height_tablets),
	                                'widescreen'    => cloudfw_format_css_int($height),
	                            ),
	                        )
                		), FALSE)
					."></div>";
				
				break;
			}
			
			return $out;

		}

		/** Admin Scheme */
		function scheme() {
			return array(
				'title'		=>	__('Blank Space','cloudfw'),
				'script'	=> array(
					'shortcode:sync'=> 'space_type',
					'tag_close'  	=> false,
					'attributes' 	=> array( 
						'height' => array( 'e' => 'space_height' ),
						'height_tablets' => array( 'e' => 'space_height_tablets' ),
						'height_phones' => array( 'e' => 'space_height_phones' ),
					),
				),
				'data'		=>	array(

					array(
						'type'		=> 'module',
						'title'		=> __('Type','cloudfw'),
						'data'		=> array(

							## Element
							array(
								'type'		=>	'select',
								'id'		=>	'space_type',
								'value'		=>	$this->get_value('space_type', 'divider_dotted'),
								'ui'		=>	true,
								'main_class'=>  'input input_250',
								'source'	=>	array(
									'space'		=> __('Blank Space','cloudfw'),
								)

							),

						)

					),

					array(
						'type'		=> 'module',
						'title'		=> __('Custom Space Height (Widescreen)','cloudfw'),
						'data'		=> array(

							## Element
							array(
								'type'		=>	'text',
								'id'		=>	'space_height',
								'value'		=>	$this->get_value('space_height'),
								'width'		=>	50,
								'unit'		=>	__('px','cloudfw')
							), // #### element: 0

						)

					),

					array(
						'type'		=> 'module',
						'title'		=> __('Custom Space Height (For Tablets)','cloudfw'),
						'data'		=> array(

							## Element
							array(
								'type'		=>	'text',
								'id'		=>	'space_height_tablets',
								'value'		=>	$this->get_value('space_height_tablets'),
								'width'		=>	50,
								'unit'		=>	__('px','cloudfw')
							), // #### element: 0

						)

					),

					array(
						'type'		=> 'module',
						'title'		=> __('Custom Space Height (For Phones)','cloudfw'),
						'data'		=> array(

							## Element
							array(
								'type'		=>	'text',
								'id'		=>	'space_height_phones',
								'value'		=>	$this->get_value('space_height_phones'),
								'width'		=>	50,
								'unit'		=>	__('px','cloudfw')
							), // #### element: 0

						)

					),
					
				)

			);

		}

	}

}