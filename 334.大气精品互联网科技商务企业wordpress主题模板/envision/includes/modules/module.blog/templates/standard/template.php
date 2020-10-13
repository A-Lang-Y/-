<?php

$i = 0; 
$columns = 1;

if ( empty($image_width) ) {
	if ( $columns == 1 )
		$image_width = 960;
	else 
		$image_width = 480;
}

if ( $image_ratio && $image_width ) {
	$image_height = cloudfw_match_ratio( $image_width, $image_ratio );  
}

$atts[ 'image_width' ] = $image_width;
$atts[ 'image_height' ] = $image_height;
$atts[ 'columns' ] = $columns;
$atts[ 'show_side_date_year' ] = true;

while( $posts->have_posts() ) : 
	$posts->the_post();
	$post_data = $this->get_post( array('readmore' => $readmore, 'excerpt' => $show_excerpt, 'excerpt_length' => $excerpt_length, 'more_link_class' => 'btn btn-small btn-grey' ) );

	/** Item number */
	$i++;
	$item_content = '';
	$item_classes = array();
	$item_classes[] = implode(' ', (array) get_post_class());
	$item_classes[] = 'ui--blog-item clearfix';
	
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
		$atts[ 'link_element' ] = $link_element;

		$item_content .= $this->media( $post_data, $atts );
		$item_content .= $this->side( $post_data, $atts );

		if( $loop_custom_link = $this->get_loop('link') ) {
			$link_element = $loop_custom_link;
		}

		$sticky_badge  = ''; 
		if ( is_sticky() ) {
			$sticky_badge .= '<span class="ui--badge ui--badge-sticky">'; 
				$sticky_badge .= '<span class="btn btn-mini btn-yellow radius-6px pull-right">'. cloudfw_translate( 'sticky_post' ) .'</span>'; 
			$sticky_badge .= '</span>'; 
		}

		$item_content .= "<div class=\"ui--blog-content-wrapper\">";
			
			$item_content .= "<div class=\"ui--blog-header\">";
				$item_content .= "<{$title_element} class=\"ui--blog-title clearfix\">" . $link_element[0] . $post_data['title'] . $link_element[1] . $sticky_badge . "</{$title_element}>";	
				
				$metas = $this->get_blog_metas( $metas_primary );
				$likes = $this->get_blog_metas( $metas_secondary );

				if ( is_array($metas) && !empty($metas) || is_array($likes) && !empty($likes) ) {
					$item_content .= "<div class=\"ui--blog-metas clearfix\">";

						if ( $likes ) {
							$item_content .= "<div class=\"ui--blog-metas-right pull-right\">";
								$item_content .= implode(" <span class=\"ui--blog-separator\">&nbsp;</span> ", $likes);
							$item_content .= "</div>";
						}
						
						if ( $metas ) {
							$item_content .= "<div class=\"ui--blog-metas-left\">";
								$item_content .= implode(" <span class=\"ui--blog-separator\">/</span> ", $metas);
							$item_content .= "</div>";
						}

					$item_content .= "</div>";
				}
			$item_content .= "</div>";

			if ( !empty($post_data['excerpt'])) {
				$item_content .= "<div class=\"ui--blog-content\">";
					$item_content .= $post_data['excerpt'];
				$item_content .= "</div>";
			}

		$item_content .= "</div>";


	$item_content .= "</div>";

	/*$column_array = array();
	$column_array['class'] = array();
	$column_array['_key'] = 'blog';

	$content_out .= cloudfw_UI_column( $column_array, $item_content, '1of' . $columns . ( $i % $columns == 0 ? '_last' : '' ), $i == $total );*/

	$content_out .= $item_content;

	$this->reset_loop();

endwhile;