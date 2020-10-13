<?php get_header(); ?>

    <section class="section-title">

        <?php if (have_posts()): the_post(); ?>
        
		<h2><?php _e( 'Author Archives for ', 'corpo' ); echo get_the_author(); ?></h2>

    </section>
	<div id="content">

        <section id="main-content" role="main">	
        
        <?php if ( get_the_author_meta('description')) : ?>
        <div class="author-info">
            <div class="author-avatar">
            <?php echo get_avatar(get_the_author_meta('user_email')); ?>
            </div>
            
            <h3><?php _e( 'About ', 'corpo' ); echo get_the_author() ; ?></h3>
            <?php the_author_meta('description'); ?>
        </div>
        <?php endif; ?>
        
        <?php rewind_posts(); ?>
	
		<?php get_template_part('loop'); ?>
		
	
	<?php else: ?>
	
		<!-- article -->
		<article>
			
			<h2><?php _e( 'Sorry, nothing to display.', 'corpo' ); ?></h2>
			
		</article>
		<!-- /article -->
	
	<?php endif; ?>
		
		<?php get_template_part('pagination'); ?>
	
	</section>
	</div>
	
<?php get_sidebar(); ?>

<?php get_footer(); ?>