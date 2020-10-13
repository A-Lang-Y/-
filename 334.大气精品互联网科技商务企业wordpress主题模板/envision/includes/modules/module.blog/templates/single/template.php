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

ob_start();
while( $posts->have_posts() ) :
	$posts->the_post();
	global $post;

	$post_data = $this->get_post( array( 'content' => true ) );

	/** Item number */
	$i++;
	$item_content = '';
	$post_navigation = '';
	$item_classes = array();
	$item_classes[] = 'ui--blog-item clearfix';
	$item_classes[] = 'layout--' . $raw_layout;

	$post_navigation_position = cloudfw_get_option( 'blog_single_navigation', 'position' );

	$item_content .= "<div".
		cloudfw_make_class( $item_classes, true ) .
		">";

		$item_content .= do_shortcode(cloudfw_get_option( 'blog_custom_codes', 'before_post' ));

		if ( !empty($post_navigation_position) )
			$post_navigation = $this->post_navigation();

		if ( $post_navigation && ( $post_navigation_position == 'both' || $post_navigation_position == 'top' ) )
			$item_content .= $post_navigation;



		$link_element = array();
		$link_element[0]  = "<span class=\"ui--blog-link\"";
		$link_element[0] .= ">";
		$link_element[1]  = "</span>";

		$atts[ 'link_element' ] = $link_element;

		$item_content .= $this->media( $post_data, $atts );

		if( $loop_custom_link = $this->get_loop('link') ) {
			$link_element = $loop_custom_link;
		}

		$item_content .= "<div class=\"ui--blog-content-wrapper\">";

			if ( ! ( $display_title = $this->get_meta( 'display_title' ) ) ) {
				$display_title = cloudfw_get_option( 'blog_single', 'display_title' );
			}

			if ( 'hide' != $display_title ) {
				$item_content .= "<div class=\"ui--blog-header\">";
					$item_content .= "<{$title_element} class=\"ui--blog-title clearfix\">" . $link_element[0] . $post_data['title'] . $link_element[1] . "</{$title_element}>";
				$item_content .= "</div>";
			}
			
			$item_content .= do_shortcode(cloudfw_get_option( 'blog_custom_codes', 'before_post_content' ));

			if ( !empty($post_data['content'])) {
				$item_content .= "<div class=\"ui--blog-content\">";
					$item_content .= $post_data['content'];
				$item_content .= "</div>";
			}

			$item_content .= do_shortcode(cloudfw_get_option( 'blog_custom_codes', 'after_post_content' ));

			wp_link_pages(array(
				'before'           => '<p>' . __('Pages:', 'cloudfw'),
				'after'            => '</p>',
				'link_before'      => '',
				'link_after'       => '',
				'next_or_number'   => 'number',
				'nextpagelink'     => cloudfw_translate( 'next_page' ),
				'previouspagelink' => cloudfw_translate( 'previous_page' ),
				'pagelink'         => '%',
				'echo'             => 1
			));

		/*$tags = $this->get_blog_metas( array('tag') );
		if ( $tags ) {
			$item_content .= "<p>";
				$item_content .= implode(" <span class=\"ui--blog-separator\">/</span> ", $tags);
			$item_content .= "</p>";
		}*/

		$meta_request = array();
		if( cloudfw_check_onoff( 'blog_single_metas', 'date' ) ) $meta_request[] = 'date';
		if( cloudfw_check_onoff( 'blog_single_metas', 'category' ) ) $meta_request[] = 'category';

		$meta_request[] = 'tag';

		$metas = $this->get_blog_metas( $meta_request );
		if ( is_array($metas) && !empty($metas) ) {
			$item_content .= "<div class=\"ui--blog-metas clearfix\"><span>";

				if ( $metas ) {
					$item_content .= "<span class=\"ui--blog-metas-left\">";
						$item_content .= implode(" <span class=\"ui--blog-separator\">/</span> ", $metas);
					$item_content .= "</span>";
				}

			$item_content .= "</span></div>";
		}

		$item_content .= "</div>";

		if( cloudfw_check_onoff( 'blog_single_like', 'enable' ) ) {
			if ( function_exists('cloudfw_likes') ) {
				$like_icon = '<i class="fontawesome-heart"></i> ';
				$item_content .= "<div class=\"ui--meta-like-shortcode\">";
					$item_content .= sprintf(
						'<span class="ui--meta-like effect">%s</span>',
						cloudfw_likes(array(
						    'zero' => $like_icon . __('<span>'. cloudfw_translate('sharrre.like_post') .'</span>','cloudfw'),
						    'one'  => $like_icon . __('<span>'. cloudfw_translate('sharrre.single_likes') .'</span>','cloudfw'),
						    'more' => $like_icon . __('<span>'. cloudfw_translate('sharrre.plural_likes') .'</span>','cloudfw'),
						))
					);
				$item_content .= "</div>";
			}
		}

	$item_content .= "</div>";

	echo $item_content; ?>

	<?php
		/** Sharrre */
		if( cloudfw_check_onoff( 'blog_single_share', 'enable' ) ) {
				echo do_shortcode(cloudfw_transfer_shortcode_attributes( 'title', array( 'element' => 'h4' ),
					cloudfw_translate('blog.single.share_the_post') ));
				echo cloudfw_sharrre( cloudfw_get_option( 'blog_single_share', 'services', cloudfw_sharrre_services( 'raw' ) )  );
		}
	?>

	<?php if( cloudfw_check_onoff( 'blog_single_author', 'enable' ) ) { ?>

		<?php echo do_shortcode(cloudfw_transfer_shortcode_attributes( 'title', array( 'element' => 'h4' ),
				cloudfw_translate('blog.single.about_author') ));
		?>

		<?php

			$author_id = get_the_author_meta( 'ID' );
			$author_name = get_the_author();
			$author_posts_url = get_author_posts_url( $author_id );

			$author_posts_url_html = array();
			$author_posts_url_html[0] = '<a href="'. $author_posts_url .'" title="'. esc_attr(__('Author\'s Posts','cloudfw')) .'">';
			$author_posts_url_html[1] = '</a>';

		 ?>

		<div class="ui--author-info clearfix">

			<div class="ui--author-info-avatar">
				<?php echo $author_posts_url_html[0] . get_avatar( get_the_author_meta('email') , 75 ) . $author_posts_url_html[1]; ?>
			</div>

			<div class="ui--author-info-content">
				<div class="ui--author-info-name">
					<h5>
						<strong><?php echo $author_posts_url_html[0] . $author_name . $author_posts_url_html[1]; ?></strong>
					</h5>

				</div>

				<?php if( $author_description = get_the_author_meta('description') ) { ?>
				<div class="ui--author-info-description ui-row">
					<?php echo do_shortcode(cloudfw_inline_format($author_description)); ?>
				</div>
				<?php } ?>
			</div>

		</div>

	<?php } ?>

	<?php if( cloudfw_check_onoff( 'blog_single_related', 'enable' ) ) { ?>

		<?php $related_posts = $this->related_posts();

			if ( !empty( $related_posts ) ) {
				echo "<div class=\"ui--blog-related-posts\">";
					echo do_shortcode(cloudfw_transfer_shortcode_attributes( 'title', array( 'element' => 'h4' ),
						__( '<strong>Related</strong> Posts', 'cloudfw' ) ));

					echo $related_posts;
				echo "</div>";

			}
		?>

	<?php } ?>

	<?php if( cloudfw_check_onoff( 'blog_single_comments', 'enable' ) ) {
		comments_template();
	} ?>

<?php

	if ( $post_navigation && ( $post_navigation_position == 'both' || $post_navigation_position == 'bottom' ) ) {
		echo $post_navigation;
	}

	echo do_shortcode(cloudfw_get_option( 'blog_custom_codes', 'after_post' ));

	$this->reset_loop();

	$content_out .= ob_get_contents();
	ob_end_clean();

endwhile;