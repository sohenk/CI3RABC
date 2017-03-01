<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class cms extends MY_Controller {
    /**
     * 全局变量：
     * $router
     * $channelList
     * $channelDepthList
     */

	public function __construct() {
		parent::__construct();
// 		echo $this->router->class.$this->router->method;
		if($this->user->checkPrivilege($this->router->class,$this->router->method) == false)
		{
			show_error("你没有权限进入");
			return ;
		}
		$this->router=array($this->router->class,$this->router->method);
		
		$this->channelDepthList=array();
		$ch=$this->db->get("cms_channel")->result();		
		$groupChannelMap=$this->get_group_channel_map($ch);
		
		$topChanelList=count($groupChannelMap)>0?$groupChannelMap[0]:array();
		$channelList=array();
		$topChannelIds=array();
		foreach ($topChanelList as $key=>$val){
		    $topChannelIds[]=$val->id;
		    $channelList[]=$this->get_channel_tree($val,$groupChannelMap);
		}
		$this->channelList=$channelList;		
	}
	
	public function channellist()
	{
		$this->db->order_by("id","asc");
		$data['category']=$this->db->get("cms_channel")->result_array();		
		$this->load->library('Tree', $data['category']);
		$data['category']= $this->tree;
		
	    $data["menu"]="channel";
	    $data["submenu"]="channel";
	    $this->load->view("admin/cms/channellist-tree",$data);
	}
	
	public function addchannel(){
	    if($_SERVER['REQUEST_METHOD']!="POST"){
	        $data["cms_action"]="new";	      
	        $data["cms_menu"]="channel";
	        
	        $this->load->view('admin/cms/channelprofile',$data);	        
	    }else{
	        $postdata=isset($_POST)?$_POST:die("非法操作");
	        $data["cms_action"]=$this->uri->segment(3);
	        $this->db->set($postdata);
	        $this->db->insert("cms_channel");
	        $id=$this->db->insert_id();
	         
	        redirect("cms/channellist");	        
	    }
	}
	
	public function editchannel(){	    
	    if($_SERVER['REQUEST_METHOD']!="POST"){
    	    $data["cms_action"]="edit";
    	    $id=isset($_GET["id"])?($_GET["id"]):0;
    	    
    	    if(!$id){
    	        $this->showerror("非法ID闯入");
    	        die("");
    	    }
    	    
    	    $this->db->where("id",$id);
    	    $data["cms_curchannel"]=$this->db->get("cms_channel")->row();
    	    $this->db->where("id !=",$id);
    	    
    	    $data["cms_channellist"]=$this->db->get("cms_channel")->result();    	    
    	    $data["cms_menu"]="channel";
    	    $this->load->view('admin/cms/channelprofile',$data);
	    }else{
	        $postdata=isset($_POST)?$_POST:die("非法操作");	       
	        $this->db->set($postdata);
	        $id=$_POST["id"];
	        $this->db->where("id",$id);
	        $this->db->update("cms_channel");
    
	        redirect("cms/channellist");
	    }
	}
	
	public function delchannel(){
	    $this->del();
	}
		
	public function contentlist()
	{
// 		print_r($_SESSION);
// 		die;
	    $channelid= ($this->uri->segment(3));
	    $channelid=intval($channelid)>0?intval($channelid):0;
	    $channelid= isset($_REQUEST["channelid"])?intval($_REQUEST["channelid"]):$channelid;
	    $page= isset($_GET["per_page"])?$_GET["per_page"]:1;
	    $page=isset($page)?$page:1;
	
	    $this->load->library('pagination');
	    $where=array();
	    if($channelid>0){
	        $base_url=site_url("cms/contentlist/$channelid");
	        $where="`cid` = '".$channelid."'";
	    }else{
	        $base_url=site_url("cms/contentlist");
	    }
	
	    if(isset($_REQUEST["search"])){
	        $search=trim($_REQUEST["search"]);
	        $base_url.="?search=".$search;
	        if(!is_array($where)){
	            $where.=" AND ";
	        }else{
	            $where="";
	        }
	        
	        $where.=" (`title` like '%".$search."%'";
	        $where.=" OR `content` like '%".$search."%')";
	    }
	    
	    if(!$this->user->get_user_ctr()){
	        if(!is_array($where)){
	            $where.=" AND ";
	            $where.=" `uid` = " .$this->user->getUserId();
	        }
	        if(empty($where)){
	            $where=" `uid` = " .$this->user->getUserId();
	        }
	    }
	    $this->db->where($where);
	    $totalRows=$this->db->count_all("cms_content");
	
	    $config['use_page_numbers'] = TRUE;
	    $config['page_query_string'] = TRUE;
	    $config['base_url'] = $base_url;
	    $config['total_rows'] = $totalRows;
	    $config['per_page'] = 20;
	    $config['first_link'] = '‹ 第一页';
	    $config['last_link'] = '最后一页 ›';
	    $this->pagination->initialize($config);
	
	    $data["page"]= $this->pagination->create_links();
	
	    $this->db->where($where);
	    $cms_contentlist=$this->db->order_by("order","DESC")->order_by("time","DESC")->get("cms_content",$config['per_page'],$config['per_page']*($page-1))->result();
	   	    
	    $data["cms_contentlist"]=$cms_contentlist;
	
	    $data["cms_channelitem"]=$this->db->where("id",$channelid)->get("cms_channel")->row();
	   

	    
	    $this->load->view("admin/cms/contentlist",$data);
	}
	
	public function addcontent(){	   
		 if($_SERVER['REQUEST_METHOD']!="POST"){	      	        
	        $channelid= intval($this->uri->segment(3));
// 	        if(!$channelid){
// 	            $this->showInfo("请选择栏目", site_url("cms"));
// 	        }	       
	        
	        $data["cms_channelitem"]=$this->db->where("id",$channelid)->get("cms_channel")->row();
	        $this->load->view('admin/cms/contentprofile',$data);	        
	    }else{
	        $postdata=isset($_POST)?$_POST:$this->showerror("非法操作");	        
	        $channelid= intval($this->uri->segment(3));
	        if(!$channelid){
	            $this->showInfo("非法操作", site_url("cms"));
	            die;
	        }
	        
	        $postdata=isset($_POST)?$_POST:die("非法操作");	
	        $postdata["uid"]=$_SESSION["uid"];
	        if(!$postdata["uid"]){
	            $this->showInfo("非法操作", site_url("cms"));
	            die;
	        }
	        $this->db->set($postdata);
	        $this->db->set(array("time"=>time(),"author"=>$this->session->userdata("username")));
	        $this->db->insert("cms_content");
	        $id=$this->db->insert_id();
	            
	        redirect("cms/contentlist/".$postdata['cid']);	        
	    } 
	}
	
	public function editcontent(){	    
	    if($_SERVER['REQUEST_METHOD']!="POST"){      
	        $channelid= intval($this->uri->segment(3));
	        $id=isset($_GET["id"])?($_GET["id"]):0;
	        if($id){
	           $this->db->where("id",$id);
	           $data["coupon"]=$this->db->get("cms_content")->row();
	        }else{
	           $this->showerror("非法ID闯入");
	           die("");
	         }
	          
	        $data["cms_channelitem"]=$this->db->where("id",$channelid)->get("cms_channel")->row();
	        $this->load->view('admin/cms/contentprofile',$data);
	    }else{
	        $postdata=isset($_POST)?$_POST:$this->showerror("非法操作");	         
	        $channelid= intval($this->uri->segment(3));
	        if(!$channelid){
	            $this->showInfo("非法操作", site_url("cms"));
	        }
	         
	        $postdata=isset($_POST)?$_POST:die("非法操作");
	         
	        $this->db->set($postdata);	       
	        $id=$_POST["id"];
	        $this->db->where("id",$id);$this->db->update("cms_content");
	        redirect("cms/contentlist/".$postdata['cid']);
	    }
	}
	
	public function delcontent(){
	    $this->del();
	}	
	
	private function get_group_channel_map($channelList){
	    $channelMap=array();
	    foreach ($channelList as $key=>$val){
	        if(!isset($channelMap[$val->parentid])){	            
	            $channelMap[$val->parentid]=array();	            
	        }
	        $channelMap[$val->parentid][]= $val;
	    }
	    return $channelMap;
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
}
