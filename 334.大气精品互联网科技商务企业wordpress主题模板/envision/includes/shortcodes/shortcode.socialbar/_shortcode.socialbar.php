<?php

/*
 * Plugin Name: Socialbars
 * Plugin URI: http://cloudfw.net
 * Description: 
 * Version: 1.0
 * Author: Orkun Gürsel
 * Author URI: http://orkungursel.com
 * Shortcode: 
 * Attributes:
 */


function cloudfw_socialbar_services(){
	return apply_filters( 'cloudfw_socialbar_services',  array(
		'facebook'    =>	array( 'title' => __('Facebook','cloudfw') ),
		'twitter'     =>	array( 'title' => __('Twitter','cloudfw') ),
		'twitter-alt' =>	array( 'title' => __('Twitter Alternative','cloudfw'), 'alt' => __('Twitter','cloudfw') ),
		'flickr'      =>	array( 'title' => __('Flickr','cloudfw') ),
		'linkedin'    =>	array( 'title' => __('Linkedin','cloudfw') ),
		'google'      =>	array( 'title' => __('Google','cloudfw') ),
		'googleplus'  =>	array( 'title' => __('Google Plus','cloudfw') ),
		'googledrive' =>	array( 'title' => __('Google Drive','cloudfw') ),
		'digg'        =>	array( 'title' => __('Digg','cloudfw') ),
		'dribbble'    =>	array( 'title' => __('Dribbble','cloudfw') ),
		'dropbox'     =>	array( 'title' => __('Dropbox','cloudfw') ),
		'deviantart'  =>	array( 'title' => __('Deviantart','cloudfw') ),
		'delicious'   =>	array( 'title' => __('Delicious','cloudfw') ),
		'ebay'        =>	array( 'title' => __('Ebay','cloudfw') ),
		'forrst'      =>	array( 'title' => __('Forrst','cloudfw') ),
		'html5'       =>	array( 'title' => __('Html5','cloudfw') ),
		'soundcloud'  =>	array( 'title' => __('Soundcloud','cloudfw') ),
		'lastfm'      =>	array( 'title' => __('Lastfm','cloudfw') ),
		'myspace'     =>	array( 'title' => __('Myspace','cloudfw') ),
		'paypal'      =>	array( 'title' => __('Paypal','cloudfw') ),
		'picasa'      =>	array( 'title' => __('Picasa','cloudfw') ),
		'pinterest'   =>	array( 'title' => __('Pinterest','cloudfw') ),
		'reddit'      =>	array( 'title' => __('Reddit','cloudfw') ),
		'skype'       =>	array( 'title' => __('Skype','cloudfw') ),
		'stumbleupon' =>	array( 'title' => __('Stumbleupon','cloudfw') ),
		'blogger'      =>	array( 'title' => __('Blogger','cloudfw') ),
		'tumblr'      =>	array( 'title' => __('Tumblr','cloudfw') ),
		'technorati'  =>	array( 'title' => __('Technorati','cloudfw') ),
		'vimeo'       =>	array( 'title' => __('Vimeo','cloudfw') ),
		'wordpress'   =>	array( 'title' => __('Wordpress','cloudfw') ),
		'yahoo'       =>	array( 'title' => __('Yahoo','cloudfw') ),
		'youtube'     =>	array( 'title' => __('Youtube','cloudfw') ),
		'github'      =>	array( 'title' => __('Github','cloudfw') ),
		'behance'     =>	array( 'title' => __('Behance','cloudfw') ),
		'yelp'        =>	array( 'title' => __('Yelp','cloudfw') ),
		'instagram'   =>	array( 'title' => __('Instagram','cloudfw') ),
		'foursquare'  =>	array( 'title' => __('Foursquare','cloudfw') ),
		'zerply'      =>	array( 'title' => __('Zerply','cloudfw') ),
		'amazon'      =>	array( 'title' => __('Amazon','cloudfw') ),
		'windows'     =>	array( 'title' => __('Windows','cloudfw') ),
		'apple'       =>	array( 'title' => __('Apple','cloudfw') ),
		'android'     =>	array( 'title' => __('Android','cloudfw') ),
		'rss'         =>	array( 'title' => __('Rss','cloudfw'), 'default' => get_bloginfo('rss2_url'), 'target' => '_self' ),
		'mail'        =>	array( 'title' => __('Mail','cloudfw'), 'default' => 'mailto:'.get_bloginfo('admin_email'), 'target' => '_self' ),
	));
}

