<?php

/** Skin map */
add_filter( 'cloudfw_skin_map_object', 'cloudfw_revslider_skin_map' );
function cloudfw_revslider_skin_map( $map ){
    /** Normal */

    $map  -> id      ( 'revoslider_arrows' )
          -> selector( '.rev_slider_wrapper .tp-leftarrow, .rev_slider_wrapper .tp-rightarrow' )
          -> attr    ( 'color', 'FFFFFF', true )
          -> attr    ( 'gradient', array('444444', '333333'), true );

    /** Hover */
    $map  -> id      ( 'revoslider_arrows_hover' )
          -> selector( '.rev_slider_wrapper .tp-leftarrow:hover, .rev_slider_wrapper .tp-rightarrow:hover' )
          -> attr    ( 'color', 'FFFFFF', true )
          -> attr    ( 'gradient', array('333333', '000000'), true );

  $map  -> id      ( 'revoslider_arrows_sync' )
        -> selector( '.rev_slider_wrapper .tp-leftarrow i, .rev_slider_wrapper .tp-rightarrow i' )
        -> sync    ( 'color', 'revoslider_arrows', 'color', true );

  $map  -> id      ( 'revoslider_arrows_hover_sync' )
        -> selector( '.rev_slider_wrapper .tp-leftarrow:hover i, .rev_slider_wrapper .tp-rightarrow:hover i' )
        -> sync    ( 'color', 'revoslider_arrows_hover', 'color', true );

  $map  -> id      ( 'revoslider_bullets' )
        -> selector( '.tp-bullets.simplebullets.round .bullet' )
        -> attr    ( 'background-image', '', true );


          
    /** Captions */
    $map  -> push    ( 'accent' , '.tp-caption.caption-primary > div' );
    $map  -> id      ( 'revoslider_captions_primary' )
          -> selector( '.tp-caption.caption-primary > div' )
          -> attr    ( 'color', '', true )
          -> attr    ( 'gradient', array(), true );

    $map  -> id      ( 'revoslider_captions_white' )
          -> selector( '.tp-caption.caption-white-background' )
          -> attr    ( 'color', '', true );

    $map  -> id      ( 'revoslider_captions_long' )
          -> selector( '.tp-caption.caption-long-text' )
          -> attr    ( 'color', '', true );

    return $map;
}

if ( is_admin() )
	include( trailingslashit(dirname(__FILE__)) . 'skin.scheme.php' );