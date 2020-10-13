<?php
/**
 *	Custom Skins
 */
class CloudFw_Page_Generator_Custom_Skins extends CloudFw_Page_Generator_Base {
	
	function custom_skin_id(){
		return $this->get_meta('custom_skin');
	}

}