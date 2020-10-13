<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * If front page is set to display the
 * blog posts index, include home.php;
 * otherwise, display static front page
 * content
 */
    if ( get_option( 'show_on_front' ) == 'posts' && (int)of_get_option('corpo_hp_style') != 1 ) {
        get_template_part( 'index' );
    } elseif ( 'page' == get_option( 'show_on_front' ) && (int)of_get_option('corpo_hp_style') != 1 ) {
        $template = get_post_meta( get_option( 'page_on_front' ), '_wp_page_template', true );
        $template = ( $template == 'default' ) ? 'page.php' : $template;
        locate_template( $template, true );
    } else { 

	get_header();	

    ?>  

        <?php corpo_home_slider(); ?>

        <div id="content-wrapper">

            <?php if ( of_get_option('corpo_callout') ) : ?>
            
            <!-- Start Callout section -->
            <section id="callout" class="row">
            <?php echo apply_filters('the_content', of_get_option('corpo_callout')); ?>
            </section><!-- END #callout -->

            <?php endif; ?>
            
            <?php $sidebar = wp_get_sidebars_widgets(); ?>
            <?php if ( !empty($sidebar['homepage-sidebar']) ) : ?>
            <!-- Start Services section -->
            <section id="services" class="row">
                <div class="row">
                <?php if( is_active_sidebar('homepage-sidebar') ) dynamic_sidebar( 'homepage-sidebar' ); ?>                 
                </div>
            </section><!-- END #services -->
            <?php endif; ?>
            
            <?php corpo_home_projects(); ?>
               
	<?php 
	get_footer(); 
}
?>