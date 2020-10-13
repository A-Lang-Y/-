/*SETTINGS FOR SLIDER*/

var settings = {
    speedFadeOut   : 300,
    speedFadeIn    : 420,
    speedMoveRight : 400,
    speedMoveLeft  : 500,
    timeout        : 4000
}

/*SETTINGS FOR SLIDER WITH TEXT ONLY*/

var settingsSmall = {
    speedMove : 1000,
    timeout   : 4000
}


function validateEmail(email) {
    var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{1,4})?$/;
    if( !emailReg.test( email ) ) {
        return false;
    } else {
        return true;
    }
}
function validateContactNumber(number) {
    var numberReg = /^((\+)?[1-9]{1,3})?([-\s\.])?((\(\d{1,4}\))|\d{1,4})(([-\s\.])?[0-9]{1,12}){1,2}$/;
    if( !numberReg.test( number ) ) {
        return false;
    } else {
        return true;
    }
}

$.fn.preload = function() {
    this.each(function(){
        $('<img/>')[0].src = this;
    });
}

var auto;
var animation = true;



/*MAIN BANNER
******************************************************************************************************************************************/

function transition(type){
            if(animation){
                clearInterval(auto);
                var index =  $('.bottom-controls div').index($(this));
                animation = false;
                transition(index);
var indexHeadings =  $('#banner-headings li').index($("li[id='selected-heading']"));

$('#banner-headings').animate({
    right: '-500'
  }, settings['speedMoveRight'], function() {
      
        var index =  $('#banner-headings li').index($("li[id='selected-heading']"));
        $("#banner-headings li").eq(index).removeAttr('id');
        
        switch(type){
            case "next": index++; break;
            case "previous": index--; break;
            default: index = type; break;
        }
        
        if($('#banner-headings li').eq(index).html() == null){
                index = 0;
        }
        $('#banner-headings li').eq(index).attr('id','selected-heading');
      
        $('#banner-headings').animate({
            easing: "swing",
            right: '50'
        }, settings['speedMoveLeft'], function(){
			animation = true;
			auto=setInterval(function(){
			transition("next");
		    },settings['timeout']);
		});
});   
       var count = $(".banner-slide-images li").length;
       var index =  $('.banner-slide-images li').index($("li[id='selected-banner']"));
       
       
       if( count!=1 ){
       $(".bottom-controls div").eq(index).removeAttr('id');
       $('.banner-slide-images li').eq(index).fadeOut(settings['speedFadeOut'], function() {
        
            $('.banner-slide-images li#selected-banner').removeAttr('id');
        
            switch(type){
                case "next": index++; break;
                case "previous": index--; break;
                default: index = type; break;
            }
            
            if($('.banner-slide-images li').eq(index).html() == null){
                index = 0;
            }
            $('.banner-slide-images li').eq(index).attr('id','selected-banner');
            $(".bottom-controls div").eq(index).attr('id','control-selected');
            $('.banner-slide-images li').eq(index).fadeIn(settings['speedFadeIn'], function(){
            });
            
        });
        } else {
            $(".bottom-controls div").eq(indexHeadings).removeAttr('id');
            switch(type){
                case "next": indexHeadings++; break;
                case "previous": indexHeadings--; break;
                default: indexHeadings = type; break;
            }
            
            if($('#banner-headings li').eq(indexHeadings).html() == null){
                indexHeadings = 0;
            }
            $(".bottom-controls div").eq(indexHeadings).attr('id','control-selected');
        }
   }
}
   
