<?php

$data = $args[0];
$scheme = array();

$folder = TMP_VISUAL_OPTIONS;
if ( !is_dir( $folder ) )
	return false;

foreach ((array) glob($folder.'/*', GLOB_ONLYDIR) as $dir) {
	if ( !is_dir( $dir ) )
		continue;

	if( preg_match('/^(\d+)./i', basename($dir), $matches) )
		$number = $matches[1];
	else 
		$number = NULL;

	$file = $dir . "/scheme.php"; 

	if ( file_exists($file) )
		include( $file );

}