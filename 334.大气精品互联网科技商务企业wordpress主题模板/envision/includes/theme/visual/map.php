<?php

/** Asset Color */
$map  -> id      ( 'accent' )
      -> selector( '.ui--accent-gradient' )
//      -> attr    ( 'gradient', array('f5f5f5','e1e1e1'))
      -> attr    ( 'gradient', array('1cbaed','0e7bdd'))
      -> attr    ( 'color', 'ffffff')
      -> pattern ( 'text-shadow', 
                   '0 %direction%px 0 #%color%', 
            array( 'color' => '094e8c', 'direction' => '-1' ) );

$map  -> id      ( 'accent_background' )
      -> selector( '.ui--accent-background' )
      -> sync    ( 'background-color', 'accent', array( 'gradient', 1 ) );

$map  -> id      ( 'accent_color' )
      -> selector( '.ui--accent-color' )
      -> sync    ( 'color', 'accent', 'color' );

$map  -> id      ( 'accent_color_forced' )
      -> selector( '.ui--accent-color-forced' )
      -> sync    ( 'color', 'accent', 'color', true );

$map  -> id      ( 'accent_bg_to_color' )
      -> selector( '.ui--accent-bg-to-color' )
      -> sync    ( 'color', 'accent', array( 'gradient', 0 ) );

$map  -> id      ( 'accent_color_w_shadow' )
      -> selector( '.ui--accent-color-with-shadow, #page-wrap .ui--box .ui--accent-gradient (h*), #page-wrap .ui--section .ui--box .ui--accent-gradient (h*)' )
      -> sync    ( 'color', 'accent', 'color' )
      -> sync    ( 'text-shadow', 'accent', 'text-shadow' );

$map  -> id      ( 'accent_border' )
      -> selector( '.ui--accent-border' )
      -> sync    ( 'border-color', 'accent', array( 'gradient', 1 ) );

$map  -> id      ( 'accent_hover' )
      -> selector( '.ui--accent-gradient-hover:hover, .ui--accent-gradient-hover-parent:hover .ui--accent-gradient-hover' )
      -> sync    ( 'gradient', 'accent', 'gradient' )
      -> sync    ( 'color', 'accent', 'color' )
      -> sync    ( 'text-shadow', 'accent', 'text-shadow' );

/** Content Color */
$map  -> id      ( 'page_content_background' )
      -> selector( '#page-wrap' )
      -> attr    ( 'gradient', array('ffffff', 'ffffff') )
      -> check_default ( 'gradient', array('ffffff', 'ffffff') )
      -> attr    ( 'background-color' )
      -> attr    ( 'background-image' )
      -> attr    ( 'background-repeat' )
      -> attr    ( 'background-position' )
      -> attr    ( 'background-attachment' )
      -> attr    ( 'background-size' )
      -> attr    ( 'pattern' );



$map  -> id      ( 'page_content' )
      -> selector( '#page-content, #page-content p, #page-content .ui--box, #page-content .ui--box p, #page-content .ui--section .ui--box, #page-content .ui--section .ui--box p, #footer-widgets .ui--box, #footer-widgets .ui--box p' )
      -> attr    ( 'color', '333333' );

/** Headings */
$map  -> id      ( 'headings' )
      -> selector( '#page-content (h*), #page-wrap .ui--video-background-wrapper .ui--box (h*), #page-wrap .ui--box (h*), #page-wrap .ui--section .ui--box (h*)' )
      -> attr    ( 'color', '333333' );

/** Link */
$map  -> id      ( 'link' )
      -> selector( 'a, #page-content a, .megamenu-html a' )
      -> attr    ( 'color', '169fe6' )
      -> attr    ( 'text-decoration' );

$map  -> id      ( 'link_hover' )
      -> selector( '#page-content a:hover, #page-content .ui--box a:hover, #footer-widgets .ui--box a:hover' )
      -> attr    ( 'color', '333333' )
      -> attr    ( 'text-decoration' );

$scope_ui_box = '#page-content|#page-content .ui--video-background-content|#footer-widgets';

/** UI Box */
$map  -> id      ( 'ui_box_content' )
      -> selector( '.ui--box, .ui--box p' )
      -> sync    ( 'color', 'page_content', 'color', true );

$map  -> id      ( 'ui_box_link' )
      -> selector( ".ui--box a, .ui--box p a, ({$scope_ui_box}) .ui--box a, ({$scope_ui_box}) .ui--box .ui--content-box-content a" )
      -> sync    ( 'color', 'link', 'color' );

$map  -> id      ( 'ui_box_link_hover' )
      -> selector( ".ui--box a:hover, .ui--box p a:hover, ({$scope_ui_box}) .ui--box a:hover, ({$scope_ui_box}) .ui--box .ui--content-box-content a:hover" )
      -> sync    ( 'color', 'link_hover', 'color' );

