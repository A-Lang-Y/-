<?php

if ( ! function_exists('cloudfw_UI_box_hover_effects') ) {
	function cloudfw_UI_box_hover_effects() {
		$effects = array();

		$effects['NULL']              = __('Default','cloudfw');
		$effects['effect--fade']      = __('Fade','cloudfw');
		$effects['effect--slide-ltr'] = __('Slide - Left to Right','cloudfw');
		$effects['effect--slide-rtl'] = __('Slide - Right to Left','cloudfw');
		$effects['effect--slide-ttb'] = __('Slide - Top to Bottom','cloudfw');
		$effects['effect--slide-btt'] = __('Slide - Bottom to Top','cloudfw');

/*		$effects['effect--swap-ltr'] = __('Swap - Left to Right','cloudfw');
		$effects['effect--swap-rtl'] = __('Swap - Right to Left','cloudfw');
		$effects['effect--swap-ttb'] = __('Swap - Top to Bottom','cloudfw');
		$effects['effect--swap-btt'] = __('Swap - Bottom to Top','cloudfw');*/

		return $effects;
	}
}


/**
 *	UI Box Skin Map 
 */
function cloudfw_UI_box_skin_map( $map, $id, $selector ) {
	/** Box Title */
	$map  -> id      ( $id )
	      -> selector( "$selector .ui--content-box-title, $selector .ui--content-box-footer" )
	      -> attr    ( 'gradient', array(), true );

	/** Box Title Text */
	$map  -> id      ( "{$id}_text" )
	      -> selector( "$selector .ui--content-box-header (h*)" )
	      -> attr    ( 'text-shadow-kit', array(), true );

    /** Box Title on Hover */
	$map  -> id      ( "{$id}_on_hover" )
	      -> selector( "$selector .ui--content-box-title.on--hover:hover" )
	      -> sync    ( 'background-color', $id, array('gradient'), true );

	/** Box Border */
	$map  -> id      ( "{$id}_border" )
	      -> selector( "$selector .ui--content-box" )
	      -> attr    ( 'border-kit', array(), true );

	$map  -> id      ( "{$id}_border_sync" )
	      -> selector( "$selector .ui--content-box-media, $selector .ui--content-box-title, $selector .ui--content-box-footer" )
	      -> sync    ( 'border-color', "{$id}_border", 'border-color', true );

	/** Box Content Background */
	$map  -> id      ( "{$id}_content" )
	      -> selector( "$selector .ui--content-box-content" )
	      -> attr    ( 'background-color', '', true );

	/** Box Content Text */
	$map  -> id      ( "{$id}_content_text" )
	      -> selector( "$selector .ui--content-box-content (|p|a|h*)" )
	      -> attr    ( 'color', '', true );


	/** Box Title Hover */
	$map  -> id      ( $id . '_hover' )
	      -> selector( "#page-wrap $selector .ui--content-box-header:hover (.ui--content-box-title|.ui--content-box-title.on--hover:hover)" )
	      -> attr    ( 'background-position', '0 0', true )
	      -> attr    ( 'gradient', array(), true );

	/** Box Title Hover Text */
	$map  -> id      ( "{$id}_text_hover" )
	      -> selector( "#page-wrap $selector .ui--content-box-header:hover (h*)" )
	      -> attr    ( 'text-shadow-kit', array(), true );

    return $map;	
}

/**
 *	UI Box Skin Scheme 
 */
