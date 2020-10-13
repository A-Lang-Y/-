jQuery.noConflict();

$apex_highlightcolor = "#ffc539";


/* #On Document Ready
================================================== */



jQuery(document).ready(function() {	



	/* Menu */
	ddsmoothmenu.init({
		mainmenuid: "mainmenu", //menu DIV id
		orientation: 'h', //Horizontal or vertical menu: Set to "h" or "v"
		classname: 'ddsmoothmenu', //class added to menu's outer DIV
		contentsource: "markup" //"markup" or ["container_id", "path_to_menu_file"]
	});	
	
	
	
	/* Responsive Menu Generation */
    menuHandler();

	
	

	/* Responsive Select Menu */
	jQuery("#responsive-menu select").change(function() {
		window.location = jQuery(this).find("option:selected").val();
	});
	
	
	/* Footer Close */
    jQuery('.footerclose').click(function() {
		jQuery('.footer').animate({height:'hide'},{duration:500,queue:false}, 'easeInOutExpo')
		jQuery('.footerclose').animate({opacity:'hide'},{duration:300,queue:false}, 'easeOutSine')
		jQuery('.footeropen').animate({opacity:'show'},{duration:300,queue:false}, 'easeOutSine')
	});
	
	
	/* Footer Open */
    jQuery('.footeropen').click(function() {
		jQuery('.footer').animate({height:'show'},{duration:500,queue:false}, 'easeInOutExpo')
		jQuery('.footerclose').animate({opacity:'show'},{duration:300,queue:false}, 'easeOutSine')
		jQuery('.footeropen').animate({opacity:'hide'},{duration:300,queue:false}, 'easeOutSine')
		jQuery('html, body').animate({ scrollTop: jQuery(document).height()},{duration:300,queue:false}, 'easeOutSine'); 
		
		setTimeout(function() {
			jQuery('html, body').animate({ scrollTop: jQuery(document).height()},{duration:300,queue:false}, 'easeOutSine'); 
		},290);
	});
	
	
	/* Init FlexSlider Home */
	jQuery('.flexslider').not(".postslider").flexslider({
		touchSwipe: true, 
		controlNav: false,
		directionNav: true,
		slideshow: false,                
		slideshowSpeed: 7000,
		animationDuration: 600, 
		randomize: false, 
		pauseOnAction: false,    
		pauseOnHover: true  
	});
	
	
	/* Init FlexSlider Post */
	jQuery('.postslider').flexslider({
		touchSwipe: true,     
		controlNav: false,
		directionNav: true,
		slideshow: false,                
		slideshowSpeed: 7000,
		animationDuration: 600, 
		randomize: false, 
		pauseOnAction: false,    
		pauseOnHover: true  
	});



	/* List Fades */
	listfades(".clients");
	
	
	
	/* Accordion Init */
	initAccordion();
	
	
	
	/* Hover Effects */
	hoverEffects();



	/* MediaElement Init */
	jQuery('audio,video').mediaelementplayer();
	
	
	
	/* Tabs */
	tabsInit();
	
	
	
	/* Fit Videos */
	jQuery(".scalevid").fitVids();
	
	
	
	/* Portfolio 4 Column */
	jQuery('.portfolio4column').tpportfolio({
		speed:500,
		row:4,
		nonSelectedAlpha:0,
		portfolioContainer:'.portfolio'
	});
	
	
	
	/* Contact Form */
	if(jQuery('#contactform').length != 0){
		addForm('#contactform');
	}
	
	
	/* Quick Contact */
	if(jQuery('#quickcontact').length != 0){
		addForm('#quickcontact');
	}
	
	
	/* Blog Comments */
	if(jQuery('#replyform').length != 0){
		addForm('#replyform');
	}
	
	
	/* Footer Position Calculator */
    footerHandler();
    
	
	
    /* PrettyPhoto */
	addPrettyPhoto();
	
	
	
	/* Back to Top */
    orig_scroll_height = jQuery(".subfooterwrap").offset().top - jQuery(window).height()-100;
    
	
	jQuery(function () {
        jQuery(window).scroll(function () {
			
            if (jQuery(this).scrollTop() > (jQuery(document).height()-jQuery(window).height()-100)) {
                jQuery('.backtotop').fadeIn(300);
                jQuery('.backtotop .btxt').css("display", "none");
            } else {
                jQuery('.backtotop').fadeOut(100);
                jQuery('.backtotop .btxt').css("display", "none");
            }
        });

        jQuery('.backtotop').click(function () {
            jQuery('body,html').animate({
                scrollTop: 0
            },  400);
            return false;
        });
    });
    jQuery(".backtotop").hover(function() {
        jQuery(this).find(".btxt").fadeIn(300);
	},function() {
		jQuery(this).find(".btxt").fadeOut(300);
	});
	
});



