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
cloudfw_register_shortcode( 'CloudFw_Shortcode_Sharrre', 'sharrre', 'advanced', 66 );
	if ( ! class_exists('CloudFw_Shortcode_Sharrre') ) {
	class CloudFw_Shortcode_Sharrre extends CloudFw_Shortcodes {

		function get_called_class(){ return get_class($this); }


		/** Add the shortcode to the composer */
		function composer(){
			return array(
				'composer'		=> true,
				'ajax'			=> true,
				'droppable'		=> false,
				'icon'			=> 'share',
				'group'			=> 'composer_widgets',
				'line'			=> 400,
				'options'		=> array(
					'title'				=> __('Sharing Services','cloudfw'),
					'column'			=> '1/1',
					'allow_columns'		=> true,
					'allow_edit'		=> true,
				)
			);
		}

		/** Run */
		function shortcode( $atts = array(), $content =  NULL ) {
			$services = isset($atts['services']) ? $atts['services'] : NULL; 
			$title = isset($atts['title']) ? $atts['title'] : NULL; 
			$url = isset($atts['url']) ? $atts['url'] : NULL; 

			if ( !is_array( $services ) ) {
				$services = explode(',', $services);
				$services = array_filter( $services ); 
			}

			if ( empty( $services ) ) {
				$services = cloudfw_sharrre_services( 'raw' );
			}

			return cloudfw_sharrre( $services, $atts, $title, $url );
		}

		/** Admin Scheme */
		function scheme() {
			return array(
				'title'		=>	__('Sharing Services','cloudfw'),
				'script'	=> array(
					'shortcode'		=> 'sharrre',
					'tag_close'  	=> false,
					'attributes' 	=> array( 
						'type'          => array( 'e' => 'sharrre_type' ),
						'counter'       => array( 'e' => 'sharrre_counter', 'onoff' => true ),
						'align'         => array( 'e' => 'sharrre_align' ),
						'margin_top'    => array( 'e' => 'margin_top' ),
						'margin_bottom' => array( 'e' => 'margin_bottom' ),
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
								'id'		=>	'sharrre_type',
								'value'		=>	$this->get_value('sharrre_type'),
								'source'	=>	array(
									'NULL'		=> __('Default','cloudfw'),
									'block'		=> __('Block Style','cloudfw'),
									'mini-block'=> __('Mini Block Style','cloudfw'),
								),
								'width'		=>	250,
							),

						)

					),

					array(
						'type'		=> 'module',
						'title'		=> __('Display Counter','cloudfw'),
						'data'		=> array(

							## Element
							array(
								'type'		=>	'onoff',
								'id'		=>	'sharrre_counter',
								'value'		=>	$this->get_value('sharrre_counter'),
							),

						)

					),

					array(
						'type'		=> 'module',
						'title'		=> __('Align','cloudfw'),
						'data'		=> array(

							## Element
							array(
								'type'		=>	'select',
								'id'		=>	'sharrre_align',
								'value'		=>	$this->get_value('sharrre_align'),
								'source'	=>	array(
									'type'		=> 'function',
									'function'	=> 'cloudfw_admin_loop_text_aligns',

								),
								'ui'		=>	true,
								'main_class'=> 'input_150'
							), // #### element: 0

						)

					),

					array(
						'type'		=>	'global-scheme',
						'scheme'	=>	'margins',
						'this'		=>	$this
					),
					
				)

			);

		}

	}

}