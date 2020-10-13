<?php	
global $_opt;

/* Load Slider CloudFw API */
require (TMP_PATH.'/cloudfw/core/engine.slider/core.slider.include_forms.php'); 

$action         = isset($_POST["operation"]) ? $_POST["operation"] : NULL;
$type           = isset($_POST["type"]) ? $_POST["type"] : NULL;
$id             = isset($_POST["id"]) ? $_POST["id"] : NULL;
$main_slider_id = isset($_POST["main_slider_id"]) ? $_POST["main_slider_id"] : NULL;
$lastID         = isset($_POST["lastID"]) ? $_POST["lastID"] : NULL;
$this_page      = isset($_POST["thispage"]) ? $_POST["thispage"] : NULL;
$raw_this_page  = isset($_POST["raw_thispage"]) ? $_POST["raw_thispage"] : NULL;


switch ($action){

	case 'edit':
	
		if ( $type == 'main_sliders' ) {

			if ( isset( $id ) ) {
				$slider_ids = isset($_opt[PFIX."_slider_ids"]) ? $_opt[PFIX."_slider_ids"] : NULL;
				$data = isset($slider_ids[ $id ]) ? $slider_ids[ $id ] : NULL;
			}

			cloudfw_main_slider_forms( $this_page, $lastID, $data, $id );	
			
		} else {
			
			$data = ''; 		
			if ( isset( $id ) ) {
				$main_slider_data = cloudfw_get_slider( $main_slider_id );
				$data = isset($main_slider_data[ $id ]) ? $main_slider_data[ $id ] : NULL;
			}
				
			cloudfw_sub_slider_forms( $this_page, $raw_this_page, $lastID, $data, $id, $main_slider_id);
				
		}		
		break;	

	case 'loop':
		
		if ( isset( $main_slider_id ) ) {
			$slider_type = cloudfw_get_slider_type( $main_slider_id );
			cloudfw_loop_slider_items( cloudfw_get_slider( $main_slider_id ), $slider_type, $main_slider_id );
		} else {
			$ids = isset($_opt[PFIX."_slider_ids"]) ? $_opt[PFIX."_slider_ids"] : NULL;
			cloudfw_loop_all_sliders( $ids, NULL, $this_page );
		}
		break;

	
	case 'delete':
		
		if ( $type == 'main_sliders' ) {
			cloudfw_loop_all_sliders( cloudfw_delete_slider( $id ), NULL, $this_page );
			
		} else {
			$slider_content = cloudfw_get_slider( $main_slider_id );
			$slider_type = cloudfw_get_slider_type( $main_slider_id );

			if ( !empty( $slider_content ) && is_array( $slider_content ) )
				ksort( $slider_content );
	
			$intent = 0;
			$new_slider_content = array(); 
			foreach ($slider_content as $vars => $var){

				if ( (int) $vars !== (int) $id ){
					$new_slider_content[ $intent ] = isset($slider_content[ $vars ]) ? $slider_content[ $vars ] : NULL;
					
					$intent++;
				}
				
			}
			
			update_option( $main_slider_id, $new_slider_content );
			cloudfw_loop_slider_items( $new_slider_content, $slider_type, $main_slider_id );

		}			
	
		break;

	case 'duplicate':

		$slider_content = (array) cloudfw_get_slider($main_slider_id);
		$slider_type = cloudfw_get_slider_type($main_slider_id);

		if ( !empty( $slider_content ) && is_array( $slider_content ) )
			ksort( $slider_content );

		$intent = 0;
		foreach ( $slider_content as $item_id => $var){
			
			if ( (int) $item_id === (int) $id ) {
				$new_slider_content[ $intent ] = $slider_content[ $id ];
				$intent++;		
			}
			
			$new_slider_content[ $intent ] = $slider_content[ $item_id ];
			$intent++;		

		}
		
		update_option( $main_slider_id, $new_slider_content );
		cloudfw_loop_slider_items( $new_slider_content, $slider_type, $main_slider_id );
		break;
	
}