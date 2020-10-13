$(function() {

	$('#navigation ul li:first-child').addClass('first')
	$('#navigation ul li:last-child').addClass('last')
	$('section:last').addClass('last-section')
});

$(window).load(function() {
	$('.flexslider').flexslider({
		animation: "slide",
		controlsContainer: ".slider-holder",
		slideshowSpeed: 5000,
		directionNav: true,
		controlNav: false,
		animationDuration: 900
	});
});