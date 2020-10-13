// Hover move listing
$(document).ready(function() {
	
	// toggle
	$(".toggle-container").hide(); 
	$(".toggle-trigger").click(function(){
		$(this).toggleClass("active").next().slideToggle("slow");
		return false;
	});
	
	// accordion
	$('.accordion-container').hide(); 
	$('.accordion-trigger:first').addClass('active').next().show();
	$('.accordion-trigger').click(function(){
		if( $(this).next().is(':hidden') ) { 
			$('.accordion-trigger').removeClass('active').next().slideUp();
			$(this).toggleClass('active').next().slideDown();		}
		return false;
	});
	
	// tabs
	$("ul.tabs").tabs("div.panes > div", {effect: 'fade'});

	// nivo slider
	$('#slider').nivoSlider({
		effect:'random', //Specify sets like: 'fold,fade,sliceDown'
        slices:15,
        animSpeed:500, //Slide transition speed
        pauseTime:3000,
        startSlide:0, //Set starting Slide (0 index)
        directionNav:true, //Next & Prev
        directionNavHide:true, //Only show on hover
        controlNav:true, //1,2,3...
        controlNavThumbs:false, //Use thumbnails for Control Nav
        controlNavThumbsFromRel:false, //Use image rel for thumbs
        controlNavThumbsSearch: '.jpg', //Replace this with...
        controlNavThumbsReplace: '_thumb.jpg', //...this in thumb Image src
        keyboardNav:true, //Use left & right arrows
        pauseOnHover:true, //Stop animation while hovering
        manualAdvance: false, //Force manual transitions
        captionOpacity:0.7 //Universal caption opacity
	});

	// Scroll to top
	$('#bottom-right').click(function(){
		$.scrollTo( {top:'0px', left:'0px'}, 300 );
	});

	// Flicker
	$('#flickr-stream').jflickrfeed({
		limit: 9,
		qstrings: {
			id: '37304598@N02'
		},
		itemTemplate:
		'<li>' +
			'<a rel="colorbox" href="{{image}}" title="{{title}}">' +
				'<img src="{{image_s}}" alt="{{title}}" />' +
			'</a>' +
		'</li>'
	}, function(data) {
		$('#flickr-stream a').colorbox();
	});
		
	// Tweet
	$(".tweet").tweet({
        username: "ansimuz",
        join_text: "auto",
        avatar_size: 32,
        count: 3,
        auto_join_text_default: "we said,",
        auto_join_text_ed: "we",
        auto_join_text_ing: "we were",
        auto_join_text_reply: "we replied to",
        auto_join_text_url: "we were checking out",
        loading_text: "loading tweets..."
    });
    
    // Poshytips
    $('.social a, .blocks-gallery a, .poshy img, .poshytip').poshytip({
    	className: 'tip-twitter',
		showTimeout: 1,
		alignTo: 'target',
		alignX: 'center',
		offsetY: 5,
		allowTipHover: false
    });
    
    // Poshytips Forms
    $('.form-poshytip').poshytip({
		className: 'tip-yellowsimple',
		showOn: 'focus',
		alignTo: 'target',
		alignX: 'right',
		alignY: 'center',
		offsetX: 5
	});


	// Superfish menu
	$("ul.sf-menu").superfish({ 
        animation: {height:'show'},   // slide-down effect without fade-in 
        delay:     800               // 1.2 second delay on mouseout 
    }); 
    
	// rollovers
	$("ul.sf-menu>li> a, ul.sf-menu>li>ul li a, #footer-cols>li ul li a").hover(function() { 
		// on rollover	
		$(this).stop().animate({ 
			marginLeft: "3" 
		}, "fast");
	} , function() { 
		// on out
		$(this).stop().animate({
			marginLeft: "0" 
		}, "fast");
	});
	
	// Gallery functions
	function galleryFunctions(){
		// Gallery Thumbnail slide
		$('.boxgrid').hover(function(){
			$(".cover", this).stop().animate({top:'-260px'},{queue:false,duration:400});
		}, function() {
			$(".cover", this).stop().animate({top:'0px'},{queue:false,duration:400});
		});
		
		// Gallery 4 cols Thumbnail slide
		$('.fourcols .boxgrid').hover(function(){
			$(".cover", this).stop().animate({top:'-126px'},{queue:false,duration:400});
		}, function() {
			$(".cover", this).stop().animate({top:'0px'},{queue:false,duration:400});
		});
		
		// Fancy box
		$("a.fancybox").fancybox({ 
			'overlayColor'		:	'#000'
		});
		
		// pretty photo
		$("a[rel^='prettyPhoto']").prettyPhoto({
			theme: 'light_square'
		});
	}
	// init
	galleryFunctions();
	
	// Quicksand -----------------------------------------------------------//
	// get the initial (full) list
	var $filterList = $('ul#portfolio-list');
		
	// Unique id 
	for(var i=0; i<$('ul#portfolio-list li').length; i++){
		$('ul#portfolio-list li:eq(' + i + ')').attr('id','unique_item' + i);
	}
	
	// clone list
	var $data = $filterList.clone();
	
	// Click
	$('#portfolio-filter a').click(function(e) {
		if($(this).attr('rel') == 'all') {
			// get a group of all items
			var $filteredData = $data.find('li');
		} else {
			// get a group of items of a particular class
			var $filteredData = $data.find('li.' + $(this).attr('rel'));
		}
		
		// call Quicksand
		$('ul#portfolio-list').quicksand($filteredData, {
			duration: 500,
			attribute: function(v) {
				// this is the unique id attribute we created above
				return $(v).attr('id');
			}
		}, function() {
	        // restart functions
	        galleryFunctions();
		});
		// remove # link
		e.preventDefault();
	});
	// ENDS Quicksand ----------------------------------------------------//

//close			
});
	
// search clearance	
function defaultInput(target){
	if((target).value == 'Search...'){(target).value=''}
}

function clearInput(target){
	if((target).value == ''){(target).value='Search...'}
}

