jQuery(window).load(function() {
	var QSandAnimationStart = true;
	// get the action filter option item on page load
	var jQueryfilterType = jQuery('#filterOptions li.active a').attr('class');
	
	// get and assign the ourHolder element to the
	// jQueryholder varible for use later
	var jQueryholder = jQuery('ul.ourHolder');
  
  
	jQueryholder.find('li').each(function(i){
		if(jQuery(this).hasClass('clear')){
			jQuery(this).removeClass('clear');
		}
		var borderBool = false;
		borderBool = (($('body').width()>=748 && i!=0 && i!=1) || ($('body').width()<748 && i!=0));
		
		if(borderBool){
			if(!jQuery(this).hasClass('border_top')){
				jQuery(this).addClass('border_top');
			}
		}
		else {
			if(jQuery(this).hasClass('border_top')){
				jQuery(this).removeClass('border_top');
			}
		}	
	
		if((i+1) % 2 == 1) {
			jQuery(this).addClass('clear');
		}
	});

	// clone all items within the pre-assigned jQueryholder element
	var jQuerydata = jQueryholder.clone();
  
	
	// init services (set at first)
	servicesInit(true, jQueryholder, jQuerydata, jQueryfilterType, jQueryfilterType);


	// page resize response
	$(window).resize(function() {
    resizeDelay(function(){
      jQuery('#filterOptions li.active a').trigger('click');
    }, 100);
	});

	// attempt to call Quicksand when a filter option
	// item is clicked
	jQuery('#filterOptions li a').click(function(e) {
	
		e.preventDefault();
		
		// reset the active class on all the buttons
		jQuery('#filterOptions li').removeClass('active');
		
		// assign the class of the clicked filter option
		// element to our jQueryfilterType variable
		var jQueryfilterType = jQuery(this).attr('class');
		jQuery(this).parent().addClass('active');
		
		servicesInit(false, jQueryholder, jQuerydata, jQueryfilterType, jQueryfilterType);
	});
});

var resizeDelay = (function(){
  var timer = 0;
  return function(callback, ms){
    clearTimeout (timer);
    timer = setTimeout(callback, ms);
  };
})();


function  servicesInit(QSandInit, jQueryholder, jQuerydata, jQueryfilterType, jQueryfilterType) {
	
	if (jQueryfilterType == 'all') {
		// assign all li items to the jQueryfilteredData var when
		// the 'All' filter option is clicked
		var jQueryfilteredData = jQuerydata.find('li');
	} 
	else {
		// find all li elements that have our required jQueryfilterType
		// values for the data-type element
		var jQueryfilteredData = jQuerydata.find('li[data-type~="' + jQueryfilterType + '"]');
		
	}
	jQueryfilteredData.each(function(i){
			if(jQuery(this).hasClass('clear')){
				jQuery(this).removeClass('clear');
			}
			if((i+1) % 2 == 1) {
				jQuery(this).addClass('clear');
			}
			
			var borderBool = false;
			borderBool = (($('body').width()>=752 && i!=0 && i!=1) || ($('body').width()<752 && i!=0));
			if(borderBool){
				if(!$(this).hasClass('border_top')){
	  				$(this).addClass('border_top');
				}
			}
			else {
				if($(this).hasClass('border_top')){
	  				$(this).removeClass('border_top');
					jQueryholder.find('li[data-id=' + $(this).attr('data-id') + ']').removeClass('border_top');
				}
			}	
	
		});
	if(!QSandInit){
		// call quicksand and assign transition parameters
		jQueryholder.quicksand(jQueryfilteredData, {
			adjustHeight: 'dynamic',
			duration: 800,
			easing: 'easeInOutQuad'
		}, function(){
			conButtonsInit();
			connectImage();
			blogImageHover();
		});
	}
	else {
		// call quicksand and assign transition parameters
		jQueryholder.quicksand(jQueryfilteredData, {
			duration: 1
		}, function(){
			conButtonsInit();
			connectImage();
			blogImageHover();
		});
	}
	return 
	
}
