<?php

if (!defined('ABSPATH'))
  exit;

function cloudfw_update_walker_add_themebase( &$item, $key, $path ){
  $item = $path . $item;
}

function cloudfw_update_walker_file_exists( &$item, $key ){
  if ( !file_exists($item) )
    $item = '';
}

function cloudfw_update_walker_is_dir( &$item, $key ){
  if ( !is_dir($item) )
    $item = '';
}

function cloudfw_theme_updater($from, $to) {
  global $wp_filesystem;

  @set_time_limit(0);

  $skip_list = array();
  
  $base = trailingslashit(get_template_directory());
  $backuplist = cloudfw_update_get_backup_file_list($from, $to, $base);
  
  if ( file_exists($from . 'delete.php') ) {
    
    $_old_theme_files = $_old_theme_folders = include( $from . 'delete.php' );
    
    if ( is_array($_old_theme_files) && !empty($_old_theme_files) ) {
      array_walk($_old_theme_folders, 'cloudfw_update_walker_add_themebase', $base);
      array_walk($_old_theme_folders, 'cloudfw_update_walker_is_dir');
      $_old_theme_folders = array_filter( $_old_theme_folders );
      
      $backupListInFolders = array();
      foreach ($_old_theme_folders as $_old_theme_folder)
        $backupListInFolders = array_merge( $backupListInFolders, (array) cloudfw_update_get_file_list($_old_theme_folder, $_old_theme_folder) );
  

      array_walk($_old_theme_files, 'cloudfw_update_walker_add_themebase', $base);
      array_walk($_old_theme_files, 'cloudfw_update_walker_file_exists');
      $_old_theme_files = array_filter( $_old_theme_files );
  

    }

  }

  if ( is_array($backuplist) && !empty($backuplist) && is_array($_old_theme_files) && !empty($_old_theme_files) ) {
      $backuplist = array_merge($backuplist, $_old_theme_files);
  }

  if ( is_array($backuplist) && !empty($backuplist) && is_array( $backupListInFolders ) && !empty( $backupListInFolders ) ) {
      $backuplist = array_merge($backuplist, $backupListInFolders);
  }

  require_once(ABSPATH . 'wp-admin/includes/class-pclzip.php');

  $tempfile = wp_tempnam();
  $archive = new PclZip($tempfile);

  if(0 == $archive->create( implode(",", $backuplist ), PCLZIP_OPT_REMOVE_PATH, $base)){
    $wp_filesystem->delete($maintenance_file);
    $wp_filesystem->delete($from, true);
    unlink($tempfile);
    return new WP_Error('backup_error', __('Backup error.', 'cloudfw'));
  }

  if ( !$wp_filesystem->is_dir($to . 'cache/') ) {
    $wp_filesystem->mkdir($to . 'cache/', FS_CHMOD_DIR);
  }

  $wp_filesystem->put_contents(
    $to . 'cache/backup/backup-from-'.CLOUDFW_THEMEVERSION.'.zip',
    file_get_contents($tempfile),
    FS_CHMOD_FILE
  );
  unlink($tempfile);
  
  $maintenance_string = '<?php $upgrading = ' . time() . '; ?>';
  $maintenance_file = $to . '.maintenance';
  $wp_filesystem->delete($maintenance_file);
  $wp_filesystem->put_contents($maintenance_file, $maintenance_string, FS_CHMOD_FILE);

  if ( file_exists(trailingslashit($from) . 'cloudfw/core/framework/core.functions.php') ) {
      if ( ! @$wp_filesystem->copy(trailingslashit($from) . 'cloudfw/core/framework/core.functions.php', trailingslashit($to) . 'cloudfw/core/framework/core.functions.php', true) ) {
          $wp_filesystem->delete($maintenance_file);
          $wp_filesystem->delete($from, true);
          return new WP_Error('copy_failed', sprintf(__('The %s file cannot upgraded.','cloudfw'), 'core.functions.php'));
      }
  }

  $result = cloudfw_update_copy_theme_dir( $from, $to, $skip_list );

  if ( is_wp_error($result) ) {
    $wp_filesystem->delete($maintenance_file);
    $wp_filesystem->delete($from, true);
    return $result;
  }

  if(!empty($_old_theme_files)){
    foreach ( $_old_theme_files as $old_file ) {      
      if ( !$wp_filesystem->exists($old_file) )
        continue;

      if (is_file($old_file))
        $wp_filesystem->delete($old_file, true);

    }
  }

  if(!empty($_old_theme_folders)){
    foreach ( $_old_theme_folders as $old_folder ) {      
      $wp_filesystem->delete($old_folder, true);
    }
  }

  $wp_filesystem->delete($to . 'delete.php');
  $wp_filesystem->delete($from, true);
  $wp_filesystem->delete($maintenance_file);
}

function cloudfw_copy_theme_file($from, $to){
  global $wp_filesystem;
  
  $to_dir = dirname($to);
  if(!$wp_filesystem->is_dir($to_dir)){
    $result = cloudfw_copy_theme_file_mkdir($to_dir);
    if ( is_wp_error($result) )
      return $result;
  }
  if ( ! $wp_filesystem->copy( $from, $to, true, FS_CHMOD_FILE) )
    return new WP_Error('copy_failed', __('Could not copy file.', 'cloudfw'), $from);
}

