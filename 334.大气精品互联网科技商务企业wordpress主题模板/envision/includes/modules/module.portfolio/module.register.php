<?php
/**
 *	Register Post Type
 *
 *	@package CloudFw
 *	@since 	 1.0
 */
add_action('init', 'cloudfw_module_register_portfolio', 1);
function cloudfw_module_register_portfolio() {
    $post_slug = sanitize_title( cloudfw_get_option( 'portfolio',  'slug', 'portfolio' ) );
    $category_slug = sanitize_title( cloudfw_get_option( 'portfolio',  'category_slug', 'portfolio-category' ) );
    $filter_slug = sanitize_title( cloudfw_get_option( 'portfolio',  'filter_slug', 'portfolio-filter' ) );
    $tag_slug = sanitize_title( cloudfw_get_option( 'portfolio',  'tag_slug', 'portfolio-tags' ) );

    /** Register Custom Post Type */
    register_post_type('portfolio', array(
        'label'         => __('Portfolio Post', 'cloudfw'),
        'public'        => true,
        'show_ui'       => true,
        'query_var'     => 'portfolio',
        'supports'      => array(
            'title',
            'editor',
            'thumbnail',
            'comments',
        ),
        'rewrite'       => array(
            'slug'          => $post_slug,
            'with_front'    =>  true
        ),
        'menu_position' => 29,
        'hierarchical'  => false,
        'labels'        => array(
            'name'               => __('Portfolio', 'cloudfw'),
            'singular_name'      => __('Portfolio', 'cloudfw'),
            'add_new'            => __('Add New', 'cloudfw'),
            'add_new_item'       => __('Add New Portfolio Post', 'cloudfw'),
            'edit'               => __('Edit Portolio Post', 'cloudfw'),
            'edit_item'          => __('Edit Portolio Post', 'cloudfw'),
            'new_item'           => __('New Portolio Post', 'cloudfw'),
            'view'               => __('View Post', 'cloudfw'),
            'view_item'          => __('View Post', 'cloudfw'),
            'not_found'          => __('There is no any portolio post', 'cloudfw'),
            'not_found_in_trash' => __('There is no any portolio post in the trash', 'cloudfw')
        )
    ));
    
    /** Category Labels */
    $portfolio_category_labels = array(
        'singular_name'          => __('Category', 'cloudfw'),
        'name'                   => __('Portfolio Category', 'cloudfw'),
        'search_items'           => __('Search Category', 'cloudfw'),
        'all_items'              => __('All Categories', 'cloudfw'),
        'parent_item'            => __('Parent Category', 'cloudfw'),
        'parent_item_colon'      => __('Parent Category', 'cloudfw'),
        'edit_item'              => __('Edit Category', 'cloudfw'),
        'update_item'            => __('Update Category', 'cloudfw'),
        'add_new_item'           => __('Add New Category', 'cloudfw'),
        'new_item_name'          => __('New Category Name', 'cloudfw'),
        'menu_name'              => __('Categories', 'cloudfw')
    );
    
    /** Register Category */
    register_taxonomy(
        'portfolio-category',
        array('portfolio'),
        array(
            'hierarchical' => true,
            'labels'       => $portfolio_category_labels,
            'show_ui'      => true,
            'query_var'    => true,
            'rewrite'      => array(
                'slug' => apply_filters( 'cloudfw_portfolio_category_slug', $category_slug ),
            )
    ));

    /** Category Labels */
    $portfolio_filter_labels = array(
        'singular_name'          => __('Filter', 'cloudfw'),
        'name'                   => __('Portfolio Filter', 'cloudfw'),
        'search_items'           => __('Search Filter', 'cloudfw'),
        'all_items'              => __('All Filters', 'cloudfw'),
        'parent_item'            => __('Parent Filter', 'cloudfw'),
        'parent_item_colon'      => __('Parent Filter', 'cloudfw'),
        'edit_item'              => __('Edit Filter', 'cloudfw'),
        'update_item'            => __('Update Filter', 'cloudfw'),
        'add_new_item'           => __('Add New Filter', 'cloudfw'),
        'new_item_name'          => __('New Filter Name', 'cloudfw'),
        'menu_name'              => __('Filters', 'cloudfw')
    );
    register_taxonomy(
        'portfolio-filter',
        array('portfolio'),
        array(
            'hierarchical' => true,
            'labels'       => $portfolio_filter_labels,
            'show_ui'      => true,
            'query_var'    => true,
            'rewrite'      => array(
                'slug' => apply_filters( 'cloudfw_portfolio_filter_slug', $filter_slug ),
            )
    ));

    /** Category Labels */
    $portfolio_tag_labels = array(
        'singular_name'          => __('Related Tag', 'cloudfw'),
        'name'                   => __('Portfolio Related Tag', 'cloudfw'),
        'search_items'           => __('Search Related Tag', 'cloudfw'),
        'all_items'              => __('All Related Tags', 'cloudfw'),
        'parent_item'            => __('Parent Related Tag', 'cloudfw'),
        'parent_item_colon'      => __('Parent Related Tag', 'cloudfw'),
        'edit_item'              => __('Edit Related Tag', 'cloudfw'),
        'update_item'            => __('Update Related Tag', 'cloudfw'),
        'add_new_item'           => __('Add New Related Tag', 'cloudfw'),
        'new_item_name'          => __('New Related Tag Name', 'cloudfw'),
        'menu_name'              => __('Related Tags', 'cloudfw')
    );
    register_taxonomy(
        'portfolio-tags',
        array('portfolio'),
        array(
            'hierarchical' => false,
            'labels'       => $portfolio_tag_labels,
            'show_ui'      => true,
            'query_var'    => true,
            'rewrite'      => array(
                'slug' => apply_filters( 'cloudfw_portfolio_tag_slug', $tag_slug ),
            )
    ));
}

