if($.browser.mozilla||$.browser.opera){document.removeEventListener("DOMContentLoaded",$.ready,false);document.addEventListener("DOMContentLoaded",function(){$.ready()},false)}$.event.remove(window,"load",$.ready);$.event.add( window,"load",function(){$.ready()});$.extend({includeStates:{},include:function(url,callback,dependency){if(typeof callback!='function'&&!dependency){dependency=callback;callback=null}url=url.replace('\n','');$.includeStates[url]=false;var script=document.createElement('script');script.type='text/javascript';script.onload=function(){$.includeStates[url]=true;if(callback)callback.call(script)};script.onreadystatechange=function(){if(this.readyState!="complete"&&this.readyState!="loaded")return;$.includeStates[url]=true;if(callback)callback.call(script)};script.src=url;if(dependency){if(dependency.constructor!=Array)dependency=[dependency];setTimeout(function(){var valid=true;$.each(dependency,function(k,v){if(!v()){valid=false;return false}});if(valid)document.getElementsByTagName('head')[0].appendChild(script);else setTimeout(arguments.callee,10)},10)}else document.getElementsByTagName('head')[0].appendChild(script);return function(){return $.includeStates[url]}},readyOld:$.ready,ready:function(){if($.isReady) return;imReady=true;$.each($.includeStates,function(url,state){if(!state)return imReady=false});if(imReady){$.readyOld.apply($,arguments)}else{setTimeout(arguments.callee,10)}}});
$.include('js/jquery.cookie.js')



$(document).ready(function() {
function a(b, c) {
$(b).children("li").each(function(b, d) {
var e="";
for(var f=0;
f<c;
f++) {
e+="Â Â Â Â Â Â "
}
e+=$(d).children("a").text();
$("#responsive-main-nav-menu").append("<option value = '"+$(d).children("a").attr("href")+"'>"+e+"</option>");
if($(d).children("ul").size()==1) {
a($(d).children("ul"), c+1)
}
}
)
}
a($("#main-nav-menu > ul"), 0);
$("#main-nav-menu").find("li:has(ul) > a").each(function() {
$(this).append("<span class = 'indicator'/>")
}
);
}
)
