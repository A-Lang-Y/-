<?php
wp_enqueue_script( 'fitvids-js' );
wp_enqueue_script( 'jplayer-js' );
wp_enqueue_style( 'jplayer-css' );
?>
<?php
$postid = $post->ID;
$embed = get_post_meta($post->ID, SN.'video_post_embed', $single = true);
?>


<div class="entry-video">



<?php
    if( !empty( $embed ) ) {
    	$embed = stripslashes(htmlspecialchars_decode($embed));
        echo add_youtube_video_wmode_transparent($embed); 
    } else {
    	player_video($postid);
	}
?>

		
</div>


<header>
	<h2 class="post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
</header>

<div class="entry-content">
	<?php the_excerpt(); ?>
</div>

<?php get_template_part( '/lib/post-formats/content-meta' ); ?>
