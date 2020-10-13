<form role="search" method="get" id="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<input type="search" placeholder="<?php echo get_option('minty_search_placeholder', '搜索&hellip;'); ?>" value="<?php echo get_search_query(); ?>" name="s" id="s" title="搜索" required x-moz-errormessage="请输入搜索关键字" />
	<input type="submit" id="searchsubmit" value="搜索" />
</form>