/**
*	@package: CloudFw / Envision
*	@access: Envision
*/

/* ========================================
    ACCORDIONS (includes.shortcodes.shortcode.accordions)
========================================*/
jQuery(document).ready(function(){
	"use strict";

	jQuery.fn.extend({

		CloudFwAccordions: function() {
			var in_progress = false,
				accordion_wrap  = this,
				accordion_items = accordion_wrap.children().not('.ui--accordion-state-static');

			accordion_items.find('> a').click(function( e ) {
				e.preventDefault();

				if ( in_progress === true ) {
					return false;
				}

				in_progress = true;

				var that = jQuery(this),
					item = that.parents('.ui--accordion-item').first();

				item.addClass('not');
				accordion_items.not('.not').removeClass('ui--accordion-state-opened').addClass('ui--accordion-state-closed');

				if (item.hasClass('ui--accordion-state-opened')) {
					item.removeClass('ui--accordion-state-opened').removeClass('not').addClass('ui--accordion-state-closed');
					in_progress = false;

				} else {
					item.removeClass('ui--accordion-state-closed').removeClass('not').addClass('ui--accordion-state-opened');
					in_progress = false;

				}

				jQuery(window).trigger('scroll');
				jQuery(window).trigger('make@2x');

			});

		}

	});

    /** Init Toggles */
    jQuery('.ui--accordion').each(function () {
        jQuery(this).CloudFwAccordions();
    });

});

/* ========================================
    CAROUSEL (includes.shortcodes.shortcode.carousel)
========================================*/
var boxGalleryInit;

jQuery(document).ready(function(){
	"use strict";

	if ( jQuery.isFunction( jQuery.fn.flexslider ) ) {

		var carouselInit = function( parent ){
			if ( typeof parent == 'undefined' || !parent.jquery )
				parent = jQuery( '.ui--carousel' );

			parent.each(function(){
				var that = jQuery(this);
				var fullwidth = ! that.parents('.ui-row').length;
				var pass = that.parents('.ui--pass');
				var wrapper = pass.length ? pass : that;

				var title_bordered = that.prev('.ui--title-bordered').length ? that.prev('.ui--title-bordered') : wrapper.prev('.ui--title-bordered');
				var title_widget = wrapper.prev('.ui--widget-title');
				var slider_data = that.data('flexslider');


				if ( !slider_data ) {
	
					var slides = that.find('.slides');

					if ( slides.length > 1 ) {
						slides.last().unwrap();
					}

					if ( fullwidth ) {
						that.addClass( 'fullwidth-content' );
						var children = slides.first().children();

						children.each(function(){
							var child = jQuery(this);

							if ( child.hasClass('.ui-row') ) {
								child.wrap('<div class="ui--carousel-content clearfix" />').wrap('<div class="container" />');
							} else {
								child.wrap('<div class="ui--carousel-content clearfix" />').wrap('<div class="container" />').wrap('<div class="ui-row" />');
							}

						});

						prepareResponsiveFullwidthContainerPage( that );
					} else {
						slides.first().children('.ui-row').wrap('<div class="ui--carousel-content clearfix" />');
					}

					var items = slides.children(); 
					if ( !( items.length > 1 ) ) {
						items.show();
						return false;
					}

					var options = CloudFwParseAttribute(that.attr('data-options'));

					if ( options.auto_rotate == '1' ) {
						options.auto_rotate = true;
					} else {
						options.auto_rotate = false; 
					}

					if ( options.animation_loop == '1' ) {
						options.animation_loop = true;
					} else {
						options.animation_loop = false; 
					}

					if ( typeof options.animate == 'undefined' || options.animate == '1' ) {
						options.animate = 600;
					} else {
						options.animate = 1; 
					}

					var that = that.flexslider({
						namespace: "ui--carousel-",
						selector: ".slides > div",
						animation: options.effect || "slide",
						slideshow: options.auto_rotate,
						//slideshow: false,
						slideshowSpeed: options.rotate_time || 7000,
						smoothHeight: true,
						animationLoop: options.animation_loop || false,
						controlNav: false,
						directionNav: false,
						animationSpeed: 1000,
						itemMargin: 30,
						start: function( obj ) {
							if ( typeof boxGalleryInit != 'undefined' ) {
								boxGalleryInit( that );
							}
						}

					});

					var slider_data = that.data('flexslider');

					if ( options.arrows == '1' ) {

						var to_prev = function(){ that.flexslider('prev'); jQuery(window).scroll(); } 
						var to_next = function(){ that.flexslider('next'); jQuery(window).scroll(); } 

						if ( title_bordered.length ) {
							title_bordered.addClass('with-navigation');
							title_bordered.find('.ui--title-navigation').remove();
							title_bordered.append( jQuery('<div/>').addClass('ui--title-navigation') );
							title_bordered.find('.ui--title-navigation').html('<span class=\"arr arr-small arr-plain arr-left ui--carosuel-prev\"><span></span><i class=\"fontawesome-angle-left px18\"></i></span> <span class=\"arr arr-small arr-plain ui--carosuel-next\"><span></span><i class=\"fontawesome-angle-right px18\"></i></span>');
							title_bordered.find('.ui--title-navigation > .ui--carosuel-prev').click( to_prev );
							title_bordered.find('.ui--title-navigation > .ui--carosuel-next').click( to_next );
						} else if ( title_widget.length ) {
							title_widget.addClass('with-navigation');
							title_widget.find('.ui--title-navigation').remove();
							title_widget.append( jQuery('<div/>').addClass('ui--title-navigation') );
							title_widget.find('.ui--title-navigation').html('<span class=\"arr arr-plain arr-left ui--carosuel-prev\"><span></span><i class=\"fontawesome-angle-left px18\"></i></span> <span class=\"arr arr-plain ui--carosuel-next\"><span></span><i class=\"fontawesome-angle-right px18\"></i></span>');
							title_widget.find('.ui--title-navigation > .ui--carosuel-prev').click( to_prev );
							title_widget.find('.ui--title-navigation > .ui--carosuel-next').click( to_next );
						} else {
							that.find('.ui--carousel-navigation').remove();
							that.append( jQuery('<div/>').addClass('ui--carousel-navigation clearfix') );
							that.find('.ui--carousel-navigation').html('<span class=\"arr arr-normal arr-left ui--carosuel-prev\"><span></span><i class=\"fontawesome-chevron-left px18\"></i></span> <span class=\"arr arr-normal ui--carosuel-next\"><span></span><i class=\"fontawesome-chevron-right px18\"></i></span>');
							that.find('.ui--carousel-navigation > .ui--carosuel-prev').click( to_prev );
							that.find('.ui--carousel-navigation > .ui--carosuel-next').click( to_next );
						}

					}

				}

			});

		} 

		/*var timeout = setTimeout( function(){
			carouselInit();
			clearTimeout( timeout );
		}, 500);
		*/
		jQuery( '.ui--carousel' ).each(function(){
			var that = jQuery(this);
			that.find('.slides > div:first').find('img:first').imagesLoaded(function(){
				var timeout = setTimeout( function(){
					carouselInit( that );
					clearTimeout( timeout );
				}, 300);
				
			});
		});
		jQuery(window).load(carouselInit);




		boxGalleryInit = function( parent ){

			parent.find( '.ui--content-box-gallery' ).each(function(){
				var that = jQuery(this);
				var slider_data = that.data('flexslider');


				if ( !slider_data ) {

					jQuery(window).load(function(){ boxGalleryInit( parent ); });
					var options = CloudFwParseAttribute(that.attr('data-options'));
						options.auto_rotate = (options.auto_rotate == '1') ? true : false;

					that.flexslider({
						namespace: "ui--content-box-gallery-",
						selector: ".mini-slides > div",
						animation: options.effect || "slide",
						slideshow: options.auto_rotate || false,
						slideshowSpeed: 7000,
						smoothHeight: true,
						controlNav: false,
						directionNav: false,
						keyboard: false
					});

					var slider_data = that.data('flexslider');

					var to_prev = function(){ that.flexslider("prev"); } 
					var to_next = function(){ that.flexslider("next"); } 

					that.find('.ui--content-box-gallery-navigation').remove();
					that.append( jQuery('<div/>').addClass('ui--content-box-gallery-navigation') );
					that.find('.ui--content-box-gallery-navigation').html('<span class=\"arr arr-normal arr-left ui--carosuel-prev\"><span></span><i class=\"fontawesome-chevron-left px18\"></i></span> <span class=\"arr arr-normal ui--carosuel-next\"><span></span><i class=\"fontawesome-chevron-right px18\"></i></span>');
					that.find('.ui--content-box-gallery-navigation > .ui--carosuel-prev').click( to_prev );
					that.find('.ui--content-box-gallery-navigation > .ui--carosuel-next').click( to_next );
					

				}

			});

		} 

		jQuery('.ui--content-box').each(function(){
			var that = jQuery(this),
				parents = that.parents(); 

			if ( !parents.filter('.ui--carousel').length && !parents.filter('.ui--masonry').length ) {
				boxGalleryInit( that );
				jQuery(window).load(function(){ boxGalleryInit( that ); });
			}
			

		});




	} 

});

/* ========================================
    GALLERY (includes.shortcodes.shortcode.gallery)
========================================*/
(function( jQuery ){
	"use strict";

	jQuery(document).ready(function(){

		if ( !CloudFwOp.gallery_overlay_opacity ) {
			CloudFwOp.gallery_overlay_opacity = 0.60;
		}

		jQuery('.ui--gallery-item a').hover(function(){
			var that = jQuery(this),
				overlay = that.find('.ui--gallery-overlay');

			overlay.stop(1).fadeTo(500, CloudFwOp.gallery_overlay_opacity);

		},function(){
			var that = jQuery(this),
				overlay = that.find('.ui--gallery-overlay');

			overlay.stop(1).fadeTo(500,0);

		});

	});

})(jQuery);

