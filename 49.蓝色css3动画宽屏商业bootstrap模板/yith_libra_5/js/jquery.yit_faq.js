(function( window, $, undefined ) {

	$.yit_faq = function( options, element ) {
		this.element = $( element );
		this._init( options );
	};

	$.yit_faq.defaults	= {
		elements : {
			items: $('.faq-wrapper'),
			header: '.faq-title',
			content: '.faq-item',
			filters: $('.filters li a')
		}
    };

	$.yit_faq.prototype = {
		_init : function( options ) {
			this.options = $.extend( true, {}, $.yit_faq.defaults, options );

			this._initSizes();
			this._initEvents();
		},
		
		_initSizes : function() {
			$(this.options.elements.content, this.element).each(function(){
				var parentWidth = $(this).parent().width();
				$(this).width(parentWidth);
			})
		},
		
		_initEvents : function() {
			var elements = this.options.elements;
			var self = this;
			
			//filters
			elements.filters.on('click.yit', function(e){
				e.preventDefault();
				
				if( !$(this).hasClass('active') ) {
					elements.filters.removeClass('active').filter(this).addClass('active');
					
					self._closeAll();
					self._filterItems( $(this).data('option-value') );
				}
			});
			
			//single items
			elements.items.on('click.yit', elements.header, function(e){
				e.preventDefault();
				self._toggle( $(this) );
			});
			
			$(window).resize(function(e){
				self._initSizes();
			});
		},
		
		_filterItems : function( selector ) {
			var items = this.options.elements.items;
			
			items.filter(':visible').fadeOut('slow', function(){
				items.filter(selector).fadeIn();
			});
		},
		
		_toggle : function( selector ) {
			if( selector.next().is(':visible') ) {
				this._close( selector );
			} else {
				this._open( selector );
			}
		},
		
		_open : function( selector ) {
			selector.toggleClass('active').find(':first-child').toggleClass('plus').toggleClass('minus');
			selector.siblings( this.options.elements.content ).slideDown();
		},
		
		_close : function( selector, animation ) {
			selector.toggleClass('active').find(':first-child').toggleClass('plus').toggleClass('minus');
			selector.siblings( this.options.elements.content ).slideUp();
		},
		
		_closeAll : function() {
			var headers = $( this.options.elements.header ).filter('.active');
			var self = this;
			
			headers.each(function(){
				self._close( $(this) );
			});
		}
		
	};

	$.fn.yit_faq = function( options ) {
		if ( typeof options === 'string' ) {
			var args = Array.prototype.slice.call( arguments, 1 );

			this.each(function() {
				var instance = $.data( this, 'yit_faq' );
				if ( !instance ) {
					console.error( "cannot call methods on yit_checkout prior to initialization; " +
					"attempted to call method '" + options + "'" );
					return;
				}
				if ( !$.isFunction( instance[options] ) || options.charAt(0) === "_" ) {
					console.error( "no such method '" + options + "' for yit_faq instance" );
					return;
				}
				instance[ options ].apply( instance, args );
			});
		} 
		else {
			this.each(function() {
				var instance = $.data( this, 'yit_faq' );
				if ( !instance ) {
					$.data( this, 'yit_faq', new $.yit_faq( options, this ) );
				}
			});
		}
		return this;
	};


})( window, jQuery );
