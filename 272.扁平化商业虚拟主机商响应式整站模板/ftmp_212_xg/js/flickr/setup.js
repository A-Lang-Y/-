$(document).ready(function(){

	$('#fbox').jflickrfeed({
		limit: 6,
		qstrings: {
			id: '37304598@N02'
		},
		itemTemplate: '<li>'+
						'<a rel="photo_gallery" href="{{image}}" title="{{title}}">' +
							'<img src="{{image_s}}" alt="{{title}}" />' +
						'</a>' +
					  '</li>'
	}, function(data) {
		$('#fbox a').fancybox();
	});	
	
});