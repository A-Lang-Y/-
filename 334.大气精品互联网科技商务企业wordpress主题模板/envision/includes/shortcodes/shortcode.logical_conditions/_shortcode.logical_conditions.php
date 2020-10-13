<?php
/*
 * Plugin Name: Logical Conditions
 * Plugin URI: http://cloudfw.net
 * Description:
 * Version: 1.0
 * Author: Orkun Gürsel
 * Author URI: http://orkungursel.com
 * Shortcode:
 * Attributes:
 */

cloudfw_register_shortcode( 'CloudFw_Shortcode_Logical_Conditions', 'condition', 'advanced', 5000 );
if( ! class_exists('CloudFw_Shortcode_Logical_Conditions') ) {
	class CloudFw_Shortcode_Logical_Conditions extends CloudFw_Shortcodes {

		function get_called_class(){ return get_class($this); }


		/** Add the shortcode to the composer */
		function composer(){
			return array(
				'composer'		=> true,
				'droppable'     => true,
				'ajax'			=> true,
				'icon'			=> 'check',
				'group'			=> 'composer_widgets',
				'line'			=> 5000,
				'options'		=> array(
					'title'				=> __('Logical Condition','cloudfw'),
					'column'			=> '1/1',
					'sync_title'		=> 'condition',
					'allow_columns'		=> true,
				)
			);
		}

		/** Run */
		function shortcode( $atts = array(), $content =  NULL ) {

			extract(cloudfw_make_var(array(
				'condition'          => '',
				'if_false_call_page' => NULL,
			), _check_onoff_false($atts)));

			$out = '';
			$show_content = false;

			switch ($condition) {
				case 'logged_in':
					$show_content = is_user_logged_in();
					break;

				case 'not_logged_in':
					$show_content = ! is_user_logged_in();
					break;

				default:
					# code...
					break;
			}

			if ( $show_content === true ) {
				$out = $content;
			} elseif ( !empty( $if_false_call_page ) ) {
				$out = cloudfw_get_page_content( $if_false_call_page );
			}

			return $out;
		}

		/** Scheme */
		function scheme() {
			return array(
				'type'		=>	'shortcode:sub',
				'id'		=>	'condition',
				'ajax'		=>	true,
				'title'		=>	__('Logical Condition','cloudfw'),
				'script'	=> array(
					'shortcode'  => 'condition',
					'tag_close'  => false,
					'attributes' =>	array(
						'condition'          => array( 'e' => 'condition' ),
						'if_false_call_page' => array( 'e' => 'if_false_page' ),
					),
					'if'		 =>	array(
						array(
							'type'    => 'toggle',
							'e' 	  => 'condition',
							'related' => 'conditionOptions',
							'targets' => array(
								//array('1', '#resize_width'),
							)
						)

					)

				),
				'data'		=>	array(

					array(
						'type'		=> 'message',
						'fill'		=> true,
						'color'		=> 'yellow',
						'title'		=> __('Logical Condition','cloudfw'),
						'data'		=> __('if the condition is true then the content, dropped into this widget content area, will be shown.','cloudfw')

					),

					array(
						'type'		=> 'module',
						'title'		=> __('Logical Condition','cloudfw'),
						'data'		=> array(

							## Element
							array(
								'type'		=>	'select',
								'id'		=>	'condition',
								'value'		=>	$this->get_value('condition'),
								'source'	=>	array(
									__('User Conditions','cloudfw') 	=> array(
										'logged_in'		=>	__('If User Logged In','cloudfw'),
										'not_logged_in' =>	__('If User NOT Logged In','cloudfw'),
									)
								),
								'width'		=>	250,
							), // #### element: 0

						)

					),

					array(
						'type'		=>	'mini-section',
						'title'		=>	__('If the condition is false','cloudfw'),
						'data'		=>	array(

							array(
								'type'		=> 'module',
								'title'		=> __('If the condition is false, call the content of the selected page','cloudfw'),
								'data'		=> array(

									## Element
									array(
										'type'		=>	'select',
										'id'		=>	'if_false_page',
										'value'		=>	$this->get_value('if_false_page'),
										'source'	=>	array(
											'type'		=>	'function',
											'function'	=>	'cloudfw_admin_loop_all_pages',
											'include'	=>	array(
												'NULL' 		=>	'',
											),
										),
										'width'		=>	250,
									), // #### element: 0

								)

							),
					
						)
					
					),
					


				)


			);

		}

		/** Scheme */
		function composer_scheme() {
			return array(
				'data'      =>  array(
					cloudfw_composer_default_dropped_area()
				)
			);
		}

	}

}