/**
 *  Activate Shortcode Admin UI for Portfolio
 *
 *	@package CloudFw
 *	@since 	 1.0
 */
add_filter('cloudfw_post_thumbnails',                 'cloudfw_module_activate_shortcodes_on_portfolio');
add_filter('cloudfw_composer_default_types',          'cloudfw_module_activate_shortcodes_on_portfolio');
add_filter('cloudfw_post_types_for_core_metaboxes',   'cloudfw_module_activate_shortcodes_on_portfolio');
add_filter('cloudfw_post_types_for_composer',         'cloudfw_module_activate_shortcodes_on_portfolio');
add_filter('cloudfw_post_types_for_dummy_thumbnails', 'cloudfw_module_activate_shortcodes_on_portfolio');
function cloudfw_module_activate_shortcodes_on_portfolio( $post_types ) {
    $post_types[] = 'portfolio';
    return $post_types;
}

/**
 *    Set Category Slug for Post Type
 *
 *    @since 1.0
 */
add_filter('cloudfw_bar_category_slug_portfolio', 'cloudfw_bar_category_slug_portfolio');
function cloudfw_bar_category_slug_portfolio( $default ) {
    return 'portfolio-category';
}

add_filter('cloudfw_bar_tag_slug_portfolio', 'cloudfw_bar_tag_slug_portfolio');
function cloudfw_bar_tag_slug_portfolio( $default ) {
    return 'portfolio-filter';
}


/**
 *    Register the post type for breadcrumb trial
 */
add_filter('cloudfw_breadcrumbs_singular_portfolio_before', 'cloudfw_breadcrumbs_singular_portfolio_before');
add_filter('cloudfw_breadcrumbs_archive_portfolio-category_before', 'cloudfw_breadcrumbs_singular_portfolio_before');
function cloudfw_breadcrumbs_singular_portfolio_before( $trial ) {
    $slug = cloudfw_get_option('portfolio', 'slug');
    $parent_page = get_page_by_path( trim( $slug, '/' ) );

    if ( !empty( $parent_page ) && $parent_page->ID > 0 ) {
        $post_id = $parent_page->ID;
        return $trial;
    }
    
    $portfolio_page = cloudfw_get_option('portfolio', 'page');
    if ( !empty($portfolio_page) && is_numeric($portfolio_page) ) {
        $page_data = get_page( $portfolio_page );
        if ( !empty($page_data->post_title) )
            $trial[] = '<a href="'. get_page_link( $portfolio_page ) .'">'. $page_data->post_title .'</a>';
    }
    return $trial;
}

/**
 *    Selects portfolio item in the navigation menu
 */
add_filter('nav_menu_css_class', 'cloudfw_nav_menu_css_class_portfolio', 10, 2);
function cloudfw_nav_menu_css_class_portfolio( $classes, $item ){

    if ( is_singular('portfolio') || is_tax( 'portfolio-category' ) || is_tax( 'portfolio-filter' ) ) {
        $portfolio_page = cloudfw_get_option('portfolio', 'page');
        if ( !empty($portfolio_page) && is_numeric($portfolio_page) && isset($item->object_id) && $item->object_id == $portfolio_page ) {
            $classes[] = 'current-menu-item'; 
            $classes[] = 'force-for-select'; 
        }
    }

    return $classes;
}

add_filter('cloudfw_content_before_portfolio', 'cloudfw_content_before_portfolio');
function cloudfw_content_before_portfolio( $that ){

}