<?php
/*
 * Plugin Name: Columns
 * Plugin URI: http://cloudfw.net
 * Description:
 * Version: 1.0
 * Author: Orkun Gürsel
 * Author URI: http://orkungursel.com
 * Shortcode:
 * Attributes:
 */

if ( !function_exists('cloudfw_UI_column') ) {


	function cloudfw_UI_column_close( $_key ) {

		if ( !isset($_key) || empty($_key) )
			$_key = 'default';

		global $cloudfw_close_row;

		if ( !isset($cloudfw_close_row[ $_key ]) )
			$cloudfw_close_row[ $_key ] = 0;


		if ( $cloudfw_close_row[ $_key ] > 0 ) {
			$cloudfw_close_row[ $_key ]--;
			return "\n</div> \n";
		}


	}

	function cloudfw_UI_column( $atts = array(), $content =  NULL, $case = NULL, $force_close = false ) {
		extract(shortcode_atts(array(
			'_key'			=> 'default',
			'row_class'		=> '',
			'do_shortcode'	=> true,
			'id'			=> NULL,
			'style'			=> NULL,
			'class'			=> NULL,
			'top'			=> NULL,
			'bottom'		=> NULL,
			'text_align'	=> NULL,
			'padding'		=> NULL,
		), $atts));

		switch($case):
		 	default:
		 		return $do_shortcode ? do_shortcode($content) : $content;
			case 'full':
			case '1of1':
			case '1':
				$main_class = 'span12';
			break;
			case '1of1_last':
				$main_class = 'span12';
				$close = true;
			break;

			case '1of2':			$main_class = 'span6';					break;
			case '1of2_last': 	$main_class = 'span6';$close = true;	break;

			case '1of3':		$main_class = 'span4';					break;
			case '1of3_last':	$main_class = 'span4';$close = true;	break;
			case '2of3':			$main_class = 'span8';					break;
			case '2of3_last': 	$main_class = 'span8';$close = true;	break;

			case '1of4':		$main_class = 'span3';					break;
			case '1of4_last': 	$main_class = 'span3';$close = true;	break;
			case '2of4':			$main_class = 'span6';					break;
			case '2of4_last': 	$main_class = 'span6';$close = true;	break;
			case '3of4':		$main_class = 'span9';					break;
			case '3of4_last': 	$main_class = 'span9';$close = true;	break;


			case '1of6':		$main_class = 'span2';					break;
			case '1of6_last': 	$main_class = 'span2';$close = true;		break;
			case '2of6':			$main_class = 'span4';					break;
			case '2of6_last': 	$main_class = 'span4';$close = true;	break;
			case '3of6':		$main_class = 'span6';					break;
			case '3of6_last': 	$main_class = 'span6';$close = true;	break;
			case '4of6':		$main_class = 'span8';					break;
			case '4of6_last': 	$main_class = 'span8';$close = true;	break;
			case '5of6':		$main_class = 'span10';					break;
			case '5of6_last': 	$main_class = 'span10';$close = true;	break;

			case '1of5':
			case '1of5_last':
			case '1of7':
			case '1of7_last':
			case '1of8':
			case '1of8_last':
			case '1of9':
			case '1of9_last':
			case '1of10':
			case '1of10_last':
			case '1of11':
			case '1of11_last':
			case '1of12':
			case '1of12_last':
				$numeric_columns = str_replace( '1of', '', $case);
				$numeric_columns = str_replace( '_last', '', $numeric_columns);
				$mod = (false !== strpos( $case, '_last' ));

				return cloudfw_UI_column_fluid( $atts, $content, (int) $numeric_columns, $mod, $force_close );
			break;

		endswitch;

		// Debug:
		//$atts['case'] = $case;
		//$atts['close'] = isset($close) ? $close : NULL;
		//$atts['force_close'] = $force_close;
		//$atts['content'] = htmlentities($content);

		if (isset($id) && $id)
			$id = "id=\"$id" ;

		if ($style)
			$style = "style=\"$style";

		if ( $class ) {
			if ( is_array($class) ) {
				$main_class .= " " . implode(' ', $class);
			} else {
				$main_class .= " $class";
			}
		}

		if (isset($top) && $style)
			$style .= " padding-top: $top"."px;";
		elseif (isset($top) && !$style)
			$style = "style=\"padding-top: $top"."px;";

		if (isset($bottom) && $style)
			$style .= " margin-bottom: $bottom"."px;";
		elseif (isset($bottom) && !$style)
			$style = "style=\"margin-bottom: $bottom"."px;";

		if ($style)
			$style .= "\" ";

		if ($padding)
			$content = "<div style=\"padding: $padding;\">$content</div>";

		$content = trim($content);
		$out = '';

		if ( !isset($_key) || empty($_key) )
			$_key = 'default';

		global $cloudfw_close_row;


		if ( !isset($cloudfw_close_row[ $_key ]) ) {
			$cloudfw_close_row[ $_key ] = 0;
		}

		if ( $cloudfw_close_row[ $_key ] === 0 ) {
			$out .= '<div class="ui-row ';
			$out .= !empty($row_class) ? $row_class : cloudfw( 'row_class', $cloudfw_close_row[ $_key ] );
			$out .= '">';
			$cloudfw_close_row[ $_key ]++;
		}

		$out .= "\n <div $id $style class=\"ui-column $main_class\">$content</div> \n";

		if ((isset($close) && $close) || $force_close) {
			if ( $cloudfw_close_row[ $_key ] > 0 ) {
				$out .= "\n</div> \n";
				$cloudfw_close_row[ $_key ]--;
				//if ( $cloudfw_close_row[ $_key ] === 0 ) unset($cloudfw_close_row[ $_key ]);
			}
		}

		return $do_shortcode ? do_shortcode($out) : $out;

	}

}


	function cloudfw_UI_column_fluid( $atts = array(), $content =  NULL, $columns = NULL, $mod = false, $force_close = false ) {
		extract(shortcode_atts(array(
			'_key'			=> 'default',
			'row_class'		=> '',
			'do_shortcode'	=> true,
			'id'			=> NULL,
			'style'			=> NULL,
			'class'			=> NULL,
			'top'			=> NULL,
			'bottom'		=> NULL,
			'text_align'	=> NULL,
			'padding'		=> NULL,
		), $atts));

		$main_class = '';

		if (isset($id) && $id)
			$id = "id=\"$id" ;

		if ($style)
			$style = "style=\"$style";

		if ( $class ) {
			if ( is_array($class) )
				$main_class .= " " . implode(' ', $class);
			else
				$main_class .= " $class";
		}

		$content = trim($content);
		$out = '';

		if ( !isset($_key) || empty($_key) )
			$_key = 'default_fluid';

		global $cloudfw_close_row;

		if ( !isset($cloudfw_close_row[ $_key ]) )
			$cloudfw_close_row[ $_key ] = 0;

		if ( $cloudfw_close_row[ $_key ] === 0 ) {
			$out .= '<div class="ui-fluid-columns ui-fluid-columns-'. $columns .' ui-row ';
			$out .= !empty($row_class) ? $row_class : cloudfw( 'row_class', $cloudfw_close_row[ $_key ] );
			$out .= '">';
			$cloudfw_close_row[ $_key ]++;
		}

		$last_class = ($mod) ? ' last' : '';

		$out .= "\n <div $id $style class=\"ui-column ui-fluid-column";
		$out .= $last_class;
		$out .= $main_class;
		$out .= "\">";
			$out .= $content;
		$out .= "</div> \n";

		if ($mod || $force_close) {
			if ( $cloudfw_close_row[ $_key ] > 0 ) {
				$out .= "\n</div> \n";
				$cloudfw_close_row[ $_key ]--;
			}
		}

		return $do_shortcode ? do_shortcode($out) : $out;

	}



