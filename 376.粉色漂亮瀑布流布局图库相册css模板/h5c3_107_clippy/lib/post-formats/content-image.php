<?php
$image_post = get_post_meta($post->ID, SN.'image_post_upload',true);
if($image_post !=''){ ?>

<div class="entry-image">
	
<?php
    $thumb = wp_get_attachment_image_src($image_post['id'], 'post-thumb', false);
	echo '<a class="prettyPhoto[mixed]" href="'.$image_post['src'].'"><img src="'.$thumb[0].'"></a>';
?>
	
</div>
<?php } ?>

<header>
	<h2 class="post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
	
</header>


<div class="entry-content">
	<?php the_excerpt(); ?>
</div>

<?php get_template_part( '/lib/post-formats/content-meta' ); ?>
