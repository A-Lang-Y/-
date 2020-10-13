if($.browser.mozilla||$.browser.opera ){document.removeEventListener("DOMContentLoaded",jQuery.ready,false);document.addEventListener("DOMContentLoaded",function(){jQuery.ready()},false)}
jQuery.event.remove( window, "load", jQuery.ready );
jQuery.event.add( window, "load", function(){jQuery.ready();} );
jQuery.extend({
	includeStates:{},
	include:function(url,callback,dependency){
		if ( typeof callback!='function'&&!dependency){
			dependency = callback;
			callback = null;
		}
		url = url.replace('\n', '');
		jQuery.includeStates[url] = false;
		var script = document.createElement('script');
		script.type = 'text/javascript';
		script.onload = function () {
			jQuery.includeStates[url] = true;
			if ( callback )
				callback.call(script);
		};
		script.onreadystatechange = function () {
			if ( this.readyState != "complete" && this.readyState != "loaded" ) return;
			jQuery.includeStates[url] = true;
			if ( callback )
				callback.call(script);
		};
		script.src = url;
		if ( dependency ) {
			if ( dependency.constructor != Array )
				dependency = [dependency];
			setTimeout(function(){
				var valid = true;
				$.each(dependency, function(k, v){
					if (! v() ) {
						valid = false;
						return false;
					}
				})
				if ( valid )
					document.getElementsByTagName('body')[0].appendChild(script);
				else
					setTimeout(arguments.callee, 10);
			}, 10);
		}
		else
			document.getElementsByTagName('body')[0].appendChild(script);
		return function(){
			return jQuery.includeStates[url];
		}
	},

	readyOld: jQuery.ready,
	ready: function () {
		if (jQuery.isReady) return;
		imReady = true;
		$.each(jQuery.includeStates, function(url, state) {
			if (! state)
				return imReady = false;
		});
		if (imReady) {
			jQuery.readyOld.apply(jQuery, arguments);
		} else {
			setTimeout(arguments.callee, 10);
		}
	}
});

var cssFix = function() {
    var u = navigator.userAgent.toLowerCase(),
    addClass = function(el,val){
        if(!el.className) {
            el.className = val;
        } else {
            var newCl = el.className;
            newCl+=(" "+val);
            el.className = newCl;
        }
    },
    is = function(t){
        return (u.indexOf(t)!=-1)
        };
    addClass(document.getElementsByTagName('html')[0],[
        (!(/opera|webtv/i.test(u))&&/msie (\d)/.test(u))?('ie ie'+RegExp.$1)
        :is('firefox/2')?'gecko ff2'
        :is('firefox/3')?'gecko ff3'
        :is('gecko/')?'gecko'
        :is('opera/9')?'opera opera9':/opera (\d)/.test(u)?'opera opera'+RegExp.$1
        :is('konqueror')?'konqueror'
        :is('safari/')?'webkit safari'
        :is('mozilla/')?'gecko':'',
        (is('x11')||is('linux'))?' linux'
        :is('mac')?' mac'
        :is('win')?' win':''
        ].join(" "));
}();


/*
* Jquery Cookie
*/
jQuery.cookie=function(name,value,options){if(typeof value!='undefined'){options=options||{};if(value===null){value='';options.expires=-1}var expires='';if(options.expires&&(typeof options.expires=='number'||options.expires.toUTCString)){var date;if(typeof options.expires=='number'){date=new Date();date.setTime(date.getTime()+(options.expires*24*60*60*1000))}else{date=options.expires}expires='; expires='+date.toUTCString()}var path=options.path?'; path='+(options.path):'';var domain=options.domain?'; domain='+(options.domain):'';var secure=options.secure?'; secure':'';document.cookie=[name,'=',encodeURIComponent(value),expires,path,domain,secure].join('')}else{var cookieValue=null;if(document.cookie&&document.cookie!=''){var cookies=document.cookie.split(';');for(var i=0;i<cookies.length;i++){var cookie=jQuery.trim(cookies[i]);if(cookie.substring(0,name.length+1)==(name+'=')){cookieValue=decodeURIComponent(cookie.substring(name.length+1));break}}}return cookieValue}};

