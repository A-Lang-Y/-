<?php

class CloudFw_Export {
	
	public $filename;
	public $name;
	public $case;
	public $key;
	public $server;
	public $data;
	
	public $file;
	private $i;
	private $tag;
	private $signatured_data;
	private $caught_files = array();
	private $caught_files_url = array();
	private $defined_caught_files = array();


	/**
	 *	Construct
	 */
	function __construct(){
		$uploads = wp_upload_dir();
		$this->baseurl = untrailingslashit($uploads['baseurl']);
		$this->basepath_no_file = str_replace('/files', '', $uploads['basedir']);

		$this->i = 1;
		$this->tag = '%%SERVER%%';
		$this->caught_files = array(); 
		$this->caught_files_url = array(); 
		$this->defined_caught_files = array(); 
	}


	/**
	 *	Encrypt the data
	 */
	private function encrypt( $data ){
		require_once (TMP_PATH.'/cloudfw/core/classes/JSON.php'); 
		$json = new Services_JSON();

		$data = $json->encode( $data );
		$data = base64_encode($data);

		return $data;
	}

	/**
	 *	Create file.
	 */
	private function create_file( $data, $file ){
		global $wp_filesystem;
		$result = $wp_filesystem->put_contents($this->get_file(), $data, FS_CHMOD_FILE);

		if ( ! $result ) {
			return wp_die("Export file cannot created.");
		}

		return $result;
	}

	/**
	 *	Prepare.
	 */
	public function prepare( $mode = 'zip' ){
        $url = wp_unslash( $_SERVER['REQUEST_URI'] );
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


		$this->signatured_data = array();
		$this->signatured_data['case'] = $this->case; 
		$this->signatured_data['key'] = $this->key; 
		$this->signatured_data['server'] = $this->server; 
		$this->signatured_data['data'] = $this->get_data();

		if ( $mode == 'normal' ) {

			$this->signatured_data = $this->encrypt( $this->signatured_data );
			$this->set_file();
			$this->create_file( $this->signatured_data, $this->get_file() );

		} else {
			$this->catch_files( $this->signatured_data['data'] );
			$this->signatured_data['data'] = $this->replace_data( $this->signatured_data['data'] );
			$this->signatured_data = $this->encrypt( $this->signatured_data );
			$this->set_file();
		}
		
		return $this;
	}

	/**
	 *	Prepare.
	 */
	public function zip(){

		require_once(ABSPATH . 'wp-admin/includes/file.php');
		require_once(ABSPATH . 'wp-admin/includes/class-pclzip.php');
		
		global $wp_filesystem;

		$tempfile = wp_tempnam();
		$archive = new PclZip($tempfile);

		$error = false;
		$files = array();
		$error_files = array();
		if ( is_array($this->caught_files) && !empty($this->caught_files) ) {
			foreach ($this->caught_files as $file) {

				if ( file_exists($file['path']) ) {
					$files[ $file['path'] ] = $file['filename'];
				} else {
					$error = true;
					$error_files[ $file['path'] ] = $file['url'];
				}

			}
		}

		if ( is_array($files) && !empty($files) ) {
			foreach ($files as $file => $name) {
				$result = $archive->add(
					array(
	                    array( PCLZIP_ATT_FILE_NAME => $file,
	                           PCLZIP_ATT_FILE_NEW_FULL_NAME => $name
	                    )
					),
	                PCLZIP_OPT_REMOVE_ALL_PATH
				);

				if ( $result == 0 ) {
					wp_die(sprintf("File(%s) cannot created.", $file));
				}

			}
		}

		$result = $archive->add(array(
			array(  PCLZIP_ATT_FILE_NAME => pathinfo(sanitize_file_name($this->name), PATHINFO_FILENAME) . '.' . pathinfo($this->name, PATHINFO_EXTENSION),
					PCLZIP_ATT_FILE_CONTENT => $this->signatured_data )
			)
		);

		if ( $result == 0 ) {
			wp_die("Data file cannot created.");
		}

		if ( $error ) {
			$error_message = 'Files cannot downloaded:';
			foreach ($error_files as $error_path => $url) {
				$error_message .= "\r\n- {$error_path} / {$url})";
			}

			$archive->add(array(
				array(  PCLZIP_ATT_FILE_NAME => 'error.txt',
						PCLZIP_ATT_FILE_CONTENT => $error_message )
				)
			);

			$this->set_file( '(Error)-' . $this->get_filename() );

		}
  		
  		$wp_filesystem->put_contents($this->get_file(), file_get_contents($tempfile), FS_CHMOD_FILE);

		return $this;
	}

	/**
	 *	Download the file.
	 */
	public function download(){
		$org_file = $this->get_file();
		$file = $this->get_file();
		$file = cloudfw_abs_path( $file );

		if ( !file_exists($file) ) {
			wp_die("The download file not exists.");
		}

		header("Content-Type: application/octet-stream");
		header("Content-Disposition: attachment; filename=" . $this->filename);   
		header("Content-Type: application/force-download");
		header("Content-Type: application/octet-stream");
		header("Content-Type: application/download");
		header("Content-Description: File Transfer");            
		header("Content-Length: " . filesize($file));
		flush();

		$fp = fopen($file, "r");
		while (!feof($fp))
		{
			echo fread($fp, 65536);
			flush(); 
		} 
		fclose($fp);

		//unlink($file);

		global $wp_filesystem;
		if ( $wp_filesystem->exists( $org_file ) ) {
			$wp_filesystem->delete( $org_file );
		}

		exit;
	}

