<?php get_header(); ?>
    <section class="section-title">
        <h2>
        
        <?php
            if ( is_day() ) :
                printf( __( 'Daily Archives: %s', 'corpo' ), get_the_date());
            elseif ( is_month() ) :
                printf( __( 'Monthly Archives: %s', 'corpo' ), get_the_date( 'F Y' ));
            elseif ( is_year() ) :
                printf( __( 'Yearly Archives: %s', 'corpo' ), get_the_date( 'Y' ));
            elseif ( is_category() ) :
                printf( __( 'Category: %s', 'corpo' ), single_cat_title('',false));
            elseif ( is_tag() ) :
                printf( __( 'Tagged: %s', 'corpo' ), single_tag_title('',false));					
            else :
                _e( 'Archives', 'corpo' );
            endif;
        ?>
        </h2>
        
    </section>
	<div id="content">
        <section id="main-content" role="main">	
	
		<?php get_template_part('loop'); ?>
        
		<?php get_template_part('pagination'); ?>
	
	</section>
	</div>
	
<?php get_sidebar(); ?>

<?php get_footer(); ?>