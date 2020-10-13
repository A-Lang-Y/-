/*
* This file controls all the defualt actions for every
* html standard page
* NOTE: jQuery must be included before this file
*
**/
$('document').ready(function() {
							 
	/////////////////////////////////////////////
	// Navagation Menus
	/////////////////////////////////////////////
	$(".menu li").each(function() {
		// if has child menus
		if( $(this).children('ul').length > 0 ) {
			// add the submenu class to it
			$(this).find('a.active').append('<span class="indicator"></span>');
			$(this).addClass("submenu");
			if($(this).find('ul > .tr').length <= 0) // make sure there isnt one already there
				$(this).find('ul').prepend( $('<div class="tr" />') );
			// label first and last li elements
			$(this).find('ul.child > li:last').addClass("last-child");
			$(this).find('ul.child > li:first').addClass("first-child");
			if($(this).find('ul > .bf').length <= 0) // make sure there isnt one already there
				$(this).find('ul').append( $('<div class="bf" />') );
			// find the deep children classes
			$(this).find('ul.deep-child > li:last').addClass("last-child");
			$(this).find('ul.deep-child > li:first').addClass("first-child");
			var menuTimeOut = null;
			// label deep-child's li elements
			$(this).mouseenter(function() {
				// show if not already being shown
				$(this).find('ul.child').filter(":not(:animated)").stop().fadeIn(250);
				$(this).find('a').addClass("hover");
				if(menuTimeOut)
					clearTimeout(menuTimeOut);
			}).mouseleave(function() {
				//save parent
				var ele = this;
				 menuTimeOut = setTimeout(function(){
					$(ele).find('ul.child').stop().fadeOut(50);
					// Hide all child submenus
					$(ele).find('ul.child ul.deep-child').each(function() {
						$(this).css('display', 'none');													
					});
					$(ele).find('a').removeClass("hover");
				}, 75);				
			});
			// if has more sub classes
			if( $(this).find('ul').filter(":not(:first)").length > 0 ) {
				$(this).find('ul').filter(":not(:first)").each(function() {
					$(this).addClass('deep-child');									
				});
			}
			
			var submenuTimeOut = null;
			// now the deep child classes appear if hovered over
			$("ul.deep-child").parent('li').mouseenter(function() {
				var ele = this; // save element
				// hide all children that are visible
				$('ul.deep-child:visible').each(function() {
					if( $(ele).has( $(this) ).length <= 0 ) // check if current tab is a child to the parent
						// if not, hide it
						$(this).fadeOut(100);
				});
				// show the child
				$(this).children('ul.deep-child').filter(":not(:animated)").stop().fadeIn(250).addClass('activeAnim');
				
				if(submenuTimeOut)
					clearTimeout(submenuTimeOut);	
					
			}).mouseleave(function() {
				var ele = this; // save the element
				submenuTimeOut = setTimeout(function() {
					$(ele).children('ul.deep-child').stop().fadeOut(50).removeClass('activeAnim');
				}, 200);
			});
		}
	});
	
	/////////////////////////////////////////////
	// Navagation Dropdown Setup
	/////////////////////////////////////////////
	var menuNav = $('.navagation-wrapper select.navagation');
	$('.tabwrapper .menu li').each(function() { 		// Go through all the menu options		
		var depth = ''; 								// level of list style
		var len = $(this).parents("ul").length;			// Amount of parents
		for(i=1;i<len;i++){depth += '&mdash;&nbsp;';}   // For each parent, create identifiers
		var text = depth + $(this).clone().children('ul').remove().end().text();
		var link = $(this).find('a').attr('href');
		var options = '<option value="'+link+'">'+text+'</option>';
		$(options).appendTo(menuNav); 
	});
	$(menuNav).change(function() {
		window.location = $(this).attr('value');
	}); 
	
	/////////////////////////////////////////////
	// Input OnClick
	/////////////////////////////////////////////
	$(".default-form input").focus(function() {
		$(this).parent(".input-wrapper").addClass('active');					  
	}).blur(function() {
		$(this).parent(".input-wrapper").removeClass('active');	
	});
	$(".default-form textarea").focus(function() {
		$(this).parent(".textarea-wrapper").addClass('active');					  
	}).blur(function() {
		$(this).parent(".textarea-wrapper").removeClass('active');	
	});
	
	/////////////////////////////////////////////
	// Social Media Animations
	/////////////////////////////////////////////
	$("ul.sm li").each(function() {
		if( $(this).parent("ul").hasClass("foot") ) {
			var imgSrc = $(this).css('background-image');
			var newImg = imgSrc.replace('.png', '-hover.png');
		} else {
			var imgSrc = $(this).css('background-image');
			var newImg = imgSrc.replace('2.png', '.png');
		}
		$(this).find('a').prepend("<div class='overlay' style='background-image:"+newImg+"'>");
		$(this).mouseenter(function() {	
			$(this).find('.overlay').stop().fadeIn(200);
		}).mouseleave(function() {
			$(this).find('.overlay').stop().fadeOut(200);
		});
	});
	/////////////////////////////////////////////
	// Transparent Hover
	/////////////////////////////////////////////
	$('img#transparent').each(function() {
		
		$(this).bind('mouseenter', function() {
			$(this).stop().animate({
				opacity: 1
			}, 400);
		}).bind('mouseleave', function() {
			$(this).stop().animate({
				opacity: .9				
			}, 400);
		});
	});
	
	/////////////////////////////////////////////
	// Gray Image Hover
	/////////////////////////////////////////////
	$(".border img.gray,.border img.grey").each(function() {
		// Save all existing classes and add the same img
		var src = $(this).attr('src');
		$(this).addClass('over');
		var classList = $(this).attr('class').split(/\s+/);
		var imgClasses = "";
		$.each( classList, function(index, item){
			if (item !== 'gray' && item !== 'grey' && item !== 'over') {
			   imgClasses += ' ' + item;
			}
		});
		var appendi = '.border'; // append after the border
		if( $(this).parent('a').length ) appendi = 'a'; // otherwise, append after the a tag if it exists
		$(this).parent(appendi).append( "<img src='"+src+"' class='"+imgClasses+"' />" );
		$(this).bind('mouseover', function() {
			$(this).closest('img.over').stop().animate({
				opacity: 0											
			}, 200);
		}).bind('mouseleave', function() {
			$(this).closest('img.over').stop().animate({
				opacity: 1											
			}, 200);
		});
	});
	
	/////////////////////////////////////////////
	// Footer Logo Animation
	/////////////////////////////////////////////
	var overlay_class = '.footer .first .logo-caption-overlay';
	$('.footer .first .left').prepend('<div class="logo-caption-overlay" />'); 		   // Add the caption overlay
	$(overlay_class).stop().animate({opacity: 0}, 1000); 	  						   // Hide the caption overlay on page load
	$('.footer .first').mouseenter(function() {
		$(overlay_class).stop().animate({opacity: 1}, 200);  						   // Show caption
	}).mouseleave(function() {
		$(overlay_class).stop().animate({opacity: 0}, 200);  						   // Show caption
	});
	
	/////////////////////////////////////////////
	// Adjust Sidebar Border Height
	/////////////////////////////////////////////
	if( $(".sideborder").length > 0 && $(".sideborder") !== "undefined" ) {
		var add = 0;
		if( $(".tcontent").length > 0 && $(".tcontent") !== "undefined" )
			add = 200;
		$(".sideborder").height( $(".sidebar").height() + add );
	}
		
	/////////////////////////////////////////////
	// Scroll Up
	/////////////////////////////////////////////
	$('a').click(function (e) {
		if(this.hash == '#top') {				 
			$('body,html').animate({
				scrollTop: 0
			}, 500);
			e.preventDefault();
		}
	});
	
	/////////////////////////////////////////////
	// Button set up
	/////////////////////////////////////////////
	if ( $.browser.msie ) {
		$('.button').click(function() {
			$(this).blur();		
		});
	}
	$("a.big-button,a.medium-button").mouseenter(function() {
		if($(this).hasClass('color') || $(this).parent('a').hasClass('color') )
			return;
		if(toColor == "")
			toColor = $(this).css("background-color");
		$(this).stop().animate({backgroundColor: toColor},200);
		$(this).children('span').stop().animate({backgroundColor: toColor},200);
	}).mouseleave(function() {
		if($(this).hasClass('color') || $(this).parent('a').hasClass('color') )
			return;
		$(this).stop().animate({backgroundColor: '#404040'},200);
		$(this).children('span').stop().animate({backgroundColor: '#404040'},200);
	});
	/////////////////////////////////////////////
	// Search Field
	/////////////////////////////////////////////
	$('.callout .search .search-box').click(function() {
		$('.callout .search').addClass('active');
	}).blur(function() {
		$('.callout .search.active').removeClass('active');
	});
	
	/////////////////////////////////////////////
	// Tag Cloud
	/////////////////////////////////////////////
	$('.cloud li a').each(function() {
		$(this).mouseenter(function() {
			$(this).animate({padding:'+=4'}, 100);
		}).mouseleave(function() {
			$(this).animate({padding:'-=4'}, 100);
		});
	})
	/////////////////////////////////////////////
	// Input Field Placeholder
	/////////////////////////////////////////////
	$("input[placeholder]").each(function() {			  
		$(this).val( $(this).attr('placeholder') ).css('font-style', 'italic');
		$(this).focus(function() {
			// if the placeholder value is the same as the text
			if( $(this).val() === $(this).attr('placeholder') ) {
				$(this).val('');	// clear the text
				$(this).css('font-style', 'normal'); // no italic
			}
		}).blur(function() {
			// if the user left the input field with the field blank
			if( $(this).val().length <= 0 || $(this).val().length == 'undefined' )
				// set the value to the placeholder
				$(this).val( $(this).attr('placeholder') ).css('font-style', 'italic');
		});
	});
	
	/////////////////////////////////////////////
	// Accordion
	/////////////////////////////////////////////	
	$('ul.accordion > div.tcontent').hide();
	$('ul.accordion > li > div.parent').click(function() {
		// if already visible
		if ( $(this).next("div.tcontent").hasClass('visible') ) {		
			$(this).removeClass('open').next('div.tcontent').stop().slideUp('fast').removeClass('visible');
		} else {
			$(this).addClass('open').closest('ul.accordion').find('div.visible').stop().slideUp('fast').removeClass("visible").prev('div.parent').removeClass('open');
    		$(this).next('div.tcontent').stop().slideDown('fast').addClass("visible");
		}
  	});
	$('ul.accordion .active').each(function(){ $(this).click(); });
	
	/////////////////////////////////////////////
	// Tabs
	/////////////////////////////////////////////
	$(".tabbed-area .tcontent").first().show(1);
     // When a link is clicked  
    $(".tabbed-area a.tab").click(function (e) {  
        // switch all tabs off  
        $(".tabbed-area .active").removeClass("active");  
        // switch this tab on  
        $(this).addClass("active");
  		// save parent
		var thisEle = this;
		 // Now figure out what the 'title' attribute value is and find the element with that id.  Then slide that down.  
		 var content_show = $(thisEle).attr("title");
        // slide all elements with the class 'content' up  
        $(".tabbed-area .tcontent[id!='"+content_show+"']").hide(0, function() {
			$("#"+content_show).fadeIn(200);
		});
		// prevent from scrolling up the page
  		e.preventDefault();
    }); 
		
}); // end of $(document).ready();

