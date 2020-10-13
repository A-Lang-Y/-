<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php if( ! has_post_format('quote') ) : ?><h2 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2><?php endif; ?>
		<?php dw_minion_entry_meta(); ?>
	</header>
	<?php if( has_post_thumbnail() ) : ?>
	<div class="entry-thumbnail"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_post_thumbnail(); ?></a></div>
	<?php endif; ?>
	<div class="entry-content"> 
		<?php the_content( __( '<span class="btn btn-small">Continue reading</span>', 'dw-minion' ) ); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">',
				'after'  => '</div>',
				'link_before' => '<span class="btn btn-small">',
				'link_after'  => '</span>',
			) );
		?>
	</div>
</article>