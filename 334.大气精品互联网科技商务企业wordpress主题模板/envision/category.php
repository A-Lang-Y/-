<?php
/**
 *	Blog Category Page
 *
 *	@since 1.0
 */
$that = cloudfw();
$layout = $that->page_settings(
	'blog_category_page', 
	array(
		'layout' 		 => 'page_layout',
		'sidebar' 		 => 'page_sidebar',
		'titlebar_style' => 'page_titlebar_style',
		'skin' 			 => 'page_skin',
	), 
	'layout'
);
$that->set('blog_options', $that->blog_settings( 'blog_category_page' ));

if ( is_category() ) {
    $spec_cat_options = cloudfw_walk_options( array( 
		'id'               => 'indicator',
		'layout'           => 'layout',
		'sidebar'          => 'sidebar',
		'skin'             => 'skin',
		'titlebar_style'   => 'titlebar_style',
		'titlebar_title'   => 'titlebar_title',
		'titlebar_desc'    => 'titlebar_desc',

		'post_list_layout' =>'post_list_layout',
		'columns'          =>'columns',
		'image_ratio'      =>'image_ratio',
		'video_ratio'      =>'video_ratio',
		'title_size'       =>'title_size',
		'meta_author'      =>'meta_author',
		'meta_date'        =>'meta_date',
		'meta_category'    =>'meta_category',
		'meta_comment'     =>'meta_comment',
		'meta_likes'       =>'meta_likes',
		'list_style'       =>'list_style',
		'excerpt'          =>'excerpt',
		'excerpt_length'   =>'excerpt_length',

    ), cloudfw_get_option( 'category_options' ), 'indicator', get_query_var('cat') );

	if ( !empty( $spec_cat_options ) ) {

		if ( !empty($spec_cat_options['layout']) ) {
			$layout = $spec_cat_options['layout']; 
		}

		if ( !empty($spec_cat_options['skin']) ) {
			$that->set('skin', $spec_cat_options['skin'] );
		}

		if ( !empty($spec_cat_options['sidebar']) ) {
			$that->set('custom_sidebar', $spec_cat_options['sidebar']);
		}

		if ( !empty($spec_cat_options['titlebar_style']) ) {
			$that->set('default_titlebar_style', $spec_cat_options['titlebar_style']);
		}

		if ( !empty($spec_cat_options['titlebar_title']) ) {
			$that->set_meta('titlebar_title', $spec_cat_options['titlebar_title']);
		}

		if ( !empty($spec_cat_options['titlebar_desc']) ) {
			$that->set_meta('titlebar_text', $spec_cat_options['titlebar_desc']);
		}

		$blog_options = array();
		if ( $blog_layout = $spec_cat_options['post_list_layout'] )
			$blog_options['layout'] = $blog_layout;

		if ( $columns = $spec_cat_options['columns'] )
			$blog_options['columns'] = $columns;

		if ( $image_ratio = $spec_cat_options['image_ratio'] )
			$blog_options['image_ratio'] = $image_ratio;

		if ( $video_ratio = $spec_cat_options['video_ratio'] )
			$blog_options['video_ratio'] = $video_ratio;

		if ( $title_size = $spec_cat_options['title_size'] )
			$blog_options['title_element'] = $title_size;

		$blog_options['pagination'] = true;

		if ( $list_style = $spec_cat_options['list_style'] )
			$blog_options['list_style'] = $list_style;

		if ( $excerpt_length = $spec_cat_options['excerpt_length'] )
			$blog_options['excerpt_length'] = $excerpt_length;

		$blog_options['meta_author'] = isset( $spec_cat_options['meta_author'] ) && $spec_cat_options['meta_author'] == 'true' ? true : false;
		$blog_options['meta_date'] = isset( $spec_cat_options['meta_date'] ) && $spec_cat_options['meta_date'] == 'true' ? true : false;
		$blog_options['meta_category'] = isset( $spec_cat_options['meta_category'] ) && $spec_cat_options['meta_category'] == 'true' ? true : false;
		$blog_options['meta_comment'] = isset( $spec_cat_options['meta_comment'] ) && $spec_cat_options['meta_comment'] == 'true' ? true : false;
		$blog_options['meta_likes'] = isset( $spec_cat_options['meta_likes'] ) && $spec_cat_options['meta_likes'] == 'true' ? true : false;
		$blog_options['show_excerpt'] = isset( $spec_cat_options['show_excerpt'] ) && $spec_cat_options['show_excerpt'] == 'true' ? true : false;

		$that->set('blog_options', $blog_options);

	}

}




if ( ! $that->get_meta('titlebar_title') ) {
	$that->set_meta('titlebar_title', sprintf( cloudfw_translate( 'category_titles' ), single_term_title( '', false )) );
}

if ( ! $that->get_meta('titlebar_title') ) {
	$that->set_meta('titlebar_text', category_description() );
}

if ( empty($layout) )
	$layout = $that->blog_page_layout();

$that->return_layout( $layout );