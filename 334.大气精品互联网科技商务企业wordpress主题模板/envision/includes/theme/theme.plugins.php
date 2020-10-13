<?php

add_action( 'tgmpa_register', 'cloudfw_register_required_plugins' );
function cloudfw_register_required_plugins() {

	$min_version_message = '<a href="' . cloudfw_admin_url( 'modules' ) . '#plugins">'. __('%s (v.%s)','cloudfw') .'</a>'; 

	$plugins = array(
		array(
			'name'     				=> 'Slider Revolution',
			'slug'     				=> 'revslider',
			'source'   				=> TMP_INCLUDES . '/plugins/revslider.zip',
			'required' 				=> false,
			'force_activation' 		=> false,
			'force_deactivation' 	=> false,
			'external_url' 			=> '',
		),

		array(
			'name'     				=> 'Envision - Custom Login Pages',
			'slug'     				=> 'wpt-login',
			'source'   				=> TMP_INCLUDES . '/plugins/wpt-login.zip',
			'version' 				=> '1.0.0',
			'required_version'		=> true,
			'min_version_message'	=> $min_version_message,
			'required' 				=> false,
			'force_activation' 		=> false,
			'force_deactivation' 	=> false,
			'external_url' 			=> '',
		),

		array(
        	'name'      			=> 'Contact Form 7',
        	'slug'     				=> 'contact-form-7',
        	'required'  			=> false,
			'force_activation' 		=> false,
			'force_deactivation' 	=> false,

        ),

		array(
        	'name'      			=> 'WooCommerce',
        	'slug'     				=> 'woocommerce',
        	'required'  			=> false,
			'force_activation' 		=> false,
			'force_deactivation' 	=> false,

        ),
	);

	$config = array(
		'domain'       		=> 'cloudfw',         			// Text domain - likely want to be the same as your theme.
		'default_path' 		=> '',							// Default absolute path to pre-packaged plugins
		'parent_menu_slug' 	=> 'themes.php', 				// Default parent menu slug
		'parent_url_slug' 	=> 'themes.php', 				// Default parent URL slug
		'menu'         		=> 'install-required-plugins', 	// Menu slug
		'has_notices'      	=> true,                       	// Show admin notices or not
		'is_automatic'    	=> true,					   	// Automatically activate plugins after installation or not
		'message' 			=> '',							// Message to output right before the plugins table
		'strings'      		=> array(
			'page_title'                       			=> __( 'Install Required Plugins', 'cloudfw' ),
			'menu_title'                       			=> __( 'Install Plugins', 'cloudfw' ),
			'installing'                       			=> __( 'Installing Plugin: %s', 'cloudfw' ), // %1$s = plugin name
			'oops'                             			=> __( 'Something went wrong with the plugin API.', 'cloudfw' ),
			'notice_can_install_required'     			=> _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.' ), // %1$s = plugin name(s)
			'notice_can_install_recommended'			=> _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.' ), // %1$s = plugin name(s)
			'notice_cannot_install'  					=> _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.' ), // %1$s = plugin name(s)
			'notice_can_activate_required'    			=> _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s)
			'notice_can_activate_recommended'			=> _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s)
			'notice_cannot_activate' 					=> _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.' ), // %1$s = plugin name(s)
			'notice_ask_to_update' 						=> _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.' ), // %1$s = plugin name(s)
			'notice_cannot_update' 						=> _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.' ), // %1$s = plugin name(s)
			'install_link' 					  			=> _n_noop( 'Begin installing plugin', 'Begin installing plugins' ),
			'activate_link' 				  			=> _n_noop( 'Activate installed plugin', 'Activate installed plugins' ),
			'return'                           			=> __( 'Return to Required Plugins Installer', 'cloudfw' ),
			'plugin_activated'                 			=> __( 'Plugin activated successfully.', 'cloudfw' ),
			'complete' 									=> __( 'All plugins installed and activated successfully. %s', 'cloudfw' ), // %1$s = dashboard link
			'nag_type'									=> 'updated' // Determines admin notice type - can only be 'updated' or 'error'
		)
	);

	tgmpa( $plugins, $config );

}


if ( is_admin() ) {



}