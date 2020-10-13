<?php
/*
 * Plugin Name: Contact Form for CF7
 * Plugin URI: http://cloudfw.net
 * Description: 
 * Version: 1.0
 * Author: Orkun Gürsel
 * Author URI: http://orkungursel.com
 * Shortcode:  
 * Attributes:
 */

cloudfw_register_shortcode( 'CloudFw_Shortcode_Contact', NULL, 'advanced', 35 );
if ( ! class_exists('CloudFw_Shortcode_Contact') ) {
	class CloudFw_Shortcode_Contact extends CloudFw_Shortcodes {
		
		public $do_before = false;

		function get_called_class(){ return get_class($this); }


		/** Add the shortcode to the composer */
		function composer(){
			return array(
				'composer'		=> defined( 'WPCF7_VERSION' ),
				'ajax'			=> true,
				'icon'			=> 'envelope',
				'group'			=> 'composer_widgets',
				'line'			=> 430,
				'options'		=> array(
					'title'				=> __('Contact Form','cloudfw'),
					'sync_title'		=> 'contact_form_id',
					'column'			=> '1/1',
					'allow_columns'		=> true,
				)
			);
		}

		/** Shortcode */
		function shortcode( $atts, $content =  NULL, $case = NULL ) {
			return (do_shortcode("[{$case} id=\"{$atts['id']}\"]"));
		}

		/** Run */
		function register() {
			return array();
		}

		/** Scheme */
		function scheme() {
			return array(
				'title'		=> __('Contact Form','cloudfw'),
				'ajax' 		=> true,
				'script'	=> array(
					'shortcode'		=> 'contact-form-7',
					'prepend'	=> ' ',
					'append' 	=> ' ',
					'tag_close'  	=> false,
					'attributes' 	=> array( 
						'id' 		=> array( 'e' => 'contact_form_id', 'required' => __('Please select a contact form to add','cloudfw'), 'check_visiblity' => false ),
					)
				),
				'data'		=>	array(

				

					5 => array(
						'type'		=> 'module',
						'condition' => (defined( 'WPCF7_VERSION' )),
						'title'		=> __('Contact Forms','cloudfw'),
						'data'		=> array(

							## Element
							array(
								'type'		=>	'select',
								'id'		=>	'contact_form_id',
								'value'		=>	$this->get_value('contact_form_id'),
								'main_class'=>  'input input_250',
								'ui'		=>	true,
								'source'	=>	array(
									'type'		=>	'function',
									'function'	=>	'cloudfw_admin_loop_contact_forms'
								)							
							), // #### element: 0

						)

					),  // #### element: 5

					6 => array(
						'type'		=> 'module',
						'condition' => (!defined( 'WPCF7_VERSION' )),
						'title'		=> __('Plugin','cloudfw'),
						'data'		=> array(

							## Element
							array(
								'type'		=>	'html',
								'data'		=>	'Please install Contact Form 7 plugin',
						
							), // #### element: 0

						)

					),  // #### element: 6


				
				)

			);

		}

		/** Skin map */
		function skin_map( $map ){
			$map  -> id      ( 'cf7_success_message' )
			      -> selector( 'div.wpcf7-mail-sent-ok' )
			      -> attr    ( 'gradient', array(), true )
			      -> attr    ( 'border-kit', array(), true );

			$map  -> id      ( 'cf7_success_message_text' )
			      -> selector( 'div.wpcf7-mail-sent-ok (|p|a)' )
			      -> attr    ( 'text-shadow-kit', array(), true );

			$map  -> id      ( 'cf7_error_message' )
			      -> selector( '.wpcf7-validation-errors, .wpcf7-mail-sent-ng, span.wpcf7-not-valid-tip' )
			      -> attr    ( 'gradient', array(), true )
			      -> attr    ( 'border-kit', array(), true );

			$map  -> id      ( 'cf7_error_message_text' )
			      -> selector( '.wpcf7-validation-errors (|p|a), .wpcf7-mail-sent-ng (|p|a), span.wpcf7-not-valid-tip (|p|a)' )
			      -> attr    ( 'text-shadow-kit', array(), true );


			$map  -> id      ( 'cf7_error_message_arrow' )
			      -> selector( 'span.wpcf7-not-valid-tip:after' )
			      -> sync    ( 'border-bottom-color', 'cf7_error_message', array( 'gradient' ) );

		    return $map;
		}


		/** Skin scheme */
		function skin_scheme( $schemes, $data ){
			return cloudfw_add_skin_scheme( 'shortcode',
				$schemes,
				array(
					'type'		=>	'module-set',
					'title'		=>	__('Contact Form','cloudfw'),
					'closable'	=>	true,
					'state'		=>	'closed',
					'data'		=>	array(

						array(
							'type'		=>	'mini-section',
							'title'		=>	__('Success Message','cloudfw'),
							'data'		=>	array(

								## Module Item
								array(
									'divider'	=>	false,
									'type'		=>	'module',
									'ucode'		=>	'CONTACT FORM',
									'title'		=>	__('Background','cloudfw'),
									'data'		=>	array(

										array(
											'type'		=>	'gradient',
											'id'		=>	cloudfw_sanitize('cf7_success_message','gradient'),
											'value'		=>	$data['cf7_success_message']['gradient'],
										),

									)

								),

								## Module Item
								array(
									'type'		=>	'border',
									'title'		=>	__('Border','cloudfw'),
									'id'		=>	cloudfw_sanitize('cf7_success_message'),
									'value'		=>	$data['cf7_success_message'],
									'merge'		=>	'module',
									'ucode'		=>	'CONTACT FORM',
								),

								## Module Item
								array(
									'type'		=>	'text-shadow-kit',
									'merge'		=>	'module',
									'title'		=>	__('Text','cloudfw'),
									'id'		=>	cloudfw_sanitize('cf7_success_message_text'),
									'value'		=>	$data['cf7_success_message_text'],
									'ucode'		=>	'CONTACT FORM',
								),

							)

						),

						array(
							'type'		=>	'mini-section',
							'title'		=>	__('Error Message','cloudfw'),
							'data'		=>	array(

								## Module Item
								array(
									'divider'	=>	false,
									'type'		=>	'module',
									'ucode'		=>	'CONTACT FORM',
									'title'		=>	__('Background','cloudfw'),
									'data'		=>	array(

										array(
											'type'		=>	'gradient',
											'id'		=>	cloudfw_sanitize('cf7_error_message','gradient'),
											'value'		=>	$data['cf7_error_message']['gradient'],
										),

									)

								),

								## Module Item
								array(
									'type'		=>	'border',
									'title'		=>	__('Border','cloudfw'),
									'id'		=>	cloudfw_sanitize('cf7_error_message'),
									'value'		=>	$data['cf7_error_message'],
									'merge'		=>	'module',
									'ucode'		=>	'CONTACT FORM',
								),

								## Module Item
								array(
									'type'		=>	'text-shadow-kit',
									'merge'		=>	'module',
									'title'		=>	__('Text','cloudfw'),
									'id'		=>	cloudfw_sanitize('cf7_error_message_text'),
									'value'		=>	$data['cf7_error_message_text'],
									'ucode'		=>	'CONTACT FORM',
								),

							)

						),


															
					) // module set data
						
				)
				
			);

		}

	}

}