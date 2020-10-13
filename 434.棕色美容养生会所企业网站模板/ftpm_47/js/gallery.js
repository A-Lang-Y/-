


 
// DOM Loaded 
$(function(){ 
     
    //init js styles 
    $('body').addClass('hasJS'); 
	 
    // homepage cycles 
    $('#feature_gallery .bigimg').wrapAll('<div class="bigimgs">').parents('#feature_gallery').append('<ul class="menu" id="feature_gallery_pager">').cycle({ 
        fx:'fade', 
        easing: 'swing', 
        inDelay:    250, 
        drop:       40, 
        timeout:    5000, 
        pause:      true,
        slideExpr: '.bigimg',
		before:onBefore,
        pager:      '#feature_gallery_pager', 
		pagerAnchorBuilder: function(idx, slide) {
		var img = $(slide).children().eq(0).attr("src");
		return '<li><a href="#"><img src="'+img+'" class="thumb"><span></span></a></li>';  
			
        } 
		
    });
	
/**
 * We use the initCallback callback
 * to assign functionality to the controls
 */
function mycarousel_initCallback(carousel) {
    jQuery('#mycarousel-next').bind('click', function() {
        carousel.next();
        return false;
    });

    jQuery('#mycarousel-prev').bind('click', function() {
        carousel.prev();
        return false;
    });
};


$(function() {
    jQuery('#feature_gallery_pager').jcarousel({
        scroll:1,
		wrap:"both",

        initCallback: mycarousel_initCallback,
        // This tells jCarousel NOT to autobuild prev/next buttons
        buttonNextHTML: null,
        buttonPrevHTML: null
    });
});

	
function onBefore() { 
    $('#output').html(this.id); 
} 	
     
}); 
 
/* Window load event (things that need to wait for images to finish loading) */ 
//equal heights 

 
