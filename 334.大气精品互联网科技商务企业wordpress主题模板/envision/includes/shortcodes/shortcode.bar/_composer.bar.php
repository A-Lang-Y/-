<?php
/*
 * Plugin Name: Bar
 * Plugin URI: http://cloudfw.net
 * Description: 
 * Version: 1.0
 * Author: Orkun Gürsel
 * Author URI: http://orkungursel.com
 * Shortcode:  
 * Attributes:
 */

cloudfw_register_shortcode( 'CloudFw_Composer_Bar' );
if ( ! class_exists('CloudFw_Composer_Bar') ) {
	class CloudFw_Composer_Bar extends CloudFw_Shortcodes {

		var $parent	= 0;
		var $child	= 0;
		var $total	= 0;
		var $atts	= array();
		var $header	= '';
		var $footer	= '';
		var $contents= '';

		function get_called_class(){ return get_class($this); }


		/** Add the shortcode to the composer */
		function composer(){
			return array(
				'composer'		=> true,
				'droppable'		=> true,
				'ajax'			=> true,
				'icon'			=> 'menubar',
				'group'			=> 'composer_widgets',
				'do_shortcode'	=> false,
				'line'			=> 340,
				'options'		=> array(
					'title'				=> __('Custom Menu Bar','cloudfw'),
					'column'			=> '1/1',
					'allow_columns'		=> true,
					'not_in'			=> array('CloudFw_Composer_Bar', 'CloudFw_Composer_Bar_Item'),
					'allow_only'		=> array('CloudFw_Composer_Bar_Item'),
				)
			);
		}


		function add() {
			return array(
				'content_bar' 			=> array( &$this, 'shortcode_bar' ),
				'content_bar_item' 		=> array( &$this, 'shortcode_item' ),
			);
		}

		/** Run */
		function shortcode( $atts = array(), $content =  NULL ) { return cloudfw_transfer_shortcode_attributes( 'content_bar', $atts, $content ); }

		/** Bar */
		function shortcode_bar( $atts = array(), $content =  NULL ) {

			$this->atts = shortcode_atts(array(
				'margin_top'    => '',
				'margin_bottom' => '',
				"class" 		=> '',

				"style" 		=> '',
				"orientation"	=> '',
				"align" 		=> 'left',
				'height'			=> 'normal',
			), _check_onoff_false($atts)); 

			extract( $this->atts );

			$this->parent++;
			$this->child = 0;
			$this->total = 0;
			$this->header = '';
			$this->footer = '';
			$this->contents = '';
			$this->total = count(explode("[content_bar_item",$content)) - 1;
			

			$classes   = array();
			$classes[] = 'ui--custom-menu-bar';
			$classes[] = 'ui--gradient ui--gradient-grey';
			$classes[] = 'hover-effect';
			$classes[] = $class;

			if ( $style == 'boxed' ) {
				$classes[] = 'ui--box';

				if ( $orientation == 'vertical' ) {
					$classes[] = 'orientation-vertical';
				} else {
					$classes[] = 'orientation-horizontal';
				}

			} else {
				$classes[] = 'fullwidth-container';
			}
			
			if ( $height ) {
				$classes[] = 'ui--height-' . $height;
			}

			$classes[] = 'text-' . $align;
			

			$classes[] = 'clearfix';

			
			$this->header  .= '<div'. cloudfw_make_class($classes, 1) .
				cloudfw_make_style_attribute( array( 
					'margin-top'    => $margin_top,
					'margin-bottom' => $margin_bottom,
				), FALSE, TRUE )

			 .'>';
				$this->header .= '<ul class="unstyled clearfix">';
			
					do_shortcode( $content );
			
				$this->footer .= '</ul>';
			$this->footer .= '</div>';

			return 	$this->header. 
				 	$this->contents. 
				 	$this->footer;


		}

		function shortcode_item( $atts = array(), $content =  NULL ) {
			extract(shortcode_atts(array(
				'item_type'			=> 'custom',
				'icon'				=> '',
				'icon_position'		=> 'left',
				'link'				=> '',
				'attr_title'		=> '',
				'target'			=> '',
				'lightbox'			=> '',
				'item_class'		=> '',
			), _check_onoff_false($atts)));

			$this->child++;
			extract($this->atts);
		
			$classes   = array();
			if ( $this->child == 1 )
				$classes[] = 'first-item';
			
			if ( $this->child == $this->total )
				$classes[] = 'last-item';

			if ( $orientation == 'vertical' )
				$classes[] = 'ui--gradient-grey';

			if ( $item_class )
				$classes[] = $item_class;

			if ( $icon_position )
				$classes[] = 'ui--icon-position-' . $icon_position;

			if ( $item_type !== 'custom' ) {
				$out = '';
				$id = cloudfw('get_ID');
				$post_type = cloudfw('get_post_type');
				$link = $target = $lightbox = ''; 

				if ( $item_type == 'category' ) {
					$title = __('Category','cloudfw').': ';
					$category_slug = apply_filters( "cloudfw_bar_category_slug_{$post_type}", "category" );
					$out = get_the_term_list( $id, $category_slug, '', ', ', '' );
				} elseif ( $item_type == 'tag' ) {
					$title = __('Tag','cloudfw').': ';
					$category_slug = apply_filters( "cloudfw_bar_tag_slug_{$post_type}", "post_tag" );
					$out = get_the_term_list( $id, $category_slug, '', ', ', '' );
				} elseif ( $item_type == 'date' ) {
					$title = __('Date','cloudfw').': ';
					$out = ($date = get_the_date(NULL, $id)) ? "<strong>$date</strong>" : '';
				}

				if ( !empty($out) ) {

					if ( !empty($content) )
						$content = $content . $out;
					else
						$content = $title . $out;
	
					$icon = cloudfw_make_icon( $icon );

				} else {
					$icon = ''; 
				}


			} else {
				$icon = cloudfw_make_icon( $icon );
			}
			

			if ( !empty($content) || !empty($icon) ) {

				$this->contents .= '<li'. 
					cloudfw_make_class($classes, 1) .
					cloudfw_make_attribute(array(
						'title' => $attr_title,
					) , FALSE) .
				'>';
					if ( !empty($link) )
						$this->contents .= '<a href="'. $link .'"'. _if( $target, ' target="'. $target .'"' ) . _if( $lightbox, ' data-rel="prettyPhoto"' ) .'>';
					else
						$this->contents .= '<span>';
						

					if ( $icon_position == '' || $icon_position == 'left' || $icon_position == 'center' )
						$this->contents .= $icon;
					
					$this->contents .= do_shortcode( $content );

					if ( $icon_position == 'right' )
						$this->contents .= $icon;
			

					if ( !empty($link) )
						$this->contents .= '</a>';
					else
						$this->contents .= '</span>';

				$this->contents .= '</li>';

			}

		}

		/** Scheme */
		function scheme() {
			return array(
				'title'		=>	__('Custom Menu Bar','cloudfw'),
				'ajax'		=>	true,
				'script'	=> array(
					'shortcode'  => 'content_bar',
					'attributes' =>	array( 
						'margin_top'     		=> array( 'e' => 'margin_top' ),
						'margin_bottom'  		=> array( 'e' => 'margin_bottom' ),

						'style' 				=> array( 'e' => 'bar_style' ),
						'orientation' 			=> array( 'e' => 'bar_orientation' ),
						'height'	 			=> array( 'e' => 'bar_height' ),
						'align' 				=> array( 'e' => 'bar_align' ),

					),
					'if'		 =>	array(
						array( 
							'type'    => 'toggle',
							'e' 	  => 'bar_style',
							'related' => 'barStyleOptions',
							'targets' => array( 
								array('boxed', '#bar_orientation'),
							)
						)
					
					)
				),
				'data'		=>	array(

					array(
						'type'		=>	'module',
						'title'		=>	__('Style','cloudfw'),
						'data'		=>	array(
							array(
								'type'		=>	'select',
								'id'		=>	'bar_style',
								'value'		=>	$this->get_value('bar_style'),
								'source'	=>	array(
									'NULL'		=>	__('Fullwidth Style Bar','cloudfw'),
									'boxed'		=>	__('Boxed Style Bar','cloudfw'),
								),
								'width'		=>	300,

							)
						)
					),

					array(
						'type'		=> 'module',
						'related'	=> 'barStyleOptions',
						'title'		=> __('Orientation','cloudfw'),
						'data'		=> array(

							## Element
							array(
								'type'		=>	'select',
								'id'		=>	'bar_orientation',
								'value'		=>	$this->get_value('bar_orientation'),
								'source'	=>	array(
									'NULL'			=> __('Horizontal','cloudfw'),
									'vertical' 		=> __('Vertical','cloudfw'),
								),
								'width'		=>	250,

							), // #### element: 0


						)

					),

					array(
						'type'		=> 'module',
						'title'		=> __('Height','cloudfw'),
						'data'		=> array(

							## Element
							array(
								'type'		=>	'select',
								'id'		=>	'bar_height',
								'value'		=>	$this->get_value('bar_height'),
								'source'	=>	array(
									'NULL'			=> __('Normal','cloudfw'),
									'thin' 			=> __('Compact','cloudfw'),
								),
								'width'		=>	250,

							), // #### element: 0


						)

					),


					array(
						'type'		=> 'module',
						'title'		=> __('Content Align','cloudfw'),
						'data'		=> array(

							## Element
							array(
								'type'		=>	'select',
								'id'		=>	'bar_align',
								'value'		=>	$this->get_value('bar_align'),
								'source'	=>	array(
									'type'			=> 'function',
									'function' 		=> 'cloudfw_admin_loop_text_aligns',
								),
								'width'		=>	250,

							), // #### element: 0


						)

					),

					array(
						'type'		=>	'global-scheme',
						'scheme'	=>	'margins',
						'this'		=>	$this
					),

				)

			);

		}


		/** Scheme */
		function composer_scheme() {
			return array(
				'data'		=>	array(
					cloudfw_composer_default_dropped_area(
						array(
							array(
								'id'	=>	'CloudFw_Composer_Bar_Item',
								'title'	=>	__('+ Add new menu item','cloudfw'),
							),
						)
					)
				)
			);
		}

	}

}

