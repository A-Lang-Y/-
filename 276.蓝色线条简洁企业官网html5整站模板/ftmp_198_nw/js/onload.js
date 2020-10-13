$(document).ready(function(){
	
	
	/* = Add arrow to current menu item
	-------------------------------------------------------------- */

	$(function() {
		$('#top_menu .current-menu-item').append('<span class="arrow"></span>');
	});
	
	
	
	/* = Add arrow to buttons
	-------------------------------------------------------------- */
	
	$(function() {
	
		$('button.arrow').each(function() {
			$(this).append('<span></span>');
		});
	
	});



	/* = Pretty Photo
	-------------------------------------------------------------- */

	if ( $("a[rel^='prettyPhoto']").length > 0 ) $("a[rel^='prettyPhoto']").prettyPhoto();




	/* = Big Photo in Portfolio - show only first
	-------------------------------------------------------------- */
	
	$('.portfolio .photo-big a').hide().eq(0).show();
	


	/* = Accordion
	-------------------------------------------------------------- */

	$(function() {
	
		// Open active
		if ( $('.accordion').length > 0 ) {
		
			$('.accordion').each(function() {
			
				if ( $('.title', this).hasClass('active') ) {
				
					$('.title', this).
						next('.content').
						slideToggle('fast');
				}

			});
		
		}

		$('.accordion .title').click(function() {
		
			if ( $(this).hasClass('active') ) {
				
				toggle(this);

			} else {

				$('.accordion').each(function() {
				
					if ( $('.title', this).hasClass('active') )
					
						$('.title', this).
							removeClass('active').
							next('.content').
							slideToggle('fast');
				
				});

				toggle(this);
			}

		});
		
		function toggle(arg) {
			$(arg).
					toggleClass('active').
					next('.content').
					slideToggle('fast');
		}
	
	})



	/* = Find reply comment and remove first HR
	-------------------------------------------------------------- */
	
	$(function() {
	
		$('.comments > ul > li').each(function() {
		
			submenu = $(this).find('ul');
			
			if (submenu.length >0) {
				
				$('.post:eq(0)', this).css({ background: 'none' });
				
			}
		
		});
	
	});



	/* = Tabs
	-------------------------------------------------------------- */	
	
	$(function() {

		var index = 0;

		showTab(index);

		function showTab() {

			$('.tabs nav li').removeClass('current');
			$('.tabs nav li').eq(index).addClass('current');

			$('.tabs article').hide();
			$('.tabs article').eq(index).show();

		}

		$('.tabs nav li').click(function() {

			index = $(this).index();

			showTab();

		});
	
	})
	
	

	/* = Nav drop down
	-------------------------------------------------------------- */	

	$(function() {
	
		var submenu = false;

		$("#titlebar ul#top_menu > li").mouseenter(function() {
	
			if ( $(this).find('ul:first').length > 0 ) {
	
				$(this).append('<span class="arrow-menu"></span>');
				$(this).find("ul").fadeIn('fast').addClass("on");
				$(this).addClass("on");
				
				if ( $(this).hasClass('current-menu-item') ) {
					submenu = true;
					$(this).removeClass('current-menu-item');
					$(this).css({ fontWeight: 'bold' });
				}

				$("li", this).live({
					mouseenter:
						function() {
							if ( $(this).index() == 0 )	$('ul#top_menu').find('.arrow-menu').addClass('blue');
						},
					mouseleave:
						function() {
							$('ul#top_menu').find('.arrow-menu').removeClass('blue');
						}
					});
			}
	
	    }).mouseleave(function(){
	
			$(this).find('.arrow-menu').remove();
			$(this).find("ul").fadeOut('fast');
			$(this).removeClass("on");
			
			if (submenu == true) {
				submenu = false;
				$(this).addClass('current-menu-item');
			}
			
	    });

	})



	// Top Slider

	function topSlider() {
		var slOnStart		= 0;
		var currentShow		= slOnStart;
		var slLen			= $('#slider .slider_photos li').length;
		
		var ivSLShow;
		
		function setStart() {
			$('#slider li div.inside').hide();
			$('#slider .progressbar').show();
			$('#slider nav.arrows').show();
			showSlide(slOnStart);
		}

		function showSlide(nr) {
			progressbar();
			$('#slider .slider_photos li div.inside').fadeOut('slow');
			$('#slider .slider_photos li:eq('+nr+') div.inside').fadeIn('slow');
		}

		function showNextSlide() {
			clearInterval (ivSLShow);

			ivSLShow = setInterval (function (){
			   showNextSlide ();
			}, 3000);

			currentShow = currentShow + 1;
			if (currentShow == slLen) {
			   currentShow = 0;
			}
			showSlide (currentShow);
		}

		function slideShowOnStart (nr) {
			setStart();
			ivSLShow = setInterval (function (){
				showNextSlide ();

			}, 3000);
		}

		function progressbar() {
			$('#slider .progressbar .bar').css({ width: 0 }).stop().animate({
				width: '100%'
			}, {
				duration: 3000,
					specialEasing: {
					width: 'linear',
					queue: false
				}
			});
		}

		$('#slider .arrows a.next').click(function() {
			clearInterval (ivSLShow);
			currentShow = currentShow + 1;
			if (currentShow == slLen) {
			   currentShow = 0;
			}
			showSlide (currentShow);
		})
		
		$('#slider .arrows a.prev').click(function() {
			clearInterval (ivSLShow);
			currentShow = currentShow - 1;
			if (currentShow < 0) {
			   currentShow = slLen-1;
			}
			showSlide (currentShow);
		})


		$(window).bind ('blur', function() {
			clearInterval (ivSLShow);
		});

		$(window).bind ('focus', function() {
			clearInterval (ivSLShow);
		   
			if ( slLen > 1 ) {
				ivSLShow = setInterval (function (){
					showNextSlide ();
				}, 4000);
			}
		});

		if ( slLen > 1 ) {
			slideShowOnStart(slOnStart);
		}
	}



	/* = Portfolio slider
	-------------------------------------------------------------- */

	function portfolioSlider() {

		var itemWidth = 255;

		items = $('#slider_portfolio ul li').length;
		
		if ( items > 4 ) $('.home_portfolio nav').show();
	
		var itemNumber = 0;

		window.nextItem = function() {
			if (itemNumber == ( items-4 )) {
				return false;
			}
			itemNumber = itemNumber + 1;		
			var containerPosition = -(itemWidth * itemNumber);
			$('#slider_portfolio ul').animate({left: containerPosition}, 250);
		}

		window.prevItem = function() {
			if (itemNumber == 0) {
				return false;
			}
			itemNumber = itemNumber - 1;
			var containerPosition = -(itemWidth * itemNumber);
			$('#slider_portfolio ul').animate({left: containerPosition}, 250);
		}
		
		$('.home_portfolio .arrows a.next').click(function() {
			nextItem();
		})
		
		$('.home_portfolio .arrows a.prev').click(function() {
			prevItem();
		})

	};



	// Scroll Top

	$('a.top').click(function() {
		$.scrollTo( 0, 3000, { easing: 'easeOutCubic', queue:true } );	
	});




	/* = Start sliders
	-------------------------------------------------------------- */

	if ( $('body').hasClass('home') ) {
		topSlider();
	}

	if ( $('.home_portfolio').length > 0 ) {
		portfolioSlider();
	}



	/* = Contact Form
	-------------------------------------------------------------- */

	$('#contact button[type="submit"]').click(function() {

		$('#contact .req').removeClass('error');

		$('#contact .button').fadeOut('fast');

		$('#contact #submit').attr("disabled", "disabled");

		var isFocus=0;
		var isError=0;

		// Get the data from the form
		var name	= $('#contact #name').val();
		var email	= $('#contact #email').val();
		var subject	= $('#contact #subject').val();
		var message	= $('#contact #message').val();


		// Validate the data
		$('#contact .req').each(function() {
		
			if ( $(this).val() == '' ) {
				$(this).addClass('error');
				isError=1;
			}

		});

		var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
		if (reg.test(email)==false) {
			$('#contact #email').addClass('error');
			isError=1;
		}

		// Terminate the script if an error is found
		if (isError==1) {
			$('#contact .button').fadeIn('fast');
			return false;
		}

		$.ajaxSetup ({
			cache: false
		});
		
		var dataString = 'name='+ name + '&email=' + email + '&subject=' + subject + '&message=' + message;  
		
		$.ajax({
			type: "POST",
			url: "php/submit-form-ajax.php",
			data: dataString,
			success: function(msg) {
				
				// Check to see if the mail was successfully sent
				if (msg=='Mail sent') {
					$("#contact fieldset.thanks").show();
					$("#contact fieldset.form").hide();
	
				} else {
					$('#contact .button').fadeIn('fast');
					alert('The problem with sending it, please try again!');
				}
				
			},

			error: function(ob,errStr) {
				alert('The problem with sending it, please try again.');
				
			}
		});

		return false;
	});
	


});





