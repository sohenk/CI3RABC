<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

date_default_timezone_set('Asia/Shanghai');
mb_internal_encoding("UTF-8");
header("Content-type:text/html;charset=utf-8");
if((isset($actionUrl)&&$actionUrl)||$_GET["actionUrl"]){
require('../static/phpQuery/phpQuery.php');
// INITIALIZE IT
// phpQuery::newDocumentHTML($markup);
// phpQuery::newDocumentXML();
// phpQuery::newDocumentFileXHTML('test.html');
// phpQuery::newDocumentFilePHP('test.php\');
// phpQuery::newDocument('test.xml', 'application/rss+xml');
// this one defaults to text/html in utf8
$url=base64_decode((isset($actionUrl)&&$actionUrl)?$actionUrl:$_GET["actionUrl"]);
$doc = phpQuery::newDocumentFile($url);

header("Content-type: text/html; charset=utf-8");
echo '
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
 <head>
    <title>			
	</title> 
 </head> 
 <body style="background:#fff"> 
  <script type="text/javascript">
TTOOLS_PIC_SERVER_URL="http://static1.icourses.cn/";
CMS_SERVER_URL="http://www.icourses.cn/";
SNS_PIC_SERVER_URL="http://sns.icourses.cn/";
ssoUrl = \'http://ucenter.icourses.cn/\';
</script> 
  <script type="text/javascript" id="headjs_jquery" src="http://static1.icourses.cn/sns/js/common/jquery.min.js"></script> 
  <script type="text/javascript" src="http://static1.icourses.cn/common/player/swfobject.js"></script> 
  <script type="text/javascript" src="http://static1.icourses.cn/cms/jpk/course/js/lixcharacter.js"></script> 
  <div class="video" style="text-align:center;"> 
   <div class="con lix" id="videocontent"> 
    <div id="win1" class="win" style="z-index: 200;width:100%;margin:0 auto;float:none"> 
     <script type="text/javascript">'.pq(".video")->find("script")->html().'
							</script> 
    </div> 
    <p id="MPlayerBox"> </p> 
    <p id="DPlayerBox"></p> 
   </div> 
  </div>  
 </body>
</html>
';
}else{
    echo "非法请求";
}

