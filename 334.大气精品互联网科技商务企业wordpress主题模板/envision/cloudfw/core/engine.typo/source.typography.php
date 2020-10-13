<?php
 function cloudfw_run_typo_modules() { 
 	cloudfw_render_page( 
 		cloudfw_get_schemes('font_map', true, cloudfw_get_font_data()),
 		isset($GLOBALS["args"]) ? $GLOBALS["args"] : NULL
 	); 
}

function cloudfw_font_sizes() { 
	$out = array();
	//$out['NULL'] = __('Default','cloudfw');
	$out['NULL'] = '-';

	for ( $i=9; $i <= 96 ; $i++ ) { 
		$out[ ''.$i.'' ] = $i . 'px';
	}

	return $out;
}

function cloudfw_font_line_heights() { 
	$out = array();
	$out['NULL'] = '-';

	for ( $i=9; $i <= 120 ; $i++ ) { 
		$out[ ''.$i.'' ] = $i . 'px';
	}

	return $out;
}

function cloudfw_font_weights() { 
	$out = array();
	//$out['NULL'] = __('Default','cloudfw');
	$out['NULL'] = '-';

	$out['100'] = '100';
	$out['200'] = '200';
	$out['300'] = '300';
	$out['400'] = __('Normal','cloudfw');
	$out['500'] = '500';
	$out['600'] = __('Bold','cloudfw');
	$out['700'] = '700';
	$out['900'] = '900';

	return $out;
}

function cloudfw_font_letter_spacing() { 
	$out = array();
	//$out['NULL'] = __('Default','cloudfw');
	$out['NULL'] = '-';

	$out['-2px']   = '-2px';
	$out['-1.5px'] = '-1.5px';
	$out['-1px']   = '-1px';
	$out['-0.5px'] = '-0.5px';
	$out['0px']    = '0px';
	$out['0.5px']  = '0.5px';
	$out['1px']    = '1px';
	$out['1.5px']  = '1.5px';
	$out['2px']    = '2px';

	return $out;
}

function cloudfw_grouped_font_list_cached() { 
 	static $font_list;
	
	if (!empty($font_list))
		return $font_list;
	
	$font_list = cloudfw_grouped_font_list();
	return $font_list;
}


/**
 *	Grouped Font Array
 *
 *	@since 1.0
 */
function cloudfw_grouped_font_list(){
	global $_opt, $cloudfw_default_fonts;
	
	$fonts = cloudfw_get_fonts();
	$custom_fonts = cloudfw_fontface_get_fonts();
	$google_fonts = cloudfw_webfonts_get_fonts();
	$service_fonts = cloudfw_servicefonts_get_fonts();
	
	$array_fonts['NULL'] = __("Default",'cloudfw');

	if (is_array($fonts)){
	
		foreach ($fonts as $font_id) {

			 if (cloudfw_get_font_type($font_id) == "custom") {
				$custom_array_fonts[ $custom_fonts[$font_id]["name"] ] = $custom_fonts[$font_id]["name"];
			} elseif (cloudfw_get_font_type($font_id) == "google") {
				$google_array_fonts[ $google_fonts[$font_id]["family"] ] = $google_fonts[$font_id]["name"];
			} elseif (cloudfw_get_font_type($font_id) == "service") {
				$service_array_fonts[ $service_fonts[$font_id]["family"] ] = $service_fonts[$font_id]["name"];
			}
					
		}

	} else {
		return false;
	}	
	
	foreach((array)$cloudfw_default_fonts as $font_id => $font_det) {
		$default_array_fonts[ $font_id ] = $font_det["name"];
	}

	if (isset($default_array_fonts) && $default_array_fonts)
		$array_fonts[ __("System Fonts",'cloudfw') ] = $default_array_fonts;

	if (isset($custom_array_fonts) && $custom_array_fonts)
		$array_fonts[ __("Installed Fonts",'cloudfw') ] = $custom_array_fonts;

	if (isset($google_array_fonts) && $google_array_fonts)
		$array_fonts[ __("Installed Google Web Fonts",'cloudfw') ] = $google_array_fonts;

	if (isset($service_array_fonts) && $service_array_fonts)
		$array_fonts[ __("Service Fonts",'cloudfw') ] = $service_array_fonts;
	
	return $array_fonts;
}


function cloudfw_admin_get_custom_fonts_array() {
	$fonts = cloudfw_fontface_get_fonts(); 

	if ( is_array($fonts) ) {
		@asort($fonts);
	}

	$custom_fonts_array = array();

	$i = 0;
	foreach ((array)$fonts as $font_id => $font) {
		
		$custom_fonts_array[] =  array(
			"item_value"	=> $font_id,
			"item_class"	=> "",
			"item_html" 	=> '<span id="fontface-custom-preview-'. $i .'" class="skin-name no-bold fontface-preview">'.$font["name"].'</span>',
			"item_before" 	=> '<span class="edit_remove_skin_container">',
			"item_after"	=> '
				<span class="edit_remove_skin">
					<a class="duplicate copyFontNameZclip cloudfw-tooltip" data-font-name="'. esc_attr( $font["name"] ) .'" title="'.__('Copy Font Name','cloudfw').'" href="javascript:void(0);"><span>'.__('Copy Font Name','cloudfw').'</span></a></span>
				</span>'
		);

		$i++;
						
	}
	
	return $custom_fonts_array;
	
}

