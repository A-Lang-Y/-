<?php

/**
 *  CloudFw Font Engine
 *
 *  @since 1.0
 */
function cloudfw_font_engine() {
	echo cloudfw_font_engine_render();
}

/**
 *  CloudFw Render Font Script 
 *
 *  @since 1.0
 */
function cloudfw_font_engine_render(){

	$out = ''; 
	$fontface = cloudfw_fontface_render();
	$cufon    = cloudfw_cufon_render_codes();
	$cufon_mobile  = _check_onoff( cloudfw_get_option('cufon', 'enable_mobile') );

	if ( !empty( $cufon ) || !empty( $fontface ) ):
		$out = "\n<!-- Load Fonts -->\n<script type=\"text/javascript\">\n// <![CDATA[\n";
			$out .= $fontface;
			if ( ! $cufon_mobile )
				$out .= "\nif( detectDeviceViaPageWidth() != 'phone' ) {\n  ";
			$out .= $cufon;
			if ( ! $cufon_mobile )
				$out .= "\n}";

		$out .= "// ]]>\n</script>\n";
	endif;

	$service_fonts = cloudfw_servicefonts_get_fonts();
	if ( is_array($service_fonts) && !empty($service_fonts) ) {
		foreach ($service_fonts as $font_id => $font) {
			if ( isset($font[ 'embed' ]) && $font[ 'embed' ] )
				$out .= $font[ 'embed' ];
		}
	}

	return $out;
}

/**
 *  CloudFw Get Font Data
 *
 *  @since 1.0
 */
function cloudfw_get_font_data( $force = FALSE ) {
	static $font_data;
	
	if (empty($font_data) || $force) {
		$font_data = cloudfw_prepare_skin_data( cloudfw_get_content_maps("font_map"), get_option(PFIX.'_font_engine') );
	}

	return $font_data;
}

/**
 *  CloudFw Get Installed Fonts
 *
 *  @since 1.0
 */
function cloudfw_get_fonts( $force = FALSE ) {
	static $fonts;
	if ( empty($fonts) || $force ):
		$fonts = (array) get_option(PFIX.'_fonts');

		$google_web_fonts = cloudfw_webfonts_get_fonts();
		if ( isset($google_web_fonts) && is_array($google_web_fonts) )
			foreach ($google_web_fonts as $font_key => $font)
				$fonts[] = $font_key;

		$service_fonts = cloudfw_servicefonts_get_fonts();
		if ( isset($service_fonts) && is_array($service_fonts) )
			foreach ($service_fonts as $font_key => $font)
				$fonts[] = $font_key;


		$fonts = array_filter((array)$fonts); 

	endif;
	return $fonts;
}

/**
 *  CloudFw Font Face 
 *
 *  @since 1.0
 */
function cloudfw_fontface_render() {
	global $_opt;
	
	$render = false;

	/** Get font lists */
	$fonts = cloudfw_get_fonts();

	$custom_fonts = array(); 
	if ( _check_onoff( cloudfw_get_option('webfonts', 'enable') ) )
		$custom_fonts = cloudfw_fontface_get_fonts();

	$google_fonts = cloudfw_webfonts_get_fonts();

	/** Create variable for the fonts to load */
	$load_google_fonts  = $load_custom_fonts = '';
	$out_google_fonts   = $out_custom_fonts = '';
	
	if (is_array($fonts)){
	
		foreach ($fonts as $font_id) {
			if ( isset($google_fonts[$font_id]) ) {
				//Google Font    
				$load_google_fonts[] = $font_id;
			} elseif (isset($custom_fonts[$font_id])) {
				//Custom Font    
				$load_custom_fonts[] = $font_id;
			}
			
		} // foreach: fonts
		
	} else 
		return false;


	if ( is_array($load_google_fonts) ) {
		
		$out_google_font_names = ''; 
		foreach ($load_google_fonts as $load_google_fonts => $g_font)
			$out_google_font_names .= '"'.$g_font.'",';     
		
		$out_google_fonts  = "\t";
		$out_google_fonts .= 'google: {';
		$out_google_fonts .= 'families: [ '.substr($out_google_font_names,0,-1) .' ]';
		$out_google_fonts .= '},';
		$out_google_fonts .= "\n";

		$render = true;
	}


	if (is_array($load_custom_fonts)) {

		$out_custom_font_families = $out_custom_font_csses = '';
		foreach ( $load_custom_fonts as $load_custom_fonts => $c_font ) {

			$out_custom_font_families .= '"'.$custom_fonts[$c_font]["name"].'",';
			$out_custom_font_csses .= '"'.$custom_fonts[$c_font]["uri"].'",';
			
		}
			
		$out_custom_fonts  = "\t";
		$out_custom_fonts .= 'custom: {';
		$out_custom_fonts .= 'families: [ '.substr($out_custom_font_families,0,-1) .' ],';
		$out_custom_fonts .= 'urls: [ '.substr($out_custom_font_csses,0,-1) .' ]';
		$out_custom_fonts .= '},';
		$out_custom_fonts .= "\n";

		$render = true;
	}
	
	if ( $render ) {
		
		$out = '
if ( typeof WebFont == "object" && typeof WebFont.load == "function" ) {
	WebFont.load({
	  '. $out_custom_fonts . $out_google_fonts .'
		fontinactive: function(fontFamily, fontDescription) {
			//alert("Font Cannot Loaded: "+ fontFamily);
		}
	});
}
';

		return $out;
	}

}


