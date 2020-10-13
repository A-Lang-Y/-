<?php get_header(); ?>
<div id="primary" class="content-area">
	<div class="primary-inner">
		<header class="page-header">
			<h1 class="page-title"><?php printf( __( 'Search Results for: %s', 'dw-minion' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
		</header>
		<div id="content" class="site-content content-list" role="main">
		<?php 
		if ( have_posts() ) :
			while ( have_posts() ) : the_post();
				get_template_part( 'content', 'search' );
			endwhile;
			dw_minion_content_nav( 'nav-below' );
		else :
			get_template_part( 'no-results', 'search' );
		endif; ?>
		</div>
	</div>
</div>
<?php get_sidebar('secondary'); ?>
<?php get_footer(); ?>