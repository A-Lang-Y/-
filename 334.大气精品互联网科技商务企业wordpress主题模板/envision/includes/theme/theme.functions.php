<?php

/**
 *    Wp Footer
 *
 *    @since 1.0
 */
add_action  ('wp_footer', 'cloudfw_footer_callback', 10);
function cloudfw_footer_callback(){
	cloudfw_option('custom_codes', 'footer');
	cloudfw_google_analytics_tracking( cloudfw_get_option('custom_codes', 'tracking') );
}

/**
 *  Pagination Function
 *
 *  @author Eric Martin <eric@ericmmartin.com>
 *  @author Orkun Gursel <support@cloudfw.net>
 */
if ( ! function_exists( 'cloudfw_pagination' ) ):
	function cloudfw_pagination( $args = array() ) {
		$defaults = array(
			'page'              => NULL,
			'pages'             => NULL, 
			'range'             => 3,
			'gap'               => 1,
			'anchor'            => 1,
			'before'            => '<ul class="ui--pagination unstyled clearfix">',
			'after'             => '</ul>',
			'title'             => '',
			'nextpage'          => __('Next','cloudfw'),
			'previouspage'      => __('Previous','cloudfw'),
			'echo'              => 1,
			'container'         => true,
			'container_classes' => 'ui--pagination-wrapper clearfix',
			'link_class'        => '',
			'current_link_class'=> '',
			'pasive_link_class' => '',
		);

		extract(wp_parse_args($args, $defaults), EXTR_SKIP);

		$loop_args = array(
			'link_class'        => $link_class,
			'current_link_class'=> $current_link_class,
			'pasive_link_class' => $pasive_link_class,        
		); 

		if (!$page && !$pages) {
			global $wp_query;

			$page = get_query_var('paged');
			$page = !empty($page) ? intval($page) : 1;

			$posts_per_page = intval(get_query_var('posts_per_page'));
			$pages = intval(ceil($wp_query->found_posts / $posts_per_page));
		}

		if ( !($pages > 1) )
			return '';
		
		
		$output = "";
		$output .= $before;
			
			if ($page > 1 && !empty($previouspage)) {
				$output .= "<li class='ui--box ui--gradient ui--gradient-grey ui--pagination-previous-link'><a href='" . get_pagenum_link($page - 1) . "' class='sprite previous-link {$link_class}'>$previouspage</a></li>";
			}else {
				$output .= "<li class='ui--box ui--gradient ui--gradient-grey ui--pagination-previous-link inactive'><span class='sprite previous-link {$pasive_link_class}'>$previouspage</span></li>";
			}
			
			if($title)
				$output .= "<li><span class='ui--pagination-title'>$title</span></li>";

			$ellipsis = "<li class='ui--pagination-blabla'>...</li>";
			
			$min_links = $range * 2 + 1;
			$block_min = min($page - $range, $pages - $min_links);
			$block_high = max($page + $range, $min_links);
			$left_gap = (($block_min - $anchor - $gap) > 0) ? true : false;
			$right_gap = (($block_high + $anchor + $gap) < $pages) ? true : false;

			if ($left_gap && !$right_gap) {
				$output .= sprintf('%s%s%s', 
					cloudfw_pagination_loop(1, $anchor, NULL, $loop_args), 
					$ellipsis, 
					cloudfw_pagination_loop($block_min, $pages, $page, $loop_args)
				);
			}
			else if ($left_gap && $right_gap) {
				$output .= sprintf('%s%s%s%s%s', 
					cloudfw_pagination_loop(1, $anchor, NULL, $loop_args), 
					$ellipsis, 
					cloudfw_pagination_loop($block_min, $block_high, $page, $loop_args), 
					$ellipsis, 
					cloudfw_pagination_loop(($pages - $anchor + 1), $pages, NULL, $loop_args)
				);
			}
			else if ($right_gap && !$left_gap) {
				$output .= sprintf('%s%s%s', 
					cloudfw_pagination_loop(1, $block_high, $page, $loop_args),
					$ellipsis,
					cloudfw_pagination_loop(($pages - $anchor + 1), $pages, NULL, $loop_args)
				);
			}
			else {
				$output .= cloudfw_pagination_loop(1, $pages, $page, $loop_args);
			}

			
			
			if ($page < $pages && !empty($nextpage)) {
				$output .= "<li class='ui--box ui--gradient ui--gradient-grey ui--pagination-next-link'><a href='" . get_pagenum_link($page + 1) . "' class='sprite next-link {$link_class}'>$nextpage</a></li>";
			}else {
				$output .= "<li class='ui--box ui--gradient ui--gradient-grey ui--pagination-next-link inactive'><span class='sprite next-link {$pasive_link_class}'>$nextpage</span></li>";
			}
		
		$output .= $after;
						
		if ($container && $output)
			$output = "<div class=\"$container_classes\">$output</div>";

		if ($echo)
			echo $output;

		return $output;
	}

