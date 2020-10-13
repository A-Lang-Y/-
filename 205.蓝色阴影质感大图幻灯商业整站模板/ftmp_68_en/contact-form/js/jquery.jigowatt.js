jQuery(document).ready(function(){


	$('#contactform').submit(function(){

		var action = $(this).attr('action');

		$('#submit').attr('disabled','disabled').after('<img src="contact-form/assets/ajax-loader.gif" class="loader" />');

		$("#message").slideUp(750,function() {
		$('#message').hide();

		$.post(action, {
			name: $('#name').val(),
			email: $('#email').val(),
			phone: $('#phone').val(),
			comments: $('#comments').val(),
			verify: $('#verify').val()
		},
			function(data){
				document.getElementById('message').innerHTML = data;
				$('#message').slideDown('slow');
				$('#contactform img.loader').fadeOut('fast',function(){$(this).remove()});
				$('#submit').removeAttr('disabled');
				if(data.match('success') != null) $('#contactform').slideUp('slow');
				
				// 2 functions added by TrueThemes
				if(data.match('success') != null) $("html,body").animate({
					scrollTop: $("#message").offset().top
					}, 1000, function(){
						//scroll complete function
					});
				if(data.match('success') == null) $("html,body").animate({
					scrollTop: $("#message").offset().top
					}, 1000, function(){
						//scroll complete function
					});
				
				

			}
		);

		});

		return false;

	});

});