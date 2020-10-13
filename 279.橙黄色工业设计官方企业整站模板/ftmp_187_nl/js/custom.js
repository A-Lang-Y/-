/**************************************************************************
   ******************Media Query Support for IE 6-8 ********************
***************************************************************************/



/*! matchMedia() polyfill - Test a CSS media type/query in JS. Authors & copyright (c) 2012: Scott Jehl, Paul Irish, Nicholas Zakas. Dual MIT/BSD license */
/*! NOTE: If you're already including a window.matchMedia polyfill via Modernizr or otherwise, you don't need this part */
window.matchMedia = window.matchMedia || (function(doc, undefined){
  
  var bool,
      docElem = doc.documentElement,
      refNode = docElem.firstElementChild || docElem.firstChild,
      // fakeBody required for <FF4 when executed in <head>
      fakeBody = doc.createElement('body'),
      div = doc.createElement('div');
  
  div.id = 'mq-test-1';
  div.style.cssText = "position:absolute;top:-100em";
  fakeBody.appendChild(div);
  
  return function(q){
    
    div.innerHTML = '&shy;<style media="'+q+'"> #mq-test-1 { width: 42px; }</style>';
    
    docElem.insertBefore(fakeBody, refNode);
    bool = div.offsetWidth == 42;
    docElem.removeChild(fakeBody);
    
    return { matches: bool, media: q };
  };
  
})(document);




