<?php

include_once(TMP_PATH.'/cloudfw/core/engine.dummy/core.transfer.php');	

/**
 *	Export/Import Menu Datas
 *
 *	@version 1.0
 *	@since 	 3.0
 */
class CloudFw_Transfer_Menus extends CloudFw_Transfer_Dummy
{
	/**
	 *	Construct.
	 */
	function __construct() {
		$this->dir = DUMMY_DIR_PATH . 'menus/';
		$this->filename = 'menus.txt';
	}

	/**
	 *	Export.	
	 */
	public function export(){
		global $wpdb;
		
		$this->data = array();
		$locations = get_nav_menu_locations();

		$terms_table = $wpdb->prefix . "terms";
		foreach ((array)$locations as $location => $menu_id) {
			$menu_slug = $wpdb->get_results("SELECT * FROM $terms_table where term_id={$menu_id}", ARRAY_A);
			$this->data[ $location ] = $menu_slug[0]['slug'];
			
		}
		return base64_encode(serialize( $this->data ));
	}

	/**
	 *	Import.	
	 */
	public function import( $filename = NULL ){
		global $wpdb;
		$terms_table = $wpdb->prefix . "terms";

		/** Get the import data */
		$this->data = $this->get_file_data( $filename );

		if ( is_array($this->data) && !empty($this->data) ) {

			$out = array(); 
			foreach ($this->data as $location => $menu_slug) {
				$rows = $wpdb->get_results("SELECT * FROM $terms_table where slug='{$menu_slug}'", ARRAY_A);
				$term_id = isset($rows[0]['term_id']) ? $rows[0]['term_id'] : NULL; 
				$out[ $location ] = $term_id;
				
				if ( !empty($term_id) ) {
					$items = wp_get_nav_menu_items( $term_id );
					foreach ((array)$items as $item) {
						if ($item->title == "Home") {
							update_post_meta($item->ID, '_menu_item_url', home_url());
						}
					}
				}

			}
		}

		set_theme_mod('nav_menu_locations', array_map('absint', $out ) );
		return $out;

	}

}