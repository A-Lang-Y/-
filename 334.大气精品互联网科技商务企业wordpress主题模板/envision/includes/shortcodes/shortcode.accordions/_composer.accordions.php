<?php
/*
 * Plugin Name: Accordions
 * Plugin URI: http://cloudfw.net
 * Description: 
 * Version: 1.0
 * Author: Orkun Gürsel
 * Author URI: http://orkungursel.com
 * Shortcode: 
 * Attributes:
 */
cloudfw_register_shortcode( 'CloudFw_Composer_Accordions' );
if ( ! class_exists('CloudFw_Composer_Accordions') ) {
	class CloudFw_Composer_Accordions extends CloudFw_Shortcodes {
		function get_called_class(){ return get_class($this); }

		var $id	= 0;
		var $child	= array();
		var $total	= array();
		var $atts	= array();
		var $header	= array();
		var $footer	= array();
		var $titles	= array();
		var $content= array();

		/** Add the shortcode to the composer */
		function composer(){
			return array(
				'composer'		=> true,
				'droppable'		=> true,
				'ajax'			=> true,
				'icon'			=> 'accordion',
				'group'			=> 'composer_widgets',
				'line'			=> 250,
				'options'		=> array(
					'title'				=> __('Accordion','cloudfw'),
					'column'			=> '1/1',
					'allow_columns'		=> true,
					'not_in'			=> array('CloudFw_Composer_Accordions', 'CloudFw_Composer_Accordions_Item'),
					'allow_only'		=> array('CloudFw_Composer_Accordions_Item'),
					'error_messages'	=> array(
						'not_in'			=> array(
							'CloudFw_Composer_Accordions' => array(
								'message' 	=> __('You must add a accordion item here.','cloudfw')
							)
						)
					)
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
								'id'	=>	'CloudFw_Composer_Accordions_Item',
								'title'	=>	__('+ Add new accordion item','cloudfw'),
							),
						)
					)
				)
			);
		}

		/** Admin Scheme */
		function scheme() {
			return array(
				'title'		=>	__('Accordion','cloudfw'),
				'script'	=> array(
					'shortcode' 	=> 'accordions',
					'attributes' 	=> array( 
						'icon'           => array( 'e' => 'accordion_icon' ),
						'icon_opened'    => array( 'e' => 'accordion_icon_opened' ),
						'device'         => array( 'e' => 'the_device' ),
						'margin_top'     => array( 'e' => 'margin_top' ),
						'margin_bottom'  => array( 'e' => 'margin_bottom' ),

					)

				),
				'data'		=>  $this->load_scheme( __FILE__ )
			);

		}


		/**
		 *	Add
		 */
		function add() {
			return array(
				'accordions' 	=> array( &$this, 'register_group' ),
				'accordion' 	=> array( &$this, 'register_item' ),
			);
		}

		/** Shortcode */
		function shortcode( $atts, $content = NULL, $case = NULL ) {
			return cloudfw_transfer_shortcode_attributes( $case, $atts, $content );
		}

		function register_group($atts, $content =  NULL, $case = NULL){

			if ( !isset($this->id) )
				$this->id = 0;

			$this->id++;
		
			$this->atts = shortcode_atts(array(
				'title_element'  => 'div',
				'id'             => '',
				'class'          => '',
				'icon'           => '',
				'icon_opened'    => '',
				'device'         => '',
				'margin_top'     => '',
				'margin_bottom'  => '',
			), $atts); 

			extract( $this->atts );

			$this->child = 0;
			$this->total = 0;
			$this->header = '';
			$this->footer = '';
			$this->contents = '';
			$this->total = count(explode("[accordion",$content)) - 1;

			$classes = array();
			$classes[] = 'ui--accordion';
			$classes[] = 'ui--box';
			$classes[] = 'ui--animation';
			$classes[] = 'clearfix';

			$classes[] = cloudfw_visible( $device ); 
			$classes[] = $class;

			do_shortcode($content);

			$this->header  = "<div ". 
				cloudfw_make_id( $id ) .
				cloudfw_make_class($classes, true) .
				cloudfw_make_style_attribute( array( 
					'margin-top'     => $margin_top,
					'margin-bottom'  => $margin_bottom,
				), FALSE, TRUE )

			.">";

			/** Define the Footer */
			$this->footer = "</div>";

			$out = 	$this->header . 
				 	$this->contents . 
				 	$this->footer;

			unset($this->header);
			unset($this->contents);
			unset($this->footer);

			return $out; 
		}


		/*
		 *	Item
		 */
		function register_item($atts, $content =  NULL){
			extract(shortcode_atts(array(
				'title'				=> '',
				'state'				=> '',
				'hash'				=> '',
			), $atts));

			if ( !isset($this->child) )
				$this->child = 0;

			$this->child++;

			extract($this->atts);

			$icon_closed = cloudfw_make_icon( isset($this->atts['icon']) ? $this->atts['icon'] : NULL );
			$icon_opened = cloudfw_make_icon( isset($this->atts['icon_opened']) ? $this->atts['icon_opened'] : NULL );

			if ( empty( $icon_opened ) ) {
				$icon_opened = $icon_closed; 
			} elseif ( empty( $icon_closed ) ) {
				$icon_closed = $icon_opened; 
			}

			$classes = array();
			$classes[] = 'ui--accordion-item'; 
			$classes[] = 'ui--gradient'; 
			$classes[] = 'ui--gradient-grey'; 
			$classes[] = 'on--hover'; 
			$classes[] = 'ui-row'; 

			$i = $this->child; 
			$count = $this->total;

			if ( $i == 1 ) {
				$classes[] = 'first-item';
			} elseif ( $i == $count ) {
				$classes[] = 'last-item';
			}


			if ( $state == 'opened' ) {
				$classes[] = 'ui--accordion-state-opened'; 
			} elseif ( $state == 'static' ) {
				$classes[] = 'ui--accordion-state-opened ui--accordion-state-static'; 
			} else {
				$classes[] = 'ui--accordion-state-closed'; 
			}


			$hash = sanitize_html_class( $hash, "accordion-". $this->id ."-{$i}" );
			if ( !empty($hash) && ($hash[strlen($hash)-1] == '/') )
				 $hash .= '/';
			
			$classes[] = $hash;

			
			if ( empty($title) )
				$title = "Accordion Item {$i}";
			
			$title = html_entity_decode(stripcslashes($title)); 

			$this->contents .= "<div ".	cloudfw_make_class($classes, true) .">";

			$this->contents .= "<a href=\"#{$hash}\" class=\"ui--accordion-item-title heading\">";
			if ( $title_element ) {
				$this->contents .= "<$title_element>";
			}

			if ( ! empty( $icon_closed ) ) {
				$this->contents .= "<span class=\"ui--accordion-item-icon\">";
					$this->contents .= "<span class=\"ui--accordion-item-icon-closed\">";
						$this->contents .= $icon_closed;
					$this->contents .= "</span>";
					$this->contents .= "<span class=\"ui--accordion-item-icon-opened\">";
						$this->contents .= $icon_opened;
					$this->contents .= "</span>";
				$this->contents .= "</span>";
			}

			$this->contents .= "<span class=\"ui--accordion-item-title-text\">";
				$this->contents .= $title;
			$this->contents .= "</span>";

			if ( $title_element ) {
				$this->contents .= "</$title_element>";
			}
			$this->contents .= "</a>";

			$this->contents .= "<div class=\"ui--accordion-item-content\">";
			$this->contents .= do_shortcode( $content );
			$this->contents .= "</div>";
			
			$this->contents .= "</div>";


		}


		/** Skin map */
		function skin_map( $map ){
			$map  -> push    ( 'accent', '#page-wrap .ui--accordion-state-opened > .ui--accordion-item-title' );
			$map  -> push    ( 'accent_color_w_shadow', '#page-wrap .ui--accordion-state-opened > .ui--accordion-item-title, #page-wrap .ui--accordion-state-opened > .ui--accordion-item-title, #page-wrap .ui--accordion-state-opened > .ui--accordion-item-title:hover' );


			$map  -> id      ( 'accordions' )
			      -> selector( '#page-wrap .ui--accordion-state-opened > .ui--accordion-item-title' )
			      -> attr    ( 'gradient', array(), true );

			$map  -> id      ( 'accordions_item_border' )
			      -> selector( '#page-wrap .ui--accordion .ui--accordion-item-title, #page-wrap .ui--accordion .ui--accordion-item-content' )
			      -> attr    ( 'border-color', '', true );

			$map  -> id      ( 'accordions_opened_title' )
			      -> selector( '#page-wrap .ui--accordion-state-opened > .ui--accordion-item-title' )
			      -> attr    ( 'color', '', true )
			      -> pattern ( 'text-shadow', 
			                   '0 %direction%px 0 #%color%', 
			            array( 'color' => '', 'direction' => '-1' ) );

			$map  -> id      ( 'accordions_closed_title' )
			      -> selector( '#page-wrap .ui--accordion-state-closed > .ui--accordion-item-title' )
			      -> attr    ( 'color', '', true )
			      -> pattern ( 'text-shadow', 
			                   '0 %direction%px 0 #%color%', 
			            array( 'color' => '', 'direction' => '-1' ) );

			$map  -> id      ( 'accordions_closed_title_hover' )
			      -> selector( '#page-wrap .ui--accordion-state-closed > .ui--accordion-item-title:hover' )
			      -> attr    ( 'color', '', true )
			      -> pattern ( 'text-shadow', 
			                   '0 %direction%px 0 #%color%', 
			            array( 'color' => '', 'direction' => '-1' ) );


			$map  -> id      ( 'accordions_content' )
			      -> selector( '#page-wrap .ui--accordion .ui--accordion-item-content, #page-wrap .ui--accordion .ui--accordion-item-content p' )
			      -> attr    ( 'color', '', true );

			$map  -> id      ( 'accordions_content_link' )
			      -> selector( '#page-wrap .ui--accordion .ui--accordion-item-content a' )
			      -> attr    ( 'color', '', true )
			      -> attr    ( 'text-decoration' );

			$map  -> id      ( 'accordions_content_link_hover' )
			      -> selector( '#page-wrap .ui--accordion .ui--accordion-item-content a:hover' )
			      -> attr    ( 'color', '', true )
			      -> attr    ( 'text-decoration' );

		   
		    return $map;

		}


		/** Skin scheme */
		function skin_scheme( $schemes, $data ){
			return cloudfw_add_skin_scheme( 'shortcode',
				$schemes,
				array(
					'type'		=>	'module-set',
					'title'		=>	__('Accordions','cloudfw'),
					'closable'	=>	true,
					'state'		=>	'closed',
					'data'		=>	array(


						## Module Item
						array(
							'type'		=>	'module',
							'ucode'		=>	'ACCORDIONS',
							'title'		=>	__('Accordion Titles Separator Line Color','cloudfw'),
							'data'		=>	array(

								array(
									'type'		=>	'color',
									'style'		=>	'horizontal',
									'id'		=>	cloudfw_sanitize('accordions_item_border','border-color'),
									'value'		=>	$data['accordions_item_border']['border-color'],
								),
								
							)

						),

						## Module Item
						array(
							'type'		=>	'mini-section',
							'title'		=>	__('Accordion Titles (Opened State)','cloudfw'),
						),

						## Module Item
						array(
							'divider'	=>	false,
							'type'		=>	'module',
							'ucode'		=>	'ACCORDIONS',
							'title'		=>	__('Accordion Title Background','cloudfw'),
							'data'		=>	array(

								array(
									'type'		=>	'gradient',
									'id'		=>	cloudfw_sanitize('accordions','gradient'),
									'value'		=>	$data['accordions']['gradient'],
								),

							)

						),

						## Module Item
						array(
							'type'		=>	'module',
							'ucode'		=>	'ACCORDIONS',
							'title'		=>	__('Accordion Title Text Colors','cloudfw'),
							'layout'	=> 'float',
							'data'		=>	array(

									## Element
									array(
										'type'		=>	'color',
										'style'		=>	'horizontal',
										'title'		=>	__('Text Color','cloudfw'),
										'id'		=>	cloudfw_sanitize('accordions_opened_title','color'),
										'value'		=>	$data['accordions_opened_title']['color'],

									),

									## Element
									array(
										'type'		=>	'color',
										'style'		=>	'horizontal',
										'title'		=>	__('Text Shadow','cloudfw'),
										'id'		=>	cloudfw_sanitize('accordions_opened_title','text-shadow color'),
										'value'		=>	$data['accordions_opened_title']['text-shadow']['color'],

									),

									## Element
									array(
										'type'		=>	'select',
										'style'		=>	'horizontal',
										'title'		=>	__('Shadow Direction','cloudfw'),
										'id'		=>	cloudfw_sanitize('accordions_opened_title','text-shadow direction'),
										'value'		=>	$data['accordions_opened_title']['text-shadow']['direction'],
										'source'	=>	array(
											'-1'		=>	__('Top','cloudfw'),
											'1'			=>	__('Bottom','cloudfw'),
										),
										'width'		=>	120

									),

							)

						),

						## Module Item
						array(
							'type'		=>	'mini-section',
							'title'		=>	__('Accordion Titles (Closed State)','cloudfw'),
						),


						## Module Item
						array(
							'divider'	=>	false,
							'type'		=>	'module',
							'ucode'		=>	'TOGGLES',
							'title'		=>	__('Accordion Title','cloudfw'),
							'layout'	=> 'float',
							'data'		=>	array(

									## Element
									array(
										'type'		=>	'color',
										'style'		=>	'horizontal',
										'title'		=>	__('Text Color','cloudfw'),
										'id'		=>	cloudfw_sanitize('accordions_closed_title','color'),
										'value'		=>	$data['accordions_closed_title']['color'],

									),

									## Element
									array(
										'type'		=>	'color',
										'style'		=>	'horizontal',
										'title'		=>	__('Text Shadow','cloudfw'),
										'id'		=>	cloudfw_sanitize('accordions_closed_title','text-shadow color'),
										'value'		=>	$data['accordions_closed_title']['text-shadow']['color'],

									),

									## Element
									array(
										'type'		=>	'select',
										'style'		=>	'horizontal',
										'title'		=>	__('Shadow Direction','cloudfw'),
										'id'		=>	cloudfw_sanitize('accordions_closed_title','text-shadow direction'),
										'value'		=>	$data['accordions_closed_title']['text-shadow']['direction'],
										'source'	=>	array(
											'-1'		=>	__('Top','cloudfw'),
											'1'			=>	__('Bottom','cloudfw'),
										),
										'width'		=>	120

									),

							)

						),

						## Module Item
						array(
							'type'		=>	'module',
							'ucode'		=>	'TOGGLES',
							'title'		=>	__('Accordion Title Hover','cloudfw'),
							'layout'	=> 'float',
							'data'		=>	array(

									## Element
									array(
										'type'		=>	'color',
										'style'		=>	'horizontal',
										'title'		=>	__('Text Color','cloudfw'),
										'id'		=>	cloudfw_sanitize('accordions_closed_title_hover','color'),
										'value'		=>	$data['accordions_closed_title_hover']['color'],

									),


									## Element
									array(
										'type'		=>	'color',
										'style'		=>	'horizontal',
										'title'		=>	__('Text Shadow','cloudfw'),
										'id'		=>	cloudfw_sanitize('accordions_closed_title_hover','text-shadow color'),
										'value'		=>	$data['accordions_closed_title_hover']['text-shadow']['color'],

									),

									## Element
									array(
										'type'		=>	'select',
										'style'		=>	'horizontal',
										'title'		=>	__('Shadow Direction','cloudfw'),
										'id'		=>	cloudfw_sanitize('accordions_closed_title_hover','text-shadow direction'),
										'value'		=>	$data['accordions_closed_title_hover']['text-shadow']['direction'],
										'source'	=>	array(
											'-1'		=>	__('Top','cloudfw'),
											'1'			=>	__('Bottom','cloudfw'),
										),
										'width'		=>	120

									),

							)

						),

						## Module Item
						array(
							'type'		=>	'mini-section',
							'title'		=>	__('Accordion Contents','cloudfw'),
						),

						## Module Item
						array(
							'divider'	=>	false,
							'type'		=>	'module',
							'ucode'		=>	'ACCORDIONS',
							'title'		=>	__('Accordion Contents Color','cloudfw'),
							'layout'	=>	'float',
							'data'		=>	array(
								## Element
								array(
									'type'		=>	'color',
									'style'		=>	'horizontal',
									'title'		=>	__('Color','cloudfw'),
									'id'		=>	cloudfw_sanitize('accordions_content','color'),
									'value'		=>	$data['accordions_content']['color'],

								),

							)

						),
						## Module Item
						array(
							'type'		=>	'module',
							'ucode'		=>	'ACCORDIONS LINK',
							'title'		=>	__('Accordion Contents Link Colors','cloudfw'),
							'layout'	=>	'float',
							'data'		=>	array(
								## Element
								array(
									'type'		=>	'color',
									'style'		=>	'horizontal',
									'title'		=>	__('Color','cloudfw'),
									'id'		=>	cloudfw_sanitize('accordions_content_link','color'),
									'value'		=>	$data['accordions_content_link']['color'],

								),

								## Element
								array(
									'type'		=>	'color',
									'style'		=>	'horizontal',
									'title'		=>	__('Hover Color','cloudfw'),
									'id'		=>	cloudfw_sanitize('accordions_content_link_hover','color'),
									'value'		=>	$data['accordions_content_link_hover']['color'],

								),

								array(
									'type'		=>	'select',
									'ui'		=>	true,
									'width'		=>	120,
									'title'		=>	__('Text-Decoration','cloudfw'),
									'id'		=>	cloudfw_sanitize('accordions_content_link','text-decoration'),
									'value'		=>	$data['accordions_content_link']['text-decoration'],
									'source'	=>	array(
										'type'			=> 'function',
										'function'		=> 'cloudfw_admin_array_text_decorations',
									),
								),
								array(
									
									'type'		=>	'select',
									'ui'		=>	true,
									'width'		=>	120,
									'title'		=>	__('Text-Decoration Hover','cloudfw'),
									'id'		=>	cloudfw_sanitize('accordions_content_link_hover','text-decoration'),
									'value'		=>	$data['accordions_content_link_hover']['text-decoration'],
									'source'	=>	array(
										'type'			=> 'function',
										'function'		=> 'cloudfw_admin_array_text_decorations',
									),									
								)

							)

						),
															
					) // module set data
						
				)
				
			);

		}

		/** Typo map */
		function typo_map( $map ){
			cloudfw_add_typo_setting( $map, 'accordion_titles', '.ui--accordion-item-title');

		    return $map;
		}


		/** Typo Scheme */
		function typo_scheme( $scheme, $data, $number ){

			$scheme[ cloudfw_id_for_sequence( $scheme, $number ) ] = array(
				'type'			=>	'container',
				'width'			=>	940,
				'footer'		=>	false,
				'title'			=>	__('Accordions','cloudfw'),
				'data'			=>	array(
				
					array(
						'type'		=>	'typo-set',
						'title'		=>	__('Accordion Titles','cloudfw'),
						'id'		=>	cloudfw_sanitize('accordion_titles'),
						'value'		=>	$data['accordion_titles'],
						'data'		=>	array()
						
					),

				
				) 


			);

			return $scheme;


		}

	}

}


