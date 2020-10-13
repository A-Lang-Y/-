<form class="searchform" action="<?php echo home_url( '/' ); ?>" method="get">
	<input type="hidden" name="post_type" value="product" />
	<input type="text" name="s" value="<?php the_search_query(); ?>" placeholder="<?php echo esc_attr(cloudfw_translate( 'search' )); ?>" />
	<button type="submit" class="btn btn-primary btn-small"><?php echo esc_attr(cloudfw_translate( 'search' )); ?></button>
</form>