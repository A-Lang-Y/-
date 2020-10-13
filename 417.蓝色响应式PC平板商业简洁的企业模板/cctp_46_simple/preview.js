function set_frame_height(){
	var head_h = $('#header').outerHeight();

	//var h = 0;
	var win_h = $(window).height();
	var h = 0;

	// tablet
	if( $('body').hasClass('tablet') ) {
		var h_top = 62;
		var h_max = 781;
	} else if( $('body').hasClass('mobile') ) {
		var h_top = 72;
		var h_max = 504;
	}

	h = win_h - h_top;
	h = h > h_max ? h_max : h;	

	if( !$('body').hasClass('tablet') && !$('body').hasClass('mobile') ) {
		h = win_h;
	}
	
	$('#frame').height( h );
}
function change_template(src){
	var start_x = 50;
	var end_x = 180;
	$('#loading').show().stop(true, true).animate({'left' : end_x}, function(){
		$('#frame').attr('src', src);
	});
	$('#frame').load(function(){
		$('#loading').animate({ 'left' : start_x });
	});
}

$(document).ready(function(){

	var hide_button = $('<span id="hide-button"></span>').appendTo("#customize");
	var loading = $('<div id="loading"><span>Loading...</span></div>').appendTo('#customize');
	var is_mobile_template = $('body').hasClass('mobile');

	set_frame_height();
	$(window).resize(function(){ set_frame_height(); });
	
	$('.colors ol li a').click(function(){
		$(this).parent().parent().find('a').removeClass('active');
		$(this).addClass('active');
		
		change_template($(this).attr('href'));
		return false;
	});
	$('a.color').click(function(){
		var last_ol = $('.colors > ul > li.active ol');
		$('.colors > ul > li').removeClass('active');
		$(this).parent().addClass('active');
		$(this).parent().find('ol').slideDown();
		last_ol.slideUp();
		$(this).parent().find('ol a').removeClass('active');
		$(this).parent().find('ol a').eq(0).addClass('active');
		change_template($(this).attr('href'));
		return false;
	});
	$('a.color:eq(0)').trigger('click');

	var initial_left = parseInt($('#customize').css('left'));

	$('#hide-button').live('click', function(){
		var container = $('#customize');
		var width = parseInt(container.outerWidth());
		if( !container.hasClass('hidden') ) {
			container.animate( {'left': -1*width+5});
			container.addClass('hidden');
		}else {
			container.removeClass('hidden');
			container.animate( {'left': initial_left });
		}
	});

	// responsive links
	$('.responsive a').live('click', function(){
		$('.responsive a').each(function(){
			$('body').removeClass( $(this).attr('rel') );	
			$(this).removeClass('active');
		});

		$('body').addClass( $(this).attr('rel') );
		$(this).addClass('active');

		set_frame_height();

		return false;
	});
	$('.responsive a:eq(0)').trigger('click');

	// add note if is mobile
	if( is_mobile_template ) {
		$('body').append('<div class="note">Please use Firefox or Chrome latest version to preview the mobile templates.</div>');
	}

	if( is_mobile() ) {
		$('body').removeClass('mobile');
		$('.note').remove();
		$('head').append('<meta name="viewport" content="width=device-width,user-scalable=no" />');
	}

});

function is_mobile() {
	return navigator.userAgent.indexOf('iPhone') != -1 || navigator.userAgent.indexOf('iPod') != -1 || navigator.userAgent.indexOf('iPad') != -1 || navigator.userAgent.indexOf('Android') != -1 || navigator.userAgent.indexOf('Zune') != -1;
}