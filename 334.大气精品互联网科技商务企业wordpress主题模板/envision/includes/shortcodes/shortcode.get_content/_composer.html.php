<?php
/*
 * Plugin Name: HTML Code
 * Plugin URI: http://cloudfw.net
 * Description: 
 * Version: 1.0
 * Author: Orkun Gürsel
 * Author URI: http://orkungursel.com
 */
cloudfw_register_shortcode( 'CloudFw_Composer_HTML' );
if ( ! class_exists('CloudFw_Composer_HTML') ) {
	class CloudFw_Composer_HTML extends CloudFw_Shortcodes {
		
		function get_called_class(){ return get_class($this); }

		/** Add the shortcode to the composer */
		function composer(){
			return array(
				'composer'		=> true,
				'icon'			=> 'html',
				'group'			=> 'composer_widgets',
				'line'			=> 100,
				'options'		=> array(
					'title'				=> __('HTML / Text Block','cloudfw'),
					'column'			=> '1/1',
					'allow_columns'		=> true,
					'allow_edit'		=> true,
				)
			);
		}

		/** Run */
		function shortcode( $atts = array(), $content =  NULL, $case = NULL ) {
			$atts = shortcode_atts(array(
				"format" 	=> 'FALSE',
				"animate" 	=> true,
			), _check_onoff_false( $atts ));

			extract( $atts );

			$classes = array(); 
			if ( _check_onoff( $format ) ) {
				$classes[] = 'auto-format';
				$content = cloudfw_inline_format( $content ); 
			}

			if ( _check_onoff( $animate ) ) {
				$classes[] = 'ui--animation';
			}

			return '<div'.
				cloudfw_make_class( $classes, TRUE ) .
			'>'. $content .'</div>';
		}

		/** Scheme */
		function scheme() {
			return array(
				'title'		=>	__('HTML / Text Block','cloudfw'),
				'script'	=> array(
					'shortcode' 	=> '',
					'tag_close'  	=> true,
					'attributes' 	=> array( 
						'content' 	=> array( 'e' => 'the_content' ),
						'format' 	=> array( 'e' => 'format' ),
						'animate' 	=> array( 'e' => 'animate' ),
					)
				),
				'data'		=>  $this->load_scheme( __FILE__ )

			);

		}

	}

}