cloudfw_register_shortcode( 'CloudFw_Shortcode_Columns', 'columns', 'columns', 5 );
if ( ! class_exists('CloudFw_Shortcode_Columns') ) {
	class CloudFw_Shortcode_Columns extends CloudFw_Shortcodes {

		function get_called_class(){ return get_class($this); }


		/** Register */
		function register() {
			return array(
				'1of1',
				'1of2',
				'1of3',
				'1of4',
				'1of5',
				'1of6',

				'2of3',
				'3of4',
				'2of5',
				'3of5',
				'4of5',
				'5of6',

				'1of1_last',
				'1of2_last',
				'1of3_last',
				'1of4_last',
				'1of5_last',
				'1of6_last',

				'2of3_last',
				'3of4_last',
				'2of5_last',
				'3of5_last',
				'4of5_last',
				'5of6_last',

			);

		}

		/** Run */
		function shortcode( $atts = array(), $content =  NULL, $case = NULL ) {
			return cloudfw_UI_column( $atts, $content, $case );
		}

		/** Admin Scheme */
		function scheme() {
			return 	array(
				'title'		=>	__('Single Columns','cloudfw'),
				'script'	=> array(
					'shortcode:sync' => 'column_number',
					'tag_close'  => true,
					'attributes' =>	array(
						'content' 	=> array( 'e' => 'columns_content' ),
					)
				),
				'data'		=>	array(

					5 => array(
						'type'		=> 'module',
						'title'		=> __('Column','cloudfw'),
						'data'		=> array(

							## Element
							array(
								'type'		=>	'select',
								'id'		=>	'column_number',
								'value'		=>	'',
								'ui'		=>	true,
								'source'	=>	array('1of2' => '1/2', '1of2_last' => '1/2 last', '1of3' => '1/3', '1of3_last' => '1/3 last' , '1of4' => '1/4', '1of4_last' => '1/4 last', '1of5' => '1/5', '1of5_last' => '1/5 last', '1of6' => '1/6', '1of6_last' => '1/6 last' ),
							), // #### element: 0

						)

					),  // #### element: 5

					10 => array(
						'type'		=> 'module',
						'title'		=> __('Content','cloudfw'),
						'data'		=> array(

							## Element
							array(
								'type'		=>	'textarea',
								'id'		=>	'columns_content',
								'value'		=>	'',
							), // #### element: 0

						)

					),  // #### element: 10

				)

			);

		}

	}

}