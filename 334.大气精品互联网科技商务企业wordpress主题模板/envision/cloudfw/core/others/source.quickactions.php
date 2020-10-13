<?php 

/*-----------------------------------------------------------------------------------*/
/*	Reset Theme
/*-----------------------------------------------------------------------------------*/

if (isset($_GET['reset'])) {
	$nonce = $_GET["nonce"];
	check_admin_referer();
	
	if (wp_create_nonce('cloudfw') == $nonce) {

	cloudfw_reset_options();
	wp_redirect(admin_url(CLOUDFW_PAGE.'&m=9000'));
	
	}
}

/*-----------------------------------------------------------------------------------*/
/*	Duplicate Skin
/*-----------------------------------------------------------------------------------*/

if (isset($_GET['duplicateSkin'])) {
	$data = array();
	$id = $_GET["id"];
	$data['name'] = $_GET["skin_duplicate_name"];
	cloudfw_skin_manager( $id, 'duplicate', $data );
	wp_redirect(admin_url(CLOUDFW_PAGE.'&tab=visual&jump=0&m=7006'));		
}

/*-----------------------------------------------------------------------------------*/
/*	Delete Skin
/*-----------------------------------------------------------------------------------*/

if (isset($_GET['deleteSkin'])) {
	$id = $_GET["id"];
	cloudfw_skin_manager($id,'delete');
	wp_redirect(admin_url(CLOUDFW_PAGE.'&tab=visual&jump=0&m=7003'));
}

/*-----------------------------------------------------------------------------------*/
/*	Duplicate Slider
/*-----------------------------------------------------------------------------------*/

if (isset($_GET['duplicateSlider'])) {
	$data = array();
	$id = $_GET["id"];
	cloudfw_duplicate_slider($id);
	wp_redirect(admin_url(CLOUDFW_PAGE.'&m=6006'));		
}