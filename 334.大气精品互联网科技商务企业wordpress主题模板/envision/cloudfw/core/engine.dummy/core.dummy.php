<?php

class CloudFw_Import_Dummy {
	/** Vars */
	private $dummy_file = 'posts/dummy.xml';
	private $succes_message	= '';
	private $offset	= 0;
	
	/**
	 *	Import
	 */
	public function import() {

		//@ini_set( 'memory_limit', '256M' );
		//@ini_set( 'max_execution_time', 300 );
		@error_reporting(0);
		
		/** Requests */
		$type = isset($_REQUEST['type']) ? $_REQUEST['type'] : NULL;
		$offset = isset($_REQUEST['offset']) ? $_REQUEST['offset'] : NULL;

		if ( !empty($offset) )
			$this->offset = $offset; 

		switch ($type) {
			case 'contents':
				$this->import_contents();
				$this->featured_images();
				//$this->success( __("Demo pages and posts imported.",'cloudfw') );
				//$no_response = true; 
				break;

			case 'pages':
				$this->import_contents( 'posts/pages.xml' );
				//$this->featured_images();
				$this->success( __("Sample pages imported.",'cloudfw') );
				break;

			case 'portfolios':
				$this->import_contents( 'posts/portfolios.xml' );
				$this->featured_images();
				$this->success( __("Sample portfolio posts imported.",'cloudfw') );
				break;

			case 'posts':
				$this->import_contents( 'posts/posts.xml' );
				$this->featured_images();
				$this->success( __("Sample blog posts imported.",'cloudfw') );
				break;

			case 'featured_images':
				$this->featured_images();
				$this->success( __("Default featured images set.",'cloudfw') );
				break;

			case 'default_skin':
				$this->import_default_skins();
				$this->success( __("Default visual set imported.",'cloudfw') );
				break;

			case 'skins':
				$this->import_skins();
				$this->success( __("Demo visual sets imported.",'cloudfw') );
				break;

			case 'sliders':
				$this->import_sliders();
				$this->success( __("Demo sliders imported.",'cloudfw') );

				break;
			case 'widgets':
				$this->import_widgets();
				$this->success( __("Demo widgets imported.",'cloudfw') );

				break;
			case 'menus':
				$this->import_menus();
				$this->success( __("Navigation menus imported.",'cloudfw') );

				break;

			case 'options':
				$this->import_options();
				$this->success( __("Options imported.",'cloudfw') );

				break;

			case 'all':
				$this->import_contents();
				$this->featured_images();
				$this->import_menus();
				$this->import_options();
				$this->import_skins();
				$this->import_sliders();
				$this->import_widgets();
				$this->success( __("Demo contents imported successfuly",'cloudfw') );
				$no_response = true; 

				break;
			
			default:

				break;
		}

		if ( !isset($no_response) || !$no_response )
			$this->ajax_response('update', $this->succes_message);

	}

	/**
	 *	Import Skins
	 */
	public function import_default_skins(){

		$folder = array();
		$dirs = array_filter((array)glob(TMP_DEFAULTS.'/skin/*'), 'is_dir');
		$dir = isset($dirs[0]) ? trailingslashit($dirs[0]) : NULL;


		if ( $dir ) {
			include_once ABSPATH . 'wp-admin/includes/file.php';
			global $wp_filesystem;

			add_filter('filesystem_method', array(&$this, '_return_direct') );
			WP_Filesystem();
			remove_filter('filesystem_method', array(&$this, '_return_direct') );

			$dirname = basename($dir);
			$target = $dir;
			$target_relative = cloudfw_relative_path( $dir );

			include_once(TMP_PATH.'/cloudfw/core/classes/class.import.php');	
			$args = array();
			$args['type'] = 'skin';
			$importer = new CloudFw_Import( $args );
			$importer->mode 	 = 'zip';
			$importer->remove 	 = false;
			$importer->overwrite = true;

            $the_skin_files = $importer->findSkinFile($target);

			$skin_file = ''; 	                
			if ($the_skin_files) {
				$skin_file = $target . '/' . $the_skin_files[0];
			}

            $skin_id = $importer->importSkin($skin_file, $target_relative);
			cloudfw_sync_skins($skin_id, true);

            return $skin_id;
		}

	}

