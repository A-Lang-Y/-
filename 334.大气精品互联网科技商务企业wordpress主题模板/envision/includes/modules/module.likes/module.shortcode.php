<?php
/*
 * Plugin Name: Likes Shortcode
 * Plugin URI: http://cloudfw.net
 * Description: 
 * Version: 1.0
 * Author: Orkun Gürsel
 * Author URI: http://orkungursel.com
 * Shortcode: 
 * Attributes:
 */
cloudfw_register_shortcode( 'CloudFw_Shortcode_Likes', 'like_the_post', 'advanced' );
if ( ! class_exists('CloudFw_Shortcode_Likes') ) {
	class CloudFw_Shortcode_Likes extends CloudFw_Shortcodes {
		function get_called_class(){ return get_class($this); }

		public $do_before = false; 

		/** Add the shortcode to the composer */
		function composer(){
			return array(
				'composer'		=> function_exists('cloudfw_likes'),
				'droppable'		=> false,
				'ajax'			=> true,
				'icon'			=> 'heart',
				'group'			=> 'composer_widgets',
				'do_shortcode'	=> false,
				'line'			=> 1500,
				'options'		=> array(
					'title'				=> __('Like the Post','cloudfw'),
					'column'			=> '1/1',
					'allow_columns'		=> false,
				)
			);
		}

		/** Run */
		function shortcode( $atts = array() ) {

			$out = ''; 
			if ( function_exists('cloudfw_likes') ) {
				$like_icon = '<i class="fontawesome-heart"></i> '; 
				$out .= "<div class=\"ui--meta-like-shortcode\">";
				$out .= sprintf( 
					'<span class="ui--meta-like clearfix effect">%s</span>', 
					cloudfw_likes(array(
						'zero' => $like_icon . __('<span>'. cloudfw_translate('sharrre.like_post') .'</span>','cloudfw'),
						'one'  => $like_icon . __('<span>'. cloudfw_translate('sharrre.single_likes') .'</span>','cloudfw'),
						'more' => $like_icon . __('<span>'. cloudfw_translate('sharrre.plural_likes') .'</span>','cloudfw'),
					))
				);
				$out .= "</div>";
			}

			return $out;

		}

		/** Scheme */
		function scheme() {
			return array(
				'title'		=>	__('Like the Post','cloudfw'),
				'ajax'		=>	true,
				'script'	=> array(
					'shortcode'  => 'like_the_post',
					'tag_close'  => false,
					'attributes' =>	array( 
						'likes_layout'     	=> array( 'e' => 'margin_top' ),
						//'margin_top'     	=> array( 'e' => 'margin_top' ),
						//'margin_bottom'  	=> array( 'e' => 'margin_bottom' ),
					),
				),
				'data'		=>	array(

					array(
						'type'		=> 'mini-section',
						'title'		=> __('Style','cloudfw'),
						'data'		=> array(

							array(
								'type'		=> 'module',
								'title'		=> __('Layout','cloudfw'),
								'data'		=> array(

									## Element
									array(
										'type'		=>	'select',
										'id'		=>	'likes_layout',
										'value'		=>	$this->get_value('likes_layout'),
										'width'		=>	250,
										'source'	=>	array(
											'NULL' 				=> __('Default','cloudfw'),
										)							
									), // #### element: 0

								)

							),

						)

					),

				)

			);

		}

	}

}