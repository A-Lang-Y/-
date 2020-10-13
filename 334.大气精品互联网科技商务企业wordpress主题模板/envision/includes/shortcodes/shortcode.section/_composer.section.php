<?php
/*
 * Plugin Name: Section
 * Plugin URI: http://cloudfw.net
 * Description: 
 * Version: 1.0
 * Author: Orkun Gürsel
 * Author URI: http://orkungursel.com
 */
cloudfw_register_shortcode( 'CloudFw_Composer_Section', 'section', 'columns', 15 );
if ( ! class_exists('CloudFw_Composer_Section') ) {
	class CloudFw_Composer_Section extends CloudFw_Shortcodes {

		function get_called_class(){ return get_class($this); }


		/** Add the shortcode to the composer */
		function composer(){
			return array(
				'composer'      => true,
				'droppable'     => true,
				'icon'          => 'panel-split',
				'group'         => 'composer_layouts',
				'line'          => 2,
				'options'       => array(
					'title'             => __('Fullwidth Section','cloudfw'),
					'column'            => '1/1',
					'allow_columns'     => false,
					'allow_edit'        => true,
				)
			);
		}

		/** Run */
		function shortcode( $atts = array(), $content =  NULL, $case = NULL ) {
			extract(shortcode_atts(array(
				'id'             => '',
				'class'          => '',
				'style_id'       => '',
				'style'          => '',
				'device'         => '',
				'margin_top'     => '',
				'margin_bottom'  => '',
				'padding_top'    => '',
				'padding_bottom' => '',
			), _check_onoff_false($atts)));

			$cover = false;
			$classes = array();
			$classes[] = 'fullwidth-container'; 
			$classes[] = 'ui--section'; 
			$classes[] = 'clearfix'; 
			$classes[] = cloudfw_visible( $device ); 
			$classes[] = $class;


			if ( !empty($style_id) ) {

				$current_custom_color = cloudfw_walk_options( array( 
					'id'                    => 'indicator',
					'name'                  => 'name',
					'gradient_start'        => 'gradient_0',
					'gradient_stop'         => 'gradient_1',
					'background_image'      => 'background_image',
					'background_position'   => 'background_position',
					'background_style'      => 'background_style',
					'border_top'            => 'border_top',
					'border_bottom'         => 'border_bottom',
					'color'                 => 'color',
					'heading_color'         => 'heading_color',
					'link_color'            => 'link_color',
					'link_decoration'       => 'link_decoration',
					'link_hover_color'      => 'link_hover_color',
					'link_hover_decoration' => 'link_hover_decoration',
					'shadow_style'          => 'shadow_style',
					'overflow'              => 'overflow',
					'parallax'              => 'parallax',
				), cloudfw_get_option('section_styles'), 'indicator', $style_id );

				if ( !empty($current_custom_color['shadow_style']) ) {
					$classes[] = $current_custom_color['shadow_style']; 
				}

				if ( $current_custom_color['parallax'] == 'yes' ) {
					$classes[] = 'cloudfw-ui-parallax-effect'; 
				}

				if ( isset($current_custom_color) && $current_custom_color ) {

					$classes[] = $style_id; 

					if ( !cloudfw_vc_isset( 'css', 'section-' . $current_custom_color['id'] ) ) {
						$custom_color_css  = '';

						if ( empty($current_custom_color['gradient_start']) ) {
							$current_custom_color['gradient_start'] = $current_custom_color['gradient_stop'];
						} elseif ( empty($current_custom_color['gradient_stop']) ) {
							$current_custom_color['gradient_stop'] = $current_custom_color['gradient_start'];
						}

						if ( !empty($current_custom_color['background_image']) && $current_custom_color['background_style'] == 'cover' ) {
							$current_custom_color['background_style'] = NULL;
							$cover = true;
						} else {
							if (empty($current_custom_color['background_image'])) {
								$current_custom_color['background_style'] = NULL;

							} else {
								if (empty($current_custom_color['background_style'])) {
									$current_custom_color['background_style'] = 'repeat';
								}
								
							}

						}

						$custom_class = 'html #page-content .' . $current_custom_color['id']; 

						$custom_color_css .= $custom_class . ' {';
						$custom_color_css .= cloudfw_make_style_attribute( array( 
							'color'                      => $current_custom_color['color'],
							'gradient'                   => array($current_custom_color['gradient_start'], $current_custom_color['gradient_stop']),
							$cover ? 'background-cover' : '!background-image-no-filter' 
														 => $current_custom_color['background_image'],
							'!background-repeat'         => $current_custom_color['background_style'],
							'!background-position'       => $current_custom_color['background_position'],
							'+border-top'                => $current_custom_color['border_top'],
							'+border-bottom'             => $current_custom_color['border_bottom'],
							'overflow'                   => $current_custom_color['overflow'],
						), FALSE, FALSE );
						$custom_color_css .= '} ';

						if ( $cover ) {
							$custom_color_css .= 'html.old-browser #page-content .'.$current_custom_color['id'] . ' {';
							$custom_color_css .= cloudfw_make_style_attribute( array( 
								'background-ie'          => $current_custom_color['background_image'],
							), FALSE, FALSE );
							$custom_color_css .= '} ';
						}

						$custom_color_css .= $custom_class . ' p {';
						$custom_color_css .= cloudfw_make_style_attribute( array( 
							'color'              => $current_custom_color['color'],
						), FALSE, FALSE );
						$custom_color_css .= '} ';

						$custom_color_css .= $custom_class . ' h1, ';
						$custom_color_css .= $custom_class . ' h2, ';
						$custom_color_css .= $custom_class . ' h3, ';
						$custom_color_css .= $custom_class . ' h4, ';
						$custom_color_css .= $custom_class . ' h5, ';
						$custom_color_css .= $custom_class . ' h6, ';
						$custom_color_css .= $custom_class . ' .heading-colorable {';
						$custom_color_css .= cloudfw_make_style_attribute( array( 
							'color'              => $current_custom_color['heading_color'],
						), FALSE, FALSE );
						$custom_color_css .= '} ';

						$custom_color_css .= $custom_class . ' a {';
						$custom_color_css .= cloudfw_make_style_attribute( array( 
							'color'              => $current_custom_color['link_color'],
							'text-decoration'    => $current_custom_color['link_decoration'],
						), FALSE, FALSE );
						$custom_color_css .= '} ';

						$custom_color_css .= $custom_class . ' a:hover {';
						$custom_color_css .= cloudfw_make_style_attribute( array( 
							'color'              => $current_custom_color['link_hover_color'],
							'text-decoration'    => $current_custom_color['link_hover_decoration'],
						), FALSE, FALSE );
						$custom_color_css .= '} ';


						cloudfw_vc_set( 'css', 'section-' . $current_custom_color['id'], $custom_color_css );
						unset( $custom_color_css );

					}

				}

				if ( isset($current_custom_color['gradient_stop']) && cloudfw_color_analysis( $current_custom_color['gradient_stop'], 'bool' ) === 'dark' ) {
					$classes[] = 'color--dark'; 
				}

			}

			$out  = '';
			$out .= "<div ". 
				cloudfw_make_id( $style_id ) .
				cloudfw_make_class($classes, true) .
				cloudfw_make_style_attribute( array( 
					'margin-top'    => $margin_top,
					'margin-bottom' => $margin_bottom,
					'padding-top'    => $padding_top,
					'padding-bottom' => $padding_bottom,
				), FALSE, TRUE )
			.">";
				$out .= "<div class=\"container\">";
					$out .= do_shortcode($content);
				$out .= "</div>";
			$out .= "</div><!-- /.fullwidth-container -->";

			return $out; 
		}

		/** Scheme */
		function scheme() {
			return array(
				'title'     =>  __('Fullwidth Section','cloudfw'),
				'script'    => array(
					'shortcode'     => 'section',
					'tag_close'     => true,
					'attributes'    => array( 
						'id'             => array( 'e' => 'custom_id' ),
						'class'          => array( 'e' => 'custom_class' ),
						'style_id'       => array( 'e' => 'style_id' ),
						'device'         => array( 'e' => 'the_device' ),
						'content'        => array( 'e' => 'content' ),
						'margin_top'     => array( 'e' => 'margin_top' ),
						'margin_bottom'  => array( 'e' => 'margin_bottom' ),
						'padding_top'    => array( 'e' => 'padding_top' ),
						'padding_bottom' => array( 'e' => 'padding_bottom' ),
					)
				),
				'data'      =>  $this->load_scheme( __FILE__ )
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