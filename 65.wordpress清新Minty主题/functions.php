<?php
/**
 * Improves the caption shortcode with HTML5 tag & microdata
 */
add_filter('img_caption_shortcode', 'html5_img_caption_shortcode_filter', 10, 3);

function html5_img_caption_shortcode_filter($val, $attr, $content = null) {
        extract(shortcode_atts(array(
                'id'    => '',
                'align' => 'alignnone',
                'width' => '',
                'caption' => ''
        ), $attr));

        if ( 1 > (int) $width || empty($caption) )
                return $val;

        if ( $id ) $id = 'id="' . esc_attr($id) . '" ';
		
		$content = str_replace('<img', '<img itemprop="contentURL"', $content);

        return '<figure ' . $id . 'class="wp-caption ' . esc_attr($align) . '" itemscope itemtype="http://schema.org/ImageObject" style="width: ' . (int) $width . 'px">' . do_shortcode( $content ) . '<figcaption class="wp-caption-text" itemprop="description">' . $caption . '</figcaption></figure>';
}

/**
 * Fix header issue when the admin bar is visible.
 */
function fix_header_top() {
	global $wp_version;
	if ( is_user_logged_in() ) echo '<style>.admin-bar #header{top:' . ($wp_version >= 3.8 ? 32 : 28) . 'px} @media screen and (max-width:782px) {.admin-bar #header {top:46px;z-index:499} @media screen and (max-width:600px) {html{margin-top:0!important}.admin-bar #header {top:0}</style>';
}
add_filter('wp_head', 'fix_header_top');

 /**
 * Insert post cover to RSS
 */
function minty_rss($content) {
	$cover = minty_get_post_cover();

	if( !empty( $cover ) )
		$content = '<a href="' . get_permalink($post->ID) . '">' . $cover . '</a>' . $content;

    return $content;
}
add_filter('the_excerpt_rss', 'minty_rss');
add_filter('the_content_feed', 'minty_rss');


/**
 * Sets up theme.
 */
function minty_setup() {
	//添加主题特性
	add_theme_support( 'custom-background' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list' ) );
	add_theme_support( 'post-formats', array(
		'aside', 'audio', 'chat', 'gallery', 'image', 'link', 'quote', 'status', 'video'
	) );
	//添加特色图片
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 700, get_option('minty_post_thumbnail_size_h', 220), true );

	//注册菜单
	register_nav_menus( array(
		'primary' => 'Navigation Menu',
		'footer' => 'Footer Menu'
	) );

	//禁用自带相册样式
	add_filter( 'use_default_gallery_style', '__return_false' );
}
add_action( 'after_setup_theme', 'minty_setup' );


/**
 * Registers sidebar.
 */
function minty_widgets_init() {
	register_sidebar( array(
		'name'          => '侧边栏（上）',
		'id'            => 'sidebar',
		'before_widget' => '<aside id="%1$s" class="widget %2$s clearfix">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title"><span>',
		'after_title'   => '</span></h3>',
	) );
	register_sidebar( array(
		'name'          => '侧边栏（下）',
		'id'            => 'sidebar-bottom',
		'before_widget' => '<aside id="%1$s" class="widget %2$s clearfix">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title"><span>',
		'after_title'   => '</span></h3>',
	) );
}
add_action( 'widgets_init', 'minty_widgets_init' );

/**
 * Enqueues scripts and styles for front end.
 */
function minty_scripts_styles() {
	wp_enqueue_script('jquery');
	
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );

	if ( get_option('minty_featured_content_position', 'disabled') != 'disabled' && get_option('minty_featured_content_type', 'slides') == 'slides' )
		wp_enqueue_script( 'responsiveslides', get_template_directory_uri() . '/js/vendor/responsiveslides.min.js', array( 'jquery' ), null, true );

	if ( get_option('minty_infinitescroll') > 0 )
		wp_enqueue_script( 'jquery-inview', get_template_directory_uri() . '/js/vendor/jquery.inview.min.js', array( 'jquery' ), null, true );

	if ( get_option('minty_nprogress') )
		wp_enqueue_script( 'nprogress', get_template_directory_uri() . '/js/vendor/nprogress.js', array( 'jquery' ), null, true );

	if ( get_option('minty_lazyload') )
		wp_enqueue_script( 'jquery-lazyload', get_template_directory_uri() . '/js/vendor/jquery.lazyload.min.js', array( 'jquery' ), null, true );

	if ( get_option('minty_snowfall') == 'site' || (get_option('minty_snowfall') == 'home' && is_home()) )
		wp_enqueue_script( 'snowfall', get_template_directory_uri() . '/js/vendor/snowfall.js', array(), null, true );

	wp_enqueue_script( 'minty-script', get_template_directory_uri() . '/js/script.js', array( 'jquery' ), null, true );

	wp_enqueue_style( 'minty-style', get_stylesheet_uri() );
	wp_enqueue_style( 'minty-style-customize', get_template_directory_uri() . '/theme-css.php' );
}
add_action( 'wp_enqueue_scripts', 'minty_scripts_styles' );

