<?php
/*
 * Plugin Name: Google Maps
 * Plugin URI: http://cloudfw.net
 * Description: 
 * Version: 1.0
 * Author: Orkun Gürsel
 * Author URI: http://orkungursel.com
 * Shortcode:  [gmap]
 */

add_action('cloudfw_javascript', 'cloudfw_javascript_gmap');
function cloudfw_javascript_gmap(){
	global $pagenow;

	$schema = is_ssl() ? 'https://' : 'http://';
	$language_code = cloudfw_get_current_language();
	$api_key = cloudfw_get_option('apis', 'gmap');

	if ( ! empty( $api_key ) ) {
		wp_register_script ('theme-gmap-api', $schema . 'maps.googleapis.com/maps/api/js?v=3.14&key='. $api_key .'&sensor=false&language=' . $language_code,  array(), NULL );
	} else {
		wp_register_script ('theme-gmap-api', $schema . 'maps.googleapis.com/maps/api/js?v=3.14&sensor=false&language=' . $language_code,  array(), NULL );
	}
	wp_register_script ('theme-gmap',  cloudfw_relative_path( dirname(__FILE__) ).'/js/gmap.js', array( 'theme-gmap-api' ), cloudfw_get_combined_version(), false);

    if ( !(isset($pagenow) && $pagenow == 'wp-login.php') ) {
    	//wp_enqueue_script ('theme-gmap-api');
    }
}

