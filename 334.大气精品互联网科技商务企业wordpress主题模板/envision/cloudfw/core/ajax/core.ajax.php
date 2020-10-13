<?php

/**
 *    Register Ajax Function :: Save Changes
 *
 *    @since 1.0
 */
add_action('wp_ajax_nopriv_cloudfw_save_changes', 'cloudfw_ajax_save_changes');
add_action('wp_ajax_cloudfw_save_changes', 'cloudfw_ajax_save_changes');
function cloudfw_ajax_save_changes() {
	cloudfw_check_admin_ajax_permissions( array( 'user_level' => 'edit_posts' ) );

	$form_selector = isset( $_POST['form_selector'] ) ? $_POST['form_selector'] : NULL;
	if ($form_selector !== ""){
		$out = '';

		$_opt = cloudfw_get_all_options();
		cloudfw_form_register($form_selector);
		global $cloudfw_extra_query;

		if ( ! cloudfw_check_message() ) {
			cloudfw_set_message( 1000 );
		}

		if ($cloudfw_extra_query && is_array($cloudfw_extra_query)) {
			$out = '';
			foreach((array) $cloudfw_extra_query as $query_key => $query) {
				$out .= '"'.$query_key.'":	"'.$query.'",';
			}
		}

		cloudfw_ajax_response( cloudfw_get_message(), isset($cloudfw_extra_query) ? $cloudfw_extra_query : NULL );
	}
	exit;
}

/**
 *    Register Ajax Function :: Image Uploader
 *
 *    @since 1.0
 */
add_action('wp_ajax_cloudfw_image_upload', 'cloudfw_ajax_image_upload');
function cloudfw_ajax_image_upload() {

	cloudfw_check_admin_ajax_permissions();

	include_once(TMP_PATH.'/cloudfw/core/classes/class.uploader.php');

    $uploads = wp_upload_dir();
    $upload_url = $uploads['url'].'/';
    $upload_path = $uploads['path'].'/';

    $allowedExtensions = apply_filters('cloudfw_custom_upload_mimes', array('jpg','png','gif','ico', 'svg') );

	$sizeLimit = apply_filters('cloudfw_upload_limit', cloudfw_upload_size());

    $uploader = new qqFileUploader($allowedExtensions, $upload_url, $sizeLimit);
    $result = $uploader->handleUpload( $upload_path );

    if ( isset($_GET['store']) && $_GET['store'] ) {
	    cloudfw_save_to_library(array(
	    	'title'			=> '',
	    	'filename'		=> $result['fileRelpath'],
	    ));
    }

    echo htmlspecialchars(json_encode($result), ENT_NOQUOTES);
    exit;
}


/**
 *    Register Ajax Function :: Get Slider Content Forms
 *
 *    @since 1.0
 */
add_action( 'wp_ajax_cloudfw_get_slider_content_forms', 'cloudfw_ajax_get_slider_content_forms' );
function cloudfw_ajax_get_slider_content_forms() {

	cloudfw_check_admin_ajax_permissions();
	require( TMP_PATH.'/cloudfw/core/ajax/ajax.slider.get_content_forms.php' );
	exit;
}


/**
 *    Register Ajax Function :: Copy Slider Item
 *
 *    @since 1.0
 */
add_action('wp_ajax_cloudfw_copy_slider_item', 'cloudfw_ajax_copy_slider_item');
function cloudfw_ajax_copy_slider_item() {

	cloudfw_check_admin_ajax_permissions( array( 'user_level' => 'edit_posts' ) );

	$item_id = $_POST['item_id'];
	$slider_id = $_POST['slider_id'];

	$slider_data = cloudfw_get_slider( $slider_id );
	$slider_type = cloudfw_get_slider_type( $slider_id );
	$out = $slider_data[ $item_id ];

	if ( is_array($out) ) {
		$out = array_merge((array)$out, array( '__key' => CLOUDFW_THEMEKEY, '__type' => $slider_type ));
		$serialized_data 	= @serialize($out);
		$encode_data 		= @base64_encode($serialized_data);
		$message 			= 3107; // success
		$results = array(
			'data'	=> $encode_data
		);

	} else {
		cloudfw_ajax_response( 3108 );
	}

	cloudfw_ajax_response( $message, $results );
	exit;
}

/**
 *    Register Ajax Function :: Paste Slider Item
 *
 *    @since 1.0
 */
