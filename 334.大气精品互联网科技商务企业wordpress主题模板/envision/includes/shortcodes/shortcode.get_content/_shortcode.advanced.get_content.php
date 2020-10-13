<?php
/*
 * Plugin Name: Get Content
 * Plugin URI: http://cloudfw.net
 * Description: 
 * Version: 1.0
 * Author: Orkun Gürsel
 * Author URI: http://orkungursel.com
 * Shortcode:  [the_content]
 * Attributes: (int) id
 */

cloudfw_register_shortcode( 'CloudFw_Shortcode_Get_Content', 'the_content', 'advanced', 30 );
if ( ! class_exists('CloudFw_Shortcode_Get_Content') ) {
	class CloudFw_Shortcode_Get_Content extends CloudFw_Shortcodes {

		function get_called_class(){ return get_class($this); }


		/** Add the shortcode to the composer */
		function composer(){
			return array(
				'composer'		=> true,
				'ajax'			=> true,
				'icon'			=> 'page-content',
				'group'			=> 'composer_widgets',
				'line'			=> 380,
				'options'		=> array(
					'title'				=> __('Page Content','cloudfw'),
					'sync_title'		=> 'the_content_id',
					'column'			=> '1/1',
					'allow_columns'		=> false,
				)
			);
		}

		/** Run */
		function shortcode( $atts = array(), $content =  NULL ) {
			extract(shortcode_atts(array(
				"id" 		=> NULL
			), $atts));
			
			if (empty($id) || !is_numeric($id) )
				return cloudfw_error_message(__('Please insert a correct id when using "the_content" shortcode','cloudfw'));

			$out = cloudfw_get_page_content( $id );  

			return !empty($out) ? 
					do_shortcode( $out ) :
					'';
					//cloudfw_error_message( sprintf(__('The page content (id:%s) cannot found','cloudfw'), $id) );

		}

		/** Scheme */
		function scheme() {
			return array(
				'title'		=>	__('Get Page Content','cloudfw'),
				'ajax'		=>	true,
				'script'	=> array(
					'shortcode'		=> 'the_content',
					'tag_close'  	=> false,
					'attributes' 	=> array( 
						'id' 		=> array( 'e' => 'the_content_id', 'required' => __('Please select a page','cloudfw') ),
					)
				),
				'data'		=>  $this->load_scheme( __FILE__ )

			);

		}

	}

}




/** Class */
class CloudFw_Widget_Get_Content extends CloudFw_Widgets{
	/** Variables */
	private $class;

	/** Init */
	function __construct() {
		$this->WP_Widget(
			/** Base ID */
			'widget_cloudfw_get_content',
			/** Title */
			__('Theme - Get Page Content','cloudfw'),
			/** Other Options */
			array( 
				'classname'   => 'widget_cloudfw_get_content', 
				'description' => '',
			),
			/** Size */
			array( 'width'  => 300 )
		);

		/** Services */
		$this->class = new CloudFw_Shortcode_Get_Content();
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

		$scheme = array();
		$scheme['data'] = $this->class->load_scheme( __FILE__ );

		return $scheme;

	}

}


/**
 *	Register Widget
 */
register_widget('CloudFw_Widget_Get_Content');