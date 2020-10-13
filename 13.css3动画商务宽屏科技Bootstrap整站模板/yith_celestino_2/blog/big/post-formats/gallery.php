<?php
/**
 * Your Inspiration Themes
 * 
 * @package WordPress
 * @subpackage Your Inspiration Themes
 * @author Your Inspiration Themes Team <info@yithemes.com>
 *
 * This source file is subject to the GNU GENERAL PUBLIC LICENSE (GPL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/gpl-3.0.txt
 */

if( !is_single() && !yit_get_option( 'blog-post-formats-list' ) )
    { yit_get_template( 'blog/big/post-formats/standard.php' ); return; }
    
$has_thumbnail = ( ! has_post_thumbnail() || ( ! is_single() && ! yit_get_option( 'blog-show-featured' ) ) || ( is_single() && ! yit_get_option( 'blog-show-featured-single' ) ) ) ? false : true; ?>

<div class="<?php if ( ! $has_thumbnail ) echo 'without ' ?>thumbnail">
    <!-- post title -->
    <?php
    $link = get_permalink();
    
    if( get_the_title() == '' )
        { $title = __( '(this post does not have a title)', 'yit' ); }
    else
        { $title = get_the_title(); }

    $attachments = get_posts( array(
    	'post_type' 	=> 'attachment',
    	'numberposts' 	=> -1,
    	'post_status' 	=> null,
    	'post_parent' 	=> get_the_ID(),
    	'post_mime_type'=> 'image',
    	'orderby'		=> 'menu_order',
    	'order'			=> 'ASC'
    ) );
    
    if( $attachments ) {
        $height = 0;
        $html = '';
                                                        
        foreach ( $attachments as $key => $attachment ) { 
            $image = wp_get_attachment_image_src( $attachment->ID, 'blog_big' );
            $html .= $image[0] . PHP_EOL;
        }
        
        $html = '[images_slider effect="fade" width="0" height="auto" direction="horizontal" speed="5000"]' . PHP_EOL . $html . '[/images_slider]';
        
        echo do_shortcode( $html );
    }
    ?>
    
    <!-- post meta -->
    <?php if ( get_post_type() == 'post' ) : ?>
    <div class="meta group span4">
        <?php
        if ( is_single() )
            { yit_string( "<h1 class=\"post-title\"><a href=\"$link\">", $title, "</a></h1>" ); } 
        else
            { yit_string( "<h2 class=\"post-title\"><a href=\"$link\">", $title, "</a></h2>" ); }
        ?>
        
        <div>
            <?php if( yit_get_option( 'blog-show-author' ) ) : ?><p class="author"><?php echo yit_get_icon( 'blog-author-icon', true ) ?><span><?php _e( 'Author:', 'yit' ) ?></span> <?php the_author_posts_link() ?></p><?php endif; ?>
            <?php if( yit_get_option( 'blog-show-date' ) ) : ?><p class="date"><?php echo yit_get_icon( 'blog-date-icon', true ) ?><span><?php _e( 'Date:', 'yit') ?></span> <?php echo get_the_date() ?></p><?php endif; ?>
            <?php if( yit_get_option( 'blog-show-comments' ) ) : ?><p class="comments"><?php echo yit_get_icon( 'blog-comments-icon', true ) ?><span><?php comments_popup_link( __( '<span>Comments:</span> 0', 'yit' ), __( '<span>Comments:</span> 1', 'yit' ), __( '<span>Comments:</span> %', 'yit' ) ); ?></span></p><?php endif ?>
            
            <?php edit_post_link( __( 'Edit', 'yit' ), '<p class="edit-link"><i class="icon-pencil"></i>', '</p>' ); ?>
        </div>
    </div>
    <?php endif ?>
    
    <div class="clear"></div>
    
    <?php if( get_post_format() != '' ) : ?><span class="post-format <?php echo get_post_format() ?>"><?php _e( ucfirst( get_post_format() ), 'yit' ) ?></span><?php endif ?>
</div>

<div class="clear"></div>