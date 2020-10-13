<?php

$i = 0; 

if ( empty($image_width) ) {
	if ( $columns == 1 )
		$image_width = 960;
	else 
		$image_width = 480;
}

if ( $image_ratio && $image_width ) {
	$image_height = cloudfw_match_ratio( $image_width, $image_ratio );  
}

$atts[ 'show_side_date_year' ] = false;


while( $posts->have_posts() ) : 
	$posts->the_post();
	$post_data = $this->get_post( array('readmore' => $readmore, 'excerpt' => $show_excerpt, 'excerpt_length' => $excerpt_length, 'use_more_link' => false ) );

	/** Item number */
	$i++;
	$item_content = '';
	$item_classes = array();
	$item_classes[] = 'ui--blog-item ui--animation ui--accent-gradient-hover-parent clearfix';
	
	$item_classes[] = 'layout--' . $raw_layout;

	if ( $i == $post_count )
		$item_classes[] = 'last-item'; 

	$item_content .= "<div".
		cloudfw_make_class( $item_classes, true ) .
		">";

		$link_element = array();
		$link_element[0]  = "<a class=\"ui--blog-link\" href=\"". $post_data['permalink'] ."\"";
		$link_element[0] .= ">";
		$link_element[1]  = "</a>";

		$item_content .= $this->side( $post_data, $atts );

		$item_content .= "<div class=\"ui--blog-content-wrapper\">";
			
			$item_content .= "<div class=\"ui--blog-header\">";
				$item_content .= "<{$title_element} class=\"ui--blog-title\">" . $link_element[0] . $post_data['title'] . $link_element[1] . "</{$title_element}>";	
				
				$metas = $this->get_blog_metas( $metas_primary );
				$likes = $this->get_blog_metas( $metas_secondary );

			$item_content .= "</div>";

			if ( !empty($post_data['excerpt'])) {
				$item_content .= "<div class=\"ui--blog-content\">";
					$item_content .= $post_data['excerpt'];
				$item_content .= "</div>";
			}

			$item_content .= "<div class=\"ui--blog-readmore more-link\">";
				$item_content .= "<a class=\"btn btn-small ". cloudfw_make_button_style( cloudfw_get_option( 'blog_template_mini',  'button_color', 'btn-secondary muted' ), true ) . "\" href=\"". $post_data['permalink'] ."\"";
				$item_content .= ">";
					$item_content .= $readmore;
				$item_content .= "</a>";
			$item_content .= "</div>";

		$item_content .= "</div>";

	$item_content .= "</div>";

	if ( $columns > 1 ) {
		$column_array = array();
		$column_array['class'] = array();
		$column_array['_key'] = 'blog_mini';

		//$content_out .= $item_content;
		$content_out .= cloudfw_UI_column( $column_array, $item_content, '1of' . $columns . ( $i % $columns == 0 ? '_last' : '' ), $i == $post_count );
	} else {
		$content_out .= $item_content;
	}

endwhile;