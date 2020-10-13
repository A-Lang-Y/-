<?php
class upgradeHelper {

    function __construct() {
        add_action('update-core-custom_CloudFw_Theme_Update', array(&$this,'update'));
    }

    function check(){
        if( !(defined( 'DOING_AJAX' ) && DOING_AJAX) ) 
            return $this->update();
    }

    function package_url(){
        $purchase_code = cloudfw_get_option('envato', 'purchase_code');
        $url = 'http://updates.wptation.com/upgrade/'. CLOUDFW_THEMEID .'/'. CLOUDFW_THEMEVERSION .'/to/latest/api/' . $purchase_code . '/';
        return apply_filters('cloudfw_theme_package_url', $url, CLOUDFW_THEMEID, CLOUDFW_THEMEVERSION, $purchase_code);
    }

    function update(){
        if ( ! current_user_can( 'update_themes' ) )
            wp_die( __( 'You do not have sufficient permissions to update this site.', 'cloudfw' ) );

        $title =  sprintf(__('Update %s Themes','cloudfw'),CLOUDFW_THEMENAME);
        check_admin_referer('upgrade-'.CLOUDFW_THEMEKEY);

        require_once(ABSPATH . 'wp-admin/admin-header.php');

            global $_opt, $cloudfw_setting_slug, $cloudfw_nav_pages, $cloudfw_current_page_number;
            $purchase_code = cloudfw_get_option('envato', 'purchase_code');
            
            $tab    = cloudfw_get_admin_tab_slug();
            $map    = cloudfw_get_schemes('upgrader', true, $_opt, $purchase_code);


            if ( !empty( $purchase_code ) ) {

                  ## Container Item
                $map[10]['data'][] =  array(
                    'type'      =>  'container',
                    'title'     =>  __('Upgrade Process','cloudfw'),
                    'footer'    =>  false,
                    'data'      =>  array(

                        ## Module Item
                        array(
                            'type'      =>  'module',
                            'layout'    =>  'raw',
                            'data'      =>  array(
                                

                                   array(
                                            'type'      =>  'run',
                                            'function'  =>  array( &$this, 'start_upgrade' ),
                                    )


                            )
                        ),
                            
                    )

                );

            }

            unset($cloudfw_nav_pages);
            extract( cloudfw_detect_spec_tabs( 'upgrading_tabs', $tab, $map ) );
            
            $current_page = $map[$cloudfw_current_page_number];

            $current_page_data = $current_page[$current_page['page']];
            $the_data = $current_page['data'];
            
            require(TMP_PATH.'/cloudfw/core/framework/cloudfw.render.php');
            

        include(ABSPATH . 'wp-admin/admin-footer.php');
        exit;
        
    }


    function start_upgrade(){


            global $wp_filesystem;
            $url = 'update-core.php?action=CloudFw_Theme_Update';
            $url = wp_nonce_url($url, 'upgrade-'.CLOUDFW_THEMEKEY);
            if ( false === ($credentials = request_filesystem_credentials($url, '', false, ABSPATH)) )
                return;
            if ( ! WP_Filesystem($credentials, ABSPATH) ) {
                request_filesystem_credentials($url, '', true, ABSPATH); //Failed to connect, Error and request again
                return;
            }

            if ( $wp_filesystem->errors->get_error_code() ) {
                foreach ( $wp_filesystem->errors->get_error_messages() as $message )
                    show_message($message);
                echo '</div>';
                return;
            }

            add_filter('update_feedback', 'show_message');

            $latest_version = get_transient(CLOUDFW_THEMEKEY.'_update');
            $query = array(
                'version'           => CLOUDFW_THEMEVERSION,
                'theme'             => CLOUDFW_THEMEKEY,
            );
            $name = CLOUDFW_THEMENAME;
            $package = $this->package_url();
            $theme = compact('name','need_update','latest_version','package');

            $upgrader = new CloudFw_Theme_Upgrader();
            $result =  $upgrader->upgrade($theme);

            
            if ( is_wp_error($result) ) {
                show_message($result);

                if ('up_to_date' != $result->get_error_code() )
                    show_message( __('Installation Failed', 'cloudfw') );
            } else {
                show_message( sprintf(__('%s updated successfully.','cloudfw'), CLOUDFW_THEMENAME) );
                show_message( '<a href="' . esc_url( self_admin_url() ) . '">' . __('Go to Dashboard', 'cloudfw') . '</a>' );
            }

    }


}


include_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
class CloudFw_Theme_Upgrader extends WP_Upgrader {
    function upgrade_strings() {
        $helper = new upgradeHelper(); 
        $this->strings['up_to_date']          = sprintf(__('%s is at the latest version.','cloudfw'),CLOUDFW_THEMENAME);
        $this->strings['no_package']          = __('Update package not available.', 'cloudfw');
        $this->strings['downloading_package'] = __('Downloading update from <span class="code">%s</span>&#8230;','cloudfw') . ' ' . sprintf(__('(<a href="%s">download the patch</a>)','cloudfw'), $helper->package_url());
        $this->strings['unpack_package']      = __('Unpacking the package&#8230;','cloudfw');
        $this->strings['copy_failed']         = __('Could not copy files.','cloudfw');
    }

