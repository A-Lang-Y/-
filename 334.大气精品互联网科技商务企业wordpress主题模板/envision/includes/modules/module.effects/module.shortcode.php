<?php
/*
 * Plugin Name: CSS Effect 
 * Plugin URI: http://cloudfw.net
 * Description: 
 * Version: 1.0
 * Author: Orkun Gürsel
 * Author URI: http://orkungursel.com
 * Shortcode:  
 * Attributes:
 */
cloudfw_register_shortcode( 'CloudFw_Shortcode_Effects', 'fx', 'style', 50 );
	if ( ! class_exists('CloudFw_Shortcode_Effects') ) {
	class CloudFw_Shortcode_Effects extends CloudFw_Shortcodes {

		function get_called_class(){ return get_class($this); }


		/** Add the shortcode to the composer */
		function composer(){
			return array(
				'composer'		=> true,
				'ajax'			=> true,
				'droppable'		=> true,
				'icon'			=> 'fx',
				'group'			=> 'composer_widgets',
				'line'			=> 420,
				'options'		=> array(
					'title'				=> __('CSS Entrance Effect','cloudfw'),
					'sync_title'		=> 'fx_effect',
					'column'			=> '1/1',
					'allow_columns'		=> true,
					'allow_edit'		=> true,
					/*'allow_only'		=> apply_filters( 
						'cloudfw_transition_fx_allowed_widgets',
						array(
							'CloudFw_Shortcode_Image',
							'CloudFw_Shortcode_Buttons',
							'CloudFw_Shortcode_Gallery',
							'CloudFw_Composer_HTML',
							'CloudFw_Shortcode_Icon_Boxes',
							'CloudFw_Shortcode_Icon_Text',
							'CloudFw_Shortcode_UI_Box',
							'CloudFw_Composer_List_Group',
							'CloudFw_Shortcode_Testimonial',
							'CloudFw_Shortcode_Twitter',
							'CloudFw_Shortcode_Titles',
							'CloudFw_Shortcode_Headings',
							'CloudFw_Shortcode_Toggle',
							'CloudFw_Shortcode_Portfolio',
							'CloudFw_Shortcode_Socialbar',
							'CloudFw_Composer_Masonry',
							'CloudFw_Composer_Carousel',
							'CloudFw_Shortcode_Spaces',
							'CloudFw_Composer_Columns',
						)
					),*/
				)
			);
		}

		/** Run */
		function shortcode( $atts = array(), $content =  NULL ) {
			return cloudfw_make_css_animation( $atts, $content );
		}

		/** Admin Scheme */
		function scheme() {
			return array(
				'title'		=>	__('CSS Entrance Effect','cloudfw'),
				'script'	=> array(
					'shortcode'		=> 'fx',
					'tag_close'  	=> false,
					'attributes' 	=> array( 
						'effect'      => array( 'e' => 'fx_effect' ),
						'delay'       => array( 'e' => 'fx_delay' ),
						'start_delay' => array( 'e' => 'fx_start_delay' ),
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
								'id'		=>	'fx_effect',
								'value'		=>	$this->get_value('fx_effect'),
								'ui'		=>	true,
								'source'	=>	array(
									'type'		=>	'function',
									'function'	=>	'cloudfw_css_effect_list',
									'vars'		=>	array( true ),
								),
								'width'		=>	400,
								'desc'		=>	__('This effect may be overridden for individual widgets or elements.','cloudfw'),
							),

						)

					),

					array(
						'type'		=> 'module',
						'title'		=> __('Delay Time','cloudfw'),
						'data'		=> array(

							## Element
							array(
								'type'		=>	'slider',
								'id'		=>	'fx_delay',
								'value'		=>	$this->get_value('fx_delay', 150),
								'min'		=>	0,
								'max'		=>	10000,
								'step'		=>	50,
								'unit'		=>	__('ms','cloudfw'),
								'width'		=>	400

							),

						)

					),

					array(
						'type'		=> 'module',
						'title'		=> __('Starting Delay Time','cloudfw'),
						'data'		=> array(

							## Element
							array(
								'type'		=>	'slider',
								'id'		=>	'fx_start_delay',
								'value'		=>	$this->get_value('fx_start_delay', 0),
								'min'		=>	0,
								'max'		=>	10000,
								'step'		=>	50,
								'unit'		=>	__('ms','cloudfw'),
								'width'		=>	400

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
					cloudfw_composer_default_dropped_area()
				)
			);
		}

	}

}