require_once(TEMPLATEPATH . '/inc/theme-customize.php');
require_once(TEMPLATEPATH . '/inc/theme-options.php');
require_once(TEMPLATEPATH . '/inc/theme-widgets.php');
require_once(TEMPLATEPATH . '/inc/theme-ajaxcomment.php');

/**
 * Add Theme Options Page to Admin Bar.
 */
function minty_add_theme_options_to_admin_bar( $wp_admin_bar ) {
	$args = array(
		'id'    => 'theme-options',
		'title' => '主题选项',
		'href'  => admin_url('themes.php?page=theme-options.php'),
		'parent'=> 'appearance'
	);
	$wp_admin_bar->add_node( $args );
}
add_action( 'admin_bar_menu', 'minty_add_theme_options_to_admin_bar', 999 );

/**
 * Displays navigation to next/previous set of posts when applicable.
 */
function minty_paging_nav() {
	global $wp_query;

	// Don't print empty markup if there's only one page.
	if ( $wp_query->max_num_pages < 2 && ( is_home() || is_archive() || is_search() ) )
		return;
	?>

	<div class="navigation">
		<?php if ( get_next_posts_link() ) echo str_replace('<a', '<a class="loadmore"', get_next_posts_link('查看更多')); ?>
		<?php if ( get_option('minty_pagination_list') != true ) : ?>
		<nav class="pagination" role="navigation">
			<?php
				if ( get_previous_posts_link() ) {
					previous_posts_link();
				} else {
					echo '<span>' . __('&laquo; Previous Page') . '</span>';
				}
				echo '<span class="pagenum">' . max( 1, get_query_var('paged') ) . '/' . $wp_query->max_num_pages . '</span>';
				if ( get_next_posts_link() ) {
					next_posts_link();
				} else {
					echo '<span>' . __('Next Page &raquo;') . '</span>';
				}
			?>
		</nav>
		<?php else : ?>
		<nav class="pagination" role="navigation">
			<?php
			global $wp_query;
	
			$big = 999999999; // need an unlikely integer
			
			echo paginate_links( array(
				'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
				'format' => '?paged=%#%',
				'current' => max( 1, get_query_var('paged') ),
				'total' => $wp_query->max_num_pages,
				'mid_size' => 3
			) );
			?>
		</nav>
		<?php endif; ?>
	</div>
	<?php
}

/**
 * Displays entry footer.
 */
function minty_single_footer() {
	if ( is_single() ) {
		$copyright = str_replace(array('{{title}}', '{{link}}'), array(get_the_title(), get_permalink()), stripslashes(get_option('minty_copyright')));
		if (!empty($copyright)) echo '<div class="copyright">' . $copyright . '</div>';
		if ( function_exists(wp_related_posts) ) { wp_related_posts(); };
		if ( function_exists(related_entries) ) { related_entries(); } ;
		echo '<div id="wumiiDisplayDiv"></div>';
    }
}


/**
 * Displays entry meta.
 */
