<?php

if ( $tag_list = get_the_tag_list( NULL, ', ' ) )
	$metas[] = sprintf( 
		'<span class="ui--meta-tags">Tags: %s</span>', 
		$tag_list 
	);