/*
 * $ Easing v1.3 - http://gsgd.co.uk/sandbox/$/easing/
 *
 * Uses the built in easing capabilities added In $ 1.1
 * to offer multiple easing options
*/

$.easing["jswing"]=$.easing["swing"];$.extend($.easing,{def:"easeOutQuad",swing:function(a,b,c,d,e){return $.easing[$.easing.def](a,b,c,d,e)},easeInQuad:function(a,b,c,d,e){return d*(b/=e)*b+c},easeOutQuad:function(a,b,c,d,e){return-d*(b/=e)*(b-2)+c},easeInOutQuad:function(a,b,c,d,e){if((b/=e/2)<1)return d/2*b*b+c;return-d/2*(--b*(b-2)-1)+c},easeInCubic:function(a,b,c,d,e){return d*(b/=e)*b*b+c},easeOutCubic:function(a,b,c,d,e){return d*((b=b/e-1)*b*b+1)+c},easeInOutCubic:function(a,b,c,d,e){if((b/=e/2)<1)return d/2*b*b*b+c;return d/2*((b-=2)*b*b+2)+c},easeInQuart:function(a,b,c,d,e){return d*(b/=e)*b*b*b+c},easeOutQuart:function(a,b,c,d,e){return-d*((b=b/e-1)*b*b*b-1)+c},easeInOutQuart:function(a,b,c,d,e){if((b/=e/2)<1)return d/2*b*b*b*b+c;return-d/2*((b-=2)*b*b*b-2)+c},easeInQuint:function(a,b,c,d,e){return d*(b/=e)*b*b*b*b+c},easeOutQuint:function(a,b,c,d,e){return d*((b=b/e-1)*b*b*b*b+1)+c},easeInOutQuint:function(a,b,c,d,e){if((b/=e/2)<1)return d/2*b*b*b*b*b+c;return d/2*((b-=2)*b*b*b*b+2)+c},easeInSine:function(a,b,c,d,e){return-d*Math.cos(b/e*(Math.PI/2))+d+c},easeOutSine:function(a,b,c,d,e){return d*Math.sin(b/e*(Math.PI/2))+c},easeInOutSine:function(a,b,c,d,e){return-d/2*(Math.cos(Math.PI*b/e)-1)+c},easeInExpo:function(a,b,c,d,e){return b==0?c:d*Math.pow(2,10*(b/e-1))+c},easeOutExpo:function(a,b,c,d,e){return b==e?c+d:d*(-Math.pow(2,-10*b/e)+1)+c},easeInOutExpo:function(a,b,c,d,e){if(b==0)return c;if(b==e)return c+d;if((b/=e/2)<1)return d/2*Math.pow(2,10*(b-1))+c;return d/2*(-Math.pow(2,-10*--b)+2)+c},easeInCirc:function(a,b,c,d,e){return-d*(Math.sqrt(1-(b/=e)*b)-1)+c},easeOutCirc:function(a,b,c,d,e){return d*Math.sqrt(1-(b=b/e-1)*b)+c},easeInOutCirc:function(a,b,c,d,e){if((b/=e/2)<1)return-d/2*(Math.sqrt(1-b*b)-1)+c;return d/2*(Math.sqrt(1-(b-=2)*b)+1)+c},easeInElastic:function(a,b,c,d,e){var f=1.70158;var g=0;var h=d;if(b==0)return c;if((b/=e)==1)return c+d;if(!g)g=e*.3;if(h<Math.abs(d)){h=d;var f=g/4}else var f=g/(2*Math.PI)*Math.asin(d/h);return-(h*Math.pow(2,10*(b-=1))*Math.sin((b*e-f)*2*Math.PI/g))+c},easeOutElastic:function(a,b,c,d,e){var f=1.70158;var g=0;var h=d;if(b==0)return c;if((b/=e)==1)return c+d;if(!g)g=e*.3;if(h<Math.abs(d)){h=d;var f=g/4}else var f=g/(2*Math.PI)*Math.asin(d/h);return h*Math.pow(2,-10*b)*Math.sin((b*e-f)*2*Math.PI/g)+d+c},easeInOutElastic:function(a,b,c,d,e){var f=1.70158;var g=0;var h=d;if(b==0)return c;if((b/=e/2)==2)return c+d;if(!g)g=e*.3*1.5;if(h<Math.abs(d)){h=d;var f=g/4}else var f=g/(2*Math.PI)*Math.asin(d/h);if(b<1)return-.5*h*Math.pow(2,10*(b-=1))*Math.sin((b*e-f)*2*Math.PI/g)+c;return h*Math.pow(2,-10*(b-=1))*Math.sin((b*e-f)*2*Math.PI/g)*.5+d+c},easeInBack:function(a,b,c,d,e,f){if(f==undefined)f=1.70158;return d*(b/=e)*b*((f+1)*b-f)+c},easeOutBack:function(a,b,c,d,e,f){if(f==undefined)f=1.70158;return d*((b=b/e-1)*b*((f+1)*b+f)+1)+c},easeInOutBack:function(a,b,c,d,e,f){if(f==undefined)f=1.70158;if((b/=e/2)<1)return d/2*b*b*(((f*=1.525)+1)*b-f)+c;return d/2*((b-=2)*b*(((f*=1.525)+1)*b+f)+2)+c},easeInBounce:function(a,b,c,d,e){return d-$.easing.easeOutBounce(a,e-b,0,d,e)+c},easeOutBounce:function(a,b,c,d,e){if((b/=e)<1/2.75){return d*7.5625*b*b+c}else if(b<2/2.75){return d*(7.5625*(b-=1.5/2.75)*b+.75)+c}else if(b<2.5/2.75){return d*(7.5625*(b-=2.25/2.75)*b+.9375)+c}else{return d*(7.5625*(b-=2.625/2.75)*b+.984375)+c}},easeInOutBounce:function(a,b,c,d,e){if(b<e/2)return $.easing.easeInBounce(a,b*2,0,d,e)*.5+c;return $.easing.easeOutBounce(a,b*2-e,0,d,e)*.5+d*.5+c}})


