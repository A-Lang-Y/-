<?php

/** Skin map */
add_filter( 'cloudfw_skin_map_object', 'cloudfw_default_widgets_skin_map', 40 );
function cloudfw_default_widgets_skin_map( $map ){

/** CALENDAR */
  /** Normal */
  $map  -> id      ( 'wp_calendar' )
        -> selector( '#page-content #wp-calendar tbody td' )
        -> attr    ( 'color' )
        -> attr    ( 'gradient', array() )
        -> pattern ( 'text-shadow', 
                     '0 %direction%px 0 #%color%', 
              array( 'color' => '', 'direction' => '-1' ) );

  /** Hover */
  $map  -> id      ( 'wp_calendar_hover' )
        -> selector( '#page-content #wp-calendar tbody td:hover' )
        -> attr    ( 'color' )
        -> attr    ( 'gradient', array() )
        -> pattern ( 'text-shadow', 
                     '0 %direction%px 0 #%color%', 
              array( 'color' => '', 'direction' => '-1' ) );

  /** Link */
  $map  -> id      ( 'wp_calendar_link' )
        -> selector( '#page-content #wp-calendar tbody td a' )
        -> attr    ( 'color' )
        -> attr    ( 'text-decoration' ) 
        -> pattern ( 'text-shadow', 
                     '0 %direction%px 0 #%color%', 
              array( 'color' => '', 'direction' => '-1' ) );

  /** Link Hover */
  $map  -> id      ( 'wp_calendar_link_hover' )
        -> selector( '#page-content #wp-calendar tbody td a:hover' )
        -> attr    ( 'color' )
        -> attr    ( 'text-decoration' ) 
        -> pattern ( 'text-shadow', 
                     '0 %direction%px 0 #%color%', 
              array( 'color' => '', 'direction' => '-1' ) );

  /** Caption Sync */
  $map  -> id      ( 'wp_calendar_caption_border_sync' )
        -> selector( '#page-content #wp-calendar caption' )
        -> sync    ( 'border-color', 'sidebars_widget_titles', 'border-color' );

  /** Normal */
  $map  -> id      ( 'footer_wp_calendar' )
        -> selector( 'footer #wp-calendar tbody td' )
        -> sync    ( 'background-color', 'auto-ui_footer_darker', 'background-color' )
        -> attr    ( 'gradient', array() )
        -> attr    ( 'color', '' )
        -> pattern ( 'text-shadow', 
                     '0 %direction%px 0 #%color%', 
              array( 'color' => '', 'direction' => '-1' ) );

  /** Hover */
  $map  -> id      ( 'footer_wp_calendar_hover' )
        -> selector( 'footer #wp-calendar tbody td:hover' )
        -> sync    ( 'background-color', 'auto-ui_footer_darker_hover', 'background-color' )
        -> attr    ( 'gradient', array() )
        -> sync    ( 'color', 'auto-ui_footer_darker_hover', 'color' )
        -> attr    ( 'color', '' )
        -> pattern ( 'text-shadow', 
                     '0 %direction%px 0 #%color%', 
              array( 'color' => '', 'direction' => '-1' ) );

  /** Link */
  $map  -> id      ( 'footer_wp_calendar_link' )
        -> selector( 'footer #wp-calendar tbody td a' )
        -> attr    ( 'color' )
        -> attr    ( 'text-decoration' ) 
        -> pattern ( 'text-shadow', 
                     '0 %direction%px 0 #%color%', 
              array( 'color' => '', 'direction' => '-1' ) );

  /** Link Hover */
  $map  -> id      ( 'footer_wp_calendar_link_hover' )
        -> selector( 'footer #wp-calendar tbody td a:hover' )
        -> attr    ( 'color' )
        -> attr    ( 'text-decoration' ) 
        -> pattern ( 'text-shadow', 
                     '0 %direction%px 0 #%color%', 
              array( 'color' => '', 'direction' => '-1' ) );

  /** Caption Sync */
  $map  -> id      ( 'footer_wp_calendar_caption_border_sync' )
        -> selector( 'footer #wp-calendar caption' )
        -> sync    ( 'border-color', 'footer_widgetized_separator', 'background-color' );


/** TAGS */
  /** Normal */
  $map  -> id      ( 'wp_tags' )
        -> selector( '#page-content .tagcloud a' )
        -> attr    ( 'color' )
        -> attr    ( 'gradient', array() )
        -> attr    ( '+border' )
        -> pattern ( 'text-shadow', 
                     '0 %direction%px 0 #%color%', 
              array( 'color' => '', 'direction' => '-1' ) );

  /** Hover */
  $map  -> id      ( 'wp_tags_hover' )
        -> selector( '#page-content .tagcloud a:hover' )
        -> attr    ( 'color' )
        -> attr    ( '+border' )
        -> attr    ( 'gradient', array() )
        -> pattern ( 'text-shadow', 
                     '0 %direction%px 0 #%color%', 
              array( 'color' => '', 'direction' => '-1' ) );

  /** Normal */
  $map  -> id      ( 'footer_wp_tags' )
        -> selector( 'footer .tagcloud a' )
        -> sync    ( 'background-color', 'auto-ui_footer_darker', 'background-color' )
        -> attr    ( 'gradient', array() )
        -> sync    ( 'color', 'auto-ui_footer_darker', 'background-color' )
        -> attr    ( 'color' )
        -> attr    ( '+border' )

        -> pattern ( 'text-shadow', 
                     '0 %direction%px 0 #%color%', 
              array( 'color' => '', 'direction' => '-1' ) );

  /** Hover */
  $map  -> id      ( 'footer_wp_tags_hover' )
        -> selector( 'footer .tagcloud a:hover' )
        -> sync    ( 'background-color', 'auto-ui_footer_darker_hover', 'background-color' )
        -> attr    ( 'gradient', array() )
        -> sync    ( 'color', 'auto-ui_footer_darker_hover', 'background-color' )
        -> attr    ( 'color', '' )
        -> attr    ( '+border' )
        
        -> pattern ( 'text-shadow', 
                     '0 %direction%px 0 #%color%', 
              array( 'color' => '', 'direction' => '-1' ) );



  $map  -> id      ( 'footer_wp_menu_border_sync' )
        -> selector( 'footer .widget_nav_menu > div > ul > li, footer .ui--widget-subpages-classic > li' )
        -> sync    ( 'border-color', 'footer_widgetized_separator', 'background-color' );



    return $map;
}

if ( is_admin() )
	include( trailingslashit(dirname(__FILE__)) . 'widget.defaults.scheme.php' );