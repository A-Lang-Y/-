$(window).load(function(){
	$('.slider')._TMS({
		preset:'diagonalFade',
		easing:'easeOutQuad',
		duration:800,
		pagination:true,
		slideshow:6000
	})
	$("#testimonials").jCarouselLite({
		btnNext: ".down",
		btnPrev: ".up",
		visible: 1,
		speed: 600,
		vertical: true,
        circular: true,
		easing: 'easeOutCirc'
	});
})