/*MAIN BANNER (small
******************************************************************************************************************************************/
   
   function transitionSmall(type){
       if(animation){
                clearInterval(auto);
                animation = false;
        var index =  $('#banner-headings li').index($("li[id='selected-heading']"));
       if(type!="next"&&type!="previous"){
           //alert("index: "+index+"  type:"+type);
           if((type == 1 && index == 0) || (type==2 && index == 1) || (type==0 && index == 2)){
               type = "next";
           } else {
               type = "previous";
           }
       }
        
        $("#banner-headings li").removeAttr('id');
        $(".bottom-controls-small div").eq(index).removeAttr('id');
        var indexHold = index;
        var direction = "";
        switch(type){
            case "next": direction = '+=1550'; indexHold++; break;
            case "previous": direction = '-=1550'; indexHold--; break;
        }

        if($('#banner-headings li').eq(indexHold).html() == null){
                indexHold = 0;
        }
        $('#banner-headings li').eq(indexHold).attr('id','selected-heading');
        $(".bottom-controls-small div").eq(indexHold).attr('id','control-selected');
            
        
        $('#banner-headings li').animate({
            easing: "swing",
            left: direction
        }, settingsSmall['speedMove'], function(){
            animation = true;
			clearInterval(auto);
			auto=setInterval(function(){
			transitionSmall("next");
		    },settingsSmall['timeout']);
			
            switch(index){
            case 0:
                if(type=='previous'){
                    $("#banner-headings li").eq(1).css("left","1600px");
                    $("#banner-headings li").eq(0).css("left","-1500px");
                } else {
                    $("#banner-headings li").eq(0).css("left","1600px");
                    $("#banner-headings li").eq(2).css("left","-1500px");
                }
                break;
            case 1: 
                if(type=='previous'){
                    $("#banner-headings li").eq(2).css("left","1600px");
                    $("#banner-headings li").eq(1).css("left","-1500px");
                } else {
                    $("#banner-headings li").eq(1).css("left","1600px");
                    $("#banner-headings li").eq(0).css("left","-1500px");
                }
                break;
            case 2: 
                 if(type=='previous'){
                    $("#banner-headings li").eq(0).css("left","1600px");
                    $("#banner-headings li").eq(2).css("left","-1500px");
                } else {
                    $("#banner-headings li").eq(2).css("left","1600px");
                    $("#banner-headings li").eq(1).css("left","-1500px");
                }
                break;
            }
        });
       
	   }
   }


