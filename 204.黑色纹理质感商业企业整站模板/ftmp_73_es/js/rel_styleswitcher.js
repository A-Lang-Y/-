/*
 * .Author Name: Satish Pokharel.
 * 
 * .Author Company: RelStudios. 
 * 
 * .Theme Name: Selroti Premium Neplease Best Theme.
 * 
 * .Description: Selroti is a premium theme for protfolio and business use.
 * 
 * .Author URI: 
 */

/* If you want to modify the js of this theme  first of all please go through the detail documentation of this theme. Otherwise sky will fall in your head :p
 */
 
jQuery(document).ready(function() {
	jQuery('body').append('<div class="rel-styleswitcher-wrapepr"><div class="rel-stylechanger"><div class="rel-changer-inner"><span>Color Options</span><div id="rel-switcher"><a href="#" class="style-option option-one" id="orange"></a><a href="#"  class="style-option option-two" id="green"></a><a href="#"  class="style-option option-three" id="lightblue"></a><a href="#"  class="style-option option-four" id="red"></a></div></div></div><div class="rel-sliding"></div></div>');
	
		jQuery('.rel-sliding').click(function() {
		if (jQuery(this).parent().css('left') == '-148px') {
			jQuery(this).parent().animate({
				"left": "0"
			}, 300);
		} else {
			jQuery(this).parent().animate({
				"left": "-148px"
			}, 300);
		}
	});
	
	var rel_path = 'css/';
	jQuery('#orange').click(function() {
		jQuery('#changer').attr('href', rel_path + 'orange' + '.css');
		jQuery('body').find('.lightblue').removeClass('lightblue').addClass('orange');
		jQuery('#path').attr('src','template_images/orange/logo-footer.png');
	});
	
	jQuery('#green').click(function() {
		jQuery('#changer').attr('href', rel_path + 'green' + '.css');		
		jQuery('body').find('.orange').removeClass('orange').addClass('buttons green');
		jQuery('#path').attr('src','template_images/green/logo-footer.png');
		
	});
	
	jQuery('#lightblue').click(function() {
		jQuery('#changer').attr('href', rel_path + 'style' + '.css');
		jQuery('body').find('.green').removeClass('green').addClass('lightblue');
		jQuery('#path').attr('src','template_images/logo-footer.png');
		
	});
	
	jQuery('#red').click(function() {
		jQuery('#changer').attr('href', rel_path + 'red' + '.css');
		jQuery('body').find('.lightblue').removeClass('lightblue').addClass('red');
		jQuery('#path').attr('src','template_images/red/logo-footer.png');
		
	});
	
	
	
});
	
	
