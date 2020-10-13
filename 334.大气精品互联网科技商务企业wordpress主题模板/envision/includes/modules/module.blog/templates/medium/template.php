<?php

$layout = 'standard';
$template_path = $templates_dir_path . "{$layout}/template.php";

if ( file_exists($template_path) )
	include( $template_path );
else
	return cloudfw_error_message( sprintf(__( 'Blog template %s cannot found.','cloudfw'), $layout) );