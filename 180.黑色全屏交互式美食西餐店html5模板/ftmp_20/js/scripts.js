include("js/html5.js");
include("js/jquery.animate-colors-min.js");
include("js/jquery.backgroundpos.min.js");
include("js/jquery.easing.js");
include("js/superfish.js");
include("js/switcher.js");
include("js/bgStretch.js");
include("js/sImg.js");
include("js/forms.js");
include("js/jquery.tinyscrollbar.min.js");
include("js/MathUtils.js");

function include(url) {
    document.write('<script type="text/javascript" src="' + url + '"></script>');
}
var MSIE = false;
var content,header, footer;
var time = 700;
var ease = 'easeInOutCirc';

function addAllListeners(){
    $('.close').hover(
        function(){
            if (!MSIE){
                $(this).stop().animate({'backgroundPosition':'center top'},250,'easeOutCubic');
            } else {
                $(this).stop().css({'backgroundPosition':'center top'});
            }
        },
        function(){
            if (!MSIE){
                $(this).stop().animate({'backgroundPosition':'center bottom'},400,'easeOutCubic');
            } else {
                $(this).stop().css({'backgroundPosition':'center bottom'});
            }
        }
    );
    var overColor1 = '#f3ff3a';
    var outColor1 = $('.readMore').css('color');    
    $('.readMore').hover(
        function(){
            if (!MSIE){
                $(this).stop().animate({'color':overColor1},500,'easeOutCubic');
            } else {
                $(this).stop().css({'color':overColor1});
            }
        },
        function(){
            if (!MSIE){
                $(this).stop().animate({'color':outColor1},500,'easeOutCubic');
            } else {
                $(this).stop().css({'color':outColor1});
            }
        }
    );
    var outColor2 = $('.list3 a>span:first').css('color');    
    var outColor3 = $('.list3 a>span:last').css('color');    
    $('.list3 a').hover(
        function(){
            if (!MSIE){
                $(this).find('span:first').stop().animate({'color':overColor1},500,'easeOutCubic');
                $(this).find('span:last').stop().animate({'color':overColor1},500,'easeOutCubic');
            } else {
                $(this).find('span:first').stop().css({'color':overColor1});
                $(this).find('span:last').stop().css({'color':overColor1});
            }
        },
        function(){
            if (!MSIE){
                $(this).find('span:first').stop().animate({'color':outColor2},500,'easeOutCubic');
                $(this).find('span:last').stop().animate({'color':outColor3},500,'easeOutCubic');
            } else {
                $(this).find('span:first').stop().css({'color':outColor2});
                $(this).find('span:last').stop().css({'color':outColor3});
            }
        }
    );
    var defColor1 = $('.thumb').css('backgroundColor');
    $('.thumb').hover(
        function(){
            if (!MSIE){
                $(this).stop().animate({'backgroundColor':'#fff'},700,'easeOutCubic');
            } else {
                $(this).stop().css({'backgroundColor':'#fff'});
            }
        },
        function(){
            if (!MSIE){
                $(this).stop().animate({'backgroundColor':defColor1},700,'easeOutCubic');
            } else {
                $(this).stop().css({'backgroundColor':defColor1});
            }
        }
    );
}

function hideSplash(){
    header.stop().animate({'top':'29px'},time,ease);
    footer.stop().animate({'bottom':'0px'},time,ease);
}

function showSplash(){
    header.stop().animate({'top':'409px'},time,ease);
    footer.stop().animate({'bottom':'100px'},time,ease);
}
$(document).ready(function() {
    /*SUPERFISH MENU*/  
    $('.menu #menu').superfish({
	   delay: 800,
	   animation: {
	       height: 'show'
	   },
       speed: 'slow',
       autoArrows: false,
       dropShadows: false
    });
});




