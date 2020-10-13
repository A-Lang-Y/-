//////////////////
//Site Preloader//
///////////////////

$(window).load(function() { // makes sure the whole site is loaded
	$("#status").fadeOut(); // will first fade out the loading animation
	$("#preloader").delay(350).fadeOut("slow"); // will fade out the white DIV that covers the website.
})


$(document).ready(function(){
	
	
	//////////////////////
	//////////////////////
	//Touch Enabled Stuf//
	//////////////////////
	//////////////////////
	
	//Tap Dismiss
	
    $(".tap-dismiss").hammer({ 
		drag_max_touches:0,
	})	
	.on("tap", function() {
		$(this).fadeOut(500);
	});
	
	//Double tap dimiss
	
    $(".double-tap-dismiss").hammer({ 
		drag_max_touches:0,
	})	
	.on("doubletap", function() {
		$(this).fadeOut(500);
	});
	
	//Swipe to tick swipe to cross tap to clear
	
	$('.swipe-tick-cross-left').click(function(){return false});
    $(".swipe-tick-cross-left").hammer({ 
		drag_max_touches:0,
	})
	.on("dragleft", function(ev){
		var touches = ev.gesture.touches;
		ev.gesture.preventDefault();
		$(this).css("background-color", "#ffdcdd");
		$(this).find(".swipe-check-box").show();
		$(this).find(".swipe-tick-box").hide();
		$(this).find(".swipe-null-box").hide();
	})
	.on("dragright", function(ev) {
		var touches = ev.gesture.touches;
		ev.gesture.preventDefault();
		$(this).css("background-color", "#e3ffdc");
		$(this).find(".swipe-check-box").hide();
		$(this).find(".swipe-tick-box").show();
		$(this).find(".swipe-null-box").hide();		
	})
	.on("tap", function() {
		$(this).css( "background-color", "#f1f1f1");
		$(this).find(".swipe-check-box").hide();
		$(this).find(".swipe-tick-box").hide();
		$(this).find(".swipe-null-box").show();
	});
	
	//

	$('.swipe-tick-cross-right').click(function(){return false});
    $(".swipe-tick-cross-right").hammer({ 
		drag_max_touches:0,
	})
	.on("dragright", function(ev){
		var touches = ev.gesture.touches;
		ev.gesture.preventDefault();
		$(this).css("background-color", "#ffdcdd");
		$(this).find(".swipe-check-box").show();
		$(this).find(".swipe-tick-box").hide();
		$(this).find(".swipe-null-box").hide();
	})
	.on("dragleft", function(ev) {
		var touches = ev.gesture.touches;
		ev.gesture.preventDefault();
		$(this).css("background-color", "#e3ffdc");
		$(this).find(".swipe-check-box").hide();
		$(this).find(".swipe-tick-box").show();
		$(this).find(".swipe-null-box").hide();		
	})
	.on("tap", function() {
		$(this).css( "background-color", "#f1f1f1");
		$(this).find(".swipe-check-box").hide();
		$(this).find(".swipe-tick-box").hide();
		$(this).find(".swipe-null-box").show();
	});

	
	//Swipe Left Dismiss Right Dismiss

	
	$('.swipe-left-notification').click(function(){return false});
    $(".swipe-left-notification").hammer({ 
		drag_max_touches:0,
	})
	.on("dragleft", function(ev){
		var touches = ev.gesture.touches;
		ev.gesture.preventDefault();
		$(this).find('.swipe-button').css( "width", "20%" ).css( "display", "block");
		$(this).parent().find('.swipe-left-notification a').css( "width", "75%" );
	})
	.on("dragright", function(ev) {
		var touches = ev.gesture.touches;
		ev.gesture.preventDefault();
		$(this).find('.swipe-button').css( "width", "0%" ).css( "display", "none");
		$(this).parent().find('.swipe-left-notification a').css( "width", "100%" );
	})

	.on("touch", function() {
		$(this).css( "background-color", "#eaeaea");
	})
	
	.on("release", function() {
		$(this).css( "background-color", "#f1f1f1");
	});
	
	//
	
	$('.swipe-right-notification').click(function(){return false});
    $(".swipe-right-notification").hammer({ 
		drag_max_touches:0,
	})
	.on("dragright", function(ev){
		var touches = ev.gesture.touches;
		ev.gesture.preventDefault();
		$(this).find('.swipe-button').css( "width", "20%" ).css( "display", "block");
		$(this).parent().find('.swipe-right-notification a').css( "width", "75%" );
	})
	.on("dragleft", function(ev) {
		var touches = ev.gesture.touches;
		ev.gesture.preventDefault();
		$(this).find('.swipe-button').css( "width", "0%" ).css( "display", "none");
		$(this).parent().find('.swipe-right-notification a').css( "width", "100%" );
	})

	.on("touch", function() {
		$(this).css( "background-color", "#eaeaea");
	})
	
	.on("release", function() {
		$(this).css( "background-color", "#f1f1f1");
	});

	
	$('.swipe-button').click(function(){
		$(this).parent().parent().fadeOut(200);
		return false;
	});
	


	
	////////////////////////////////////////
	////////////////////////////////////////
	//Subscribe Form Deploy//
	////////////////////////////////////////
	////////////////////////////////////////
	
	$('.subscribe').click(function(){
		$('#modal-hider').fadeIn();
		$('#modal-body').fadeIn();	
		document.ontouchmove = function(event){ event.preventDefault();}
		$('body,html').animate({scrollTop:0},500);
		return false;		
	});
	
	////////////////////////////////////////
	////////////////////////////////////////
	/*Page Coach Arrows Showere*/
	////////////////////////////////////////
	////////////////////////////////////////	
	
	$('.enable-coach').click(function(){
		$(this).addClass('active-nav');
		$('.page-coach').fadeIn(200);
		document.ontouchmove = function(event){ event.preventDefault();}
	});
	
	$('.page-coach').click(function(){
		$('.enable-coach').removeClass('active-nav');
		$('.page-coach').fadeOut(200);
		document.ontouchmove = function(event){ event.allowDefault();}
	});

	////////////////////////////////////////
	////////////////////////////////////////
	/*Big White notifications */
	////////////////////////////////////////
	////////////////////////////////////////
	
	$('.white-notification a em').click(function(){
		$(this).parent().parent().parent().hide(200);
		return false;
	});
	
	$('.white-notification').click(function(){
		return false;
	});
	
	////////////////////////////////////////
	////////////////////////////////////////
	/*Go back to top button*/
	////////////////////////////////////////
	////////////////////////////////////////	
	
	$('.go-up').click(function() {
		$('body,html').animate({scrollTop:0},500);
		return false;
	});
	
	
	////////////////////////////////////////
	////////////////////////////////////////
	/* Extended Content*/
	////////////////////////////////////////
	////////////////////////////////////////
	
	$('.show-extended-content').click(function(){
		$(this).parent().find('.extended-content').fadeToggle('medium', 'easeInOutExpo');
		return false;
	});

	
	////////////////////////////////////////
	////////////////////////////////////////
	/*Dropdown Menu*/
	////////////////////////////////////////
	////////////////////////////////////////
		
	$('.dropdown-hidden').hide();
	$('.dropdown-item').hide();

	$('.dropdown-deploy').click(function(){
		$(this).parent().parent().find('.dropdown-item').show(200);
		$(this).parent().parent().find('.dropdown-hidden').show();
		$(this).hide();
		return false;
	});
	
	$('.dropdown-hidden').click(function(){
		$(this).parent().parent().find('.dropdown-item').hide(200);
		$(this).parent().parent().find('.dropdown-deploy').show();
		$(this).parent().parent().find(this).hide();
		return false;		
	});
	
	////////////////////////////////////////
	////////////////////////////////////////
	/*Sliding Door for phone number*/
	////////////////////////////////////////
	////////////////////////////////////////
	
	$('.sliding-door-top').click(function(){
		$(this).animate({
			left:'101%'
		}, 500, 'easeInOutExpo');
		return false;
	});
	
	$('.sliding-door-bottom a em').click(function(){
		$(this).parent().parent().parent().find('.sliding-door-top').animate({
			left:'0px'
		}, 500, 'easeOutBounce');
		return false
		
	});
	
	//////////////////////////
	//Image Gallery Colorbox//
	//////////////////////////	
	$("#gallery-filtralbe li a").colorbox({
	 	transition:"fade",
		scalePhotos:"true",
		maxWidth:"100%",
		maxHeight:"100%",
		arrowKey:"false"
	});
	
	$(".portfolio-item-full-width a").colorbox({
	 	transition:"fade",
		scalePhotos:"true",
		maxWidth:"100%",
		maxHeight:"100%"
	});
	
	$(".portfolio-item-thumb a").colorbox({
	 	transition:"fade",
		scalePhotos:"true",
		maxWidth:"100%",
		maxHeight:"100%"
	});

	/////////////////////////////////////////////////////////////////////////////
	//Detect if iOS WebApp Engaged and permit navigation without deploying Safari
	/////////////////////////////////////////////////////////////////////////////
	(function(a,b,c){if(c in b&&b[c]){var d,e=a.location,f=/^(a|html)$/i;a.addEventListener("click",function(a){d=a.target;while(!f.test(d.nodeName))d=d.parentNode;"href"in d&&(d.href.indexOf("http")||~d.href.indexOf(e.host))&&(a.preventDefault(),e.href=d.href)},!1)}})(document,window.navigator,"standalone")


	/////////////////////////////////////////////////////////////////////////////////////////////
	//Detect user agent for known mobile devices and show hide elements for each specific element
	/////////////////////////////////////////////////////////////////////////////////////////////
	
	var isiPhone = 		navigator.userAgent.toLowerCase().indexOf("iphone");
	var isiPad = 		navigator.userAgent.toLowerCase().indexOf("ipad");
	var isiPod = 		navigator.userAgent.toLowerCase().indexOf("ipod");
	var isiAndroid = 	navigator.userAgent.toLowerCase().indexOf("android");
	
	if(isiPhone > -1) 	 {		 $('.ipod-detected').hide();		 $('.ipad-detected').hide();		 $('.iphone-detected').show();		 $('.android-detected').hide();	 }
	if(isiPad > -1)	 {		 	 $('.ipod-detected').hide();		 $('.ipad-detected').show();		 $('.iphone-detected').hide();		 $('.android-detected').hide();	 }
	if(isiPod > -1)	 {		 	 $('.ipod-detected').show();		 $('.ipad-detected').hide();		 $('.iphone-detected').hide();		 $('.android-detected').hide();	 }   
	if(isiAndroid > -1) {		 $('.ipod-detected').hide();		 $('.ipad-detected').hide();		 $('.iphone-detected').hide();		 $('.android-detected').show();	 }  

	
	////////////////////////////////////////
	////////////////////////////////////////
	// Creating a cookie for the modal form! 
	////////////////////////////////////////
	////////////////////////////////////////
	
	function createCookie(name,value,days) {
		if (days) {
			var date = new Date();
			date.setTime(date.getTime()+(days*24*60*60*1000));
			var expires = "; expires="+date.toGMTString();
		}
		else var expires = "";
		document.cookie = name+"="+value+expires+"; path=/";
	}
	
	function readCookie(name) {
		var nameEQ = name + "=";
		var ca = document.cookie.split(';');
		for(var i=0;i < ca.length;i++) {
			var c = ca[i];
			while (c.charAt(0)==' ') c = c.substring(1,c.length);
			if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
		}
		return null;
	}
	
	function eraseCookie(name) {	createCookie(name,"",-1);	}
	
	var webappStatus = readCookie('webappIsClosed');

	////////////////////////////////////////
	////////////////////////////////////////
	/*Show and Close WebApp*/	
	////////////////////////////////////////
	////////////////////////////////////////
		
	$('.delete-cookie').click(function(){
		eraseCookie('webappIsClosed');
		return false;
	});
	
	if(window.navigator.standalone==true){	$('.webapp').hide();	}
	
		
	$('.close-webapp').click(function(){
		createCookie('webappIsClosed', 'true' , 7);
		$('.webapp').animate({
			bottom: '-100',
		}, 500, function() {
			$('.webapp').hide();
		});
	});	
	
	if(isiPhone > -1){
		$('.webapp').delay(1000).animate({
			bottom: '0',
		}, 500, function(){});		
	};

	if(webappStatus == 'true'){
		$('.webapp').hide();	
	};



	/////////////////////////////
	//Checkboxes and radio boxes! 
	/////////////////////////////
	
	$('.checkbox-v1').click(function(){		$(this).toggleClass('checked-v1');		return false;	});	
	$('.checkbox-v2').click(function(){		$(this).toggleClass('checked-v2');		return false;	});
	$('.checkbox-v3').click(function(){		$(this).toggleClass('checked-v3');		return false;	});
	$('.checkbox-v4').click(function(){		$(this).toggleClass('checked-v4');		return false;	});
	$('.radio-v1').click(function(){		$(this).toggleClass('balled-v1');		return false;	});
	$('.radio-v2').click(function(){		$(this).toggleClass('balled-v2');		return false;	});

	///////////////////////
	//Notification boxes!//
	///////////////////////
	$(".close-notification").click(function(){	$(this).parent().hide(150);		return false;	});
	$(".small-notification a").click(function(){$(this).parent().hide(150);		return false;	});

	////////////////////
	//Toggle Function!//
	/////////////////////
	$('.show-toggle-v1').hide();
	$('.toggle-content-v1').hide();
	$('.show-toggle-v1').click(function(){$(this).hide();		$(this).parent().find('.hide-toggle-v1').show();	$(this).parent().find('.toggle-content-v1').fadeOut(100); return false;	});
	$('.hide-toggle-v1').click(function(){$(this).parent().find('.show-toggle-v1').show();		$(this).hide();		$(this).parent().find('.toggle-content-v1').fadeIn(200); return false;	});		

	$('.show-toggle-v2').hide();
	$('.toggle-content-v2').hide();
	$('.show-toggle-v2').click(function(){$(this).hide();		$(this).parent().find('.hide-toggle-v2').show();		$(this).parent().find('.toggle-content-v2').fadeOut(100); return false;	});
	$('.hide-toggle-v2').click(function(){$(this).parent().find('.show-toggle-v2').show();			$(this).hide();		$(this).parent().find('.toggle-content-v2').fadeIn(200); return false;	});		

	$('.show-toggle-v3').hide();
	$('.toggle-content-v3').hide();
	$('.show-toggle-v3').click(function(){$(this).hide();		$(this).parent().find('.hide-toggle-v3').show();		$(this).parent().find('.toggle-content-v3').fadeOut(100); return false;	});
	$('.hide-toggle-v3').click(function(){$(this).parent().find('.show-toggle-v3').show();			$(this).hide();		$(this).parent().find('.toggle-content-v3').fadeIn(200); return false;	});	

	$('.show-toggle-v4').hide();
	$('.toggle-content-v4').hide();
	$('.show-toggle-v4').click(function(){$(this).hide();		$(this).parent().find('.hide-toggle-v4').show();		$(this).parent().find('.toggle-content-v4').fadeOut(100); return false;	});
	$('.hide-toggle-v4').click(function(){$(this).parent().find('.show-toggle-v4').show();			$(this).hide();		$(this).parent().find('.toggle-content-v4').fadeIn(200); return false;	});	

	$('.show-toggle-v5').hide();
	$('.toggle-content-v5').hide();
	$('.show-toggle-v5').click(function(){$(this).hide();		$(this).parent().find('.hide-toggle-v5').show();		$(this).parent().find('.toggle-content-v5').fadeOut(100); return false;	});
	$('.hide-toggle-v5').click(function(){$(this).parent().find('.show-toggle-v5').show();			$(this).hide();		$(this).parent().find('.toggle-content-v5').fadeIn(200); return false;	});	

	////////////////////////////
	//Top Header Notifications//
	////////////////////////////
	$('.header-notification strong').click(function() {
	  $(this).parent().animate({
		height: '0px'
	  }, 350, function() {
	  });
	  return false;
	});
	
	///////
	//Tab//
	///////
	$('#tab').tabify();
	
	/////////////////////
	//Filtrable Gallery//
	/////////////////////

	$('#filter-all').click(function(){
		$('.filter-one, .filter-two, .filter-three, .filter-four, .filter-five, .filter-six').fadeTo("fast", 1);
		return false;
	});
	
	$('#filter-one').click(function(){
		$('.filter-one, .filter-two, .filter-three, .filter-four, .filter-five, .filter-six').fadeTo("fast", 1);	
		$('.filter-two, .filter-three, .filter-four, .filter-five, .filter-six').fadeTo("fast", 0.4);	
		return false;
	});
	
	$('#filter-two').click(function(){
		$('.filter-one, .filter-two, .filter-three, .filter-four, .filter-five, .filter-six').fadeTo("fast", 1);	
		$('.filter-one, .filter-three, .filter-four, .filter-five, .filter-six').fadeTo("fast", 0.4);	
		return false;
	});
	
	$('#filter-three').click(function(){
		$('.filter-one, .filter-two, .filter-three, .filter-four, .filter-five, .filter-six').fadeTo("fast", 1);	
		$('.filter-one, .filter-two, .filter-four, .filter-five, .filter-six').fadeTo("fast", 0.4);	
		return false;
	});
	
	$('#filter-four').click(function(){
		$('.filter-one, .filter-two, .filter-three, .filter-four, .filter-five, .filter-six').fadeTo("fast", 1);	
		$('.filter-one, .filter-two, .filter-three, .filter-five, .filter-six').fadeTo("fast", 0.4);	
		return false;
	});
	
	$('#filter-five').click(function(){
		$('.filter-one, .filter-two, .filter-three, .filter-four, .filter-five, .filter-six').fadeTo("fast", 1);	
		$('.filter-one, .filter-two, .filter-three, .filter-four, .filter-six').fadeTo("fast", 0.4);	
		return false;
	});
	
	$('#filter-six').click(function(){
		$('.filter-one, .filter-two, .filter-three, .filter-four, .filter-five, .filter-six').fadeTo("fast", 1);	
		$('.filter-one, .filter-two, .filter-three, .filter-four, .filter-five').fadeTo("fast", 0.4);
		return false;	
	});
	

	
	/////////////////
	//Image Gallery//
	/////////////////
	$(".swipebox").swipebox({
		useCSS : true, // false will force the use of jQuery for animations
		hideBarsDelay : 3000 // 0 to always show caption and action bar
	});
		
});

(function (a) {
    a.fn.extend({
        tabify: function (e) {
            function c(b) {
                hash = a(b).find("a").attr("href");
                return hash = hash.substring(0, hash.length - 4)
            }
            function f(b) {
                a(b).addClass("active");
                a(c(b)).show();
                a(b).siblings("li").each(function () {
                    a(this).removeClass("active");
                    a(c(this)).hide()
                })
            }
            return this.each(function () {
                function b() {
                    location.hash && a(d).find("a[href=" + location.hash + "]").length > 0 && f(a(d).find("a[href=" + location.hash + "]").parent())
                }
                var d = this,
                    g = {
                        ul: a(d)
                    };
                a(this).find("li a").each(function () {
                    a(this).attr("href", a(this).attr("href") + "-tab")
                });
                location.hash && b();
                setInterval(b, 100);
                a(this).find("li").each(function () {
                    a(this).hasClass("active") ? a(c(this)).show() : a(c(this)).hide()
                });
                e && e(g)
            })
        }
    })
})(jQuery);

