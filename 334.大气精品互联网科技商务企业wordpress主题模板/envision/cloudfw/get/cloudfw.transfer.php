<?php

if ( !is_user_logged_in() || !current_user_can('administrator') )
	wp_die(__("You are not allowed to be here","cloudfw"));


$nonce = $_REQUEST['nonce'];
if ( ! wp_verify_nonce($nonce, 'cloudfw') ) {
	wp_die(__("Invalid Nonce", "cloudfw"));
}


$case = $_GET["case"];
if ( !isset($_REQUEST['comeback']) || !$_REQUEST['comeback'] )
	$_REQUEST['comeback'] = $_SERVER['HTTP_REFERER'];

@error_reporting( 0 );

/** Include Export Class */
require_once (TMP_PATH.'/cloudfw/core/classes/class.export.php');

switch ($case){
	case 'export-all-options':
	default:

		$export = new CloudFw_Export();

		$export->filename('options.backup', true);
		$export->case = 'options';
		$export->key = CLOUDFW_THEMEKEY;
		$export->server = TMP_URL;
		$export->set_data( cloudfw_exclude_options( cloudfw_get_all_options( NULL, FALSE ) ) );

		$export->prepare('normal')->download();


	break;
	case 'export-skins':

		$ids = isset($_REQUEST["ids"]) ? $_REQUEST["ids"] : NULL;

		if( !isset($ids) || !$ids ) {
			wp_die( __('Please select a skin to export','cloudfw'), __('Error','cloudfw') );
		}

		$export = new CloudFw_Export();

		if ( $the_content = cloudfw_get_a_skin($ids) ) {
			$the_content['foldername'] = sanitize_file_name($the_content["name"]);
			$the_content['data']['custom']['foldername'] = sanitize_file_name(!empty($the_content['data']['custom']["foldername"]) ? $the_content['data']['custom']["foldername"] : $the_content["name"]);
			$the_content = apply_filters( 'cloudfw_export_skin_data', $the_content );

			$all_contents[ $ids ] = $the_content;
		}

		if ( !isset($all_contents) || !$all_contents ) {
			wp_redirect(($_REQUEST['comeback'].'&m=9013'));
		}

		$export->filename( 'Skin-' . $the_content["name"] . '.zip', true);
		$export->name = 'Skin-' . $the_content["name"] . '.skin';
		$export->case = 'skin';
		$export->key = CLOUDFW_THEMEKEY;
		$export->server = TMP_URL;
		$export->set_data( $all_contents );
		$export->prepare('zip');
		$export->zip();
		$export->download();


	break;

	case 'export-sliders':
		$ids = isset($_REQUEST["ids"]) ? $_REQUEST["ids"] : NULL;

		if( !isset($ids) || !$ids ) {
			wp_die( __('Please select a slider to export','cloudfw'), __('Error','cloudfw') );
		}

		$export = new CloudFw_Export();
		$sliders = get_option(PFIX.'_slider_ids');


		if ( isset($sliders[$ids]) && $sliders[$ids] ) {
			$sliders[$ids]['foldername'] = sanitize_file_name($sliders[$ids]["foldername"] ? $sliders[$ids]["foldername"] : $sliders[$ids]["title"]);
			$all_contents[$ids] = array(
				'main'	=> $sliders[$ids],
				'data'	=> get_option($ids)
			);
		}

		if ( !isset($all_contents) || !$all_contents )
			wp_redirect(($_REQUEST['comeback'].'&m=9013'));

		$export->filename( 'Slider-' . $sliders[$ids]["title"] . '.zip', true);
		$export->name = 'Slider-' . $sliders[$ids]["title"] . '.slider';
		$export->case = 'slider';
		$export->key = CLOUDFW_THEMEKEY;
		$export->server = TMP_URL;
		$export->set_data( $all_contents );

		$export->prepare('zip')->zip()->download();

	break;
}