	function _return_direct() { return 'direct'; }

	/**
	 *	Import Skins
	 */
	private function import_skins(){
		include_once ABSPATH . 'wp-admin/includes/file.php';
		global $wp_filesystem;
		WP_Filesystem( request_filesystem_credentials( '' ) );

		$cloudfw_dummy_skins = array();
		foreach( (array)glob( DUMMY_DIR_PATH."skins/*.zip" ) as $skin ){
			$cloudfw_dummy_skins[] = cloudfw_find_folder( $skin ); 
		}

		if ( count($cloudfw_dummy_skins) > 0 ) {
			include_once(TMP_PATH.'/cloudfw/core/classes/class.import.php');	

			foreach ($cloudfw_dummy_skins as $skin) {
				$args = array();
				$args['type'] = 'skin';
				$importer = new CloudFw_Import( $args );
				$importer->mode = 'zip';
				$importer->attachment_type = 'direct';
				$importer->remove = false;
				$importer->overwrite = true;

		        $pathinfo = pathinfo($skin);
		        $filename = sanitize_file_name($pathinfo['filename']);
				$importer->import($skin, $filename);
			}

		} else {
			$this->ajax_response('error', sprintf(__("This theme doesn't have any demo skin inside %s folder.",'cloudfw'), $this->dirname() . 'skins/' ));
		}

	}

	/**
	 *	Import Sliders
	 */
	private function import_sliders(){
		include_once ABSPATH . 'wp-admin/includes/file.php';
		global $wp_filesystem;
		WP_Filesystem( request_filesystem_credentials( '' ) );

		$cloudfw_dummy_sliders = array();
		foreach( glob( DUMMY_DIR_PATH."sliders/*.zip" ) as $slider ){
			$cloudfw_dummy_sliders[] = cloudfw_find_folder( $slider ); 
		}

		if ( count($cloudfw_dummy_sliders) > 0 ) {
			include_once(TMP_PATH.'/cloudfw/core/classes/class.import.php');	

			foreach ($cloudfw_dummy_sliders as $slider) {

				$args = array();
				$args['type'] = 'slider';
				$importer = new CloudFw_Import( $args );
				$importer->attachment_type = 'direct';
				$importer->mode = 'zip';
				$importer->remove = false;

		        $pathinfo = pathinfo($slider);
		        $filename = sanitize_file_name($pathinfo['filename']);
				$importer->import($slider, $filename);
			}

		} else {
			$this->ajax_response('error', sprintf(__("This theme doesn't have any demo slider inside %s folder.",'cloudfw'), $this->dirname() . 'sliders/' ));
		}

	}

	/**
	 *	Import Demo Contents
	 */
	private function import_contents( $file = '' ){
		if ( isset($file) && $file ) {
			$this->dummy_file = $file; 
		}
		
		if( $this->check_WP_environment() ){

			if( $this->is_xml_exists()) {
				$error_level = error_reporting();
				defined('IMPORT_DEBUG') || define( 'IMPORT_DEBUG', false );

				if(defined('WP_DEBUG') && WP_DEBUG === false)
					@error_reporting(0);
				
					ob_start();
					$result = $this->core_import_xml();


					if(is_wp_error($result)){
						$this->ajax_response('error',  $result->get_error_message());
					}
					else {
						$this->mark();
						$this->admin_init();
					}

				$data = ob_get_contents();
				ob_get_clean();
				
				$this->success( $data );
					
				/** Restore error repoting level */
				@error_reporting($error_level);
				
				/*if(strlen($data))
					$this->ajax_response('error', $data);*/
						
			} else {
				$this->ajax_response('error', "The XML file containing the dummy content is not available or could not be read in <pre>" . $this->dirname() . "</pre>");
			}

		} else 
			$this->ajax_response('error', "WP_Importer class cannot loaded!</pre>");

	}