	/**
	 *	Replace data.
	 */
	public function replace_data( $data ){		
		if ( is_array($this->caught_files) && !empty($this->caught_files) ) {
			foreach ($this->caught_files as $file) {
				$data = $this->array_replace( $file['url'], $file['replace'], $data );
			}
		}

		return $data;
	}

	/**
	 *	Catch files.
	 */
	public function catch_files( $data ){
		if (!is_array($data)) 
			return array();

		foreach ($data as $key => $value){
			unset( $out );
			unset( $out_url );
			unset( $out_path );


			if(is_array($value)) {
				$this->catch_files($value);

			} elseif(is_string($value)) {
				$pathinfo = pathinfo($value);
				
				if (strpos( $value, $this->baseurl ) === 0) {
										
					if ($pathinfo['extension'] == 'png' || $pathinfo['extension'] == 'jpg' || $pathinfo['extension'] == 'gif' || $pathinfo['extension'] == 'tiff') {
						$out_path = str_replace($this->baseurl, untrailingslashit(CLOUDFW_UPLOADDIR), $value);
						$filename = $pathinfo['filename'] . '.'.$pathinfo['extension'];
						$out_url = $this->tag . $filename;
					}

				} elseif (strpos($value, untrailingslashit( cloudfw_home_url(1) ) . '/files') === 0) {
					
					if ($pathinfo['extension'] == 'png' || $pathinfo['extension'] == 'jpg' || $pathinfo['extension'] == 'gif' || $pathinfo['extension'] == 'tiff') {
						$out_path = str_replace(cloudfw_home_url(1), $this->basepath_no_file, $value);
						$filename = $pathinfo['filename'] . '.'.$pathinfo['extension'];
						$out_url = $this->tag . $filename;
					}
						
				} elseif (strpos($value, cloudfw_home_url(1)) === 0) {
					
					if ($pathinfo['extension'] == 'png' || $pathinfo['extension'] == 'jpg' || $pathinfo['extension'] == 'gif' || $pathinfo['extension'] == 'tiff') {
						$out_path = str_replace(cloudfw_home_url(1) . '/', untrailingslashit(ABSPATH) . '/', $value);
						$filename = $pathinfo['filename'] . '.'.$pathinfo['extension'];
						$out_url = $this->tag . $filename;
					}

				}
	
				if ( isset($out_path) && !empty($out_path) ) {
	
					$this->caught_files_all[] = $value;
					if ( isset($this->caught_files_urls) && in_array($value, (array) $this->caught_files_urls) ) 
						continue;

					$out = array();
					$out['path'] = $out_path;
					$out['url'] = $value;

					if ( isset($this->caught_files_names) && in_array($filename, (array) $this->caught_files_names) ) {
						/** Replace */
						$this->caught_files_rename[$value] = str_replace($filename, $pathinfo['filename'] . '-' . $this->i . '.' . $pathinfo['extension'], $out_url);
						$out['replace'] = str_replace($filename, $pathinfo['filename'] . '-' . $this->i . '.' . $pathinfo['extension'], $out_url);
						$out['filename'] = $pathinfo['filename'] . '-' . $this->i . '.' . $pathinfo['extension'];
					} else {
						$out['replace'] = $out_url;
						$out['filename'] = $filename;
					}

					$this->caught_files_names[] = $filename;
					$this->caught_files_urls[] = $value;
					$this->caught_files[] = $out;
				}
				
				
			} else {
				//$data[$key] = $value;
			}
		}

		return $this->caught_files;

	}

	/**
	 *	Set filename.
	 */
	function filename( $name, $prefix = false ) {
		return $this->filename = $this->create_filename( $name, $prefix );
	}

	/**
	 *	Set filename.
	 */
	function create_filename( $name, $prefix = false ) {
 	 	$name = sanitize_file_name( $name ); 

		$pathinfo = pathinfo( $name );

		$filename = $pathinfo['filename'];
		$extension = $pathinfo['extension'];

		if ( $prefix ) {
			$filename = sanitize_file_name( CLOUDFW_THEMENAME ) . '-' . $filename; 
		}

		return $filename . '.' . $extension;

	}

	/**
	 *	Array Replace
	 */
	function array_replace($find, $replace, $array){
		if (!is_array($array)) {
			return str_replace($find, $replace, $array);
		}
	
		$newArray = array();
		foreach ($array as $key => $value)
			$newArray[$key] = $this->array_replace($find, $replace, $value);

		return $newArray;
	}

	/**
	 *	Get filename.
	 */
	function get_filename(){
		$filename = $this->filename;

		if ( !isset($filename) || !$filename ) {
			wp_die("Please set filename.");
		} else {
			return $filename;
		}

	}


	/**
	 *	Set file.
	 */
	function set_file( $new_name = '' ) {
		if ( $new_name ) {
			$this->filename = $new_name; 
		}

		return $this->file = cloudfw_find_folder( trailingslashit(CLOUDFW_UPLOADDIR_FULL) . $this->get_filename() );
	}

	/**
	 *	Get file.
	 */
	function get_file() {
		$file = $this->file;

		if ( !isset($file) || !$file ) {
			wp_die("Please set file path.");
		} else {
			return $file;
		}
	}

	/**
	 *	Set data.
	 */
	function set_data( $data ) {
		$this->data = $data;
	}

	/**
	 *	Get data.
	 */
	function get_data() {
		$data = $this->data;

		if ( !isset($data) || empty($data) ) {
			wp_die("The data not ready.");
		} else {
			return $data;
		}
	}


}