$map  -> id      ( 'ui_box_header_link' )
      -> selector( '.ui--content-box-header, .ui--content-box-header (h*), .ui--content-box-header a (h*)' )
      -> sync    ( 'color', 'page_content', 'color', true );

$map  -> id      ( 'ui_box_header_link_hover' )
      -> selector( '.ui--content-box-header a:hover, .ui--content-box-header a:hover (h*)' )
      -> sync    ( 'color', 'link_hover', 'color', true );

$map  -> id      ( 'ui_box_link_muted' )
      -> selector( ".ui--box a.muted, .ui--box p a.muted, ({$scope_ui_box}) .ui--box a.muted" )
      -> sync    ( 'color', 'muted_hover', 'color' );

$map  -> id      ( 'ui_box_link_muted_hover' )
      -> selector( ".ui--box a.muted:hover, .ui--box p a.muted:hover, ({$scope_ui_box}) .ui--box a.muted:hover" )
      -> sync    ( 'color', 'muted_hover', 'color' );

/** Sidebar */
$map  -> id      ( 'sidebars' )
      -> selector( '#sidebars, #sidebars p' )
      -> attr    ( 'color' );

$map  -> id      ( 'sidebars_link' )
      -> selector( '#sidebars a' )
      -> attr    ( 'color' )
      -> attr    ( 'text-decoration' );

$map  -> id      ( 'sidebars_link_hover' )
      -> selector( '#sidebars a:hover' )
      -> attr    ( 'color' )
      -> attr    ( 'text-decoration' );

$map  -> id      ( 'sidebars_widget_titles' )
      -> selector( '.sidebar-widget-title' )
      -> attr    ( 'color' )
      -> attr    ( 'border-color' );

$map  -> id      ( 'sidebars_widget_titles_border' )
      -> selector( '.sidebar-widget-title > span' )
      -> attr    ( 'border-color' );

/** Boxed Layout */
$map  -> id      ( 'boxed_layout' )
      -> selector( 'body.layout--boxed' )
      -> attr    ( 'gradient' )
      -> attr    ( 'background-color' )
      -> attr    ( 'background-image' )
      -> attr    ( 'background-repeat' )
      -> attr    ( 'background-position' )
      -> attr    ( 'background-attachment' )
      -> attr    ( 'background-size' )
      -> attr    ( 'pattern' );

$map  -> id      ( 'boxed_layout_page_wrap' )
      -> selector( '.layout--boxed #page-wrap' )
      -> sync    ( 'border-color', 'accent_bg_to_color', 'color' )
      -> attr    ( 'margin-top' )
      -> attr    ( 'margin-bottom' )
      -> pattern ( 'box-shadow', 
                   '0 0 %size%px rgba(0,0,0,%opacity%)', 
            array( 'size' => null, 'opacity' => null ) );

/** Top Bar */
$map  -> id      ( 'topbar' )
      -> selector( '#top-bar, #header-container #top-bar' )
      -> attr    ( 'color', '7c7c7c' );

$map  -> id      ( 'topbar_background' )
      -> selector( '#top-bar-background' )
      -> attr    ( 'gradient' )
      -> attr    ( 'background-color' )
      -> attr    ( 'background-image' )
      -> attr    ( 'background-repeat' )
      -> attr    ( 'background-position' )
      -> attr    ( 'pattern' );

$map  -> id      ( 'topbar_text' )
      -> selector( '#top-bar-text, #header-container #top-bar-text' )
      -> attr    ( 'color', '7c7c7c' )
      -> pattern ( 'text-shadow', 
                   '0 %direction%px 0 #%color%', 
            array( 'color' => '', 'direction' => '-1' ) );

$map  -> id      ( 'topbar_text_link' )
      -> selector( '#top-bar-text a, #header-container #top-bar-text a, #header-container #top-bar-widgets a' )
      -> attr    ( 'color', '7c7c7c' )
      -> pattern ( 'text-shadow', 
                   '0 %direction%px 0 #%color%', 
            array( 'color' => '', 'direction' => '-1' ) );

$map  -> id      ( 'topbar_text_link_hover' )
      -> selector( '#top-bar-text a:hover, #header-container #top-bar-text a:hover, #header-container #top-bar-widgets a:hover' )
      -> attr    ( 'color', '333333' );

/** Titlebar */
$map  -> id      ( 'titlebar_link' )
      -> selector( '#titlebar-text a' )
      -> sync    ( 'color', 'link', 'color' );

$map  -> id      ( 'titlebar_link_hover' )
      -> selector( '#titlebar-text a:hover' )
      -> sync    ( 'color', 'link_hover', 'color' );

