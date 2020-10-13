/***************************************************
			Map
***************************************************/
jQuery.noConflict()(function($){
var $map = $('#map-contact');
		google.maps.event.addDomListener(window, 'resize', function() {
			map.setCenter(homeLatlng);
		});
		if( $map.length ) {

			$map.gMap({
				address: '2133 Gentry Memorial, Highway Pickens',
				zoom: 14,
				markers: [
					{ 'address' : '2133 Gentry Memorial, Highway Pickens',}
				]
			});

		}
});
/***************************************************
			Responsive Menu
***************************************************/
jQuery.noConflict()(function($){
	   
      // Create the dropdown base
      $("<select />").appendTo("nav");
      
      // Create default option "Go to..."
      $("<option />", {
         "selected": "selected",
         "value"   : "",
         "text"    : "Please choose page"
      }).appendTo("nav select");
      
      // Populate dropdown with menu items
      $("nav a").each(function() {
       var el = $(this);
       $("<option />", {
           "value"   : el.attr("href"),
           "text"    : el.text()
       }).appendTo("nav select");
      });
      
	   // To make dropdown actually work
	   // To make more unobtrusive: http://css-tricks.com/4064-unobtrusive-page-changer/
      $("nav select").change(function() {
        window.location = $(this).find("option:selected").val();
      });
	 
});
/***************************************************
			Elastic Image Slideshow
***************************************************/
jQuery.noConflict()(function($){
	$(function() {
		$('#ei-slider').eislideshow({
			animation			: 'center',
			autoplay			: true,
			slideshow_interval	: 3000,
			titlesFactor		: 0
		});
	});
});

/***************************************************
			SuperFish Menu
***************************************************/	
// initialise plugins
	jQuery.noConflict()(function(){
		jQuery('ul#menu').superfish();
	});
	
jQuery.noConflict()(function($) {
  if ($.browser.msie && $.browser.version.substr(0,1)<7)
  {
	$('li').has('ul').mouseover(function(){
		$(this).children('ul').css('visibility','visible');
		}).mouseout(function(){
		$(this).children('ul').css('visibility','hidden');
		})
  }
});


/***************************************************
			Nivo SLider
***************************************************/
jQuery.noConflict()(function($){
	$(window).load(function() {
		$('#slider').nivoSlider({directionNavHide:false});
    });
});


/***************************************************
			Slabtext
***************************************************/
jQuery.noConflict()(function($){
	// Function to slabtext the H1 headings
	function slabTextHeadlines() {
			$("#slab").slabText({
					// Don't slabtext the headers if the viewport is under 380px
					"viewportBreakpoint":300
			});
	};
	
	// Called one second after the onload event for the demo (as I'm hacking the fontface load event a bit here)
	// you should really use google WebFont loader events (or something similar) for better control
	$(window).load(function() {
			setTimeout(slabTextHeadlines, 1000);
	});
});


/***************************************************
			Flickr Feed
***************************************************/
 jQuery.noConflict()(function($){
	$(document).ready(function(){

		 $('#basicuse').jflickrfeed({
			  limit: 6,
			  qstrings: {
				   id: '36587311@N08'
			  },
			  itemTemplate: '<li class="span1"><div class="view view-first nolink"><img src="{{image_b}}" alt="" /><div class="mask"><a href="{{image_b}}" title="" class="info fancybox-thumb" rel="fancybox-thumb 1"><span></span></a></div></div></li>'},
		function(data) {
			  $("a[rel^='prettyPhoto']").prettyPhoto({opacity:0.80,default_width:200,default_height:344,theme:'facebook',hideflash:false,modal:false});
		 });
	});
});

/***************************************************
			Pretty Photo
***************************************************/

jQuery.noConflict()(function($){
	$(document).ready(function() {  
		$("a[rel^='prettyPhoto']").prettyPhoto({opacity:0.80,default_width:200,default_height:344,theme:'facebook',hideflash:false,modal:false});
	});
});

/***************************************************
			Twitter feed
***************************************************/
jQuery.noConflict()(function($){
	jQuery(document).ready(function () {
		JQTWEET.loadTweets();
	});
})

/***************************************************
			FancyBox Thumb
***************************************************/

jQuery.noConflict()(function($){
	$(document).ready(function() {
		$(".fancybox-thumb").fancybox({
			openEffect	: 'elastic',
    		closeEffect	: 'elastic',
			prevEffect	: 'none',
			nextEffect	: 'none',
			helpers	: {
				title	: {
					type: 'inside'
				},
				overlay	: {
					opacity : 0.8,
					css : {
						'background-color' : '#4A4A43'
					}
				},
				thumbs	: {
					width	: 50,
					height	: 50
				}
			}
		});
	});
});

/***************************************************
			FancyBox Single
***************************************************/

jQuery.noConflict()(function($){
	$(".fancybox").fancybox({
		helpers: {
			title : {
				type : 'inside'
			},
			overlay : {
				speedIn : 500,
				opacity : 0.95
			}
		}
	});
});

/***************************************************
			Testimonials rotator
***************************************************/
jQuery.noConflict()(function($){
	$(".testimonialrotator").testimonialrotator({
		settings_slideshowTime:2
	});
});

/***************************************************
			Isotope Portfolio
***************************************************/
jQuery.noConflict()(function($){
var $container = $('#portfolio');
		
if($container.length) {
	$container.waitForImages(function() {
		
		// initialize isotope
		$container.isotope({
		  itemSelector : '.block',
		  layoutMode : 'fitRows'
		});
		
		// filter items when filter link is clicked
		$('#filters a').click(function(){
		  var selector = $(this).attr('data-filter');
		  $container.isotope({ filter: selector });
		  $(this).parent().addClass('current').siblings().removeClass('current');
		  return false;
		});
		
	},null,true);
}});

/***************************************************
			Arctext
***************************************************/

jQuery.noConflict()(function($){
	$('#example1').arctext({radius: 70})
	$('#example2').arctext({radius: 70, dir: -1})
});

/***************************************************
			Flexslider
***************************************************/

jQuery.noConflict()(function($){
	$(window).load(function() {
	  $('.flexslider').flexslider({
		animation: "slide",
		animationLoop: true,
		controlNav: false,
		itemWidth: 200,
		itemMargin: 0,
		minItems: 3,
		maxItems: 3,
		pauseOnHover: true,
		preload: true,
        preloadImage: 'assets/img/spinner.gif',
	  });
	});
});

/***************************************************
			Flexslider Blog
***************************************************/

jQuery.noConflict()(function($){
	$(window).load(function() {
	  $('.flexslider_blog').flexslider({
		animation: "slide",
		animationLoop: true,
		controlNav: false,
		directionNav: true,
		itemWidth: 100,
		itemMargin: 0,
		minItems: 1,
		maxItems: 1,
		pauseOnHover: true,
		preload: true,
        preloadImage: 'assets/img/spinner.gif',
	  });
	});
});

/***************************************************
			Preloader
***************************************************/

if (runFancy) {
	jQuery.noConflict()(function($){
		$(".view").preloader();
	});
}