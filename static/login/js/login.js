// JavaScript Document
//支持Enter键登录
		document.onkeydown = function(e){
			if($(".bac").length==0)
			{
				if(!e) e = window.event;
				if((e.keyCode || e.which) == 13){
					var obtnLogin=document.getElementById("submit_btn")
					obtnLogin.focus();
				}
			}
		}

    	$(function(){
    		//提交表单
			$('#submit_btn').click(function(){
				show_loading();

				var validateObj=validate();
				var loginname=$.trim($('#loginname').val());
				var pwd=$.trim($('#password').val());
				
				if(loginname == ''){
					show_err_msg('用户名还没填呢！');	
					$('#loginname').focus();
				}else if(pwd == ''){
					show_err_msg('密码还没填呢！');
					$('#password').focus();
				}else if(validateObj.status==false){
					show_err_msg(validate().msg);
					$('#j_captcha').val("");
					$('#j_captcha').focus();
					createCode();
				}else{
					$.ajax({
					       url:'./action/login',
					       type:'post',         
					       dataType:'json',     
					       data:{
					    	    loginname:loginname,
					       		password:pwd
					       },
					       success:function(callbackData){
					       		if(callbackData.loginstatus){
					       			show_msg(callbackData.msg,"./admin");
					       		}else{
					       			show_err_msg(callbackData.msg);	
					       		}
					       } 
					 });
				}
			});
		});
		
var code ; //在全局定义验证码   
//产生验证码  
window.onload = createCode;	

function createCode(){  
     code = "";   
     var codeLength = 4;//验证码的长度  
     var checkCode = document.getElementById("code");   
     var random = new Array(0,1,2,3,4,5,6,7,8,9,'A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R',  
     'S','T','U','V','W','X','Y','Z');//随机数  
     for(var i = 0; i < codeLength; i++) {//循环操作  
        var index = Math.floor(Math.random()*36);//取得随机数的索引（0~35）  
        code += random[index];//根据索引取得随机数加到code上  
    }  
    checkCode.value = code;//把code值赋给验证码  
}  
 
//校验验证码  
function validate(){ 
	var validateObj={};
    var inputCode = document.getElementById("j_captcha").value.toUpperCase(); //取得输入的验证码并转化为大写        
    if(inputCode.length <= 0) { //若输入的验证码长度为0  
    	validateObj.msg="请输入验证码！"; //则弹出请输入验证码
    	validateObj.status=false;
    }         
    else if(inputCode != code ) { //若输入的验证码与产生的验证码不一致时  
    	validateObj.msg="验证码输入错误！"; //则弹出验证码输入错误 
    	validateObj.status=false;
        //createCode();//刷新验证码  
        //document.getElementById("input").value = "";//清空文本框  
    }else{
    	validateObj.status=true;	
    }
    
    return validateObj;
}  