/** Top Bar Widgets */
$map  -> id      ( 'topbar_widgets_background' )
      -> selector( '#top-bar .ui--gradient' )
      -> attr    ( 'gradient', array(), true )
      -> attr    ( 'background-color' )
      -> attr    ( 'background-image' )
      -> attr    ( 'background-repeat' )
      -> attr    ( 'background-position' )
      -> attr    ( 'pattern' );

$map  -> id      ( 'topbar_widgets_background_sync' )
      -> selector( '#top-bar .ui--gradient.on--hover:hover' )
      -> sync    ( 'background-color', 'topbar_widgets_background', array( 'gradient', 1 ), true );

$map  -> id      ( 'topbar_widgets_separator' )
      -> selector( '#top-bar .ui--widget > ul > li, #top-bar ul.ui--widget > li' )
      -> attr    ( 'border-color', '', true );

$map  -> id      ( 'topbar_border_bottom_sync' )
      -> selector( '#top-bar, #top-bar-text' )
      -> sync    ( 'border-color', 'topbar_widgets_separator', 'border-color' );

$map  -> id      ( 'topbar_border_bottom' )
      -> selector( '#top-bar, #top-bar-text' )
      -> attr    ( 'border-color', '', true );

$map  -> id      ( 'topbar_widgets_link' )
      -> selector( '#top-bar .ui--gradient, #top-bar .ui--gradient > a ' )
      -> attr    ( 'color', '', true )
      -> pattern ( 'text-shadow', 
                   '0 %direction%px 0 #%color%', 
            array( 'color' => '', 'direction' => '-1' ) );

$map  -> id      ( 'topbar_widgets_input_sync' )
      -> selector( '#top-bar input' )
      -> sync    ( 'color', 'topbar_widgets_link', 'color', true );

$map  -> id      ( 'topbar_widgets_input_sync_moz' )
      -> selector( '#top-bar input:-moz-placeholder' )
      -> sync    ( 'color', 'topbar_widgets_link', 'color', true );

$map  -> id      ( 'topbar_widgets_input_sync_ms' )
      -> selector( '#top-bar input::-ms-input-placeholder' )
      -> sync    ( 'color', 'topbar_widgets_link', 'color', true );

$map  -> id      ( 'topbar_widgets_input_sync_webkit' )
      -> selector( '#top-bar input::-webkit-input-placeholder' )
      -> sync    ( 'color', 'topbar_widgets_link', 'color', true );

$map  -> id      ( 'topbar_widgets_link_hover' )
      -> selector( '#top-bar .ui--gradient.on--hover:hover, #top-bar .ui--gradient.on--hover:hover > a' )
      -> attr    ( 'color', '', true );

$map  -> id      ( 'topbar_widgets_fallout_link' )
      -> selector( '#top-bar .ui--custom-menu li > ul.sub-menu li > a' )
      -> attr    ( 'color', '7c7c7c' )
      -> attr    ( 'gradient', array(), true )
      -> attr    ( 'border-color' )
      -> pattern ( 'text-shadow', 
                   '0 %direction%px 0 #%color%', 
            array( 'color' => '', 'direction' => '-1' ) );

$map  -> id      ( 'topbar_widgets_fallout_link_hover' )
      -> selector( '#top-bar .ui--custom-menu li > ul.sub-menu li:hover > a' )
      -> attr    ( 'color', '333333' )
      -> attr    ( 'gradient', array(), true )
      -> attr    ( 'border-color' )
      -> pattern ( 'text-shadow', 
                   '0 %direction%px 0 #%color%', 
            array( 'color' => '', 'direction' => '-1' ) );

/** Header */
$map  -> id      ( 'header' )
      -> selector( '#header-container-background' )
      -> attr    ( 'gradient' )
      -> attr    ( 'background-image' )
      -> attr    ( 'background-repeat' )
      -> attr    ( 'background-position' )
      -> attr    ( '+border-bottom' )
      -> attr    ( 'pattern' );

$map  -> id      ( 'header_text' ) 
      -> selector( '#header-container' )
      -> attr    ( 'color' );

$map  -> id      ( 'header_link' )
      -> selector( '#header-container a' )
      -> attr    ( 'color' )
      -> sync    ( 'color', 'link', 'color' )
      -> attr    ( 'text-decoration' );

$map  -> id      ( 'header_link_hover' )
      -> selector( '#header-container a:hover' )
      -> attr    ( 'color' )
      -> sync    ( 'color', 'link_hover', 'color' )
      -> attr    ( 'text-decoration' );



/** Navigation: First Level */
$map  -> id      ( 'navigation_level_0_paddings_wide' )
      -> media   ( 'wide' )
      -> selector( '#header-navigation > li.top-level-item > a' )
      -> attr    ( 'padding-horizontal' );

