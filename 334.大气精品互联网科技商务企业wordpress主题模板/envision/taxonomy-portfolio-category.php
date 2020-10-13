<?php
/**
 *	Portfolio Category Archives
 *
 *	@since 1.0
 */

$that = cloudfw(); 
$that->set('skip_is_blog', true);

add_filter( 'cloudfw_custom_content', 'cloudfw_portfolio_tax_contents' );
function cloudfw_portfolio_tax_contents(){
	global $wp_query;

	return do_shortcode(
		cloudfw_transfer_shortcode_attributes( 
			'portfolio', 
			array( 
				'from'           => 'wp_query',
				'layout'         => 'masonry',
				'pagination'     => true,
				'limit'          => 3,
				'shadow'         => 8
			)
		)
	);
}

$title = $that->get_meta('titlebar_title');
if ( empty($title) ) {
	
	$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
	$the_tax = get_taxonomy( get_query_var( 'taxonomy' ) );
	$text = $term->name;

	$that->set_meta('titlebar_title', sprintf( $the_tax->labels->name . ': <strong>%s</strong>', $text) );
}

$that->return_layout( 'page.php' );