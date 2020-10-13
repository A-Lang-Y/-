<?php
/**
 *	Blog Archive Pages
 *
 *	@since 1.0
 */
$that = cloudfw();
$layout = $that->page_settings(
	'blog_archive_page', 
	array(
		'layout' 		 => 'page_layout',
		'sidebar' 		 => 'page_sidebar',
		'titlebar_style' => 'page_titlebar_style',
		'skin' 			 => 'page_skin',
	), 
	'layout'
);
$that->set('blog_options', $that->blog_settings( 'blog_archive_page' ));

$title = $that->get_meta('titlebar_title');

if ( empty($title) ) {
	if ( is_day() ) {
		$text = get_the_date();
	}
	elseif ( is_month() ) {
		$text = get_the_date('F, Y');
	}
	elseif ( is_year() ) {
		$text = get_the_date('Y');
	}
	elseif ( is_tax() ) {

		$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );

		$the_tax = get_taxonomy( get_query_var( 'taxonomy' ) );
		$text = $term->name . ' <small>('. $the_tax->labels->name . ')</small>';
	}
	else {
		$text = '';
	}
			
	$that->set_meta('titlebar_title', sprintf( cloudfw_translate('archive_titles'), $text) );
}

if ( empty($layout) )
	$layout = $that->blog_page_layout();

$that->return_layout( $layout );