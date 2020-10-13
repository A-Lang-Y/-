<?php 
/*Template Name: Portfolio 3 Columns*/
get_header();
?>
	

<div id="content">
	<article <?php hybrid_post_attributes(); ?>>
		<header class="entry-header">
			<?php bearded_post_thumbnail(); ?>
			<?php echo apply_atomic_shortcode( 'entry_title', the_title( '<h1 class="entry-title">', '</h1>', false ) ); ?>
		</header><!-- .entry-header -->

		<div class="entry-content">
			<?php the_content(); ?>
		</div><!-- .entry-content -->

		 <div class="row"><div class="column large-12">
	    	<ul id="isotope-filters" class="nostyle list-centered">
	          <li><a href="#all" data-filter="isotope-item" class="active"><?php _e('All', 'bearded'); ?></a></li>
			  <?php wp_list_categories( array('title_li' => '', 'taxonomy' => 'portfolio', 'walker' => new Portfolio_Walker() ) ); ?>
			</ul>
	    </div></div>

		<div class="row portfolio-3-columns" id="portfolio-isotope">
		<?php
			$args = array(
				'post_type' => 'portfolio_item',
				'posts_per_page' => -1
			);
			$portfolio_query = new WP_Query($args);

			if( $portfolio_query->have_posts() ) : while( $portfolio_query->have_posts() ) : $portfolio_query->the_post(); ?>

				<?php
					 $terms =  get_the_terms( get_the_ID(), 'portfolio' ); 
							    $term_list = '';
							    if( is_array($terms) ) {
							        foreach( $terms as $term ) {
			    				        $term_list .= urldecode($term->slug);
			    				        $term_list .= ' ';
			    				    }
						        }
				     ?>

				<div class="column large-3 portfolio-entry-container <?php echo $term_list; ?> isotope-item" id="portfolio-item-<?php echo get_the_ID(); ?>">
					<div class="portfolio-entry">
						<div class="portfolio-entry-thumbnail">
					<?php if(current_theme_supports( 'get-the-image' )) { get_the_image( array( 'size' => 'large' ) ); } ?>
						</div>
						<div class="portfolio-entry-title">
							<?php 
								the_title('<h2><a href="'.get_permalink().'" title="'.the_title_attribute( array('echo' => false ) ).'">', '</a></h2>'); 
							?>

						</div>
					</div>
				</div>

		<?php endwhile; endif; wp_reset_postdata(); ?>

		</div>
	</article><!-- .hentry -->
</div><!-- #content -->

<?php get_footer();?>