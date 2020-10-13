<?php

/** Logo */
$map  -> option  ( 'logo' )
	  -> sub     ( 'link' )
	  -> sub     ( 'image', TMP_URL.'/lib/images/logo.png' )
	  -> sub     ( 'image@2x' )
	  -> sub     ( 'margin-top', 0 )
	  -> sub     ( 'margin-bottom', 0 );

$map  -> option  ( 'logo-tablet' )
	  -> sub     ( 'image' )
	  -> sub     ( 'image@2x' )
	  -> sub     ( 'margin-top', -1 )
	  -> sub     ( 'margin-bottom', -1 );

$map  -> option  ( 'logo-phone' )
	  -> sub     ( 'image' )
	  -> sub     ( 'image@2x' )
	  -> sub     ( 'margin-top', -1 )
	  -> sub     ( 'margin-bottom', -1 );

$map  -> option  ( 'logo-sticky' )
	  -> sub     ( 'image' )
	  -> sub     ( 'image@2x' )
	  -> sub     ( 'height', 0 )
	  -> sub     ( 'margin-top', 10 )
	  -> sub     ( 'margin-bottom', 10 );

/** Favicon */
$map  -> option  ( 'favicon' )
	  -> sub     ( '16' )
	  -> sub     ( '57' )
	  -> sub     ( '72' )
	  -> sub     ( '114' )
	  -> sub     ( '144' );
	
/** Navigation */
$map  -> option  ( 'navigation' )
	  -> sub     ( 'margin-top', 0 )
	  -> sub     ( 'margin-right', 0 );

/** Widget Area on the Header */
$map  -> option  ( 'widgetized_header' )
	  -> sub     ( 'margin-top', 0 )
	  -> sub     ( 'margin-right', 0 );

/** Header */
$map  -> option  ( 'header' )
	  -> sub     ( 'type', 1 )
	  -> sub     ( 'sticky', 'FALSE' )
	  -> sub     ( 'sticky_offset', 0 );

/** Top Bar */
$map  -> option  ( 'topbar' )
	  -> sub     ( 'sticky', 'FALSE' )
	  -> sub     ( 'enable', true )
	  -> sub     ( 'layout', 'widgets-right' )
	  -> sub     ( 'text' );

$map  -> option  ( 'topbar_widgets' )
	  -> sub     ( 'indicator', array() )
	  -> sub     ( 'widget', array() )
	  -> sub     ( 'device', array() );

$map  -> option  ( 'topbar_widget_social_icons' )
	  -> sub     ( 'indicator', array() )
	  -> sub     ( 'service', array() )
	  -> sub     ( 'url', array() )
	  -> sub     ( 'color', 'grey-bevel-gradient' )
	  -> sub     ( 'effect', 'fade' );

$map  -> option  ( 'topbar_widget_custom_menu' )
	  -> sub     ( 'menu_id' );

$map  -> option  ( 'login_widget_custom_menu' )
	  -> sub     ( 'menu_id' )
	  -> sub     ( 'show_sub_level' )
	  -> sub     ( 'show_avatar', 'FALSE' );

$map  -> option  ( 'topbar_widget_shoping_cart' )
	  -> sub     ( 'show_side_panel' );

$map  -> option  ( 'topbar_widget_language_switcher' )
	  -> sub     ( 'link_type' )
	  -> sub     ( 'flag' );

/** Titlebar */
$map  -> option  ( 'titlebar' )
	  -> sub     ( 'title_element', 'h2' );

/** Footer */
$map  -> option  ( 'footer' )
	  -> sub     ( 'widgetized_enable', true )

	  -> sub     ( 'row1_enable', true )
	  -> sub     ( 'row1', 'span6/span3/span3' )

	  -> sub     ( 'widget_column_row1_1', 'footer-widget-area-1' )
	  -> sub     ( 'widget_column_row1_2', 'footer-widget-area-2' )
	  -> sub     ( 'widget_column_row1_3', 'footer-widget-area-3' )
	  -> sub     ( 'widget_column_row1_4', 'footer-widget-area-4' )

	  -> sub     ( 'row2_enable', 'FALSE' )
	  -> sub     ( 'row2', 'span3/span3/span3/span3' )

	  -> sub     ( 'widget_column_row2_1', 'footer-widget-area-5' )
	  -> sub     ( 'widget_column_row2_2', 'footer-widget-area-6' )
	  -> sub     ( 'widget_column_row2_3', 'footer-widget-area-7' )
	  -> sub     ( 'widget_column_row2_4', 'footer-widget-area-8' )
 ;

