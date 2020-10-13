$(document).ready(function(){
    

    /*==================== MENU =====================*/
    jQuery('#menu').superfish({ 
        delay:       1000,                          
        animation:   {opacity:'show', height:'show'},  
        speed:       'fast',                        
        autoArrows:  false
    });
	(function() {

		var $menu = $('#menu'),
			optionsList = '<option value="" selected>Menu...</option>';

		$menu.find('li').each(function() {
			var $this   = $(this),
				$anchor = $this.children('a'),
				depth   = $this.parents('ul').length - 1,
				indent  = '';

			if( depth ) {
				while( depth > 0 ) {
					indent += ' - ';
					depth--;
				}
			}

			optionsList += '<option value="' + $anchor.attr('href') + '">' + indent + ' ' + $anchor.text() + '</option>';
		}).end()
		  .after('<select class="responsive-menu">' + optionsList + '</select>');

		$('.responsive-menu').on('change', function() {
			window.location = $(this).val();
		});
		
	})();


    $('*[data-rel]').each(function() {
        $(this).attr('rel', $(this).data('rel'));
    });
    $("*[rel^='tooltip']").tooltip('hide');

    $("*[rel^='popover']").popover('hide');

    $('.home_services li:last, #page .entry:last, .comments-list li:last').addClass('last');

    $('.da-thumbs article').hoverdir();

    $('#footer .social li:odd').addClass('odd');

     //prettyPhoto
    $("a[rel^='prettyPhoto']").prettyPhoto();

    portfolio = $('.portfolio .p-text').height();
    portfolio =  portfolio+30;
    $('.portfolio div a').css("marginTop", -portfolio );


    prettyPrint();


    //FILTRABLE PORTFOLIO
    var $portfolioClone = $(".portfolio").clone();
    $(".menu-filtrable a").live('click', function(e){
        
        $(".menu-filtrable li").removeClass("current");  
        
        var $filterClass = $(this).parent().attr("class");

        if ( $filterClass == "all" ) {
            var $filteredPortfolio = $portfolioClone.find("article");
        } else {
            var $filteredPortfolio = $portfolioClone.find("article[data-type~=" + $filterClass + "]");
        }
        
        $(".portfolio").quicksand( $filteredPortfolio, { 
            duration: 800, 
            easing: 'easeOutQuint' 
        }, function(){

            $('.da-thumbs  article').hoverdir();
            
            portfolio = $('.portfolio .p-text').height();
            portfolio =  portfolio+30;
            $('.portfolio div a').css("marginTop", -portfolio )
            
            $("a[rel^='prettyPhoto']").prettyPhoto();

        });

        $(this).parent().addClass("current");
        e.preventDefault();
    })


    //FLICKR
    if(jQuery().jflickrfeed) {  
        $('.widget-flickr').jflickrfeed({
            limit: 8,
            qstrings: {
                id: '99771506@N00'
            },
            itemTemplate: '<li>'+
                            '<a rel="prettyPhoto[flickr]" href="{{image}}" title="{{title}}">' +
                                '<img src="{{image_s}}" alt="{{title}}" />' +
                            '</a>' +
                          '</li>'
        }, function(data) {
            $("a[rel^='prettyPhoto']").prettyPhoto();

            $(".flickr li").hover(function () {                      
               $(this).find("img").stop(true, true).animate({ opacity: 0.8 }, 800);
            }, function() {
               $(this).find("img").stop(true, true).animate({ opacity: 1.0 }, 800);
            });
        });
    }


    $("#sidebar .latest-post li").hover(function () {                      
           $(this).find("img").stop(true, true).animate({ opacity: 0.5 }, 800);
        }, function() {
           $(this).find("img").stop(true, true).animate({ opacity: 1.0 }, 800);
    });



    /*==================== ACCORDION =====================*/
    $('.accordion').on('show', function (e) {
         $(e.target).prev('.accordion-heading').find('.accordion-toggle').addClass('acc-active');
    });
    
    $('.accordion').on('hide', function (e) {
        $(this).find('.accordion-toggle').not($(e.target)).removeClass('acc-active');
    });
      
    
});





$(window).load(function() {
    
    /*==================== HOME PAGE SLIDER =====================*/
    $('#home_slider').flexslider({
        animation: "slide",
        directionNav: true,
        slideshow: false,
        controlNav: false,  
        controlsContainer: "#home_slider",
        manualControls: "#slider_control ul li", 
    });

    $('.flex-direction-nav a').css({ opacity: 0 });
    $("#home_slider").hover(function () {                         
        $(this).find("a.flex-prev").animate({left: 0+'px', opacity: 1}, 0);
        $(this).find("a.flex-next").animate({right: 0+'px', opacity: 1}, 0);
    }, function() {
        $(this).find("a.flex-prev").animate({left: -50+'px', opacity: 0 }, 0);
        $(this).find("a.flex-next").animate({right:  -50+'px', opacity: 0 }, 0);
    });
    
});




