$map  -> id      ( 'navigation_level_0_paddings_standard' )
      -> media   ( 'only_standard' )
      -> selector( '#header-navigation > li.top-level-item > a' )
      -> attr    ( 'padding-horizontal' );

$map  -> id      ( 'navigation_level_0_paddings_tablet' )
      -> media   ( 'tablet' )
      -> selector( '#header-navigation > li.top-level-item > a' )
      -> attr    ( 'padding-horizontal' );

$map  -> id      ( 'navigation_level_0' )
      -> selector( '#header-navigation > li.top-level-item > a' )
      -> attr    ( 'color' );

$map  -> id      ( 'navigation_level_0_current_item' )
      -> selector( '#header-navigation > li.current-menu-item > a' )
      -> attr    ( 'color' );

$map  -> id      ( 'navigation_level_0_current_item_hover' )
      -> selector( '#header-navigation > li.current-menu-item > a:hover' )
      -> attr    ( 'color', '', true );

$map  -> push    ( 'accent_bg_to_color', '#header-navigation.active > li.top-level-item.hover > a, #header-navigation > li.top-level-item:hover > a' );
$map  -> id      ( 'navigation_level_0_hover' )
      -> selector( '#header-navigation.active > li.top-level-item.hover > a, #header-navigation > li.top-level-item:hover > a' )
      -> attr    ( 'color' );

$map  -> push    ( 'accent_border', '#header-navigation > li.current-menu-item > a, #header-navigation.active > li.top-level-item.hover > a, #header-navigation > li.top-level-item:hover > a' );
$map  -> id      ( 'navigation_level_0_active_border' )
      -> selector( '#header-navigation > li.current-menu-item > a, #header-navigation.active > li.top-level-item.hover > a, #header-navigation > li.top-level-item:hover > a' )
      -> attr    ( 'border-color' );

$map  -> id      ( 'navigation_level_0_active_border_sync' )
      -> selector( '#header-navigation > li.current-menu-item:hover > a' )
      -> sync    ( 'border-color', 'navigation_level_0_active_border', 'border-color', true );


$map  -> push    ( 'accent', '#header-navigation > li.top-level-item.has-child.hover > a' );
$map  -> id      ( 'navigation_level_0_opened' )
      -> selector( '#header-navigation > li.top-level-item.has-child.hover > a' )
      -> attr    ( 'color', '', true )
      -> attr    ( 'gradient', array(), true )
      -> pattern ( 'text-shadow', 
                   '0 %direction%px 0 #%color%', 
            array( 'color' => '', 'direction' => '-1' ) );

$map  -> push    ( 'accent_background', '#header-navigation li > ul.sub-menu:after' );
$map  -> id      ( 'navigation_level_0_opened_sync' )
      -> selector( '#header-navigation li > ul.sub-menu:after' )
      -> sync    ( 'background-color', 'navigation_level_0_opened', array( 'gradient', 1 ), true );

$map  -> id      ( 'navigation_fallout_link' )
      -> selector( '#header-navigation li.fallout > ul.sub-menu li > a' )
      -> attr    ( 'color', '7c7c7c' )
      -> attr    ( 'gradient', array(), true )
      -> attr    ( 'border-color' )
      -> pattern ( 'text-shadow', 
                   '0 %direction%px 0 #%color%', 
            array( 'color' => '', 'direction' => '-1' ) );

$map  -> id      ( 'navigation_fallout_link_hover' )
      -> selector( '#header-navigation li.fallout > ul.sub-menu li:hover > a, #header-navigation li.fallout > ul.sub-menu li.hover > a' )
      -> attr    ( 'color', '333333' )
      -> attr    ( 'gradient', array(), true )
      -> attr    ( 'border-color' )
      -> pattern ( 'text-shadow', 
                   '0 %direction%px 0 #%color%', 
            array( 'color' => '', 'direction' => '-1' ) );

$map  -> id      ( 'navigation_fallout_border' )
      -> selector( '#header-navigation > li.fallout ul.sub-menu' )
      -> attr    ( 'border-color', '', true );

/** Mega Menu */
$map  -> id      ( 'navigation_megamenu_background' )
      -> selector( '#header-navigation > li.megamenu > ul.sub-menu' )
      -> attr    ( 'border-color', '' )
      -> attr    ( 'background-color', '' );

$map  -> id      ( 'navigation_megamenu_seperator' )
      -> selector( '#header-navigation > .megamenu .menu-item > a, #header-navigation > .megamenu .style--standard > a' )
      -> attr    ( 'border-color' );

$map  -> id      ( 'navigation_megamenu_seperator_sync' )
      -> selector( '#header-navigation > .megamenu .level-1:after' )
      -> sync    ( 'background-color', 'navigation_megamenu_seperator', 'border-color' );

