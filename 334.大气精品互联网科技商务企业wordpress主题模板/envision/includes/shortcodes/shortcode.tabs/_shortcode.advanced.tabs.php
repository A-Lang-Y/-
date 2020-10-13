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

cloudfw_register_shortcode( 'CloudFw_Shortcode_Tabs' );
if ( ! class_exists('CloudFw_Shortcode_Tabs') ) {
	class CloudFw_Shortcode_Tabs extends CloudFw_Shortcodes {
		function get_called_class(){ return get_class($this); }

		var $id	= 0;
		var $child	= array();
		var $total	= array();
		var $atts	= array();
		var $header	= array();
		var $footer	= array();
		var $titles	= array();
		var $content= array();

		/**
		 *	Add
		 */
		function add() {
			return array(
				'tabs_mega'		=> array( &$this, 'register_tabs_mega' ),
				'tabs' 			=> array( &$this, 'register_tabs_mini' ),
				'tabs_vertical' => array( &$this, 'register_tabs_mini_vertical' ),
				'tab' 			=> array( &$this, 'register_tab_item' ),
			);
		}


		function register_tabs_mega($atts, $content =  NULL, $case = NULL){

			if ( !isset($this->id) )
				$this->id = 0;

			$this->id++;
		
			$this->atts[ $this->id ] = shortcode_atts(array(
				'title_element'  => 'h5',
				'id'             => '',
				'class'          => '',
				'device'         => '',
				'margin_top'     => '',
				'margin_bottom'  => '',
				'align'			 => 'center',
			), $atts); 

			extract( $this->atts[ $this->id ] );


			$this->child[ $this->id ] = 0;
			$this->total[ $this->id ] = 0;
			$this->header[ $this->id ] = '';
			$this->titles[ $this->id ] = '';
			$this->footer[ $this->id ] = '';
			$this->contents[ $this->id ] = '';
			$this->total[ $this->id ] = count(explode("[tab",$content)) - 1;

			$classes = array();
			$classes[] = 'ui--tabs';
			$classes[] = 'ui--tabs-mega';
			$classes[] = 'clearfix';

			$classes[] = cloudfw_visible( $device ); 
			$classes[] = $class;

			if ( !empty($align) )
				$classes[] = 'text-' . $align;

			do_shortcode($content);

			$this->header[ $this->id ]  = "<div ". 
				cloudfw_make_id( $id ) .
				cloudfw_make_class($classes, true) .
				cloudfw_make_style_attribute( array( 
					'margin-top'     => $margin_top,
					'margin-bottom'  => $margin_bottom,
				), FALSE, TRUE )

			.">";
				$this->header[ $this->id ] .= "<div class=\"ui--tabs-header ui--accent-gradient ui--accent-color fullwidth-container clearfix\">";
						$this->header[ $this->id ] .= "<div class=\"container\">";
						$this->header[ $this->id ] .= "<ul class=\"ui--tabs-titles clearfix unstyled\">";
							$this->header[ $this->id ] .= $this->titles[ $this->id ];
						$this->header[ $this->id ] .= "</ul>";
					$this->header[ $this->id ] .= "</div>";
				$this->header[ $this->id ] .= "</div>";

			if ( $this->contents[ $this->id ] ) {
				$this->contents[ $this->id ] = "<div class=\"clearfix\"></div><ul class=\"ui--tabs-contents text-left clearfix\">".$this->contents[ $this->id ]."</ul>";
			}

			/** Define the Tab Footer */
			$this->footer[ $this->id ] = "</div>";

			$out = 	$this->header[ $this->id ] . 
				 	$this->contents[ $this->id ] . 
				 	$this->footer[ $this->id ];

			unset($this->header[ $this->id ]);
			unset($this->titles[ $this->id ]);
			unset($this->contents[ $this->id ]);
			unset($this->footer[ $this->id ]);

			return $out; 
		}



		/**
		 *	Mini Style
		 */
		function register_tabs_mini($atts, $content =  NULL, $case = NULL){

			if ( !isset($this->id) )
				$this->id = 0;

			$this->id++;
		
			$this->atts[ $this->id ] = shortcode_atts(array(
				'title_element'  => 'h5',
				'id'             => '',
				'class'          => '',
				'device'         => '',
				'margin_top'     => '',
				'margin_bottom'  => '',
				'align'			 => 'center',
			), $atts); 

			extract( $this->atts[ $this->id ] );


			$this->child[ $this->id ] = 0;
			$this->total[ $this->id ] = 0;
			$this->header[ $this->id ] = '';
			$this->titles[ $this->id ] = '';
			$this->footer[ $this->id ] = '';
			$this->contents[ $this->id ] = '';
			$this->total[ $this->id ] = count(explode("[tab",$content)) - 1;

			$classes = array();
			$classes[] = 'ui--tabs';
			$classes[] = 'ui--tabs-mini';
			$classes[] = 'ui--tabs-mini-horizontal';
			$classes[] = 'clearfix';

			$classes[] = cloudfw_visible( $device ); 
			$classes[] = $class;

			if ( !empty($align) )
				$classes[] = 'text-' . $align;

			do_shortcode($content);

			$this->header[ $this->id ]  = "<div ". 
				cloudfw_make_id( $id ) .
				cloudfw_make_class($classes, true) .
				cloudfw_make_style_attribute( array( 
					'margin-top'     => $margin_top,
					'margin-bottom'  => $margin_bottom,
				), FALSE, TRUE )

			.">";
				$this->header[ $this->id ] .= "<div class=\"ui--tabs-header clearfix\">";
				$this->header[ $this->id ] .= "<div class=\"ui--tabs-header-holder\">";
				$this->header[ $this->id ] .= "<div class=\"ui--tabs-border-before\"></div>";
				$this->header[ $this->id ] .= "<div class=\"ui--tabs-border-after\"></div>";
					$this->header[ $this->id ] .= "<ul class=\"ui--tabs-titles clearfix unstyled\">";
						$this->header[ $this->id ] .= $this->titles[ $this->id ];
					$this->header[ $this->id ] .= "</ul>";
				$this->header[ $this->id ] .= "</div>";
				$this->header[ $this->id ] .= "</div>";

			if ( $this->contents[ $this->id ] ) {
				$this->contents[ $this->id ] = "<div class=\"clearfix\"></div><ul class=\"ui--tabs-contents text-left clearfix\">".$this->contents[ $this->id ]."</ul>";
			}

			/** Define the Tab Footer */
			$this->footer[ $this->id ] = "</div>";

			$out = 	$this->header[ $this->id ] . 
				 	$this->contents[ $this->id ] . 
				 	$this->footer[ $this->id ];

			unset($this->header[ $this->id ]);
			unset($this->titles[ $this->id ]);
			unset($this->contents[ $this->id ]);
			unset($this->footer[ $this->id ]);

			return $out; 
		}


		/**
		 *	Mini Vertical Style
		 */
		function register_tabs_mini_vertical($atts, $content =  NULL, $case = NULL){

			if ( !isset($this->id) )
				$this->id = 0;

			$this->id++;
		
			$this->atts[ $this->id ] = shortcode_atts(array(
				'position'  	 => 'left',
				'title_element'  => 'h5',
				'id'             => '',
				'class'          => '',
				'device'         => '',
				'margin_top'     => '',
				'margin_bottom'  => '',
			), $atts); 

			extract( $this->atts[ $this->id ] );


			$this->child[ $this->id ] = 0;
			$this->total[ $this->id ] = 0;
			$this->header[ $this->id ] = '';
			$this->titles[ $this->id ] = '';
			$this->footer[ $this->id ] = '';
			$this->contents[ $this->id ] = '';
			$this->total[ $this->id ] = count(explode("[tab",$content)) - 1;

			$classes = array();
			$classes[] = 'ui--tabs';
			$classes[] = 'ui--tabs-mini ui--tabs-mini-vertical';
			$classes[] = 'ui-row';
			$classes[] = cloudfw( 'row_class' );
			$classes[] = 'clearfix';

			$classes[] = cloudfw_visible( $device ); 
			$classes[] = 'position--' . $position;
			$classes[] = $class;

			do_shortcode($content);

			$this->header[ $this->id ]  = "<div ". 
				cloudfw_make_id( $id ) .
				cloudfw_make_class($classes, true) .
				cloudfw_make_style_attribute( array( 
					'margin-top'     => $margin_top,
					'margin-bottom'  => $margin_bottom,
				), FALSE, TRUE )

			.">";
				$this->header[ $this->id ] .= "<div class=\"ui--tabs-header span3 clearfix\">";
				$this->header[ $this->id ] .= "<div class=\"ui--tabs-border-top\"></div>";
				$this->header[ $this->id ] .= "<div class=\"ui--tabs-border-bottom\"></div>";
						$this->header[ $this->id ] .= "<div class=\"\">";
						$this->header[ $this->id ] .= "<ul class=\"ui--tabs-titles clearfix unstyled\">";
							$this->header[ $this->id ] .= $this->titles[ $this->id ];
						$this->header[ $this->id ] .= "</ul>";
					$this->header[ $this->id ] .= "</div>";
				$this->header[ $this->id ] .= "</div>";

			if ( $this->contents[ $this->id ] ) {
				$this->contents[ $this->id ] = "<ul class=\"ui--tabs-contents span9 text-left clearfix\">".$this->contents[ $this->id ]."</ul>";
			}

			/** Define the Tab Footer */
			$this->footer[ $this->id ] = "</div>";

			$out = 	$this->header[ $this->id ] . 
				 	$this->contents[ $this->id ] . 
				 	$this->footer[ $this->id ];

			unset($this->header[ $this->id ]);
			unset($this->titles[ $this->id ]);
			unset($this->contents[ $this->id ]);
			unset($this->footer[ $this->id ]);

			return $out; 
		}


		/*
		 *	Shortcode: 	 [tab]
		 */
		function register_tab_item($atts, $tab_content =  NULL){
			extract(shortcode_atts(array(
				'title'				=> '',
				'icon'				=> '',
				'hash'				=> '',
			), $atts));

			if ( !isset($this->child[ $this->id ]) )
				$this->child[ $this->id ] = 0;

			$this->child[ $this->id ]++;

			extract($this->atts[ $this->id ]);

			$i = $this->child[ $this->id ]; 
			$tabs_count = $this->total[ $this->id ]; 

			$icon = cloudfw_make_icon($icon, 'ui--icon');

			$hash = sanitize_html_class( $hash, "tab-". $this->id ."-{$i}" );
			if ( !empty($hash) && ($hash[strlen($hash)-1] == '/') )
				 $hash .= '/';

			if ( empty($title) && empty($icon) )
				$title = "Tab {$i}";


			$title = html_entity_decode(stripcslashes($title)); 

			$this->titles[ $this->id ] .= "<li class=\"";
			if ( empty($title) ) {
				$this->titles[ $this->id ] .= ' empty-title';
			}

			$this->titles[ $this->id ] .= "\">";
			if ( $title_element ) {
				$this->titles[ $this->id ] .= "<$title_element>";
			}

				$this->titles[ $this->id ] .= "<a href=\"#{$hash}\">{$icon}{$title}</a>";

			if ( $title_element ) {
				$this->titles[ $this->id ] .= "</$title_element>";
			}
			$this->titles[ $this->id ] .= "</li>";

		
			$tab_content = do_shortcode($tab_content);
			$this->contents[ $this->id ] .= "<li class=\"hidden\">";
			$this->contents[ $this->id ] .= "{$tab_content}</li>";

		}


		/** Skin map */
		function skin_map( $map ){
			$map  -> push( 'accent_color_w_shadow', '#page-wrap .ui--tabs-mega .ui--tabs-titles > li a' );
			$map  -> id      ( 'mini_tab_active_item_border' )
			      -> selector( '#page-wrap .ui--tabs-mini-horizontal > .ui--tabs-header .ui--tabs-titles > li.active a, #page-wrap .ui--tabs-mini-horizontal > .ui--tabs-header .ui--tabs-titles > li.active a:hover' )
			      -> sync    ( 'border-top-color', 'accent', array( 'gradient', 1 ), true );

			$map  -> id      ( 'mini_vertical_tab_active_item_border' )
			      -> selector( '#page-wrap .ui--tabs-mini-vertical > .ui--tabs-header .ui--tabs-titles > li.active a, #page-wrap .ui--tabs-mini-vertical > .ui--tabs-header .ui--tabs-titles > li.active a:hover' )
			      -> sync    ( 'border-left-color', 'accent', array( 'gradient', 1 ), true );

			$map  -> id      ( 'mini_vertical_tab_active_item_border' )
			      -> selector( '#page-wrap .ui--tabs-mini-vertical.position--right > .ui--tabs-header .ui--tabs-titles > li.active a, #page-wrap .ui--tabs-mini-vertical.position--right > .ui--tabs-header .ui--tabs-titles > li.active a:hover' )
			      -> sync    ( 'border-right-color', 'accent', array( 'gradient', 1 ), true );




			$map  -> id      ( 'tabs_mega' )
			      -> selector( '#page-wrap .ui--tabs-mega > .ui--tabs-header' )
			      -> attr    ( 'gradient', array(), true );

			$map  -> id      ( 'tabs_mega_title_passive' )
			      -> selector( '#page-wrap .ui--tabs-mega > .ui--tabs-header .ui--tabs-titles > li a, #page-wrap .ui--tabs-mega > .ui--tabs-header .ui--tabs-titles > li a:hover' )
			      -> attr    ( 'color', '' )
			      -> pattern ( 'text-shadow', 
			                   '0 %direction%px 0 #%color%', 
			            array( 'color' => '', 'direction' => '-1' ) );

			$map  -> id      ( 'tabs_mega_title_passive_hover' )
			      -> selector( '#page-wrap .ui--tabs-mega > .ui--tabs-header .ui--tabs-titles > li a:hover' )
			      -> attr    ( 'color', '' )
			      -> pattern ( 'text-shadow', 
			                   '0 %direction%px 0 #%color%', 
			            array( 'color' => '', 'direction' => '-1' ) );

			$map  -> id      ( 'tabs_mega_title_active' )
			      -> selector( '#page-wrap .ui--tabs-mega > .ui--tabs-header .ui--tabs-titles > li.active a, #page-wrap .ui--tabs-mega > .ui--tabs-header .ui--tabs-titles > li.active a:hover' )
			      -> attr    ( 'color', '', true );
			      



			$map  -> id      ( 'tabs_mini' )
			      -> selector( '#page-wrap .ui--tabs-mini-horizontal > .ui--tabs-header .ui--tabs-titles > li.active a, #page-wrap .ui--tabs-mini-horizontal > .ui--tabs-header .ui--tabs-titles > li.active a:hover, #page-wrap .ui--tabs-mini-horizontal > .ui--tabs-header .ui--tabs-border-before, #page-wrap .ui--tabs-mini-horizontal > .ui--tabs-header .ui--tabs-border-after' )
			      -> attr    ( 'border-color', '', true );

			$map  -> id      ( 'tabs_mini_active' )
			      -> selector( '#page-wrap .ui--tabs-mini-horizontal > .ui--tabs-header .ui--tabs-titles > li.active a, #page-wrap .ui--tabs-mini-horizontal > .ui--tabs-header .ui--tabs-titles > li.active a:hover' )
			      -> attr    ( 'color', '' )
			      -> attr    ( 'border-top-color', '', true );

			$map  -> id      ( 'tabs_mini_vertical' )
			      -> selector( '#page-wrap .ui--tabs-mini-vertical > .ui--tabs-header .ui--tabs-titles > li.active a, #page-wrap .ui--tabs-mini-vertical > .ui--tabs-header .ui--tabs-titles > li.active a:hover, #page-wrap .ui--tabs-mini-vertical > .ui--tabs-header .ui--tabs-border-top, #page-wrap .ui--tabs-mini-vertical > .ui--tabs-header .ui--tabs-border-bottom' )
			      -> sync    ( 'border-color', 'tabs_mini', 'border-color', true );

			$map  -> id      ( 'tabs_mini_vertical_left_active' )
			      -> selector( '#page-wrap .ui--tabs-mini-vertical > .ui--tabs-header .ui--tabs-titles > li.active a, #page-wrap .ui--tabs-mini-vertical > .ui--tabs-header .ui--tabs-titles > li.active a:hover, #page-wrap .ui--tabs-mini-vertical.position--right > .ui--tabs-header .ui--tabs-titles > li.active a, #page-wrap .ui--tabs-mini-vertical.position--right > .ui--tabs-header .ui--tabs-titles > li.active a:hover' )
			      -> sync    ( 'border-left-color', 'tabs_mini_active', 'border-top-color', true );

			$map  -> id      ( 'tabs_mini_vertical_right_active' )
			      -> selector( '#page-wrap .ui--tabs-mini-vertical.position--right > .ui--tabs-header .ui--tabs-titles > li.active a, #page-wrap .ui--tabs-mini-vertical.position--right > .ui--tabs-header .ui--tabs-titles > li.active a:hover' )
			      -> sync    ( 'border-right-color', 'tabs_mini_active', 'border-top-color', true );


			$map  -> id      ( 'tabs_mini_title_passive' )
			      -> selector( '#page-wrap .ui--tabs-mini > .ui--tabs-header .ui--tabs-titles > li a, #page-wrap .ui--tabs-mini > .ui--tabs-header .ui--tabs-titles > li a:hover' )
			      -> attr    ( 'color', '' );

			$map  -> id      ( 'tabs_mini_title_passive_hover' )
			      -> selector( '#page-wrap .ui--tabs-mini > .ui--tabs-header .ui--tabs-titles > li a:hover' )
			      -> attr    ( 'color', '' );

			$map  -> id      ( 'tabs_mini_title_active' )
			      -> selector( '#page-wrap .ui--tabs-mini > .ui--tabs-header .ui--tabs-titles > li.active a, #page-wrap .ui--tabs-mini > .ui--tabs-header .ui--tabs-titles > li.active a:hover' )
			      -> attr    ( 'color', '', true );

		    return $map;

		}


		/** Skin scheme */
		function skin_scheme( $schemes, $data ){
			return cloudfw_add_skin_scheme( 'shortcode',
				$schemes,
				array(
					'type'		=>	'module-set',
					'title'		=>	__('Tabs','cloudfw'),
					'closable'	=>	true,
					'state'		=>	'closed',
					'layout'	=>	'subtab',
					'data'		=>	array(


						## SubTab Item
						array(
							'type'		=>	'tabs',
							'tab_id' 	=>	'tab:tab-mega',
							'tab_title' =>	__('Mega Tabs','cloudfw'),
							'data'		=>	array(

								## Module Item
								array(
									'type'		=>	'module',
									'ucode'		=>	'TABS',
									'title'		=>	__('Background','cloudfw'),
									'data'		=>	array(

										array(
											'type'		=>	'gradient',
											'id'		=>	cloudfw_sanitize('tabs_mega','gradient'),
											'value'		=>	$data['tabs_mega']['gradient'],
										),
										
									)

								),

								## Module Item
								array(
									'type'		=>	'mini-section',
									'title'		=>	__('Titles','cloudfw'),
								),

								## Module Item
								array(
									'divider'	=>	false,
									'type'		=>	'module',
									'ucode'		=>	'TABS',
									'title'		=>	__('Tab Title','cloudfw'),
									'layout'	=> 'float',
									'data'		=>	array(

											## Element
											array(
												'type'		=>	'color',
												'style'		=>	'horizontal',
												'title'		=>	__('Text Color','cloudfw'),
												'id'		=>	cloudfw_sanitize('tabs_mega_title_passive','color'),
												'value'		=>	$data['tabs_mega_title_passive']['color'],

											),

											## Element
											array(
												'type'		=>	'color',
												'style'		=>	'horizontal',
												'title'		=>	__('Text Shadow','cloudfw'),
												'id'		=>	cloudfw_sanitize('tabs_mega_title_passive','text-shadow color'),
												'value'		=>	$data['tabs_mega_title_passive']['text-shadow']['color'],

											),

											## Element
											array(
												'type'		=>	'select',
												'style'		=>	'horizontal',
												'title'		=>	__('Shadow Direction','cloudfw'),
												'id'		=>	cloudfw_sanitize('tabs_mega_title_passive','text-shadow direction'),
												'value'		=>	$data['tabs_mega_title_passive']['text-shadow']['direction'],
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
									'ucode'		=>	'TABS',
									'title'		=>	__('Tab Title Hover','cloudfw'),
									'layout'	=> 'float',
									'data'		=>	array(

											## Element
											array(
												'type'		=>	'color',
												'style'		=>	'horizontal',
												'title'		=>	__('Text Color','cloudfw'),
												'id'		=>	cloudfw_sanitize('tabs_mega_title_passive_hover','color'),
												'value'		=>	$data['tabs_mega_title_passive_hover']['color'],

											),

											## Element
											array(
												'type'		=>	'color',
												'style'		=>	'horizontal',
												'title'		=>	__('Text Shadow','cloudfw'),
												'id'		=>	cloudfw_sanitize('tabs_mega_title_passive_hover','text-shadow color'),
												'value'		=>	$data['tabs_mega_title_passive_hover']['text-shadow']['color'],

											),

											## Element
											array(
												'type'		=>	'select',
												'style'		=>	'horizontal',
												'title'		=>	__('Shadow Direction','cloudfw'),
												'id'		=>	cloudfw_sanitize('tabs_mega_title_passive_hover','text-shadow direction'),
												'value'		=>	$data['tabs_mega_title_passive_hover']['text-shadow']['direction'],
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
									'ucode'		=>	'TABS',
									'title'		=>	__('Active Tab Title','cloudfw'),
									'data'		=>	array(

										array(
											'type'		=>	'color',
											'style'		=>	'horizontal',
											'id'		=>	cloudfw_sanitize('tabs_mega_title_active','color'),
											'value'		=>	$data['tabs_mega_title_active']['color'],
										),
										
									)

								),

							)

						),

						## SubTab Item
						array(
							'type'		=>	'tabs',
							'tab_id' 	=>	'tab:tab-mini',
							'tab_title' =>	__('Mini Tabs','cloudfw'),
							'data'		=>	array(

								## Module Item
								array(
									'type'		=>	'module',
									'layout'	=>	'split',
									'ucode'		=>	'TABS',
									'title'		=>	array(__('Tab Title Border Color','cloudfw'), __('Active Item Border Color','cloudfw')),
									'data'		=>	array(

										array(
											'type'		=>	'color',
											'id'		=>	cloudfw_sanitize('tabs_mini','border-color'),
											'value'		=>	$data['tabs_mini']['border-color'],
										),

										array(
											'type'		=>	'color',
											'id'		=>	cloudfw_sanitize('tabs_mini_active','border-top-color'),
											'value'		=>	$data['tabs_mini_active']['border-top-color'],
										),
										
									)

								),

								## Module Item
								array(
									'type'		=>	'mini-section',
									'title'		=>	__('Titles','cloudfw'),
								),

								## Module Item
								array(
									'divider'	=>	false,
									'type'		=>	'module',
									'ucode'		=>	'TABS',
									'title'		=>	__('Tab Title','cloudfw'),
									'layout'	=> 'float',
									'data'		=>	array(

											## Element
											array(
												'type'		=>	'color',
												'style'		=>	'horizontal',
												'title'		=>	__('Text Color','cloudfw'),
												'id'		=>	cloudfw_sanitize('tabs_mini_title_passive','color'),
												'value'		=>	$data['tabs_mini_title_passive']['color'],

											),

									)

								),

								## Module Item
								array(
									'type'		=>	'module',
									'ucode'		=>	'TABS',
									'title'		=>	__('Tab Title Hover','cloudfw'),
									'layout'	=> 'float',
									'data'		=>	array(

											## Element
											array(
												'type'		=>	'color',
												'style'		=>	'horizontal',
												'title'		=>	__('Text Color','cloudfw'),
												'id'		=>	cloudfw_sanitize('tabs_mini_title_passive_hover','color'),
												'value'		=>	$data['tabs_mini_title_passive_hover']['color'],

											),

									)

								),


								## Module Item
								array(
									'type'		=>	'module',
									'ucode'		=>	'TABS',
									'title'		=>	__('Active Tab Title','cloudfw'),
									'data'		=>	array(

										array(
											'type'		=>	'color',
											'style'		=>	'horizontal',
											'id'		=>	cloudfw_sanitize('tabs_mini_title_active','color'),
											'value'		=>	$data['tabs_mini_title_active']['color'],
										),
										
									)

								),

							)

						),
															
					)
						
				), 
				20 //seq
				
			);

		}



	}

}