<?php
/*
 * Plugin Name: Lists
 * Plugin URI: http://cloudfw.net
 * Description: 
 * Version: 1.0
 * Author: Orkun Gürsel
 * Author URI: http://orkungursel.com
 * Shortcode: 
 * Attributes:
 */

if ( !function_exists('cloudfw_list_types') ) {

	/**
	 *    CloudFw List Types
	 *
	 *    @since 1.0
	 */
	function cloudfw_list_types(){
	    $types = array(
			'circle'                         => __('Circle','cloudfw'),
			'square'                         => __('Square','cloudfw'),
			'bull'                           => __('Bullet','cloudfw'),
			'decimal'                        => __('Decimal','cloudfw'),
			'roman-decimal'                  => __('Roman Decimal','cloudfw'),
			'fontawesome-angle-right'        => __('Right Angle Icon','cloudfw'),
			'fontawesome-chevron-right'      => __('Right Chevron Icon','cloudfw'),
			'fontawesome-chevron-sign-right' => __('Right Chevron Sign Icon','cloudfw'),
			'fontawesome-plus-sign-alt'      => __('Plus Icon','cloudfw'),
			'fontawesome-minus-sign-alt'     => __('Minus Icon','cloudfw'),
			'fontawesome-ok'                 => __('Ok! Icon','cloudfw'),
			'fontawesome-check'              => __('Check Icon','cloudfw'),
			'fontawesome-check-sign'         => __('Check Sign Icon','cloudfw'),
			'fontawesome-remove'             => __('Cancel Icon','cloudfw'),
			'fontawesome-remove-sign'        => __('Cancel Sign Icon','cloudfw'),
			'fontawesome-warning-sign'       => __('Warning Sign Icon','cloudfw'),
			'fontawesome-certificate'        => __('Asterisk Icon','cloudfw'),
			'fontawesome-heart'              => __('Heart Icon','cloudfw'),
			'fontawesome-heart-empty'        => __('Empty Heart Icon','cloudfw'),
			'fontawesome-folder-close'       => __('Folder Icon','cloudfw'),
			'fontawesome-facetime-video'     => __('Video Icon','cloudfw'),
			'fontawesome-envelope-alt'       => __('Envelope Icon','cloudfw'),
			'fontawesome-rss'                => __('RSS Icon','cloudfw'),
	    );
	    return apply_filters('cloudfw_list_types', $types);
	}

}

cloudfw_register_shortcode( 'CloudFw_Shortcode_Lists', NULL, 'style', 20 );
if ( ! class_exists('CloudFw_Shortcode_Lists') ) {

	class CloudFw_Shortcode_Lists extends CloudFw_Shortcodes {
		public $do_before = false;

		function get_called_class(){ return get_class($this); }

		/** Defines */
		var $parent	= 0;
		var $child	= 0;
		var $total	= 0;
		var $echo	= '';
		var $titles	= '';
		var $atts	= array();

		/** Add */
		function add() {
			return array(
				'list' 		=> array( &$this, 'register_list' ),
				'li' 		=> array( &$this, 'register_list_item' ),
			);
		}

		/** Run */
		function register_list( $atts = array(), $content =  NULL, $case = NULL ) {
			$this->atts = (shortcode_atts(array(
				'type'				=> '',
				'icon_color'		=> '',
				'border'			=> false,
			), _check_onoff_false($atts)));

			extract($this->atts);

			$this->parent++;
			$this->child = 0;
			$this->total = 0;
			$this->echo = '';
			$this->titles = '';
			$this->total = count(explode("[li",$content)) - 1;

			$type = str_replace('icon-', 'fontawesome-', $type);

			if ( strpos( $type, 'fontawesome-' ) !== false ){
				$class = "list-font-icon";
				$this->atts['icon_class'] = $type;
			} else {
				$class = "list-{$type}";
				$this->atts['icon_class'] = false;
			}

			$class .= ' parent-' . $this->parent;

			if ( $border )
				$class .= ' border';


			$this->echo .= do_shortcode( $content );

			if ( $this->echo ) 
				return "<ul class=\"ui--list $class\">{$this->echo}</ul>";

		}

		function register_list_item($atts, $content =  NULL, $case = NULL){
			extract(shortcode_atts(array(
				'sub'				=> 0,
			), $atts));

			extract($this->atts);

			$this->child++;

			if ( $sub ) {
				$classes[] = 'sub-level'; 
			}
			
			$classes[] = 'child-'.$this->child.'';
			$classes[] = 'total-'.$this->total.'';
			$classes[] = 'ui--animation';

			$class = cloudfw_make_class( $classes );

			$this->echo .= "<li{$class}>";

				if ( $icon_class ) {
					$this->echo .= "<i".
						cloudfw_make_class(array( 'list-icon', '14px', $icon_class ), true) .
						cloudfw_make_style_attribute( array(
							'!color' => $icon_color,
						), FALSE, TRUE )
					."></i>";
				}

				$this->echo .= "{$content}";
			$this->echo .= "</li>";

		}

		/** Admin Scheme */
		function scheme() {
			return array(
				'title'		=>	__('Lists','cloudfw'),
				'script'	=> array(
					'shortcode'		=> 'list',
					'tag_close'  	=> true,
					'tag_newline' 	=> true,
					'attributes' 	=> array( 
						'type' 			=> array( 'e' => 'list_type' ),
						'icon_color' 	=> array( 'e' => 'list_icon_color' ),
						'border'		=> array( 'e' => 'list_border', 'onoff' => true, 'check-default' => '0' ),
						'content' 		=> array( 'e' => 'list_item_content', 'force' => true, 'prepend' => '\'+$nl+\'\'+$tb+\'[li]', 'append' => '[/li]', 'multi' => 'list_element_clone', 'seperator' => ',' ),
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
								'value'		=>	'',
								'ui'		=>	true,
								'main_class'=>  'input input_250',
								'source'	=>	array(
									'type'		=>	'function',
									'function'	=>	'cloudfw_list_types',
								)

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
								'value'		=>	'FALSE',
							), // #### element: 0

						)

					),

					array(
						'type'		=> 'module',
						'title'		=> __('List Item','cloudfw'),
						'before' 	=> '<ul class="sortable_ul cursor-sortable"><li id="list_item_clone">',
						'after' 	=> '</li></ul>',
						'class'		=> 'module list_item_clone_class',
						'data'		=> array(

							## Element
							array(
								'type'		=>	'textarea',
								'id'		=>	'list_item_content',
								'value'		=>	'',
								'_class'	=>  'textarea_400px_2line list_element_clone textarea_block',
							), // #### element: 0

						)

					),

					array(
						'type'		=> 'module',
						'title'		=> '',
						'data'		=> array(
							## Element
							array(
								'type'		=>	'html',
								'data'		=>	'<a id="new_list_item" class="small-button small-green" href="javascript:;"><span>'.__('+ Add New List Item','cloudfw').'</span></a>',
							), // #### element: 0

						)

					),
					
				)

			);

		}

	}

}