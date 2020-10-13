<?php

/**
 *	Tag Page
 *
 *	@since 1.0
 */
$that = cloudfw();
$that->set_meta('titlebar_title', sprintf( cloudfw_translate('tag_titles'), single_term_title( '', false )) );
$that->return_layout( 'category.php' );