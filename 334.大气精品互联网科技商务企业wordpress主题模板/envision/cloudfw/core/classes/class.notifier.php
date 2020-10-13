<?php

/**
 *  CloudFw Update Notifier
 *
 *  @version 1.0
 *  @since 3.0
 */
class CloudFw_Notifier {
	static  $cache_interval,
			$theme_folder,
			$update_page,
			$version_cache_field,
			$version_cache_field_time,
			$changelog_cache_field,
			$changelog_cache_field_time;

	private $json;
	public  $changelog;
	public  $latest_version;

	/**
	 *  __construct Function
	 *
	 *  @since 3.0
	 */
	function __construct( $check_now = false ) {
		self::$update_page = get_admin_url() . "index.php?page=CloudFw_Notifier";
		self::$version_cache_field = PFIX . '_notifier_json';
		self::$version_cache_field_time = PFIX . 'notifier_json_last_updated';

		self::$changelog_cache_field = PFIX . CLOUDFW_THEMEVERSION . '_clog_json';
		self::$changelog_cache_field_time = PFIX . CLOUDFW_THEMEVERSION . '_clog_json_time';
		
		$who_can_see =  cloudfw_get_option('framework', 'who_can_see');
		if ( ! ($who_can_see == get_current_user_id() || $who_can_see == 0 || !isset($who_can_see )) )
			return;

		if (function_exists('json_decode')) {

			if ( $check_now ) {
					$this->json           = $this->get_latest_theme_version(0);
					$this->latest_version = isset($this->json["version"]) && $this->json["version"] ? $this->json["version"] : '1.0';                   

			} else {

					self::$cache_interval = 10800;
					$this->json           = $this->get_latest_theme_version(self::$cache_interval);
					$this->latest_version = isset($this->json["version"]) && $this->json["version"] ? $this->json["version"] : '1.0';

					$this->dissmiss       = cloudfw_get_option('last_checked_version');

					if ( $this->latest_version == $this->dissmiss )
						return;

					if( $this->need_update() ) {
						if( !(isset($_GET['action']) && $_GET['action'] == 'CloudFw_Theme_Update') ) {
							add_action( 'admin_menu',            array( &$this, 'notifier_add_into_menu' ) );  
							add_action( 'admin_bar_menu',        array( &$this, 'notifier_add_into_bar_menu' ), 1000 );  
							add_action( 'admin_notices',         array( &$this, 'notifier_add_into_message' ), 1 );  
							add_action( 'network_admin_notices', array( &$this, 'notifier_add_into_message' ), 4 );  
						}
					}

			}
			
		}

	}

	/**
	 *  Need Update?
	 */
	function need_update() {
		return version_compare( $this->latest_version , CLOUDFW_THEMEVERSION, '>');
	}

	/**
	 *  Add menu item
	 */
	function notifier_add_into_message() {
		  printf ("<div id='version-message' class='cloudfw-update-messages updated'>%s</div>",
		  sprintf ("<div style='padding:15px;'>%s</div>", 
			sprintf ( __( CLOUDFW_THEMENAME . ' version %s is available.','cloudfw') , '<strong>'. $this->latest_version . '</strong>' ) . ' ( <strong><a class="cloudfw-upgrade-theme" href="'. cloudfw_upgrade_link() .'">'. sprintf(__('Upgrade to version %s now','cloudfw'), $this->latest_version) .'</a></strong> or <a href="'. self::$update_page .'">'. __('instructions and changelog','cloudfw') .'</a> )' . "<a style='float:right;' href='javascript:void(0);' onclick='cloudfw_dismiss_update_notification();'>".__("Dismiss",'cloudfw')."</a>"     
		  )
		);
		?>
		<script type="text/javascript">
		// <![CDATA[
			function cloudfw_dismiss_update_notification() {
			
				jQuery("#version-message").slideUp();
				
				jQuery.ajax({
				  type: 'POST',
				  url: CloudFwOp.ajaxUrl,
				  data: { action: 'cloudfw_last_theme_updates', x: 'dissmiss', version:'<?php echo $this->latest_version ?>', nonce: CloudFwOp.cloudfw_nonce},
				});
				
				jQuery(document).trigger('click');
				cloudfw_destroy();
				cloudfw_get_icon_list_close();
			}
		// ]]>
		</script>

	 <?php

	}

	/**
	 *  Add menu item
	 */
	function notifier_add_into_menu() {  
		add_dashboard_page( CLOUDFW_THEMENAME . ' Theme Updates', CLOUDFW_THEMENAME . ' <span class="update-plugins count-1"><span class="update-count">'. __('update','cloudfw') .'</span></span>', 'administrator', 'CloudFw_Notifier', array( &$this, 'notifier_page' ));
	}

