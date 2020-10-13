// jquery.tweet.js - See http://tweet.seaofclouds.com/ or https://github.com/seaofclouds/tweet for more info
// Copyright (c) 2008-2011 Todd Matthews & Steve Purcell
(function($){$.fn.tweet=function(o){var s=$.extend({username:null,list:null,favorites:false,query:null,avatar_size:null,count:3,fetch:null,retweets:true,intro_text:null,outro_text:null,join_text:null,auto_join_text_default:"i said,",auto_join_text_ed:"i",auto_join_text_ing:"i am",auto_join_text_reply:"i replied to",auto_join_text_url:"i was looking at",loading_text:null,refresh_interval:null,twitter_url:"twitter.com",twitter_api_url:"api.twitter.com",twitter_search_url:"search.twitter.com",template:"{avatar}{join}{text}{time}",comparator:function(tweet1,tweet2){return tweet2["tweet_time"]-tweet1["tweet_time"]},filter:function(tweet){return true}},o);$.fn.extend({linkUrl:function(){var returning=[];var regexp=/\b((?:[a-z][\w-]+:(?:\/{1,3}|[a-z0-9%])|www\d{0,3}[.]|[a-z0-9.\-]+[.][a-z]{2,4}\/)(?:[^\s()<>]+|\(([^\s()<>]+|(\([^\s()<>]+\)))*\))+(?:\(([^\s()<>]+|(\([^\s()<>]+\)))*\)|[^\s`!()\[\]{};:'".,<>?ï¿½ï¿½ï¿½ï¿½ï¿½ï¿½]))/gi;this.each(function(){returning.push(this.replace(regexp,function(match){var url=(/^[a-z]+:/i).test(match)?match:"http://"+match;return"<a href=\""+url+"\">"+match+"</a>"}))});return $(returning)},linkUser:function(){var returning=[];var regexp=/[\@]+(\w+)/gi;this.each(function(){returning.push(this.replace(regexp,"@<a href=\"http://"+s.twitter_url+"/$1\">$1</a>"))});return $(returning)},linkHash:function(){var returning=[];var regexp=/(?:^| )[\#]+([\w\u00c0-\u00d6\u00d8-\u00f6\u00f8-\u00ff\u0600-\u06ff]+)/gi;var usercond=(s.username&&s.username.length==1)?'&from='+s.username.join("%2BOR%2B"):'';this.each(function(){returning.push(this.replace(regexp,' <a href="http://'+s.twitter_search_url+'/search?q=&tag=$1&lang=all'+usercond+'">#$1</a>'))});return $(returning)},capAwesome:function(){var returning=[];this.each(function(){returning.push(this.replace(/\b(awesome)\b/gi,'<span class="awesome">$1</span>'))});return $(returning)},capEpic:function(){var returning=[];this.each(function(){returning.push(this.replace(/\b(epic)\b/gi,'<span class="epic">$1</span>'))});return $(returning)},makeHeart:function(){var returning=[];this.each(function(){returning.push(this.replace(/(&lt;)+[3]/gi,"<tt class='heart'>&#x2665;</tt>"))});return $(returning)}});function parse_date(date_str){return Date.parse(date_str.replace(/^([a-z]{3})( [a-z]{3} \d\d?)(.*)( \d{4})$/i,'$1,$2$4$3'))}function relative_time(date){var relative_to=(arguments.length>1)?arguments[1]:new Date();var delta=parseInt((relative_to.getTime()-date)/1000,10);var r='';if(delta<60){r=delta+' seconds ago'}else if(delta<120){r='a minute ago'}else if(delta<(45*60)){r=(parseInt(delta/60,10)).toString()+' minutes ago'}else if(delta<(2*60*60)){r='an hour ago'}else if(delta<(24*60*60)){r=''+(parseInt(delta/3600,10)).toString()+' hours ago'}else if(delta<(48*60*60)){r='a day ago'}else{r=(parseInt(delta/86400,10)).toString()+' days ago'}return'about '+r}function build_url(){var proto=('https:'==document.location.protocol?'https:':'http:');var count=(s.fetch===null)?s.count:s.fetch;if(s.list){return proto+"//"+s.twitter_api_url+"/1/"+s.username[0]+"/lists/"+s.list+"/statuses.json?per_page="+count+"&callback=?"}else if(s.favorites){return proto+"//"+s.twitter_api_url+"/favorites/"+s.username[0]+".json?count="+s.count+"&callback=?"}else if(s.query===null&&s.username.length==1){return proto+'//'+s.twitter_api_url+'/1/statuses/user_timeline.json?screen_name='+s.username[0]+'&count='+count+(s.retweets?'&include_rts=1':'')+'&callback=?'}else{var query=(s.query||'from:'+s.username.join(' OR from:'));return proto+'//'+s.twitter_search_url+'/search.json?&q='+encodeURIComponent(query)+'&rpp='+count+'&callback=?'}}return this.each(function(i,widget){var list=$('<ul class="tweet_list">').appendTo(widget);var intro='<p class="tweet_intro">'+s.intro_text+'</p>';var outro='<p class="tweet_outro">'+s.outro_text+'</p>';var loading=$('<p class="loading">'+s.loading_text+'</p>');if(s.username&&typeof(s.username)=="string"){s.username=[s.username]}var expand_template=function(info){if(typeof s.template==="string"){var result=s.template;for(var key in info){var val=info[key];result=result.replace(new RegExp('{'+key+'}','g'),val===null?'':val)}return result}else return s.template(info)};if(s.loading_text)$(widget).append(loading);$(widget).bind("load",function(){$.getJSON(build_url(),function(data){if(s.loading_text)loading.remove();if(s.intro_text)list.before(intro);list.empty();var tweets=$.map(data.results||data,function(item){var join_text=s.join_text;if(s.join_text=="auto"){if(item.text.match(/^(@([A-Za-z0-9-_]+)) .*/i)){join_text=s.auto_join_text_reply}else if(item.text.match(/(^\w+:\/\/[A-Za-z0-9-_]+\.[A-Za-z0-9-_:%&\?\/.=]+) .*/i)){join_text=s.auto_join_text_url}else if(item.text.match(/^((\w+ed)|just) .*/im)){join_text=s.auto_join_text_ed}else if(item.text.match(/^(\w*ing) .*/i)){join_text=s.auto_join_text_ing}else{join_text=s.auto_join_text_default}}var screen_name=item.from_user||item.user.screen_name;var source=item.source;var user_url="http://"+s.twitter_url+"/"+screen_name;var avatar_size=s.avatar_size;var avatar_url=item.profile_image_url||item.user.profile_image_url;var tweet_url="http://"+s.twitter_url+"/"+screen_name+"/status/"+item.id_str;var retweet=(typeof(item.retweeted_status)!='undefined');var retweeted_screen_name=retweet?item.retweeted_status.user.screen_name:null;var tweet_time=parse_date(item.created_at);var tweet_relative_time=relative_time(tweet_time);var tweet_raw_text=retweet?('RT @'+retweeted_screen_name+' '+item.retweeted_status.text):item.text;var tweet_text=$([tweet_raw_text]).linkUrl().linkUser().linkHash()[0];var user='<a class="tweet_user" href="'+user_url+'">'+screen_name+'</a>';var join=((s.join_text)?('<span class="tweet_join"> '+join_text+' </span>'):' ');var avatar=(avatar_size?('<a class="tweet_avatar" href="'+user_url+'"><img src="'+avatar_url+'" height="'+avatar_size+'" width="'+avatar_size+'" alt="'+screen_name+'\'s avatar" title="'+screen_name+'\'s avatar" border="0"/></a>'):'');var time='<span class="tweet_time"><a href="'+tweet_url+'" title="view tweet on twitter">'+tweet_relative_time+'</a></span>';var text='<span class="tweet_text">'+$([tweet_text]).makeHeart().capAwesome().capEpic()[0]+'</span>';return{item:item,screen_name:screen_name,user_url:user_url,avatar_size:avatar_size,avatar_url:avatar_url,source:source,tweet_url:tweet_url,tweet_time:tweet_time,tweet_relative_time:tweet_relative_time,tweet_raw_text:tweet_raw_text,tweet_text:tweet_text,retweet:retweet,retweeted_screen_name:retweeted_screen_name,user:user,join:join,avatar:avatar,time:time,text:text}});tweets=$.grep(tweets,s.filter).slice(0,s.count);list.append($.map(tweets.sort(s.comparator),function(t){return"<li>"+expand_template(t)+"</li>"}).join('')).children('li:first').addClass('tweet_first').end().children('li:odd').addClass('tweet_even').end().children('li:even').addClass('tweet_odd');if(s.outro_text)list.after(outro);$(widget).trigger("loaded").trigger((tweets.length===0?"empty":"full"));if(s.refresh_interval){window.setTimeout(function(){$(widget).trigger("load")},1000*s.refresh_interval)}})}).trigger("load")})}})(jQuery);

/*
* Copyright (C) 2009 Joel Sutherland
* Licenced under the MIT license
* http://www.newmediacampaigns.com/page/jquery-flickr-plugin
*
* Available tags for templates:
* title, link, date_taken, description, published, author, author_id, tags, image*
*/
(function($){$.fn.jflickrfeed=function(settings,callback){settings=$.extend(true,{flickrbase:'http://api.flickr.com/services/feeds/',feedapi:'photos_public.gne',limit:20,qstrings:{lang:'en-us',format:'json',jsoncallback:'?'},cleanDescription:true,useTemplate:true,itemTemplate:'',itemCallback:function(){}},settings);var url=settings.flickrbase+settings.feedapi+'?';var first=true;for(var key in settings.qstrings){if(!first)
url+='&';url+=key+'='+settings.qstrings[key];first=false;}
return $(this).each(function(){var $container=$(this);var container=this;$.getJSON(url,function(data){$.each(data.items,function(i,item){if(i<settings.limit){if(settings.cleanDescription){var regex=/<p>(.*?)<\/p>/g;var input=item.description;if(regex.test(input)){item.description=input.match(regex)[2]
if(item.description!=undefined)
item.description=item.description.replace('<p>','').replace('</p>','');}}
item['image_s']=item.media.m.replace('_m','_s');item['image_t']=item.media.m.replace('_m','_t');item['image_m']=item.media.m.replace('_m','_m');item['image']=item.media.m.replace('_m','');item['image_b']=item.media.m.replace('_m','_b');delete item.media;if(settings.useTemplate){var template=settings.itemTemplate;for(var key in item){var rgx=new RegExp('{{'+key+'}}','g');template=template.replace(rgx,item[key]);}
$container.append(template)}
settings.itemCallback.call(container,item);}});if($.isFunction(callback)){callback.call(container,data);}});});}})(jQuery);

/* User agent detect --> Begin */

var original_bg_image_width, original_bg_image_height;


/* Footer image color change --> Begin */

    var original_footer_image_bg_color;
    var original_footer_image_border_color;
    var setFooterImageColors = function($footer_image_wrapper) {
        $footer_image_wrapper.css({
            backgroundColor : '',
            borderColor : ''
        });
        original_footer_image_bg_color = $footer_image_wrapper.css('backgroundColor');
        original_footer_image_border_color = $footer_image_wrapper.css('border-left-color');
    }

/* Footer image color change --> End */

jQuery(document).ready(function($) {
	
/* ######################### DOM READY - Begin ######################### */

	if($('#nav').length) {
		
		$('#nav').lavaLamp({
			target: 'li > a',
			container: 'li',
			fx: 'easeOutCubic',
			speed: 400
		});	
		
	}

/* Social Icons --> Begin */ 
	
    $('.kids_social li').not('li:first, li:last', this).append('<span></span>').hover(function() {
        $(this).find('span').stop(true,false).animate({
            height: "100%",
            opacity: "1"
        }, 'normal');
    }, function() {
        $(this).find('span').stop(true,false).animate({
            height: "0",
            opacity: "0"
        }, 'normal');
    });
	
/* Social Icons --> End */ 
	
/* Top Panel --> Begin */ 
	
	var $panel = $(".top-panel .l-page-width");
			
	$('.openbtn').on('click','a',function(e) {
		
		var $target = $(e.target);
		
		if($target.hasClass('hide')) {
			$panel.stop(true,false).animate({
				opacity: '0'
			},200);
			$target.blur();
		}
			
		$panel.slideToggle(600, function(){
			
			$target.toggleClass('hide');
			
			if($(this).css('display') == 'block') {
				$(this).stop(true,false).animate({
					opacity:'1'
				},200);
			} else {
				$(this).stop(true,false).animate({
					opacity:'0'
				},200);
			}
		});
				
		e.preventDefault();
	});
	
/* Top Panel --> End */ 	
	
/* Search Form --> Begin */ 
	
	var $sform = $('#search-form');
	
	$('li.search').on('click', 'a', function(e) {
		
		var $target = $(e.target);
		
		if($target.hasClass('hide')) {
		
				$sform.stop(true,false).animate({
//				width : 0,
				opacity : 0
			}, 'normal');
			$target.removeClass('hide');	
			
		} else {
		
			$sform.stop(true,false).animate({
//				width : '130px',
				opacity : 1
			}, 'normal').show();	
			
			$target.addClass('hide');
			$sform.find('input[type="text"]').focus();
		}
		
		e.preventDefault();
	});
	
/* Search Form --> End */ 	
	  
/* Twitter --> Begin */  	

  $(".top-panel .tweets").tweet({
	join_text: "auto",
	username: "jernejstrasner",
	avatar_size: 0,
	count: 1,
	auto_join_text_default: "", 
	auto_join_text_ed: "",
	auto_join_text_ing: "",
	auto_join_text_reply: "",
	auto_join_text_url: "",
	loading_text: "loading tweets..."
  });

  $(".kids_bottom_container .tweet").tweet({
	join_text: "auto",
	username: "jernejstrasner",
	avatar_size: 0,
	count: 2,
	auto_join_text_default: "", 
	auto_join_text_ed: "",
	auto_join_text_ing: "",
	auto_join_text_reply: "",
	auto_join_text_url: "",
	loading_text: "loading tweets..."
  });

  $("#sidebar .tweet").tweet({
	join_text: "auto",
	username: "jernejstrasner",
	avatar_size: 0,
	count: 3,
	auto_join_text_default: "", 
	auto_join_text_ed: "",
	auto_join_text_ing: "",
	auto_join_text_reply: "",
	auto_join_text_url: "",
	loading_text: "loading tweets..."
  });
	  
/* Twitter --> End */  	  

/* Pattern bg --> Begin */

$leftPatternBgTop = $('#bg-level-1-left');
$rightPatternBgTop = $('#bg-level-1-right');

$lpage = $('.l-page-width-after');

$leftPatternBg = $('#bg-level-2-left');
$rightPatternBg = $('#bg-level-2-right');

function setLpage(size) {
	$patternWidth = ($('body').width() - size) / 2;
	$lpage.css({
		width : $patternWidth,
		right : 0 - $patternWidth + 10
	})
}

function setPatternsSize(size) {
    $patternWidth = ($('body').width() - size) / 2;
    $leftPatternBg.css({
        width : $patternWidth,
        left : 0 - $patternWidth + 10
    });
    $rightPatternBg.css({
        width : $patternWidth,
        right : 0 - $patternWidth + 10
    });
}

function setPatternsSizeTop(size) {
    $patternWidth = ($('body').width() - size) / 2;
    $leftPatternBgTop.css({
        width : $patternWidth,
        left : 0 - $patternWidth + 10
    });
    $rightPatternBgTop.css({
        width : $patternWidth,
        right : 0 - $patternWidth + 10
    });
}

var bodySize;
if ($('body').hasClass('kids-front-page')) {
    bodySize = 940;
} else {
    bodySize = 950;
}
setLpage(bodySize);
setPatternsSize(bodySize);
setPatternsSizeTop(940);

$(window).resize(function() {setLpage(bodySize)});
$(window).resize(function() {setPatternsSize(bodySize)});
$(window).resize(function() {setPatternsSizeTop(940)});

/* Pattern bg --> End */

/* Slider control fade --> Begin */

    function fadeInControl($controlGroup) {
        $controlGroup.stop(true,true).animate({opacity : 1}, 400);
    }
    function fadeOutControl($controlGroup) {
        $controlGroup.stop(true,true).animate({opacity : 0.3}, 400);
    }

/* Slider control fade --> End */

/* NivoSlider --> Begin */
    
    if ($('#kids-slider.nivoSlider').length) {
        $('#kids-slider.nivoSlider').nivoSlider({
            controlNav: true,
            pauseTime:10000,
            directionNav: true,
            directionNavHide: false,
            prevText: '',
            nextText: ''
        });
        var $nivoControlGroup = $('.nivo-prevNav, .nivo-nextNav, .nivo-controlNavWrapperLeftBg');
        $nivoControlGroup.hover(function() {fadeInControl($nivoControlGroup)}, function() {fadeOutControl($nivoControlGroup)});
    }

/* NivoSlider --> End */

/* AnythingSlider --> Begin */

if ($('#kids-slider.anythingSlider').length) {
    $('#kids-slider.anythingSlider').anythingSlider({
        resizeContents      : false,
        autoPlay            : false,
        buildArrows         : true,      
        buildNavigation     : false
    });
    var $anythingControlGroup = $('.anythingSlider .arrow a');
    $anythingControlGroup.hover(function() {fadeInControl($anythingControlGroup)}, function() {fadeOutControl($anythingControlGroup)});
}

/* AnythingSlider --> End */


/* Lofslidernews --> Begin */

if ($('#kids-slider.lofSliderNews').length) {

    var buttons = {
        previous : $('#kids-slider.lofSliderNews .lof-previous'),
        next : $('#kids-slider.lofSliderNews .lof-next')
    };

    $('#kids-slider.lofSliderNews').lofJSidernews({
        interval        : 4000,
        direction		: 'opacitys',
        easing			: 'easeInOutExpo',
        duration		: 1200,
        auto		 	: false,
        maxItemDisplay  : 4,
        navPosition     : 'horizontal',
        navigatorHeight : 32,
        navigatorWidth  : 80,
        mainWidth       : 916,
        buttons			: buttons
    });
    
    var $lofControlGroup = $('#kids-slider.lofSliderNews .lof-previous, #kids-slider.lofSliderNews .lof-next');
    $lofControlGroup.hover(function() {fadeInControl($lofControlGroup)}, function() {fadeOutControl($lofControlGroup)});

}

/* Lofslidernews --> End */

/* jCarousel --> Begin */

	(function() {

		var $carousel = $('.projects_carousel');
		if($carousel.length) {
			
			$carousel.jcarousel({
				animation : 600,
				easing    : 'easeOutCubic',
				scroll    : 2
			});
		}
		
	})();


  if($('.minigallery-list .minigallery').length) {
	$(".minigallery-list .minigallery").jCarouselLite({
		btnNext: ".next",
		btnPrev: ".prev",
		scroll: 3,
		visible: 9,
		speed: 400,
		mouseWheel: true,
		circular:false,
		easing: "easeInOutCubic"
	});	  
  }

  if($('.minigallery-list2 .minigallery').length) {	
	$(".minigallery-list2 .minigallery").jCarouselLite({
		btnNext: ".next2",
		btnPrev: ".prev2",
		scroll: 3,
		visible: 9,
		speed: 400,
		mouseWheel: true,
		circular:false,
		easing: "easeInOutCubic"
	});
  }
  
/* jCarousel --> End */		

/* VideoJS --> Begin */
    
    VideoJS.setupAllWhenReady();
	
/* VideoJS --> End */

/* Search form --> Begin */

    var $search_form = $('#kids_search_form');
    var $search_wrapper = $search_form.find('.kids_search_wrapper');
    var $search_input = $search_form.find('input');

    $search_form.hover(function() {
        $search_wrapper.stop(true,true).fadeIn(600);
		$search_wrapper.find('input[type=text]').focus();
    },function() {
        if ($search_input.is(":focus")) {
            $search_wrapper.stop(true,true).fadeOut(400);
        } else {
            $search_input.blur(function() {
                $search_wrapper.stop(true,true).fadeOut(400);
                $search_input.unbind('blur');
            });
        }
    });
    
/* Search form --> End */


/* Main navigation --> Begin */
    
    (function() {
        $.fn.menuSlide = function(options) {
            
            options = $.extend({fx: "linear", speed: 200}, options);
            
            var $main_menu = $(this);
            var $main_menu_items = $main_menu.find('> li');
            var $submenus = $main_menu_items.find('> ul');
            var $menu_items = $main_menu.find('li');
                
                $menu_items.hover(function() {
                    $(this).find('> ul').css({
                    }).slideDown(options.speed,options.fx);
                },function() {
                    if ($(this).find('> ul').is(':animated')) {
                        $(this).find('> ul').stop(true, true).removeAttr('style');
                    }
                    $(this).find('> ul').hide();
                });
                
                $submenus.find('> li').hover(function() {
                    $(this).find('> ul').css({
                        left : $(this).parent().width() - 3
                    });
                },function() {});
                
        };
    })();
    
    var $main_nav = $('#kids_main_nav > ul');
	
	 $('#kids_main_nav > ul > li ul').hover( function(){
			var $el = $(this).closest('#kids_main_nav').find('.backLava');
			var $ell =	$el.css('left');
				$el.css({
					left : $ell
				});
				},function(){
					$('li.backLava').show(100) 
				}
			);

    $main_nav.menuSlide({fx:"easeOutCirc", speed: 400});

	var $ls = $("#kids_main_nav li a:contains('Left Sidebar')");
	var $rs = $("#kids_main_nav li a:contains('Right Sidebar')");
	 $ls.click(function() {
		 $('#sbr').attr('id', 'sbl');
		 return false;
	 });
	 $rs.click(function() {
		 $('#sbl').attr('id', 'sbr');
		 return false;
	 });

    
/* Main navigation --> End */

/* Pretty photo popup --> Begin */

    $("a.prettyPhoto").prettyPhoto();
	
	if($('.prettyPhoto').length) {
		
		(function() {
			$('a.prettyPhoto').prettyPhoto().each(function() {
				$(this).append('<span class="kids_curtain">&nbsp;</span>');
			});		
		})();	
		
	}
	

	$('p + blockquote').prev().css('margin-bottom','0');

/* Pretty photo popup --> End */

/* To top --> Begin */
	
	(function() {

		var extend = {
				button      : '#kids-back-top',
				text        : 'Back to Top',
				min         : 200,
				fadeIn      : 400,
				fadeOut     : 400,
				speed		: 800,
				easing		: 'easeOutQuint'
			}

		$('body').append('<div id="' + extend.button.substring(1) + '"><a href="#top" title="' + extend.text + '"><span>' + extend.text + '</span></a></div>');

		$(window).scroll(function() {
			var pos = $(window).scrollTop();

			if (pos > extend.min) {
				$(extend.button).fadeIn(extend.fadeIn);
			}
			else {
				$(extend.button).fadeOut (extend.fadeOut);
			}

		});

		$(extend.button).add(extend.backToTop).click(function(e){
			$('html, body').animate({scrollTop : 0}, extend.speed, extend.easing);
			e.preventDefault();
		});

	})();

/* end Back to Top */
	
	
/* To top --> End */


/* Bottom container images --> Begin */

    setFooterImageColors($('#kids_bottom_container .kids_image_wrapper'));

    if ($('#kids_bottom_container .kids_image_wrapper').length) {
        $('#kids_bottom_container .kids_image_wrapper').hover(function() {
            $(this).stop(true,true).animate({backgroundColor : "#ddf0f7", borderColor : "#ddf0f7"}, 600);
        },function() {
            $(this).stop(true,true).animate({backgroundColor : original_footer_image_bg_color, borderColor : original_footer_image_border_color}, 400);
        });
    }

/* Bottom container images --> End */


/* Pricing Tables --> Begin */

	(function() {

		if($('.pricing-table').length) {

			var pt = $('.pricing-table .column', this);
				pt.find('li:even:not(.footer_row):not(.header_row)').addClass('even');
				pt.first().addClass('first');
				pt.last().addClass('last');
				pt.find('li:not(.header_row):first').css('padding-top','2.2em');
				pt.find('li:not(.footer_row):last').css('padding-bottom','2.2em');
			var ptFirst = $('.pricing-table .column:first-child');
			var ptLast = $('.pricing-table .column:last-child');	
				ptFirst.find('li:not(.footer_row):not(.header_row)').css('border-left', '2px solid #98c2e1');
				ptLast.find('li:not(.footer_row):not(.header_row)').css('border-right', '2px solid #98c2e1');
				$('.pricing-table .column:last-child').find('.footer_row').addClass('footer_border');	

		}	

	})();


/* Pricing Tables --> End */

/* Google Map --> Begin */
	 
	(function() {
		
		if($('#map_canvas').length) {
			$('#map_canvas').gMap({ 
				address: 'New York, USA',
				zoom: 13,
				markers: [
				{
					'address' : 'Madison ST, New York'
				}
				]
			});  
		}
		
	})();
	 
/* Google Map --> End */
	  
/* Accordion --> Begin */

   if($('ul.accordion').length) {
		$('ul.accordion').accordion({autoHeight:false,header:".opener",collapsible:true,event:"click"});
   }
   
   if($('.widget_categories ul').length) {
		$('.widget_categories ul').accordion({autoHeight:false,header:".opener",collapsible:true,event:"click"});
   }
   
   if($('ul.highlighter').length) {
		$('ul.highlighter').accordion({active:'.selected',autoHeight:false,header:"a",collapsible:true,event:"click"});
   }
   
/* Accordion --> End */

/* Tabs --> Begin */

	if($('.tabs').length) {	
		//When page loads...
		$("ul.tabs li:first").addClass("active").show(); //Activate first tab
		$(".tab_container .tab_content:first").show(); //Show first tab content
	
		//On Click Event
		$("ul.tabs li").click(function() {
	
			$("ul.tabs li").removeClass("active"); //Remove any "active" class
			$(this).addClass("active"); //Add "active" class to selected tab
			$(".tab_content").hide(); //Hide all tab content
	
			var activeTab = $(this).find("a").attr("href"); //Find the href attribute value to identify the active tab + content
			$(activeTab).fadeIn('slow'); //Fade in the active ID content
			return false;
		});
	}
	
/* Tabs --> End */

/* Toggle --> Begin */

	if($('.toggle_container').length) {	
		$(".toggle_container").hide();
	
		$("b.trigger").click(function(){
			$(this).toggleClass("active").next().slideToggle("slow");
			return false;
		});
	}
	
/* Toggle --> End */


/* Flickr Photos --> Begin */	

if($('ul#flickr-badge').length) {
	jQuery('ul#flickr-badge').jflickrfeed({
		limit: 9,
		qstrings: {
		id: '56342020@N03'
	},
	itemTemplate: '<li><a href="http://www.flickr.com/photos/56342020@N03"><img src="{{image_s}}" alt="{{title}}" /></a></li>'
	}, function() {$('#flickr-badge li:nth-child(3n)').addClass('last');});
}

/* Flickr Photos --> End */


/* Gallery  --> End */

	if (jQuery("a[data-rel]").length) {
		jQuery('a[data-rel]').each(function() {jQuery(this).attr('rel', jQuery(this).data('rel'));});
	}
	
	if($('.splitter').length) {
		$('.splitter').lavaLamp({fx: "easeOutCubic", speed: 400});
	}

		var $filterType = $('#filter a');
		var $list = $('#gallery');
		var $data = $list.clone();
		$filterType.click(function(event) {
		if ($(this).attr('rel') == 'everyone') {
			var $sortedData = $data.find('li');
		} else {
			var $sortedData = $data.find('.'+ $(this).attr('rel'));
		}
			
			$list.quicksand($sortedData, {
				attribute: 'id',
				duration: 800,
				easing: 'easeInOutQuad',
				adjustHeight: 'auto',
				useScaling: 'false'
			}, function(){
				var $body = $('body');
				   $('.gallery-image img').each(function() {
					 handle_image($(this));      
				   });
				$("a.prettyPhoto").prettyPhoto({});
			});
			event.preventDefault();
		});	
		
/* Gallery  --> End */


/* Tables --> Begin */

	if($('.custom-table').length) {
		
		$('.custom-table thead tr th:first-child,.custom-table2 thead tr th:first-child').addClass('radius-left');
		$('.custom-table thead tr th:last-child, .custom-table2 thead tr th:last-child').addClass('radius-right');
		$('.custom-table tbody tr td:last-child, .custom-table2 tbody tr td:last-child').addClass('noborder');	
		
	}
	
/* Tables --> End */

/* Box close --> Begin */

	function handler(event) {
		
		var $target = $(event.target);
		
		if($target.is('.close-box')) {
			var $box = $target.parent();
			$box.animate({opacity: '0'}, 500, function() {
				$(this).slideUp(500, function() {
					$(this).remove();
				});
			});	
		}
		
	}
		
	$('.custom-box-wrap').append('<span class="close-box">&times;</span>').click(handler);


/* Box close --> End */


});/* ######################### DOM READY - END ######################### */