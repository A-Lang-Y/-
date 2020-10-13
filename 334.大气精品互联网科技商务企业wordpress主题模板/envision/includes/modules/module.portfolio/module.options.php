<?php

/**
 *	Register Options Map
 *
 *	@package 	CloudFw
 *	@subpackage Portfolio
 *	@version 	1.0
 */
add_filter( 'cloudfw_maps_options_object', 'cloudfw_module_map_portfolio' );
function cloudfw_module_map_portfolio( $map ) {
    $map  -> option	 ( 'portfolio' )
          -> sub  	 ( 'page' )
          -> sub  	 ( 'comments', 'FALSE' )
          -> sub  	 ( 'slug', 'portfolio' )
          -> sub  	 ( 'category_slug', 'portfolio-category' )
          -> sub  	 ( 'filter_slug', 'portfolio-filter' )
          -> sub  	 ( 'tag_slug', 'portfolio-tags' )
          -> sub  	 ( 'related_posts', true )
          -> sub  	 ( 'related_layout', "[section style_id='section-related-posts' margin_bottom='-12px']\r\n\t[related_portfolios]\r\n\t\t{{results}}\r\n\t[/related_portfolios]\r\n[/section]" )
          -> sub  	 ( 'related_layout_sidebar' );

	return $map;
}

/**
 *	Register Options Scheme
 *
 *	@package 	CloudFw
 *	@subpackage Portfolio
 *	@version 	1.0
 */
