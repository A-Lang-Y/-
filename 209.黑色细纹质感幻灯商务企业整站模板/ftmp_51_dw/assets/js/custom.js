$(document).ready(function () {
        /* top panel */
        $(".open_toppanel").click(function(){
                $("div#panel").slideDown("slow");    
        });   

        // Collapse Panel
        $(".close_toppanel").click(function(){
                $("div#panel").slideUp("slow");    
        });  


        /* portfolio */
        $(".overlays").fadeTo(0,0); 
        $(".overlays").hover(function() {
                $(this).fadeTo(150,1);
                $(this).find('.overlay-details-black').fadeTo(150,0.5);
                $(this).find('.overlay-details').fadeTo(150,1);
                $(this).find('.overlay-details a').fadeTo(150,1);
            }, function() {
                $(this).fadeTo(300, 0);
                $(this).find('.overlay-details-black').fadeTo(300,0);
                $(this).find('.overlay-details').fadeTo(300,0);
                $(this).find('.overlay-details a').fadeTo(300,0);
        }); 

        $('.gallery').isotope({filter : '*'});
        $(".filter_options li a").click(function() { 
                $(".filter_options li").children().removeClass('active'); 
                $(this).addClass('active'); 
                sel=($(this).attr('data-rel')); 
                $('.gallery').isotope({filter : sel});
        });

        /* Skitter */
        var options = {};

        if (document.location.search) {
            var array = document.location.search.split('=');
            var param = array[0].replace('?', '');
            var value = array[1];

            if (param == 'animation') {
                options.animation = value;
            }
            else if (param == 'type_navigation') {
                if (value == 'dots_preview') {
                    $('.border_box').css({'marginBottom': '40px'});
                    options['dots'] = true;
                    options['preview'] = true;
                }
                else {
                    options[value] = true;
                    if (value == 'dots') $('.border_box').css({'marginBottom': '40px'});
                }
            }
        }
        $(".home_slider").responsiveSlides({
                maxwidth: 940,
                speed: 800,
                nav: true,
                auto:false,
                pager:false
        });


        $(".portfolio_slider").responsiveSlides({
                maxwidth: 600,
                speed: 800,
                nav: true,
                auto:false,
                pager:true
        });        

        /* tab*/
        $("#tabs").liteTabs({ borders: true, width:220 });

        /* accordion and toggle*/

        $(".accordion div.menu_holder").click(function()
            {
                $(this).next("div.menu_body").slideDown({duration:400,easing:"jswing"}).siblings("div.menu_body").slideUp({duration:400,easing:"jswing"}); 

                if ($(this).find(".icon_plus").length==1)
                    {                                         
                    $(".accordion .active").removeClass('icon_minus active').addClass('icon_plus');    
                    $(this).find(".icon_plus").removeClass('icon_plus').addClass('icon_minus active'); 
                }
                else
                    if ($(this).find(".icon_plus").length==0)
                    {
                    $(this).next("div.menu_body").slideUp({duration:400,easing:"jswing"}); 
                    $(this).find(".active").removeClass('icon_minus active').addClass('icon_plus'); 
                }          
        });

        $(".toggle div.menu_holder").click(function()
            {
                if ($(this).find(".icon_plus").length==1)
                    {
                    $(this).next("div.menu_body").slideDown({duration:400,easing:"jswing"});
                    $(this).find(".icon_plus").removeClass('icon_plus').addClass('icon_minus active'); 
                }
                else
                    if ($(this).find(".icon_plus").length==0)
                    {
                    $(this).next("div.menu_body").slideUp({duration:400,easing:"jswing"});
                    $(this).find(".active").removeClass('icon_minus active').addClass('icon_plus'); 
                }
        });

        /* alertbox */
        $(".alertbox").click(function(){$(this).fadeOut('slow');})


        /* Scrol to top */
        $('#toTop').click(function() {
                $ ('body,html').animate({scrollTop:0},600);
        });

        /* validationEngine */
        $("#contactForm").validationEngine({promptPosition : "topLeft:80"});

        $('.fademe').click(function() {
                $(this).val('');
        });

        /* Color cookie */
        var c = $.cookie('color');
        if (c) themeswitch(c);  
});

function themeswitch(color){
    $.cookie('color',color);
    $('link[rel="stylesheet index"]').attr({href : "assets/css/"+color});                        
};   


