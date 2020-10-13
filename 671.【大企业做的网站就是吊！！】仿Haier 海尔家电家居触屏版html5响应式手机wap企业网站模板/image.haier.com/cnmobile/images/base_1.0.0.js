var touchevent = Modernizr.touch ? 'touchend' : 'click';


$(function() {
	initNav();
	initScroll();
	initForm();
	initBanner();
	initTab();
	initLoad();

	initChangeCity();
	
	// 大屏幕
	initPad();	
	
	// 折叠
	initFolder();

	// 服务中心，折叠菜单
	initListnav();
});


/**
 * 	导航 
 */
function initNav() {
	var wrapper = $('#wrapper');
	var nav = $('nav');
	var topicbtn = $('a.topicbtn');
	var goTop = $('#gotop');
	
	$('a.navbtn').bind('click', function() {
		var $this = $(this);
		if ($this.hasClass('open')) {
			$this.removeClass('open');
			closeNav();
		} else {
			$this.addClass('open');
			openNav();
		}
		return false;
	});
	
	function openNav() {
		wrapper.animate({right:206});
		nav.animate({right:0});
		topicbtn.animate({right:218});
		goTop.animate({right:216});
	}
	
	function closeNav() {
		wrapper.animate({right:0});
		nav.animate({right:-206});
		topicbtn.animate({right:12});
		goTop.animate({right:10});
	}
	
	function subnav() {
		var $this = $(this);
		var sub = $this.parent().next();
		
		if ($this.attr('open')) {
			sub.slideUp();
			$this.removeAttr('open');
		} else {
			sub.slideDown();
			$this.attr('open', 'open');
		}
	}
	
	nav.find('.trigger').bind('touchend', subnav);
}

/**
 * 	手势 
 */
function initScroll() {
	if ($('nav').length>0) {
		var myScroll = new IScroll('nav', { mouseWheel: true });
		$('nav').bind('touchmove', function (e) { 
			e.preventDefault(); 
		});
		var moveflag = false;
		$('nav a').bind({
			'touchstart': function() {
				moveflag = false;
			},
			'touchmove': function() {
				moveflag = true;
			},
			'touchend': function() {
				if (!moveflag) { location.href=$(this).attr('href'); }
			}
		});
		
		$('nav ul ul').css('display', 'none');
	}
}
/**
 * 	表单
 */
