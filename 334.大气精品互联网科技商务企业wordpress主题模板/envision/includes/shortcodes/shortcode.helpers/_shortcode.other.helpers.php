<?php
/*
 * Plugin Name: Helpers
 * Plugin URI: http://cloudfw.net
 * Description: 
 * Version: 1.0
 * Author: Orkun Gürsel
 * Author URI: http://orkungursel.com
 * Shortcode: 
 * Attributes:
 */

cloudfw_register_shortcode( 'CloudFw_Shortcode_Helpers' );
if ( ! class_exists('CloudFw_Shortcode_Helpers') ) {
	class CloudFw_Shortcode_Helpers extends CloudFw_Shortcodes {

		function get_called_class(){ return get_class($this); }


		/** Register */
		function register() {
			return array(
				'text_left',
				'text_right',
				'text_center',
				'center',
				'left',
				'right',

				'no_shortcode',
				'animate_this',
				'no_margin',
				'template_url',
				'site_url',
				'strong',
				'year',
			);

		}

		/** Run */
		function shortcode( $atts = array(), $content =  NULL, $case = NULL ) {

			switch ($case) {

			/** No Shortcode */
				case 'no_shortcode':
					return "$content";

				break;
				case 'animate_this':
					$effect = isset($atts['effect'] ) ? $atts['effect']  : NULL;

					return "<span class=\"ui--animation ui--block\"".
						cloudfw_make_attribute(array(
							'data-fx' => $effect,
						), FALSE)
					.">". do_shortcode( $content ) ."</span>";

				break;

			/** Text Aligns */
				case 'center':
				case 'text_left':
				case 'text_right':
				case 'text_center':
					$suffix = str_replace('text_', '', $case); 
					return do_shortcode("<div class=\"text-{$suffix}\">{$content}</div>");

				break;
			/** No Margin */
				case 'left':
				case 'right':
					return do_shortcode("<div class=\"pull-{$case}\">{$content}</div>");

				break;
			/** No Margin */
				case 'no_margin':
					return do_shortcode("<div class=\"full-width\">{$content}</div>");

				break;
			/** Strong */
				case 'strong':
					return "<strong>{$content}</strong>";

				break;

			/** Template URL */
				case 'template_url':	
					return TMP_URL;

				break;	

			/** Site URL */
				case 'site_url':	
					$path = $atts['path']; 
					return __home_url( $path );

				break;
			/** Template URL */
				case 'year':	
					return date( "Y" );

			}

		}

	}

}