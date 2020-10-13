<?php
/*
 * Plugin Name: Message Boxes
 * Plugin URI: http://cloudfw.net
 * Description:
 * Version: 1.0
 * Author: Orkun Gürsel
 * Author URI: http://orkungursel.com
 * Shortcode:
 * Attributes:
 */

cloudfw_register_shortcode( 'CloudFw_Shortcode_Message_Boxes', NULL, 'style', 25 );
if ( ! class_exists('CloudFw_Shortcode_Message_Boxes') ) {
	class CloudFw_Shortcode_Message_Boxes extends CloudFw_Shortcodes {

		function get_called_class(){ return get_class($this); }


		/** Add the shortcode to the composer */
		function composer(){
			return array(
				'composer'		=> true,
				'ajax'			=> true,
				'icon'			=> 'info-grey',
				'group'			=> 'composer_widgets',
				'line'			=> 220,
				'options'		=> array(
					'title'				=> __('Message Box','cloudfw'),
					'sync_title'		=> 'box_title',
					'column'			=> '1/1',
					'allow_columns'		=> true,
				)
			);
		}

		/** Register */
		function register() {
			return array(
				'caution',
				'success',
				'error',
				'info',
			);
		}

		/** Run */
		function shortcode( $atts = array(), $content =  NULL, $case = NULL ) {
			extract(shortcode_atts(array(
				'icon'		=> '',
				'shadow'	=> 0,
			), _check_onoff_false($atts)));

			switch ( $case ) {
				case 'success':	$class = "ui--message-box-success ui--gradient"; break;
				case 'error':	$class = "ui--message-box-error ui--gradient"; break;
				case 'info':	$class = "ui--message-box-info ui--gradient-primary ui--gradient"; break;
				case 'caution':	$class = "ui--message-box-caution ui--gradient"; break;
			}

			$icon = cloudfw_make_icon( $icon );
			$content = do_shortcode( $content );

			$out = '';
			$out .= "<div class=\"ui--message-box-wrap ui-row ui--animation clearfix\">";
				
				$out .= "<div class=\"ui--message-box clearfix $class\">";

					if ( ! empty( $icon ) ) {
						$out .= "<div class=\"ui--message-box-icon-wrap\">{$icon}</div>";
					}

					$out .= "<div class=\"ui--message-box-inline\">";
						$out .= cloudfw_inline_format( $content );
					$out .= "</div>";

				$out .= "</div>";

				if ( $shadow ) {
					$out .= cloudfw_UI_shadow( $shadow );
				}

			$out .= "</div>";

			return $out;
			//$out = "<div class=\"ui--message-box ui-row clearfix $class\">". _if( $icon, "<div class=\"ui--message-box-icon-wrap\">{$icon}</div>" ) ."<div class=\"ui--message-box-inline\">"._if(!empty($content), "<p>$content</p>")."</div></div>";

		}

		/** Admin Scheme */
		function scheme() {
			return array(
				'title'		=>	__('Message Boxes','cloudfw'),
				'script'	=> array(
					'shortcode:sync'=> 'box_type',
					'tag_close'  => true,
					'attributes' =>	array(
						'title' 	=> array( 'e' => 'box_title', 	'force' => true ),
						'icon' 		=> array( 'e' => 'box_icon' ),
						'shadow' 	=> array( 'e' => 'box_shadow' ),
						'content' 	=> array( 'e' => 'box_content', 'force' => true ),
					)
				),
				'data'		=>	array(

					array(
						'type'		=> 'module',
						'title'		=> __('Box Type','cloudfw'),
						'data'		=> array(

							## Element
							array(
								'type'		=>	'select',
								'id'		=>	'box_type',
								'value'		=>	$this->get_value('box_type'),
								'ui'		=>	true,
								'main_class'=>  'input input_250',
								'source'	=>	array(
									'info' 		=> __('Info Box','cloudfw'),
									'success' 	=> __('Success Box','cloudfw'),
									'error' 	=> __('Error Box','cloudfw'),
									'caution' 	=> __('Caution Box','cloudfw'),
								),
							), // #### element: 0

						)

					),

					array(
						'type'      => 'module',
						'title'     => __('Shadow','cloudfw'),
						'data'      => array(

							## Element
							array(
								'type'      =>  'select',
								'id'        =>  'box_shadow',
								'value'     =>  $this->get_value('box_shadow'),
								'source'    =>  array(
									'type'          => 'function',
									'function'      => 'cloudfw_admin_loop_shadows',
								),
								'width'     =>  250,

							), // #### element: 0

						)

					),

					array(
						'type'		=> 'module',
						'title'		=> __('Icon','cloudfw'),
						'data'		=> array(

							## Element
							array(
								'type'		=>	'icon-selector',
								'id'		=>	'box_icon',
								'value'		=>	$this->get_value('box_icon'),
							), // #### element: 0

						)

					),

					array(
						'type'		=> 'module',
						'title'		=> __('Content','cloudfw'),
						'data'		=> array(

							## Element
							array(
								'type'		=>	'textarea',
								'id'		=>	'box_content',
								'value'		=>	$this->get_value('box_content'),
								'editor'	=>	true,
								'autogrow'	=>	true,
								'width'		=>	'90%',
								'line'		=>	5

							), // #### element: 0

						)

					),

				)

			);

		}


		/** Skin map */
		function skin_map( $map ){
			$map  -> id      ( 'message_box_success' )
			      -> selector( '.ui--message-box-success' )
			      -> attr    ( 'gradient', array(), true )
			      -> attr    ( 'border-kit', array(), true );

			$map  -> id      ( 'message_box_success_text' )
			      -> selector( '.ui--message-box-success (|p|a|h*)' )
			      -> attr    ( 'text-shadow-kit', array(), true );

			$map  -> id      ( 'message_box_info' )
			      -> selector( '.ui--message-box-info' )
			      -> attr    ( 'gradient', array(), true )
			      -> attr    ( 'border-kit', array(), true );

			$map  -> id      ( 'message_box_info_text' )
			      -> selector( '.ui--message-box-info (|p|a|h*)' )
			      -> attr    ( 'text-shadow-kit', array(), true );
			
			$map  -> id      ( 'message_box_caution' )
			      -> selector( '.ui--message-box-caution' )
			      -> attr    ( 'gradient', array(), true )
			      -> attr    ( 'border-kit', array(), true );

			$map  -> id      ( 'message_box_caution_text' )
			      -> selector( '.ui--message-box-caution (|p|a|h*)' )
			      -> attr    ( 'text-shadow-kit', array(), true );

			$map  -> id      ( 'message_box_error' )
			      -> selector( '.ui--message-box-error' )
			      -> attr    ( 'gradient', array(), true )
			      -> attr    ( 'border-kit', array(), true );

			$map  -> id      ( 'message_box_error_text' )
			      -> selector( '.ui--message-box-error (|p|a|h*)' )
			      -> attr    ( 'text-shadow-kit', array(), true );


		    return $map;
		}


		/** Skin scheme */
		function skin_scheme( $schemes, $data ){
			return cloudfw_add_skin_scheme( 'shortcode',
				$schemes,
				array(
					'type'		=>	'module-set',
					'title'		=>	__('Message Boxes','cloudfw'),
					'closable'	=>	true,
					'state'		=>	'closed',
					'data'		=>	array(

						array(
							'type'		=>	'mini-section',
							'title'		=>	__('Success Box','cloudfw'),
							'data'		=>	array(

								## Module Item
								array(
									'divider'	=>	false,
									'type'		=>	'module',
									'ucode'		=>	'MESSAGE BOX',
									'title'		=>	__('Background','cloudfw'),
									'data'		=>	array(

										array(
											'type'		=>	'gradient',
											'id'		=>	cloudfw_sanitize('message_box_success','gradient'),
											'value'		=>	$data['message_box_success']['gradient'],
										),

									)

								),

								## Module Item
								array(
									'type'		=>	'border',
									'title'		=>	__('Border','cloudfw'),
									'id'		=>	cloudfw_sanitize('message_box_success'),
									'value'		=>	$data['message_box_success'],
									'merge'		=>	'module',
									'ucode'		=>	'MESSAGE BOX',
								),

								## Module Item
								array(
									'type'		=>	'text-shadow-kit',
									'merge'		=>	'module',
									'title'		=>	__('Text','cloudfw'),
									'id'		=>	cloudfw_sanitize('message_box_success_text'),
									'value'		=>	$data['message_box_success_text'],
									'ucode'		=>	'MESSAGE BOX',
								),

							)

						),

						array(
							'type'		=>	'mini-section',
							'title'		=>	__('Info Box','cloudfw'),
							'data'		=>	array(

								## Module Item
								array(
									'divider'	=>	false,
									'type'		=>	'module',
									'ucode'		=>	'MESSAGE BOX',
									'title'		=>	__('Background','cloudfw'),
									'data'		=>	array(

										array(
											'type'		=>	'gradient',
											'id'		=>	cloudfw_sanitize('message_box_info','gradient'),
											'value'		=>	$data['message_box_info']['gradient'],
										),

									)

								),

								## Module Item
								array(
									'type'		=>	'border',
									'title'		=>	__('Border','cloudfw'),
									'id'		=>	cloudfw_sanitize('message_box_info'),
									'value'		=>	$data['message_box_info'],
									'merge'		=>	'module',
									'ucode'		=>	'MESSAGE BOX',
								),

								## Module Item
								array(
									'type'		=>	'text-shadow-kit',
									'merge'		=>	'module',
									'title'		=>	__('Text','cloudfw'),
									'id'		=>	cloudfw_sanitize('message_box_info_text'),
									'value'		=>	$data['message_box_info_text'],
									'ucode'		=>	'MESSAGE BOX',
								),

							)

						),

						array(
							'type'		=>	'mini-section',
							'title'		=>	__('Caution Box','cloudfw'),
							'data'		=>	array(

								## Module Item
								array(
									'divider'	=>	false,
									'type'		=>	'module',
									'ucode'		=>	'MESSAGE BOX',
									'title'		=>	__('Background','cloudfw'),
									'data'		=>	array(

										array(
											'type'		=>	'gradient',
											'id'		=>	cloudfw_sanitize('message_box_caution','gradient'),
											'value'		=>	$data['message_box_caution']['gradient'],
										),

									)

								),

								## Module Item
								array(
									'type'		=>	'border',
									'title'		=>	__('Border','cloudfw'),
									'id'		=>	cloudfw_sanitize('message_box_caution'),
									'value'		=>	$data['message_box_caution'],
									'merge'		=>	'module',
									'ucode'		=>	'MESSAGE BOX',
								),

								## Module Item
								array(
									'type'		=>	'text-shadow-kit',
									'merge'		=>	'module',
									'title'		=>	__('Text','cloudfw'),
									'id'		=>	cloudfw_sanitize('message_box_caution_text'),
									'value'		=>	$data['message_box_caution_text'],
									'ucode'		=>	'MESSAGE BOX',
								),

							)

						),

						array(
							'type'		=>	'mini-section',
							'title'		=>	__('Error Box','cloudfw'),
							'data'		=>	array(

								## Module Item
								array(
									'divider'	=>	false,
									'type'		=>	'module',
									'ucode'		=>	'MESSAGE BOX',
									'title'		=>	__('Background','cloudfw'),
									'data'		=>	array(

										array(
											'type'		=>	'gradient',
											'id'		=>	cloudfw_sanitize('message_box_error','gradient'),
											'value'		=>	$data['message_box_error']['gradient'],
										),

									)

								),

								## Module Item
								array(
									'type'		=>	'border',
									'title'		=>	__('Border','cloudfw'),
									'id'		=>	cloudfw_sanitize('message_box_error'),
									'value'		=>	$data['message_box_error'],
									'merge'		=>	'module',
									'ucode'		=>	'MESSAGE BOX',
								),

								## Module Item
								array(
									'type'		=>	'text-shadow-kit',
									'merge'		=>	'module',
									'title'		=>	__('Text','cloudfw'),
									'id'		=>	cloudfw_sanitize('message_box_error_text'),
									'value'		=>	$data['message_box_error_text'],
									'ucode'		=>	'MESSAGE BOX',
								),

							)

						),


															
					) // module set data
						
				)
				
			);

		}

	}

}