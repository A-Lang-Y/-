<?php 
/*-----------------------------------------------------------------------------------*/
/* Social icons
/*-----------------------------------------------------------------------------------*/
function corpo_social_icons ()
{
    $services = array ('fb','twitter','gp','rss','flickr','youtube','dribble','linkedin','pinterest','vimeo','tumblr','behance','picassa','deviantart');
    
    echo '<ul class="social">';
    
    foreach ( $services as $service ) :
        
        $active[$service] = of_get_option ('corpo_social_'.$service);
        if ($active[$service]) { echo '<li><a href="'.$active[$service].'" class="social-icon '. $service .'" title="'. __('Follow me on ','corpo').$service.'"></a></li>';}
        
    endforeach;
    echo '</ul>';

}

/**
 * The formatted output of a list of pages.
 * Credit: Bavotasan (http://bavotasan.com/)
 */
function corpo_custom_wp_link_pages( $args = '' ) {
	$defaults = array(
		'before' => '<div class="wp-pagenavi">' . __( 'Pages:', 'corpo' ), 
		'after' => '</div>',
		'text_before' => '',
		'text_after' => '',
		'next_or_number' => 'number', 
		'nextpagelink' => __( 'Next page', 'corpo' ),
		'previouspagelink' => __( 'Previous page', 'corpo' ),
		'pagelink' => '%',
		'echo' => 1
	);

	$r = wp_parse_args( $args, $defaults );
	$r = apply_filters( 'wp_link_pages_args', $r );
	extract( $r, EXTR_SKIP );

	global $page, $numpages, $multipage, $more, $pagenow;

	$output = '';
	if ( $multipage ) {
		if ( 'number' == $next_or_number ) {
			$output .= $before;
			for ( $i = 1; $i < ( $numpages + 1 ); $i = $i + 1 ) {
				$j = str_replace( '%', $i, $pagelink );
				$output .= ' ';
				if ( $i != $page || ( ( ! $more ) && ( $page == 1 ) ) )
					$output .= _wp_link_page( $i );
				else
					$output .= '<span class="current">';

				$output .= $text_before . $j . $text_after;
				if ( $i != $page || ( ( ! $more ) && ( $page == 1 ) ) )
					$output .= '</a>';
				else
					$output .= '</span>';
			}
			$output .= $after;
		} else {
			if ( $more ) {
				$output .= $before;
				$i = $page - 1;
				if ( $i && $more ) {
					$output .= _wp_link_page( $i );
					$output .= $text_before . $previouspagelink . $text_after . '</a>';
				}
				$i = $page + 1;
				if ( $i <= $numpages && $more ) {
					$output .= _wp_link_page( $i );
					$output .= $text_before . $nextpagelink . $text_after . '</a>';
				}
				$output .= $after;
			}
		}
	}

	return $output;
}