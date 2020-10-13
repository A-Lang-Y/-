<?php

/**
 *  CloudFw Page Generator :: Portfolio 
 *
 *  @since 1.0
 */
class CloudFw_Page_Generator_Portfolio extends CloudFw_Page_Generator {

	/**
	 *  Portfolio
	 */
	 function portfolio( $atts = array() ){
		global $wp_query, $current_link;

		ob_start();

		/** Get portfolio options */
		$atts = shortcode_atts(array(
			'layout'            => 'normal',
			'orderby'           => 'date',
			'order'             => 'DESC',
			'id'                => NULL,
			'from'              => 'a category',
			'filters'           => NULL,
			'filters_style'     => '',
			'filters_position'  => 'left',
			'filters_title'     => '',

			'portfolio_filters' => 0,
			'columns'           => 3,
			'domID'             => NULL,
			'title_element'     => 'h5',
			'title_align'       => 'center',
			'height'            => 260,
			"pagination"        => 0,
			"forcing"           => NULL,
			"limit"             => -1,
			'titles'            => 1,
			'titles_link'       => 1,
			'categories'        => 1,
			'descriptions'      => 1,
			'descriptionmargin' => NULL,
			'external_query'    => array(),
			'link_target'      	=> '',

			'default_icon'      => '',
			'default_button_text'=> '',

			'show_caption'      => true,
			'show_desc'         => true,

			'margin_top'        => '',
			'margin_bottom'     => '',

			'image_ratio'       => '16:9',
			'video_ratio'       => '16:9',
			
			'gallery_rotate'    => false,
			'shadow'            => 0,

		), _check_onoff_false($atts));
		extract( $atts );

		if ( $limit === 0 || $limit == '0' ) {
			$limit = -1;
		}

		if ( !isset( $atts['portfolio_filters'] ) )
			$portfolio_filters = true;


		if ( $layout == 'carousel' ) {

			$pagination = false; 
			$filters = false; 
		}

		$get_filters = !empty($filters) && $portfolio_filters; 
		
		/** Detect portfolio type */
		switch ($from){
			default:
			case 'all':

				if ( function_exists('CPTO_activated') ) {
					$orderby = 'menu_order';
					$order = 'ASC';
				}

				$args = array(
					'post_type'         =>  array('portfolio'),
					'post_status'       =>  'publish',
					'posts_per_page'    =>  $limit,
					'paged'             =>  get_query_var('paged'),
					'orderby'           =>  $orderby,
					'order'             =>  $order,
					'get_filters'       =>  $get_filters
				);
				
				$portfolio = $this->get_portfolio_posts($args);
				$portfolio_source = $portfolio['source'];
				$total_post = $portfolio['total'];

			break;  
			case 'wp_query':

				$args = array(
					'query'         =>  $wp_query,
					'get_filters'   =>  $get_filters
				);

				$limit = $wp_query->query_vars['posts_per_page'];

				$portfolio = $this->get_portfolio_posts( $args );
				$portfolio_source = $portfolio['source'];
				$total_post = $portfolio['total'];

			break;  
			case 'related':
				$portfolio = $this->get_portfolio_posts( $external_query );
				$portfolio_source = $portfolio['source'];
				$total_post = $portfolio['total'];

			break;
			case 'a category':

				if ( function_exists('CPTO_activated') ) {
					$orderby = 'menu_order';
					$order = 'ASC';
				}
				
				$portfolio_categories = get_term($id, 'portfolio-category');

				if ( is_wp_error($portfolio_categories) ) {
					echo cloudfw_error_message(__('Please select a category for the portfolio source.','cloudfw'));
					return false;
				}
				
				$args = array(
					'post_type'         =>  array('portfolio'),
					'post_status'       =>  'publish',
					'portfolio-category'=>  $portfolio_categories->slug,
					'posts_per_page'    =>  $limit,
					'paged'             =>  get_query_var('paged'),
					'orderby'           =>  $orderby,
					'order'             =>  $order,
					'get_filters'       =>  $get_filters
				);
				
				$portfolio = $this->get_portfolio_posts($args);
				$portfolio_source = $portfolio['source'];
				$total_post = $portfolio['total'];
			
			break;
			case 'a filter':

				if ( function_exists('CPTO_activated') ) {
					$orderby = 'menu_order';
					$order = 'ASC';
				}
				
				$portfolio_filters = get_term($id, 'portfolio-filter');

				if ( is_wp_error($portfolio_filters) ) {
					echo cloudfw_error_message(__('Please select a filter for the portfolio source.','cloudfw'));
					return false;
				}
				
				$args = array(
					'post_type'         =>  array('portfolio'),
					'post_status'       =>  'publish',
					'portfolio-filter'  =>  $portfolio_filters->slug,
					'posts_per_page'    =>  $limit,
					'paged'             =>  get_query_var('paged'),
					'orderby'           =>  $orderby,
					'order'             =>  $order,
					'get_filters'       =>  $get_filters
				);
				
				$portfolio = $this->get_portfolio_posts($args);
				$portfolio_source = $portfolio['source'];
				$total_post = $portfolio['total'];
			
			break;
			case 'selected posts':
				
				$id = is_array($id) ? $id : explode(',', $id);

				$args = array(
					'post_type'         =>  array('portfolio'),
					'post_status'       =>  'publish',
					'post__in'          =>  $id,
					'posts_per_page'    =>  $limit,
					'paged'             =>  get_query_var('paged'),
					'get_filters'       =>  $get_filters
				);
						
				$portfolio = $this->get_portfolio_posts($args);
				$portfolio_source = $portfolio['source'];
				$total_post = $portfolio['total'];
								
				if (is_array($portfolio_source)) {
					$portfolio_source = cloudfw_array_sort_by_array($portfolio_source, $id);
				}

			break;
			case 'a post gallery':
				
				if (empty($id)) {
					$id = get_the_ID();
				}

				$portfolio_source = $this->get_gallery_images( $id, $limit, 1, get_query_var('paged') );
				$total_post = 0;

			break;
		}
		
		
		$out = '';
		$content_out = '';
		$filters_out = '';

		$i = 0;
		/** Generate an unique id for portfolio */
		$unique_id = $domID ? $domID : 'portfolio-'.cloudfw_randomizer(5);

		/** Check columns */
		if( !is_numeric($columns) )
			$columns = 3;

		if ( $columns > 6 )
			$columns = 6;

		/** Start to write portfolio */
		if (is_array($portfolio_source) && !empty($portfolio_source)):

			if ( $get_filters ) {

				$filters = is_array($filters) ? $filters : explode(',', $filters);
				$filters_item_out = '';

				$filter_i = 0; 
				$filter_count = count($filters);

				foreach ($filters as $filter_slug) {
					$filter_object = get_term_by( 'slug', $filter_slug, 'portfolio-filter');
					$filter_i++;
	
					if ( !is_wp_error( $filter_object ) && is_object($filter_object) ) {
						$filters_item_out .= '<li class="item-'. $filter_i . _if( $filter_count == $filter_i, ' last-item' ).'"><a href="javascript:;" data-filter=".filter-'. $filter_object->slug .'">'. $filter_object->name .'</a></li>';
					}
				}

				if ( ! empty($filters_item_out) ) {
					if ( $filters_style == 'boxed' )
						$filters_bar_class = 'ui--box';
					else 
						$filters_bar_class = 'fullwidth-container'; 

					$filters_out .= '<div class="ui--custom-menu-bar ui--gradient ui--gradient-grey '. $filters_bar_class .' text-'.$filters_position .' clearfix">';
						$filters_out .= '<ul id="#'.$unique_id.'-filters" class="portfolio-filters unstyled clearfix" data-isotope="#'.$unique_id.'">';
							
							if ( !empty($filters_title) )
								$filters_out .= '<li class="first-item title-item"><span>'. $filters_title .':</span></li>';
							
							$filters_out .= '<li class="active-item '. _if( empty($filters_title), 'first-item' ) .'"><a href="javascript:;" data-filter="*">'. cloudfw_translate('portfolio_filter_all') .'</a></li>';
							$filters_out .= $filters_item_out;

						$filters_out .= '</ul>';
					$filters_out .= '</div><div class="clearfix"></div>';

				}
			}

			$i = 0; 
			$total = count( $portfolio_source ); 
			foreach ($portfolio_source as $post_id => $post_data) {

				/** Item number */
				$i++;

				$box = array();
				$box['shadow'] = $shadow;
				$box['gallery_auto_rotate'] = $gallery_rotate; 

				$box['title'] = $post_data['title']; 
				$box['title_element'] = $title_element; 
				$box['title_align'] = $title_align; 
				$box['target'] = $link_target; 

				$box['columns'] = $columns; 
				$box['show_desc'] = $show_desc; 
				$box['show_caption'] = $show_caption; 

				if ( !empty($image_ratio) ) {
					$box['image_ratio'] = $image_ratio; 
				}
				
				if ( !empty($video_ratio) ) {
					$box['video_ratio'] = $video_ratio; 
				}

				$box['overlay'] = true; 
				
				$box['group_prefix'] = 'portfolio';

				if( $post_data['action'] == 'goto' ) {
					$box['lightbox'] = false; 
					$box['link'] = $post_data['permalink']; 
				} elseif( $post_data['action'] == 'lightbox' ) {
					$box['lightbox'] = true; 
					$box['link'] = !empty($post_data['custom_image']) ? $post_data['custom_image'] : $post_data['full_image']; 
				}

				if( !empty($post_data['custom_link']) ) {
					$box['link'] = $post_data['custom_link']; 
				}

				if ( !empty($post_data['icon']) ) {
					$box['icon'] = $post_data['icon'];
				} else {
					$box['icon'] = isset($default_icon) ? $default_icon : '';
				}

				if ( !empty($post_data['button_text']) ) {
					$box['button_text'] = $post_data['button_text'];
				} else {
					$box['button_text'] = isset($default_button_text) ? $default_button_text : '';
				}

				$box['caption'] = $post_data['caption'];
				$item_content = $post_data['desc']; 


				if( $post_data['thumbnail_type'] == 'video' && (!empty($post_data['video']) || !empty($post_data['video_embed'])) ) {
					
					$box['video_type'] = $post_data['video_type']; 
					$box['video'] = $post_data['video']; 
					$box['video_embed'] = $post_data['video_embed']; 

				} else {
	
					$box['image'] = $post_data['large_image'];

					if( !empty($post_data['gallery_images']) && is_array($post_data['gallery_images']) ) {
						$gallery = array();
						$gallery[] = array( 'title' => $box['title'], 'src' => $box['image'] ) ;

						foreach ($post_data['gallery_images'] as $gallery_image) {
							if( empty($gallery_image) )
								continue;

							$gallery[] = array( 'src' => $gallery_image );
						}
						
					}


					$gallery_count = count($gallery); 
					if ( is_array($gallery) && !empty($gallery)  && $gallery_count > 1 ) {
					
						if ( _check_onoff($post_data['gallery_in_list']) )
							$box['images'] = $gallery; 

						if ( _check_onoff($post_data['gallery_in_lightbox']) ) {
							$box['group'] = true; 

							if ( ! _check_onoff($post_data['gallery_in_lightbox_featured']) )
								unset($gallery[0]);
							
							$box['lighbox_images'] = $gallery; 
						}
					}
					
				}
				

				$column_array = array();
				$column_array['class'] = array();
				$column_array['_key'] = 'portfolio';

				if ( $get_filters ) {
					if( is_array( $post_data["filters"] ) && !empty( $post_data["filters"] ) ) {
						foreach ($post_data["filters"] as $filter_id => $filter) {
							$column_array['class'][] = 'filter-' . $filter["slug"];
						}
					}
				}


				$box_content  = cloudfw_UI_box( $box, $item_content );
				$content_out .= cloudfw_UI_column( $column_array, $box_content, '1of' . $columns . ( $i % $columns == 0 ? '_last' : '' ), $i == $total );

		
			}

		$content_out = cloudfw_make_layout( $layout, $content_out ); 

		$out .= '<div'.
			cloudfw_make_class('portfolio-container-wrapper ui--pass', 1) .
			cloudfw_make_attribute( array( 
				'data-layout'   => $layout,
				'data-columns'  => $columns,
			), FALSE ) .
			cloudfw_make_style_attribute( array( 
				'margin-top'    => $margin_top,
				'margin-bottom' => $margin_bottom,
			), FALSE, TRUE ) .

		'>';
			$out .= $filters_out;
			$out .= '<div id="'.$unique_id.'" class="portfolio-container layout--'. $layout .' clearfix">';
				$out .= $content_out;
			$out .= '</div>';

		$page = get_query_var('paged') ? get_query_var('paged') : get_query_var('page');
		$page = !empty($page) ? intval($page) : 1;
		$posts_per_page = intval( $limit );

		if ( is_numeric( $posts_per_page ) && (integer) $posts_per_page > 0 ) { 
			$pages = intval(ceil($total_post / $posts_per_page));
			if ( $pagination ) {
				$out .= $this->pagination( array( 'echo' => false, 'page' => $page, 'pages' => $pages) );
			}
		}

		$out .= '</div>';

		endif;


		return $out;
		
	 }