/**
****************************************************************
*/

cloudfw_register_shortcode( 'CloudFw_Composer_Accordions_Item' );
if ( ! class_exists('CloudFw_Composer_Accordions_Item') ) {
	class CloudFw_Composer_Accordions_Item extends CloudFw_Shortcodes {

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
					'title'				=> __('Accordion (Item)','cloudfw'),
					'column'			=> '1/1',
					'allow_columns'		=> false,
					'sync_title'		=> 'accordion_title',
					'in'				=> 'CloudFw_Composer_Accordions',
					'not_in'			=> 'CloudFw_Composer_Accordions_Item',
					'error_messages'	=> array(
						'in'				=> array(
							'CloudFw_Composer_Accordions' => array(
								'message' 	=> __('You can only add an accordion item into accordion group.','cloudfw')
							)
						),
						'not_in'			=> array(
							'CloudFw_Composer_Accordions_Item' => array(
								'message' 	=> __('You cannot add an accordion item inside another one. Please try to add it into the parent accordion group.','cloudfw')
							)
						),
					)
				)
			);
		}

		function shortcode( $atts, $content =  NULL, $case = NULL ) {
			return cloudfw_transfer_shortcode_attributes( 'accordion', $atts, $content );
		}

		/** Admin Scheme */
		function scheme() {
			return array(
				'script'	=> array(
					'attributes' 	=> array( 
						'title' 		=> array( 'e' => 'accordion_title' ),
						'state' 		=> array( 'e' => 'accordion_state' ),
						'hash' 			=> array( 'e' => 'accordion_hash' ),
						'content' 		=> array( 'e' => 'accordion_content' ),
					),

				),
				'data'		=>	array(


					array(
						'type'		=> 'module',
						'title'		=> __('State','cloudfw'),
						'data'		=> array(

							## Element
							array(
								'type'		=>	'select',
								'id'		=>	'accordion_state',
								'value'		=>	$this->get_value('accordion_state', 'closed'),
								'main_class'=>  'input input_250',
								'ui'		=>	true,
								'source'	=>	array(
									'opened' 		=> __('Opened','cloudfw'),
									'closed' 		=> __('Closed','cloudfw'),
									'static' 		=> __('Static (Always opened)','cloudfw'),
								)							
							), // #### element: 0

						)

					),

					array(
						'type'		=> 'module',
						'title'		=> __('Title','cloudfw'),
						'data'		=> array(

							## Element
							array(
								'type'		=>	'text',
								'id'		=>	'accordion_title',
								'value'		=>	$this->get_value('accordion_title', __('Accordion Title','cloudfw')),
								'_class'	=>  'input_150 accordion_title',
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
								'id'		=>	'accordion_hash',
								'value'		=>	$this->get_value('accordion_hash'),
								'desc'		=>	'Custom #hastag for the accordion item.',
								'width'		=>	'100'
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