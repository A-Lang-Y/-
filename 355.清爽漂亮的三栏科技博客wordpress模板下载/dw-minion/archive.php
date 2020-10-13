<?php get_header(); ?>
<div id="primary" class="content-area">
	<div class="primary-inner">
		<header class="page-header">
			<h1 class="page-title">
				<?php
					if ( is_category() ) :
						printf( __( 'Category Archives: %s', 'dw-minion' ), single_cat_title( '', false ) );
					elseif ( is_tag() ) :
						printf( __( 'Tag Archives: %s', 'dw-minion' ), single_tag_title( '', false ) );
					elseif ( is_author() ) :
						the_post();
						printf( __( 'Author: %s', 'dw-minion' ), '<span class="vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '" title="' . esc_attr( get_the_author() ) . '" rel="me">' . get_the_author() . '</a></span>' );
						rewind_posts();
					elseif ( is_day() ) :
						printf( __( 'Day: %s', 'dw-minion' ), '<span>' . get_the_date() . '</span>' );
					elseif ( is_month() ) :
						printf( __( 'Month: %s', 'dw-minion' ), '<span>' . get_the_date( 'F Y' ) . '</span>' );
					elseif ( is_year() ) :
						printf( __( 'Year: %s', 'dw-minion' ), '<span>' . get_the_date( 'Y' ) . '</span>' );
					elseif ( is_tax( 'post_format', 'post-format-aside' ) ) :
						_e( 'Asides', 'dw-minion' );
					elseif ( is_tax( 'post_format', 'post-format-image' ) ) :
						_e( 'Images', 'dw-minion');
					elseif ( is_tax( 'post_format', 'post-format-video' ) ) :
						_e( 'Videos', 'dw-minion' );
					elseif ( is_tax( 'post_format', 'post-format-quote' ) ) :
						_e( 'Quotes', 'dw-minion' );
					elseif ( is_tax( 'post_format', 'post-format-link' ) ) :
						_e( 'Links', 'dw-minion' );
					else :
						_e( 'Archives', 'dw-minion' );
					endif;
				?>
			</h1>
			<?php
				$term_description = term_description();
				if ( ! empty( $term_description ) ) :
					printf( '<div class="taxonomy-description">%s</div>', $term_description );
				endif;
			?>
		</header>
		<div id="content" class="site-content content-list" role="main">
		<?php 
		if ( have_posts() ) : 
			while ( have_posts() ) : the_post(); 
				get_template_part( 'content', get_post_format() ); 
			endwhile; 
			dw_minion_content_nav( 'nav-below' ); 
		else : 
			get_template_part( 'no-results', 'archive' ); 
		endif; 
		?>
		</div>
	</div>
</div>
<?php get_sidebar('secondary'); ?>
<?php get_footer(); ?>