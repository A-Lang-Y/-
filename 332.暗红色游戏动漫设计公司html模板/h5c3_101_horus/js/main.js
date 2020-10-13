$(document).ready(function(){

<!-- Function for ddsmoothmenu-->
ddsmoothmenu.init({
 mainmenuid: "smoothmenu1", //menu DIV id
 orientation: 'h', //Horizontal or vertical menu: Set to "h" or "v"
 classname: 'ddsmoothmenu', //class added to menu's outer DIV
 //customtheme: ["#1c5a80", "#18374a"],
 contentsource: "markup" //"markup" or ["container_id", "path_to_menu_file"]
})


$('.ddsmoothmenu').mobileMenu({
	defaultText: 'Navigation',
	className: 'select-menu',
	subMenuDash: '&ndash;'
});

			$("#tweets").tweet({
			count: 2,	
			username: "envato"
			});

			$('#flickr').jflickrfeed({
			limit: 9,
			qstrings: {
				id: '52617155@N08'
			},
			itemTemplate: '<li><a href="{{image_b}}"><img src="{{image_s}}" alt="{{title}}" /></a></li>'
		});

$('#gotop').click(function () {
  $('html,body').animate({
    scrollTop: 0
  }, 1000);
  return false;
});


});