function initForm() {
	var moved = false;
	
	$('.radio-picker label').bind({
		'touchstart': function() {
			moved = false;
		},
		'touchmove': function() {
			moved = true;
		},
		'touchend': function() {
			if (moved) { return false; }
			$(this).parents('.radio-picker').find('label').removeClass('active');
			$(this).addClass('active');
		}
	});
	
	$('.check-picker label').bind('click', function(e) {
		if ($(this).find(':checkbox')[0].checked) {
			$(this).addClass('active');
		} else {
			$(this).removeClass('active');
		}
	});
	
	function resetLabel() {
		$('.radio-picker label').each(function() {
			if ($(this).find(':radio')[0].checked) {
				$(this).addClass('active');
			} else {
				$(this).removeClass('active');
			}
		});
		$('.check-picker label').each(function() {
			if ($(this).find(':checkbox')[0].checked) {
				$(this).addClass('active');
			} else {
				$(this).removeClass('active');
			}
		});
	}
	resetLabel();
	$('form').bind('reset', resetLabel);
	
	$('.form-wrap input.input-text').bind({
		'focus': function() {
			var wrap = $(this).parent('.input-wrap');
			if (wrap) { wrap.addClass('focus'); }
		},
		'blur': function() {
			var wrap = $(this).parent('.input-wrap');
			if (wrap) { wrap.removeClass('focus'); }
		}
	});
	
	// 开关
	$('.switch').bind(touchevent, function() {
		if ($(this).hasClass('off')) {
			$(this).find('.btn').animate({'left': 37});
			$(this).find('.texton').animate({'width': '100%'});
			$(this).find('.textoff').animate({'width': '0'});
			$(this).removeClass('off');
		} else {
			$(this).find('.btn').animate({'left': -1});
			$(this).find('.texton').animate({'width': 0});
			$(this).find('.textoff').animate({'width': '100%'});
			$(this).addClass('off');
		}
	});
	
	// 显示密码
	$('.showpwd label').bind('click', function() {
		var checkbox = $(this).find(':checkbox');
		var pwds = $(this).parents('form').find('input.input-pwd');
		if (!pwds.length) {
			pwds = $('input.input-pwd');
		}
		if (checkbox[0].checked) {
			pwds.attr('type', 'text');
		} else {
			pwds.attr('type', 'password');
		}
	});
	
	// select 
	$('.select-wrap select').bind('change', function() {
		var value = $(this).val();
		var options = $(this).find('option');
		var n = 0;
		while (options.eq(n).val() != value) { n++; }
		$(this).siblings('span').text(options.eq(n).text());
	});
}
/**
 * 	banner
 */
 function initBanner() {
 	$('.flexslider').flexslider({
		directionNav: false
	});
 	$('.bbs-nav-box').flexslider({
		directionNav: false,
		animation: 'slide',
		animationLoop: false,
		slideshow: false
	});
	
	var itemWidth = $('.index-nav-box .slides>li').width();
 	$('.index-nav-box').flexslider({
		directionNav: false,
		animation: 'slide',
		animationLoop: false,
		slideshow: false,
		itemWidth: itemWidth,
		itemMargin: 0,
		minItems: 4,
		maxItems: 5,
		move: 0
	});

	var itemWidth = $('.service-index-banner .slides>li').width();
 	$('.service-index-banner').flexslider({
		directionNav: false,
		animation: 'slide',
		animationLoop: false,
		slideshow: false,
		itemWidth: itemWidth,
		itemMargin: 0,
		minItems: 4,
		maxItems: 4,
		move: 0
	});
 }
/**
 * 	tab切换
 */
 function initTab() {

 	$('.tab-nav a').bind(touchevent, function(){
 		$(this).addClass('active').siblings().removeClass('active');
 		var index = $('.tab-nav a').index(this);
 		$('.tab-wrap > div').eq(index).show().siblings().hide();
 	});
 }
 
/** 
 *	加载更多
 */
function initLoad() {
	var loadwrap = $('#loadwrap');
	var loading = $('#loading');
	var loadurl = loadwrap.attr('loadurl');
	if (loadwrap.length > 0) {
		$(window).bind('scroll', function() {
			if (document.body.scrollTop >= document.body.scrollHeight-document.body.clientHeight-130
				|| document.documentElement.scrollTop >= document.body.scrollHeight-document.body.clientHeight-130) {
				loading.css('height', 'auto');
				$.ajax({
					'type': 'post',
					'url': loadurl,
					'data': 'curNum='+loadwrap.children().length, // TODO 传当前数量
					'success': function(htmlstr) {
						loadwrap.innerHTML = loadwrap.innerHTML + htmlstr;
						loading.css('height', '0');
						// todo 比较总数	
						if ($('#loadend').val() == 'true') {
							$('#loadtext').hide();
							$(window).unbind('scroll');
						}
					}
				})
			}
		});
	}
}



function initChangeCity() {
	var box = $('.popBox');
	$('.cityTabHead h1 a').bind(touchevent, function(e) {
		e.preventDefault();
		if (box.hasClass('open')) {
			box.removeClass('open').slideUp();
		} else {
			box.addClass('open').slideDown();
		}
	});
}




/*!
 * jquery.scrollto.js 0.0.1 - https://github.com/yckart/jquery.scrollto.js
 * Scroll smooth to any element in your DOM.
 *
 * Copyright (c) 2012 Yannick Albert (http://yckart.com)
 * Licensed under the MIT license (http://www.opensource.org/licenses/mit-license.php).
 * 2013/02/17
 **/
