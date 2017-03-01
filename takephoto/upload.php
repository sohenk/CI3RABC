<?php
date_default_timezone_set("PRC");   //使用北京时间
//只接受post请求
if(strtolower($_SERVER['REQUEST_METHOD']) != 'post'){
	exit;
}

$folder = 'uploads/';
$filename = date('YmdHis').rand().'.jpg';
$original = $folder.$filename;

$input = file_get_contents('php://input');
if(md5($input) == '7d4df9cc423720b7f1f3d672b89362be'){
	exit;
}
$result = file_put_contents($original, $input);
if (!$result) {
	echo '{"error":1,"message":"文件目录不可写";}';
	exit;
}

$info = getimagesize($original);
if($info['mime'] != 'image/jpeg'){
	unlink($original);
	exit;
}


$origImage	= imagecreatefromjpeg($original);
$newImage	= imagecreatetruecolor(154,110);
imagecopyresampled($newImage,$origImage,0,0,0,0,154,110,520,370); 

//imagejpeg($newImage,'uploads/thumbs/'.$filename);
imagejpeg($newImage,'uploads/small_'.$filename);

//写入数据库
include_once('connect.php');
$time = mktime();
$sql = "insert into photobooth (pic,uploadtime)values('$filename','$time')";
$res = mysql_query($sql);
if($res){
    echo '{"status":1,"message":"Success!","filename":"'.$filename.'"}';
}else{
	echo '{"error":1,"message":"Sorry,something goes wrong.";}';
}
?>