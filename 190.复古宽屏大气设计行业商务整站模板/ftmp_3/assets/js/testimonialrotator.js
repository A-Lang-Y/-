
(function($) {

	$.fn.testimonialrotator = function(o) {
		
		var defaults = {
			settings_slideshowTime : '5',
			settings_autoHeight : 'on'
		}
		
		o = $.extend(defaults, o);
		this.each( function() {
			var cthis = jQuery(this);
			var cchildren = cthis.children();
			var currNr=0;
			var timebuf=0;
			var slideshowTime = parseInt(o.settings_slideshowTime);
			setInterval(tick, 1000);
			cthis.height(cchildren.eq(currNr).height());
			cchildren.eq(0).css('position', 'absolute');
			function tick(){
				timebuf++;
				if(timebuf>slideshowTime){
					timebuf=0;
					gotoNext();
				}
			}
			function gotoNext(){
				var arg=currNr+1;
				if(arg>cchildren.length-1){
				arg=0;
				}
				cchildren.eq(currNr).fadeOut('slow');
				cchildren.eq(arg).fadeIn('slow');
				if(o.settings_autoHeight=='on'){
					cthis.animate({'height' : cchildren.eq(arg).height()})
				}
				currNr=arg;
			}
			return this;
		})
	}
})(jQuery)
	