function cloudfw_UI_box_skin_scheme( $data, $id, $ucode ) {

	return array(

		## Module Item
		array(
			'type'		=>	'border',
			'merge'		=>	'module',
			'title'		=>	__('Box Borders','cloudfw'),
			'id'		=>	cloudfw_sanitize("{$id}_border"),
			'value'		=>	$data["{$id}_border"],
			'ucode'		=>	$ucode,
		),

		array(
			'type'		=>	'mini-section',
			'title'		=>	__('Box Title','cloudfw'),
			'data'		=>	array(

				## Module Item
				array(
					'type'		=>	'module',
					'ucode'		=>	$ucode,
					'title'		=>	__('Box Title Background','cloudfw'),
					'data'		=>	array(

						array(
							'type'		=>	'gradient',
							'id'		=>	cloudfw_sanitize( $id, 'gradient' ),
							'value'		=>	$data[ $id ]['gradient'],
						),

					)

				),

				## Module Item
				array(
					'type'		=>	'text-shadow-kit',
					'merge'		=>	'module',
					'title'		=>	__('Box Title Text','cloudfw'),
					'id'		=>	cloudfw_sanitize("{$id}_text"),
					'value'		=>	$data["{$id}_text"],
					'ucode'		=>	$ucode,
				),

			)

		),

		array(
			'type'		=>	'mini-section',
			'title'		=>	__('Box Title on Hover','cloudfw'),
			'data'		=>	array(

				## Module Item
				array(
					'type'		=>	'module',
					'ucode'		=>	$ucode,
					'title'		=>	__('Box Title Background on Hover','cloudfw'),
					'data'		=>	array(

						array(
							'type'		=>	'gradient',
							'id'		=>	cloudfw_sanitize( $id . '_hover', 'gradient' ),
							'value'		=>	$data[ $id . '_hover' ]['gradient'],
						),

					)

				),

				## Module Item
				array(
					'type'		=>	'text-shadow-kit',
					'merge'		=>	'module',
					'title'		=>	__('Box Title Text on Hover','cloudfw'),
					'id'		=>	cloudfw_sanitize("{$id}_text_hover"),
					'value'		=>	$data["{$id}_text_hover"],
					'ucode'		=>	$ucode,
				),

			)

		),

		array(
			'type'		=>	'mini-section',
			'title'		=>	__('Box Content','cloudfw'),
			'data'		=>	array(

				## Module Item
				array(
					'type'		=>	'module',
					'ucode'		=>	$ucode,
					'title'		=>	array( __('Box Content Background','cloudfw'), __('Box Content Text Color','cloudfw') ),
					'layout'	=>	'split',
					'data'		=>	array(
						## Element
						array(
							'type'		=>	'color',
							'style'		=>	'horizontal',
							'id'		=>	cloudfw_sanitize("{$id}_content",'background-color'),
							'value'		=>	$data["{$id}_content"]['background-color'],

						),

						## Element
						array(
							'type'		=>	'color',
							'style'		=>	'horizontal',
							'id'		=>	cloudfw_sanitize("{$id}_content_text",'color'),
							'value'		=>	$data["{$id}_content_text"]['color'],

						),

					)

				),

			)

		),


	);

}


/**
 *	UI Box 
 */
