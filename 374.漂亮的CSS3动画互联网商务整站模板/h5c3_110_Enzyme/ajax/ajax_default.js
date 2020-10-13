// This function gets the correct Ajax object based on the browser
function Getxmlhttp()
{
	var xmlhttp = false;
	
	try {
		xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
	} catch (e) {
		try {
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		} catch (E) {
			xmlhttp = false;
		}
	}
	
	if(!xmlhttp && typeof XMLHttpRequest != 'undefined') {
		xmlhttp = new XMLHttpRequest();
	}
	
	return xmlhttp;
}

// This function creates a function to an external page and
// creates the default response
function Makerequest(objID,serverPage)
{
	// acquire the correct AJAX object
	var xmlhttp = Getxmlhttp();
	// Open the server page
	xmlhttp.open("GET", serverPage);
	xmlhttp.onreadystatechange = function() {
		if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			obj.innerHTML = xmlhttp.responseText;
			
		}
	};
	// Send the request
	xmlhttp.send(null);
}