/* ---------------------------------------------------------------------- */
/*	Include Javascript Files
/* ---------------------------------------------------------------------- */

	$.include('js/jquery.easing.1.3.js');
	$.include('js/jquery.cycle.all.min.js');
	$.include('js/respond.min.js');
	
	if(jQuery("html").is(".ie8")) {
		$.include('js/selectivizr-and-extra-selectors.min.js')
	}
	
	if(jQuery('#portfolio-items').length) {$.include('js/jquery.isotope.min.js');}
	if(jQuery('.single-image').length) {$.include('fancybox/jquery.fancybox.pack.js');}
	if(jQuery('#jstwitter').length) {$.include('js/twitter.js');}
	
/* end */

/* ---------------------------------------------------------------------- */
/*	Load Google Fonts
/* ---------------------------------------------------------------------- */
	
WebFontConfig = {
		google: {families: ['Adamina::latin', 'Alice::latin']}
	  };
	  (function() {
		var wf = document.createElement('script');
		wf.src = ('https:' == document.location.protocol ? 'https' : 'http') +
			'://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js';
		wf.type = 'text/javascript';
		wf.async = 'true';
		var s = document.getElementsByTagName('body')[0];
		s.appendChild(wf, s);
	  })();

/* end Google Fonts */

/* ---------------------------------------------------------------------- */
/*	Panel
/* ---------------------------------------------------------------------- */
	  
$.include('themeChanger/js/themeChanger.js');

/* end Panel */

/************************************************************************/
/* DOM READY --> Begin													*/
/************************************************************************/

