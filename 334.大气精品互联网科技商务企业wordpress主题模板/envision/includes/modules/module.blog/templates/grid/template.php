<?php

$i = 0; 
while( $posts->have_posts() ) : 
	$posts->the_post();
	$post_data = $this->get_post( array(
		'readmore'        => $readmore,
		'excerpt'         => $show_excerpt,
		'excerpt_length'  => $excerpt_length,
		'more_link_class' => 'btn btn-mini btn-grey',
	) );

	/** Item number */
	$i++;

	$box = array();
	$box['shadow'] = $shadow; 
	$box['title'] = $post_data['title']; 
	$box['title_element'] = $title_element; 
	$box['title_align'] = $title_align;

	$box['icon'] = ''; 
	$box['button_text'] = cloudfw_translate('read_more'); 

	$box['columns'] = $columns; 
	$box['show_desc'] = $show_excerpt; 

	if ( !empty($image_ratio) )
		$box['image_ratio'] = $image_ratio; 
	
	if ( !empty($video_ratio) )
		$box['video_ratio'] = $video_ratio; 

	$box['overlay'] = true; 
	$box['lightbox'] = false; 
	$box['link'] = $post_data['permalink']; 

	//$box['caption'] = $post_data['caption'];
	$item_content = isset($post_data['excerpt']) ? $post_data['excerpt'] : NULL; 


	if( $post_data['format'] == 'video' && (!empty($post_data['video']) || !empty($post_data['video_embed'])) ) {
		
		$box['video_type'] = $post_data['video_type']; 
		$box['video'] = $post_data['video']; 
		$box['video_embed'] = $post_data['video_embed']; 

	} elseif ( $post_data['format'] == 'quote' ) {
	
		$box['title'] = '"'. $box['title'] .'"';
		$box['image'] = $post_data['large_image'];

	} elseif ( $post_data['format'] == 'gallery' && ( !empty($post_data['gallery_images']) && is_array($post_data['gallery_images']) ) ) {

		$box['image'] = $post_data['large_image'];

		$gallery = array();
		$gallery[] = array( 'title' => $box['title'], 'src' => $box['image'] ) ;

		foreach ($post_data['gallery_images'] as $gallery_image) {
			if( empty($gallery_image) )
				continue;

			$gallery[] = array( 'src' => $gallery_image );
		}

		$gallery_count = count($gallery); 
		if ( is_array($gallery) && !empty($gallery)  && $gallery_count > 1 ) {
			$box['images'] = $gallery;
		}
					
	} else {
		$box['image'] = $post_data['large_image'];
	}
	

	$column_array = array();
	$column_array['class'] = array();
	$column_array['_key'] = 'blog';

	$box_content  = cloudfw_UI_box( $box, $item_content );
	$content_out .= cloudfw_UI_column( $column_array, $box_content, '1of' . $columns . ( $i % $columns == 0 ? '_last' : '' ), $i == $post_count );


endwhile;


$content_out = cloudfw_make_layout( $layout, $content_out );