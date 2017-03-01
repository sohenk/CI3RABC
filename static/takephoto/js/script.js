// JavaScript Document
$(function(){
	//loadpic();
	
	//继续播放
	var keepplay=false;
	
	webcam.set_swf_url('/static/takephoto/js/webcam.swf');
	webcam.set_api_url(webcameuploadurl);	// The upload script
	webcam.set_quality(80);				// JPEG Photo Quality
	webcam.set_shutter_sound(false, '/static/takephoto/js/shutter.mp3');
	webcam.set_hook( 'onComplete', my_callback_function );
	function my_callback_function(response) {
		alert("Success! PHP returned: " + response);
	}
//	window.setInterval(upic,3000); 
//	function upic(){
//		webcam.freeze();
//		setTimeout(function(){
//			webcam.upload();
//			if(keepplay){
//				
//			}
//			},1000)
//	}

	// Generating the embed code and adding it to the page:	
	var cam = $("#webcam");
	cam.html(
		webcam.get_html(cam.width(), cam.height())
	);
	
	
	var camera = $("#camera");
//	var shown = false;
//	$('#cam').click(function(){
//		
//		if(shown){
//			camera.animate({
//				bottom:-466
//			});
//		}else {
//			camera.animate({
//				bottom:-5
//			},{easing:'easeOutExpo',duration:'slow'});
//		}
//		
//		shown = !shown;
//	});
	
	$("#btn_shoot").click(function(){
		webcam.freeze();
//		setTimeout(function(){
//			webcam.upload();
//			},5000)
//		
		return false;
	});
	
	$('#btn_cancel').click(function(){
		webcam.reset();
		$("#shoot").show();
		$("#upload").hide();
		return false;
	});
	
	$('#btn_upload').click(function(){
		webcam.upload();
		webcam.reset();
//		$("#shoot").show();
//		$("#upload").hide();
		return false;
	});
	
	
	webcam.set_hook('onComplete', function(msg){
		
		msg = $.parseJSON(msg);
		
		if(!msg.status){
//			alert(msg.message);
			canplay=0;
		}
		else {
			// Adding it to the page;
			canplay=1;
		}
	});
	
	webcam.set_hook('onError',function(e){
		console.log(e)
		cam.html(e);
	});
	

});