<div id="comments">
	<?php if (post_password_required()) : ?>
	<p><?php _e( 'Post is password protected. Enter the password to view any comments.', 'corpo' ); ?></p>
</div>

	<?php return; endif; ?>

<?php if (have_comments()) : ?>

	<h2><?php comments_number(); ?></h2>

	<ol class="commentlist">
		<?php wp_list_comments('type=all&callback=corpo_comments'); // Custom callback in functions.php ?>
	</ol>
    
    <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
		<div class="wp-pagenavi">
			<div class="alignleft"><?php previous_comments_link( __( '&larr; Older Comments', 'corpo' ) ); ?></div>
			<div class="alignright"><?php next_comments_link( __( 'Newer Comments &rarr;', 'corpo' ) ); ?></div>
		</div>
    <?php endif; // check for comment navigation ?>
    
<?php elseif ( ! comments_open() && ! is_page() && post_type_supports( get_post_type(), 'comments' ) ) : ?>
	
	<p><?php _e( 'Comments are closed.', 'corpo' ); ?></p>
	
<?php endif; ?>

<?php 
    comment_form(array(
        'comment_notes_before' => '',    
        'comment_notes_after' => ''
        )
    ); 
?>

</div>