endif;


/**
 * @author Eric Martin <eric@ericmmartin.com>
 * @author Orkun Gursel <support@cloudfw.net>
 */
if ( ! function_exists( 'cloudfw_pagination_loop' ) ):
	function cloudfw_pagination_loop($start, $max, $page = 0, $args = array()) {
		$output = "";
		extract($args, EXTR_SKIP);

		for ($i = $start; $i <= $max; $i++) {
			$output .= ($page === intval($i)) 
				? "<li class='ui--box ui--gradient ui--gradient-grey ui--pagination-current-item'><span class='{$current_link_class}'>$i</span></li>" 
				: "<li class='ui--box ui--gradient ui--gradient-grey'><a href='" . get_pagenum_link($i) . "' class='{$link_class}'>$i</a></li>";
		}
		return $output;
	}
endif;

/**
 *    Find Column CSS Class
 *
 *    @since 1.0
 */
function cloudfw_column_class( $column, $current, $total ){
	if ($current == $total)
		return 'cl cl_' . $column .' last';
	else
		return 'cl cl_' . $column;      
}

/**
 *    Facebook Like Button
 *
 *    @since 1.0
 */
function cloudfw_facebook_like_button($url = NULL){
	if (!$url) $url = __url( get_permalink() );
	return '
	<iframe src="http://www.facebook.com/plugins/like.php?href='.urlencode($url).'&amp;layout=button_count&amp;show_faces=false&amp;width=100&amp;action=like&amp;font=arial&amp;colorscheme=light&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:100px; height:21px;" allowTransparency="true" class="social-iframe"></iframe>
	';
}
	
/**
 *    Check Status of All Comments
 *
 *    @since 1.0
 */
function cloudfw_is_comments_open(){
	return _check_onoff( cloudfw_get_option('blog_actives', 'comments') );
}

/**
 *    Archive Titles
 *
 *    @since 1.0
 */
function cloudfw_archive_titles(){
	global $post;

	if (is_single()) {
		return array(
			'blog_layout'   => false,
			'title'         => false,
			'text'          => false
		);
		
	} elseif (is_category()) {
		return array(
			'blog_layout'   => false,
			'title'         => __('Category','cloudfw').':',
			'text'          => single_cat_title('', false)
		);

	} elseif (is_author()) {
		return array(
			'blog_layout'   => 'minimal',
			'title'         => __('Author','cloudfw').':',
			'text'          => get_the_author()
		);

	} elseif (is_tag()) {
		return array(
			'blog_layout'   => 'minimal',
			'title'         => __('Tag','cloudfw').':',
			'text'          => single_tag_title( '', false )
		);

	} elseif (is_search()) {
		return array(
			'blog_layout'   => 'minimal',
			'title'         => __('Search Results For','cloudfw').':',
			'text'          => '"'.get_search_query().'"'
		);

	} elseif (is_archive()) {        
					
			if ( is_day() ) $text = get_the_date();
			elseif ( is_month() ) $text = get_the_date('F / Y');
			elseif ( is_year() ) $text = get_the_date('Y');
		
		return array(
			'blog_layout'   => 'minimal',
			'title'         => __('Archives','cloudfw'),
			'text'          => $text
		);           

	}   

}

/**
 *  Loop Of Social Bookmarking Services For Select Modules
 *
 *  @since 1.0
**/ 
function cloudfw_loop_social_services() {
	$social_services = cloudfw_social_services();
	
	foreach ($social_services as $social_service_item => $item){
		$loop_social_services[] = array(
			 "item_value"   => $social_service_item,
			 "item_html"    => '<span class="contrainer"><img src="'.TMP_ADMIN_GUI.'/social_icon/'.$social_service_item.'-16x16.png" /><br/>'.$item["item_name"].'</span>'
		 );
	}
	return $loop_social_services;
}

/**
 *    Save Core Options for The Theme
 *
 *    @since 1.0
 */
add_action( 'cloudfw_save_options', 'cloudfw_save_core_options' );
function cloudfw_save_core_options( $options = array()  ){
	
	$page_for_posts = isset($_REQUEST['page_for_posts']) ? $_REQUEST['page_for_posts'] : NULL;
	if ( isset( $page_for_posts ) ) {
		update_option( 'page_for_posts', $page_for_posts );
		update_option( 'show_on_front', 'page' );
	}

	$blog_page_template = isset($_REQUEST['blog_page_wp_page_template']) ? $_REQUEST['blog_page_wp_page_template'] : NULL;
	if ( isset( $blog_page_template ) ) {
		update_post_meta( get_option('page_for_posts'), '_wp_page_template', $blog_page_template );
	}
	
	$blog_page_sidebar = isset($_REQUEST['blog_page_custom_sidebar']) ? $_REQUEST['blog_page_custom_sidebar'] : NULL;
	
	if ( isset( $blog_page_sidebar ) ) {
		update_post_meta( get_option('page_for_posts'), PFIX.'_custom_sidebar', $blog_page_sidebar );
	}
	
	return $options;
}

