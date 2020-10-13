<?php

/**
 *	Prepare Portfolio Categories
 *
 *	@since 1.0
 */
function cloudfw_admin_loop_portfolio_cats(){
	$out = array();
	$categories = get_terms('portfolio-category', 'orderby=name&hide_empty=0');

	$out['NULL'] = '';

	foreach ((array) $categories as $cat)
		$out[ $cat->term_id ] = sprintf( __('%1$s - %2$s item(s)','cloudfw'),  $cat->name,  $cat->count );

	return $out;
}

/**
 *	Prepare Portfolio Filters
 *
 *	@since 1.0
 */
function cloudfw_admin_loop_portfolio_filters(){
	$out = array();
	$categories = get_terms('portfolio-filter', 'orderby=name&hide_empty=0');

	if ( !empty($categories) ) {
		foreach ((array) $categories as $cat)
			$out[ $cat->slug ] = sprintf( __('%1$s - %2$s item(s)','cloudfw'),  $cat->name,  $cat->count );
	} else {
		$out['NULL'] = '';
	}

	return $out;
}

/**
 *	Prepare Portfolio Posts
 *
 *	@since 1.0
 */
function cloudfw_admin_loop_portfolio_posts_raw(){
	global $post;
	$tmp_post = $post;

	$out = array();            
    $args = array(
	    'post_type'	 		=>	array('portfolio'),
	    'post_status'		=>	'publish',
	    'posts_per_page'	=> -1,
	    'orderby'    		=> 'menu_order ID',
	    'order'      		=> 'DESC',
    );

    $posts = new WP_Query( $args );
    if( $posts->have_posts()) : while( $posts->have_posts() ) : $posts->the_post();
		$out[ get_the_ID() ] = esc_attr(__t( get_the_title() ));
    endwhile; endif;

	$post = $tmp_post;
	wp_reset_query();
	
    if ( !$out )
		$out['NULL'] = '';

	return $out;
}

function cloudfw_admin_loop_portfolio_posts(){
	$out = array();            
	$out['NULL'] = '';
	$out = $out + (array) cloudfw_admin_loop_portfolio_posts_raw();
	return $out;
}

/**
 *	Prepare Portfolio Js Datas
 *
 *	@since 1.0
 */
function cloudfw_admin_js_datas_portfolio(){
	global $post;
	$tmp_post = $post;

    $args = array(
	    'post_type'	 		=>	array('portfolio'),
	    'post_status'		=>	'publish',
	    'posts_per_page'	=> -1,
	    'orderby'    		=> 'menu_order ID',
	    'order'      		=> 'DESC',
    );

    $custom_post = new WP_Query( $args );
	while ($custom_post->have_posts()) : $custom_post->the_post(); 
    	$thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()),'thumbnail');
		echo '
		<input type="hidden" id="sel-port-title-'.get_the_ID().'" value="'.esc_attr(__t( get_the_title() )).'" />		
		<input type="hidden" id="sel-port-thumbnail-'.get_the_ID().'" value="'.esc_attr($thumbnail[0]).'" />		
		';
    endwhile;

	$post = $tmp_post;
	wp_reset_query();
	
}

/**
 *	Prepare Portfolio Posts Adding via Javascript
 *
 *	@since 1.0
 */
function cloudfw_admin_script_portfolio(){
?>
jQuery('#cloudfw_add_portfolio_post').on('click',function(){
	
	posts = jQuery(this).parents('.indicator').first().find('#portfolio_ids_selected_posts').val();
	selected_portfolio_items = jQuery(this).parents('.indicator').first().find('#selected_portfolio_items_2');
		
	if (posts) {
		
		var posts = "" + posts;
		var parsed_posts = posts.split(",");
		
			for(var i in parsed_posts)
			{
				var is_return_ = true;
				var title = jQuery('#sel-port-title-'+parsed_posts[i]).val();
				var thumbnail = jQuery('#sel-port-thumbnail-'+parsed_posts[i]).val();

				if ( !title )
					is_return_ = false;
				
				if (thumbnail == '') 
					var thumbnail_echo = ''; 
				else 
					var thumbnail_echo = '<img src="'+thumbnail+'" alt="" width="40" height="40" />';
				
				selected_portfolio_items.children('li').each(function(){
					var the_item = jQuery(this);
					var the_id = the_item.find('.portfolio_post_id').val();
					
					if ('' + the_id == '' + parsed_posts[i]) is_return_ = false;
					
					the_id = null;
					
				});
				
				if (is_return_ == false) return false;
				
				selected_portfolio_items.append('\
				\
				<li class="sortable_item">\
						\
						<div class="handler handler_left">\
                        	<span></span>\
                        </div>\
						<input type="hidden" name="p_id_'+parsed_posts[i]+'" class="portfolio_post_id" value="'+parsed_posts[i]+'">\
						<div style="float: left; margin-left: 20px; line-height: 30px;">'+thumbnail_echo+'</div>\
						<div style="float: left; margin-left: 20px; line-height: 30px;">'+title+' <a href="#" class="remove_portfolio">(remove)</a></div>\
						<div class="clear"></div>\
						\
						\
				</li>\
				\
				');
				
				title = null;
				thumbnail = null;
				is_return_ = null;
				
			}
			
			jQuery("#selected_portfolio_items_2")
				.sortable({opacity:  sortable_sliders_opacity,	axis: 'y', containment: 'parent', placeholder: 'sortable-placeholder', scroll:true, delay: 200,
				start: function(event, ui) {ui.item.addClass("removeBorder");},
				stop: function(event, ui) {ui.item.removeClass("removeBorder");}});
				
	} else{

		cloudfw_error_message_js("<?php _e('Please select some post to add into the portfolio','cloudfw'); ?>");
	
	}

	
	return false;
});
<?php }