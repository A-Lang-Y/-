$(window).load(function() {
   $('#slider').nivoSlider({
        effect:'sliceUpDown', //Specify sets like: 'fold,fade,sliceDown, sliceDownLeft, sliceUp, sliceUpLeft, sliceUpDown, sliceUpDownLeft' 
        slices:12,
        animSpeed:500,
        pauseTime:6000,
        startSlide:0, //Set starting Slide (0 index)
        directionNav:false, //Next & Prev
        directionNavHide:false, //Only show on hover
        controlNav:true, //1,2,3...
        controlNavThumbs:false, //Use thumbnails for Control Nav
        controlNavThumbsFromRel:false, //Use image rel for thumbs
        controlNavThumbsSearch: '.jpg', //Replace this with...
        controlNavThumbsReplace: '_thumb.jpg', //...this in thumb Image src
        keyboardNav:true, //Use left & right arrows
        pauseOnHover:true, //Stop animation while hovering
        manualAdvance:false, //Force manual transitions
        captionOpacity:1, //Universal caption opacity
        beforeChange: function(){},
        afterChange: function(){},
        slideshowEnd: function(){} //Triggers after all slides have been shown
    });
});
$(document).ready(function() {
	// initiate tool tip
	// basic usage  
	$('.normaltip').aToolTip();  
		
	// fixed tooltip  
	$('.fixedtip').aToolTip({  
			fixed: true  
	});
	$('.clicktip').aToolTip({  
		clickIt: true,  
		tipContent: 'Hello I am aToolTip with content from param'  
	}); 				   
});