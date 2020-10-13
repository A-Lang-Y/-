<?php
class Minty_PopularPosts extends WP_Widget {

	function __construct() {
		parent::__construct( 'minty_popularposts', '[Minty]最热文章', array( 'description' => '近期评论最多的文章' ) );

		add_action( 'comment_post', array($this, 'flush_minty_popularposts_cache') );
		add_action( 'transition_comment_status', array($this, 'flush_minty_popularposts_cache') );
	}

	function widget( $args, $instance ) {
		global $wpdb;

		extract($args);

		$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : '最热文章';
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );
		$number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 7;
		$thumb = isset($instance['thumb']) ? $instance['thumb'] : false;
		if ( ! $number )
 			$number = 7;

		$days = ( ! empty( $instance['days'] ) ) ? absint( $instance['days'] ) : 30;
		
		$popularposts = wp_cache_get( 'minty_popularposts' );

		if ( ! $popularposts ) {
			$popularposts = $wpdb->get_results("
				SELECT id, post_title, comment_count 
				FROM $wpdb->posts
				WHERE post_type='post' AND post_status = 'publish' AND post_date > '" . date('Y-m-d', strtotime('-' . $days . ' days')) . "' 
				ORDER BY comment_count DESC 
				LIMIT " . $number);
	
			wp_cache_set( 'minty_popularposts', $popularposts );
		}
		
		$output .= $before_widget;
		if ( $title )
			$output .= $before_title . $title . $after_title;

		$output .= '<ul';
		if ($thumb) $output .= ' class="minty_thumblist"';
		$output .= '>';
		if ( $popularposts ) {
			foreach ($popularposts as $post) {
				$output .= '<li><a href="' . get_permalink($post->id) . '" title="' . esc_attr($post->post_title) . '">';
				if ($thumb) $output .= minty_get_post_thumb($post->id) . '<span>';
				$output .= $post->post_title;
				if ($thumb) $output .= '</span>';
				$output .= '</a></li>';
			}
		}
		$output .= '</ul>';
		$output .= $after_widget;

		echo $output;
	}
	
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['number'] = (int) $new_instance['number'];
		$instance['days'] = (int) $new_instance['days'];
		$instance['thumb'] = isset($new_instance['thumb']) ? true : false;
		if ( $instance['days'] < 7 || 365 < $instance['days'] )
			$instance['days'] = 30;

		$this->flush_minty_popularposts_cache();

		return $instance;
	}
	
	function form( $instance ) {
		$title  = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$number = isset( $instance['number'] ) ? absint( $instance['number'] ) : 7;
		$days  = (int) $instance['days'];
		$thumb = isset($instance['thumb']) ? $instance['thumb'] : true;
		if ( $days < 7 || 365 < $days )
			$days = 30;
?>
		<p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>

		<p><label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of posts to show:' ); ?></label>
		<input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo $number; ?>" size="3" /></p>
		
		<p><label for="<?php echo $this->get_field_id( 'days' ); ?>">文章选取范围：</label>
		<select id="<?php echo $this->get_field_id( 'days' ); ?>" name="<?php echo $this->get_field_name( 'days' ); ?>">
<?php
			$daysArray = array(
				'一周内' => 7,
				'一个月内' => 30,
				'三个月内' => 90,
				'半年内' => 180,
				'一年内' => 365,
			);
			
			foreach ($daysArray as $text => $day) {
				echo "<option value='$day' " . selected( $days, $day, false ) . ">$text</option>";
			}
?>
		</select></p>

		<p><input class="checkbox" type="checkbox" <?php checked($instance['thumb'], true) ?> id="<?php echo $this->get_field_id('thumb'); ?>" name="<?php echo $this->get_field_name('thumb'); ?>" />
		<label for="<?php echo $this->get_field_id('thumb'); ?>">显示缩略图</label></p>
<?php
	}
	
	function flush_minty_popularposts_cache() {
		wp_cache_delete( 'minty_popularposts' );
	}
}
add_action('widgets_init', create_function('', 'return register_widget("Minty_PopularPosts");'));


