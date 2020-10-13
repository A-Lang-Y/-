/*
 * Extend String Object with addslashes and stripslashes methods
 */
String.prototype.stripslashes = function() {
  return (this + '').replace(/\\(.?)/g, function (s, n1) {
    switch (n1) {
    case '\\':
      return '\\';
    case '0':
      return '\u0000';
    case '':
      return '';
    default:
      return n1;
    }
  });
};



(function( window, $, undefined ) {

	$.yit_portfolio_libra = function( options, element ) {
		this.element = $( element );
		this._init( options );
	};

	$.yit_portfolio_libra.defaults	= {
		elements : {
			thumb: '.work-thumbnail',
			thumbs: '.work-projects ul:first',
			content: '.work-content',
			meta: '.work-meta',
			loading: 'div.work-loading',
			title: '.work-title'
		},
		pagination : {
			pageSize : 9,
			pagerStyle : 'arrows' //arrows, numbers
		},
		slider : false,
		json : null,
		url  : null,
		overlay : false,
		type : 'portfolio' //portfolio, section
    };

	$.yit_portfolio_libra.prototype = {
		_init : function( options ) {
			this.options = $.extend( true, {}, $.yit_portfolio_libra.defaults, options );
			if( this.options.url == null || this.options.json == null || this._parseJson() == null ) return false;

			this.loading = this.element.find( this.options.elements.loading );
			this._initEvents();
		},
		
		_parseJson : function() {
			var json = null;
			try {
				json = $.parseJSON( this.options.json );
				this.options.works = json;
			} catch(e) {
				console.error(e);
				json = null;
			}

			return json !== null;
		},
		
		_initEvents : function() {
			var elements = this.options.elements;
			var self = this;

			if( this.options.pagination !== false ) {
				this._pagination();
			}
			
			if( this.options.slider !== false ) {
				this._slider();
			}
			
			//thumbs click
			self.element.find(elements.thumbs).on('click', 'a', function(e){
				e.preventDefault();
				
				self.element.find(elements.thumbs).find('a').removeClass('active');
				
				var item = $(this).addClass('active').data('item');
				self._loadItem( item );
			}).find('a:first').click();
			
			//responsive hacks
			if( this.options.type == 'portfolio' ) {
				this._mobileSolution();
				
				$(window).resize(function(){
					self._mobileSolution();
				});
			}
		},
		
		_pagination : function() {
			if( $.yit_pagination ) {
				this.element.find(this.options.elements.thumbs).yit_pagination( this.options.pagination );
			}
		},
		
		_slider : function() {
			var self = this;
			this.element.find(this.options.elements.thumbs).imagesLoaded(function(){
				self.element.find(self.options.elements.thumbs).carouFredSel( self.options.slider );
			});
		}, 
		
		_loadItem : function(item) {
			var self = this;
			this.current = item;
			
			this._loading();
			
			$.ajax({
				type: 'POST',
				url: self.options.url,
				data: {
					work: self.options.works[item],
					action: 'yit_portfolio_libra',
					overlay: self.options.overlay,
					type: self.options.type
				},
				success: function(json) {
					var json = $.parseJSON(json);
					
					var thumb_container = self.element.find(self.options.elements.thumb);
					var content_container = self.element.find(self.options.elements.content);
					var meta_container = self.element.find(self.options.elements.meta);
					var title_container = self.element.find(self.options.elements.title);
					
					title_container.html(json.title);
					thumb_container.html('').append(json.thumb).fadeIn();
					
					if( self.options.type == 'portfolio' ) {
						content_container.html('').append(json.content).fadeIn();
						meta_container.html('').append(json.meta).fadeIn();
					} else {
						content_container.find('.content').html('').append(json.content).fadeIn();
						meta_container.html('').append(json.meta).fadeIn();
					}
					

					
					self._initLightboxSlider();
				},
				error: function(MLHttpRequest, textStatus, errorThrown) {
					console.log(textStatus, errorThrown);
				}
			});
		},
		
		_loading : function() {
			this.element.find(this.options.elements.thumb).html( this.loading );
		},
		
		_initLightboxSlider : function() {
			$('.extra-images-slider').flexslider({
            	controlNav: false
            });
            
            $('.work-thumbnail a[rel=lightbox_libra]').colorbox({
				transition:'elastic',
				rel:'lightbox_libra',
				fixed:true,
				maxWidth: '80%',
				maxHeight: '80%',
				opacity : 0.7
			});
			
		  	$('.picture_overlay').hover(function(){
		  		
			  	var width = $(this).find('.overlay div').innerWidth();
			  	var height =  $(this).find('.overlay div').innerHeight();
			  	var div = $(this).find('.overlay div').css({
			  		'margin-top' : - height / 2,
			  		'margin-left' : - width / 2
			  	});
		  		
				if(isIE8()) {
		  			$(this).find('.overlay > div').show();
		  		}
		  	}, function(){
		  		
		  		if(isIE8()) {
		  			$(this).find('.overlay > div').hide();
		  		}
		  	}).each(function(){
			  	var width = $(this).find('.overlay div').innerWidth();
			  	var height =  $(this).find('.overlay div').innerHeight();
			  	var div = $(this).find('.overlay div').css({
			  		'margin-top' : - height / 2,
			  		'margin-left' : - width / 2
			  	});
			});
		},
		
		_mobileSolution: function() {
			var min_width = 768;
			var element = this.element;
			var thumbs_container = element.find(this.options.elements.thumbs).parents('div.work-projects');
			var content_container = element.find(this.options.elements.content).parents('div.work-content-wrapper');
			var width = $('body').outerWidth();

			if( width >= min_width && $('.work-projects+.work-content-wrapper').length <= 0 ) {
				//from ipad portrait to wide desktops
				thumbs_container.after( content_container );
			} else if( width < min_width && $('.work-projects+.work-content-wrapper').length > 0 ) {
				//mobile
				thumbs_container.before( content_container );
			} else {
				//everything is ok
			}
		}
		
	};

	$.fn.yit_portfolio_libra = function( options ) {
		if ( typeof options === 'string' ) {
			var args = Array.prototype.slice.call( arguments, 1 );

			this.each(function() {
				var instance = $.data( this, 'yit_portfolio_libra' );
				if ( !instance ) {
					console.error( "cannot call methods on yit_checkout prior to initialization; " +
					"attempted to call method '" + options + "'" );
					return;
				}
				if ( !$.isFunction( instance[options] ) || options.charAt(0) === "_" ) {
					console.error( "no such method '" + options + "' for yit_portfolio_libra instance" );
					return;
				}
				instance[ options ].apply( instance, args );
			});
		} 
		else {
			this.each(function() {
				var instance = $.data( this, 'yit_portfolio_libra' );
				if ( !instance ) {
					$.data( this, 'yit_portfolio_libra', new $.yit_portfolio_libra( options, this ) );
				}
			});
		}
		return this;
	};


})( window, jQuery );
