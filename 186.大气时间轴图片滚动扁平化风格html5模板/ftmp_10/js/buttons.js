 $(window).load(function() {
 	conButtonsInit();
});

function conButtonsInit() {
	
	var w;
	$("a.con_button2").each(function(){
		w = $(this).width();
		$(this).find('.con_button_arrow').css({'left': w+'px'});
		$(this).find('.con_button_text').css({ 'margin-left': '0px', 'padding-right': '10px'});
	});
	
	$("a.con_button1").hover(function() {
		$(this).find('.con_button_arrow').stop().animate({ width: "100%"}, 400);},
	function() {
		$(this).find('.con_button_arrow').stop().animate({ width: "20px" }, 300);
	});
	$("a.con_button2").hover(function() {
		w = $(this).width();
		$(this).find('.con_button_text').stop().animate({ marginLeft: -w, paddingRight: w+10}, 400);
		$(this).find('.con_button_arrow').stop().animate({ left: "0"}, 400);},
	function() {
		w = $(this).width();
		$(this).find('.con_button_arrow').stop().animate({ left: w }, 300);
		$(this).find('.con_button_text').stop().animate({ marginLeft: 0, paddingRight: 10}, 300);
	});
}


function commentFormSubmit() {
	$("#submit").click()
}