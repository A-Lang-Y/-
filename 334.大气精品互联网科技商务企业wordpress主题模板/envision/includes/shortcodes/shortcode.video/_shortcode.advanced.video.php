<?php
/*
 * Plugin Name: Video Embed
 * Plugin URI: http://cloudfw.net
 * Description: 
 * Version: 1.0
 * Author: Orkun Gürsel
 * Author URI: http://orkungursel.com
 * Shortcode:  [video]
 */

cloudfw_register_shortcode( 'CloudFw_Shortcode_Video', 'video', 'advanced', 55 );
if ( ! class_exists('CloudFw_Shortcode_Video') ) {
	class CloudFw_Shortcode_Video extends CloudFw_Shortcodes {

		function get_called_class(){ return get_class($this); }


		/** Add the shortcode to the composer */
		function composer(){
			return array(
				'composer'		=> true,
				'ajax'			=> true,
				'icon'			=> 'video',
				'group'			=> 'composer_widgets',
				'line'			=> 180,
				'options'		=> array(
					'title'				=> __('Video','cloudfw'),
					'column'			=> '1/1',
					'allow_columns'		=> true,
				)
			);
		}

		/** Run */
		function shortcode( $atts = array(), $content = NULL ) {
			$atts = shortcode_atts(array(
				'url'       => NULL,
				'type'      => 'auto',
				'height'	=> NULL,
				'ratio'		=> '16:9',
				'autoplay'	=> 0,
				'shadow'	=> NULL,
			), _check_onoff_false($atts));
			extract($atts);

			if ( empty($ratio) )
				$ratio = '16:9'; 

			if( $type == 'manual' ) {
				if ( empty($content) )
					return cloudfw_error_message( __('Please insert custom embed code.','cloudfw') );

			} else {
				if ( empty($url) )
					return cloudfw_error_message( __('Please insert a video url.','cloudfw') );

				$content = '';
			}

			$classes = array();
			$classes[] = 'ui--video';

			if ( !empty($ratio) && empty($height) )
				$classes[] = 'ui--video-' . str_replace(':', '-', $ratio) ;

			$result = cloudfw_video_embed( $atts, $content ); 

			if ( !$result === false && !empty($result) ) {
				
				$ratio_padding = cloudfw_match_ratio_percent( $ratio );

				$out = '<div class="ui--video-wrapper clearfix"><div'.

					cloudfw_make_class($classes, true) .
					cloudfw_make_style_attribute( array(
						'height'    		=> $height,
						'padding-bottom'    => $ratio_padding,
					), FALSE, TRUE )

				.'>';
				$out .= $result;
				$out .= '</div>';

				$out .= cloudfw_UI_shadow( $shadow );

				$out .= '</div>';

				return $out;

			} else {
				return cloudfw_error_message( sprintf(__('The video (%s) couldn\'t be embedded.','cloudfw'), $url) );
			}

		}


		/** Scheme */
		function scheme() {
			return array(
				'title'		=>	__('Video','cloudfw'),
				'script'	=> array(
					'shortcode'  => 'video',
					'tag_close'  => true,
					'attributes' =>	array( 
						'type' 		=> array( 'e' => 'video_embed_type' ),
						'url' 		=> array( 'e' => 'video_url', 'required' => __('Please insert video url','cloudfw') ),
						'autoplay' 	=> array( 'e' => 'video_autoplay', 'onoff' => true ),
						'content' 	=> array( 'e' => 'video_custom_code' ),
						'shadow' 	=> array( 'e' => 'video_shadow' ),
					),
					'if'		 =>	array(
						array( 
							'type'    => 'toggle',
							'e' 	  => 'video_embed_type',
							'related' => 'videoWidgetEmbedTypeOptions',
							'targets' => array( 
								array('',  		'#video_url'),
								array('',  		'#video_autoplay'),
								array('manual', '#video_custom_code'),
							)
						)
					
					)
				),
				'data'		=>	array(

					array(
						'type'		=> 'module',
						'title'		=> __('Embed Type','cloudfw'),
						'data'		=> array(

							## Element
							array(
								'type'		=>	'select',
								'id'		=>	'video_embed_type',
								'value'		=>	$this->get_value('video_embed_type'),
								'source'	=>	array(
									'NULL'		=>	__('Auto','cloudfw'),
									'manual'	=>	__('Manual Code','cloudfw'),
								),
								'width'		=>	250
							), // #### element: 0

						)

					),

					array(
						'type'		=> 'module',
						'related'	=> 'videoWidgetEmbedTypeOptions',
						'title'		=> __('Video URL','cloudfw'),
						'data'		=> array(

							## Element
							array(
								'type'		=>	'text',
								'id'		=>	'video_url',
								'value'		=>	$this->get_value('video_url'),
								'class'		=>	'input input_350 bold',
								'desc'		=>	__('e.g. <code>http://www.youtube.com/watch?v=2DclLrdaxQd</code> <code>http://vimeo.com/123456</code>','cloudfw'),
							), // #### element: 0

						)

					),

					array(
						'type'		=>	'module',
						'related'	=> 'videoWidgetEmbedTypeOptions',
						'title'		=>	__('Custom Embed Code','cloudfw'),
						'data'		=>	array(
							array(
								'type'		=>	'textarea',
								'id'		=>	'video_custom_code',
								'value'		=>	$this->get_value('video_custom_code', ''),
								'width'		=>	'90%',
								'line'		=>	5,
								'tabkey'	=>	true
							)
						)
						
					),

					array(
						'type'		=> 'module',
						'related'	=> 'videoWidgetEmbedTypeOptions',
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

			);

		}

	}

}