/* ========================================
    GMAP (includes.shortcodes.shortcode.gmap)
========================================*/
jQuery(document).ready(function(){
	"use strict";

	jQuery(".gmap").each(function(){
		var that     = jQuery(this),
			gmap     = '',
			api      = '',
			data     = that.attr('data-gmap-options') || '',
			defaults = {};
		
		try {
			
			if ( typeof data != 'object' ) {
				var gmap_metadata = jQuery.parseJSON( data );
			} else {
				var gmap_metadata = data;
			}

		} catch (e) {
			var gmap_metadata = {};
		}

		var defaults = {
			zoom            : 12,
			latitude        : 0,
			longitude       : 0,
			maptype         : "ROADMAP",
			doubleclickzoom : 1,
			scrollwheel     : 1,
			controls        : false
		};

		var gmap_options = jQuery.extend( {}, defaults, gmap_metadata );

		that.unbind('gMapReady').bind('gMapReady',function(){
			gmap = that.gMap( gmap_options );
			api  = that.data('gMap.reference');
			that.data( "gMapReady", true );

			var styles = gmap_options.stylers || {};

			if ( styles ) {
				api.setOptions({styles: styles});
			}
		
		}).data("gMapReady", false);

		var init_now = true;

		if ( init_now ) {
			that.trigger( 'gMapReady' );
		}

		var device_callback = function(){
			var device = detectDeviceViaPageWidth(); 

			if ( device == 'phone' ) {
				that.trigger('gMapReady');
			}
		}

		device_callback();
		//jQuery(window).bind('CloudFwDetectDevice', device_callback );

	});

}); 

/* ========================================
    MASONRY (includes.shortcodes.shortcode.masonry)
========================================*/
jQuery(document).ready(function(){
	"use strict";

	//return true;

	if ( jQuery.isFunction( jQuery.fn.isotope ) ) {

		// code found on this page: http://isotope.metafizzy.co/custom-layout-modes/masonry-gutters.html

		// modified Isotope methods for gutters in masonry
		jQuery.Isotope.prototype._getMasonryGutterColumns = function() {
			var gutter = this.options.masonry && this.options.masonry.gutterWidth || 0;
			var containerWidth = this.element.width();

			this.masonry.columnWidth = this.options.masonry && this.options.masonry.columnWidth ||
			// or use the size of the first item
			this.$filteredAtoms.outerWidth(true) ||
			containerWidth;

			this.masonry.columnWidth += gutter;

			this.masonry.cols = Math.floor((containerWidth + gutter) / this.masonry.columnWidth);
			this.masonry.cols = Math.max(this.masonry.cols, 1);
		}

		jQuery.Isotope.prototype._masonryReset = function() {
			// layout-specific props
			this.masonry = {};
			this._getMasonryGutterColumns();
			var i = this.masonry.cols;
			this.masonry.colYs = [];
			while (i--) {
				this.masonry.colYs.push(0);
			}
		}

		jQuery.Isotope.prototype._masonryResizeChanged = function() {
			var prevSegments = this.masonry.cols;
			// update cols/rows
			this._getMasonryGutterColumns();
			// return if updated cols/rows is not equal to previous
			return (this.masonry.cols !== prevSegments);
		}

		var masonryInit = function(){

			jQuery( '.ui--masonry' ).each(function(){
				var that = jQuery(this);
				var title_bordered = that.prev('.ui--title-bordered');
				var title_widget = that.prev('.ui--widget-title');
				var masonry_data = that.data('masonry');
				var init = new Object();
				var is_fluid = false;

				if ( that.hasClass('row-fluid') || that.parents('.ui-row').length ) {
					is_fluid = true; 
				}

				if ( !masonry_data ) {
					
					CloudFwLoaded( that );

					var items = that.find('.ui--content-item');
					items.each(function(){
						if( !jQuery(this).parent().hasClass('ui-column') ) {
							jQuery(this).wrap('<div class="ui-column span12"/>');
						}
					});
					
					that.find('> .ui-row > .ui-column').addClass('ui--isotope-item');
					that.imagesLoaded(masonryInit);
				
				}

				if ( masonry_data == true && !is_fluid ) {
					that.isotope( 'reLayout' );
					return false;
				}

				/** Init Object */
				init.resizable = false;
				init.itemSelector = '.ui--isotope-item';
				init.onLayout = function(){
					that.show();
					if ( typeof boxGalleryInit != 'undefined' )
						boxGalleryInit( that );
				};
				init.layoutMode = 'masonry';

				if ( is_fluid ) {
					var containerWidth = that.width(),
						column = CloudFwGetColumByClassname( that.find('.ui--isotope-item') ),
						gutter = (containerWidth * column) / 100, 
						gutterWidth = gutter * (column - 1),
						columnWidth = Math.floor(((containerWidth - gutterWidth) / column));

					init.masonry = {
						columnWidth: columnWidth,
						gutterWidth: gutter
					};
				}

				that.data('masonry',true);
				that.css("visibility", "visible").css("overflow", "visible").isotope(init);
				that.addClass('ui--done');

			});

		} 

		if ( BrowserDetect.browser == 'IE' ) {
			jQuery(window).load(masonryInit);
		} else {
			masonryInit();
		}
		
		jQuery(window).smartresize(masonryInit, 5000);
		jQuery(document).ajaxSuccess(masonryInit);

	} 

});

/* ========================================
    TABLE (includes.shortcodes.shortcode.pricing_table)
========================================*/
jQuery(document).ready(function(){
	"use strict";

	var pricingTableInit = function(){

		jQuery('.ui--pricing-table').each(function(){
			var that = jQuery(this),
				before_htmls = that.find( '.ui--pricing-table-before-html' ),
				features = that.find( '.ui--pricing-table-features' );

			before_htmls.css({'min-height': ''}).css({'min-height': Math.max.apply(null, before_htmls.map(function(){return jQuery(this).height();}).get())});

			features.first().children('.ui--pricing-table-feature').each(function(){
				var group = jQuery(this).attr('data-group'),
					items = that.find( '.' + group ); 

				items.css({'min-height': ''}).css({'min-height': Math.max.apply(null, items.map(function(){return jQuery(this).height();}).get())});

			});

		});

	}

	pricingTableInit();
	jQuery(window).load( pricingTableInit );
	jQuery(window).smartresize( pricingTableInit );

});

/* ========================================
    PROGRESS BAR (includes.shortcodes.shortcode.progress_bar)
========================================*/
jQuery(document).ready(function(){
	"use strict";

	if ( ! jQuery.isFunction( jQuery.inviewport ) ) 
		return false;

	var progressBarInit = function(){

		jQuery('.ui--progress:in-viewport').each(function(){
			var that = jQuery(this);

			if( ! that.hasClass('animated') ) {
				var percent	= that.find('.ui--progress-percent');
				var callback = function(){

				}

				percent.css({'visibility': 'visible'});
				if ( animation_type == 'css' ) {

					that.addClass('lock');
					that.addClass('animated');

			        var delay = setInterval(function(){
						that.removeClass('lock');
			            clearInterval(delay);
			        }, 500);

					that.bind("transitionend webkitTransitionEnd oTransitionEnd MSTransitionEnd", callback);

				} else {
					
					that.addClass('animated');
					var width = percent.attr('data-value');
					percent.width('0').animate({'width': width}, 600, callback);
				
				}
				

			}
		});

	} 

	if ( jQuery('.ui--progress').length ) {
		var animation_type = jQuery('html').hasClass('cssanimations') ? 'css' : 'javascript';

		if ( animation_type == 'css' ) {
			progressBarInit();
			jQuery(window).load( progressBarInit );
			jQuery(window).scroll( jQuery.throttle( 250, progressBarInit ) );
		}
		
	}
});

/* ========================================
    PROGRESS CIRCLE (includes.shortcodes.shortcode.progress_circle)
========================================*/
jQuery(document).ready(function(){
	"use strict";

	if ( ! jQuery.isFunction( jQuery.inviewport ) || ! jQuery.isFunction( jQuery.easyPieChart ) ) {
		return false;
	}

	var initPieChart = function() {
		jQuery('.ui--progress-circle').each(function(){
			var that = jQuery(this),
				wrapper = that.parent(),
				wrapper_width = wrapper.width(),
				percent_text = wrapper.find('.ui--progress-circle-percent'),
				percent = parseInt(that.attr('data-percent-update'), 10),
				width = parseInt(that.attr('data-width'), 10);

			if ( !width || width > wrapper_width ) {
				width = wrapper_width;
			}

			that.easyPieChart({
				animate: 1000,
				trackColor: '#f1f1f1',
				barColor: '#169FE5',
				scaleColor: false,
				lineCap: 'butt',
				rotate: -90,
				lineWidth: 15,
				size: width,
				onStep: function(value) { percent_text.text(~~value); },
				onStop: function(value) { percent_text.text(percent); }
			});

			that.find('.ui--center-vertical').uiVerticalCenter();


		});

		initPieChartUpdate();

	};

	var initPieChartResize = function() {

		jQuery('.ui--progress-circle').each(function(){
			var that = jQuery(this);

			that.removeData( 'easyPieChart' );
			that.removeData( 'inViewport' );
			that.css({
				'width'			: '',
				'height'		: '',
				'line-height'	: ''
			});
			that.find('canvas').remove();

		});

		initPieChart();

	};

	var initPieChartUpdate = function() {
		jQuery('.ui--progress-circle:in-viewport').each(function(){
			var that = jQuery(this);

			if ( ! that.is(':visible') ) {
				return true;
			}

			if ( that.data('inViewport') ) {
				return true;
			}

			that.data('inViewport', true);

			var percent = parseInt(that.attr('data-percent-update'), 10);
			that.data('easyPieChart').update( percent );
		});
	};


	if ( jQuery('.ui--progress-circle').length ) {
		var animation_type = jQuery('html').hasClass('cssanimations') ? 'css' : 'javascript';

		if ( animation_type == 'css' ) {
			initPieChart();
			jQuery(window).load( initPieChartUpdate );
			jQuery(window).scroll( jQuery.throttle( 250, initPieChartUpdate ) );
			jQuery(window).smartresize( initPieChartResize, 5000 );
		}
	};

});