function cloudfw_socialbar_sprites(){
	return apply_filters( 'cloudfw_socialbar_sprites',  array(
		'default'             =>	__('Default','cloudfw'),
		'colorful-gradient'   =>	__('Colorful Gradient Icons / Transparent Background','cloudfw'),
		'grey-gradient'       =>	__('Grey Icons / Hover Gradient Background','cloudfw'),
		'grey-bevel-gradient' =>	__('Grey (Bevel Effect) Icons / Hover Gradient Background','cloudfw'),
		'white-gradient'      =>	__('White Icons / Hover Gradient Background','cloudfw'),
		'white_p50-gradient'  =>	__('White (50% Transparent) Icons / Hover Gradient Background','cloudfw'),
		'dark-gradient'       =>	__('Dark Icons / Hover Gradient Background','cloudfw'),
		'dark_p50-gradient'   =>	__('Dark (50% Transparent) Icons / Hover Gradient Background','cloudfw'),
		'blue-gradient'       =>	__('Blue Icons / Hover Gradient Background','cloudfw'),
		'grey-transparent'    =>	__('Grey Icons / White Transparent Background','cloudfw'),
	));
}

function cloudfw_socialbar( $option, $services ){
	$option = shortcode_atts(array(
		'echo'				=> false,
		'effect'			=> 'slide',
		'size'				=> NULL,
		'align'				=> NULL,
		'color'				=> '',
		'radius'			=> '',

		'start_color'		=> '',
		'end_color'			=> '',
		'hover_start_color'	=> '',
		'hover_end_color'	=> '',
		
		'border_color'		=> '',
		'borderless'		=> true,
		
		'element'			=> 'ul',
		'id'				=> '',
		'class'				=> '',

		'item_element'		=> 'li',
		'item_class'		=> '',
		'all_class'			=> '',
		'custom_effect'		=> '',

		'wrapper'			=> false,
		'wrapper_element'	=> 'div',
		'wrapper_id'		=> '',
		'wrapper_class'		=> '',

	), $option); 

	$out = '';  
	if ( !empty($services) && is_array($services) ) {

		$id = $option['id']; 

		if ( empty( $id ) ) {
			$id = cloudfw_id( 'socialbar' );
		}

		/** Get the list of all services */
		$services_list = cloudfw_socialbar_services();
	
		$ss_class = array(); 
		if ( $option['size'] == 'big' ) {
			$ss_class[] = 'ss';
		} else {
			$ss_class[] = 'ssm';
		}

		if ( $option['color'] ) {
			$ss_class[] = $option['color'];
		}

		/** Define Colors */
		if ( empty( $option['start_color'] ) ) {
			$option['start_color'] = $option['end_color']; 
		}

		if ( empty( $option['hover_start_color'] ) ) {
			$option['hover_start_color'] = $option['hover_end_color'];
		}

		/** Check for bg color */
		if ( !empty( $option['start_color'] ) ) {
			$ss_class[] = 'with-bg';
		}

		if ( $option['effect'] ) {
			$ss_class[] = 'effect--'. $option['effect'];
		}
		
		if ( $option['borderless'] ) {
			$ss_class[] = 'borderless';
		}

		if ( $option['radius'] ) {
			if ( !empty( $option['all_class'] ) ) {
				$option['all_class'] .= ' '. $option['radius'];
			} else {
				$option['all_class'] = $option['radius'];
			}
		}

		if ( isset($option['align']) && $option['align'] == 'left' ) {
			$option['align'] = '';
		}

		if ( isset($option['align']) && $option['align'] ) {
			$out .= '<div class="text-' . $option['align'] . '">';
		}


		if ( $option['wrapper'] ) {
			$out .= '<'. $option['wrapper_element'] .' id="'. $option['wrapper_id'] .'" class="'. $option['wrapper_class'] .'">';
		}


		$classes = array(); 
		$classes[] = 'ui-socialbar'; 
		$classes[] = 'unstyled'; 
		$classes[] = $option['class']; 
		$classes[] = implode(' ', $ss_class); 

		$out .= "<{$option['element']}". 
			cloudfw_make_id( $id ) .
			cloudfw_make_class( $classes, true ) .
		">";

		foreach ( $services as $service ) {

			if ( !empty( $service ) && isset($services_list[$service['service']]) ) {
				$service_title   = isset($services_list[$service['service']]['title']) ? $services_list[$service['service']]['title'] : NULL;
				$service_title   = isset($services_list[$service['service']]['alt']) ? $services_list[$service['service']]['alt'] : $service_title;
				$service_pattern = isset($services_list[$service['service']]['pattern']) ? $services_list[$service['service']]['pattern'] : NULL;
				$service_default = isset($services_list[$service['service']]['default']) ? $services_list[$service['service']]['default'] : NULL;
				$service_target  = isset($services_list[$service['service']]['target']) ? $services_list[$service['service']]['target'] : NULL;

				if ( !(isset($service['url']) && $service['url']) && $service_default ) {
					$service['url'] = $service_default;
				}

				$href = $service_pattern ? sprintf( $service_pattern, $service['url'] ) : $service['url'];

				$item_classes = array(); 
				$item_classes[] = $service['service']; 
				$item_classes[] = $option['item_class']; 
				$item_classes[] = $option['all_class']; 
				$item_classes[] = 'ui-socialbar-item'; 
				$item_classes[] = 'ui--animation'; 
				
				$item_attributes = array();
				if ( $option['custom_effect'] ) {
					$item_attributes['data-fx'] = $option['custom_effect'];
				}

				$link_classes = array(); 
				$link_classes[] = 'ui-socialbar-image'; 
				$link_classes[] = $option['all_class']; 

				$out .= "<{$option['item_element']}". 
					cloudfw_make_class( $item_classes, true ) .
					cloudfw_make_attribute( $item_attributes, FALSE ) .
				">";

					if ( !empty($option['hover_start_color']) ) {
						$out .= '<div class="ui-socialbar-background-hover '. $option['all_class'] .'"></div>';
					}

					$out .= '<div class="ui-socialbar-image ui-socialbar-background '. $option['all_class'] .'"></div>';
					$out .= "<a". 
						cloudfw_make_attribute( array( 
							'href'   => $href,
							'class'  => $link_classes,
							'target' => isset($service_target) ? $service_target : '_blank',
							'title'  => isset($service_title) ? $service_title : '',
						), FALSE, TRUE ) .
					"></a>";
				$out .= "</{$option['item_element']}>";

			}

		}

		$out .= '</'. $option['element'] .'>';

		if ( $option['wrapper'] ) {
			$out .= '</'. $option['wrapper_element'] .'>';
		}
		
		if ( isset($option['align']) && $option['align'] ) {
			$out .= '</div>';
		}

	}

	$css = '';
	$css .= cloudfw_make_style( array( 
			"html #{$id} .ui-socialbar-item",
		), array( 
			'gradient' => array( $option['start_color'], $option['end_color'] ),
		), FALSE, FALSE 
	);

	$css .= cloudfw_make_style( array( 
			"html #{$id} .ui-socialbar-item .ui-socialbar-background-hover",
		), array( 
			'gradient' => array( $option['hover_start_color'], $option['hover_end_color'] ),
		), FALSE, FALSE 
	);

	$css .= cloudfw_make_style( array( 
			"html #{$id} .ui-socialbar-item",
		), array( 
			'+border' => $option['border_color'],
		), FALSE, FALSE 
	);

	cloudfw_inline_css( $id, $css );
	unset( $css );


	if ( $option['echo'] ) {
		echo $out;
	}

	return 	$out;

}



