<?php
/*
 * Plugin Name: Typography
 * Plugin URI: http://cloudfw.net
 * Description: 
 * Version: 1.0
 * Author: Orkun Gürsel
 * Author URI: http://orkungursel.com
 * Shortcode: 
 * Attributes:
 */

cloudfw_register_shortcode( 'CloudFw_Shortcode_Typography', NULL, 'style', 10 );
if ( ! class_exists('CloudFw_Shortcode_Typography') ) {
	class CloudFw_Shortcode_Typography extends CloudFw_Shortcodes {

		function get_called_class(){ return get_class($this); }


		/** Add the shortcode to the composer */
		function composer(){
			return array(
				'composer'		=> true,
				'ajax'			=> true,
				'icon'			=> 'typo',
				'group'			=> 'composer_widgets',
				'line'			=> 140,
				'options'		=> array(
					'title'				=> __('Typography','cloudfw'),
					'sync_title'		=> 'typo_type',
					'column'			=> '1/1',
					'allow_columns'		=> true,
				)
			);
		}

		/** Register */
		function register() {
			return array(
				'dropcap',
				'highlight',
				'highlight1',
				'highlight2'	,
				'highlight3',
				'blockquote',
				'pullquote_left',
				'pullquote_right',
				'pre',
				'code',
			);

		}

		/** Run */
		function shortcode( $atts = array(), $content =  NULL, $case = NULL ) {

			switch ($case) {

			/** Hightlights */
				case 'highlight':
				case 'highlight1':
				case 'highlight2':
				case 'highlight3':

					extract(shortcode_atts(array(
						'id'				=> NULL,
						'color'				=> NULL,
						'background'		=> NULL,
						'class'				=> NULL,
						'style'				=> NULL,
					), $atts));

					if 	   ( $case == 'highlight'  ) $class_default = "ui--highlight highlight_1";
					elseif ( $case == 'highlight1' ) $class_default = "ui--highlight highlight_1";
					elseif ( $case == 'highlight2' ) $class_default = "ui--highlight highlight_2";
					elseif ( $case == 'highlight3' ) $class_default = "ui--highlight highlight_3";

					if ( empty($class) )
						$class = $class_default; 
					else
						$class = $class_default . ' ' . $class;

					if ( $case !== 'highlight' ) {
						$color = $background = '';     
					}
					
					return "<span".
					cloudfw_make_id( $id ) .
					cloudfw_make_class($class, true) .
					cloudfw_make_style_attribute( array( 
						'!color'            => $color,
						'!background-color' => $background,
						'style'				=> $style,
					), FALSE, TRUE ).

					">{$content}</span>";

				break;

			/** DropCaps */
				case 'dropcap':
					
					$class = "dropcap";
					$content = trim($content);
					$length = strlen($content);
					$c_content = '';
					
					if ($length > 1) {
						$c_content = substr($content,1,$length-1); 
						$content = $content[0];
					}

					return "<h1 class=\"$class\"><strong>$content</strong></h1>" . do_shortcode( cloudfw_inline_format($c_content) );

				break;

			/** Quotes */
				case 'pullquote_left':
				case 'pullquote_right':
				case 'blockquote':

					if 	   ( $case == 'pullquote_left' )  $classes = "ui--pullquote pull-left ui--pullquote-left";
					elseif ( $case == 'pullquote_right' ) $classes = "ui--pullquote pull-right ui--pullquote-right";
					else    	  						  $classes = "ui--blockquote";

					if ( empty($class) )
						$class = $classes; 
					else
						$class = $classes . ' ' . $class;

					return do_shortcode("<blockquote class=\"$class\">". do_shortcode( cloudfw_inline_format($content) ) ."</blockquote>");

				break;

			/** Pre */
				case 'pre':
					$content = str_replace(array( '[', ']' ), array( '&#91;', '&#93;' ), $content); 
					return "<pre><code>{$content}</code></pre><div class=\"clear\"></div>";

				break;

			/** Code */
				case 'code':

					$content = str_replace(array( '[', ']' ), array( '&#91;', '&#93;' ), $content); 
					return "<code>{$content}</code>";

				break;

			}

		}

		/** Admin Scheme */
		function scheme() {
			return array(
				'title'		=>	__('Typography','cloudfw'),
				'ajax'		=> true,
				'script'	=> array(
					'shortcode:sync'=> 'typo_type',
					'tag_close'  	=> true,
					'attributes' 	=> array( 
						'color' 		=> array( 'e' => 'highlight_color', 'prepend' => '#' ),
						'background'	=> array( 'e' => 'highlight_bg', 'prepend' => '#' ),
						'content' 		=> array( 'e' => 'typo_content', 'force' => true, 'default' => __('Content Text','cloudfw') ),
					),
					'if'	=>	array(
						array( 
							'type' 		=> 'toggle',
							'e' 		=> 'typo_type',
							'related'	=> 'highlightCustom',
							'targets'	=> array( array('highlight', '#highlight_color'), array('highlight', '#highlight_bg') )
						)
					)

				),
				'data'		=>	array(

					5 => array(
						'type'		=> 'module',
						'title'		=> __('Type','cloudfw'),
						'data'		=> array(

							## Element
							array(
								'type'		=>	'select',
								'id'		=>	'typo_type',
								'value'		=>	$this->get_value('typo_type'),
								'ui'		=>	true,
								'main_class'=>  'input input_250',
								'source'	=>	array(
									'NULL'			=> __('Please select','cloudfw'),
									'dropcap'		=> __('Drop Cap','cloudfw'),
									'highlight'		=> __('Highlight Custom','cloudfw'),
									'highlight1'	=> __('Highlight Style 1','cloudfw'),
									'highlight2'	 	=> __('Highlight Style 2','cloudfw'),
									'highlight3'	=> __('Highlight Style 3','cloudfw'),
									'blockquote' 	=> __('Blockquote','cloudfw'),
									'pullquote_left'=> __('Pullquote - Left','cloudfw'),
									'pullquote_right'=> __('Pullquote - Right','cloudfw'),
									'pre'			=> __('Pre','cloudfw'),
									'code'			=> __('Code','cloudfw'),
								)

							), // #### element: 0

						)

					),  // #### module: 5

					10 => array(
						'type'		=> 'module',
						'title'		=> __('Content','cloudfw'),
						'data'		=> array(

							## Element
							array(
								'type'		=>	'textarea',
								'id'		=>	'typo_content',
								'value'		=>	$this->get_value('typo_content'),
								'editor'	=>	true,
								'width'		=>	'90%',
								'line'		=>	5
							), // #### element: 0

						)

					),  // #### module: 10

					15 => array(
						'type'		=> 'module',
						'related'	=> 'highlightCustom',
						'hidden'	=> true,
						'title'		=> __('Custom Highlight Text Color','cloudfw'),
						'data'		=> array(

							## Element
							array(
								'type'		=>	'color',
								'style'		=>	'horizontal',
								'id'		=>	'highlight_color',
								'value'		=>	$this->get_value('highlight_color'),
							), // #### element: 0

						)

					),  // #### module: 15

					20 => array(
						'type'		=> 'module',
						'related'	=> 'highlightCustom',
						'hidden'	=> true,
						'title'		=> __('Custom Highlight Background Color','cloudfw'),
						'data'		=> array(

							## Element
							array(
								'type'		=>	'color',
								'style'		=>	'horizontal',
								'id'		=>	'highlight_bg',
								'value'		=>	$this->get_value('highlight_bg'),
							), // #### element: 0

						)

					),  // #### module: 20

					
				)

			);

		}


		/** Skin map */
		function skin_map( $map ){
		    /** Highlight */
		    $map  -> id      ( 'highlight' )
		          -> selector( '.highlight' )
		          -> attr    ( 'color' )
		          -> attr    ( 'background-color' );
		    
		    return $map;
		}

		/** Skin scheme */
		function skin_scheme( $schemes, $data ){
			return cloudfw_add_skin_scheme( 'shortcode',
				$schemes,
				array(
					'type'		=>	'module-set',
					'title'		=>	__('Highlighter','cloudfw'),
					'closable'	=>	true,
					'state'		=>	'closed',
					'data'		=>	array(

						array(
							'type'		=>	'module',
							'ucode'		=>	'HIGHLIGHT',
							'title'		=>	__('Default Highlighter','cloudfw'),
							'data'		=>	array( array(
									'type'		=>	'grid',
									'layout'	=>	'nospaced',
									'data'		=>	array(
																	
										array(
											'type'		=>	'color',
											'title'		=>	__('Background','cloudfw'),
											'id'		=>	cloudfw_sanitize('highlight','background-color'),
											'value'		=>	$data['highlight']['background-color'],
										),
										array(
											'type'		=>	'color',
											'title'		=>	__('Text Color','cloudfw'),
											'id'		=>	cloudfw_sanitize('highlight','color'),
											'value'		=>	$data['highlight']['color'],
										),

									)
									
								),
								
							)

						),

															
					) // module set data
						
				)
				
			);

		}


		/** Typo map */
		function typo_map( $map ){
			cloudfw_add_typo_setting( $map, 'blockquote', 'blockquote, .ui--blockquote, .ui--pullquote, blockquote p, .ui--blockquote p, .ui--pullquote p');

		    return $map;
		}


		/** Typo Scheme */
		function typo_scheme( $scheme, $data, $number ){

			$scheme[ cloudfw_id_for_sequence( $scheme, $number ) ] = array(
				'type'			=>	'container',
				'width'			=>	940,
				'footer'		=>	false,
				'title'			=>	__('Other Typography Elements','cloudfw'),
				'data'			=>	array(
				
					array(
						'type'		=>	'typo-set',
						'title'		=>	__('Blockquotes','cloudfw'),
						'id'		=>	cloudfw_sanitize('blockquote'),
						'value'		=>	$data['blockquote'],
						'data'		=>	array()
						
					),

				
				) 


			);

			return $scheme;


		}

	}

}