/* ========================================
    TABS (includes.shortcodes.shortcode.tabs)
========================================*/
jQuery(document).ready(function(){
	"use strict";

	jQuery.fn.extend({
		/**
		 *  CloudFw Tabs
		 *
		 *  @since 1.0
		 */
		CloudFwTabs: function() {
			var in_proccess = false,
				tabs = this,
				titles = tabs.find('.ui--tabs-header .ui--tabs-titles').children('li'),
				border_before = tabs.find('.ui--tabs-header .ui--tabs-border-before'),
				border_after = tabs.find('.ui--tabs-header .ui--tabs-border-after'),
				border_top = tabs.find('.ui--tabs-header .ui--tabs-border-top'),
				border_bottom = tabs.find('.ui--tabs-header .ui--tabs-border-bottom'),
				contents = tabs.children('.ui--tabs-contents').children('li');

			titles.first().addClass('first-item');
			titles.last().addClass('last-item');

			contents.first().show().removeClass('hidden').addClass('active').addClass('first-item');
			contents.last().addClass('last-item');

			titles.find('a').click(function(e) {
				//e.preventDefault();

				var that    = jQuery(this),
					li      = that.parents('li').first(),
					width   = li.width(),
					height  = li.height(),
					pos     = li.position(),
					index   = li.index();


				if (in_proccess === true ) {
					return false;
				}

				in_proccess = true;

				if ( ! li.hasClass('active') ) {
					contents.filter('.active').removeClass('active').addClass('hidden');
					var current_item = contents.eq(index);

					current_item.removeClass('hidden').addClass('active');

					titles.filter('.active').removeClass('active');
					li.addClass('active');

					/*if ( ! current_item.is(':in-viewport' ) ) {
						var pos = parseInt(current_item.offset().top, 10);

						if ( pos > 100 ) {
							pos = pos - 200;
						}

						jQuery("html, body").scrollTop( pos );
					}*/

				}

				border_after.css( { left: (pos.left + width) } );
				border_before.css( { left: -(border_before.width() - pos.left) } );

				border_top.css( { top: -(border_top.height() - pos.top) } );
				border_bottom.css( { top: (pos.top + height) } );

				tabs.addClass('ui--done');

				in_proccess = false;
				jQuery(window).trigger('scroll');
				jQuery(window).trigger('make@2x');


			});

			titles.first().find('a').click();

			var refresh_titles = function(){
				titles.filter('.active').find('a').click();
			};

			jQuery(window).smartresize(refresh_titles, 20);
			jQuery(document).ready(refresh_titles);
			jQuery(window).load(refresh_titles);

		}

	});

	/** Prepare Tabs */
	jQuery('.ui--tabs').each(function () {
		jQuery(this).CloudFwTabs();
	});

});

/* ========================================
    TITLES (includes.shortcodes.shortcode.titles)
========================================*/
jQuery(document).ready(function(){
	"use strict";

	var bordered_titles_callback = function(){
		jQuery('.ui--title-bordered').each(function(){
			var that		 = jQuery(this),
				text 		 = that.find('.ui--title-text'),
				pos			 = text.position(),
				width		 = text.outerWidth(),
				border_left  = that.find('.ui--title-border-left'),
				border_right = that.find('.ui--title-border-right');


			border_left.show().css({ left: 0 - (border_left.width() - pos.left) });
			border_right.show().css( { left: (pos.left + width) } );

		});
	}

	bordered_titles_callback();
	jQuery(window).load( bordered_titles_callback );
	jQuery(window).smartresize( bordered_titles_callback );


});

/* ========================================
    TOGGLES (includes.shortcodes.shortcode.toggles)
========================================*/
jQuery(document).ready(function(){
	"use strict";

	jQuery.fn.extend({

		CloudFwToggle: function() {
			var in_progress = false,
				toggle      = this,
				title       = toggle.children('.ui--toggle-title'),
				title_link  = title.children('a'),
				content     = toggle.children('.ui--toggle-content');

			title_link.click(function( e ) {
				e.preventDefault();

				if (in_progress === true) {
					return false;
				}

				in_progress = true;

				var that = jQuery(this),
					group = toggle.attr("data-group");

				toggle.addClass('not');

				if (group && toggle.hasClass('ui--toggle-state-closed')) {
					jQuery('[data-group="' + group + '"]').not('.not').removeClass('ui--toggle-state-opened').addClass('ui--toggle-state-closed');
				}

				if (toggle.hasClass('ui--toggle-state-opened')) {
					toggle.removeClass('ui--toggle-state-opened').removeClass('not').addClass('ui--toggle-state-closed');
					in_progress = false;

				} else {
					toggle.removeClass('ui--toggle-state-closed').removeClass('not').addClass('ui--toggle-state-opened');
					in_progress = false;
					jQuery(window).trigger('scroll');
					jQuery(window).trigger('make@2x');
				}

			});


		}

	});

	/** Init Toggles */
	jQuery('.ui--toggle').each(function () {
		jQuery(this).CloudFwToggle();
	});

});

/* ========================================
    GALLERY (includes.shortcodes.shortcode.ui_box)
========================================*/
jQuery(document).ready(function(){
	"use strict";

	if ( jQuery.isFunction( jQuery.fn.flexslider ) ) {
		//jQuery( '.ui--carousel' ).imagesLoaded(boxGalleryInit);

	} 

	jQuery('.ui--content-box').each(function(){
		var that = jQuery(this);
		var options = CloudFwParseAttribute(that.attr('data-ligthbox'));

		if ( options ) {
			if ( options.src ) {
				that.find('.ui--content-box-link').bind('click', function(){
					jQuery.CloudFwPrettyPhoto.open(options.src, null, options.desc);
					return false;

				});
			}
		}


	});



});

/* ========================================
    BLOG (includes.modules.module.blog)
========================================*/
jQuery(document).ready(function(){


		blogGalleryInit = function( parent ){

			jQuery( '.ui--blog-gallery' ).each(function(){
				var that = jQuery(this);
				var slider_data = that.data('flexslider');


				if ( !slider_data ) {

					jQuery(window).load(function(){ blogGalleryInit( parent ); });
					var options = CloudFwParseAttribute(that.attr('data-options'));
						options.auto_rotate = (options.auto_rotate == '1') ? true : false;

					that.flexslider({
						namespace: "ui--blog-gallery-",
						selector: ".slides > div",
						animation: options.effect || "slide",
						slideshow: options.auto_rotate || false,
						slideshowSpeed: 7000,
						smoothHeight: true,
						controlNav: false,
						directionNav: false,
						keyboard: false
					});

					var slider_data = that.data('flexslider');

					var to_prev = function(){ that.flexslider("prev"); } 
					var to_next = function(){ that.flexslider("next"); } 

					that.find('.ui--blog-gallery-navigation').remove();
					that.append( jQuery('<div/>').addClass('ui--blog-gallery-navigation') );
					that.find('.ui--blog-gallery-navigation').html('<span class=\"arr arr-normal arr-left ui--carosuel-prev\"><span></span><i class=\"fontawesome-chevron-left px18\"></i></span> <span class=\"arr arr-normal ui--carosuel-next\"><span></span><i class=\"fontawesome-chevron-right px18\"></i></span>');
					that.find('.ui--blog-gallery-navigation > .ui--carosuel-prev').click( to_prev );
					that.find('.ui--blog-gallery-navigation > .ui--carosuel-next').click( to_next );
					

				}

			});

		} 

		blogGalleryInit();
		jQuery(window).load(function(){ blogGalleryInit(); });


});

/* ========================================
    EFFECTS (includes.modules.module.effects)
========================================*/
jQuery(document).ready(function(){
	'use strict';

	var initEffects = function() {

		jQuery('.ui--animation-in:in-viewport').each(function(){
			var parent = jQuery(this);

			if ( ! parent.is(':visible') ) {
				return true;
			}

			if ( parent.data('inViewport') ) {
				return true;
			}

			parent.data('inViewport', true);

			initEffectsFire( parent );

		});
		
	};

	var initEffectsFire = function( parent ) {

		var animator    = parent.hasClass('ui--animation-in') ? parent : parent.parents('.ui--animation-in:first');

		var elements    = parent.find('.ui--animation'),
			effect      = animator.attr('data-fx'),
			start_delay = parseInt( parent.attr('data-start-delay'), 10 ) || 0,
			delay       = parseInt( animator.attr('data-delay'), 10 ) || 150;

		var carousel = parent.find('.ui--carousel');
		if ( carousel.length ) {
			var active_carousel = carousel.find('.ui--carousel-active-slide'); 

			if ( active_carousel.length ) {
				var passive_elements = elements;

				if ( carousel.parents('.ui--animation').length ) {
					initEffectsFire( carousel.find('.ui--carousel-active-slide') );
				} else {
					elements = carousel.find('.ui--carousel-active-slide').find('.ui--animation');
				}
				passive_elements.not( elements ).addClass('ui--animation-fire');/*.removeClass('ui--animation')*/;
			}

		}

		elements = elements.filter(function(index){
			var parent_animations = jQuery(this).parents('.ui--animation');

			parent_animations = parent_animations.filter(function(){
				return jQuery(this).find('.ui--animation-in').length === 0;
			});

			return parent_animations.length === 0;
		});

		/*elements = elements.filter(function(index){
			var all_parents = jQuery(this).parents();
			var has_ui_animation = false;

			all_parents.each(function(){
				var up_element = jQuery(this);
				if ( up_element.hasClass( '.ui--animation-in' ) ) {
					return false;
				} else if ( up_element.hasClass( '.ui--animation' ) ) {
					has_ui_animation = true;
					return false;
				}
			});

			return has_ui_animation ? false : true;
		});*/



		elements.each(function(i){

			var element         = jQuery(this),
				element_effect  = element.attr('data-fx'),
				element_delay   = parseInt( element.attr('data-delay'), 10 ) || 0,
				current_delay   = (start_delay + element_delay) + (i * delay);

			//element.attr('data-current-delay', current_delay);

			if ( element_effect ) {
				element.addClass( element_effect );
			} else if ( effect ) {
				element.addClass( effect );
			}

			var timeout = setTimeout(function(){ 

				//element.bind("animationend webkitAnimationEnd oAnimationEnd MSAnimationEnd", function(){});
				element.addClass('ui--animation-fire').attr('DELAY', current_delay);

				if ( element.find('.ui--animation') ) {
					element.removeClass('ui--animation');
					initEffectsFire( element );
				}

			}, (current_delay));

		});

	};

	var animation_type = jQuery('html').hasClass('cssanimations') ? 'css' : 'javascript';

	if ( animation_type == 'css' ) {
		//setTimeout( initEffects, 200 );
		jQuery(document).ready( initEffects );
		jQuery(document).ajaxSuccess( initEffects );
		jQuery(window).load( initEffects );
		jQuery(window).focus( initEffects );
		jQuery(window).scroll( jQuery.throttle( 250, initEffects ) );
	}

});