/* #On Window Load
================================================== */



jQuery(window).load(function() {	
			 
	jQuery("#background").fullBg();

	/* Tweet List */
	if(jQuery('.widget_tweets').length != 0){
		jQuery.ajaxSetup({ cache: true });
		jQuery.getJSON("http://twitter.com/status/user_timeline/envato.json?count=3&callback=?", function(data){
			jQuery.each(data, function(index, item){
					var $twlink = item.text.linkify();
					jQuery(".widget_tweets ul").append("<li>" + $twlink + "<div class='subline'>" + relative_time(item.created_at) + "</div></li>");
			});
		});
	}
	
});



/* #Menu Handler
================================================== */


function menuHandler() {

	var defpar = jQuery('#mainmenu').parents().length;
	
	jQuery('#mainmenu li >a').each(function() {
		var a=jQuery(this);
		var par= a.parents().length-defpar -3;	
		
		var atext = a.html().split('<')[0];
		atext = atext.toLowerCase();
		atext = atext.substr(0,1).toUpperCase() + atext.substr(1,atext.length);
						
		if (par==0)
			var newtxt=jQuery("<div>"+atext+"</div>").text();
		else
			if (par==2)
				var newtxt=jQuery("<div>&nbsp;&nbsp;&nbsp;"+atext+"</div>").text();
			else
				if (par==4)
					var newtxt=jQuery("<div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"+atext+"</div>").text();
		
		 jQuery('#responsive-menu select').append(new Option(newtxt,a.attr('href')) );
	});
	
	
	
	//var aktmenu=jQuery('.current_page_item a:first').text();
	//jQuery('#responsive-menu-button').html(aktmenu);	
}



/* #Footer Handler
================================================== */



function footerHandler() {	
	
	var main_cont = jQuery('body').find('.main:first');
	var footer_wrap = jQuery('body').find('.footerwrap');
	var subfooter_wrap = jQuery('body').find('.subfooterwrap');
	setInterval(function() {
	
		
				var mainh = main_cont.outerHeight();
				var footerh = footer_wrap.outerHeight() + subfooter_wrap.outerHeight();
				var windowh = jQuery(window).height();
				
				var dif = windowh - (mainh+footerh);

				if (dif>0) {
					footer_wrap.stop();
					footer_wrap.animate({'marginTop':dif+"px"},{duration:300,queue:false});
				}
				
				if (dif<0) {
					footer_wrap.stop();
					footer_wrap.animate({'marginTop':"0px"},{duration:300,queue:false});
					
				}

				// DEBUG jQuery('body').find('.khinfo').html('main:'+mainh+"  footer:"+footerh+" Window:"+windowh+"  dif:"+dif);
		
	},100);
	
	setInterval(function() {
			
			jQuery('.tiledbackground').height(jQuery(document).height());
			jQuery('.whitebackground').height(jQuery(document).height());
		
	},500);
	
}



/* #Accordion
================================================== */



function initAccordion() {
	jQuery('.accordion-item').each(function(i) {
		var item=jQuery(this);
		item.find('.togglecontent').slideUp(0);
		item.find('.toggleswitch').click(function() {
		 var displ = item.find('.togglecontent').css('display');
		 item.closest('ul').find('.toggleswitch').each(function() {
		  var li = jQuery(this).closest('li');
		  li.find('.togglecontent').slideUp(300);
		  jQuery(this).parent().removeClass("selected");
		 });
		 if (displ=="block") {
		  item.find('.togglecontent').slideUp(300) 
		  item.removeClass("selected");
		 } else {
		  item.find('.togglecontent').slideDown(300) 
		  item.addClass("selected");
		 }
		});
	});
}



/* #List Fade
================================================== */



function listfades(container) {
	jQuery(container).find('>li').each(function() {
		var li=jQuery(this);
		li.hover(
			function() {
				var li=jQuery(this);								
				li.addClass('listover');
				li.find('img:first').addClass('listovereffect');
				
				
				jQuery(container).find('>li').each(function(i) {
					var lis = jQuery(this);
					lis.stop();
					if (!lis.hasClass('listover'))
						lis.find('img:first').animate({opacity:0.3},{duration:300,queue:false});
					else
						lis.find('img:first').animate({opacity:1},{duration:300,queue:false});
				});	
			},
			function() {
				var li=jQuery(this);								
				li.removeClass('listover');
				li.find('img:first').removeClass('listovereffect');
				li.siblings().each(function() {
					var lis = jQuery(this);
					lis.stop();
					lis.find('img:first').animate({opacity:1},{duration:300,queue:false});
				});
				
				li.stop();					
				li.find('img:first').animate({opacity:1},{duration:300,queue:false});
			});
	});
}