	/**
	 *	Import featured images
	 */
	public function featured_images() {
		include_once ABSPATH . 'wp-admin/includes/file.php';
		global $wp_filesystem;
		WP_Filesystem( request_filesystem_credentials( '' ) );

		include_once(TMP_PATH.'/cloudfw/core/engine.dummy/transfer.images.php');	

		$images = new CloudFw_Transfer_Images();
		$result = $images->import();
		if ( is_wp_error( $result ) ) {
			$this->ajax_response('error', __('Couldn\'t imported featured images.','cloudfw') . ' (' . $result->get_error_message() .')' );
		}

		unset( $images );
	}


	/**
	 *	Import widgets
	 */
	public function import_widgets( $for_what = '' ) {
		include_once(TMP_PATH.'/cloudfw/core/engine.dummy/transfer.widgets.php');	

		$widgets = new CloudFw_Transfer_Widgets( $for_what );

		if ( $for_what == 'setup' )
			$widgets->import('setup.txt');
		else
			$widgets->import('widgets.txt');

		unset( $widgets );

	}

	/**
	 *	Import menus
	 */
	private function import_menus() {
		include_once(TMP_PATH.'/cloudfw/core/engine.dummy/transfer.menus.php');	

		$menus = new CloudFw_Transfer_Menus();
		$menus->import('menus.txt');
		unset( $menus );
	}

	/**
	 *	Import options
	 */
	private function import_options() {
		include_once(TMP_PATH.'/cloudfw/core/engine.dummy/transfer.options.php');	

		$options = new CloudFw_Transfer_Options();
		$options->import('options.txt');
		unset( $options );
	}

	/**
	 *	Check WP Environment
	 */
	private function check_WP_environment()
	{
		if (!class_exists('WP_Importer'))
		{
			$class_wp_importer = ABSPATH . 'wp-admin/includes/class-wp-importer.php';
			if (file_exists($class_wp_importer)){
				require_once($class_wp_importer);
				return true;
			}
		}
		return false;
	}

	/**
	 *	Import the XML File
	 */
	private function core_import_xml() {
		/** Include Core WP Importer */
 		require_once(TMP_PATH.'/cloudfw/core/classes/class.wp-import.php');
 		require_once(TMP_PATH.'/cloudfw/core/classes/class.wp-import-parsers.php');

		if ( class_exists('CloudFW_WP_Importer') ) {		
 			/** Try to Import */
			$wp_import = new CloudFW_WP_Importer();
			$wp_import->fetch_attachments = false;
			set_time_limit(0);
			return $wp_import->import( $this->xml_filepath() );
		} else {

			/** Importer class is not exists */
			$this->ajax_response('error', "Class not exist 'CloudFW_WP_Importer'");
		}

		return $wp_import;
	}
		
	/**
	 *	Mark as "imported".
	 */
	private function mark() {
		$importeds = get_option(PFIX.'_dummy_imported_xmls');

		if ( ! is_array($importeds) )
			$importeds = array( $this->dummy_file );
		else
			$importeds[] = $this->dummy_file;


		update_option(PFIX.'_dummy_imported_xmls', $importeds);
	}
		
	/**
	 *	Get the filename.
	 */
	private function xml_filename() {
		return $this->dummy_file;
	}
	
	/**
	 *	Get the directory name.
	 */
	private function dirname() {
		return DUMMY_DIR_PATH;
	}
	
	/**
	 *	Check if the xml file is exists.
	 */
	private function is_xml_exists() {
		return is_file($this->xml_filepath());
	}
	
	/**
	 *	Get the filepath of xml file.
	 */
	private function xml_filepath()	{
		return DUMMY_DIR_PATH . $this->xml_filename();
	}