/* ========================================
    LIKES (includes.modules.module.likes)
========================================*/
jQuery(document).ready(function($){

	jQuery('.ui--likes').on('click',
		function() {
			var that = jQuery(this);

			//if(that.hasClass('active')) 
			//  return false;

			var id      = that.attr('data-post-id'),
				options = CloudFwParseAttribute(that.attr('data-options'));

			var options_encoded = {};
			jQuery.each( options, function( k, v ){
				options_encoded[ k ] = encodeURIComponent(v);
			});

			jQuery.post(CloudFwOp.ajaxUrl, {
				action: 'cloudfw_likes',
				likes_id: id,
				options: options_encoded
			}, function(data){
				that.html(data).addClass('active').attr('title','You already like this');
			});

			return false;
	});

});

/* ========================================
    PRIMARY NAVIGATION (includes.modules.module.nav)
========================================*/
jQuery(document).ready(function(){

	if ( jQuery.isFunction( jQuery.fn.superfish ) ) {
		var navigation = jQuery('#header-navigation');

		navigation.superfish({
			hoverClass: 'hover',
			cssArrows: false,
			delay: 800,
			speed: 200,
			speedOut: 200,
			onBeforeShow: function( $ul ){
				navigation.addClass('active');
			},
			onShow: function( $ul ){
				jQuery(window).trigger('scroll');
				jQuery(window).trigger('make@2x');
			},
			onBeforeHide: function(){
				navigation.removeClass('active');
			}
		});
	}


	jQuery('#header-navigation-toggle > a').click(function(){
		var that = jQuery(this),
			nav = jQuery('#header-navigation'); 

		if ( nav.is(':visible') ) {
			nav.slideUp();
		} else {
			nav.slideDown();
		}

	});

});

/* ========================================
    PORTFOLIO (includes.modules.module.portfolio)
========================================*/
jQuery(document).ready(function(){

	function splitarray(input, spacing)
	{
	    var output = [];

	    for (var i = 0; i < input.length; i += spacing)
	    {
	        output[output.length] = input.slice(i, spacing);
	    }

	    return output;
	}

    /** Portfolio Filters */
	jQuery('.portfolio-filters > li > a').click(function(e){
		e.preventDefault();

		var that  	  = jQuery(this),
			wrapper   = that.parents('.portfolio-container-wrapper').first(),
			container = wrapper.find('.portfolio-container'),
			layout    = wrapper.attr('data-layout'),
			columns   = parseInt(wrapper.attr('data-columns')),
			parent    = that.parents('.portfolio-filters').first(),
			parent_li = that.parent('li'),
			isotope   = parent.attr('data-isotope'),
			selector  = that.attr('data-filter');


		if ( layout == 'masonry' ) {		
			jQuery(""+isotope+"").find('.ui--masonry').first().isotope({ filter: selector });
			
		} else if ( layout == 'carousel' ) {

		} else {

			var items = container.find('> .ui-row > .ui-column'),
				count = items.length,
				rows  = container.children('.ui-row');

			items.show().removeClass('passive-item').fadeTo(1000,1).not('' + selector).stop(1).addClass('passive-item').fadeTo(1000,.3);
		}

		parent.children('li.active-item').removeClass('active-item');
		parent_li.addClass('active-item');
		parent.children('li').not('.active-item');
		
	});

});

/* ========================================
    REVSLIDER (includes.modules.module.revslider)
========================================*/
jQuery(document).ready(function(){
	"use strict";
		
	jQuery('.rev_slider_wrapper').bind("revolution.slide.onloaded",function (e) {
		var that = jQuery(this);

		that.find( '.caption-primary' ).wrapInner('<div />');
		that.find( '.tp-leftarrow' ).html( '<div class="slider-navigation-wrapper"><i class="fontawesome-chevron-left"></i></div>' );
		that.find( '.tp-rightarrow' ).html( '<div class="slider-navigation-wrapper"><i class="fontawesome-chevron-right"></i></div>' );
		that.find( '.tp-bullets.round > .bullet' ).html( '<div class="ui--bullets"><div class="ui--bullets-color ui--accent-gradient"></div></div>' );

	});
		

});	



/* ========================================
    BROWSER (includes.modules.module.script)
========================================*/
var BrowserDetect = 
{
    init: function () 
    {
        this.browser = this.searchString(this.dataBrowser) || "Other";
        this.version = this.searchVersion(navigator.userAgent) || this.searchVersion(navigator.appVersion) || "Unknown";
    },

    searchString: function (data) 
    {
        for (var i=0 ; i < data.length ; i++)   
        {
            var dataString = data[i].string;
            this.versionSearchString = data[i].subString;

            if (dataString.indexOf(data[i].subString) != -1)
            {
                return data[i].identity;
            }
        }
    },

    searchVersion: function (dataString) 
    {
        var index = dataString.indexOf(this.versionSearchString);
        if (index == -1) return;
        return parseFloat(dataString.substring(index+this.versionSearchString.length+1));
    },

    dataBrowser: 
    [
        { string: navigator.userAgent, subString: "Chrome",  identity: "Chrome" },
        { string: navigator.userAgent, subString: "MSIE",    identity: "IE" },
        { string: navigator.userAgent, subString: "Trident/", identity: "IE" },
        { string: navigator.userAgent, subString: "Firefox", identity: "Firefox" },
        { string: navigator.userAgent, subString: "Safari",  identity: "Safari" },
        { string: navigator.userAgent, subString: "Opera",   identity: "Opera" },
    ]

};
BrowserDetect.init();

/* ========================================
    HOVER INTENT (includes.modules.module.script)
========================================*/
/*!
 * hoverIntent r7 // 2013.03.11 // jQuery 1.9.1+
 * http://cherne.net/brian/resources/jquery.hoverIntent.html
 *
 * You may use hoverIntent under the terms of the MIT license. Basically that
 * means you are free to use hoverIntent as long as this header is left intact.
 * Copyright 2007, 2013 Brian Cherne
 */
 
/* hoverIntent is similar to jQuery's built-in "hover" method except that
 * instead of firing the handlerIn function immediately, hoverIntent checks
 * to see if the user's mouse has slowed down (beneath the sensitivity
 * threshold) before firing the event. The handlerOut function is only
 * called after a matching handlerIn.
 *
 * // basic usage ... just like .hover()
 * .hoverIntent( handlerIn, handlerOut )
 * .hoverIntent( handlerInOut )
 *
 * // basic usage ... with event delegation!
 * .hoverIntent( handlerIn, handlerOut, selector )
 * .hoverIntent( handlerInOut, selector )
 *
 * // using a basic configuration object
 * .hoverIntent( config )
 *
 * @param  handlerIn   function OR configuration object
 * @param  handlerOut  function OR selector for delegation OR undefined
 * @param  selector    selector OR undefined
 * @author Brian Cherne <brian(at)cherne(dot)net>
 */
(function($) {
    $.fn.hoverIntent = function(handlerIn,handlerOut,selector) {

        // default configuration values
        var cfg = {
            interval: 100,
            sensitivity: 7,
            timeout: 0
        };

        if ( typeof handlerIn === "object" ) {
            cfg = $.extend(cfg, handlerIn );
        } else if ($.isFunction(handlerOut)) {
            cfg = $.extend(cfg, { over: handlerIn, out: handlerOut, selector: selector } );
        } else {
            cfg = $.extend(cfg, { over: handlerIn, out: handlerIn, selector: handlerOut } );
        }

        // instantiate variables
        // cX, cY = current X and Y position of mouse, updated by mousemove event
        // pX, pY = previous X and Y position of mouse, set by mouseover and polling interval
        var cX, cY, pX, pY;

        // A private function for getting mouse position
        var track = function(ev) {
            cX = ev.pageX;
            cY = ev.pageY;
        };

        // A private function for comparing current and previous mouse position
        var compare = function(ev,ob) {
            ob.hoverIntent_t = clearTimeout(ob.hoverIntent_t);
            // compare mouse positions to see if they've crossed the threshold
            if ( ( Math.abs(pX-cX) + Math.abs(pY-cY) ) < cfg.sensitivity ) {
                $(ob).off("mousemove.hoverIntent",track);
                // set hoverIntent state to true (so mouseOut can be called)
                ob.hoverIntent_s = 1;
                return cfg.over.apply(ob,[ev]);
            } else {
                // set previous coordinates for next time
                pX = cX; pY = cY;
                // use self-calling timeout, guarantees intervals are spaced out properly (avoids JavaScript timer bugs)
                ob.hoverIntent_t = setTimeout( function(){compare(ev, ob);} , cfg.interval );
            }
        };

        // A private function for delaying the mouseOut function
        var delay = function(ev,ob) {
            ob.hoverIntent_t = clearTimeout(ob.hoverIntent_t);
            ob.hoverIntent_s = 0;
            return cfg.out.apply(ob,[ev]);
        };

        // A private function for handling mouse 'hovering'
        var handleHover = function(e) {
            // copy objects to be passed into t (required for event object to be passed in IE)
            var ev = jQuery.extend({},e);
            var ob = this;

            // cancel hoverIntent timer if it exists
            if (ob.hoverIntent_t) { ob.hoverIntent_t = clearTimeout(ob.hoverIntent_t); }

            // if e.type == "mouseenter"
            if (e.type == "mouseenter") {
                // set "previous" X and Y position based on initial entry point
                pX = ev.pageX; pY = ev.pageY;
                // update "current" X and Y position based on mousemove
                $(ob).on("mousemove.hoverIntent",track);
                // start polling interval (self-calling timeout) to compare mouse coordinates over time
                if (ob.hoverIntent_s != 1) { ob.hoverIntent_t = setTimeout( function(){compare(ev,ob);} , cfg.interval );}

                // else e.type == "mouseleave"
            } else {
                // unbind expensive mousemove event
                $(ob).off("mousemove.hoverIntent",track);
                // if hoverIntent state is true, then call the mouseOut function after the specified delay
                if (ob.hoverIntent_s == 1) { ob.hoverIntent_t = setTimeout( function(){delay(ev,ob);} , cfg.timeout );}
            }
        };

        // listen for mouseenter and mouseleave
        return this.on({'mouseenter.hoverIntent':handleHover,'mouseleave.hoverIntent':handleHover}, cfg.selector);
    };
})(jQuery);

