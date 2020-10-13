<?php

/**
 *  CloudFw - WordPress Theme Framework
 *  Only Admin Functions
 *
 *  @package WordPress
 *  @package CloudFw
**/


function cloudfw_options_route_periot( $type ){
	switch ($type) {
		case 'page':
			$periot = 0;
			break;
		case 'vertical_tabs':
			$periot = 10;
			break;
		case 'tabs':
			$periot = 11;
			break;
		case 'container':
			$periot = 50;
			break;
		case 'section':
			$periot = 60;
			break;
		case 'section-title':
			$periot = 61;
			break;
		case 'module-set':
			$periot = 98;
			break;
		case 'module':
			$periot = 99;
			break;
	}

	return isset($periot) ? $periot : NULL;
}

/**
 *  Set Options Route
 *
 *  @since 4.0
 */
function cloudfw_options_route_set( $type, $data, $title = NULL ){
	if ( ! cloudfw_in_developing() ) {
		return false;
	}

	global $cloudfw_options_route;

	if ( !is_array($cloudfw_options_route) ) {
		$cloudfw_options_route = array();
	}

	switch ($type) {
		case 'tabs':
		case 'vertical_tabs':
			cloudfw_options_route_reset( $type );
			$cloudfw_options_route[ cloudfw_options_route_periot( $type ) ] = isset($data['tab_title']) ? $data['tab_title'] : NULL;
			break;
		case 'page':
		case 'container':
		case 'section':
		case 'section-title':
		case 'module-set':
		case 'module':
			cloudfw_options_route_reset( $type );
			$cloudfw_options_route[ cloudfw_options_route_periot( $type ) ] = isset($data['title']) ? $data['title'] : NULL;
			break;
	}

}

/**
 *  Get Options Route
 *
 *  @since 4.0
 */
function cloudfw_options_route_reset( $type = NULL ){
	global $cloudfw_options_route;

	$limit = cloudfw_options_route_periot( $type );
	if ( isset($limit) && $limit ) {
		foreach ($cloudfw_options_route as $key => $value) {
			if ( $key > $limit ) {
				unset($cloudfw_options_route[ $key ]);
			}
		}
	}

}

/**
 *  Get Options Route
 *
 *  @since 4.0
 */
function cloudfw_options_route_get( $type = NULL ){
	if ( ! cloudfw_in_developing() ) {
		return false;
	}

	global $cloudfw_options_route;
	$route = $cloudfw_options_route;

	$limit = cloudfw_options_route_periot( $type );
	if ( isset($limit) && $limit ) {
		foreach ($route as $key => $value) {
			if ( $key > $limit ) {
				unset($route[ $key ]);
			}
		}
	}

	if ( is_array( $route ) ) {
		$route = array_unique($route);
		$route = array_filter($route);
		ksort( $route );
	}

	return $route;
}

/**
 *  Get Options Route
 *
 *  @since 4.0
 */
function cloudfw_options_route_button( $type = NULL ){
	if ( ! cloudfw_in_developing() ) {
		return false;
	}

	$route = cloudfw_options_route_get( $type );
	$title = implode(' > ', $route);
	$out = '';

	if ( !empty( $title ) ) {
		$title = 'Theme Control Panel > ' . $title;
		$out = "<a href=\"javascript:;\" title=\"". esc_attr( $title ) ."\" class=\"cloudfw-ui-route\">Route</a>";
	}

	return $out;
}

/**
 *  Set Message
 *
 *  @since 3.0
 */
function cloudfw_set_message( $message = 1000 ){
	global $cloudfw_admin_message;
	return $cloudfw_admin_message = $message;
}

/**
 *  Get Message
 *
 *  @since 3.0
 */
function cloudfw_get_message(){
	global $cloudfw_admin_message;
	return isset($cloudfw_admin_message) ? $cloudfw_admin_message : 1000;
}


/**
 *  Check Message
 *
 *  @since 3.0
 */
function cloudfw_check_message(){
	global $cloudfw_admin_message;
	return isset($cloudfw_admin_message);
}

/**
 *  Get the value
 *
 *  @since 3.0
 */
function cloudfw_get_value( $key, $default = '' ){
	if ( !empty( $key ) || $key === 0 || $key === '0' )
		return $key;
	else
		return $default;
}


/**
 *  CloudFw Ajax Responses
 */