	/**
	 *  Get Portfolio Posts via Category
	 */
	private function get_portfolio_posts( $args ) {

		if (empty($args)) {
			return false;
		}

		$source = array();

		global $post;
		$tmp_post = $post;

		$posts = isset($args['query']) && is_a( $args['query'], 'WP_Query' ) ? $args['query'] : new WP_Query( $args );
		$total = 0; 

		if( $posts->have_posts()) : while( $posts->have_posts() ) : $posts->the_post();
						
			$id = get_the_ID();
			$metas = get_post_meta($id, false);
			$thumbs = get_post_thumbnail_id($id);
		
			$thumbnail = wp_get_attachment_image_src( $thumbs, 'medium');
			$full_image = wp_get_attachment_image_src( $thumbs, 'full');
			$large_image = wp_get_attachment_image_src( $thumbs, 'large');
			
			/** Categories */
			$portfolioCats = wp_get_object_terms($id, 'portfolio-category');

			$cats = array();
			foreach((array) $portfolioCats as $category_number => $category) { 
				$cats[] = '<a href="'.get_category_link($category->term_id ).'">'.$category->name.'</a>';
			}
			//if (!empty($cats)) $cats = substr($cats,0,-2); 

			/** Filters */
			$filters = array();  
			if ( isset($args['get_filters']) && $args['get_filters'] ) {

				$portfolioFilters = wp_get_object_terms($id, 'portfolio-filter');

				foreach((array) $portfolioFilters as $filter_number => $filter) { 
					$filters[$filter->term_id] = array(
						'id'   => $filter->term_id,
						'name' => $filter->name,
						'slug' => $filter->slug,
						'link' => get_term_link($filter->slug, 'portfolio-filter'),
					);
				}
			
			}
			

			$source[ $id ] = array(
				'title'               => __t( get_the_title() ),
				'permalink'           => __url( get_permalink() ),
				'content'             => __t( get_the_content() ),
				'category'            => $cats,
				'filters'             => $filters,
				'thumbnail'           => $thumbnail[0] ,
				'large_image'         => $large_image[0],
				'full_image'          => $full_image[0],
				'desc'                => isset($metas[PFIX.'_port_desc'][0]) ? $metas[PFIX.'_port_desc'][0] : NULL,
				'caption'             => isset($metas[PFIX.'_port_caption'][0]) ? $metas[PFIX.'_port_caption'][0] : NULL,
				'action'              => isset($metas[PFIX.'_port_link_action'][0]) ? $metas[PFIX.'_port_link_action'][0] : NULL,
				'thumbnail_type'      => isset($metas[PFIX.'_port_thumbnail_type'][0]) ? $metas[PFIX.'_port_thumbnail_type'][0] : NULL,
				'icon'                => isset($metas[PFIX.'_port_icon'][0]) ? $metas[PFIX.'_port_icon'][0] : NULL,
				'button_text'         => isset($metas[PFIX.'_port_default_button_text'][0]) ? $metas[PFIX.'_port_default_button_text'][0] : NULL,
				
				'video_type'          => isset($metas[PFIX.'_port_video_type'][0]) ? $metas[PFIX.'_port_video_type'][0] : NULL,
				'video'               => isset($metas[PFIX.'_port_video'][0]) ? $metas[PFIX.'_port_video'][0] : NULL,
				'video_embed'         => isset($metas[PFIX.'_port_video_embed_code'][0]) ? $metas[PFIX.'_port_video_embed_code'][0] : NULL,
				'custom_image'        => isset($metas[PFIX.'_port_custom_image'][0]) ? $metas[PFIX.'_port_custom_image'][0] : NULL,
				'custom_link'         => isset($metas[PFIX.'_port_custom_link'][0]) ? $metas[PFIX.'_port_custom_link'][0] : NULL,
				
				'gallery_images'      => isset($metas[PFIX.'_port_gallery_image'][0]) ? cloudfw_unserialize($metas[PFIX.'_port_gallery_image'][0]) : NULL,
				'gallery_in_list'     => isset($metas[PFIX.'_gallery_in_list'][0]) ? $metas[PFIX.'_gallery_in_list'][0] : NULL,
				'gallery_in_lightbox' => isset($metas[PFIX.'_gallery_in_lightbox'][0]) ? $metas[PFIX.'_gallery_in_lightbox'][0] : NULL,
				'gallery_in_lightbox_featured'  
									  => isset($metas[PFIX.'_gallery_in_lightbox_featured'][0]) ? $metas[PFIX.'_gallery_in_lightbox_featured'][0] : NULL,
			);      
			
		endwhile;  endif;

		$total = $posts->found_posts;
		$post = $tmp_post;
		wp_reset_query();

		return compact( 'source', 'total' );

	}


