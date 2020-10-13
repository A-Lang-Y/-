"use strict";

jQuery(document).ready(function($){

	/************** Background Polygon Drawing *********************/

	var canvas = document.createElement("canvas");
	canvas.width = 894;
	canvas.height = 854;
	if (canvas && canvas.getContext) {
		var ctx = canvas.getContext("2d");
		if (ctx) {
			ctx.fillStyle = "#383e42";
			ctx.beginPath();
			ctx.moveTo(0,470);
			ctx.lineTo(223,82);
			ctx.lineTo(670,82);
			ctx.lineTo(894,470);
			ctx.lineTo(670,854);
			ctx.lineTo(223,854);
			ctx.fill();
		}
	}
    	
	$('body').css({'background-image':"url(" + canvas.toDataURL("image/png")+ ")" }); 
	$('body').css({'background-repeat':"no-repeat" });
	$('body').css({'background-position':"center top" });
	$(".overlay").hide();
	
	/************** Gallery Hover Effect *********************/

	$(".overlay").hide();

	$('.gallery-item, .team-item').hover(
	  function() {
	    $(this).find('.overlay').addClass('animated fadeIn').show();
	  },
	  function() {
	    $(this).find('.overlay').removeClass('animated fadeIn').hide();
	  }
	);

	/************** LightBox *********************/
	$(function(){
		$('[data-rel="lightbox"]').lightbox();
	});
});

/************** Google Map *********************/

function loadScript() {
  var script = document.createElement('script');
  script.type = 'text/javascript';
  script.src = 'https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&' +
      'callback=initialize';
  document.body.appendChild(script);
}

function initialize() {
    var mapOptions = {
      zoom: 14,
      center: new google.maps.LatLng(16.8496189,96.1288854)
    };
    var map = new google.maps.Map(document.getElementById('templatemo_map'),  mapOptions);
}

/************** Pagination *********************/
function pagination_click(event)
{
	if( event.data.page_no == 1 )
	{
		$('#page1').slideDown();
		$('#page2').hide();
		$('#page3').hide();

		$('#page_link_1').addClass('active');
		$('#page_link_2').removeClass('active');
		$('#page_link_3').removeClass('active');
	}
	else if( event.data.page_no == 2 )
	{
		$('#page2').slideDown();
		$('#page1').hide();    		
		$('#page3').hide();

		$('#page_link_2').addClass('active');
		$('#page_link_1').removeClass('active');
		$('#page_link_3').removeClass('active');
	}
	else 
	{
		$('#page3').slideDown();
		$('#page1').hide();
		$('#page2').hide();

		$('#page_link_3').addClass('active');
		$('#page_link_1').removeClass('active');
		$('#page_link_2').removeClass('active');
	}
}