<?php


if ( ! class_exists('CloudFw_Flex_Slider') ) {

class CloudFw_Flex_Slider extends CloudFw_Sliders {
	
	/**
	 *	Run slider
	 */
	function slider( $atts, $custom_data = NULL ){
		extract(cloudfw_make_var(array(
			'id'				=> NULL,
		), $atts));	
		
		$slider_options = cloudfw_get_slider_options( $id );
		
		if ($slider_options["source"] == 'shortcode')
			$slider_data = $custom_data;
		else
			$slider_data = cloudfw_get_slider($id);
		
		ob_start();	

		if (is_array($slider_data) && !empty($slider_data)):

			wp_enqueue_script ( 'theme-flexslider' );
			
			$unique_id = 'flex-slider-'.cloudfw_randomizer(4);
			
			if (is_numeric($slider_options["autorotation_speed"]))
				$slider_options["autorotation_speed"] = ($slider_options["autorotation_speed"] * 1000);
			else
				$slider_options["autorotation_speed"] = 10000;
				
			if ($slider_options["autorotation_speed"] < $slider_options["effect_speed"])
					$slider_options["autorotation_speed"] = $slider_options["effect_speed"];
		
			echo '
			<script type="text/javascript">		
			// <![CDATA[
				jQuery(document).ready(function(){
					"use strict";

					jQuery("#'.$unique_id.' .slides > li:eq(0) > img").imagesLoaded(function(){

						CloudFwLoaded(jQuery("#'.$unique_id.'").parents(".flexslider-wrapper").first());
						jQuery("#'.$unique_id.'").flexslider({
							'._if(
								(isset($slider_options["autorotation_speed"]) && $slider_options["autorotation_speed"] > 0 && _check_onoff($slider_options["slideshow"]) ),
								'slideshow: true, slideshowSpeed: '.$slider_options["autorotation_speed"].',',
								'slideshow: false,').'
							'._if((isset($slider_options["effect_speed"]) && $slider_options["effect_speed"] > 0 ),
								'animationDuration: '.$slider_options["effect_speed"].',',
								NULL).'
							animation: "'._if( empty($slider_options["effect"]),'fade',$slider_options["effect"] ).'",
							slideDirection: "'._if( empty($slider_options["direction"]),'horizontal',$slider_options["direction"] ).'",
							controlNav: '._if(_check_onoff($slider_options["pagination"]),'true','false').',
							smoothHeight: true,
							directionNav: '._if(_check_onoff($slider_options["next_prev"]),'true','false').',
							keyboardNav: '._if(_check_onoff($slider_options["keyboard"]),'true','false').',
							mousewheel: '._if(_check_onoff($slider_options["mousewheel"]),'true','false').',
							pauseOnAction: '._if(_check_onoff($slider_options["pause_onaction"]),'true','false').',
							pauseOnHover: '._if(_check_onoff($slider_options["pause_onhover"]),'true','false').'
						});

					});
				
				 }); 
			// ]]>
			</script>
			
			';
		
		echo '
			<div class="flexslider-wrapper ui--loading clearfix">
				<div class="flexslider-relative clearfix">
					<div id="'.$unique_id.'" class="flexslider clearfix'.
					_if(_check_onoff($slider_options["pagination"]),' pagination-on', ' pagination-off') .
					_if($slider_options["direction"],' direction--'. $slider_options["direction"]) .
				'">';

			echo '<ul class="slides">';
			
			// loop
			foreach ($slider_data as $slider_id => $slider){
				
				if ( _check_onoff( $slider_options["crop"] ) )
					$slider_img = cloudfw_thumbnail(array('src' => $slider["slider_image"], 'w' => $slider_options["width"], 'h' => $slider_options["height"], 'cache' =>0));
				else
					$slider_img = $slider["slider_image"];

				if ( empty($html_caption_id) )
					$html_caption_id = '';
				
				echo '<li>';
				echo $slider["slider_url"] ? 
					 '<a href="'.cloudfw_get_page_link($slider["slider_url"]).'"><img src="'.$slider_img.'" '._if($html_caption_id, 'title="#'.$html_caption_id.'" ').'alt=""/></a>':
					 '<img src="'.$slider_img.'" '._if($html_caption_id, 'title="#'.$html_caption_id.'" ').'alt=""/>';
					
					if ( !empty($slider["slider_caption"]) || !empty($slider["caption_text"])  ) {
						$html_caption_id = $unique_id.'-caption-'.$slider_id;
						echo '<p id="'.$html_caption_id.'" class="flex-caption">'.$slider["slider_caption"].'</p>';
					} else
						unset($html_caption_id);

				echo '</li>';
				

			}
			// end of loop
			
			echo '</ul></div><!-- /.flexslider -->';


			if ( _check_onoff($slider_options["next_prev"]) ) {
				echo '<div class="ui--flexslider-navigation clearfix">
							<span class="arr arr-large arr-left flexslider-navigation-prev"><span></span><i class="fontawesome-chevron-left px18"></i></span> <span class="arr arr-large flexslider-navigation-next"><span></span><i class="fontawesome-chevron-right px18"></i></span>
					  </div>';
			}

			echo '</div><!-- /.flexslider-relative -->';
			
			if ( !empty($slider_options["shadow"]) ) {
				echo cloudfw_UI_shadow( $slider_options["shadow"] );
			}

			echo '
			</div>
			';

			echo cloudfw_loader_render();

		endif;
		
		$out = ob_get_contents();
		ob_end_clean();
		
		return $out;

	}

	/**
	 *	Variable map for main options
	 */
	function main_map(){
		$site_max_width = apply_filters('cloudfw_slider_max_width', cloudfw('content_width', 'nomargin'), 'flex_slider');

		return array(
			'foldername',
			'source'             => array('default' => 'manual'),
			'title',
			'direction'          => array('default' => 'horizontal'),
			'effect'             => array('default' => 'fade'),
			'effect_speed'       => array('default' => 500),
			'autorotation_speed' => array('default' => 5),
			'crop'               => array('type' => 'boolean', 'default' => TRUE),
			'width'              => array('default' => $site_max_width),
			'height'             => array('default' => 400),
			'slideshow'          => array('type' => 'boolean', 'default' => TRUE),
			'pagination'         => array('type' => 'boolean', 'default' => TRUE),
			'next_prev'          => array('type' => 'boolean', 'default' => TRUE),
			'keyboard'           => array('type' => 'boolean', 'default' => TRUE),
			'mousewheel'         => array('type' => 'boolean', 'default' => 'FALSE'),
			'pause_onaction'     => array('type' => 'boolean', 'default' => TRUE),
			'pause_onhover'      => array('type' => 'boolean', 'default' => 'FALSE'),
			'pagination_position',
			'shadow',
		);

	}

	/**
	 *	Variable map for item options
	 */
	function item_map(){
		return array(
			'slider_image',
			'slider_url',
			'slider_title',
			'slider_name',
			'slider_caption'
		);

	}


	/**
	 *	Main option scheme
	 */
	function main_scheme( $data ){

		$this->set_data( $data );

		$site_max_width = apply_filters('cloudfw_slider_max_width', cloudfw('content_width', 'nomargin'), 'flex_slider');
		if ( !$data['width'] )
			$data['width'] = $site_max_width;

		$max_width = (int) $data['width'] > $site_max_width ? $data['width'] : $site_max_width;

		return array(				
			## Tab Item
			array(
				'type'			=>	'tabs',
				'tab_id'		=>	'slider_options',
				'tab_title'		=>	__('Slider Options','cloudfw'),
				'data'			=>	array(
				
					array(
						'type'		=>	'module',
						'title'		=>	__('Slider Content Source','cloudfw'),
						'data'		=>	array(
						
							## Element
							array(
								'type'		=>	'select',
								'id'		=>	'source',
								'value'		=>	$data['source'],
								'source'	=>	array(
									array('item_title' => __('Slider Manager','cloudfw'), 'item_value' => 'manual'),
									array('item_title' => __('Composer Module or Shortcode','cloudfw'), 'item_value' => 'shortcode')
								),
								'ui'		=>  true,
								'main_class'=>  'input input_300'
							), // #### element: 0

						)

					),

					array(
						'type'			=>	'module',
						'title'			=>	__('Slider Name','cloudfw'),
						'data'			=>	array(
						
							## Element
							array(
								'type'		=>	'text',
								'id'		=>	'title',
								'value'		=>	$data['title'],
								'_class'	=>  'bold',
							), // #### element: 0
														
						)
					),
					
					array(
						'type'		=>	'module',
						'title'		=>	__('Transition Effect','cloudfw'),
						'data'		=>	array(
						
							## Element
							array(
								'type'		=>	'select',
								'id'		=>	'effect',
								'value'		=>	$data['effect'],
								'source'	=>	array(
									'fade' 			=> 	__('Fade','cloudfw'),
									'slide' 		=> 	__('Slide','cloudfw'),
								),
								'ui'		=>  true,
								'main_class'=>  'input input_300'
							), // #### element: 0
														
						),
						'js' 		=> 	array(
							## Script Item
							array(
								'type' 			=> 'toggle',
								'related' 		=> 'effectOptions',
								'compatibility' => 'module',
								'conditions' 	=> array(
									array( 'val' => 'slide', 'e' => 'direction' ),
								)
							),

						)
					),

					array(
						'type'		=>	'module',
						'title'		=>	__('Direction','cloudfw'),
						'related'	=>	'effectOptions',
						'data'		=>	array(
						
							## Element
							array(
								'type'		=>	'select',
								'id'		=>	'direction',
								'value'		=>	$data['direction'],
								'source'	=>	array(
									'horizontal' 	=> 	__('Horizontal','cloudfw'),
									'vertical' 		=> 	__('Vertical','cloudfw'),
								),
								'ui'		=>  true,
								'main_class'=>  'input input_300'
							), // #### element: 0										
						)
					),
					
					array(
						'type'		=>	'module',
						'title'		=>	__('Transition Speed','cloudfw'),
						'data'		=>	array(
						
							## Element
							array(
								'type'		=>	'slider',
								'id'		=>	'effect_speed',
								'value'		=>	$data['effect_speed'],
								'default_value'=> 500,
								'class'		=>	'input_250',
								'min'		=>	100,
								'max'		=>	10000,
								'step'		=>	100,
								'unit'		=>	'ms'
							),
														
						)
					),

					array(
						'type'		=>	'module',
						'title'		=>	__('Crop Images Automatically?','cloudfw'),
						'data'		=>	array(
						
							## Element
							array(
								'type'		=>	'onoff',
								'id'		=>	'crop',
								'value'		=>	$data['crop'],
							),
														
						),
						'js' 		=> array(
							array(
								'type' 			=> 'toggle',
								'related' 		=> 'sliderCroppingOptions',
								'compatibility' => 'module',
								'conditions' 	=> array(
									array( 'val' => '1', 'e' => 'width' ),
								)
							)

						)
					),

					array(
						'type'		=>	'module',
						'title'		=>	__('Crop Size','cloudfw'),
						'related' 	=> 'sliderCroppingOptions',
						'data'		=>	array(
						
							## Element
							array(
								'type'		=>	'slider',
								'id'		=>	'width',
								'title'		=>	__('Width','cloudfw'),
								'value'		=>	$data['width'],
								'default_value'=> $site_max_width,
								'class'		=>	'input_150',
								'min'		=>	apply_filters('cloudfw_slider_min_width', 100),
								'max'		=>	$max_width,
							),
						
							## Element
							array(
								'type'		=>	'slider',
								'id'		=>	'height',
								'title'		=>	__('Height','cloudfw'),
								'value'		=>	$data['height'],
								'default_value'=> 280,
								'class'		=>	'input_150',
								'min'		=>	apply_filters('cloudfw_slider_min_height', 50),
								'max'		=>	apply_filters('cloudfw_slider_max_height', 1200)
							),
														
						)
					),
					
					array(
						'type'		=>	'module',
						'title'		=>	__('Slideshow','cloudfw'),
						'data'		=>	array(	
							## Element
							array(
								'type'		=>	'onoff',
								'id'		=>	'slideshow',
								'value'		=>	$data['slideshow'],
							),				
														
						),
						'js' 		=> 	array(
							## Script Item
							array(
								'type' 			=> 'toggle',
								'related' 		=> 'slideshowOptions',
								'compatibility' => 'module',
								'conditions' 	=> array(
									array( 'val' => '1', 'e' => 'autorotation_speed' ),
								)
							),

						)

					),

					array(
						'type'		=>	'module',
						'title'		=>	__('Pause Time','cloudfw'),
						'related'	=>	'slideshowOptions',
						'data'		=>	array(

							## Element
							array(
								'type'		=>	'slider',
								'id'		=>	'autorotation_speed',
								'value'		=>	$data['autorotation_speed'],
								'default_value'=> 5,
								'class'		=>	'input_250',
								'min'		=>	1,
								'max'		=>	120,
								'step'		=>	.5,
								'unit'		=>	__('second(s)','cloudfw')
							),
														
						)
					),
					
					array(
						'type'		=>	'module',
						'title'		=>	__('Next/Previous Navigation','cloudfw'),
						'data'		=>	array(
						
							## Element
							array(
								'type'		=>	'onoff',
								'id'		=>	'next_prev',
								'value'		=>	$data['next_prev'],
							),


						)

					), 

					array(
						'type'		=> 'module',
						'title'		=> __('Pagination','cloudfw'),
						'data'		=> array(

							## Element
							array(
								'type'		=>	'onoff',
								'id'		=>	'pagination',
								'value'		=>	$data['pagination'],
							),


						)

					),

					array(
						'type'		=>	'module',
						'layout'	=>	'split',
						'title'		=>	array(__('Keyboard Navigation','cloudfw'), __('Mousewheel Navigation','cloudfw')),
						'data'		=>	array(
						
							## Element
							array(
								'type'		=>	'onoff',
								'id'		=>	'keyboard',
								'value'		=>	$data['keyboard'],
							),

							## Element
							array(
								'type'		=>	'onoff',
								'id'		=>	'mousewheel',
								'value'		=>	$data['mousewheel'],
							),
														
						)
					),

					array(
						'type'		=>	'module',
						'layout'	=>	'split',
						'title'		=>	array(__('Pause on Action','cloudfw'), __('Pause on Hover','cloudfw')),
						'data'		=>	array(
						
							## Element
							array(
								'type'		=>	'onoff',
								'id'		=>	'pause_onaction',
								'value'		=>	$data['pause_onaction'],
							),

							## Element
							array(
								'type'		=>	'onoff',
								'id'		=>	'pause_onhover',
								'value'		=>	$data['pause_onhover'],
							),
														
						)
					),

					array(
						'type'		=> 'module',
						'title'		=> __('Shadow','cloudfw'),
						'data'		=> array(

							## Element
							array(
								'type'		=>	'select',
								'id'		=>	'shadow',
								'value'		=>	$data['shadow'],
								'ui'		=>	true,
								'main_class'=>  'input input_250',
								'source'	=>	array(
									'type'			=> 'function',
									'function'		=> 'cloudfw_admin_loop_shadows',
								)

							), // #### element: 0

						)

					),

				)

			),

			## Tab Item
			array(
				'type'			=>	'tabs',
				'tab_id'		=>	'export_options',
				'tab_title'		=>	__('Export','cloudfw'),
				'data'			=>	array(
				
					array(
						'type'			=>	'module',
						'title'		=>	__('Export Folder Name','cloudfw'),
						'data'			=>	array(
						
							## Element
							array(
								'type'		=>	'text',
								'id'		=>	'foldername',
								'value'		=>	$data['foldername'],
								'_class'	=>  'bold',
							), // #### element: 0
														
						)

					),
							
				)

			),

		);

	}


	/**
	 *	Item scheme
	 */
	function item_scheme( $data ){
		global $slider_id, $main_slider_id, $main_slider_data;

		$this->set_data( $data );

		return array(

			array(
				'type'			=>	'module',
				'title'		=>	__('Item Name','cloudfw'),
				'data'			=>	array(
				
					## Element
					array(
						'type'		=>	'text',
						'id'		=>	'slider_name',
						'value'		=>	$this->get_value('slider_name'),
						'_class'	=>  'bold',
					), // #### element: 0
												
				)
			), 

			## Module Item
			array(
				'type'		=>	'module',
				'title'		=>	__('Image URL','cloudfw'),
				'data'		=>	array(
					array(
						'type'		=>	'upload',
						'id'		=>	'slider_image',
						'value'		=>	$this->get_value('slider_image'),
						'description'=>	sprintf(__('Fixed Size: %s x %s px','cloudfw'), $main_slider_data['width'], $main_slider_data['height'])
					)
				)
			),
								
			## Module Item
			array(
				'type'		=>	'module',
				'title'		=>	__('Link URL','cloudfw'),
				'data'		=>	array(
					array(
						'type'		=>	'page-selector',
						'id'		=>	'slider_url',
						'value'		=>	$this->get_value('slider_url'),
					)
				)
			),
			
			## Module Item
			array(
				'type'		=>	'module',
				'title'		=>	__('Slider Text','cloudfw'),
				'data'		=>	array(
					array(
						'type'		=>	'textarea',
						'id'		=>	'slider_caption',
						'value'		=>	$this->get_value('slider_caption'),
						'width'		=>	'90%',
						'line'		=>	3,
						'editor'	=>	true,
					)
				)
			),	

		);

	}


	/**
	 *	Skin map
	 */
	/*function skin_map( $map ){

	    return $map;

	}*/


	/**
	 *	Skin scheme
	 */
	/*function skin_scheme( $schemes, $data ){
		return cloudfw_add_skin_scheme( 'slider',
			$schemes,
			array(
				'type'		=>	'module-set',
				'title'		=>	__('Flex Slider','cloudfw'),
				'closable'	=>	true,
				'state'		=>	'opened',
				'data'		=>	array(

														
				) // module set data
					
			)
			
		);

	}*/

}

}