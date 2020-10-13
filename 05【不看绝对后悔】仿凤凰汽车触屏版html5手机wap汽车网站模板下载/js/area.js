/*
 * 地区js
 */

function fillCity(){
    aCity = areaData.split(",");
    var j = 1;
    for (i = 1; i <= aCity.length; i++) {
        if (aCity[i - 1].substring(2, 6) == "0000") {
            document.getElementById("province").options[j] = new Option(aCity[i - 1].substring(7, aCity[i - 1].length), aCity[i - 1].substring(0, 6));
            j++;
        }
    }
}

function setCity(provinceCode){
	aCity = areaData.split(",");
    var j = 1;
	
    var city = document.getElementById("city");
    while (city.firstChild) { //判断是否有子节点
        city.removeChild(city.firstChild);
    }
    first = new Option("城市/地区", "");
    document.getElementById("city").options[0] = first;
    if(provinceCode == 110000){
        temp = new Option("北京", 110000);
        document.getElementById("city").options[1] = temp;
        return;
    }
    if(provinceCode == 310000){
        temp = new Option("上海", 310000);
        document.getElementById("city").options[1] = temp;
        return;
    }
    if(provinceCode == 500000){
         temp = new Option("重庆", 500000);
        document.getElementById("city").options[1] = temp;
        return;
    }
    if(provinceCode == 120000){
        temp = new Option("天津", 120000);
        document.getElementById("city").options[1] = temp;
        return;
    }	
	
    var provinceCode = provinceCode / 10000;
    for (i = 1; i <= aCity.length; i++) {
        if (aCity[i - 1].substring(0, 2) == provinceCode && aCity[i - 1].substring(2, 6) != "0000") {
            document.getElementById("city").options[j] = new Option(aCity[i - 1].substring(7, aCity[i - 1].length), aCity[i - 1].substring(0, 6));
            j++;
        }
    }
    document.getElementById("city").length = j;
    
}

function getArea(cityCode) {
    var area = {};
    aCity = areaData.split(",");
    var j = 0;
    for (i = 1; i <= aCity.length; i++) {
        if (aCity[i - 1].substring(2, 6) == "0000" && aCity[i - 1].substring(0, 2) == cityCode.substring(0, 2)) {
            area.province = aCity[i - 1].substring(7, aCity[i - 1].length);
            j ++;
        }else if (aCity[i - 1].substring(0, 6) == cityCode) {
            area.city = aCity[i - 1].substring(7, aCity[i - 1].length);
            j ++;
        }
        if(2 <= j) {
            return area;
        }
    }
    if(undefined == area.province) {
        area.province = '';
    }
    if(undefined == area.city) {
        area.city = '';
    }
    return area;
}

/*
$(function() {
    if(undefined != $('#province').attr('id')) {		
        fillCity();
    }
});
*/