/* #Pretty Photo
================================================== */



function addPrettyPhoto() {
	/* PrettyPhoto init */
	jQuery("a[data-rel^='prettyPhoto']").prettyPhoto({
		theme: 'pp_default',
		overlay_gallery: false,
		show_title: false,
        social_tools: false,
		hideflash: true
	});
}



/* #Site Tabs
================================================== */



function tabsInit() {
	
	/*
	* Skeleton V1.1
	* Copyright 2011, Dave Gamache
	* www.getskeleton.com
	* Free to use under the MIT license.
	* http://www.opensource.org/licenses/mit-license.php
	* 8/17/2011
	*/
	
	/* Tabs Activiation
	================================================== */

	var tabs = jQuery('ul.tabs');

	tabs.each(function(i) {

		//Get all tabs
		var tab = jQuery(this).find('> li > a');
		tab.click(function(e) {

			//Get Location of tab's content
			var contentLocation = jQuery(this).attr('href');

			//Let go if not a hashed one
			if(contentLocation.charAt(0)=="#") {

				e.preventDefault();

				//Make Tab Active
				tab.removeClass('active');
				jQuery(this).addClass('active');

				//Show Tab Content & add active class
				jQuery(contentLocation).fadeIn().addClass('active').siblings().hide().removeClass('active');

			}
		});
	});	
}



/* #Site Hover Effects
================================================== */



function hoverEffects() {
	
	/* Social Tooltip Hover */
	function addSocialHover(socialitem) {
		var descrdiv = jQuery(socialitem).parent().find('div');
		jQuery(socialitem).hover(function() {
			descrdiv.css("opacity", "0");
			descrdiv.css("display", "block");
			descrdiv.animate({opacity:1},{duration:200,queue:false});
		},function() {
			descrdiv.animate({opacity:0},{duration:200,queue:false});
		});
	}
	addSocialHover("a.social_facebook");
	addSocialHover("a.social_twitter");
	addSocialHover("a.social_rss");
	addSocialHover("a.social_vimeo");
	addSocialHover("a.social_googleplus");
	addSocialHover("a.social_linkedin");
	addSocialHover("a.social_flickr");
	addSocialHover("a.social_youtube");
	addSocialHover("a.social_pinterest");
	
	/* Image Hover */
	jQuery('.hovering').hover(		
		function() {
			var $this=jQuery(this);
			var $bordertop=jQuery(this).parent().find('.topline');
			var $borderbottom=jQuery(this).parent();
			
			if (jQuery.browser.msie && jQuery.browser.version==8) {
				jQuery('body').data('somethinghovered',1);				
			}
			
			if (!$this.find('img:first').hasClass("underanimation")) {
					if (jQuery.browser.msie && jQuery.browser.version<9 && $this.find('.overlay').length>0) {
						// IS ALREADY IN ACTION
						
					} else {
							
							var img = $this.find('img:first');
							var w=img.width();
							var h=img.height();
							var btw = parseInt(img.css('border-top-width'),0);
							var blw = parseInt(img.css('border-left-width'),0);
							if (btw>0 && btw<1000)	{
								} else {
									btw=0;
								}
							if (blw>0 && blw<1000)	{
								} else {
									blw=0;
								}
							
							
							var t=img.position().top + btw;
							var l=img.position().left + blw;
							
							
							// ADD THE OVERLAY ON THE A TAG BY HOVER
							
							$this.append('<div class="overlay" style="overflow:hidden;position:absolute;cursor:pointer;"></div>');
							$this.find('.overlay').css({'top':t+'px',
														'left':l+'px',
														'width':w+'px',
														'height':h+'px'});
							
							$this.find('.overlay').css({'opacity':0});
							$this.find('.overlay').animate({'opacity':0.5},{duration:300,queue:false}, 'easeOutExpo');
							
							// ADD THE TEXT CAPTION ON THE HOVERED A TAG IMAGE
							if ($this.data('text')!=undefined) {
								$this.append('<div class="overlaytext" style="position:absolute;opacity:0.0">'+$this.data("text")+'</div>');
								var txt=$this.find('.overlaytext');				
								
								txt.css({'top':(t+h/2-parseInt(txt.outerHeight(),0)/2)+40+"px"});
								txt.css({'left':(l+w/2-parseInt(txt.outerWidth(),0)/2)+"px"});
								var linkytarg = (t+h/2-parseInt(txt.outerHeight(),0)/2);
								txt.animate({'opacity':'1.0','top':linkytarg+"px"},{duration:300,queue:false}, 'easeOutExpo');
							}

							
					}
			}
		},
		function() {
						
		
				
			var $this=jQuery(this);
			var $bordertop=jQuery(this).parent().find('.topline');
			var $borderbottom=jQuery(this).parent();
			$this.find('.overlay').stop();
			$this.find('.overlay').animate({'opacity':0},{duration:300,queue:false}, 'easeOutExpo');
			$this.find('.overlaytext').animate({'opacity':0},{duration:300,queue:false}, 'easeOutExpo');
			$this.data('removetimer',setTimeout(function() {
					$this.find('.overlay').remove();
					$this.find('.overlaytext').remove();
					
				},300));
			
		});

	}


