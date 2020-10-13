<?php
/*
 * Plugin Name: Progress Bar
 * Plugin URI: http://cloudfw.net
 * Description: 
 * Version: 1.0
 * Author: Orkun Gürsel
 * Author URI: http://orkungursel.com
 * Shortcode:  [progress_bar]
 */
cloudfw_register_shortcode( 'CloudFw_Shortcode_Progress_Bar', 'progress_bar', 'advanced', 10 );
if ( ! class_exists('CloudFw_Shortcode_Progress_Bar') ) {
	class CloudFw_Shortcode_Progress_Bar extends CloudFw_Shortcodes {

		public $do_before = false;

		function get_called_class() { return get_class($this); }

		/** Add the shortcode to the composer */
		function composer(){
			return array(
				'composer'      => true,
				'droppable'     => false,
				'ajax'          => true,
				'icon'          => 'progress',
				'group'         => 'composer_widgets',
				'line'          => 350,
				'options'       => array(
					'title'             => __('Progress Bar','cloudfw'),
					'sync_title'        => 'progress_content',
					'column'            => '1/1',
					'allow_columns'     => true,
				)
			);
		}

		/** Run */
		function shortcode( $atts = array(), $content =  NULL ) {
			extract(shortcode_atts(array(
				'percent'        => '0',
				'value'          => '',
				'height'         => '',
				'stripe'         => 'FALSE',
				'gradient_start' => '',
				'gradient_stop'  => '',
				'margin_top'     => '',
				'margin_bottom'  => '',

			), _check_onoff_false($atts)));

			$id = cloudfw_id( 'progress-bar' );

			wp_enqueue_script( 'theme-viewport' );

			if ( (int) $percent < 0 || (int) $percent > 100 ) {
				$percent = 0;
			}

			$percent_write = isset($value) && $value ? $value : $percent . '%';

			$attributes = array();
			$classes = array();
			$classes[] = 'ui--progress'; 
			$classes[] = 'clearfix';

			$out  = '';
			$out .= "<div ". 
				cloudfw_make_id( $id ) .
				cloudfw_make_class( $classes, true ) .
				cloudfw_make_style_attribute( array( 
					'margin-top'    => $margin_top,
					'margin-bottom' => $margin_bottom,
				), FALSE, TRUE ).
				cloudfw_make_attribute( $attributes, FALSE )
			.">";
				$out .= "<div class=\"ui--progress-title\">";
					$out .= $content .  ' / ' . $percent_write;
				$out .= "</div>";

				$out .= "<div class=\"ui--progress-bar ui--box\">";
					$out .= "<div class=\"ui--progress-percent ui--gradient ui--accent-gradient\"".
						cloudfw_make_style_attribute( array( 
							'width' => $percent . '%',
							'height' => $height,
						), FALSE, TRUE ) .
						cloudfw_make_attribute( array( 
							'data-value' => $percent . '%',
						), FALSE, TRUE )
					.">";
						if ( $stripe ) {
							$out .= "<div class=\"ui--progress-stripe\">";
							$out .= "</div>";
						}
					$out .= "</div>";
				$out .= "</div>";
			$out .= "</div>";

			/** Sets custom style code if it's not blank. */
			$style = cloudfw_make_style_attribute( array( 
				'gradient' => array( $gradient_start, $gradient_stop ),
			), FALSE, FALSE );

			if ( ! empty( $style ) ) {
				$css = '#' . $id . ' .ui--gradient {';
					$css .= $style;
				$css .= '}';
				cloudfw_vc_set( 'css', $id, $css );
			}

			return $out; 

		}

		/** Scheme */
		function scheme() {
			return array(
				'title'     =>  __('Progress Bar','cloudfw'),
				'script'    => array(
					'shortcode'  => 'toggle',
					'tag_close'  => true,
					'attributes' => array( 
						'percent'       => array( 'e' => 'progress_percent', 'required' => __('Please insert a title text','cloudfw') ),
						'value'         => array( 'e' => 'progress_value' ),
						'height'        => array( 'e' => 'progress_height' ),
						'stripe'        => array( 'e' => 'progress_stripe', 'onoff' => true ),
						'gradient_start'=> array( 'e' => 'progress_gradient_0' ),
						'gradient_stop' => array( 'e' => 'progress_gradient_1' ),
						'content'       => array( 'e' => 'progress_content', 'default' => __('Progress Title','cloudfw') ),
						'margin_top'    => array( 'e' => 'margin_top' ),
						'margin_bottom' => array( 'e' => 'margin_bottom' ),
					)
				),
				'data'      =>  $this->load_scheme( __FILE__ )

			);

		}

	}

}