/**
 *  Detect Font Type
 *
 *  @since 1.0
 */
function cloudfw_get_font_type( $id ){

	//Service Font   
	$service_fonts = cloudfw_servicefonts_get_fonts();
	if ( isset( $service_fonts[$id] ) )
		return 'service';

	//Google Font    
	$google_fonts = cloudfw_webfonts_get_fonts();
	if ( isset( $google_fonts[$id] ) )
		return 'google';
	
	//Custom Font    
	$custom_fonts = cloudfw_fontface_get_fonts();
	if (isset($custom_fonts[$id]) )
		return 'custom';
	
	//Default Font   
	global $cloudfw_default_fonts;
	if (in_array($id, $cloudfw_default_fonts) )
		return 'default';

	return NULL;
		
}

/**
 *  Register Font
 *
 *  @since 1.0
 */
function cloudfw_register_font($type = 'custom', $id = NULL, $name = NULL, $css = NULL) {
	
	if ($type == 'webfont') {
		global $cloudfw_webfonts;

		(array) $cloudfw_webfonts[$id] = array('name' => $name, 'family' => cloudfw_webfonts_parse_fontfamily($id));
		
	} elseif ($type == 'default') { 
		global $cloudfw_default_fonts;
		
		(array) $cloudfw_default_fonts[$id] = array('name' => $name);
	
	}
	
}

/**
 *  CloudFw Get Fontface
 *
 *  @since 3.0
 */
function cloudfw_fontface_get_fonts( $force = FALSE ){
	global $cloudfw_fontface;

	if ( !isset( $cloudfw_fontface ) || $force )
	{
		if ( ! _check_onoff( cloudfw_get_option('webfonts', 'enable') ) )
			return $cloudfw_fontface = array();

		$fonts = array();
		$dirs = array_filter((array)glob(FONTS_DIR_PATH.'*'), 'is_dir');
		
		foreach((array) $dirs as $dir){
			$stylesheet = $dir.'/stylesheet.css';
			if(file_exists($stylesheet)){
				$file_content = cloudfw_get_file_contents($stylesheet);
				if( preg_match_all("/@font-face\s*{.*?font-family\s*:\s*('|\")(.*?)\\1.*?}/is", $file_content, $matchs) ){
					foreach($matchs[0] as $index => $css){
						$font_folder = basename($dir);
						$cloudfw_fontface[$font_folder.'-'.$matchs[2][$index]] = array(
							'folder' => $font_folder,
							'name'   => $matchs[2][$index],
							'uri'    => cloudfw_fontface_uri($font_folder, 'stylesheet.css'),
							//'css'    => $css,
						);
					}
					
				}

			}

		}

	}

	return $cloudfw_fontface;
}

/**
 *  CloudFw Fontface - URI
 *
 *  @since 3.0
 */