function cloudfw_copy_theme_file_mkdir($dir){
  global $wp_filesystem;
  $parent_dir = dirname($dir);
  if(!$wp_filesystem->is_dir($parent_dir)){
    $result = cloudfw_copy_theme_file_mkdir($parent_dir);
    if ( is_wp_error($result) )
      return $result;
  }
  if ( !$wp_filesystem->mkdir($dir, FS_CHMOD_DIR) )
    return new WP_Error('mkdir_failed', __('Could not create directory.', 'cloudfw'), $dir);
}

/**
 * Copies a directory from one location to another via the WordPress Filesystem Abstraction.
 * Assumes that WP_Filesystem() has already been called and setup.
 *
 * This is a temporary function for the 3.1 -> 3.2 upgrade only and will be removed in 3.3
 *
 * @ignore
 * @since 3.2.0
 * @see copy_dir()
 *
 * @param string $from source directory
 * @param string $to destination directory
 * @param array $skip_list a list of files/folders to skip copying
 * @return mixed WP_Error on failure, True on success.
 */
function cloudfw_update_copy_theme_dir($from, $to, $skip_list = array() ) {
  global $wp_filesystem;
  $dirlist = $wp_filesystem->dirlist($from);

  $from = trailingslashit($from);
  $to = trailingslashit($to);

  $skip_regex = '';
  foreach ( (array)$skip_list as $key => $skip_file )
    $skip_regex .= preg_quote($skip_file, '!') . '|';

  if ( !empty($skip_regex) )
    $skip_regex = '!(' . rtrim($skip_regex, '|') . ')$!i';

  foreach ( (array) $dirlist as $filename => $fileinfo ) {
    if ( !empty($skip_regex) )
      if ( preg_match($skip_regex, $from . $filename) )
        continue;

    if ( 'f' == $fileinfo['type'] ) {
      if ( ! $wp_filesystem->copy($from . $filename, $to . $filename, true, FS_CHMOD_FILE) ) {
        // If copy failed, chmod file to 0644 and try again.
        $wp_filesystem->chmod($to . $filename, 0644);
        if ( ! $wp_filesystem->copy($from . $filename, $to . $filename, true, FS_CHMOD_FILE) )
          return new WP_Error('copy_failed', __('Could not copy file.', 'cloudfw'), $to . $filename);
      }
    } elseif ( 'd' == $fileinfo['type'] ) {

      if ( !$wp_filesystem->is_dir($to . $filename) ) {
        if ( !$wp_filesystem->mkdir($to . $filename, FS_CHMOD_DIR) )
          return new WP_Error('mkdir_failed', __('Could not create directory.', 'cloudfw'), $to . $filename);

      }
      $result = cloudfw_update_copy_theme_dir($from . $filename, $to . $filename, $skip_list);
      if ( is_wp_error($result) )
        return $result;
    }
  }
  return true;
}

function cloudfw_update_get_backup_file_list($from, $to, $base, $skip_list = array() ) {
  $backuplist = array();
  global $wp_filesystem;

  $dirlist = $wp_filesystem->dirlist($from);

  $from = trailingslashit($from);
  $to = trailingslashit($to);
  $base = trailingslashit($base);

  $skip_regex = '';
  foreach ( (array)$skip_list as $key => $skip_file )
    $skip_regex .= preg_quote($skip_file, '!') . '|';

  if ( !empty($skip_regex) )
    $skip_regex = '!(' . rtrim($skip_regex, '|') . ')$!i';

  foreach ( (array) $dirlist as $filename => $fileinfo ) {
    if ( !empty($skip_regex) )
      if ( preg_match($skip_regex, $from . $filename) )
        continue;

    if ( 'f' == $fileinfo['type'] ) {
      if ( !$wp_filesystem->exists($to.$filename) )
        continue;
      $backuplist[] =  $base.$filename;
    } elseif ( 'd' == $fileinfo['type'] ) {
      if ( !$wp_filesystem->is_dir($to . $filename) ) 
        continue;
      $backuplist = array_merge($backuplist, cloudfw_update_get_backup_file_list($from . $filename, $to . $filename, $base.$filename, $skip_list));
    }
  }

  return $backuplist;
}


function cloudfw_update_get_file_list($from, $base, $skip_list = array() ) {
  $fileList = array();
  global $wp_filesystem;

  $dirlist = $wp_filesystem->dirlist($from);

  $from = trailingslashit($from);
  $base = trailingslashit($base);

  $skip_regex = '';
  foreach ( (array)$skip_list as $key => $skip_file )
    $skip_regex .= preg_quote($skip_file, '!') . '|';

  if ( !empty($skip_regex) )
    $skip_regex = '!(' . rtrim($skip_regex, '|') . ')$!i';

  foreach ( (array) $dirlist as $filename => $fileinfo ) {
    if ( !empty($skip_regex) )
      if ( preg_match($skip_regex, $from . $filename) )
        continue;

    if ( 'f' == $fileinfo['type'] ) {
      $fileList[] =  $base.$filename;

    } elseif ( 'd' == $fileinfo['type'] ) {
      $fileList = array_merge($fileList, cloudfw_update_get_file_list($from . $filename, $base.$filename, $skip_list));
    }
  }

  return $fileList;
}
