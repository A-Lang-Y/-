<?php
// Map, key, classes

/** Main Font Family */
//cloudfw_add_typo_setting( $map, 'font_general', 'body, p, input, textarea, h1, h2, h3, h4, h5, h6, #header-navigation > .megamenu .style--strong-title > a' );

cloudfw_add_typo_setting( $map, 'body', 'body', array( 'font-family' => 'Helvetica, Arial, sans-serif',  'font-size' => '14' ));
cloudfw_add_typo_setting( $map, 'inputs','select, button, textarea, input[type="text"], input[type="submit"], input[type="password"], input[type="datetime"], input[type="datetime-local"], input[type="date"], input[type="month"], input[type="time"], input[type="week"], input[type="number"], input[type="email"], input[type="url"], input[type="search"], input[type="tel"], input[type="color"], .uneditable-input', 
      array(   'font-size' => '14', 'line-height' => '18' ) 
);

cloudfw_add_typo_setting( $map, 'headings', 'h1, h2, h3, h4, h5, h6, .heading, .heading-colorable');
cloudfw_add_typo_setting( $map, 'strong_headings', 'h1 strong, h2 strong, h3 strong, h4 strong, h5 strong, h6 strong, .heading strong, .heading-colorable strong');
cloudfw_add_typo_setting( $map, 'h1', 'h1', array( 'font-size' => '30', 'line-height' => '36' ));
cloudfw_add_typo_setting( $map, 'h2', 'h2', array( 'font-size' => '24', 'line-height' => '30' ));
cloudfw_add_typo_setting( $map, 'h3', 'h3', array( 'font-size' => '20', 'line-height' => '24' ));
cloudfw_add_typo_setting( $map, 'h4', 'h4', array( 'font-size' => '18', 'line-height' => '24' ));
cloudfw_add_typo_setting( $map, 'h5', 'h5', array( 'font-size' => '16', 'line-height' => '18' ));
cloudfw_add_typo_setting( $map, 'h6', 'h6', array( 'font-size' => '14', 'line-height' => '18' ));
cloudfw_add_typo_setting( $map, 'heading', '.heading, .heading-colorable', array( 'font-size' => '18', 'line-height' => '24' ));

cloudfw_add_typo_setting( $map, 'topbar', '#top-bar', array( 'font-size' => '12' ));
cloudfw_add_typo_setting( $map, 'titlebar_title', '#titlebar-title' );
cloudfw_add_typo_setting( $map, 'titlebar_title_strong', '#titlebar-title strong' );
cloudfw_add_typo_setting( $map, 'titlebar_text', '.titlebar-text-content p' );
cloudfw_add_typo_setting( $map, 'breadcrumb', '#breadcrumb', array( 'font-size' => '12' ) );
//cloudfw_add_typo_setting( $map, 'topbar_inputs', '#topbar select, #topbar textarea, #topbar input[type="text"], #topbar input[type="password"], #topbar input[type="datetime"], #topbar input[type="datetime-local"], #topbar input[type="date"], #topbar input[type="month"], #topbar input[type="time"], #topbar input[type="week"], #topbar input[type="number"], #topbar input[type="email"], #topbar input[type="url"], #topbar input[type="search"], #topbar input[type="tel"], #topbar input[type="color"]');

cloudfw_add_typo_setting( $map, 'sidebar_texts', '#page-content #sidebars' );
cloudfw_add_typo_setting( $map, 'sidebar_widgets_title', '#page-content #sidebars .sidebar-widget-title', array(), array(), array('font-family', 'font-size', 'font-weight', 'line-height', 'letter-spacing') );
cloudfw_add_typo_setting( $map, 'sidebar_widgets_title_strong', '#page-content #sidebars .sidebar-widget-title strong' );

cloudfw_add_typo_setting( $map, 'footer_widgets_title', '#footer-widgets .footer-widget-title' );
cloudfw_add_typo_setting( $map, 'footer_widgets_title_strong', '#footer-widgets .footer-widget-title > strong' );
cloudfw_add_typo_setting( $map, 'footer_widgetized', '#footer-widgets', array( 'font-size' => '14' ) );
cloudfw_add_typo_setting( $map, 'footer_bottom', '#footer-bottom, #footer-bottom a', array( 'font-size' => '13' ) );

cloudfw_add_typo_setting( $map, 'navigation_first_level', '#header-navigation li.menu-item.level-0 > a', array( 'font-size' => '15', 'font-weight' => 400 ) );
cloudfw_add_typo_setting( $map, 'navigation_sub_level', '#header-navigation .sub-menu li.menu-item > a', array( 'font-size' => '14' ) );
cloudfw_add_typo_setting( $map, 'navigation_mobile_toggle', '#header-navigation-toggle a');

cloudfw_add_typo_setting( $map, 'revslider_caption_primary', '.tp-caption.caption-primary', array( 'font-size' => '30', 'line-height' => '36', 'font-weight' => '300' ));
cloudfw_add_typo_setting( $map, 'revslider_caption_primary_strong', '.tp-caption.caption-primary strong', array( 'font-weight' => '700' ));
cloudfw_add_typo_setting( $map, 'revslider_caption_white_background', '.tp-caption.caption-white-background', array( 'font-size' => '24', 'line-height' => '30', 'font-weight' => '300' ));
cloudfw_add_typo_setting( $map, 'revslider_caption_text', '.tp-caption.caption-long-text', array( 'font-size' => '16', 'line-height' => '20', 'font-weight' => '300' ));