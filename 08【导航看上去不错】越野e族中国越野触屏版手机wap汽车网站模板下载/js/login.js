

//��չ����
$.extend({
	//�ж��û��Ƿ��¼
	getuserinfo:function(){
		$.ajax({
			url:'ajax.php@c=user&a=getinfo&t='+(new Date()).getTime(),
		    dataType:'xml',
		    success:function(msgxml){
		    	var msgxml = $(msgxml);
		    	var errno = parseInt(msgxml.find('errno').text());
		    	//�Ѿ���¼
		    	if(errno === 0){
		    		var uid = msgxml.find('uid').text(); //uid
		    		var username = msgxml.find('username').text(); //uid
		    		var upic = msgxml.find('upic').text(); //ͷ��
		    		$('#userpic').attr('src',upic); //ͷ��
		    		$('#username').text(username); //�û���
		    		$('#loginno').hide(); 
		    		$('#logined').show(); 
		    	}else if(errno === 1){
		    	}else{
		    		return;
		    	}
		    }
		});
	},
	//�û��˳�
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
		    		$('#userpic').attr('src',_global_var._default_headpic()); //ͷ��
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






























