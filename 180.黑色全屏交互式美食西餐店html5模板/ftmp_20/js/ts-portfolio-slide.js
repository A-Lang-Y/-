jQuery(document).ready(function () {
	//sliding box
	jQuery('.ts-display-pf-img').hover(function(){

		jQuery(".cover", this).stop().animate({top:'380px', left:'0px'},{queue:false,duration:800});

	}, function() {

		jQuery(".cover", this).stop().animate({top:'0px', left:'0px'},{queue:false,duration:800});

	});
});
