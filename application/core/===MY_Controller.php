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
			$link=site_url("member");
		}
		redirect($link);
		echo '<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">';
		echo '<div style="text-align: center;padding: 20px;margin: 10px;border: 1px solid #D0D0D0;background:rgb(57, 160, 123);
color: #fff;-webkit-box-shadow: 0 0 8px #4CFF70;"><h2>';
		echo $msg;
		echo '</h2><a style="color:#fff;text-decoration: none; "  href="javascript:void(0);" onclick="history.back(-1);">点击返回上一页</a></div>';
		die;
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


class Front_Controller extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		date_default_timezone_set('Asia/Shanghai');
		mb_internal_encoding("UTF-8");
		header("Content-type:text/html;charset=utf-8");
		
		$this->channelDepthList=array();
		$this->channelMap=array();
		$ch=$this->db->get("cms_channel")->result();
		
		foreach ($ch as $channel){
			$this->channelMap[$channel->id]=clone $channel;
		}
		
		$groupChannelMap=$this->get_group_channel_map($ch);
		
		$topChanelList=count($groupChannelMap)>0?$groupChannelMap[0]:array();
		$channelList=array();
		foreach ($topChanelList as $key=>$val){
			$channelList[]=$this->get_channel_tree($val,$groupChannelMap);
		}
		
		$curChannelId=0;
		if($this->uri->segment(2)=="channel"||$this->uri->segment(2)=="newestnews"){
			$curChannelId=intval($this->uri->segment(3));
		}
		
		$this->channelList=$channelList;
		$this->curChannel=$this->channelList[0];
		if(isset($this->channelMap[$curChannelId])){
			$this->curChannel=$this->channelMap[$curChannelId];
		}		
		
	}
	/**
	 * 检测是否登陆并且跳转到相应的地址
	 * @param string $url
	 * @param boolean $isRedirect 
	 * @return boolean
	 */
	public function checkUserAndRedircect($url="",$isRedirect=1){
	   if($this->session->student||$this->session->teacher){
	       if($isRedirect){
	           redirect($url);
	       }
		}
		else{
		   if(!$isRedirect){
	           redirect($url);
	       }
		}
	}
	
	private function get_channel_tree($channel,$groupChannelMap){
		if(isset($this->topChannelMap[$channel->parentid])){
			$channel->depth=$this->topChannelMap[$channel->parentid]->depth+1;
		}else{
			$channel->depth=0;
		}
		 
		$this->topChannelMap[$channel->id]=$channel;
		 
		$this->channelDepthList[]=clone $channel;
		if(isset($groupChannelMap[$channel->id])){
			$channel->children=$groupChannelMap[$channel->id];
			foreach ($channel->children as $key=>$val){
				$val=$this->get_channel_tree($val,$groupChannelMap);
			}
		}
		 
		return $channel;
	}
	
	
	
	private function get_group_channel_map($channelList){
		$channelMap=array();
		foreach ($channelList as $key=>$val){
			if($val->visible){
				if(!isset($channelMap[$val->parentid])){
					$channelMap[$val->parentid]=array();
				}
				$channelMap[$val->parentid][]= $val;
			}
		}
		 
		return $channelMap;
	}
}