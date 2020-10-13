<?php

/** System Settings */
$map  -> option      ( 'cloudfw_actives' )
      -> sub     	 ( 'autocheck', true )
      -> sub         ( 'dummy', true )
      -> sub         ( 'map', true );

$map  -> option      ( 'framework' )
      -> sub         ( 'who_can_see', 0 )
      -> sub         ( 'logo', TMP_URL.'/cloudfw/gui/cloudfw_logo.png' )
      -> sub         ( 'title', CLOUDFW_THEMENAME );

$map  -> option      ( 'who_can_see' )
      -> sub         ( 'control_panel', 0 )
      -> sub         ( 'slider_manager', 0 );

$map  -> option      ( 'envato' )
      -> sub     	 ( 'purchase_code' );

$map  -> option      ( 'caps' )
      -> sub     	 ( 'prebuilt_pages' )
      -> sub     	 ( 'save_load_template' );