function cloudfw_ajax_response( $message, $extra = array() ){
	if ( empty($message) ) {
		$message = 1000;
	}

	$msg = cloudfw_admin_messages($message);
	$out = array(
		'messageId'     => isset($message) ? $message : 1000,
		'messageTitle'  => isset($msg['title']) ? $msg['title'] : NULL,
		'messageText'   => isset($msg['msg']) ? $msg['msg'] : NULL,
		'messageCase'   => isset($msg['key']) ? $msg['key'] : NULL,
	);

	$out = array_merge((array)$out, (array)$extra);

	cloudfw_ajax_make_json( $out );
	exit;
}

/**
 *  Make Not Found Text
 */
function cloudfw_notfound( $text ){
	return "<div class=\"thereisno\">{$text}</div>";
}

/**
 *  Exclude theme options when transfering datas
 *
 *  @since 1.0
 */
function cloudfw_exclude_options($data = array(), $server = NULL, $folder = NULL, $server_replace = FALSE){

	unset($data[PFIX.'_font_engine']);
	unset($data[PFIX.'_skin_engine']);
	unset($data[PFIX.'_slider_ids']);
	unset($data[PFIX.'_skin_ids']);
	unset($data[PFIX.'_last_checked_version']);

	if ($server_replace && $server)
		$data = cloudfw_server_replacer($data, $server, $folder);

	return $data;

}

/**
 *  Replace server address in data
 *
 *  @since 1.0
 */
function cloudfw_server_replacer($data = array(), $a = NULL, $b = NULL){
	if (!$a || !$b) return $data;

	foreach ($data as $key => $value){
		if(is_array($value))
			$data[$key] = cloudfw_server_replacer($value, $a, $b);
		elseif(is_string($value)) {

			if (strpos($value, $a) === 0) {

				$pathinfo = pathinfo($value);

				if ($pathinfo['extension'] == 'png' || $pathinfo['extension'] == 'jpg' || $pathinfo['extension'] == 'gif' || $pathinfo['extension'] == 'tiff')
					$data[$key] = trailingslashit( TMP_URL.'/resources/'.$b ).$pathinfo['filename'].'.'.$pathinfo['extension'];
				else
					$data[$key] = $value;

			}else{
				$data[$key] = $value;
			}

		}else {
			$data[$key] = $value;
		}
	}

	return $data;
}

/**
 *  Prepare URI to import
 *
 *  @since 1.0
 */
function cloudfw_prepare_URI_for_import($data = array(), $target = NULL, $tag = '%%SERVER%%') {

	if (!$target || !$tag)
		return $data;

	foreach ((array)$data as $key => $value){
		if(is_array($value))
			$data[$key] = cloudfw_prepare_URI_for_import($value, $target, $tag);
		elseif(is_string($value)) {
			$data[$key] = str_replace($tag, trailingslashit( $target ), $value);
		}else {
			$data[$key] = $value;
		}
	}

	return $data;
}

/**
 *  Grouped Predefined Pattern Array
 *
 *  @since 1.0
 */
function cloudfw_groupped_skin_styles( $group_filter = array(), $namespace = 'default', $default_title = NULL, $preview = true ){
	global $cloudfw_pre_styles;
	static $cloudfw_cache_pre_styles;
	$cache_ID = cloudfw_generate_cache_ID( func_get_args() );

	if ( isset( $cloudfw_cache_pre_styles[ $cache_ID ] ) )
		return $cloudfw_cache_pre_styles[ $cache_ID ];

	if ( !$namespace )
		$namespace = 'default';

	$array_styles[] = array(
		'item_name'         => _if( $default_title, $default_title, __('No Style','cloudfw') ),
		'item_value'        => ''
	);

	if ( is_array( $cloudfw_pre_styles ) ){

		foreach ($cloudfw_pre_styles as $pattern_id => $pattern) {

			if ( $namespace !== $pattern["namespace"] )
				continue;

			if ( is_array( $group_filter ) && !empty( $group_filter ) )
				if ( !in_array( $pattern["group"], $group_filter ) )
					continue;

			$groups[] = $pattern["group"];

			 if ($pattern["name"]) {

				${$pattern["group"].'_array'}[] = array(
					'item_value'    => $pattern_id,
					'item_name'     => $pattern["name"],
					'item_before'   => _if( $preview, '<span class="pattern-preview" style="'.$pattern["code"].'"></span>' )
				);

			}

		} // foreach: pattern

	} else
		return false; /** There is no skin */

	if ( is_array( $groups ) ) {

		$groups = array_unique($groups);
		asort($groups);

		foreach ((array)$groups as $group) {

			$array_styles[] = array(
				'group'         => TRUE,
				'item_name'     => $group,
				'item_value'    => ${$group.'_array'}
			);

		}

	}

	return $cloudfw_cache_pre_styles[ $cache_ID ] = $array_styles;

}

