<?php get_header(); ?>

	<div id="content" class="full-width">
        <section id="main-content" class="page-404" role="main">
	
		<div>
			<h1><?php _e( '404', 'corpo' ); ?></h1>
            <h2><?php _e( 'Page not found!', 'corpo' ); ?></h2>
			<p>
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php _e( 'Return home?', 'corpo' ); ?></a>
			</p>
		</div>	
		
	</section>
    
    </div>

<?php get_footer(); ?>