function cloudfw_fontface_uri( $folder, $font ){
	if ( empty( $font ) || empty( $folder ) )
		return false;

	$folder = rawurlencode($folder);
	$folder = str_replace('%2F', '/', $folder); 

	return trailingslashit(trailingslashit( FONTS_DIR ) . $folder) . $font;
}

/**
 *  CloudFw Get Google Web Fonts
 *
 *  @since 3.0
 */
function cloudfw_webfonts_get_fonts( $force = false ){
	//if ( ! _check_onoff( cloudfw_get_option('webfonts', 'enable') ) )
	//  return array();

	global $cloudfw_webfonts_cache;

	if ( !isset( $cloudfw_webfonts_cache ) || $force )
	{
		global $cloudfw_webfonts;

		$fonts = cloudfw_get_option('webfonts');
		$indicator = $fonts['indicator'];

		$cloudfw_webfonts_cache = $cloudfw_webfonts; 

		if ( is_array($indicator) && count($indicator) > 0 ) {
			foreach ($indicator as $key => $dummy) {
				$font_id = $fonts['fontfamily'][$key] ? $fonts['fontfamily'][$key] : $fonts['custom_fontfamily'][$key];

				if ( empty($font_id) )
					continue;

				$cloudfw_webfonts_cache[ $font_id ] = array(
					'family'    => cloudfw_webfonts_parse_fontfamily($font_id),
					'name'      => $fonts['fontname'][$key] ? $fonts['fontname'][$key] : cloudfw_webfonts_parse_fontfamily($font_id),
				);


			}
		}

	}

	return $cloudfw_webfonts_cache;
}

/**
 *  CloudFw Get Service Fonts
 *
 *  @since 3.0
 */
function cloudfw_servicefonts_get_fonts( $force = false ){
	global $cloudfw_servicefonts_cache;

	if ( !isset( $cloudfw_servicefonts_cache ) || $force )
	{

		$fonts = cloudfw_get_option('servicefonts');
		$indicator = $fonts['indicator'];

		if ( is_array($indicator) && count($indicator) > 0 ) {
			foreach ($indicator as $key => $dummy) {
				$font_id = isset($fonts['fontfamily'][$key]) ? $fonts['fontfamily'][$key] : NULL;

				if ( empty($font_id) )
					continue;

				$cloudfw_servicefonts_cache[ $font_id ] = array(
					'family'    => $font_id,
					'name'      => $fonts['fontname'][$key] ? $fonts['fontname'][$key] : $font_id,
					'embed'     => isset($fonts['embed_code'][$key]) ? $fonts['embed_code'][$key] : NULL
				);


			}
		}

	}

	return (array)$cloudfw_servicefonts_cache;
}

/**
 *  CloudFw Parse Font Family for CSS
 *
 *  @since 3.0
 */
function cloudfw_webfonts_parse_fontfamily( $font ){
	if ( !$font )
		return '';

	$exploded_font = explode(':', $font);
	$fontfamily = str_replace('+', ' ', $exploded_font[0]);
	return $fontfamily;
}

/**
 *  CloudFw Cufon - URI
 *
 *  @since 1.0
 */
function cloudfw_cufon_uri( $font ){
	if ( empty( $font ) )
		return false;

	return trailingslashit( CUFON_DIR ) . $font;
}

/**
 *  CloudFw Cufon - Path
 *
 *  @since 1.0
 */
function cloudfw_cufon_path( $font ){
	if ( empty( $font ) )
		return false;

	return trailingslashit( CUFON_DIR_PATH ) . $font;
}

/**
 *  CloudFw Cufon - Get Fonts
 *
 *  @since 1.0
 */
if ( !function_exists("cloudfw_cufon_get_fonts")){

	function cloudfw_cufon_get_fonts( $force = FALSE ){
		static $cloudfw_cufon;

		if ( !isset( $cloudfw_cufon ) || $force ) {

			$cloudfw_cufon = array();
			$glob = glob( CUFON_DIR_PATH."/*.js" );
			if ( !empty($glob) && is_array($glob) ) {

				foreach( $glob as $font ){
					
					if ( $font_id = cloudfw_cufon_get_fontfamily( $font ) );
						$cloudfw_cufon[ $font_id ] = basename( $font ); 
				}

			}
			
		}

		return $cloudfw_cufon;
	}

}

