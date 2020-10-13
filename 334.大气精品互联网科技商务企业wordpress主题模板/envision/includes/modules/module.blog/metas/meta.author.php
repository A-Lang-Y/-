<?php

$metas['author'] = sprintf( 
	'<span class="ui--meta-author">'. __('by %1$s','cloudfw') .'</span>',
	'<a href="'. get_author_posts_url( get_the_author_meta( 'ID' ) ) .'">' . get_the_author() . '</a>'
);