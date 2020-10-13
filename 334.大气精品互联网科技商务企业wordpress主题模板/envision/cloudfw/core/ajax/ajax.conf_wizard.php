<?php

global $_opt;
	
$id = $_REQUEST["id"];
$operation = $_REQUEST["op"];

if (empty($id))
	exit('An Error Has Occurred');

	$_opt = cloudfw_get_all_options(NULL, array(PFIX.'_setup_status'), TRUE);


		
	$_setup_status = $_opt[PFIX."_setup_status"];

	if (empty($_setup_status))
		$_setup_status = array();
	
	if ($operation == 'done'){
		array_push($_setup_status, $id);
	} else {
		foreach($_setup_status as $key => $value) {if ($value == $id) unset($_setup_status[$key]);}
	}
		
	if ( !empty($_setup_status) )
		array_unique($_setup_status);
	
	update_option(PFIX."_setup_status",$_setup_status);
	$_opt[PFIX."_setup_status"] = $_setup_status;
	$in_ajax = 'TRUE';
	$percent_old =  $_REQUEST["old_val"];
	
	require(TMP_PATH.'/cloudfw/core/engine.wizard/fn.guide.php');