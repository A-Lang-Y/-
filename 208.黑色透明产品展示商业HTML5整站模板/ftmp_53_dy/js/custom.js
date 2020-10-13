  jQuery.noConflict()(function($){
  $(document).ready(function($) {

$(window).scroll(function(){
		if($("#header").offset().top>0){
			$("#header").addClass("fixed-nav")
		}else{
			$("#header").removeClass("fixed-nav")
		}
	});


	
  	$('.flickr-photos').jflickrfeed({
		limit: 9,
		qstrings: {
			id: '37304598@N02'
		},
		itemTemplate: '<li><a href="{{image_b}}" target="_blank"><img src="{{image_s}}" alt="{{title}}" /></a></li>'
	});
	
  /*JQUERY TOOLTIP STARTS */
  if ( jQuery().tipsy ) {
	$("#filter-01").tipsy({gravity: 's'});
	$("#filter-02").tipsy({gravity: 's'});
	$("#filter-03").tipsy({gravity: 's'});
	$("#filter-04").tipsy({gravity: 's'});
	$("#filter-05").tipsy({gravity: 's'});
	$("#filter-06").tipsy({gravity: 's'});
	}
   /*JQUERY TOOLTIP ENDS  */
  
    /*RESPONSIVE NAVIGATION STARTS */
  mainNavChildren($("#main-navigation > ul") , 0);
	function mainNavChildren(parent , level){
		$(parent).children("li").each(function(i , obj){
			var label = "";
			for(var k = 0 ; k < level ; k++){
				label += "&nbsp;&nbsp;&nbsp;&nbsp;";
			}
			label += $(obj).children("a").text();
			$("#responsive-main-nav-menu").append("<option value = '" + $(obj).children("a").attr("href") + "'>" + label + "</option>");
			
			if($(obj).children("ul").size() == 1){
				mainNavChildren($(obj).children("ul") , level + 1);
			}
		});
	}
    /*RESPONSIVE NAVIGATION ENDS */		
	/*AUDIO / VIDEO PLAYER STARS*/	
$('audio,video').mediaelementplayer();
/*AUDIO / VIDEO PLAYER ENDS*/	
/*TAB STARS*/	
	(function() {
		var $tabsNav    = $('.tabs-nav'),
			$tabsNavLis = $tabsNav.children('li'),
			$tabContent = $('.tab-content');
		$tabContent.hide();
		$tabsNavLis.first().addClass('active').show();
		$tabContent.first().show();
		$tabsNavLis.on('click', function(e) {
			var $this = $(this);
			$tabsNavLis.removeClass('active');
			$this.addClass('active');
			$tabContent.hide();			
			$( $this.find('a').attr('href') ).fadeIn(700);
			e.preventDefault();
		});
	})();
/*TAB ENDS */	
/*ACCORDION STARS*/		
  initAccordion();	
function initAccordion() {
	jQuery('.accordion-item').each(function(i) {
		var item=jQuery(this);
		item.find('.accordion-content').slideUp(0);
		item.find('.accordion-switch').click(function() {
		 var displ = item.find('.accordion-content').css('display');
		 item.closest('ul').find('.accordion-switch').each(function() {
		  var li = jQuery(this).closest('li');
		  li.find('.accordion-content').slideUp(300);
		  jQuery(this).parent().removeClass("selected");
		 });
		 if (displ=="block") {
		  item.find('.accordion-content').slideUp(300) 
		  item.removeClass("selected");
		 } else {
		  item.find('.accordion-content').slideDown(300) 
		  item.addClass("selected");
		 }
		});
	});
}
	/*ACCORDION ENDS*/	
  
   /*PORTFOLIO ITEM HOVER*/
		if ( $( '.portfolio-item-hover-content' ).length && jQuery() ) {
		function hover_effect() {  
	$('.portfolio-item-hover-content').hover(function() {
            $(this).find('div,a').stop(0,0).removeAttr('style');
            $(this).find('.hover-options').animate({opacity: 0.9}, 'fast');
            $(this).find('a').animate({"top": "15%" });
        }, function() {
            $(this).find('.hover-options').stop(0,0).animate({opacity: 0}, "fast");
            $(this).find('a').stop(0,0).animate({"top": "150%"}, "slow");
            $(this).find('a.zoom').stop(0,0).animate({"top": "150%"}, "slow");
        });
		}
		hover_effect();
		}
	/*PORTFOLIO ITEM HOVER ENDS*/
	/*PRETTY PHOT O& FIT VIDEOS STARTS*/			
	$("a[data-rel^='prettyPhoto']").prettyPhoto({overlay_gallery: false});
	$(".container").fitVids();
 	/*PRETTY PHOT O& FIT VIDEOS ENDS*/	 	
	/*TWITTER FEEDS STARTS*/	   
 if ( $( '.tweet' ).length && jQuery()) {
$(".tweet").tweet({
	 username: "web_vogue",	/*PUT YOUR USERNAME*/	
	 join_text: null,
	 avatar_size: null,
	 count: 2,
	 auto_join_text_default: "we said,", 
	 auto_join_text_ed: "we",
	 auto_join_text_ing: "we were",
	 auto_join_text_reply: "we replied to",
	 auto_join_text_url: "we were checking out",
	 loading_text: "loading tweets..."
 });
 }
	/*TWITTER FEEDS ENDS*/	
 if ( $( '.flexslider' ).length && jQuery() ) {
		$('.flexslider').flexslider({ 
		 animation:"slide",
			controlNav:false,
		 controlsContainer:"#home",
		 nextText:"&rsaquo;",
		 prevText:"&lsaquo;",
		 keyboardNav: true,  
		});
  }
if ( $( '#map' ).length && jQuery() ) {
  /*GOOGLE MAPS*/
var $map = $('#map');		 
			$map.gMap({				
				address: 'Level 13, 2 Elizabeth St, Melbourne Victoria 3000 Australia',
				zoom: 18,
				markers: [
					{ 'address' : 'Level 13, 2 Elizabeth St, Melbourne Victoria 3000 Australia' },			 
				]	
			});
		 } 
   if ( $( '#main-navigation' ).length && jQuery() ) {
/* NAVIGATION JQUERY STARS */
var arrowimages={down:['downarrowclass', '', 23], right:['rightarrowclass', './images/plus-white.png']}
var jqueryslidemenu={
animateduration: {over: 200, out: 100}, //duration of slide in/ out animation, in milliseconds
buildmenu:function(menuid, arrowsvar){
	jQuery(document).ready(function($){
		var $mainmenu=$("#"+menuid+">ul")
		var $headers=$mainmenu.find("ul").parent()
		$headers.each(function(i){
			var $curobj=$(this)
			var $subul=$(this).find('ul:eq(0)')
			this._dimensions={w:this.offsetWidth, h:this.offsetHeight, subulw:$subul.outerWidth(), subulh:$subul.outerHeight()}
			this.istopheader=$curobj.parents("ul").length==1? true : false
			$subul.css({top:this.istopheader? this._dimensions.h+"px" : 0})
			$curobj.children("a:eq(0)").css(this.istopheader? {paddingRight: arrowsvar.down[2]} : {}).append(
				'<img src="'+ (this.istopheader? arrowsvar.down[1] : arrowsvar.right[1])
				+'" class="' + (this.istopheader? arrowsvar.down[0] : arrowsvar.right[0])
				+ '" style="border:0;" />'
			)
			$curobj.hover(
				function(e){
					var $targetul=$(this).children("ul:eq(0)")
					this._offsets={left:$(this).offset().left, top:$(this).offset().top}
					var menuleft=this.istopheader? 0 : this._dimensions.w
					menuleft=(this._offsets.left+menuleft+this._dimensions.subulw>$(window).width())? (this.istopheader? -this._dimensions.subulw+this._dimensions.w : -this._dimensions.w) : menuleft
					if ($targetul.queue().length<=1) //if 1 or less queued animations
						$targetul.css({left:menuleft+"px", width:this._dimensions.subulw+'px'}).slideDown(jqueryslidemenu.animateduration.over)
				},
				function(e){
					var $targetul=$(this).children("ul:eq(0)")
					$targetul.slideUp(jqueryslidemenu.animateduration.out)
				}
			) //end hover
			$curobj.click(function(){
				$(this).children("ul:eq(0)").hide()
			})
		}) //end $headers.each()
		$mainmenu.find("ul").css({display:'none', visibility:'visible'})
	}) //end document.ready
}
}
jqueryslidemenu.buildmenu("main-navigation", arrowimages)
}	/*CONTACT FORM STARTS*/	
if ( $( '#contact-form' ).length && jQuery() ) {
$('form#contact-form').submit(function() {
function resetForm($form) {
    $form.find('input:text, input:password, input:file, select, textarea').val('');
    $form.find('input:radio, input:checkbox')
    .removeAttr('checked').removeAttr('selected');
}
$('form#contact-form .error').remove();
var hasError = false;
$('.requiredField').each(function() {
if(jQuery.trim($(this).val()) == '') {
 var labelText = $(this).prev('label').text();
 $(this).parent().append('<div class="error">You forgot to enter your '+labelText+'</div>');
 $(this).addClass('inputError');
 hasError = true;
 } else if($(this).hasClass('email')) {
 var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
 if(!emailReg.test(jQuery.trim($(this).val()))) {
 var labelText = $(this).prev('label').text();
 $(this).parent().append('<div class="error">You entered an invalid '+labelText+'</div>');
 $(this).addClass('inputError');
 hasError = true;}}});
if(!hasError) {
$('form#contact-form input.submit').fadeOut('normal', function() {
$(this).parent().append('');});
var formInput = $(this).serialize();
$.post($(this).attr('action'),formInput, function(data){
$('#contact-form').prepend('<div class="success">Your email was successfully sent. We will contact you as soon as possible.</div>');
resetForm($('#contact-form'));
$('.success').fadeOut(15000);});}
return false;
});
}
/*CONTACT FORM ENDS*/	
/* ---------------------------------------------------------------------- */
	/*	Portfolio Filter
	/* ---------------------------------------------------------------------- */
	(function() {
		var $container = $('.portfolio-items');
		if( $container.length ) {
			var $itemsFilter = $('#filterable');
			// Copy categories to item classes
			$('li', $container).each(function(i) {
				var $this = $(this);
				$this.addClass( $this.attr('data-categories') );
			});
			// Run Isotope when all images are fully loaded
			$(window).on('load', function() {
				$container.isotope({
					itemSelector : 'li',
					layoutMode   : 'fitRows'
				});
			});
			// Filter projects
			$itemsFilter.on('click', 'a', function(e) {
				var $this         = $(this),
				currentOption = $this.attr('data-categories');
				$itemsFilter.find('a').removeClass('active');
				$this.addClass('active');
				if( currentOption ) {
					if( currentOption !== '*' ) currentOption = currentOption.replace(currentOption, '.' + currentOption)
					$container.isotope({ filter : currentOption });
				}
				e.preventDefault();
			});
			$itemsFilter.find('a').first().addClass('active');		
			$itemsFilter.on('mouseenter', function() {
				$(this).find('li a').stop(true,true).slideLeftShow(300);
			}).on('mouseleave', function() {
				$(this).find('li a').not('.active').stop(true,true).slideLeftHide(150);
			});
		}
	})();
	/* end Portfolio Filter */
});
});