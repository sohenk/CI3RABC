
<!DOCTYPE html>
<html lang="en" class="no-js">

<head>

<meta charset="utf-8">
<title>管理系统</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="">

<!-- CSS -->

<link rel="stylesheet" href="<?php echo base_url("static")?>/login/css/supersized.css">
<link rel="stylesheet" href="<?php echo base_url("static")?>/login/css/login.css">
<link href="<?php echo base_url("static")?>/login/css/bootstrap.min.css" rel="stylesheet">
<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
<!--[if lt IE 9]>
	<script src="js/html5.js"></script>
<![endif]-->
<script type="text/javascript">
	var __IMAGERESOURCESURL="<?php echo config_item("STATIC_RESOURCE_URL");?>";
</script>
<script src="<?php echo base_url("static")?>/login/js/jquery-1.8.2.min.js"></script>
<script type="text/javascript" src="<?php echo base_url("static")?>/login/js/jquery.form.js"></script>
<script type="text/javascript" src="<?php echo base_url("static")?>/login/js/tooltips.js"></script>
<script type="text/javascript" src="<?php echo base_url("static")?>/login/js/login.js"></script>
</head>

<body>

<div class="page-container">
	<div class="main_box">
		<div class="login_box">
			<div class="login_logo">				
				<h2>管理系统</h2>
			</div>             
            
			<div class="login_form">
				<form onsubmit="return false;" id="login_form" method="post">
					<div class="form-group">
						<label for="j_username" class="t">用户名：</label> 
						<input id="loginname" value="" name="loginname" type="text" class="form-control x319 in" 
						autocomplete="off">
					</div>
					<div class="form-group">
						<label for="j_password" class="t">密　码：</label> 
						<input id="password" value="" name="password" type="password" 
						class="password form-control x319 in">
					</div>
					<div class="form-group">
						<label for="j_captcha" class="t">验证码：</label>
						 <input id="j_captcha" name="j_captcha" type="text" class="form-control x164 in">&nbsp;
						 <input type = "button" id="code" onclick="createCode()"/>
						<!-- <img id="captcha_img" alt="点击更换" title="点击更换" src="<?php echo base_url("static")?>/login/images/captcha.jpeg" class="m"> -->
					</div>
<!-- 					<div class="form-group"> -->
<!-- 						<label class="t"></label> -->
<!-- 						<label for="j_remember" class="m"> -->
<!-- 						<input id="j_remember" type="checkbox" value="true">&nbsp;记住登陆账号!</label> -->
<!-- 					</div> -->
					<div class="form-group space">
						<label class="t"></label>　　　
						<button type="button"  id="submit_btn" 
						class="btn btn-primary btn-lg">&nbsp;登&nbsp;录&nbsp </button>
						<input type="reset" value="&nbsp;重&nbsp;置&nbsp;" class="btn btn-default btn-lg">
					</div>
				</form>
			</div>
		</div>
		<div class="bottom">Copyright &copy; 2014 - 2016 <a href="#">系统登陆</a></div>
	</div>
</div>

<!-- Javascript -->

<script src="<?php echo base_url("static")?>/login/js/supersized.3.2.7.min.js"></script>
<script src="<?php echo base_url("static")?>/login/js/supersized-init.js"></script>
<script src="<?php echo base_url("static")?>/login/js/scripts.js"></script>
</body>
</html>