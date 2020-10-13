var CloudFw_jQueried = function( key, element ){
	"use strict";
	if ( typeof element === 'undefined' ) {
		return true;
	}

	if( element.parents('.dont-make-ui').length ) {
		return true;
	}

	if ( jQuery.data(element, key) === true ) {
		return true;
	}

	jQuery.data(element, key, true);
	return false;
};

/*
 * jQuery throttle / debounce - v1.1 - 3/7/2010
 * http://benalman.com/projects/jquery-throttle-debounce-plugin/
 * 
 * Copyright (c) 2010 "Cowboy" Ben Alman
 * Dual licensed under the MIT and GPL licenses.
 * http://benalman.com/about/license/
 */
(function(b,c){var $=b.jQuery||b.Cowboy||(b.Cowboy={}),a;$.throttle=a=function(e,f,j,i){var h,d=0;if(typeof f!=="boolean"){i=j;j=f;f=c}function g(){var o=this,m=+new Date()-d,n=arguments;function l(){d=+new Date();j.apply(o,n)}function k(){h=c}if(i&&!h){l()}h&&clearTimeout(h);if(i===c&&m>e){l()}else{if(f!==true){h=setTimeout(i?k:l,i===c?e-m:e)}}}if($.guid){g.guid=j.guid=j.guid||$.guid++}return g};$.debounce=function(d,e,f){return f===c?a(d,e,false):a(d,f,e!==false)}})(this);


/**
 * Sticky Header
 * 
 * @return void
 */
(function(){
	"use strict";

	var cloudfw_sticky_header = function(){
		
		if ( ! CloudFwOp.sticky_header ) {
			return false;
		}

		var header_container = jQuery('#header-container'); 

		if ( ! jQuery.isFunction( jQuery.fn.waypoint ) ) {      
			return true;
		}


		var device = detectDeviceViaPageWidth(); 

		if ( device == 'widescreen' ) {
			/*if ( header_container.parent().hasClass('sticky-wrapper') ) {
				header_container.unwrap();
			}*/
			//header_container.waypoint('unsticky');

			header_container.waypoint('sticky', {
				wrapper: '<div class="sticky-wrapper" />',
				stuckClass: 'stuck',
				offset: parseInt(CloudFwOp.sticky_header_offset, 10) || 0
			});
		}

	}

	jQuery(window).load(function(){
		cloudfw_sticky_header();
		jQuery(window).smartresize( cloudfw_sticky_header );
	});
	
})(jQuery);

/**
 * Debouncing function from John Hann
 * 
 * http://unscriptable.com/index.php/2009/03/20/debouncing-javascript-methods/
 */
(function($,sr){
  "use strict";

	var debounce = function (func, threshold, execAsap) {
	var timeout;

		return function debounced () {
			var obj = this, args = arguments;
			function delayed () {
				if (!execAsap) {
					func.apply(obj, args);
				}
				timeout = null;
			}

			if (timeout) {
				clearTimeout(timeout);
			} else if (execAsap) {
				func.apply(obj, args);
			}

			timeout = setTimeout(delayed, threshold || 100);
		};

	};

	// smartresize
	jQuery.fn[sr] = function(fn){  return fn ? this.bind('resize', debounce(fn)) : this.trigger(sr); };

})(jQuery,'smartresize');


function cloudFwGetViewportWidth() {
	"use strict";
	var xWidth = null;
	if(window.screen !== null)
		xWidth = window.screen.availWidth;

	if(window.innerWidth !== null)
		xWidth = window.innerWidth;

	if(document.body !== null)
		xWidth = document.body.clientWidth;

	return xWidth;
}

var CloudFwParseAttribute = function( input ){
	"use strict";
	var data = {};

	if ( input ) {
		try {
			if ( typeof input !== 'object' )
				data = jQuery.parseJSON( input );

		} catch (e) {}

		return data;
	}
};


var CloudFwGetColumByClassname = function( elements ){
	"use strict";
	var columns_array = new Array( 1, 2, 3, 4, 6 ),
		classes_array = new Array('span12', 'span6','span4','span3','span2'),
		first_item = elements.first(),
		classes = first_item.attr('class');

	var span = classes.match(/span(\d+)/)[1];
	if ( span )
		span = 'span' + span;

	var position = jQuery.inArray( span, classes_array );

	if ( position !== -1 ) {
		return columns_array[ position ];
	} else {
		return 1;
	}
};


var cloudfw_load_css_file = function( id, filepath ) {
	"use strict";

	var head  = document.getElementsByTagName('head')[0];
	var link  = document.createElement('link');

	link.id   = id;
	link.rel  = 'stylesheet';
	link.type = 'text/css';
	link.href = filepath;
	link.media = 'all';
	head.appendChild(link);
};