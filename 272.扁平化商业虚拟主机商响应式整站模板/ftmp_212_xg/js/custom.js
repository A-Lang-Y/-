jQuery(".flickr").delegate("#fbox li a img", "mouseout mouseover", function(m) {
	if (m.type == 'mouseover') {
		jQuery("#fbox li a img").not(this).dequeue().animate({opacity: 0.5}, 400);
	} else {
		jQuery("#fbox li a img").not(this).dequeue().animate({opacity: 1}, 400);}
});

jQuery(".blog").delegate(".blog ul li", "mouseout mouseover", function(m) {
	if (m.type == 'mouseover') {
		jQuery(".blog ul li").not(this).dequeue().animate({opacity: 0.3}, 400);
	} else {
		jQuery(".blog ul li").not(this).dequeue().animate({opacity: 1}, 400);}
});
/*======= Features area image fadin  =======*/
$(document).ready(function(){
	$('#myslides, #myslides1').cycle({
		fx: 'fade',
		speed: 2300,
		timeout: 2000
	});
});