$map  -> id      ( 'navigation_megamenu' )
      -> selector( '#header-navigation > .megamenu ul.sub-menu' )
      -> attr    ( 'color', '7c7c7c' );

$map  -> id      ( 'navigation_megamenu_link' )
      -> selector( '#header-navigation > .megamenu > ul.sub-menu > li > ul.sub-menu .menu-item > a, #header-navigation > .megamenu > ul.sub-menu .style--standard > a, #header-navigation > .megamenu ul.sub-menu .style--big-title > a, #header-navigation > .megamenu > ul.sub-menu .style--list > a' )
      -> attr    ( 'color', '7c7c7c' );

$map  -> push    ( 'link', '#header-navigation > .megamenu > ul.sub-menu > li > ul.sub-menu .menu-item > a:hover, #header-navigation > .megamenu > ul.sub-menu .style--standard > a:hover, #header-navigation > .megamenu > ul.sub-menu .style--list > a:hover' );
$map  -> id      ( 'navigation_megamenu_link_hover' )
      -> selector( '#header-navigation > .megamenu ul.sub-menu .style--standard > a:hover, #header-navigation > .megamenu ul.sub-menu .style--list > a:hover' )
      -> attr    ( 'color', '', true );

$map  -> id      ( 'navigation_megamenu_syncs_headings' )
      -> selector( '#header-navigation > .megamenu (|h*|strong)' )
      -> is_dark ( 'lighter', 1, 'color', 'navigation_megamenu_background', 'background-color' )
      -> is_light( 'darker', .90, 'color', 'navigation_megamenu_background', 'background-color' )
      -> attr    ( 'color' );

$map  -> id      ( 'navigation_megamenu_syncs_inputs' )
      -> selector( '#header-navigation > .megamenu (inputs*)' )
      -> is_dark ( 'darker', .21, 'background-color', 'navigation_megamenu_background', 'background-color' )
      -> is_light( 'lighter', .90, 'background-color', 'navigation_megamenu_background', 'background-color' )

      -> is_dark ( 'darker', .40, 'border-color', 'navigation_megamenu_background', 'background-color' )
      -> is_light( 'darker', .1, 'border-color', 'navigation_megamenu_background', 'background-color' )
      
      -> is_dark ( 'lighter', .90, 'color', 'navigation_megamenu_background', 'background-color' )
      -> is_light( 'darker', .50, 'color', 'navigation_megamenu_background', 'background-color' );

$map  -> id      ( 'navigation_megamenu_syncs_inputs_focus' )
      -> selector( '#header-navigation > .megamenu (inputs*):focus' )
      -> is_dark ( 'darker', .26, 'background-color', 'navigation_megamenu_background', 'background-color' )
      -> is_light( 'lighter', .60, 'background-color', 'navigation_megamenu_background', 'background-color' )

      -> is_dark ( 'darker', .45, 'border-color', 'navigation_megamenu_background', 'background-color' )
      -> is_light( 'darker', .25, 'border-color', 'navigation_megamenu_background', 'background-color' );

/** Standard Links */
$map  -> id      ( 'navigation_megamenu_standard_link' )
      -> selector( '#header-navigation > .megamenu > ul.sub-menu .style--standard > a' )
      -> attr    ( 'color', '', true )
      -> attr    ( 'gradient', array() )
      -> attr    ( 'border-color', '', true )
      -> pattern ( 'text-shadow', 
                   '0 %direction%px 0 #%color%', 
            array( 'color' => '', 'direction' => '1' ) );

$map  -> id      ( 'navigation_megamenu_standard_link_hover' )
      -> selector( '#header-navigation > .megamenu > ul.sub-menu .style--standard > a:hover' )
      -> attr    ( 'color', '', true )
      -> attr    ( 'gradient', array() )
      -> pattern ( 'text-shadow', 
                   '0 %direction%px 0 #%color%', 
            array( 'color' => '', 'direction' => '1' ) );

/** Big Titles */
$map  -> id      ( 'navigation_megamenu_big_title' )
      -> selector( '#header-navigation > .megamenu ul.sub-menu .style--big-title > a' )
      -> attr    ( 'color', '7c7c7c' )
      -> attr    ( 'gradient', array() )
      -> attr    ( 'border-color', '', true )
      -> pattern ( 'text-shadow', 
                   '0 %direction%px 0 #%color%', 
            array( 'color' => 'FFFFFF', 'direction' => '1' ) );

$map  -> push    ( 'link', '#header-navigation > .megamenu ul.sub-menu .style--big-title.link-enabled > a:hover' );
$map  -> id      ( 'navigation_megamenu_big_title_hover' )
      -> selector( '#header-navigation > .megamenu ul.sub-menu .style--big-title.link-enabled > a:hover' )
      -> attr    ( 'color', '' )
      -> attr    ( 'gradient', array() )
      -> pattern ( 'text-shadow', 
                   '0 %direction%px 0 #%color%', 
            array( 'color' => '', 'direction' => '1' ) );

