<?php 

/**
 *	CloudFw Uploader Class
 *	
 *	@class CloudFw_Upload_Xhr
 *
 *	@since 1.0
 */
class CloudFw_Uploader {  

    function save($path) {
        if(!move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $path)){
            return false;
        }
        return $path;
    }
    function getName() {
        return $_FILES['uploadedfile']['name'];
    }
    function getSize() {
        return $_FILES['uploadedfile']['size'];
    }
    function getPathInfo() {
        return pathinfo($this->getName());
    }
    function detectMode( $extension ){
        switch ( $extension ) {
            case 'skin':
            case 'slider':
            case 'backup':
                return 'cfile';
            break;
            case 'zip':
                return 'zip';
            default:
                return 'unknown';
            break;
        }
                 
    }

}

/**
 *	CloudFw Import/Export Class
 *	
 *	@class CloudFw_Import
 *
 *	@since 1.0
 *
 *	@param $args array
 *	@return NULL
 */
class CloudFw_Import {  
    private $allowedTypes = array();
    private $sizeLimit  = 8388608;
    private $uploadFolder;
    private $zipFolder;
    public  $mode;
    public  $remove     = false;
    public  $overwrite  = false;
    private $status     = true;
    private $file;
    private $message;


    function __construct( array $args = array() ){
    
		extract(shortcode_atts(array(
			'allowedTypes'	=> array(),
			'sizeLimit'		=> NULL,
			'type'			=> '',
			'uploadFolder'	=> ''
		), $args));
    	                
        $this->allowedTypes =  array_map("strtolower", $allowedTypes);        
        $this->sizeLimit = $sizeLimit;
        $this->uploadFolder = $uploadFolder;
        $this->type = $type;      

    }

    function result(){

        $this->checkServerSettings();
        
        if ($this->status()) {
            
            //if (isset($_FILES['uploadedfile'])) {
                $this->file = new CloudFw_Uploader();
            //} else {
            //    $this->file = false; 
            //}

            return $this->handleUpload();
        }
                
        return $this->getMessage();

    }

    /**
     *	Check Server Settings
     *
     *	@since 1.0
     */
    private function checkServerSettings(){        
        $postSize = cloudfw_to_bytes(ini_get('post_max_size'));
        $uploadSize = cloudfw_to_bytes(ini_get('upload_max_filesize'));
        
        if ($postSize < $this->sizeLimit || $uploadSize < $this->sizeLimit){
            $size = max(1, $this->sizeLimit / 1024 / 1024) . 'M';
            $this->message(1024, false); // increase post_max_size and upload_max_filesize to $size

        }        
    }