add_action('wp_ajax_cloudfw_paste_slider_item', 'cloudfw_ajax_paste_slider_item');
function cloudfw_ajax_paste_slider_item() {

	cloudfw_check_admin_ajax_permissions( array( 'user_level' => 'edit_posts' ) );
	$import        = isset($_POST['data']) ? $_POST['data'] : NULL;
	$slider_id     = isset($_POST['slider_id']) ? $_POST['slider_id'] : NULL;
	$mode          = isset($_POST['mode']) ? $_POST['mode'] : NULL;
	$lastID        = isset($_POST["lastID"]) ? $_POST["lastID"] : NULL;
	$this_page     = isset($_POST["thispage"]) ? $_POST["thispage"] : NULL;
	$raw_this_page = isset($_POST["raw_thispage"]) ? $_POST["raw_thispage"] : NULL;

	$slider_data = cloudfw_get_slider( $slider_id );
	$slider_type = cloudfw_get_slider_type( $slider_id );

	$decode_import = @base64_decode($import);
	$unserialized_import = @unserialize($decode_import);
	$data = $unserialized_import;

	if( $data['__key'] !== CLOUDFW_THEMEKEY ) {
		cloudfw_ajax_response( 3110 ); // not compatible
	}

	if( $data['__type'] !== $slider_type ) {
		cloudfw_ajax_response( 3110 ); // not compatible with slider type
	}

	unset($data['__key']);
	unset($data['__type']);

	if( !empty( $data ) ) {
		/* Load Slider CloudFw API */
		require (TMP_PATH.'/cloudfw/core/engine.slider/core.slider.include_forms.php');

		@ksort($slider_data);
		$slider_data[] = $data;

		if ( $mode == 'edit' ) {
			cloudfw_sub_slider_forms( $this_page, $raw_this_page ,$lastID, $data, '', $slider_id);
		} else {
			update_option($slider_id, $slider_data);
			cloudfw_loop_slider_items($slider_data, $slider_type, $slider_id);
		}

	} else {
		cloudfw_ajax_response( 3110 ); // not compatible
	}

	exit;
}

/**
 *    Register Ajax Function :: Sorting Skins
 *
 *    @since 3.0
 */
add_action( 'wp_ajax_cloudfw_sort_main_sliders', 'cloudfw_ajax_sort_main_sliders' );
function cloudfw_ajax_sort_main_sliders() {
	cloudfw_check_admin_ajax_permissions( array( 'user_level' => 'edit_posts' ) );

	$sorting_ids = $_POST['slider_sorting'];
	$slider_ids = get_option(PFIX.'_slider_ids');
	$sorted_ids = cloudfw_array_sort_by_array( $slider_ids, $sorting_ids );

	if ( is_array($sorted_ids) && !empty($sorted_ids) ) {
		update_option(PFIX.'_slider_ids', $sorted_ids);

		cloudfw_ajax_response( 6008 );
	} else
		cloudfw_ajax_response( 9022 );

	die(1);
}



/**
 *    Register Ajax Function :: Sorting Skins
 *
 *    @since 3.0
 */
add_action( 'wp_ajax_cloudfw_sort_skins', 'cloudfw_ajax_sort_skins' );
function cloudfw_ajax_sort_skins() {

	cloudfw_check_admin_ajax_permissions( array( 'user_level' => 'edit_posts' ) );

	$sorting_ids = $_POST['skin_sorting'];
	$skin_ids = get_option(PFIX.'_skin_ids');
	$sorted_ids = cloudfw_array_sort_by_array($sorting_ids, $skin_ids );

	if ( is_array($sorted_ids) && !empty($sorted_ids) ) {
		$sorted_ids = array_reverse($sorted_ids);
		update_option(PFIX.'_skin_ids', $sorted_ids);

		cloudfw_ajax_response( 7012 );
	} else
		cloudfw_ajax_response( 9022 );

	die(1);
}

/**
 *    Register Ajax Function :: Get Last Theme Updates
 *
 *    @since 1.0
 */
add_action( 'wp_ajax_cloudfw_last_theme_updates', 'cloudfw_ajax_last_theme_updates' );
function cloudfw_ajax_last_theme_updates() {

	cloudfw_check_admin_ajax_permissions( array( 'user_level' => 'edit_posts' ) );
	require( TMP_PATH.'/cloudfw/core/ajax/ajax.other.last_theme_updates.php' );
	exit;
}

