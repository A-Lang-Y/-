<?php
/*
 * Plugin Name: Progress Circle
 * Plugin URI: http://cloudfw.net
 * Description: 
 * Version: 1.0
 * Author: Orkun Gürsel
 * Author URI: http://orkungursel.com
 * Shortcode:  [progress_circle]
 */
cloudfw_register_shortcode( 'CloudFw_Shortcode_Progress_Circle', 'progress_circle', 'advanced', 10 );
if ( ! class_exists('CloudFw_Shortcode_Progress_Circle') ) {
	class CloudFw_Shortcode_Progress_Circle extends CloudFw_Shortcodes {

		public $do_before = false;

		function get_called_class(){ return get_class($this); }


		/** Add the shortcode to the composer */
		function composer(){
			return array(
				'composer'		=> true,
				'droppable'		=> false,
				'ajax'			=> true,
				'icon'			=> 'Circle_Grey',
				'group'			=> 'composer_widgets',
				'line'			=> 360,
				'options'		=> array(
					'title'				=> __('Circle Progress Bar','cloudfw'),
					'sync_title'		=> 'progress_circle_label',
					'column'			=> '1/1',
					'allow_columns'		=> true,
				)
			);
		}

		function CloudFw_Shortcode_Progress_Circle(){
			add_action('init', array( &$this, 'register_sources' ));
		}

		function register_sources(){
			wp_register_script ('theme-excanvas',  cloudfw_relative_path( dirname(__FILE__) ).'/js/excanvas.js', NULL, cloudfw_get_combined_version(), true);
			wp_register_script ('theme-pie-chart',  cloudfw_relative_path( dirname(__FILE__) ).'/js/jquery.easy-pie-chart.js', array('theme-excanvas'), cloudfw_get_combined_version(), true);
		}

		/** Run */
		function shortcode( $atts = array(), $content =  NULL ) {
			extract(shortcode_atts(array(			
				'label' 		=> '',
				'percent' 		=> '',
				'size' 			=> 200,
				'rotate' 		=> -90,
				'bar_width' 	=> NULL,
				'bar_color' 	=> NULL,
				'track_color' 	=> NULL,
				'margin_top'     => '',
				'margin_bottom'  => '',

			), _check_onoff_false($atts)));

			wp_enqueue_script( 'theme-viewport' );
			wp_enqueue_script( 'theme-pie-chart' );

			if ( (int) $percent < 0 || (int) $percent > 100 )
				$percent = 0;
			
			if ( empty( $content ) ) {
				$content = '<strong>{{percent}}</strong>%';
			}

			$percent_counter_html = '<span class="ui--progress-circle-percent">'. $percent .'</span>';
			$percent_html = str_replace('{{percent}}', $percent_counter_html, $content);


			$attributes = array();
			$classes = array();
			$classes[] = 'ui--progress-circle'; 
			$classes[] = 'clearfix';

			$out  = '';
			$out .= "<div ". 
				cloudfw_make_class('ui--progress-circle-wrapper', true) .
				cloudfw_make_style_attribute( array( 
					'margin-top'    => $margin_top,
					'margin-bottom' => $margin_bottom,
				), FALSE, TRUE )
			.">";

				if ( ! $bar_color ) {
					$bar_color = cloudfw_get_skin_value( 'accent', 'gradient', 1 );
				}

				$bar_color = cloudfw_value_color( $bar_color );

				if ( ! $track_color ) {
					$track_color = '#f1f1f1';
				} else {
					$track_color = cloudfw_value_color( $track_color );
				}

				$out .= "<div ". 
					cloudfw_make_class($classes, true) .
					cloudfw_make_attribute( $attributes, FALSE ) .
					cloudfw_make_style_attribute( array( 
						'margin-top'    => $margin_top,
						'margin-bottom' => $margin_bottom,
						'width'			=> $size,
						'height'		=> $size,
						'line-height'	=> $size,
					), FALSE, TRUE ) . 
					cloudfw_make_data_attribute( array(
						'percent'        => (int) 0,
						'width'          => (int) $size,
						'rotate'         => (int) $rotate,
						'percent-update' => (int) $percent,
						'line-width'     => (int) $bar_width,
						'bar-color'      => $bar_color,
						'track-color'    => $track_color,
					), FALSE )
				.">";

					$out .= '<div class="ui--center-vertical">'. $percent_html .'</div>';

				$out .= "</div>";

				if ( !empty( $label ) ) {
					$label = do_shortcode( $label ); 
					$out .= '<div class="ui--progress-circle-label">'. $label .'</div>';
				}

			$out .= "</div>";

			return $out; 

		}

		/** Scheme */
		function scheme() {
			return array(
				'title'		=>	__('Circle Progress Bar','cloudfw'),
				'script'	=> array(
					'shortcode'  => 'toggle',
					'tag_close'  => true,
					'attributes' =>	array( 
						'percent' 		=> array( 'e' => 'progress_circle_percent' ),
						'size' 			=> array( 'e' => 'progress_circle_size' ),
						'rotate' 		=> array( 'e' => 'progress_circle_rotate' ),
						'bar_width' 	=> array( 'e' => 'progress_circle_bar_width' ),
						'bar_color' 	=> array( 'e' => 'progress_circle_bar_color' ),
						'track_color' 	=> array( 'e' => 'progress_circle_track_color' ),
						'content' 		=> array( 'e' => 'progress_circle_content' ),
						'label' 		=> array( 'e' => 'progress_circle_label' ),
						'margin_top'    => array( 'e' => 'margin_top' ),
						'margin_bottom' => array( 'e' => 'margin_bottom' ),
					)
				),
				'data'		=>  $this->load_scheme( __FILE__ )

			);

		}

	}

}