<?php
/*
 * Plugin Name: Client List
 * Plugin URI: http://cloudfw.net
 * Description: 
 * Version: 1.0
 * Author: Orkun Gürsel
 * Author URI: http://orkungursel.com
 * Shortcode:  
 * Attributes:
 */

cloudfw_register_shortcode( 'CloudFw_Composer_Clients' );
if ( ! class_exists('CloudFw_Composer_Clients') ) {
	class CloudFw_Composer_Clients extends CloudFw_Shortcodes {

		function get_called_class(){ return get_class($this); }


		/** Add the shortcode to the composer */
		function composer(){
			return array(
				'composer'		=> true,
				'droppable'		=> true,
				'ajax'			=> true,
				'icon'			=> 'clients',
				'group'			=> 'composer_widgets',
				'do_shortcode'	=> false,
				'line'			=> 280,
				'options'		=> array(
					'title'				=> __('Clients List','cloudfw'),
					'column'			=> '1/1',
					'allow_columns'		=> false,
					'not_in'			=> array('CloudFw_Composer_Clients', 'CloudFw_Composer_Clients_Item'),
					'allow_only'		=> array('CloudFw_Composer_Clients_Item'),
					'error_messages'	=> array(
						'not_in'			=> array(
							'CloudFw_Composer_Clients' => array(
								'message' 	=> __('You must add a client instead of cilent list container.','cloudfw')
							)
						),
					)
				)
			);
		}

		/** Run */
		function shortcode( $atts = array(), $content =  NULL ) {
			return cloudfw_transfer_shortcode_attributes( 'clients_list', $atts, $content );
		}

		/** Scheme */
		function scheme() {
			return array(
				'title'		=>	__('Clients List','cloudfw'),
				'ajax'		=>	true,
				'script'	=> array(
					'shortcode'  => 'clients_list',
					'attributes' =>	array( 
						'margin_top'     	=> array( 'e' => 'margin_top' ),
						'margin_bottom'  	=> array( 'e' => 'margin_bottom' ),

						'shadow' 			=> array( 'e' => 'client_list_shadow' ),
						'columns' 			=> array( 'e' => 'client_list_columns' ),
						'sorting'    		=> array( 'e' => 'client_list_sorting' ),
						'carousel'    		=> array( 'e' => 'carousel', 'onoff' => true ),
						'auto_rotate'    	=> array( 'e' => 'auto_rotate' ),
						'animation_loop'    => array( 'e' => 'animation_loop' ),
						'rotate_time'    	=> array( 'e' => 'rotate_time' ),

					),
					'if' =>	array(
						
					)
				),
				'data'		=>	array(

					array(
						'type'		=>	'module',
						'title'		=>	__('Columns','cloudfw'),
						'data'		=>	array(
							array(
								'type'		=>	'slider',
								'id'		=>	'client_list_columns',
								'value'		=>	$this->get_value('client_list_columns', 6),
								'class'		=>	'input_250',
								'min'		=>	1,
								'max'		=>	6,
								'unit'		=>	__('column(s)','cloudfw')
							)
						)
					),

					array(
						'type'		=> 'module',
						'title'		=> __('Shadow','cloudfw'),
						'data'		=> array(

							## Element
							array(
								'type'		=>	'select',
								'id'		=>	'client_list_shadow',
								'value'		=>	$this->get_value('client_list_shadow'),
								'source'	=>	array(
									'type'			=> 'function',
									'function'		=> 'cloudfw_admin_loop_shadows',
								),
								'width'		=>	250,

							), // #### element: 0

						)

					),

					array(
						'type'		=> 'module',
						'title'		=> __('Sorting','cloudfw'),
						'data'		=> array(

							## Element
							array(
								'type'		=>	'select',
								'id'		=>	'client_list_sorting',
								'value'		=>	$this->get_value('client_list_sorting'),
								'source'	=>	array(
									'NULL'			=> __('Default','cloudfw'),
									'random'		=> __('Random','cloudfw'),
								),
								'width'		=>	250,

							), // #### element: 0

						)

					),

					array(
						'type'		=>	'global-scheme',
						'scheme'	=>	'carousel',
						'vars'		=>	array( array( 'carousel' => true, 'effect' => false ) ),
						'this'		=>	$this
					),

					array(
						'type'		=>	'global-scheme',
						'scheme'	=>	'margins',
						'this'		=>	$this
					),

				)

			);

		}


		/** Scheme */
		function composer_scheme() {
			return array(
				'data'		=>	array(
					cloudfw_composer_default_dropped_area(
						array(
							array(
								'id'	=>	'CloudFw_Composer_Clients_Item',
								'title'	=>	__('+ Add new client','cloudfw'),
							),
						)
					)
				)
			);
		}

	}

}

