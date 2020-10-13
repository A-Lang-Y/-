<?php


cloudfw_register_shortcode( 'CloudFw_Shortcode_Text_Rotator', 'text_rotator', 'style', 15 );
if ( ! class_exists('CloudFw_Shortcode_Text_Rotator') ) {
	class CloudFw_Shortcode_Text_Rotator extends CloudFw_Shortcodes {

		function get_called_class(){ return get_class($this); }

		function CloudFw_Shortcode_Text_Rotator(){
			add_action('init', array( &$this, 'register_sources' ));
		}

		function register_sources(){
			wp_register_script ('theme-text-rotator',  cloudfw_relative_path( dirname(__FILE__) ).'/source/jquery.text-rotator.js', array( 'jquery' ), cloudfw_get_combined_version(), false);
		}

		/** Shortcode */
		function shortcode( $atts, $content = NULL, $case = NULL ) {
			extract(cloudfw_make_var(array(
				'id'            => '',
				'effect'        => 'flipUp',
				'speed'         => '',
				'block'         => 'FALSE',
				'color'         => '',

				'border_color'  => '',
				'border_style'  => '',
				'border_width'  => '',
			), _check_onoff_false($atts))); 

			wp_enqueue_script('theme-text-rotator');
			
			$id = trim( $id ); 
			if ( empty( $id ) ) {
				$id = cloudfw_id( 'text-rotator' );
			}
			
			$classes = array(); 
			$classes[] = 'ui--text-rotator'; 

			if ( empty( $effect ) ) {
				$effect = 'flipUp'; 
			}

			if ( !empty( $speed ) && is_numeric( $speed ) ) {
				$speed = (int) $speed * 1000; 
			}
			
			if ( empty($border_width) ) {
				$border_style = ''; 
				$border_width = ''; 

			} else {

				if ( empty($border_width) ) {
					$border_width = 1; 
				}

				if ( empty($border_style) ) {
					$border_style = 'solid'; 
				}

			}

			$css = '';
			$css .= cloudfw_make_style( array( 
					"html #{$id}",
				), array( 
					'color'         => $color,
					'display'       => $block ? 'block' : '',
				), FALSE, FALSE 
			);

			$css .= cloudfw_make_style( array( 
					"html #{$id} .ui--text-rotator-placeholder",
					"html #{$id}.waiting-rotating",
					"html #{$id} .rotating > span",
				), array( 
					'border-bottom-style'  => $border_style,
					'border-bottom-width'  => $border_width,
					'border-bottom-color'  => $border_color,
				), FALSE, FALSE 
			);

			cloudfw_vc_set( 'css', $id, $css );
			unset( $css );

			$out  = '';
			$out .= '<span'.
				cloudfw_make_id( $id ) .
				cloudfw_make_class( $classes , TRUE ) .
				cloudfw_make_attribute( array( 
					'data-effect'   => $effect,
					'data-speed'    => $speed,
				), FALSE ) .
			'>';
				$words = explode('|', $content);
				$out .= '<span class="ui--text-rotator-placeholder">';
					$out .= isset($words[0]) ? $words[0] : '';
				$out .= '</span>';
				$out .= '<span class="ui--text-rotator-words">';
					$out .= $content;
				$out .= '</span>';
			$out .= '</span>';

			return $out;

		}

		/** Admin Scheme */
		function scheme() {
			return array(
				'title'     =>  __('Text Rotator','cloudfw'),
				'ajax'		=>	true,
				'script'    => array(
					'shortcode'         => 'text_rotator',
					'tag_close'         => true,
					'attributes'        => array(

						'effect'           => array( 'e' => 'text_rotator_effect' ),
						'speed'            => array( 'e' => 'text_rotator_speed' ),
						'color'            => array( 'e' => 'text_rotator_color' ),

						'border_color'     => array( 'e' => 'border_color' ),
						'border_style'     => array( 'e' => 'border_style' ),
						'border_width'     => array( 'e' => 'border_width' ),

						'block'            => array( 'e' => 'text_rotator_block', 'onoff' => true ),
						'content'          => array( 'e' => 'text_rotator_content' ),

					)

				),
				'data'      =>  $this->global_scheme()
			);

		}

		/**
		 *  Global Render Scheme
		 */
		function global_scheme(){
			return array(

				array(
					'type'      => 'module',
					'title'     => __('Rotating Words','cloudfw'),
					'data'      => array(

						## Element
						array(
							'type'      =>  'text',
							'id'        =>  'text_rotator_content',
							'value'     =>  $this->get_value('text_rotator_content'),
							'width'     =>  '90%',
							'_class'    =>  'bold',
							'desc'      =>  __('Separate words with <code><strong>|</strong></code> seperator. E.g: <code>Word1 | Word2 | Word3</code>','cloudfw')
				
						), // #### element: 0

					)

				),

				array(
					'type'      => 'module',
					'title'     => __('Transition Effect','cloudfw'),
					'data'      => array(

						## Element
						array(
							'type'      =>  'select',
							'id'        =>  'text_rotator_effect',
							'value'     =>  $this->get_value('text_rotator_effect'),
							'source'    =>  array(
								'NULL'      =>  __('Default','cloudfw'),
								'dissolve'   => __('Dissolve','cloudfw'),
								'fade'       => __('Fade','cloudfw'),
								'flip'       => __('Flip','cloudfw'),
								'flipUp'     => __('Flip Up','cloudfw'),
								'flipCube'   => __('Flip Cube','cloudfw'),
								'flipCubeUp' => __('Flip Cube Up','cloudfw'),
								'spin'       => __('Spin','cloudfw'),
							),
							'width'     =>  '250',
				
						), // #### element: 0

					)

				),

				array(
					'type'      => 'module',
					'title'     => __('Transition Speed','cloudfw'),
					'data'      => array(

						## Element
						array(
							'type'      =>  'slider',
							'id'        =>  'text_rotator_speed',
							'value'     =>  $this->get_value('text_rotator_speed', 5),
							'min'		=>	.5,
							'max'		=>	20,
							'step'		=>	.5,
							'unit'		=>	__('seconds','cloudfw'),
							'width'     =>  '250',
				
						), // #### element: 0

					)

				),

				array(
					'type'      => 'module',
					'title'     => __('Block Style','cloudfw'),
					'data'      => array(

						## Element
						array(
							'type'      =>  'onoff',
							'id'        =>  'text_rotator_block',
							'value'     =>  $this->get_value('text_rotator_block', 'FALSE'),
				
						), // #### element: 0

					)

				),

				array(
					'type'      => 'module',
					'title'     => __('Text Color','cloudfw'),
					'data'      => array(

						## Element
						array(
							'type'      =>  'color',
							'id'        =>  'text_rotator_color',
							'value'     =>  $this->get_value('text_rotator_color'),
							'style'		=>	'horizontal',
				
						), // #### element: 0

					)

				),

				array(
					'type'		=> 'mini-section',
					'title'		=> __('Border Bottom','cloudfw'),
					'data'		=> array(

						array(
							'type'		=>	'global-scheme',
							'scheme'	=>	'border',
							'this'		=>	$this,
							'vars'		=>	array()
						),

					)

				),				

			);

		}

	}

}