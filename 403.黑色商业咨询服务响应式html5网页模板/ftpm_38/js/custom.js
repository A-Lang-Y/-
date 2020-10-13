// Toggle Jquery
jQuery(document).ready(function(){

jQuery(".toggle_container").hide();

jQuery("span.trigger").toggle(function(){
jQuery(this).addClass("active"); 
}, function () {
jQuery(this).removeClass("active");
});

jQuery("span.trigger").click(function(){
jQuery(this).next(".toggle_container").slideToggle("slow,");
});
});


function portfoliohover()
{
	jQuery('.portfolio_content').hover(
		function() {
			 jQuery(this).find('.link_btn').stop().css("display","block");
			 jQuery(this).find('.overlay').stop().animate({opacity:0.7},200);
			  jQuery(this).find('.zoom').stop().animate({opacity:1},200);
			  jQuery(this).find('.link_post').stop().animate({opacity:1},200);
			// jQuery(this).find('.linkto').stop().animate({left:"42%"});
			  jQuery(this).find('img').css({opacity:.4});
			   jQuery(this).find('h4').stop().css("color","#fff");
			    //jQuery(this).find('.portfolio_content h5 a').stop().css("color","#fff");
			 
			 
			},
		function() {
			jQuery(this).find('.overlay').stop().animate({opacity:0},200);
			 jQuery(this).find('.zoom').stop().animate({opacity:0},200);
			 jQuery(this).find('.link_post').stop().animate({opacity:0},200);
			//jQuery(this).find('.linkto').stop().animate({left:'100%'});
			  jQuery(this).find('img').css({opacity:1});
				 jQuery(this).find('h4').stop().css("color","#828282");
		 });
}
jQuery(document).ready(function(){
//jQuery('.jqueryslidemenu ul:first > li').addClass("main-links");
jQuery('nav ul:first > li').addClass("main-links");	
jQuery('.overlay').css({opacity:0});
jQuery('.zoom').css({opacity:0});
jQuery('.link_post').css({opacity:0});
//jQuery('.linkto').css({left:'-100%'});
portfoliohover();
 });


// Create the dropdown bases
	jQuery(document).ready(function(){				
				jQuery("<select />").appendTo(".jqueryslidemenu");
				
				// Create default option "Go to..."
				jQuery("<option />", {
				   "selected": "selected",
				   "value"   : "",
				   "text"    : "Go to..."
				}).appendTo(".jqueryslidemenu select");
							
				// Populate dropdowns with the first menu items
				jQuery(".jqueryslidemenu ul li a").each(function() {
				 	var el = jQuery(this);
				 	jQuery("<option />", {
				     	"value"   : el.attr("href"),
				    	"text"    : el.text()
				 	}).appendTo(".jqueryslidemenu select");

					
				});
				
				//make responsive dropdown menu actually work			
		      	jQuery(".jqueryslidemenu select").change(function() {
		        	window.location = jQuery(this).find("option:selected").val();
					
		      	});
		});