<?php

if ( function_exists('cloudfw_likes') ) {
	$like_icon = '<i class="fontawesome-heart px14"></i> '; 
	$metas[] = sprintf( 
		'<span class="ui--meta-like">%s</span>', 
		cloudfw_likes(array(
		    'zero' => $like_icon . __('%d','cloudfw'),
		    'one'  => $like_icon . __('%d','cloudfw'),
		    'more' => $like_icon . __('%d','cloudfw'),
		))
	);
}