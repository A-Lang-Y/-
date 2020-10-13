<?php 

if ( cloudfw_is_multilingual() ) {

    /** Get Languages */
    $languages = cloudfw_get_languages();
    if ( !empty( $languages ) ){
        /** Get Current Language */
        $current_language_code = cloudfw_get_current_language();

        $cl = $languages[$current_language_code];
        $languages_count = count( (array) $languages );
        
        $show_flag = cloudfw_check_onoff( 'topbar_widget_language_switcher', 'flag' );
        $link_type = cloudfw_get_option( 'topbar_widget_language_switcher', 'link_type' );


        if ( $languages_count > 1 ){

            echo '<ul class="widget--language-selector ui--widget ui--custom-menu opt--on-hover opt--menu-direction-right unstyled-all <?php echo cloudfw_visible( $device ); ?>">';
                echo '<li>';
                    echo '<a class="ui--gradient ui--gradient-grey on--hover" href="javascript:;">';
                        echo $cl['name'];
                        echo '<i class="fontawesome-angle-down px14"></i>';
                    echo '</a>';
                    echo '<ul class="sub-menu">';

                    foreach ($languages as $language => $l) {
                        if ($l['current'] == 1)
                            continue;

                        $url = $link_type == 'home' ? $l['home_url'] : $l['url'];
                    
                        echo '<li class="language-item language-'.$language.''._if( $l['current'] == 1, ' current' ).'">';
                            echo '<a href="'. $url .'">';
                                if ( $show_flag && $l['flag'] )
                                    echo '<img class="flag" src="'.$l['flag'].'" alt="'.esc_attr(  $l['name'] .' flag' ).'" />';
                                echo $l['name'];
                            echo '</a>';
                        echo '</li>';
                    }      
                    echo '</ul>';
                echo '</li>';
            echo '</ul>';
            
        }
    }

}

?>