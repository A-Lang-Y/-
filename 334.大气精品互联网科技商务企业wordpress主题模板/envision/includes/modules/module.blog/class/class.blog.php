<?php
/**
 *	CloudFw Page Generator::Blog 
 *
 *	@since 1.0
 */
class CloudFw_Page_Generator_Blog extends CloudFw_Page_Generator_Base {

	function path(){
		return trailingslashit(dirname(dirname(__FILE__)));
	}

	/**
	 *  CloudFw - Comments List Function
	 *
	 *  @since 1.0
	**/
	function comment_list( $comment, $args, $depth ) {
		$comments_loop = trailingslashit(dirname(dirname(__FILE__))) . "templates/single/comments-loop.php";

		if ( file_exists($comments_loop) )
			include( $comments_loop );
	}

	/**
	 *	Blog
	 */
	 function blog( $atts = array() ){

		/** Get portfolio options */
		$atts = shortcode_atts(array(
			'main_query'		=> NULL,
			'from'				=> NULL,
			'layout'			=> '',
			'orderby'    		=> 'date',
			'order'      		=> 'DESC',
			'id'				=> NULL,
			'columns'			=> 3,
			"limit"				=> -1,
			'domID'				=> NULL,
			"pagination" 		=> 0,
			
			"category" 			=> NULL,

			/** Grid Options */
			'title_element'		=> 'h3',
			'title_align'		=> 'center',
			'show_caption'	  	=> true,

			'excerpt_length' 	=> 50,
			'show_excerpt' 	  	=> true,

			'default_icon'		=> '',
			'default_button_text'=> '',

			'margin_top'     	=> '',
			'margin_bottom'  	=> '',

			'image_ratio'	  	=> '16:9',
			'video_ratio'	  	=> '16:9',

			/** Meta Options */
			'meta_author'		=> true,
			'meta_date'			=> true,
			'meta_category'		=> true,

			'meta_comment'		=> true,
			'meta_likes'		=> true,

			/** List Style */
			'list_style'		=> 'date',

			/** Other Options */
			'readmore'			=>	cloudfw_translate('read_more'),

			'shadow'			=> 0,

		), _check_onoff_false($atts));
		extract($atts);

		unset($atts['main_query']);
		if ( !$limit ) 
			$limit = -1;

		if ( function_exists('CPTO_activated') ) {
			$orderby = 'menu_order';
			$order = 'ASC';
		}

		if ( empty($layout) ) {
			$layout = 'standard';
		}

		if ( empty($title_element) ) {
			$title_element = $layout == 'mini' ? 'h5' : 'h3';
		}

		$excerpt_length = (int) $excerpt_length;
		if ( $excerpt_length < 1 )
			$excerpt_length = 50; 
		
		if( $main_query ) {
			global $wp_query;
			$posts = $wp_query;

		} elseif( $from == 'related_posts' ) {
			global $post;

			$tags = wp_get_post_tags( $post->ID );
			$tag_ids = array();  
			if ($tags) {  
				foreach($tags as $individual_tag) 
					$tag_ids[] = $individual_tag->term_id;
			}

			//if ( !$tag_ids )
			//	return;

			$args = array(  
				'post_type'         => array('post'),
				'post_status'       => 'publish',
				'tag__in'           => $tag_ids,  
				'post__not_in'      => array( $post->ID ),  
				'posts_per_page'    => $limit,
				'ignore_sticky_posts'  => 1,
				'orderby'    		=>  'rand',
				'order'      		=>  'DESC',
			);  

			$tmp_post = $post;
			$posts = new WP_Query( $args );
			
			
		} else {
			$args = array(
				'post_type'	 		=>	array('post'),
				'post_status' 		=>	'publish',
				'posts_per_page' 	=>  $limit,
				'paged'				=>	get_query_var('paged'),
				'orderby'    		=>  $orderby,
				'order'      		=>  $order,
			);

			/** Category Filter */
			if ( $from == 'a category' ) {
				if ( !empty($category) )
					$args['cat'] = $category;
			}

			global $post;
			$tmp_post = $post;
			$posts = new WP_Query( $args );
		}

		/** Start */
		$total = $posts->found_posts;
		$post_count = $posts->post_count;
		/** End */
		
		$out = '';
		$content_out = '';
		$i = 0;

		/** Generate an unique id for portfolio */
		$unique_id = $domID ? $domID : cloudfw_id( 'blog' );

		/** Check columns */
		if( !is_numeric($columns) )
			$columns = 3;

		if ( $columns > 4 )
			$columns = 4;

		/** Start to write portfolio */
		if ($posts->have_posts()):

			$metas_primary = array(); 
			if ( $meta_author ) $metas_primary[] = 'author'; 
			if ( $meta_date ) $metas_primary[] = 'date'; 
			if ( $meta_category ) $metas_primary[] = 'category'; 
				
			$metas_secondary = array(); 
			if ( $meta_comment ) $metas_secondary[] = 'comment'; 
			if ( $meta_likes ) $metas_secondary[] = 'like'; 
				
			$templates_dir_path = $this->path() . "templates/"; 
			$template_path = $templates_dir_path . "{$layout}/template.php";
			$raw_layout = $layout; 

			if ( file_exists($template_path) ) {
				include( $template_path );
			} else {
				return cloudfw_error_message( sprintf(__( 'Blog template %s cannot found.','cloudfw'), $layout) );
			}

			$out .= '<div'.
				cloudfw_make_id( $unique_id ) .
				cloudfw_make_class('ui--blog ui--blog-wrapper ui--pass', 1) .
				cloudfw_make_attribute( array( 
					'data-layout'   => $layout,
					'data-columns'  => $columns,
				), FALSE ) .
				cloudfw_make_style_attribute( array( 
					'margin-top'    => $margin_top,
					'margin-bottom' => $margin_bottom,
				), FALSE, TRUE ) .

			'>';

			$out .= $content_out;

			$page = get_query_var('paged') ? get_query_var('paged') : get_query_var('page');
			$page = !empty($page) ? intval($page) : 1;

			if ( $pagination && $posts->max_num_pages > 1 ) {	
				$out .= $this->pagination( array( 'echo' => false, 'page' => $page, 'pages' => $posts->max_num_pages) );
			}

			$out .= '</div>';

		endif;

		if ( isset( $tmp_post ) ) {
			$post = $tmp_post;
			wp_reset_query();
		}

		return $out;
		
	 }

