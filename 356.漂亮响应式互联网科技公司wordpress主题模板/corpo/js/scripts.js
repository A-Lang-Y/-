jQuery(function($){

    $("ul.tabs").tabs("> .pane",  {effect: 'fade'} );
    
    // Flexslider init
    if( $('.flexslider').length ) {
        $('.flexslider').flexslider({
            slideshow: true,
            animation: "slide",
            directionNav: false,
            start: function(slider){
                $('body').removeClass('loading');
            }
        });
    }

    
    $("#main-menu").tinyNav({header: 'Navigation'});
            
    $(".portfolio-item").hover(function(){
        $(this).find('.image-overlay').animate({opacity : '1'}, 300);
    }, function(){
        $(this).find('.image-overlay').animate({opacity : '0'}, 300 ,function(){ 
        });
    });
    
    /* Classes for prefooter & services widgets */
    var sidebars = $('#services, #footer-inner'); 
    
    $.each(sidebars, function() {

        var widgetCount = $(this).find('.widget').length;
        var widgetArray = $(this).find('.widget');
        
        widgetArray.last().addClass( 'last' );
        
        if ( widgetCount == 2) {
            widgetArray.addClass('one-half');
        }else if ( widgetCount == 3 ) {
            widgetArray.addClass('one-third');
        }else if ( widgetCount == 4 ) {
            widgetArray.addClass('one-fourth');
        };
    
    });
        
});