/* ========================================
    SUPERFISH (includes.modules.module.script)
========================================*/
/*
 * jQuery Superfish Menu Plugin
 * Copyright (c) 2013 Joel Birch
 *
 * Dual licensed under the MIT and GPL licenses:
 *	http://www.opensource.org/licenses/mit-license.php
 *	http://www.gnu.org/licenses/gpl.html
 */
(function ($) {
	"use strict";

	var methods = (function () {
		// private properties and methods go here
		var c = {
				bcClass: 'sf-breadcrumb',
				menuClass: 'sf-js-enabled',
				anchorClass: 'sf-with-ul',
				menuArrowClass: 'sf-arrows'
			},
			ios = (function () {
				var ios = /iphone|ipad|ipod/i.test(navigator.userAgent.toLowerCase());
				if (ios) {
					// iOS clicks only bubble as far as body children
					$(window).load(function () {
						$('body').children().on('click', $.noop);
					});
				}
				return ios;
			})(),
			wp7 = (function () {
				var style = document.documentElement.style;
				return ('behavior' in style && 'fill' in style && /iemobile/i.test(navigator.userAgent));
			})(),
			toggleMenuClasses = function ($menu, o) {
				var classes = c.menuClass;
				if (o.cssArrows) {
					classes += ' ' + c.menuArrowClass;
				}
				$menu.toggleClass(classes);
			},
			setPathToCurrent = function ($menu, o) {
				return $menu.find('li.' + o.pathClass).slice(0, o.pathLevels)
					.addClass(o.hoverClass + ' ' + c.bcClass)
						.filter(function () {
							return ($(this).children(o.popUpSelector).hide().show().length);
						}).removeClass(o.pathClass);
			},
			toggleAnchorClass = function ($li) {
				$li.children('a').toggleClass(c.anchorClass);
			},
			toggleTouchAction = function ($menu) {
				var touchAction = $menu.css('ms-touch-action');
				touchAction = (touchAction === 'pan-y') ? 'auto' : 'pan-y';
				$menu.css('ms-touch-action', touchAction);
			},
			applyHandlers = function ($menu, o) {
				var targets = 'li:has(' + o.popUpSelector + ')';
				if ($.fn.hoverIntent && !o.disableHI) {
					$menu.hoverIntent(over, out, targets);
				}
				else {
					$menu
						.on('mouseenter.superfish', targets, over)
						.on('mouseleave.superfish', targets, out);
				}
				var touchevent = 'MSPointerDown.superfish';
				if (!ios) {
					touchevent += ' touchend.superfish';
				}
				if (wp7) {
					touchevent += ' mousedown.superfish';
				}
				$menu
					.on('focusin.superfish', 'li', over)
					.on('focusout.superfish', 'li', out)
					.on(touchevent, 'a', o, touchHandler);
			},
			touchHandler = function (e) {
				var $this = $(this),
					$ul = $this.siblings(e.data.popUpSelector);

				if ($ul.length > 0 && $ul.is(':hidden')) {
					$this.one('click.superfish', false);
					if (e.type === 'MSPointerDown') {
						$this.trigger('focus');
					} else {
						$.proxy(over, $this.parent('li'))();
					}
				}
			},
			over = function () {
				var $this = $(this),
					o = getOptions($this);
				clearTimeout(o.sfTimer);
				$this.siblings().superfish('hide').end().superfish('show');
			},
			out = function () {
				var $this = $(this),
					o = getOptions($this);
				if (ios) {
					$.proxy(close, $this, o)();
				}
				else {
					if ( o.sfTimer ) {
						clearTimeout(o.sfTimer);
					}
					o.sfTimer = setTimeout($.proxy(close, $this, o), o.delay);
				}
			},
			close = function (o) {
				o.retainPath = ($.inArray(this[0], o.$path) > -1);
				this.superfish('hide');

				if (!this.parents('.' + o.hoverClass).length) {
					o.onIdle.call(getMenu(this));
					if (o.$path.length) {
						$.proxy(over, o.$path)();
					}
				}
			},
			getMenu = function ($el) {
				return $el.closest('.' + c.menuClass);
			},
			getOptions = function ($el) {
				return getMenu($el).data('sf-options');
			};

		return {
			// public methods
			hide: function (instant) {
				if (this.length) {
					var $this = this,
						o = getOptions($this);
					if (!o) {
						return this;
					}
					var not = (o.retainPath === true) ? o.$path : '',
						$ul = $this.find('li.' + o.hoverClass).add(this).not(not).removeClass(o.hoverClass).children(o.popUpSelector),
						speed = o.speedOut;

					if (instant) {
						$ul.show();
						speed = 0;
					}
					o.retainPath = false;
					o.onBeforeHide.call($ul);
					$ul.stop(true, true).animate(o.animationOut, speed, function () {
						var $this = $(this);
						o.onHide.call($this);
					});
				}
				return this;
			},
			show: function () {
				var o = getOptions(this);
				if (!o) {
					return this;
				}
				var $this = this.addClass(o.hoverClass),
					$ul = $this.children(o.popUpSelector);

				o.onBeforeShow.call($ul);
				$ul.stop(true, true).animate(o.animation, o.speed, function () {
					o.onShow.call($ul);
				});
				return this;
			},
			destroy: function () {
				return this.each(function () {
					var $this = $(this),
						o = $this.data('sf-options'),
						$hasPopUp;
					if (!o) {
						return false;
					}
					$hasPopUp = $this.find(o.popUpSelector).parent('li');
					clearTimeout(o.sfTimer);
					toggleMenuClasses($this, o);
					toggleAnchorClass($hasPopUp);
					toggleTouchAction($this);
					// remove event handlers
					$this.off('.superfish').off('.hoverIntent');
					// clear animation's inline display style
					$hasPopUp.children(o.popUpSelector).attr('style', function (i, style) {
						return style.replace(/display[^;]+;?/g, '');
					});
					// reset 'current' path classes
					o.$path.removeClass(o.hoverClass + ' ' + c.bcClass).addClass(o.pathClass);
					$this.find('.' + o.hoverClass).removeClass(o.hoverClass);
					o.onDestroy.call($this);
					$this.removeData('sf-options');
				});
			},
			init: function (op) {
				return this.each(function () {
					var $this = $(this);
					if ($this.data('sf-options')) {
						return false;
					}
					var o = $.extend({}, $.fn.superfish.defaults, op),
						$hasPopUp = $this.find(o.popUpSelector).parent('li');
					o.$path = setPathToCurrent($this, o);

					$this.data('sf-options', o);

					toggleMenuClasses($this, o);
					toggleAnchorClass($hasPopUp);
					toggleTouchAction($this);
					applyHandlers($this, o);

					$hasPopUp.not('.' + c.bcClass).superfish('hide', true);

					o.onInit.call(this);

					$this.iosnavfix();
				});
			}
		};
	})();

	$.fn.superfish = function (method, args) {
		if (methods[method]) {
			return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
		}
		else if (typeof method === 'object' || ! method) {
			return methods.init.apply(this, arguments);
		}
		else {
			return $.error('Method ' +  method + ' does not exist on jQuery.fn.superfish');
		}
	};

	$.fn.superfish.defaults = {
		popUpSelector: 'ul, .sf-mega', // within menu context
		hoverClass: 'sfHover',
		pathClass: 'overrideThisToUse',
		pathLevels: 1,
		delay: 800,
		animation: {opacity: 'show'},
		animationOut: {opacity: 'hide'},
		speed: 'normal',
		speedOut: 'fast',
		cssArrows: true,
		disableHI: false,
		onInit: $.noop,
		onBeforeShow: $.noop,
		onShow: $.noop,
		onBeforeHide: $.noop,
		onHide: $.noop,
		onIdle: $.noop,
		onDestroy: $.noop
	};

	// soon to be deprecated
	$.fn.extend({
		hideSuperfishUl: methods.hide,
		showSuperfishUl: methods.show
	});

})(jQuery);


/*!
 * iOS Nav Fix - Dropdown menu fix for iOS devices
 *
 * Version:  1.0
 * Released: 19-02-2013
 * Source:   http://github.com/Vheissu/IOSNavFix
 * Plugin:   Iosnavfix
 * Author:   Dwayne Charrington (dwaynecharrington@gmail.com)
 * Modified: Orkun Gursel (support@cloudfw.net)
 * License:  MIT Licence 
 *           http://www.opensource.org/licenses/mit-license.php
 * 
 * Copyright (c) 2013 Dwayne Charrington.
 *
 */
