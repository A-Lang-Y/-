<?php	

$x = $_REQUEST["x"];

switch($x):
	case 'dissmiss':
		update_option(PFIX.'_last_checked_version', $_POST["version"]);
	break;

endswitch;