$.scrollTo = $.fn.scrollTo = function(x, y, options){
    if (!(this instanceof $)) return $.fn.scrollTo.apply($('html, body'), arguments);

    options = $.extend({}, {
        gap: {
            x: 0,
            y: 0
        },
        animation: {
            easing: 'swing',
            duration: 600,
            complete: $.noop,
            step: $.noop
        }
    }, options);

    return this.each(function(){
        var elem = $(this);
        elem.stop().animate({
            scrollLeft: !isNaN(Number(x)) ? x : $(y).offset().left + options.gap.x,
            scrollTop: !isNaN(Number(y)) ? y : $(y).offset().top + options.gap.y
        }, options.animation);
    });
};


$(function() {
	initGotop();
});

function initGotop() {
	var goTop = $('#gotop');
	goTop.bind(touchevent, function(e) {
		e.preventDefault();
		$.scrollTo(0,0);
	});
	goTop.css('display', 'none');
	
	$(window).scroll(function() {
		var top = $(window).scrollTop();
		if (top > 100) {
			goTop.fadeIn();
		} else {
			goTop.fadeOut();
		}
	})
}




function initPad() {
	var footerpos = 'static';
	
	function setGotop() {
		if (footerpos == 'static' && document.documentElement.scrollHeight <= document.documentElement.clientHeight) {
			$('#wrapper').css({
				'height': '100%'
			});
			$('footer').css({
				'position': 'absolute',
				'left': 0,
				'bottom': 0,
				'width': '100%'
			});
			footerpos = 'fixed';
		} else if (footerpos == 'fixed' && document.documentElement.scrollHeight+102 > document.documentElement.clientHeight) {
			$('#wrapper').css({
				'height': 'auto'
			});
			$('footer').css({
				'position': 'static'
			});
			footerpos = 'static';
		}
		
		if (document.documentElement.scrollHeight <= document.documentElement.clientHeight) {
			$('#gotop').hide();	
		} else if ($(window).scrollTop() > 200) {
			$('#gotop').show();	
		}
		
		if (document.documentElement.scrollHeight <= document.documentElement.clientHeight) {
			var gap = (document.documentElement.clientHeight - 140 - $('div.content').height()) / 2 - 30;
			if (gap > 200) { gap = 200; }
			$('div.pad-center').css({
				'padding-top': gap
			});
		} else {
			$('div.pad-center').css({
				'padding-top': 0
			});
		}
		
	}
	setGotop();
	$('body').resize(function() {
		setGotop();
	}); 
	
	

}


function initFolder() {
	var moved = false;
	$('.folder .tit').bind('touchstart', function() { moved = false; });
	$('.folder .tit').bind('touchmove', function() { moved = true; });
	
	$('.folder .tit').bind('touchend', function() {
		if (moved) { return false; }
		if ($(this).hasClass('tit-close')) {	
			$(this).next('.con').slideDown();
			$(this).removeClass('tit-close');
		} else {
			$(this).next('.con').slideUp();
			$(this).addClass('tit-close');
		}
	});
}



function initListnav() {
	var moved = false;
	$('.list-nav a.hassub').bind({
		'touchstart': function() {
			moved = false;
		},
		'touchmove': function() {
			moved = true;
		},
		'touchend': function() {
			if (moved) { return false; }
			var $this = $(this);
			var sub = $this.next('ul');
			
			if ($this.attr('open')) {
				sub.slideUp();
				$this.removeAttr('open');
			} else {
				sub.slideDown();
				$this.attr('open', 'open');
			}
		}
	});
}






/*!
 * jQuery resize event - v1.1 - 3/14/2010
 * http://benalman.com/projects/jquery-resize-plugin/
 * 
 * Copyright (c) 2010 "Cowboy" Ben Alman
 * Dual licensed under the MIT and GPL licenses.
 * http://benalman.com/about/license/
 */

