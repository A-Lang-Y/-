<?php

if ( !class_exists('CloudFw_Page_Generator') ) {

/**
 *  CloudFw Page Generator Functions
 *
 *  @since 1.0
 */
class CloudFw_Page_Generator extends CloudFw_Page_Generator_Base {

	/**
	 *  __construct Function
	 */
   function __construct() {
		parent::__construct();
   }

   /**
	*   Get Row Class
	*/
   function row_class(){
		switch ( $this->get_layout() ){
			default:
				$class = 'row';

			break;
			case 'page-sidebar-left.php':
			case 'page-sidebar-right.php':
				$class = 'row-fluid';

			break;
		}

		return $class;
   }

   /**
	*   Site Main Layout
	*/
   function site_layout(){

		$layout = cloudfw_get_visual_option('site_layout');
		if ( empty( $layout ) )
			$layout = 'default'; 

		return $layout;
   }

   /**
	* Content Width
	*/
   function content_width(){
		
		switch ( $this->get_layout() ){
			default:
				$width = 980;

			break;
			case 'page-sidebar-left.php':
			case 'page-sidebar-right.php':
				$width = 500;

			break;
		}

		return $width;
   }

   /**
	* Header Function
	*/
   function header( $args = array() ){
		$classes = array();
		$content_classes = array();

		$this->set('post_type', get_post_type( $this->ID ));

		$layout = $this->get_layout();
		$sidebar = $this->get('sidebar');

		if ( !empty( $sidebar ) && $sidebar == true ){
			$classes[] = 'sidebar-layout';
			$classes[] = 'ui-row';

			$sidebar_position = $this->get('sidebar-position'); 
			
			if ( $sidebar_position == 'left' )
				$classes[] = 'sidebar-left';
			else 
				$classes[] = 'sidebar-right';

		} else {
			$classes[] = 'no-sidebar-layout';
		}

		if ( $this->get( 'titlebar' ) !== false )
			$this->titlebar();

		if ( $rev_slider = $this->get_meta('rev_slider') ) {
			$this->get_rev_slider( $rev_slider );
		}
			
		echo "<div id=\"page-content\"". cloudfw_make_class( $classes ) .">";
			echo "<div class=\"container\">";
					echo "<div id=\"the-content\" ". cloudfw_make_class( $content_classes ) .">";

		do_action( "cloudfw_content_before", $this);
		do_action( "cloudfw_content_before_" . $this->get('post_type'), $this);
   }


   /**
	* Footer Function
	*/
   function footer( $layout = NULL, $args = array() ){
		$layout = $this->get_layout();
		$sidebar = $this->get('sidebar');

		do_action( "cloudfw_content_after", $this);
		do_action( "cloudfw_content_after_" . $this->get('post_type'), $this);

		echo "</div>";

		if ( isset( $sidebar ) && $sidebar == true )
			get_sidebar();

				//echo '</div><!-- /.row -->';  
			echo '</div><!-- /.container -->';

		echo cloudfw_get_page_content( 
			cloudfw_get_option( 'called_pages', 'before_footer' ),
			'<div class="container clearfix">',
			'</div>'
		 );

		echo '</div><!-- /#page-content -->';

	}

	/**
	 * Get Title Bar
	 */
	function titlebar( $args = array() ){

	$titlebar = _check_onoff($this->get_meta('titlebar'));

	if ( ! $titlebar ) {
		return;
	}

	$titlebar_title_element = cloudfw_get_option( 'titlebar', 'title_element', 'h2' );
	$spec_titlebar_default = $this->get('default_titlebar_style');
	$titlebar_default = !empty($spec_titlebar_default) ? $spec_titlebar_default : cloudfw_get_option( 'titlebar_default' );
	$titlebar_style = $this->get_meta( 'titlebar_style' );
	$titlebar_display_title = $this->get_meta( 'titlebar_display_title' );

	if (  $titlebar_display_title == 'default' || $titlebar_display_title == 'on' || $titlebar_display_title == '' ) {
		$titlebar_title = $this->get_meta( 'titlebar_title' ) ? $this->get_meta( 'titlebar_title' ) : get_the_title( $this->get_ID() );
	} else {
		$titlebar_title = '';
	}

	$titlebar_text  = $this->get_meta( 'titlebar_text' );
	$breadcrumb     = $this->breadcrumb();
	$class          = '';

	if ( empty($titlebar_style) ) {
		$titlebar_style = $titlebar_default;
	}

	if ( $titlebar_style ) {

		$styles = cloudfw_walk_options( array( 
			'id'                    => 'indicator',
			'background_style'      => 'background_style',
			'background_image'      => 'background_image',
			'background_position'   => 'background_position',
			'background_color'      => 'background_color',
			'parallax'              => 'parallax',
			'color'                 => 'color',
			'title_color'           => 'title_color',
			'link_color'            => 'link_color',
			'link_decoration'       => 'link_decoration',
			'link_hover_color'      => 'link_hover_color',
			'link_hover_decoration' => 'link_hover_decoration',
			'border_bottom'         => 'border_bottom',
			
			'bc_background_color'   => 'bc_background_color',
			'bc_border_color'       => 'bc_border_color',
			'bc_link_color'         => 'bc_link_color',
			'bc_link_hover_color'   => 'bc_link_hover_color',
			
			'padding_top'           => 'padding_top',
			'padding_bottom'        => 'padding_bottom',
		), cloudfw_get_option('titlebar_styles'), 'indicator' );

		if ( isset($styles[$titlebar_style]) )
			$titlebar_style = $styles[$titlebar_style];
		else {
			if ( isset($styles[$titlebar_default]) )
				$titlebar_style = $styles[$titlebar_default];
		}

		$class = $titlebar_style['id'];
	}

	if ( !is_array($titlebar_style) ) {
		$titlebar_style = array();
	}
	

	$titlebar_parallax = isset($titlebar_style['parallax']) ? $titlebar_style['parallax'] : NULL;
	$titlebar_background_style = isset($titlebar_style['background_style']) ? $titlebar_style['background_style'] : NULL;
	$titlebar_background_image = isset($titlebar_style['background_image']) ? $titlebar_style['background_image'] : NULL;
	$titlebar_background_position = isset($titlebar_style['background_position']) ? $titlebar_style['background_position'] : NULL;
	$titlebar_background_color = isset($titlebar_style['background_color']) ? $titlebar_style['background_color'] : NULL;
	$titlebar_color = isset($titlebar_style['color']) ? $titlebar_style['color'] : NULL;
	$titlebar_title_color = isset($titlebar_style['title_color']) ? $titlebar_style['title_color'] : NULL;
	$titlebar_link_color = isset($titlebar_style['link_color']) ? $titlebar_style['link_color'] : NULL;
	$titlebar_link_decoration = isset($titlebar_style['link_decoration']) ? $titlebar_style['link_decoration'] : NULL;
	$titlebar_link_hover_color = isset($titlebar_style['link_hover_color']) ? $titlebar_style['link_hover_color'] : NULL;
	$titlebar_link_hover_decoration = isset($titlebar_style['link_hover_decoration']) ? $titlebar_style['link_hover_decoration'] : NULL;
	
	$titlebar_border_bottom = isset($titlebar_style['border_bottom']) ? $titlebar_style['border_bottom'] : NULL;
	
	$titlebar_bc_background = isset($titlebar_style['bc_background_color']) ? $titlebar_style['bc_background_color'] : NULL;
	$titlebar_bc_border_color = isset($titlebar_style['bc_border_color']) ? $titlebar_style['bc_border_color'] : NULL;
	$titlebar_bc_link_color = isset($titlebar_style['bc_link_color']) ? $titlebar_style['bc_link_color'] : NULL;
	$titlebar_bc_link_hover_color = isset($titlebar_style['bc_link_hover_color']) ? $titlebar_style['bc_link_hover_color'] : NULL;

	$titlebar_padding_top = isset($titlebar_style['padding_top']) ? $titlebar_style['padding_top'] : NULL;
	$titlebar_padding_bottom = isset($titlebar_style['padding_bottom']) ? $titlebar_style['padding_bottom'] : NULL;
	
	/** Background Image */
	if( $this->get_meta( 'titlebar_background_image' ) )
		$titlebar_background_image  = $this->get_meta( 'titlebar_background_image' );

	/** Background Style */
	if( $this->get_meta( 'titlebar_background_style' ) )
		$titlebar_background_style  = $this->get_meta( 'titlebar_background_style' );


	/** Orientation */
	$titlebar_orientation   = $this->get_meta( 'titlebar_orientation' ) ? $this->get_meta( 'titlebar_orientation' ) : NULL;


	if ( $titlebar_background_style == 'repeat' ) {
		$class .= ' repeat';
	} else {
		$class .= ' cover'; 
	}

	if ( $titlebar_parallax == 'yes' ) {
		$class .= ' cloudfw-ui-parallax-effect';
	}

	if ( $titlebar_orientation ) {
		$class .= ' orientation-' . $titlebar_orientation; 
	}

	if ( empty($titlebar_style) ) {
		$class .= ' titlebar-default'; 
	}

	?>
	<?php //if ( !empty($titlebar_style) ) { ?>          
		<?php ob_start(); ?>

		#titlebar {<?php cloudfw_make_style_attribute( array( 
			'color'               => $titlebar_color,
			'background-color'    => $titlebar_background_color,
			'background-position' => $titlebar_background_position,
			'background-image'    => $titlebar_background_image,
			'background-ie'       => $titlebar_background_image,
			'+border-bottom'      => $titlebar_border_bottom
		), TRUE, FALSE ); ?>}

		#titlebar-title { <?php cloudfw_make_style_attribute( array( 
			'color'            => $titlebar_title_color,
		), TRUE, FALSE ); ?>}

		#titlebar-text a {<?php cloudfw_make_style_attribute( array( 
			'color'            => $titlebar_link_color,
			'text-decoration'  => $titlebar_link_decoration,
		), TRUE, FALSE ); ?>}

		#titlebar-text a:hover {<?php cloudfw_make_style_attribute( array( 
			'color'            => $titlebar_link_hover_color,
			'text-decoration'  => $titlebar_link_hover_decoration,
		), TRUE, FALSE ); ?>}

		#titlebar #breadcrumb {<?php cloudfw_make_style_attribute( array( 
			'background-color' => $titlebar_bc_background,
			'border-color' => $titlebar_bc_border_color,
			'border-bottom-color' => $titlebar_bc_border_color,
		), TRUE, FALSE ); ?>}

		#titlebar #breadcrumb,
		#titlebar #breadcrumb a {<?php cloudfw_make_style_attribute( array( 
			'color' => $titlebar_bc_link_color,
		), TRUE, FALSE ); ?>}

		#titlebar #breadcrumb a:hover {<?php cloudfw_make_style_attribute( array( 
			'color' => $titlebar_bc_link_hover_color,
		), TRUE, FALSE ); ?>}

		#titlebar > .container {<?php cloudfw_make_style_attribute( array( 
			'padding-top'    => $titlebar_padding_top,
			'padding-bottom' => $titlebar_padding_bottom,
		), TRUE, FALSE ); ?>}

		<?php 
			
			$titlebar_css = ob_get_contents();
			ob_end_clean();
			
			cloudfw_vc_set( 'css', 'titlebar', $titlebar_css );
			unset( $titlebar_css );

		 ?>
	<?php //} ?>

		<div id="titlebar" class="<?php echo $class; ?>">
			<div class="container relative">
				<div id="titlebar-text"<?php if ( empty($breadcrumb) ) echo ' class="no-breadcrumb"'; ?>>
					<?php if ( !empty($titlebar_title) ) { ?>
						<<?php echo $titlebar_title_element ?> id="titlebar-title"><?php echo do_shortcode($titlebar_title); ?></<?php echo $titlebar_title_element ?>>
					<?php } ?>

					<?php if ( !empty($titlebar_text) ) { ?>
						<div class="titlebar-text-content"<?php if ( empty($titlebar_title) ) echo ' style="margin-top:0;"' ?>><?php echo cloudfw_inline_format(do_shortcode($titlebar_text)); ?></div>
					<?php } ?>
				</div>
				<?php if ( !empty($breadcrumb) ) { ?>
					<div id="titlebar-breadcrumb"><div id="breadcrumb" class="ui--box-alias centerVertical"><?php echo $breadcrumb; ?></div></div>
				<?php } ?>
			</div>
		</div><!-- /#titlebar -->

	<?php
   }

   /**
	* BreadCrumb Function
	*/
   function breadcrumb(){
		
		if (    function_exists( 'cloudfw_breadcrumb' ) 
			//&&    ( _check_onoff( cloudfw_get_option( 'global', 'breadcrumb' ) ) || $this->get_meta('breadcrumb') == 'on'  ) 
			//&&    !is_front_page()
			&&  ( $this->get_meta('breadcrumb') == 'default' || $this->get_meta('breadcrumb') == 'on' || $this->get_meta('breadcrumb') == '' )
		)
			return cloudfw_breadcrumb(array( 
				'echo' => false,
				'separator' => ' <i class="ui--caret fontawesome-angle-right px18"></i> '
			));

   }

   /**
	* Get Revolution Slider
	*/
   function get_rev_slider( $alias = NULL, $args = array() ){
		if( function_exists('putRevSlider') ) {
			echo '<div'.
				cloudfw_make_class(array(
					'ui--rev-slider',
					cloudfw_visible( $this->get_meta('rev_slider_visibility') ),
				)) .
			'>';
			putRevSlider( $alias );
			echo  cloudfw_UI_shadow( $this->get_meta('rev_slider_shadow') );
			echo '</div>';
		}
   }

   /**
    * Gets the content or excerpt
    */
   function content() {
		if( is_search() ) {
			the_excerpt();
		} else {
			the_content();  
		}
   }

   /**
	* Call Standart Page
	*/
   function page( $type = NULL, $args = array() ){
		if ( $this->get( 'woocommerce' ) ):
			woocommerce_content();
		elseif ( $this->get( 'blog' ) ):
			return $this->get_blog();
		elseif ( $this->get( '__page' ) ):
			return $this->get_a_page();
		else:

			$custom_content = apply_filters( 'cloudfw_custom_content', '' );
			
			if ( empty($custom_content) ) {
				$custom_content = $this->get( 'content' );
			}

			if ( !empty($custom_content) ) {
				echo $custom_content;
				return;
			} else {

				if ( have_posts() && !is_404() ){
					while ( have_posts() ) : the_post();
						echo $this->content();      
					endwhile;
					wp_reset_postdata();
				}
			}

			if ( is_singular( array( 'post' ) ) ){
				$args = array(
					'before'           => '<p><strong>' . __('Pages:','cloudfw') . '</strong> ',
					'after'            => '</p>',
					'link_before'      => '',
					'link_after'       => '',
					'next_or_number'   => 'number',
					'nextpagelink'     => cloudfw_translate( 'next_page' ),
					'previouspagelink' => cloudfw_translate( 'previous_page' ),
					'pagelink'         => '%',
					'echo'             => 1
				);

				wp_link_pages( $args );
			}
			
		endif;
   }

   function get_a_page(){

		global $post;
		$tmp_post = $post;

		$out = '';            
		$args = array(
			'showposts'         =>  '1',
			'page_id'           =>  $this->ID,
		);
		$check_for_content_exists = $this->get( 'check_for_content_exists' ); 

		$posts = new WP_Query( $args );
		if( $posts->have_posts()) :
			ob_start();
			while( $posts->have_posts() ) : $posts->the_post();
				echo $this->content();
			endwhile;
			$out = ob_get_contents();
			ob_end_clean();

			echo $out;

			wp_reset_postdata();
			$post = $tmp_post;
			wp_reset_query();

			if ( $check_for_content_exists ) {
				if ( !empty($out) )
					return true;
			} else
				return true;

		endif;

   }

	/**
	 *  Generates blog settings.
	 */
	function page_settings( $option_key, $options, $return  = 'layout' ) {

		$field_layout = !empty($options['layout']) ? $options['layout'] : 'layout'; 
		$field_sidebar = !empty($options['sidebar']) ? $options['sidebar'] : 'sidebar'; 
		$field_skin = !empty($options['skin']) ? $options['skin'] : 'skin'; 
		$field_titlebar_style = !empty($options['titlebar_style']) ? $options['titlebar_style'] : 'titlebar_style'; 

		$layout         = cloudfw_get_option( $option_key, $field_layout, isset($options['_defaults'][$option_key]) ? $options['_defaults'][$field_layout] : NULL );
		$sidebar        = cloudfw_get_option( $option_key, $field_sidebar, isset($options['_defaults'][$option_key]) ? $options['_defaults'][$field_sidebar] : NULL );
		$skin           = cloudfw_get_option( $option_key, $field_skin, isset($options['_defaults'][$option_key]) ? $options['_defaults'][$field_skin] : NULL );
		$titlebar_style = cloudfw_get_option( $option_key, $field_titlebar_style, isset($options['_defaults'][$option_key]) ? $options['_defaults'][$field_titlebar_style] : NULL );

		if ( !empty($skin) )
			$this->set('skin', $skin );

		if ( !empty($sidebar) )
			$this->set('custom_sidebar', $sidebar);

		if ( !empty($titlebar_style) )
			$this->set('default_titlebar_style', $titlebar_style);


		if ( isset($$return) )
			return $$return;

	}

	/**
	 *    Default Sidebar Contents
	 *
	 *    @since 1.0
	 */
	function default_sidebar( $sidebar ){
		
		$widget_args = array(
			'before_title'  => '<h4 class="sidebar-widget-title ui--widget-title"><span>',
			'after_title'   => '</h4>',
		);
		
		switch($sidebar){
			default:
			case 'default-widget-area':

					 the_widget('WP_Widget_Meta', NULL, $widget_args);
					 //the_widget('WP_Widget_Calendar', array('title' => 'Calender'), $widget_args);
						
				break;
			case 'blog-widget-area':

					 //the_widget('WP_Widget_Meta', NULL, $widget_args);
					 the_widget('WP_Widget_Calendar', array('title' => 'Calendar'), $widget_args);
						
				break;
			case 'archive-widget-area':
			
				if ( ! dynamic_sidebar( 'default-widget-area' ) ) {

					 the_widget('WP_Widget_Search', NULL, $widget_args);
					 the_widget('WP_Widget_Calendar', array('title' => 'Calendar'), $widget_args);
				}
				
			break;  
			case 'searchpage-widget-area':
				
				 the_widget('WP_Widget_Search', NULL, $widget_args);
				 the_widget('WP_Widget_Calendar', array('title' => 'Calendar'), $widget_args);
				 
			break;  
			
		}
		
	}


   /**
	* Get Blog Loop
	*/
   function get_blog( $args = array() ){
		global $post;
		$tmp_post = $post;
		$post_type = $this->get_post_type();

		if ( is_single() && $post_type == 'post' ) {

			global $wp_query;
			$obj = new CloudFw_Shortcode_Blog();
			echo $obj->shortcode( array( 'main_query' => $wp_query, 'layout' => 'single', 'title_element' => cloudfw_get_option('blog_single', 'title_element') ) );

		} else {

			global $wp_query;
			if( have_posts()) {
				$obj = new CloudFw_Shortcode_Blog();
				$args = $this->get('blog_options');

				if ( !isset($args) || empty($args) )
					$args = $this->blog_settings( 'blog_page' );

				$args['main_query'] = $wp_query;
				echo $obj->shortcode( $args );
			}

		}

		$post = $tmp_post;
		wp_reset_query();
		
	}

	/**
	 *  Generates blog settings.
	 */
	function blog_settings( $option_key ) {
		$args = array();
		if ( $blog_layout = cloudfw_get_option($option_key, 'layout', 'standard') )
			$args['layout'] = $blog_layout;

		if ( $columns = cloudfw_get_option($option_key, 'columns') )
			$args['columns'] = $columns;

		if ( $image_ratio = cloudfw_get_option($option_key, 'image_ratio') )
			$args['image_ratio'] = $image_ratio;

		if ( $video_ratio = cloudfw_get_option($option_key, 'video_ratio') )
			$args['video_ratio'] = $video_ratio;

		if ( $title_size = cloudfw_get_option($option_key, 'title_size') )
			$args['title_element'] = $title_size;

		$args['pagination'] = true;

		if ( $list_style = cloudfw_get_option($option_key, 'list_style') )
			$args['list_style'] = $list_style;
		
		if ( $show_excerpt = cloudfw_get_option($option_key, 'excerpt') )
			$args['show_excerpt'] = $show_excerpt;

		if ( $excerpt_length = cloudfw_get_option($option_key, 'excerpt_length') )
			$args['excerpt_length'] = $excerpt_length;

		if ( $meta_author = cloudfw_get_option($option_key, 'meta_author') )
			$args['meta_author'] = $meta_author;

		if ( $meta_date = cloudfw_get_option($option_key, 'meta_date') )
			$args['meta_date'] = $meta_date;

		if ( $meta_category = cloudfw_get_option($option_key, 'meta_category') )
			$args['meta_category'] = $meta_category;

		if ( $meta_comment = cloudfw_get_option($option_key, 'meta_comment') )
			$args['meta_comment'] = $meta_comment;

		if ( $meta_likes = cloudfw_get_option($option_key, 'meta_likes') )
			$args['meta_likes'] = $meta_likes;

		return $args;
	}   

	/**
	 *  Get Portfolio Posts via a Post
	 *
	 *  @since 1.0
	 */
	function get_gallery_images( $id, $limit = -1, $exclude_featured = 0, $paged = 0 ){
		if ( !$id )
			return array();

		$out = array();
		$indicator = ($this->get_meta('port_gallery_indicator', $id));

		if ( is_array($indicator) && !empty($indicator) ) {
			$images = ($this->get_meta('port_gallery_image', $id));
			$titles = ($this->get_meta('port_gallery_title', $id));
			$links  = ($this->get_meta('port_gallery_link', $id));
			$descs  = ($this->get_meta('port_gallery_desc', $id));

			if ( $limit > 0 )
				 $indicator = array_splice($indicator, $limit);

			foreach ($indicator as $i => $dummy) {
				if ( !$images[ $i ] )
					continue;

				$item = array();
				$item['title']          = __t(isset($titles[ $i ]) ? $titles[ $i ] : NULL);
				$item['permalink']      = __url(isset($links [ $i ]) ? $links [ $i ] : NULL);
				$item['thumbnail']      = isset($images[ $i ]) ? $images[ $i ] : NULL;
				$item['large_image']    = isset($images[ $i ]) ? $images[ $i ] : NULL;
				$item['full_image']     = isset($images[ $i ]) ? $images[ $i ] : NULL;
				$item['desc']           = isset($descs [ $i ]) ? $descs [ $i ] : NULL;
				$item['type']           = 'lightbox';

				$out[] = $item; 
				unset($item);

			}

		}

		return $out;
	}

}

}