cloudfw_register_shortcode( 'CloudFw_Shortcode_Gmap', NULL, 'advanced', 45 );
if ( ! class_exists('CloudFw_Shortcode_Gmap') ) {
	class CloudFw_Shortcode_Gmap extends CloudFw_Shortcodes {
		
		public $do_before = false;
		var $id	= 0;
		var $child	= 0;
		var $total	= array();
		var $atts	= array();
		var $markers= array();
		var $parent_shortcode 	= 'gmap'; 
		var $children_shortcode = 'gmap_marker'; 

		function get_called_class(){ return get_class($this); }

		/** Add the shortcode to the composer */
		function composer(){
			return array(
				'composer'		=> true,
				'ajax'			=> true,
				'droppable'		=> true,
				'icon'			=> 'map',
				'group'			=> 'composer_widgets',
				'line'			=> 330,
				'options'		=> array(
					'title'				=> __('Google Map','cloudfw'),
					'column'			=> '1/1',
					'allow_columns'		=> true,
					'allow_edit'		=> true,
					'not_in'			=> array('CloudFw_Shortcode_Gmap', 'CloudFw_Shortcode_Gmap_Marker'),
					'allow_only'		=> array('CloudFw_Shortcode_Gmap_Marker'),
				)
			);
		}

		/**
		 *	Add
		 */
		function add() {
			return array(
				$this->parent_shortcode		=> array( &$this, 'register_map' ),
				$this->children_shortcode	=> array( &$this, 'register_marker' ),
			);
		}

		/** Shortcode */
		function shortcode( $atts, $content = NULL, $case = NULL ) {
			return cloudfw_transfer_shortcode_attributes( $case, $atts, $content );
		}


		/** Run */
		function register_map($atts, $content =  NULL) {
			$this->atts = shortcode_atts(array(
				"align"                       => '',
				"width"                       => false,
				"height"                      => '400',
				"address"                     => '',
				"latitude"                    => 0,
				"longitude"                   => 0,
				"zoom"                        => 1,
				"popup"                       => 'true',
				"maptype"                     => 'ROADMAP',
				"marker"                      => true,
				"scrollwheel"                 => 'false',
				'doubleclickzoom'             => 'false',
				"controls"                    => 'false',
				'pancontrol'                  => 'false',
				'zoomcontrol'                 => 'false',
				'maptypecontrol'              => 'false',
				'scalecontrol'                => 'false',
				'streetviewcontrol'           => 'false',
				'overviewmapcontrol'          => 'false',
				
				/** Styler Options */
				'stylers'                     => 'FALSE',
				'stylers_hue'                 => '',
				'stylers_saturation'          => '',
				'stylers_lightness'           => '',
				
				'stylers_labels_text_color'   => '',
				'stylers_labels_stroke_color' => '',
				
				'stylers_road_labels'         => true,
				'stylers_road_lightness'      => '',
				
				'shadow'                      => NULL,
				'fullwidth'                   => 'false',
				'margin_top'                  => NULL,
				'margin_bottom'               => NULL,
			), _check_onoff_false( $atts ));

			extract($this->atts);
    		wp_enqueue_script ('theme-gmap');

			$this->markers = array();
			$this->child = 0; 
			do_shortcode( $content );

			$options                    = array();
			$options['zoom']            = (int) $zoom; 
			$options['maptype']         = (string) $maptype; 
			$options['doubleclickzoom'] = (bool) cloudfw_bool( $doubleclickzoom ); 
			$options['scrollwheel']     = (bool) cloudfw_bool( $scrollwheel );

			$options['address']         = (string) $address; 
			$options['latitude']        = (float) $latitude; 
			$options['longitude']       = (float) $longitude;

			if ( !empty( $this->markers ) && is_array( $this->markers ) ) {
				$options['markers'] = $this->markers;
			}
			
			if ( isset($controls) && $controls ) {

				$controls                       = array();
				$controls['scrollwheel']        = (bool) cloudfw_bool( $scrollwheel ); 
				$controls['pancontrol']         = (bool) cloudfw_bool( $pancontrol ); 
				$controls['zoomControl']        = (bool) cloudfw_bool( $zoomcontrol ); 
				$controls['mapTypeControl']     = (bool) cloudfw_bool( $maptypecontrol ); 
				$controls['scaleControl']       = (bool) cloudfw_bool( $scalecontrol ); 
				$controls['scaleControl']       = (bool) cloudfw_bool( $scalecontrol ); 
				$controls['streetViewControl']  = (bool) cloudfw_bool( $streetviewcontrol ); 
				$controls['overviewMapControl'] = (bool) cloudfw_bool( $overviewmapcontrol ); 

			} else {
				$controls = (bool) cloudfw_bool( $controls ); 
			}
			$options['controls'] = $controls;

			$options['stylers'] = array();
			if ( $stylers ) {
			
				/** Global Styler Options */
				$stylers_global = array();
				$stylers_global['stylers'] = array();
				if( !empty( $stylers_hue ) ) {
					$stylers_global['stylers'][] = array('hue' => cloudfw_color_check( $stylers_hue, true ));
				}

				$stylers_saturation = (int) $stylers_saturation; 
				if( $stylers_saturation !== 0 ) {
					$stylers_global['stylers'][] = array('saturation' => (int) $stylers_saturation );
				}

				$stylers_lightness = (int) $stylers_lightness; 
				if( $stylers_lightness !== 0 ) {
					$stylers_global['stylers'][] = array('lightness' => (int) $stylers_lightness );
				}
				
				$road_global = array();
				$road_global['featureType'] = 'road';
				$road_global['elementType'] = 'geometry';
				$road_global['stylers'][] = array('visibility' => "simplified");
				$stylers_road_lightness = (int) $stylers_road_lightness; 
				if( $stylers_road_lightness !== 0 ) {
					$road_global['stylers'][] = array('lightness' => (int) $stylers_road_lightness );
				}
				
				$road_labels = array();
				if ( ! $stylers_road_labels ) {
					$road_labels['featureType'] = 'road';
					$road_labels['elementType'] = 'labels';
					$road_labels['stylers'][] = array('visibility' => "off");
				}

				$label_texts = array();
				if( !empty( $stylers_labels_text_color ) ) {
					$label_texts['elementType'] = 'labels.text.fill';
					$label_texts['stylers'][] = array('color' => cloudfw_color_check( $stylers_labels_text_color, true ));
				}

				$label_strokes = array();
				if( !empty( $stylers_labels_stroke_color ) ) {
					$label_strokes['elementType'] = 'labels.text.stroke';
					$label_strokes['stylers'][] = array('color' => cloudfw_color_check( $stylers_labels_stroke_color, true ));
				}
	
				$options['stylers'][] = $stylers_global;
				$options['stylers'][] = $road_global;
				$options['stylers'][] = $road_labels;
				$options['stylers'][] = $label_texts;
				$options['stylers'][] = $label_strokes;
			}

    		$id = 'gmap-'.cloudfw_randomizer(4);
			$wrapper_classes = array(); 
			$wrapper_classes[] = 'gmap-wrapper';
			$wrapper_classes[] = 'ui--animation';

			if ( $fullwidth ) {
				$wrapper_classes[] = 'gmap-fullwidth'; 
				$wrapper_classes[] = 'fullwidth-content';
				$shadow = 0; 
			}

			$wrapper_classes[] = 'clearfix'; 
			$classes[] = $align; 
			
			$classes = array(); 
			$classes[] = 'gmap'; 
			$classes[] = 'clearfix'; 
			
			$out = "
			<div". 
				cloudfw_make_class( $wrapper_classes, TRUE ) .
				cloudfw_make_style_attribute( array(
					'margin-top'    => $margin_top,
					'margin-bottom' => $margin_bottom,
					'height'        => $height,
				), FALSE, TRUE ) .
			">
				<div".
					cloudfw_make_class( 'gmap-wrap-holder', TRUE ) .
					cloudfw_make_style_attribute( array(
						'height' => $height,
					), FALSE, TRUE ) .
				"></div>
				<div". 
					cloudfw_make_id( $id ) .
					cloudfw_make_class( $classes, TRUE ) .
					cloudfw_make_style_attribute( array(
						'height' => $height,
					), FALSE, TRUE ) .
					cloudfw_json_attribute( 'data-gmap-options', $options, FALSE ) .
				"></div>
				". cloudfw_UI_shadow( $shadow ) ."
			</div>
			";

			return $out;

		}


		/*
		 *	Item
		 */
		function register_marker($atts, $content =  NULL){
			extract(shortcode_atts(array(
				'marker_html'             => '',
				'marker_address'          => '',
				'marker_latitude'         => 0,
				'marker_longitude'        => 0,
				'marker_popup'            => 0,

				'marker_icon'             => '',
				'marker_icon_src'         => '',
				'marker_icon_width'       => 32,
				'marker_icon_height'      => 32,
				'marker_icon_anchor_x'    => 16,
				'marker_icon_anchor_y'    => 32,

			),  _check_onoff_false( $atts )));

			if ( !isset($this->markers) ) {
				$this->markers = array();
			}

			extract($this->atts);

			$marker_html = do_shortcode(cloudfw_inline_format($marker_html));

			$this->markers[ $this->child ]['html'] = (string) $marker_html;
			$this->markers[ $this->child ]['address'] = (string) $marker_address;
			$this->markers[ $this->child ]['latitude'] = (float) $marker_latitude;
			$this->markers[ $this->child ]['longitude'] = (float) $marker_longitude;
			$this->markers[ $this->child ]['popup'] = (bool) cloudfw_bool( $marker_popup );

			if ( $marker_icon && !empty( $marker_icon_src ) ) {

				$this->markers[ $this->child ]['icon'] = array();
				$this->markers[ $this->child ]['icon']['image'] = (string) $marker_icon_src;
				$this->markers[ $this->child ]['icon']['iconsize'] = array( (float) $marker_icon_width, (float) $marker_icon_height );
				$this->markers[ $this->child ]['icon']['iconanchor'] = array( (float) $marker_icon_anchor_x, (float) $marker_icon_anchor_y );

			}

			$this->child++;

		}

		/** Scheme */
		function composer_scheme() {
			return array(
				'data'		=>	array(
					cloudfw_composer_default_dropped_area(
						array(
							array(
								'id'	=>	'CloudFw_Shortcode_Gmap_Marker',
								'title'	=>	__('+ Add marker','cloudfw'),
							),
						)
					)
				)
			);
		}

		/** Scheme */
		function scheme() {
			return array(
				'title'		=>	__('Google Map','cloudfw'),
				'ajax'		=>	true,
				'script'	=> array(
					'shortcode'		=> $this->parent_shortcode,
					'tag_close'  	=> false,
					'attributes' 	=> array( 
						'maptype'                     => array( 'e' => 'gmap_type' ),
						'height'                      => array( 'e' => 'gmap_height' ),
						'address'                     => array( 'e' => 'gmap_address' ),
						'latitude'                    => array( 'e' => 'gmap_latitude' ),
						'longitude'                   => array( 'e' => 'gmap_longitude' ),
						'zoom'                        => array( 'e' => 'gmap_zoom' ),
						'marker'                      => array( 'e' => 'gmap_marker', 'onoff' => true ),
						'html'                        => array( 'e' => 'gmap_html' ),
						'shadow'                      => array( 'e' => 'gmap_shadow' ),
						'doubleclickzoom'             => array( 'e' => 'gmap_doubleclickzoom', 'onoff' => true ),
						'fullwidth'                   => array( 'e' => 'gmap_fullwidth', 'onoff' => true ),
						'scrollwheel'                 => array( 'e' => 'gmap_scrollwheel', 'onoff' => true ),
						'controls'                    => array( 'e' => 'gmap_controls', 'onoff' => true, 'check-default' => '0' ),
						'pancontrol'                  => array( 'e' => 'gmapControls_Pan', 'onoff' => true ),
						'zoomcontrol'                 => array( 'e' => 'gmapControls_Zoom', 'onoff' => true ),
						'maptypecontrol'              => array( 'e' => 'gmapControls_mapType', 'onoff' => true ),
						'scalecontrol'                => array( 'e' => 'gmapControls_scale', 'onoff' => true ),
						'streetviewcontrol'           => array( 'e' => 'gmapControls_streetview', 'onoff' => true ),
						'overviewmapcontrol'          => array( 'e' => 'gmapControls_overviewmap', 'onoff' => true ),
						
						'stylers'                     => array( 'e' => 'gmap_stylers', 'onoff' => true ),
						'stylers_hue'                 => array( 'e' => 'gmap_stylers_hue' ),
						'stylers_saturation'          => array( 'e' => 'gmap_stylers_saturation' ),
						'stylers_lightness'           => array( 'e' => 'gmap_stylers_lightness' ),
						
						'stylers_labels_text_color'   => array( 'e' => 'gmap_stylers_labels_text_color' ),
						'stylers_labels_stroke_color' => array( 'e' => 'gmap_stylers_labels_stroke_color' ),
						
						'stylers_road_labels'         => array( 'e' => 'gmap_stylers_road_labels', 'onoff' => true ),
						'stylers_road_lightness'      => array( 'e' => 'gmap_stylers_road_lightness' ),
						
						'margin_top'                  => array( 'e' => 'margin_top' ),
						'margin_bottom'               => array( 'e' => 'margin_bottom' ),
					),
					'if'		 =>	array(
						array( 
							'type' 	  => 'toggle',
							'e' 	  => 'gmap_controls',
							'related' => 'gmapControls',
							'targets' => array(
								array('1', '#gmapControls_Pan'),
								array('1', '#gmapControls_Zoom'),
								array('1', '#gmapControls_mapType'),
								array('1', '#gmapControls_scale'),
								array('1', '#gmapControls_overviewmap'),
							)
						),
						array( 
							'type' 	  => 'toggle',
							'e' 	  => 'gmap_type',
							'related' => 'stylerSection',
							'mode'    => 'same',
							'targets' => array(
								array('', 		 '.stylerSection'),
								array('ROADMAP', '.stylerSection'),
							)
						),
						array( 
							'type' 	  => 'toggle',
							'e' 	  => 'gmap_stylers',
							'related' => 'stylerOptions',
							'mode'    => 'same',
							'targets' => array(
								array('1', '.stylerOptions'),
							)
						)
					)
				),
				'data'		=>	array(

					array(
						'type'		=> 'module',
						'title'		=> __('Map Height','cloudfw'),
						'data'		=> array(

							## Element
							array(
								'type'		=>	'slider',
								'id'		=>	'gmap_height',
								'value'		=>	$this->get_value('gmap_height', 400),
								'class'		=>	'input_250',
								'min'		=>	50,
								'max'		=>	1000,
							), // #### element: 0

						)

					),  // #### module: 5


					array(
						'type'		=> 'module',
						'title'		=> __('Map Type','cloudfw'),
						'data'		=> array(

							## Element
							array(
								'type'		=>	'select',
								'id'		=>	'gmap_type',
								'value'		=>	$this->get_value('gmap_type'),
								'ui'		=>	true,
								'source'	=>	array(
									'NULL' 			=> __('Default','cloudfw'),
									'ROADMAP' 		=> __('ROADMAP - Roadmap','cloudfw'),
									'SATELLITE' 	=> __('SATELLITE - Google Earth Satellite','cloudfw'),
									'HYBRID' 		=> __('HYBRID - Mixture of Normal and Satellite','cloudfw'),
									'TERRAIN' 		=> __('TERRAIN - Physical Map','cloudfw'),
								),
							), // #### element: 0

						)

					),  // #### element: 7

					array(
						'type'		=> 'module',
						'title'		=> __('Zoom Level','cloudfw'),
						'data'		=> array(

							## Element
							array(
								'type'		=>	'slider',
								'id'		=>	'gmap_zoom',
								'value'		=>	$this->get_value('gmap_zoom', 12),
								'class'		=>	'input_250',
								'min'		=>	1,
								'max'		=>	19,
							), // #### element: 0

						)

					),

					array(
						'type'		=> 'module',
						'title'		=> __('Fullwidth Map?','cloudfw'),
						'data'		=> array(

							## Element
							array(
								'type'		=>	'onoff',
								'id'		=>	'gmap_fullwidth',
								'value'		=>	$this->get_value('gmap_fullwidth', 'FALSE'),
							), // #### element: 0

						)

					),

					array(
						'type'		=> 'module',
						'title'		=> __('Shadow','cloudfw'),
						'data'		=> array(

							## Element
							array(
								'type'		=>	'select',
								'id'		=>	'gmap_shadow',
								'value'		=>	$this->get_value('gmap_shadow'),
								'source'	=>	array(
									'type'			=> 'function',
									'function'		=> 'cloudfw_admin_loop_shadows',
								),
								'width'		=>	250,

							), // #### element: 0

						)

					),

					array(
						'type'		=> 'mini-section',
						'title'		=> __('Default Map Position','cloudfw'),
						'data'		=> array(

							array(
								'type'		=> 'module',
								'optional'	=> true,
								'title'		=> __('Address','cloudfw'),
								'data'		=> array(

									## Element
									array(
										'type'		=>	'text',
										'id'		=>	'gmap_address',
										'value'		=>	$this->get_value('gmap_address'),
										'class'		=>	'input input_400',
										'desc'		=>	__('You can leave blank if insert latitude and longitude values.','cloudfw')
									), // #### element: 0

								)

							),

							array(
								'type'		=> 'module',
								'_class'	=> 'limited',
								'title'		=> __('Latitude / Longitude','cloudfw'),
								'data'		=> array(

									## Element
									array(
										'type'		=>	'text',
										'title'		=>	__('Latitude','cloudfw'),
										'id'		=>	'gmap_latitude',
										'value'		=>	$this->get_value('gmap_latitude'),
										'class'		=>	'input input_150',
									), // #### element: 0

									## Element
									array(
										'type'		=>	'text',
										'title'		=>	__('Longitude','cloudfw'),
										'id'		=>	'gmap_longitude',
										'value'		=>	$this->get_value('gmap_longitude'),
										'class'		=>	'input input_150',
									), // #### element: 1
									array(),

								)

							),

						)

					),

					array(
						'type'		=> 'mini-section',
						'title'		=> __('Zoom Control','cloudfw'),
						'data'		=> array(

							array(
								'type'		=> 'module',
								'title'		=> __('Double Click Zoom','cloudfw'),
								'data'		=> array(

									## Element
									array(
										'type'		=>	'onoff',
										'id'		=>	'gmap_doubleclickzoom',
										'value'		=>	$this->get_value('gmap_doubleclickzoom', 1),
									), // #### element: 0

								)

							),

							array(
								'type'		=> 'module',
								'title'		=> __('Scrollwheel','cloudfw'),
								'data'		=> array(

									## Element
									array(
										'type'		=>	'onoff',
										'id'		=>	'gmap_scrollwheel',
										'value'		=>	$this->get_value('gmap_scrollwheel', 1),
									), // #### element: 0

								)

							),

						)

					),

					array(
						'type'		=> 'mini-section',
						'title'		=> __('Controls','cloudfw'),
						'data'		=> array(


							array(
								'type'		=> 'module',
								'title'		=> __('Controls','cloudfw'),
								'data'		=> array(

									## Element
									array(
										'type'		=>	'onoff',
										'id'		=>	'gmap_controls',
										'value'		=>	$this->get_value('gmap_controls', 'FALSE'),
									), // #### element: 0

								)

							),

							array(
								'type'		=> 'module',
								'title'		=> __('Pan Control','cloudfw'),
								'related' 	=> 'gmapControls',
								'hidden' 	=> true,
								'data'		=> array(

									## Element
									array(
										'type'		=>	'onoff',
										'id'		=>	'gmapControls_Pan',
										'value'		=>	$this->get_value('gmapControls_Pan', 1),
									), // #### element: 0

								)

							),

							array(
								'type'		=> 'module',
								'title'		=> __('Zoom Control','cloudfw'),
								'related' 	=> 'gmapControls',
								'hidden' 	=> true,
								'data'		=> array(

									## Element
									array(
										'type'		=>	'onoff',
										'id'		=>	'gmapControls_Zoom',
										'value'		=>	$this->get_value('gmapControls_Zoom', 1),
									), // #### element: 0

								)

							),

							array(
								'type'		=> 'module',
								'title'		=> __('Map Type Control','cloudfw'),
								'related' 	=> 'gmapControls',
								'hidden' 	=> true,
								'data'		=> array(

									## Element
									array(
										'type'		=>	'onoff',
										'id'		=>	'gmapControls_mapType',
										'value'		=>	$this->get_value('gmapControls_mapType', 1),
									), // #### element: 0

								)

							),

							array(
								'type'		=> 'module',
								'title'		=> __('Scale Control','cloudfw'),
								'related' 	=> 'gmapControls',
								'hidden' 	=> true,
								'data'		=> array(

									## Element
									array(
										'type'		=>	'onoff',
										'id'		=>	'gmapControls_scale',
										'value'		=>	$this->get_value('gmapControls_scale', 1),
									), // #### element: 0

								)

							),

							array(
								'type'		=> 'module',
								'title'		=> __('Street View Control','cloudfw'),
								'related' 	=> 'gmapControls',
								'hidden' 	=> true,
								'data'		=> array(

									## Element
									array(
										'type'		=>	'onoff',
										'id'		=>	'gmapControls_streetview',
										'value'		=>	$this->get_value('gmapControls_streetview', 1),
									), // #### element: 0

								)

							),

							array(
								'type'		=> 'module',
								'title'		=> __('Overview Map Control','cloudfw'),
								'related' 	=> 'gmapControls',
								'hidden' 	=> true,
								'data'		=> array(

									## Element
									array(
										'type'		=>	'onoff',
										'id'		=>	'gmapControls_overviewmap',
										'value'		=>	$this->get_value('gmapControls_overviewmap', 1),
									), // #### element: 0

								)

							),

						)

					),

					array(
						'type'		=> 'mini-section',
						'related'	=> 'stylerSection',
						'title'		=> __('Styler','cloudfw'),
						'data'		=> array(

							array(
								'type'		=> 'module',
								'title'		=> __('Enable Custom Map Colors?','cloudfw'),
								'data'		=> array(

									## Element
									array(
										'type'		=>	'onoff',
										'id'		=>	'gmap_stylers',
										'value'		=>	$this->get_value('gmap_stylers', 'FALSE'),
									), // #### element: 0

								)

							),

							array(
								'type'		=> 'group',
								'related'	=> 'stylerOptions',
								'data'		=> array(

									array(
										'type'		=> 'module',
										'title'		=> __('Hue Color','cloudfw'),
										'data'		=> array(

											## Element
											array(
												'type'		=>	'color',
												'style'		=>	'horizontal',
												'id'		=>	'gmap_stylers_hue',
												'value'		=>	$this->get_value('gmap_stylers_hue'),
											), // #### element: 0

										)

									),

									array(
										'type'		=> 'module',
										'title'		=> __('Saturation','cloudfw'),
										'data'		=> array(

											## Element
											array(
												'type'		=> 'slider',
												'id'		=> 'gmap_stylers_saturation',
												'value'		=> $this->get_value('gmap_stylers_saturation', 0),
												'step'		=> 1,
												'min'		=> -100,
												'max'		=> 100,
												'unit'		=> '',
												'width'		=> 400,
											), // #### element: 0

										)

									),

									array(
										'type'		=> 'module',
										'title'		=> __('Lightness','cloudfw'),
										'data'		=> array(

											## Element
											array(
												'type'		=> 'slider',
												'id'		=> 'gmap_stylers_lightness',
												'value'		=> $this->get_value('gmap_stylers_lightness', 0),
												'step'		=> 0.1,
												'min'		=> -100,
												'max'		=> 100,
												'unit'		=> '',
												'width'		=> 400,
											), // #### element: 0

										)

									),


									array(
										'type'		=> 'module',
										'title'		=> __('Labels Text Color','cloudfw'),
										'data'		=> array(

											## Element
											array(
												'type'		=>	'color',
												'style'		=>	'horizontal',
												'id'		=>	'gmap_stylers_labels_text_color',
												'value'		=>	$this->get_value('gmap_stylers_labels_text_color'),
											), // #### element: 0

										)

									),

									array(
										'type'		=> 'module',
										'title'		=> __('Labels Stroke Color','cloudfw'),
										'data'		=> array(

											## Element
											array(
												'type'		=>	'color',
												'style'		=>	'horizontal',
												'id'		=>	'gmap_stylers_labels_stroke_color',
												'value'		=>	$this->get_value('gmap_stylers_labels_stroke_color'),
											), // #### element: 0

										)

									),

									array(
										'type'		=> 'module',
										'title'		=> __('Road Labels Visibility?','cloudfw'),
										'data'		=> array(

											## Element
											array(
												'type'		=>	'onoff',
												'id'		=>	'gmap_stylers_road_labels',
												'value'		=>	$this->get_value('gmap_stylers_road_labels', 'FALSE'),
											), // #### element: 0

										)

									),


									array(
										'type'		=> 'module',
										'title'		=> __('Road Geometry Lightness','cloudfw'),
										'data'		=> array(

											## Element
											array(
												'type'		=> 'slider',
												'id'		=> 'gmap_stylers_road_lightness',
												'value'		=> $this->get_value('gmap_stylers_road_lightness', 50),
												'step'		=> 0.1,
												'min'		=> -100,
												'max'		=> 100,
												'unit'		=> '',
												'width'		=> 400,
											), // #### element: 0

										)

									),


								)

							),

						)


					),

					array(
						'type'		=> 'mini-section',
						'title'		=> __('Margins','cloudfw'),
						'data'		=> array(

							array(
								'type'		=>	'global-scheme',
								'scheme'	=>	'margins',
								'this'		=>	$this
							),

						)

					),

				
				)

			);

		}

		/** Typo map */
		function typo_map( $map ){
			cloudfw_add_typo_setting( $map, 'gmap_tooltip', '.gm-style .gm-style-iw div', array( 'font-size' => 14 ));

		    return $map;
		}

	}

}



