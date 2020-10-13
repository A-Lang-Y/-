<?php
/*
 * Plugin Name: Headings
 * Plugin URI: http://cloudfw.net
 * Description: 
 * Version: 1.0
 * Author: Orkun Gürsel
 * Author URI: http://orkungursel.com
 * Shortcode: 
 * Attributes:
 */

cloudfw_register_shortcode( 'CloudFw_Shortcode_Headings', NULL, 'style', 5 );
if ( ! class_exists('CloudFw_Shortcode_Headings') ) {
	class CloudFw_Shortcode_Headings extends CloudFw_Shortcodes {

		function get_called_class(){ return get_class($this); }


		/** Add the shortcode to the composer */
		function composer(){
			return array(
				'composer'		=> true,
				'ajax'			=> true,
				'icon'			=> 'headings',
				'group'			=> 'composer_widgets',
				'line'			=> 110,
				'options'		=> array(
					'title'				=> __('Heading','cloudfw'),
					'sync_title'		=> 'heading_title',
					'column'			=> '1/1',
					'allow_columns'		=> false,
				)
			);
		}

		/** Register */
		function register() {
			return array(
				'h1',
				'h2',
				'h3',
				'h4',
				'h5',
				'h6',
				'custom_heading',
			);

		}

		/** Run */
		function shortcode( $atts = array(), $content =  NULL, $case = NULL ) {

			switch ($case) {
				case 'h1':
				case 'h2':
				case 'h3':
				case 'h4':
				case 'h5':
				case 'h6':

					extract(shortcode_atts(array(
						"id"             	=> '',
						"class"            	=> '',
						"margin_top"        => '',
						"margin_bottom"     => '',
						"color"            	=> '',
						"align"             => '',
						"link"              => '',
					), _check_onoff_false($atts)));

					if ( !empty($link) ) {
						$link = cloudfw_get_page_link($link);
						$content = "<a href=\"{$link}\">{$content}</a>";
					}

					$out = do_shortcode("<{$case}"
						. _if( !empty($id), ' id="'. $id .'"' )
						.' class="ui--animation '. $class .'"'
						." style=\"".
						cloudfw_style( 'text-align', $align ) .
						cloudfw_style( 'color', $color, true) .
						cloudfw_style( 'margin-top', $margin_top ) .
						cloudfw_style( 'margin-bottom', $margin_bottom ) .
						"\">{$content}</{$case}>");
				break;
				case 'custom_heading':

					extract(shortcode_atts(array(
						"id"             	=> '',
						"class"            	=> '',
						"margin_top"        => '',
						"margin_bottom"     => '',
						"color"            	=> '',
						"align"             => '',
						"size"              => NULL,
						"line_height"       => NULL,
						"link"              => '',
					), _check_onoff_false($atts)));

					if ( !empty($link) ) {
						$link = cloudfw_get_page_link($link);
						$content = "<a href=\"{$link}\">{$content}</a>";
					}

					$out = "<h1"
						. _if( !empty($id), ' id="'. $id .'"' )
						.' class="ui--animation '. $class .'"'
						." style=\"".
						cloudfw_style( 'font-size', $size ) .
						cloudfw_style( 'line-height', $line_height ) .
						cloudfw_style( 'text-align', $align ) .
						cloudfw_style( 'color', $color, true ) .
						cloudfw_style( 'margin-top', $margin_top ) .
						cloudfw_style( 'margin-bottom', $margin_bottom ) .
					"\" ". 

						cloudfw_responsive_options(array( 
	                       /* 'css' => array(
	                            'font-size' => array( 
	                                'phone'         => (int) 18,
	                                'tablet'        => (int) 30,
	                                'widescreen'    => (int) $size,
	                            ),
	                            'line-height' => array( 
	                                'phone'         => '18px',
	                                'tablet'        => '24px',
	                                'widescreen'    => $line_height . 'px',
	                            ),
	                        )*/
                		), FALSE) 

					.">". do_shortcode($content) ."</h1>";


 				;

				break;

			}

			return $out;

		}

		/** Admin Scheme */
		function scheme() {
			return array(
				'title'		=>	__('Headings','cloudfw'),
				'script'	=> array(
					'shortcode:sync'=> 'heading_type',
					'tag_close'  	=> true,
					'attributes' 	=> array( 
						'id' 			=> array( 'e' => 'heading_id' ),
						'class' 		=> array( 'e' => 'heading_class' ),
						'color' 		=> array( 'e' => 'heading_color' ),
						'align' 		=> array( 'e' => 'heading_align' ),
						'link' 			=> array( 'e' => 'heading_link' ),
						'size' 			=> array( 'e' => 'heading_size' ),
						'margin_top' 	=> array( 'e' => 'heading_margin_top' ),
						'margin_bottom'	=> array( 'e' => 'heading_margin_bottom' ),
						'line_height' 	=> array( 'e' => 'heading_line_height' ),
						'content' 		=> array( 'e' => 'heading_title', 'force' => true, 'default' => 'Title Text' ),
					),
					'if' 	=>	array(
						array( 
							'type' 	  => 'toggle',
							'e' 	  => 'heading_type',
							'related' => 'headingElements',
							'targets' => array( 
								array('custom_heading', '#heading_size') 
							)
						)
					)
				),
				'data'		=>  $this->load_scheme( __FILE__ )
				
			);

		}

	}

}