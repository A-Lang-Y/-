<?php 
	
	# Load Render Functions
	require_once(TMP_PATH.'/cloudfw/core/engine.render/core.render.php');
	
	
	$tab = isset($_GET['tab']) ? $_GET['tab'] : NULL;
	$this_page = CLOUDFW_PAGE;
	if ($tab) $this_page .= '&tab='.$tab ;
	
	# Call Theme Options
	global $_opt, $onloadscript, $vertical_subnavigation, $header_subnavigation;

	# Set Arguments
	$args = array(
		'current_page'	=> isset($current_page) ? $current_page : NULL,
		'this_page' 	=> isset($this_page) ? $this_page : NULL,
		'lastID'		=> isset($lastID) ? $lastID : NULL,
		'_opt'			=> isset($_opt) ? $_opt : NULL
	);
	
	cloudfw_render_page( isset($current_page_data['load_file']) ? $current_page_data['load_file'] : NULL, $args );
	
	$load_header = isset($current_page_data["load_header"]) ? $current_page_data["load_header"] : NULL;
	$load_footer = isset($current_page_data["load_footer"]) ? $current_page_data["load_footer"] : NULL;
	
	if ( ! (isset($load_header) && !$load_header) ):
?>


<?php 
		
	$header_title = isset($current_page_data['page_nice_title']) ? $current_page_data['page_nice_title'] : ( isset($current_page_data['page_title']) ? $current_page_data['page_title'] : __('No Title','cloudfw') );
	$sector_id = $current_page_data['page_css_id'];
	$header_subnavigation = cloudfw_prepare_tabs( $the_data, 'tabs' );
	$has_header_subnavigation = is_array($header_subnavigation) && !empty($header_subnavigation); 
	$vertical_subnavigation = cloudfw_prepare_tabs_vertical( $the_data );
	$has_vertical_subnavigation = is_array($vertical_subnavigation) && !empty($vertical_subnavigation); 

	if ( $has_vertical_subnavigation )
		$the_tabs = false;
	elseif ( $has_header_subnavigation )
		$the_tabs = $header_subnavigation;
	else
		$the_tabs = false;

	cloudfw_options_route_set( 'page', array(
		'title' => $current_page_data['page_title'],  
	) );

	/** If there is not vertical tab */
	$framework_classes = array();
	if( !$has_vertical_subnavigation ) {
		$vertical_subnavigation[] = array(
			'id'	=> 	'page_'. $current_page_data['page_slug'],
			'title'	=> 	$current_page_data['page_title'],
		);


		$framework_classes[] = 'no-vertical-tabs'; 
	}

	?>

<div id="framework" class="<?php echo cloudfw_make_class($framework_classes, 0); ?>">

	<?php

	if (isset($current_page_data["onload"]))
		$onloadscript	= $current_page_data["onload"];
	else
		$onloadscript = '';
		require (TMP_PATH.'/cloudfw/core/framework/cloudfw_header.php');
	endif;
	
	cloudfw_render_form_header(isset($current_page["form"]) ? $current_page["form"] : NULL, $args);

		if ($the_tabs) {
			echo '<div class="cloudfw-ui-tabs" rel="'. @md5(@serialize($the_tabs)) .'">';
			$tabs_align = isset($current_page_data['tabs_align']) ? $current_page_data['tabs_align'] : NULL;
			echo cloudfw_render_horizontal_tabs($the_tabs, $tabs_align);
		}	

			cloudfw_render_page( $the_data, $args );

		if ($the_tabs)
			echo '</div>';

	cloudfw_render_form_footer(isset($current_page["form"]) ? $current_page["form"] : NULL, $args);
	
?>
        
</div><!-- /#framework -->

<?php 
	if ( ! (isset($load_footer) && !$load_footer) )
		require (TMP_PATH.'/cloudfw/core/framework/cloudfw_footer.php');