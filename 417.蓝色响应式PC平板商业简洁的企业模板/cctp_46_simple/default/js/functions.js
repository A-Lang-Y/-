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

	$('.main .cols .col:last, .footer-cols .col:last ').addClass('last');
	$('.footer-nav ul li:first-child ').addClass('first');
	$('.top-nav ul li:last-child').addClass('last');
	$('.top-nav ul li:first-child').addClass('first');
	$('.sidebar ul li:last-child').addClass('last');


	$('.top-nav a.nav-btn').click(function(){
		$(this).closest('.shell').find('ul').stop(true,true).slideToggle()
		
		$(this).find('span').toggleClass('active')
		return false;
	})
});

$(window).load(function() {
	$('.flexslider').flexslider({
		animation: "slide",
		controlsContainer: ".flexslider",
		slideshowSpeed: 3000,
		directionNav: false,
		controlNav: true,
		animationDuration: 900
	});
});