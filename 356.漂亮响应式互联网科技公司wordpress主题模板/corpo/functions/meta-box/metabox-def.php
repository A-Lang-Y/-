<?php
/**
 * Registering meta boxes
 *
 * For more information, please visit:
 * @link http://www.deluxeblogtips.com/meta-box/
 */

/********************* META BOX DEFINITIONS ***********************/

/**
 * Prefix of meta keys (optional)
 * Use underscore (_) at the beginning to make keys hidden
 * Alt.: You also can make prefix empty to disable it
 */
// Better has an underscore as last sign
$prefix = 'corpo_';

global $corpo_meta_boxes;

$corpo_meta_boxes = array();

// 1st meta box
$corpo_meta_boxes[] = array(
	'id' => 'corpo_portfolio_gallery',
	'title' => __( 'Portfolio Gallery', 'corpo' ),
	'pages' => array( 'corpo_portfolio' ),

	// Where the meta box appear: normal (default), advanced, side. Optional.
	'context' => 'normal',

	// Order of meta box: high (default), low. Optional.
	'priority' => 'high',

	// Auto save: true, false (default). Optional.
	'autosave' => true,

	// List of meta fields
	'fields' => array(
		// IMAGE ADVANCED (WP 3.5+)
		array(
			'name'             => __( 'Project gallery', 'corpo' ),
			'id'               => "{$prefix}imgadv",
			'type'             => 'image_advanced',
			'max_file_uploads' => 10,
		),
	)

);

$corpo_meta_boxes[] = array(

	'title' => __( 'Project Details', 'corpo' ),
	'id' => 'corpo_project_details',
	'pages' => array( 'corpo_portfolio' ),
	'context' => 'side',
	'priority' => 'core',
	'autosave' => true,

	'fields' => array(
        // TEXT
		array(
			'name'  => __( 'Client', 'corpo' ),
			'id'    => "{$prefix}projectClient",
			'type'  => 'text',
		),
        // TEXT
		array(
			'name'  => __( 'Project Date', 'corpo' ),
			'id'    => "{$prefix}projectDate",
            'desc'  => __('For example: August 2012', 'corpo' ),
			'type'  => 'text',
		),
		// URL
		array(
			'name'  => __( 'Project URL', 'corpo' ),
			'id'    => "{$prefix}projectURL",
			'type'  => 'url',
			'std'   => '',
		),
	)
);

$corpo_meta_boxes[] = array(

	'title' => __( 'Slide Options', 'corpo' ),
	'id' => 'corpo_slide_options',
	'pages' => array( 'corpo_slider' ),
	'context' => 'side',
	'priority' => 'high',
	'autosave' => true,

	'fields' => array(
		// URL
		array(
			'name'  => __( 'Slide URL', 'corpo' ),
			'id'    => "{$prefix}slideURL",
			'type'  => 'url',
			'std'   => '',
		),
	)
);


/********************* META BOX REGISTERING ***********************/

/**
 * Register meta boxes
 *
 * @return void
 */
function corpo_register_meta_boxes()
{
	// Make sure there's no errors when the plugin is deactivated or during upgrade
	if ( !class_exists( 'RW_Meta_Box' ) )
		return;

	global $corpo_meta_boxes;
	foreach ( $corpo_meta_boxes as $meta_box )
	{
		new RW_Meta_Box( $meta_box );
	}
}
// Hook to 'admin_init' to make sure the meta box class is loaded before
// (in case using the meta box class in another plugin)
// This is also helpful for some conditionals like checking page template, categories, etc.
add_action( 'admin_init', 'corpo_register_meta_boxes' );