/**
 *    Register Ajax Function :: Hide Container
 *
 *    @since 3.0
 */
add_action( 'wp_ajax_cloudfw_hide_container', 'cloudfw_ajax_hide_container' );
function cloudfw_ajax_hide_container() {

	cloudfw_check_admin_ajax_permissions( array( 'user_level' => 'edit_posts' ) );

	$key 		= $_POST['key'];
	$title 		= $_POST['title'] ? $_POST['title'] : __('Container hide succesfuly.','cloudfw');
	$message 	= $_POST['message'];
	if ( $key ) {
		cloudfw_update_option( array(PFIX.'_cloudfw_actives' => array($key => 'FALSE') ) );
		cloudfw_ajax_response(0, array(
			'messageTitle'	=> $title,
			'messageText'	=> $message,
			'messageCase'	=> 'ok'
		));
	}
	else
		cloudfw_ajax_response(0, array(
			'messageTitle'	=> __('An error has been occurred.','cloudfw'),
			'messageCase'	=> 'cancel'
		));

	die(1);
}

/**
 *    Register Ajax Function :: Configuration Wizard
 *
 *    @since 1.0
 */
add_action( 'wp_ajax_cloudfw_conf_wizard', 'cloudfw_ajax_cloudfw_conf_wizard' );
function cloudfw_ajax_cloudfw_conf_wizard() {

	cloudfw_check_admin_ajax_permissions( array( 'user_level' => 'edit_posts' ) );
	require( TMP_PATH.'/cloudfw/core/ajax/ajax.conf_wizard.php' );
	exit;
}

/**
 *    Register Ajax Function :: Get Icons in Library
 *
 *    @since 1.0
 */
add_action( 'wp_ajax_cloudfw_get_library_icons', 'cloudfw_ajax_get_library_icons' );
function cloudfw_ajax_get_library_icons() {

	cloudfw_check_admin_ajax_permissions( array( 'user_level' => 'edit_posts' ) );

	$icons = array();
	if ( function_exists('cloudfw_get_icons') ) {
		$icons = cloudfw_get_icons();
	}

	$show_not_found = false;
	if ( is_array($icons) && !empty($icons) ) {

		$data = array();
		$data['icon'] = isset($_REQUEST['icon']) ? $_REQUEST['icon'] : NULL;
		$data['icon_categories'] = array();
		$data['icon_categories']['NULL'] = __('- Select icon set -','cloudfw');

		$data['icon_list'] = array();
		if ( !empty( $icons ) &&  is_array( $icons ) ) {
			foreach ($icons as $folder_name => $set_icons) {

				$sanitez_set_id = cloudfw_sanitize($folder_name);

				$data['icon_categories'][ 'icon-set-' . $sanitez_set_id ] = $folder_name;
				$data['icon_list'][ $sanitez_set_id ] = array();

				foreach ( (array) $set_icons as $icon_url => $icon_name ) {

					$item = array(
						'item_value' => $icon_url,
						'item_html' => '
							<div class="icon_selector_item">
								<div class="icon_selector_image">' . cloudfw_make_icon( $icon_url ) . '</div>
								<div class="icon_selector_name">' . $icon_name . '</div>
							</div>',
					);

					$data['icon_list'][ $sanitez_set_id ][] = $item;
				}
			}
		}

		require_once(TMP_PATH.'/cloudfw/core/engine.render/core.render.php');
		require_once(TMP_PATH.'/cloudfw/core/engine.shortcode/core.shortcodes.php');

        $map = cloudfw_get_schemes('icon_library', true, $data);
		cloudfw_render_page( $map );

	} else {
		$show_not_found = true;
	}

	echo '<div class="cloudfw-ui-not-found-text" '._if( !$show_not_found, 'style="display:none;"' ).'>'.__('We couldn\'t found any result.','cloudfw').'</div>';
	exit;
}


/**
 *    Register Ajax Function :: Get Awesome Font Icons
 *
 *    @since 1.0
 */
