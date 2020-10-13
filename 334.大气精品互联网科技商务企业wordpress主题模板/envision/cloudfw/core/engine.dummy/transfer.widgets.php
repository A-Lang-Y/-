<?php

include_once(TMP_PATH.'/cloudfw/core/engine.dummy/core.transfer.php');	

/**
 *	Export Widget Datas
 *
 *	@version 1.0
 *	@since 	 3.0
 */
class CloudFw_Transfer_Widgets extends CloudFw_Transfer_Dummy
{
	/**
	 *	Construct.
	 */
	function __construct( $for_what = 'dummy' ) {
		if ( $for_what == 'setup' )
			$this->dir = trailingslashit(TMP_WIDGETS);
		else
			$this->dir = DUMMY_DIR_PATH . 'widgets/';
	}

	/**
	 *	Export.	
	 */
	public function export(){
		$this->data 			= array();
		$this->data['sidebars'] = $this->export_sidebars(); 
		$this->data['widgets'] 	= $this->export_widgets(); 

		if ( defined('CLOUDFW_LOCALE_URL') && defined('CLOUDFW_REMOTE_URL') ) {
			$this->data = cloudfw_array_replace( CLOUDFW_LOCALE_URL, CLOUDFW_REMOTE_URL, $this->data );
		}

		return base64_encode(serialize( $this->data ));
	}

	/**
	 *	Get sidebars.
	 */
	private function export_sidebars(){
		$sidebars = get_option("sidebars_widgets");
		$sidebars = $this->exclude_sidebar_keys( $sidebars ); 

		return $sidebars;
	}

	/**
	 *	Get widget datas.
	 */
	private function export_widgets(){
		global $wp_registered_widgets;
		$all_widgets = array();
		
		foreach ($wp_registered_widgets as $widget_id => $widget_params) 
			$all_widgets[] = $widget_params['callback'][0]->id_base; 

		foreach ($all_widgets as $widget_id) {
			$widget_data = get_option( 'widget_' . $widget_id ); 
			if ( !empty($widget_data) )
				$widget_datas[ $widget_id ] = $widget_data;
		}

		unset($all_widgets);
		return $widget_datas;
	}

	/**
	 *	Exclude sidebar array keys.
	 */
	private function exclude_sidebar_keys( $keys = array() ){
		if ( ! is_array($keys) )
			return $keys;

		unset($keys['wp_inactive_widgets']);
		unset($keys['array_version']);
		return $keys;
	}

	/**
	 *	Import.	
	 */
	public function import( $filename = NULL ){
		$this->data = $this->get_file_data( $filename );

		$this->import_widgets();
		$this->import_sidebars();
		return $this->data;
	}

	/**
	 *	Import sidebars.
	 */
	private function import_sidebars(){
		$sidebars = get_option("sidebars_widgets");
		unset($sidebars['array_version']);

		if ( is_array($this->data['sidebars']) ) {
			$sidebars = array_merge( (array) $sidebars, (array) $this->data['sidebars'] );
			unset($sidebars['wp_inactive_widgets']);
			$sidebars = array_merge(array('wp_inactive_widgets' => array()), $sidebars);
			$sidebars['array_version'] = 2;

			wp_set_sidebars_widgets( $sidebars );
		}
	}

	/**
	 *	Import widgets data.
	 */
	private function import_widgets(){
		foreach ((array) $this->data['widgets'] as $widget_id => $widget_data) {
			update_option( 'widget_' . $widget_id, $widget_data );
		}
	}

}