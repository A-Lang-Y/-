<ul id="widget--search" class="ui--widget unstyled-all <?php echo cloudfw_visible( $device ); ?>">
    <li>
        <a href="#" class="ui--gradient ui--gradient-grey on--hover helper--vertical-center-icon"><i class="fontawesome-search px14"></i></a>
        <div class="ui--search-form ui--gradient ui--gradient-grey">
	
			<form action="<?php echo home_url( '/' ); ?>" method="get">
				<input type="text" name="s" value="<?php the_search_query(); ?>" class="global-radius" placeholder="<?php echo esc_attr(cloudfw_translate( 'search' )); ?>" />
			</form>

        </div>

    </li>
</ul>