$(document).ready(function(){
    
    $('nav ul li').map(function() {
          if($(this).children("ul").length==1){
              $(this).addClass("dropdown");
          }
    });

    
    $(['img/woman1.png','img/woman2.png','img/woman3.png']).preload();
    
    $("a[rel^='prettyPhoto']").prettyPhoto();

if ($(".banner-slide-video").length > 0){
	
	$('.banner-slide-video').hover(function() {
		clearInterval(auto);
		animation = false;
	}, 
	function(){
		clearInterval(auto);
		animation = true;
		auto=setInterval(function(){
			transition("next");
		    },settings['timeout']);
	});
	
	var iframe = $('#player1')[0],
		player = $f(iframe),
		status = $('.status');
	
	// When the player is ready, add listeners for pause, finish, and playProgress
	player.addEvent('ready', function() {
		status.text('ready');
		
		player.addEvent('pause', onPause);
		player.addEvent('finish', onFinish);
		player.addEvent('playProgress', onPlayProgress);
	});
	
	// Call the API when a button is pressed
	$('button').bind('click', function() {
		player.api($(this).text().toLowerCase());
	});
	
	function onPause(id) {
            clearInterval(auto);
            animation = true;
	}
	
	function onFinish(id) {
            clearInterval(auto);
            animation = true;
	}
	
	function onPlayProgress(data, id) {
            clearInterval(auto);
            animation = false;
	}
}
   /*************************
	***MAIN BANNER controls**
	*************************/
	
  if($("#banner").html()!=null){
       auto=setInterval(function(){
        transition("next");
    },settings['timeout']);
  } else {
       auto=setInterval(function(){
        transitionSmall("next");
    },settingsSmall['timeout']);
  }
 
    $(".bottom-controls div").click(function(){
        if( $(this).attr("id") != "control-selected" ) {
			if(animation){
                var index =  $('.bottom-controls div').index($(this));
                transition(index);
			}
        }
    })
 
    $("#banner .control-left").click(function(){
		if(animation){
            transition("previous");
		}
    });
    $("#banner .control-right").click(function(){
		if(animation){
            transition("next");
		}
    });
	
	
	
   /*************************
	***SMALL BANNER controls**
	*************************/
	
     $("#banner-small .control-right").click(function(){
        if(animation){
            transitionSmall("next");
        }
    });
	
	
    $("#banner-small .control-left").click(function(){
        if(animation){
            transitionSmall("previous");
        }
    });
    $(".bottom-controls-small div").click(function(){
            if( $(this).attr("id") != "control-selected" ) {
                if(animation){
                    var index =  $('.bottom-controls-small div').index($(this));
                    transitionSmall(index);
                }
            }
        })
    

/*SERVICES*/
var servicesAnimation = true;
$('.arrowRight').click(function(){
	var count = "-"+(($(".slider a").length - 3 ) * 299) + "px";
	if($('.slider').css('left')!=count&&servicesAnimation){
    var step = '299';
    servicesAnimation = false;
    $('.slider').stop().animate({left: '-='+step+'px'}, 200, function(){
            servicesAnimation = true;
        });      
	}
});      
$('.arrowLeft').click(function(){
    if($('.slider').css('left')!='0px'&&servicesAnimation) {
    	var step = '299';
        servicesAnimation = false;
        $('.slider').stop().animate({left: '+='+step+'px'}, 200, function(){
            servicesAnimation = true;
        });        
    }
});


  $('li.dropdown').hover(function () { 
        $(this).children("ul").stop().slideDown(200);
  });
  $('li.dropdown').mouseleave(function () {
            $(this).children("ul").stop().slideUp(200);
  });
    
    $(".banner-cube-first").hover(function(){
        $(".banner-cube-first .imageHover").fadeIn(200);
    }, function() {
        $(".banner-cube-first .imageHover").fadeOut(200);
    });
    
    $(".banner-cube-middle").hover(function(){
        $(".banner-cube-middle .imageHover").fadeIn(200);
    }, function() {
        $(".banner-cube-middle .imageHover").fadeOut(200);
    });
    
    $(".banner-cube-last").hover(function(){
        $(".banner-cube-last .imageHover").fadeIn(200);
    }, function() {
        $(".banner-cube-last .imageHover").fadeOut(200);
    });
    
    if($.browser.msie){
        if($.browser.version == "9.0" || $.browser.version == "8.0" || $.browser.version == "7.0"){
            $(".control-left, .control-right").hover(function(){
                $(this).stop().animate({backgroundColor: '#cd3c00'}, 200);
            }, function() {
                $(this).stop().animate({backgroundColor: '#fabb12'}, 200);
            });
            
            
            $("header nav li").not("#selected").hover(function(){
                $(this).stop().animate({backgroundColor: '#cd3c00'}, 100);
            }, function() {
                $(this).stop().animate({backgroundColor: '#fff'}, 100);
            });
            $(".recent-projects-wrapper a ").hover(function(){
                $(this).children(".magnifier").css("background","none");
                $(this).children(".magnifier").css("display","none");
                $(this).stop().animate({backgroundColor: '#666'}, 100, function(){
                    $(this).children(".magnifier").fadeIn(200);
                    
                });
            }, function() {
                $(this).stop().animate({backgroundColor: '#fff'}, 200);
            });
            
            $(".portfolioPage .singleProject .singleProjectImageLink").hover(function(){
                $(this).children(".magnifier").css("background","none");
                $(this).children(".magnifier").css("display","none");
                $(this).stop().animate({backgroundColor: '#666'}, 100, function(){
                    $(this).children(".magnifier").fadeIn(200);
                    
                });
            }, function() {
                $(this).stop().animate({backgroundColor: '#fff'}, 200);
            });
            
        }
        if($.browser.version == "8.0" || $.browser.version == "7.0"){
            $('.banner-slide-images').find("li").eq(0).css("display","block");
            $('#content article:last').css("border","none");
            $('.recent-projects-wrapper a:nth-child(3n+1)').css("margin","36px 0 0 0");
            $('.recent-projects-wrapper a:nth-child(3n)').css("margin","36px 0 0 0");
            $('#banner-small #banner-headings ul li').eq(0).css({display : "block"});
            $('#banner-small #banner-headings ul li').eq(1).css({left : "-1500px", display : "block"});
            $('#banner-small #banner-headings ul li').eq(2).css({left : "1600px", display : "block"});
            $('.portfolio-page .singleProject:nth-child(3n+1)').css("margin","36px 0 0 0");
            $('.portfolio-page .singleProject:nth-child(3n)').css("margin","36px 0 0 0");
            $('.posts').children(".post:first-child").children(".image").css({background : "url(img/blog/firstPost.png)", backgroundColor: "#d64c00", backgroundPosition: "14px", backgroundRepeat: "no-repeat"});
            $('.posts').children(".post:nth-child(2)").children(".image").css({background : "url(img/blog/secondPost.png)", backgroundColor: "#fff", backgroundPosition: "18px", backgroundRepeat: "no-repeat"});
            $('.posts').children(".post:last-child").children(".image").css({background : "url(img/blog/thirdPost.png)", backgroundColor: "#d60000", backgroundPosition: "13px", backgroundRepeat: "no-repeat"});

        }
        if($.browser.version == "9.0"){
            $('#content article:not(:first-child) footer .footer-triangle-right').css("left","161px");
            $('.banner-button-arrow').css("top","15px");
        }
        if($.browser.version == "7.0"){
            $('#content article footer').css("bottom","7px");
            $('#banner-small').css("padding","15px 0 0 0");
            $('#banner-small #banner-headings ul li').css("padding","15px 0 0 0 0");
            $('#banner-small #banner-headings ul li').css("z-index","999");
            $('.form-buttons').css("margin-right","8px");
	    $('hr').parent().css("display","none"); 
            $('header, footer h3, #banner h2,#banner h3,#banner-small h2, #banner-small h3, .error404 h1, .error404 h2, nav ul li a').css("z-index","1");
            $(".columns-header").css("padding","50px 0 10px 0");
            $(".columns-header:first-child").css("padding","0 0 10px 0");
        }
    }
    $(".contentWrapper").prepend("<div class='contentWrapperTop'></div>");
    $(".contentWrapper").append("<div class='contentWrapperBottom'></div>");
    $(".contentWrapper[id='content-more'], .contentWrapper[id='portfolioItemDetails']").append("<div class='contentWrapperBottom'></div><div class='contentWrapperShadow'></div>");
    $(".sidebarTexts").append("<img src='img/quoteOrange.png' />");
    $(".twitter").append("<img src='img/twitter.png' />");
    $(".sidebarTexts").append("<div class=\"arrowRight\"></div>");
    $(".sidebarTexts").append("<div class=\"arrowLeft\"></div>");
    $(".banner-button").append("<div class=\"banner-button-arrow\"></div>");
    
    $("#banner, #banner-small").append('<!--BANNER SHADOWS--><div class="banner-shadow-left"></div><div class="banner-shadow-right"></div>');
    $("#banner #controls, #banner-small #controls").append('<div class="control-left-triangle-top"></div><div class="control-left-triangle-bottom"></div><div class="control-right-triangle-top"></div><div class="control-right-triangle-bottom"></div>');
    $("#banner, #banner-small").prepend('<div class="banner-end"></div>');
    $(".banner-slide-video").append('<div class="header-video-shadow"></div>');
    $("#banner-small").append('<div id="banner-end-overlay"></div>');
    $(".blog footer").prepend('<div class="footer-triangle-left"></div>');
    $(".blog footer").append('<div class="footer-triangle-right"></div>');
    $(".tags").prepend('<div></div>');
    
    $(".portfolioThumbnails div").append("<div class='portfolioThumbnailsHover'></div><div class='triangle' id='thumbnailTriagle'></div>");
    
    
    $(".sidebarTexts .arrowRight").click(function() {
        var index =  $('.sidebarTexts p').index($("p[id='selected']"));
        $('.sidebarTexts #selected').fadeOut(100);
        $('.sidebarTexts #selected').removeAttr('id');
        index++;

        if($('.sidebarTexts p').eq(index).html()==null){
            index = 0;
        }
        $('.sidebarTexts p').eq(index).attr('id','selected');
        $('.sidebarTexts p').eq(index).fadeIn(100);
    })
        
    $(".sidebarTexts .arrowLeft").click(function() {
        var index =  $('.sidebarTexts p').index($("p[id='selected']"));
        $('.sidebarTexts #selected').fadeOut(100);
        $('.sidebarTexts #selected').removeAttr('id');
        index--;
        if($('.sidebarTexts p').eq(index).html()==null){
            index = 0;
        }
        $('.sidebarTexts p').eq(index).attr('id','selected');
        $('.sidebarTexts p').eq(index).fadeIn(100);
    });
    
    
    $("#selected-submenu").append("<div class='content-menu-over'>"+$("#selected-submenu").html()+"</div>");
    $("#selected-submenu").append("<div class='content-menu-shadow-right'></div>");
    
    
    /**************************************************************
    ***************CONTENT WITH MENU - TRANSITIONS******************
    ***************************************************************/
   
    /*Hides all except the first content in a content with menu*/
    $("#menu-content-2").css("display", "none");
    $("#menu-content-3").css("display", "none");
    $("#menu-content-4").css("display", "none");

    
    $('.content-menu li').click(function(){
        
        if(this.id != 'selected-submenu' && this.id != 'selected-submenu-2') {

        $('.content-menu li').removeAttr('id');
        $('.content-menu-over').remove();
        $('.content-menu-shadow-right').remove();
        $('.content-menu-shadow-left').remove();
        
        $('.content-menu li:first-child').css("border-style","solid");
        
        $("#menu-content-1").hide();
        $("#menu-content-2").hide();
        $("#menu-content-3").hide();
        $("#menu-content-4").hide();
        
        var clickedIndex = $('.content-menu li').index(this);
        clickedIndex++;
        
        $("#menu-content-"+clickedIndex).fadeIn();
            
        if($(this).is(':last-child'))
        {
             $('.content-menu li:first-child').css("border-style","solid none solid solid");
            this.id='selected-submenu-2';
            $("#selected-submenu-2").append("<div class='content-menu-over'>"+$("#selected-submenu-2").html()+"</div>");
            $("#selected-submenu-2").append("<div class='content-menu-shadow-left'></div>");
            
        }else if($(this).is(':first-child')){
            this.id='selected-submenu';
            $("#selected-submenu").append("<div class='content-menu-over'>"+$("#selected-submenu").html()+"</div>");
            $("#selected-submenu").append("<div class='content-menu-shadow-right'></div>");
        }else{
            this.id='selected-submenu';
            $("#selected-submenu").append("<div class='content-menu-over'>"+$("#selected-submenu").html()+"</div>");
            $("#selected-submenu").append("<div class='content-menu-shadow-left'></div>");
            $("#selected-submenu").append("<div class='content-menu-shadow-right'></div>");
        }
        }
    });
    
    
   /*Contact */
   
   var fieldNotSet = "enter your ";
   var fieldNotValid = "enter a valid ";
   
   
   $('input[type="text"]').map(function() {
        this.value= this.title;
        if(this.id == "required"){
            $(this).parent().append("<div id='errorMessage' class='errorMessageInput'>" + fieldNotSet + " "+this.value+"</div>");
            this.value += "*";
        }
        if(this.name == "contact-number"){
            $(this).parent().append("<div id='errorMessage' class='errorMessageInput'>" + fieldNotSet + " "+this.value+"</div>");
        }
    });
    $('textarea').map(function() {
        this.value= this.title;
        if(this.id == "required"){
            $(this).parent().append("<div id='errorMessage' class='errorMessageTextarea'>" + fieldNotSet + " "+this.value+"</div>");
            this.value += "*";
        }
    });
    $('input[type="text"], textarea').click(function(){
        if((this.value == this.title) || (this.value == this.title+"*" && this.id == "required")){
            this.value = "";
        } 
    })
    $("input, textarea").blur(function(){
        if(this.value == ""){
            this.value = this.title;
            if(this.id=="required"){
                $(this).addClass("errorInput");
                $(this).parent().children("#errorMessage").html(fieldNotSet + this.value);
                $(this).parent().children("#errorMessage").css("display","block"); 
                this.value += "*";
            }else {
               $(this).removeClass("errorInput"); 
               $(this).parent().children("#errorMessage").css("display","none"); 
            }
        } else {
                if(this.name=='e-mail') {
                    if(this.value == this.title || this.value == this.title+"*"){
                        $(this).parent().children("#errorMessage").html("" + fieldNotSet + this.title);
                        $(this).parent().children("#errorMessage").css("display","block");
                    }
                    if(validateEmail(this.value)){
                        $(this).removeClass("errorInput");
                        $(this).parent().children("#errorMessage").css("display","none");
                    }
                    else{
                        $(this).addClass("errorInput");
                        $(this).parent().children("#errorMessage").html(fieldNotValid + this.title);
                        $(this).parent().children("#errorMessage").css("display","block");
                    }
                }
                 else if(this.name=='contact-number') {
                    if(this.value == this.title || this.value == this.title+"*"){
                        $(this).parent().children("#errorMessage").css("display","none"); 
                    }
                    else if(validateContactNumber(this.value)){
                        $(this).removeClass("errorInput");
                    }
                    else {
                        $(this).addClass("errorInput");
                    }
                } 
                else {
                    $(this).removeClass("errorInput");
                    $(this).parent().children("#errorMessage").css("display","none"); 
                }
        }
    })
    $('input, textarea').bind('keydown', function() { 
        if(this.name=='e-mail') {
            if(validateEmail(this.value)){
                $(this).removeClass("errorInput");
                $(this).parent().children("#errorMessage").css("display","none");
                if( $(this).css("padding-right") == "125px" ){
                    $(this).css("padding-right","10px");
                    $(this).width($(this).width() + 115);
                }
            }
            else{
                $(this).parent().children("#errorMessage").html(fieldNotValid + this.title);
                $(this).parent().children("#errorMessage").css("display","block");
                if( $(this).css("padding-right") != "125px" ){
                $(this).css("padding-right","125px");
                $(this).width($(this).width() - 114);
                }
                $(this).addClass("errorInput");
            }
        }
        else if(this.name=='contact-number') {
                if(validateContactNumber(this.value)){
                $(this).removeClass("errorInput");
                $(this).parent().children("#errorMessage").css("display","none");
            }
            else{
                $(this).addClass("errorInput");
                $(this).parent().children("#errorMessage").html(fieldNotValid + this.title);
                $(this).parent().children("#errorMessage").css("display","block");
            }
        } 
        else {
            $(this).removeClass("errorInput");
            $(this).parent().children("#errorMessage").css("display","none"); 
        }
    });

    $('input[type="button"]').click(function(){
        if(this.name=='reset') {
            $('input[type="text"], textarea').map(function() {
                this.value = this.title;
                $(this).removeClass("errorInput");
                $(this).parent().children("#errorMessage").css("display","none");
                if(this.id=="required"){
                    this.value += "*";
                }
            });
        }
        if(this.name=='send') {
            
            var noErrors = true;
            
            $('input[type="text"], textarea').map(function() {
                if(this.value == this.title+"*"  && this.id == "required"){
                    $(this).addClass("errorInput");
                    $(this).parent().children("#errorMessage").css("display","block")
                    noErrors = false;
                }
                if($(this).parent().children("#errorMessage").css("display") == "block"){
                    noErrors = false;
                }

            });
            
            if(noErrors){
                $.ajax({
                type: "POST",
                url: "php/contact-us.php",
                data: $("#contact-form").serialize(),
                success: function(msg) {
                    $(".success").fadeIn(100);
                }
                });
            }
        }
        if(this.name=='follow') {
            
            var noErrors = true;
            
            if(noErrors){
                $.ajax({
                type: "POST",
                url: "php/follow-us.php",
                data: $("#followForm").serialize(),
                success: function(msg) {
                }
                });
            }
        }
    });
    
    
    
    $('.thumbnail').click(function(){
        $('.thumbnail').removeAttr('id');
        $('.portfolioFullImage').fadeOut(100,function(){
            $('.portfolioFullImage').css("background","url("+$(".portfolioFullImage img").eq(clickedIndex).attr("src")+")");
            $('.portfolioFullImage').fadeIn(100);
        });
        this.id = 'selected';   
        var clickedIndex = $('.thumbnail').index(this);
    });
    
    
    $('#content article.blog header .tagsIcon').hover(function() {
        var index = $('#content article.blog header .tagsIcon').index(this);
        $('#content article.blog header .tags').eq(index).fadeIn(100);
    });
    $('#content article.blog header .tagsIcon').mouseout(function() {
        var index = $('#content article.blog header .tagsIcon').index(this);
        $('#content article.blog header .tags').eq(index).fadeOut(100);
    });
    
	
	
	var portfolioAnimation = true;
	
	$("#portfolioWrapper .arrowRight").click(function(){
		var count = "-"+(($(".portfolio-slider .portfolio-page").length - 1) * 980 ) + "px";
		if($(".portfolio-slider").css("margin-left")!=count && portfolioAnimation)
		{
			portfolioAnimation = false;
			$(".portfolio-slider").animate({
    		marginLeft: "-=980px"
  			}, 400, function() {
				portfolioAnimation = true;
			});
		}
	});
	
	
	$("#portfolioWrapper .arrowLeft").click(function(){
		if($(".portfolio-slider").css("margin-left")!="0px" && portfolioAnimation)
		{
			portfolioAnimation = false;
			$(".portfolio-slider").animate({
    		marginLeft: "+=980px"
  			}, 400, function() {
				portfolioAnimation = true;
			});
		}
	});
	
});