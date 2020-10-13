<?php
/*

# CloudFW Register Functions
# Author: Orkun Gürsel - contact@orkungursel.com - support@cloudfw.net

*/

function cloudfw_get_form_vars($id, $vars = array()){
	foreach((array)$vars as $var){
		$out[] = $id.'_'.$var;
	}
	return $out;
};



function cloudfw_PV($data = array()) {
	$out = cloudfw_PV_foreach($data);
	return $out;
}


function cloudfw_PV_foreach($skin = array()) {

	if (is_array($skin)){
			
		foreach ((array)$skin as $element => $attributes) {
			
			if (is_array($attributes)){
				
				foreach ($attributes as $attribute => $value) {
					
					$var = cloudfw_PV_make_attribute($element,$attribute,$value);
				
					if ( $var === '0' )
						$out_attr[$attribute] = '0';
					elseif ( !empty($var) ) 
						$out_attr[$attribute] = $var;
					
				}
					
			}
			
			if ($out_attr) 
				$out[$element] = $out_attr;

			$out_attr = NULL;
		
		}
		
	}

	if ($out) return $out; else return false;
	
}

function cloudfw_PV_make_attribute( $element = NULL, $attribute = NULL, $value = NULL ) {

	$keys = @key($value);
	$out = array(); 
	
	if (is_array($value) && $keys=="pattern_" ) {
			
		$form = isset($value["pattern_"]) ? $value["pattern_"] : NULL;
		unset($value["pattern_"]);
					
			foreach($value as $number => $sub_value) {
				$sanitized_key = cloudfw_sanitize($element,$attribute.'_'.$number);
				$var = isset($_POST[ $sanitized_key ]) ? $_POST[ $sanitized_key ] : NULL;

				if ( isset($var) && !is_array($var) ) {
					$var = stripslashes($var);
				}

				if ( !empty($var) ) {
					$out[ $number ] = $var;
				} 

			}
						
		return $out; 
						
	} elseif ( $attribute == "gradient" ) {

		$sanitized = cloudfw_sanitize( $element, $attribute . ' 0' ); 
		$var = isset($_POST[$sanitized]) ? $_POST[$sanitized] : NULL;

		$var = stripslashes( $var );
		if ( isset( $var ) ) {
			$out[0] = $var;
		}

		$sanitized = cloudfw_sanitize( $element, $attribute . ' 1' ); 
		$var = isset($_POST[$sanitized]) ? $_POST[$sanitized] : NULL;

		$var = stripslashes( $var );
		
		if ( isset($var) ) {
			$out[1] = $var;
		}

		return $out; 
						
	} else {
		
		switch ($attribute) {
			case 'ID':
				return false;
			break;
			default:
				$sanitized = cloudfw_sanitize($element,$attribute); 
				$var = isset($_POST[ $sanitized ]) ? $_POST[ $sanitized ] : NULL;
				$is_defined = isset($_POST[ 'is_defined_'. $sanitized ]) ? $_POST[ 'is_defined_'. $sanitized ] : NULL;

				if ( $is_defined == 'onoff' && empty( $var ) )
					$var = 'FALSE';

				if ( ! is_array( $var ) ) {
					$var = stripslashes($var);
				}

				if ( isset($var) ) {
					$out = $var;
				}
				
			break;	
		}
	
		return $out; 
	
	}
	
}