class Minty_RandomLinks extends WP_Widget {

	function __construct() {
        parent::__construct( 'minty_randomlinks', '[Minty]随机链接', array( 'description' => '随机显示' . __( "Your blogroll" ), 'classname' => 'widget_links' ) );
    }

	function widget( $args, $instance ) {
		extract($args, EXTR_SKIP);

		$onlyhome = isset($instance['onlyhome']) ? $instance['onlyhome'] : 0;
		$category = isset($instance['category']) ? $instance['category'] : false;
		$title = apply_filters('widget_title', empty($instance['title']) ? '随机链接' : $instance['title'], $instance, $this->id_base);
		$limit = isset( $instance['limit'] ) ? $instance['limit'] : 10;
		$target = isset($instance['newwin']) ? '' : ' target="_blank"';
		
		if(!$onlyhome || ($onlyhome && is_home())){
			echo $before_widget;
			echo $before_title . $title . $after_title;
			echo '<ul class="xoxo blogroll">';
			wp_list_bookmarks(apply_filters('widget_links_args', 'title_li=&categorize=0&orderby=rand' . '&category=' . $instance['category'] . '&limit=' . $instance['limit']));
			echo apply_filters( 'widget_text', empty( $instance['addto'] ) ? '' : $instance['addto'], $instance );
			echo '</ul>';
			echo $after_widget;
		};
	}

	function update( $new_instance, $old_instance ) {
		$new_instance = (array) $new_instance;
		$instance = array( 'title' => '', 'category' => false, 'limit' => 10, 'onlyhome' => false, 'addto' => '' );
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['category'] = intval($new_instance['category']);
		$instance['limit'] = ! empty( $new_instance['limit'] ) ? intval( $new_instance['limit'] ) : 10;
		$instance['onlyhome'] = isset($new_instance['onlyhome']) ? 1 : 0;
		$instance['addto'] = $new_instance['addto'];
		
		return $instance;
	}

	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'category' => false, 'limit' => 10, 'onlyhome' => false, 'addto' => '' ) );
		
		$title = strip_tags($instance['title']);
		$addto = esc_textarea($instance['addto']);
		if ( ! $limit = intval( $instance['limit'] ) ) $limit = 10;
		
		$link_cats = get_terms( 'link_category' );
?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>
		
		<p><label for="<?php echo $this->get_field_id('category'); ?>"><?php _e( 'Select Link Category:' ); ?></label>
		<select class="widefat" id="<?php echo $this->get_field_id('category'); ?>" name="<?php echo $this->get_field_name('category'); ?>"></p>
		
		<p><option value="">所有链接</option>
		<?php
		foreach ( $link_cats as $link_cat ) {
			echo '<option value="' . intval( $link_cat->term_id ) . '"'
				. selected( $instance['category'], $link_cat->term_id, false )
				. '>' . $link_cat->name . "</option>\n";
		}
		?>
		</select></p>
		
		<p><label for="<?php echo $this->get_field_id('limit'); ?>"><?php _e( 'Number of links to show:' ); ?></label>
		<input id="<?php echo $this->get_field_id('limit'); ?>" name="<?php echo $this->get_field_name('limit'); ?>" type="text" value="<?php echo $limit == 10 ? '' : intval( $limit ); ?>" size="3" /></p>

		<p><label for="<?php echo $this->get_field_id('addto'); ?>">追加链接：</label>
		<textarea class="widefat" rows="6" cols="20" id="<?php echo $this->get_field_id('addto'); ?>" name="<?php echo $this->get_field_name('addto'); ?>"><?php echo $addto; ?></textarea>
		<small>链接格式：</small><br /><code>&lt;li&gt;&lt;a href=&quot;地址&quot;&gt;名称&lt;/a&gt;&lt;/li&gt;</code></p>
		
		<p><input class="checkbox" type="checkbox" <?php checked($instance['onlyhome'], true) ?> id="<?php echo $this->get_field_id('onlyhome'); ?>" name="<?php echo $this->get_field_name('onlyhome'); ?>" />
		<label for="<?php echo $this->get_field_id('onlyhome'); ?>">仅在首页显示</label></p>
