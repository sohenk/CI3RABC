<?php 
class TelephoneCheck
{


    /**
     * 取得某个用户某次活动的手机验证码
     * @param $uin 用户ID 小于10000系统保留
     * @param $actId 活动ID  小于1000系统保留
     * @param $telephone 用户手机号
     * @return bool|int 4位数的验证码
     */
    public function getTelephoneCode($uin, $actId, $telephone)
    {

        if ($uin < 10000 || $actId < 1000 || empty($telephone)) {
            return false;
        }

        $time = time();

        $timeFeature = hexdec(substr(md5($time), 0, 3)) & 0x1F1;

        $telephoneFeature = hexdec(substr(md5($telephone), 8, 4));

        $actIdFeature = hexdec(substr(md5($actId), 16, 4));

        $uinFeature = hexdec(substr(md5($uin), 24, 4));

        $sumFeature = $telephoneFeature + $actIdFeature + $uinFeature;

        $sumFeature = $sumFeature % 10000;

        if ($sumFeature < 1000) {
            $sumFeature = 5145;
        }

        $result = $sumFeature | $timeFeature;

        return $result;
    }


    /**
     * 验证用户的手机验证码
     * @param $uin 用户ID 小于10000系统保留
     * @param $actId 活动ID  小于1000系统保留
     * @param $telephone 用户手机号
     * @param $code getTelephoneCode生成的验证码
     * @return bool 是否正确
     */
    public function  checkTelephoneCode($uin, $actId, $telephone, $code)
    {

        if ($uin < 10000 || $actId < 1000 || empty($telephone) || empty($code)) {
            return false;
        }

        $telephoneFeature = hexdec(substr(md5($telephone), 8, 4));

        $actIdFeature = hexdec(substr(md5($actId), 16, 4));

        $uinFeature = hexdec(substr(md5($uin), 24, 4));

        $sumFeature = $telephoneFeature + $actIdFeature + $uinFeature;

        $sumFeature = $sumFeature % 10000;

        if ($sumFeature < 1000) {
            $sumFeature = 5145;
        }

        $sumFeature = $sumFeature & 0xE0E;

        $code = $code & 0xE0E;

        if ($sumFeature == $code) {
            return true;
        }
        return false;
    }
}

//发送短信
function sendSms($phone,$content){

    $CI= &get_instance();
    
    $statusStr = array(
        "0" => "短信发送成功",
        "-1" => "参数不全",
        "-2" => "服务器空间不支持,请确认支持curl或者fsocket，联系您的空间商解决或者更换空间！",
        "30" => "密码错误",
        "40" => "账号不存在",
        "41" => "余额不足",
        "42" => "帐户已过期",
        "43" => "IP地址限制",
        "50" => "内容含有敏感词"
    );
    $smsapi = "http://api.smsbao.com/";
    $user = $CI->config->config['SMSUSER'];    ; //短信平台帐号
    $pass = md5($CI->config->config['SMSPASSWORD']); //短信平台密码
    $content=$content;//要发送的短信内容
    $phone =$phone;//要发送短信的手机号码
    $sendurl = $smsapi."sms?u=".$user."&p=".$pass."&m=".$phone."&c=".urlencode($content);
    $result =file_get_contents($sendurl) ;
    return $statusStr[$result];
}

//秒数转换时分秒显示
function changeTimeType($seconds){
	if ($seconds>3600){
		$hours = intval($seconds/3600);
		$minutes = $seconds600;
		$time = $hours."时".gmstrftime('%M分%S秒', $minutes);
	}else{
		$time = gmstrftime('%H时%M分%S秒', $seconds);
	}
	return $time;
}

//加密
function newbase64_en($str){
    $str = str_replace('/','@',str_replace('+','-',base64_encode($str)));
    return $str;
}

//解密
function newbase64_de($str){
    $encode_arr = array('UTF-8','ASCII','GBK','GB2312','BIG5','JIS','eucjp-win','sjis-win','EUC-JP');
    $str = base64_decode(str_replace('@','/',str_replace('-','+',$str)));
    $encoded = mb_detect_encoding($str, $encode_arr);
    $str = iconv($encoded,"utf-8",$str);
    return $str;
}

//发邮件
function postmail($to,$subject = "",$body = ""){
	
	$CI= &get_instance();
    //Author:Jiucool WebSite: http://www.jiucool.com 
    //$to 表示收件人地址 $subject 表示邮件标题 $body表示邮件正文
    //error_reporting(E_ALL);
//     error_reporting(E_STRICT);
    require_once(FCPATH.'static/mail/class.phpmailer.php');
    include(FCPATH."static/mail/class.smtp.php"); 
    $mail             = new PHPMailer(); //new一个PHPMailer对象出来
    $body             = $body; //对邮件内容进行必要的过滤
    $mail->CharSet ="UTF-8";//设定邮件编码，默认ISO-8859-1，如果发中文此项必须设置，否则乱码
    $mail->IsSMTP(); // 设定使用SMTP服务
    $mail->SMTPDebug  = 0;                     // 启用SMTP调试功能
                                           // 1 = errors and messages
                                           // 2 = messages only
    //这里在config。php设置
    $mail->SMTPAuth   = $CI->config->config['SMTPAuth'];                  // 启用 SMTP 验证功能
    $mail->SMTPSecure =  $CI->config->config['SMTPSecure'];                 // 安全协议
    $mail->Host       = $CI->config->config['STMPHOST'];      // SMTP 服务器
    $mail->Port       = $CI->config->config['SMTPPort'];                   // SMTP服务器的端口号
    $mail->Username   = $CI->config->config['SMTPUsername'];  // SMTP服务器用户名
    $mail->Password   = $CI->config->config['SMTPPassword'];            // SMTP服务器密码
    $mail->SetFrom($CI->config->config['SMTPUsername'], $CI->config->config['SMTPFrom']);
//     $mail->AddReplyTo($CI->config->config['SMTPUsername'],$CI->config->config['SMTPFrom']);
    $mail->Subject    = $subject;
    $mail->AltBody    = "技术提供有SOHENK提供"; // optional, comment out and test
    $mail->MsgHTML($body);
    $address = $to;
    $mail->AddAddress($address, "收件人名称");
    //$mail->AddAttachment("images/phpmailer.gif");      // attachment 
    //$mail->AddAttachment("images/phpmailer_mini.gif"); // attachment
    if(!$mail->Send()) {
//         echo "Mailer Error: " . $mail->ErrorInfo;
        return false;
    } else {
        return true;
        }
    }
 function showInfo($msg,$url=null){

//      echo $url;
     if(!$url&&isset($_SERVER["HTTP_REFERER"])&&$_SERVER["HTTP_REFERER"]){
         $url=$_SERVER["HTTP_REFERER"];
     }
     elseif(!$url&&!isset($_SERVER["HTTP_REFERER"])){
         $url=site_url("cmsfront/index");
     }
     else if(!$url&&($_SERVER["HTTP_REFERER"]==current_url())){
       $url=site_url("cmsfront/index");
     }
//          echo $url;
//      return;
        echo '<script type="text/javascript">alert("'.$msg.'");</script>';
        echo "<meta http-equiv='Refresh' content='0;URL=".$url."'>";
    }



?>