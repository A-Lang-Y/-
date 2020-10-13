<?php
/** Set first installation */
cloudfw_modules_first_installation();
cloudfw_reset_options();

/** Font Options */
$font_map = cloudfw_get_content_maps("font_map_setup");
if (!empty($font_map)) {
	update_option(PFIX.'_font_engine', $font_map);
}

require_once(TMP_PATH.'/cloudfw/core/engine.dummy/core.dummy.php');
$importer = new CloudFw_Import_Dummy();
$importer->import_default_skins();

add_action( 'init', 'cloudfw_theme_setup_default_widgets', 100 );
function cloudfw_theme_setup_default_widgets() {
	require_once(TMP_PATH.'/cloudfw/core/engine.dummy/core.dummy.php');
	$importer = new CloudFw_Import_Dummy();
	$importer->import_widgets('setup');
}

add_action( 'wp_loaded', 'cloudfw_redirect_to_theme_dashboard' );
function cloudfw_redirect_to_theme_dashboard() {
	global $cloudfw_setting_slug;
	
	wp_redirect(admin_url('admin.php?page=' . $cloudfw_setting_slug . '&w=cloudfw_activated'));
	exit;
}



update_option(PFIX . '_already_installed', TRUE);

add_action( 'admin_notices', 'cloudfw_theme_installed_message', 5 );
function cloudfw_theme_installed_message() {

	printf ("<div id='cloudfw-update-message' class='updated'>%s</div>",
		sprintf ("<div style='padding:15px;'>%s</div>", 
			sprintf (__("Theme installed","cloudfw"))
		)
	);

}
