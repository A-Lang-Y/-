<?php

/**
 *	Makes shadow.
 *
 *	@since 1.0
 */
function cloudfw_UI_shadow( $type = NULL, $content = '', $class = '', $before = '', $after = '' ) {

	$shadows = cloudfw_admin_loop_shadows(); 
	if ( !empty( $type ) && !is_array( $type ) && isset( $shadows[ $type ] ) ) {
		$out = '';
		$out .= $before;
		$out .= $content;
		$out .= '
			<div class="ui--shadow ui--shadow-type-'. $type .' '. $class .' clearfix">
				<img src="'. cloudfw_relative_path( dirname(__FILE__) ) .'/shadows/shadow-'. $type .'.png" alt="" />
			</div>
		';
		$out .= $after;

		return $out;

	} else {
		return $content;

	}

}

/**
 *	Shadows
 *
 *	@since 1.0
 */
function cloudfw_admin_loop_shadows() { 
	$out = array();
	$out['NULL']   = __('No Shadow','cloudfw');
	$out['1']      = sprintf( __('Shadow Style %d','cloudfw'), 1 );
	$out['2']      = sprintf( __('Shadow Style %d','cloudfw'), 2 );
	$out['3']      = sprintf( __('Shadow Style %d','cloudfw'), 3 );
	$out['4']      = sprintf( __('Shadow Style %d','cloudfw'), 4 );
	$out['5']      = sprintf( __('Shadow Style %d','cloudfw'), 5 );
	$out['6']      = sprintf( __('Shadow Style %d','cloudfw'), 6 );
	$out['7']      = sprintf( __('Shadow Style %d','cloudfw'), 7 );
	$out['8']      = sprintf( __('Shadow Style %d','cloudfw'), 8 );

	return $out;
}