/**
****************************************************************
*/

cloudfw_register_shortcode( 'CloudFw_Shortcode_Gmap_Marker' );
if ( ! class_exists('CloudFw_Shortcode_Gmap_Marker') ) {
	class CloudFw_Shortcode_Gmap_Marker extends CloudFw_Shortcodes {

		function get_called_class(){ return get_class($this); }

		/** Add the shortcode to the composer */
		function composer(){
			return array(
				'composer'		=> true,
				'droppable'		=> false,
				'ajax'			=> true,
				'list'			=> false,
				'icon'			=> '',
				'group'			=> 'composer_widgets',
				'line'			=> 330,
				'do_shortcode'	=> false,
				'options'		=> array(
					'title'				=> __('Gmap Marker','cloudfw'),
					'column'			=> '1/1',
					'allow_columns'		=> false,
					'sync_title'		=> 'marker_address',
					'in'				=> 'CloudFw_Shortcode_Gmap',
					'not_in'			=> 'CloudFw_Shortcode_Gmap_Marker',
				)
			);
		}

		function shortcode( $atts, $content =  NULL, $case = NULL ) {
			return cloudfw_transfer_shortcode_attributes( 'gmap_marker', $atts, $content );
		}

		/** Admin Scheme */
		function scheme() {
			return array(
				'script'	=> array(
					'attributes' 	=> array( 
						'marker_html'          => array( 'e' => 'marker_html' ),
						'marker_address'       => array( 'e' => 'marker_address' ),
						'marker_latitude'      => array( 'e' => 'marker_latitude' ),
						'marker_longitude'     => array( 'e' => 'marker_longitude' ),
						'marker_popup'         => array( 'e' => 'marker_popup' ),

						'marker_icon'          => array( 'e' => 'marker_icon', 'onoff' => true ),
						'marker_icon_src'      => array( 'e' => 'marker_icon_src' ),
						'marker_icon_width'    => array( 'e' => 'marker_icon_width' ),
						'marker_icon_height'   => array( 'e' => 'marker_icon_height' ),
						'marker_icon_anchor_x' => array( 'e' => 'marker_icon_anchor_x' ),
						'marker_icon_anchor_y' => array( 'e' => 'marker_icon_anchor_y' ),
					),

					'if'		 =>	array(
						array( 
							'type' 	  => 'toggle',
							'e' 	  => 'marker_icon',
							'related' => 'gmapMarkerIcon',
							'mode' 	  => 'same',
							'targets' => array(
								array('1', '.gmapMarkerIcon'),
							)
						)
					)					

				),
				'data'		=>	array(

					array(
						'type'		=> 'module',
						'optional'	=> true,
						'title'		=> __('Address','cloudfw'),
						'data'		=> array(

							## Element
							array(
								'type'		=>	'text',
								'id'		=>	'marker_address',
								'value'		=>	$this->get_value('marker_address'),
								'class'		=>	'input input_400',
								'desc'		=>	__('You can leave blank if insert latitude and longitude values.','cloudfw')
							), // #### element: 0

						)

					),

					array(
						'type'		=> 'module',
						'_class'	=> 'limited',
						'title'		=> __('Latitude / Longitude','cloudfw'),
						'data'		=> array(

							## Element
							array(
								'type'		=>	'text',
								'title'		=>	__('Latitude','cloudfw'),
								'id'		=>	'marker_latitude',
								'value'		=>	$this->get_value('marker_latitude'),
								'class'		=>	'input input_150',
							), // #### element: 0

							## Element
							array(
								'type'		=>	'text',
								'title'		=>	__('Longitude','cloudfw'),
								'id'		=>	'marker_longitude',
								'value'		=>	$this->get_value('marker_longitude'),
								'class'		=>	'input input_150',
							), // #### element: 1
							array(),

						)

					),

					array(
						'type'		=> 'module',
						'title'		=> __('HTML','cloudfw'),
						'data'		=> array(

							## Element
							array(
								'type'		=>	'textarea',
								'id'		=>	'marker_html',
								'value'		=>	$this->get_value('marker_html'),
								'width'		=>	500,
								'line'		=>	3,
							), // #### element: 0
						)

					),

					array(
						'type'		=> 'module',
						'title'		=> __('Open popup by default?','cloudfw'),
						'data'		=> array(

							## Element
							array(
								'type'		=>	'onoff',
								'id'		=>	'marker_popup',
								'value'		=>	$this->get_value('marker_popup', 'FALSE'),
							), // #### element: 0

						)

					),

					array(
						'type'		=> 'mini-section',
						'title'		=> __('Custom Marker Icon','cloudfw'),
						'data'		=> array(

							array(
								'type'		=> 'module',
								'title'		=> __('Use custom icon?','cloudfw'),
								'data'		=> array(

									## Element
									array(
										'type'		=>	'onoff',
										'id'		=>	'marker_icon',
										'value'		=>	$this->get_value('marker_icon', 'FALSE'),
									), // #### element: 0

								)

							),
		
							array(
								'type'		=> 'group',
								'related'	=>	'gmapMarkerIcon',
								'data'		=> array(

									array(
										'type'		=> 'module',
										'title'		=> __('Icon','cloudfw'),
										'data'		=> array(

											## Element
											array(
												'type'		=>	'upload',
												'id'		=>	'marker_icon_src',
												'value'		=>	$this->get_value('marker_icon_src'),
												'remove'	=>	true,
												'library'	=>	true,
												'store'		=>	true,
											), // #### element: 0

										)

									),

									array(
										'type'		=> 'module',
										'title'		=> array(__('Icon Width','cloudfw'), __('Icon Height','cloudfw')),
										'layout'	=> 'split',
										'data'		=> array(

											## Element
											array(
												'type'		=>	'text',
												'id'		=>	'marker_icon_width',
												'value'		=>	$this->get_value('marker_icon_width', 32),
												'width'		=>	50,
												'unit'		=>	__('px','cloudfw')
											), // #### element: 0

											## Element
											array(
												'type'		=>	'text',
												'id'		=>	'marker_icon_height',
												'value'		=>	$this->get_value('marker_icon_height', 32),
												'width'		=>	50,
												'unit'		=>	__('px','cloudfw')
											), // #### element: 0

										)

									),

									array(
										'type'		=> 'module',
										'title'		=> array(__('Anchor Position X','cloudfw'), __('Anchor Position Y','cloudfw')),
										'layout'	=> 'split',
										'data'		=> array(

											## Element
											array(
												'type'		=>	'text',
												'id'		=>	'marker_icon_anchor_x',
												'value'		=>	$this->get_value('marker_icon_anchor_x', 12),
												'width'		=>	50,
												'unit'		=>	__('px','cloudfw')
											), // #### element: 0

											## Element
											array(
												'type'		=>	'text',
												'id'		=>	'marker_icon_anchor_y',
												'value'		=>	$this->get_value('marker_icon_anchor_y', 32),
												'width'		=>	50,
												'unit'		=>	__('px','cloudfw')
											), // #### element: 0

										)

									),

								)

							),

						)

					),


				)

			);

		}

	}

}