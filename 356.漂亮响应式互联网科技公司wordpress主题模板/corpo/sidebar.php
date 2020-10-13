<!-- sidebar -->
<aside id="sidebar" role="complementary">
    <?php do_action( 'before_sidebar' ); ?>
    
    <?php 
    if( is_active_sidebar('main-sidebar') ) :
        
        dynamic_sidebar( 'main-sidebar' );
        
    else: ?>
    
    	<div id="archives" class="widget">
			<h3 class="widget-title"><?php _e( 'Archives', 'corpo' ); ?></h3>
			<ul class="list arrow">
				<?php wp_get_archives( array( 'type' => 'monthly' ) ); ?>
			</ul>
		</div>

		<div id="meta" class="widget">
			<h3 class="widget-title"><?php _e( 'Meta', 'corpo' ); ?></h3>
			<ul>
				<?php wp_register(); ?>
				<?php wp_meta(); ?>
			</ul>
		</div>
        
    <?php endif; ?>
    
</aside>
<!-- /sidebar -->