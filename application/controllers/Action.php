<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class action extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();		
	}
	
    /*
     * 后台管理员登陆
     */
	public function login(){
		$userpost=isset($_POST)?$_POST:exit("illegal access");
				
		$user["loginname"]=$userpost["loginname"];
		$user["pwd"]=md5($userpost["password"]);
		$userinfo="";

		$userinfo=$this->db->where($user)->get("user")->row(0);
		
		$pageData=new stdClass();
		$pageData->loginstatus=false;
		$pageData->msg="登陆失败！";
			
		if($userinfo){
			$newdata = array(
					'username'  => $userinfo->name,
					'uid'	=>$userinfo->id,
// 					'authority'	=>$userinfo->authority,
					'logged_in' => TRUE			        
			);
			$this->session->set_userdata($newdata);
			$pageData->loginstatus=true;
			$pageData->msg="登录成功咯！  正在为您跳转...！";
		}
		else{
			$pageData->loginstatus=false;
			$pageData->msg="用户名密码错误！";
		}
		
		if(isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && strtolower($_SERVER["HTTP_X_REQUESTED_WITH"])=="xmlhttprequest"){			
			echo json_encode($pageData);
		}else{
			echo $pageData->loginstatus==true?redirect("admin"):"用户名密码错误";
		};
	}
	public function sendyzm(){
	    //$msg=(sendSms($_POST["tel"],"test"));
	    
	    $returndata["msg"]="短信发送不成功，请在尝试";
	    $returndata["status"]=0;
	    
	    
	    
	    if($this->cktelunique($_POST["tel"])){
	        $returndata["msg"]="手机已被注册";
	        echo json_encode($returndata,true);
	        die;
	    }
	    
	    
	    if (isset($_SESSION['yzmtime']))//判断缓存时间
	    {
	        $restime=time()-$_SESSION['yzmtime'];
	        if($restime<60) {
	            $returndata["msg"]="请在".(60-$restime)."秒后再次发送短信";
	            echo json_encode($returndata,true);
	            die;
	        }
	    }
	    $_SESSION['yzmtime'] = time();
// 	    echo json_encode($returndata,true);die;
// 	    print_r($_SESSION);die;
	    
	    $telCode = new TelephoneCheck();
	    
	    $actId = 10001;
	    $telephone = $_POST["tel"];
	    $uin = 514540767;
	    
	    $code = $telCode->getTelephoneCode($uin, $actId, $telephone);
	    
	    $msg=(sendSms($_POST["tel"],"注册验证码：$code,验证码有效时间为1分钟"));
	    
	    if ($msg=='短信发送成功') {
	        $_SESSION["yzm"]=$code;
	        $_SESSION["phone"]=$_POST["tel"];
	        $returndata["status"]=1;
	        $returndata["msg"]="短信发送成功";
	        echo json_encode($returndata,true);
	        die;
	    } else {
	        echo json_encode($returndata,true);
	        die;
	    }
	}
	
	
	public function logout(){
		$this->session->unset_userdata('username');
		$this->session->unset_userdata('uid');
		$this->session->unset_userdata('logged_in');
// 		$this->session->unset_userdata('districtid');
// 		$this->session->unset_userdata('authority');
// 		$this->session->unset_userdata('unitid');
		redirect("member");
	}
	public function actionUploadify()
	{
// 		print_r($_POST);
		$status=0;
		$msg="文件不存在";
		$fileName=""; 
	    if (!empty($_FILES)) {
	        $fileName = $_FILES['download']['name'];
	        //$fileParts = pathinfo($_FILES['Filedata']['name']);
	        //复制文件到目的地址
	        $fileName = $this->getRandomName($fileName);
	        //dealerfiles
	        //$targetFile = "D:/testupload".'/'.$fileName;
	        $targetFile =FCPATH.'/uploads/'.$fileName;
	        $tmpfile = $_FILES['download']['tmp_name'];
// 	        echo $tmpfile; 
	        @move_uploaded_file($tmpfile, $targetFile);
			$status=1;

			$msg="上传成功";
	    }
	   
	    echo json_encode(array('status'=>$status,'filename'=>$fileName,'msg'=>$msg,"path"=>base_url("uploads/$fileName")));
	    
	    
	}
	
	public function studentlogout(){

		$this->session->unset_userdata('student');
		showInfo("退出成功");
	}
	
	public function studentlogin(){
		$userpost=isset($_POST)?$_POST:exit("illegal access");
		
		$user["id"]=$userpost["id"];
		$user["password"]=($userpost["pwd"]);
		if(!isset($_POST["type"])){
		    showInfo("请选择登陆类型",$_SERVER["HTTP_REFERER"]?$_SERVER["HTTP_REFERER"]:site_url());return;
		}
		
		switch ($_POST["type"]){
			case 1:{
				$this->load->library('student');
				// 		print_r($this->session->student);
				if($this->student->validStudent($user["id"],$user["password"])){
					if($this->_checkIsNeedToPerfectionUserInfo()){					    
					   redirect("member/userInfoSettingEdit?perfectionUserInfo=true");
					   return FALSE;
					}
					
					//showInfo("登陆成功",$_SERVER["HTTP_REFERER"]?$_SERVER["HTTP_REFERER"]:site_url());
					showInfo("登陆成功",site_url());
				}
				else{
// 					echo $this->db->last_query();
					showInfo("密码错误");
				}
				break;
			}
			case 2:{
				$this->load->library('teachers');
				// 		print_r($this->session->student);
				if($this->teachers->validTeacher($user["id"],$user["password"])){

				    showInfo("登陆成功",$_SERVER["HTTP_REFERER"]?$_SERVER["HTTP_REFERER"]:site_url());
				}
				else{
// 					echo $this->db->last_query();
					showInfo("密码错误");
				}
				break;
			}
			default :showInfo("非法错误",$_SERVER["HTTP_REFERER"]?$_SERVER["HTTP_REFERER"]:site_url());;
		}
		
		
		
	}
	public function logoutall(){

	    $this->session->unset_userdata('student');
		$this->session->unset_userdata('teacher');
	    showInfo("退出成功",site_url());
	}
	/**
	 * 上传截图
	 */
	public function uploadcapture(){
      	$json["status"]=0;
		$json["message"]="参数错误";
		
		if(strtolower($_SERVER['REQUEST_METHOD']) != 'post'){
			echo json_encode($json,true);
			exit;
		}
		
		$process=(isset($_GET["process"])?$_GET["process"]:0);
		
		//$_GET["student"]学生id
		$studentid=isset($_GET["student"])?intval(newbase64_de($_GET["student"])):0;
		if(!($studentid)){
			echo json_encode($json,true);
            exit;
		}
		
		//$_GET["video"]学生id
		$videoid=isset($_GET["video"])?intval(newbase64_de($_GET["video"])):0;
		if(!($videoid)){
			echo json_encode($json,true);
			exit;
		}
// 		echo $_GET["video"]."!!".$_GET["student"];
// 		die;

		
		$videohistory=$this->db->where("videoid",$videoid)->where("studentid",$studentid)->get("yy_videohistory")->row(0);
		//创建观看历史纪录
		if(!$videohistory){
			$history["process"]=$process;
			$history["studentid"]=$studentid;
			$history["videoid"]=$videoid;
			$history["starttime"]=time();
			
			$this->db->set($history)->insert("yy_videohistory");
			$videohistory=$this->db->where("videoid",$videoid)->where("studentid",$studentid)->get("yy_videohistory")->row(0);
// 			$this->db->set
		}
		else{
			
			//更新进度
			if($process>=$videohistory->process){
				if(isset($_GET["isended"])&&$_GET["isended"]==1){
					$this->db->set("isfinished",1);
// 					echo 123;
				}
				
				if(time()>$videohistory->starttime+20*60){
					$this->db->set("isfinished",1);
				}
				
				$this->db->set("process",$process)->where("id",$videohistory->id)->update("yy_videohistory");
				
			}
		}
		$folder = FCPATH.'/uploads/capturesimages/';
		$todayFolder=$folder.date ( 'Y-m-d')."/"; // 接收文件目录
		echo $todayFolder;
		if (! file_exists ( $todayFolder )) {
			$mkdirStatus=mkdir ( $todayFolder, 0777, true );
			if(!$mkdirStatus){
				$json["message"]="系统错误代码 captures 001，请联系管理员！";
				echo json_encode($json,true);
				exit;
			}
		}
		
		$filename = date('YmdHis').rand().'.jpg';
		$original = $todayFolder.$filename;
		
		$input = file_get_contents('php://input');
		if(md5($input) == '7d4df9cc423720b7f1f3d672b89362be'){
			exit;
		}
		$result = file_put_contents($original, $input);
		if (!$result) {
			
			$json["message"]="参数错误";
			echo json_encode($json,true);
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
		imagejpeg($newImage, FCPATH.'uploads/captures/small_'.$filename);

		$insertdata["capturetime"]=time();
		$insertdata["path"]='/uploads/capturesimages/'.date ( 'Y-m-d')."/".$filename;
		$insertdata["smallpic"]='/uploads/capturesimages/'.date ( 'Y-m-d').'/small_'.$filename;
		$insertdata["videohistoryid"]=$videohistory->id;
		
		//判断摄像头拍照是否有效
		$picture=file_get_contents(FCPATH.'/uploads/captures/empty.jpg');
		$picture1=file_get_contents(FCPATH.'/uploads/captures/empty2.jpg');
		$picture2=file_get_contents(FCPATH.$insertdata["path"]);
		if($picture==$picture2||$picture1==$picture2){
			
			$json["status"]=0;
			$json["message"]="摄像头没有准备好";
			$this->load->helper('file');
			delete_files($insertdata["path"]);
			delete_files($insertdata["smallpic"]);
			echo json_encode($json,true);
			die;
		}
		
		
		$this->db->set($insertdata)->insert("yy_videopicture");
		$json["status"]=1;
		$json["message"]="上传成功";

		echo json_encode($json,true);
	}
	/**
	 * 上传考试截图
	 */
	public function uploadexamcapture(){
	    $json["status"]=0;
	    $json["message"]="参数错误";
	
	    if(strtolower($_SERVER['REQUEST_METHOD']) != 'post'){ 
	        echo json_encode($json,true);
	        exit;
	    }
	  
	    $studentid=isset($_GET["student"])?intval(newbase64_de($_GET["student"])):0;
	    if(!($studentid)){
	        echo json_encode($json,true);
	        exit;
	    }
	    
	    $examhistoryid=isset($_GET["examhistoryid"])?intval(newbase64_de($_GET["examhistoryid"])):0;
	    if(!($examhistoryid)){	       
	        echo json_encode($json,true);
	        exit;
	    }
	   
	    //上传并保存到服务器
	    $folder = FCPATH.'/uploads/captures/';
	    $filename = date('YmdHis').rand().'.jpg';
	    $original = $folder.$filename;
	
	    $input = file_get_contents('php://input');
	    if(md5($input) == '7d4df9cc423720b7f1f3d672b89362be'){
	        exit;
	    }
	    $result = file_put_contents($original, $input);
	    if (!$result) {
	        	
	        $json["message"]="参数错误";
	        echo json_encode($json,true);
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
	    imagejpeg($newImage, FCPATH.'uploads/captures/small_'.$filename);
	
	    $insertdata["capturetime"]=time();
	    $insertdata["path"]='/uploads/captures/'.$filename;
	    $insertdata["smallpic"]='/uploads/captures/small_'.$filename;
	    $insertdata["exam_history_id"]=$examhistoryid;
	    
	    //判断摄像头拍照是否有效
	    $picture=file_get_contents(FCPATH.'/uploads/captures/exam.jpg');
	    $picture1=file_get_contents(FCPATH.'/uploads/captures/exam1.jpg');
	    $picture2=file_get_contents(FCPATH.$insertdata["path"]);
	    if($picture==$picture2||$picture1==$picture2){	        	
	        $json["status"]=0;
	        $json["message"]="摄像头没有准备好";
	        $this->load->helper('file');
	        delete_files($insertdata["path"]);
	        delete_files($insertdata["smallpic"]);
	        echo json_encode($json,true);
	        die;
	    }
	   
	    $this->db->set($insertdata)->insert("exam_history_picture");
	    $json["status"]=1;
	    $json["message"]="上传成功";
	    
	    echo json_encode($json,true);
	  
	}
	public function cktelunique($phone=13825615708){
	    if($this->db->where("phone",$phone)->get("yy_teacher")->num_rows()||$this->db->where("phone",$phone)->get("yy_student")->num_rows()){
	        return true;
	    }
	    return false;
	}
	
	private function getRandomName($filename)
	{
	    $pos = strrpos($filename, ".");
	    $fileExt = strtolower(substr($filename, $pos));
	    return date("YmdHis").rand(1000, 9999).$fileExt;
	}
	
	private function _checkIsNeedToPerfectionUserInfo(){
	    $student=$this->db->where("id",$this->session->student['id'])->get("yy_student")->row();
	    if($student&&(
	        $student->sfz==""
	        ||$student->phone==""
    	    ||$student->email==""
    	    ||$student->realname==""
    	    ||$student->birthday=""
    	    ||$student->highest_education=""    	    
    	    ||$student->jiguan==""
    	    ||$student->current_job==""
    	    ||$student->current_city==""
    	    ||$student->work_or_stydy_units==""
    	    ||$student->my_zhiwu==""
    	    ||$student->my_address==""
    	    ||$student->zhong_yi_xue_xi_nian_xian==""
    	    ||$student->zyjczp==""
    	    ||$student->nbdsfx==""
    	    ||$student->zszc==""    	    
	        ||($student->customer_source!="system_admin"&&empty($student->zsdm))
//     	    ||$student->tui_jian_ren_name==""
//     	    ||$student->tui_jian_ren_work_units==""
//     	    ||$student->tui_jian_ren_contact_information==""
//     	    ||$student->tui_jian_ren_zhiwu==""
//     	    ||$student->study_exp1_date] =>
//     	    ||$student->study_exp2_date] =>
//     	    ||$student->study_exp3_date] =>
//     	    ||$student->study_exp4_date] =>
//     	    ||$student->study_exp1] =>
//     	    ||$student->study_exp2] =>
//     	    ||$student->study_exp3] =>
//     	    ||$student->study_exp4] =>
//     	    ||$student->study_exp1_zhiwu] =>
//     	    ||$student->study_exp2_zhiwu] =>
//     	    ||$student->study_exp3_zhiwu] =>
//     	    ||$student->study_exp4_zhiwu] =>
//     	    ||$student->grcs] =>
    	    ||$student->start_work_date==""
//     	    ||$student->workexp] =>
//     	    ||$student->xjd] =>
//     	    ||$student->txdz] =>
//     	    ||$student->xl] =>
//     	    ||$student->xxjl] =>
//     	    ||$student->gzjl] =>
//     	    ||$student->zyxxjl] =>
    	    ||$student->people==""
//     	    ||$student->headimg==""
//     	    ||$student->dylj] =>
//     	    ||$student->nldj] =>
//     	    ||$student->bmsj] =>
//    	    ||$student->grjl] =>
//     	    ||$student->zsdm] =>
//     	    ||$student->work_exp1_date] =>
//     	    ||$student->work_exp2_date] =>
//     	    ||$student->work_exp3_date] =>
//     	    ||$student->work_exp1] =>
//     	    ||$student->work_exp2] =>
//     	    ||$student->work_exp3] =>
//     	    ||$student->work_exp1_zhiwu] =>
//     	    ||$student->work_exp2_zhiwu] =>
//     	    ||$student->work_exp3_zhiwu] =>
//     	    ||$student->zhongyi_study_exp1_date] =>
//     	    ||$student->zhongyi_study_exp2_date] =>
//     	    ||$student->zhongyi_study_exp3_date] =>
//     	    ||$student->zhongyi_study_exp1] =>
//     	    ||$student->zhongyi_study_exp2] =>
//     	    ||$student->zhongyi_study_exp3] =>
//     	    ||$student->zhongyi_study_exp1_zhiwu] =>
//     	    ||$student->zhongyi_study_exp2_zhiwu] =>
//     	    ||$student->zhongyi_study_exp3_zhiwu] =>	        
	        )){
	        var_dump($student->sfz=="");
	        var_dump($student->phone=="");
	        var_dump($student->email=="");
	        var_dump($student->realname=="");
	        var_dump($student->birthday="");
	        var_dump($student->highest_education="");
	        var_dump($student->jiguan=="");
	        var_dump($student->current_job=="");
	        var_dump($student->current_city=="");
	        var_dump($student->work_or_stydy_units=="");
	        var_dump($student->my_zhiwu=="");
	        var_dump($student->my_address=="");
	        var_dump($student->zhong_yi_xue_xi_nian_xian=="");
	        var_dump($student->zyjczp=="");
	        var_dump($student->nbdsfx=="");
	        var_dump($student->zszc=="");
	        var_dump($student->tui_jian_ren_name=="");
	        var_dump($student->tui_jian_ren_work_units=="");
	        var_dump($student->tui_jian_ren_contact_information=="");
	        var_dump($student->tui_jian_ren_zhiwu=="");
	        var_dump($student->start_work_date=="");
	        var_dump($student->people=="");
	        
	        //exit;
	        return true;
	        
	    }
	    return false;
	}
}
