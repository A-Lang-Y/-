<?php get_header(); ?>
<div id="primary" class="content-area">
	<div class="primary-inner">
		<div id="content" class="site-content content-list" role="main">
		<?php 
		if ( have_posts() ) : 
			while ( have_posts() ) : the_post(); 
				get_template_part( 'content', get_post_format() ); 
			endwhile;
			dw_minion_content_nav( 'nav-below' ); 
		else : 
			get_template_part( 'no-results', 'index' ); 
		endif; 
		?>
		</div>
	</div>
</div>
<?php get_sidebar('secondary'); ?>
<?php get_footer(); ?>