/**
 * $.ScrollTo - Easy element scrolling using $.
 * Copyright (c) 2007-2009 Ariel Flesler - aflesler(at)gmail(dot)com | http://flesler.blogspot.com
 * Dual licensed under MIT and GPL.
 * Date: 5/25/2009
 * @author Ariel Flesler
 * @version 1.4.2
 *
 * http://flesler.blogspot.com/2007/10/$scrollto.html
 */
;(function(d){var k=d.scrollTo=function(a,i,e){d(window).scrollTo(a,i,e)};k.defaults={axis:'xy',duration:parseFloat(d.fn.$)>=1.3?0:1};k.window=function(a){return d(window)._scrollable()};d.fn._scrollable=function(){return this.map(function(){var a=this,i=!a.nodeName||d.inArray(a.nodeName.toLowerCase(),['iframe','#document','html','body'])!=-1;if(!i)return a;var e=(a.contentWindow||a).document||a.ownerDocument||a;return d.browser.safari||e.compatMode=='BackCompat'?e.body:e.documentElement})};d.fn.scrollTo=function(n,j,b){if(typeof j=='object'){b=j;j=0}if(typeof b=='function')b={onAfter:b};if(n=='max')n=9e9;b=d.extend({},k.defaults,b);j=j||b.speed||b.duration;b.queue=b.queue&&b.axis.length>1;if(b.queue)j/=2;b.offset=p(b.offset);b.over=p(b.over);return this._scrollable().each(function(){var q=this,r=d(q),f=n,s,g={},u=r.is('html,body');switch(typeof f){case'number':case'string':if(/^([+-]=)?\d+(\.\d+)?(px|%)?$/.test(f)){f=p(f);break}f=d(f,this);case'object':if(f.is||f.style)s=(f=d(f)).offset()}d.each(b.axis.split(''),function(a,i){var e=i=='x'?'Left':'Top',h=e.toLowerCase(),c='scroll'+e,l=q[c],m=k.max(q,i);if(s){g[c]=s[h]+(u?0:l-r.offset()[h]);if(b.margin){g[c]-=parseInt(f.css('margin'+e))||0;g[c]-=parseInt(f.css('border'+e+'Width'))||0}g[c]+=b.offset[h]||0;if(b.over[h])g[c]+=f[i=='x'?'width':'height']()*b.over[h]}else{var o=f[h];g[c]=o.slice&&o.slice(-1)=='%'?parseFloat(o)/100*m:o}if(/^\d+$/.test(g[c]))g[c]=g[c]<=0?0:Math.min(g[c],m);if(!a&&b.queue){if(l!=g[c])t(b.onAfterFirst);delete g[c]}});t(b.onAfter);function t(a){r.animate(g,j,b.easing,a&&function(){a.call(this,n,b)})}}).end()};k.max=function(a,i){var e=i=='x'?'Width':'Height',h='scroll'+e;if(!d(a).is('html,body'))return a[h]-d(a)[e.toLowerCase()]();var c='client'+e,l=a.ownerDocument.documentElement,m=a.ownerDocument.body;return Math.max(l[h],m[h])-Math.min(l[c],m[c])};function p(a){return typeof a=='object'?a:{top:a,left:a}}})($);