/*! Respond.js v1.1.0: min/max-width media query polyfill. (c) Scott Jehl. MIT/GPLv2 Lic. j.mp/respondjs */
(function( win ){
//exposed namespace
win.respond = {};

//define update even in native-mq-supporting browsers, to avoid errors
respond.update = function(){};

//expose media query support flag for external use
respond.mediaQueriesSupported = win.matchMedia && win.matchMedia( "only all" ).matches;

//if media queries are supported, exit here
if( respond.mediaQueriesSupported ){ return; }

//define vars
var doc = win.document,
docElem = doc.documentElement,
mediastyles = [],
rules = [],
appendedEls = [],
parsedSheets = {},
resizeThrottle = 30,
head = doc.getElementsByTagName( "head" )[0] || docElem,
base = doc.getElementsByTagName( "base" )[0],
links = head.getElementsByTagName( "link" ),
requestQueue = [],

//loop stylesheets, send text content to translate
ripCSS = function(){
var sheets = links,
sl = sheets.length,
i = 0,
//vars for loop:
sheet, href, media, isCSS;

for( ; i < sl; i++ ){
sheet = sheets[ i ],
href = sheet.href,
media = sheet.media,
isCSS = sheet.rel && sheet.rel.toLowerCase() === "stylesheet";

//only links plz and prevent re-parsing
if( !!href && isCSS && !parsedSheets[ href ] ){
// selectivizr exposes css through the rawCssText expando
if (sheet.styleSheet && sheet.styleSheet.rawCssText) {
translate( sheet.styleSheet.rawCssText, href, media );
parsedSheets[ href ] = true;
} else {
if( (!/^([a-zA-Z:]*\/\/)/.test( href ) && !base)
|| href.replace( RegExp.$1, "" ).split( "/" )[0] === win.location.host ){
requestQueue.push( {
href: href,
media: media
} );
}
}
}
}
makeRequests();
},

//recurse through request queue, get css text
makeRequests = function(){
if( requestQueue.length ){
var thisRequest = requestQueue.shift();

ajax( thisRequest.href, function( styles ){
translate( styles, thisRequest.href, thisRequest.media );
parsedSheets[ thisRequest.href ] = true;
makeRequests();
} );
}
},

//find media blocks in css text, convert to style blocks
translate = function( styles, href, media ){
var qs = styles.match( /@media[^\{]+\{([^\{\}]*\{[^\}\{]*\})+/gi ),
ql = qs && qs.length || 0,
//try to get CSS path
href = href.substring( 0, href.lastIndexOf( "/" )),
repUrls = function( css ){
return css.replace( /(url\()['"]?([^\/\)'"][^:\)'"]+)['"]?(\))/g, "$1" + href + "$2$3" );
},
useMedia = !ql && media,
//vars used in loop
i = 0,
j, fullq, thisq, eachq, eql;

//if path exists, tack on trailing slash
if( href.length ){ href += "/"; }

//if no internal queries exist, but media attr does, use that
//note: this currently lacks support for situations where a media attr is specified on a link AND
//its associated stylesheet has internal CSS media queries.
//In those cases, the media attribute will currently be ignored.
if( useMedia ){
ql = 1;
}


for( ; i < ql; i++ ){
j = 0;

//media attr
if( useMedia ){
fullq = media;
rules.push( repUrls( styles ) );
}
//parse for styles
else{
fullq = qs[ i ].match( /@media *([^\{]+)\{([\S\s]+?)$/ ) && RegExp.$1;
rules.push( RegExp.$2 && repUrls( RegExp.$2 ) );
}

eachq = fullq.split( "," );
eql = eachq.length;

for( ; j < eql; j++ ){
thisq = eachq[ j ];
mediastyles.push( {
media : thisq.split( "(" )[ 0 ].match( /(only\s+)?([a-zA-Z]+)\s?/ ) && RegExp.$2 || "all",
rules : rules.length - 1,
hasquery: thisq.indexOf("(") > -1,
minw : thisq.match( /\(min\-width:[\s]*([\s]*[0-9\.]+)(px|em)[\s]*\)/ ) && parseFloat( RegExp.$1 ) + ( RegExp.$2 || "" ),
maxw : thisq.match( /\(max\-width:[\s]*([\s]*[0-9\.]+)(px|em)[\s]*\)/ ) && parseFloat( RegExp.$1 ) + ( RegExp.$2 || "" )
} );
}
}

applyMedia();
},
        
lastCall,

resizeDefer,

// returns the value of 1em in pixels
getEmValue = function() {
var ret,
div = doc.createElement('div'),
body = doc.body,
fakeUsed = false;

div.style.cssText = "position:absolute;font-size:1em;width:1em";

if( !body ){
body = fakeUsed = doc.createElement( "body" );
}

body.appendChild( div );

docElem.insertBefore( body, docElem.firstChild );

ret = div.offsetWidth;

if( fakeUsed ){
docElem.removeChild( body );
}
else {
body.removeChild( div );
}

//also update eminpx before returning
ret = eminpx = parseFloat(ret);

return ret;
},

//cached container for 1em value, populated the first time it's needed
eminpx,

//enable/disable styles
applyMedia = function( fromResize ){
var name = "clientWidth",
docElemProp = docElem[ name ],
currWidth = doc.compatMode === "CSS1Compat" && docElemProp || doc.body[ name ] || docElemProp,
styleBlocks = {},
lastLink = links[ links.length-1 ],
now = (new Date()).getTime();

//throttle resize calls
if( fromResize && lastCall && now - lastCall < resizeThrottle ){
clearTimeout( resizeDefer );
resizeDefer = setTimeout( applyMedia, resizeThrottle );
return;
}
else {
lastCall = now;
}

for( var i in mediastyles ){
var thisstyle = mediastyles[ i ],
min = thisstyle.minw,
max = thisstyle.maxw,
minnull = min === null,
maxnull = max === null,
em = "em";

if( !!min ){
min = parseFloat( min ) * ( min.indexOf( em ) > -1 ? ( eminpx || getEmValue() ) : 1 );
}
if( !!max ){
max = parseFloat( max ) * ( max.indexOf( em ) > -1 ? ( eminpx || getEmValue() ) : 1 );
}

// if there's no media query at all (the () part), or min or max is not null, and if either is present, they're true
if( !thisstyle.hasquery || ( !minnull || !maxnull ) && ( minnull || currWidth >= min ) && ( maxnull || currWidth <= max ) ){
if( !styleBlocks[ thisstyle.media ] ){
styleBlocks[ thisstyle.media ] = [];
}
styleBlocks[ thisstyle.media ].push( rules[ thisstyle.rules ] );
}
}

//remove any existing respond style element(s)
for( var i in appendedEls ){
if( appendedEls[ i ] && appendedEls[ i ].parentNode === head ){
head.removeChild( appendedEls[ i ] );
}
}

//inject active styles, grouped by media type
for( var i in styleBlocks ){
var ss = doc.createElement( "style" ),
css = styleBlocks[ i ].join( "\n" );

ss.type = "text/css";
ss.media = i;

//originally, ss was appended to a documentFragment and sheets were appended in bulk.
//this caused crashes in IE in a number of circumstances, such as when the HTML element had a bg image set, so appending beforehand seems best. Thanks to @dvelyk for the initial research on this one!
head.insertBefore( ss, lastLink.nextSibling );

if ( ss.styleSheet ){
ss.styleSheet.cssText = css;
}
else {
ss.appendChild( doc.createTextNode( css ) );
}

//push to appendedEls to track for later removal
appendedEls.push( ss );
}
},
//tweaked Ajax functions from Quirksmode
ajax = function( url, callback ) {
var req = xmlHttp();
if (!req){
return;
}
req.open( "GET", url, true );
req.onreadystatechange = function () {
if ( req.readyState != 4 || req.status != 200 && req.status != 304 ){
return;
}
callback( req.responseText );
}
if ( req.readyState == 4 ){
return;
}
req.send( null );
},
//define ajax obj
xmlHttp = (function() {
var xmlhttpmethod = false;
try {
xmlhttpmethod = new XMLHttpRequest();
}
catch( e ){
xmlhttpmethod = new ActiveXObject( "Microsoft.XMLHTTP" );
}
return function(){
return xmlhttpmethod;
};
})();

//translate CSS
ripCSS();

//expose update for re-running respond later on
respond.update = ripCSS;

//adjust on resize
function callMedia(){
applyMedia( true );
}
if( win.addEventListener ){
win.addEventListener( "resize", callMedia, false );
}
else if( win.attachEvent ){
win.attachEvent( "onresize", callMedia );
}
})(this);



/**************************************************************************
   ******************     Contact Form Validation    ********************
***************************************************************************/
$(document).ready(function() {
	$('form#contact_form').submit(function() {
		$('form#contact_form .error').remove();
		var hasError = false;
		$('.requiredField').each(function() {
			if(jQuery.trim($(this).val()) == '') {
            	var labelText = $(this).prev('label').text();
            	$(this).parent().append('<span class="error">You forgot to enter your '+labelText+'.</span>');
            	$(this).addClass('inputError');
            	hasError = true;
            } else if($(this).hasClass('email')) {
            	var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
            	if(!emailReg.test(jQuery.trim($(this).val()))) {
            		var labelText = $(this).prev('label').text();
            		$(this).parent().append('<span class="error">You entered an invalid '+labelText+'.</span>');
            		$(this).addClass('inputError');
            		hasError = true;
            	}
            }
		});
		if(!hasError) {
			$('form#contact_form input.submit').fadeOut('normal', function() {
				$(this).parent().append('');
			});
			var formInput = $(this).serialize();
			$.post($(this).attr('action'),formInput, function(data){
				$('form#contact_form').slideUp("fast", function() {
					$(this).before('<p class="success">Thanks! Your email was successfully sent. We will contact you as soon as possible.</p>');
				});
			});
		}

		return false;

	});
});

/**************************************************************************
   ******************           Tabbed Area          ********************
***************************************************************************/



$(document).ready(function() {

	//When page loads...
	$(".tab_content").hide(); //Hide all content
	$("ul.tabs li:first").addClass("active").show(); //Activate first tab
	$(".tab_content:first").show(); //Show first tab content

	//On Click Event
	$("ul.tabs li").click(function() {

		$("ul.tabs li").removeClass("active"); //Remove any "active" class
		$(this).addClass("active"); //Add "active" class to selected tab
		$(".tab_content").hide(); //Hide all tab content

		var activeTab = $(this).find("a").attr("href"); //Find the href attribute value to identify the active tab + content
		$(activeTab).fadeIn(); //Fade in the active ID content
		return false;
	});

});


/**************************************************************************
   ******************       Tipsy Rollovers          ********************
***************************************************************************/


(function(jQuery) {
    jQuery.fn.tipsy = function(options) {

        options = jQuery.extend({}, jQuery.fn.tipsy.defaults, options);
        
        return this.each(function() {
            
            var opts = jQuery.fn.tipsy.elementOptions(this, options);
            
            jQuery(this).hover(function() {

                jQuery.data(this, 'cancel.tipsy', true);

                var tip = jQuery.data(this, 'active.tipsy');
                if (!tip) {
                    tip = jQuery('<div class="tipsy"><div class="tipsy-inner"/></div>');
                    tip.css({position: 'absolute', zIndex: 100000});
                    jQuery.data(this, 'active.tipsy', tip);
                }

                if (jQuery(this).attr('title') || typeof(jQuery(this).attr('original-title')) != 'string') {
                    jQuery(this).attr('original-title', jQuery(this).attr('title') || '').removeAttr('title');
                }

                var title;
                if (typeof opts.title == 'string') {
                    title = jQuery(this).attr(opts.title == 'title' ? 'original-title' : opts.title);
                } else if (typeof opts.title == 'function') {
                    title = opts.title.call(this);
                }

                tip.find('.tipsy-inner')[opts.html ? 'html' : 'text'](title || opts.fallback);

                var pos = jQuery.extend({}, jQuery(this).offset(), {width: this.offsetWidth, height: this.offsetHeight});
                tip.get(0).className = 'tipsy'; // reset classname in case of dynamic gravity
                tip.remove().css({top: 0, left: 0, visibility: 'hidden', display: 'block'}).appendTo(document.body);
                var actualWidth = tip[0].offsetWidth, actualHeight = tip[0].offsetHeight;
                var gravity = (typeof opts.gravity == 'function') ? opts.gravity.call(this) : opts.gravity;

                switch (gravity.charAt(0)) {
                    case 'n':
                        tip.css({top: pos.top + pos.height, left: pos.left + pos.width / 2 - actualWidth / 2}).addClass('tipsy-north');
                        break;
                    case 's':
                        tip.css({top: pos.top - actualHeight, left: pos.left + pos.width / 2 - actualWidth / 2}).addClass('tipsy-south');
                        break;
                    case 'e':
                        tip.css({top: pos.top + pos.height / 2 - actualHeight / 2, left: pos.left - actualWidth}).addClass('tipsy-east');
                        break;
                    case 'w':
                        tip.css({top: pos.top + pos.height / 2 - actualHeight / 2, left: pos.left + pos.width}).addClass('tipsy-west');
                        break;
                }

                if (opts.fade) {
                    tip.css({opacity: 0, display: 'block', visibility: 'visible'}).animate({opacity: 1.0});
                } else {
                    tip.css({visibility: 'visible'});
                }

            }, function() {
                jQuery.data(this, 'cancel.tipsy', false);
                var self = this;
                setTimeout(function() {
                    if (jQuery.data(this, 'cancel.tipsy')) return;
                    var tip = jQuery.data(self, 'active.tipsy');
                    if (opts.fade) {
                        tip.stop().fadeOut(function() { jQuery(this).remove(); });
                    } else {
                        tip.remove();
                    }
                }, 100);

            });
            
        });
        
    };
    
    // Overwrite this method to provide options on a per-element basis.
    // For example, you could store the gravity in a 'tipsy-gravity' attribute:
    // return jQuery.extend({}, options, {gravity: jQuery(ele).attr('tipsy-gravity') || 'n' });
    // (remember - do not modify 'options' in place!)
    jQuery.fn.tipsy.elementOptions = function(ele, options) {
        return jQuery.metadata ? jQuery.extend({}, options, jQuery(ele).metadata()) : options;
    };
    
    jQuery.fn.tipsy.defaults = {
        fade: false,
        fallback: '',
        gravity: 'e',
        html: false,
        title: 'title'
    };
    
    jQuery.fn.tipsy.autoNS = function() {
        return jQuery(this).offset().top > (jQuery(document).scrollTop() + jQuery(window).height() / 2) ? 's' : 'n';
    };
    
    jQuery.fn.tipsy.autoWE = function() {
        return jQuery(this).offset().left > (jQuery(document).scrollLeft() + jQuery(window).width() / 2) ? 'e' : 'w';
    };
    
})(jQuery);

/**************************************************************************
   ******************     Image Fade Rollovers       ********************
***************************************************************************/

$(document).ready(function(){
	$("#footer a img, .flickr_badge_image").fadeTo("slow", 1.0); // This sets the opacity of the thumbs to fade down to 100% when the page loads

	$("#footer a img, .flickr_badge_image").hover(function(){
		$(this).fadeTo("slow", 0.6); // This should set the opacity to 60% on hover
	},function(){
   		$(this).fadeTo("slow", 1.0); // This should set the opacity back to 100% on mouseout
	});
});

/**************************************************************************
   ******************   Quicksand Portfolio Filter   ********************
***************************************************************************/

/*-----------------------------------------------------------------------------------*/
/*	Filter States
/*-----------------------------------------------------------------------------------*/

	var filterLinks = $('#filter li');
	
	filterLinks.click( function(e) {
	
		filterLinks.removeClass('active');
		
		filterLinks.not(this).find('span.border').fadeOut(100);
		
		$(this).addClass('active');
		
		e.preventDefault();
	});
	
	filterLinks.hover( function() {
		$(this).not('.active').find('.border').stop().css({
			opacity: 0,
			display: 'block'
		}).animate({
			opacity: 1
		}, 150);
			
	}, function() {
		$(this).not('.active').find('.border').stop().fadeOut(150);
	});

	
/*-----------------------------------------------------------------------------------*/
/*	Portfolio Sorting
/*-----------------------------------------------------------------------------------*/
	
	if ($().quicksand) {

		(function($) {
			
			$.fn.sorted = function(customOptions) {
				var options = {
					reversed: false,
					by: function(a) {
						return a.text();
					}
				};
		
				$.extend(options, customOptions);
		
				$data = $(this);
				arr = $data.get();
				arr.sort(function(a, b) {
		
					var valA = options.by($(a));
					var valB = options.by($(b));
			
					if (options.reversed) {
						return (valA < valB) ? 1 : (valA > valB) ? -1 : 0;				
					} else {		
						return (valA < valB) ? -1 : (valA > valB) ? 1 : 0;	
					}
			
				});
		
				return $(arr);
		
			};
		
		})($);
		
		$(function() {
		
			var read_button = function(class_names) {
				
				var r = {
					selected: false,
					type: 0
				};
				
				for (var i=0; i < class_names.length; i++) {
					
					if (class_names[i].indexOf('selected-') == 0) {
						r.selected = true;
					}
				
					if (class_names[i].indexOf('segment-') == 0) {
						r.segment = class_names[i].split('-')[1];
					}
				};
				
				return r;
				
			};
		
			var determine_sort = function($buttons) {
				var $selected = $buttons.parent().filter('[class*="selected-"]');
				return $selected.find('a').attr('data-value');
			};
		
			var determine_kind = function($buttons) {
				var $selected = $buttons.parent().filter('[class*="selected-"]');
				return $selected.find('a').attr('data-value');
			};
		
			var $preferences = {
				duration: 500,
				adjustHeight: 'dynamic'
			}
		
			var $list = $('.grid');
			var $data = $list.clone();
		
			var $controls = $('#filter');
		
			$controls.each(function(i) {
		
				var $control = $(this);
				var $buttons = $control.find('a');
		
				$buttons.bind('click', function(e) {
		
					var $button = $(this);
					var $button_container = $button.parent();
					
					var button_properties = read_button($button_container.attr('class').split(' '));      
					var selected = button_properties.selected;
					var button_segment = button_properties.segment;
		
					if (!selected) {
		
						$buttons.parent().removeClass();
						$button_container.addClass('selected-' + button_segment);
		
						var sorting_type = determine_sort($controls.eq(1).find('a'));
						var sorting_kind = determine_kind($controls.eq(0).find('a'));
		
						if (sorting_kind == 'all') {
							var $filtered_data = $data.find('li');
						} else {
							var $filtered_data = $data.find('li.' + sorting_kind);
						}
		
						var $sorted_data = $filtered_data.sorted({
							by: function(v) {
								return parseInt(jQuery(v).find('.count').text());
							}
						});
		
						$list.quicksand($sorted_data, $preferences, function () {
						});
						
						//console.log($sorted_data);
			
					}
			
					e.preventDefault();
					
				});
			
			}); 
			
		});
	
	}


/**************************************************************************
   ******************        Drop Down Panel         ********************
***************************************************************************/

var timerlen = 2;
var slideAniLen = 350;

var timerID = new Array();
var startTime = new Array();
var obj = new Array();
var endHeight = new Array();
var moving = new Array();
var dir = new Array();

function slidedown(toggleMe){
        if(moving[toggleMe])
                return;

        if(document.getElementById(toggleMe).style.display != "none")
                return; // cannot slide down something that is already visible

        moving[toggleMe] = true;
        dir[toggleMe] = "down";
        startslide(toggleMe);
}

function slideup(toggleMe){
        if(moving[toggleMe])
                return;

        if(document.getElementById(toggleMe).style.display == "none")
                return; // cannot slide up something that is already hidden

        moving[toggleMe] = true;
        dir[toggleMe] = "up";
        startslide(toggleMe);
}

function startslide(toggleMe){
        obj[toggleMe] = document.getElementById(toggleMe);

        endHeight[toggleMe] = parseInt(obj[toggleMe].style.height);
        startTime[toggleMe] = (new Date()).getTime();

        if(dir[toggleMe] == "down"){
                obj[toggleMe].style.height = "1px";
        }

        obj[toggleMe].style.display = "block";

        timerID[toggleMe] = setInterval('slidetick(\'' + toggleMe + '\');',timerlen);
}

function slidetick(toggleMe){
        var elapsed = (new Date()).getTime() - startTime[toggleMe];

        if (elapsed > slideAniLen)
                endSlide(toggleMe)
        else {
                var d =Math.round(elapsed / slideAniLen * endHeight[toggleMe]);
                if(dir[toggleMe] == "up")
                        d = endHeight[toggleMe] - d;

                obj[toggleMe].style.height = d + "px";
        }

        return;
}

function endSlide(toggleMe){
        clearInterval(timerID[toggleMe]);

        if(dir[toggleMe] == "up")
                obj[toggleMe].style.display = "none";

        obj[toggleMe].style.height = endHeight[toggleMe] + "px";

        delete(moving[toggleMe]);
        delete(timerID[toggleMe]);
        delete(startTime[toggleMe]);
        delete(endHeight[toggleMe]);
        delete(obj[toggleMe]);
        delete(dir[toggleMe]);

        return;
}

function toggleSlide(toggleMe){
  if(document.getElementById(toggleMe).style.display == "none"){
    // div is hidden, so let's slide down
    slidedown(toggleMe);
  }else{
    // div is not hidden, so slide up
    slideup(toggleMe);
  }
}


/**************************************************************************
   ******************           ACCORDION            ********************
***************************************************************************/


/***********************************************************************************************************************
DOCUMENT: includes/javascript.js
DEVELOPED BY: Ryan Stemkoski
COMPANY: Zipline Interactive
EMAIL: ryan@gozipline.com
PHONE: 509-321-2849
DATE: 3/26/2009
UPDATED: 3/25/2010
DESCRIPTION: This is the JavaScript required to create the accordion style menu.  Requires jQuery library
NOTE: Because of a bug in jQuery with IE8 we had to add an IE stylesheet hack to get the system to work in all browsers. I hate hacks but had no choice :(.
************************************************************************************************************************/
jQuery(document).ready(function() {
	 
	//ACCORDION BUTTON ACTION (ON CLICK DO THE FOLLOWING)
	jQuery('.accordionButton').click(function() {

		//REMOVE THE ON CLASS FROM ALL BUTTONS
		jQuery('.accordionButton').removeClass('on');
		  
		//NO MATTER WHAT WE CLOSE ALL OPEN SLIDES
	 	jQuery('.accordionContent').slideUp('300','easeInQuad');
   
		//IF THE NEXT SLIDE WASN'T OPEN THEN OPEN IT
		if(jQuery(this).next().is(':hidden') == true) {
			
			//ADD THE ON CLASS TO THE BUTTON
			jQuery(this).addClass('on');
			  
			//OPEN THE SLIDE
			jQuery(this).next().slideDown('300','easeInQuad');
		 } 
		  
	 });
	  
	
	/*** REMOVE IF MOUSEOVER IS NOT REQUIRED ***/
	
	//ADDS THE .OVER CLASS FROM THE STYLESHEET ON MOUSEOVER 
	jQuery('.accordionButton').mouseover(function() {
		jQuery(this).addClass('over');
		
	//ON MOUSEOUT REMOVE THE OVER CLASS
	}).mouseout(function() {
		jQuery(this).removeClass('over');										
	});
	
	/*** END REMOVE IF MOUSEOVER IS NOT REQUIRED ***/
	
	
	/********************************************************************************************************************
	CLOSES ALL S ON PAGE LOAD
	********************************************************************************************************************/	
	jQuery('.accordionContent').hide();

});




    $(document).ready(function(){  
        $('.menuitem img').animate({width: 305}, 0); //Set all menu items to smaller size  
      
        $('.menuitem').mouseover(function(){ //When mouse over menu item  
      
            gridimage = $(this).find('img'); //Define target as a variable  
            gridimage.stop().animate({width: 381}, 150); //Animate image expanding to original size  
      
        }).mouseout(function(){ //When mouse no longer over menu item  
      
            gridimage.stop().animate({width: 305}, 150); //Animate image back to smaller size  
      
        });  
    }); 
	
/**************************************************************************
   ******************      THIS IS THE MENU JS      ********************
***************************************************************************/

$(document).ready(function(){ 
$("ul.sf-menu").supersubs({ 
minWidth:    12,   // minimum width of sub-menus in em units 
maxWidth:    45,   // maximum width of sub-menus in em units 
extraWidth:  1     // extra width can ensure lines don't sometimes turn over 
				   // due to slight rounding differences and font-family 
}).superfish();  // call supersubs first, then superfish, so that subs are 
			 // not display:none when measuring. Call before initialising 
			 // containing tabs for same reason. 
}); 

/**************************************************************************
   ******************   THIS IS THE TWITTER JS      ********************
***************************************************************************/

$(document).ready(function(){
$(".tweet").tweet({
	username: "@twsjonathan",
	join_text: "auto",
	avatar_size: 47,
	count: 2,
	auto_join_text_default: "we said,", 
	auto_join_text_ed: "we",
	auto_join_text_ing: "we were",
	auto_join_text_reply: "we replied to",
	auto_join_text_url: "we were checking out",
	loading_text: "loading tweets..."
});
});
