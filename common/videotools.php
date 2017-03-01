<?php header("Content-type: text/html; charset=utf-8");?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title></title>
<link href='videoToolsResource/css/style.css' rel='stylesheet' type='text/css'>
<script src="/static/front/cms/js/jquery-1.7.1.min.js"></script>
<script>
	function getVideoUrl(actionType){
		var dataurl=$.trim($("#videoUrl").val());
		if(dataurl=="请输入视频页面地址"||dataurl==""){
			alert("请输入视频地址！");
			return;
			}
		var actionUrl="getVideosCode.php";
		dataurl=encodeURI(dataurl);
		$("#codePanel").html("").hide();
 		$("#preview").val("");
		
		$.ajax({
	        type: "POST",
	        url:actionUrl,
	        data:{dataurl:dataurl},
	        async: false,
	        dataType:"json",
	        error: function(request) {
	            alert("Connection error");
	        },
	        success: function(data) {
		        if(data){
			        if(actionType=="action"){
			        	$("#codePanel").text('<iframe frameborder=0 width=100% height=500 marginheight=0 marginwidth=0 scrolling=no src="/common/videoAction.php?actionUrl='+data.actionUrl+'"></iframe>');
					}else{
						$("#codePanel").html(data.encryptionUrl);
					}
		        	
		        	$("#codePanel").show();
		        	$("#preview").val("/common/videoAction.php?actionUrl="+data.actionUrl);
			    }
	        }
	   });		   
	}

	function palyVideo(){		
		var code=$("#codePanel").html();
		if(code==""){
			alert("请先获取播放代码！");
			return;
		}		
		window.open($("#preview").val());
	}
	
</script>
<style>
    .playButton{background: #c5eeb6; font-size: 30px;line-height: 60px; color:#b65f5f; margin-top:30px;}
    .playButton:hover{background: #e2fad9;}
    .encryptionVideoCode{background: #c5eeb6; font-size: 30px;line-height: 60px; color:#b65f5f; margin-top:3px; margin-bottom:3px;}
    .encryptionVideoCode:hover{background: #e2fad9;}  
    
    .codePanel{height: 80px;background: #FFF; margin:3px;border-radius:2em;display: none;padding:20px;word-wrap:break-word;word-break:break-all;}  
    
</style>
</head>
<body>
	<h1>视频连接生成工具</h1>
	<div class="login-form">
	<div>
    	<div style="color: #FFF; line-height: 3em; font-size: 26px;">请输入视频页面地址，并点击获取视频代码：</div>
    	   <input type="hidden" id="preview" />
    	   <input type="text" id="videoUrl" name="videoUrl" value="请输入视频页面地址" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = '请输入视频页面地址';}"/>				
        </div>
    	<input id="videoUrl" type="hidden" value="" />
        <div id="codePanel" class="codePanel"></div>
        <div class="playButton" onclick="palyVideo()">播放预览</div>
        <div class="encryptionVideoCode" onclick="getVideoUrl('encryption')">获取视频代码</div>
        <div class="signin">
        	<input type="submit" onclick="getVideoUrl('action')" value="获取文章页播放代码">        	
        </div>       
	</div>
	<div class="copy-rights">
	</div>

</body>
</html>