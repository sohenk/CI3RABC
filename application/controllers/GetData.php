<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class getData extends CI_Controller {
    /**
     * 全局变量：
     * $router
     * $channelList
     * $channelDepthList
     */

	public function __construct() {
		parent::__construct();
	}
	public function getContentList(){

	//	header("ALLOW-CONTROL-ALLOW-ORIGIN:*");
	//	print_r($_SERVER);
		$returndata["status"]=0;
		$returndata["msg"]="参数不正确";
		$channelid=isset($_GET["cid"])?($_GET["cid"]):0;
// 		if(!$channelid){
// 			echo json_encode($returndata);
// 			die;
// 		}
		$channels = explode(",", $channelid);
		$count=isset($_GET["count"])?intval($_GET["count"]):10;
		$page=isset($_GET["page"])?intval($_GET["page"]):1;
		$pos=isset($_GET["pos"])?intval($_GET["pos"]):0;
		if($pos){
			$this->db->like("pos",$pos);
		}
		if($channelid){
			$this->db->where_in("cid",$channels);
		}
		$data=$this->db->where("state",1)->select("id,cid,thumb,title,tags,  from_unixtime(time,'%Y-%d-%m') as time,description")->order_by("order","desc")->order_by("time","desc")->order_by("id","desc")->get("cms_content",$count,$count*($page-1))->result_array();
// 		echo $this->db->last_query();
		if($data){
			$returndata["status"]=1;
			$returndata["msg"]="数据成功";
			$returndata["data"]=$data;
			$returndata["total"]=count($data);
			echo json_encode($returndata);
			die;
		}
		else{
			$returndata["status"]=0;
			$returndata["msg"]="到底啦！";
			echo json_encode($returndata);
			die;
		}
	}
	public function getContent(){
		$returndata["status"]=0;
		$returndata["msg"]="参数不正确";
		$id=isset($_GET["id"])?intval($_GET["id"]):0;
		if(!$id){
			echo json_encode($returndata);
			die;
		}
		$data=$this->db->where_in("id",$id)->where("state",1)->select("*,  from_unixtime(time,'%Y-%d-%m') as ftime")->get("cms_content")->row_array(0);
		if($data){
			$returndata["status"]=1;
			$returndata["msg"]="数据加载成功";
			$returndata["data"]=$data;
			$returndata["total"]=count($data);
			echo json_encode($returndata);
			die;
		}
		else{
			$returndata["status"]=0;
			$returndata["msg"]="哎呀文章找不到啦！";
			echo json_encode($returndata);
			die;
		}
	}
	public function getChannel(){
		$returndata["status"]=0;
		$returndata["msg"]="参数不正确";
		$id=isset($_GET["id"])?intval($_GET["id"]):0;
		if(!$id){
			echo json_encode($returndata);
			die;
		}
		$data=$this->db->where_in("id",$id)->get("cms_channel")->row_array(0);
		if($data){
			$returndata["status"]=1;
			$returndata["msg"]="数据加载成功";
			$returndata["data"]=$data;
			$returndata["total"]=count($data);
			echo json_encode($returndata);
			die;
		}
		else{
			$returndata["status"]=0;
			$returndata["msg"]="哎呀频道找不到啦！";
			echo json_encode($returndata);
			die;
		}
	}
}