	/**
	 *	Get Post
	 */
	public function get_post( $args ) {
		global $post;

		$id = get_the_ID();
		$format = get_post_format();
		$metas = get_post_meta($id, false);
		$thumbs = get_post_thumbnail_id($id);
	
		$thumbnail = wp_get_attachment_image_src( $thumbs, 'medium');
		$large_image = wp_get_attachment_image_src( $thumbs, 'large');
		//$full_image = wp_get_attachment_image_src( $thumbs, 'full');

		$the_post = array();

		/** Post Format */
		$the_post['format'] 		= $format;
		$the_post['id'] 			= $id;

		/** Title */
		$the_post['title'] 			= __t( get_the_title() );
		$the_post['permalink'] 		= __url( get_permalink() );
		$the_post['date'] 			= get_the_date();
		$the_post['raw_date'] 		= $post->post_date;
		
		/** Thumbnails */
		$the_post['thumbnail'] 		= $thumbnail[0];
		$the_post['large_image'] 	= $large_image[0];


		/** Video */
		if ( $format == 'video' ) {
			$the_post['video_type'] 	= $this->get_meta( 'blog_video_type', $id );
			$the_post['video'] 			= $this->get_meta( 'blog_video', $id );
			$the_post['video_embed']	= $this->get_meta( 'blog_video_embed_code', $id );
		} elseif ( $format == 'gallery' ) {
			$the_post['gallery_images'] = cloudfw_unserialize($this->get_meta( 'blog_gallery_image', $id ));
		} elseif ( $format == 'link' ) {
			$the_post['custom_link'] = $this->get_meta( 'blog_custom_link', $id );
		}

		if ( isset($args['content']) && $args['content'] ) {
			ob_start();
			the_content();
			$content = ob_get_contents();
			ob_end_clean();

			$the_post['content'] = $content;
		}

		if ( isset($args['excerpt']) && $args['excerpt'] ) {
			$the_post['excerpt'] = __t(cloudfw_get_the_excerpt( array(
				'length'			=>	isset($args['excerpt_length']) ? $args['excerpt_length'] : NULL,
				'use_more_link'		=>	isset($args['use_more_link']) ? $args['use_more_link'] : true,
				'more_link_class'	=>	isset($args['more_link_class']) ? $args['more_link_class'] : NULL,
				'more_link_text'	=>	!empty($args['readmore']) ? $args['readmore'] : __('Read More','cloudfw'),
			) ));
		}

		return $the_post;

	}