/**
 *  CloudFw Cufon - Get FontFamily
 *
 *  @since 1.0
 */
function cloudfw_cufon_get_fontfamily( $font ){
	if ( !file_exists( $font ) )
		return false;

	$content = cloudfw_get_file_contents( $font );
	if( preg_match('/font-family":"(.*?)"/i', $content, $match )){
		if ( !empty( $match[1] ) )
			return $match[1]; 
	}

	return false;
}

/**
 *  CloudFw Cufon - Get Installed Fonts
 *
 *  @since 1.0
 */
function cloudfw_cufon_get_installed_fonts( $force = FALSE ) {
	static $cloudfw_installed_cufon;

	if ( empty($cloudfw_installed_cufon) || $force ):
		$cloudfw_installed_cufon = (array) cloudfw_get_option('cufon', 'fonts');
	endif;

	return $cloudfw_installed_cufon;
}


/**
 *  CloudFw @font-face - Init Admin
 *
 *  @since 1.0
 */
function cloudfw_fontface_init_admin(){
	$tab = isset($_GET['tab']) ? $_GET['tab'] : '';  
	
	if ( ! _check_onoff( cloudfw_get_option('webfonts', 'enable') ) || $tab !== 'typography' )
		return;

	wp_enqueue_script ('webfont', TMP_ADMIN.'/js/webfont.js', array( 'jquery' ), cloudfw_get_combined_version());
	cloudfw_fontface_render_on_admin();

}

/**
 *  CloudFw Font Face 
 *
 *  @since 1.0
 */
function cloudfw_fontface_render_on_admin() {
	global $_opt;
	
	$render = false;

	if ( ! _check_onoff( cloudfw_get_option('webfonts', 'enable') ) )
		return;

	/** Get font lists */
	$fonts = cloudfw_get_fonts();
	$custom_fonts = cloudfw_fontface_get_fonts();
	$google_fonts = cloudfw_webfonts_get_fonts();

	if ( isset($custom_fonts) && is_array($custom_fonts) )
		asort( $custom_fonts );

	if ( isset($google_fonts) && is_array($google_fonts) )
		asort( $google_fonts );


	$fontface_preview = '';
	$out_google_font_names = '';
	$out_google_fonts = ''; 
	if ( is_array($google_fonts) ) {
		
		$i = 0;
		foreach ($google_fonts as $google_fonts_id => $g_font){
			$out_google_font_names .= '"'.$google_fonts_id.'",';
			$parsed_fontfamily = cloudfw_webfonts_parse_fontfamily($google_fonts_id);  
			$fontface_preview .= "#fontface-webfont-preview-{$i} { font-family: '{$parsed_fontfamily}'; }\n";
			$i++;
		}

		
		$out_google_fonts  = "\t";
		$out_google_fonts .= 'google: {';
		$out_google_fonts .= 'families: [ '.substr($out_google_font_names,0,-1) .' ]';
		$out_google_fonts .= '},';
		$out_google_fonts .= "\n";

		$render = true;
	}

	$out_custom_fonts = ''; 
	if (is_array($custom_fonts)) {
		$out_custom_font_families = $out_custom_font_csses = '';

		$i = 0;
		foreach ($custom_fonts as $custom_fonts_id => $c_font) {

			$out_custom_font_families .= '"'.$c_font["name"].'",';
			$out_custom_font_csses .= '"'.$c_font["uri"].'",';
			$fontface_preview .= "#fontface-custom-preview-{$i} { font-family: '{$c_font["name"]}'; }\n";           
			$i++;
		}
			
		$out_custom_fonts  = "\t";
		$out_custom_fonts .= 'custom: {';
		$out_custom_fonts .= 'families: [ '.substr($out_custom_font_families,0,-1) .' ],';
		$out_custom_fonts .= 'urls: [ '.substr($out_custom_font_csses,0,-1) .' ]';
		$out_custom_fonts .= '},';
		$out_custom_fonts .= "\n";

		$render = true;

	}
	
	if ( $render ) {
		
		$out = '
jQuery(document).ready(function(){

	WebFont.load({
		//CFWF
	  '.$out_custom_fonts.''.$out_google_fonts.'
		fontinactive: function(fontFamily, fontDescription) {
			cloudfw_dialog( " \""+ fontFamily +"\" Font Cannot Loaded", "Please make sure all options are correct for the font.", "error" );
		}
	});

});
';

		echo "\n<!-- Load Fonts -->\n<script type=\"text/javascript\">// <![CDATA[\n";
			echo $out;
		echo "\n// ]]></script>\n";

		echo "<style type=\"text/css\">";
			echo $fontface_preview;
		echo "</style>";

		return $out;
	}

}


