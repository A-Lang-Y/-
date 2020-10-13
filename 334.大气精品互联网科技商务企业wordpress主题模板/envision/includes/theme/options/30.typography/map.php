<?php

/** Web Fonts */
$map  -> option  ( 'webfonts' )
      -> sub     ( 'enable', true )
      -> sub     ( 'codes' )
      -> sub     ( 'indicator', array() )
      -> sub     ( 'fontname', array() )
      -> sub     ( 'fontfamily', array() )
      -> sub     ( 'custom_fontfamily', array() );

/** Service Fonts */
$map  -> option  ( 'servicefonts' )
      -> sub     ( 'indicator', array() )
      -> sub     ( 'fontname', array() )
      -> sub     ( 'fontfamily', array() )
      -> sub     ( 'embed_code', array() );

/** Cufon Fonts */
$map  -> option  ( 'cufon' )
      -> sub     ( 'enable', 'FALSE' )
      -> sub     ( 'enable_mobile', true )
      -> sub     ( 'fonts', array() )
      -> sub     ( 'codes' )
      -> sub     ( 'primary' )
      -> sub     ( 'applytoHeadings', true )
      -> sub     ( 'fontTypeHeadings' )
      -> sub     ( 'applytoNavigation', true )
      -> sub     ( 'fontTypeNavigation' )
      -> sub     ( 'applytoButtons', 'FALSE' )
      -> sub     ( 'fontTypeButtons' )
      -> sub     ( 'applytoDropcaps', 'FALSE' )
      -> sub     ( 'fontTypeDropcaps' );