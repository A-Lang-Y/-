/*! Copyright (c) 2011 Brandon Aaron (http://brandonaaron.net)
 * Licensed under the MIT License (LICENSE.txt).
 *
 * Thanks to: http://adomas.org/javascript-mouse-wheel/ for some pointers.
 * Thanks to: Mathias Bank(http://www.mathias-bank.de) for a scope bug fix.
 * Thanks to: Seamus Leahy for adding deltaX and deltaY
 *
 * Version: 3.0.6
 * 
 * Requires: 1.2.2+
 */

(function($) { 

var types = ['DOMMouseScroll', 'mousewheel'];

if ($.event.fixHooks) {
    for ( var i=types.length; i; ) {
        $.event.fixHooks[ types[--i] ] = $.event.mouseHooks;
    }
}

$.event.special.mousewheel = {
    setup: function() {
        if ( this.addEventListener ) {
            for ( var i=types.length; i; ) {
                this.addEventListener( types[--i], handler, false );
            }
        } else {
            this.onmousewheel = handler;
        }
    },
    
    teardown: function() {
        if ( this.removeEventListener ) {
            for ( var i=types.length; i; ) {
                this.removeEventListener( types[--i], handler, false );
            }
        } else {
            this.onmousewheel = null;
        }
    }
};

$.fn.extend({
    mousewheel: function(fn) {
        return fn ? this.bind("mousewheel", fn) : this.trigger("mousewheel");
    },
    
    unmousewheel: function(fn) {
        return this.unbind("mousewheel", fn);
    }
});


function handler(event) {
    var orgEvent = event || window.event, args = [].slice.call( arguments, 1 ), delta = 0, returnValue = true, deltaX = 0, deltaY = 0;
    event = $.event.fix(orgEvent);
    event.type = "mousewheel";
    
    // Old school scrollwheel delta
    if ( orgEvent.wheelDelta ) { delta = orgEvent.wheelDelta/120; }
    if ( orgEvent.detail     ) { delta = -orgEvent.detail/3; }
    
    // New school multidimensional scroll (touchpads) deltas
    deltaY = delta;
    
    // Gecko
    if ( orgEvent.axis !== undefined && orgEvent.axis === orgEvent.HORIZONTAL_AXIS ) {
        deltaY = 0;
        deltaX = -1*delta;
    }
    
    // Webkit
    if ( orgEvent.wheelDeltaY !== undefined ) { deltaY = orgEvent.wheelDeltaY/120; }
    if ( orgEvent.wheelDeltaX !== undefined ) { deltaX = -1*orgEvent.wheelDeltaX/120; }
    
    // Add event and delta to the front of the arguments
    args.unshift(event, delta, deltaX, deltaY);
    
    return ($.event.dispatch || $.event.handle).apply(this, args);
}

})(jQuery);

/**
 * @version		2.0
 * @package		jquery
 * @subpackage	lofslidernews
 * @copyright	Copyright (C) JAN 2010 LandOfCoder.com <@emai:landofcoder@gmail.com>. All rights reserved.
 * @website     http://landofcoder.com
 * @license		This plugin is dual-licensed under the GNU General Public License and the MIT License 
 */