function cloudfw_admin_get_google_fonts_array() {
	$fonts = cloudfw_webfonts_get_fonts();

	if ( is_array($fonts) )
		@asort($fonts);

	$i = 0;
	foreach ((array)$fonts as $font_id => $font) {
		if ( empty($font["family"]) )
			continue;

		$name = ''; 
		if( $font["name"] )
			$name = $font["name"];
		else 
			$name = cloudfw_webfonts_parse_fontfamily( $font["family"] );

		$google_fonts_array[] =  array(
			"item_value"	=> $font_id,
			"item_class"	=> "",
			"item_html" 	=> '<span id="fontface-webfont-preview-'. $i .'" class="skin-name no-bold fontface-preview">'.$name.'</span>',
			"item_before" 	=> '<span class="edit_remove_skin_container">',
			"item_after"	=> '
				<span class="edit_remove_skin">
					<a class="duplicate copyFontNameZclip cloudfw-tooltip" data-font-name="'. esc_attr( $font["family"] ) .'" title="'.__('Copy Font Name','cloudfw').'" href="javascript:void(0);"><span>'.__('Copy Font Name','cloudfw').'</span></a></span>
				</span>'
		);
		$i++;
						
	}
	
	return $google_fonts_array;
	
}

/**
 *	CloudFw Cufon - Admin Array
 *
 *	@since 1.0
 */
function cloudfw_admin_get_cufon_array() {

	$cufons = cloudfw_cufon_get_fonts();
	asort($cufons);
	$i = 1;

	foreach ((array)$cufons as $font_id => $font) {
			
		$cufons_array[] =  array(
			"item_value"	=> $font,
			"item_class"	=> "",
			"item_html" 	=> '<span id="cufon-preview-'.$i.'" class="skin-name cufon-preview">'.$font_id.'</span>',
			"item_before" 	=> '<span class="edit_remove_skin_container">',
			"item_after"	=> '
				<span class="edit_remove_skin">
					<a class="duplicate copyFontNameZclip cloudfw-tooltip" data-font-name="'. esc_attr( $font_id ) .'" title="'.__('Copy Font Name','cloudfw').'" href="javascript:void(0);"><span>'.__('Copy Font Name','cloudfw').'</span></a></span>
				</span>'
		);

		$i++;
	}
	
	return $cufons_array;	
}

/**
 *	CloudFw Cufon - Admin Array for Installed Fonts
 *
 *	@since 1.0
 */
function cloudfw_admin_get_installed_cufon_array( $preoption = false ) {

	$installed_cufons = cloudfw_cufon_get_installed_fonts();

	if ( $preoption )
		$cufons_array['NULL'] = '(Primary Font Type)';
	else
		$cufons_array['NULL'] = '';

	foreach ( $installed_cufons as $id => $font_file )
		if ( file_exists( cloudfw_cufon_path( $font_file ) ) )
			$cufons_array[ $font_file ] = cloudfw_cufon_get_fontfamily( cloudfw_cufon_path( $font_file ) );
	
	return $cufons_array;	
}

/**
 *	CloudFw Webfonts - Get all fonts via Google API
 *
 *	@since 1.0
 */
function cloudfw_admin_get_google_font_list() {
	$font_array = array();
 
   $font_array = get_transient(PFIX . '_google_webfonts');
    if ( $font_array !== false )
        return $font_array;


	$font_array['NULL'] = '';
	$need_defaults = true;
	//$request = wp_remote_get('https://www.googleapis.com/webfonts/v1/webfonts?key=AIzaSyDDtCeYSUSlm1vCe1PrBMui-arTJZ22PHU', array( 'sslverify' => false ));

	/*
	if ( !is_wp_error($request)) {

		$json = $request['body']; 
		$decode = json_decode($json, true);

		if ( is_array($decode['items']) && count($decode['items']) > 0 ){

			foreach ($decode['items'] as $key => $value) {

				$item_family= $decode['items'][$key]['family'];
				$item_family_trunc =  str_replace(' ','+',$item_family);
				$item_variants= $decode['items'][$key]['variants'];
				$item_subsets= $decode['items'][$key]['subsets'];

				$item_id  = '';
				$item_id .= $item_family_trunc;

				if ( !empty($item_variants) && is_array($item_variants) ) {
					$item_id .= ':' . implode(',', $item_variants);
				}

				if ( !empty($item_subsets) && is_array($item_subsets) ) {
					$item_id .= ':' . implode(',', $item_subsets);
				}
				 
				$font_array[$item_id] = $item_family;
				set_transient(PFIX . '_google_webfonts', $font_array, 86400 );
				$need_defaults = false;
			}

		}

	} */


	if ( $need_defaults ) {
		if ( file_exists(TMP_LOADERS . '/theme.webfonts.php') ) {
			include( TMP_LOADERS . '/theme.webfonts.php' );
		}
	}

	return $font_array;

}