    /*
     *	Handler
     *
     *	@since 1.0
    **/
    function handleUpload(){
    	/*$uploadDirectory = $this->uploadFolder;

        if (!is_writable($uploadDirectory))
            return $this->message(9009, false); // Server error. Upload directory isn't writable.
        
        if (!$this->file)
            return $this->message(9003, false); // please upload a file
        
        $size = $this->file->getSize();
        
        if ($size == 0) 
            return $this->message(9003, false); // please upload a file
        
        if ($size > $this->sizeLimit) 
            return $this->message(9007, false); // File is too large*/

        if ($this->status()) {

            include_once ABSPATH . 'wp-admin/includes/screen.php';
            include_once ABSPATH . 'wp-admin/includes/file.php';
            include_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';

            $id = isset($_GET['package_id']) ? $_GET['package_id'] : NULL; 

            if ( empty($id) ) {
                $file_upload = new File_Upload_Upgrader('uploadedfile', 'package');
                $id = $file_upload->id;
            }
            $attachment = get_attached_file( $id );

            $pathinfo = pathinfo($attachment);
            $filename = sanitize_file_name($pathinfo['filename']);
            $ext = $pathinfo['extension'];

            $this->mode = $this->file->detectMode( $ext );

            if ($this->mode == 'zip')
                $this->uploadFolder = CLOUDFW_UPLOADDIR;
            elseif ($this->mode == 'cfile')
                $this->uploadFolder = CLOUDFW_UPLOADDIR;
            else 
                return $this->message(9021, false); // not valid file type

            $url = add_query_arg(array('package_id' => $id), $_POST['_wp_http_referer']);
            $GLOBALS['hook_suffix'] = '';
            set_current_screen();

            $extra_fields = array(); 
            foreach ($_POST as $key => $value) {
                if ( in_array($key, array( 'hostname', 'username', 'password', 'connection_type' )) )
                    continue;

                $extra_fields[] = $key; 
            }

            ob_start();

            if ( false === ($credentials = request_filesystem_credentials( $url, NULL, false, false, $extra_fields )) ) {
                $data = ob_get_contents();
                ob_end_clean();
                if ( ! empty($data) ){
                    wp_die( $data );
                    exit;
                }
                return;
            }


            if ( ! WP_Filesystem($credentials) ) {
                request_filesystem_credentials( $url, '', true, false, $extra_fields ); //Failed to connect, Error and request again
                $data = ob_get_contents();
                ob_end_clean();
                if ( ! empty($data) ){
                    wp_die( $data );
                    exit;
                }
                return;
            }

            $this->import($id, $filename);

            wp_delete_attachment( $id );
            $this->delFile( $attachment );

            if ( ! $this->status() ) {
                $this->delFolder( $this->getZipFolder() );
            }

            return $this->getMessage();

            /*if ($the_file = $this->file->save($uploadDirectory . $filename . '.' . $ext)){              
                $this->import($the_file, $filename);
                $this->delFile($uploadDirectory . $filename . '.' . $ext);

                if ( ! $this->status() )
                    $this->delFolder( $this->getZipFolder() );

                return $this->getMessage();

            } else 
                return $this->message(9008, false); // Could not save uploaded file. The upload was cancelled, or server error encountered
            */


        } else {
            
            return $this->getMessage();

        }

        
    }


    /*
     *  Check Signature
     *
     *  @since 1.0
    **/
    function checkSignature($data){
        return $data['key'] === CLOUDFW_THEMEKEY;
    }
    
    /*
     *  Check Type
     *
     *  @since 1.0
    **/
    function checkType($data){
        return !empty($this->type) ? ($data['case'] == $this->type) : ($data['case'] == 'options');
    }
    

    /*
     *	Get File Content
     *
     *	@since 1.0
    **/
    private function getContent($the_file){
        if (empty($the_file) || !$the_file)
            return false;


		$fp = fopen($the_file, "r");
		while (!feof($fp))
			$the_content = fread($fp, 65536);
			 
		fclose($fp); 
		
		return $this->decodeContent($the_content);
    }

    /*
     *  Decode Contents
     *
     *  @since 1.0
    **/
    private function decodeContent($content){
        include_once(TMP_PATH.'/cloudfw/core/classes/JSON.php');
        $json = new Services_JSON(); 

        $decoded_options = @(base64_decode($content));
        $parse_all_options = @($json->decode($decoded_options));

       if ( $this->status() && ! $parse_all_options ) 
            $this->message(9005, false);
        

        if ($this->status()){
            if (!empty($parse_all_options))
                return cloudfw_object_to_array((array) $parse_all_options);
        }

        return $this->status();

    }

    /*
     *  Set FeedBack Message
     *
     *  @since 1.0
    **/
    function message($message, $status = 1){
        $this->message = $message;
        if (isset($status))
            $this->status = $status;

        return $this->message;
    }

    /*
     *  Get Message
     *
     *  @since 1.0
    **/
    function getMessage(){
        return $this->message;
    }

    /*
     *  Get Status
     *
     *  @since 1.0
    **/
    function status(){
        return $this->status;
    }


    /*
     *  Delete A File
     *
     *  @since 1.0
    **/
    private function delFile($the_file){
        $the_file = cloudfw_find_folder( $the_file );

        global $wp_filesystem;
        if ( $wp_filesystem->exists( $the_file ) ) {
            return $wp_filesystem->delete( cloudfw_find_folder($the_file) );
        }

    }

    /*
     *  Delete A Folder
     *
     *  @since 1.0
    **/
    private function delFolder($dir){
        $dir = cloudfw_find_folder( $dir );

        if ( $wp_filesystem->is_dir( $dir ) && $wp_filesystem->exists( $dir ) ) {
            return $wp_filesystem->delete( $dir, true );
        }
    }

    /*
     *  Set Zip Folder
     *
     *  @since 1.0
    **/
    function getZipFolder(){
        return $this->zipFolder;
    }