/** Mobile Menu */
$map  -> id      ( 'navigation_mobile_toggle' )
      -> selector( '#header-navigation-toggle a' )
      -> sync    ( 'color', 'link', 'color' )
      -> attr    ( 'color', '' )
      -> attr    ( 'border-color', '' )
      -> attr    ( 'gradient', array() )
      -> pattern ( 'text-shadow', 
                   '0 %direction%px 0 #%color%', 
            array( 'color' => '', 'direction' => '-1' ) );

$map  -> id      ( 'navigation_mobile_toggle_hover' )
      -> selector( '#header-navigation-toggle a:hover' )
      -> sync    ( 'color', 'link', 'color' )
      -> attr    ( 'color', '' )
      -> attr    ( 'border-color', '' )
      -> sync    ( 'background-color', 'navigation_mobile_toggle', array( 'gradient', 1 ) )
      -> attr    ( 'gradient', array() )
      -> pattern ( 'text-shadow', 
                   '0 %direction%px 0 #%color%', 
            array( 'color' => '', 'direction' => '-1' ) );      

$map  -> id      ( 'navigation_mobile_border_sync' )
      -> media   ( 'phone' )
      -> selector( '#header-navigation > li' )
      -> sync    ( 'border-color', 'navigation_mobile_toggle', 'border-color' );

$map  -> id      ( 'navigation_mobile_toggle_border' )
      -> selector( '#header-navigation > li' )
      -> media   ( 'phone' )
      -> attr    ( 'border-color', '', true );

/** Side Menu */
$map  -> id      ( 'side_panel' )
      -> selector( '#side-panel' )
      -> sync    ( 'background-color', 'accent_background', 'background-color' )
      -> attr    ( 'background-color' )
      -> attr    ( 'color' )
      -> attr    ( 'background-image' )
      -> attr    ( 'background-repeat' )
      -> attr    ( 'background-position' )
      -> attr    ( 'pattern' );

$map  -> id      ( 'side_panel_headings' )
      -> selector( '#side-panel (h*|.heading|strong)' )
      -> is_dark ( 'lighter', 1, 'color', 'side_panel', 'background-color' )
      -> is_light( 'darker', .90, 'color', 'side_panel', 'background-color' )
      -> attr    ( 'color' );

$map  -> id      ( 'side_panel_color' )
      -> selector( '#side-panel' )
      -> is_dark ( 'lighter', .53, 'color', 'side_panel', 'background-color' )
      -> is_light( 'darker', .40, 'color', 'side_panel', 'background-color' )
      -> attr    ( 'color' );

$map  -> id      ( 'side_panel_title' )
      -> selector( '#side-panel (h*|strong)' )
      -> attr    ( 'color' );

$map  -> id      ( 'side_panel_link' )
      -> selector( '#side-panel (a|.btn-secondary)' )
      -> attr    ( 'color' )
      -> is_dark ( 'lighter', .90, 'color', 'side_panel', 'background-color' )
      -> is_light( 'darker', .75, 'color', 'side_panel', 'background-color' )
      -> attr    ( 'text-decoration' );

$map  -> id      ( 'side_panel_link_hover' )
      -> selector( '#side-panel a:hover' )
      -> is_dark ( 'lighter', 1, 'color', 'side_panel', 'background-color' )
      -> is_light( 'darker', .90, 'color', 'side_panel', 'background-color' )
      -> attr    ( 'color' )
      -> attr    ( 'text-decoration' );

$map  -> id      ( 'side_panel_separator' )
      -> selector( '.side-panel-row-separator' )
      -> is_dark ( 'lighter', .20, 'background-color', 'side_panel', 'background-color' )
      -> is_light( 'darker', .20, 'background-color', 'side_panel', 'background-color' )
      -> attr    ( 'background-color' );

/** Footer Inputs */
$map  -> id      ( 'side_panel_inputs' )
      -> selector( '#side-panel (inputs*)' )
      -> is_dark ( 'darker', .21, 'background-color', 'side_panel', 'background-color' )
      -> is_light( 'lighter', .90, 'background-color', 'side_panel', 'background-color' )

      -> is_dark ( 'darker', .40, 'border-color', 'side_panel', 'background-color' )
      -> is_light( 'darker', .1, 'border-color', 'side_panel', 'background-color' )
      
      -> is_dark ( 'lighter', .90, 'color', 'side_panel', 'background-color' )
      -> is_light( 'darker', .50, 'color', 'side_panel', 'background-color' );

