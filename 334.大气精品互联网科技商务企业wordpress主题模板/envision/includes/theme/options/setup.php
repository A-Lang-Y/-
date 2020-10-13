<?php

/** Skin Engine Defaults */
$map  -> option  ( 'skin_engine' )
      -> sub     ( 'mode', 'default' )
      -> sub     ( 'id' )
      -> sub     ( 'name' )
      -> sub     ( 'css' )
      -> sub     ( 'version', 0 )
      -> sub     ( 'data', cloudfw_get_content_maps("skin_map") );

/** Logo */
$map  -> option  ( 'logo' )
      -> sub     ( 'image', TMP_URL.'/lib/images/logo.png' )
      -> sub     ( 'margin-top', 40 )
      -> sub     ( 'margin-bottom', 40 );

$map  -> option  ( 'logo-tablet' )
      -> sub     ( 'margin-top', 40 )
      -> sub     ( 'margin-bottom', 30 );

$map  -> option  ( 'logo-phone' )
      -> sub     ( 'margin-top', 20 )
      -> sub     ( 'margin-bottom', 20 );

/** Topbar */
$map  -> option  ( 'topbar' )
      -> sub     ( 'text', "<a href=\"tel:(1)13546897\">[icon icon='FontAwesome/fontawesome-phone||size:14px'] (1) 13 546 897</a>\n<div class=\"helper--seperator\">/</div>\n<a href=\"/contact/\">[icon icon='FontAwesome/fontawesome-envelope-alt||size:14px'] Contact Us</a>" );

/** Footer */
$map  -> option  ( 'topbar_widgets' )
      -> sub     ( 'indicator', array( 1, 1, 1, ) )
      -> sub     ( 'widget', array( 'social-icons', 'custom-menu', 'shop-cart' ) )
      -> sub     ( 'device', array( 'all', 'all', 'all', ) );

$map  -> option  ( 'topbar_widget_social_icons' )
      -> sub     ( 'indicator', array( 1,1,1,1, ) )
      -> sub     ( 'service', array( 'facebook', 'twitter', 'googleplus', 'pinterest', ) )
      -> sub     ( 'url', array( '#','#','#','#', ) )
      -> sub     ( 'effect', 'slide' );

/** Footer Bottom Bar */
$map  -> option  ( 'footer_bottom' )
      -> sub     ( 'text', '<strong>Envision</strong> - WordPress Theme by Orkun Gursel [year]' );

/** Web Fonts */
$map  -> option  ( 'webfonts' )
      -> sub     ( 'enable', true )
      -> sub     ( 'codes' )
      -> sub     ( 'indicator', array( 0 => 1 ) )
      -> sub     ( 'fontname', array( 0 => '' ) )
      -> sub     ( 'fontfamily', array( 0 => 'Roboto:100,100italic,300,300italic,regular,italic,500,500italic,700,700italic,900,900italic:latin-ext,vietnamese,greek,cyrillic-ext,greek-ext,latin,cyrillic' ) )
      -> sub     ( 'custom_fontfamily', array( 0 => '' ) );