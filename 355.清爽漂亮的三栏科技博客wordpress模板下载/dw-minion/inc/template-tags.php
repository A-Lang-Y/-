<?php
if ( ! function_exists( 'dw_minion_content_nav' ) ) :
function dw_minion_content_nav( $nav_id ) {
	global $wp_query, $post;
	if ( is_single() ) {
		$previous = ( is_attachment() ) ? get_post( $post->post_parent ) : get_adjacent_post( false, '', true );
		$next = get_adjacent_post( false, '', false );
		if ( ! $next && ! $previous )
			return;
	}
	if ( $wp_query->max_num_pages < 2 && ( is_home() || is_archive() || is_search() ) )
		return;
	$nav_class = ( is_single() ) ? 'post-navigation pager' : 'paging-navigation pager';
	?>
	<nav role="navigation" id="<?php echo esc_attr( $nav_id ); ?>" class="<?php echo $nav_class; ?>">
	<?php if ( is_single() ) : ?>
		<?php previous_post_link( '<div class="nav-previous">%link</div>', '<span class="meta-nav btn">' . _x( '<i class="icon-chevron-left"></i>', 'Previous post link', 'dw-minion' ) . '</span> <span class="pager-title">%title</span>' ); ?>
		<?php next_post_link( '<div class="nav-next">%link</div>', '<span class="meta-nav btn">' . _x( '<i class="icon-chevron-right"></i>', 'Next post link', 'dw-minion' ) . '</span><span class="pager-title">%title</span>' ); ?>
	<?php elseif ( $wp_query->max_num_pages > 1 && ( is_home() || is_archive() || is_search() ) ) : ?>
		<div class="nav-previous">
			<?php if ( get_previous_posts_link() ) : ?>
				<?php previous_posts_link( __( '<span class="meta-nav btn"><i class="icon-chevron-left"></i></span>', 'dw-minion' ) ); ?>
			<?php else: ?>
				<span class="btn disabled"><i class="icon-chevron-left"></i></span>
			<?php endif; ?>
		</div>
		<div class="nav-next">
			<?php if ( get_next_posts_link() ) : ?>
				<?php next_posts_link( __( '<span class="meta-nav btn"><i class="icon-chevron-right"></i></span>', 'dw-minion' ) ); ?>
			<?php else: ?>
				<span class="btn disabled"><i class="icon-chevron-right"></i></span>
			<?php endif; ?>
		</div>
	<?php endif; ?>
	</nav>
	<?php
}
endif;