cloudfw_register_shortcode( 'CloudFw_Composer_Clients_Item');
if ( ! class_exists('CloudFw_Composer_Clients_Item') ) {
	class CloudFw_Composer_Clients_Item extends CloudFw_Shortcodes {

		function get_called_class(){ return get_class($this); }


		/** Add the shortcode to the composer */
		function composer(){
			return array(
				'composer'		=> true,
				'ajax'			=> true,
				'list'			=> false,
				'icon'			=> 'layout',
				'group'			=> 'composer_widgets',
				'do_shortcode'	=> false,
				'line'			=> 38,
				'options'		=> array(
					'title'				=> __('Client','cloudfw'),
					'column'			=> '1/1',
					'allow_columns'		=> false,

					'sync_title'		=> 'the_content_id',
					'in'				=> 'CloudFw_Composer_Clients',
					'not_in'			=> 'CloudFw_Composer_Clients_Item',
					'not_allow'			=> array('CloudFw_Composer_Container'),
					'error_messages'	=> array(
						'in'				=> array(
							'CloudFw_Composer_Clients' => array(
								'message' 	=> __('You can only add a client into a client list container.','cloudfw')
							)
						)
					)

				)
			);
		}

		/** Run */
		function shortcode( $atts = array(), $content =  NULL ) {
			return cloudfw_transfer_shortcode_attributes( 'client', $atts, $content );
		}

		/** Scheme */
		function scheme() {
			return array(
				'script'	=> array(
					'shortcode'		=> 'client',
					'attributes' 	=> array( 
						'img' 		=> array( 'e' => 'client_image' ),
						'link' 		=> array( 'e' => 'client_link' ),
						'alt' 		=> array( 'e' => 'client_alt' ),
						'title' 	=> array( 'e' => 'client_title' ),
					)
				),
				'data'		=>	array(

					array(
						'type'		=> 'module',
						'title'		=> __('Client Logo / Image','cloudfw'),
						'data'		=> array(

							## Element
							array(
								'type'		=>	'upload',
								'id'		=>	'client_image',
								'value'		=>	$this->get_value('client_image'),
								'store'		=>	true,
								'library'	=>	true,
								'removable'	=>	true,
							)

						)

					),

					array(
						'type'		=> 'module',
						'title'		=> __('Link URL','cloudfw'),
						'data'		=> array(

							## Element
							array(
								'type'		=>	'page-selector',
								'id'		=>	'client_link',
								'value'		=>	$this->get_value('client_link'),
								'response'	=>	'URL',
							)

						)

					),

					array(
						'type'		=> 'module',
						'layout'	=> 'split',
						'title'		=> array(__('Alt Attribute','cloudfw'), __('Title Attribute','cloudfw')),
						'data'		=> array(

							## Element
							array(
								'type'		=>	'text',
								'id'		=>	'client_alt',
								'value'		=>	$this->get_value('client_alt'),
								'width'		=>	200,
					
							), // #### element: 0

							## Element
							array(
								'type'		=>	'text',
								'id'		=>	'client_title',
								'value'		=>	$this->get_value('client_title'),
								'width'		=>	200,
					
							), // #### element: 0

						)

					),

				
				)

			);

		}

	}

}