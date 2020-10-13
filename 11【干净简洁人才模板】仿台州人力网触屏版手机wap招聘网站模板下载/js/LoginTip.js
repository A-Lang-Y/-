 $(function(){
	LoginTip =  function(data) {
	var cookiesval;
	if($.cookie("per_username")!=null){
	 cookiesval=$.cookie("per_username");
	}
	else
	{
	cookiesval="";
	}
	var html = '<div class="popBox" style="visibility: visible; position: absolute;width: 250px; height: auto; z-index: 35;  opacity: 1;"><a class="box-close" title="关闭"><i></i></a><div class="box-title">用户登录</div><div class="box-content"><ul class="pop_login"><li class="find_pwd"><a href="../password/default.htm">忘记密码？</a> </li><li class="user_name"><input id="username" name="username" type="text" value="'+cookiesval+'" tabindex="1" placeholder="用户名"></li><li class="password"><input id="password" name="password" type="password" tabindex="2" placeholder="密码"></li><li class="login_free"><input id="Hidden1" type="hidden" value="1" /><input type="checkbox" value="1" id="loginFree" class="inputCheckbox" checked=""><label for="loginFree">30天内自动登录</label></li><li class="btn_login"><button type="button" class="btn_orange1 box-ok" tabindex="3">登录</button><button class="btn_green1" onclick="window.location.href=\'../reg/default.htm\'" type="button" tabindex="4">注册</button></li></ul></div></div>';
	        $('.overlay').append($(html));
	        var $t = $('.popBox');
	        var winW = $(window).width()
			 	,winH = $(window).height()
			 	,altW = $t.width()
			 	,altH = $t.height()
			 	
			 	$t.css({'top':(winH-altH)/2+'px','left':(winW-altW)/2+'px'}).fadeIn(0);
	         };
	         
	   $(".overlay").on('click','.box-close',function(){
                 $('.overlay').hide();
                 $('.overlay').css({ 'display': 'none', 'opacity': '0'});
                  
            }); 
            
        $(".overlay").on('click','#loginFree',function(){
            if($("#Hidden1").val()=="0")
            {
             $("#Hidden1").val("1");
            }
            else
            {
             $("#Hidden1").val("0");
            }
        });
        
        $(".overlay").on('click','.btn_orange1',function(){
            $.ajax({
			  type: "post",
			  url: "../login/ajax/login.ashx",
			  data:{flag:$("#Hidden1").val(),username:$("#username").val(),password:$("#password").val()},
			  error:function(){showTip('系统维护，请稍候再试！');return false;},
			  success : function(data){
			       if(data=="1"){
			       showTip('用户名密码不能为空！');return false;
			       }
			       else if(data=="2"){
			       showTip('登陆成功');
			       setTimeout(function(){window.location.reload();},1500)
			       }
			       else if(data=="3"){
			       showTip('用户名密码不正确！');return false;
			       }
		         }
		     
			}); 
           
        });
});