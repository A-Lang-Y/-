<!-- DASHBOARD -->

<?php
	global $_opt;
	$_opt = cloudfw_get_all_options(NULL, array(PFIX.'_setup_status'));
	
	if (_check_onoff( cloudfw_get_option('cloudfw_actives', 'map'))) 
		require(TMP_PATH.'/cloudfw/core/engine.wizard/fn.guide.php');
?>