<?php

function cloudfw_form_register( $case = NULL ) {

	$_REQUEST["_wp_nonce"] = isset($_REQUEST["_wp_nonce"]) ? $_REQUEST["_wp_nonce"] : '';
	$nonce = isset($_REQUEST["nonce"]) ?  $_REQUEST["nonce"] : $_REQUEST["_wp_nonce"];

	if ( ! wp_verify_nonce( $nonce, 'cloudfw') )
		die(__("Failed nonce check and the action aborted.","cloudfw"));

	require_once(TMP_PATH.'/cloudfw/core/framework/core.register.php');
			
		
switch ( $case ) {

case "save_options":

	cloudfw_save_options();
	
	if (isset($_REQUEST['message']) && $_REQUEST['message']) {
		cloudfw_set_message( $_REQUEST['message'] );
	}

	
break;	

case "module":

	$enabled_modules = $_POST[ PFIX.'_enabled_modules' ]; 
	update_option(PFIX.'_enabled_modules', $enabled_modules);
	
	if (isset($_REQUEST['message']) && $_REQUEST['message'])
		cloudfw_set_message( $_REQUEST['message'] );
	
break;	

case "import-data":
	
	if ( ! wp_verify_nonce( $nonce, 'cloudfw') )
		die(__("Failed nonce check and the action aborted.","cloudfw"));

	
	include_once(TMP_PATH.'/cloudfw/core/classes/class.import.php');	

	$args = array();

	$args['allowedTypes']	= array();
	$args['sizeLimit']		= apply_filters('cloudfw_upload_limit', cloudfw_upload_size());
	$args['type']			= $_POST["type"];

	$importer = new CloudFw_Import( $args );
	$message = $importer->result();

	if (isset($message) && $message)
		cloudfw_set_message( $message );


break;

case "import-zip":



	if (!wp_verify_nonce( $nonce, 'cloudfw'))
		die(__("Failed nonce check and the action aborted.","cloudfw"));

	delete_transient('cloudfw_icons');


    include_once ABSPATH . 'wp-admin/includes/template.php';
    include_once ABSPATH . 'wp-admin/includes/screen.php';
    include_once ABSPATH . 'wp-admin/includes/file.php';
    include_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';

    $id = isset($_GET['package_id']) ? $_GET['package_id'] : NULL; 

    if ( empty($id) ) {
        $file_upload = new File_Upload_Upgrader('uploadedfile', 'package');
        $id = $file_upload->id;
    }
    $attachment = get_attached_file( $id );

    $pathinfo = pathinfo($attachment);
    $filename = sanitize_file_name($pathinfo['filename']);
    $ext = $pathinfo['extension'];

	if ( $ext !== 'zip' ) {
		cloudfw_set_message( 9015 ); 
		return false;
	}


    $url = add_query_arg(array('package_id' => $id), $_POST['_wp_http_referer']);
    $GLOBALS['hook_suffix'] = '';
    set_current_screen();

    $extra_fields = array(); 
    foreach ($_POST as $key => $value) {
        if ( in_array($key, array( 'hostname', 'username', 'password', 'connection_type' )) )
            continue;

        $extra_fields[] = $key; 
    }

    global $wp_filesystem;

    ob_start();
    if ( false === ($credentials = request_filesystem_credentials( $url, NULL, false, false, $extra_fields )) ) {
        $data = ob_get_contents();
        ob_end_clean();
        if ( ! empty($data) ){
            wp_die( $data );
            exit;
        }
        return;
    }


    if ( ! WP_Filesystem($credentials) ) {
        request_filesystem_credentials( $url, '', true, false, $extra_fields ); //Failed to connect, Error and request again
        $data = ob_get_contents();
        ob_end_clean();
        if ( ! empty($data) ){
            wp_die( $data );
            exit;
        }
        return;
    }

	$source_file = cloudfw_abs_path(get_attached_file( $id ));
	$target = cloudfw_find_folder( trailingslashit( ICONS_DIR_PATH ) . $filename );



	if ( cloudfw_extract_zip($source_file, $target) ) {
		$message = 9012; 
	} else {
		$message = 9014;
	}

	if ( isset($messag) && $message ) {
		cloudfw_set_message( $message );
	}

	if ( $message == 9012 ) {
		$wp_filesystem->delete( $source_file );
	}


break;
// DEFAULT SLIDER ITEM ADDING AND UPDATING
case "manage_slider_items":
				
	$id = isset($_POST["slider_id"]) ? $_POST["slider_id"] : NULL;
	$main_slider_id = isset($_POST["main_slider_id"]) ? $_POST["main_slider_id"] : NULL;
	
	global $_opt, $cloudfw_extra_query;
	$cloudfw_slider_default = cloudfw_get_slider($main_slider_id);
	$main_slider_type = cloudfw_get_slider_type($main_slider_id);
	
	if ( !$main_slider_type ) {
		exit('ERROR __');
	}
	
	cloudfw_include_slider( $main_slider_type );
	$class_name = cloudfw_get_slider_class( $main_slider_type );
	$class = new $class_name;
	$slider_variables = $class->item_map();

	if (!is_array($slider_variables)) {
		exit('ERROR __');
	}

	foreach ( (array)$slider_variables as $vars ){

		if ( isset( $_POST[$vars] ) && !is_array( $_POST[ $vars ] ) ) {
	        
	        if ( isset($_POST[ 'is_defined_'. $vars ]) && $_POST[ 'is_defined_'. $vars ] == 'onoff' && empty( $_POST[ $vars ] ) )
	            $_POST[ $vars ] = 'FALSE';
	   
			$$vars = isset($_POST[$vars]) ? stripslashes( $_POST[$vars] ) : NULL;

		} else {

			if ( !empty( $_POST[$vars] ) ) {
				foreach ((array)$_POST[$vars] as $sub_key => $value) {
					$_POST[$vars][$sub_key] = stripslashes( $value );
				}
			}
			
			$$vars = isset($_POST[$vars]) ? $_POST[$vars] : NULL;

		}

	}

	if ( empty($id) || !is_numeric( $id ) ):

		foreach ( (array) $slider_variables as $vars ) {
			$additive_item_vars[ $vars ] = $$vars;
		}
			
		$additive_item = $additive_item_vars;
		
		if ( isset($cloudfw_slider_default) && $cloudfw_slider_default ) {
			array_unshift ( $cloudfw_slider_default, $additive_item );
		} else {
			$cloudfw_slider_default[] = $additive_item;
		}
		
		update_option( $main_slider_id, $cloudfw_slider_default );
		delete_transient( 'cloudfw_slider_'.$main_slider_id );
		cloudfw_set_message( 6001 );
		$cloudfw_extra_query = array( "slider_id" => 0 );
			
	else: 
	
		// Update A Slider Item
		foreach ((array) $slider_variables as $vars) {
			$gonnabeupdated_item_vars[$vars] = $$vars;
		}
			
		$gonnabeupdated_item = $gonnabeupdated_item_vars;
		$cloudfw_slider_default[$id] = $gonnabeupdated_item;

		update_option( $main_slider_id, $cloudfw_slider_default );
		delete_transient( 'cloudfw_slider_'.$main_slider_id );
		cloudfw_set_message( 6002 );
		
	endif;
	
break;
				
case PFIX."_slider_sorting":
	
	global $cloudfw_slider_default, $_opt;
	$main_slider_id = $_POST["main_slider_id"];
	$cloudfw_slider_default = cloudfw_get_slider($main_slider_id);

	
	$ii = 0;
	foreach ((array) $cloudfw_slider_default as $vars => $var)
	{
		$sorting_number = $_POST[ "s_" . $ii ];
		$delete = ($_POST[ "d_" . $ii ]) ? true : false;

		if (!$delete)
			$new_slider_default[ $sorting_number ] = $cloudfw_slider_default[$vars];		

		$ii++;
	}
		
	ksort($new_slider_default);
		
	$i = 0; 	
	foreach ((array) $new_slider_default as $key => $vars){
		$renew_slider_default[$i] = $vars;
		$i++;
	}
		
	update_option($main_slider_id, $renew_slider_default);
	
	cloudfw_set_message( 6002 );
	delete_transient('cloudfw_slider_'.$main_slider_id);

	if ( $renew_slider_default ) {
		/* Load Slider CloudFw API */
		require (TMP_PATH.'/cloudfw/core/engine.slider/core.slider.include_forms.php'); 
		
		$slider_type = cloudfw_get_slider_type( $main_slider_id );
		cloudfw_loop_slider_items($renew_slider_default, $slider_type, $main_slider_id);
		exit;
	}
	
break;


/**
 *	Create a Slider
 */
case "manage_main_slider":
 	global $cloudfw_extra_query;
	
	$id = $_POST["slider_id"];
	$slider_type = $id ? cloudfw_get_slider_type( $id ) : $_POST["slider_type"];
		
	cloudfw_include_slider( $slider_type );
	$class_name = cloudfw_get_slider_class( $slider_type );

	$class = new $class_name;
	$variables = $class->main_map();

	$slider_data = array();
	
	if (!is_array($variables))
		exit('ERROR');
	
	foreach ((array) $variables as $vars => $var) {

		if ( !is_array( $var ) ) {
			$slider_data[$var] = isset($_POST[$var]) ? stripslashes($_POST[$var]) : NULL;

		} else {

			if(isset($_POST[$vars])) {
				$slider_data[$vars] = stripslashes($_POST[$vars]);
			} else {
			
				if(isset($var["default"]) && !$id)
					$slider_data[$vars] = stripslashes($var["default"]);					
				elseif($var["type"] == "boolean")		
					$slider_data[$vars] = "FALSE";

			}

		}
						
	}
	
	
	if ( !isset($id) || ! $id ) {
		/** Add Slider */
		$slider_data['type'] = $slider_type;
		$slider_id 			 = cloudfw_create_slider( $slider_data );
		
		$_POST["comeback"] .= "&msid=".$slider_id."&slider_type=".$slider_type;
		cloudfw_set_message( 6004 );

	} else {

		/** Update Slider */
		$slider_data['id'] = $id;
		$slider_data['type'] = isset($slider_type) ? $slider_type : NULL;
		cloudfw_create_slider( $slider_data );
		
		$cloudfw_extra_query['this_page'] = isset($_REQUEST['comeback']) ? $_REQUEST['comeback'] : NULL;
		$cloudfw_extra_query['msid'] = $id;
		cloudfw_set_message( 6005 );
		
	}
	
	
break;		
// ADD SKIN
case PFIX."_add_skin":
	
	$force = FALSE;
	$id = isset($_POST["skin_id"]) ? $_POST["skin_id"] : NULL;
	$skin_apply = isset($_POST["skin_apply"]) ? $_POST["skin_apply"] : NULL;
	
	if ( empty($id) ) {

		$id = cloudfw_skin_manager();
		$force = TRUE;
		cloudfw_set_message( 7001 );

	}			
				
	$variables = array( 'skin_name' );				
	foreach ($variables as $var) {
		$$var = isset( $_POST[ $var ] ) ? stripslashes( $_POST[ $var ] ) : NULL;
	}
	
	$the_skin = array(
		'mode' 		=> 'custom',
		'name'		=> $skin_name,
		'id' 		=> $id,
		'data' 		=> cloudfw_PV( cloudfw_get_content_maps("skin_map") )
	);

	if ( isset($skin_apply) && $skin_apply == 1 ) {
		$force = TRUE;
		cloudfw_set_message( 7005 );
	}	
	
	update_option($id, $the_skin);
	cloudfw_sync_skins( $id, $force );
	
	if ( ! cloudfw_check_message() ) {
		cloudfw_set_message( 7002 );
	} 
			
break;	

// CHANGE SKIN
case PFIX."_colors":

	$variables = array(
		PFIX.'_skin'
	 );
	
	foreach ($variables as $var) {
		$$var = isset( $_POST[ $var ] ) ? stripslashes( $_POST[ $var ] ) : NULL;
	}
	
	if ( ! empty(${PFIX.'_skin'}) ) {
		cloudfw_change_skin(${PFIX.'_skin'});
	}

	cloudfw_set_message( 7004 );
			
break;

// CREATE SKIN
case PFIX."_create_skin":
		
	global $cloudfw_editing_skin_id, $jump_tab;
	
	$variables = array(
		'skin_name'
	 );
	
	foreach ($variables as $var) {
		$$var = isset( $_POST[ $var ] ) ? stripslashes( $_POST[ $var ] ) : NULL;
	}

	if (empty($skin_name)) $skin_name = __('Unnamed Skin','cloudfw');
	
	$id = cloudfw_skin_manager();
	
	$the_skin = array(
		'mode'	=>  'custom',
		'id'	=>	$id,
		'name'  =>	$skin_name
	);
	update_option($id , $the_skin);
	delete_option( cloudfw_get_the_skin_cache_ID( $id ) );
	
	cloudfw_set_message( 7001 );

	$cloudfw_editing_skin_id = $id;
	$jump_tab = 1;
			
break;
// LOAD FONTS
case PFIX."_font_settings":
	
	
	$variables = array(
		 PFIX.'_loaded_fonts'
	 );
	
	foreach ($variables as $var) {
		if ( isset( $_POST[ $var ] ) ) {
			$$var = !is_array( $_POST[ $var ] ) ? stripslashes( $_POST[ $var ] ) : $_POST[ $var ];
		}
	}
		
	update_option(PFIX.'_fonts', ${PFIX.'_loaded_fonts'});
	cloudfw_save_options();
	
	cloudfw_delete_skin_caches();
	cloudfw_set_message( 8010 );
			
break;

// LOAD FONTS
case PFIX."_font_settings_customize":
			
	$map = cloudfw_get_content_maps("font_map");
	$results = cloudfw_PV( $map );
	$results = cloudfw_prepare_skin_data( $map, $results );

	update_option(PFIX.'_font_engine', $results);
	cloudfw_delete_skin_caches();
	
	cloudfw_set_message( 8011 );
	
	return false;
			
break;
	}

}