/* #Time Format & Linkify
================================================== */



/* Linkify and Relative Time functions by Ralph Whitbeck http://ralphwhitbeck.com/2007/11/20/PullingTwitterUpdatesWithJSONAndJQuery.aspx */
String.prototype.linkify = function() {
	return this.replace(/[A-Za-z]+:\/\/[A-Za-z0-9-_]+\.[A-Za-z0-9-_:%&\?\/.=]+/, function(m) {
			return m.link(m);
	})/*.split('<a href').join('</br><a href').split('/a>').join('/a></br>')*/;
};

function relative_time(time_value) {
  var values = time_value.split(" ");
  time_value = values[1] + " " + values[2] + ", " + values[5] + " " + values[3];
  var parsed_date = Date.parse(time_value);
  var relative_to = (arguments.length > 1) ? arguments[1] : new Date();
  var delta = parseInt((relative_to.getTime() - parsed_date) / 1000);
  delta = delta + (relative_to.getTimezoneOffset() * 60);

  var r = '';
  if (delta < 60) {
        r = 'a minute ago';
  } else if(delta < 120) {
        r = 'couple of minutes ago';
  } else if(delta < (45*60)) {
        r = (parseInt(delta / 60)).toString() + ' minutes ago';
  } else if(delta < (90*60)) {
        r = 'an hour ago';
  } else if(delta < (24*60*60)) {
        r = '' + (parseInt(delta / 3600)).toString() + ' hours ago';
  } else if(delta < (48*60*60)) {
        r = '1 day ago';
  } else {
        r = (parseInt(delta / 86400)).toString() + ' days ago';
  }
  
  return r;
}



/* #Background Image
================================================== */



/**
 * jQuery.fullBg
 * Version 1.0
 * Copyright (c) 2010 c.bavota - http://bavotasan.com
 * Dual licensed under MIT and GPL.
 * Date: 02/23/2010
**/
(function($) {
  $.fn.fullBg = function(){
    var bgImg = $(this);		
 
    function resizeImg() {
      var imgwidth = bgImg.width();
      var imgheight = bgImg.height();
 
      var winwidth = $(window).width();
      var winheight = $(window).height();
 
      var widthratio = winwidth / imgwidth;
      var heightratio = winheight / imgheight;
 
      var widthdiff = heightratio * imgwidth;
      var heightdiff = widthratio * imgheight;
 
      if(heightdiff>winheight) {
        bgImg.css({
          width: winwidth+'px',
          height: heightdiff+'px'
        });
      } else {
        bgImg.css({
          width: widthdiff+'px',
          height: winheight+'px'
        });		
      }
    } 
    resizeImg();
	bgImg.fadeIn('fast');
    $(window).resize(function() {
      resizeImg();
    }); 
  };
})(jQuery)



/* #Forms
================================================== */



function addForm(formtype) {

	var formid = jQuery(formtype);
	var emailsend = false;
	
	formid.find("button[name=send]").click(sendemail);
	
	function validator() {
		
		var emailcheck = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
		var othercheck = /.{4}/;
		var noerror = true;
		
		formid.find(".requiredfield").each(function () {
													 
			var fieldname = jQuery(this).attr('name');
			var value = jQuery(this).val();
			if(value == "Name *" || value == "Email *" || value == "Message *"){
				value = "";	
			}

			if(fieldname == "email"){
				if (!emailcheck.test(value)) {
					jQuery(this).addClass("formerror");
					noerror = false;
				} else {
					jQuery(this).removeClass("formerror");
				}	
			}else{
				if (!othercheck.test(value)) {
					jQuery(this).addClass("formerror");
					noerror = false;
				} else {
					jQuery(this).removeClass("formerror");
				}	
			}
		})
		
		if(!noerror){
			formid.find(".errormessage").fadeIn();
		}
		
		return noerror;
	}
	
	function resetform() {
		formid.find("input").each(function () {
			jQuery(this).val("");	
		})
		formid.find("textarea").val("");
		emailsend = false;
	}
	
	function sendemail() {
		formid.find(".successmessage").hide();
		var phpfile = "";
		if(formtype=="#contactform"){
			phpfile = "php/contact.php";
		}else if(formtype=="#quickcontact"){
			phpfile = "php/quickcontact.php";
		}else{
			phpfile = "";
		}
		if (validator()) {
			if(!emailsend){
				emailsend = true;
				formid.find(".errormessage").hide();
				formid.find(".sendingmessage").show();
				jQuery.post(phpfile, formid.serialize(), function() {
					formid.find(".sendingmessage").hide();
					formid.find(".successmessage").fadeIn();
					resetform();
				});
			}
		} 
		return false
	}
}