jQuery(document).ready(function($) {
	
	/* ---------------------------------------------------------------------- */
	/*	Main Navigation
	/* ---------------------------------------------------------------------- */
	
	(function() {
		
		var	arrowimages = {
			down: 'downarrowclass',
			right: 'rightarrowclass'
		};
		var $mainNav    = $('#navigation').find('> ul'),
			optionsList = '<option value="" selected>Navigation</option>';
			  
			var $submenu = $mainNav.find("ul").parent();
			$submenu.each(function (i) {
				var $curobj = $(this);
				 this.istopheader = $curobj.parents("ul").length == 1 ? true : false;
				$curobj.children("a").append('<span class="' + (this.istopheader ? arrowimages.down : arrowimages.right) +'"></span>');
			});

			
		// Navigation Responsive
		
		$mainNav.find('li').each(function() {
			var $this   = $(this),
				$anchor = $this.children('a'),
				depth   = $this.parents('ul').length - 1,
				dash  = '';
				
			if(depth) {
				while(depth > 0) {
					dash += '--';
					depth--;
				}
			}
			
			optionsList += '<option value="' + $anchor.attr('href') + '">' + dash + ' ' + $anchor.text() + '</option>';
			
		}).end()
		  .after('<select class="nav-responsive">' + optionsList + '</select>');

		$('.nav-responsive').on('change', function() {
			window.location = $(this).val();
		});
		
	})();

	/* end Main Navigation */

	/* ---------------------------------------------------------------------- */
	/*	Flex Slider
	/* ---------------------------------------------------------------------- */

	if ($('#slider').length) {
		$.include('sliders/flexslider/jquery.flexslider-min.js');
		$(window).load(function() {
			$('#slider img').css('visibility','visible').fadeIn();
			$('#slider').flexslider({
				directionNav: true,
				controlNav: false
			});
		});
	}

	/* end Flex Slider */

	/* ---------------------------------------------------------------------- */
	/*	Fit Videos
	/* ---------------------------------------------------------------------- */

	(function() {

		$('.container').each(function(){
			var target  = [
				"iframe[src^='http://www.youtube.com']",
				"iframe[src^='http://player.vimeo.com']",
				"object"
			];

				$allVideos = $(this).find(target.join(','));

			$allVideos.each(function(){
				var $this = $(this);

				if (this.tagName.toLowerCase() == 'embed' && $this.parent('object').length || $this.parent('.liquid-video-wrapper').length) {return;} 
				var height = this.tagName.toLowerCase() == 'object' ? $this.attr('height') : $this.height(),
				aspectRatio = height / $this.width();

				if(!$this.attr('id')){
					var $ID = Math.floor(Math.random()*9999999);
					$this.attr('id', $ID);
				}
				$this.wrap('<div class="liquid-video-wrapper"></div>').parent('.liquid-video-wrapper').css('padding-top', (aspectRatio * 100)+"%");
				$this.removeAttr('height').removeAttr('width');
			});
		});
	})();

	/* end Fit Videos */

	/* ---------------------------------------------------- */
	/*	Min. Height
	/* ---------------------------------------------------- */

	(function() {

		$('section.container')
		.css( 'min-height', $(window).outerHeight(true) 
			- $('#header').outerHeight(true) 
			- $('#footer').outerHeight(true));

	})();

	/* end Min. Height */

	/* ---------------------------------------------------- */
	/*	Content Toggle
	/* ---------------------------------------------------- */

	(function() {

		if($('.toggle-container').length) {	
			$(".toggle-container").hide(); //Hide (Collapse) the toggle containers on load
			//Switch the "Open" and "Close" state per click then slide up/down (depending on open/close state)
			$(".trigger").click(function(){
				$(this).toggleClass("active").next().slideToggle("slow");
				return false; //Prevent the browser jump to the link anchor
			});
		}
	})();

	/* end Content Toggle */

	/* ---------------------------------------------------------------------- */
	/*	Accordion Content
	/* ---------------------------------------------------------------------- */

	(function() {

		if($('.acc-container').length) {

			var $container = $('.acc-container'),
				$trigger   = $('.acc-trigger');

			$container.hide();
			$trigger.first().addClass('active').next().show();

			var fullWidth = $container.outerWidth(true);
			$trigger.css('width', fullWidth);
			$container.css('width', fullWidth + 2);

			$trigger.on('click', function(e) {
				if( $(this).next().is(':hidden') ) {
					$trigger.removeClass('active').next().slideUp(300);
					$(this).toggleClass('active').next().slideDown(300);
				}
				e.preventDefault();
			});

			// Resize
			$(window).on('resize', function() {
				fullWidth = $container.outerWidth(true)
				$trigger.css('width', $trigger.parent().width() );
				$container.css('width', $container.parent().width() + 2 );
			});
		}
	})();

	/* end Accordion Content */
	
	/* ---------------------------------------------------- */
	/*	Content Tabs
	/* ---------------------------------------------------- */

	(function() {

		if($('.content-tabs').length) {

			var $contentTabs  = $('.content-tabs');

			$.fn.tabs = function($obj) {
					$tabsNavLis = $obj.find('.tabs-nav').children('li'),
					$tabContent = $obj.find('.tab-content');

				$tabContent.hide();	
				$tabsNavLis.first().addClass('active').show();
				$tabContent.first().show();

				$obj.find('ul.tabs-nav li').on('click', function(e) {
					var $this = $(this);

						$obj.find('ul.tabs-nav li').removeClass('active');
						$this.addClass('active');
						$obj.find('.tab-content').hide(); //Hide all tab content
						$($this.find('a').attr('href')).fadeIn();

					e.preventDefault();
				});
			}

			$contentTabs.tabs($contentTabs);
		}

	})();

	/* end Content Tabs */
	
	/* ---------------------------------------------------------------------- */
	/*	Contact Form
	/* ---------------------------------------------------------------------- */

	(function() {

		if($('#contactform').length) {

			var $form = $('#contactform'),
			$loader = '<img src="images/preloader.gif" alt="Loading..." />';
			$form.append('<div class="hidden" id="contact_form_responce">');

			var $response = $('#contact_form_responce');
			$response.append('<p></p>');

			$form.submit(function(e){

				$response.find('p').html($loader);

				var data = {
					action: "contact_form_request",
					values: $("#contactform").serialize()
				};

				//send data to server
				$.post("php/contact-send.php", data, function(response) {

					response = $.parseJSON(response);

					$(".wrong-data").removeClass("wrong-data");
					$response.find('img').remove();

					if(response.is_errors){

						$response.find('p').removeClass().addClass("error");
						$.each(response.info,function(input_name, input_label) {

							$("[name="+input_name+"]").addClass("wrong-data");
							$response.find('p').append('Please enter correctly "'+input_label+'"!'+ '</br>');
						});

					} else {

						$response.find('p').removeClass().addClass('success');

						if(response.info == 'success'){

							$response.find('p').append('Your email has been sent!');
							$form.find('input:not(input[type="submit"], button), textarea, select').val('').attr( 'checked', false );
							$response.delay(1500).hide(400);
						}

						if(response.info == 'server_fail'){
							$response.find('p').append('Server failed. Send later!');
						}
					}

					// Scroll to bottom of the form to show respond message
					var bottomPosition = $form.offset().top + $form.outerHeight() - $(window).height();

					if($(document).scrollTop() < bottomPosition) {
						$('html, body').animate({
							scrollTop : bottomPosition
						});
					}

					if(!$('#contact_form_responce').css('display') == 'block') {
						$response.show(450);
					}

				});

				e.preventDefault();

			});				

		}

	})();

	/* end Contact Form */

	/* ---------------------------------------------------------------------- */
	/*	Google Maps
	/* ---------------------------------------------------------------------- */

	(function() {

		if($('#map').length) {
			$('#map').gMap({ 
				address: 'New York, USA',
				zoom: 14,
				markers: [
					{'address' : 'Grand St, New York'}
				]
			});  
		}

	})();

	/* end Google Maps */

	/* ---------------------------------------------------- */
	/*	Back to Top
	/* ---------------------------------------------------- */

	(function() {

		var extend = {
				button      : '#back-top',
				text        : 'Back to Top',
				min         : 200,
				fadeIn      : 400,
				fadeOut     : 400,
				speed		: 800,
				easing		: 'easeOutQuint'
			},
			oldiOS     = false,
			oldAndroid = false;
			
		// Detect if older iOS device, which doesn't support fixed position
		if( /(iPhone|iPod|iPad)\sOS\s[0-4][_\d]+/i.test(navigator.userAgent) )
			oldiOS = true;

		// Detect if older Android device, which doesn't support fixed position
		if( /Android\s+([0-2][\.\d]+)/i.test(navigator.userAgent) )
			oldAndroid = true;

		$('body').append('<a href="#" id="' + extend.button.substring(1) + '" title="' + extend.text + '">' + extend.text + '</a>');

		$(window).scroll(function() {
			var pos = $(window).scrollTop();
			
			if( oldiOS || oldAndroid ) {
				$( extend.button ).css({
					'position' : 'absolute',
					'top'      : position + $(window).height()
				});
			}
			
			if (pos > extend.min) {
				$(extend.button).fadeIn(extend.fadeIn);
			}
				
			else {
				$(extend.button).fadeOut (extend.fadeOut);
			}
				
		});

		$(extend.button).click(function(e){
			$('html, body').animate({scrollTop : 0}, extend.speed, extend.easing);
			e.preventDefault();
		});

	})();

	/* end Back to Top */

	/* ---------------------------------------------------- */
	/*	Fancybox
	/* ---------------------------------------------------- */
	
	(function() {
			
		if($('.single-image').length) {
			
			$('.single-image').fancybox({
				'titlePosition' : 'over',
				'transitionIn'  : 'fade',
				'transitionOut' : 'fade'
			}).each(function() {
				$(this).append('<span class="curtain">&nbsp;</span>');
			});	
			
		}
	})();
	

	/* end fancybox --> End */

	/* ---------------------------------------------------------------------- */
	/*	Testimonials
	/* ---------------------------------------------------------------------- */

	(function(){
		
		var $quotes = $('ul.quotes');

		if($quotes.length) {

			// Run slider when all images are fully loaded
			$(window).load(function() {

				$quotes.each(function(i) {
					var $this = $(this);

					$this.css('height', $this.find('li:first img').height())
						.cycle({
							before: function(curr, next, opts) {
								var $this = $(this);
								$this.parent().stop().animate({ height: $this.height() }, opts.speed);
							},
							containerResize : false,
							easing          : 'easeInOutExpo',
							fx              : 'fade',
							fit             : true,
							next            : '.next',
							pause           : true,
							prev            : '.prev',
							slideExpr       : 'li',
							slideResize     : true,
							speed           : 600,
							timeout         : 4000,
							width           : '100%'
						});
				});

			});
		}		
		
	})();
	
	/* ------------------------------------------------------------------- */
	/*	Portfolio														   */
	/* ------------------------------------------------------------------- */
	
	(function() {

		var $cont = $('#portfolio-items');
		
		
		if($cont.length) {

			var $itemsFilter = $('#portfolio-filter'),
				mouseOver;
				
				
			// Copy categories to item classes
			$('article', $cont).each(function(i) {
				var $this = $(this);
				$this.addClass( $this.attr('data-categories') );
			});

			// Run Isotope when all images are fully loaded
			$(window).on('load', function() {

				$cont.isotope({
					itemSelector : 'article',
					layoutMode   : 'fitRows'
				});

			});

			// Filter projects
			$itemsFilter.on('click', 'a', function(e) {
				var $this         = $(this),
					currentOption = $this.attr('data-categories');

				$itemsFilter.find('a').removeClass('active');
				$this.addClass('active');

				if(currentOption) {
					if(currentOption !== '*') currentOption = currentOption.replace(currentOption, '.' + currentOption)

					$cont.isotope({filter : currentOption});
				}

				e.preventDefault();
			});

			$itemsFilter.find('a').first().addClass('active');
		}

	})();

	/* end Portfolio  */
	
	/* ---------------------------------------------------------------------- */
	/*	Image Gallery Slider
	/* ---------------------------------------------------------------------- */
	
	(function() {

		var $slider = $('.image-post-slider ul');

		if($slider.length) {

			// Run slider when all images are fully loaded
			$(window).load(function() {

				$slider.each(function(i) {
					var $this = $(this);

					$this.css('height', $this.find('li:first img').height())
					.after('<div class="post-pager">&nbsp;</div>')
					.cycle({
						before: function(curr, next, opts) {
							var $this = $(this);
							$this.parent().stop().animate({
								height: $this.height()
							}, opts.speed);
						},
						containerResize : false,
						easing          : 'easeInOutExpo',
						fx              : 'scrollRight',
						fit             : true,
						next            : '.next',
						pause           : true,
						pager			: '.post-pager',
						prev            : '.prev',
						slideExpr       : 'li',
						slideResize     : true,
						speed           : 600,
						timeout         : 0,
						width           : '100%'
					});
				});

			});
		}	

		// Include swipe touch
		if(Modernizr.touch) {

			function swipe(e, dir) {

				var $slider = $(e.currentTarget);

				$slider.data('dir', '')

				if(dir === 'left') {
					$slider.cycle('next');
				}

				if(dir === 'right') {
					$slider.data('dir', 'prev')
					$slider.cycle('prev');
				}

			}

			$slider.swipe({
				swipeLeft       : swipe,
				swipeRight      : swipe,
				allowPageScroll : 'auto'
			});

		}
		
	})();
			
/************************************************************************/
});/* DOM READY --> End													*/
/************************************************************************/
