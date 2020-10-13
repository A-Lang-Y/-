<?php


cloudfw_register_shortcode( 'CloudFw_Composer_Masonry' );
if ( ! class_exists('CloudFw_Composer_Masonry') ) {
	class CloudFw_Composer_Masonry extends CloudFw_Shortcodes {

		function get_called_class(){ return get_class($this); }

		/** Add the shortcode to the composer */
		function composer(){
			return array(
				'composer'		=> true,
				'droppable'		=> true,
				'ajax'			=> true,
				'icon'			=> 'masonry',
				'group'			=> 'composer_layouts',
				'line'			=> 41,
				'options'		=> array(
					'title'				=> __('Masonry Layout','cloudfw'),
					'column'			=> '1/1',
					'allow_columns'		=> false,
				)
			);
		}

		/** Shortcode */
		function shortcode( $atts, $content = NULL, $case = NULL ) {
			extract(cloudfw_make_var(array(
				'effect'        => 'slide',
				'auto_rotate'   => 'FALSE',
				'rotate_time'   => '',
			), _check_onoff_false($atts)));	

			wp_enqueue_script('theme-isotope');
			
			$out  = '';
			$out .= '<div class="ui--masonry ui--row '. cloudfw('row_class') .' clearfix"'.
				cloudfw_json_attribute( 'data-options', array( 

				), FALSE )
			.'>';
				$out .= $content;
			$out .= '</div>';

			return $out;

		}

		/** Admin Scheme */
		function scheme() {
			return array(
				'title'		=>	__('Masonry Layout','cloudfw'),
				'script'	=> array(
					'shortcode' 		=> '',
					'attributes' 		=> array(
						'effect'    		=> array( 'e' => 'effect' ),
						'auto_rotate'    	=> array( 'e' => 'auto_rotate' ),
						'rotate_time'    	=> array( 'e' => 'rotate_time' ),

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