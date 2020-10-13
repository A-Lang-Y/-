<?php
/*
 * Plugin Name: Tabs
 * Plugin URI: http://cloudfw.net
 * Description: 
 * Version: 1.0
 * Author: Orkun Gürsel
 * Author URI: http://orkungursel.com
 * Shortcode: 
 * Attributes:
 */

cloudfw_register_shortcode( 'CloudFw_Composer_Tab_Group' );
if ( ! class_exists('CloudFw_Composer_Tab_Group') ) {
	class CloudFw_Composer_Tab_Group extends CloudFw_Shortcodes {

		function get_called_class(){ return get_class($this); }

		/** Add the shortcode to the composer */
		function composer(){
			return array(
				'composer'		=> true,
				'droppable'		=> true,
				'ajax'			=> true,
				'icon'			=> 'tabs',
				'group'			=> 'composer_widgets',
				'line'			=> 230,
				'options'		=> array(
					'title'				=> __('Tabs','cloudfw'),
					'column'			=> '1/1',
					'allow_columns'		=> true,
					//'limit'				=> 2,
					'not_in'			=> array('CloudFw_Composer_Container', 'CloudFw_Composer_Tab_Group', 'CloudFw_Composer_Tab_Item'),
					'allow_only'		=> array('CloudFw_Composer_Tab_Item'),
					'error_messages'	=> array(
						'not_in'			=> array(
							'CloudFw_Composer_Container' => array(
								'message' 	=> __('You cannot use the tab component inside a container.','cloudfw')
							),
							'CloudFw_Composer_Tab_Group' => array(
								'message' 	=> __('You must add a tab item instead of tab container here.','cloudfw')
							)
						)
					)
				)
			);
		}

		/** Shortcode */
		function shortcode( $atts, $content = NULL, $case = NULL ) {
			return cloudfw_transfer_shortcode_attributes( $case, $atts, $content );
		}

		/** Admin Scheme */
		function scheme() {
			return array(
				'title'		=>	__('Tabs','cloudfw'),
				'script'	=> array(
					'shortcode:sync' => 'tab_type',
					'attributes' 	=> array( 
						'position'      => array( 'e' => 'tab_position', 'check-default' => 'left' ),
						'align'         => array( 'e' => 'tab_title_align' ),
						'height'        => array( 'e' => 'tab_cont_height', 'check-default' => '0' ),
						'device'        => array( 'e' => 'the_device' ),
						'id'            => array( 'e' => 'custom_id' ),
						'class'         => array( 'e' => 'custom_class' ),
						'margin_top'    => array( 'e' => 'margin_top' ),
						'margin_bottom' => array( 'e' => 'margin_bottom' ),

					),
					'if'		 =>	array(
						array( 
							'type'    => 'toggle',
							'e' 	  => 'tab_type',
							'related' => 'tabsAlignOptions',
							'targets' => array( 
								array('tabs', '#tab_title_align'),
								array('tabs_mega', '#tab_title_align'),
								array('tabs_vertical', '#tab_position') 
							)
						)
					
					)

				),
				'data'		=>  $this->load_scheme( __FILE__ )
			);

		}

		/** Scheme */
		function composer_scheme() {
			return array(
				'data'		=>	array(
					cloudfw_composer_default_dropped_area(
						array(
							array(
								'id'	=>	'CloudFw_Composer_Tab_Item',
								'title'	=>	__('+ Add new tab','cloudfw'),
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

cloudfw_register_shortcode( 'CloudFw_Composer_Tab_Item' );
if ( ! class_exists('CloudFw_Composer_Tab_Item') ) {
	class CloudFw_Composer_Tab_Item extends CloudFw_Shortcodes {

		function get_called_class(){ return get_class($this); }



		/** Add the shortcode to the composer */
		function composer(){
			return array(
				'composer'		=> true,
				'droppable'		=> true,
				'ajax'			=> true,
				'list'			=> false,
				'icon'			=> 'tab-item',
				'group'			=> 'composer_widgets',
				'line'			=> 11,
				'do_shortcode'	=> false,
				'options'		=> array(
					'title'				=> __('Tab (Item)','cloudfw'),
					'column'			=> '1/1',
					'allow_columns'		=> false,
					'sync_title'		=> 'tab_item_title',
					'in'				=> 'CloudFw_Composer_Tab_Group',
					'not_in'			=> 'CloudFw_Composer_Tab_Item',
					'not_allow'			=> array('CloudFw_Composer_Container'),
					'error_messages'	=> array(
						'in'				=> array(
							'CloudFw_Composer_Tab_Group' => array(
								'message' 	=> __('You can only add a tab item component into a tab container.','cloudfw')
							)
						),
						'not_in'			=> array(
							'CloudFw_Composer_Tab_Item' => array(
								'message' 	=> __('You cannot add a tab item component inside another one. Please try to add it into the parent tab group.','cloudfw')
							)
						),
					)
				)
			);
		}

		function shortcode( $atts, $content =  NULL, $case = NULL ) {
			return cloudfw_transfer_shortcode_attributes( 'tab', $atts, $content );
		}

		/** Admin Scheme */
		function scheme() {
			return array(
				'script'	=> array(
					'attributes' 	=> array( 
						'title' 		=> array( 'e' => 'tab_item_title' ),
						'icon' 			=> array( 'e' => 'tab_item_icon' ),
						'hash' 			=> array( 'e' => 'tab_item_tag' ),
						'auto_title'	=> array( 'e' => 'tab_item_auto_title' ),
						'content' 		=> array( 'e' => 'tab_item_content' ),
					),

				),
				'data'		=>	array(

					array(
						'type'		=> 'module',
						'title'		=> __('Title','cloudfw'),
						'data'		=> array(

							## Element
							array(
								'type'		=>	'text',
								'id'		=>	'tab_item_title',
								'value'		=>	$this->get_value('tab_item_title', __('Tab Title','cloudfw')),
								'_class'	=>  'input_150 tab_item_title',
								'editor'	=>	true,
							), // #### element: 0

						)

					),
					
					array(
						'type'		=> 'module',
						'title'		=> __('Custom Hash Tag','cloudfw'),
						'optional'	=> true,
						'data'		=> array(

							## Element
							array(
								'type'		=>	'text',
								'id'		=>	'tab_item_tag',
								'value'		=>	$this->get_value('tab_item_tag'),
								'desc'		=>	'Custom #hastag for the tab item.',
								'width'		=>	'100'
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
								'id'		=>	'tab_item_icon',
								'value'		=>	$this->get_value('tab_item_icon'),
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
					cloudfw_composer_default_dropped_area()
				)
			);
		}

	}

}