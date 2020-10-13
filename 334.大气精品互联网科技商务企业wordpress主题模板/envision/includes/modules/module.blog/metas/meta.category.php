<?php

if ( $categories_list = get_the_category_list( ', ' ) )
	$metas[] = sprintf( 
		'<span class="ui--meta-categories">%s</span>', 
		$categories_list 
	);