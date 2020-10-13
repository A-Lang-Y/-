<?php 

function cloudfw_gradient_generator( $from_stop, $to_stop ){

$from_stop = str_replace('#', '', $from_stop); 
$to_stop   = str_replace('#', '', $to_stop); 

ob_start();	
?><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.0" preserveAspectRatio="none" width="100%" height="100%">
    <defs>
        <linearGradient id="linear-gradient" x1="0%" y1="0%" x2="0%" y2="100%" spreadMethod="pad">
            <stop offset="0%" stop-color="#<?php echo $from_stop?>" stop-opacity="1"/>
            <stop offset="100%" stop-color="#<?php echo $to_stop?>" stop-opacity="1"/>
        </linearGradient>
    </defs>
    <rect width="100%" height="100%" style="fill: url(#linear-gradient);"/>
</svg><?php
	
	$out = ob_get_contents(); ob_end_clean();
	return base64_encode($out);;
}