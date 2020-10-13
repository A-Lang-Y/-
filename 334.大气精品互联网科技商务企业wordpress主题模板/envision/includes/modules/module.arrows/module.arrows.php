<?php

/** Skin map */
add_filter( 'cloudfw_skin_map_object', 'cloudfw_arrows_skin_map' );
function cloudfw_arrows_skin_map( $map ){
    /** Normal */

    $map  -> id      ( 'arrows' )
          -> selector( '.arr:hover' )
          -> sync    ( 'color', 'accent', 'color', true )
          -> sync    ( 'text-shadow', 'accent', 'text-shadow', true );

    $map  -> id      ( 'arrows_gradient' )
          -> selector( '.arr > span' )
          -> sync    ( 'gradient', 'accent', 'gradient', true );


    $map  -> id      ( 'arrows_footer' )
          -> selector( 'footer .arr' )
          -> sync    ( 'color', 'auto-ui_footer_widgetized_separator', 'background-color', true )
          -> sync    ( 'border-color', 'auto-ui_footer_widgetized_separator', 'background-color', true )
          -> sync    ( 'color', 'footer_widgetized_separator', 'background-color', true )
          -> sync    ( 'border-color', 'footer_widgetized_separator', 'background-color', true );

    $map  -> id      ( 'arrows_footer_hover' )
          -> selector( 'footer .arr:hover' )
          -> sync    ( 'color', 'auto-footer_widgetized_title', 'color', true )
          -> sync    ( 'border-color', 'auto-footer_widgetized_title', 'color', true )
          -> sync    ( 'color', 'footer_widgetized_title', 'color', true )
          -> sync    ( 'border-color', 'footer_widgetized_title', 'color', true );

    return $map;
}