    /*
     *  Get Message
     *
     *  @since 1.0
    **/
    function setZipFolder($folder){
        $this->zipFolder = $folder;
    }

    /*
     *  Extract Zip File
     *
     *  @since 1.0
    **/
    function extractZip($the_file, $to){
        global $wp_filesystem;
        $to = trailingslashit(cloudfw_find_folder( $to ));
        $the_file = cloudfw_abs_path( $the_file ); 

        $pathinfo = pathinfo($the_file);
        $filename = sanitize_file_name($pathinfo['filename']);

        $target = $to . $filename.'/';

        if ($this->status()){


            if ( cloudfw_extract_zip($the_file, $target) == 1 ) {
                if ( $this->remove ) {
                    $this->delFile($the_file);
                }

                $this->setZipFolder( $target );
                return $target;

            } else {
                $this->message(9019, false); // Php ZipArchive extension is not found
            }

        }
    
        return $this->status();

    }


    /**
     *  Find Skin File In Folder
     *
     *  @since 1.0
     */
    function findSkinFile( $the_folder ){
        global $wp_filesystem;
        $the_folder = cloudfw_find_folder( $the_folder ); 

        if( ! $wp_filesystem->is_dir( $the_folder ) ){
            $this->message(9018, false);  // the folder cannot opened
            return $this->status();
        }

        $dirlist = $wp_filesystem->dirlist( $the_folder );
        $skin_files = array(); 
        foreach ($dirlist as $file => $file_props) {
            if ( pathinfo($file, PATHINFO_EXTENSION) == 'skin' ) {
                $skin_files[] = $file;
            }
        }

        if ($this->status()){

            if ( !empty($skin_files) )
                return $skin_files; // .skin file found
            else 
                $this->message(9017, false); // no-found .skin file in the folder

        }
    
        return $this->status();

    }

    /**
     *  Find Slider File In Folder
     *
     *  @since 1.0
     */
    function findSliderFile($the_folder){
        global $wp_filesystem;
        $the_folder = cloudfw_find_folder( $the_folder ); 

        if( ! $wp_filesystem->is_dir( $the_folder ) ){
            $this->message(9018, false);  // the folder cannot opened
            return $this->status();
        }

        $dirlist = $wp_filesystem->dirlist( $the_folder );
        $skin_files = array(); 
        foreach ($dirlist as $file => $file_props) {
            if ( pathinfo($file, PATHINFO_EXTENSION) == 'slider' ) {
                $skin_files[] = $file;
            }
        }

        if ($this->status()){

            if ( !empty($skin_files) )
                return $skin_files; // .skin file found
            else 
                $this->message(9022, false); // no-found .slider file in the folder

        }
    
        return $this->status();

    }



    /**
     *  Import
     *
     *  @since 1.0
     */
    public function import($id, $filename){

        if ( !isset($this->attachment_type) || $this->attachment_type != 'direct' ) {
            $the_file = get_attached_file( $id );
        } else {
            $the_file = $id;
        }

        switch ($this->type) {
            case '':
            case 'options':

                return $this->importOptions($the_file);               

            break;
            case 'skin':

                if ($this->mode == 'zip') {
                    $zip_folder = $this->extractZip($the_file, SKINS_DIR_PATH);
                    $zip_folder_relative = SKINS_DIR . sanitize_file_name($filename).'/';

                    if ($zip_folder) {
                        $the_skin_files = $this->findSkinFile($zip_folder);
                        
                        if ($the_skin_files) {
                            $the_file = $zip_folder . $the_skin_files[0];
                        }

                    }
                    
                    $this->importSkin($the_file, $zip_folder_relative);

                } elseif ($this->mode == 'cfile'){

                     $this->importSkin($the_file);

                } else 
                    return $this->message(9004, false); // not compatible
               

            break;
            case 'slider':


                if ($this->mode == 'zip') {
                    $zip_folder = $this->extractZip($the_file, SLIDER_RESOURCES_PATH);
                    $zip_folder_relative = SLIDER_RESOURCES . sanitize_file_name( $filename ).'/';

                    if ($zip_folder) {
                        $the_slider_files = $this->findSliderFile($zip_folder);
                        
                        if ($the_slider_files) {
                            $the_file = $zip_folder . $the_slider_files[0];
                        }

                    }                      
                    

                     $this->importSlider($the_file, $zip_folder_relative);

                } elseif ($this->mode == 'cfile'){

                     $this->importSlider($the_file);

                } else 
                    return $this->message(9004, false); // not compatible
               

            break;

        }
    
    }