// Script: jQuery resize event
//
// *Version: 1.1, Last updated: 3/14/2010*
// 
// Project Home - http://benalman.com/projects/jquery-resize-plugin/
// GitHub       - http://github.com/cowboy/jquery-resize/
// Source       - http://github.com/cowboy/jquery-resize/raw/master/jquery.ba-resize.js
// (Minified)   - http://github.com/cowboy/jquery-resize/raw/master/jquery.ba-resize.min.js (1.0kb)
// 
// About: License
// 
// Copyright (c) 2010 "Cowboy" Ben Alman,
// Dual licensed under the MIT and GPL licenses.
// http://benalman.com/about/license/
// 
// About: Examples
// 
// This working example, complete with fully commented code, illustrates a few
// ways in which this plugin can be used.
// 
// resize event - http://benalman.com/code/projects/jquery-resize/examples/resize/
// 
// About: Support and Testing
// 
// Information about what version or versions of jQuery this plugin has been
// tested with, what browsers it has been tested in, and where the unit tests
// reside (so you can test it yourself).
// 
// jQuery Versions - 1.3.2, 1.4.1, 1.4.2
// Browsers Tested - Internet Explorer 6-8, Firefox 2-3.6, Safari 3-4, Chrome, Opera 9.6-10.1.
// Unit Tests      - http://benalman.com/code/projects/jquery-resize/unit/
// 
// About: Release History
// 
// 1.1 - (3/14/2010) Fixed a minor bug that was causing the event to trigger
//       immediately after bind in some circumstances. Also changed $.fn.data
//       to $.data to improve performance.
// 1.0 - (2/10/2010) Initial release

