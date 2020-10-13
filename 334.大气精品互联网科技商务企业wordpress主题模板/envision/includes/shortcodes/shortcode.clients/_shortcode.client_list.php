<?php
/*
 * Plugin Name: Client List
 * Plugin URI: http://cloudfw.net
 * Description: 
 * Version: 1.0
 * Author: Orkun Gürsel
 * Author URI: http://orkungursel.com
 * Shortcode:  
 * Attributes:
 */

cloudfw_register_shortcode( 'CloudFw_Shortcode_Clients', NULL, 'advanced', 60 );
if ( ! class_exists('CloudFw_Shortcode_Clients') ) {
	class CloudFw_Shortcode_Clients extends CloudFw_Shortcodes {

		function get_called_class(){ return get_class($this); }
		
		var $parent	= 0;
		var $child	= 0;
		var $total	= 0;
		var $atts	= array();
		var $header	= '';
		var $footer	= '';
		var $content= '';

		function add() {
			return array(
				'clients_list' 	=> array( &$this, 'register_client_list' ),
				'client' 		=> array( &$this, 'register_client' ),
			);
		}

		/*
		 *	Shortcode: 	 [client_list]
		 */
		function register_client_list($atts, $content =  NULL, $case = NULL){
			$this->atts = shortcode_atts(array(
				"columns" 		 => 4,
				"shadow" 		 => 0,
				'carousel'		 => 0,
				'sorting'		 => '',

				'auto_rotate'    => 'FALSE',
				'animation_loop' => 'FALSE',
				'rotate_time'    => '',
				'margin_top'     => '',
				'margin_bottom'  => '',
			), _check_onoff_false($atts)); 

			if ( (int) $this->atts['columns'] < 1 )
				$this->atts['columns'] = 1;
			
			extract( $this->atts );

			$this->parent++;
			$this->child = 0;
			$this->header = '';
			$this->footer = '';
			$this->contents = array();
			
			do_shortcode( $content );

			$unique_id = 'clients_'.$this->parent;

			$classes   = array();
			$classes[] = 'ui--client-list';
			$classes[] = 'ui--box';
			$classes[] = 'ui-row';
			$classes[] = 'clearfix';

			if ( $carousel ) {
				$classes[] = 'ui--carousel';
				wp_enqueue_script('theme-flexslider');
			}

			
			$this->header   = '<div class="ui--client-list-wrapper ui--animation ui-row clearfix"'.
				cloudfw_make_style_attribute( array( 
					'margin-top'    => $margin_top,
					'margin-bottom' => $margin_bottom,
				), FALSE, TRUE ) .
			'>';
			$this->header  .= '<div'. 
				cloudfw_make_class($classes, 1) .
				cloudfw_json_attribute( 'data-options', array( 
					'effect'      => 'slide',
					'auto_rotate' => $auto_rotate,
					'animation_loop' => $animation_loop,
					'rotate_time' => (int) $rotate_time * 1000,
				), FALSE ) .
			'>';

			if ( $carousel ) {
				$this->header .= '<div class="slides">';
				$this->footer .= '</div>';
			}

			
			$this->footer .= '</div>';

			if ( $shadow ) {
				$this->footer .= cloudfw_UI_shadow( $shadow );
			}

			$this->footer .= '</div>';

			$contents_array = $this->contents;
			$total = count( (array) $contents_array );
			$this->contents = ''; 

			if ( is_array( $contents_array ) && ! empty( $contents_array ) ) {
				if ( $sorting == 'random' ) {
					@shuffle( $contents_array );
				}

				foreach ($contents_array as $item_number => $item_content) {
					$item_number++;
					$this->contents .= cloudfw_UI_column( array('_key' => 'client_list'), $item_content, '1of' . (int) $columns . ( $item_number % (int) $columns == 0 ? '_last' : '' ), $item_number == $total );
				}



			}

			return 	$this->header. 
				 	$this->contents. 
				 	$this->footer;
		}

		/*
		 *	Shortcode: 	 [client]
		 */
		function register_client($atts, $content =  NULL){
			extract(shortcode_atts(array(
				'img'				=> '',
				'alt'				=> '',
				'title'				=> '',
				'link'				=> '',
				'target'			=> '',
			), $atts));

			$this->child++;
			extract($this->atts);
	
			$output  = '';
			$output .= '<div class="ui--client ui--carousel-item">';
				if ( $link )
					$output .= '<a href="'. $link .'"'. _if( $target, ' target="'. $target .'"' ) .'>';
						$output .= '<img src="'. $img .'" alt="' . $alt . '" title="' . $title . '" class="ui--animation">';
				if ( $link ) 
					$output .= '</a>';

			$output .= '</div><div class="vertical-divider"></div>';


			$this->contents[] = $output;

		}

	}

}