jQuery.noConflict()(function($){

$(document).ready(function($) {

/*----------------------------------------YDCOZA----------------------------------------*/
/*    GMaps  */
/*--------------------------------------------------------------------------------------*/

          var map = new GMaps({
          div: "#map_canvas",
          lat: -33.924845,  // Center The Map with this Lat
          lng: 18.440000,   // Center The Map with this lng
          zoom: 15, 
          zoomControl : true,
          zoomControlOpt: {
            style : "SMALL",
            position: "TOP_LEFT"
          },
          panControl : true,
          streetViewControl : false,
          mapTypeControl: true,
          overviewMapControl: false
        });
        

      map.addMarker({
          lat: -33.926000, // Marker Position
          lng: 18.428000,  // Marker Position
          infoWindow: {
          content: '<p>Castle of Good Hope, Cape Town</p>'
        }
      });


        var styles = [
          {
            stylers: [
              { hue: "#4D3F61" },
              { saturation: -40 },
              { lightness: 20 },
            ]
          },{
            featureType: "road",
            elementType: "geometry",
            stylers: [
              { lightness: 100 },
              { visibility: "simplified" }
            ]
          },{
            featureType: "road",
            elementType: "labels",
            stylers: [
              { visibility: "off" }
            ]
          }
        ];

        
        map.addStyle({
            styledMapName:"Styled Map",
            styles: styles,
            mapTypeId: "map_style"  
        });
        
        map.setStyle("map_style");




    }); //Doc Ready
}); // No Conflict