function minty_entry_meta() {

	printf( '<time class="entry-date" datetime="%1$s" pubdate itemprop="datePublished">%2$s</time>',
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date( has_post_format( 'status' ) ? 'Y-m-d H:i' : 'Y-m-d') )
	);

	if ( ! has_post_format( 'status' ) ) {
		$categories_list = get_the_category_list( '、' );
		if ( $categories_list ) {
			echo ' <span class="dot">&bull;</span> <span class="categories-links" itemprop="keywords">' . $categories_list . '</span>';
		}
	}

	echo ' <span class="dot">&bull;</span> ';

	comments_popup_link('0 条评论', '1 条评论', '% 条评论', 'comments-link', '评论关闭');
	
	if (get_option( 'minty_show_post_author' )) echo ' <span class="dot">&bull;</span> <a class="author vcard" itemprop="author" itemscope itemtype="http://schema.org/Person" rel="author" href="' . get_author_posts_url( get_the_author_meta( 'ID' ) ) . '"><span itemprop="name" class="fn">' . get_the_author() . '</span></a>';

	if (function_exists('the_views')) {
		echo ' <span class="dot">&bull;</span>';
		the_views();
	};

	edit_post_link(__('Edit This'), ' <span class="dot">&bull;</span> ');
}

/**
 * Get Post Link.
 */
function minty_get_link_url() {
	$content = get_the_content();
	$has_url = get_url_in_content( $content );

	return ( $has_url ) ? $has_url : apply_filters( 'the_permalink', get_permalink() );
}

/**
 * Get First Image.
 */
function minty_get_first_img() {
	global $post;

	ob_start();
	ob_end_clean();
	$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);

	return $matches[1][0];
}

/**
 * Breadcrumb.
 */
function minty_breadcrumb() {
	if ( function_exists('yoast_breadcrumb') ) {
		echo '<div class="breadcrumb" itemprop="breadcrumb">';
		yoast_breadcrumb();
		echo '</div>';
	} elseif ( function_exists('bcn_display') ) {
		echo '<div class="breadcrumb" itemprop="breadcrumb">';
	    bcn_display();
	    echo '</div>';
	}
}

/**
 * Custom MetaBox.
 */
add_action( 'add_meta_boxes', 'custom_metabox' );

function custom_metabox(){
	add_meta_box('post_metabox', '题图', 'custom_metabox_callback', 'post');
};

function custom_metabox_callback( $post ) {
	$post_id = $post->ID;
	
	wp_nonce_field( plugin_basename( __FILE__ ), 'custom_metabox_nonce' );

	$meta_array = array(
		'cover' => array(
			'name' => '题图',
			'type' => 'text'
		)
	);

	echo '<table class="form-table">';
	foreach($meta_array as $key => $value) {
		echo "<tr><td><label for='{$key}'>" . $value['name'] . '</label></td><td>';
			switch ($value['type']) {
				case 'url':
					echo "<input type='url' placeholder='http://' id='{$key}' name='{$key}' value='" . get_post_meta($post_id, $key, true) . "' class='regular-text' />";
					break;
				case 'checkbox':
					echo "<label><input type='checkbox' id='{$key}' name='{$key}' value='1' " . checked(get_post_meta($post_id, $key, true), 1, false) . " /> {$value['name']}</label>";
					break;
				default:
					echo "<input type='{$value['type']}' id='{$key}' name='{$key}' value='" . get_post_meta($post_id, $key, true) . "' class='regular-text' />";
					break;
			};
		echo '</td></tr>';
	};
	echo '</table>';
};

function save_custom_meta($post_id) {
    if ( 'post' != $_POST['post_type'] ) {
        return;
    }
    if ( !current_user_can( 'edit_post', $post_id ) ) {
        return;
    }
    if ( ! isset( $_POST['custom_metabox_nonce'] ) || !wp_verify_nonce( $_POST['custom_metabox_nonce'], plugin_basename( __FILE__ ) ) )
    {
        return;
    }

	$meta_array = array('cover');
	foreach($meta_array as $key) {
		$val = $_REQUEST[$key];
		if (isset($val)) {
			update_post_meta($post_id, $key, $val);
		}
	}
};
add_action( 'save_post', 'save_custom_meta' );


/**
 * Get Post Cover.
 */
function minty_get_post_cover() {
	if ( has_post_thumbnail() ) {
		return get_the_post_thumbnail( get_the_ID(), 'post-thumbnail', array('itemprop' => 'image', 'lazyload' => 1) );
	} else {
		$cover = get_post_meta( get_the_ID(), 'cover', true );

		if( !empty( $cover ) ) {
			return '<img src="' . $cover . '" itemprop="image" width="700" alt="' . the_title_attribute( 'echo=0' ) . '" lazyload="1" />';
		} else {
			return;
		};
	}
}
/**
 * Get Post Thumb.
 */