// JavaScript Document
(function($) {
	 $.fn.lofJSidernews = function( settings ) {
	 	return this.each(function() {
			// get instance of the lofSiderNew.
			new  $.lofSidernews( this, settings ); 
		});
 	 }
	 $.lofSidernews = function( obj, settings ){
		this.settings = {
			direction	    	: '',
			mainItemSelector    : 'li',
			navInnerSelector	: 'ul',
			navSelector  		: 'li' ,
			navigatorEvent		: 'click'/* click|mouseenter */,
			wapperSelector: 	'.sliders-wrap-inner',
			interval	  	 	: 5000,
			auto			    : false, // whether to automatic play the slideshow
			maxItemDisplay	 	: 3,
			startItem			: 0,
			navPosition			: 'vertical',/* values: horizontal|vertical*/ 
			navigatorHeight		: 100,
			navigatorWidth		: 310,
			duration			: 600,
			navItemsSelector    : '.navigator-wrap-inner li',
			navOuterSelector    : '.navigator-wrapper' ,
			isPreloaded			: true,
			easing				: 'easeInOutQuad',
			onPlaySlider:function(obj, slider){},
			onComplete:function(slider, index){  }
		}	
		$.extend( this.settings, settings ||{} );	
		this.nextNo         = null;
		this.previousNo     = null;
		this.maxWidth  = this.settings.mainWidth || 684;
		
		

		this.wrapper = $( obj ).find( this.settings.wapperSelector );	
		var wrapOuter = $('<div class="sliders-wrapper"></div>').width( this.maxWidth );
		this.wrapper.wrap( wrapOuter );
		
		this.slides = this.wrapper.find( this.settings.mainItemSelector ); 
		if( !this.wrapper.length || !this.slides.length ) return ;
		// set width of wapper
		if( this.settings.maxItemDisplay > this.slides.length ){
			this.settings.maxItemDisplay = this.slides.length;	
		}
		this.currentNo      = isNaN(this.settings.startItem)||this.settings.startItem > this.slides.length?0:this.settings.startItem;
		this.navigatorOuter = $( obj ).find( this.settings.navOuterSelector );	
		this.navigatorItems = $( obj ).find( this.settings.navItemsSelector ) ;
		this.navigatorInner = this.navigatorOuter.find( this.settings.navInnerSelector );
		// if use automactic calculate width of navigator
		
	 	if( this.settings.navigatorHeight == null || this.settings.navigatorWidth == null ){
			this.settings.navigatorHeight = this.navigatorItems.eq(0).outerWidth(true);
			this.settings.navigatorWidth = this.navigatorItems.eq(0).outerHeight(true);
			
		}
		if( this.settings.navPosition == 'horizontal' ){ 
			this.navigatorInner.width( this.slides.length * this.settings.navigatorWidth );
			this.navigatorOuter.width( this.settings.maxItemDisplay * this.settings.navigatorWidth );
			this.navigatorOuter.height(	this.settings.navigatorHeight );
			
		} else {
			this.navigatorInner.height( this.slides.length * this.settings.navigatorHeight );	
			
			this.navigatorOuter.height( this.settings.maxItemDisplay * this.settings.navigatorHeight );
			this.navigatorOuter.width(	this.settings.navigatorWidth );
		}		
		this.slides.width( this.settings.mainWidth );	
		this.navigratorStep = this.__getPositionMode( this.settings.navPosition );		 
		this.directionMode = this.__getDirectionMode();  
		
		
		if( this.settings.direction == 'opacity') {
			this.wrapper.addClass( 'lof-opacity' );
			$(this.slides).css({'opacity':0,'z-index':1}).eq(this.currentNo).css({'opacity':1,'z-index':3});
		} else { 
			this.wrapper.css({'left':'-'+this.currentNo*this.maxSize+'px', 'width':( this.maxWidth ) * this.slides.length } );
		}

		
		if( this.settings.isPreloaded ) {
			this.preLoadImage( this.onComplete );
		} else {
			this.onComplete();
		}
		
		$buttonControl = $( ".button-control", obj);
		if( this.settings.auto ){
			$buttonControl.addClass("action-stop");
		} else {
			$buttonControl.addClass("action-start");
		}
		var self = this;
		
		$( obj ).hover(function(){
				self.stop();	
				$buttonControl.addClass("action-start").removeClass("action-stop").addClass("hover-stop");
		}, function(){
			if( $buttonControl.hasClass("hover-stop") ){
		
				if(	self.settings.auto ){
					$buttonControl.removeClass("action-start").removeClass("hover-stop").addClass("action-stop");
					self.play( self.settings.interval,'next', true );		
				}
			}
		} );
		
		
		$buttonControl.click( function() {
			if( $buttonControl.hasClass("action-start") ){
				self.settings.auto =true;
				self.play( self.settings.interval,'next', true );
				$buttonControl.removeClass("action-start").addClass("action-stop");
			} else{
				self.settings.auto =false;
				self.stop();	
				$buttonControl.addClass("action-start").removeClass("action-stop");
			}
		} );
	 }
     $.lofSidernews.fn =  $.lofSidernews.prototype;
     $.lofSidernews.fn.extend =  $.lofSidernews.extend = $.extend;
	 
	 $.lofSidernews.fn.extend({
							  
		startUp:function( obj, wrapper ) {
			seft = this;

			this.navigatorItems.each( function(index, item ){
				$(item).bind( seft.settings.navigatorEvent,( function(){
					seft.jumping( index, true );
					seft.setNavActive( index, item );					
				} ));
				$(item).css( {'height': seft.settings.navigatorHeight, 'width':  seft.settings.navigatorWidth} );
			})
			this.registerWheelHandler( this.navigatorOuter, this );
			this.setNavActive( this.currentNo );
			this.settings.onComplete( this.slides.eq(this.currentNo ),this.currentNo  );
			if( this.settings.buttons && typeof (this.settings.buttons) == "object" ){
				this.registerButtonsControl( 'click', this.settings.buttons, this );

			}
			if( this.settings.auto ) 
			this.play( this.settings.interval,'next', true );
			
			return this;
		},
		onComplete:function(){
			setTimeout( function(){ $('.preload').fadeOut( 900, function(){  $('.preload').remove(); } ); }, 400 );	this.startUp( );
		},
		preLoadImage:function(  callback ){
			var self = this;
			var images = this.wrapper.find( 'img' );
	
			var count = 0;
			images.each( function(index,image){ 
				if( !image.complete ){				  
					image.onload =function(){
						count++;
						if( count >= images.length ){
							self.onComplete();
						}
					}
					image.onerror =function(){ 
						count++;
						if( count >= images.length ){
							self.onComplete();
						}	
					}
				}else {
					count++;
					if( count >= images.length ){
						self.onComplete();
					}	
				}
			} );
		},
		navivationAnimate:function( currentIndex ) { 
			if (currentIndex <= this.settings.startItem 
				|| currentIndex - this.settings.startItem >= this.settings.maxItemDisplay-1) {
					this.settings.startItem = currentIndex - this.settings.maxItemDisplay+2;
					if (this.settings.startItem < 0) this.settings.startItem = 0;
					if (this.settings.startItem >this.slides.length-this.settings.maxItemDisplay) {
						this.settings.startItem = this.slides.length-this.settings.maxItemDisplay;
					}
			}		
		
			this.navigatorInner.stop().animate( eval('({'+this.navigratorStep[0]+':-'+this.settings.startItem*this.navigratorStep[1]+'})'), 
												{duration:500, easing:'easeInOutQuad'} );	
		},
		setNavActive:function( index, item ){
			if( (this.navigatorItems) ){ 
				this.navigatorItems.removeClass( 'active' );
				$(this.navigatorItems.get(index)).addClass( 'active' );	
				this.navivationAnimate( this.currentNo );	
			}
		},
		__getPositionMode:function( position ){
			if(	position  == 'horizontal' ){
				return ['left', this.settings.navigatorWidth];
			}
			return ['top', this.settings.navigatorHeight];
		},
		__getDirectionMode:function(){
			switch( this.settings.direction ){
				case 'opacity': this.maxSize=0; return ['opacity','opacity'];
				default: this.maxSize=this.maxWidth; return ['left','width'];
			}
		},
		registerWheelHandler:function( element, obj ){ 
			 element.bind('mousewheel', function(event, delta ) {
				var dir = delta > 0 ? 'Up' : 'Down',
					vel = Math.abs(delta);
				if( delta > 0 ){
					obj.previous( true );
				} else {
					obj.next( true );
				}
				return false;
			});
		},
		registerButtonsControl:function( eventHandler, objects, self ){ 
			for( var action in objects ){ 
				switch (action.toString() ){
					case 'next':
						objects[action].click( function() { self.next( true) } );
						break;
					case 'previous':
						objects[action].click( function() { self.previous( true) } );
						break;
				}
			}
			return this;	
		},
		onProcessing:function( manual, start, end ){	 		
			this.previousNo = this.currentNo + (this.currentNo>0 ? -1 : this.slides.length-1);
			this.nextNo 	= this.currentNo + (this.currentNo < this.slides.length-1 ? 1 : 1- this.slides.length);				
			return this;
		},
		finishFx:function( manual ){
			if( manual ) this.stop();
			if( manual && this.settings.auto ){ 
				this.play( this.settings.interval,'next', true );
			}		
			this.setNavActive( this.currentNo );
			this.settings.onPlaySlider( this, $(this.slides).eq(this.currentNo) );
		},
		getObjectDirection:function( start, end ){
			return eval("({'"+this.directionMode[0]+"':-"+(this.currentNo*start)+"})");	
		},
		fxStart:function( index, obj, currentObj ){
				var s = this;
				if( this.settings.direction == 'opacity' ) { 
					
					$(this.slides).stop().animate({opacity:0}, {duration: this.settings.duration, easing:this.settings.easing,complete:function(){ 
																					s.slides.css("z-index","1")
																					s.slides.eq(index).css("z-index","3");															
																						}} );
					$(this.slides).eq(index).stop().animate( {opacity:1}, { duration : this.settings.duration, 
																		    easing   :this.settings.easing,
																		    complete :function(){ s.settings.onComplete($(s.slides).eq(index),index); }} );
				}else {
					this.wrapper.stop().animate( obj, {duration: this.settings.duration, easing:this.settings.easing,complete:function(){ 
																										s.settings.onComplete($(s.slides).eq(index),index)								   
																									} } );
				}
			return this;
		},
		jumping:function( no, manual ){
			this.stop(); 
			if( this.currentNo == no ) return;		
			 var obj = eval("({'"+this.directionMode[0]+"':-"+(this.maxSize*no)+"})");
			this.onProcessing( null, manual, 0, this.maxSize )
				.fxStart( no, obj, this )
				.finishFx( manual );	
				this.currentNo  = no;
		},
		next:function( manual , item){

			this.currentNo += (this.currentNo < this.slides.length-1) ? 1 : (1 - this.slides.length);	
			this.onProcessing( item, manual, 0, this.maxSize )
				.fxStart( this.currentNo, this.getObjectDirection(this.maxSize ), this )
				.finishFx( manual );
		},
		previous:function( manual, item ){
			this.currentNo += this.currentNo > 0 ? -1 : this.slides.length - 1;
			this.onProcessing( item, manual )
				.fxStart( this.currentNo, this.getObjectDirection(this.maxSize ), this )
				.finishFx( manual	);			
		},
		play:function( delay, direction, wait ){	
			this.stop(); 
			if(!wait){ this[direction](false); }
			var self  = this;
			this.isRun = setTimeout(function() { self[direction](true); }, delay);
		},
		stop:function(){ 
			if (this.isRun == null) return;
			clearTimeout(this.isRun);
            this.isRun = null; 
		}
	})
})(jQuery)

