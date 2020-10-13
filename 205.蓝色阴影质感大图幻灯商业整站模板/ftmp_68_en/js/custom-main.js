/* ------------------------------------------------------------------------
Fire up Functions on Page Load
* ------------------------------------------------------------------------- */
jQuery(document).ready(function(){
	doMenu();
	doTestimonials();
	doTabsType1();
	doTabsType2();
	doAccordion();
	initScrollTop();
});




/* ------------------------------------------------------------------------
Main Navigation
* ------------------------------------------------------------------------- */
function doMenu(){
	var isOpen, theTimeout;
	var menu = jQuery("header").find('ul').eq(0);
	var menu_items = menu.find("li");

	menu_items.hover(function(){
		if(jQuery(this).css('display') == 'block'){
			return;//DIsables the menues. I don't check for window size since the sizec ould varia from CSS to javascript. Checking the display attribute is more accurate since it changes with CSS media queries.
		}
		var theSub = jQuery(this).children('ul').eq(0);
		if(this.timeout){
			clearTimeout(this.timeout);
		}
		if(theSub && !theSub.attr('goingUp')){
			var winSize = getWinSize();
			theSub.slideDown().fadeIn();
			if(theSub.offset()!= null){ // mod by denzel to fix null error
			var theSubEndLine = theSub.outerWidth() + theSub.offset().left;
			}else{
			var theSubEndLine = theSub.outerWidth();
			}
			if((theSubEndLine > winSize.w) &&  (!jQuery.browser.msie || (jQuery.browser.msie && parseInt(jQuery.browser.version) > 7))){
				if(!theSub.attr('wasDisplaced')){
					theSub.attr('wasDisplaced', true);
					theSub.animate({
						left: '-=495px'
					}, 350, 'swing');
				}
			}
		}
	});

	menu_items.mouseleave(function(e){
		var theSub = jQuery(this).children('ul').eq(0);
		var that = this;
		if(theSub){
			that.timeout = setTimeout(function(){
				if(theSub.attr('wasDisplacedfake')){
					theSub.animate({
						left: '+=480px'
					}, 0, 'swing', function(){
						theSub.slideUp().fadeOut();
					});
					theSub.attr('wasDisplaced', false);
				}else{
					theSub.attr('goingUp', true);
					theSub.slideUp().fadeOut(function(){
						theSub.removeAttr('goingUp');
					});
				}
			}, 350);
		}
	});
}

function getWinSize(){
if (document.body && document.body.offsetWidth) {
 winW = document.body.offsetWidth;
 winH = document.body.offsetHeight;
}
if (document.compatMode=='CSS1Compat' &&
    document.documentElement &&
    document.documentElement.offsetWidth ) {
 winW = document.documentElement.offsetWidth;
 winH = document.documentElement.offsetHeight;
}
if (window.innerWidth && window.innerHeight) {
 winW = window.innerWidth;
 winH = window.innerHeight;
}
return {
h: winH,
w: winW
}
}








/* ------------------------------------------------------------------------
Scroll to Top
* ------------------------------------------------------------------------- */
function initScrollTop() {
    var change_speed = 1200;
    jQuery('a.link-top').click(function () {
        if (!jQuery.browser.opera) {
            jQuery('body').animate({
                scrollTop: 0
            }, {
                queue: false,
                duration: change_speed
            })
        }
        jQuery('html').animate({
            scrollTop: 0
        }, {
            queue: false,
            duration: change_speed
        });
        return false
    })
}






/* ------------------------------------------------------------------------
Testimonials
* ------------------------------------------------------------------------- */
function doTestimonials(){
	var testimonialsCont = jQuery('.testimonials');
	if(testimonialsCont.length < 1){
		return;
	}
testimonialsCont.each(function(){
	var maxHeight = 0, total = 0, dots, circle;
	var testimonials = jQuery(this).children('div');
	testimonials.each(function(){
		maxHeight = jQuery(this).outerHeight() > maxHeight ? jQuery(this).outerHeight() : maxHeight;
	});
	testimonials.css({'position':'absolute', 'display': 'none'});
	if(jQuery(this).parent().hasClass('home_1_sidebar')){
		var gap = 50;
	}else{
		var gap = 30;
	}
	jQuery(this).css({'height': maxHeight + gap + 'px', 'position' : 'relative'});
	testimonials.eq(0).css('display', 'block');
	total = testimonials.length;
	dots = document.createElement('div');
	dots.className = 'dots';
	for(var i = 0; i < total; i++){
		circle = document.createElement('div');
		circle.className = 'circle';
		if(i == 0){
			circle.className += " current";
		}
		dots.appendChild(circle);
	}
	jQuery(this).append(dots);
	dots = jQuery('.dots');
	dots.css({'position': 'absolute', 'right' : 0, 'bottom' : 0});
	doCicleTestimonials(jQuery(this));
});
}