if ( ! function_exists( 'dw_minion_comment' ) ) :
function dw_minion_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	if ( 'pingback' == $comment->comment_type || 'trackback' == $comment->comment_type ) : ?>
	<li id="comment-<?php comment_ID(); ?>" <?php comment_class(); ?>>
		<div class="comment-body">
			<?php _e( 'Pingback:', 'dw-minion' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( 'Edit', 'dw-minion' ), '<span class="edit-link">', '</span>' ); ?>
		</div>
	<?php else : ?>
	<li id="comment-<?php comment_ID(); ?>" <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ); ?>>
		<article id="div-comment-<?php comment_ID(); ?>" class="comment-body">
			<footer class="comment-meta">
				<div class="comment-author vcard">
					<?php if ( 0 != $args['avatar_size'] ) echo get_avatar( $comment, 60 ); ?>
					<?php printf( __( '%s', 'dw-minion' ), sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?>
				</div>
				<div class="comment-metadata">
					<a class="comment-datetime" href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
						<i class="icon-time"></i>
						<time datetime="<?php comment_time( 'c' ); ?>">
							<?php printf( _x( '%1$s at %2$s', '1: date, 2: time', 'dw-minion' ), get_comment_date(), get_comment_time() ); ?>
						</time>
					</a>
					<?php edit_comment_link( __( '<i class="icon-pencil"></i> Edit', 'dw-minion' ), '<span class="edit-link">', '</span>' ); ?>
				</div>
				<?php if ( '0' == $comment->comment_approved ) : ?>
				<p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'dw-minion' ); ?></p>
				<?php endif; ?>
			</footer>
			<div class="comment-content">
				<?php comment_text(); ?>
			</div>
			<span class="reply">
				<?php comment_reply_link( array_merge( $args, array( 'add_below' => 'div-comment', 'reply_text' => '<i class="icon-reply"></i> Reply' ,'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
			</span>
		</article>
	<?php
	endif;
}
endif;

if ( ! function_exists( 'dw_minion_entry_meta' ) ) :
function dw_minion_entry_meta() {
	if ( 'post' != get_post_type() || has_post_format('link') ) return false;
	echo '<div class="entry-meta">';
	if ( ! has_post_format('quote') ) {
		printf( __( '<span class="byline">By <span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s">%3$s</a></span></span>', 'dw-minion' ),
			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
			esc_attr( sprintf( __( 'View all posts by %s', 'dw-minion' ), get_the_author() ) ),
			esc_html( get_the_author() )
		);
		$categories_list = get_the_category_list( __( ', ', 'dw-minion' ) );
		if ( $categories_list )
			printf( __( '<span class="cat-links"> in %1$s</span>', 'dw-minion' ), $categories_list );
		if( 'gallery' == get_post_format() ) {
			$post_format_icon = 'icon-picture';
		} else if ( 'video' == get_post_format() ) {
			$post_format_icon = 'icon-facetime-video';
		} else if ( 'quote' == get_post_format() ) {
			$post_format_icon = 'icon-quote-left';
		} else if ( 'link' == get_post_format() ) {
			$post_format_icon = 'icon-link';
		} else {
			$post_format_icon = 'icon-file-text';
		}
		printf( __( '<span class="sep"><span class="post-format"><i class="%1$s"></i></span></span>', 'dw-minion' ), $post_format_icon );
	}
	$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';
	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() )
	);
	printf( __( '<span class="posted-on"><a href="%1$s" title="%2$s" rel="bookmark"><i class="icon-calendar-empty"></i> %3$s</a></span>', 'dw-minion' ),
		esc_url( get_permalink() ),
		esc_attr( get_the_time() ),
		$time_string
	);
	if ( ! post_password_required() && comments_open() ) { ?>
		<span class="comments-link"><?php comments_popup_link( __( '<i class="icon-comment-alt"></i> 0 Comment', 'dw-minion' ), __( '<i class="icon-comment-alt"></i> 1 Comment', 'dw-minion' ), __( '<i class="icon-comment-alt"></i> % Comments', 'dw-minion' ) ); ?></span>
	<?php }
	echo '</div>';
}
endif;

function dw_minion_related_post($post_id) {
	$tags = wp_get_post_tags($post_id);
	if ($tags) {
		$tag_ids = array();
		foreach($tags as $individual_tag) $tag_ids[] = $individual_tag->term_id;
		$args = array (
			'tag__in' => $tag_ids,
			'post__not_in' => array($post_id),
			'posts_per_page' => 5,
			'ignore_sticky_posts'=>1 
		);
	} else {
		$args = array (
			'post__not_in' => array($post_id),
			'posts_per_page' => 5,
			'ignore_sticky_posts'=>1 
		);
	} ?>

<?php $related_query = new wp_query( $args ); ?>
	<?php if ( $related_query->have_posts() ) : ?>
	<div class="related-posts">
		<h2 class="related-posts-title"><?php _e( 'Related Articles.', 'dw_minion' ); ?></h2>
		<div class="related-content">
			<?php while ( $related_query->have_posts() ) : $related_query->the_post(); ?>
			<article class="related-post clearfix">
				<h3 class="related-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h3>
				<div class="related-meta"><time class="related-date"><?php echo get_the_date('d M, Y'); ?></time></div>
			</article>
			<?php endwhile; ?>
		</div>
	</div>
	<?php endif; ?>
<?php wp_reset_query(); ?>
<?php }