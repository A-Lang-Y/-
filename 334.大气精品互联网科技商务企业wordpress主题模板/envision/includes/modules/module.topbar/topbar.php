            <?php if( cloudfw_check_onoff( 'topbar', 'enable' ) ) {

                $topbar_layout = cloudfw_get_option( 'topbar', 'layout' );
                $topbar_classes = array();  

                if ( $topbar_layout == 'widgets-left' ) {
                    $topbar_classes['widgets'] = 'left';
                    $topbar_classes['text']    = 'right';
                } else {
                    $topbar_classes['widgets'] = 'right';
                    $topbar_classes['text']    = 'left';
                }
            ?>
            <div id="top-bar" class="clearfix">
                <div id="top-bar-background">
                    <div class="container relative">
                        <?php if ( class_exists('CloudFw_TopBar_Widgets') && $topbar_text = cloudfw_translate( 'text', 'topbar' ) ) { ?>
                        <div id="top-bar-text" class="top-bar-sides abs-<?php echo $topbar_classes['text']; ?>">
                            <?php echo do_shortcode($topbar_text); ?>
                        </div>
                        <?php } ?>

                        <div id="top-bar-widgets" class="<?php echo cloudfw_visible('all'); ?>top-bar-sides abs-<?php echo $topbar_classes['widgets']; ?>">

                            <?php CloudFw_TopBar_Widgets::render(); ?>

                        </div>
                    </div>
                </div>
            </div><!-- /#top-bar -->
            <?php } ?>