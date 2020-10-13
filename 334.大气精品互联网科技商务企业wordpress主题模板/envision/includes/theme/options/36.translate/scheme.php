<?php

$scheme[ cloudfw_id_for_sequence( $scheme, $number ) ] = array(
	'type'		=> 'page',
	'page'  	=> 'global',
	'global' 	=>  array(
		'page_title' 	=>	__('Translate','cloudfw'),
		'page_slug' 	=>	'translate',
		'page_css_id' 	=>	'cloud_nav_translate'
	),
	'form'	=> 	array(
		'enable'	=> true,
		'ajax'		=> true,
		'shortcut'	=> true,
	),
	'data'	=>  array(

		## Tab Item		
		array(
			'type'		=>	'vertical_tabs',
			'tab_id' 	=>	'translate_general',
			'tab_title' =>	__('General','cloudfw'),
			'data'		=>	array(
			
				## Container Item
				array(
					'type'		=>	'container',
					'title'		=>	__('General','cloudfw'),
					'footer'	=>	false,
					'data'		=>	array(

						## Module Item
						array(
							'type'		=>	'module',
							'title'		=>	__('Default Home Text','cloudfw'),
							'data'		=>	array(
								array(
									'type'		=>	'text',
									'id'		=>	cloudfw_sanitize(PFIX.'_texts home'),
									'value'		=>	$_opt[PFIX.'_texts']['home'],
									'_class'	=>	'bold'
								)
							)

						), 

						## Module Item
						array(
							'type'		=>	'module',
							'title'		=>	__('Mobile Navigation Text','cloudfw'),
							'data'		=>	array(
								array(
									'type'		=>	'text',
									'id'		=>	cloudfw_sanitize(PFIX.'_texts mobile_navigation'),
									'value'		=>	$_opt[PFIX.'_texts']['mobile_navigation'],
									'_class'	=>	'bold'
								)
							)

						), 

						## Module Item
						array(
							'type'		=>	'module',
							'title'		=>	__('Search Form Placeholder Text','cloudfw'),
							'data'		=>	array(
								array(
									'type'		=>	'text',
									'id'		=>	cloudfw_sanitize(PFIX.'_texts search'),
									'value'		=>	$_opt[PFIX.'_texts']['search'],
								)
							)

						), 

					)
					
				), 

				## Container Item
				array(
					'type'		=>	'container',
					'title'		=>	__('404 Page','cloudfw'),
					'footer'	=>	false,
					'data'		=>	array(

						## Module Item
						array(
							'type'		=>	'module',
							'title'		=>	__('404 Page Title','cloudfw'),
							'data'		=>	array(
								array(
									'type'		=>	'text',
									'id'		=>	cloudfw_sanitize(PFIX.'_texts 404_title'),
									'value'		=>	$_opt[PFIX.'_texts']['404_title'],
									'_class'	=>	'bold'
								)
							)

						), 

						## Module Item
						array(
							'type'		=>	'module',
							'title'		=>	__('404 Page Text','cloudfw'),
							'data'		=>	array(
								array(
									'type'		=>	'text',
									'id'		=>	cloudfw_sanitize(PFIX.'_texts 404_text'),
									'value'		=>	$_opt[PFIX.'_texts']['404_text'],
								)
							)

						), 

					)

				),

				## Container Item
				array(
					'type'		=>	'container',
					'title'		=>	__('Archive Pages','cloudfw'),
					'footer'	=>	false,
					'data'		=>	array(

						## Module Item
						array(
							'type'		=>	'module',
							'title'		=>	__('Category Page Title','cloudfw'),
							'data'		=>	array(
								array(
									'type'		=>	'text',
									'id'		=>	cloudfw_sanitize(PFIX.'_texts category_titles'),
									'value'		=>	$_opt[PFIX.'_texts']['category_titles'],
									'_class'	=>	'bold',
									'desc'		=>	__('<code>%s</code> is category name','cloudfw') 
								)
							)

						), 

						## Module Item
						array(
							'type'		=>	'module',
							'title'		=>	__('Tag Page Title','cloudfw'),
							'data'		=>	array(
								array(
									'type'		=>	'text',
									'id'		=>	cloudfw_sanitize(PFIX.'_texts tag_titles'),
									'value'		=>	$_opt[PFIX.'_texts']['tag_titles'],
									'_class'	=>	'bold',
									'desc'		=>	__('<code>%s</code> is tag name','cloudfw') 
								)
							)

						), 

						## Module Item
						array(
							'type'		=>	'module',
							'title'		=>	__('Search Page Title','cloudfw'),
							'data'		=>	array(
								array(
									'type'		=>	'text',
									'id'		=>	cloudfw_sanitize(PFIX.'_texts search_titles'),
									'value'		=>	$_opt[PFIX.'_texts']['search_titles'],
									'_class'	=>	'bold',
									'desc'		=>	__('<code>%s</code> is search key','cloudfw') 
								)
							)

						), 

					)

				),

				## Container Item
				array(
					'type'		=>	'container',
					'footer'	=>	false,
					'title'		=>	__('Human-Readable Timestamp','cloudfw'),
					'data'		=>	array(

						array(
							'type'		=>	'global-scheme',
							'scheme'	=>	'translate',
							'vars'		=>	array(
								array(
									'time_seconds',
									'time_second',
									'time_minutes',
									'time_minute',
									'time_hours',
									'time_hour',
									'time_days',
									'time_day',
									'time_months',
									'time_month',
									'time_years',
									'time_year',
								)
							)
						),

					)

				),

				## Container Item
				array(
					'type'		=>	'container',
					'title'		=>	__('Likes','cloudfw'),
					'footer'	=>	false,
					'data'		=>	array(

						array(
							'type'		=>	'global-scheme',
							'scheme'	=>	'translate',
							'vars'		=>	array(
								array(
									'sharrre.like_post',
									'sharrre.plural_likes',
									'sharrre.single_likes',
									'sharrre.like_this',
									'sharrre.already_like_this',
								)
							)
						),

					)
					
				),


				## Module Item
				array(
					'type'		=>	'submit',
					'layout'	=>	'fixed',
				), 

			
			)

		), // #### vertical_tabs: 25	


		## Tab Item		
		array(
			'type'		=>	'vertical_tabs',
			'tab_id' 	=>	'translate_blog',
			'tab_title' =>	__('Blog General','cloudfw'),
			'data'		=>	array(

				## Container Item
				array(
					'type'		=>	'container',
					'title'		=>	__('Blog','cloudfw'),
					'footer'	=>	false,
					'data'		=>	array(

						array(
							'type'		=>	'global-scheme',
							'scheme'	=>	'translate',
							'vars'		=>	array(
								array(
									'read_more',
									'next_post',
									'previous_post',
									'sticky_post',
									'goto_blog_page',
								)
							)
						),

					)
					
				),

				## Container Item
				array(
					'type'		=>	'container',
					'title'		=>	__('Single Blog Posts','cloudfw'),
					'footer'	=>	false,
					'data'		=>	array(

						array(
							'type'		=>	'global-scheme',
							'scheme'	=>	'translate',
							'vars'		=>	array(
								array(
									'blog.single.about_author',
									'blog.single.share_the_post',
									'blog.single.comments',
									'blog.single.comments_s',
									'blog.single.comments_closed',
									'blog.single.no_comment_yet',
									'blog.single.comment_navigation',
									'blog.single.older_comments',
									'blog.single.newer_comments',
								)
							)
						),

					)
					
				),

				## Container Item
				array(
					'type'		=>	'container',
					'title'		=>	__('Comment Form','cloudfw'),
					'footer'	=>	false,
					'data'		=>	array(

						array(
							'type'		=>	'global-scheme',
							'scheme'	=>	'translate',
							'vars'		=>	array(
								array(
									'commentform.name',
									'commentform.email',
									'commentform.website',
									'commentform.comment',
									'commentform.leave_a_reply',
									'commentform.title_reply_to',
									'commentform.reply',
									'commentform.cancel_reply',
									'commentform.post_comment',
									'commentform.must_log_in',
									'commentform.logged_in_as',
									'commentform.email_not_published',
									'commentform.required_fields_marked',
								)
							)
						),

					)
					
				),



				## Module Item
				array(
					'type'		=>	'submit',
					'layout'	=>	'fixed',
				), 


			)

		),


		## Tab Item		
		array(
			'type'		=>	'vertical_tabs',
			'tab_id' 	=>	'translate_portfolio',
			'tab_title' =>	__('Portfolio','cloudfw'),
			'data'		=>	array(

				## Container Item
				array(
					'type'		=>	'container',
					'title'		=>	__('Portfolio','cloudfw'),
					'footer'	=>	false,
					'data'		=>	array(

						## Module Item
						array(
							'type'		=>	'module',
							'title'		=>	__('Related Portfolio Posts Title','cloudfw'),
							'data'		=>	array(
								array(
									'type'		=>	'text',
									'id'		=>	cloudfw_sanitize(PFIX.'_texts portfolio_related'),
									'value'		=>	$_opt[PFIX.'_texts']['portfolio_related'],
								)
							)

						),

						## Module Item
						array(
							'type'		=>	'module',
							'title'		=>	__('Show All Post Text in Porfolio Filters','cloudfw'),
							'data'		=>	array(
								array(
									'type'		=>	'text',
									'id'		=>	cloudfw_sanitize(PFIX.'_texts portfolio_filter_all'),
									'value'		=>	$_opt[PFIX.'_texts']['portfolio_filter_all'],
								)
							)

						),

					)
					
				),


				## Module Item
				array(
					'type'		=>	'submit',
					'layout'	=>	'fixed',
				), 


			)

		),

		## Tab Item		
		array(
			'type'		=>	'vertical_tabs',
			'tab_id' 	=>	'translate_wc',
			'tab_title' =>	__('WooCommerce Shop','cloudfw'),
			'data'		=>	array(

				## Container Item
				array(
					'type'		=>	'container',
					'title'		=>	__('WooCommerce General','cloudfw'),
					'footer'	=>	false,
					'data'		=>	array(


						array(
							'type'		=>	'mini-section',
							'title'		=>	__('Widgets','cloudfw'),
							'data'		=> 	array(

								## Module Item
								array(
									'type'		=>	'module',
									'title'		=>	__('Topbar Login Widget Text','cloudfw'),
									'data'		=>	array(
										array(
											'type'		=>	'text',
											'id'		=>	cloudfw_sanitize(PFIX.'_texts wc.widget.login.text'),
											'value'		=>	cloudfw_get_option('texts', 'wc.widget.login.text'),
											'holder' 	=>	cloudfw_raw_option('texts', 'wc.widget.login.text'),
											'desc'		=>	__('<code>%s</code> is username.','cloudfw')
										)
									)

								), 

							)

						), 

					)

				), 

				## Container Item
				array(
					'type'		=>	'container',
					'title'		=>	__('Product Lists','cloudfw'),
					'footer'	=>	false,
					'data'		=>	array(


						array(
							'type'		=>	'mini-section',
							'title'		=>	__('Badges','cloudfw'),
							'data'		=> 	array(

								## Module Item
								array(
									'type'		=>	'module',
									'title'		=>	cloudfw_raw_option('texts', 'wc.loop.badge.sale'),
									'data'		=>	array(
										array(
											'type'		=>	'text',
											'id'		=>	cloudfw_sanitize(PFIX.'_texts wc.loop.badge.sale'),
											'value'		=>	cloudfw_get_option('texts', 'wc.loop.badge.sale'),
										)
									)

								), 

								## Module Item
								array(
									'type'		=>	'module',
									'title'		=>	cloudfw_raw_option('texts', 'wc.loop.badge.out_of_stock'),
									'data'		=>	array(
										array(
											'type'		=>	'text',
											'id'		=>	cloudfw_sanitize(PFIX.'_texts wc.loop.badge.out_of_stock'),
											'value'		=>	cloudfw_get_option('texts', 'wc.loop.badge.out_of_stock'),
										)
									)

								), 

								## Module Item
								array(
									'type'		=>	'module',
									'title'		=>	cloudfw_raw_option('texts', 'wc.loop.badge.free'),
									'data'		=>	array(
										array(
											'type'		=>	'text',
											'id'		=>	cloudfw_sanitize(PFIX.'_texts wc.loop.badge.free'),
											'value'		=>	cloudfw_get_option('texts', 'wc.loop.badge.free'),
										)
									)

								), 

							)

						),

					)
					
				),

				## Container Item
				array(
					'type'		=>	'container',
					'title'		=>	__('Catalog Pages','cloudfw'),
					'footer'	=>	false,
					'data'		=>	array(

						## Module Item
						array(
							'type'		=>	'module',
							'title'		=>	__('Added','cloudfw'),
							'data'		=>	array(
								array(
									'type'		=>	'text',
									'id'		=>	cloudfw_sanitize(PFIX.'_texts wc.loop.ajax_added'),
									'value'		=>	cloudfw_get_option('texts', 'wc.loop.ajax_added'),
								)
							)

						), 

						## Module Item
						array(
							'type'		=>	'module',
							'title'		=>	cloudfw_raw_option('texts', 'wc.loop.details'),
							'data'		=>	array(
								array(
									'type'		=>	'text',
									'id'		=>	cloudfw_sanitize(PFIX.'_texts wc.loop.details'),
									'value'		=>	cloudfw_get_option('texts', 'wc.loop.details'),
								)
							)

						), 

					)
					
				),

				## Module Item
				array(
					'type'		=>	'submit',
					'layout'	=>	'fixed',
				), 


			)

		),

	) // page -> data
	
);