/**
 *  Extract Zip Files
 *
 *  @since 1.0
 */
function cloudfw_extract_zip($file_to_open, $target) {
	global $wp_filesystem;

	if ( is_wp_error( $result = unzip_file($file_to_open, $target) ) ) {
		wp_die( $result->get_error_message() );

	} else
		return $result;

}


/**
 *  Get Max Upload Size of Server
 *
 *  @since 1.0
 */
function cloudfw_upload_size(){
	require_once(ABSPATH.'/wp-admin/includes/template.php');
	$u_bytes = wp_convert_hr_to_bytes( ini_get( 'upload_max_filesize' ) );
	$p_bytes = wp_convert_hr_to_bytes( ini_get( 'post_max_size' ) );
	$sizeLimit = min($u_bytes, $p_bytes);

	if ( !$sizeLimit )
		$sizeLimit = 4 * 1024 * 1024;

	return $sizeLimit;
}

/**
 *  Prepare ID and name attribute
 *
 *  @since 3.0
 */
function cloudfw_prepare_id_and_name( $id, $brackets = false ) {
	if ( ! $brackets ) {
		return array(
			'id'    => $id,
			'name'  => $id,
		);
	}

	/*static $cloudfw_static_vars;

	if ( ! isset( $cloudfw_static_vars[ $id ] ) ) {
		$cloudfw_static_vars[ $id ] = 0;
	} else {
		$cloudfw_static_vars[ $id ]++;
	}*/

	$name = $id . '[]';
	//$id = $id . '_' . $cloudfw_static_vars[ $id ];

	return array(
		'id'    => $id,
		'name'  => $name,
	);
}

/**
 *  Get Icon Folders
 *
 *  @since 1.0
 */
function cloudfw_get_icon_folders($icon_folder) {
	if (!$icon_folder)
		return false;

	$out = array();
	if ($handle = opendir($icon_folder)) {
		while (false !== ($file = readdir($handle))) {
			if ($file != "." && $file != ".." && is_dir($icon_folder.$file) ) {
				$out[] = $file;
			}
		}
		closedir($handle);
	}

	return $out;
}

/**
 *  Get Icon Files
 *
 *  @since 1.0
 */
function cloudfw_get_icon_files() {

	$icon_folder = ICONS_DIR_PATH;
	$path = TMP_URL;
	$folders = cloudfw_get_icon_folders($icon_folder);
	$out = array();

	if (is_array($folders)):

		foreach((array) $folders as $folder):
			//if (!is_dir($folder)) continue;

			if ($handle = @opendir($icon_folder.$folder)) {
				while (false !== ($file = readdir($handle))) {
					if ($file != "." && $file != ".." &&
						(
						 strpos($file, '.png') !== false ||
						 strpos($file, '.gif') !== false ||
						 strpos($file, '.jpg') !== false
						)
					) {

						$file_name = explode('.',$file);
						if ( substr($file_name[0], -3) !== '@2x' ) {
							$out[$folder][$folder.'/'.$file] = $file_name[0];
						}

					}
				}
				closedir($handle);
			}

		endforeach;

	endif;

	return $out;
}

/**
 *  Get All Icons
 *
 *  @since 1.0
 */
function cloudfw_get_icons() {
	$icons = cloudfw_get_icon_files();
	return $icons;
}

/**
 *  CloudFw Create Sample Pages
 *
 *  @since 1.0
 */
function cloudfw_create_a_page($args = array(), $opt = array()){
	if (empty($args) || !is_array($args))
		return false;

	// Insert the post into the database
	if (!$opt["update"])
		$out["id"] = wp_insert_post($args);
	else
		$out["id"] = wp_update_post($args);

	foreach ((array) get_pages('sort_column=post_date&sort_order=desc&post_type=' . $args["post_type"] . '') as $page) {
		$lastID       = $page->ID;
		//$out["id"]    = $lastID;
		$out["title"] = get_the_title($page->ID);
		$out["url"]   = get_permalink($page->ID);

		break;
	}

	$template = $opt["template"];

	if (!update_post_meta($lastID, '_wp_page_template', $template) && isset($template))
		add_post_meta($lastID, '_wp_page_template', $template, true);

	return $out;
}



