(function (window, $) {
	'use strict';

	// Cache document for fast access.
	var document = window.document;


	/************** Toggle Menu *********************/
	$('a.toggle-menu').click(function(){
        $(".menu").slideToggle(400);
		return false;
    });




    /************** Open Different Pages *********************/
	$(".menu a").click(function(){
		var id =  $(this).attr('class');
		id = id.split('-');
		$("#menu-container .content").hide();
		$("#menu-container #menu-"+id[1]).addClass("animated fadeInDown").show();
		return false;
	});

	$(".menu a.homebutton").click(function(){
		$(".menu").slideUp();
	});


	$(window).resize(function(){
		if ($(window).width() <= 769){	
			$(".menu a").click(function(){
				$(".menu").hide();
				return false;
			});
		}	
	});



	/************** Tabs *********************/
	$('ul.tabs').each(function(){
		// For each set of tabs, we want to keep track of
		// which tab is active and it's associated content
		var $active, $content, $links = $(this).find('a');

		// If the location.hash matches one of the links, use that as the active tab.
		// If no match is found, use the first link as the initial active tab.
		$active = $($links.filter('[href="'+location.hash+'"]')[0] || $links[0]);
		$active.addClass('active');

		$content = $($active[0].hash);

		// Hide the remaining content
		$links.not($active).each(function () {
		$(this.hash).hide();  
		});

		// Bind the click event handler
		$(this).on('click', 'a', function(e){
		// Make the old tab inactive.
		$active.removeClass('active');
		$content.hide();

		// Update the variables with the new link and content
		$active = $(this);
		$content = $(this.hash);

		// Make the tab active.
		$active.addClass('active');
		$content.slideToggle();

		// Prevent the anchor's default click action
		e.preventDefault();
		});
	});


	/************** LightBox *********************/
	$(function(){
		$('[data-rel="lightbox"]').lightbox();
	});


})(window, jQuery);

