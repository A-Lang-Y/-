        </div><!-- END #content-wrapper -->
        <footer id="footer">
            <div id="footer-inner" class="row">
                <?php if( is_active_sidebar( 'prefooter-sidebar' ) ) dynamic_sidebar( 'prefooter-sidebar' ); ?>
            </div>
        </footer><!-- END #footer -->
        <div id="footer-bar">
            <div class="right">
                <div id="footer-nav">
                <?php
                    if(has_nav_menu('footer-menu')){
                         wp_nav_menu(array(
                            'theme_location'  => 'footer-menu',
                            'container'       => false, 
                            'menu_class'      => 'menu', 
                            'menu_id'         => 'footer-menu',
                            'echo'            => true,
                            'depth'           => 1,
                         ));
                    }
                ?>
                </div>
            </div>
            <div class="left">
                Copyright &copy; <?php echo date("Y"); ?> <?php bloginfo('name'); ?>. <?php _e('Powered by', 'corpo'); ?> 
					<a href="//wordpress.org" title="WordPress"><?php _e('WordPress', 'corpo'); ?></a> &amp; <a href="http://webtuts.pl/themes/corpo" title="<?php _e('Corpo Theme', 'corpo'); ?>"><?php _e('Corpo Theme', 'corpo'); ?></a>.
            </div>
        </div>
    </div><!-- END #wrapper -->

    <?php wp_footer(); ?>
	</body>
</html>