	/**
	 *  Get Related Portfolios
	 *
	 *  @since 1.0
	 */
	function related_portfolios( $atts, $content ){
		$key = '{{results}}';

		/** Get portfolio options */
		extract(shortcode_atts(array(
			'title'         =>  cloudfw_translate( 'portfolio_related' ),
			'title_element' => 'h5', 
			'columns'       => 3, 
			'shadow'        => 8, 
		), $atts));

		$id = $this->ID;
		$tags = wp_get_post_terms( $id, 'portfolio-tags' );

		if ( $tags ) {
			
			foreach ($tags as $tag) {
				$related_tags[] = $tag->term_id;
			}

			$args = array(
				'tax_query'     => array(
					array(
						'taxonomy' => 'portfolio-tags',
						'field'    => 'term_id',
						'terms'    => $related_tags,
						'operator' => 'IN'
					)
				),
				'post__not_in'      =>  array( $id ),
				'post_type'         =>  array('portfolio'),
				'post_status'       =>  'publish',
				'paged'             =>  get_query_var('paged'),
				'orderby'           =>  'rand',
				'order'             =>  'none',
				'ignore_sticky_posts' => 1,
				'posts_per_page'    => 12,
			);

			$results = $this->portfolio(
				array(
					'from'              => 'related',
					'columns'           => $columns,
					'limit'             => 12,
					'domID'             => NULL,
					'title_element'     => $title_element,
					'title_align'       => 'center',
					'titles'            => 1,
					'titles_link'       => 1,
					'categories'        => 0,
					'descriptions'      => 0,
					'external_query'    => $args,
					'layout'            => 'carousel',

					'image_ratio'       => '16:9',
					'video_ratio'       => '16:9',

					'default_icon'      => 'FontAwesome/fontawesome-link',

					'show_caption'      => false,
					'show_desc'         => false,
					'shadow'            => $shadow,
				)

			);

			if ( empty($content) )
				$content = $key;
			else {
				if ( strpos($content, $key) === false ) {
					$content .= "\n{$key}"; 
				}
			}

			if ( !empty( $results ) ) {

				if ( !empty( $title ) ) {
					$results = do_shortcode(cloudfw_transfer_shortcode_attributes( 'title', array( 'element' => 'h3' ), $title) ) . $results;
				}
				echo str_replace($key, $results, do_shortcode($content));
			}

		}

	}