/* #Portfolio
================================================== */



(function($,undefined){	
	
	
	
	////////////////////////////
	// THE PLUGIN STARTS HERE //
	////////////////////////////
	
	$.fn.extend({
	
		
		// OUR PLUGIN HERE :)
		tpportfolio: function(options) {
	
		
			
		////////////////////////////////
		// SET DEFAULT VALUES OF ITEM //
		////////////////////////////////
		var defaults = {	
			speed:500,
			row:4,
			nonSelectedAlpha:0,
			portfolioContainer:".portfolio"
		};
		
			options = $.extend({}, $.fn.tpportfolio.defaults, options);
		

			return this.each(function() {
			
				var opt=options;				
				var bod= $(this);
				
				var start=0;				
				var many =bod.find('.all-group').length;
				var lasts = many - (Math.floor(many / opt.row) * opt.row);
				
				if (opt.nonSelectedAlpha===0) {
					bod.find(opt.portfolioContainer).wrap('<div class="portfoliooutterholder" style="position:relative;clear:both;overflow:hidden;"></div>');	
				}
				
				if (lasts==0) lasts=opt.row;
				
				
				
				// ADD ALPHA AND OMEGA CLASS FOR FIRST AND LAST ITEM !
				bod.find('.all-group').each(function(i) {
					start++;
					var item=$(this);					
					
					//alert(item.find('img:first').width());
					if (start==1)
						item.addClass('alpha');
						
						
					if (start===opt.row) {
						item.addClass('omega');
						start=0;										
					}
					
					if (i>=many-lasts) item.addClass('nopadding');
					
				});
				
				
				
				
				
				
				// SET UP THE CLICKS AND THE ANIMATIONS
				bod.find('.portfolio_selector').each(function(){
				
					// PREPARE THE FIRST START HERE
					var selector=$(this);
					if (selector.data('group') === "all-group") {
						selector.addClass('selected_selector');
					} else {
						selector.addClass('nonselected_selector');
					}
					
					
					// HOVER EFFECT
					selector.hover(
						function() {
							var sels=$(this);
							if (!(sels.hasClass('selected_selector'))) {
								sels.removeClass('nonhovered_selector');
								sels.addClass('hovered_selector');
							}
						},
						function() {
							var sels=$(this);
							if (!(sels.hasClass('selected_selector'))) {
								sels.removeClass('hovered_selector');
								sels.addClass('nonhovered_selector');
							}
						});
						
						
						
					// CLICK EFFECT
					selector.click(function() {
						
						// FOR HIDING PORTFOLIO SET THE OUTER CONTAINER HEIGHT
						if (opt.nonSelectedAlpha===0) {
								// SET THE OUTTER  AND INNER HEIGHT OF THE CONTAINER DIV
								var oholder = bod.find('.portfoliooutterholder');
								var iholder = bod.find(opt.portfolioContainer);
								oholder.css({'width':'100%','height':iholder.height()+"px"});				
						
								if (!oholder.hasClass("row")) oholder.addClass("row");
						}

						
						// ADD AND REMOVE THE FADES FROM THE SELECTORS !!
						// FIRST REMOVE THE SELECTED SELECTORS
						bod.find('.portfolio_selector').each(function(){ 
							var sels=$(this);
							sels.removeClass('selected_selector');
							sels.removeClass('nonselected_selector');
							sels.removeClass('hovered_selector');
							sels.removeClass('nonhovered_selector');
						});
						
						// THAN ADD THE SELECTED SELECTOR TO THE NEW ONE
						selector.addClass("selected_selector");
						
						// THAN FADE OUT ALL NOT NEEDED SELECTOR
						bod.find('.portfolio_selector').each(function(){
							var sels=$(this);
							sels.stop();
							if (sels.hasClass('selected_selector')) {
								sels.addClass("selected_selector");
							} else {
								sels.addClass('nonselected_selector');
							}
						});
						
						
						
						
						// DEPENDING ON HOW FAR WE SHOUD HIDE THE REsT OF THE ITEMS, WE NEED TO REORGANISE THE FULL PORTFOLIO
						if (opt.nonSelectedAlpha===0) {
								
								var aoh = 0; // Amount Of Items to Hide
								var aos = 0; // Amount Of Items to Show
								
								$('body').find('.all-group').each(function(i) {
								
									var item=$(this);							
									item.stop();
									
									var img=item.find('img:first');

									// CALCULATE THE CURRENT IMAGE SIZES
									var l=img.position().left;
									var t=img.position().top;
									var iw=img.width();
									var ih=img.height();
									
									item.css({'position':'relative'});
									
									if (item.find('.deletemesoon').length==0)
										img.wrap('<div class="deletemesoon" style="position:relative;overflow:hidden;width:100%;height:'+ih+'px"></div>');
									img.css({'position':'absolute'});
								
									//if (item.css('display') != "none") aoh++;
									setTimeout(function() {
										img.animate({'top':ih+'px'},{duration:opt.speed,queue:false});
										item.animate({'opacity':0},{duration:opt.speed,queue:false});									
									},aoh*125);
									
								});
								
								
								// REMOVE THE ITEMS WE DONT NEED, AND REMOVE THE CLASSES
								setTimeout(function() {
									$('body').find('.all-group').each(function(i) {
										var item=$(this);	
										
										
										
										if (!item.hasClass(selector.data('group'))) 
											{
												item.css({'display':'none'}) 
											} else {
												item.css({'display':'block','opacity':0}) 
											}
										item.removeClass('alpha')
										item.removeClass('omega')
										item.remove('nopadding');

										
									 });
									},opt.speed+aoh*125);
								
								
								setTimeout(function() {
									
									var start=0;
									var many = $('body').find('.'+selector.data('group')).length;
									var lasts = many - (Math.floor(many / opt.row) * opt.row);
									if (lasts==0) lasts=opt.row;
									
									$('body').find('.'+selector.data('group')).each(function(i) {
										start++;
										var item=$(this);
										item.css({'display':'block','opacity':0});
										
										// STOP IMG ANIMATION
										var img=item.find('img:first');	
										var dele=item.find('.deletemesoon');
										dele.css({'width':'100%'});
										img.css({'top':'0px'});
										dele.css({'height':img.height()+"px"});
										
										img.stop();
										img.css({'position':'absolute','top':img.height()+"px"});
										img.animate({'top':'0px'},{duration:opt.speed,queue:false});
										
										var oholder = bod.find('.portfoliooutterholder');
										
										
										setTimeout(function() {
											img.prependTo(item.find('a:first'));
											img.css({'position':'relative','top':'0px'});
											item.find('.deletemesoon').remove();
											
											
										},opt.speed+10+aoh*125);
										
										
										
										item.stop();
										item.animate({'opacity':1},{duration:opt.speed,queue:false});
										
										if (start==1)
											item.addClass('alpha');											
											
										if (start===opt.row) {
											item.addClass('omega');
											start=0;
										}
										if (i>=many-lasts) {
											item.addClass('nopadding');
										} else {
											item.removeClass('nopadding');
										}
									});
									
									
									buildRows(opt);
																									
									// SET HEIGHT OF PORTFOLIO HOLDER
									
									
									var iholder = bod.find(opt.portfolioContainer);
									oholder.stop();
									
									oholder.animate({'height':iholder.outerHeight()+"px"},{duration:400,queue:false});																		
									
									},(opt.speed+20)+(aoh*125));

						 } else {
						 
						 
							$('body').find('.nonclickbar').remove();
							// IF UNSLECTED ARE STILL VISIBLE, WE DONT NEED TO REMOVE THEM... 
							
							
							$('body').find('.all-group').each(function() {
									
									var item=$(this);							
									item.stop();
									if (item.hasClass(selector.data('group'))) {										
										item.animate({'opacity':1},{duration:opt.speed,queue:false});
									} else {
										
										var w=item.outerWidth();
										var h=item.outerHeight();
										
										
										
										var t=item.position().top;
										var l=item.position().left;
										
										
										// ADD THE OVERLAY ON THE A TAG BY HOVER
										item.parent().append('<div class="nonclickbar" style="position:absolute;top:'+t+'px;left:'+l+'px;width:'+w+'px;height:'+h+'px;background:#000"></div>');
										
										item.parent().find('.nonclickbar').css({'opacity':0.0}).addClass(item.data('row'));
										
										
										item.animate({'opacity':opt.nonSelectedAlpha/100},{duration:opt.speed,queue:false});
										
										
									}
																			
								});
								setTimeout(function() {buildRows(opt);},100);
						 }
						return false;
					});
				});
				
				
				var lodedimg=0;
				bod.find('.all-group').waitForImages(
					function() {
						buildRows(opt);
						if (opt.nonSelectedAlpha===0) {
								// SET THE OUTTER  AND INNER HEIGHT OF THE CONTAINER DIV
								var oholder = bod.find('.portfoliooutterholder');
								var iholder = bod.find(opt.portfolioContainer);
								oholder.css({'width':'100%','height':iholder.height()+"px"});										
								if (!oholder.hasClass("row")) oholder.addClass("row");
						}
						
					},
					
					function() {
						lodedimg = lodedimg+1;
						buildRows(opt);
						
					}
					
				);
					
				buildRows(opt,true);
				$(window).resize(function() {
					
					clearTimeout(opt.resized);
					opt.resized=setTimeout(function() {
						buildRows(opt,true);
					},100);
					
				});		
												
			})
	}
})

		//////////////////////////////////////////////
		// BUILD THE ROWS ON RESCALING OR AT START //
		////////////////////////////////////////////
		function buildRows(opt,no) {
		
						
						var bod=$('body');
						
						// REMOVE ACTUAL ROWS (IF THERE IS ANY)
						bod.find('.rowwrap').each(function(i) {
							var item=$(this).find('.rowed:first');
							item.unwrap();
							
						});
						
						// REMOVE THE ROWED AND ROWx CLASSES
						bod.find('.rowed').each(function(i) {
							var item=$(this);
							item.removeClass(item.data('row'));
							item.removeClass('rowed');
						});
						
						var row=0;
						
						// GO THROUGH, AND CHECK ALPHAS AND OMEGAS
						bod.find('.all-group').each(function(i) {
							var item=$(this);
							item.addClass('row'+row);
							item.addClass('rowed');
							item.data('row','row'+row);
							if (item.hasClass('omega')) {
								row++;
							}
						});
						
						
						// CREATE ROWS AROUND THE ITEMS
						for (i=0;i<row;i++) {												
							bod.find('.row'+i).wrapAll('<div class="rowwrap" style="position:relative;height:0px;width:100%;"></div>');					
						}
						
						// SET HEIGHT OF EACH ROW HERE
						
						bod.find('.killerclear').remove();
						var maxrowa = bod.find('.rowwrap').length;
						
						bod.find('.rowwrap').each(function(j) {
							var $this=$(this);
							var max=0;
							$this.find('.rowed').each(function(i) {
									if ($(this).css('display')!="none") {
										//console.log(j+". Row Element "+i+". height:"+$(this).outerHeight());
										if (max<$(this).height()) max=$(this).outerHeight();
									}
							});
							//console.log(j+'. Row Berechnete:'+max);							
							$this.css({'height':(max)+"px"});  //max+"px"});
							//if (j<maxrowa-1) {
								//console.log('Added Clear');
								$this.after('<div style="clear:both" class="killerclear"></div>');
							//} else {
							//	console.log('Last Row has no Clear !!');
							//}
							
						});
						
						
						var oholder = bod.find('.portfoliooutterholder');						
						var iholder = bod.find(opt.portfolioContainer);
						oholder.stop();
						oholder.animate({'height':iholder.outerHeight()+"px"},{duration:400,queue:false});
						
				};
				
			
})(jQuery);	



