$(document).ready(function() {
	$('.backgrnd-image').cycle({
	  	fx: 'scrollUp',
	  	timeout: 6000, 
    	delay:  800,
    	after: 	function(currSlideElement, nextSlideElement, options, forwardFlag){
    		var className = $(nextSlideElement).attr('class');
    		console.log(className);
    		$("#main ").find('.selected').removeClass('selected');
    		$("#main ").find("."+className).addClass('selected');
    	
    	} 
     });
 });