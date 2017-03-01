<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class MY_Controller extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->chkaccess();
		date_default_timezone_set('Asia/Shanghai');
		mb_internal_encoding("UTF-8");
		header("Content-type:text/html;charset=utf-8");
	}
	private function chkaccess(){
		if(!$this->session->userdata('logged_in')){
			$this->showerror("请先登录");
		}
	}
	public function showerror($msg,$link=""){
		if(!$link){
			$link="member";
		}
		redirect($link);
	}
	public function showInfo($msg,$url){
		echo '<script type="text/javascript">alert("'.$msg.'");</script>';
		echo "<meta http-equiv='Refresh' content='0;URL=".$url."'>";
	}

	public function showPrompt($v){
		echo '<script type="text/javascript">';
		echo "
				var value = prompt('".$v."：', '');  
    if(value == null){  
        alert('你取消了输入！');  
    }else if(value == ''){  
        alert('姓名输入为空，请重新输入！');  
        show_prompt();  
    }else{  
        alert('你好，'+value);  
    }  
				";
		
		echo '</script>';
// 		echo "<meta http-equiv='Refresh' content='0;URL=".$url."'>";
	}
	
	public function del(){
	    $id=isset($_GET["id"])?$_GET["id"]:redirect("admin");
	    $table=isset($_GET["table"])?$_GET["table"]:redirect("admin");
	     
	    $this->db->where("id",$id);
	    $this->db->delete($table);
	     
	    $this->showInfo("删除成功", $_SERVER["HTTP_REFERER"]);
	}
	
	/**
	 * 批量删除
	 */
	public function delAll(){
	    $idStr=isset($_GET["idStr"])?$_GET["idStr"]:redirect("admin");
	    $table=isset($_GET["table"])?$_GET["table"]:redirect("admin");
	
	    $ids=explode(',',$idStr);
	
	    $this->db->where_in("id",$ids);
	    $this->db->delete($table);
	
	    $this->showInfo("删除成功", $_SERVER["HTTP_REFERER"]);
	}
}