	/**
	 *  Add menu item for updates
	 */
	function notifier_add_into_bar_menu() {
		global $wp_admin_bar;
	
		if ( !is_super_admin() || !is_admin_bar_showing() )
			return;
		
		$wp_admin_bar->add_menu( array( 'id' => 'notifier_page', 'title' => '<span>' . CLOUDFW_THEMENAME . ' <span id="ab-updates">'. __('update','cloudfw') .'</span></span>', 'href' => self::$update_page ) );

	}

	/**
	 *  Notifier Frontend Page
	 */
	function notifier_page() { 
		self::$theme_folder = basename( CLOUDFW_TMP_PATH );
		$this->changelog = $this->get_changelog(self::$cache_interval);

		if ( !empty($this->changelog) && is_array($this->changelog) ) {
			extract($this->changelog);
		}

	?>

		
		<style type="text/css">
			.update-nag,
			.cloudfw-update-messages { display: none !important; }
			#instructions {max-width: 670px; overflow: hidden;}
			#changelog, #changelog li { list-style-type: square; list-style-position: inside; }
			#changelog li { padding-left: 20px;}
			#changelog.infos > li { padding-bottom: 15px;}
			#changelog.infos > li > ul { padding-top: 7px;}
			#changelog.infos > li li { list-style-type: circle;}
			h3.title {margin: 30px 0 0 0; padding: 30px 0 0 0; border-top: 1px solid #ddd;}
		</style>

		<div class="wrap">
		
			<div id="icon-tools" class="icon32"></div>
			<h2><?php echo CLOUDFW_THEMENAME ?> <?php _e('Theme Updates','cloudfw'); ?></h2>
			<div id="message" class="updated below-h2"><p><strong>There is a new version of the <?php echo CLOUDFW_THEMENAME; ?> theme available.</strong> You have version <?php echo CLOUDFW_THEMEVERSION; ?> installed. Update to version <?php echo $this->latest_version; ?>.</p></div>

			<img style="float: left; margin: 0 20px 20px 0; border: 1px solid #ddd;" src="<?php echo TMP_URL . '/screenshot.png'; ?>" />
			
			<div id="instructions">
				<h3><?php _e('Update Download and Instructions','cloudfw'); ?></h3>
				<p><strong>Please note:</strong> make a <strong>backup</strong> of the Theme inside your WordPress installation folder <strong>/wp-content/themes/<?php echo self::$theme_folder; ?>/</strong></p>
				<p><strong>To upgrade the Theme manually</strong>, login to <a target="_blank" href="http://themeforest.net/">ThemeForest</a>, head over to your <strong>downloads</strong> section and re-download the theme like you did when you bought it.</p>
				<p>Extract the zip's contents, look for the extracted theme folder, and after you have all the new files upload them using FTP to the <strong>/wp-content/themes/<?php echo self::$theme_folder; ?>/</strong> folder overwriting the old ones (this is why it's important to backup any changes you've made to the theme files).</p>
				
				<p><strong>Also you can upgrade the theme automatically.</strong> To upgrade the theme auto, click the <em><?php printf(__('Upgrade to version %s now','cloudfw'), $this->latest_version); ?></em> button below. Your theme will be upgraded to the latest version and be created a backup file into <strong><?php echo cloudfw_only_folder_url( CACHE_DIR ) . 'backup/'; ?></strong> folder, that has the old versions of modified files with this version.</p>
				<p>If you didn't make any changes to the theme files, you are free to overwrite them with the new ones without the risk of losing theme settings, pages, posts, etc, and backwards compatibility is guaranteed.</p>
				<p>
					<?php echo '<a class="small-button small-green cloudfw-upgrade-theme" href="'. cloudfw_upgrade_link() .'"><span>'. sprintf(__('Upgrade to version %s now','cloudfw'), $this->latest_version).'</span></a>';?>
					<?php echo '<a class="small-button small-grey" target="_blank" href="http://themeforest.net/"><span>'. __('Download from ThemeForest','cloudfw').'</span></a>';?>
				</p>
			</div>

			
			<?php if ( !empty($version_info) ) { ?>
				<?php if (is_array($version_info) ) { asort( $version_info ) ?>
				<h3 class="title"><?php printf(__('Changelogs from version %s to %s','cloudfw'), CLOUDFW_THEMEVERSION, $this->latest_version); ?></h3>
				<ul id="changelog" class="infos">
					<?php foreach ($version_info as $version => $info) {
						if ( !empty($info) ) {
							echo '<li><strong>'. sprintf(__('Changelog for version %s','cloudfw'), $version) . '</strong>';
								echo stripslashes($info);
							echo '</li>';
						}

					}  ?>
				</ul>
				<div style="margin-bottom: -15px;"></div>
				<?php } ?>
			<?php } ?>

			<?php if( is_array($modified) && !empty($modified) ) { ?>
			<h3 class="title"><?php _e('Modified Files','cloudfw'); ?></h3>
			<ul id="changelog">
				<?php foreach ($modified as $file) {
					echo "<li><code>{$file}</code></li>\n";
				}  ?>
			</ul>
			<?php } ?>

			<?php if( is_array($added) && !empty($added) ) { ?>
			<h3 class="title"><?php _e('Added Files','cloudfw'); ?></h3>
			<ul id ="changelog">
				<?php foreach ($added as $file) {
					echo "<li><code>{$file}</code></li>\n";
				}  ?>
			</ul>
			<?php } ?>

			<?php if( is_array($missing) && !empty($missing) ) { ?>
			<h3 class="title"><?php _e('Deleted Files','cloudfw'); ?></h3>
			<ul id="changelog">
				<?php foreach ($missing as $file) {
					echo "<li><code>{$file}</code></li>\n";
				}  ?>
			</ul>
			<?php } ?>



		</div>
		
	<?php } 


	/**
	 *  Gets Changelog Url
	 */
	function version_url(){
		$url  = 'http://updates.wptation.com/json/';
		$url .= CLOUDFW_THEMEID . '/';
		$url .= 'version.json';

		return apply_filters('cloudfw_theme_version_url', $url, CLOUDFW_THEMEID);
	}

	/**
	 *  Get the theme version
	 */
	function get_latest_theme_version( $interval ) {
		$default_data = '{"product":"'. CLOUDFW_THEMEID .'","version":"1.0"}';

		$last = get_option( self::$version_cache_field_time );
		$now = time();

		if ( !$interval )
			$interval = 60;

		if ( !$last || (( $now - $last ) > $interval) ) {

			$notifier_file_url = $this->version_url();

			$args['timeout'] = 10;
			$args['header'] = 0;
			$args['returntransfer'] = TRUE;

			if ( !is_wp_error( $response = wp_remote_request( $notifier_file_url, $args ) ) ) {
				$data = wp_remote_retrieve_body( $response ); 
			} else {
				$data = '';
			}

			if ( $this->is_json( $data ) ){
				update_option( self::$version_cache_field, $data );
				update_option( self::$version_cache_field_time, time() );
			} else {
				update_option( self::$version_cache_field, $default_data );
			}

			update_option( self::$version_cache_field_time, time() );               
			$notifier_data = $data;
		}
		else {
			$notifier_data = get_option( self::$version_cache_field );
		}

		if ( empty($notifier_data) || !$this->is_json( $notifier_data ) )
			$notifier_data = $default_data; 


		try {
			$json = json_decode($notifier_data, true); 

		} catch (Exception $e) {
			$json = json_decode($default_data, true); 
		}
		
		return $json;
	}

	/**
	 *  Gets Changelog Url
	 */
	function changelog_url(){
		$latest = isset($this->latest_version) && $this->latest_version ? $this->latest_version : 'latest';

		$url  = 'http://updates.wptation.com/changelog/';
		$url .= CLOUDFW_THEMEID . '/';
		$url .= CLOUDFW_THEMEVERSION . '/';
		$url .= 'to/';
		$url .= $latest . '/';

		return apply_filters('cloudfw_theme_changelog_url', $url, CLOUDFW_THEMEID, CLOUDFW_THEMEVERSION, $latest);
	}

	/**
	 *  Gets the theme changelog
	 */
	function get_changelog( $interval ) {
		$changelog_file_url = $this->changelog_url();

		$last = get_option( self::$changelog_cache_field_time );
		$now = time();

		if ( !$last || (( $now - $last ) > $interval) ) {

			$args['timeout'] = 10;
			$args['header'] = 0;
			$args['returntransfer'] = TRUE;

			if ( !is_wp_error( $response = wp_remote_request( $changelog_file_url, $args ) ) ) {
				$data = wp_remote_retrieve_body( $response ); 
			} else {
				$data = cloudfw_get_file_contents( $changelog_file_url );
			}

			if ( $this->is_json( $data ) ){
				update_option( self::$changelog_cache_field, $data );
				update_option( self::$changelog_cache_field_time, time() );
			} else {
				update_option( self::$changelog_cache_field, $default_data );
			}

			update_option( self::$changelog_cache_field_time, time() );             
			$changelog_data = $data;
		}
		else {
			$changelog_data = get_option( self::$changelog_cache_field );
		}

		try {
			$json = json_decode($changelog_data, true); 

		} catch (Exception $e) {
			$json = array(); 
		}
		
		return $json;
	}

	function is_json($string) {
		try {
			json_decode($string);
			return true;            
		} catch (Exception $e) {
			return false;
		}
	}

}

if ( ( _check_onoff( cloudfw_get_option( 'cloudfw_actives', 'autocheck' ) ) && !is_multisite() ) ||
	 ( _check_onoff( cloudfw_get_option( 'cloudfw_actives', 'autocheck' ) ) && is_multisite() && is_super_admin() )  )
	$CloudFw_Notifier = new CloudFw_Notifier;