function doCicleTestimonials(testimonialsObj){
	var interval = "6500";//milliseconds
	var currentTestimonial = "0";//always starts at 0
	var testimonials = testimonialsObj.children('.testimonial');
	var dotsCont = testimonialsObj.children('.dots');
	var dots = dotsCont.children('div');
	var theTimeout;
	theTimeout = setTimeout(cicleTestimonials, interval);
	function cicleTestimonials(){
		testimonials.eq(currentTestimonial).fadeOut();
		dots.eq(currentTestimonial).removeClass('current');
		currentTestimonial++;
		if(currentTestimonial == testimonials.length){
			currentTestimonial = 0;
		}
		testimonials.eq(currentTestimonial).fadeIn();
		dots.eq(currentTestimonial).addClass('current');
		theTimeout = setTimeout(cicleTestimonials, interval);
	}
	dots.click(function(){
		clearTimeout(theTimeout);
		testimonials.eq(currentTestimonial).fadeOut();
		dots.eq(currentTestimonial).removeClass('current');
		currentTestimonial = jQuery(this).index();
		testimonials.eq(currentTestimonial).fadeIn();
		jQuery(this).addClass('current');
		theTimeout = setTimeout(cicleTestimonials, interval);
	});
}







/* ------------------------------------------------------------------------
Tabs - Type 1
* ------------------------------------------------------------------------- */
function doTabsType1(){
	var tabs = jQuery('.tabs_type_1');
	if(tabs.length < 1){
		return;
	}
	tabs.append("<span class='tabs_type_1_arrow'></span>");
	tabs.each(function(){
		var handlers = jQuery(this).children('dt');
		var tabContentBlocks = jQuery(this).children('dd');
		var currentTab = jQuery(this).find('dd.current');
		var arrow = jQuery(this).children('span').eq(0);
		var handlersWidth = handlers.eq(0).outerWidth();
		var minus = currentTab.prev().index() == 0 ? 18 : currentTab.prev().outerHeight()/2 + 18;
		var firstHandlerY = currentTab.prev().position().top + currentTab.prev().outerHeight() - minus;
		arrow.css({'left': handlersWidth-18 + 'px', 'top': firstHandlerY + 'px'});

		maybeGrowShrinkTab(currentTab.eq(0).prev());

		handlers.click(function(){
			if(jQuery(this).hasClass('current')) return
			currentTab.prev().removeClass('current');
			currentTab.fadeOut('fast');
			arrow.fadeOut('fast');
			var that = this;
			maybeGrowShrinkTab(this, function(){
				currentTab = jQuery(that).next();
				var minus = jQuery(that).index() == 0 ? 18 : jQuery(that).outerHeight()/2 + 18;
				arrowY = jQuery(that).position().top + jQuery(that).outerHeight() - minus;
				arrow.fadeIn('fast');
				arrow.animate({'top':arrowY + 'px'});
				currentTab.fadeIn('slow');
				jQuery(that).addClass('current');
			});
		});
	});
}

function maybeGrowShrinkTab(tab, callback, add){
	var jTab = (tab.nodeName) ? jQuery(tab) :  tab 
	var tabCont = jTab.next();
	var tabsContainer = jTab.parent();
	var handlers = tabsContainer.children('dt');
	var plus = add || 0;//tabs type 2 need a little added height because the handlers are placed on top.

	tabCont.css('height', 'auto');

	var tabContHeight = tabCont.outerHeight();
	tabContHeight += plus;
	var tabsContainerHeight = tabsContainer.outerHeight();
	var totalHandlersHeight = 0;

	handlers.each(function(){
		totalHandlersHeight += jQuery(this).outerHeight();
	});

	if(tabContHeight != tabsContainerHeight){
		if(tabContHeight > totalHandlersHeight){
			tabsContainer.animate({'height': tabContHeight + 'px'}, function(){
				if(typeof callback != 'undefined') callback()
			});
		}else{
			totalHandlersHeight += 60; //Just give it a lil space so it doesn't look too tight
			tabCont.css('height', totalHandlersHeight + 'px');
			tabsContainer.animate({'height': totalHandlersHeight + 'px'}, function(){
				if(typeof callback != 'undefined') callback()
			});
		}
	}else{
		if(typeof callback != 'undefined') callback()
	}
}










