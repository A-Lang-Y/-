$(document).ready(function(){


//------------------------------------- Scroll navigation ------------------------------------------------//
	
			$('#mainNav .navigation a, .plus a, #aboutusContent a, a.blueButton ').click(function(){
						var pageSection = $(this).attr('href');
						$(window).scrollTo( $(pageSection) , 800, {offset: { top: -190 }} );

			});
			
						
//------------------------------------- End scroll navigation ------------------------------------------------//


//--------------------------------- Hover animation for the elements of the portfolio --------------------------------//

				$('.work, .item').hover( function(){ 
					$(this).children('img').animate({ opacity: 0.20 }, 'fast');
				}, function(){ 
					$(this).children('img').animate({ opacity: 1 }, 'slow'); 
				}); 
				
				$('.work, .item').on('mouseenter', function(){
						$(this).children('.zoom,.link').stop(true,true).slideDown(200);
					}).on('mouseleave', function(){
						$(this).children('.zoom, .link').stop(true,true).slideUp(200);
					});

//--------------------------------- End hover animation for the elements of the portfolio --------------------------------//

//-----------------------------------Initilaizing fancybox for the portfolio-------------------------------------------------//

	$('.portfolio a.folio').fancybox({
					'overlayShow'	: true,
					'opacity'		: true,
					'transitionIn'	: 'elastic',
					'transitionOut'	: 'none',
					'overlayOpacity'	:   0.8
				});
				
//-----------------------------------End initilaizing fancybox for the portfolio-------------------------------------------------//

	//--------------------------------- Sorting portfolio elements with quicksand plugin  --------------------------------//
	
		var $portfolioClone = $('.portfolio').clone();

		$('.filter a').click(function(e){
			$('.filter li').removeClass('current');	
			var $filterClass = $(this).parent().attr('class');
			if ( $filterClass == 'all' ) {
				var $filteredPortfolio = $portfolioClone.find('li');
			} else {
				var $filteredPortfolio = $portfolioClone.find('li[data-type~=' + $filterClass + ']');
			}
			$('.portfolio').quicksand( $filteredPortfolio, { 
				duration: 800,
				easing: 'easeInOutQuad' 
			}, function(){
					$('.item').hover( function(){ 
						$(this).children('img').animate({ opacity: 0.20 }, 'fast');
					}, function(){ 
						$(this).children('img').animate({ opacity: 1 }, 'slow'); 
					}); 

					$('.item').on('mouseenter', function(){
							$(this).children('.zoom,.link').stop(true,true).slideDown(200);
						}).on('mouseleave', function(){
							$(this).children('.zoom, .link').stop(true,true).slideUp(200);
						});

//------------------------------ Reinitilaizing fancybox for the new cloned elements of the portfolio----------------------------//

				$('.portfolio a.folio').fancybox({
								'overlayShow'	: true,
								'opacity'		: true,
								'transitionIn'	: 'elastic',
								'transitionOut'	: 'none',
								'overlayOpacity'	:   0.8
							});

//-------------------------- End reinitilaizing fancybox for the new cloned elements of the portfolio ----------------------------//

			});


			$(this).parent().addClass('current');
			e.preventDefault();
		});

//--------------------------------- End sorting portfolio elements with quicksand plugin--------------------------------//


//--------------------------------- Form validation --------------------------------//
$(".contactForm").validate();
//--------------------------------- End form validation--------------------------------//


//---------------------------------- Google map location -----------------------------------------//

	$location = "Avenue de France, Agdal, Rabat, Rabat-SalÃ©-Zemmour-ZaÃ«r, Maroc";
		$('#location').gMap({ 
		address:$location,
		zoom:18,
		markers: [{ address: $location }]
 });
	//---------------------------------- End google map location -----------------------------------------//

//--------------------------------- End hover animation for the elements of the portfolio --------------------------------//
$('.flexslider').flexslider({
   animation: "fade"
 });
//--------------------------------- Initilaizing fancybox for the clicked elements of the portfolio --------------------------------//

$('.work a.folio').fancybox({
	'overlayShow'	: true,
	'opacity'		: true,
	'transitionIn'	: 'elastic',
	'transitionOut'	: 'none',
	'overlayOpacity'	:   0.8
});
//--------------------------------- End initilaizing fancybox for the clicked elements of the portfolio --------------------------------//


//--------------------------------- Scroll to the top --------------------------------//
$().UItoTop({ easingType: 'easeOutQuart' });
//--------------------------------- End scroll to the top --------------------------------//


$('#testimonia')
	.cycle({
        fx: 'fade',
		timeout: 5000
     });
});