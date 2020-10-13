// Hover move listing
$(document).ready(function() {

	// cufon
	Cufon.replace('.custom, .link-button, #nav>li>a, #social-bar, h1, h2, h3, h4, h5, h6, .bullet-title .big, .bullet-title .small, .title, .subtitle, .portfolio-sidebar ul li a, .post-title, #sidebar ul li a, .staff .information .header .name, .headline', { 
				fontFamily: 'bebas-neue',
				hover: true	
	});
	
	// rollovers
	$("#sidebar li ul li.cat-item a, .portfolio-sidebar ul li a").hover(function() { 
		// on rollover	
		$(this).stop().animate({ 
			marginLeft: "7" 
		}, "fast");
	} , function() { 
		// on out
		$(this).stop().animate({
			marginLeft: "0" 
		}, "fast");
	});
	
	// twitter 
    getTwitters('twitter-holder', {
        id: 'ansimuz', 
        prefix: '',  // If you want display your avatar and name <img height="16" width="16" src="%profile_image_url%" /><a href="http://twitter.com/%screen_name%">%name%</a> said:<br/>
        clearContents: false, // leave the original message in place
        count: 1, 
        withFriends: true,
        ignoreReplies: false,
        newwindow: true,
        template: '<div class="twitter-entry">"%text%" <span class="twitter-time">%time%</span> </div>'

    });
	
	//superfish
	$("ul.sf-menu").superfish({
		  autoArrows:  false, // disable generation of arrow mark-up
		  animation: {height:'show'},
		  speed: 'fast'
	}); 
		
	// slideshow
  	$('#slides')
  	.before('<div id="slideshow-nav-holder"><div id="slideshow-nav">')
  	.cycle({ 
		fx:     'scrollHorz', 
		speed:  500, 
		timeout: 6000, 
		pause: 1,
		pager:  '#slideshow-nav',
		next:   '#next', 
		prev:   '#prev'
	});

	//  slide fade
	$('.slide-fade').cycle({ 
		fx:     'fade', 
		speed:  500, 
		timeout: 3000, 
		pause: 1
	});
	
	//  slide scroll
	$('.slide-scroll').cycle({ 
		fx:     'scrollHorz', 
		speed:  500, 
		timeout: 3000, 
		pause: 1
	});
	
	// toggle
	$(".toggle-container").hide(); 
	$(".toggle-trigger").click(function(){
		$(this).toggleClass("active").next().slideToggle("slow");
		return false;
	});
	
	// accordion
	$('.accordion-container').hide(); 
	$('.accordion-trigger:first').addClass('active').next().show();
	$('.accordion-trigger').click(function(){
		if( $(this).next().is(':hidden') ) { 
			$('.accordion-trigger').removeClass('active').next().slideUp();
			$(this).toggleClass('active').next().slideDown();		}
		return false;
	});
	
	// tooltip
	$.tools.tooltip.addEffect("fade",
		// opening animation
		function(done) {
			this.getTip().fadeIn();
			done.call();
		},
		// closing animation
		function(done) {
			this.getTip().fadeOut();
			done.call();
		}
	);
	$(".tool").tooltip({
		effect: 'fade',
		offset: [50, 0]
	});
	$(".tool-right").tooltip({
		effect: 'fade',
		position: 'center right',
		offset: [0, -50],
		tipClass: 'tooltip-right'
	});
	$(".tool-bottom").tooltip({
		effect: 'fade',
		position: 'bottom center',
		offset: [-50, 0],
		tipClass: 'tooltip-bottom'
	});
	$(".tool-left").tooltip({
		effect: 'fade',
		position: 'center left',
		offset: [0, 50],
		tipClass: 'tooltip-left'
	});
	$(".social-tooltip").tooltip({
		effect: 'fade',
		offset: [0, 0],
		tipClass: 'tooltip-social'
	});
	
	// tabs
	$('.tabbed').tabs({
		fxFade: true
	});
	
	// pretty photo
	$("a[rel^='prettyPhoto']").prettyPhoto({
		theme: 'light_square'
	});	
		
//close			
});
	


// search clearance	
function defaultInput(target){
	if((target).value == 'Search...'){(target).value=''}
}

function clearInput(target){
	if((target).value == ''){(target).value='Search...'}
}