/** Footer Bottom Bar */
$map  -> option  ( 'footer_bottom' )
	  -> sub     ( 'enable', true )
	  -> sub     ( 'layout' )
	  -> sub     ( 'text' );

/** Custom Sidebars */
$map  -> option  ( 'custom_sidebars' )
	  -> sub     ( 'id', array() )
	  -> sub     ( 'name', array() )
	  -> sub     ( 'desc', array() );

/** Custom Codes */
$map  -> option  ( 'custom_codes' )
	  -> sub     ( 'tracking' )
	  -> sub     ( 'css' )
	  -> sub     ( 'header' )
	  -> sub     ( 'before_footer' )
	  -> sub     ( 'footer' );

$map  -> option  ( 'called_pages' )
	  -> sub     ( 'before_footer' )
	  -> sub     ( 'after_footer' );

/** Global Options */
$map  -> option  ( 'global' )
	  -> sub     ( 'default_page_layout', 'default' )
	  -> sub     ( 'homeitem', true )
	  -> sub     ( 'blurb', true )
	  -> sub     ( 'breadcrumb', true )
	  -> sub     ( 'responsive', true )
	  -> sub     ( 'uniform', true )
	  -> sub     ( 'thumb_resizer', 'aqua_resizer' )
	  -> sub     ( 'preloader', 'FALSE' )
	  -> sub     ( 'smoothscroll', 'FALSE' )
	  -> sub     ( 'hide_sidebar_on_phones', 'FALSE' )
	  -> sub     ( 'width', '1170' )
	  -> sub     ( 'footer' );

/** API Options */
$map  -> option  ( 'apis' )
	  -> sub     ( 'gmap' );
	
/** Page Defines */
$map  -> option  ( 'page_defines' )
	  -> sub     ( '404' );

/** Side Panel */
$map  -> option  ( 'side_panel' )
	  -> sub     ( 'close_button', 'FALSE' );

$map  -> option  ( 'side_panel_1' )
	  -> sub     ( 'enable' )
	  -> sub     ( 'page_id' )
	  -> sub     ( 'title' )
	  -> sub     ( 'button_style' )
	  -> sub     ( 'close_button_style' )
	  -> sub     ( 'icon' )
	  -> sub     ( 'position' )
	  -> sub     ( 'margin_top' )
	  -> sub     ( 'margin_bottom' )
	  -> sub     ( 'visibility' );

$map  -> option  ( 'side_panel_2' )
	  -> sub     ( 'enable' )
	  -> sub     ( 'page_id' )
	  -> sub     ( 'title' )
	  -> sub     ( 'button_style' )
	  -> sub     ( 'icon' )
	  -> sub     ( 'position' )
	  -> sub     ( 'margin_top' )
	  -> sub     ( 'margin_bottom' )
	  -> sub     ( 'visibility' );

$map  -> option  ( 'side_panel_3' )
	  -> sub     ( 'enable' )
	  -> sub     ( 'page_id' )
	  -> sub     ( 'title' )
	  -> sub     ( 'button_style' )
	  -> sub     ( 'icon' )
	  -> sub     ( 'position' )
	  -> sub     ( 'margin_top' )
	  -> sub     ( 'margin_bottom' )
	  -> sub     ( 'visibility' );

/** Twitter Oauth Options */
$map  -> option  ( 'twitter' )
	  -> sub     ( 'consumer_key' )
	  -> sub     ( 'consumer_secret' )
	  -> sub     ( 'access_token' )
	  -> sub     ( 'access_token_secret' )
	  -> sub     ( 'screenname' );

/** Troubleshooting */
$map  -> option  ( 'troubleshooting' )
	  -> sub     ( 'refresh_carts', 'FALSE' )
	  -> sub     ( 'disable_prettyphoto_on_mobile', true )
	  -> sub     ( 'disable_gravity_uniform_select', 'FALSE' );