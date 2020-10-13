<?php
/*
 * Plugin Name: List
 * Plugin URI: http://cloudfw.net
 * Description: 
 * Version: 1.0
 * Author: Orkun Gürsel
 * Author URI: http://orkungursel.com
 * Shortcode: 
 * Attributes:
 */

cloudfw_register_shortcode( 'CloudFw_Composer_List_Group' );
if ( ! class_exists('CloudFw_Composer_List_Group') ) {
	class CloudFw_Composer_List_Group extends CloudFw_Shortcodes {
		public $do_before = false;

		function get_called_class(){ return get_class($this); }

		/** Add the shortcode to the composer */
		function composer(){
			return array(
				'composer'		=> true,
				'droppable'		=> true,
				'ajax'			=> true,
				'icon'			=> 'list',
				'group'			=> 'composer_widgets',
				'line'			=> 170,
				'options'		=> array(
					'title'				=> __('List Group','cloudfw'),
					'column'			=> '1/1',
					'allow_columns'		=> true,
					'not_in'			=> array('CloudFw_Composer_List_Group', 'CloudFw_Composer_List_Item'),
					'allow_only'		=> array('CloudFw_Composer_List_Item'),
					'error_messages'	=> array(
						'not_in'			=> array(
							'CloudFw_Composer_List_Group' => array(
								'message' 	=> __('You must add a list item instead of list container here.','cloudfw')
							)
						),
					)
				)
			);
		}

		function shortcode( $atts, $content =  NULL, $case = NULL ) {
			$list_content = isset($atts['list_cont']) ? $atts['list_cont'] : NULL;
			unset($list_content_out);
			$list_content_out = ''; 

			if ( !empty( $list_content ) ) {
				$list_content = explode('*', $list_content);

				foreach ((array)$list_content as $list_item) {
					$list_item_trimmed = trim( $list_item );

					if ( !empty( $list_item_trimmed ) )
						$list_content_out .= "[li]{$list_item_trimmed}[/li]";
				}

			}


			return do_shortcode(cloudfw_transfer_shortcode_attributes( $case, $atts, $list_content_out . $content ));
		}

		/** Admin Scheme */
		function scheme() {
			return array(
				'title'		=>	__('List Group','cloudfw'),
				'script'	=> array(
					'shortcode'		=> 'list',
					'tag_close'  	=> true,
					'tag_newline' 	=> true,
					'attributes' 	=> array( 
						'type' 			=> array( 'e' => 'list_type' ),
						'icon_color'	=> array( 'e' => 'list_icon_color' ),
						'border'		=> array( 'e' => 'list_border', 'onoff' => true, 'check-default' => '0' ),
						'list_cont'		=> array( 'e' => 'list_content' ),
					),
					'if'		 =>	array(
						0 	 => array( 
							'type'     => 'clone',
							'action'   => 'add_list_item',
							'e' 	   => '#list_item_clone',
							'e-trigger'=> '#new_list_item',
							'reset'	   =>  array('list_item_content')
						)
					)
				),
				'data'		=>	array(

					array(
						'type'		=> 'module',
						'title'		=> __('Type','cloudfw'),
						'data'		=> array(

							## Element
							array(
								'type'		=>	'select',
								'id'		=>	'list_type',
								'value'		=>	$this->get_value('list_type'),
								'ui'		=>	true,
								'main_class'=>  'input input_250',
								'source'	=>	cloudfw_list_types()

							), // #### element: 0

						)

					),

					array(
						'type'		=> 'module',
						'title'		=> __('Icon Color','cloudfw'),
						'data'		=> array(

							## Element
							array(
								'type'		=>	'color',
								'style'		=>	'horizontal',
								'id'		=>	'list_icon_color',
								'value'		=>	$this->get_value('list_icon_color'),
							), // #### element: 0

						)

					),


					array(
						'type'		=> 'module',
						'condition'	=> false,
						'title'		=> __('Border?','cloudfw'),
						'data'		=> array(

							## Element
							array(
								'type'		=>	'onoff',
								'id'		=>	'list_border',
								'value'		=>	$this->get_value('list_border', 'FALSE'),
							), // #### element: 0

						)

					),

					array(
						'type'		=> 'module',
						'optional'	=> true,
						'title'		=> __('List Content','cloudfw'),
						'data'		=> array(
							## Element
							array(
								'type'		=>	'textarea',
								'id'		=>	'list_content',
								'value'		=>	$this->get_value('list_content'),
								'_class'	=>  'list_element_clone textarea_block',
								'editor'	=>	true,
								'width'		=>	'95%',
								'line'		=>	8,
								'desc'		=>	__('You can add list items instead of list content.','cloudfw') . '<br/><br/><strong>Format:</strong><br/> * Item Text 1<br/>* Item Text 2<br/>* Item Text 3'
							), // #### element: 0

						)

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
								'id'	=>	'CloudFw_Composer_List_Item',
								'title'	=>	__('+ Add list item','cloudfw'),
							),
						)
					)
				)
			);
		}

	}

}


/**
****************************************************************
*/

cloudfw_register_shortcode( 'CloudFw_Composer_List_Item' );
if ( ! class_exists('CloudFw_Composer_List_Item') ) {
	class CloudFw_Composer_List_Item extends CloudFw_Shortcodes {

		function get_called_class(){ return get_class($this); }



		/** Add the shortcode to the composer */
		function composer(){
			return array(
				'composer'		=> true,
				'droppable'		=> false,
				'ajax'			=> true,
				'list'			=> false,
				'icon'			=> 'list-item',
				'group'			=> 'composer_widgets',
				'line'			=> 32,
				'do_shortcode'	=> false,
				'options'		=> array(
					'title'				=> 'List Item',
					'sync_title'		=> 'list_item_content',
					'column'			=> '1/1',
					'allow_columns'		=> false,
					'in'				=> 'CloudFw_Composer_List_Group',
					'not_in'			=> 'CloudFw_Composer_List_Item',
					'not_allow'			=> array('CloudFw_Composer_Container'),
					'error_messages'	=> array(
						'in'				=> array(
							'CloudFw_Composer_List_Group' => array(
								'message' 	=> __('You can only add the list item into a list container.','cloudfw')
							)
						),
						'not_in'			=> array(
							'CloudFw_Composer_List_Item' => array(
								'message' 	=> __('You cannot add the list item inside another one. Please try to add it into the parent list container.','cloudfw')
							)
						),
					)
				)
			);
		}

		function shortcode( $atts, $content =  NULL, $case = NULL ) {
			return cloudfw_transfer_shortcode_attributes( 'li', $atts, $content );

		}

		/** Admin Scheme */
		function scheme() {
			return array(
				'script'	=> array(
					'attributes' 	=> array( 
						'content' 		=> array( 'e' => 'list_item_content' ),
					),

				),
				'data'		=>	array(

					array(
						'type'		=> 'module',
						'title'		=> __('List Content','cloudfw'),
						'data'		=> array(
							## Element
							array(
								'type'		=>	'textarea',
								'id'		=>	'list_item_content',
								'value'		=>	$this->get_value('list_item_content'),
								'_class'	=>  'list_element_clone textarea_block',
								'editor'	=>	true,
								'width'		=>	'90%',
								'line'		=>	2
							), // #### element: 0

						)

					),

				)

			);

		}

	}

}