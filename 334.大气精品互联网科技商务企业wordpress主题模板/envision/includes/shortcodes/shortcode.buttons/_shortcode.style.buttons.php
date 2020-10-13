<?php
/*
 * Plugin Name: Buttons
 * Plugin URI: http://cloudfw.net
 * Description: 
 * Version: 1.0
 * Author: Orkun Gürsel
 * Author URI: http://orkungursel.com
 * Shortcode: 
 * Attributes:
 */

function cloudfw_make_button_style( $color, $to_class = false, $extra_class = '' ) {

	$button_classes = array();

	if ( !is_array( $extra_class ) ) {
		$extra_class = array( $extra_class ); 
	}

	$button_classes = array_merge( $button_classes, $extra_class );

	/** Set Class for Color */
	if ( !empty($color) ) {
		$cloudfw_pre_colors = cloudfw_button_array();

		if ( !isset($cloudfw_pre_colors[ $color ]) ) {
			$button_classes[] = $color;
			$button_classes[] = 'btn-custom-color';
			$is_custom_color = true;
		} else {
			$button_classes[] = $color;
			$is_custom_color = false;
		}
	}


	if ( $is_custom_color ) {

		$custom_colors = cloudfw_walk_options( array( 
			'id'                     => 'indicator',
			'name'                   => 'name',
			'name'                   => 'name',
			'gradient_start'         => 'gradient_0',
			'gradient_stop'          => 'gradient_1',
			'gradient_start_hover'   => 'gradient_hover_0',
			'gradient_stop_hover'    => 'gradient_hover_1',
			'color'                  => 'color',
			'color_hover'            => 'color_hover',
			'border_color'           => 'border_color',
			'border_color_hover'     => 'border_color_hover',
			'shadow_color'           => 'shadow_color',
			'shadow_color_hover'     => 'shadow_color_hover',
			'shadow_direction'       => 'shadow_direction',
			'shadow_direction_hover' => 'shadow_direction_hover',
		), cloudfw_get_option('button_colors'), 'indicator' );

		$current_custom_color = isset($custom_colors[ $color ]) ? $custom_colors[ $color ] : NULL;
		unset($custom_colors);

		if ( isset($current_custom_color) && $current_custom_color ) {

			if ( !cloudfw_vc_isset( 'css', 'button-' . $current_custom_color['id'] ) ) {
				$custom_color_css  = '';

				if ( empty($current_custom_color['gradient_start']) ) {
					$current_custom_color['gradient_start'] = $current_custom_color['gradient_stop'];
				} elseif ( empty($current_custom_color['gradient_stop']) ) {
					$current_custom_color['gradient_stop'] = $current_custom_color['gradient_start'];
				}

				if ( !empty($current_custom_color['border_color']) ) {
					cloudfw_vc_set( 'css_button_border', $current_custom_color['id'], true );
				}

				$custom_class = 'html .' . (isset($current_custom_color['id']) ? $current_custom_color['id'] : NULL); 

				/** Link */
				$custom_color_css .= $custom_class . ' {';
				$custom_color_css .= cloudfw_make_style_attribute( array( 
					'!color'         => $current_custom_color['color'],
					'gradient'       => array($current_custom_color['gradient_start'], $current_custom_color['gradient_stop']),
					'!text-shadow'   => !empty($current_custom_color['shadow_color']) ? '0 '. _if( !empty($current_custom_color['shadow_direction']), $current_custom_color['shadow_direction'], '-1' ) . 'px 0 #' . $current_custom_color['shadow_color'] : NULL,
					'!+border'       => $current_custom_color['border_color'],
				), FALSE, FALSE );
				$custom_color_css .= '}';


				if ( empty($current_custom_color['gradient_start_hover']) ) {
					$current_custom_color['gradient_start_hover'] = isset($current_custom_color['gradient_stop_hover']) ? $current_custom_color['gradient_stop_hover'] : $current_custom_color['gradient_stop'];
				}

				if ( empty($current_custom_color['gradient_stop_hover']) ) {
					$current_custom_color['gradient_stop_hover'] = isset($current_custom_color['gradient_start_hover']) ? $current_custom_color['gradient_start_hover'] : $current_custom_color['gradient_start'];
				}

				/** Hover */
				$custom_color_css .= $custom_class . ':hover,';
				$custom_color_css .= $custom_class . ':focus,';
				$custom_color_css .= $custom_class . ':active,';
				$custom_color_css .= $custom_class . ':disabled,';
				$custom_color_css .= $custom_class . '[disabled] {';
				$custom_color_css .= cloudfw_make_style_attribute( array( 
					'!color'         => !empty($current_custom_color['color_hover']) ? $current_custom_color['color_hover'] : $current_custom_color['color'],
					'gradient'       => array($current_custom_color['gradient_start_hover'], $current_custom_color['gradient_stop_hover']),
					'!text-shadow'   => !empty($current_custom_color['shadow_color_hover']) ? '0 '. _if( !empty($current_custom_color['shadow_direction_hover']), $current_custom_color['shadow_direction_hover'], '-1' ) . 'px 0 #' . $current_custom_color['shadow_color_hover'] : NULL,
					'!+border'       => $current_custom_color['border_color_hover'],
				), FALSE, FALSE );
				$custom_color_css .= '}';

				cloudfw_vc_set( 'css', 'button-' . $current_custom_color['id'], $custom_color_css );
				unset( $custom_color_css );

			}
			
		}

	}

	if ( !empty( $button_classes ) ) {
		$button_classes = array_filter( $button_classes ); 
		$button_classes = implode( ' ', $button_classes ); 
	}

	if ( $to_class ) {
		return $button_classes;
	} else {
		return compact( 'color', 'is_custom_color', 'button_classes' );
	}

}

