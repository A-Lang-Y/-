<?php
/*
 * Plugin Name: Tagline Box
 * Plugin URI: http://cloudfw.net
 * Description:
 * Version: 1.0
 * Author: Orkun Gürsel
 * Author URI: http://orkungursel.com
 */
cloudfw_register_shortcode( 'CloudFw_Composer_Video_Background', 'video_background' );
if ( ! class_exists('CloudFw_Composer_Video_Background') ) {
	class CloudFw_Composer_Video_Background extends CloudFw_Shortcodes {

		function get_called_class(){ return get_class($this); }

		function CloudFw_Composer_Video_Background(){
			add_action('init', array( &$this, 'register_sources' ));
		}

		function register_sources(){
			wp_register_script ('theme-video-background-init',  cloudfw_relative_path( dirname(__FILE__) ).'/source/jquery.video_background.init.js', array( 'jquery' ), cloudfw_get_combined_version(), false);
		}

		/** Add the shortcode to the composer */
		function composer(){
			return array(
				'composer'      => true,
				'droppable'     => true,
				'icon'          => 'video',
				'group'         => 'composer_layouts',
				'line'          => 3,
				'options'       => array(
					'title'             => __('Video/Image Background','cloudfw'),
					'column'            => '1/1',
					'allow_columns'     => false,
					'allow_edit'        => true,
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

				'source_m4v'       => '',
				'source_ogv'       => '',
				'source_webmv'     => '',
				'poster'           => '',
				'poster_style'     => 'cover',
				'loop'             => true,

				'opacity'          => '',
				'gradient_start'   => '',
				'gradient_stop'    => '',
				'color'            => '',
				'link_color'       => '',
				'link_hover_color' => '',

				'video_width'      => '',
				'video_height'     => '',
				
				'full_height'      => false,

				'margin_top'       => '',
				'margin_bottom'    => '',
				'padding_top'      => '',
				'padding_bottom'   => '',
			), _check_onoff_false($atts)));

			$video_exists = ! empty( $source_m4v ) || ! empty( $source_webmv ) || ! empty( $source_ogv );

			$id = trim( $id );
			if ( empty( $id ) ) {
				$id = cloudfw_id( 'video-background' );
			}

			$cover = false;
			$wrap_classes = array();
			$wrap_classes[] = 'ui--video-background-wrapper';
			$wrap_classes[] = 'fullwidth-content';
			$wrap_classes[] = 'clearfix';
			$wrap_classes[] = cloudfw_visible( $device );
			$wrap_classes[] = $class;
			
			if ( $full_height ) {
				$wrap_classes[] = 'ui--video-background-v-center';
			}

			$bg_classes = array();
			$bg_classes[] = 'ui--video-background';

			$video_classes = array();
			$video_classes[] = 'ui--video-background-video';
			$video_classes[] = cloudfw_visible( 'desktop-tablet' );

			$poster_classes = array();
			$poster_classes[] = 'ui--video-background-poster';

			if ( $video_exists ) {
				//$poster_classes[] = cloudfw_visible( 'phone' );
			}

			$content_classes = array();
			$content_classes[] = 'ui--video-background-content';
			$content_classes[] = 'container';
			$content_classes[] = 'clearfix';


			if ( empty($gradient_start) ) {
				$gradient_start = $gradient_stop;
			} elseif ( empty($gradient_stop) ) {
				$gradient_stop = $gradient_start;
			}

			if ( cloudfw_color_analysis( $gradient_stop, 'bool' ) === 'dark' ) {
				$wrap_classes[] = 'color--dark';
			}

			$css = '';
			$css .= cloudfw_make_style( array(
					"html #{$id} .ui--video-background",
				), array(
					'opacity'       => $opacity,
				), FALSE, FALSE
			);

			$css .= cloudfw_make_style( array(
					"html #{$id} .ui--video-background .ui--gradient",
				), array(
					'gradient'      => array( $gradient_start, $gradient_stop ),
				), FALSE, FALSE
			);


			if ( !empty($poster) && $poster_style == 'cover' ) {
				$poster_style = NULL;
				$cover = true;
			} else {
				if (empty($poster)) {
					$poster_style = NULL;

				} else {
					if (empty($poster_style)) {
						$poster_style = 'repeat';
					}
					
				}

			}


			if ( isset($cover) && $cover ) {
				$css .= cloudfw_make_style( array(
						"html #{$id} .ui--video-background-poster",
					), array(
						'background-ie'     => $poster,
						'background-image'  => $poster,
					), FALSE, FALSE
				);
			} else {
				$css .= cloudfw_make_style( array(
						"html #{$id} .ui--video-background-poster",
					), array(
						'background-image'  => $poster,
						'background-repeat' => $poster_style,
					), FALSE, FALSE
				);				
			}

			$css .= cloudfw_make_style( array(
					"html #{$id} .ui--video-background-content (|p|h*)",
				), array(
					'color'  => $color,
				), FALSE, FALSE
			);

			$css .= cloudfw_make_style( array(
					"html #{$id} .ui--video-background-content a",
				), array(
					'color'  => $link_color,
				), FALSE, FALSE
			);

			$css .= cloudfw_make_style( array(
					"html #{$id} .ui--video-background-content a:hover",
				), array(
					'color'  => $link_hover_color,
				), FALSE, FALSE
			);

			cloudfw_vc_set( 'css', $id, $css );
			unset( $css );

			$out  = '';
			$out .= "<div ".
				cloudfw_make_id( $id ) .
				cloudfw_make_class( $wrap_classes, true ) .
				cloudfw_make_style_attribute( array(
					'margin-top'     => $margin_top,
					'margin-bottom'  => $margin_bottom,
				), FALSE, TRUE ) .
			">";

				/** Video */
				$out .= "<div ".
					cloudfw_make_class( $video_classes, true ) .
				">";

					wp_enqueue_script ('theme-fillparent');
					wp_enqueue_script ('theme-video-background-init');

					if ( $video_exists ) {

						/** Video */ 
						$out .= "<video". 
							cloudfw_make_attribute( array( 
								'autoplay'  => 'autoplay',
								'loop'      => $loop ? 'loop' : NULL,           
								'muted'     => 'muted',
								//'poster'    => $poster,
								'width'     => $video_width,
								'height'    => $video_height,
							), FALSE ) .
						">";

							if ( ! empty( $source_m4v ) ) {
								$out .= "<source". 
									cloudfw_make_attribute( array( 
										'src'   => $source_m4v,
										'type'  => 'video/mp4',
									), FALSE ) .
								" />";
							}

							if ( ! empty( $source_webmv ) ) {
								$out .= "<source". 
									cloudfw_make_attribute( array( 
										'src'   => $source_webmv,
										'type'  => 'video/webm',
									), FALSE ) .
								" />";
							}

							if ( ! empty( $source_ogv ) ) {
								$out .= "<source". 
									cloudfw_make_attribute( array( 
										'src'   => $source_ogv,
										'type'  => 'video/ogg',
									), FALSE ) .
								" />";
							}

						$out .= "</video>";
					}


				$out .= "</div>";

				$out .= "<div".
					cloudfw_make_class( $poster_classes, true ) .
				"></div>";


				/** Background */
				$out .= "<div ".
					cloudfw_make_class( $bg_classes, true ) .
				"><div class=\"ui--gradient\"></div></div>";

				/** Content */
				$out .= "<div ".
					cloudfw_make_class( $content_classes, true ) .
					cloudfw_make_style_attribute( array(
						'padding-top'    => $padding_top,
						'padding-bottom' => $padding_bottom,
					), FALSE, TRUE ) .
				">";

					$out .= do_shortcode( $content );

				$out .= "</div>";

			$out .= "</div>";

			return $out;
		}

		/** Scheme */
		function scheme() {
			return array(
				'title'     =>  __('Video/Image Background','cloudfw'),
				'script'    => array(
					'shortcode'     => 'boxed_content',
					'tag_close'     => true,
					'attributes'    => array(
						'id'               => array( 'e' => 'custom_id' ),
						'class'            => array( 'e' => 'custom_class' ),
						'device'           => array( 'e' => 'the_device' ),
						'content'          => array( 'e' => 'content' ),
						'radius'           => array( 'e' => 'box_radius' ),

						'gradient_start'   => array( 'e' => 'box_gradient_0' ),
						'gradient_stop'    => array( 'e' => 'box_gradient_1' ),
						'opacity'          => array( 'e' => 'box_opacity' ),

						'color'            => array( 'e' => 'box_color' ),
						'link_color'       => array( 'e' => 'box_link_color' ),
						'link_hover_color' => array( 'e' => 'box_link_hover_color' ),

						'source_m4v'       => array( 'e' => 'video_source_m4v' ),
						'source_ogv'       => array( 'e' => 'video_source_ogv' ),
						'source_webmv'     => array( 'e' => 'video_source_webmv' ),
						'poster'           => array( 'e' => 'video_poster' ),
						'poster_style'     => array( 'e' => 'video_poster_style' ),
						'loop'             => array( 'e' => 'video_loop', 'onoff' => true ),

						'video_width'      => array( 'e' => 'video_width' ),
						'video_height'     => array( 'e' => 'video_height' ),
						'full_height'      => array( 'e' => 'full_height' ),

						'margin_top'       => array( 'e' => 'margin_top' ),
						'margin_bottom'    => array( 'e' => 'margin_bottom' ),
						'padding_top'      => array( 'e' => 'padding_top' ),
						'padding_bottom'   => array( 'e' => 'padding_bottom' ),
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