	function related_filter($content){

		if( 'portfolio' == get_post_type() ) {
			if ( $this->get_meta('related_posts') !== 'hide' ) {
				if ( strpos($content, "[related_portfolios") === false ) {

					$layout_fullwidth = trim(cloudfw_get_option( 'portfolio',  'related_layout' ));

					$current_page_layout = $this->get_layout();
					if ( $current_page_layout == 'page-sidebar-left.php' || $current_page_layout == 'page-sidebar-right.php' ) {
						
						$layout_sidebar   = trim(cloudfw_get_option( 'portfolio',  'related_layout_sidebar' ));
						
						if ( empty( $layout_sidebar ) ) {
							$layout_sidebar = $layout_fullwidth;
						}

						$layout = $layout_sidebar;

					} else {

						$layout = $layout_fullwidth;

					}

					$raw_content = !empty($layout) ? $layout : " [related_portfolios /]";
					$content    .= do_shortcode($raw_content);
				}
			}
		}

		return $content;
	}

}

/**
 *  Adds comments and related post after the portfolio post contents.
 *
 *  @since 1.0
 */
add_filter( 'the_content', 'cloudfw_add_contents_after_portfolios', 11 );
function cloudfw_add_contents_after_portfolios( $content ) {
	if ( is_singular('portfolio') ) {

		if ( cloudfw_check_onoff( 'portfolio', 'comments' ) && ! post_password_required() ) {
			if ( cloudfw('get_meta', 'comments_enable') != 'hide' ) {
				ob_start();
				comments_template( '', true );
				$content .= ob_get_contents();
				ob_end_clean();
			}
		}

		if ( _check_onoff( cloudfw_get_option( 'portfolio',  'related_posts' ) ) ) {
			$content =  cloudfw_module('CloudFw_Page_Generator_Portfolio', 'related_filter', $content);
		}
	}

	return $content;

}