<div class="entry-meta">
	<span class="entry-author">
		<?php if(is_single()) echo get_avatar( get_the_author_meta( 'ID' ), 32 ); ?>
		<span class="byline author vcard">
			<?php echo __('By', 'dw-timeline'); ?> <a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>" rel="author" class="fn"><?php echo get_the_author(); ?></a>
		</span>
	</span>
	<span class="sep">&bull;</span>
	<span class="entry-date"><?php _e('On', 'dw-timeline'); ?> <a href="<?php the_permalink(); ?>"><time class="published" datetime="<?php echo get_the_time('c'); ?>"><?php echo get_the_date(); ?></time></a></span>
	<span class="sep">&bull;</span>
	<span class="cat-links"><?php  _e('In', 'dw-timeline'); ?> 
	<?php echo get_the_category_list( ', ' ); ?></span>
</div>
