<?php
/*
 * Plugin Name: Tagline Box
 * Plugin URI: http://cloudfw.net
 * Description: 
 * Version: 1.0
 * Author: Orkun Gürsel
 * Author URI: http://orkungursel.com
 */
cloudfw_register_shortcode( 'CloudFw_Composer_Tagline_Box', 'boxed_content', 'columns', 15 );
if ( ! class_exists('CloudFw_Composer_Tagline_Box') ) {
	class CloudFw_Composer_Tagline_Box extends CloudFw_Shortcodes {

		function get_called_class(){ return get_class($this); }


		/** Add the shortcode to the composer */
		function composer(){
			return array(
				'composer'		=> true,
				'droppable'		=> true,
				'icon'			=> 'boxed-content',
				'group'			=> 'composer_widgets',
				'line'			=> 210,
				'options'		=> array(
					'title'				=> __('Boxed Content','cloudfw'),
					'column'			=> '1/1',
					'allow_columns'		=> true,
					'allow_edit'		=> true,
				)
			);
		}

		/** Run */
		function shortcode( $atts = array(), $content =  NULL, $case = NULL ) {
			extract(shortcode_atts(array(
				'id'               => '',
				'class'            => '',
				'type'             => '',
				'style'            => 'custom',
				'device'           => '',
				
				'gradient_start'   => '',
				'gradient_stop'    => '',
				
				'bg_image'         => '',
				'bg_position'      => '',
				'bg_attachment'    => '',

				'border_color'     => '',
				'border_style'     => '',
				'border_width'     => '',
				
				'shadow'           => 0,
				'shadow_color'     => '',
				'shadow_direction' => '',

				'height'           => '',
				'color'            => '',
				'link_color'       => '',
				'link_hover_color' => '',
				'radius'           => '',
				
				'link'             => '',
				'target'           => '',
				
				'margin_top'       => '',
				'margin_bottom'    => '',
				'padding_top'      => '',
				'padding_bottom'   => '',
			), _check_onoff_false($atts)));

			$id = trim( $id ); 
			if ( empty( $id ) ) {
				$id = cloudfw_id( 'tagline' );
			}

			$cover = false;
			$wrap_classes = array();
			$wrap_classes[] = 'ui--tagline-box-wrapper'; 
			$wrap_classes[] = 'ui--animation'; 
			$wrap_classes[] = 'clearfix'; 
			$wrap_classes[] = cloudfw_visible( $device ); 
			$wrap_classes[] = $class;

			$classes = array();
			$classes[] = 'ui--tagline-box'; 
			$classes[] = 'ui-row'; 
			$classes[] = 'clearfix';

			if ( $style == 'custom' ) {
				$classes[] = 'ui--tagline-box-custom-color'; 
			} elseif ( $style == 'accent' ) {
				$classes[] = 'ui--accent-gradient'; 
				$classes[] = 'ui--accent-color'; 
			} else {
				$classes[] = 'ui--gradient-grey'; 
				$classes[] = 'ui--box';
			}

			if ( !empty( $radius ) ) {
				$classes[] = $radius;
			}


			if ( empty($gradient_start) ) {
				$gradient_start = $gradient_stop;
			} elseif ( empty($gradient_stop) ) {
				$gradient_stop = $gradient_start;
			}

			if ( empty($border_color) ) {
				$border_style = ''; 
				$border_width = ''; 

			} else {

				if ( empty($border_width) ) {
					$border_width = 1; 
				}

				if ( empty($border_style) ) {
					$border_style = 'solid'; 
				}

			}

			$css = '';
			$css .= cloudfw_make_style( array( 
					"html #{$id}",
				), array( 
					'height' 		=> $height,
					'gradient' 		=> array( $gradient_start, $gradient_stop ),
					'border-style'  => $border_style,
					'border-width'  => $border_width,
					'border-color'  => $border_color,
				), FALSE, FALSE 
			);

			$css .= cloudfw_make_style( array( 
					"html #{$id}",
					"html #{$id} p",
					"html #{$id} h1",
					"html #{$id} h2",
					"html #{$id} h3",
					"html #{$id} h4",
					"html #{$id} h5",
					"html #{$id} h6",
					"html #{$id} .heading",
				), array( 
					'color'  => $color,
					'+text-shadow' => array(
						'color'     => $shadow_color, 
						'direction' => $shadow_direction, 
					)
				), FALSE, FALSE 
			);

			$css .= cloudfw_make_style( array( 
					"html #{$id} a",
				), array( 
					'color'  => $link_color,
				), FALSE, FALSE 
			);

			$css .= cloudfw_make_style( array( 
					"html #{$id} a:hover",
				), array( 
					'color'  => $link_hover_color,
				), FALSE, FALSE 
			);

			cloudfw_vc_set( 'css', $id, $css );
			unset( $css );



			$out  = '';
			$out .= "<div ". 
				cloudfw_make_class( $wrap_classes, true ) .
				cloudfw_make_style_attribute( array( 
					'margin-top'     => $margin_top,
					'margin-bottom'  => $margin_bottom,
				), FALSE, TRUE ) .
			">";
				$out .= "<div ". 
					cloudfw_make_id( $id ) .
					cloudfw_make_class( $classes, true ) .
					cloudfw_make_style_attribute( array( 
						'padding-top'    => $padding_top,
						'padding-bottom' => $padding_bottom,
					), FALSE, TRUE ) .
				">";
					$out .= do_shortcode( $content );

				/** Link */
				if ( ! empty( $link ) ) {

					$link_classes = array();
					$link_classes[] = 'ui--tagline-box-block-link';

					$link_attributes = array();
					$link_attributes['href'] = $link;
					$link_attributes['target'] = $target;
					$link_attributes['class'] = cloudfw_make_class( $link_classes, false );

					$out .= "<a" . 
						cloudfw_make_attribute( $link_attributes, false ) .
					"></a>";
				}

				$out .= "</div>";

				if ( $shadow ) {
					$out .= cloudfw_UI_shadow( $shadow );
				}

			$out .= "</div>";

			return $out; 
		}

		/** Scheme */
		function scheme() {
			return array(
				'title'		=>	__('Boxed Content','cloudfw'),
				'script'	=> array(
					'shortcode' 	=> 'boxed_content',
					'tag_close'  	=> true,
					'attributes' 	=> array( 
						'id'               => array( 'e' => 'custom_id' ),
						'class'            => array( 'e' => 'custom_class' ),
						'device'           => array( 'e' => 'the_device' ),
						'content'          => array( 'e' => 'content' ),
						'radius'           => array( 'e' => 'box_radius' ),
						
						'shadow'           => array( 'e' => 'shadow' ),
						'shadow_color'     => array( 'e' => 'shadow_color' ),
						'shadow_direction' => array( 'e' => 'shadow_direction' ),
						
						'gradient_start'   => array( 'e' => 'box_gradient_0' ),
						'gradient_stop'    => array( 'e' => 'box_gradient_1' ),
						
						'bg_image'         => array( 'e' => 'background_image' ),
						'bg_position'      => array( 'e' => 'background_position' ),
						'bg_attachment'    => array( 'e' => 'background_attachment' ),
						
						'border_color'     => array( 'e' => 'border_color' ),
						'border_style'     => array( 'e' => 'border_style' ),
						'border_width'     => array( 'e' => 'border_width' ),
						
						'link'             => array( 'e' => 'link' ),
						'target'           => array( 'e' => 'target' ),
						
						'height'           => array( 'e' => 'box_height' ),
						'color'            => array( 'e' => 'box_color' ),
						'link_color'       => array( 'e' => 'box_link_color' ),
						'link_hover_color' => array( 'e' => 'box_link_hover_color' ),
						
						'margin_top'       => array( 'e' => 'margin_top' ),
						'margin_bottom'    => array( 'e' => 'margin_bottom' ),
						'padding_top'      => array( 'e' => 'padding_top' ),
						'padding_bottom'   => array( 'e' => 'padding_bottom' ),
					)
				),
				'data'		=>  $this->load_scheme( __FILE__ )
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