<?php

global $_opt;

$folder = TMP_OPTIONS;
if ( !is_dir( $folder ) ) {
	return false;
}

foreach ((array) glob($folder.'/*', GLOB_ONLYDIR) as $dir) {
	if ( !is_dir( $dir ) ) {
		continue;
	}

	if( preg_match('/^(\d+)./i', basename($dir), $matches) ) {
		$number = $matches[1];
	} else {
		$number = NULL;
	}

	foreach( (array) glob( $dir . "/scheme.php" ) as $file ){
		if ( is_readable($file) ) {
			include( $file );
		}

	}

}