add_action( 'wp_ajax_cloudfw_get_font_icons', 'cloudfw_ajax_get_font_icons' );
function cloudfw_ajax_get_font_icons() {

	cloudfw_check_admin_ajax_permissions( array( 'user_level' => 'edit_posts' ) );

	$icons = array();
	if ( function_exists('cloudfw_font_icons_list') ) {
		$icons = cloudfw_font_icons_list();
	}

	$show_not_found = false;
	if ( is_array($icons) && !empty($icons) ) {

		$data = array();

		$data['allow_customization'] = isset($_REQUEST['allow_customization']) && $_REQUEST['allow_customization'] == 'true' ? true : false;
		$data['icon'] = isset($_REQUEST['icon']) ? $_REQUEST['icon'] : NULL;
		$data['size'] = isset($_REQUEST['size']) ? $_REQUEST['size'] : NULL;
		$data['color'] = isset($_REQUEST['color']) ? $_REQUEST['color'] : NULL;
		$data['background'] = isset($_REQUEST['background']) ? $_REQUEST['background'] : NULL;
		$data['border_color'] = isset($_REQUEST['border_color']) ? $_REQUEST['border_color'] : NULL;
		$data['border_width'] = isset($_REQUEST['border_width']) ? $_REQUEST['border_width'] : NULL;
		$data['border_radius'] = isset($_REQUEST['border_radius']) ? $_REQUEST['border_radius'] : NULL;

		$data['icon_list'] = array();
		if ( !empty( $icons ) &&  is_array( $icons ) ) {
			foreach ($icons as $class => $title) {
				$item = array(
					'item_value' => $class,
					'item_html' => '
						<div style="text-align:center;">
							<div style="margin: 20px 0;">' . cloudfw_make_icon( $class . '||size:24px||color:333' ) . '</div>
							' . $title . '
						</div>',
				);
				$data['icon_list'][] = $item;
			}
		}


		require_once(TMP_PATH.'/cloudfw/core/engine.render/core.render.php');
		require_once(TMP_PATH.'/cloudfw/core/engine.shortcode/core.shortcodes.php');

        $map = cloudfw_get_schemes('fontawesome', true, $data);
		cloudfw_render_page( $map );

	} else {
		$show_not_found = true;
	}

	echo '<div class="cloudfw-ui-not-found-text" '._if( !$show_not_found, 'style="display:none;"' ).'>'.__('We couldn\'t found any result.','cloudfw').'</div>';
	exit;
}


/**
 *    Register Ajax Function :: Call Shortcode Section
 *
 *    @since 1.0
 */
add_action( 'wp_ajax_cloudfw_call_shortcode_section', 'cloudfw_ajax_call_shortcode_section' );
function cloudfw_ajax_call_shortcode_section() {

	cloudfw_check_admin_ajax_permissions( array( 'user_level' => 'edit_posts' ) );
 	require_once(TMP_PATH.'/cloudfw/core/engine.render/core.render.php');
 	require_once(TMP_PATH.'/cloudfw/core/engine.shortcode/core.shortcodes.php');

	$parent = $_REQUEST['parent'];
	$section = $_REQUEST['section'];

	if ( !isset($section) ) {
		echo 'Please section';
	}

 	$shortcode_map  = cloudfw_get_schemes('shortcodes');

 	//$section_scheme = $section_scheme[$parent]['data'];
 	if ( $parent )
 		$section_scheme = $shortcode_map[$parent]['data'][$section];
 	else
 		$section_scheme = $shortcode_map[$section];


 	if ( !empty( $section_scheme ) )
		cloudfw_render_page( $section_scheme["data"] );


	exit;
}

/**
 *    Register Ajax Function :: Save Changes
 *
 *    @since 1.0
 */
add_action('wp_ajax_nopriv_cloudfw_save_composer', 'cloudfw_ajax_save_composer');
add_action('wp_ajax_cloudfw_save_composer', 'cloudfw_ajax_save_composer');
function cloudfw_ajax_save_composer() {

	cloudfw_check_admin_ajax_permissions( array( 'user_level' => 'edit_posts' ) );

	$post_id = $_POST['post_id'];
	cloudfw_composer_save_callback( $post_id );

	global $cloudfw_extra_query;
	if ( ! cloudfw_check_message() )
		cloudfw_set_message( 1000 );

	cloudfw_ajax_response( cloudfw_get_message(), $cloudfw_extra_query );
	exit;
}

/**
 *    Register Ajax Function :: Copy Composer
 *
 *    @since 1.0
 */
