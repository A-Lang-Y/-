function ajaxobj() {
	var ajax = false;
	if (window.XMLHttpRequest) {
		ajax = new XMLHttpRequest();

		//alert(ajax);
		if (ajax.overrideMimeType) {
			ajax.overrideMimeType("text/xml");
		}
	} else {
		if (window.ActiveXObject) {
			var versions = ["Microsoft.XMLHTTP", "MSXML.XMLHTTP", "Microsoft.XMLHTTP", "Msxml2.XMLHTTP.7.0", "Msxml2.XMLHTTP.6.0", "Msxml2.XMLHTTP.5.0", "Msxml2.XMLHTTP.4.0", "MSXML2.XMLHTTP.3.0", "MSXML2.XMLHTTP"];
			ajax = new ActiveXObject("Microsoft.XMLHTTP");
			for (var i = 0; i < versions.length; i++) {
				try {
					ajax = new ActiveXObject(versions[i]);
					if (ajax) {
						break;
					}
				}
				catch (e) {
				}
			}
		}
	}
	if (!ajax) {
		//alert("Giving up :( Cannot create an XMLHTTP instance");
		return false;
	}
	return ajax;
}
function showCar() {
	var s = document.getElementById("serial");
	var car = document.getElementById("car");
	if (s.value == "" || s.value == "-1") {
		car.options.length = 0;
		var selectedValue = "-1";
		var selectedText = "\u8bf7\u9009\u62e9\u8f66\u578b";
		var newItem = new Option(selectedText, selectedValue);
		newItem.selected = "selected";
		car.options.add(newItem);
		return;
	}
	var data;
	$.ajax({
    	type : "get",  
     	async:false,  
     	url: "serial/ajaxCar.do?serialId=" + escape(s.value) + "&" + new Date(),  
     	dataType : "jsonp",
     	jsonp: "callbackparam",
     	jsonpCallback: "success_jsonpCallback",
     	contentType:"application/x-www-form-urlencoded; charset=UTF-8",
     	success : function(json){
		data=json.msg;     	
     	},
		error : function(){}
     	
});
	
	
	//var ajax = null;
	//var url = "serial/ajaxCar.do?serialId=" + escape(s.value) + "&" + new Date();
	//ajax = ajaxobj();
	//ajax.dataType : "jsonp";
    //ajax.jsonp: "callbackparam";
	//ajax.open("GET", url, false);//同步
	//ajax.send(null);
	//var data = ajax.responseText;
	if (data.indexOf(",") >= 0) {
		var arr = new Array();
		var arr = data.split(",");
		car.options.length = 0;
		var selectedValue = "-1";
		var selectedText = "\u8bf7\u9009\u62e9\u8f66\u578b";
		var newItem = new Option(selectedText, selectedValue);
		car.options.add(newItem);
		for (var i = 0; i < arr.length; ) {
			if (arr[i] == "") {
				break;
			}
			var selectedValue = arr[i];
			var selectedText = arr[i + 1];
			var newItem = new Option(selectedText, selectedValue);
			car.options.add(newItem);
			i = i + 2;
		}

			    //获取选择的值   
	} else {
		car.options.length = 0;
		var selectedValue = "-1";
		var selectedText = "\u8bf7\u9009\u62e9\u8f66\u578b";
		var newItem = new Option(selectedText, selectedValue);
		newItem.selected = "selected";
		car.options.add(newItem);
		return;
	}
}


 function showBrand1(brandId,serialId) {
	var brand = document.getElementById(brandId);
	var corp = document.getElementById(serialId);
	brand.options.length = 0;
	var selectedValue = "-1";
	var selectedText = "\u8bf7\u9009\u62e9\u54c1\u724c";
	var newItem = new Option(selectedText, selectedValue);
	brand.options.add(newItem);
	var count = 1;
	var index = "A";
	corp.options.length = 0;
	var newItem1 = new Option("\u8bf7\u9009\u62e9\u7cfb\u5217", "-1");
	corp.options.add(newItem1);
	for (var i = 0; i < brandMods.length; i++) {
		var selectedValue = brandMods[i].i;
		var selectedText = brandMods[i].n;
		var newItem = new Option(selectedText, selectedValue);
		if (index != brandMods[i].n.substring(0, 1)) {
			count++;
			index = brandMods[i].n.substring(0, 1);
		}
		if (count % 2 == 0) {
			newItem.className = "opt_red";
		}
		brand.options.add(newItem);
	}
};
function showCorp1(brandId,serialId,carId) {
	var b = document.getElementById(brandId);
	var obj = document.getElementsByTagName("optgroup");
	var corp = document.getElementById(serialId);
	var car = document.getElementById(carId);
	while (corp.firstChild) { //判断是否有子节点
	corp.removeChild(corp.firstChild);
	}
	if (b.value == "" || b.value == "-1") {
		while (corp.firstChild) { //判断是否有子节点
		corp.removeChild(corp.firstChild);
		}
		corp.options.length = 0;
		var selectedValue = "-1";
		var selectedText = "\u8bf7\u9009\u62e9\u7cfb\u5217";
		var newItem = new Option(selectedText, selectedValue);
		newItem.selected = "selected";
		corp.options.add(newItem);
		car.options.length = 0;
		var selectedValue2 = "-1";
		var selectedText2 = "\u8bf7\u9009\u62e9\u8f66\u578b";
		var newItem2 = new Option(selectedText2, selectedValue2);
		newItem2.selected = "selected";
		car.options.add(newItem2);
		return;
	}
	var serial = new Array();
	for (var i = 0; i < brandMods.length; i++) {
		if (b.value == brandMods[i].i) {
			serial = brandMods[i].s;
		}
	}
	if (serial.length > 0) {
		for (var i = 0; i < obj.length; i++) {
			corp.removeChild(obj[i]);
		}
		corp.options.length = 0;
		var selectedValue = "-1";
		var selectedText = "\u8bf7\u9009\u62e9\u7cfb\u5217";
		var newItem = new Option(selectedText, selectedValue);
		corp.options.add(newItem);
		car.options.length = 0;
		var selectedValue2 = "-1";
		var selectedText2 = "\u8bf7\u9009\u62e9\u8f66\u578b";
		var newItem2 = new Option(selectedText2, selectedValue2);
		newItem2.selected = "selected";
		car.options.add(newItem2);
		for (var i = 0; i < serial.length; i++) {
			var group = document.createElement("optgroup");
			group.label = serial[i].n;
			group.id = "optgroup" + i;
			group.className = "opt_red";
			corp.appendChild(group);
			var bss = serial[i].b;
			for (var j = 0; j < bss.length; j++) {
				//var selectedValue = bss[j].i;
				//var selectedText = bss[j].n;
				//var newItem = new Option(selectedText, selectedValue);
				//corp.options.add(newItem);
				var newItem = new Option();
				newItem.value=bss[j].i;
				newItem.innerHTML = "&nbsp;&nbsp;" + bss[j].n;
				corp.appendChild(newItem);
			}
		}
	} else {
		corp.options.length = 0;
		var selectedValue = "-1";
		var selectedText = "\u8bf7\u9009\u62e9\u7cfb\u5217";
		var newItem = new Option(selectedText, selectedValue);
		newItem.selected = "selected";
		corp.options.add(newItem);
		car.options.length = 0;
		var selectedValue2 = "-1";
		var selectedText2 = "\u8bf7\u9009\u62e9\u8f66\u578b";
		var newItem2 = new Option(selectedText2, selectedValue2);
		newItem2.selected = "selected";
		car.options.add(newItem2);
		return;
	}
}
function showCorp(brandId,serialId) {
	var b = document.getElementById(brandId);
	var obj = document.getElementsByTagName("optgroup");
	var corp = document.getElementById(serialId);
	
	while (corp.firstChild) { //判断是否有子节点
	corp.removeChild(corp.firstChild);
	}
	if (b.value == "" || b.value == "-1") {
		while (corp.firstChild) { //判断是否有子节点
		corp.removeChild(corp.firstChild);
		}
		corp.options.length = 0;
		var selectedValue = "-1";
		var selectedText = "\u8bf7\u9009\u62e9\u7cfb\u5217";
		var newItem = new Option(selectedText, selectedValue);
		newItem.selected = "selected"; 
		corp.options.add(newItem);
		return;
	}
	var serial = new Array();
	for (var i = 0; i < brandMods.length; i++) {
		if (b.value == brandMods[i].i) {
			serial = brandMods[i].s;
		}
	}
	if (serial.length > 0) {
		corp.options.length = 0;
		var selectedValue = "-1";
		var selectedText = "\u8bf7\u9009\u62e9\u7cfb\u5217";
		var newItem = new Option(selectedText, selectedValue);
		corp.options.add(newItem);
		for (var i = 0; i < serial.length; i++) {
			var group = document.createElement("OPTGROUP");
			group.label = serial[i].n;
			group.id = "optgroup" + i;
			group.className = "opt_red";
			corp.appendChild(group);
			var bss = serial[i].b;
			for (var j = 0; j < bss.length; j++) {
				//var selectedValue = bss[j].i;
				//var selectedText = bss[j].n;
				//var newItem = new Option(selectedText, selectedValue);
				//group.appendChild(newItem);
				var newItem = new Option();
				newItem.value=bss[j].i;
				newItem.innerHTML = "&nbsp;&nbsp;" + bss[j].n;
				corp.appendChild(newItem);
			}
		}
	} else {
		corp.options.length = 0;
		var selectedValue = "-1";
		var selectedText = "\u8bf7\u9009\u62e9\u7cfb\u5217";
		var newItem = new Option(selectedText, selectedValue);
		newItem.selected = "selected";
		corp.options.add(newItem);
		return;
	}
}
function searchSerial() {
	var brand = document.getElementById("brand");
	var serial = document.getElementById("serial");

	if(serial.value == "" || serial.value == "-1") {
		if (brand.value == "" || brand.value == "-1") {
			window.open("http://car.auto.ifeng.com/series/2593", "_blank");
		} else {
			window.open("http://data.auto.ifeng.com/price/b-"+ brand.value+"-1-1.html", "_blank");
		}
	} else {
		window.open("http://car.auto.ifeng.com/series/" + serial.value, "_blank");
	}
}
