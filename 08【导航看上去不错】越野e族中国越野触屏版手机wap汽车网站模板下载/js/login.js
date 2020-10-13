

//扩展函数
$.extend({
	//判断用户是否登录
	getuserinfo:function(){
		$.ajax({
			url:'ajax.php@c=user&a=getinfo&t='+(new Date()).getTime(),
		    dataType:'xml',
		    success:function(msgxml){
		    	var msgxml = $(msgxml);
		    	var errno = parseInt(msgxml.find('errno').text());
		    	//已经登录
		    	if(errno === 0){
		    		var uid = msgxml.find('uid').text(); //uid
		    		var username = msgxml.find('username').text(); //uid
		    		var upic = msgxml.find('upic').text(); //头像
		    		$('#userpic').attr('src',upic); //头像
		    		$('#username').text(username); //用户名
		    		$('#loginno').hide(); 
		    		$('#logined').show(); 
		    	}else if(errno === 1){
		    	}else{
		    		return;
		    	}
		    }
		});
	},
	//用户退出
	userlogout:function(){
		var objframe = document.createElement("IFRAME"); 
		objframe.id = "iframelogin"; 
		objframe.name= "iframelogin"; 
		objframe.height=0; 
		objframe.width=0; 
		objframe.src='ajax.php@c=user&a=logoutiframe'; 
		document.body.appendChild(objframe);
		
		$.ajax({
			url:'ajax.php@c=user&a=logout',
		    dataType:'xml',
		    success:function(msgxml){
		    	var msgxml = $(msgxml);
		    	var errno = parseInt(msgxml.find('errno').text());
		    	if(errno === 0){
		    		$('#userpic').attr('src',_global_var._default_headpic()); //头像
		    		$('#logined').hide(); 
		    		$('#loginno').show();
		    	}else{
			    	return;
			    }
			}
		});
	}
})


$(function(){

	$.getuserinfo();

	$("#logout").click(function(){
		$.userlogout();
	});
});






























