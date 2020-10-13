<?php
/**
 * Review Comments Template
 *
 * Closing li is left out on purpose!
 *
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $post; ?>
<li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
	<div id="comment-<?php comment_ID(); ?>" class="comment_container">

		<div class="comment-avatar">
			<?php echo get_avatar( $GLOBALS['comment'], $size = '75' ); ?>
		</div>


		<div class="comment-text ui--box ui--gradient ui--gradient-grey clearfix">

			<div class="meta ui--gradient ui--gradient-grey ui--gradient-grey-border-bottom clearfix">
				<div class="ui--comments-arrow"><i class="fontawesome-caret-left"></i></div>

				<div class="pull-left">
					<?php if ($GLOBALS['comment']->comment_approved == '0') : ?>
						<em><?php _e( 'Your comment is awaiting approval', 'cloudfw' ); ?></em>
					<?php else : ?>
							<strong itemprop="author"><?php comment_author(); ?></strong><span class="dash">&ndash;</span> <small><time itemprop="datePublished" datetime="<?php echo get_comment_date('c'); ?>"><?php echo get_comment_date(__( get_option('date_format'), 'cloudfw' )); ?></time>:</small>
						
					<?php endif; ?>
				</div>			

				<div class="pull-right">
	                <small><?php 
		               echo get_comment_reply_link( array( 'reply_text' => '<i class="fontawesome-reply px12"></i> ' . cloudfw_translate('commentform.reply'), 'depth' => $depth, 'max_depth' => 3 ) ); 
		               //edit_comment_link( __( 'edit', 'cloudfw' ), ' · ' );
	                 ?>
	                </small>
				</div>

			</div>
			<div itemprop="description" class="description"><?php comment_text(); ?></div>
			<div class="clear"></div>

		</div>
		<div class="clear"></div>
	</div>