/** #side-panel Inputs:Focus */
$map  -> id      ( 'side_panel_inputs_focus' )
      -> selector( '#side-panel (inputs*):focus' )
      -> is_dark ( 'darker', .26, 'background-color', 'side_panel', 'background-color' )
      -> is_light( 'lighter', .60, 'background-color', 'side_panel', 'background-color' )
      -> is_dark ( 'darker', .45, 'border-color', 'side_panel', 'background-color' )
      -> is_light( 'darker', .25, 'border-color', 'side_panel', 'background-color' );

/** Footer */
$map  -> id      ( 'footer' )
      -> selector( 'footer' )
      -> attr    ( 'color' )
      -> attr    ( 'background-color', '3b3b3b' )
      -> attr    ( 'background-image' )
      -> attr    ( 'background-repeat' )
      -> attr    ( 'background-position' )
      -> attr    ( 'pattern' );

$map  -> id      ( 'ui_footer_darker' )
      -> selector( 'footer .ui--darker' )
      -> is_dark ( 'darker', .21, 'background-color', 'footer', 'background-color' )
      -> is_light( 'darker', .10, 'background-color', 'footer', 'background-color' )
      -> is_dark ( 'lighter', .90, 'color', 'footer', 'background-color' )
      -> is_light( 'darker', .75, 'color', 'footer', 'background-color' );

$map  -> id      ( 'ui_footer_darker_hover' )
      -> selector( 'footer .ui--darker-hover:hover' )
      -> is_dark ( 'darker', .40, 'background-color', 'footer', 'background-color' )
      -> is_light( 'darker', .20, 'background-color', 'footer', 'background-color' )
      -> is_dark ( 'lighter', 1, 'color', 'footer', 'background-color' )
      -> is_light( 'darker', .90, 'color', 'footer', 'background-color' );

$map  -> id      ( 'ui_footer_widgetized_separator' )
      -> selector( 'footer .seperator' )
      -> is_dark ( 'lighter', .40, 'background-color', 'footer', 'background-color' )
      -> is_light( 'darker', .40, 'background-color', 'footer', 'background-color' );

$map  -> id      ( 'footer_widgetized_separator' )
      -> selector( '.footer-widgets-row-separator' )
      -> is_dark ( 'lighter', .20, 'background-color', 'footer', 'background-color' )
      -> is_light( 'darker', .20, 'background-color', 'footer', 'background-color' )
      -> attr    ( 'background-color'/*, '595959'*/ );

$map  -> id      ( 'footer_widgetized' )
      -> selector( '#footer-widgets' )
      -> is_dark ( 'lighter', .53, 'color', 'footer', 'background-color' )
      -> is_light( 'darker', .40, 'color', 'footer', 'background-color' )
      -> attr    ( 'color'/*, '8c8989'*/ );

$map  -> id      ( 'footer_widgetized_title' )
      -> selector( '#footer-widgets .footer-widget-title' )
      -> is_dark ( 'lighter', .99, 'color', 'footer', 'background-color' )
      -> is_light( 'darker', .85, 'color', 'footer', 'background-color' )      
      -> attr    ( 'color'/*, 'f1f1f1'*/ );

$map  -> id      ( 'footer_widgetized_link' )
      -> selector( '#footer-widgets a' )
      -> attr    ( 'color'/*, 'ffffff'*/ )
      -> is_dark ( 'lighter', .90, 'color', 'footer', 'background-color' )
      -> is_light( 'darker', .75, 'color', 'footer', 'background-color' )
      -> attr    ( 'text-decoration' );

$map  -> id      ( 'footer_widgetized_link_hover' )
      -> selector( '#footer-widgets a:hover' )
      -> is_dark ( 'lighter', 1, 'color', 'footer', 'background-color' )
      -> is_light( 'darker', .90, 'color', 'footer', 'background-color' )
      -> attr    ( 'color'/*, 'ffffff'*/ )
      -> attr    ( 'text-decoration' );

$map  -> id      ( 'footer_muted' )
      -> selector( '#footer-widgets .muted, #footer-widgets a.muted' )
      -> is_dark ( 'lighter', .50, 'color', 'footer_widgetized_link', 'color' )
      -> is_light( 'darker', .50, 'color', 'footer_widgetized_link', 'color' );

$map  -> id      ( 'footer_muted_hover' )
      -> selector( '#footer-widgets a.muted:hover' )
      -> sync    ( 'color', 'footer_widgetized_link', 'color' );