add_action('wp_ajax_cloudfw_copy_composer', 'cloudfw_ajax_copy_composer');
function cloudfw_ajax_copy_composer() {

	cloudfw_check_admin_ajax_permissions( array( 'user_level' => 'edit_posts' ) );

	$out = cloudfw_copy_composer_data();

	if ( is_array($out) ) {
		$out = array_merge((array)$out, array( '__key' => CLOUDFW_THEMEKEY ));
		$serialized_data 	= @serialize($out);
		$encode_data 		= @base64_encode($serialized_data);
		$message 			= 3107; // success
		$results = array(
			'data'	=> $encode_data
		);

	} else {
		cloudfw_ajax_response( 3108 );
	}

	cloudfw_ajax_response( $message, $results );
	exit;
}

/**
 *    Register Ajax Function :: Paste Composer
 *
 *    @since 1.0
 */
add_action('wp_ajax_cloudfw_paste_composer', 'cloudfw_ajax_paste_composer');
function cloudfw_ajax_paste_composer() {

	cloudfw_check_admin_ajax_permissions( array( 'user_level' => 'edit_posts' ) );
	$import = $_REQUEST['data'];

	$decode_import = @base64_decode($import);
	$unserialized_import = @unserialize($decode_import);
	$data = $unserialized_import;

	if( $unserialized_import['__key'] !== CLOUDFW_THEMEKEY )
		cloudfw_ajax_response( 3110 ); // not compatible

	require_once(TMP_PATH.'/cloudfw/core/engine.render/core.render.php');

	if( !empty( $data ) ) {
		ob_start();	cloudfw_composer_render_item( false, $data );
		$out = ob_get_contents(); ob_end_clean();

		if ( !empty($out) )
			echo $out;
		else
			cloudfw_ajax_response( 3111 ); //empty

	} else {
		cloudfw_ajax_response( 3110 ); // not compatible
	}

	exit;
}

/**
 *    Register Ajax Function :: Call Composer Element
 *
 *    @since 1.0
 */
add_action( 'wp_ajax_cloudfw_call_composer_element', 'cloudfw_ajax_call_composer_element' );
function cloudfw_ajax_call_composer_element() {

	cloudfw_check_admin_ajax_permissions( array( 'user_level' => 'edit_posts' ) );
 	require_once(TMP_PATH.'/cloudfw/core/engine.render/core.render.php');
 	require_once(TMP_PATH.'/cloudfw/core/engine.shortcode/core.shortcodes.php');
 	//require_once(TMP_PATH.'/cloudfw/core/engine.composer/core.composer.php');

	$type = $_REQUEST['type'];
 	cloudfw_composer_get_source( $type, true );
	exit;
}

/**
 *    Register Ajax Function :: Composer Template Save Form
 *
 *    @since 1.0
 */
add_action( 'wp_ajax_cloudfw_get_composer_prebuilt_templates', 'cloudfw_ajax_get_composer_prebuilt_templates' );
function cloudfw_ajax_get_composer_prebuilt_templates() {

	cloudfw_check_admin_ajax_permissions( array( 'user_level' => 'edit_posts' ) );

	$templates = array();
	foreach ( (array) glob(PREPAGES_DIR_PATH.'*') as $file ) {

		$filename = basename( $file );
		$title = str_replace('.txt', '', $filename);
		$title = str_replace('-', ' ', $title);

		$templates[ $filename ] = $title;
	}

	asort($templates);


	if ( is_array($templates) && !empty($templates) ) {

		echo '<ul id="cloudfw-composer-templates" class="cloudfw-ui-list mini no-preview">';
		foreach ((array)$templates as $template_id => $template_name ) {

			$template_name = preg_replace('/^\(\d+\)/', '', $template_name);
			$template_name = ucwords( $template_name );
			$template_name = trim( $template_name );

			if ( strlen($template_name) > 50 ) {
				$template_name = mb_substr( $template_name, 0, 50 ) . '..';
			}

			echo '
			<li>
				<div class="inset overflow-hidden">

				<div class="cont">
					<a href="javascript:;" class="use" rel="'.$template_id.'">
						<span class="title">'.$template_name.'</span>
					</a>
					<div class="mini-buttons">
						<a href="javascript:;" class="use" rel="'.$template_id.'">'.__('Import','cloudfw').'</a>
					</div>
				</div>


				<div class="item-action" style="width:75px;">
					<div class="action-divider"></div>
					<div class="mini-action-icons horizontal item-2">
						<a href="javascript:;" class="use cloudfw-tooltip" title="'. __('import','cloudfw') .'"  rel="'.$template_id.'"></a>
					</div>
				</div>

				<div class="clear"></div>

				</div>

			</li>';

		 }
		echo '</ul><div class="clear"></div>';

	} else {
		echo cloudfw_notfound( __('There is no any composer template.','cloudfw') );
	}

	exit;
}