cloudfw_register_shortcode( 'CloudFw_Shortcode_Socialbar', NULL, 'advanced', 66 );
if ( ! class_exists('CloudFw_Shortcode_Socialbar') ) {
	class CloudFw_Shortcode_Socialbar extends CloudFw_Shortcodes {

		function get_called_class(){ return get_class($this); }

		public $do_before = false;

		var $atts	= array();
		var $header	= '';
		var $footer	= '';
		var $content= '';
		var $services = array();

		function CloudFw_Shortcode_Socialbar() {
			$this->services = cloudfw_socialbar_services();
		}

		/**
		 *	Add
		 */
		function add() {
			return array(
				'socialbar' 			=> array( &$this, 'socialbar' ),
				'socialbar_service' 	=> array( &$this, 'socialbar_service' ),
			);
		}

		/*
		 *	Shortcode via Composer
		 */
		function shortcode($atts, $content = NULL, $case = NULL){
			$services = cloudfw_walk_options( array( 
				'indicator' => 'indicator',
				'service'	=> 'socialbar_service_id',
				'url'		=> 'socialbar_service_url',
			), $atts );

			return cloudfw_socialbar( $atts, $services );

		}

		/*
		 *	Shortcode via Manual Code
		 */
		function socialbar($atts, $content =  NULL, $case = NULL){

			$this->contents = array();
			do_shortcode( $content );

			return cloudfw_socialbar( $atts, $this->contents );
		}

		/**
		 *	Items
		 */
		function socialbar_service($atts, $content =  NULL, $case = NULL){
			$atts = shortcode_atts(array(
				'service'	=> '',
				'url'		=> '',
			), $atts);

			$this->contents[] = $atts;
		}

		/** Add the shortcode to the composer */
		function composer(){
			return array(
				'composer'		=> true,
				'droppable'		=> false,
				'ajax'			=> true,
				'icon'			=> 'social-services',
				'group'			=> 'composer_widgets',
				'line'			=> 390,
				'options'		=> array(
					'title'				=> __('Social Services','cloudfw'),
					'column'			=> '1/1',
				)
			);
		}

		/** Admin Scheme */
		function scheme() {

			return array(
				'title'		=>	__('Social Services','cloudfw'),
				'script'	=> array(
					'shortcode'		=> 'socialbar',
					'tag_close'  	=> true,
					'tag_newline' 	=> false,
					'attributes' 	=> array( 
						'size' 				=> array( 'e' => 'socialbar_size' ),
						'align'				=> array( 'e' => 'socialbar_align' ),
						'color' 			=> array( 'e' => 'socialbar_color' ),
						'radius' 			=> array( 'e' => 'socialbar_radius' ),
						'effect' 			=> array( 'e' => 'socialbar_effect' ),

						'start_color' 		=> array( 'e' => 'socialbar_background_0' ),
						'end_color' 		=> array( 'e' => 'socialbar_background_1' ),
						'hover_start_color' => array( 'e' => 'socialbar_hover_background_0' ),
						'hover_end_color' 	=> array( 'e' => 'socialbar_hover_background_1' ),

						'border_color' 		=> array( 'e' => 'socialbar_border_color' ),
						'custom_effect' 	=> array( 'e' => 'socialbar_custom_effect' ),

						'content' 			=> array( 
							'e'       			=> 'socialbar_services_all', 
							'multi'   			=> 'socialbar_service_clone_class',
							'check_visiblity'   => false,
							'tag_newline'   	=> false,
							'data' 	 			=> array(

								array(
									'id' 	  => 'socialbar_service',
									'script'  => array(
										'shortcode' 	=> 'socialbar_service',
										'tag_close'  	=> false,
										'tag_newline_default' => true,
										'prepend' 		=> '\'+$tb+\'',
										'attributes' 	=> array(
											'service' 		=> array( 'e' => 'socialbar_service_id' ),
											'url' 			=> array( 'e' => 'socialbar_service_url' ),
										)
									),
								)

							)

						),
					),

				),
				'data'		=>	$this->global_scheme()

			);

		}

		/**
		 *	Global Render Scheme
		 */
		function global_scheme(){
			foreach ( (array) $this->services as $service_id => $service )
				$this->services_select[ $service_id ] = $service['title'];

			return array(

					array(
						'type'		=>	'module',
						'condition'	=>	$this->is_widget,
						'title'		=>	__('Title','cloudfw'),
						'data'		=>	array(
							array(
								'type'		=>	'text',
								'id'		=>	$this->get_field_name('title'),
								'value'		=>	$this->get_value('title'),
								'_class'		=>	'widefat',
							)
						),
					),


					array(
						'type'		=>	'mini-section',
						'title'		=>	__('Icon Set','cloudfw'),
						'data'		=>	array(

							array(
								'type'		=>	'module',
								'title'		=>	__('Icon Set','cloudfw'),
								'data'		=>	array(
									array(
										'type'		=>	'select',
										'id'		=>	$this->get_field_name('socialbar_color'),
										'value'		=>	$this->get_value('socialbar_color'),
										'source'	=>	array(
											'type'		=>	'function',
											'function'	=>	'cloudfw_socialbar_sprites',
										),
										'width'		=>	'400',
									)
								)
							),

							array(
								'type'		=>	'module',
								'title'		=>	__('Icon Size','cloudfw'),
								'data'		=>	array(
									array(
										'type'		=>	'select',
										'id'		=>	$this->get_field_name('socialbar_size'),
										'value'		=>	$this->get_value('socialbar_size'),
										'source'	=>	array(
											'NULL'		=>	__('30px','cloudfw'),
											'big'		=>	__('40px','cloudfw'),
										),
										'width'		=>	'250',
									)
								),
							),
						)
					),

					array(
						'type'		=>	'mini-section',
						'title'		=>	__('Options','cloudfw'),
						'data'		=>	array(

							array(
								'type'		=>	'module',
								'title'		=>	__('Hover Effect','cloudfw'),
								'data'		=>	array(
									array(
										'type'		=>	'select',
										'id'		=>	$this->get_field_name('socialbar_effect'),
										'value'		=>	$this->get_value('socialbar_effect'),
										'source'	=>	array(
											'NULL'		=>	__('Slide','cloudfw'),
											'fade'		=>	__('Fade','cloudfw'),
										),
										'width'		=>	'250',
									)
								),
							),

							array(
								'type'		=>	'module',
								'title'		=>	__('Align','cloudfw'),
								'data'		=>	array(
									array(
										'type'		=>	'select',
										'id'		=>	$this->get_field_name('socialbar_align'),
										'value'		=>	$this->get_value('socialbar_align'),
										'source'	=>	array(
											'NULL'		=>	__('Left','cloudfw'),
											'center'	=>	__('Center','cloudfw'),
											'right'		=>	__('Right','cloudfw'),
										),
										'width'		=>	'250',
									)
								),
							),

							array(
								'type'		=>	'module',
								'title'		=>	__('Border Radius','cloudfw'),
								'data'		=>	array(
									array(
										'type'		=>	'select',
										'id'		=>	$this->get_field_name('socialbar_radius'),
										'value'		=>	$this->get_value('socialbar_radius'),
										'source'	=>	array(
											'NULL'			=> __('Default','cloudfw'),
											'radius-circle'	=> __('Circle','cloudfw'),
											'radius-3px'	=> __('3px Radius','cloudfw'),
											'radius-30px'	=> __('30px Radius','cloudfw'),
											'no-radius'		=> __('No Radius','cloudfw'),
										),
										'width'		=>	'250',
									)
								),
							),

							array(
								'type'		=> 'module',
								'title'		=> __('Custom Transition Effect','cloudfw'),
								'data'		=> array(

									## Element
									array(
										'type'		=>	'select',
										'id'		=>	$this->get_field_name('socialbar_custom_effect'),
										'value'		=>	$this->get_value('socialbar_custom_effect'),
										'source'	=>	array(
											'type'		=>	'function',
											'function'	=>	'cloudfw_css_effect_list',
										),
										'width'		=>	400,
									),

								)

							),

						)
					),

					array(
						'type'		=>	'mini-section',
						'title'		=>	__('Colors','cloudfw'),
						'data'		=>	array(

							## Module Item
							array(
								'type'		=>	'module',
								'title'		=>	__('Background','cloudfw'),
								'data'		=>	array(
									array(
										'type'		=>	'gradient',
										'id'		=>	$this->get_field_name('socialbar_background'),
										'value'		=>	array( $this->get_value('socialbar_background_0'), $this->get_value('socialbar_background_1') ),	
									)
								),
							),

							## Module Item
							array(
								'type'		=>	'module',
								'title'		=>	__('Hover Background','cloudfw'),
								'data'		=>	array(
									array(
										'type'		=>	'gradient',
										'id'		=>	$this->get_field_name('socialbar_hover_background'),
										'value'		=>	array( $this->get_value('socialbar_hover_background_0'), $this->get_value('socialbar_hover_background_1') ),	
									)
								),
							),

							## Module Item
							array(
								'type'		=>	'module',
								'title'		=>	__('Border Color','cloudfw'),
								'data'		=>	array(
									array(
										'type'		=>	'color',
										'style'		=>	'horizontal',
										'id'		=>	$this->get_field_name('socialbar_border_color'),
										'value'		=>	$this->get_value('socialbar_border_color'),	
									)
								),
							),

						)

					),

					array(
						'type'		=>	'mini-section',
						'title'		=>	__('Services','cloudfw'),
					),

					array(
						'type'		=>	'sorting',
						'id'		=>	'socialbar_sorting',
						'item:id'	=>	'socialbar_service_clone',
						'data'		=> 

							cloudfw_core_loop_multi_option( 
								
								array(
									'start' 	=> 5,
									'indicator' => $this->get_value('indicator'),
									'dummy'		=> true,
									'data' 		=> 

										array(
											'type'		=>	'module',
											'title'		=>	_if( !$this->is_widget , __('Service','cloudfw') ),
											'layout'	=>	'vertical',
											'_class'	=>  'socialbar_service_clone_class',
											'data'		=>	array(
							
												## Module Item
												array(
													'type'		=>	'remove',
												),

												## Module Item
												array(
													'type'		=>	'indicator',
													'id'		=>	$this->get_field_name('indicator'),
												),

												## Element
												array(
													'type'		=>	'select',
													'title'		=>	__('Service','cloudfw'),
													'id'		=>	$this->get_field_name('socialbar_service_id'),
													'value'		=>	$this->get_value('socialbar_service_id'),
													'reset'		=>	'',
													'source'	=>	$this->services_select,
													'width'		=>	'200',
													'brackets'	=>	true

												), // #### element: 0

												## Element
												array(
													'type'		=>	'text',
													'title'		=>	__('URL','cloudfw'),
													'id'		=>	$this->get_field_name('socialbar_service_url'),
													'value'		=>	$this->get_value('socialbar_service_url'),
													'reset'		=>	'',
													'_class'	=>  'input_150 tab_item_title',
													'brackets'	=>	true

												), // #### element: 0

											)

										),

								)

							)

					),

					## Element
					array(
						'type'		=>	'html',
						'data'		=>	'<a data-target="" class="cloudfw-action-duplicate cloudfw-ui-button cloudfw-ui-button-metro cloudfw-ui-button-metro-green" href="javascript:;"><span>'.__('+ Add New Service','cloudfw').'</span></a>',
					), // #### element: 0
			);


		}

	}

}

