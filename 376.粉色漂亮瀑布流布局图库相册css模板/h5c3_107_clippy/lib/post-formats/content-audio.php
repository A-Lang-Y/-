<?php
wp_enqueue_script( 'jplayer-js' );
wp_enqueue_style( 'jplayer-css' );
?>
<?php
$postid = $post->ID;
?>


<div class="entry-audio">

<?php
   player_audio($postid);
?>
		
</div>

<header>
	<h2 class="post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
</header>

<div class="entry-content">
	<?php the_excerpt(); ?>
</div>

<?php get_template_part( '/lib/post-formats/content-meta' ); ?>