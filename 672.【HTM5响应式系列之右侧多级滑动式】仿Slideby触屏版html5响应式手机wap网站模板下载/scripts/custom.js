// JavaScript Document

$(document).ready(function(){
	
	$('.close-nav, .sidebar-close').click(function(){
		snapper.close();
		return false;
	});
	
	$('.submenu-deploy').click(function(){
		$(this).parent().find('.nav-item-submenu').toggle(100);
		$(this).find('em').toggleClass('dropdown-nav');
		return false;
	});
	
	
	var snapper = new Snap({
	  element: document.getElementById('content')
	});

	$('.deploy-sidebar').click(function(){
		//$(this).toggleClass('remove-sidebar');
		if( snapper.state().state=="left" ){
			snapper.close();
		} else {
			snapper.open('left');
		}
		return false;
	});

	
});