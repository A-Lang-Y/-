<?php
/**
 * A unique identifier is defined to store the options in the database and reference them from the theme.
 * By default it uses the theme name, in lowercase and without spaces, but this can be changed if needed.
 * If the identifier changes, it'll appear as if the options have been reset.
 */
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
 
function optionsframework_option_name() {

	// This gets the theme name from the stylesheet
	$themename = get_option( 'stylesheet' );
	$themename = preg_replace("/\W/", "_", strtolower($themename) );

	$optionsframework_settings = get_option( 'optionsframework' );
	$optionsframework_settings['id'] = $themename;
	update_option( 'optionsframework', $optionsframework_settings );
}

/**
 * Defines an array of options that will be used to generate the settings page and be saved in the database.
 * When creating the 'id' fields, make sure to use all lowercase and no spaces.
 *
 * If you are making your theme translatable, you should replace 'options_framework_theme'
 * with the actual text domain for your theme.  Read more:
 * http://codex.wordpress.org/Function_Reference/load_theme_textdomain
 */

function optionsframework_options() {
	
	// Color schemes
	$color_scheme = array("red" => __('Red', 'corpo'), "green" => __('Green', 'corpo'), "blue" => __('Blue', 'corpo'), "sandy" =>__('Sandy', 'corpo'), "yellow" =>__('Yellow', 'corpo'),  "cherry" =>__('Cherry', 'corpo'),  "orange" =>__('Orange', 'corpo'));

	$radio = array("0" => __('No', 'corpo'),"1" => __('Yes', 'corpo'));

	// Pull all the categories into an array
	$options_categories = array();  
    $args = array();
	$options_categories_obj = get_categories( );

	foreach ($options_categories_obj as $category) {
    	$options_categories[$category->cat_ID] = $category->cat_name;
	}

	// Pull all the pages into an array
	$options_pages = array();  
	$options_pages_obj = get_pages('sort_column=post_parent,menu_order');
	$options_pages[''] = 'Select a page:';
	foreach ($options_pages_obj as $page) {
    	$options_pages[$page->ID] = $page->post_title;
	}
		
	// If using image radio buttons, define a directory path
	$imagepath =  get_stylesheet_directory_uri() . '/images/';
		
	$options = array();
		
	$options[] = array( "name" => __('Basic settings', 'corpo'),
						"type" => "heading");					

	$options[] = array( "name" => __('Color scheme', 'corpo'),
						"desc" => __('Select color scheme.', 'corpo'),
						"id" => "corpo_color_scheme",
						"std" => "red",
						"type" => "select",
						"class" => "mini", //mini, tiny, small
						"options" => $color_scheme);

    $options[] = array( "name" => __('Custom logo image', 'corpo'),
						"desc" => __('You can upload custom image for your website logo (optional).', 'corpo'),
						"id" => "corpo_logo_image",
						"type" => "upload");
                        
	$options[] = array( "name" => __('Blog Header', 'corpo'),
						"desc" => __('Do you want to display Blog header on blog pages?', 'corpo'),
						"id" => "corpo_blogheader_radio",
                        "std" => 0,
						"type" => "select",
                        "class" => "hidden_control",                        
                        "options" => $radio);
                        
	$options[] = array( "name" => __('Custom Blog Header', 'corpo'),
						"desc" => __('If you choose to display blog header, you can set up your own custom title. Default title is "Blog".', 'corpo'),
						"id" => "corpo_blogheader",
                        "std" => __('Blog', 'corpo'),
						"type" => "text",
                        "class" => "medium hidden");    

    if ( is_plugin_active( 'corpo_toolkit/corpo_toolkit.php' ) ) :
    
    $options[] = array( "name" => __('Portfolio Page Title', 'corpo'),
						"id" => "corpo_portfolio_title",
                        "std" => __('Portfolio', 'corpo'),
						"type" => "text",
                        "class" => "medium");    
    
    $options[] = array( "name" => __('Portfolio intro text','corpo'),
						"id" => "corpo_portfolio_intro",
                        "desc" => __('This text will be displayed on Portfolio main page','corpo'),
						"std" => "",
						"type" => "editor");
    endif;
                            
	$options[] = array( "name" => __('Home Page', 'corpo'),
						"type" => "heading");							

	$options[] = array( "name" => __('Enable Custom Front Page', 'corpo'),
						"id" => "corpo_hp_style",
                        "desc" => __('Overrides WordPress <a href="options-reading.php">front page setting</a>','corpo'),
						"std" => 0,
						"type" => "select",
						"options" => $radio);

    if ( is_plugin_active( 'corpo_toolkit/corpo_toolkit.php' ) ) :
						
	$options[] = array( "name" => __('Do You want to display image slider on the Home Page?','corpo'),
						"id" => "corpo_slider_radio",
                        "desc" => __('Pertains only to Custom Home Page','corpo'),
						"std" => 1,
						"type" => "radio",
						"options" => $radio);
    endif;
    
    $options[] = array( "name" => __('Home Page Callout section', 'corpo'),
						"id" => "corpo_callout",
                        "desc" => __('If you leave this field empty, the callout section will not be displayed.','corpo'),
						"std" => "<h3>Welcome!</h3><p>You need to configure your Home Page! Please visit Theme Options Page.</p>[button color='red' size='medium' url='http://']Sample button[/button]",
						"type" => "textarea"); 

    if ( is_plugin_active( 'corpo_toolkit/corpo_toolkit.php' ) ) :
    
    $options[] = array( "name" => __('Do you want to display latest projects section on the Home Page?','corpo'),
						"id" => "corpo_hp_projects",
                        "desc" => __('Pertains only to Custom Home Page','corpo'),
						"std" => 1,
						"type" => "radio",
						"options" => $radio);

    $options[] = array( "name" => __('Latest projects section header', 'corpo'),
						"id" => "corpo_projects_section_header",
                        "std" => __('Latest Projects', 'corpo'),
						"type" => "text");                         
    endif;
                        
	$options[] = array( "name" => __('Social Media', 'corpo'),
						"type" => "heading");		

    $options[] = array( "name" => __('Phone number', 'corpo'),
						"id" => "corpo_social_phone",
                        "desc" => __('Phone number is displayed in the top left corner of the page.', 'corpo'),
						"type" => "text");                         

    $options[] = array( "name" => __('Facebook URL', 'corpo'),
						"id" => "corpo_social_fb",
						"type" => "text");                         

    $options[] = array( "name" => __('Twitter URL', 'corpo'),
						"id" => "corpo_social_twitter",
						"type" => "text");                         

    $options[] = array( "name" => __('Google+ URL', 'corpo'),
						"id" => "corpo_social_gp",
						"type" => "text");                         

    $options[] = array( "name" => __('RSS URL', 'corpo'),
						"id" => "corpo_social_rss",
						"type" => "text");                         
                        
    $options[] = array( "name" => __('Flickr URL', 'corpo'),
						"id" => "corpo_social_flickr",
						"type" => "text");                         

    $options[] = array( "name" => __('YouTube Page URL', 'corpo'),
						"id" => "corpo_social_youtube",
						"type" => "text");                         

    $options[] = array( "name" => __('Dribble URL', 'corpo'),
						"id" => "corpo_social_dribble",
						"type" => "text");                         

    $options[] = array( "name" => __('LinkedIn URL', 'corpo'),
						"id" => "corpo_social_linkedin",
						"type" => "text");                         

    $options[] = array( "name" => __('Pinterest URL', 'corpo'),
						"id" => "corpo_social_pinterest",
						"type" => "text"); 
                        
    $options[] = array( "name" => __('Vimeo URL', 'corpo'),
						"id" => "corpo_social_vimeo",
						"type" => "text");                         

    $options[] = array( "name" => __('Tumblr  URL', 'corpo'),
						"id" => "corpo_social_tumblr",
						"type" => "text");                         

    $options[] = array( "name" => __('Behance URL', 'corpo'),
						"id" => "corpo_social_behance",
						"type" => "text");                         
                        
    $options[] = array( "name" => __('Picasa URL', 'corpo'),
						"id" => "corpo_social_picassa",
						"type" => "text");                         

    $options[] = array( "name" => __('Deviant Art URL', 'corpo'),
						"id" => "corpo_social_deviantart",
						"type" => "text");                         
                       
                        
    return $options;
}