/*
 *  * .Author Name: Satish Pokharel.
 *  * 
 *  * .Author Company: http://www.mojo-themes.com/user/rel-studios/
 *  * 
 *  * .Theme Name: Selroti Premium Neplease Best Theme.
 *  * 
 *  * .Description: Selroti is a premium theme for protfolio and business use.
 *  * 
 *  * .Author URI: http://www.fortystones.com/spstudios/themes 
 *  */

/* If you want to modify the javascript of this theme first of all please go through the detail documentation of this theme.Otherwise sky will fall in your head :p
 *  */
 
jQuery(document).ready(function() {
	jQuery("a[data-gal^='prettyPhoto']").prettyPhoto({theme:'light_rounded'}); //choose between different styles / dark_rounded / light_rounded / dark_square / light_square..
	
/*-----------------------------------------------------------------------------------*/
/*	Superfish Settings - http://users.tpg.com.au/j_birch/plugins/superfish/
/*-----------------------------------------------------------------------------------*/
	
	if(jQuery().superfish) {
		
		// Main Navigation
		jQuery('nav ul.sf-menu').superfish({ 
			delay: 200, // change the speed of the dropdown
			animation: {opacity:'show', height:'show'},
			speed: 'fast',
			dropShadows: false //turn on or off shadows
		});
		
		jQuery('nav li li a').hover(
			function () {
				jQuery(this).find('span').not('span.sf-sub-indicator').stop().animate({paddingLeft: 20}, 200, 'jswing'); 
			},
			function () {
				jQuery(this).find('span').not('span.sf-sub-indicator').stop().animate({paddingLeft: 0}, 200, 'jswing');
			}
		);
	
	}
	

/*-----------------------------------------------------------------------------------*/
/*	Crausol Fred
/*-----------------------------------------------------------------------------------*/  

	
	// Hover effect of recent-works 
	jQuery('.hover').css('opacity','0');
	jQuery('.hover').hover(
		function() {
			//console.log(this);
			jQuery(this).addClass('current_project');
			jQuery('.current_project').stop().animate({opacity: 1}, 350);
			
	},	function () {
			jQuery('.current_project').stop().animate({opacity: 0}, 350);
			jQuery('.current_project').removeClass('current_project');
		}
	);
	
	
	jQuery('ul.social-icons li a img, .scroll-top').css('opacity', '0.7'); //set every social icon opacity to 0.6
	jQuery('ul.social-icons li a img, .scroll-top').hover(
		function() {
			//console.log(this);
			jQuery(this).stop().animate({opacity: 1}, 350);
		}, function() {
			jQuery(this).stop().animate({opacity: .7}, 350);
		}
	);
	
	//Flickr, Some other fade option
	jQuery('.flickr-widget ul ').children().hover(
		function() {
			jQuery(this).siblings().stop().fadeTo(600, 0.6);
		}, function() {
			jQuery(this).siblings().stop().fadeTo(600, 1);
		}
	);
	
	
	jQuery('.filterable-list ul li a').click(function() {
		jQuery(this).css('outline','none');
		jQuery('.filterable-list ul .current').removeClass('current');
		jQuery(this).parent().addClass('current');

		var filterVal = jQuery(this).text().toLowerCase().replace(' ','-');

		if(filterVal == 'all') {
			jQuery('ul.portfolio-list li.hidden').fadeIn('slow').removeClass('hidden');
		} else {
			jQuery('ul.portfolio-list li').each(function() {
				if(!jQuery(this).hasClass(filterVal)) {
					jQuery(this).fadeOut('normal').addClass('hidden');
				} else {
					jQuery(this).fadeIn('slow').removeClass('hidden');
				}
			});
		}

		return false;
	});

	jQuery('.scroll-top').click(
		function () {
			jQuery('body,html').animate({
				scrollTop: 0
			}, 800);
		return false;
		}
	);
		
});
