<?php
/*
 * Plugin Name: Titles
 * Plugin URI: http://cloudfw.net
 * Description: 
 * Version: 1.0
 * Author: Orkun Gürsel
 * Author URI: http://orkungursel.com
 * Shortcode: 
 * Attributes:
 */

cloudfw_register_shortcode( 'CloudFw_Shortcode_Titles', NULL, 'style', 6 );
if ( ! class_exists('CloudFw_Shortcode_Titles') ) {
	class CloudFw_Shortcode_Titles extends CloudFw_Shortcodes {
		function get_called_class(){ return get_class($this); }

		/** Add the shortcode to the composer */
		function composer(){
			return array(
				'composer'		=> true,
				'ajax'			=> false,
				'icon'			=> 'text',
				'group'			=> 'composer_widgets',
				'line'			=> 120,
				'options'		=> array(
					'title'				=> __('Custom Titles','cloudfw'),
					'sync_title'		=> 'titles_title',
					'column'			=> '1/1',
					'allow_columns'		=> false,
				)
			);
		}

		/** Register */
		function register() {
			return array(
				'title',
			);

		}

		/** Run */
		function shortcode( $atts = array(), $content =  NULL, $case = NULL ) {

			$out = ''; 
			switch ($case) {
				case 'title':
				case 'title_bottom':
				case 'title_bottom_alt':

					extract(shortcode_atts(array(
						'id'			=> '',
						'class'			=> '',
						'margin_top'	=> '',
						'margin_bottom'	=> '',
						'element'		=> 'h1',
						'align'			=> 'left',
						'color'			=> '',
						'link'			=> '',
						'border_color'	=> '',
						'border_width'	=> '',
						'border_style'	=> '',
					), $atts));

					$classes = array();
					$classes[] = 'ui--title';
					$classes[] = 'ui--animation';

					if ( $case == 'title' )
						$classes[] = 'ui--title-bordered';
					elseif ( $case == 'title_bottom' || $case == 'title_bottom_alt' )
						$classes[] = 'ui--title-bordered-bottom';

					if ( $align )
						$classes[] = 'text-' . $align;
					$classes[] = $class;

					$classes_title = array();
					$classes_title[] = 'ui--title-text';


					$border_margin_top = '';
					if ( ! (int) $border_width > 0 ) 
						$border_width = '';
					else
						$border_margin_top = -abs((floor((int)$border_width * 2) / 4));

					if ( !empty($link) ) {
						$link = cloudfw_get_page_link($link);
						$content = "<a href=\"{$link}\">{$content}</a>";
					}

					$out .= "<div".
						cloudfw_make_id( $id ) .
						cloudfw_make_class($classes, true) .
						cloudfw_make_style_attribute( array( 
							'margin-top' 	=> $margin_top,
							'margin-bottom' => $margin_bottom,
					), FALSE, TRUE ). ">";

						$out .= "<div class=\"ui--title-holder\">";

							$out .= "<{$element}".
								cloudfw_make_class($classes_title, true) .
								cloudfw_make_style_attribute( array( 
									'!color' => $color,
								), FALSE, TRUE ). ">";
								$out .= $content;


							if ( $case == 'title_bottom_alt' ) {

								$out .= "<div".
									cloudfw_make_style_attribute( array( 
										'!border-color' => $border_color,
										'border-width'  => $border_width,
										'border-style'  => $border_style,
									), FALSE, TRUE ). " class=\"ui--title-borders ui--title-border-bottom\"></div>";

							}

							$out .= "</{$element}>";

							if ( $case == 'title' ) {
								$out .= "<div".
									cloudfw_make_style_attribute( array( 
										'!border-color' => $border_color,
										'border-width'  => $border_width,
										'border-style'  => $border_style,
										'margin-top'    => $border_margin_top,
									), FALSE, TRUE ). " class=\"ui--title-borders ui--title-border-left\"></div>";

								$out .= "<div".
									cloudfw_make_style_attribute( array( 
										'!border-color' => $border_color,
										'border-width'  => $border_width,
										'border-style'  => $border_style,
										'margin-top'    => $border_margin_top,
									), FALSE, TRUE ). " class=\"ui--title-borders ui--title-border-right\"></div>";
							}

						$out .= "</div>";

					if ( $case == 'title_bottom' ) {

						$out .= "<div".
							cloudfw_make_style_attribute( array( 
								'!border-color' => $border_color,
								'border-width'  => $border_width,
								'border-style'  => $border_style,
							), FALSE, TRUE ). " class=\"ui--title-borders ui--title-border-bottom\"></div>";

					}

					$out .= "</div>";


					break;


			}

			return $out;

		}

		/** Skin map */
		function skin_map( $map ){

		    return $map;

		}

		/** Admin Scheme */
		function scheme() {
			return array(
				'title'		=>	__('Custom Titles','cloudfw'),
				'script'	=> array(
					'shortcode:sync'=> 'title_type',
					'tag_close'  	=> true,
					'attributes' 	=> array( 
						'id' 			=> array( 'e' => 'titles_id' ),
						'class' 		=> array( 'e' => 'titles_class' ),
						'margin_top' 	=> array( 'e' => 'margin_top' ),
						'margin_bottom' => array( 'e' => 'margin_bottom' ),
						'element' 		=> array( 'e' => 'titles_element' ),
						'color' 		=> array( 'e' => 'titles_color' ),
						'border_color'	=> array( 'e' => 'titles_border_color' ),
						'border_style'	=> array( 'e' => 'titles_border_style' ),
						'border_width'	=> array( 'e' => 'titles_border_width' ),
						'link' 			=> array( 'e' => 'titles_link' ),
						'align' 		=> array( 'e' => 'titles_align' ),
						'content' 		=> array( 'e' => 'titles_title', 'force' => true, 'default' => 'Title Text' ),
					),
					'if' =>	array(
						array( 
							'type' 		=> 'toggle',
							'e' 		=> 'title_type',
							'related' 	=> 'titleBorderedOptions',
							'targets' 	=> array( 
								array('title', 			'#titles_element'),
							)
						),
						array( 
							'type' 		=> 'toggle',
							'e' 		=> 'title_type',
							'related' 	=> 'titleBlockOptions',
							'targets' 	=> array( 
								array('title', 		'#titles_background'),
								array('title', 		'#titles_color'),
								array('title', 		'#titles_border_color'),
								array('title', 		'#titles_align'),
							)
						),
					)
				),
				'data'		=>  $this->load_scheme( __FILE__ )

			);

		}

	}

}