<?php
	}
}
add_action('widgets_init', create_function('', 'return register_widget("Minty_RandomLinks");'));


class Minty_MailSubscription extends WP_Widget {

	function __construct() {
        parent::__construct( 'minty_mailsubscription', '[Minty]邮件订阅', array( 'description' => 'QQ邮件列表订阅工具' ) );
	}

	function widget( $args, $instance ) {

		extract($args);
		
		$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : '邮件订阅';
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );
		
		$nid = empty( $instance['nid'] ) ? '' : $instance['nid'];
		$info = empty( $instance['info'] ) ? '订阅精彩内容' : $instance['info'];
		$placeholder = empty( $instance['placeholder'] ) ? 'your@email.com' : $instance['placeholder'];
		
		$output .= $before_widget;
		if ( $title )
			$output .= $before_title . $title . $after_title;

		$output .= '<form action="http://list.qq.com/cgi-bin/qf_compose_send" target="_blank" method="post">'
				.      '<h3 class="info">' . $info . '</h3>'
				.      '<input type="hidden" name="t" value="qf_booked_feedback" /><input type="hidden" name="id" value="' . $nid . '" />'
				.      '<input type="email" name="to" class="rsstxt" placeholder="' . $placeholder . '" value="" required /><input type="submit" class="rssbutton" value="订阅" />'
				.  '</form>';
		
		$output .= $after_widget;

		echo $output;
	}
	
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['nid'] = strip_tags( $new_instance['nid'] );
		$instance['info'] = strip_tags( $new_instance['info'] );
		$instance['placeholder'] = strip_tags( $new_instance['placeholder'] );

		return $instance;
	}
	
	function form( $instance ) {
		$title  = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$nid = esc_attr( $instance['nid'] );
		$info = esc_attr( $instance['info'] );
		$placeholder = esc_attr( $instance['placeholder'] );

?>
		<p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>

		<p><label for="<?php echo $this->get_field_id( 'nid' ); ?>">nId：</label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'nid' ); ?>" name="<?php echo $this->get_field_name( 'nid' ); ?>" type="text" value="<?php echo $nid; ?>" /></p>
		
		<p><label for="<?php echo $this->get_field_id( 'info' ); ?>">提示文字：</label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'info' ); ?>" name="<?php echo $this->get_field_name( 'info' ); ?>" type="text" value="<?php echo $info; ?>" /></p>
		
		<p><label for="<?php echo $this->get_field_id( 'placeholder' ); ?>">占位文字：</label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'placeholder' ); ?>" name="<?php echo $this->get_field_name( 'placeholder' ); ?>" type="text" value="<?php echo $placeholder; ?>" /></p>
		
		<p class="description">本工具基于 <a href="http://list.qq.com/" target="_blank">QQ邮件列表</a> 服务。</p>

<?php
	}
}
add_action('widgets_init', create_function('', 'return register_widget("Minty_MailSubscription");'));


class Minty_Ad extends WP_Widget {

	function __construct() {
		parent::__construct( 'minty_ad', '[Minty]广告', array( 'description' => '广告位' ) );
	}

	function widget( $args, $instance ) {
		extract($args);
		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
		$code = apply_filters( 'widget_text', empty( $instance['code'] ) ? '' : $instance['code'], $instance );
		echo $before_widget;
		if ( !empty( $title ) ) { echo $before_title . $title . $after_title; }
		echo $code;
		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		if ( current_user_can('unfiltered_html') )
			$instance['code'] =  $new_instance['code'];
		else
			$instance['code'] = stripslashes( wp_filter_post_kses( addslashes($new_instance['code']) ) );
		return $instance;
	}

	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'code' => '' ) );
		$title = strip_tags($instance['title']);
		$code = esc_textarea($instance['code']);
