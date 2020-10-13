<?php

/** Blog Settings */
$map  -> option    ( 'blog' )
      -> sub       ( 'page' )
      -> sub       ( 'fit_blog_media' );

/** Mini Layout Options */
$map  -> option    ( 'blog_template_mini' )
      -> sub       ( 'button_color', 'btn-secondary muted' );

/** Blog Page */
$map  -> option    ( 'blog_page' )
      -> sub       ( 'columns', 3 )
      -> sub       ( 'layout' )
      -> sub       ( 'image_ratio' )
      -> sub       ( 'video_ratio' )
      -> sub       ( 'title_size' )
      -> sub       ( 'meta_author' )
      -> sub       ( 'meta_date' )
      -> sub       ( 'meta_category' )
      -> sub       ( 'meta_comment' )
      -> sub       ( 'meta_likes' )
      -> sub       ( 'list_style', 'date' )
      -> sub       ( 'excerpt' )
      -> sub       ( 'excerpt_length');

/** Category Page */
$map  -> option    ( 'blog_category_page' )
      -> sub       ( 'page_layout' )
      -> sub       ( 'page_sidebar' )
      -> sub       ( 'page_skin' )
      -> sub       ( 'page_titlebar_style' )

      -> sub       ( 'columns', 3 )
      -> sub       ( 'layout', 'medium' )
      -> sub       ( 'image_ratio' )
      -> sub       ( 'video_ratio' )
      -> sub       ( 'title_size', 'h3' )
      -> sub       ( 'meta_author', 'FALSE' )
      -> sub       ( 'meta_date' )
      -> sub       ( 'meta_category', 'FALSE' )
      -> sub       ( 'meta_comment' )
      -> sub       ( 'meta_likes' )
      -> sub       ( 'list_style', 'date' )
      -> sub       ( 'excerpt' )
      -> sub       ( 'excerpt_length');

/** Archive Pages */
$map  -> option    ( 'blog_archive_page' )
      -> sub       ( 'page_layout' )
      -> sub       ( 'page_sidebar' )
      -> sub       ( 'page_skin' )
      -> sub       ( 'page_titlebar_style' )

      -> sub       ( 'columns', 3 )
      -> sub       ( 'layout', 'medium' )
      -> sub       ( 'image_ratio' )
      -> sub       ( 'video_ratio' )
      -> sub       ( 'title_size', 'h3' )
      -> sub       ( 'meta_author', 'FALSE' )
      -> sub       ( 'meta_date' )
      -> sub       ( 'meta_category', 'FALSE' )
      -> sub       ( 'meta_comment' )
      -> sub       ( 'meta_likes' )
      -> sub       ( 'list_style', 'date' )
      -> sub       ( 'excerpt' )
      -> sub       ( 'excerpt_length');

/** Search Pages */
$map  -> option    ( 'blog_search_page' )
      -> sub       ( 'page_layout' )
      -> sub       ( 'page_sidebar' )
      -> sub       ( 'page_skin' )
      -> sub       ( 'page_titlebar_style' )

      -> sub       ( 'columns', 3 )
      -> sub       ( 'layout', 'medium' )
      -> sub       ( 'image_ratio' )
      -> sub       ( 'video_ratio' )
      -> sub       ( 'title_size', 'h3' )
      -> sub       ( 'meta_author', 'FALSE' )
      -> sub       ( 'meta_date', 'FALSE' )
      -> sub       ( 'meta_category', 'FALSE' )
      -> sub       ( 'meta_comment', 'FALSE' )
      -> sub       ( 'meta_likes', 'FALSE' )
      -> sub       ( 'list_style', 'none' )
      -> sub       ( 'excerpt' )
      -> sub       ( 'excerpt_length', 100);

/** Single Blog Pages */
$map  -> option    ( 'blog_single' )
      -> sub       ( 'layout' )
      -> sub       ( 'sidebar' )
      -> sub       ( 'skin' )
      -> sub       ( 'titlebar_style' )
      -> sub       ( 'title_element', 'h3' )
      -> sub       ( 'display_title', 'show' )
      -> sub       ( 'display_featured', 'show' );

$map  -> option    ( 'blog_single_metas' )
      -> sub       ( 'category' )
      -> sub       ( 'date' );

$map  -> option    ( 'blog_single_share' )
      -> sub       ( 'enable' )
      -> sub       ( 'services' );

$map  -> option    ( 'blog_single_comments' )
      -> sub       ( 'enable' );

$map  -> option    ( 'blog_single_related' )
      -> sub       ( 'enable' )
      -> sub       ( 'columns' )
      -> sub       ( 'limit' )
      -> sub       ( 'title_element' );

$map  -> option    ( 'blog_single_navigation' )
      -> sub       ( 'position', 'both' );

$map  -> option    ( 'blog_single_author' )
      -> sub       ( 'enable' );

$map  -> option    ( 'blog_single_like' )
      -> sub       ( 'enable' );


$map  -> option    ( 'blog_custom_codes' )
      -> sub       ( 'before_post' )
      -> sub       ( 'before_post_content' )
      -> sub       ( 'after_post' )
      -> sub       ( 'after_post_content' );


$map  -> option    ( 'category_options' )
      -> sub       ( 'indicator', array() )
      -> sub       ( 'id', array() )
      -> sub       ( 'layout', array() )
      -> sub       ( 'sidebar', array() )
      -> sub       ( 'skin', array() )
      -> sub       ( 'titlebar_style', array() )
      -> sub       ( 'titlebar_title', array() )
      -> sub       ( 'titlebar_desc', array() )

      -> sub       ( 'post_list_layout', array() )
      -> sub       ( 'columns', array() )
      -> sub       ( 'image_ratio', array() )
      -> sub       ( 'video_ratio', array() )
      -> sub       ( 'title_size', array() )
      -> sub       ( 'meta_author', array() )
      -> sub       ( 'meta_date', array() )
      -> sub       ( 'meta_category', array() )
      -> sub       ( 'meta_comment', array() )
      -> sub       ( 'meta_likes', array() )
      -> sub       ( 'list_style', array() )
      -> sub       ( 'excerpt', array() )
      -> sub       ( 'excerpt_length', array() )
;