add_filter( 'cloudfw_schemes_options', 'cloudfw_module_option_portfolio' );
function cloudfw_module_option_portfolio( $schemes ) {
	$schemes[ cloudfw_id_for_sequence( $schemes, 20 ) ] = array(
		'type'		=> 'page',
		'page' 		=> 'portfolio',
		'portfolio'	=> array(
			'page_title' 	=>	__('Portfolio Settings','cloudfw'),
			'page_nice_title'=>	__('portfolio','cloudfw'),
			'page_slug' 	=>	'portfolio',
			'page_css_id' 	=>	'cloud_nav_portfolio',
		),
		'form'	=> 	array(
			'enable'	=> true,
			'ajax'		=> true,
			'shortcut'	=> true,
		),	

		'data'	=> array(
		
			## Tab Item
			5	=>  array(
				'type'		=>	'tabs',
				'tab_id' 	=>	'portfolio_page',
				'tab_title' =>	__('Portfolio Page','cloudfw'),
				'data'		=>	array(
							
					## Container Item
					array(
						'type'			=>	'container',
						'footer'		=>  false,
						'title'			=>	__('Portfolio Pages','cloudfw'),
						'data'			=>	array(
						

							array(
								'type'		=> 'module',
								'title'		=>	__('Porfolio Page','cloudfw'),
								'data'		=> array(

									## Element
									array(
										'type'		=>	'page-selector',
										'id'		=>	cloudfw_sanitize( PFIX.'_portfolio page' ),
										'value'		=>	cloudfw_get_option( 'portfolio',  'page' ),
										'response'	=>	'ID',
										'hide_input'=>	true,
									)

								)

							),
							
							array(
								'type'		=>	'module-set',
								'title'		=>	__('Portfolio Slugs','cloudfw'),
								'closable'	=>	false,
								'state'		=>	'opened',
								'data'		=>	array(
			
									array(
										'type'		=> 'message',
										'fill'		=> true,
										'title'		=>	__('Important!','cloudfw'),
										'data'		=> sprintf(__('If you change the portfolio slug settings, you should navigate to <code>%s</code> page and save changes on the page to make them worked properly.','cloudfw'), '<a href="'. admin_url('options-permalink.php') .'">'. __('Settings > Permalinks','cloudfw') .'</a>'),

									),
						
									## Module Item
									array(
										'type'		=>	'module',
										'title'		=>	__('Portfolio Posts Slug','cloudfw'),
										'data'		=>	array(

											## Element
											array(
												'type'		=>	'text',
												'id'		=>	cloudfw_sanitize( PFIX.'_portfolio slug' ),
												'value'		=>	cloudfw_get_option( 'portfolio',  'slug' ),
												'_class'	=>  'bold',
											), // #### element: 0
												
										)

									),

									## Module Item
									array(
										'type'		=>	'module',
										'title'		=>	__('Porfolio Category Slug','cloudfw'),
										'data'		=>	array(

											## Element
											array(
												'type'		=>	'text',
												'id'		=>	cloudfw_sanitize( PFIX.'_portfolio category_slug' ),
												'value'		=>	cloudfw_get_option( 'portfolio',  'category_slug' ),
												'_class'	=>  'bold',
											), // #### element: 0
												
										)

									),

									## Module Item
									array(
										'type'		=>	'module',
										'title'		=>	__('Porfolio Tag Slug','cloudfw'),
										'data'		=>	array(

											## Element
											array(
												'type'		=>	'text',
												'id'		=>	cloudfw_sanitize( PFIX.'_portfolio tag_slug' ),
												'value'		=>	cloudfw_get_option( 'portfolio',  'tag_slug' ),
												'_class'	=>  'bold',
											), // #### element: 0
												
										)

									),

									## Module Item
									array(
										'type'		=>	'module',
										'title'		=>	__('Porfolio Filter Slug','cloudfw'),
										'data'		=>	array(

											## Element
											array(
												'type'		=>	'text',
												'id'		=>	cloudfw_sanitize( PFIX.'_portfolio filter_slug' ),
												'value'		=>	cloudfw_get_option( 'portfolio',  'filter_slug' ),
												'_class'	=>  'bold',
											), // #### element: 0
												
										)

									),

								)
							
							),

							## Module Item
							array(
								'type'		=>	'module',
								'title'		=>	__('Enable comments for portfolio posts?','cloudfw'),
								'data'		=>	array(

									## Element
									array(
										'type'		=>	'onoff',
										'id'		=>	cloudfw_sanitize( PFIX.'_portfolio comments' ),
										'value'		=>	cloudfw_get_option( 'portfolio',  'comments' ),
									), // #### element: 0
										
								)

							),

						)

					),

					## Container Item
					array(
						'type'			=>	'container',
						'footer'		=>  false,
						'title'			=>	__('General Portfolio Settings','cloudfw'),
						'data'			=>	array(
						
							## Module Item
							array(
								'type'		=>	'module',
								'title'		=>	__('Show related portfolio posts after portfolio contents?','cloudfw'),
								'data'		=>	array(

									## Element
									array(
										'type'		=>	'onoff',
										'id'		=>	cloudfw_sanitize( PFIX.'_portfolio related_posts' ),
										'value'		=>	cloudfw_get_option( 'portfolio',  'related_posts' ),
									), // #### element: 0
										
								)

							),

							## Module Item
							array(
								'type'		=>	'module',
								'title'		=>	__('Related Posts Shortcode for Fullwidth Pages','cloudfw'),
								'data'		=>	array(

									## Element
									array(
										'type'		=>	'textarea',
										'id'		=>	cloudfw_sanitize( PFIX.'_portfolio related_layout' ),
										'value'		=>	cloudfw_get_option( 'portfolio',  'related_layout' ),
										'_class'	=>	'textarea_500px_4line tabtext',
										'line'		=>	10,
										'desc'		=>	'<p><code>[section style_id=\'section-related-posts\' margin_bottom=\'-12px\'][related_portfolios]{{results}}[/related_portfolios][/section]</code></p>' . '<p><code>{{results}}</code>: Related Posts</p>'
									), // #### element: 0
										
								)

							),

							## Module Item
							array(
								'type'		=>	'module',
								'title'		=>	__('Related Posts Shortcode for Sidebar Pages','cloudfw'),
								'data'		=>	array(

									## Element
									array(
										'type'		=>	'textarea',
										'id'		=>	cloudfw_sanitize( PFIX.'_portfolio related_layout_sidebar' ),
										'value'		=>	cloudfw_get_option( 'portfolio',  'related_layout_sidebar' ),
										'_class'	=>	'textarea_500px_4line tabtext',
										'line'		=>	10,
										'desc'		=>	'<p><code>[related_portfolios]{{results}}[/related_portfolios]</code></p>' . '<p><code>{{results}}</code>: Related Posts</p>'
									), // #### element: 0
										
								)

							),

						)

					),


					## Module Item
					100 => array(
						'type'      =>  'submit',
						'layout'    =>  'fixed',
					),
						
				)

			), // #### tab: 5			
		
		)
	);

	return $schemes;
}