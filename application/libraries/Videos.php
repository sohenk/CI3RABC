<?php defined('BASEPATH') OR exit('No direct script access allowed');



class Teachers
{
	
	/**
	 *@access private
	 */
	private $_CI;

	private $db;
	
	/**
	 * construct of user class
	 * @access public
	 */
	function __construct()
	{
		$this->_CI = &get_instance();
		$this->db =$this->_CI ->db;
	}

	/*
	 * 获取教师
	 * 
	 */
	function getTeacher($tid){
		return $this->db->where("id",$tid)->get("yy_teacher")->row(0);;
	}
	/*
	 * 获取教师信息
	 */
	public function getTeacherProfile($tid){

		return $this->db->where("teacherid",$tid)->get("yy_teacherdata")->row(0);;
	}

	/*
	 * 获取教师上传附件
	*/
	public function getTeacherAttachments($tid){
	
		return $this->db->where("teacherid",$tid)->get("yy_teacherattachments")->result();;
	}


	/*
	 * 获取教师的学生
	*/
	public function getTeacherStudents($tid){
	
		return $this->db->where("teacherid",$tid)->get("yy_student")->result();
	}
	/**
	 * 重置密码请求
	 *
	 * @param $email $id
	 */
	public function sendResetPasswordUrl($id,$email){
	    $student=$this->db->where("id",$id)->where($email)->where("status",1)->get("yy_teacher")->row(0);
	    if($student){
	        $now=time();
	        if($student->resettime){
	            //修改密码有效期3天
	            if(($now-$student->resettime)>3600*24*3){
	                $this->db->set("resettime",$now)->where("id",$id)->update("yy_teacher");
	            }
	            else{
	                $now=$student->resettime;
	            }
	        }
	        $returndata["uid"]=$student->id;
	        $returndata["sign"]=newbase64_en($now);
	        return $returndata;
	    }
	    else{
	        return false;
	    }
	}
	/**
	 * 重置密码
	 * @param $sign $uid $password
	 * @return boolean
	 */
	public function resetPassword($uid,$password){
	    $this->db->set("resettime","")->set("pwd",md5($password))->update("yy_teacher");
	    $student=$this->db->where("id",$uid)->get("yy_teacher")->row_array(0);
	    if($student){
	        $this->set_sutdent_session($student);
	        return $student;
	    }
	    else{
	        return false;
	    }
	}
	/**
	 * 验证url
	 * @param url标识 $sign
	 * @param 用户id $uid
	 * @return boolean
	 */
	public function validReseturl($sign,$uid){
	    $where["resettime"]=newbase64_de($sign);
	    $where["id"]=$uid;
	    $student=$this->db->where($where)->get("yy_teacher")->row(0);
	    if($student){
	        return true;
	    }
	    else{
	        return false;
	    }
	}
}