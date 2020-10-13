function slideSwitch(switchSpeed) {
    var $active = $('#slideshow img.active');
    
    if ( $active.length == 0 ) $active = $('#slideshow img:last');

    var $next =  $active.next('img').length ? $active.next('img')
        : $('#slideshow img:first');

    $active.addClass('last-active');
    
    
    $next.css({opacity: 0.0})
        .addClass('active')
        .animate({opacity: 1.0}, switchSpeed, function() {
            $active.removeClass('active last-active');
        });
}

$(function() {
    setInterval ( "slideSwitch(1000)", 5000 );    
});

