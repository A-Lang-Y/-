<?php get_header(); ?>
    <?php if ( of_get_option('corpo_blogheader_radio') ): ?>
        <?php of_get_option( 'corpo_blogheader' ) == '' ? $header = __('Blog','corpo') : $header  = of_get_option( 'corpo_blogheader' ); ?>
        <section class="section-title"><?php echo $header; ?></section>            
    <?php endif; ?>
	<div id="content">
        <section id="main-content" role="main">
			
			<?php while ( have_posts() ) : the_post(); ?>

				<article id="post-<?php the_ID(); ?>" <?php post_class('single'); ?>>
                    <header>
                        <h2><a href="<?php echo get_permalink($post->post_parent); ?>" rev="attachment"><?php echo get_the_title($post->post_parent); ?> </a></h2>
                        <div class="entry-meta">
                            <i class="date">posted on <?php the_time('F j, Y'); ?></i> 
                            <i><?php _e( 'by', 'corpo' ); ?> <?php the_author_posts_link(); ?></i> 
                            <i>| <?php comments_popup_link( __( 'Leave your thoughts', 'corpo' ), __( '1 Comment', 'corpo' ), __( '% Comments', 'corpo' )); ?></i>
                        </div>
                    </header>
                    <div class="entry-content">
                        <div style="text-align: center;"><a href="<?php echo wp_get_attachment_url($post->ID); ?>" class="aligncenter"><?php echo wp_get_attachment_image( $post->ID, 'medium' ); ?></a>      
                        <?php if ( !empty($post->post_excerpt) ) the_excerpt(); ?>
                        </div>
                        <br />
                        <div style="float:right;"><?php next_image_link('',__('Next image &raquo;','corpo')) ?></div><?php previous_image_link('',__('&laquo; Previous image','corpo')) ?><br />
                    </div>
                </article>
			<?php endwhile; // end of the loop. ?>
			
			<?php
				// If comments are open or we have at least one comment, load up the comment template
				if ( comments_open() || '0' != get_comments_number() )
					comments_template( '', true );
			?>
		</section>
	</div>
	<!-- END CONTENT -->
		
	<?php get_sidebar(); ?>

<?php get_footer(); ?>