	/**
	 *	Get Metas
	 */
	function get_blog_metas( $items ) {
		if ( empty( $items ) || !is_array( $items ) )
			return array();
		
		$metas_dir_path = $this->path() . "metas/"; 

		$metas = array(); 
		foreach ($items as $item) {

			$template_path = $metas_dir_path . "meta.{$item}.php";

			if ( file_exists($template_path) )
				include( $template_path );

		}

		return $metas;

	}

	/**
	 *	Media
	 */
	function media( $post_data, $atts ) {
		extract($atts);

		$item_content = ''; 
		if ( $post_data['format'] == 'video' ) {

			$item_content .= "<div class=\"ui--blog-media\">";
				$item_content .= "<div class=\"ui--blog-video clearfix\">";
					$video_obj = new CloudFw_Shortcode_Video();

					if( $post_data['video_type'] == 'manual' ) {
						$item_content .= $video_obj->shortcode( array( 'type' => 'manual', 'ratio' => $video_ratio ), $post_data['video_embed'] );
					} else {
						$item_content .= $video_obj->shortcode( array( 'type' => 'auto', 'url' => $post_data['video'], 'ratio' => $video_ratio ) );
					}
					
				$item_content .= "</div>";
			$item_content .= "</div>";

		} elseif ( $post_data['format'] == 'gallery' && !empty($post_data['gallery_images']) ) {

			$gallery = array();
			if ( !empty( $post_data['gallery_images'] ) && is_array($post_data['gallery_images']) && ! in_array( $post_data['large_image'], $post_data['gallery_images'] ) ) {
				$gallery[] = array( 'src' => $post_data['large_image'], 'link' => $post_data['permalink']  ) ;
			}

			foreach ( (array) $post_data['gallery_images'] as $gallery_image) {
				if( empty($gallery_image) ) {
					continue;
				}

				$gallery[] = array( 'src' => $gallery_image, 'link' => $post_data['permalink'] );
			}

			$item_content .= "<div class=\"ui--blog-media\">";
				$item_content .= cloudfw_UI_gallery() 
						-> set('class', 'ui--blog-gallery')
						-> set('slides_class', 'slides')
						-> set('item_class', 'ui--blog-gallery-item')
						-> set('image_class', 'ui--blog-gallery-image')
						-> set('width', $image_width)
						-> set('height', $image_height)
						-> items( $gallery )
						-> render();
			$item_content .= "</div>";

		} elseif ( $post_data['format'] == 'link' && ! empty( $post_data['custom_link'] ) ) {

			$title_element_html = array();

			$title_element_html[0]  = "<a class=\"ui--blog-link\" target=\"_blank\" href=\"". $post_data['custom_link'] ."\"";
			$title_element_html[0] .= ">";
			$title_element_html[1]  = "</a>";

			$this->set_loop('link', $title_element_html);
			$post_data['format'] = 'image';
			return $this->media( $post_data, $atts ); 

		} elseif ( $post_data['format'] == 'quote' ) {

			$title_element_html = array();

			$title_element_html[0]  = "<span class=\"ui--blog-link\"";
			$title_element_html[0] .= ">";
			$title_element_html[1]  = "</span>";

			$this->set_loop('link', $title_element_html);

		} elseif ( !empty($post_data['large_image']) ) {

			if ( is_single() && get_post_type() == 'post' ) {
	
				if ( ! ( $display_featured = $this->get_meta( 'display_featured' ) ) ) {
					$display_featured = cloudfw_get_option( 'blog_single', 'display_featured' );
				}

				if ( 'hide' == $display_featured )
					return '';

			}

			if ( cloudfw_check_onoff( 'blog', 'fit_blog_media' ) && $image_width && $image_height ) {
				$image = cloudfw_thumbnail(array('src'=> $post_data['large_image'],'w'=> $image_width,'h'=> $image_height )); 
			} else {
				$image = $post_data['large_image']; 
			}

			if ( $link_element_custom = $this->get_loop('link') )
				$link_element =  $link_element_custom; 

			$item_content .= "<div class=\"ui--blog-media\">";
				$item_content .= $link_element[0];
				$item_content .= "<img ". 
					cloudfw_make_class(array( 'ui--blog-image' ), true) .
					cloudfw_make_attribute( array( 
						'src'   => $image,
						'alt'   => '',
					), FALSE )
				."/>";

				$item_content .= $link_element[1];
			$item_content .= "</div>";

		}

		return $item_content;

	}