/* ------------------------------------------------------------------------
Tabs - Type 2
* ------------------------------------------------------------------------- */
function doTabsType2(){
	var tabs = jQuery('.tabs_type_2');
	if(tabs.length <  1){
		return;
	}
	tabs.append("<span class='tabs_type_2_arrow'></span>");
	tabs.each(function(){
		var handlers = jQuery(this).children('dt');
		var tabContentBlocks = jQuery(this).children('dd');
		//var currentTab = tabContentBlocks.eq(0);
		var currentTab = jQuery(this).find('dd.current');
		var arrow = jQuery(this).children('span').eq(0);
		var handlersWidth = handlers.eq(0).outerWidth();
		var firstHandlerY = handlers.eq(0).position().top + handlers.eq(0).outerHeight() - 18;
		var firstHandlerX = currentTab.prev().position().left + (currentTab.prev().outerWidth() /2) - 2;
		arrow.css({'left': firstHandlerX + 'px'});

		maybeGrowShrinkTab(currentTab.eq(0).prev(), undefined, 70);

		handlers.click(function(){
			currentTab.prev().removeClass('current');
			currentTab.fadeOut('fast');
			arrow.fadeOut('fast');
			var that = this;
			maybeGrowShrinkTab(this, function(){
				currentTab = jQuery(that).next();
				arrowY = jQuery(that).position().left + (jQuery(that).outerWidth() /2) - 2;
				arrow.fadeIn('fast');
				arrow.animate({'left':arrowY + 'px'});
				currentTab.fadeIn('slow');
				jQuery(that).addClass('current');
			}, 70);
		});
	});
}









/* ------------------------------------------------------------------------
Accordions
* ------------------------------------------------------------------------- */
function doAccordion(){
	var accordions = jQuery('.accordion');
	if(accordions.length < 1){
		return;
	}
	accordions.each(function(){
		var that = jQuery(this);
		var handlers = jQuery(this).children('dt');
		handlers.click(function(){
			that.children('dt.current').removeClass('current').next().slideUp();
			jQuery(this).toggleClass('current');
			jQuery(this).next('dd').slideToggle();
		});
	});
}






/* ------------------------------------------------------------------------
Gallery Image Fade
* ------------------------------------------------------------------------- */
jQuery('.hover-item').live('hover', function(e) {
		if( e.type == 'mouseenter' )
			jQuery(this).stop().animate({opacity:0.3},400);

		if( e.type == 'mouseleave' )
			jQuery(this).stop().animate({opacity:1},400);
	});







/*-----------------------------------------------------------------------------------*/
/*	Select Element - Responsive Navigation
/*-----------------------------------------------------------------------------------*/
jQuery("<select />").appendTo("header nav");

// Create default option "Go to..."
jQuery("<option />", {
   "selected": "selected",
   "value"   : "",
   "text"    : "Select a page:"
}).appendTo("nav select");

// Populate dropdown with menu items
jQuery("nav a").each(function() {
 var el = jQuery(this);
 jQuery("<option />", {
     "value"   : el.attr("href"),
     "text"    : el.text()
 }).appendTo("nav select");
});

jQuery("nav select").change(function() {
  window.location = jQuery(this).find("option:selected").val();
});







/* ------------------------------------------------------------------------
Notification Boxes
* ------------------------------------------------------------------------- */
jQuery(document).ready(function(){

	jQuery('.closeable').closeThis({
		animation: 'fadeAndSlide', 	// set animation
		animationSpeed: 400 		// set animation speed
	});
	
});

(function($)
{
	$.fn.closeThis = function(options)
	{
		var defaults = {
			animation: 'slide',
			animationSpeed: 300
		};
		
		var options = $.extend({}, defaults, options);
		
		return this.each(function()
		{
			var message = $(this);
			
			message.css({cursor: 'pointer'});
			
			message.click(function()
			{
				hideMessage(message);
			});
			
			function hideMessage(object)
			{
				switch(options.animation)
				{
					case 'fade':
						fadeAnimation(object);
						break;
					case 'slide':
						slideAnimation(object);
						break;
					case 'size':
						sizeAnimation(object);
						break;
					case 'fadeThenSlide':
						fadeAndSlideAnimation(object);
						break;
					default:
						fadeAndSlideAnimation(object);
				}
			}
			
			function fadeAnimation(object)
			{
				object.fadeOut(options.animationSpeed);
			}
			
			function slideAnimation(object)
			{
				object.slideUp(options.animationSpeed);
			}
			
			function sizeAnimation(object)
			{
				object.hide(options.animationSpeed);
			}
			
			function fadeAndSlideAnimation(object)
			{
				object.fadeTo(options.animationSpeed, 0, function() { slideAnimation(message) } );
			}
			
		});
	}
})(jQuery);
