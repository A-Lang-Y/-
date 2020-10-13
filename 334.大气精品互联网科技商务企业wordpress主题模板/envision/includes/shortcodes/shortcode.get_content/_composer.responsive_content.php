<?php
/*
 * Plugin Name: Responsive Content
 * Plugin URI: http://cloudfw.net
 * Description: 
 * Version: 1.0
 * Author: Orkun Gürsel
 * Author URI: http://orkungursel.com
 */
cloudfw_register_shortcode( 'CloudFw_Composer_Responsive_Content', 'responsive', 'columns', 25  );
if ( ! class_exists('CloudFw_Composer_Responsive_Content') ) {
	class CloudFw_Composer_Responsive_Content extends CloudFw_Shortcodes {

		function get_called_class(){ return get_class($this); }


		/** Add the shortcode to the composer */
		function composer(){
			return array(
				'composer'		=> true,
				'droppable'		=> true,
				'ajax'			=> true,
				'icon'			=> 'html-responsive',
				'group'			=> 'composer_layouts',
				'line'			=> 40,
				'options'		=> array(
					'title'				=> __('Responsive Content','cloudfw'),
					'column'			=> '1/1',
					'allow_columns'		=> true,
					'allow_edit'		=> true,
				)
			);
		}

		/** Run */
		function shortcode( $atts = array(), $content =  NULL, $case = NULL ) {
			extract(shortcode_atts(array(
				'device'      => '',
			), _check_onoff_false($atts)));

			$class = cloudfw_visible( $device ); 

			$content = cloudfw_inline_format( $content ); 
			return "<div class=\"{$class}\">{$content}</div>";
		}

		/** Scheme */
		function scheme() {
			return array(
				'title'		=>	__('Responsive Content','cloudfw'),
				'script'	=> array(
					'shortcode' 	=> 'responsive',
					'tag_close'  	=> true,
					'attributes' 	=> array( 
						'device' 	=> array( 'e' => 'the_device' ),
						'content' 	=> array( 'e' => 'responsive_content' ),
					)
				),
				'data'		=>  $this->load_scheme( __FILE__ )
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