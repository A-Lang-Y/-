<?php
wp_enqueue_script( 'flexslider-js' );
wp_enqueue_style ( 'flexslider-css' );
?>

<script type="text/javascript">
(function($) {
	jQuery(document).ready(function($){

	/*  Flex Slider */
	      $('.flexslider').flexslider({
	        animation: "fade",
	        easing:"swing",
	        smoothHeight: false,
	        slideshow: false,
	        after: function(slider) {
		         $('#posts').masonry( 'reload' );
		    }
	      });
	});
})(jQuery);
</script>


<div class="entry-gallery">
	<div class="flexslider clearfix">
	  <ul class="slides">
	  	<?php
		//Pull gallery images from custom meta
		$gallery_images = get_post_meta($post->ID, SN.'gallery_post_images_',true);
		//s5pr(get_post_meta($post->ID));
		if($gallery_images !=  ''){ 
			foreach ($gallery_images as $gallery_image){
				$thumb = wp_get_attachment_image_src($gallery_image[SN.'gallery_post_image']['id'], 'post-thumb', false);
				echo '<li><a class="prettyPhoto[mixed]" href="'.$gallery_image[SN.'gallery_post_image']['src'].'"><img src="'.$thumb[0].'" alt="'.$gallery_image[SN.'gallery_post_title'].'" /></a><p class="flex-caption">'.$gallery_image[SN.'gallery_post_title'].'</p></li>';
			}
		}
		?>
	  </ul>
	</div>
</div>

<header>
	<h2 class="post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
</header>

<div class="entry-content">
	<?php the_excerpt(); ?>
</div>

<?php get_template_part( '/lib/post-formats/content-meta' ); ?>