?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>

		<p><label for="<?php echo $this->get_field_id('code'); ?>">代码：</label>
		<textarea class="widefat" rows="16" cols="20" id="<?php echo $this->get_field_id('code'); ?>" name="<?php echo $this->get_field_name('code'); ?>"><?php echo $code; ?></textarea>
		<small>推荐广告尺寸：200 x 200 - 小方形</small></p>
<?php
	}
}
add_action('widgets_init', create_function('', 'return register_widget("Minty_Ad");'));

class Minty_Slideshow extends WP_Widget {

	function __construct() {
		parent::__construct( 'minty_slideshow', '[Minty]幻灯片', array( 'description' => '轮播幻灯片' ) );
	}

	function widget( $args, $instance ) {
		extract($args);
		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
		$code = apply_filters( 'widget_text', empty( $instance['code'] ) ? '' : $instance['code'], $instance );
		echo $before_widget;
		if ( !empty( $title ) ) { echo $before_title . $title . $after_title; }
		echo '<div class="slideshow-wrap"><script>var slideList = [' . $code . '];</script></div>';
		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		if ( current_user_can('unfiltered_html') )
			$instance['code'] =  $new_instance['code'];
		else
			$instance['code'] = stripslashes( wp_filter_post_kses( addslashes($new_instance['code']) ) );
		return $instance;
	}

	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'code' => '' ) );
		$title = strip_tags($instance['title']);
		$code = esc_textarea($instance['code']);
?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>

		<p><label for="<?php echo $this->get_field_id('code'); ?>">代码：</label>
		<textarea class="widefat" rows="16" cols="20" id="<?php echo $this->get_field_id('code'); ?>" name="<?php echo $this->get_field_name('code'); ?>"><?php echo $code; ?></textarea>
		<small>数据格式：</small><br />
		<pre><code style="display:block">{
	"image": "幻灯片1的图片地址",
	"title": "幻灯片1的文字描述",
	"link": "幻灯片1的链接地址"
}, {
	"image": "幻灯片2的图片地址",
	"title": "幻灯片2的文字描述",
	"link": "幻灯片2的链接地址"
} ... {
	"image": "幻灯片N的图片地址",
	"title": "幻灯片N的文字描述",
	"link": "幻灯片N的链接地址"
}</code></pre></p>
<?php
	}
}
add_action('widgets_init', create_function('', 'return register_widget("Minty_Slideshow");'));

class Minty_RecentComments extends WP_Widget {


	function __construct() {
        parent::__construct( 'minty_recentcomments', '[Minty]最新评论', array( 'description' => '带头像的最新评论' ) );

		add_action( 'comment_post', array($this, 'flush_minty_recentcomments_cache') );
		add_action( 'edit_comment', array($this, 'flush_minty_recentcomments_cache') );
		add_action( 'transition_comment_status', array($this, 'flush_minty_recentcomments_cache') );
	}

	function flush_minty_recentcomments_cache() {
		wp_cache_delete('minty_recentcomments');
	}

	function widget( $args, $instance ) {
		global $comments, $comment;

		$cache = wp_cache_get('minty_recentcomments');

		if ( ! is_array( $cache ) )
			$cache = array();

		if ( ! isset( $args['widget_id'] ) )
			$args['widget_id'] = $this->id;

		if ( isset( $cache[ $args['widget_id'] ] ) ) {
			echo $cache[ $args['widget_id'] ];
			return;
		}

 		extract($args, EXTR_SKIP);
 		$output = '';

		$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : __( 'Recent Comments' );
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );
		$number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 5;
		if ( ! $number )
 			$number = 5;

		$comments = get_comments( apply_filters( 'widget_comments_args', array( 'number' => $number, 'status' => 'approve', 'post_status' => 'publish' ) ) );
		$output .= $before_widget;
		if ( $title )
			$output .= $before_title . $title . $after_title;