/**
 *  Detect Option From A Content Schema
 *
 *  @since 1.0
 */
function cloudfw_detect_options( $scheme = array(), $out = array() ){

	if ( is_array( $scheme ) ) {

		$data = isset($scheme['data']) ? $scheme['data'] : array();
		foreach ( (array) $data as $key => $value ) {
			$type = isset($value['type']) ? $value['type'] : NULL;

			switch ( $type ) {
				case 'text':
				case 'textarea':
				case 'onoff':
				case 'color':
				case 'gradient':
				case 'upload':
				case 'slider':
				case 'radio':
				case 'checkbox':
				case 'select':
				case 'dropdown':
				case 'page-selector':
				case 'icon-selector':
				case 'multi-blog-cats':
				case 'user-select':
				case 'indicator':

					$out[] = array(
						'id'    =>  $value['id'],
						'type'  =>  $value['type'],
					);

				break;
				default;

				break;

			}

			$out = cloudfw_detect_options( $value, $out );

		}

	}

	return (array) $out;
}

/**
 *  Check Ajax Permissions
 *
 *  @since 1.0
 */
function cloudfw_check_admin_ajax_permissions( $args = array() ) {

	extract(cloudfw_make_var(array(
		'nonce'         => isset($_REQUEST['nonce']) ? $_REQUEST['nonce'] : NULL,
		'nonce_key'     => 'cloudfw',
		'user_level'    => 'edit_posts',
	), $args));

	if ( !is_user_logged_in() ) {
		cloudfw_ajax_response( 1006 );
	}

	if ( !wp_verify_nonce($nonce, $nonce_key) ) {
		cloudfw_ajax_response( 1004 );
	}

	if ( $user_level != false ) {
		if ( !is_user_logged_in() || !current_user_can($user_level) ) {
			cloudfw_ajax_response( 1005 );
		}
	}

}

/**
 *  Parse Query String
 *
 *  @since 1.0
 */
function cloudfw_parse_querystring($str) {
	$op = array();
	$pairs = explode("&", $str);
	foreach ($pairs as $pair) {
		list($k, $v) = array_map("urldecode", explode("=", $pair));
		$op[$k] = $v;
	}
	return $op;
}


/**
 *  CloudFw Admin This Page
 *
 *  @since 1.0
 */
function cloudfw_admin_this_page(){
	$tab = isset($_GET['tab']) ? $_GET['tab'] : NULL;
	$this_page = CLOUDFW_PAGE;

	if( $tab )
		$this_page .= '&tab='. $tab;

	return $this_page;
}

/**
 *	Show UI for Dummy Contents
 */
function cloudfw_dummy_show_ui( $location = NULL  ){
	if( ! @is_dir(DUMMY_DIR_PATH) )
		return false;

	$cloudfw_render_import_dummy = cloudfw_render_import_dummy();

	if ( isset($location) && $location == 'dashboard' )
		return _check_onoff( cloudfw_get_option('cloudfw_actives', 'dummy')) && !empty($cloudfw_render_import_dummy);
	else
		return true;

}

/**
 *  Import Dummy Contents
 *
 *  @since 1.0
 */
