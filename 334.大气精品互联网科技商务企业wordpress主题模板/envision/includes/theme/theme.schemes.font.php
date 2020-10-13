<?php

$data = $args[0];
$scheme = array();

$folder = TMP_TYPO_OPTIONS;
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
		include_once( $file );

}

$scheme = apply_filters( 'cloudfw_typo_scheme', $scheme, $data, $number );

$scheme[ cloudfw_id_for_sequence( $scheme, 99999 ) ] = array(
	'type'		=>	'submit',
	'layout'	=>	'fixed',
);