    /**
     *  Import: Theme Options
     *
     *  @since 1.0
     */
    function importOptions($the_file){
        $the_file = cloudfw_abs_path( $the_file );

        if($the_file && file_exists($the_file))
            $data = $this->getContent($the_file);
        else{
            if ( ! $this->getMessage() )
                $this->message(9005, false); // problem in the file
        }

        /*
            Check Signature
        **/
        if ( $this->status() ){
            
            if ($this->checkSignature($data) && $this->checkType($data)){
                //true
                    $data["data"] = cloudfw_exclude_options($data["data"], $data["server"], NULL, TRUE);
                    cloudfw_update_option( (array) $data["data"]);

                    $this->message(9002, true); /*success*/

            } else {
                
                $this->message(9006, false); // not compatible
            }

        }
    
    }


    /**
     *  Import: Skin
     *
     *  @since 1.0
     */
    function importSkin($the_file, $the_folder = ''){
        $skin_id = false;
        $the_file = cloudfw_abs_path( $the_file );

        /*
         *  Check whether the file is exists
         */

        if($the_file && file_exists($the_file))
            $data = $this->getContent($the_file);
        else{
            if ( ! $this->getMessage() )
                $this->message(9005, false); // problem in the file
        }

        /**
         *   Check Signature
         */
        if ( $this->status() ){
            
            if ($this->checkSignature($data) && $this->checkType($data)){
                //true

                foreach( $data["data"] as $skin_id => $skin ) {
                        
                    if (!is_array($skin)) 
                        continue;

                    if ( ! $the_folder )
                        $target_folder = cloudfw_get_template_url() . '/resources/skins/' .$skin['data']['custom']['foldername'] . '/';
                    else
                        $target_folder = $the_folder;
                                        
                    $success = true;
                    $skin = cloudfw_prepare_URI_for_import($skin, $target_folder);
                    $skin_id = cloudfw_skin_manager(_if( $this->overwrite, $skin['id'], NULL ), 'add', $skin);

                }
                
                if ($success) 
                    $this->message(7011, true); /*success*/
                else
                    $this->message(9004, false); /*an error occured*/


            } else {
                
                $this->message(9006, false); // not compatible
            }

        }

        return $skin_id;

    }

    /**
     *	Import: Slider
     *
     *	@since 1.0
     */
    function importSlider($the_file, $the_folder = ''){
        $slider_id = false;
        $the_file = cloudfw_abs_path( $the_file );

        /*
            Check whether the file is exists
        **/
        if($the_file && file_exists($the_file))
            $data = $this->getContent($the_file);
        else{
            if ( ! $this->getMessage() )
                $this->message(9005, false); // problem in the file
        }

        /*
            Check Signature
        **/
        if ( $this->status() ){
            
            if ($this->checkSignature($data) && $this->checkType($data)){
                //true

                foreach( $data["data"] as $slider_id => $slider  ) {
                        
                    if (!is_array($slider) || !is_array($slider["main"])) 
                        continue;
                    
                    $main_id = $slider_id;

                    if ( ! $the_folder )
                        $target_folder = SLIDER_RESOURCES . $slider["main"]["foldername"]. '/';
                    else
                        $target_folder = $the_folder;
                                        
                    $success = true;
                    $slider['main'] = cloudfw_prepare_URI_for_import($slider['main'], $target_folder);

                    if ( !empty($slider['data']) )
                        $slider['data'] = cloudfw_prepare_URI_for_import($slider['data'], $target_folder);

                    $main_id = cloudfw_create_slider($slider["main"]);                  
                    if (!empty($main_id) && !empty($slider['data']) ) 
                        update_option($main_id, $slider["data"]);

                }
                
                if ($success) 
                    $this->message(6007, true); /*success*/
                else
                    $this->message(9004, false); /*an error occured*/


            } else {
                
                $this->message(9006, false); // not compatible
            }

        }
 	
    }
      
}