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

$post_classes = 'hentry-post group blog-elegant';

if( yit_get_option( 'blog-post-formats-list' ) )
    { $post_classes .= ' post-formats-on-list'; }
?>
<div id="post-<?php the_ID(); ?>" <?php post_class( $post_classes ); ?>>
    <!-- post featured & title -->
    <?php
    $post_format = get_post_format() == '' ? 'standard' : get_post_format();
    $post_format = yit_get_option( 'blog-post-formats-list' ) && get_post_format() != ''  ? get_post_format() : $post_format;
    
    yit_get_template( 'blog/elegant/post-formats/' . $post_format . '.php' );
    ?>
</div>