jQuery.noConflict()(function($){
		
			// Create the dropdown bases
			$("<select />").appendTo(".navigation div");
				
			// Create default option "Go to..."
			$("<option />", {
			   "selected": "selected",
			   "value"   : "",
			   "text"    : "Go to..."
			}).appendTo("div select");
				
				
			// Populate dropdowns with the first menu items
			$(".navigation div li a").each(function() {
			 	var el = $(this);
			 	$("<option />", {
			     	"value"   : el.attr("href"),
			    	"text"    : el.text()
			 	}).appendTo("div select");
			});
			
			//make responsive dropdown menu actually work			
	      	$("div select").change(function() {
	        	window.location = $(this).find("option:selected").val();
	      	});
});		

/***************************************************
			TOP TOGGLE PANEL
***************************************************/
jQuery.noConflict()(function($){
$('.toggle').click(function () {
    $('.login-box').slideToggle('5000',"swing", 
        // Animation complete.
         function(){
	        $('.toggle').toggleClass('hide-panel');
			      }   
		    );
	});
});



/***************************************************
			SUPER FISH MENU
***************************************************/
jQuery.noConflict()(function($){
   $("ul.sf-menu").superfish({ 
            pathClass:  'current',
			autoArrows	: false,
			delay:300,
			speed: 'normal',
			animation:   {opacity:'show'}
    });
});


/***************************************************
			EQUAL BLOCK HEIGHT IN THE FOOTER
***************************************************/
jQuery.noConflict()(function($){
        var k = jQuery.noConflict();
        function equalHeight(group) {
            var tallest = 0;
            group.each(function() {
                thisHeight = k(this).height();
                if(thisHeight > tallest) {
                    tallest = thisHeight;
                }
                });
            group.height(tallest);
        }        
            equalHeight(k("footer .widget"));
});


/***************************************************
					Pretty Photo (Lightbox)
***************************************************/
/* Major Colorbox */
jQuery.noConflict()(function($){
	$(document).ready(function(){
		$("a[class^='prettyPhoto']").prettyPhoto({
			animationSpeed: 'normal', /* fast/slow/normal */
			opacity: 0.80, /* Value between 0 and 1 */
			showTitle: true, /* true/false */
			theme:'dark_square'
		});
	});
});	

/***************************************************
					Flickr
***************************************************/
	

/* Sidebar widget */
jQuery.noConflict()(function($){

	$('.flickr').jflickrfeed({
		limit: 12,
		qstrings: {
			id: '98318718@N00'
		},
		itemTemplate: '<li>'+
						'<a data-rel="prettyPhoto" href="{{image_b}}" title="{{title}}">' +
							'<img src="{{image_s}}" alt="{{title}}" />' +
						'</a>' +
					  '</li>'
	}, function(data) {
		$("a[data-rel^='prettyPhoto']").prettyPhoto({
			animationSpeed: 'normal', /* fast/slow/normal */
			opacity: 0.80, /* Value between 0 and 1 */
			showTitle: true, /* true/false */
			theme:'light_square'
		});
	});

});


/***************************************************
					Twitter
***************************************************/
jQuery.noConflict()(function($){
	$(document).ready(function(){
	  /*---- Sidebar Twitter ----*/
	  $(".widget .tweet").tweet({
        	count: 3,
        	username: "envato",
        	loading_text: "loading twitter..."      
		});
				});
});


/***************************************************
			jCarousel
***************************************************/
jQuery.noConflict()(function($){
var $zcarousel = $('#main-carousel, #posts-carousel, #clients-carousel');

    if( $zcarousel.length ) {

        var scrollCount;
        var itemWidth;

        	if( $(window).width() < 320 ) {
           		scrollCount = 1;
            	itemWidth = 234;
        	} else if( $(window).width() < 479 ) {
            	scrollCount = 1;
            	itemWidth = 300;
        	} else if( $(window).width() < 767 ) {
            	scrollCount = 2;
            	itemWidth = 270;
        	} else if( $(window).width() < 960 ) {
            	scrollCount = 3;
            	itemWidth = 172;
        	} else if( $(window).width() < 1200 ) {
            	scrollCount = 3;
            	itemWidth = 220;            	
        	} else {
            	scrollCount = 4;
            	itemWidth = 260;
        }

        $zcarousel.jcarousel({
			   easing: 'easeInOutQuint',
        	   animation : 800,
               scroll    : scrollCount,
               setupCallback: function(carousel) {
               carousel.reload();
                },
                reloadCallback: function(carousel) {
                    var num = Math.floor(carousel.clipping() / itemWidth);
                    carousel.options.scroll = num;
                    carousel.options.visible = num;
                }
            });
        }
});


/***************************************************
			Social Icons Tooltips
***************************************************/
jQuery.noConflict()(function($){
	$('.social-icons').tooltip({
	selector: "a[data-rel=tooltip]"
	});
	
	// tooltip demo
    $('.tooltip-demo.well').tooltip({
      selector: "a[data-rel=tooltip]"
    })	
});