    function _unpack_package($package, $delete_package = true) {
        global $wp_filesystem;

        $this->skin->feedback('unpack_package');

        $upgrade_folder = $wp_filesystem->wp_content_dir() . 'upgrade/';

        //Clean up contents of upgrade directory beforehand.
        $upgrade_files = $wp_filesystem->dirlist($upgrade_folder);
        if ( !empty($upgrade_files) ) {
            foreach ( $upgrade_files as $file )
                $wp_filesystem->delete($upgrade_folder . $file['name'], true);
        }

        //We need a working directory
        $working_dir = $upgrade_folder . basename($package, '.zip');

        // Clean up working directory
        if ( $wp_filesystem->is_dir($working_dir) )
            $wp_filesystem->delete($working_dir, true);

        // Unzip package to working directory
        $result = unzip_file($package, $working_dir); //TODO optimizations, Copy when Move/Rename would suffice?

        // Once extracted, delete the package if required.
        if ( $delete_package )
            unlink($package);

        if ( is_wp_error($result) ) {
            $wp_filesystem->delete($working_dir, true);
            if ( 'incompatible_archive' == $result->get_error_code() ) {
                return new WP_Error( 'incompatible_archive', $this->strings['incompatible_archive'], $result->get_error_data() );
            }
            return $result;
        }

        return $working_dir;
    }



    function _download_url( $url, $timeout = 300 ) {
        //WARNING: The file is not automatically deleted, The script must unlink() the file.
        if ( ! $url )
            return new WP_Error('http_no_url', __('Invalid URL Provided.', 'cloudfw'));

        $tmpfname = wp_tempnam($url);
        if ( ! $tmpfname )
            return new WP_Error('http_no_file', __('Could not create Temporary file.', 'cloudfw'));

        $response = wp_remote_get( $url, array( 'timeout' => $timeout, 'stream' => true, 'filename' => $tmpfname ) );

        if ( is_wp_error( $response ) ) {
            unlink( $tmpfname );
            return $response;
        }

        if ( 200 != wp_remote_retrieve_response_code( $response ) ){
            if ( file_exists($response['filename']) ) {
                $content = trim( cloudfw_get_file_contents( $response['filename'] ) );
                try { 
                    $decoded_content = json_decode($content, true);

                    if ( $decoded_content['error'] == '1' ) {
                        $message = '<strong>'.$decoded_content['message'].'</strong>'; 
                    }

                } catch (Exception $e) {}

                if ( empty($message) )
                    $message = $content;
            }

            if ( empty($message) )
                $message = trim( wp_remote_retrieve_response_message( $response ) ); 

            unlink( $tmpfname );
            return new WP_Error( 'http_404', $message );
        }

        return $tmpfname;
    }

    function _download_package($package) {

        if ( ! preg_match('!^(http|https|ftp)://!i', $package) && file_exists($package) ) //Local file or remote?
            return $package; //must be a local file..

        if ( empty($package) )
            return new WP_Error('no_package', $this->strings['no_package']);

        $this->skin->feedback('downloading_package', $package);

        $download_file = $this->_download_url($package);

        if ( is_wp_error($download_file) )
            return new WP_Error('download_failed', $this->strings['download_failed'], $download_file->get_error_message());

        return $download_file;
    }

    function upgrade($theme) {
        global $wp_filesystem;

        $this->init();
        $this->upgrade_strings();

        $theme_name = basename(TMP_PATH);
        $theme_dir = trailingslashit(trailingslashit($wp_filesystem->wp_themes_dir()).$theme_name);
        
        $download = $this->_download_package( $theme['package'] );
        if ( is_wp_error($download) )
            return $download;

        $working_dir =  trailingslashit($this->_unpack_package( $download ));
        if ( is_wp_error($working_dir) )
            return $working_dir;
        
        if ( $wp_filesystem->is_dir( $working_dir . CLOUDFW_THEMEID . '/' ) )
            $working_dir = $working_dir . CLOUDFW_THEMEID . '/';
        
        // Copy update.php from the new version into place.
        if ( file_exists($working_dir . 'cloudfw/core/update/class.update.php') ) {
            if ( ! @$wp_filesystem->copy($working_dir . 'cloudfw/core/update/class.update.php', $theme_dir . 'cloudfw/core/update/class.update.php', true) ) {
                $wp_filesystem->delete($working_dir, true);
                return new WP_Error('copy_failed', $this->strings['copy_failed']);
            }
        }

        $wp_filesystem->chmod($theme_dir . 'cloudfw/core/update/class.update.php', FS_CHMOD_FILE);

        require_once(TMP_PATH.'/cloudfw/core/update/class.update.php');

        return cloudfw_theme_updater($working_dir, $theme_dir);
    }

}