cloudfw_register_shortcode( 'CloudFw_Composer_Bar_Item');
if ( ! class_exists('CloudFw_Composer_Bar_Item') ) {
	class CloudFw_Composer_Bar_Item extends CloudFw_Shortcodes {

		function get_called_class(){ return get_class($this); }


		/** Add the shortcode to the composer */
		function composer(){
			return array(
				'composer'		=> true,
				'ajax'			=> true,
				'list'			=> false,
				'icon'			=> 'layout',
				'group'			=> 'composer_layouts',
				'do_shortcode'	=> false,
				'line'			=> 38,
				'options'		=> array(
					'title'				=> __('Custom Menu Item','cloudfw'),
					'column'			=> '1/1',
					'allow_columns'		=> false,

					'sync_title'		=> 'bar_item_text',
					'in'				=> 'CloudFw_Composer_Bar',
					'not_in'			=> 'CloudFw_Composer_Bar_Item',
				)
			);
		}

		/** Run */
		function shortcode( $atts = array(), $content =  NULL ) {
			return cloudfw_transfer_shortcode_attributes( 'content_bar_item', $atts, $content );
		}


		/** Scheme */
		function scheme() {
			return array(
				'script'	=> array(
					'shortcode'		=> 'content_bar_item',
					'attributes' 	=> array( 
						'item_type' => array( 'e' => 'bar_item_type' ),
						'link' 		=> array( 'e' => 'bar_item_link' ),
						'target' 	=> array( 'e' => 'bar_item_target' ),
						'content' 	=> array( 'e' => 'bar_item_text' ),
						'icon' 		=> array( 'e' => 'bar_item_icon' ),
						'lightbox'  => array( 'e' => 'bar_item_lightbox', 'onoff' => true ),
					),
					'if' =>	array(
						array( 
							'type' 	  => 'toggle',
							'e' 	  => 'bar_item_type',
							'mode' 	  => 'same',
							'related' => 'customTypeOptions',
							'targets' => array( 
								array('custom', '.customTypeOptions'),
							)
						),
					)
				),
				'data'		=>	array(

					array(
						'type'		=> 'module',
						'title'		=> __('Item Type','cloudfw'),
						'data'		=> array(

							## Element
							array(
								'type'		=>	'select',
								'id'		=>	'bar_item_type',
								'value'		=>	$this->get_value('bar_item_type'),
								'source'	=>	array(
									'custom'		=> __('Custom','cloudfw'),
									'category' 		=> __('Post Categories','cloudfw'),
									'tag' 			=> __('Post Tags','cloudfw'),
									'date' 			=> __('Post Date','cloudfw'),
								),
								'width'		=>	250,

							), // #### element: 0


						)

					),

					array(
						'type'		=> 'module',
						'title'		=> __('Item Text / Title','cloudfw'),
						'data'		=> array(

							## Element
							array(
								'type'		=>	'text',
								'id'		=>	'bar_item_text',
								'value'		=>	$this->get_value('bar_item_text'),
								'editor'	=>	true,
							)

						)

					),

					array(
						'type'		=> 'module',
						'title'		=> __('Icon','cloudfw'),
						'data'		=> array(

							## Element
							array(
								'type'		=>	'icon-selector',
								'id'		=>	'bar_item_icon',
								'value'		=>	$this->get_value('bar_item_icon'),
							)

						)

					),

					array(
						'type'		=> 'group',
						'related'	=> 'customTypeOptions',
						'data'		=>	array(


							array(
								'type'		=> 'module',
								'title'		=> __('Link URL','cloudfw'),
								'data'		=> array(

									## Element
									array(
										'type'		=>	'page-selector',
										'id'		=>	'bar_item_link',
										'value'		=>	$this->get_value('bar_item_link'),
										'response'	=>	'URL',
									)

								)

							),

							array(
								'type'		=> 'module',
								'title'		=> __('Link Target','cloudfw'),
								'data'		=> array(

									## Element
									array(
										'type'		=>	'select',
										'id'		=>	'bar_item_target',
										'value'		=>	$this->get_value('bar_item_target'),
										'source'	=>	array(
											'type'			=> 'function',
											'function' 		=> 'cloudfw_admin_loop_link_targets',
										),
										'width'		=>	250,

									), // #### element: 0


								)

							),

							array(
								'type'		=> 'module',
								'title'		=> __('Link to lightbox?','cloudfw'),
								'data'		=> array(

									## Element
									array(
										'type'		=>	'onoff',
										'id'		=>	'bar_item_lightbox',
										'value'		=>	$this->get_value('bar_item_lightbox', 'FALSE'),
									)

								)

							),



						)

					),

				
				)

			);

		}

	}

}