$(document).ready(function(){

var bgColor;
var effect = 'animated bounceInLeft'; /* bounceIn, bounceInUp, bounceInDown, bounceInLeft,
										 bounceInRight, rotateIn, rotateInUpLeft, rotateInDownLeft,
										 rotateInUpRight, rotateInDownRight  */

$('.all-content').hide();

/**
*
* Click list
*
**/
$('.a_content li').click(function(){

	/* Hide Card Front & Card Back from all lists */
	$('.card-front, .card-back').hide();

	/* Remove Class active, Hide and Adding border: none to the lists */
	$('.a_content li').removeClass('active').hide().css('border','none');
	$(this).addClass('active').show();

	/* Get Background Color */
	bgColor = $('.active .card-back').css('background-color');
	$('.content').css('background-color',bgColor);

	/* Show Close Element & Content of list */
	$('.close, .all-content').show();

	/* Append close element and Add CSS effect "bounceInLeft"*/
	$('.responsive').append('<span class="close">close</span>').addClass(effect);

});


/**
*
* Close element
*
**/
$('.responsive').on('click', '.close', function(){

	/* Remove close button */
	$('.close').remove();

	/* Get Background Color */
	bgColor = $('.active .card-front').css('background-color');

	/* Remove animation effect from ul.content */
	$('.responsive').removeClass(effect);

	/* Hide Close Element & Content of list */
	$('.all-content').hide();

	/*  Remove "active" class from all lists and adding "bounceInLeft" */
	$('.a_content li').removeClass('active').show().css({ 'border-bottom':'1px solid #2c2c2c',
													    'border-left':'1px solid #2c2c2c' });

	$('.card-front, .card-back').show();
	$('.content').css('background-color',bgColor);
	
});


});