		$output .= '<ul id="minty_recentcomments">';
		if ( $comments ) {
			foreach ( (array) $comments as $comment) {
				if ($comment->comment_type == '') $output .=  '<li><a href="' . $comment->comment_author_url . '" target="_blank" rel="external nofollow" class="avatar">' . get_avatar($comment->comment_author_email, 32) . '</a><div class="bd">' . get_comment_author_link() .'<a href="' . esc_url( get_comment_link($comment->comment_ID) ) . '" class="desc" title="发表在《' . esc_attr(get_the_title($comment->comment_post_ID)) . '》">' . $comment->comment_content . '</a>' . '</div></li>';
			}
 		}
		$output .= '</ul>';
		$output .= $after_widget;

		echo $output;
		$cache[$args['widget_id']] = $output;
		wp_cache_set('minty_recentcomments', $cache);
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['number'] = absint( $new_instance['number'] );
		$this->flush_minty_recentcomments_cache();

		return $instance;
	}

	function form( $instance ) {
		$title  = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$number = isset( $instance['number'] ) ? absint( $instance['number'] ) : 5;
?>
		<p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>

		<p><label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of comments to show:' ); ?></label>
		<input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo $number; ?>" size="3" /></p>
<?php
	}
}

add_action('widgets_init', create_function('', 'return register_widget("Minty_RecentComments");'));


class Minty_RecentPosts extends WP_Widget {

	function __construct() {
        parent::__construct( 'minty_recentposts', '[Minty]最新文章', array( 'description' => '带缩略图的最新文章' ) );

		add_action( 'save_post', array($this, 'flush_minty_recentposts_cache') );
		add_action( 'deleted_post', array($this, 'flush_minty_recentposts_cache') );
		add_action( 'switch_theme', array($this, 'flush_minty_recentposts_cache') );
	}

	function widget($args, $instance) {
		$cache = wp_cache_get('minty_recentposts');

		if ( !is_array($cache) )
			$cache = array();

		if ( ! isset( $args['widget_id'] ) )
			$args['widget_id'] = $this->id;

		if ( isset( $cache[ $args['widget_id'] ] ) ) {
			echo $cache[ $args['widget_id'] ];
			return;
		}

		ob_start();
		extract($args);

		$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : __( 'Recent Posts' );
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );
		$number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 10;
		if ( ! $number )
 			$number = 10;

		$r = new WP_Query( apply_filters( 'widget_posts_args', array( 'posts_per_page' => $number, 'no_found_rows' => true, 'post_status' => 'publish', 'ignore_sticky_posts' => true ) ) );
		if ($r->have_posts()) :
?>
		<?php echo $before_widget; ?>
		<?php if ( $title ) echo $before_title . $title . $after_title; ?>
		<ul class="minty_thumblist">
		<?php while ( $r->have_posts() ) : $r->the_post(); ?>
			<li>
				<a href="<?php the_permalink(); ?>">
					<?php echo minty_get_post_thumb($post->id); ?><span><?php get_the_title() ? the_title() : the_ID(); ?></span>
				</a>
			</li>
		<?php endwhile; ?>
		</ul>
		<?php echo $after_widget; ?>
<?php
		// Reset the global $the_post as this query will have stomped on it
		wp_reset_postdata();

		endif;

		$cache[$args['widget_id']] = ob_get_flush();
		wp_cache_set('minty_recentposts', $cache);
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['number'] = (int) $new_instance['number'];
		$this->flush_minty_recentposts_cache();

		return $instance;
	}

	function flush_minty_recentposts_cache() {
		wp_cache_delete('minty_recentposts');
	}

	function form( $instance ) {
		$title     = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$number    = isset( $instance['number'] ) ? absint( $instance['number'] ) : 5;
?>
		<p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>

		<p><label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of posts to show:' ); ?></label>
		<input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo $number; ?>" size="3" /></p>
<?php
	}
}
add_action('widgets_init', create_function('', 'return register_widget("Minty_RecentPosts");'));