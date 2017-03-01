<?php
/**
 * FCKeditor 保存远程图片插件
 * @author LuTH(512701323@qq.com)
 * @license LGPL
 * @version 1.0 2009.6.10
 * @copyright  Copyright (c) 2009
 * 
 */

function getFiles($html) {
	$files = array ();
	//$re = "/http:\/\/(\w+\.)+(net|com|cn|org|cc|tv|com.cn)(\S*\/)(\S)+\.(gif|jpg|png|bmp|jpeg)/"; //原始、简洁
	$re = "/http:\/\/((\w+\.)+(com|net|cn|org|cc|tv|com.cn))(\S*\/)(\S+)\.(gif|jpg|png|bmp|jpeg)/"; //扩展、清晰
	preg_match_all ( $re, $html, $out, PREG_PATTERN_ORDER );
	$host=array_unique ( $out [1] );
	$yes=0;
	foreach($host as $h){
		if($h!="t.hizh.cn"){
			$yes=1;
		}
	}
	if($yes){
		$out = array_unique ( $out [0] );
		foreach ( $out as $file ) {
			$files [] = trim ( $file );
		}
	}
	return $files;
}

/**
 * Save Http Files 
 *
 * @param array $files: remote path
 * @param string $dir: save location path
 * @param string $dir2: display 
 * @return information
 */
function SaveHTTPFile($files, $dir, $dir2) {
	$ret = array ();
	//记录程序开始的时间
	$ret ['start'] = getmicrotime ();
	$ret ['files'] = $files;
	
	//	创建目录	
	if (! file_exists ( $dir )) {
		$oldumask = umask ( 0 );
		mkdir ( $dir, 0777 );
		umask ( $oldumask );
	}
	
	if (! is_array ( $files ))
		$files [0] = $files;
	    
	for($i = 0; $i < count ( $files ); $i ++) {
		//取得文件名
		$name = date ( 'His' ) . '_' . rand ( 0, 1000 ) . strrchr ( trim ( $files [$i] ), "." );
		$fileName = $dir . $name;
		$ret ['path'] [] = $fileName;
		$ret ['path2'] [] = $dir2 . $name;

		//取得文件的内容
		ob_start ();
		readfile ( $files [$i] );
		$img = ob_get_contents ();
		ob_end_clean ();
// 		$size = strlen($img);
// 		echo $size;

		//保存到本地
		$fp2 = @fopen ( $fileName, "w+" );
		
		// 权限
		$oldumask = umask ( 0 );
		chmod ( $fileName, 0777 );
		umask ( $oldumask );
		
		fwrite ( $fp2, $img );
		fclose ( $fp2 );
	
	}
	
	//记录程序运行结束的时间
	$ret ['end'] = getmicrotime ();
	$ret ['time'] = $ret ['end'] - $ret ['start'];
	
// 	printf ("[页面执行时间: %.2f毫秒]\n\n",($ret ['end'] - $ret ['start'] )*1000);
	
	//返回运行时间
	return $ret;
}
function getmicrotime()
{
	list($usec, $sec) = explode(" ",microtime());
	return ((float)$usec + (float)$sec);
}
?>