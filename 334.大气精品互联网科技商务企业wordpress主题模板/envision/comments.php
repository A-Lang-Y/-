
	<?php if ( post_password_required() ) {
		return;	
	}
	?>

<div id="comments" class="clearfix">

	<?php if ( have_comments() ) : ?>
		<?php echo do_shortcode(cloudfw_transfer_shortcode_attributes( 'title', array( 'element' => 'h4' ), 
				sprintf( cloudfw_translate('blog.single.comments_s'), number_format_i18n( get_comments_number() ), '<span>' . get_the_title() . '</span>' ) )); 
		?>
		<ol class="commentlist">
			<?php $blog_obj = cloudfw_module( 'CloudFw_Page_Generator_Blog' );  ?>
			<?php wp_list_comments( array( 'type' => 'comment', 'callback' => array( $blog_obj, 'comment_list' ) ) ); ?>
		</ol>


		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
		<nav id="comment-nav-below">
			<h1 class="assistive-text"><?php echo cloudfw_translate('blog.single.comment_navigation'); ?></h1>
			<div class="nav-previous"><?php previous_comments_link( cloudfw_translate('blog.single.older_comments') ); ?></div>
			<div class="nav-next"><?php next_comments_link( cloudfw_translate('blog.single.newer_comments') ); ?></div>
		</nav>
		<?php endif; // check for comment navigation ?>

	<?php elseif ( ! comments_open() && ! is_page() && post_type_supports( get_post_type(), 'comments' ) ) :?>
		<?php echo do_shortcode(cloudfw_transfer_shortcode_attributes( 'title', array( 'element' => 'h4' ), 
				cloudfw_translate('blog.single.comments') )); 
		?>
		<p class="ui--notfound muted"><?php echo cloudfw_translate('blog.single.comments_closed'); ?></p>
	<?php else:?>
		<?php echo do_shortcode(cloudfw_transfer_shortcode_attributes( 'title', array( 'element' => 'h4' ), 
				cloudfw_translate('blog.single.comments') )); 
		?>
		<p class="ui--notfound muted"><?php echo cloudfw_translate('blog.single.no_comment_yet'); ?></p>
	<?php endif; ?>

	<?php /** Get Comments Form */
		cloudfw('comment_form'); ?>

</div><!-- #comments -->