	/**
	 *	Add the importer to WP importers list.
	 */
	private function admin_init() {
		add_action( 'admin_init', array($this, 'wordpress_importer_init'));
	}
	
	/**
	 *	Register the importer to WP
	 */
	private function wordpress_importer_init() {		
		$GLOBALS['wp_import'] = new CloudFW_WP_Importer();
		register_importer( 'wordpress', 'WordPress', __('Import <strong>posts, pages, comments, custom fields, categories, and tags</strong> from a WordPress export file.', 'cloudfw'), array( $GLOBALS['wp_import'], 'dispatch' ) );
	}

	/**
	 *	Success Message
	 */
	private function success( $message ){
		$this->succes_message = $message;
	}

	/**
	 *	Create a JSON object for responses.
	 */
	private function ajax_response( $status, $title = '', $text = '' ) {
		cloudfw_ajax_response(0, array(
			'messageTitle'	=> $title,
			'messageText'	=> $text,
			'messageCase'	=> $status
		));

	}

}







class CloudFw_Export_Dummy {
	/** Vars */
	private $dummy_file = 'posts/dummy.xml';
	private $succes_message	= '';
	private $offset	= 0;
	
	/**
	 *	Export
	 */
	public function export() {
		
		/** Requests */
		$type = $_REQUEST['type'];
		$no_response = false;

		switch ($type) {
			case 'contents':
				$this->export_contents();
				$this->success( __("Demo pages exported successfuly",'cloudfw') );

				break;

			case 'widgets':
				$this->export_widgets();
				$this->success( __("Demo widgets exported successfuly",'cloudfw') );

				break;
			case 'widgets_setup':
				$this->export_widgets('setup');
				$this->success( __("Demo widgets exported successfuly for setup",'cloudfw') );

				break;
			case 'menus':
				$this->export_menus();
				$this->success( __("Demo menus exported successfuly",'cloudfw') );

				break;

			case 'options':
				$this->export_options();
				$this->success( __("Options exported successfuly",'cloudfw') );

				break;

			case 'all':
				$this->export_menus();
				$this->export_options();
				$this->export_widgets();
				$this->success( __("All contents exported successfuly",'cloudfw') );

				break;
			
			default:

				break;
		}

		if ( ! $no_response )
			$this->ajax_response('update', $this->succes_message);

	}

	/**
	 *	Export Demo Contents
	 */
	private function export_contents(){

	}

	/**
	 *	Import widgets
	 */
	private function export_widgets( $for_what = '' ) {
		include_once(TMP_PATH.'/cloudfw/core/engine.dummy/transfer.widgets.php');	

		$widgets = new CloudFw_Transfer_Widgets( $for_what );
		$widgets->export_as_file('setup.txt');
		unset( $widgets );

	}

	/**
	 *	Import menus
	 */
	private function export_menus() {
		include_once(TMP_PATH.'/cloudfw/core/engine.dummy/transfer.menus.php');	

		$menus = new CloudFw_Transfer_Menus();
		$menus->export_as_file('menus.txt');
		unset( $menus );
	}

	/**
	 *	Import options
	 */
	private function export_options() {
		include_once(TMP_PATH.'/cloudfw/core/engine.dummy/transfer.options.php');	

		$options = new CloudFw_Transfer_Options();
		$options->export_as_file('options.txt');
		unset( $options );
	}
	
	/**
	 *	Get the directory name.
	 */
	private function dirname() {
		return DUMMY_DIR_PATH;
	}
	
	/**
	 *	Check if the xml file is exists.
	 */
	private function is_xml_exists() {
		return is_file($this->xml_filepath());
	}

	/**
	 *	Success Message
	 */
	private function success( $message ){
		$this->succes_message = $message;
	}

	/**
	 *	Create a JSON object for responses.
	 */
	private function ajax_response( $status, $title = '', $text = '' ) {
		cloudfw_ajax_response(0, array(
			'messageTitle'	=> $title,
			'messageText'	=> $text,
			'messageCase'	=> $status
		));
	}

}