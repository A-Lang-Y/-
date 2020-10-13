// JavaScript Document

$(document).ready(function() {
						   
//Google map setting

        $('#google_map').gmap3({
            action: 'addMarker',
            address: "Pearl St, NY",
            map: {
                center: true,
                zoom: 10
            },
            marker: {
                options: {
                    draggable: false
                }
            },
            infowindow: {
                options: {
                    content: 'Hello World !<br>Phone: +1 111 111-11-11<br>Address: Chicago, IL, 111 Webdev St'
                },
                events: {
                    closeclick: function() {

}
                }
            }
        });


// smoothScroll	/ page

    $('.main-navigation a').smoothScroll({
        speed: 1500,
        offset: -150,
        easing: 'easeOutExpo',
        exclude: ['#portfolio-filter li a,#gallery-filter li a,#about']

    });

$('article > section').waypoint({
        offset: '35%'
    });

    $('body').delegate('article > section', 'waypoint.reached',
    function(event, direction) {
        var $active = $(this);
        if (direction === 'up') {
            $active = $active.prev();
        }
        if (!$active.length) {
            $active.end();
        }

        $('.section-active').removeClass('section-active');

        $active.addClass('section-active').find('.header > h1').delay(500).animate({
            marginLeft: "0px"
        },
        {
            duration: 500,
            easing: 'easeOutExpo',
            complete: function() {
                /////////////////////////////////
                $active.find('.header > p').animate({
                    marginTop: "0px"
                },
                {
                    duration: 500,
                    easing: 'easeOutExpo',
                    complete: function() {}
                    /////////////
                });
            }

        });

        $('.current').removeClass('current');
        $(".main-navigation a[href=#" + $active.attr("id") + "]").addClass('current');
    });
	
	
	// prettyPhoto plugin

    $("a[rel^='prettyPhoto']").prettyPhoto();
	
	$('ul#portfolio-filter a').click(function() {

        $('ul#portfolio-filter a.currents').removeClass('currents');
        $(this).addClass('currents');

        var filterVal = $(this).text().toLowerCase().replace(' ', '-');

        if (filterVal == 'all') {
            $('#containment-portfolio li.hidden').fadeTo("slow",1).removeClass('hidden');
        } else {

            $('#containment-portfolio li').each(function() {
                if (!$(this).hasClass(filterVal)) {
                    $(this).fadeTo("slow",0.5).addClass('hidden');

                } else {
                    $(this).fadeTo("slow",1).removeClass('hidden');

                }
            });
        }

        return false;
    });
	
	$('.portfolio-item').hover(function() {

        $(this).find('.block-zoom').stop().animate({
            top: "0px",
            opacity: 1
        },
        {
            duration: 500,
            easing: 'easeOutExpo'
        });

    },
    function() {

        $(this).find('.block-zoom').stop().delay(500).animate({
            top: "-400px",
            opacity: 0
        },
        {
            duration: 2000,
            easing: 'easeOutExpo',
            complete: function() {}

        });

        return false;
    });

   // Skills setting

            $(".pr1").progression({
                Current: 100,
                // Change Your percent skill
                Easing: 'easeOutExpo',
                aBackgroundImg: 'images/progress.png'
            });

            $(".pr2").progression({
                Current: 75,
                // Change Your percent skill
                Easing: 'easeOutExpo',
                aBackgroundImg: 'images/progress.png'
            });

            $(".pr3").progression({
                Current: 70,
                // Change Your percent skill
                Easing: 'easeOutExpo',
                aBackgroundImg: 'images/progress.png'
            });

            $(".pr4").progression({
                Current: 65,
                // Change Your percent skill
                Easing: 'easeOutExpo',
                aBackgroundImg: 'images/progress.png'
            });

	
//Portfolio section

    var itemTime = $('.portfolio-item').length;

    $('#containment-portfolio li.portfolio-item').click(function() {
																 
        $('#containment-portfolio li').fadeTo("slow",0.5);
		$(this).fadeTo("slow",1);
        $(this).find('.loading-item').fadeIn();
		
		 $('.item_block').slideUp(1000);

        id = $(this).attr('id');

        setTimeout(function() {

            $('div#post-' + id).delay(1000).slideToggle(1000,
            function() {

                $.smoothScroll({
                    speed: 500,
                    offset: 0,
                    easing: 'swing',
                    scrollTarget: '#portfolio'

                });
            });
            $('.loading-item').fadeOut();

        },
        itemTime * 300);

    });


    $('.item_block a.close').click(function() {

        $('.item_block').slideUp(1000);
		$('#containment-portfolio li').fadeTo("slow",1);
		
		$.smoothScroll({
            speed: 1000,
            offset: 0,
            easing: 'swing',
            scrollTarget: '#portfolio'

        });

    });	
	
	// Nivo slider

    $('#sliders').nivoSlider({
        effect: 'random',
        slices: 15,
        animSpeed: 1000,
        //Slide transition speed
        pauseTime: 7000,
        //startSlide:0, //Set starting Slide (0 index)
        directionNav: true,
        //Next & Prev
        directionNavHide: false,
        //Only show on hover
        controlNav: true,
        //1,2,3...
        //controlNavThumbs:false, //Use thumbnails for Control Nav
        // controlNavThumbsFromRel:false, //Use image rel for thumbs
        // controlNavThumbsSearch: '.jpg', //Replace this with...
        //controlNavThumbsReplace: '_thumb.jpg', //...this in thumb Image src
        // keyboardNav:true, //Use left & right arrows
        pauseOnHover: true,
        //Stop animation while hovering
        // manualAdvance:false, //Force manual transitions
         captionOpacity:1, //Universal caption opacity
        beforeChange: function() {},
        // slideshowEnd: function(){}, //Triggers after all slides have been shown
        lastSlide: function() {},
        //Triggers when last slide is shown
        afterLoad: function() {},
        //Triggers when slider has loaded
        afterChange: function() {}

    });

    $('#sliders-port').nivoSlider({
        effect: 'random',
        slices: 15,
        animSpeed: 1000,
        //Slide transition speed
        pauseTime: 4000,
        directionNav: true,
        //Next & Prev
        directionNavHide: false,
        //Only show on hover
        controlNav: true,
        pauseOnHover: true

    });
	
	
//Toggle

    $(".toggle-box").hide();
    $(".open-block").toggle(function() {
        $(this).addClass("active");
    },
    function() {
        $(this).removeClass("active");
    });
    $(".open-block").click(function() {
        $(this).next(".toggle-box").slideToggle();
    });
	
//Accordion

    $('.accordion-box').hide();
    $('.open-block-acc').click(function() {
        $(".open-block-acc").removeClass("active"); 
		$('.accordion-box').slideUp('normal');
        if ($(this).next().is(':hidden') == true) {
            $(this).next().slideDown('normal');
            $(this).addClass("active");
        }
    });

    $('.message-box').find('.closemsg').click(function() {
        $(this).parent('.message-box').slideUp(500);
    });
	


// Validator plugin

    $('#submit').formValidator({
        scope: '#form'
    });

    $('#submit').click(function() {
        $('input.error-input, textarea.error-input').delay(300).animate({
            marginLeft: 0
        },
        100).animate({
            marginLeft: 10
        },
        100).animate({
            marginLeft: 0
        },
        100).animate({
            marginLeft: 10
        },
        100);
    });

// Form plugin

    var options = {

        beforeSubmit: function() {
            $('.sending').show();

        },
        success: function() {
            $('.sending').hide();
            $('#form').hide();
            $(".mess").show().html('<h3>Thanks !</h3><h3>Your message has been sent.</h3>'); // Change Your message post send
            $('.mess').delay(3000).fadeOut(function() {

                $('#form').clearForm();
                $('#form').delay(3500).show();

            });
        }
    };

    $('#form').submit(function() {
        $(this).ajaxSubmit(options);
        return false;
    });
	
	
	
$('.item_block').hide();
  
});

jQuery.fn.progression.defaults.Current = 0;
jQuery.fn.progression.defaults.Background = '';
jQuery.fn.progression.defaults.aBackground = '';
jQuery.fn.progression.defaults.TextColor = '';
jQuery.fn.progression.defaults.aTextColor = '';