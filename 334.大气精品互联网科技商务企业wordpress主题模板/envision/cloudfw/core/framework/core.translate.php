<?php
/**
 *	Translate Function
 *
 *	@since 1.0
 */
function cloudfw_ml_plugin(){
	static $cloudfw_ml_plugin;

	if ( !empty( $cloudfw_ml_plugin ) )
		return $cloudfw_ml_plugin;

	if ( function_exists('icl_t') )
		$cloudfw_ml_plugin = 'wpml';
	elseif ( function_exists('qtrans_useCurrentLanguageIfNotFoundUseDefaultLanguage') )
		$cloudfw_ml_plugin = 'qtranslate';
	else
		$cloudfw_ml_plugin = 'none';

	return $cloudfw_ml_plugin;
}

/**
 *	Chech the website is multilingual?
 *
 *	@since 1.0
 */
 function cloudfw_is_multilingual(){
	/** Detect the Plugin */
	$plugin = cloudfw_ml_plugin();
	return !$plugin || $plugin == 'none' ? FALSE : TRUE; 
 }

/**
 *	Make URLs compatible /w MultiLanguage
 *
 *	@since 1.0
 */
if ( ! function_exists( '__url' ) ):
	function __url($url){
		/** Detect the Plugin */
		$plugin = cloudfw_ml_plugin();

		if ( $plugin == 'qtranslate' )
			return qtrans_convertURL($url);
		elseif ( $plugin == 'wpml' )
			return $url;
		else
			return $url;
	}
endif;

/**
 *	Translate Function
 *
 *	@ since 1.0
 */
if ( ! function_exists( '__t' ) ):
	function __t($data, $context = NULL, $name = NULL){
		/** Detect the Plugin */
		$plugin = cloudfw_ml_plugin();
		if ( $plugin == 'qtranslate' )
			return qtrans_useCurrentLanguageIfNotFoundUseDefaultLanguage($data);
		elseif ( $plugin == 'wpml' && $context && $name )
			return icl_t($context, $name, $data);
		else
			return $data;
	}
endif;

/**
 *	Make URLs compatible /w MultiLanguage
 *
 *	@since 1.0
 */
if ( ! function_exists( '__home_url' ) ):
	function __home_url($url = NULL){
		return __url(home_url($url));
	}
endif;

/**
 *	Registers strings for translate plugins.
 */
function cloudfw_translate_register( $name = NULL, $key = 'texts' ){
	if ( function_exists('icl_register_string') ) {	
		$context = $key . '_' . $name; 
		icl_register_string('cloudfw_wpml', $context, cloudfw_raw_option( $key, $name ) );

		return true;
	}

	return false;
}

/**
 *	Translate Function.
 */
function cloudfw_translate( $name = NULL, $key = 'texts' ){
	$default = cloudfw_raw_option( $key, $name );
	$option  = cloudfw_get_option( $key, $name );

	$plugin_using = false; 
	if ( function_exists('qtrans_useCurrentLanguageIfNotFoundUseDefaultLanguage') ) {
		$plugin_using = true; 
		$translated_plugin = qtrans_useCurrentLanguageIfNotFoundUseDefaultLanguage( $option );
	} elseif ( function_exists('icl_t') ) {
		$plugin_using = true; 
		$context = $key . '_' . $name; 
		$translated_plugin = icl_t( 'cloudfw_wpml', $context, $option );
	} else {
		$translated_plugin = $option;
	}

	if ( $translated_plugin == $option ) {
		$translated_mo = cloudfw_get_default( $key, $name );
		if ( $plugin_using ) {
			$return = $translated_mo == $default ? $option : $translated_mo;
		} else {
			$return = $option == $default ? $translated_mo : $option;
		}
	} else {
		$return = $translated_plugin;
	}

	return do_shortcode($return);
}

/**
 *	Home URL by Language
 *
 *	@since 1.0
 */
function cloudfw_homeurl_by_language($language = NULL){
	/** Detect the Plugin */
	$plugin = cloudfw_ml_plugin();

	if ( $plugin == 'qtranslate' ) {
		return qtrans_convertURL( home_url(), $language );
	} elseif ( $plugin == 'wpml' ){
	    global $sitepress;
	    return $sitepress->language_url($language);
	} else
		return home_url();
}

/**
 *	Get Current Language Key
 *
 *	@since 1.0
 */
if ( ! function_exists( 'cloudfw_get_current_language' ) ):
function cloudfw_get_current_language( $type = NULL ){
	/** Detect the Plugin */
	$plugin = cloudfw_ml_plugin();

	if ( $plugin == 'qtranslate' ) {
		global $q_config;
		$lang_code = $q_config["language"];

	} elseif ( $plugin == 'wpml' && defined('ICL_LANGUAGE_CODE') ){
		$lang_code = ICL_LANGUAGE_CODE;
	} else {
		$lang_code = get_bloginfo( 'language' );
	}

	if ( $type == 'standard' ) {
		$lang_code = str_replace('-', '_', $lang_code);

	} elseif ( $type == 'sort' ) {
		$lang_code = str_replace('-', '_', $lang_code);
		$lang_code_x = explode('_', $lang_code);

		if ( count($lang_code_x) > 1 )
			$lang_code = $lang_code_x[0];
	}

	return $lang_code;
}
endif;

/**
 *	Get Website Languages
 *
 *	@since 1.0
 */
if ( ! function_exists( 'cloudfw_get_languages' ) ):
function cloudfw_get_languages(){
	static $cloudfw_languages_list;

	if ( is_array( $cloudfw_languages_list ) )
		return $cloudfw_languages_list;

	/** Detect the Plugin */
	$plugin = cloudfw_ml_plugin();

    /** Get Current Language */
    $current_language = cloudfw_get_current_language();

	if ( $plugin == 'qtranslate' ) {
		global $q_config;

		$languages = $q_config['enabled_languages'];
		$language_names = $q_config['language_name'];
		$flags = $q_config['flag'];
		$flag_location = $q_config['flag_location'];
		$language_list = array();

		if( 1 < count($languages) )
			foreach( $languages as $li => $l )
				$language_list[ $l ] = array(
					'current' => $current_language == $l,
					'id' => $l,
					'name' => $language_names[ $l ],
					'native_name' => $language_names[ $l ],
					'flag' => trailingslashit(WP_CONTENT_URL) . trailingslashit($flag_location) . $flags[ $l ],
					'url' => qtrans_convertURL( NULL, $l ),
					'home_url' => cloudfw_homeurl_by_language( $l )
				);

		$cloudfw_languages_list = $language_list;

	} elseif ( $plugin == 'wpml' && function_exists('icl_get_languages') ){

		$languages = icl_get_languages('skip_missing=0');
		$language_list = array();

		if( 1 < count($languages) )
			foreach( $languages as $l )
				$language_list[ $l['language_code'] ] = array(
					'current' => $current_language == $l['language_code'],
					'id' => $l['id'],
					'name' => $l['translated_name'],
					'native_name' => $l['native_name'],
					'flag' => $l['country_flag_url'],
					'url' => $l['url'],
					'home_url' =>  cloudfw_homeurl_by_language( $l['language_code'] )
				);

		$cloudfw_languages_list = $language_list;

	} else
		$cloudfw_languages_list = array();

	return $cloudfw_languages_list;

}
endif;