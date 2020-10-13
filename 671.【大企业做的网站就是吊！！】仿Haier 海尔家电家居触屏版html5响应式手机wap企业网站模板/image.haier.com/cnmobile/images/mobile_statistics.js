// 安装预约、维修预约 按钮监控
	$("#service_reg").click(function(){
		//判断是维修还是安装，
		var servicetype ="";
		var service_type = document.getElementsByName("service_type");
		for(var i=0;i<service_type.length;i++){
			if(service_type[i].checked==true){
				servicetype = service_type[i].value;
			}
		}
		if(servicetype=="1"){
			if (window._gsTracker) {
				_gsTracker.track("../targetpage/supports/repair");
			}
		}else if(servicetype=="2"){
			if (window._gsTracker) {
				_gsTracker.track("../targetpage/supports/save");
			}
		}
	 });
	
	