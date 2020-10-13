<?php
/*
 * Plugin Name: Widgetized Area
 * Plugin URI: http://cloudfw.net
 * Description: 
 * Version: 1.0
 * Author: Orkun Gürsel
 * Author URI: http://orkungursel.com
 * Shortcode:  [widget]
 * Attributes: (string) sidebar
 */

cloudfw_register_shortcode( 'CloudFw_Shortcode_Widget', 'widget', 'advanced', 55 );
if ( ! class_exists('CloudFw_Shortcode_Widget') ) {
	class CloudFw_Shortcode_Widget extends CloudFw_Shortcodes {

		function get_called_class(){ return get_class($this); }


		/** Add the shortcode to the composer */
		function composer(){
			return array(
				'composer'		=> true,
				'ajax'			=> true,
				'icon'			=> 'sidebar',
				'group'			=> 'composer_widgets',
				'line'			=> 410,
				'options'		=> array(
					'title'				=> __('Widgetized Area','cloudfw'),
					'column'			=> '1/1',
					'allow_columns'		=> true,
				)
			);
		}

		/** Run */
		function shortcode( $atts = array(), $content =  NULL ) {
			extract(shortcode_atts(array(
				"sidebar" 	=> NULL,
			), $atts));

			ob_start();	dynamic_sidebar( $sidebar ); 
			$output = ob_get_contents(); ob_end_clean();

			return $output;
		}

		/** Scheme */
		function scheme() {
			return array(
				'title'		=>	__('Widgetized Areas','cloudfw'),
				'ajax'		=>	true,
				'script'	=> array(
					'shortcode'  => 'widget',
					'tag_close'  => false,
					'attributes' =>	array( 
						'sidebar' 	=> array( 'e' => 'sidebar_id', 'required' => __('Please select a sidebar','cloudfw'), 'check-default' => '0' ),
					)
				),
				'data'		=>	array(

					5 => array(
						'type'		=> 'module',
						'title'		=> __('Sidebar','cloudfw'),
						'data'		=> array(

							## Element
							array(
								'type'		=>	'select',
								'id'		=>	'sidebar_id',
								'value'		=>	$this->get_value('sidebar_id'),
								'main_class'=>  'input input_250',
								'ui'		=>	true,
								'source'	=>	array(
									'type'		=>	'function',
									'function'	=>	'cloudfw_admin_loop_custom_sidebars'
								)							
							), // #### element: 0

						)

					),  // #### element: 5
					
				)

			);

		}


	}

}