/**
 *    Register Ajax Function :: Composer Template Save Form
 *
 *    @since 1.0
 */
add_action( 'wp_ajax_cloudfw_get_composer_templates', 'cloudfw_ajax_get_composer_templates' );
function cloudfw_ajax_get_composer_templates() {

	cloudfw_check_admin_ajax_permissions( array( 'user_level' => 'edit_posts' ) );

	$templates = cloudfw_composer_template_all();

	if ( is_array($templates) && !empty($templates) ) {

		echo '<ul id="cloudfw-composer-templates" class="cloudfw-ui-list mini no-preview">';
		foreach ((array)$templates as $template_id => $template ) {

		 	$template_data = cloudfw_composer_template( $template_id );


					if ( strlen($template['name']) > 50 ) {
						$template['name'] = mb_substr( $template['name'], 0, 50 ) . '..';
					}

					echo '
					<li>
						<div class="inset overflow-hidden">

						<div class="cont">
							<a href="javascript:;" class="use" rel="'.$template_id.'">
								<span class="title">'.$template['name'].'</span>
							</a>
							<div class="mini-buttons">
								<a href="javascript:;" class="use" rel="'.$template_id.'">'.__('Import','cloudfw').'</a>
							</div>
						</div>


						<div class="item-action" style="width:105px;">
							<div class="action-divider"></div>
							<div class="mini-action-icons horizontal item-2">
								<a href="javascript:;" class="use cloudfw-tooltip" title="'. __('import','cloudfw') .'"  rel="'.$template_id.'"></a>
								<a href="javascript:;" class="remove cloudfw-tooltip" title="'. __('remove','cloudfw') .'" rel="'.$template_id.'"></a>
							</div>
						</div>

						<div class="clear"></div>

						</div>

					</li>';

		 }
		echo '</ul><div class="clear"></div>';

	} else {
		echo cloudfw_notfound( __('There is no any composer template.','cloudfw') );
	}

	exit;
}

/**
 *    Register Ajax Function :: Composer Template Save Form
 *
 *    @since 1.0
 */
add_action( 'wp_ajax_cloudfw_save_composer_template_form', 'cloudfw_ajax_save_composer_template_form' );
function cloudfw_ajax_save_composer_template_form() {

	cloudfw_check_admin_ajax_permissions( array( 'user_level' => 'edit_posts' ) );
	require( TMP_PATH.'/cloudfw/core/engine.composer/render.composer.save_form.php' );
	exit;
}

/**
 *    Register Ajax Function :: Composer Template Save
 *
 *    @since 1.0
 */
add_action( 'wp_ajax_cloudfw_save_composer_template', 'cloudfw_ajax_save_composer_template' );
function cloudfw_ajax_save_composer_template() {

	cloudfw_check_admin_ajax_permissions( array( 'user_level' => 'edit_posts' ) );

	$message_type = isset($_REQUEST['message_type']) ? $_REQUEST['message_type'] : 'standard';
	$type = isset($_REQUEST['type']) ? $_REQUEST['type'] : NULL;
	$id = isset($_REQUEST['template_id']) ? $_REQUEST['template_id'] : NULL;
	$post_id = isset($_REQUEST['post_id']) ? $_REQUEST['post_id'] : NULL;
	$template_name =isset($_REQUEST['template_name']) ? $_REQUEST['template_name'] : NULL;

	if ( empty( $post_id ) && !is_numeric( $post_id ) ) {
		cloudfw_ajax_response( 3102 );
	}

	if ( empty( $template_name ) ) {
		$template_name = get_the_title( $post_id );
		//cloudfw_ajax_response( 3103 );
	}

	$data = cloudfw_composer_get_data( $post_id );

	if ( empty($id) ) { // Add new
		if ( empty($data) || !is_array($data) ) {
			cloudfw_ajax_response( 3104 );
		}

		if ( $type == 'prepage' ) {

			if ( defined('CLOUDFW_LOCALE_URL') && defined('CLOUDFW_REMOTE_URL') ) {
				$data = cloudfw_array_replace( CLOUDFW_LOCALE_URL, CLOUDFW_REMOTE_URL, $data );
			}

			$result = cloudfw_composer_template_manager( 'export', array( 'name' => $template_name ), $data );

			if ( $result ) {
				if ( $message_type == 'standard' ) {
					cloudfw_ajax_response( 3101 );
					
				} else {

					$message = array(
						'messageTitle' => sprintf(__('<strong>%s</strong> Exported','cloudfw'), $template_name),
					);
					cloudfw_ajax_response( 3101, $message );
				}
			}

		} else {
			$template_id = cloudfw_composer_template_manager( 'add', array( 'name' => $template_name ), $data );
		}

		if ( $template_id ) {
			cloudfw_ajax_response( 3101 );
		}

	}


	exit;
}

