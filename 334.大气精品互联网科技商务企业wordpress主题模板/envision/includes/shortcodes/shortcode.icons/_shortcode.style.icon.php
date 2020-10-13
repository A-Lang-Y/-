<?php
/*
 * Plugin Name: Icon
 * Plugin URI: http://cloudfw.net
 * Description: 
 * Version: 1.0
 * Author: Orkun Gürsel
 * Author URI: http://orkungursel.com
 * Shortcode:  
 * Attributes:
 */
cloudfw_register_shortcode( 'CloudFw_Shortcode_Icon', 'icon', 'style', 24 );
if ( ! class_exists('CloudFw_Shortcode_Icon') ) {
	class CloudFw_Shortcode_Icon extends CloudFw_Shortcodes {

		function get_called_class(){ return get_class($this); }


		/** Run */
		function shortcode( $atts = array(), $content =  NULL, $case = NULL ) {
			extract(shortcode_atts(array(
				"icon" 		=> NULL,
			), $atts));

			$icon = cloudfw_make_icon($icon, NULL, cloudfw_style( 'margin-right', '5px' ));

			if (!empty($icon)) {
				$output = $icon;
				return "{$output}";
			}
			return false;
		}

		/** Scheme */
		function scheme() {
			return array(
				'title'		=>	__('Icon','cloudfw'),
				'script'	=> array(
					'shortcode'  => 'icon',
					'tag_close'  => false,
					'attributes' =>	array( 
						'icon' 	=> array( 'e' => 'icon_source', 'required' => __('Please select an icon','cloudfw') ),

					)
				),
				'data'		=>  array(

					array(
						'type'		=> 'module',
						'title'		=> __('Icon','cloudfw'),
						'data'		=> array(

							## Element
							array(
								'type'			=>	'icon-selector',
								'id'			=>	'icon_source',
								'value'			=>	$this->get_value('icon_source'),
							), // #### element: 0

						)

					),

				)

			);

		}

	}

}