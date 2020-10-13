<?php
/**
 *	Register Module
 *
 *	@since 3.0
 */
function cloudfw_register_module( $module, $args = array() ){
	global 	$cloudfw_modules,
			$cloudfw_found_modules,
			$cloudfw_core_modules;

	extract( cloudfw_make_var(
		array(
		'module_folder' => '',
		'_auto_register'=> TRUE,
		'_can_disabled' => TRUE,
		'title'         => __('Unnamed Module','cloudfw'),
		'init'          => array( 'init', 'options', 'metabox' ),
		'includes'      => array( 'register', 'shortcode', 'skin', 'page_generator' ),
		'admin'         => array( 'admin' ),
		'desc'          => '',
		'version'       => '1.0',
	), $args) );

	/** Define the Module Folder */

	if ( empty( $module_folder ) ) {
		$module_folder = TMP_MODULES  . "/module.{$module}";
	}

	/** Load Setup File */
	if ( defined('CLOUDFW_INSTALLING') && CLOUDFW_INSTALLING )
		if ( file_exists( $module_folder . '/module.setup.php' ) ) {
			$cloudfw_modules['inits'][ $module ][ 'setup' ] = $module_folder . '/module.setup.php';
		}

	/** Check if the module is exists */
	if ( isset( $cloudfw_found_modules[ $module ] ) ) {
		return;
	}

	if ( ! $_can_disabled ) {
		$_auto_register = true;
	}

	/** Add the module to found modules array */
	$module_options = array( 
		'id'             => $module,
		'title'          => $title,
		'desc'           => $desc,
		'_auto_register' => $_auto_register,
		'_can_disabled'  => $_can_disabled,
	);

	if ( $_can_disabled ) {
		$cloudfw_found_modules[ $module ] = $module_options;
	}
	else {
		$cloudfw_core_modules[] = $module;
	}

	/** Check if the module is enabled */
	if ( ! in_array( $module, (array) cloudfw_get_enabled_modules() ) && ! in_array( $module, (array) $cloudfw_core_modules ) ) {
		return;
	}

	/** Add the file paths into the init list */
	foreach ((array)$init as $init_key => $init_value) {
		$path = $module_folder . '/module.' . $init_value . '.php';

		if ( file_exists( $path ) ) {
			$cloudfw_modules['inits'][ $module ][ $init_value ] = $module_folder . '/module.' . $init_value . '.php';
		}
	}

	/** Add the file paths into the the list has included files */
	foreach ((array)$includes as $include_key => $include_value) {
		$path = $module_folder . '/module.' . $include_value . '.php'; 
		
		if ( file_exists( $path ) ) {
			$cloudfw_modules['includes'][ $module ][ $include_value ] = $module_folder . '/module.' . $include_value . '.php';
		}
	}

	if ( is_admin() ) {

		foreach ((array)$admin as $include_key => $include_value) {
			$path = $module_folder . '/module.' . $include_value . '.php'; 
			
			if ( file_exists( $path ) ) {
				$cloudfw_modules['admin'][ $module ][ $include_value ] = $module_folder . '/module.' . $include_value . '.php';
			}

		}

	}

}

/**
 *	Get Module
 *
 *	@since 3.0
 */
function cloudfw_get_modules(){
	global $cloudfw_modules;
	return $cloudfw_modules;
}


/**
 *	Init Modules
 *
 *	@since 3.0
 */
add_action( 'cloudfw_modules_init', 'cloudfw_init_modules' );
function cloudfw_init_modules(){
	$modules = cloudfw_get_modules();
	$inits = isset($modules['inits']) ? $modules['inits'] : NULL;
	$admins = isset($modules['admin']) ? $modules['admin'] : NULL;

	if ( $inits && is_array( $inits ) ) {	
		foreach ($inits as $module) {
			foreach ($module as $path) {
				include_once ( $path );
			}
		}
	}

	if ( $admins && is_array( $admins ) ) {	
		foreach ($admins as $module) {
			foreach ($module as $path) {
				include_once ( $path );
			}
		}
	}

}

/**
 *	Include Modules
 *
 *	@since 3.0
 */
add_action( 'cloudfw_modules', 'cloudfw_include_modules' );
function cloudfw_include_modules(){
	$modules = cloudfw_get_modules();
	$includes = isset($modules['includes']) ? $modules['includes'] : NULL;

	if ( $includes && is_array( $includes ) ) {	
		foreach ($includes as $module) {
			foreach ($module as $path) {
				include_once ( $path );

			}

		}

	}

}

/**
 *	Get Found Module
 *
 *	@since 3.0
 */
function cloudfw_get_found_modules(){
	global $cloudfw_found_modules;
	return $cloudfw_found_modules;
}

/**
 *	Get Disabled Module
 *
 *	@since 3.0
 */
function cloudfw_get_enabled_modules(){
	global $cloudfw_enabled_modules;

	if ( !isset( $cloudfw_enabled_modules ) )
		$cloudfw_enabled_modules = get_option( PFIX . '_enabled_modules' );

	return (array)$cloudfw_enabled_modules;
}

/**
 *	Check is module loaded
 *
 *	@return boolean
 *	@since 3.0
 */
if ( !function_exists('is_module_loaded') ) {
	function is_module_loaded( $module ){
		global  $cloudfw_found_modules,
				$cloudfw_enabled_modules,
				$cloudfw_core_modules;
		return ( in_array( $module, (array) cloudfw_get_enabled_modules() ) || in_array( $module, (array) $cloudfw_core_modules ) );
	}
} else { __debug( '<strong>is_module_loaded</strong> function is already exists.' ); }


/**
 *	Installing Modules
 *
 *	@since 3.0
 */
function cloudfw_modules_first_installation(){
	global  $cloudfw_found_modules;
	$registered_modules = get_option( PFIX . '_enabled_modules' );

	if ( $registered_modules !== false )
		return;

	$modules_to_register = array();

	foreach ($cloudfw_found_modules as $module => $module_options) {
		if ( $module_options['_auto_register'] )
			$modules_to_register[] = $module;
	}

	update_option( PFIX . '_enabled_modules', $modules_to_register );

	cloudfw_init_modules();
	cloudfw_include_modules();

	return $modules_to_register;
}