/**
 *    Custom Post Gallery
 *
 *    @since 1.0
 */
add_filter( 'post_gallery', 'cloudfw_custom_post_gallery', 10, 2 );
function cloudfw_custom_post_gallery( $output, $attr) {
	global $post, $wp_locale;

	static $instance = 0;
	$instance++;

	// We're trusting author input, so let's at least make sure it looks like a valid orderby statement
	if ( isset( $attr['orderby'] ) ) {
		$attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
		if ( !$attr['orderby'] )
			unset( $attr['orderby'] );
	}

	extract(shortcode_atts(array(
		'order'      => 'ASC',
		'orderby'    => 'menu_order ID',
		'id'         => $post->ID,
		'itemtag'    => 'dl',
		'icontag'    => 'dt',
		'captiontag' => 'dd',
		'columns'    => 3,
		'size'       => 'thumbnail',
		'include'    => '',
		'exclude'    => '',
		'link'       => 'file'
	), $attr));

	$id = intval($id);
	if ( 'RAND' == $order )
		$orderby = 'none';

	if ( !empty($include) ) {
		$include = preg_replace( '/[^0-9,]+/', '', $include );
		$_attachments = get_posts( array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );

		$attachments = array();
		foreach ( $_attachments as $key => $val ) {
			$attachments[$val->ID] = $_attachments[$key];
		}
	} elseif ( !empty($exclude) ) {
		$exclude = preg_replace( '/[^0-9,]+/', '', $exclude );
		$attachments = get_children( array('post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
	} else {
		$attachments = get_children( array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
	}

	if ( empty($attachments) )
		return '';

	if ( is_feed() ) {
		$output = "\n";
		foreach ( $attachments as $att_id => $attachment )
			$output .= wp_get_attachment_link($att_id, $size, true) . "\n";
		return $output;
	}

	$itemtag = tag_escape($itemtag);
	$captiontag = tag_escape($captiontag);
	$columns = intval($columns);
	$itemwidth = $columns > 0 ? floor(100/$columns) : 100;
	$float = is_rtl() ? 'right' : 'left';

	$selector = "gallery_{$instance}";

	$output = apply_filters('gallery_style', "
		<style type='text/css'>
			#{$selector} {
				margin: auto;
				width: 100%;
			}
			#{$selector} .gallery-item {
				float: {$float};
			   /* margin:0 20px 20px 0;*/
				text-align: center;
				width: {$itemwidth}%;
				display: block;
				}
			#{$selector} img {
				max-width: 95% !important;
				height: auto !important;
				margin: 0 auto;
			}
			#{$selector} .gallery-caption {
				margin-left: 0;
			}
		</style>

		<div id='$selector' class='gallery galleryid-{$id}'>");

	$i = 0; //
	foreach ( $attachments as $id => $attachment ) {
		$link = isset($attr['link']) && 'file' == $attr['link'] ? wp_get_attachment_link($id, $size, false, false) : wp_get_attachment_link($id, $size, true, false);

		$output .= "<{$itemtag} class='gallery-item'>";
		$output .= "
			<{$icontag} class='gallery-icon' data-group='$selector'>
				$link
			</{$icontag}>";
		if ( $captiontag && trim($attachment->post_excerpt) ) {
			$output .= "
				<{$captiontag} class='gallery-caption'>
				" . wptexturize($attachment->post_excerpt) . "
				</{$captiontag}>";
		}
		$output .= "</{$itemtag}>";
		if ( $columns > 0 && ++$i % $columns == 0 )
			$output .= '<br style="clear: both" />';
	}

	$output .= "
			<br style='clear: both;' />
		</div>\n";

	return $output;
}

/**
 *	Content Loader HTML Codes
 *
 *	@since 1.0
 */
function cloudfw_loader_render() {
	return '
		<div class="ui--loading-progress clearfix">
			<i class="fontawesome-spinner fontawesome-spin fontawesome-large"></i>
		</div>
	';
}

/**
 * Removes category rel from links.
 */
add_filter( 'the_category', 'add_nofollow_cat' ); 
function add_nofollow_cat( $text ) { 
	$text = str_replace('rel="category"', "", $text); return $text; 
}

// TODO:
// posts_nav_link(); paginate_links(); next_posts_link(); previous_posts_link();