jQuery(document).ready(function(){
	
	//Add Class Js to html
	jQuery('html').addClass('js');	
								
    //=================================== MENU ===================================//
	jQuery("ul.menu").supersubs({ 
	minWidth		: 12,		// requires em unit.
	maxWidth		: 12,		// requires em unit.
	extraWidth		: 3	// extra width can ensure lines don't sometimes turn over due to slight browser differences in how they round-off values
						   // due to slight rounding differences and font-family 
	}).superfish();  // call supersubs first, then superfish, so that subs are 
					 // not display:none when measuring. Call before initialising 
					 // containing tabs for same reason. 
	
	//=================================== MOBILE MENU DROPDOWN ===================================//
	jQuery('#menu').tinyNav({
		active: 'selected'
	});
	
	
	
});





function ON_LOAD(){
	jQuery('.menu ul > li:last-child a').addClass("background-image", "none");	
    MSIE = ($.browser.msie) && ($.browser.version <= 8);
    $('.spinner').fadeOut();

    
   
     _val = 0;
    $("#page_about .overview div:even").each(function(ind,el){
        _val += $(el).outerHeight(true);
        $(this).parent().css({height:_val});
    });
	 _val = 0;
    $("#page_services .overview div:even").each(function(ind,el){
        _val += $(el).outerHeight(true);
        $(this).parent().css({height:_val});
    });
	 $("#page_portfolio .overview div:even").each(function(ind,el){
        _val += $(el).outerHeight(true);
        $(this).parent().css({height:_val});
    });
	   _val = 0;
    $("#page_blog .overview div:even").each(function(ind,el){
        _val += $(el).outerHeight(true);
        $(this).parent().css({height:_val});
    });
        
	$("#page_about .wrapper").tinyscrollbar({axis: 'y', sizethumb:"51", size:"331"});
	$("#page_services .wrapper").tinyscrollbar({axis: 'y', sizethumb:"51", size:"331"});
	$("#page_portfolio .wrapper").tinyscrollbar({axis: 'y', sizethumb:"51", size:"331"});
	$("#page_blog .wrapper").tinyscrollbar({axis: 'y', sizethumb:"51", size:"331"});
    
    //content switch
    header = $('header');
    footer = $('footer');
    content = $('#content');
    content.tabs({
        show:0,
        preFu:function(_){
            _.li.css({'display':'none'});
            _.li.eq(0).css({'visibility':'hidden'});
            hideSplash();		
        },
        actFu:function(_){
            if(_.curr){
                if (_.n == 0){
                    showSplash();
                }
                _.curr
                    .css({'top':'-1000px'}).stop(true).show().animate({'top':'0px'},{duration:time,easing:ease});
            }   
    		if(_.prev){
    		  if ((_.pren == 0) || (_.pren == undefined) && (_.n != 0)){
    		      hideSplash();
    		  }
  		        _.prev
                    .show().stop(true).animate({'top':'10000px'},{duration:time,easing:ease,complete:function(){
                            if (_.prev){
                                _.prev.css({'display':'none'});
                            }
                        }
		              });
            }        
  		}
    });
    var defColor = $('#menu>li>a').eq(0).css('color'); 
    var nav = $('.menu');
    nav.navs({
		useHash:true,
        defHash: '#!/page_home',
        hoverIn:function(li){
        },
        hoverOut:function(li){
            if ((!li.hasClass('with_ul')) || (!li.hasClass('sfHover'))) {
            }
        }
    })
    .navs(function(n){	
   	    $('#content').tabs(n);
   	});
    
    setTimeout(function(){
        $('#bgStretch').bgStretch({
    	   align:'leftTop',
           autoplay: true,
           navs:$('.pagin').navs({autoPlay:8000})
        })
        .sImg({
            sleep: 1000,
            spinner:$('<div class="spinner spinner_bg"></div>').css({opacity:1}).stop().hide(3000)
        });
    },0);
    
    setTimeout(function(){  $('body').css({'overflow':'visible'}); },300);    
    addAllListeners();
    $(window).trigger('resize');
}

$(window).resize(function(){
    if (content) {
        content.stop().animate({'top': ((windowH() - content.height())*.5)},700,'easeOutExpo');
    }
});

function listen(evnt, elem, func) {
    if (elem.addEventListener)  // W3C DOM
        elem.addEventListener(evnt,func,false);
    else if (elem.attachEvent) { // IE DOM
        var r = elem.attachEvent("on"+evnt, func);
    return r;
    }
}
listen("load", window, ON_LOAD);

