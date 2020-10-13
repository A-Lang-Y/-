<?php if ( post_password_required() )
	return;
?>

<div id="comments">

	<?php if ( comments_open() ) : ?>
		<h3 id="comments-title">
			<?php comments_number('发表评论','1 条评论','% 条评论'); ?>
		</h3>

		<div id="respond">
			<?php if ( get_option( 'comment_registration' ) && !is_user_logged_in() ) : ?>
				<div id="commentform">
					<img alt="" src="http://1.gravatar.com/avatar/ad516503a11cd5ca435acc9bb6523536?s=50" class="avatar avatar-50 photo" height="50" width="50" />
					<p class="comment-form-comment must-log-in">
						<?php echo sprintf( __( 'You must be <a href="%s">logged in</a> to post a comment.' ), wp_login_url( apply_filters( 'the_permalink', get_permalink( $post->ID ) ) ) ); ?>
					</p>
				</div>
			<?php else : ?>
				<?php cancel_comment_reply_link(); ?>
				<form action="<?php echo site_url( '/wp-comments-post.php' ); ?>" method="post" id="commentform">
					<?php $current_user = wp_get_current_user(); echo get_avatar( $current_user->user_email, 50 ); ?>
					<div id="comment-settings">
					<?php if ( is_user_logged_in() ) : ?>
						<?php echo '<div class="logged-in-as">' . sprintf( __( 'Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>' ), get_edit_user_link(), $user_identity, wp_logout_url( get_permalink( $post->ID ) ) ) . '</div>'; ?>
					<?php else : ?>
						<div class="comment-fields">
							<div class="comment-form-author">
								<label for="author">昵称</label><input id="author" name="author" type="text" value="<?php echo $comment_author; ?>" size="30" <?php if ( get_option('require_name_email') ) echo 'required title="必填项"'; ?>>
							</div>
							<div class="comment-form-email">
								<label for="email">邮箱</label><input id="email" name="email" type="email" value="<?php echo $comment_author_email; ?>" size="30" <?php if ( get_option('require_name_email') ) echo 'required title="必填项"'; ?>>
							</div>
							<div class="comment-form-url">
								<label for="url">网站</label><input id="url" name="url" type="text" value="<?php echo $comment_author_url; ?>" size="30">
							</div>
						</div>
					<?php endif; ?>
						<div class="comment-more">
							<?php do_action( 'comment_form', $post->ID ); ?>	
						</div>
					</div>
					<p class="comment-form-comment">
						<label for="comment"><?php echo get_option('minty_comment_placeholder'); ?></label><textarea id="comment" name="comment" cols="45" rows="8" onfocus="this.previousSibling.style.display='none'" onblur="this.previousSibling.style.display=this.value==''?'block':'none'" required></textarea>
					</p>

					<footer class="comment-form-footer">
						<div class="comment-smilies"><?php if ( function_exists('cs_print_smilies') ) { cs_print_smilies(); } ?></div>
						<input name="submit" type="submit" id="submit" value="发表评论" />
						<?php if ( is_user_logged_in() ) : ?>
						<div class="comment-settings-toggle"><span class="name"><?php echo $user_identity; ?></span><i class="arrow">&#9660;</i></div>
						<?php else : ?>
						<div class="comment-settings-toggle required"><span class="name">昵称</span><i class="arrow">&#9660;</i></div>
						<?php endif; ?>
					</footer>
					<?php comment_id_fields( $post->ID ); ?>
				</form>
			<?php endif; ?>
		</div>
		<?php do_action( 'comment_form_after' ); ?>

		<?php if ( !have_comments() ) : ?>
			<p class="no-comments" onclick="document.getElementById('explorer').scrollIntoView();document.getElementById('comment').focus();"><?php echo get_option('minty_comment_sofatext'); ?></p>
		<?php endif; ?>

	<?php else : ?>
		<p id="comments-title" class="nocomments">评论已关闭</p>
	<?php endif; ?>

	<?php if ( have_comments() ) : ?>
		<ol class="commentlist">
			<?php
				wp_list_comments( array(
					'style'       => 'ol',
					'short_ping'  => true,
					'callback' => 'minty_comment',
					'reverse_top_level' => true,
					'reverse_children'  => false	
				) );
			?>
		</ol>

		<?php
		 if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) && get_previous_comments_link() )
			echo '<div class="navigation">' . str_replace('<a', '<a class="loadmore" role="navigation"', get_previous_comments_link('更多评论')) . '</div>'
		?>
	<?php endif; ?>

</div>