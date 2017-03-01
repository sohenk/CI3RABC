
jQuery(document).ready(function() {

    /*
        Background slideshow
    */
    $.backstretch([
      "../static/resources/img/backgrounds/1.jpg"
    , "../static/resources/img/backgrounds/2.jpg"
    , "../static/resources/img/backgrounds/3.jpg"
    ], {duration: 3000, fade: 750});

    /*
        Tooltips
    */
    $('.links a.home').tooltip();
    $('.links a.blog').tooltip();
    
    $("#niming").click(function(){    	
    	if($("#nimingCheckbox").is(':checked')){
    		$("#userInfoPanel").hide(200);
    	}else{
    		$("#userInfoPanel").show(200);
    	}
    });
});

function submitForm(){
	var uname=$("#uname").val();
	var phone=$("#phone").val();

	if(uname==""){	
		alert("请填写用户名！");
		return false;
	}    

    if(phone==""){
    	alert("请填写手机号码");
    	return false;
    }
    
   if(phone.length!=11){
    	alert("请填写正确的手机号码");
    	return false;
    }    
   
	return true;
}

function closeBtn(){
	
	return false;
}