	/**
	 *	Side
	 */
	function side( $post_data, $atts ) {
		extract($atts);
		$item_content = ''; 


		if ( $list_style == 'author' ) {

			$author_id = get_the_author_meta( 'ID' ); 
			$author_name = get_the_author();
			$author_posts_url = get_author_posts_url( $author_id );

			$author_posts_url_html = array(); 
			$author_posts_url_html[0] = '<a href="'. $author_posts_url .'" title="'. esc_attr( $author_name ) .'">'; 
			$author_posts_url_html[1] = '</a>'; 

			$item_content .= "<div class=\"ui--blog-side ui--blog-side-author\">";
				$item_content .= $author_posts_url_html[0] . get_avatar( get_the_author_meta('email') , 60 ) . $author_posts_url_html[1];
			$item_content .= "</div>";


		} elseif ( $list_style == 'icon' ) {

			switch ($post_data['format']) {
				case 'video':
					$blog_icon_class = 'fontawesome-facetime-video'; 
					break;

				case 'gallery':
					$blog_icon_class = 'fontawesome-th-large'; 
					break;

				case 'link':
					$blog_icon_class = 'fontawesome-link'; 
					break;

				case 'quote':
					$blog_icon_class = 'fontawesome-quote-right'; 
					break;
				
				default:

					if ( !empty($post_data['large_image']) )
						$blog_icon_class = 'fontawesome-camera'; 
					else
						$blog_icon_class = 'fontawesome-asterisk'; 
					# code...
					break;
			}


			$item_content .= "<div class=\"ui--blog-side ui--blog-icon ui--box ui--gradient-grey\">";
				$item_content .= "<div class=\"\">";
					$item_content .= "<i class=\"{$blog_icon_class}\"></i>";
				$item_content .= "</div>";
			$item_content .= "</div>";

		} elseif ( $list_style == 'date' ) {

			$item_content .= "<div class=\"ui--blog-side ui--blog-date ui--accent-gradient-hover-parent ui--box\">";
				$item_content .= "<h3><span class=\"ui--blog-date-day ui--accent-gradient-hover\">";
					$item_content .= get_the_date( 'd' );
				$item_content .= "</span></h3>";
				$item_content .= "<h6 class=\"ui--blog-date-month ui--gradient ui--gradient-grey\">";
					$item_content .= "<span>";
						$item_content .= get_the_date( 'M' );
					$item_content .= "</span>";

					if ( $show_side_date_year ) {
						$item_content .= "<span>";
							$item_content .= get_the_date( 'Y' );
						$item_content .= "</span>";
					}
				$item_content .= "</h6>";
			$item_content .= "</div>";

		} elseif ( $list_style == 'thumbnail' ) {

			$id = get_the_ID();
			$thumbs = get_post_thumbnail_id( $id );
			$thumbnail = wp_get_attachment_image_src( $thumbs, 'thumbnail' );
			$thumbnail = $thumbnail[0];

			if ( !empty( $thumbnail ) ) {
				$item_content .= "<div class=\"ui--blog-side ui--blog-thumbnail\">";

					$item_content .= "<a href=\"". get_permalink() ."\">";
					$item_content .= "<img ". 
						cloudfw_make_attribute( array( 
							'src'    => $thumbnail,
							'alt'    => '',
							'width'  => 60,
							'height' => 60,
						), FALSE )
					."/>";

					$item_content .= "</a>";
				$item_content .= "</div>";
			}

		}

		return $item_content;

	}

