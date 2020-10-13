<?php
/*
 * Plugin Name: Video HTML5 Embed
 * Plugin URI: http://cloudfw.net
 * Description: 
 * Version: 1.0
 * Author: Orkun Gürsel
 * Author URI: http://orkungursel.com
 * Shortcode:  [video]
 */
cloudfw_register_shortcode( 'CloudFw_Shortcode_Video_HTML5', 'html5_player', 'advanced', 55 );
if ( ! class_exists('CloudFw_Shortcode_Video_HTML5') ) {
	class CloudFw_Shortcode_Video_HTML5 extends CloudFw_Shortcodes {
		function get_called_class(){ return get_class($this); }

		public $do_before = false;
		var $instant = 0;

		/** Add the shortcode to the composer */
		function composer(){
			return array(
				'composer'		=> true,
				'ajax'			=> true,
				'icon'			=> 'video_html5',
				'group'			=> 'composer_widgets',
				'line'			=> 370,
				'options'		=> array(
					'title'				=> __('HTML5 Video/Audio','cloudfw'),
					'column'			=> '1/1',
					'allow_columns'		=> true,
				)
			);
		}

		function CloudFw_Shortcode_Video_HTML5(){
			add_action('init', array( &$this, 'register_sources' ));
		}

		function register_sources(){
			wp_register_script ('theme-jplayer',  cloudfw_relative_path( dirname(__FILE__) ).'/jplayer/jquery.jplayer.js', array( 'jquery' ), cloudfw_get_combined_version(), false);
		}

		/** Run */
		function shortcode( $atts = array(), $content = NULL ) {
			extract(shortcode_atts(array(
				'type'         => 'video',
				'source_m4v'   => '',
				'source_ogv'   => '',
				'source_webmv' => '',
				'poster'       => '',
				'autoplay'     => '',
				'ratio'		   => '16:9',
				'shadow'       => NULL,

				'margin_top'		=> NULL,
				'margin_bottom'		=> NULL,
			), _check_onoff_false($atts)));

			if ( is_feed() ) {
				return '';
			}

			if ( empty($ratio) ) {
				$ratio = '16:9'; 
			}

			$this->instant++;
			$player_id = cloudfw_id( 'html5-player-id' );

			$classes = array(); 
			$classes[] = 'jp-video';
			$classes[] = 'ui--video';
			$classes[] = 'ui--box';
			$classes[] = 'no-effect';


			if ( $type == 'audio' ) {
				$ratio_padding = '';
				$classes[] = 'type--audio';
				$id = cloudfw_id( 'html5-audio' );

			} else {

				$id = cloudfw_id( 'html5-video' );
				if ( !empty($ratio) ) {
					$classes[] = 'ui--video-' . str_replace(':', '-', $ratio) ;
				}

				$ratio_padding = cloudfw_match_ratio_percent( $ratio );
				$classes[] = 'type--video';

			}

			cloudfw_vc_set ( 'load_css', 'theme-css-jplayer', cloudfw_relative_path( dirname(__FILE__) ).'/jplayer/skin/jplayer.skin.css' );
			wp_enqueue_script('theme-jplayer');

			$out  = '';

					$out .= '
						<div class="ui--video-wrapper ui--animation clearfix" '.
							cloudfw_make_style_attribute( array(
								'margin-top'     => $margin_top,
								'margin-bottom'  => $margin_bottom,
							), FALSE, TRUE )
						.'>
							<div id="'. $player_id .'"'.
								cloudfw_make_class( $classes, TRUE ) .
								cloudfw_make_style_attribute( array(
									'padding-bottom'    => $ratio_padding,
								), FALSE, TRUE ) .
								
							'>
								<div class="jp-type-single">
									<div id="'. $id .'" class="jp-jplayer"></div>
									<div class="jp-gui">
										<div class="jp-video-play effect">
											<a href="javascript:;" class="jp-video-play-icon" tabindex="1"><i class="fontawesome-play"></i></a>
										</div>
										<div class="jp-interface">
											<div class="jp-progress">
												<div class="jp-seek-bar">
													<div class="jp-play-bar ui--accent-gradient"></div>
												</div>
											</div>

											<div class="jp-controls-holder ui--gradient ui--gradient-grey">
												<ul class="jp-controls">
													<li><a href="javascript:;" class="jp-play" tabindex="1"><i class="fontawesome-play px14"></i></a></li>
													<li><a href="javascript:;" class="jp-pause" tabindex="1"><i class="fontawesome-pause px14"></i></a></li>
													<li><a href="javascript:;" class="jp-stop" tabindex="1"><i class="fontawesome-stop px14"></i></a></li>
													<li>
														<ul class="jp-volume-bar-holder">
															<li class="jp-volume-bar-item"><a href="javascript:;" class="jp-mute" tabindex="1" title="mute"><i class="fontawesome-volume-off px18"></i></a></li>
															<li class="jp-volume-bar-item"><a href="javascript:;" class="jp-unmute" tabindex="1" title="unmute"><i class="fontawesome-volume-down px18"></i></a></li>
															<li class="jp-volume-bar">
																<div class="jp-volume-bar-value"></div>
															</li>
															<li class="jp-volume-bar-item"><a href="javascript:;" class="jp-volume-max" tabindex="1" title="max volume"><i class="fontawesome-volume-up px18"></i></a></li>
														</ul>
													</li>
													<li>
														<div class="jp-time-holder">
															<div class="jp-current-time"></div>
															<div class="jp-time-separator">/</div> 
															<div class="jp-duration"></div>
														</div>
													</li>
													
													<li class="jp-controls-right"><a href="javascript:;" class="jp-full-screen" tabindex="1" title="full screen"><i class="fontawesome-fullscreen px14"></i></a></li>
													<li class="jp-controls-right"><a href="javascript:;" class="jp-restore-screen" tabindex="1" title="restore screen"><i class="fontawesome-resize-small px14"></i></a></li>
												</ul>
											</div>
										</div>
									</div>
									<div class="jp-no-solution">
										<span>Update Required</span>
										To play the media you will need to either update your browser to a recent version or update your <a href="http://get.adobe.com/flashplayer/" target="_blank">Flash plugin</a>.
									</div>
								</div>
							</div>
					';
						$out .= cloudfw_UI_shadow( $shadow );

					$out .= '</div>';

			$out .= '<script type="text/javascript">// <![CDATA[' . PHP_EOL;
			$out .= 'jQuery(document).ready(function(){ "use strict";' . PHP_EOL;
			$out .= '	jQuery("#'. $id .'").jPlayer({' . PHP_EOL;
			$out .= '		ready: function () {' . PHP_EOL;
			$out .= '			jQuery(this).jPlayer("setMedia", {' . PHP_EOL;
			if ( $source_m4v ) {
				$out .= '				m4v: "'. $source_m4v .'",' . PHP_EOL;
			}
			if ( $source_ogv ) {
				$out .= '				ogv: "'. $source_ogv .'",' . PHP_EOL;
			}
			if ( $source_webmv ) {
				$out .= '				webmv: "'. $source_webmv .'",' . PHP_EOL;
			}
			$out .= '				poster: "'. esc_attr( $poster ) .'"' . PHP_EOL;
			$out .= '			});' . PHP_EOL;

			if ( $autoplay ) {
				$out .= ' jQuery(this).jPlayer("play"); ' . PHP_EOL;
			}

			$out .= '		},' . PHP_EOL;
			$out .= '		cssSelectorAncestor: "#'. $player_id .'",' . PHP_EOL;
			$out .= '		swfPath: "'. cloudfw_relative_path( dirname(__FILE__) ) .'/jplayer/",' . PHP_EOL;
			$out .= '		supplied: "webmv, ogv, m4v",' . PHP_EOL;
			$out .= '		size: {' . PHP_EOL;
			$out .= '			width: "100%",' . PHP_EOL;
			$out .= '			height: "400px",' . PHP_EOL;
			$out .= '			cssClass: ""' . PHP_EOL;
			$out .= '		},' . PHP_EOL;
			$out .= '		smoothPlayBar: true,' . PHP_EOL;
			$out .= '		keyEnabled: true' . PHP_EOL;
			$out .= '	});' . PHP_EOL;
			$out .= '});' . PHP_EOL;
			$out .= '// ]]></script>';

			return $out;

		}


		/** Scheme */
		function scheme() {
			return array(
				'title'		=>	__('HTML5 Video/Audio','cloudfw'),
				'script'	=> array(
					'shortcode'  => 'html5_player',
					'tag_close'  => false,
					'attributes' =>	array( 
						'type'    		=> array( 'e' => 'video_type' ),
						'source_m4v'    => array( 'e' => 'video_source_m4v' ),
						'source_ogv'    => array( 'e' => 'video_source_ogv' ),
						'source_webmv'  => array( 'e' => 'video_source_webmv' ),
						'poster'        => array( 'e' => 'video_poster' ),
						'autoplay'      => array( 'e' => 'video_autoplay', 'onoff' => true ),
						'shadow'        => array( 'e' => 'video_shadow' ),
						'margin_top'    => array( 'e' => 'margin_top' ),
						'margin_bottom' => array( 'e' => 'margin_bottom' ),
					),
				),
				'data'		=>	array(

					array(
						'type'		=> 'module',
						'title'		=> __('Media Type','cloudfw'),
						'data'		=> array(

							## Element
							array(
								'type'		=>	'select',
								'id'		=>	'video_type',
								'value'		=>	$this->get_value('video_type'),
								'source'	=>	array(
									'video'			=> __('Video','cloudfw'),
									'audio'			=> __('Audio','cloudfw'),
								),
								'width'		=>	250,

							), // #### element: 0

						)

					),

							array(
								'type'		=> 'module',
								'title'		=> __('Video Source (m4v Format)','cloudfw'),
								'data'		=> array(

									## Element
									array(
										'type'		=>	'text',
										'id'		=>	'video_source_m4v',
										'value'		=>	$this->get_value('video_source_m4v'),
										'width'		=>	400,
									), // #### element: 0

								)

							),

							array(
								'type'		=> 'module',
								'title'		=> __('Video Source (ogv Format)','cloudfw'),
								'data'		=> array(

									## Element
									array(
										'type'		=>	'text',
										'id'		=>	'video_source_ogv',
										'value'		=>	$this->get_value('video_source_ogv'),
										'width'		=>	400,
									), // #### element: 0

								)

							),

							array(
								'type'		=> 'module',
								'title'		=> __('Video Source (webmv Format)','cloudfw'),
								'data'		=> array(

									## Element
									array(
										'type'		=>	'text',
										'id'		=>	'video_source_webmv',
										'value'		=>	$this->get_value('video_source_webmv'),
										'width'		=>	400,
									), // #### element: 0

								)

							),

							array(
								'type'		=> 'module',
								'title'		=> __('Poster Image','cloudfw'),
								'data'		=> array(

									## Element
									array(
										'type'		=>	'upload',
										'id'		=>	'video_poster',
										'value'		=>	$this->get_value('video_poster'),
										'store'		=>	true,
										'library'	=>	true,
										'removable'	=>	true,
									), // #### element: 0

								)

							),

							array(
								'type'		=> 'module',
								'title'		=> __('Auto Play','cloudfw'),
								'data'		=> array(

									## Element
									array(
										'type'		=>	'onoff',
										'id'		=>	'video_autoplay',
										'value'		=>	$this->get_value('video_autoplay', 'FALSE'),
									), // #### element: 0

								)

							),

					array(
						'type'		=> 'mini-section',
						'title'		=> __('Shadow','cloudfw'),
						'data'		=> array(

							array(
								'type'		=> 'module',
								'title'		=> __('Shadow','cloudfw'),
								'data'		=> array(

									## Element
									array(
										'type'		=>	'select',
										'id'		=>	'video_shadow',
										'value'		=>	$this->get_value('video_shadow'),
										'source'	=>	array(
											'type'			=> 'function',
											'function'		=> 'cloudfw_admin_loop_shadows',
										),
										'width'		=>	250,

									), // #### element: 0

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

		/** Skin map */
		function skin_map( $map ){

			$map  -> id      ( 'html5_video_texts' )
			      -> selector( '.jp-controls' )
			      -> sync    ( 'color', 'page_content', 'color', true );

			$map  -> id      ( 'html5_video_links' )
			      -> selector( '.jp-video a, .jp-controls a' )
			      -> sync    ( 'color', 'link', 'color', true );

			$map  -> id      ( 'html5_video_links_hover' )
			      -> selector( '.jp-video a:hover, .jp-controls a:hover' )
			      -> sync    ( 'color', 'link_hover', 'color', true );

			$map  -> id      ( 'html5_video_volume_bar' )
			      -> selector( '.jp-volume-bar-value' )
			      -> sync    ( 'background-color', 'link', 'color', true );

			$map  -> id      ( 'html5_video_volume_bar_hover' )
			      -> selector( '.jp-volume-bar-value:hover' )
			      -> sync    ( 'background-color', 'link_hover', 'color', true );

			return $map;
		}

	}

}