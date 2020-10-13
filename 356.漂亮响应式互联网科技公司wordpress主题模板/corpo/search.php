<?php get_header(); ?>
	
<div id="content-wrapper">	

	<div id="content">
        <section id="main-content" role="main">		
        <h2><?php echo sprintf( __( '%s Search Results for ', 'corpo' ), $wp_query->found_posts ); echo get_search_query(); ?></h2>
		<?php get_template_part('loop'); ?>		
	
		<?php get_template_part('pagination'); ?>
	
        </section>
	</div>
	
<?php get_sidebar(); ?>

<?php get_footer(); ?>