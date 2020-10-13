
$(window).load(function() { 
	$("#loader").fadeOut();				
});

$(function(){

	function windowResize()
	{
	
		if($(window).height() <= 300)
			$("body").addClass("smallHeight");
		else
			$("body").removeClass("smallHeight");
		
		//If landscape
		if($(window).height() <= $(window).width())
			$("body").addClass("p-landscape");
		else
			$("body").removeClass("p-landscape");
			
		var homeHeight = parseInt($("#Logo").width() /2) * -1;
		$(".home-content").css({'margin-top': homeHeight});
		
	}
	
	windowResize();
	setTimeout(function(){
        windowResize();
    }, 1000);
	
	$(window).resize(function() {
		windowResize();
	});
		
	$(window).scroll(function() {
		if ($(this).scrollTop() >= 100) { 
			$("body").addClass("p-scrolling");    
		}
		else
		{
			$("body").removeClass("p-scrolling");
		}
	});

	//---------------------------------------------------------------------- mmenu
	$('nav#menu').mmenu({
		 searchfield : false,
		 slidingSubmenus: true,
         position: "top",
         zposition: "front"
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
	$(".about-openBtn").click(function(){
		var self = $(this);
		
		if(self.hasClass("active"))
		{
			self.parent().find(".o-person-content").slideUp(500);
			self.removeClass("active").find('i').removeClass("fa-minus");
			return false;
		}
		
		self.addClass("active").find('i').addClass("fa-minus");
		self.parent().find(".o-person-content").slideDown(500);
			
		// Easy-pie-chart
			self.parent().find(".chart.red").easyPieChart({
			animate: 2500,
			scaleColor: false,
			lineWidth : 3,
			trackColor : "#efefef",
			barColor : "#EA2424",
			size : 75
		});
		
		$("body.o-page").animate({ scrollTop: self.parent().offset().top -80 }, 600);
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