$(window).load(function() {
	/////////////////////////////////////////////
	// Image Animation Icons
	/////////////////////////////////////////////
	var specID = 0;
	$(".border").each(function() {
		// Setup the icons
		if( $(this).children('a').hasClass('link') || $(this).children('a').hasClass('zoom') ) { // look for links
			var both = '';
			var imgELE = $(this).find("img");
			if( $(this).children('a').hasClass('link') && $(this).children('a').hasClass('zoom') ) {both = 'both';}
			$(this).append('<div class="'+both+' mask" id="specialID'+specID+'"></div>');
			// Create the proper containers
			$(this).children('a.link,a.zoom').each(function() {
				var ele = 'link';
				if( $(this).hasClass('zoom') ) { ele = 'zoom'; } // This line and the previous check witch type of link it is
				$(this).siblings('.mask#specialID'+specID).append('<span class="'+ele+'"></span>');
				$(this).removeClass(ele).appendTo('.mask#specialID'+specID+' .'+ele);
			});
			$(this).mouseenter(function(){
				var maskWidth = $(imgELE).width();
				var maskHeight = $(imgELE).height();
				$(this).children('.mask').css({'width':maskWidth+"px",'height':maskHeight+"px"});
				$(this).children('.mask').fadeIn(300);
			}).mouseleave(function(){
				$(this).children('.mask').stop().fadeOut(200);
			});
			// Increment the ID
			++specID;
		}
	});
	/////////////////////////////////////////////
	// IMAGE PRELOADERS
	/////////////////////////////////////////////
	if( $(".preload").length > 0 ) {
		$(".preload").each(function() {
			$(this).remove();
		});
	}
});

