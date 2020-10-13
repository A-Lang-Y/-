/*
 * simpleWeather
 * 
 * A simple jQuery plugin to display the weather information
 * for a location. Weather is pulled from the public Yahoo!
 * Weather feed via their api.
 *
 * Developed by James Fleeting <hello@jamesfleeting.com>
 * Another project from monkeeCreate <http://monkeecreate.com>
 *
 * Version 2.0.1 - Last updated: January 26 2012
 */
(function($) {
	"use strict";
	$.extend({
		simpleWeather: function(options){
			options = $.extend({
				zipcode: '76309',
				location: '',
				unit: 'f',
				success: function(weather){},
				error: function(message){}
			}, options);
			
			var now = new Date();
			
			var weatherUrl = 'http://query.yahooapis.com/v1/public/yql?format=json&rnd='+now.getFullYear()+now.getMonth()+now.getDay()+now.getHours()+'&diagnostics=true&callback=?&diagnostics=true&env=store%3A%2F%2Fdatatables.org%2Falltableswithkeys&q=';
			if(options.location !== '') {
				weatherUrl += 'select * from weather.forecast where location in (select id from weather.search where query="'+options.location+'") and u="'+options.unit+'"';
			} else if(options.zipcode !== '') {
				weatherUrl += 'select * from weather.forecast where location in ("'+options.zipcode+'") and u="'+options.unit+'"';
			} else {
				options.error("No location given.");
				return false;
			}
						
			$.getJSON(
				weatherUrl,
				function(data) {
					if(data !== null && data.query.results !== null) {
						$.each(data.query.results, function(i, result) {
							if (result.constructor.toString().indexOf("Array") !== -1) {
								result = result[0];
							}
														
							var currentDate = new Date();
							var sunRise = new Date(currentDate.toDateString() +' '+ result.astronomy.sunrise);
							var sunSet = new Date(currentDate.toDateString() +' '+ result.astronomy.sunset);
							
							if(currentDate>sunRise && currentDate<sunSet) {
								var timeOfDay = 'd'; 
							} else {
								var timeOfDay = 'n';
							}
							
							var compass = ['N', 'NNE', 'NE', 'ENE', 'E', 'ESE', 'SE', 'SSE', 'S', 'SSW', 'SW', 'WSW', 'W', 'WNW', 'NW', 'NNW', 'N'];
							var windDirection = compass[Math.round(result.wind.direction / 22.5)];
							
							if(result.item.condition.temp < 80 && result.atmosphere.humidity < 40) {
								var heatIndex = -42.379+2.04901523*result.item.condition.temp+10.14333127*result.atmosphere.humidity-0.22475541*result.item.condition.temp*result.atmosphere.humidity-6.83783*(Math.pow(10, -3))*(Math.pow(result.item.condition.temp, 2))-5.481717*(Math.pow(10, -2))*(Math.pow(result.atmosphere.humidity, 2))+1.22874*(Math.pow(10, -3))*(Math.pow(result.item.condition.temp, 2))*result.atmosphere.humidity+8.5282*(Math.pow(10, -4))*result.item.condition.temp*(Math.pow(result.atmosphere.humidity, 2))-1.99*(Math.pow(10, -6))*(Math.pow(result.item.condition.temp, 2))*(Math.pow(result.atmosphere.humidity,2));
							} else {
								var heatIndex = result.item.condition.temp;
							}
							
							if(options.unit === "f") {
								var tempAlt = Math.round((5.0/9.0)*(result.item.condition.temp-32.0));
							} else {
								var tempAlt = Math.round((9.0/5.0)*result.item.condition.temp+32.0);
							}
							
							var weather = {					
								title: result.item.title,
								temp: result.item.condition.temp,
								tempAlt: tempAlt,
								code: result.item.condition.code,
								todayCode: result.item.forecast[0].code,
								units:{
									temp: result.units.temperature,
									distance: result.units.distance,
									pressure: result.units.pressure,
									speed: result.units.speed
								},
								currently: result.item.condition.text,
								high: result.item.forecast[0].high,
								low: result.item.forecast[0].low,
								forecast: result.item.forecast[0].text,
								wind:{
									chill: result.wind.chill,
									direction: windDirection,
									speed: result.wind.speed
								},
								humidity: result.atmosphere.humidity,
								heatindex: heatIndex,
								pressure: result.atmosphere.pressure,
								rising: result.atmosphere.rising,
								visibility: result.atmosphere.visibility,
								sunrise: result.astronomy.sunrise,
								sunset: result.astronomy.sunset,
								description: result.item.description,
								thumbnail: "http://l.yimg.com/a/i/us/nws/weather/gr/"+result.item.condition.code+timeOfDay+"s.png",
								image: "http://l.yimg.com/a/i/us/nws/weather/gr/"+result.item.condition.code+timeOfDay+".png",
								tomorrow:{
									high: result.item.forecast[1].high,
									low: result.item.forecast[1].low,
									forecast: result.item.forecast[1].text,
									code: result.item.forecast[1].code,
									date: result.item.forecast[1].date,
									day: result.item.forecast[1].day,
									image: "http://l.yimg.com/a/i/us/nws/weather/gr/"+result.item.forecast[1].code+"d.png"
								},
								city: result.location.city,
								country: result.location.country,
								region: result.location.region,
								updated: result.item.pubDate,
								link: result.item.link
							};
							
							options.success(weather);
						});
					} else {
						if (data.query.results === null) {
							options.error("Invalid location given.");
						} else {
							options.error("Weather could not be displayed. Try again.");
						}
					}
				}
			);
			return this;
		}		
	});
})(jQuery);