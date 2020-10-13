<?php
function cloudfw_get_content_maps($map = NULL, $map_id = '') {
  
$out = array();
switch ($map) {
    
case 'theme':
    /** Create Map Element */
    $map  = new CloudFw_Map( $map_id ? $map_id : 'theme_options' );

    $folder = TMP_OPTIONS;
    if ( !is_dir( $folder ) )
      return false;

    foreach ((array) glob($folder.'/*', GLOB_ONLYDIR) as $dir) {
      if ( !is_dir( $dir ) )
        continue;

      $file = $dir . "/map.php"; 

      if ( file_exists($file) )
         include( $file );
    }  

    $map = apply_filters("cloudfw_maps_options_object", $map);
    $out = $map->flush();

break;

case 'setup':

  /** Create Skin Map Element */
    $map  = new CloudFw_Map( $map_id ? $map_id : 'theme_defaults' );

    if ( file_exists( TMP_OPTIONS . '/setup.php' ) )
          include( TMP_OPTIONS . '/setup.php' );
    else
        echo cloudfw_error_message('The map file for setup not found.');

    $map = apply_filters("cloudfw_maps_setup_object", $map);

    /** Flush settings */
    $out = $map->flush();

break;
  
case 'skin_map':

  /** Create Map Element */
    $map  = new CloudFw_Map( $map_id ? $map_id : 'skin_map' );

    if ( file_exists( TMP_VISUAL_OPTIONS . '/map.php' ) )
          include( TMP_VISUAL_OPTIONS . '/map.php' );
    else
        echo cloudfw_error_message('The map file for visual options not found.');

    $map = apply_filters("cloudfw_skin_map_object", $map);
    $out = $map->flush();

break;
case 'font_map':

  /** Create Font Map Element */
    $map  = new CloudFw_Map( $map_id ? $map_id : 'font_map' );
    $default_system_font = 'Helvetica, Arial, sans-serif'; 

    if ( file_exists( TMP_TYPO_OPTIONS . '/map.php' ) )
          include( TMP_TYPO_OPTIONS . '/map.php' );
    else
        echo cloudfw_error_message('The map file for typography options not found.');

    $map = apply_filters("cloudfw_typo_map_object", $map);

    $out = $map->flush();

break;

case 'font_map_setup':

  /** Create Skin Map Element */
    $map  = new CloudFw_Map( $map_id ? $map_id : 'font_map_defaults' );

    if ( file_exists( TMP_TYPO_OPTIONS . '/setup.php' ) )
          include( TMP_TYPO_OPTIONS . '/setup.php' );
    else
        echo cloudfw_error_message('The setup map file for the typography elements cannot found.');

    $map = apply_filters("cloudfw_font_maps_setup_object", $map);

    /** Flush settings */
    $out = $map->flush();

break;

	
} return apply_filters('cloudfw_options', $out, $map); }