	/**
	 *	Returns related blog posts.
	 */
	function related_posts(){
		return $this->blog( array( 
			'from'          => 'related_posts', 
			'layout'        => 'grid-carousel',
			'title_element' => cloudfw_get_option( 'blog_single_related', 'title_element', 'h6' ),
			'columns'       => cloudfw_get_option( 'blog_single_related', 'columns', 3 ),
			'limit'         => cloudfw_get_option( 'blog_single_related', 'limit', 8 ),
			'show_excerpt'  => false,
		));
	}

	/**
	 *	Returns comment count.
	 */
	function comment_count(){
		ob_start();
		comments_number( '0', '1', '%' );
		$number = ob_get_contents();
		ob_end_clean();
		return '<a href="'. get_comments_link() .'"><i class="fontawesome-comment px14"></i> ' . $number . '</a>';
	}


	/**
	 *	Returns post navigation.
	 */
	function post_navigation(){
		$previous = ( is_attachment() ) ? get_post( $post->post_parent ) : get_adjacent_post( false, '', true );
		$next = get_adjacent_post( false, '', false );

		$bar_contents = ''; 
		$bar_contents .= cloudfw_transfer_shortcode_attributes( 'content_bar_item', 
			array( 'link'           => $next ? get_permalink( $next->ID ) : NULL, 
				   'attr_title'     => $next ? get_the_title( $next->ID ) : NULL, 
				   'icon'           => 'FontAwesome/fontawesome-chevron-right||size:14px',
				   'item_class'     => 'pull-right', 
				   'icon_position'  => 'right',
			), 
			cloudfw_translate('next_post') 
		);

		$bar_contents .= cloudfw_transfer_shortcode_attributes( 'content_bar_item', 
			array( 'link'           => $previous ? get_permalink( $previous->ID ) : NULL, 
				   'attr_title'     => $previous ? get_the_title( $previous->ID ) : NULL, 
				   'icon'           => 'FontAwesome/fontawesome-chevron-left||size:14px', 
				   'item_class'     => 'pull-left',
			), 
			cloudfw_translate('previous_post') 
		);
		

		$blog_page = cloudfw_get_option('blog', 'page');
		if ( !empty($blog_page) && is_numeric($blog_page) )
			$bar_contents .= cloudfw_transfer_shortcode_attributes( 'content_bar_item',
					array( 'link'           => get_permalink( $blog_page ), 
							'attr_title'    => cloudfw_translate('goto_blog_page'), 
							'icon'          => 'FontAwesome/fontawesome-th||size:14px', 
							'item_class'    => 'text-center ui--no-border-lr', 
							'icon_position' => 'center', 
					)
				);

		if ( !empty($bar_contents) )
			return do_shortcode(cloudfw_transfer_shortcode_attributes( 'content_bar', array( 'align' => 'center', 'style' => 'boxed', 'class' => 'ui--type-splitted ui--height-thin' ), $bar_contents ));

		return false;

	}

}