;(function(w, $) {  

	$.fn.iosnavfix = function() {

		return this.each(function() {

			if ( isMobile() ) {
				var $this = $(this);
				var $list       = []; 

				$("li", $this).each(function() {
					var $this       = $(this);
					var $parentLink = $("> a", $this);


					// If we have children
					if ($this.children('ul').length || $this.children('ol').length) {

						// Set default clicked state
						$parentLink.data('clicked', false);

						// When the link is clicked
						$parentLink.on("click", function(e) {

							jQuery.each($list, function(k,v){
								if ( v.jquery && v != $parentLink ) {
									v.data('clicked', false);
								}
							});

							// if we haven't already clicked, false
							if ($parentLink.data('clicked') == false) {
								// Inform everyone we've now clicked
								$parentLink.data('clicked', true);

								$list.push( $parentLink );

								// Prevent link being followed into next click
								return false;
							} else {
								// Reset link click state
								$parentLink.data('clicked', false);

								// Allow link to be followed now
								return true;
							}

						});
					}
				});
			}

		});

		/** 
		 * If a user is pretending to be an iOS device, too bad for them.
		 * As if you would imitate an iPad or iPhone for non-testing purposes.
		 *
		 * Anyway, this function will detect iOS user agents, simple.
		 */
		function isMobile() {
			if ( (navigator.userAgent.match(/iPhone/i)) || (navigator.userAgent.match(/iPod/i) ) || (navigator.userAgent.match(/iPad/i) )|| (navigator.userAgent.toLowerCase().match(/android/i) ) ) { return true; } else { return false; }
		}

	}

})(window, jQuery);

/* ========================================
    IMAGELOADED (includes.modules.module.script)
========================================*/
/*!
 * imagesLoaded PACKAGED v3.0.4
 * JavaScript is all like "You images are done yet or what?"
 */

(function(){"use strict";function e(){}function t(e,t){for(var n=e.length;n--;)if(e[n].listener===t)return n;return-1}var n=e.prototype;n.getListeners=function(e){var t,n,i=this._getEvents();if("object"==typeof e){t={};for(n in i)i.hasOwnProperty(n)&&e.test(n)&&(t[n]=i[n])}else t=i[e]||(i[e]=[]);return t},n.flattenListeners=function(e){var t,n=[];for(t=0;e.length>t;t+=1)n.push(e[t].listener);return n},n.getListenersAsObject=function(e){var t,n=this.getListeners(e);return n instanceof Array&&(t={},t[e]=n),t||n},n.addListener=function(e,n){var i,r=this.getListenersAsObject(e),o="object"==typeof n;for(i in r)r.hasOwnProperty(i)&&-1===t(r[i],n)&&r[i].push(o?n:{listener:n,once:!1});return this},n.on=n.addListener,n.addOnceListener=function(e,t){return this.addListener(e,{listener:t,once:!0})},n.once=n.addOnceListener,n.defineEvent=function(e){return this.getListeners(e),this},n.defineEvents=function(e){for(var t=0;e.length>t;t+=1)this.defineEvent(e[t]);return this},n.removeListener=function(e,n){var i,r,o=this.getListenersAsObject(e);for(r in o)o.hasOwnProperty(r)&&(i=t(o[r],n),-1!==i&&o[r].splice(i,1));return this},n.off=n.removeListener,n.addListeners=function(e,t){return this.manipulateListeners(!1,e,t)},n.removeListeners=function(e,t){return this.manipulateListeners(!0,e,t)},n.manipulateListeners=function(e,t,n){var i,r,o=e?this.removeListener:this.addListener,s=e?this.removeListeners:this.addListeners;if("object"!=typeof t||t instanceof RegExp)for(i=n.length;i--;)o.call(this,t,n[i]);else for(i in t)t.hasOwnProperty(i)&&(r=t[i])&&("function"==typeof r?o.call(this,i,r):s.call(this,i,r));return this},n.removeEvent=function(e){var t,n=typeof e,i=this._getEvents();if("string"===n)delete i[e];else if("object"===n)for(t in i)i.hasOwnProperty(t)&&e.test(t)&&delete i[t];else delete this._events;return this},n.emitEvent=function(e,t){var n,i,r,o,s=this.getListenersAsObject(e);for(r in s)if(s.hasOwnProperty(r))for(i=s[r].length;i--;)n=s[r][i],o=n.listener.apply(this,t||[]),(o===this._getOnceReturnValue()||n.once===!0)&&this.removeListener(e,s[r][i].listener);return this},n.trigger=n.emitEvent,n.emit=function(e){var t=Array.prototype.slice.call(arguments,1);return this.emitEvent(e,t)},n.setOnceReturnValue=function(e){return this._onceReturnValue=e,this},n._getOnceReturnValue=function(){return this.hasOwnProperty("_onceReturnValue")?this._onceReturnValue:!0},n._getEvents=function(){return this._events||(this._events={})},"function"==typeof define&&define.amd?define(function(){return e}):"undefined"!=typeof module&&module.exports?module.exports=e:this.EventEmitter=e}).call(this),function(e){"use strict";var t=document.documentElement,n=function(){};t.addEventListener?n=function(e,t,n){e.addEventListener(t,n,!1)}:t.attachEvent&&(n=function(t,n,i){t[n+i]=i.handleEvent?function(){var t=e.event;t.target=t.target||t.srcElement,i.handleEvent.call(i,t)}:function(){var n=e.event;n.target=n.target||n.srcElement,i.call(t,n)},t.attachEvent("on"+n,t[n+i])});var i=function(){};t.removeEventListener?i=function(e,t,n){e.removeEventListener(t,n,!1)}:t.detachEvent&&(i=function(e,t,n){e.detachEvent("on"+t,e[t+n]);try{delete e[t+n]}catch(i){e[t+n]=void 0}});var r={bind:n,unbind:i};"function"==typeof define&&define.amd?define(r):e.eventie=r}(this),function(e){"use strict";function t(e,t){for(var n in t)e[n]=t[n];return e}function n(e){return"[object Array]"===c.call(e)}function i(e){var t=[];if(n(e))t=e;else if("number"==typeof e.length)for(var i=0,r=e.length;r>i;i++)t.push(e[i]);else t.push(e);return t}function r(e,n){function r(e,n,s){if(!(this instanceof r))return new r(e,n);"string"==typeof e&&(e=document.querySelectorAll(e)),this.elements=i(e),this.options=t({},this.options),"function"==typeof n?s=n:t(this.options,n),s&&this.on("always",s),this.getImages(),o&&(this.jqDeferred=new o.Deferred);var a=this;setTimeout(function(){a.check()})}function c(e){this.img=e}r.prototype=new e,r.prototype.options={},r.prototype.getImages=function(){this.images=[];for(var e=0,t=this.elements.length;t>e;e++){var n=this.elements[e];"IMG"===n.nodeName&&this.addImage(n);for(var i=n.querySelectorAll("img"),r=0,o=i.length;o>r;r++){var s=i[r];this.addImage(s)}}},r.prototype.addImage=function(e){var t=new c(e);this.images.push(t)},r.prototype.check=function(){function e(e,r){return t.options.debug&&a&&s.log("confirm",e,r),t.progress(e),n++,n===i&&t.complete(),!0}var t=this,n=0,i=this.images.length;if(this.hasAnyBroken=!1,!i)return this.complete(),void 0;for(var r=0;i>r;r++){var o=this.images[r];o.on("confirm",e),o.check()}},r.prototype.progress=function(e){this.hasAnyBroken=this.hasAnyBroken||!e.isLoaded;var t=this;setTimeout(function(){t.emit("progress",t,e),t.jqDeferred&&t.jqDeferred.notify(t,e)})},r.prototype.complete=function(){var e=this.hasAnyBroken?"fail":"done";this.isComplete=!0;var t=this;setTimeout(function(){if(t.emit(e,t),t.emit("always",t),t.jqDeferred){var n=t.hasAnyBroken?"reject":"resolve";t.jqDeferred[n](t)}})},o&&(o.fn.imagesLoaded=function(e,t){var n=new r(this,e,t);return n.jqDeferred.promise(o(this))});var f={};return c.prototype=new e,c.prototype.check=function(){var e=f[this.img.src];if(e)return this.useCached(e),void 0;if(f[this.img.src]=this,this.img.complete&&void 0!==this.img.naturalWidth)return this.confirm(0!==this.img.naturalWidth,"naturalWidth"),void 0;var t=this.proxyImage=new Image;n.bind(t,"load",this),n.bind(t,"error",this),t.src=this.img.src},c.prototype.useCached=function(e){if(e.isConfirmed)this.confirm(e.isLoaded,"cached was confirmed");else{var t=this;e.on("confirm",function(e){return t.confirm(e.isLoaded,"cache emitted confirmed"),!0})}},c.prototype.confirm=function(e,t){this.isConfirmed=!0,this.isLoaded=e,this.emit("confirm",this,t)},c.prototype.handleEvent=function(e){var t="on"+e.type;this[t]&&this[t](e)},c.prototype.onload=function(){this.confirm(!0,"onload"),this.unbindProxyEvents()},c.prototype.onerror=function(){this.confirm(!1,"onerror"),this.unbindProxyEvents()},c.prototype.unbindProxyEvents=function(){n.unbind(this.proxyImage,"load",this),n.unbind(this.proxyImage,"error",this)},r}var o=e.jQuery,s=e.console,a=s!==void 0,c=Object.prototype.toString;"function"==typeof define&&define.amd?define(["eventEmitter/EventEmitter","eventie/eventie"],r):e.imagesLoaded=r(e.EventEmitter,e.eventie)}(window);