/**
 *    Register Ajax Function :: Composer Template Actions
 *
 *    @since 1.0
 */
add_action( 'wp_ajax_cloudfw_composer_template_actions', 'cloudfw_ajax_composer_template_actions' );
function cloudfw_ajax_composer_template_actions() {

	cloudfw_check_admin_ajax_permissions( array( 'user_level' => 'edit_posts' ) );

	$id = $_REQUEST['template_id'];
	$post_id = $_REQUEST['post_id'];
	$type = $_REQUEST['type'];

	switch ($type) {
		case 'import':
			require_once(TMP_PATH.'/cloudfw/core/engine.render/core.render.php');
			$composer_data = cloudfw_composer_template( $id );

 			if( !empty( $composer_data ) ) {
 				echo cloudfw_composer_render_item( false, $composer_data );
 			} else {
				cloudfw_ajax_response( 3105 );
 			}

			break;
		case 'import-prepage':

			require_once(TMP_PATH.'/cloudfw/core/engine.render/core.render.php');
			$composer_data = cloudfw_composer_template( $id );

			$composer_data = '';

			if ( file_exists( trailingslashit( PREPAGES_DIR_PATH ) . $id ) ) {
				$file_data = cloudfw_get_file_contents( trailingslashit( PREPAGES_DIR_PATH ) . $id );
				$composer_data 	= json_decode( $file_data, true );
			}

 			if( !empty( $composer_data ) ) {
 				echo cloudfw_composer_render_item( false, $composer_data );
 			} else {
				cloudfw_ajax_response( 3105 );
 			}

			break;
		case 'delete':
			cloudfw_composer_template_manager( 'delete', array( 'id' => $id ) );
			cloudfw_ajax_response( 3106 );

			break;
	}


	exit;
}


/**
 *    Register Ajax Function :: Preview Shortcodes
 *
 *    @since 1.0
 */
add_action( 'wp_ajax_cloudfw_shortcode_preview', 'cloudfw_ajax_cloudfw_shortcode_preview' );
function cloudfw_ajax_cloudfw_shortcode_preview() {

	cloudfw_check_admin_ajax_permissions( array( 'user_level' => 'edit_posts' ) );
	if ( file_exists( TMP_LOADERS . '/theme.shortcodes.preview.php' ) )
		include_once( TMP_LOADERS . '/theme.shortcodes.preview.php' );
	die(1);
}

/**
 *    Register Ajax Function :: Loader for Shortcode Generator
 *
 *    @since 3.0
 */
add_action( 'wp_ajax_cloudfw_load_shortcode_generator', 'cloudfw_ajax_cloudfw_load_shortcode_generator' );
function cloudfw_ajax_cloudfw_load_shortcode_generator() {

	cloudfw_check_admin_ajax_permissions( array( 'user_level' => 'edit_posts' ) );
	if ( file_exists( TMP_PATH.'/cloudfw/core/engine.shortcode/core.shortcodes.render.php' ) )
		include_once( TMP_PATH.'/cloudfw/core/engine.shortcode/core.shortcodes.render.php' );
	die(1);
}

/**
 *    Register Ajax Function :: Loader for Shortcode Generator dynamically
 *
 *    @since 3.0
 */