function cloudfw_render_import_dummy( $location = NULL ){

	$data = array(
		## Module Item
		array(
			'type'      =>  'html',
			'data'      =>  '<div id="dummy-messages"></div>'
		),

		## Module Item
		array(
			'type'      =>  'jquery',
			'data'      =>  '

				var process_bar = jQuery("#process-bar-import"),
					procces_bar_bar = jQuery(".pbar-bar", process_bar),
					procces_bar_current = jQuery(".pbar-current-value", process_bar),
					procces_step;

				/** Dummy Content Import Function */
				var cloudfw_import_dummies = function( args ){

					jQuery("body").addClass("cloudfw-state-importing");
					cloudfw_global_loading("show");

					var ajaxForm_vars = {
						action          : "cloudfw_import_dummies",
						type            : args.type,
						hostname        : jQuery("input[name=\'hostname\']", "#container-dummy-importer").val(),
						username        : jQuery("input[name=\'username\']", "#container-dummy-importer").val(),
						password        : jQuery("input[name=\'password\']", "#container-dummy-importer").val(),
						public_key      : jQuery("input[name=\'public_key\']", "#container-dummy-importer").val(),
						private_key     : jQuery("input[name=\'private_key\']", "#container-dummy-importer").val(),
						connection_type : jQuery("input[name=\'connection_type\']", "#container-dummy-importer").val(),
						nonce           : CloudFwOp.cloudfw_nonce
					};

					var success_callback = function( data ){

						try {
							var obj = jQuery.parseJSON(data);
							cloudfw_dialog(obj.messageTitle,obj.messageText,obj.messageCase);
							//alert(data);

						} catch (e) {
							//cloudfw_dialog("Fatal Error", "There was an error when the action in proccess.", "error");
							//alert(data);

							jQuery("#todolist-import").show().append( "<li class=\"donea\">"+ data +"</li>" );

						}

						jQuery("body").removeClass("cloudfw-state-importing");
						cloudfw_global_loading("hide");

					}

					jQuery.ajax({
						url: CloudFwOp.ajaxUrl,
						cache: false,
						type: "POST",
						data: (jQuery.param(ajaxForm_vars, true)),
						success: (typeof args.callback == \'function\') ? args.callback : success_callback
					});

				}

				// Create a new queue.
				var queue = jQuery.jqmq({
					delay: -1,
					batch: 1,
					callback: function( item ) {
						cloudfw_import_dummies({
							type:   item,
							callback: function( data ){

								try {
									var obj = jQuery.parseJSON(data);
									jQuery( "<li class=\"donea\"><span class=\"guide\">"+ obj.messageTitle +"</span></li>" ).appendTo( jQuery("#todolist-import") ).hide().slideDown();

								} catch (e) {
									jQuery( "<li class=\"donea\"><span class=\"guide\">"+ data +"</span></li>" ).appendTo( jQuery("#todolist-import") ).hide().slideDown();

								}


								var current_per = parseInt(procces_bar_current.val()),
									new_per = Math.ceil(current_per + procces_step);

								if ( new_per > 100 )
									new_per = 100;


								console.log(new_per);
								procces_bar_current.val( new_per );
								cloudfw_make_timer(jQuery(".pbar-in-center", process_bar), new_per, 1000);
								procces_bar_bar.stop(1).animate({width: (660 * ((new_per < 10 ? 10 : new_per ) / 100))}, 1000, function(){
									//if ( new_per == 100 )
									//  process_bar.delay(1000).fadeOut();

								});

								queue.next();

							}
						});
					},
					complete: function(){
						jQuery( "<li class=\"done\"><span class=\"guide\" style=\"color: #00A651 !important;\">'. __('Import process completed.','cloudfw') .'</span></li>" ).appendTo( jQuery("#todolist-import") ).hide().slideDown();;

						jQuery("body").removeClass("cloudfw-state-importing");
						cloudfw_global_loading("hide");
					}

				});


				jQuery("#dummy-submit").click(function(){
					if (jQuery("body").hasClass("cloudfw-state-importing")) {
						cloudfw_dialog("Please Wait", "Plase wait while an import action in proccess.", "error");
						return false;
					}

					CloudFw_UI.sure.init({
						id           : "cloudfw-box-sure-dummy",
						content      : "'. __('The existing datas maybe lost after importing. <br/><br/> Now, are you sure want to continue?','cloudfw') .'",
						texts        : { sure: "'. __('Yes, I\'m sure','cloudfw') .'" },
						button_color : { sure: \'green\' },
						overlay      : true,
						resume       : function(){

							var modules = jQuery("#'. PFIX .'_dummy_import_modules").val();

							if (modules.length) {
								jQuery("#todolist-import").show().html("");
								process_bar.fadeIn();
								procces_step = 100 / parseInt( modules.length );
								procces_bar_current.val( "0" );
								jQuery(".pbar-in-center > span", process_bar).text("0");
								procces_bar_bar.stop(1).width(66);

								jQuery.each( modules, function(){
									queue.add( this );
								});

							}

						}

					});

				});

				jQuery("#dummy-hide-importer").click(function(){
					cloudfw_global_loading("show");
					queue.pause();
					queue.clear();
					cloudfw_ui_hide_container(
						{
							key: "dummy",
							title: "'. __('Demo content importer has been hidden successfuly.','cloudfw') .'",
							message: "'. __('If you will need it, you can find in System > Demo Contents tab.','cloudfw') .'"
						},
						function(){
							cloudfw_global_loading("hide");
							jQuery("#container-dummy-importer").slideUp();
						}
					);
				});

			'
		),

		## Module Item
		array(
			'type'      =>  'message',
			'fill'      =>  true,
			'color'     =>  'yellow',
			'title'     =>  'Important!',
			'data'      =>  __('<em>DO NOT INSTALL demo contents on your live website</em>. It will corrupt your existing datas. We suggest you <strong>install demo contents only on a clean WordPress setup</strong>. We do not hold any responsibility if you lost existing data.','cloudfw'),
		),

		## Module Item
		array(
			'type'      =>  'html',
			'data'      =>  '
				<div id="process-bar-import" class="pbar hidden">

						<input type="hidden" class="pbar-current-value" value="0" />
						<div class="pbar-bar" style="width:10%;">
							<div class="pbar-in-center"><span class="pbar-value">0</span>%</div>
							<div class="pbar-in-left"></div>
							<div class="pbar-in-right"></div>
						</div>

				</div>

				<ul id="todolist-import" style="margin: 0 -60px; padding: 0 60px; display: none;" class="todolist"></ul>
			'
		),

		## Module Item
		array(
			'type'      =>  'module',
			'title'     =>  __('Import','cloudfw'),
			'data'      =>  array(

				array(
					'type'      =>  'select',
					'id'        =>  PFIX.'_dummy_import_modules',
					'value'     =>  array(
						'pages',
						'posts',
						'portfolios',
						'options',
						//'menus',
						'widgets',
						'skins',
						//'sliders',
					),
					'source'    =>  array(
						'pages'     =>  __('Sample Pages','cloudfw'),
						'posts'     =>  __('Sample Blog Posts','cloudfw'),
						'portfolios'=>  __('Sample Portfolio Posts','cloudfw'),
						'skins'     =>  __('Sample Color Skins','cloudfw'),
						//'sliders'   =>  __('Sample Sliders','cloudfw'),
						'widgets'   =>  __('Sample Widgets','cloudfw'),
						'options'   =>  __('Theme Options','cloudfw'),
						//'menus'     =>  __('Navigation Menu','cloudfw'),
					),
					'multiple'  =>  true,
					//'brackets'    =>  true,
					'height'    =>  120,
					'main_class'=>  'input input_400',
					'ui'        =>  true,

				), // #### element: 0

			)
		)

	);

	$credentials = array(
		'hostname',
		'username',
		'password',
		'public_key',
		'private_key',
		'connection_type',
	);

	$credentials_out = '';
	foreach ( (array) $credentials as $field ) {
		if ( isset( $_POST[ $field ] ) ) {
			$credentials_out .= '<input type="hidden" name="' . esc_attr( $field ) . '" value="' . esc_attr( wp_unslash( $_POST[ $field ] ) ) . '" />';
		}
	}

	$footer = array(

		array(
			'type'      =>  'html',
			'data'      =>
				$credentials_out .
				'
				<div class="divider"></div>
				<div class="module">
					'. _if( $location == 'dashboard',
						'<div style="float:left;">
							<a id="dummy-hide-importer" class="small-button small-grey" href="javascript:;"><span>'. __('Hide the Importer','cloudfw').'</span></a>
						 </div>'
					) .'
					<div style="float:right;">
						<a id="dummy-submit" class="small-button small-red" href="javascript:;"><span>'. __('Import Demo Contents','cloudfw').'</span></a>
					</div>
					<div class="clear cf"></div>
				</div>'
		)

	);


    $url = wp_unslash( $_SERVER['REQUEST_URI'] );
    $GLOBALS['hook_suffix'] = '';
    set_current_screen();

    $extra_fields = array();
    foreach ($_POST as $key => $value) {
        if ( in_array($key, array( 'hostname', 'username', 'password', 'connection_type' )) )
            continue;

        $extra_fields[] = $key;
    }

    ob_start();
    if ( false === ($credentials = request_filesystem_credentials( $url, NULL, false, false, $extra_fields )) ) {
        $connect_form = ob_get_contents();
    }


    if ( empty($connect_form) && ! WP_Filesystem($credentials) ) {
        request_filesystem_credentials( $url, '', true, false, $extra_fields ); //Failed to connect, Error and request again
        $connect_form = ob_get_contents();
    }
	ob_end_clean();


    if ( isset($connect_form) && !empty($connect_form) ) {

		$data = array(
			array(

				'type'      =>  'html',
				'data'      =>  '<div style="margin: 30px 30px 0;">'. $connect_form .'</div>'
			),

		);

		$footer = array();

    }

	return array(
		'type'      =>  'container',
		'id'        =>  'container-dummy-importer',
		'title'     =>  __('One Click Import Demo Contents','cloudfw'),
		'submit_button'
					=>  false,
		'footer'    =>  $footer,
		'data'      =>  $data

	);

}


/**
 *  CloudFw Composer - Make Dropped Area
 *
 *  @since 1.0
 */
function cloudfw_composer_default_dropped_area( $data = NULL ){
	$source_html = '';

	if ( $data ) {

		$source_html .= '<div class="composer-item-bottom">';
		foreach ($data as $item) {

			if ( isset($item['before'] ) && $item['before'] ) {
				$source_html .= $item['before'];
			}

			$source_html .= '<a class="cloudfw-composer-add-item" data-id="'.$item['id'].'" href="javascript:;">';
				$source_html .= '<span>';
					$source_html .= isset($item['title']) ? $item['title'] : NULL;
				$source_html .= '</span>';
			$source_html .= '</a>';

		}

	$source_html .= '</div>';

  }

  return  array(
		'type'      =>  'html',
		'before_html' =>  '<ul class="droppable sub-level row-fluid'._if( empty($source_html), ' droppable-live' ).'">',
		'source'    =>  array(
			'type'    =>  'function',
			'function'  =>  'cloudfw_composer_render_item',
			'vars'    =>  array( true )
		),
		'after_html'  =>  '</ul>' . $source_html
	);
}

/**
 *  Hex to RGB
 *
 *  @since 1.0
 */
function cloudfw_hex2rgb( $hex, $opacity = NULL ) {
	if ( empty( $hex ) || !is_string( $hex ) )
		return false;

	$color = str_replace('#', '', $hex);
	$rgb = array('r'    => hexdec(substr($color,0,2)),
				 'g'    => hexdec(substr($color,2,2)),
				 'b'    => hexdec(substr($color,4,2)));

	if ( $opacity )
		$rgb['o'] = $opacity;

	return $rgb;
}


/**
 *  Formatted Hex to RGB
 *
 *  @since 1.0
 */
function cloudfw_fhex2rgb( $hex, $opacity = NULL ) {
	$rgb = cloudfw_hex2rgb( $hex, $opacity );

	if ( is_array( $rgb ) )
		return implode(', ', $rgb);

	return $rgb;
}

/**
 *	Transfer Options
 */
function cloudfw_merge_option_args( $args ){

	if ( isset( $args['type'] ) ) unset( $args['type'] );
	if ( isset( $args['id'] ) ) unset( $args['id'] );
	if ( isset( $args['value'] ) ) unset( $args['value'] );
	if ( isset( $args['options'] ) ) unset( $args['options'] );
	if ( !empty( $args['merge'] ) ) {
		$args['type'] = $args['merge'];
		unset( $args['merge'] );
	}

	return $args;
}

/**
 *  CloudFw - Get Schemes
 *
 *  @since 1.0
 */
function cloudfw_get_schemes($case = NULL, $cache = true) {
	global $cloudfw_schemes;
	$args = array_slice( func_get_args(), 2 );

	if ( isset( $cloudfw_schemes[$case] ) && $cache )
		return $cloudfw_schemes[$case];

	/** Get Option Sources */
	include_once( TMP_PATH.'/cloudfw/core/framework/source.options.php');

	$scheme = array();

	switch ($case) {

		case 'theme':
			if ( file_exists( TMP_LOADERS . '/theme.schemes.options.php' ) )
				include( TMP_LOADERS . '/theme.schemes.options.php' );

			$scheme = apply_filters('cloudfw_schemes_options', $scheme);

		break;
		case 'skin_map':
			global $skin_datas, $array_text_decorations, $array_bg_style;

			if ( file_exists( TMP_LOADERS . '/theme.schemes.skin.php' ) )
				include( TMP_LOADERS . '/theme.schemes.skin.php' );

			$scheme = apply_filters('cloudfw_schemes_skin', $scheme, $data);

		break;
		case 'font_map':
			if ( file_exists( TMP_LOADERS . '/theme.schemes.font.php' ) )
				include( TMP_LOADERS . '/theme.schemes.font.php' );

			$scheme = apply_filters('cloudfw_schemes_font', $scheme);

		break;
		case 'menu_map':
			$scheme = array();
			if ( file_exists( TMP_LOADERS . '/theme.schemes.menu.php' ) )
				include( TMP_LOADERS . '/theme.schemes.menu.php' );

			$scheme = apply_filters('cloudfw_schemes_menu', $scheme);

		break;
		case 'shortcodes':
			global $CloudFw_Shortcodes;
			$scheme = $CloudFw_Shortcodes->get_scheme();

		break;
		case 'composer':
			global $CloudFw_Shortcodes;
			$scheme = $CloudFw_Shortcodes->get_composer_scheme();

		break;
		case 'slider_management':
			if ( file_exists( CLOUDFW_PATH.'/core/engine.slider/core.schemes.sliders.php' ) )
				include( CLOUDFW_PATH.'/core/engine.slider/core.schemes.sliders.php' );

			$scheme = apply_filters('cloudfw_schemes_slider_management', $scheme);

		break;
		default:

			$scheme = array();
			if ( file_exists( TMP_LOADERS . "/schemes/scheme.{$case}.php" ) )
				include( TMP_LOADERS . "/schemes/scheme.{$case}.php" );
			elseif ( file_exists( CLOUDFW_PATH. "/core/schemes/scheme.{$case}.php" ) )
				include( CLOUDFW_PATH. "/core/schemes/scheme.{$case}.php" );

			$scheme = apply_filters("cloudfw_schemes_{$case}", $scheme);

		break;
	}

	return $cloudfw_schemes[$case] = apply_filters('cloudfw_schemes', $scheme, $case);
}

/**
 *  User can see the framework page
 *
 *  @since 3.0
 */
function cloudfw_user_can_see( $type, $default = 'administrator', $custom_capability = '' ){
	if ( empty( $type ) )
		$author_id =  0;
	elseif ( is_int( $type ) )
		$author_id =  $type;
	else
		$author_id =  cloudfw_get_option('who_can_see', $type);


	if ( $author_id == 0 || !isset($author_id ) || empty($author_id ) ) {
		if (!empty( $custom_capability )) {
			if ( current_user_can( $custom_capability ) )
				return true;
		}
		return current_user_can( $default );

	} else {
	   return $author_id == get_current_user_id();
	}
}

/**
 *  Check is need for update
 *
 *  @since 1.0
 */
function cloudfw_need_update() {
	static $cache_theme_version;

	if ($cache_theme_version)
		return $cache_theme_version;

	global $_opt;

	if (!_check_onoff($_opt[PFIX."_cloudfw_actives"]["autocheck"]) || (!function_exists("is_multisite")) || ( !is_super_admin() && is_multisite() ) )
		return false;

	if ( ( $the_version = get_option(PFIX.'_version') ) ) {

		$_last_checked_version = get_option(PFIX.'_last_checked_version');

		if (version_compare(CLOUDFW_THEMEVERSION /*Now*/, $the_version/*Last Version*/, '<') && $_last_checked_version !== $the_version) {
			$cache_theme_version = $the_version;
			return $the_version;
		}
	}

	return false;
}

/**
 *  Check for update
 *
 *  @since 1.0
 */
function cloudfw_check_update() {
	include_once(TMP_PATH.'/cloudfw/core/classes/class.notifier.php');
	$CloudFw_Notifier = new CloudFw_Notifier( true );
	$result = $CloudFw_Notifier->need_update();

	if ( $result ) {
		delete_option( PFIX . '_last_checked_version' );
		delete_option( CloudFw_Notifier::$changelog_cache_field );
		delete_option( CloudFw_Notifier::$changelog_cache_field_time );

		return $CloudFw_Notifier->latest_version;
	} else
		return false;
}

/**
 *  Upgrade Link
 *
 *  @since 3.0
 */
function cloudfw_upgrade_link( $replace = false ){
	$url = 'update-core.php?action=CloudFw_Theme_Update';
	$url = wp_nonce_url($url, 'upgrade-'.CLOUDFW_THEMEKEY);

	if ( $replace ) {
		$url = htmlspecialchars_decode( $url );
	}

	return $url;
}

/**
 *  Get All Post Types
 *
 *  @since 1.0
 */
function cloudfw_get_all_post_types(){
	if ( cloudfw_vc_isset( __FUNCTION__, 'cache' ) )
		return cloudfw_vc_get( __FUNCTION__, 'cache' );

	$out = array();
	$out = get_post_types();

	unset($out['attachment']);
	unset($out['revision']);
	unset($out['nav_menu_item']);

	$types = array();
	foreach ($out as $key => $value)
		$types[] = $value;

	return cloudfw_vc_set( __FUNCTION__, 'cache', $types );
}