/**
 *  CloudFw Cufon - Init Admin
 *
 *  @since 1.0
 */
function cloudfw_cufon_init_admin(){
	$tab = isset($_GET['tab']) ? $_GET['tab'] : '';  
	
	if ( ! _check_onoff( cloudfw_get_option('cufon', 'enable') ) || $tab !== 'typography' )
		return;

	wp_enqueue_script ('cufon', TMP_URL.'/lib/js/cufon.js', array( 'jquery' ), cloudfw_get_combined_version());

	$cufons = cloudfw_cufon_get_fonts();
	$inline_script = "<script type=\"text/javascript\">\n// <![CDATA[\njQuery(document).ready(function() {\n";

	$i = 1;

	foreach ( $cufons as $font_name => $font ) {
		/** Add the Font */
		wp_enqueue_script( $font_name,  cloudfw_cufon_uri( $font ) );

		/** Preview the Font */
		$inline_script .= stripslashes("Cufon('#cufon-preview-$i', { fontFamily: '$font_name' });\n");
		$i ++;
	}
	echo $inline_script . "});\n// ]]>\n</script>";
}

/**
 *  CloudFw Cufon - Render Scripts
 *
 *  @since 1.0
 */
function cloudfw_cufon_render_scripts(){
	$installed_cufons = cloudfw_cufon_get_installed_fonts();

	foreach ( $installed_cufons as $id => $font_file )
		if ( file_exists( cloudfw_cufon_path( $font_file ) ) )
			wp_enqueue_script( 'cufon-' . $id,  cloudfw_cufon_uri( $font_file ) );

}

/**
 *  CloudFw Cufon - Render Codes
 *
 *  @since 1.0
 */
function cloudfw_cufon_render_codes(){
	$installed_cufons = cloudfw_cufon_get_installed_fonts();
	$out ='';

	$primary = cloudfw_get_option( 'cufon', 'primary' );

	if ( !in_array( $primary, $installed_cufons ) )
		$primary = false;

	if ( $primary ) {
		$current_font = cloudfw_cufon_get_fontfamily( cloudfw_cufon_path( $primary ) );
	} else {    
		if ( is_array( $installed_cufons ) )
			if ( count( $installed_cufons ) > 0 )
				$current_font = cloudfw_cufon_get_fontfamily( cloudfw_cufon_path( $installed_cufons[0] ) );
	}

	if ( isset($current_font) && $current_font )
		$out .= apply_filters( 'cloudfw_cufon_defaults', $current_font );

	if ( current_theme_supports('cufon') && cloudfw_check_onoff('cufon', 'enable') ) {
		$out .= "\n" . cloudfw_get_option( 'cufon', 'codes' );
	}

	if( ! empty( $out ) ) {
		$out = "\n" . $out ."\n";
	}

	return $out;
}


/**
 *  Adds Typo Setting
 */
function cloudfw_add_typo_setting( &$map, $id, $selector, $options = array(), $defaults = array(), $importants = array() ){
	if ( !isset($defaults) || empty($defaults) ) {
		  $defaults = array(
				'font-family'     => null,
				'font-size'       => null,
				'font-weight'     => null,
				'line-height'     => null,
				'letter-spacing'  => null,
		  );
	}

	$options = cloudfw_make_var( $defaults, $options);

	$map -> id( $id );
	$map -> selector( $selector );

	foreach ($options as $key => $value) {
		$add_important = in_array($key, (array) $importants);
		$map -> attr( $key, $value, $add_important );
	}

}