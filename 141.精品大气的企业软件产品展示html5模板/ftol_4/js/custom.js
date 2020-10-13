$(document).ready(function() {
                    
	$('li.parent').hover(function() {
		if($(this).find('> ul').css('display') == "none"){
			$(this).find('> ul').slideDown(200);
			slide = true;
		}
	}, function() {
		if(slide == true){
			$(this).find('> ul').slideUp();
			slide = false;
		}
	});     

	$('nav strong').click(function() {        
       $('nav ul').toggle();
    });     
  
});