/* ========================================
    UI (includes.modules.module.script)
========================================*/
;(function ( $, window, document, undefined ) {

	// Create the defaults once
	var pluginName = "uiVerticalCenter",
		defaults = {};

	// The actual plugin constructor
	function Plugin( element, options ) {
		this.element = element;
		this.options = $.extend( {}, defaults, options );

		this._defaults = defaults;
		this._name = pluginName;

		this.init();
	}

	Plugin.prototype = {

		init: function() {
			var element = jQuery(this.element);
			var images = element.find('img');
			var height = element.outerHeight();

			element.css({'margin-top' : - (height / 2) }).attr('data-height', height );
			if ( images.length ) {
				images.imagesLoaded(function(){
					var height = element.outerHeight();
					element.css({'margin-top' : - (height / 2) });
				});
			}

		},

        calcHeight: function () {
            var that = jQuery(this.element);

            var height =
                parseInt(that.css('margin-top'), 10) +
                parseInt(that.css('padding-top'), 10) +
                parseInt(that.css('border-top-width'), 10) +
                parseInt(that.height(), 10) +
                parseInt(that.css('border-bottom-width'), 10) +
                parseInt(that.css('padding-bottom'), 10) +
                parseInt(that.css('margin-bottom'), 10);

            return height;
        }


	};

	$.fn[pluginName] = function ( options ) {
		return this.each(function () {
			if (!$.data(this, "plugin_" + pluginName)) {
				$.data(this, "plugin_" + pluginName, new Plugin( this, options ));
			}
		});
	};

})( jQuery, window, document );

jQuery(document).ready(function(){
	var centerVertical = function(){
		jQuery('.ui--center-vertical').uiVerticalCenter();
	};

	setTimeout(function(){
		centerVertical();
	}, 100 );

	jQuery(window).resize( centerVertical );
	jQuery(window).load( centerVertical );	


});

/* ========================================
    CURRENT MENU (includes.modules.module.script)
========================================*/
jQuery(document).ready(function(){
	"use strict";

	jQuery.fn.extend({
		/**
		 *	CloudFw Select Current Menu Item
		 *
		 *	@since 1.0
		 */
		selectCurrentMenu : function() {

			jQuery.fn.extend({

				/* Match Classes */
				matchClasses : function() {

					//this.addClass('passed');

					if ( this.is('.current-menu-item, .current-menu-ancestor, .current-menu-parent, .current_page_parent, .current_page_ancestor, .current_page_item') ) {
						if ( this.parents('.depth-0').length ) {
							this.parents('.depth-0').last().addClass('current-item-handler');
						} else {
							this.addClass('current-item-handler');
						}
					}
					this.removeClass('current-menu-item current-menu-ancestor current-menu-parent current_page_parent current_page_ancestor current_page_item');
					return this;
				},

				/* Loop Items */
				loopItems : function() {

					if ( this.length ){

						this.each(function(){
							var item = jQuery(this);
							item.matchClasses();

							if ( item.children('.sub-menu').length ) {
								item.children('.sub-menu').children().loopItems();
							}

						});

					}

				},

				/* Set Final */
				setCurrentItem : function() {

					var currentItemClass = 'current-menu-item';

					if ( this.find( '.current-item-handler' ).length ){
						if ( this.find( '.current-item-handler' ).is('.force-for-select') )
							this.find( '.current-item-handler.force-for-select' ).removeClass( 'current-item-handler' ).first().addClass( currentItemClass );
						else
							this.find( '.current-item-handler' ).removeClass( 'current-item-handler' ).first().addClass( currentItemClass );
					}
					/*else
						this.children().first().addClass( currentItemClass );*/

				}


			});

			/* Run the Plugin */
			return this.each(function() {
				var theMenu = jQuery(this);
				var menuItems = theMenu.children();

				menuItems.loopItems();
				theMenu.setCurrentItem();
			});
		},

		/**
		 *	CloudFw Prepare Menus
		 *
		 *	@since 1.0
		 */
		prepareMenu: function() {
			/* Run the Plugin */
			return this.each(function() {
				var theMenu = jQuery(this);
				var navMenuItems = theMenu.find('li');

				navMenuItems.each(function(){

					if ( jQuery(this).find('.sub-menu').length )
						if ( !jQuery(this).hasClass('has-sub-menu') )
							jQuery(this)
								.addClass('has-sub-menu')
								.find('a')
								.first()
								.append('<span class="indicator"></span>');

				});

				/** Add class to first level navigation menu items */
				var navMenuFirstLevelItems = theMenu.children('ul > li.depth-0');
				var navMenuFirstLevelItemsLenght = navMenuFirstLevelItems.length;
				navMenuFirstLevelItems.each(function(itemNumber) {
					jQuery(this).addClass('asc-' + itemNumber++ ).addClass('desc-' + parseInt(navMenuFirstLevelItemsLenght - itemNumber, 10));
				});

			});

		}

	});

	jQuery('#header-navigation').selectCurrentMenu();

});

/* ========================================
    GLOBAL (includes.modules.module.script)
========================================*/
jQuery(document).ready(function(){

	jQuery("a[data-rel^='prettyPhoto']").CloudFwPrettyPhoto({
		theme: 'pp_envision',
		show_title: true,
		slideshow: false,
		social_tools: false,
		deeplinking: false,
		modal: false
	});

});

/* ========================================
    HASHCHANGE (includes.modules.module.script)
========================================*/
/*
 * jQuery hashchange event - v1.3 - 7/21/2010
 * http://benalman.com/projects/jquery-hashchange-plugin/
 * 
 * Copyright (c) 2010 "Cowboy" Ben Alman
 * Dual licensed under the MIT and GPL licenses.
 * http://benalman.com/about/license/
 */