// function for content animations
(function( $ ) {
		  
	var methods = {
		// holds the timeout variable
		"timeout": null,
		// the default funtion to cycle the animation
		cycle : function( element, next, delay, previous, settings ) { 
			// keeps track of the loop		
			var index = 1;
			$(element).find('li').filter('li:not(.nav-bullet)').each(function() {
				// check for the element to be shown
				if( index == previous ) {
					$(this).fadeOut( settings.hideSpeed,function() {
						$(this).css('position', 'relative');
					});
					$(this).filter('li:not(.nav-bullet)').fadeOut( settings.hideSpeed, function() {
						$(this).css('position', 'relative');																			
					});
				}
				else if( index == next ) {
					$(this).filter('li:not(.nav-bullet)').fadeIn( settings.showSpeed );
					$(element).css('height', $(this).height() + "px" );
					$(this).css({"position": "absolute"});
					
					// deactivate all the bullets
					$(element).find("li.nav-bullet").each(function() {
						$(this).removeClass('active');										 
					});
					// set the correct button active
					$(element).find("li#"+index).addClass('active');
					
				}
				// increment the counter
				++index;
			});
			// get the next animation variable
			if( (index - 1) < (next + 1) )
				var gNext = 1;
			else
				var gNext = next + 1;
				
			methods.timeout = setTimeout(function () {
				methods.cycle( element, gNext, delay, next, settings );			 
			}, delay);
		},
		// what happens when someone clicks a bullet
		forceCycle: function( element, next, settings ) {
			// clear the timeout
			clearTimeout( methods.timeout );
			// keep track of loop
			var index = 1;
			// loop through all the child elements
			$(element).find('li').each(function() {
				// show the clicked one
				if( next == index ) {
					$(this).filter('li:not(.nav-bullet)')[settings.type]( settings.showSpeed );
					// unactivate all the bullets
					$(element).find("li.nav-bullet").each(function() {
						$(this).removeClass('active');										 
					});
					// set the correct button active
					$(element).find("li#"+index).addClass('active');
				} else {
					$(this).filter('li:not(.nav-bullet)').fadeOut( settings.hideSpeed );
				}
				++index;
			});
		}
	};
		
	$.fn.contentSlide = function( options ) {
		
		 // Create some defaults, extending them with any options that were provided
		var settings = $.extend( {
		  'delay' : 5000,         // 5 second interval between animations
		  'showSpeed': 600,       // speed in which the content will show
		  'hideSpeed': 600,	    // speed in which the content will hide
		  'nav': true,            // show the nav system
		  'bulletChildClass': 'children', // extra classes to add to the bullets
		  'bulletParentClass':'content-bullets' // extra classes to add to the parent bullet (UL)
		}, options);
		
		// create the nav system
		this.append('<ul class="content-slide-nav '+settings.bulletParentClass+'"></ul>');
		// this will keep track of the loop
		var index = 1;
		// loop through all the child elements
		this.find('li').each(function () {
			// hide them all
			$(this).css({"display": "none"});
			// add a nav bullet
			if( index == 1 ) {// make it active
				$(this).siblings('.content-slide-nav').append('<li class="active nav-bullet '+settings.bulletChildClass+'" id="'+index+'"></li>');
			} else // default
				$(this).siblings('.content-slide-nav').append('<li class="nav-bullet '+settings.bulletChildClass+'" id="'+index+'"></li>');
			// increment loop count
			++index;
		});
		// get the nav system
		var nav = this.find('ul.content-slide-nav');
		// save parent
		var parent = this;
		// hide the nav system if not needed
		if( settings.nav === false || settings.nav === 'false' ) {
			nav.css('display', 'none');
		} else {
			// bind the click function to the nav systems
			nav.find('li').each(function () {						  
				$(this).bind({
					click: function() {
						// get the number that was clicked
						var num = parseFloat( $(this).attr('id') );
						// keep track of loop
						var x = 1;
						// animate or not?
						var animate = true;
						$(parent).find('li').each(function () {
							// check to see if the image is already visible
							if( x == num )
								if( $(this).is(':visible') )
									animate = false;
							// check to see if any are still animating
							if( $(this).is(':animated') )
								animate = false;
							// create the nav
							++x;
						});
						if( animate )
							methods.forceCycle( parent, num, settings );
					}
				});	
			});
		}
		// create the recursive animation call
		methods.cycle(this, 1, settings.delay, null, settings);
		return this;
	};
})( jQuery );
