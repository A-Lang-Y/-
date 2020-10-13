<?php get_header(); ?>
        <?php if ( of_get_option('corpo_blogheader_radio') ): ?>
            <?php of_get_option( 'corpo_blogheader' ) == '' ? $header = __('Blog','corpo') : $header  = of_get_option( 'corpo_blogheader' ); ?>
            <section class="section-title"><?php echo $header; ?></section>            
        <?php endif; ?>
            
            <div id="content">
                <section id="main-content" role="main">
                
                    <?php get_template_part('loop'); ?>
                    
                </section>
                
                <?php get_template_part('pagination'); ?>
                
            </div>
            <!-- END #content -->
        
<?php get_sidebar(); ?>

<?php get_footer(); ?>