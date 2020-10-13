$(function() {
	$(document).on('focusin', '.field, textarea', function() {
		if(this.title==this.value) {
			this.value = '';
		}
	}).on('focusout', '.field, textarea', function(){
		if(this.value=='') {
			this.value = this.title;
		}
	});
	
	$('.col ul li:last').addClass('last')
	$('.footer-nav li:last').addClass('last')

	$('.flexslider li .slide-cnt .thumbnail a').hover(function(){

		$(this).stop(true,true).animate({"top": "-10px"}, "fast");

		}, function () {
  		  $(this).animate({"top": "0px"}, "fast")	
		}
	)

});

$(window).load(function() {
	$('.flexslider').flexslider({
		animation: "slide",
		controlsContainer: ".slider-holder",
		slideshowSpeed: 5000,
		directionNav: true,
		controlNav: true,
		animationDuration: 900
	});
});