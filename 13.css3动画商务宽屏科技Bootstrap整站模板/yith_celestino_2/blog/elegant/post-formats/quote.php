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
?>
<div class="thumbnail">
        <div class="row">                
            <!-- post meta -->
            <?php if ( get_post_type() == 'post' ) : ?>
            <div class="meta group span3">              
                <div>
                    <?php if( yit_get_option( 'blog-show-date' ) ) : ?><p class="date"><?php echo yit_get_icon( 'blog-date-icon', true ) ?><span><?php _e( 'Date:', 'yit') ?></span> <?php echo get_the_date() ?></p><?php endif; ?>                    
                    
                    <?php edit_post_link( __( 'Edit', 'yit' ), '<p class="edit-link"><i class="icon-pencil"></i>', '</p>' ); ?>
                </div>
                <div>
                    <?php if( yit_get_option( 'blog-show-comments' ) ) : ?><p class="comments"><?php echo yit_get_icon( 'blog-comments-icon', true ) ?><span><?php comments_popup_link( __( '<span>Comments:</span> 0', 'yit' ), __( '<span>Comments:</span> 1', 'yit' ), __( '<span>Comments:</span> %', 'yit' ) ); ?></span></p><?php endif ?>
                </div>
                <div>
                    <?php echo do_shortcode( '[share title="' . __( 'Share on', 'yit' ) . '" socials="facebook, twitter, google, pinterest"]' ); ?>
                </div>
            </div>
            <?php endif ?>
            
            <!-- post title -->
            <div class="the-content span6">
                <div>
                    <?php
                    $link = get_permalink();
                
                    if( get_the_title() == '' )
                        { $title = __( '(this post does not have a title)', 'yit' ); }
                    else
                        { $title = get_the_title(); }
                    ?>
                    
                    <?php yit_string( "<blockquote class=\"post-title\"><a href=\"$link\">", get_the_content(), "</a><cite>" . $title . "</cite></blockquote>" ) ?>
                </div>
            </div>
        </div>
    </div>