if ( ! function_exists('cloudfw_UI_box') ) {
	function cloudfw_UI_box( $atts = array(), $content =  NULL ) {
		$atts = shortcode_atts(array(
			'id'                  => NULL,
			'class'               => NULL,
			'style'               => NULL,
			'margin_top'          => NULL,
			'margin_bottom'       => NULL,
			
			'media'               => '',
			'media_append'        => NULL,
			'image'               => NULL,
			'image_hover'         => NULL,
			'video'               => NULL,
			'video_type'          => 'auto',
			'video_embed'         => NULL,
			
			'title'               => NULL,
			'title_element'       => 'h5',
			'title_size'          => NULL,
			'title_height'        => NULL,
			'title_align'         => 'center',
			
			'show_caption'        => true,
			'caption'             => NULL,
			'caption_element'     => 'h6',
			
			'show_desc'           => true,
			
			'media_link_append'   => NULL,
			'link'                => NULL,
			'link_style'          => 'all',
			'target'              => NULL,
			
			'hover_effect'        => NULL,
			'hover_text'          => NULL,
			'hover_icon'          => NULL,
			
			'footer'              => NULL,
			'footer_align'        => 'left',
			
			'lightbox'            => false,
			'group'               => false,
			'group_prefix'        => '',
			
			'overlay'             => false,
			'overlay_bg'          => '',
			'icon'                => 'FontAwesome/icon-fullscreen',
			'button_text'         => '',
			
			'columns'             => 3,
			'image_width'         => '',
			'image_height'        => '',
			'image_ratio'         => '16:9',
			'video_ratio'         => '16:9',

			'shadow'			  => 0,
			
			'gallery_effect'      => 'fade',
			'gallery_rotate_time' => 5000,
			'gallery_auto_rotate' => false,

			'images'              => array(),
			'lighbox_images'      => array(),
			
			'attr_alt'            => '',
			'attr_title'          => '',

		), _check_onoff_false($atts));
		extract($atts);

		global $cloudfw_ui_box_id;
		if ( !isset($cloudfw_ui_box_id) )
			$cloudfw_ui_box_id = 0;

		$cloudfw_ui_box_id++;
		$box_id = $cloudfw_ui_box_id;

		$group_id = '';
		if ( $group == true ) {
			$group_id = 'box-group-' . $box_id;
		} elseif ( !empty($group_prefix) ) {
			$group_id = $group_prefix . '-group';
		}

		$content = do_shortcode( $content );
		$content = trim( $content );
		$lightbox_title = '';
		$lightbox_description = esc_attr( strip_tags($title) );

		if( $button_text === 'NULL' ) {
			$button_text = '';
		}
			
		$shadow_wrap_classes = array();

		$classes = array();
		$classes[] = 'ui--content-box';  
		$classes[] = 'ui--box'; 

		if ( ! $shadow  ) {
			$classes[] = 'ui--content-item';  
			$classes[] = 'ui--animation'; 
		} else {
			$shadow_wrap_classes[] = 'ui--block ui--content-item ui--pass';
			$shadow_wrap_classes[] = 'ui--animation'; 
		}

		$classes[] = 'ui-row';  
		$classes[] = $class;

		if ( empty($image_ratio) ) {
			$image_ratio = '16:9'; 
		}

		if ( empty($video_ratio) ) {
			$video_ratio = '16:9'; 
		}


		if ( !empty($link) || ($lightbox && !empty($image) ) ) {
			if ( $lightbox && empty($link) ) {
				$link = $image; 
			}

			$link = cloudfw_get_page_link( $link );
			$link_element = array();
			$link_element[0]  = "<a class=\"ui--content-box-link\" href=\"{$link}\"";
			if ( !empty( $target ) ) {
				$link_element[0] .= " target=\"{$target}\"";
			}

			if ( $lightbox && !$group ) {
				$link_element[0] .= " data-rel=\"prettyPhoto";
				$link_element[0] .= "\"";
				$link_element[0] .= " data-title=\"". $lightbox_description ."\"";
			}

			$link_element[0] .= ">";
			$link_element[1]  = "</a>";
		} else {
			
			$link_element[0]  =
			$link_element[1]  = "";
		}

		$lighbox_api = array(); 

		if ( $group == true && $lightbox  ) {

			if ( !empty($lighbox_images) ) {

				foreach ($lighbox_images as $gallery_image) {
					if ( empty($gallery_image['src']) )
						continue;
						$lighbox_api['src'][] = $gallery_image['src']; 
						$lighbox_api['desc'][] = !empty($gallery_image['title']) ? esc_attr( strip_tags($gallery_image['title']) ) : $lightbox_description; 
				}
				
			}

		}

		/** Detect the media type */
		if ( !empty( $media ) ) {
			$media_type = $media;
		} else {
			if ( !empty( $video ) || !empty( $video_embed ) ) {
				$media_type = 'video';
			} elseif( !empty($images) && is_array($images) ) {
				$media_type = 'gallery';
			} elseif( !empty($image) ) {
				$media_type = 'image';
			} else {
				$media_type = false;
			}
		}

		$out = '';			
		$out .= "<div ". 
			cloudfw_make_id( $id ) .
			cloudfw_make_class($classes, true) .
			cloudfw_make_attribute( array( 
			), FALSE ) .
			cloudfw_make_style_attribute( array(
				'margin-top'    => $margin_top,
				'margin-bottom' => $margin_bottom,
				'style'         => $style,
			), FALSE, TRUE ) .
			cloudfw_json_attribute( 'data-ligthbox', $lighbox_api, FALSE )

		.">";
			/** Header */
			$out .= "<div class=\"ui--content-box-header\">";

				if ( !empty( $image_hover ) && $media_type == 'image' ) {
					$overlay_class = 'type--image-hover';
				} else {
					$overlay_class = 'type--default';
				}

				if( empty( $hover_effect ) || empty( $image_hover ) ) {
					$hover_effect = 'effect--fade'; 
				}


				if ( $media_type ) {
					$media_ratio = $media_type == 'video' ? $video_ratio : $image_ratio;  
					
					if ( $media_type == 'image' || $media_type == 'gallery' ) {
						$ratio_padding = cloudfw_match_ratio_percent( $media_ratio );
					} else {
						$ratio_padding = '';
					}


					$out .= "<div class=\"ui--content-box-media {$hover_effect} {$overlay_class} clearfix";
					if ( !$media_ratio || (! $ratio_padding && $media_type !== 'video' ) ) {
						$out .= " ratio-original";
					}
					$out .= "\"".
						cloudfw_make_style_attribute( array(
							'padding-bottom' => $ratio_padding,
						), FALSE, TRUE )
					.">";
						
						if ( $media_type == 'image' || $media_type == 'gallery' ) {

							if ( empty($image_width) ) {
								if ( $columns == 1 ) {
									$image_width = 959;
								} else {
									$image_width = 570;
								}
							}

							if ( $image_ratio && $image_width ) {
								$image_height = cloudfw_match_ratio( $image_width, $image_ratio );
								$image = cloudfw_thumbnail(array( 'src'=> $image,'w'=> $image_width,'h'=> $image_height, 'retina' => cloudfw_is_retina() )); 

								if ( !empty( $image_hover ) ) {
									$image_hover = cloudfw_thumbnail(array( 'src'=> $image_hover,'w'=> $image_width,'h'=> $image_height, 'retina' => cloudfw_is_retina() )); 
								}

							}
							
							$overlay_html  = "";
							if ( $overlay || !empty( $image_hover ) ) {
								$overlay_html .= "<div class=\"ui--content-box-overlay\">";

									if ( !empty($image_hover) ) {
				
										$overlay_html .= "<div class=\"ui--content-box-overlay-image\">";

											$overlay_html .= "<img ". 
												cloudfw_make_class(array( 'ui--content-box-image' ), true) .
												cloudfw_make_attribute( array( 
													'src'   => $image_hover,
													'alt' 	=> $attr_alt ? $attr_alt : $lightbox_title,
													'title' => $attr_title,
												), FALSE )
											."/>";
										
										$overlay_html .= "</div>";

									} else {

										$icon = cloudfw_make_icon( $icon ); 
										$overlay_html .= "<div class=\"ui--content-box-overlay-background\"".
											cloudfw_make_style_attribute( array(
												'background-color'    => $overlay_bg,
											), FALSE, TRUE )
										."></div>";
										$overlay_html .= "<div class=\"center\">";
											if ( !empty($button_text) || !empty($icon) ) {
												$overlay_html .= "<span class=\"btn btn-grey ui--center-vertical\">";

													if ( $button_text )
														$overlay_html .= "<span class=\"ui--content-box-overlay-button-text\">{$button_text}</span>";

													if ( $icon )
														$overlay_html .= "<span class=\"ui--content-box-overlay-button-icon\">{$icon}</span>";

												$overlay_html .= "</span>";
											}
										$overlay_html .= "</div>";

									}

								$overlay_html .= "</div>";
							}


							/** Gallery */
							if ( !empty($images) ) {

								$out .= cloudfw_UI_gallery() 
										-> set('class', 'ui--content-box-gallery')
										-> set('slides_class', 'mini-slides')
										-> set('item_class', 'ui--content-box-gallery-item')
										-> set('image_class', 'ui--content-box-gallery-image')
										-> set('width', $image_width)
										-> set('height', $image_height)
										-> set('effect', $gallery_effect)
										-> set('auto_rotate', $gallery_auto_rotate)
										-> set('rotate_time', $gallery_rotate_time)
										-> items( $images )
										-> render();

								$out .= $link_element[0];
									$out .= $overlay_html;
									$out .= $media_link_append;
								$out .= $link_element[1];
							
							} else {
								/** Single Image */

								$out .= $link_element[0];
									$out .= "<div class=\"ui--content-box-image-default\">";
										$out .= "<img ". 
											cloudfw_make_class(array( 'ui--content-box-image' ), true) .
											cloudfw_make_attribute( array( 
												'src'   => $image,
												'alt' 	=> $attr_alt ? $attr_alt : $lightbox_title,
												'title' => $attr_title,
											), FALSE )
										."/>";
									$out .= "</div>";
									$out .= $overlay_html;
									$out .= $media_link_append;
								$out .= $link_element[1];

							}


						} elseif ( $media_type == 'video' ) {
							
							$out .= "<div class=\"ui--content-box-video clearfix\">";
								$video_obj = new CloudFw_Shortcode_Video();

								if( $video_type == 'manual' ) {
									$out .= $video_obj->shortcode( array( 'type' => 'manual', 'ratio' => $video_ratio ), $video_embed );
								} else {
									$out .= $video_obj->shortcode( array( 'type' => 'auto', 'url' => $video, 'ratio' => $video_ratio ) );
								}
								
							$out .= "</div>";
						}

					$out .= $media_append;
					$out .= "</div>";
				}

				if ( !empty($title) || (!empty($caption) && $show_caption ) ) {
					$out .= $link_element[0];
					$out .= "<div class=\"ui--content-box-title ui--gradient ui--gradient-grey on--hover clearfix text-{$title_align}\">";

						if ( !empty($title) ) {
							$out .= "<{$title_element} class=\"ui--content-box-title-text\">";
								$out .= do_shortcode( $title );
							$out .= "</{$title_element}>";
						}

						if ( $show_caption && !empty($caption) ) {
							$out .= "<{$caption_element} class=\"ui--content-box-title-caption\">";
								$out .= do_shortcode( $caption );
							$out .= "</{$caption_element}>";
						}

					$out .= "</div>";
					$out .= $link_element[1];
				}

			$out .= "</div>";


			/** Content */
			if ( !empty($content) && $show_desc ) {
				$out .= "<div class=\"ui--content-box-content\">";
					$out .= "<div class=\"ui--content-box-content-text\">";
						$out .= cloudfw_inline_format( $content );
					$out .= "</div>";
				$out .= "</div>";
			}

			/** Footer */
			if ( !empty($footer) ) {
				$out .= "<div class=\"ui--content-box-footer ui--gradient ui--gradient-grey clearfix text-{$footer_align}\">";
					$out .= do_shortcode( $footer );
				$out .= "</div>";
			}


		$out .= "</div>";

		if ( !empty( $shadow ) ) {
			$out = cloudfw_UI_shadow( $shadow, $out, 'ui--shadow-abs ui--shadow-reset', '<div'. cloudfw_make_class( $shadow_wrap_classes, true ) .'>', '</div>' );
		}

		return $out;

	}

}