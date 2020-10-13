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

yit_get_template( 'blog/big/post-formats/standard.php' );

if( is_single() || yit_get_option( 'blog-post-formats-list' ) ) : ?>
<div class="soundcloud-frame">
    <?php
    $url = yit_get_post_meta( get_the_ID(), '_format_audio' );
    $iframe = ( bool ) yit_get_post_meta( get_the_ID(), '_format_audio_iframe' );
    $show_artwork = ( bool ) yit_get_post_meta( get_the_ID(), '_format_audio_artwork' );
    $show_comments = ( bool ) yit_get_post_meta( get_the_ID(), '_format_audio_comments' );
    $auto_play = ( bool ) yit_get_post_meta( get_the_ID(), '_format_audio_autoplay' );
    $color = yit_get_post_meta( get_the_ID(), '_format_audio_color' );
    
    echo do_shortcode( '[soundcloud iframe="' . $iframe . '" url="' . $url . '" show_artwork="' . $show_artwork . '" show_comments="' . $show_comments . '" auto_play="' . $auto_play . '" color="' . $color . '"]' );
    ?>
</div>

<div class="clear"></div>
<?php endif ?>