cloudfw_register_shortcode( 'CloudFw_Shortcode_Buttons', 'button', 'style', 15 );
if ( ! class_exists('CloudFw_Shortcode_Buttons') ) {
	class CloudFw_Shortcode_Buttons extends CloudFw_Shortcodes {

		public $do_before = false;

		function get_called_class(){ return get_class($this); }


		/** Add the shortcode to the composer */
		function composer(){
			return array(
				'composer'      => true,
				'ajax'          => true,
				'icon'          => 'buttons',
				'group'         => 'composer_widgets',
				'line'          => 150,
				'options'       => array(
					'title'             => __('Button','cloudfw'),
					'sync_title'        => 'button_title',
					'column'            => '1/1',
					'allow_columns'     => true,
				)
			);
		}

		/** Run */
		function shortcode( $atts = array(), $content =  NULL, $case = NULL ) {
			extract(shortcode_atts(array(
					'id'                => NULL,
					'link'              => NULL,
					'radius'            => NULL,
					'block'             => 'FALSE',
					'color'             => "primary",
					'size'              => "normal",
					'target'            => NULL,
					'align'             => 'left',
					'style'             => NULL,
					'class'             => NULL,
					'rel'               => NULL,
					'icon'              => NULL,
					'icon_position'     => NULL,
					'shadow'            => NULL,
					'custom_effect'     => NULL,
					'title'             => '',

					'margin_top'        => NULL,
					'margin_bottom'     => NULL,
					'margin_left'       => NULL,
					'margin_right'      => NULL,
					'attributes'        => array(),
				), _check_onoff_false($atts)));

				$classes = array();
				$classes[] = 'btn';
				$style = '';

				/** Detect button size */
				switch ( $size ) {
					case 'mini':
						$classes[] = 'btn-mini'; 
					break;
					case 'small':
						$classes[] = 'btn-small'; 
					break;
					case 'medium':
						$classes[] = 'btn-medium'; 
					break;
					case 'large':
					case 'big':
						$classes[] = 'btn-large'; 
					break;
					default:
						$classes[] = 'btn-normal';
					break;
				}

				if ( $block ) {
					$classes[] = 'btn-block';
				}

				if ( $icon_position )
					$classes[] = 'btn-icon-' . $icon_position;
				else
					$classes[] = 'btn-icon-left';

				if ( $class )
					$classes[] = $class;
				
				/** Check Icon Attr */
				if ( !empty($atts['button_icon_source']) && $atts['button_icon_source'] != 'custom' ) $src = '';
				if ( !empty($atts['button_icon_source_hover']) && $atts['button_icon_source_hover'] != 'custom' ) $src_hover = '';

				$icon = cloudfw_make_icon( $icon, 'ui--icon btn-icon icon-normal' );

				if ( !empty($icon) ) {
					$classes[] = 'with-icon';
				}
				
				if ( $icon )
					$classes[] = 'button-hover';


				/** Link URL */
				if ( ! $link ) {
					$link = "#";
				} elseif( $link[0] == '/' ) {
					$link = cloudfw_home_url() . $link;
				}

				if ( strpos((string)$link, '%permalink%') !== false ) {
					global $current_link;
					if ( empty($current_link) ) {
						$current_link = get_permalink();
					}

					$link = str_replace('%permalink%', $current_link, $link);
				}

				$button_color = (array) cloudfw_make_button_style( $color );
				extract($button_color);

				if ( !empty($button_classes) ) {
					$classes[] = $button_classes;
				}

				if ( !empty($radius) ) {
					$classes[] = $radius;
				}

				if ( $is_custom_color && cloudfw_vc_get( 'css_button_border', $color ) === true  ) {
					$classes[] = 'btn-with-border';
				}

				if ( empty( $attributes ) ) {
					$attributes = array();
				}

				$wrap_classes = array();
				$wrap_attributes = array();

				if ( !empty( $id ) ) $attributes['id'] = $id;
				if ( !empty( $link ) ) $attributes['href'] = $link;
				if ( !empty( $rel ) ) $attributes['rel'] = $rel;
				if ( !empty( $style ) ) $attributes['style'] = $style;
				if ( !empty( $target ) ) $attributes['target'] = $target;
				if ( !empty( $title ) ) $attributes['title'] = $title;
				if ( !empty( $alt ) ) $attributes['alt'] = $alt;

				$margins = cloudfw_make_style_attribute( array(
					'margin-left'    => $margin_left,
					'margin-right'   => $margin_right,
					'margin-top'     => $margin_top,
					'margin-bottom'  => $margin_bottom,
				), FALSE, FALSE );
				
				if( $align != 'left' ) {
					$wrap_classes[] = "text-{$align}";
				}

				if ( !empty( $shadow ) ) {
					$wrap_attributes['style'] = $margins;
				} else {
					$attributes['style'] = $margins;
				}

				if ( !empty( $wrap_classes ) || !empty( $wrap_attributes ) ) {
					$wrap_classes[] = 'ui--animation';
					$wrap_attributes['data-fx'] = $custom_effect;

				} else {
					$classes[] = 'ui--animation';
					$attributes['data-fx'] = $custom_effect;
				}
				
				$out = '';
				$out .= "<a". 
					cloudfw_make_class( $classes, true ) . 
					cloudfw_make_attribute( $attributes, false ) .
				">";
				
				if ( $icon && $icon_position != 'right' ) {
					$out .= "<span class=\"button-icon\">{$icon}</span>";
				}

				if ( !empty($content) ) {
					$out .= "{$content}";
				} else {
					$out .= "<span class=\"button-text-placeholder\"></span>";
				}

				if ( $icon && $icon_position == 'right' ) {
					$out .= "<span class=\"button-icon\">{$icon}</span>";
				}

				$out .= "</a>";
				$out .= " "; // blank space

				if ( !empty( $shadow ) ) {
					$shadow_wrap_classes = array();

					if ( $block ) {
						$shadow_wrap_classes[] = 'ui--block';
					} else {
						$shadow_wrap_classes[] = 'ui--inline-block';
					}

					$out = cloudfw_UI_shadow( $shadow, $out, 'ui--shadow-abs', '<div'. cloudfw_make_class( $shadow_wrap_classes, true ) .'>', '</div>' );
					$wrap_classes[] = 'ui--button-wrapper';
				}

				if ( !empty( $wrap_classes ) || !empty( $wrap_attributes ) ) {

					$out = "<div". 
						cloudfw_make_class( $wrap_classes, true ) . 
						cloudfw_make_attribute( $wrap_attributes, false ) .
					">{$out}</div>";

				}
				
				return $out;

		}

		/** Admin Scheme */
		function scheme() {
			return array(
				'title'     =>  __('Buttons','cloudfw'),
				'script'    => array(
					'shortcode'  => 'button',
					'tag_close'  => true,
					'attributes' => array( 
						'size'          => array( 'e' => 'button_size' ),
						'color'         => array( 'e' => 'button_color', 'required' => __('Please select a color for the button','cloudfw') ),
						'link'          => array( 'e' => 'button_link', 'required' => __('Please insert a button link','cloudfw') ),
						'target'        => array( 'e' => 'button_target' ),
						'align'         => array( 'e' => 'button_align' ),
						'radius'        => array( 'e' => 'button_radius' ),
						'block'         => array( 'e' => 'button_block', 'onoff' => true ),
						'icon_position' => array( 'e' => 'button_icon_icon_position' ),
						'icon'          => array( 'e' => 'button_icon_pre' ),
						'content'       => array( 'e' => 'button_title', 'force' => true, 'default' => __('Button Title','cloudfw') ),
						'shadow'        => array( 'e' => 'button_shadow' ),
						'title'         => array( 'e' => 'button_title_attr' ),
						'custom_effect' => array( 'e' => 'button_custom_effect' ),
						'margin_top'    => array( 'e' => 'margin_top' ),
						'margin_bottom' => array( 'e' => 'margin_bottom' ),
					)
				),
				'data'      =>  $this->load_scheme( __FILE__ )
			);

		}


		/** Skin map */
		function skin_map( $map ){
			/** Primary Buttons */

			$map  -> id      ( 'primary_button' )
				  -> selector( '.btn-primary' )
				  -> attr    ( 'color', '', true )
				  -> attr    ( 'gradient', array(), true )
				  -> pattern ( 'text-shadow', 
							   '0 -1px 0 #%color% !important', 
						array( 'color' => '' ) );

			$map  -> id      ( 'primary_button_hover' )
				  -> selector( '.btn-primary:hover, .btn-primary:focus, .btn-primary:active, .btn-primary.active, .btn-primary.disabled, .btn-primary[disabled]' )
				  -> sync    ( 'background-color', 'primary_button', array( 'gradient', 1 ), true ); /** [attribute] [sync_element] [sync_attribute] */

			$map  -> id      ( 'secondary_button' )
				  -> selector( '.btn-secondary' )
				  -> attr    ( 'color', '', true )
				  -> attr    ( 'border-color', '', true );

			$map  -> id      ( 'secondary_button_hover' )
				  -> selector( '.btn-secondary:hover, .btn-secondary:focus, .btn-secondary:active, .btn-secondary.active, .btn-secondary.disabled, .btn-secondary[disabled]' )
				  -> attr    ( 'color', '', true )
				  -> attr    ( 'border-color', '', true );

			$map  -> id      ( 'secondary_button_dark' )
				  -> selector( '.ui-dark .btn-secondary' )
				  -> sync    ( 'color', 'auto-ui_footer_widgetized_separator', 'background-color', true )
				  -> sync    ( 'border-color', 'auto-ui_footer_widgetized_separator', 'background-color', true )
				  -> sync    ( 'color', 'footer_widgetized_separator', 'background-color', true )
				  -> sync    ( 'border-color', 'footer_widgetized_separator', 'background-color', true )
				  -> attr    ( 'color', '', true )
				  -> attr    ( 'border-color', '', true );

			$map  -> id      ( 'secondary_button_hover_dark' )
				  -> selector( '.ui-dark .btn-secondary:hover, .ui-dark .btn-secondary:focus, .ui-dark .btn-secondary:active, .ui-dark .btn-secondary.active, .ui-dark .btn-secondary.disabled, .ui-dark .btn-secondary[disabled]' )
				  -> sync    ( 'color', 'auto-footer_widgetized_title', 'color', true )
				  -> sync    ( 'border-color', 'auto-footer_widgetized_title', 'color', true )
				  -> sync    ( 'color', 'footer_widgetized_title', 'color', true )
				  -> sync    ( 'border-color', 'footer_widgetized_title', 'color', true )
				  -> attr    ( 'color', '', true )
				  -> attr    ( 'border-color', '', true );

			return $map;
		}

		/** Skin scheme */
		function skin_scheme( $schemes, $data ){
			return cloudfw_add_skin_scheme( 'shortcode',
				$schemes,
				array(
					'type'      =>  'module-set',
					'title'     =>  __('Button Colors','cloudfw'),
					'closable'  =>  true,
					'state'     =>  'closed',
					'layout'    =>  'subtab',
					'data'      =>  array(


						## SubTab Item
						array(
							'type'      =>  'tabs',
							'tab_id'    =>  'tab:button-primary',
							'tab_title' =>  __('Primary Button Color','cloudfw'),
							'data'      =>  array(

								## Module Item
								array(
									'type'      =>  'module',
									'ucode'     =>  'BUTTON, PRIMARY',
									'title'     =>  __('Primary Button Color','cloudfw'),
									'title'     =>  __('Background Color','cloudfw'),
									'data'      =>  array(
										## Element
										array(
											'type'      =>  'gradient',
											'id'        =>  cloudfw_sanitize('primary_button','gradient'),
											'value'     =>  $data['primary_button']['gradient'],
										), // #### element: 0

									)

								),

								## Module Item
								array(
									'type'      =>  'module',
									'title'     =>  array( __('Text Color','cloudfw'), __('Text Shadow Color','cloudfw')),
									'layout'    =>  'split',
									'data'      =>  array(
										## Element
										array(
											'type'      =>  'color',
											'style'     =>  'horizontal',
											'id'        =>  cloudfw_sanitize('primary_button','color'),
											'value'     =>  $data['primary_button']['color'],

										),

										## Element
										array(
											'type'      =>  'color',
											'style'     =>  'horizontal',
											'id'        =>  cloudfw_sanitize('primary_button','text-shadow color'),
											'value'     =>  $data['primary_button']['text-shadow']['color'],

										),

									)

								),

							)

						),

						## SubTab Item
						array(
							'type'      =>  'tabs',
							'tab_id'    =>  'tab:button-secondary',
							'tab_title' =>  __('Secondary Button Color','cloudfw'),
							'data'      =>  array(

								## Module Item
								array(
									'type'      =>  'module',
									'ucode'     =>  'BUTTON, SECONDARY',
									'title'     =>  array( __('Border Color','cloudfw'), __('Text Color','cloudfw')),
									'layout'    =>  'split',
									'data'      =>  array(

										array(
											'type'      =>  'color',
											'style'     =>  'horizontal',
											'id'        =>  cloudfw_sanitize('secondary_button','border-color'),
											'value'     =>  $data['secondary_button']['border-color'],
										), // #### element: 0


										## Element
										array(
											'type'      =>  'color',
											'style'     =>  'horizontal',
											'id'        =>  cloudfw_sanitize('secondary_button','color'),
											'value'     =>  $data['secondary_button']['color'],

										),

									)

								),

								## Module Item
								array(
									'type'      =>  'module',
									'ucode'     =>  'BUTTON, SECONDARY, HOVER',
									'title'     =>  array( __('Border Color Hover','cloudfw'), __('Text Color Hover','cloudfw')),
									'layout'    =>  'split',
									'data'      =>  array(

										array(
											'type'      =>  'color',
											'style'     =>  'horizontal',
											'id'        =>  cloudfw_sanitize('secondary_button_hover','border-color'),
											'value'     =>  $data['secondary_button_hover']['border-color'],
										), // #### element: 0


										## Element
										array(
											'type'      =>  'color',
											'style'     =>  'horizontal',
											'id'        =>  cloudfw_sanitize('secondary_button_hover','color'),
											'value'     =>  $data['secondary_button_hover']['color'],

										),

									)

								),

								## Module Item
								array(
									'type'      =>  'module',
									'ucode'     =>  'BUTTON, SECONDARY',
									'title'     =>  array( __('Border Color','cloudfw') . ' ' . __('(with Dark Background)','cloudfw'), __('Text Color','cloudfw')  . ' ' . __('(with Dark Background)','cloudfw') ),
									'layout'    =>  'split',
									'data'      =>  array(

										array(
											'type'      =>  'color',
											'style'     =>  'horizontal',
											'id'        =>  cloudfw_sanitize('secondary_button_dark','border-color'),
											'value'     =>  $data['secondary_button_dark']['border-color'],
										), // #### element: 0


										## Element
										array(
											'type'      =>  'color',
											'style'     =>  'horizontal',
											'id'        =>  cloudfw_sanitize('secondary_button_dark','color'),
											'value'     =>  $data['secondary_button_dark']['color'],

										),

									)

								),

								## Module Item
								array(
									'type'      =>  'module',
									'ucode'     =>  'BUTTON, SECONDARY, HOVER',
									'title'     =>  array( __('Border Color Hover','cloudfw') . ' ' . __('(with Dark Background)','cloudfw'), __('Text Color Hover','cloudfw') . ' ' . __('(with Dark Background)','cloudfw')),
									'layout'    =>  'split',
									'data'      =>  array(

										array(
											'type'      =>  'color',
											'style'     =>  'horizontal',
											'id'        =>  cloudfw_sanitize('secondary_button_hover_dark','border-color'),
											'value'     =>  $data['secondary_button_hover_dark']['border-color'],
										), // #### element: 0


										## Element
										array(
											'type'      =>  'color',
											'style'     =>  'horizontal',
											'id'        =>  cloudfw_sanitize('secondary_button_hover_dark','color'),
											'value'     =>  $data['secondary_button_hover_dark']['color'],

										),

									)

								),



							)

						),

															
					)

				),

				5 // seq
				
			);

		}


		/** Typo map */
		function typo_map( $map ){
			cloudfw_add_typo_setting( $map, 'button', '.btn');
			cloudfw_add_typo_setting( $map, 'button_normal', '.btn, .btn-normal', array( 'font-size' => 12 ));
			cloudfw_add_typo_setting( $map, 'button_large', '.btn.btn-large', array( 'font-size' => 16 ));
			cloudfw_add_typo_setting( $map, 'button_small', '.btn.btn-small', array( 'font-size' => 11 ));
			cloudfw_add_typo_setting( $map, 'button_mini', '.btn.btn-mini', array( 'font-size' => 10 ));

			return $map;
		}


		/** Typo Scheme */
		function typo_scheme( $scheme, $data, $number ){

			$scheme[ cloudfw_id_for_sequence( $scheme, $number ) ] = array(
				'type'          =>  'container',
				'width'         =>  940,
				'footer'        =>  false,
				'title'         =>  __('Buttons','cloudfw'),
				'data'          =>  array(
				
					array(
						'type'      =>  'typo-set',
						'title'     =>  __('Button Text','cloudfw'),
						'id'        =>  cloudfw_sanitize('button'),
						'value'     =>  $data['button'],
						'data'      =>  array( 
							'line-height'     => false,             
							'letter-spacing'  => false,             
							'font-size'       => false,             
						)
						
					),

					array(
						'type'      =>  'typo-set',
						'title'     =>  __('Button Text(Large Size)','cloudfw'),
						'id'        =>  cloudfw_sanitize('button_large'),
						'value'     =>  $data['button_large'],
						'data'      =>  array( 
							'line-height'     => false,     
						)
						
					),

					array(
						'type'      =>  'typo-set',
						'title'     =>  __('Button Text(Normal Size)','cloudfw'),
						'id'        =>  cloudfw_sanitize('button_normal'),
						'value'     =>  $data['button_normal'],
						'data'      =>  array( 
							'line-height'     => false,     
						)
						
					),

					array(
						'type'      =>  'typo-set',
						'title'     =>  __('Button Text(Small Size)','cloudfw'),
						'id'        =>  cloudfw_sanitize('button_small'),
						'value'     =>  $data['button_small'],
						'data'      =>  array( 
							'line-height'     => false,     
						)
						
					),

					array(
						'type'      =>  'typo-set',
						'title'     =>  __('Button Text(Mini Size)','cloudfw'),
						'id'        =>  cloudfw_sanitize('button_mini'),
						'value'     =>  $data['button_mini'],
						'data'      =>  array( 
							'line-height'     => false,     
						)
						
					),
				
				) 


			);

			return $scheme;


		}



	}

}


