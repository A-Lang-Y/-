
$(window).load(function() { 
	$("#loader").fadeOut();				
});

$(function(){

	//---------------------------------------------------------------------- mmenu
	$('nav#menu').mmenu({
		searchfield : true,
		slidingSubmenus: true
	});

	
	//---------------------------------------------------------------------- BANNER SLIDER
	if($(".flexslider").length != 0) {
		$('.flexslider').flexslider({
			animation: "slide",
			start: function(slider){
			  $('body').removeClass('loading');
			}
		});
	}
				
	//---------------------------------------------------------------------- Gallery
	if($("#Gallery").length != 0) {
		$("#Gallery a").photoSwipe();
	}
	
	
	//---------------------------------------------------------------------- ABOUT
	$(".o-team-person").click(function(){
		if($(this).hasClass("active"))
		{
			$(".o-person-details").slideUp(500);
			$(".o-team-person").removeClass("active").removeClass("opacity50");
			return false;
		}
		$(".o-team-person").removeClass("active").addClass("opacity50");
		var self = $(this);
		$(this).addClass("active");
		$(".o-person-details").slideUp(500, function(){

			$(".o-person-details").html(self.find(".o-person-content").html());
			$(".o-person-details").slideDown(500);
			
				// Easy-pie-chart
				$('.o-person-details .chart.green').easyPieChart({
					animate: 2500,
					scaleColor: false,
					lineWidth : 5,
					trackColor : "#efefef",
					barColor : "#93af53",
					size : 85
				});
				
				$('.o-person-details .chart.orange').easyPieChart({
					animate: 2500,
					scaleColor: false,
					lineWidth : 5,
					trackColor : "#efefef",
					barColor : "#dfa654",
					size : 85
				});
				
				$('.o-person-details .chart.red').easyPieChart({
					animate: 2500,
					scaleColor: false,
					lineWidth : 5,
					trackColor : "#efefef",
					barColor : "#ff756f",
					size : 85
				});
			$("body.o-page").animate({ scrollTop: $('#o-person-details-pane').offset().top -20 }, 600);
		});
	});

	
    /* ---------------------------------------------------------------------- */
	/*	Contact Map
	/* ---------------------------------------------------------------------- */
	var contact = {"lat":"42.672421", "lon":"21.16453899999999"}; //Change a map coordinate here!

	try {
		$('#map').gmap3({
		    action: 'addMarker',
		    latLng: [contact.lat, contact.lon],
		    map:{
		    	center: [contact.lat, contact.lon],
		    	zoom: 14
		   		},
		    },
		    {action: 'setOptions', args:[{scrollwheel:true}]}
		);
	} catch(err) {

	}
	
	
	/* ---------------------------------------------------------------------- */
	/*	Contact Form
	/* ---------------------------------------------------------------------- */
	$('#SubmitContact').on('click', function(e){
		e.preventDefault();

		$this = $(this);
		
		$.ajax({
			type: "POST",
			url: 'contact.php',
			dataType: 'json',
			cache: false,
			data: $('#contact').serialize(),
			success: function(data) {
				if(data.info != 'error'){
					$this.parents('form').find('input[type=text],textarea,select').filter(':visible').val('');
					$('#msg').hide().removeClass('success').removeClass('error').addClass('success').html(data.msg + "<i></i>").fadeIn('slow').delay(5000).fadeOut('slow');
				} else {
					$('#msg').hide().removeClass('success').removeClass('error').addClass('error').html(data.msg + "<i></i>").fadeIn('slow').delay(5000).fadeOut('slow');
				}
			}
		});
	});

	
});