/** Class */
class CloudFw_Widget_Socialbar extends CloudFw_Widgets{
	/** Variables */
	public $services = array();
	public $services_dir = '';
	private $class;

	/** Init */
	function __construct() {
		$this->WP_Widget(
			/** Base ID */
			'widget_cloudfw_socialbar',
			/** Title */
			__('Theme - Socialbar','cloudfw'),
			/** Other Options */
			array( 
				'classname'   => 'widget_cloudfw_socialbar', 
				'description' => '',
			),
			/** Size */
			array( 'width'  => 300 )
		);

		/** Services */
		$this->class = new CloudFw_Shortcode_Socialbar();
		$this->class->is_widget = true;
		$this->class->widget = $this;
	}

	/** Render */
	function widget($args, $instance) {
		extract($args, EXTR_SKIP);
		$title = isset($instance['title']) ? $instance['title'] : NULL; 

		echo $before_widget;
		$title = empty($title) ? '' : apply_filters('widget_title', $title);

		if ( !empty( $title ) )	
			echo $before_title . $title . $after_title;

		$shortcode_options = $this->class->scheme();
		$instance = cloudfw_composer_convert_data( $instance, $shortcode_options['script'] );
		
			echo do_shortcode($this->class->shortcode( $instance ));
		
		echo $after_widget;
	}

	/** Scheme */
	function scheme( $data = array() ) {

		/** Defaults */
		$data = wp_parse_args( $data, array() );
		$this->class->set_data( $data );

		$services = array(); 
		foreach ( (array) $this->class->services as $service_id => $service )
			$services[ $service_id ] = $service['title'];

		$scheme = array();
		$scheme['data'] = $this->class->global_scheme();

		return $scheme;

	}

}


/**
 *	Register Widget
 */
register_widget('CloudFw_Widget_Socialbar');