function minty_get_post_thumb($post_id=false) {
	$noTitle = $post_id ? true : false;
	if(!$post_id) $post_id = get_the_ID();
	if ( has_post_thumbnail($post_id) ) {
		return get_the_post_thumbnail( $post_id, 'medium', array('itemprop' => 'image', 'lazyload' => 1) );
	} else {
		$cover = get_post_meta( $post_id, 'cover', true );

		if( !empty( $cover ) ) {
			return '<img src="' . $cover . '" itemprop="image" width="300" alt="' . ($noTitle?'':the_title_attribute( 'echo=0' )) . '" lazyload="1" />';
		} else {
			return;
		};
	}
}

/**
 * Output Post Cover.
 */
function minty_post_cover() {
	if ( !is_search() ) {
		$cover = minty_get_post_cover();
		if( !empty( $cover ) ) {
			if( is_single() ) {
?>
	<div class="entry-cover"><?php echo $cover; ?></div>
<?php
			} else {
?>
	<a class="entry-cover" href="<?php the_permalink(); ?>"><?php echo $cover; ?></a>
	<?php
			}
		}
	}
}

/**
 * Output Post Thumb.
 */
function minty_post_thumb() {
	if ( !is_search() ) {
		$thumb = minty_get_post_thumb();
		if( !empty( $thumb ) ) {
			if( is_single() ) {
?>
	<div class="entry-thumb entry-cover"><?php echo $thumb; ?></div>
<?php
			} else {
?>
	<a class="entry-thumb entry-cover" href="<?php the_permalink(); ?>"><?php echo $thumb; ?></a>
	<?php
			}
		}
	}
}

/**
 * Display User Info @ Header.
 */
function minty_userinfo() {
	if ( is_user_logged_in() ) {
		global $current_user;
        get_currentuserinfo();
        echo '<a href="' . get_edit_user_link() . '">' . get_avatar( $current_user->ID, 32 ) . '</a>';
	    echo '<a href="' . get_edit_user_link() . '">' . $current_user->display_name . '</a>';
	    echo ' [';
	    wp_loginout();
	    echo ']';
	} else {
		echo '<a href="' . wp_login_url( get_permalink() ) . '">' . get_avatar( '', 32 ) . '</a>';
		wp_loginout();
		wp_register(' / ', '');
	}
}

/**
 * Detect Mobile Device.
 */
function minty_is_wap() {
	return isset($_SERVER['HTTP_X_WAP_PROFILE']) || stripos($_SERVER['HTTP_ACCEPT'], 'wap') > 0;
}
function minty_is_mobile() {
	$useragent = $_SERVER['HTTP_USER_AGENT'];
	return wp_is_mobile() && stripos($useragent, 'iPad') === false && stripos($useragent, 'KFJWA') === false && stripos($useragent, 'KFJWI') === false && stripos($useragent, 'KFTT') === false;
}

/**
 * Featured Content.
 */
function minty_featured_content() {
    $featuredContentType = get_option('minty_featured_content_type', 'slides');
    $featuredContentCaption = get_option('minty_featured_content_caption', 'cover');
	$featuredContentData = json_decode('[' . stripslashes(get_option('minty_featured_content_data', '')) . ']');
?>
<div id="featured-content" class="<?php echo $featuredContentType == 'slides' ? 'rslides_container' : 'fcgrid fcgrid-' . count($featuredContentData) ?> fccaption-<?php echo $featuredContentCaption; ?>">
	<ul <?php if($featuredContentType == 'slides') echo 'class="rslides"'; ?>>
<?php foreach ($featuredContentData as $index=>$item) : ?>
		<li class="slide-<?php echo $index; ?>">
			<a href="<?php echo $item->link ?>">
				<img src="<?php echo $item->image ?>" alt="<?php echo $item->title ?>" />
			<?php if ($featuredContentCaption != "hidden") : ?>
				<h3><?php echo $item->title ?></h3>
			<?php endif; ?>
			</a>
		</li>
<?php endforeach; ?>
	</ul>
</div>
<?php
}

/**
 * Custom Excerpt.
 */
function minty_excerpt_length( $length ) {
	return get_option( 'minty_excerpt_length', 160 );
}
add_filter( 'excerpt_length', 'minty_excerpt_length', 999 );