add_action( 'wp_ajax_cloudfw_load_dynamic_shortcode_generator', 'cloudfw_ajax_cloudfw_load_dynamic_shortcode_generator' );
function cloudfw_ajax_cloudfw_load_dynamic_shortcode_generator() {

	cloudfw_check_admin_ajax_permissions( array( 'user_level' => 'edit_posts' ) );
	if ( file_exists( TMP_PATH.'/cloudfw/core/engine.shortcode/core.shortcodes.dynamic.render.php' ) )
		include_once( TMP_PATH.'/cloudfw/core/engine.shortcode/core.shortcodes.dynamic.render.php' );
	die(1);
}

/**
 *    Register Ajax Function :: Get Posts for Selector
 *
 *    @since 3.0
 */
add_action( 'wp_ajax_cloudfw_post_list_for_selector', 'cloudfw_ajax_post_list_for_selector' );
function cloudfw_ajax_post_list_for_selector() {

	cloudfw_check_admin_ajax_permissions( array( 'user_level' => 'edit_posts' ) );
	if ( file_exists( TMP_PATH.'/cloudfw/core/others/render.page_selector.php' ) )
		include_once( TMP_PATH.'/cloudfw/core/others/render.page_selector.php' );
	die(1);
}

/**
 *    Register Ajax Function :: Import Dummy Contents
 *
 *    @since 3.0
 */
add_action( 'wp_ajax_cloudfw_import_dummies', 'cloudfw_ajax_import_dummies' );
function cloudfw_ajax_import_dummies() {
	cloudfw_check_admin_ajax_permissions( array( 'user_level' => 'administrator' ) );
 	require_once(TMP_PATH.'/cloudfw/core/engine.dummy/core.dummy.php');

	$importer = new CloudFw_Import_Dummy();
	$importer->import();

	die(1);
}

/**
 *    Register Ajax Function :: Import Dummy Contents
 *
 *    @since 3.0
 */
add_action( 'wp_ajax_cloudfw_export_dummies', 'cloudfw_ajax_export_dummies' );
function cloudfw_ajax_export_dummies() {

	cloudfw_check_admin_ajax_permissions( array( 'user_level' => 'administrator' ) );
 	require_once(TMP_PATH.'/cloudfw/core/engine.dummy/core.dummy.php');

	$importer = new CloudFw_Export_Dummy();
	$importer->export();

	die(1);
}

/**
 *    Register Ajax Function :: Import Dummy Contents
 *
 *    @since 3.0
 */
add_action( 'wp_ajax_cloudfw_check_update', 'cloudfw_ajax_check_update' );
function cloudfw_ajax_check_update() {
	$version = cloudfw_check_update();

	if ( $version !== false ) {

		static $cache_theme_version;
		unset($cache_theme_version);

		cloudfw_need_update();
		$out = array(
			'need' => true,
			'version' => $version
		);

	} else {

		$out = array(
			'need' => false,
		);

	}

	cloudfw_ajax_make_json( $out );

	die(1);
}

/**
 *    Register Ajax Function :: Import Dummy Contents
 *
 *    @since 3.0
 */
add_action( 'wp_ajax_cloudfw_refresh_menus', 'cloudfw_ajax_refresh_menu' );
function cloudfw_ajax_refresh_menu() {
	require_once ABSPATH . 'wp-admin/includes/nav-menu.php';
	$result = wp_get_nav_menu_to_edit( $_REQUEST['menu_id'] );
	if ( is_wp_error($result) )
		echo $result->get_error_message();
	else
		echo $result;
	die(1);
}

/**
 *    Register Ajax Function :: Resize Image
 *
 *    @since 3.0
 */
add_action( 'wp_ajax_cloudfw_resize_image', 'cloudfw_ajax_resize_image' );
function cloudfw_ajax_resize_image() {

	cloudfw_check_admin_ajax_permissions( array( 'user_level' => false ) );

	$url = isset($_REQUEST['url']) ? $_REQUEST['url'] : NULL;
	$width = isset($_REQUEST['width']) ? $_REQUEST['width'] : 300;
	$height = isset($_REQUEST['height']) ? $_REQUEST['height'] : NULL;

	$resized_url = cloudfw_thumbnail(array('src'=> $url,'w'=> $width,'h'=> $height ));

	$out = array(
		'success' => true,
		'url'     => $resized_url,
	);

	cloudfw_ajax_make_json( $out );
	exit;
}