(function($,window,undefined){
  '$:nomunge'; // Used by YUI compressor.
  
  // A jQuery object containing all non-window elements to which the resize
  // event is bound.
  var elems = $([]),
    
    // Extend $.resize if it already exists, otherwise create it.
    jq_resize = $.resize = $.extend( $.resize, {} ),
    
    timeout_id,
    
    // Reused strings.
    str_setTimeout = 'setTimeout',
    str_resize = 'resize',
    str_data = str_resize + '-special-event',
    str_delay = 'delay',
    str_throttle = 'throttleWindow';
  
  // Property: jQuery.resize.delay
  // 
  // The numeric interval (in milliseconds) at which the resize event polling
  // loop executes. Defaults to 250.
  
  jq_resize[ str_delay ] = 250;
  
  // Property: jQuery.resize.throttleWindow
  // 
  // Throttle the native window object resize event to fire no more than once
  // every <jQuery.resize.delay> milliseconds. Defaults to true.
  // 
  // Because the window object has its own resize event, it doesn't need to be
  // provided by this plugin, and its execution can be left entirely up to the
  // browser. However, since certain browsers fire the resize event continuously
  // while others do not, enabling this will throttle the window resize event,
  // making event behavior consistent across all elements in all browsers.
  // 
  // While setting this property to false will disable window object resize
  // event throttling, please note that this property must be changed before any
  // window object resize event callbacks are bound.
  
  jq_resize[ str_throttle ] = true;
  
  // Event: resize event
  // 
  // Fired when an element's width or height changes. Because browsers only
  // provide this event for the window element, for other elements a polling
  // loop is initialized, running every <jQuery.resize.delay> milliseconds
  // to see if elements' dimensions have changed. You may bind with either
  // .resize( fn ) or .bind( "resize", fn ), and unbind with .unbind( "resize" ).
  // 
  // Usage:
  // 
  // > jQuery('selector').bind( 'resize', function(e) {
  // >   // element's width or height has changed!
  // >   ...
  // > });
  // 
  // Additional Notes:
  // 
  // * The polling loop is not created until at least one callback is actually
  //   bound to the 'resize' event, and this single polling loop is shared
  //   across all elements.
  // 
  // Double firing issue in jQuery 1.3.2:
  // 
  // While this plugin works in jQuery 1.3.2, if an element's event callbacks
  // are manually triggered via .trigger( 'resize' ) or .resize() those
  // callbacks may double-fire, due to limitations in the jQuery 1.3.2 special
  // events system. This is not an issue when using jQuery 1.4+.
  // 
  // > // While this works in jQuery 1.4+
  // > $(elem).css({ width: new_w, height: new_h }).resize();
  // > 
  // > // In jQuery 1.3.2, you need to do this:
  // > var elem = $(elem);
  // > elem.css({ width: new_w, height: new_h });
  // > elem.data( 'resize-special-event', { width: elem.width(), height: elem.height() } );
  // > elem.resize();
      
  $.event.special[ str_resize ] = {
    
    // Called only when the first 'resize' event callback is bound per element.
    setup: function() {
      // Since window has its own native 'resize' event, return false so that
      // jQuery will bind the event using DOM methods. Since only 'window'
      // objects have a .setTimeout method, this should be a sufficient test.
      // Unless, of course, we're throttling the 'resize' event for window.
      if ( !jq_resize[ str_throttle ] && this[ str_setTimeout ] ) { return false; }
      
      var elem = $(this);
      
      // Add this element to the list of internal elements to monitor.
      elems = elems.add( elem );
      
      // Initialize data store on the element.
      $.data( this, str_data, { w: elem.width(), h: elem.height() } );
      
      // If this is the first element added, start the polling loop.
      if ( elems.length === 1 ) {
        loopy();
      }
    },
    
    // Called only when the last 'resize' event callback is unbound per element.
    teardown: function() {
      // Since window has its own native 'resize' event, return false so that
      // jQuery will unbind the event using DOM methods. Since only 'window'
      // objects have a .setTimeout method, this should be a sufficient test.
      // Unless, of course, we're throttling the 'resize' event for window.
      if ( !jq_resize[ str_throttle ] && this[ str_setTimeout ] ) { return false; }
      
      var elem = $(this);
      
      // Remove this element from the list of internal elements to monitor.
      elems = elems.not( elem );
      
      // Remove any data stored on the element.
      elem.removeData( str_data );
      
      // If this is the last element removed, stop the polling loop.
      if ( !elems.length ) {
        clearTimeout( timeout_id );
      }
    },
    
    // Called every time a 'resize' event callback is bound per element (new in
    // jQuery 1.4).
    add: function( handleObj ) {
      // Since window has its own native 'resize' event, return false so that
      // jQuery doesn't modify the event object. Unless, of course, we're
      // throttling the 'resize' event for window.
      if ( !jq_resize[ str_throttle ] && this[ str_setTimeout ] ) { return false; }
      
      var old_handler;
      
      // The new_handler function is executed every time the event is triggered.
      // This is used to update the internal element data store with the width
      // and height when the event is triggered manually, to avoid double-firing
      // of the event callback. See the "Double firing issue in jQuery 1.3.2"
      // comments above for more information.
      
      function new_handler( e, w, h ) {
        var elem = $(this),
          data = $.data( this, str_data );
        
        // If called from the polling loop, w and h will be passed in as
        // arguments. If called manually, via .trigger( 'resize' ) or .resize(),
        // those values will need to be computed.
        data.w = w !== undefined ? w : elem.width();
        data.h = h !== undefined ? h : elem.height();
        
        old_handler.apply( this, arguments );
      };
      
      // This may seem a little complicated, but it normalizes the special event
      // .add method between jQuery 1.4/1.4.1 and 1.4.2+
      if ( $.isFunction( handleObj ) ) {
        // 1.4, 1.4.1
        old_handler = handleObj;
        return new_handler;
      } else {
        // 1.4.2+
        old_handler = handleObj.handler;
        handleObj.handler = new_handler;
      }
    }
    
  };
  
  function loopy() {
    
    // Start the polling loop, asynchronously.
    timeout_id = window[ str_setTimeout ](function(){
      
      // Iterate over all elements to which the 'resize' event is bound.
      elems.each(function(){
        var elem = $(this),
          width = elem.width(),
          height = elem.height(),
          data = $.data( this, str_data );
        
        // If element size has changed since the last time, update the element
        // data store and trigger the 'resize' event.
        if ( width !== data.w || height !== data.h ) {
          elem.trigger( str_resize, [ data.w = width, data.h = height ] );
        }
        
      });
      
      // Loop.
      loopy();
      
    }, jq_resize[ str_delay ] );
    
  };
  
})(jQuery,this);