(function($,e,b){var c="hashchange",h=document,f,g=$.event.special,i=h.documentMode,d="on"+c in e&&(i===b||i>7);function a(j){j=j||location.href;return"#"+j.replace(/^[^#]*#?(.*)$/,"$1")}$.fn[c]=function(j){return j?this.bind(c,j):this.trigger(c)};$.fn[c].delay=50;g[c]=$.extend(g[c],{setup:function(){if(d){return false}$(f.start)},teardown:function(){if(d){return false}$(f.stop)}});f=(function(){var j={},p,m=a(),k=function(q){return q},l=k,o=k;j.start=function(){p||n()};j.stop=function(){p&&clearTimeout(p);p=b};function n(){var r=a(),q=o(m);if(r!==m){l(m=r,q);$(e).trigger(c)}else{if(q!==m){location.href=location.href.replace(/#.*/,"")+q}}p=setTimeout(n,$.fn[c].delay)}$('html').hasClass('ie')&&!d&&(function(){var q,r;j.start=function(){if(!q){r=$.fn[c].src;r=r&&r+a();q=$('<iframe tabindex="-1" title="empty"/>').hide().one("load",function(){r||l(a());n()}).attr("src",r||"javascript:0").insertAfter("body")[0].contentWindow;h.onpropertychange=function(){try{if(event.propertyName==="title"){q.document.title=h.title}}catch(s){}}}};j.stop=k;o=function(){return a(q.location.href)};l=function(v,s){var u=q.document,t=$.fn[c].domain;if(v!==s){u.title=h.title;u.open();t&&u.write('<script>document.domain="'+t+'"<\/script>');u.close();q.location.hash=v}}})();return j})()})(jQuery,this);

jQuery(function(){
	"use strict";

	jQuery(window).hashchange( function() {

		var hash = location.hash.replace('#', '');
		if ( hash ) {   
			jQuery('a[href$=' + hash + ']').click(); 
		}

	});

	jQuery(window).hashchange();

});

/* ========================================
    LOADING (includes.modules.module.script)
========================================*/
var CloudFwLoaded = function( item ){
	if ( typeof item.jquery == 'undefined' )
		return false;

	if ( item.hasClass('ui--loading') ) {
		item.removeClass('ui--loading');
		item.next('.ui--loading-progress').addClass('loaded');

		//console.log(item.next('.ui--loading-progress'));
	}

};

/* ========================================
    MIDWAY (includes.modules.module.script)
========================================*/
/**
 * Midway.js
 * Version: 1.0
 * Author: Shipp Co. (Brandon Jacoby, Jordan Singer, Jeremy Goldberg)
 * Copyright (c) 2013 - Midway.  All rights reserved.
 * http://www.shipp.co/midway
 */
(function($) {
	eval(function(p,a,c,k,e,r){e=function(c){return c.toString(a)};if(!''.replace(/^/,String)){while(c--)r[e(c)]=k[c]||e(c);k=[function(e){return r[e]}];e=function(){return'\\w+'};c=1};while(c--)if(k[c])p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c]);return p}('$(m).l(5(){4 c=$(\'.0\').1(\'6\',- +$(\'.0\').7()/2);4 d=$(\'.3\').1(\'8\',- +$(\'.3\').9()/2);c;d;$(".0").1({\'h\':\'f\',\'g\':\'e%\',\'i\':\'e%\'});$(j).k(5(){4 a=$(\'.0\').1(\'6\',- +$(\'.0\').7()/2);4 b=$(\'.3\').1(\'8\',- +$(\'.3\').9()/2);a;b})});',23,23,'centerHorizontal|css||centerVertical|var|function|marginLeft|width|marginTop|outerHeight|||||50|absolute|top|position|left|window|resize|ready|document'.split('|'),0,{}))
})(jQuery);

/* ========================================
    RESPONSIVE OPTIONS (includes.modules.module.script)
========================================*/
var detectDeviceViaPageWidth = function(){
	"use strict";

	var device;

	if ( Modernizr.mq('only all and (max-width: 767px)') ) {
		device = 'phone';
	}
	else if ( Modernizr.mq('only all and (min-width: 768px) and (max-width: 979px)') ) {
		device = 'tablet';
	}
	else {
		device = 'widescreen';
	}

	return device;

};

var responsiveOptionsCallback = function(){
	"use strict";

	var elements = jQuery("[data-responsive]");
	elements.each(function(){
		var that = jQuery(this);
		var options = {};
		var data_responsive = that.attr('data-responsive');
		var device = detectDeviceViaPageWidth();

		if ( data_responsive ) {
			try {
				options = jQuery.parseJSON( data_responsive );
			} catch (e) {}

			if ( options.replaceClass ) {
				jQuery.each( options.replaceClass, function( k,v ){
					var default_val = k,
						new_class = '';

					if ( typeof v[ device ] != 'undefined' || v[ device ] !== null )
						new_class = v[ device ];
					else
						new_class = default_val;


					if ( new_class !== '' && new_class != default_val ) {
						that.removeClass( that.attr('data-replaced-class') ).removeClass( default_val ).addClass( new_class );
						that.attr('data-replaced-class', new_class);
					} else {
						var replaced_class = that.attr('data-replaced-class'); 
						if ( replaced_class )
							that.removeClass( replaced_class ).addClass( default_val );

					}

				});
			}

			if ( options.css ) {
				jQuery.each( options.css, function( k,v ){
					var property = k,
						object = {};

					object[ property ] = (typeof v[ device ] == 'undefined' || v[ device ] === null) ? 
										( (typeof v.widescreen != 'undefined' && v.widescreen !== null) ? v.widescreen : '' )
									: v[ device ];

					that.css(object);

				});
			}

		}

	});


};

jQuery(document).ready(responsiveOptionsCallback);
jQuery(window).resize(responsiveOptionsCallback);


var prepareResponsiveFullwidthContainer = function(){
	"use strict";

	var fullwidth_containers = jQuery('.fullwidth-container');

	if ( fullwidth_containers.length ) {

		var prepareResponsiveFullwidthContainer_Resize = function(){

			var page_width = jQuery('body').innerWidth();
			if ( page_width <= 767 ) {
				fullwidth_containers.each(function(){
					var that = jQuery(this); 
					that.width( that.parent().width() );
				});

			} else {
				fullwidth_containers.css({width: ''});
			}

		}
		
		prepareResponsiveFullwidthContainer_Resize();
		jQuery(window).resize(prepareResponsiveFullwidthContainer_Resize);

	}
};
jQuery(document).ready(prepareResponsiveFullwidthContainer);

/**
 * Resizes fullwidth container by the page width
 * @return void
 */
var prepareResponsiveFullwidthContainerPage = function(){
	"use strict";

	var fullwidth_contents = jQuery('.fullwidth-content');

	if ( fullwidth_contents.length ) {

		var prepareResponsiveFullwidthContainerPage_Resize = function(){

			var page_width = jQuery('body').innerWidth();
			var content_width = jQuery('#page-content > .container').width();

			if ( ! CloudFwOp.RTL ) {
				fullwidth_contents.css({
					'width': page_width + 1,
					'margin-left': 0 - (( page_width - content_width ) / 2) - 1,
					'margin-right': 0
				});
			} else {
				fullwidth_contents.css({
					'width': page_width + 1,
					'margin-right': 0 - (( page_width - content_width ) / 2) - 1,
					'margin-left': 0
				});
			}
		}
		
		prepareResponsiveFullwidthContainerPage_Resize();
		jQuery(window).resize(prepareResponsiveFullwidthContainerPage_Resize);

	}
};
jQuery(document).ready(prepareResponsiveFullwidthContainerPage);


var parseResponsiveAttribute = function( data_responsive, selector, default_value ){
	"use strict";

	var data = {};

	if ( data_responsive ) {
		try {
			
			if ( typeof data_responsive != 'object' )
				data = jQuery.parseJSON( data_responsive );

		} catch (e) {}

		if ( typeof data[ selector ] != 'undefined' || data[ selector ] !== null )
			return data[ selector ];
		else
			return default_value;
	}

};

/* ========================================
    TOPBAR (includes.modules.module.script)
========================================*/
jQuery(document).ready(function(){

	if ( jQuery.isFunction( jQuery.fn.superfish ) ) {

		var topbar_menu = jQuery('.ui--custom-menu', '#top-bar');
		var topbar_menu_custom_animation_speed = topbar_menu.attr('data-animation-speed');

		topbar_menu.superfish({
			hoverClass: 'hover',
			cssArrows: false,
			delay: 500,
			speed: topbar_menu_custom_animation_speed || 50,
			speedOut: topbar_menu_custom_animation_speed || 50
		});
	}


	var search_form = jQuery('#widget--search', '#top-bar'),
		toggle 		= search_form.find('a'),
		input 		= search_form.find('input'),
		form 		= search_form.find('.ui--search-form'),
		cssanimations = jQuery('html').hasClass('cssanimations'); 


	toggle.click(function(e){
		e.preventDefault();
		input.focus();

	});

	input.bind('focus', function(){
		if( cssanimations )
			search_form.addClass('state--open');
		else
			form.stop(1).animate({'width': 150});
		
		//toggle.addClass('ui--gradient-primary').removeClass('ui--gradient-grey');

	});

	input.bind('blur', function(){
		if( cssanimations )
			search_form.removeClass('state--open');
		else
			form.stop(1).animate({'width': 0});
		
		//toggle.removeClass('ui--gradient-primary').addClass('ui--gradient-grey');
	});

});

/* ========================================
    PANEL (includes.modules.module.side_panel)
========================================*/
jQuery(document).ready(function(){
	"use strict";
	
	var side_panel_handlers = jQuery('.ui--side-panel'),
		side_panel          = jQuery('#side-panel'),
		side_panel_items    = jQuery('#side-panel').children('div'),
		html               = jQuery('html'),
		listener           = false; 

	if ( side_panel.length && side_panel_handlers.length ) {

		var side_panel_close_listener = function(){
			listener = true; 

			jQuery('#main-container').click(function(){
				html.removeClass('side-panel-open');
			});

			jQuery('#ui--side-panel-close-button').click(function(){
				html.removeClass('side-panel-open');
			});
		}

		side_panel_handlers.bind('click', function(e){
			e.preventDefault();

			var that = jQuery(this);
				
			if ( ! html.hasClass('side-panel-open') ) {
			
				setTimeout( function() {
					side_panel_items.hide();

					if ( that.attr('data-target') ) {
						side_panel_items.filter('#' + that.attr('data-target')).show();
					} else {
						side_panel_items.first().show();
					}

					jQuery('body, html').animate({scrollTop:0}, '500', 'swing', function() { 
						html.addClass('side-panel-open');
					});

				}, 25 );

			} else {
				html.removeClass('side-panel-open');
			}

			if ( ! listener ) {
				side_panel_close_listener();
			}

		});


	}

});

/* ========================================
    UNIFORM (includes.modules.module.uniform)
========================================*/
jQuery(document).ready(function(){
	"use strict";

	if ( ! CloudFwOp.uniform_elements ) {
		return true;
	}

	var CloudFw_Uniform = function( wrapper ){

		if( jQuery('html').hasClass('old-browser') )
			return true;

		if ( ! wrapper )
			wrapper = null;
		else {
			if ( typeof wrapper.jquery == 'undefined' )
				wrapper = jQuery( wrapper );

			if ( ! wrapper.length )
				return true;
		}

		/**
		 *	Select
		 */
		jQuery("select", wrapper).each(function(){
			var that = jQuery(this);

			if ( that.css('display') == 'none' ) {
				return true;
			}

			if ( that.hasClass('no-uniform') ) {
				return true;
			}
		
			if ( CloudFwOp.disable_gravity_uniform_select ) {
				if ( that.hasClass('gfield_select') ) {
					return true;
				}
			}

			if ( CloudFw_jQueried('cloudfw-select', that) ) {
				return true;
			}

			if ( that.attr('multiple') ) {
				return true;
			}

			var ui_wrapper = jQuery('<span/>').addClass('ui--select-wrapper ui--box ui--gradient ui--gradient-grey').addClass( that.attr('data-wrapper-classes') );
	        var resize_callback = function(){
	        	var margin = that.css({'margin': ''}).css('margin');
	        	var width = that.css({'width': ''}).css('width');

	        	ui_wrapper.css({'margin': margin});
	        	ui_wrapper.css({'width': width});

	        }
	        resize_callback();

			that.wrap( ui_wrapper );

			var	title = jQuery('<span/>').addClass('ui--select-title');
			that.before( title );

			var	arrow = jQuery('<i/>').addClass('ui--icon icon fontawesome-angle-down ui--select-arrow');
			that.before( arrow );


			var change_callback = function() {
	        	var val = that.find(':selected').first().text();

	        	if ( val == '' ) {
	        		var default_title = that.attr('data-default-title'); 
	        		if ( default_title )
	        			var val = default_title; 
	        	}

	        	title.text(val);
	        }

	        jQuery(document).delegate( that, 'change', change_callback);
	        change_callback();

	        that.bind('focus', function(){
	        	that.parent().addClass('active');
	        });

	        that.bind('blur', function(){
	        	that.parent().removeClass('active');
	        });

	        if ( that.attr('data-init') )
	        	that.change();

			

		});
		

	} 	

	CloudFw_Uniform();
	jQuery(document).on('ajaxSuccess',CloudFw_Uniform);

});

/* ========================================
    FLEXSLIDER (includes.sliders.flex_slider)
========================================*/
jQuery(document).ready(function(){

	jQuery('.flexslider-navigation-prev').click(function(){
		var that = jQuery(this);
		var slider = that.parents('.flexslider-wrapper').first().find('.flexslider');

		slider.flexslider("prev");
	});


	jQuery('.flexslider-navigation-next').click(function(){
		var that = jQuery(this);
		var slider = that.parents('.flexslider-wrapper').first().find('.flexslider');

		slider.flexslider("next");
	});


});

jQuery(window).load(function(){
	jQuery('.flexslider .flex-control-paging li a').html('<div class="ui--bullets"><div class="ui--bullets-color ui--accent-gradient"></div></div>');
});

