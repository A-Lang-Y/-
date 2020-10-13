<?php
/*
 * Plugin Name: Pricing Table
 * Plugin URI: http://cloudfw.net
 * Description: 
 * Version: 1.0
 * Author: Orkun Gürsel
 * Author URI: http://orkungursel.com
 * Shortcode:  
 * Attributes:
 */

cloudfw_register_shortcode( 'CloudFw_Shortcode_Price_Table' );
if ( ! class_exists('CloudFw_Shortcode_Price_Table') ) {
	class CloudFw_Shortcode_Price_Table extends CloudFw_Shortcodes {

		function get_called_class(){ return get_class($this); }

		var $parent	= 0;
		var $child	= 0;
		var $total	= 0;
		var $atts	= array();
		var $header	= '';
		var $footer	= '';
		var $content= '';
		var $features= '';


		/** Add */
		function add() {
			return array(
				'price_table' 			=> array( &$this, 'register_price_table' ),
				'price_table_column' 	=> array( &$this, 'register_price_table_column' ),
				'price_table_feature' 	=> array( &$this, 'register_price_table_feature' ),
			);
		}


		/*
		 *	Shortcode: 	 [price_table]
		 */
		function register_price_table($atts, $content =  NULL, $case = NULL){
			$this->atts = shortcode_atts(array(
				"style" 			=> NULL,
				'titles'  			=> array(),
				"height" 			=> NULL,
				'feature_align'		=> '',
				'shadow'			=> '',
				'margin_top'     	=> '',
				'margin_bottom'  	=> '',
			), _check_onoff_false($atts)); 

			if ( !empty($this->atts['titles']) ) {
				$this->atts['titles'] = cloudfw_unserialize( htmlspecialchars_decode($this->atts['titles']) );
			}

			extract($this->atts);

			$this->parent++;
			$this->child = 0;
			$this->total = 0;
			$this->header = '';
			$this->footer = '';
			$this->contents = '';
			$this->features = '';
			$this->total = count(explode("[price_table_column",$content)) - 1;
			
			do_shortcode( $content );

			$unique_id = 'price_table_'.$this->parent;

			$classes   = array();
			$classes[] = 'ui--pricing-table';
			$classes[] = 'unstyled';
			$classes[] = 'clearfix';
			$classes[] = 'columns-' . $this->total;

			$this->header  = '<div class="ui--pricing-table-wrap clearfix '. $style .'">';
			$this->header .= '<ul'. 
				cloudfw_make_id($unique_id, false).
				cloudfw_make_class($classes, 1).
				cloudfw_make_style_attribute( array( 
					'margin-top'    => $margin_top,
					'margin-bottom' => $margin_bottom,
				), FALSE, TRUE ).
			'>';
			$this->footer .= '</ul>';
			$this->footer .= '</div>';

			return 	$this->header. 
				 	$this->contents. 
				 	$this->footer;
		}

		/*
		 *	Shortcode: 	 [price_table_column]
		 */
		function register_price_table_column($atts, $content =  NULL){
			$this->atts_column = shortcode_atts(array(
				'title'				=> '',
				'title_size'		=> '',
				'value'				=> '',
				'value_size'		=> '',
				'caption'			=> '',
				'featured'			=> '',
				'icon'				=> '',
				'link'				=> '',
				'target'			=> '',
				'height'			=> '',
				'html_after'		=> '',
				'custom_effect'		=> '',
			), _check_onoff_false($atts, true));

			$this->child++;
			$this->feature_row_number = 0;
			$this->even = false;
			extract($this->atts);
			extract($this->atts_column);

			$height = $this->atts_column['height'] ? $this->atts_column['height'] : $this->atts['height'];

			$this->features = '';
			do_shortcode( $content );
	

			$output  = '';
			$output .= '<li class="ui--pricing-table-column ui--animation'. 
							_if( $featured, ' featured' ). 
					    '"><div class="ui--shadow-top inset ui--box"'. 
						cloudfw_style_tag( array(
							array( 'attribute' =>  'height', 'value' => _if( $height > 0, $height, NULL ), 'important' => true )
						)
				 	) . '>';

				if ( $title )
					$title = do_shortcode( $title ); 
					$output .= "<div class=\"ui--pricing-table-item-title-wrap ui--gradient ". _if( $featured, 'ui--accent-gradient ui--accent-color', 'ui--gradient-grey' ) ."\">
						<h1 class=\"ui--pricing-table-item-title ". _if( $featured, 'ui--accent-color-forced' ) ."\"". 
					_if( $title_size && $title_size > 9, cloudfw_style_tag( array(
							array( 'attribute' =>  'font-size', 'value' => $title_size, 'important' => true )
						)
				 	) ).">{$title}</h1></div>";

				
				$output .= "<div class=\"ui--pricing-table-before-html clearfix\">";

				if ( $value )
					$output .= "<h2 class=\"ui--pricing-table-item-price\"". 
					_if( $value_size && $value_size > 9, cloudfw_style_tag( array(
							array( 'attribute' =>  'font-size', 'value' => $value_size, 'important' => true )
						)
				 	) ).">{$value}</h2>";

				if ( $caption )
					$output .= "<div class=\"caption\">". cloudfw_inline_format($caption) ."</div>";

				$output .= "</div>";
				
				if ( $this->features ) {				
					$output .= '<div class="ui--pricing-table-features-rows ui--pricing-table-features text-'. _if( $feature_align, $feature_align, 'left' ) .'">';
						$output .= $this->features;

						if ( $style == 'style2' && $this->child === 1 ) {

							if ( is_array($this->atts['titles']) && !empty($this->atts['titles']) ) {

								$output .= '<div class="ui--pricing-table-features-titles ui--pricing-table-features text-left">';
									foreach ($this->atts['titles'] as $key => $row_title) {
										$output .= '<div class="ui--animation ui--pricing-table-feature ui--pricing-table-feature-row-'. $key .' '. _if( $key % 2 == 0, 'odd', 'even' ) .'"  data-fx="fx--caption-left" data-group="ui--pricing-table-feature-row-'. $this->feature_row_number .'">'. $row_title .'</div>';
									}
								$output .= '</div>';

							}
						}

					$output .= '</div>';
				}

			if ( isset($html_after) && $html_after )
				 $output .= '<div class="ui--pricing-table-after-html">'. cloudfw_inline_format( do_shortcode( $html_after ) ) .'</div>';

			$output .= '</div>';

			$output .= cloudfw_UI_shadow( $shadow );

			$output .= '</li>';

			$this->contents .= $output;

		}

		/*
		 *	Shortcode: 	 [price_table_feature]
		 */
		function register_price_table_feature($atts, $content =  NULL){

			//if ( $content ) {

				if ( $atts ) {
					extract($atts);
				}
				
				extract($this->atts);
				extract($this->atts_column);

				if ( $this->even == true ) {
					$class = 'even';
					$this->even = false;
				} else {
					$class = 'odd';
					$this->even = true;
				}

				$output  = '';
				$output .= '<div class="ui--pricing-table-feature ui--pricing-table-feature-row-'. $this->feature_row_number .' '. $class .' ui--animation" data-group="ui--pricing-table-feature-row-'. $this->feature_row_number .'"'.
					cloudfw_make_attribute( array(
						'data-fx' => $custom_effect, 
					), FALSE) .
				'>';

						if ( $style == 'style2' && isset($this->atts['titles'][ $this->feature_row_number ]) ) {
							
							$output .= '<div class="ui--pricing-table-feature-title-phone '. cloudfw_visible( 'phones' ) .'"><strong>';
								$output .= $this->atts['titles'][ $this->feature_row_number ];
							$output .= ':</strong></div>';

						}

						$output .= do_shortcode($content);
				$output .= '</div>';

				$this->features .= $output;
				$this->feature_row_number++;

			//}

		}

	}

}