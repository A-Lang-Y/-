<?php
/*
 * Plugin Name: Toogle
 * Plugin URI: http://cloudfw.net
 * Description: 
 * Version: 1.0
 * Author: Orkun Gürsel
 * Author URI: http://orkungursel.com
 * Shortcode:  [toggle]
 */
cloudfw_register_shortcode( 'CloudFw_Shortcode_Toggle', 'toggle', 'advanced' );
if ( ! class_exists('CloudFw_Shortcode_Toggle') ) {
	class CloudFw_Shortcode_Toggle extends CloudFw_Shortcodes {

		public $do_before = false;

		function get_called_class(){ return get_class($this); }


		/** Add the shortcode to the composer */
		function composer(){
			return array(
				'composer'		=> true,
				'ajax'			=> true,
				'droppable'		=> true,
				'icon'			=> 'toggles',
				'group'			=> 'composer_widgets',
				'line'			=> 240,
				'options'		=> array(
					'title'				=> __('Toggle','cloudfw'),
					'sync_title'		=> 'toggle_title',
					'column'			=> '1/1',
					'allow_columns'		=> true,
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


		/** Run */
		function shortcode( $atts = array(), $content =  NULL ) {
			extract(shortcode_atts(array(
				'id'             => '',
				'class'          => '',
				'device'         => '',
				'margin_top'     => '',
				'margin_bottom'  => '',
				'padding_top'    => '',
				'padding_bottom' => '',
				'title_element'  => 'span',
				'icons'			 =>	'fontawesome-plus/fontawesome-minus',
				'title'          => __('Toggle Title','cloudfw'),
				'state'        	 => 'opened',
				'group'          => NULL,

			), _check_onoff_false($atts)));

			$attributes = array();
			$classes = array();
			$classes[] = 'ui--toggle'; 
			$classes[] = 'ui--animation'; 
			$classes[] = 'clearfix'; 
			$classes[] = cloudfw_visible( $device ); 
			$classes[] = $class;

			if ( !empty($group) )
				$attributes['data-group'] = 'toggle-' . $group; 

			if ( $state == 'opened' ) {
				$classes[] = 'ui--toggle-state-opened'; 
			} else {
				$classes[] = 'ui--toggle-state-closed'; 
			}

			if ( empty($title_element) ) {
				$title_element = 'span';
			}

			if ( !empty($icons) )
				$icons = explode('/', $icons);


			if( empty($icons[0]) || empty($icons[1]) ) {
				$icons[0] = 'fontawesome-plus';
				$icons[1] = 'fontawesome-minus';
			}

			//$content = cloudfw_inline_format( $content );

			$out  = '';
			$out .= "<div ". 
				cloudfw_make_id( $id ) .
				cloudfw_make_class($classes, true) .
				cloudfw_make_style_attribute( array( 
					'margin-top'     => $margin_top,
					'margin-bottom'  => $margin_bottom,
					'padding-top'    => $padding_top,
					'padding-bottom' => $padding_bottom,
				), FALSE, TRUE ).
				cloudfw_make_attribute( $attributes, FALSE )
			.">";

				$out .= "<div class=\"ui--toggle-title\">";
					$out .= "<a href=\"javascript:;\">";
						
						$out .= "<span class=\"ui--toggle-icon\">";
							$out .= cloudfw_make_icon( 'Fontawesome/' . $icons[0], 'show-when-closed' );
							$out .= cloudfw_make_icon( 'Fontawesome/' . $icons[1], 'show-when-opened' );
							//$out .= "<i class=\"{$icons[0]} show-when-closed\"></i>";
							//$out .= "<i class=\"{$icons[1]} show-when-opened\"></i>";
						$out .= "</span>";

						$out .= "<{$title_element} class=\"ui--toggle-title-text heading\">";
							$out .= $title;
						$out .= "</{$title_element}>";

					$out .= "</a>";
				$out .= "</div>";

				$out .= "<div class=\"ui--toggle-content\">";
					$out .= $content;
				$out .= "</div>";
			$out .= "</div>";

			return $out; 

		}

		/** Scheme */
		function scheme() {
			return array(
				'title'		=>	__('Toggle','cloudfw'),
				'script'	=> array(
					'shortcode'  => 'toggle',
					'tag_close'  => true,
					'attributes' =>	array( 
						'title' 		=> array( 'e' => 'toggle_title', 'required' => __('Please insert a title text','cloudfw') ),
						'state' 		=> array( 'e' => 'toggle_state' ),
						'icons' 		=> array( 'e' => 'toggle_icons' ),
						'group' 		=> array( 'e' => 'toggle_group' ),
						'content' 		=> array( 'e' => 'toggle_content', 'default' => __('Content','cloudfw') ),
						'device'        => array( 'e' => 'the_device' ),
						'margin_top'    => array( 'e' => 'margin_top' ),
						'margin_bottom' => array( 'e' => 'margin_bottom' ),
					)
				),
				'data'		=>  $this->load_scheme( __FILE__ )

			);

		}


		/** Skin map */
		function skin_map( $map ){
			$map  -> push    ( 'accent', '#page-content .ui--toggle-state-closed > .ui--toggle-title .ui--toggle-icon' );
			$map  -> push    ( 'accent', '#page-content .ui--toggle-state-opened > .ui--toggle-title' );
			$map  -> push    ( 'accent_color_w_shadow', '#page-content .ui--toggle-state-closed > .ui--toggle-title .ui--toggle-icon' );
			$map  -> push    ( 'accent_color_w_shadow', '#page-content .ui--toggle-state-opened > .ui--toggle-title, #page-content .ui--toggle-state-opened > .ui--toggle-title a, #page-content .ui--toggle-state-opened > .ui--toggle-title a:hover' );

			$map  -> id      ( 'toggles' )
			      -> selector( '#page-content .ui--toggle-state-closed > .ui--toggle-title .ui--toggle-icon, #page-content .ui--toggle-state-opened > .ui--toggle-title' )
			      -> attr    ( '+border', '', true )
			      -> attr    ( 'gradient', array(), true );

			$map  -> id      ( 'toggles_opened_title' )
			      -> selector( '#page-content .ui--toggle-state-closed > .ui--toggle-title .ui--toggle-icon, #page-content .ui--toggle-state-opened > .ui--toggle-title, #page-content .ui--toggle-state-opened > .ui--toggle-title a, #page-content .ui--toggle-state-opened > .ui--toggle-title a:hover' )
			      -> attr    ( 'color', '', true )
			      -> pattern ( 'text-shadow', 
			                   '0 %direction%px 0 #%color%', 
			            array( 'color' => '', 'direction' => '-1' ) );

			$map  -> id      ( 'toggles_closed_title' )
			      -> selector( '#page-content .ui--toggle-state-closed > .ui--toggle-title, #page-content .ui--toggle-state-closed > .ui--toggle-title a, #page-content .ui--toggle-state-closed > .ui--toggle-title a:hover' )
			      -> attr    ( 'color', '', true );

			$map  -> id      ( 'toggles_closed_title_hover' )
			      -> selector( '#page-content .ui--toggle-state-closed > .ui--toggle-title a:hover' )
			      -> attr    ( 'color', '', true );

		    return $map;

		}

		/** Skin scheme */
		function skin_scheme( $schemes, $data ){
			return cloudfw_add_skin_scheme( 'shortcode',
				$schemes,
				array(
					'type'		=>	'module-set',
					'title'		=>	__('Toggles','cloudfw'),
					'closable'	=>	true,
					'state'		=>	'closed',
					'data'		=>	array(


						## Module Item
						array(
							'type'		=>	'module',
							'ucode'		=>	'TOGGLES',
							'title'		=>	array(__('Title & Icon Background','cloudfw'), __('Border Color','cloudfw')),
							'layout'	=> 'split',
							'data'		=>	array(

								array(
									'type'		=>	'gradient',
									'id'		=>	cloudfw_sanitize('toggles','gradient'),
									'value'		=>	$data['toggles']['gradient'],
								),

								array(
									'type'		=>	'color',
									'style'		=>	'horizontal',
									'id'		=>	cloudfw_sanitize('toggles','+border'),
									'value'		=>	$data['toggles']['+border'],
								),
								
							)

						),

						## Module Item
						array(
							'type'		=>	'mini-section',
							'title'		=>	__('Toggle Titles (Opened State)','cloudfw'),
						),


						## Module Item
						array(
							'divider'	=>	false,
							'type'		=>	'module',
							'ucode'		=>	'TOGGLES',
							'title'		=>	__('Toggle Title','cloudfw'),
							'layout'	=> 'float',
							'data'		=>	array(

									## Element
									array(
										'type'		=>	'color',
										'style'		=>	'horizontal',
										'title'		=>	__('Text Color','cloudfw'),
										'id'		=>	cloudfw_sanitize('toggles_opened_title','color'),
										'value'		=>	$data['toggles_opened_title']['color'],

									),

									## Element
									array(
										'type'		=>	'color',
										'style'		=>	'horizontal',
										'title'		=>	__('Text Shadow','cloudfw'),
										'id'		=>	cloudfw_sanitize('toggles_opened_title','text-shadow color'),
										'value'		=>	$data['toggles_opened_title']['text-shadow']['color'],

									),

									## Element
									array(
										'type'		=>	'select',
										'style'		=>	'horizontal',
										'title'		=>	__('Shadow Direction','cloudfw'),
										'id'		=>	cloudfw_sanitize('toggles_opened_title','text-shadow direction'),
										'value'		=>	$data['toggles_opened_title']['text-shadow']['direction'],
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
							'title'		=>	__('Toggle Titles (Closed State)','cloudfw'),
						),


						## Module Item
						array(
							'divider'	=>	false,
							'type'		=>	'module',
							'ucode'		=>	'TOGGLES',
							'title'		=>	__('Toggle Title','cloudfw'),
							'layout'	=> 'float',
							'data'		=>	array(

									## Element
									array(
										'type'		=>	'color',
										'style'		=>	'horizontal',
										'title'		=>	__('Text Color','cloudfw'),
										'id'		=>	cloudfw_sanitize('toggles_closed_title','color'),
										'value'		=>	$data['toggles_closed_title']['color'],

									),

							)

						),

						## Module Item
						array(
							'type'		=>	'module',
							'ucode'		=>	'TOGGLES',
							'title'		=>	__('Toggle Title Hover','cloudfw'),
							'layout'	=> 'float',
							'data'		=>	array(

									## Element
									array(
										'type'		=>	'color',
										'style'		=>	'horizontal',
										'title'		=>	__('Text Color','cloudfw'),
										'id'		=>	cloudfw_sanitize('toggles_closed_title_hover','color'),
										'value'		=>	$data['toggles_closed_title_hover']['color'],

									),

							)

						),

															
					) // module set data
						
				)
				
			);

		}


		/** Typo map */
		function typo_map( $map ){
			cloudfw_add_typo_setting( $map, 'toggle_titles', '.ui--toggle-title-text');

		    return $map;
		}


		/** Typo Scheme */
		function typo_scheme( $scheme, $data, $number ){

			$scheme[ cloudfw_id_for_sequence( $scheme, $number ) ] = array(
				'type'			=>	'container',
				'width'			=>	940,
				'footer'		=>	false,
				'title'			=>	__('Toggles','cloudfw'),
				'data'			=>	array(
				
					array(
						'type'		=>	'typo-set',
						'title'		=>	__('Toggle Titles','cloudfw'),
						'id'		=>	cloudfw_sanitize('toggle_titles'),
						'value'		=>	$data['toggle_titles'],
						'data'		=>	array()
						
					),

				
				) 


			);

			return $scheme;


		}


	}

}