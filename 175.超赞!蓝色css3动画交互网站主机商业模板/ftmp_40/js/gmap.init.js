$('#google_map').gmap3(
	{ action:'init',
		options:{
			center:[40.710443,-73.993996],
			address: "Manhattan, NY 10002 30 ft N",
			zoom: 16
		}
	},
	{ action: 'addMarkers',
		markers:[
			{lat:40.710443, lng:-73.993996, data:'Manhattan, NY 10002 30 ft N'}
		],
		marker:{
			options:{
				draggable: false,
				icon:new google.maps.MarkerImage("images/icons/Flag2LeftRed.png", new google.maps.Size(64, 64))
			},
			events:{
				click: function(marker, event, data){
					alert(data);
				}
			}
		}
	}
);