if ( ! function_exists('cloudfw_create_button') ) {
	function cloudfw_create_button( $atts = array(), $text ){
		static $cloudfw_button_crator;

		if ( !class_exists('CloudFw_Shortcode_Buttons') )
			return;

		if ( !isset( $cloudfw_button_crator ) )
			$cloudfw_button_crator = new CloudFw_Shortcode_Buttons(); 

		echo $cloudfw_button_crator->shortcode( $atts, $text );
	}
}


/**
 *  CloudFw Predefined Buttons
 *
 *  @hook: cloudfw_buttons
 *  @since 1.0
 */
function cloudfw_button_array() {

	$cloudfw_button_colors = array(); 
	$cloudfw_button_colors["btn-primary"]       = __('Primary Color','cloudfw');
	$cloudfw_button_colors["btn-secondary"]     = __('Secondary Color','cloudfw');
	$cloudfw_button_colors["btn-secondary muted"] = __('Muted Secondary Color','cloudfw');
	$cloudfw_button_colors["btn-blue"]          = __('Blue','cloudfw');
	$cloudfw_button_colors["btn-grey"]          = __('Grey','cloudfw');
	$cloudfw_button_colors["btn-dark-grey"]     = __('Dark Grey','cloudfw');
	$cloudfw_button_colors["btn-light-green"]   = __('Light Green','cloudfw');
	$cloudfw_button_colors["btn-green"]         = __('Green','cloudfw');
	$cloudfw_button_colors["btn-aqua"]          = __('Aqua','cloudfw');
	$cloudfw_button_colors["btn-red"]           = __('Red','cloudfw');
	$cloudfw_button_colors["btn-dark-red"]      = __('Dark Red','cloudfw');
	$cloudfw_button_colors["btn-yellow"]        = __('Yellow','cloudfw');
	$cloudfw_button_colors["btn-orange"]        = __('Orange','cloudfw');
	$cloudfw_button_colors["btn-dark"]          = __('Dark','cloudfw');
	$cloudfw_button_colors["btn-black"]         = __('Black','cloudfw');


	return apply_filters('cloudfw_buttons', $cloudfw_button_colors);
}

/**
 *  Prepare Button Colors Array
 *
 *  @since 1.0
 */
function cloudfw_admin_loop_button_colors(){
	if ( cloudfw_vc_isset( __FUNCTION__, 'cache' ) )
		return cloudfw_vc_get( __FUNCTION__, 'cache' );

	$out = array(); 
	$cloudfw_button_colors = cloudfw_button_array();


	$colors = cloudfw_walk_options( array( 
		'id'                => 'indicator',
		'name'              => 'name',
	), cloudfw_get_option('button_colors'), 'indicator' );

	$cloudfw_custom_colors = array(); 
	$custom_colors = array(); 
	if ( !empty($colors) && is_array($colors) ) {
		foreach ($colors as $id => $color) {
			if ( empty($color["name"]) )
				continue;

			$cloudfw_custom_colors[ $id ] = $color["name"];
		}
	}

	if ( !empty($cloudfw_button_colors) ) {
		$out[ __('Predefined Colors','cloudfw') ] = $cloudfw_button_colors; 
	}
 
	if ( !empty($cloudfw_custom_colors) ) {
		$out[ __('Custom Colors','cloudfw') ] = $cloudfw_custom_colors; 
	}

	return cloudfw_vc_set( __FUNCTION__, 'cache', $out );
}