/** Footer Inputs */
$map  -> id      ( 'footer_inputs' )
      -> selector( 'footer select, footer textarea, footer input[type="text"], footer input[type="password"], footer input[type="datetime"], footer input[type="datetime-local"], footer input[type="date"], footer input[type="month"], footer input[type="time"], footer input[type="week"], footer input[type="number"], footer input[type="email"], footer input[type="url"], footer input[type="search"], footer input[type="tel"], footer input[type="color"]' )
      -> is_dark ( 'darker', .21, 'background-color', 'footer', 'background-color' )
      -> is_light( 'lighter', .90, 'background-color', 'footer', 'background-color' )

      -> is_dark ( 'darker', .40, 'border-color', 'footer', 'background-color' )
      -> is_light( 'darker', .1, 'border-color', 'footer', 'background-color' )
      
      -> is_dark ( 'lighter', .90, 'color', 'footer', 'background-color' )
      -> is_light( 'darker', .50, 'color', 'footer', 'background-color' );

/** Footer Inputs:Focus */
$map  -> id      ( 'footer_inputs_focus' )
      -> selector( 'footer select:focus, footer textarea:focus, footer input[type="text"]:focus, footer input[type="password"]:focus, footer input[type="datetime"]:focus, footer input[type="datetime-local"]:focus, footer input[type="date"]:focus, footer input[type="month"]:focus, footer input[type="time"]:focus, footer input[type="week"]:focus, footer input[type="number"]:focus, footer input[type="email"]:focus, footer input[type="url"]:focus, footer input[type="search"]:focus, footer input[type="tel"]:focus, footer input[type="color"]:focus' )
      -> is_dark ( 'darker', .26, 'background-color', 'footer', 'background-color' )
      -> is_light( 'lighter', .60, 'background-color', 'footer', 'background-color' )
      -> is_dark ( 'darker', .45, 'border-color', 'footer', 'background-color' )
      -> is_light( 'darker', .25, 'border-color', 'footer', 'background-color' );


/** Footer Bottom */
$map  -> id      ( 'footer_bottom' )
      -> selector( '#footer-bottom' )
      -> attr    ( 'color' )
      -> attr    ( 'border-top-color'/*, '212121'*/ )
      -> attr    ( 'background-color'/*, '2d2d2d'*/ )

      -> is_dark ( 'darker', .24, 'background-color', 'footer', 'background-color' )
      -> is_light( 'darker', .20, 'background-color', 'footer', 'background-color' )

      -> is_dark ( 'darker', .24, 'border-top-color', 'footer_bottom', 'background-color' )
      -> is_light( 'darker', .20, 'border-top-color', 'footer_bottom', 'background-color' )

      -> attr    ( 'background-image' )
      -> attr    ( 'background-repeat' )
      -> attr    ( 'background-position' )
      -> attr    ( 'pattern' )
      -> pattern ( 'text-shadow', 
                   '0 -1px 0 #%color%', 
            array( 'color' => '' ) );     

$map  -> id      ( 'footer_bottom_link' )
      -> selector( '#footer-bottom, #footer-bottom a' )
      -> attr    ( 'color'/*, '8c8989'*/ )
      -> is_dark ( 'lighter', .53, 'color', 'footer_bottom', 'background-color' )
      -> is_light( 'darker', .40, 'color', 'footer_bottom', 'background-color' )
      -> attr    ( 'text-decoration' );

$map  -> id      ( 'footer_bottom_link_hover' )
      -> selector( '#footer-bottom a:hover' )
      -> attr    ( 'color' )
      -> is_dark ( 'lighter', 1, 'color', 'footer_bottom', 'background-color' )
      -> is_light( 'darker', .75, 'color', 'footer_bottom', 'background-color' )
      -> attr    ( 'text-decoration' );

/** Preloader */
$map  -> id      ( 'preloader_background' )
      -> selector( '#qLoverlay' )
      -> attr    ( 'background-color', '', true );

$map  -> id      ( 'preloader_text' )
      -> selector( '#qLoverlay, #qLoverlay h1#qLpercentage' )
      -> attr    ( 'color', '', true );

/** Skin Options */
$map  -> id      ( 'options' )
      -> attr    ( 'layout' )
      -> attr    ( 'custom-css' )
      -> attr    ( 'custom-logo' )
      -> attr    ( 'custom-logo-retina' )
      -> attr    ( 'custom-logo-tablet' )
      -> attr    ( 'custom-logo-tablet-retina' )
      -> attr    ( 'custom-logo-phone' )
      -> attr    ( 'custom-logo-phone-retina' )
      -> attr    ( 'foldername' );

$map  -> id      ( 'muted' )
      -> selector( '(#page-content|#page-content .ui--box) .muted, (#page-content|#page-content .ui--box) a.muted' )
      -> is_dark ( 'lighter', .50, 'color', 'page_content', 'color' )
      -> is_light( 'darker', .50, 'color', 'page_content', 'color' );

$map  -> id      ( 'muted_hover' )
      -> selector( '(#page-content|#page-content .ui--box) a.muted:hover' )
      -> sync    ( 'color', 'page_content', 'color' );