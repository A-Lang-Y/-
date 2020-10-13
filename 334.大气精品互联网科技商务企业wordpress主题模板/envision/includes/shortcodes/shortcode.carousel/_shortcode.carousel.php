<?php


cloudfw_register_shortcode( 'CloudFw_Composer_Carousel' );
if ( ! class_exists('CloudFw_Composer_Carousel') ) {
	class CloudFw_Composer_Carousel extends CloudFw_Shortcodes {

		function get_called_class(){ return get_class($this); }

		/** Add the shortcode to the composer */
		function composer(){
			return array(
				'composer'		=> true,
				'droppable'		=> true,
				'ajax'			=> true,
				'icon'			=> 'carousel',
				'group'			=> 'composer_layouts',
				'line'			=> 40,
				'options'		=> array(
					'title'				=> __('Content Carousel','cloudfw'),
					'column'			=> '1/1',
					'allow_columns'		=> false,
					//'not_in'			=> array('CloudFw_Composer_Container', 'CloudFw_Composer_Carousel', 'CloudFw_Shortcode_Testimonial'),
					'allow_only'		=> array(
						'CloudFw_Shortcode_Testimonial',
						'CloudFw_Shortcode_UI_Box',
						'CloudFw_Shortcode_Icon_Boxes',
						'CloudFw_Shortcode_Effects',
						'CloudFw_Composer_Tagline_Box',
					),
				)
			);
		}

		/** Shortcode */
		function shortcode( $atts, $content = NULL, $case = NULL ) {
			extract(cloudfw_make_var(array(
				'effect'      => 'slide',
				'auto_rotate' => 'FALSE',
				'animation_loop' => 'FALSE',
				'arrows'      => true,
				'animate'     => true,
				'rotate_time' => '',
			), _check_onoff_false($atts)));	

			wp_enqueue_script('theme-flexslider');

			if ( $this->is_widget ) {
				$id = isset($atts['page_id']) ? $atts['page_id'] : NULL;
				if ( $id ) {
					$content = cloudfw_get_page_content( $id );
				}
			}
			
			$out  = '';
			$out .= '<div class="ui--carousel clearfix"'.

				cloudfw_json_attribute( 'data-options', array( 
					'effect'      => $effect,
					'auto_rotate' => $auto_rotate,
					'animation_loop' => $animation_loop,
					'arrows'      => $arrows,
					'rotate_time' => (int) $rotate_time * 1000,
					'animate'     => $animate 
				), FALSE )

			.'><div class="slides">';
				$out .= $content;
			$out .= '</div></div>';

			return $out;

		}

		/** Admin Scheme */
		function scheme() {
			return array(
				'title'		=>	__('Content Carousel','cloudfw'),
				'script'	=> array(
					'shortcode' 		=> '',
					'attributes' 		=> array(
						'effect'            => array( 'e' => 'effect' ),
						'auto_rotate'       => array( 'e' => 'auto_rotate', 'onoff' => true ),
						'animation_loop'    => array( 'e' => 'animation_loop', 'onoff' => true ),
						'arrows'            => array( 'e' => 'arrows', 'onoff' => true ),
						'rotate_time'       => array( 'e' => 'rotate_time' ),

					)

				),
				'data'		=>  $this->global_scheme()
			);

		}

		/**
		 *	Global Render Scheme
		 */
		function global_scheme(){
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
					'type'		=>	'module',
					'condition'	=>	$this->is_widget,
					'title'		=>	__('Carousel Page Content','cloudfw'),
					'data'		=>	array(

						## Element
						array(
							'type'		=>	'select',
							'id'		=>	$this->get_field_name('page_id'),
							'value'		=>	$this->get_value('page_id'),
							'main_class'=>  'widefat',
							'source'	=>	array(
								'type'		=>	'function',
								'function'	=>	'cloudfw_admin_loop_all_pages'
							),
							'width'		=>	350
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
							'id'		=>	$this->get_field_name('effect'),
							'value'		=>	$this->get_value('effect'),
							'main_class'=>  'widefat',
							'source'	=>	array(
								'NULL'		=>	__('Slide','cloudfw'),
								'fade'		=>	__('Fade','cloudfw')
							),
							'width'		=>	350
						), // #### element: 0

					)

				),


				array(
					'type'		=>	'module',
					'title'		=>	__('Show Navigation Arrows?','cloudfw'),
					'data'		=>	array(
						array(
							'type'		=>	'onoff',
							'id'		=>	$this->get_field_name('arrows'),
							'value'		=>	$this->get_value('arrows'),
						)
					),
				),

				array(
					'type'		=>	'module',
					'title'		=>	__('Auto Rotate?','cloudfw'),
					'data'		=>	array(
						array(
							'type'		=>	'onoff',
							'id'		=>	$this->get_field_name('auto_rotate'),
							'value'		=>	$this->get_value('auto_rotate'),
						)
					),
				),

				array(
					'type'		=>	'module',
					'title'		=>	__('Auto Rotate Time','cloudfw'),
					'data'		=>	array(
						array(
							'type'		=>	'slider',
							'id'		=>	$this->get_field_name('rotate_time'),
							'value'		=>	$this->get_value('rotate_time'),
							'min'		=>	0,
							'max'		=>	120,
							'step'		=>	.5,
							'steps'		=>	array( 0 => __('Default','cloudfw') ),
							'unit'		=>	__('seconds','cloudfw'),
							'desc'		=>	__('Leave blank for default','cloudfw'),
							'width'		=>	250
						)
					),
				),

				array(
					'type'		=>	'module',
					'title'		=>	__('Animation Loop?','cloudfw'),
					'data'		=>	array(
						array(
							'type'		=>	'onoff',
							'id'		=>	$this->get_field_name('animation_loop'),
							'value'		=>	$this->get_value('animation_loop'),
						)
					),
				),

			);

		}

		/** Scheme */
		function composer_scheme() {
			return array(
				'data'		=>	array(
					cloudfw_composer_default_dropped_area()
				)
			);
		}

	}

}


/** Class */
class CloudFw_Widget_Carousel extends CloudFw_Widgets{
	/** Variables */
	private $class;

	/** Init */
	function __construct() {
		$this->WP_Widget(
			/** Base ID */
			'widget_cloudfw_carousel',
			/** Title */
			__('Theme - Carousel','cloudfw'),
			/** Other Options */
			array( 
				'classname'   => 'widget_cloudfw_carousel', 
				'description' => '',
			),
			/** Size */
			array( 'width'  => 300 )
		);

		/** Services */
		$this->class = new CloudFw_Composer_Carousel();
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
		$scheme['data'] = $this->class->global_scheme();

		return $scheme;

	}

}


/**
 *	Register Widget
 */
register_widget('CloudFw_Widget_Carousel');