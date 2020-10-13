<div class="meta clearfix">
	<div class="icon icon-<?php echo get_post_format(get_the_ID()) ?>"></div>
	<span class="post-date"><?php echo get_the_date("d M"); ?></span>
	<span class="post-comments">
			<?php comments_popup_link( '0', '1', '%' ); ?>
	</span>
</div>