/*
 * waitForImages 1.3.3
 * -----------------
 * Provides a callback when all images have loaded in your given selector.
 * http://www.alexanderdickson.com/
 *
 *
 * Copyright (c) 2011 Alex Dickson
 * Licensed under the MIT licenses.
 * See website for more info.
 *
 */

;(function($) {
    
    // CSS properties which contain references to images. 
    $.waitForImages = {
        hasImageProperties: [
        'backgroundImage',
        'listStyleImage',
        'borderImage',
        'borderCornerImage'
        ]
    };
    
    // Custom selector to find `img` elements that have a valid `src` attribute and have not already loaded.
    $.expr[':'].uncached = function(obj) {
        // Firefox will always return `true` even if the image has not been downloaded.
		// Doing it this way works in Firefox.
        var img = document.createElement('img');
        img.src = obj.src;
        return $(obj).is('img[src!=""]') && ! img.complete;
    };
    
    $.fn.waitForImages = function(finishedCallback, eachCallback, waitForAll) {

        // Handle options object.
        if ($.isPlainObject(arguments[0])) {
            eachCallback = finishedCallback.each;
            waitForAll = finishedCallback.waitForAll;
            finishedCallback = finishedCallback.finished;
        }

        // Handle missing callbacks.
        finishedCallback = finishedCallback || $.noop;
        eachCallback = eachCallback || $.noop;

        // Convert waitForAll to Boolean
        waitForAll = !! waitForAll;

        // Ensure callbacks are functions.
        if (!$.isFunction(finishedCallback) || !$.isFunction(eachCallback)) {
            throw new TypeError('An invalid callback was supplied.');
        };

        return this.each(function() {
            // Build a list of all imgs, dependent on what images will be considered.
            var obj = $(this),
                allImgs = [];

            if (waitForAll) {
                // CSS properties which may contain an image.
                var hasImgProperties = $.waitForImages.hasImageProperties || [],
                    matchUrl = /url\((['"]?)(.*?)\1\)/g;
                
                // Get all elements, as any one of them could have a background image.
                obj.find('*').each(function() {
                    var element = $(this);

                    // If an `img` element, add it. But keep iterating in case it has a background image too.
                    if (element.is('img:uncached')) {
                        allImgs.push({
                            src: element.attr('src'),
                            element: element[0]
                        });
                    }

                    $.each(hasImgProperties, function(i, property) {
                        var propertyValue = element.css(property);
                        // If it doesn't contain this property, skip.
                        if ( ! propertyValue) {
                            return true;
                        }

                        // Get all url() of this element.
                        var match;
                        while (match = matchUrl.exec(propertyValue)) {
                            allImgs.push({
                                src: match[2],
                                element: element[0]
                            });
                        };
                    });
                });
            } else {
                // For images only, the task is simpler.
                obj
                 .find('img:uncached')
                 .each(function() {
                    allImgs.push({
                        src: this.src,
                        element: this
                    });
                });
            };

            var allImgsLength = allImgs.length,
                allImgsLoaded = 0;

            // If no images found, don't bother.
            if (allImgsLength == 0) {
                finishedCallback.call(obj[0]);
            };

            $.each(allImgs, function(i, img) {
                
                var image = new Image;
                
                // Handle the image loading and error with the same callback.
                $(image).bind('load error', function(event) {
                    allImgsLoaded++;
                    
                    // If an error occurred with loading the image, set the third argument accordingly.
                    eachCallback.call(img.element, allImgsLoaded, allImgsLength, event.type == 'load');
                    
                    if (allImgsLoaded == allImgsLength) {
                        finishedCallback.call(obj[0]);
                        return false;
                    };
                    
                });

                image.src = img.src;
            });
        });
    };
})(jQuery);

/* http://keith-wood.name/backgroundPos.html
   Background position animation for jQuery v1.0.1.
   Written by Keith Wood (kbwood{at}iinet.com.au) November 2010.
   Dual licensed under the GPL (http://dev.jquery.com/browser/trunk/jquery/GPL-LICENSE.txt) and 
   MIT (http://dev.jquery.com/browser/trunk/jquery/MIT-LICENSE.txt) licenses. 
   Please attribute the author if you use it. */
(function($){var g='bgPos';$.fx.step['backgroundPosition']=$.fx.step['background-position']=function(a){if(!a.set){var b=$(a.elem);var c=b.data(g);b.css('backgroundPosition',c);a.start=parseBackgroundPosition(c);a.end=parseBackgroundPosition($.fn.jquery>='1.6'?a.end:a.options.curAnim['backgroundPosition']||a.options.curAnim['background-position']);for(var i=0;i<a.end.length;i++){if(a.end[i][0]){a.end[i][1]=a.start[i][1]+(a.end[i][0]=='-='?-1:+1)*a.end[i][1]}}a.set=true}$(a.elem).css('background-position',((a.pos*(a.end[0][1]-a.start[0][1])+a.start[0][1])+a.end[0][2])+' '+((a.pos*(a.end[1][1]-a.start[1][1])+a.start[1][1])+a.end[1][2]))};function parseBackgroundPosition(c){var d={center:'50%',left:'0%',right:'100%',top:'0%',bottom:'100%'};var e=c.split(/ /);var f=function(a){var b=(d[e[a]]||e[a]||'50%').match(/^([+-]=)?([+-]?\d+(\.\d*)?)(.*)$/);e[a]=[b[1],parseFloat(b[2]),b[4]||'px']};if(e.length==1&&$.inArray(e[0],['top','bottom'])>-1){e[1]=e[0];e[0]='50%'}f(0);f(1);return e}$.fn.animate=function(e){return function(a,b,c,d){if(a['backgroundPosition']||a['background-position']){this.data(g,this.css('backgroundPosition')||'center')}return e.apply(this,[a,b,c,d])}}($.fn.animate)})(jQuery);