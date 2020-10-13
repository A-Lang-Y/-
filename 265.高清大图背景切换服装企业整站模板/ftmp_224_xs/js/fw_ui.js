$(document).ready(function(){		
	/*Input and Textarea Click-Clear
	================================*/
	$('input[type=text]').focus(function() {
		if($(this).attr('readonly') || $(this).attr('readonly') == 'readonly') return false;
		if ($(this).val() === $(this).attr('title')) {
				$(this).val('');
		}   
		}).blur(function() {
		if($(this).attr('readonly') || $(this).attr('readonly') == 'readonly') return false;
		if ($(this).val().length === 0) {
			$(this).val($(this).attr('title'));
		}                        
	});	
	$('textarea').focus(function() {
		if ($(this).text() === $(this).attr('title')) {
				$(this).text('');
			}        
		}).blur(function() {
		if ($(this).text().length === 0) {
			$(this).text($(this).attr('title'));
		}                        
	});
	
	/*Activate PrettyPhoto
	=======================*/
	$('a.prettyPhoto').prettyPhoto();
	
	/*Toggles List
	===============*/
	$('ul.toggles').find('span').click(function(){
		$(this).parents('li').find('div.toggle_text').slideToggle();
		$(this).parents('li').toggleClass('act');
	});
	
	/*Accordion
	===========*/
	$( ".accordion" ).accordion();
	
	/*Image Inner Border*/
	$('img.bordered1').each(function(){
		curr_w = $(this).width();
		curr_h = $(this).height();
		$(this).css({'width' : (curr_w-6)+'px', 'height' : (curr_h-6)+'px'});
	});
	$('img.bordered1').hover(function(){
		$(this).stop().animate({'border-color' : '#61cdf5'});
	}, function(){
		$(this).stop().animate({'border-color' : '#eaeaea'});
	});	
});
