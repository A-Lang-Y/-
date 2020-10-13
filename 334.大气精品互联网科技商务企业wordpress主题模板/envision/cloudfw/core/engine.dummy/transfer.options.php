<?php

include_once(TMP_PATH.'/cloudfw/core/engine.dummy/core.transfer.php');	

/**
 *	Export/Import Options
 *
 *	@version 1.0
 *	@since 	 3.0
 */
class CloudFw_Transfer_Options extends CloudFw_Transfer_Dummy
{
	/**
	 *	Construct.
	 */
	function __construct() {
		$this->dir = DUMMY_DIR_PATH . 'options/';
		$this->filename = 'options.txt';
	}


	/**
	 *	Exclude theme options when transfering datas
	 */
	function filter( $data = array() ) {

		if ( ! empty( $data ) && is_array( $data ) ) {
			if ( isset($data[PFIX.'_envato']) ) unset($data[PFIX.'_envato']);
			if ( isset($data[PFIX.'_enabled_modules']) ) unset($data[PFIX.'_enabled_modules']);
			if ( isset($data[PFIX.'_framework']) ) unset($data[PFIX.'_framework']);
			if ( isset($data[PFIX.'_cloudfw_actives']) ) unset($data[PFIX.'_cloudfw_actives']);
			if ( isset($data[PFIX.'_texts']) ) unset($data[PFIX.'_texts']);
			if ( isset($data[PFIX.'_skin_engine']) ) unset($data[PFIX.'_skin_engine']);
			if ( isset($data[PFIX.'_slider_ids']) ) unset($data[PFIX.'_slider_ids']);
			if ( isset($data[PFIX.'_skin_ids']) ) unset($data[PFIX.'_skin_ids']);
			if ( isset($data[PFIX.'_last_checked_version']) ) unset($data[PFIX.'_last_checked_version']);	
			if ( isset($data[PFIX.'_logo']['image']) ) unset($data[PFIX.'_logo']['image']);	
			if ( isset($data[PFIX.'_logo']['image@2x']) ) unset($data[PFIX.'_logo']['image@2x']);	
			if ( isset($data[PFIX.'_logo-tablet']['image']) ) unset($data[PFIX.'_logo-tablet']['image']);	
			if ( isset($data[PFIX.'_logo-tablet']['image@2x']) ) unset($data[PFIX.'_logo-tablet']['image@2x']);	
			if ( isset($data[PFIX.'_logo-phone']['image']) ) unset($data[PFIX.'_logo-phone']['image']);	
			if ( isset($data[PFIX.'_logo-phone']['image@2x']) ) unset($data[PFIX.'_logo-phone']['image@2x']);	
			if ( isset($data[PFIX.'_favicon']) ) unset($data[PFIX.'_favicon']);	
			if ( isset($data[PFIX.'_twitter']) ) unset($data[PFIX.'_twitter']);	
		}

		return apply_filters( 'cloudfw_transfer_filter_options', $data );
		
	}

	/**
	 *	Export.	
	 */
	public function export(){
		$all_settings = $this->filter( cloudfw_get_all_options(NULL, FALSE) );
		
		$this->data = array(
			'case' 		=> 'options',
			'key' 		=> CLOUDFW_THEMEKEY,
			'server' 	=> TMP_URL,
			'others'	=> array(
				'show_on_front' 	=> get_option('show_on_front'),
				'page_on_front' 	=> get_option('page_on_front'),
				'page_for_posts' 	=> get_option('page_for_posts'),
			),
			'data' 		=> $all_settings,
		);

		if ( defined('CLOUDFW_LOCALE_URL') && defined('CLOUDFW_REMOTE_URL') ) {
			$this->data = cloudfw_array_replace( CLOUDFW_LOCALE_URL, CLOUDFW_REMOTE_URL, $this->data );
		}
		
		return base64_encode(serialize( $this->data ));
	}

	/**
	 *	Import.	
	 */
	public function import( $filename = NULL ){
		/** Get the import data */
		$this->data = $this->get_file_data( $filename );
		$theme_options = $this->filter( $this->data['data'] );
		$other_options = $this->data['others'];

		cloudfw_update_option( (array) $theme_options );

		if ( is_array($other_options) && !empty($other_options) )
			foreach ($other_options as $option => $value)
				update_option($option, $value);
	}

}