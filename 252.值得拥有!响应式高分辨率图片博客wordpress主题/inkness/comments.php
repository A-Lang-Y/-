<?php
/**
 * The template for displaying Comments.
 *
 * The area of the page that contains both current comments
 * and the comment form. The actual display of comments is
 * handled by a callback to inkness_comment() which is
 * located in the inc/template-tags.php file.
 *
 * @package Inkness
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() )
	return;
?>

	<div id="comments" class="comments-area">

	<?php // You can start editing here -- including this comment! ?>

	<?php if ( have_comments() ) : ?>
		<h2 class="comments-title">
			<?php
				printf( _nx( 'One thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', get_comments_number(), 'comments title', 'inkness' ),
					number_format_i18n( get_comments_number() ), '<span>' . get_the_title() . '</span>' );
			?>
		</h2>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
		<nav id="comment-nav-above" class="comment-navigation" role="navigation">
			<h1 class="screen-reader-text"><?php _e( 'Comment navigation', 'inkness' ); ?></h1>
			<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'inkness' ) ); ?></div>
			<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'inkness' ) ); ?></div>
		</nav><!-- #comment-nav-above -->
		<?php endif; // check for comment navigation ?>

		<ol class="comment-list">
			<?php
				/* Loop through and list the comments. Tell wp_list_comments()
				 * to use inkness_comment() to format the comments.
				 * If you want to override this in a child theme, then you can
				 * define inkness_comment() and that will be used instead.
				 * See inkness_comment() in inc/template-tags.php for more.
				 */
				wp_list_comments( array( 'callback' => 'inkness_comment' ) );
			?>
		</ol><!-- .comment-list -->

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
		<nav id="comment-nav-below" class="comment-navigation" role="navigation">
			<h1 class="screen-reader-text"><?php _e( 'Comment navigation', 'inkness' ); ?></h1>
			<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'inkness' ) ); ?></div>
			<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'inkness' ) ); ?></div>
		</nav><!-- #comment-nav-below -->
		<?php endif; // check for comment navigation ?>

	<?php endif; // have_comments() ?>

	<?php
		// If comments are closed and there are comments, let's leave a little note, shall we?
		if ( ! comments_open() && '0' != get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
	?>
		<p class="no-comments"><?php _e( 'Comments are closed.', 'inkness' ); ?></p>
	<?php endif; ?>
	
	
	
	<?php 
	//Displaying the Comment Form
	
	$commenter = wp_get_current_commenter();
	$req = get_option( 'require_name_email' );
	$aria_req = ( $req ? " aria-required='true'" : '' );
	
	$args = array(
		  'comment_notes_after' => ' ',	
		  'comment_field' =>  '<div class="form-group"><label for="comment">' . _x( 'Comment', 'noun','inkness' ) .
		    '</label><textarea id="comment" class="form-control" name="comment" cols="45" rows="8" aria-required="true">' .
		    '</textarea></div>',		
		  'fields' => apply_filters( 'comment_form_default_fields', array(
		
		    'author' =>
		      '<div class="form-group">' .
		      '<label for="author">' . __( 'Name', 'inkness' ) . '</label> ' .
		      ( $req ? '<span class="required">*</span>' : '' ) .
		      '<input id="author" name="author" class="form-control" type="text" value="' . esc_attr( $commenter['comment_author'] ) .
		      '" size="30"' . $aria_req . ' /></div>',
		
		    'email' =>
		      '<div class="form-group"><label for="email">' . __( 'Email', 'inkness' ) . '</label> ' .
		      ( $req ? '<span class="required">*</span>' : '' ) .
		      '<input id="email" name="email" class="form-control" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) .
		      '" size="30"' . $aria_req . ' /></div>',
		
		    'url' =>
		      '<div class="form-group><label for="url">' .
		      __( 'Website', 'inkness' ) . '</label>' .
		      '<input id="url" name="url" class="form-control" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) .
		      '" size="30" /></div>'
		    )
		  ),
		);
	
	
	comment_form($args); ?>

</div><!-- #comments -->
