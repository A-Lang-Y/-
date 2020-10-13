<?php
/**
 * A unique identifier is defined to store the options in the database and reference them from the theme.
 * By default it uses the theme name, in lowercase and without spaces, but this can be changed if needed.
 * If the identifier changes, it'll appear as if the options have been reset.
 */

function optionsframework_option_name() {

	// This gets the theme name from the stylesheet
	$themename = wp_get_theme();
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

	$options = array();
	$imagepath =  get_template_directory_uri() . '/images/';
		
	
	//Basic Settings
	
	$options[] = array(
		'name' => __('Basic Settings', 'options_framework_theme'),
		'type' => 'heading');
			

	$options[] = array(
		'name' => __('Custom Code in Header', 'options_framework_theme'),
		'desc' => __('Insert scripts or code before the closing &lt;/head&gt; tag in the document source:', 'options_framework_theme'),
		'id' => 'headcode1',
		'std' => '',
		'type' => 'textarea');
		
	$options[] = array(
		'name' => __('Custom Code in Footer', 'options_framework_theme'),
		'desc' => __('Insert scripts or code before the closing &lt;/body&gt; tag in the document source:', 'options_framework_theme'),
		'id' => 'footercode1',
		'std' => '',
		'type' => 'textarea');	
		
	$options[] = array(
		'name' => __('Copyright Text', 'options_framework_theme'),
		'desc' => __('Some Text regarding copyright of your site, you would like to display in the footer.', 'options_framework_theme'),
		'id' => 'footertext2',
		'std' => '',
		'type' => 'textarea');
		
		$options[] = array(
		'desc' => __('To have more customization options <a href="http://inkhive.com/product/sixteen-plus" target="_blank">Upgrade to Pro</a> at Just $24.95'),
		'std' => '',
		'type' => 'info');
		
	//Layout Settings
		
	$options[] = array(
		'name' => __('Layout Settings', 'options_framework_theme'),
		'type' => 'heading');	
	
	$options[] = array(
		'name' => "Sidebar Layout",
		'desc' => "Select Layout for Posts & Pages.",
		'id' => "sidebar-layout",
		'std' => "right",
		'type' => "images",
		'options' => array(
			'left' => $imagepath . '2cl.png',
			'right' => $imagepath . '2cr.png')
	);
	
	$options[] = array(
		'desc' => __('<a href="http://inkhive.com/product/sixteen-plus" target="_blank">Pro Version</a> supports the option to add custom themes, styles & Layouts. Upgrade at Just $24.95.'),
		'std' => '',
		'type' => 'info');
	
	$options[] = array(
		'name' => __('Custom CSS', 'options_framework_theme'),
		'desc' => __('Some Custom Styling for your site. Place any css codes here instead of the style.css file.', 'options_framework_theme'),
		'id' => 'style2',
		'std' => '',
		'type' => 'textarea');
	
	//SLIDER SETTINGS

	$options[] = array(
		'name' => __('Slider Settings', 'options_framework_theme'),
		'type' => 'heading');

	$options[] = array(
		'name' => __('Enable Slider', 'options_framework_theme'),
		'desc' => __('Check this to Enable Slider.', 'options_framework_theme'),
		'id' => 'slider_enabled',
		'type' => 'checkbox',
		'std' => '0' );
		
	$options[] = array(
		'desc' => __('This Slider supports upto 5 Images. To show only 3 Slides in the slider, upload only 3 images. Leave the rest Blank. For best results, upload images of width 1180px.', 'options_framework_theme'),
		'type' => 'info');
		
	$options[] = array(
		'desc' => __('In the <a href="http://inkhive.com/product/sixteen-plus" target="_blank">Pro Version (Sixteen Plus)</a> there are options to customize slider by choosing form over 16 animation effects, ability to set transition time and speed and more. Upgrade at Just $24.95'),
		'std' => '',
		'type' => 'info');	

	$options[] = array(
		'name' => __('Slider Image 1', 'options_framework_theme'),
		'desc' => __('First Slide', 'options_framework_theme'),
		'id' => 'slide1',
		'class' => '',
		'type' => 'upload');
	
	$options[] = array(
		'desc' => __('Title', 'options_framework_theme'),
		'id' => 'slidetitle1',
		'std' => '',
		'type' => 'text');
	
	$options[] = array(
		'desc' => __('Description or Tagline', 'options_framework_theme'),
		'id' => 'slidedesc1',
		'std' => '',
		'type' => 'textarea');			
		
	$options[] = array(
		'desc' => __('Url', 'options_framework_theme'),
		'id' => 'slideurl1',
		'std' => '',
		'type' => 'text');		
	
	$options[] = array(
		'name' => __('Slider Image 2', 'options_framework_theme'),
		'desc' => __('Second Slide', 'options_framework_theme'),
		'class' => '',
		'id' => 'slide2',
		'type' => 'upload');
	
	$options[] = array(
		'desc' => __('Title', 'options_framework_theme'),
		'id' => 'slidetitle2',
		'std' => '',
		'type' => 'text');	
	
	$options[] = array(
		'desc' => __('Description or Tagline', 'options_framework_theme'),
		'id' => 'slidedesc2',
		'std' => '',
		'type' => 'textarea');		
		
	$options[] = array(
		'desc' => __('Url', 'options_framework_theme'),
		'id' => 'slideurl2',
		'std' => '',
		'type' => 'text');	
		
	$options[] = array(
		'name' => __('Slider Image 3', 'options_framework_theme'),
		'desc' => __('Third Slide', 'options_framework_theme'),
		'id' => 'slide3',
		'class' => '',
		'type' => 'upload');	
	
	$options[] = array(
		'desc' => __('Title', 'options_framework_theme'),
		'id' => 'slidetitle3',
		'std' => '',
		'type' => 'text');	
		
	$options[] = array(
		'desc' => __('Description or Tagline', 'options_framework_theme'),
		'id' => 'slidedesc3',
		'std' => '',
		'type' => 'textarea');	
			
	$options[] = array(
		'desc' => __('Url', 'options_framework_theme'),
		'id' => 'slideurl3',
		'std' => '',
		'type' => 'text');		
	
	$options[] = array(
		'name' => __('Slider Image 4', 'options_framework_theme'),
		'desc' => __('Fourth Slide', 'options_framework_theme'),
		'id' => 'slide4',
		'class' => '',
		'type' => 'upload');	
		
	$options[] = array(
		'desc' => __('Title', 'options_framework_theme'),
		'id' => 'slidetitle4',
		'std' => '',
		'type' => 'text');
	
	$options[] = array(
		'desc' => __('Description or Tagline', 'options_framework_theme'),
		'id' => 'slidedesc4',
		'std' => '',
		'type' => 'textarea');			
		
	$options[] = array(
		'desc' => __('Url', 'options_framework_theme'),
		'id' => 'slideurl4',
		'std' => '',
		'type' => 'text');		
	
	$options[] = array(
		'name' => __('Slider Image 5', 'options_framework_theme'),
		'desc' => __('Fifth Slide', 'options_framework_theme'),
		'id' => 'slide5',
		'class' => '',
		'type' => 'upload');	
		
	$options[] = array(
		'desc' => __('Title', 'options_framework_theme'),
		'id' => 'slidetitle5',
		'std' => '',
		'type' => 'text');	
	
	$options[] = array(
		'desc' => __('Description or Tagline', 'options_framework_theme'),
		'id' => 'slidedesc5',
		'std' => '',
		'type' => 'textarea');		
		
	$options[] = array(
		'desc' => __('Url', 'options_framework_theme'),
		'id' => 'slideurl5',
		'std' => '',
		'type' => 'text');	
			
	//Social Settings
	
	$options[] = array(
		'name' => __('Social Settings', 'options_framework_theme'),
		'type' => 'heading');
	
	$options[] = array(
		'desc' => __('Please set the value of following fields, as per the instructions given along. If you do not want to use an icon, just leave it blank. If some icons are showing up, even when no value is set then make sure they are completely blank, and just save the options once. They will not be shown anymore.', 'options_framework_theme'),
		'type' => 'info');

	$options[] = array(
		'name' => __('Facebook', 'options_framework_theme'),
		'desc' => __('Facebook Profile or Page URL i.e. http://facebook.com/username/ ', 'options_framework_theme'),
		'id' => 'facebook',
		'std' => '',
		'class' => 'mini',
		'type' => 'text');
	
	$options[] = array(
		'name' => __('Twitter', 'options_framework_theme'),
		'desc' => __('Twitter Username', 'options_framework_theme'),
		'id' => 'twitter',
		'std' => '',
		'class' => 'mini',
		'type' => 'text');
	
	$options[] = array(
		'name' => __('Google Plus', 'options_framework_theme'),
		'desc' => __('Google Plus profile url, including "http://"', 'options_framework_theme'),
		'id' => 'google',
		'std' => '',
		'class' => 'mini',
		'type' => 'text');
		
	$options[] = array(
		'name' => __('Feedburner', 'options_framework_theme'),
		'desc' => __('URL for your RSS Feeds', 'options_framework_theme'),
		'id' => 'feedburner',
		'std' => '',
		'class' => 'mini',
		'type' => 'text');	

	$options[] = array(
		'name' => __('Instagram', 'options_framework_theme'),
		'desc' => __('URL of your Instagram Profile', 'options_framework_theme'),
		'id' => 'instagram',
		'std' => '',
		'class' => 'mini',
		'type' => 'text');	

	$options[] = array(
		'name' => __('Flickr', 'options_framework_theme'),
		'desc' => __('URL for your Flickr Profile', 'options_framework_theme'),
		'id' => 'flickr',
		'std' => '',
		'class' => 'mini',
		'type' => 'text');
		
	$options[] = array(
		'desc' => __('More social Icons are available in the <a href="http://inkhive.com/product/sixteen-plus" target="_blank">Pro Version (Sixteen Plus)</a>. Upgrade at Just $24.95'),
		'std' => '',
		'type' => 'info');			
						
	$options[] = array(
	'name' => __('Support', 'options_framework_theme'),
	'type' => 'heading');
	
	$options[] = array(
		'desc' => __('Sixteen WordPress theme has been Designed and Created by <a href="http://inkhive.com" target="_blank">Rohit Tripathi</a>. For any Queries or help regarding this theme, <a href="http://inkhive.com/forums/section/theme-support/sixteen" target="_blank">use our support forum.</a> You can also ask questions about this theme on WordPress.org Support Forums. I will answer your queries there too.', 'options_framework_theme'),
		'type' => 'info');	
		
	 $options[] = array(
		'desc' => __('<a href="http://twitter.com/rohitinked" target="_blank">Follow Me on Twitter</a> to know about my upcoming themes.', 'options_framework_theme'),
		'type' => 'info');	
	
	$options[] = array(
		'desc' => __('We Offer Dedicated Personal Support to all our <a href="http://inkhive.com/product/sixteen-plus" target="_blank">Pro Version Customers</a>. Upgrade at Just $24.95'),
		'std' => '',
		'type' => 'info');		
		
		
	
	$options[] = array(
		'name' => __('Live Demo Blog', 'options_framework_theme'),
		'desc' => __('I have created a  <a href="http://wpdemo.rohitink.com/sixteen/" target="_blank">Live Demo Blog</a> of this theme so that you know how it will look once ready.'),
		'std' => '',
		'type' => 'info');	
	
	$options[] = array(
		'name' => __('Regenerating Post Thumbnails', 'options_framework_theme'),
		'desc' => __('If you are using Sixteen Theme on a New Wordpress Installation, then you can skip this section.<br />But if you have just switched to this theme from some other theme, or just updated to the current version of Sixteen, then you are requested regenerate all the post thumbnails. It will fix all the isses you are facing with distorted & ugly homepage thumbnail Images. ', 'options_framework_theme'),
		'type' => 'info');	
		
	$options[] = array(
		'desc' => __('To Regenerate all Thumbnail images, Install and Activate the <a href="http://wordpress.org/plugins/regenerate-thumbnails/" target="_blank">Regenerate Thumbnails</a> WP Plugin. Then from <strong>Tools &gt; Regen. Thumbnails</strong>, re-create thumbnails for all your existing images. And your blog will look even more stylish with Sixteen theme.<br /> ', 'options_framework_theme'),
		'type' => 'info');	
		
			
	$options[] = array(
		'desc' => __('<strong>Note:</strong> Regenerating the thumbnails, will not affect your original images. It will just generate a separate image file for those images.', 'options_framework_theme'),
		'type' => 'info');	
		
	
	$options[] = array(
		'name' => __('Theme Credits', 'options_framework_theme'),
		'desc' => __('Check this if you want to you do not want to give us credit in your site footer.', 'options_framework_theme'),
		'id' => 'credit1',
		'std' => '0',
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => __('Upgrade to Pro', 'options_framework_theme'),
		'type' => 'heading');
	
	$options[] = array(
		'desc' => __('To Upgrade to Sixteen Plus and unlock plenty of features in this theme, please visit <a href="http://inkhive.com/product/sixteen-plus" target="_blank">this link</a>. Upgrade at Just $24.95'),
		'std' => '',
		'type' => 'info');	
		
	$options[] = array(
		'desc' => __('Use the coupon code: <strong>BYEBYE2013</strong> to get a discount of 30%.'),
		'std' => '',
		'type' => 'info');	
		
	$options[] = array(
		'desc' => __('For any queries, you can <a href="http://inkhive.com/contact-us/" target="_blank">contact us</a>.'),
		'std' => '',
		'type' => 'info');				

	return $options;
}