function minty_excerpt_more( $more ) {
	return '';
}
add_filter( 'excerpt_more', 'minty_excerpt_more' );

/**
 * Comment Callback.
 */
if ( ! function_exists( 'minty_comment' ) ) :
function minty_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
	?>
	<li class="pingback">
		<p>Pingback: <?php comment_author_link(); ?></p>
	<?php
			break;
		default :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<div id="comment-<?php comment_ID(); ?>" class="comment-body">

			<div class="comment-author vcard">
				<?php
				$avatar = get_avatar( $comment, !$comment->comment_parent ? 50 : 30 );
				if ( ! is_admin() && get_option('minty_lazyload') )
					$avatar = str_replace( array('src=', 'avatar avatar-' ), array( 'src="' . get_template_directory_uri() . '/img/blank.gif" data-original=', 'lazy avatar avatar-' ), $avatar );
				echo $avatar;
				?>
				<cite class="fn"><?php comment_author_link(); ?></cite>
			<?php if ( $comment->comment_approved == '0' ) : ?>
				<em class="comment-awaiting-moderation">初次评论需要等待审核</em>
			<?php else : ?>
				<time>
				<?php
				if ( current_time('timestamp') - get_comment_time('U') < 2592000 ) {
					echo human_time_diff( get_comment_time('U'), current_time('timestamp') ) . '前';
				} else {
					echo comment_time('Y-n-j H:i');
				}
				?>
				</time>
				<?php endif; ?>
			</div>

			<div class="comment-content"><?php comment_text(); ?></div>

			<?php if ( $comment->comment_approved != '0' && $args != null && $depth != null) : ?>
			<footer class="comment-footer">
				<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
				<?php if(function_exists('mailtocommenter_button')) mailtocommenter_button();?>
				<?php edit_comment_link(); ?>
			</footer>
			<?php endif; ?>
		</div>

	<?php
			break;
	endswitch;
}
endif;

/**
 * Archives
 * based on `Clean Archives Reloaded` http://www.viper007bond.com/wordpress-plugins/clean-archives-reloaded/
 */

add_action( 'save_post',   'clean_minty_archives_cache' );
add_action( 'edit_post',   'clean_minty_archives_cache' );
add_action( 'delete_post', 'clean_minty_archives_cache' );
function clean_minty_archives_cache() {
	wp_cache_delete( 'minty_archives' );
}

function minty_archives() {
	global $wpdb;

	$posts = wp_cache_get( 'minty_archives' );

	if ( ! $posts ) {
		$rawposts = $wpdb->get_results( "SELECT ID, post_date, post_date_gmt, comment_count FROM $wpdb->posts WHERE post_status = 'publish' AND post_type = 'post' AND post_password = ''" );
	
		foreach( $rawposts as $post ) {
			$posts[mysql2date( 'Y.m', $post->post_date )][] = $post;
		}
		$rawposts = null;

		wp_cache_set( 'minty_archives', $posts );
	}

	if (!$posts) return false;

	krsort( $posts );

	foreach( $posts as $key => $month ) {
		$sorter = array();
		foreach ( $month as $post )
			$sorter[] = $post->post_date_gmt;

		array_multisort( $sorter, SORT_DESC, $month );

		$posts[$key] = $month;
		unset($month);
	}

	$html = '<ul class="archives-list">';

	foreach( $posts as $yearmonth => $posts ) {
		list( $year, $month ) = explode( '.', $yearmonth );

		$firstpost = TRUE;
		foreach( $posts as $post ) {
			if ( TRUE == $firstpost ) {
				$html .= '<li><b><a href="' . get_month_link($year , $month) . '">' . sprintf( '%1$s年%2$d月', $year, ltrim($month, '0') ) . '</a></b> <span>(' . count($posts) . ' 篇文章)</span><ul>';
				$firstpost = FALSE;
			}

			$html .= '<li>' .  mysql2date( 'd', $post->post_date ) . ': <a href="' . get_permalink( $post->ID ) . '">' . get_the_title( $post->ID ) . '</a> <span>(' . $post->comment_count . ')</span></li>';
		}

		$html .= '</ul></li>';
	}

	$html .= '</ul>';

	echo $html;
}