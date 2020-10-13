<?php echo cloudfw_socialbar( 
    array(
        'id'         => 'topbar-social-icons',
        'style'      => 'topbar', 
        'size'       => 'big',
        'color'      => cloudfw_get_option('topbar_widget_social_icons', 'color', 'grey-bevel-gradient'),
        'effect'     => cloudfw_get_option('topbar_widget_social_icons', 'effect', 'fade'),
        'class'      => cloudfw_visible( $device, 'ui--widget opt--on-hover style--top-bar'),
        'item_class' => 'ui--gradient ui--gradient-grey on--hover'
    ), 
    cloudfw_walk_options( array( 
        'service'   => 'service',
        'url'       => 'url',
    ), cloudfw_get_option('topbar_widget_social_icons') )

); ?>