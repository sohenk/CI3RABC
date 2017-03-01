<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class admin extends MY_Controller {

	var $router;
	
	public function __construct() {
		parent::__construct();
// 		echo $this->router->class.$this->router->method;
		if($this->user->checkPrivilege($this->router->class,$this->router->method) == false)
		{
			showInfo("你没有权限进入");
			return ;
		}
		$this->router=array($this->router->class,$this->router->method);
	}
	
	
	public function index()
	{
		$this->load->view("admin/index");
		
	}
	
	public function menulist(){

		$data["privilegesign"]=$this->router;

		
		$this->load->view("admin/menulist",$data);
	}
	

	public function menuprofile(){
		$data["privilegesign"]=$this->router;
		
		
		$data["action"]=$this->uri->segment(3);

		if($_POST){
			switch($data["action"]){
				case "edit":{

					$id=$_POST["menu_id"];

					if($id){
						$this->db->set($_POST);
						$this->db->where("menu_id",$id);
						$this->db->update("menu");
						// 				print_r($data["term"]);;
					}
					else{
						die("非法ID闯入");
						die("");
					}
				}break;
				case "new":{
					$this->db->set($_POST);
					$this->db->insert("menu");
				}break;
// 				default :redirect("admin/menulist");return;
			}

			redirect("admin/menulist");
		}
		
		 
		switch($data["action"]){
			case "edit":{
				$id=($this->uri->segment(4));
				
				if($id){
					$this->db->where("menu_id",$id);
					$data["coupon"]=$this->db->get("menu")->row();
					// 				print_r($data["term"]);;
				}
				else{
					showInfo("非法ID闯入");
					die("");
				}
			}break;
			case "del":{
				$id=($this->uri->segment(4));
				if($id){
					if($this->db->where("parent_id",$id)-> get("menu")->num_rows()){
						showInfo("该菜单下还有子菜单，不能删除");
						die;
					}
				}
				else{
					showInfo("非法错误");
					die;
				}
				$this->db->where("menu_id",$id)-> delete("menu");
				redirect("admin/menulist");
				die();
			}
		}
		 
		$this->load->view("admin/menuprofile",$data);
	}
	
	public function rolelist(){
		$data["privilegesign"]=$this->router;
		$data["term"]=$this->db->get("role")->result();
		$data["page"]="";
		$this->load->view("admin/rolelist",$data);
	}
	
	public function roleprofile(){
		$data["privilegesign"]=$this->router;
		
		$data["action"]=$this->uri->segment(3);
	
		if($_POST){
			switch($data["action"]){
				case "edit":{
	
					$id=$_POST["role_id"];
	
					if($id){
						$this->db->set($_POST);
						$this->db->where("role_id",$id);
						$this->db->update("role");
						// 				print_r($data["term"]);;
					}
					else{
						die("非法ID闯入");
						die("");
					}
				}break;
				case "new":{
					$this->db->set($_POST);
					$this->db->insert("role");
				}break;
				// 				default :redirect("admin/menulist");return;
			}

			redirect("admin/rolelist");
		}
	
			
		switch($data["action"]){
			case "edit":{
				$id=($this->uri->segment(4));
	
				if($id){
					$this->db->where("role_id",$id);
					$data["term"]=$this->db->get("role")->row_array();
					// 				print_r($data["term"]);;
				}
				else{
					die("非法ID闯入");
					die("");
				}
			}break;
			case "del":{
				$id=($this->uri->segment(4));
				if($id){
					if($this->db->where("role_id",$id)-> get("user")->num_rows()){
						showInfo("该角色还有用户，不能删除");
						die;
					}
				}
				else{
					showInfo("非法错误");
					die;
				}
				$this->db->where("role_id",$id)-> delete("role");
				redirect("admin/rolelist");
				die();
			}	
		}
			
		$this->load->view("admin/roleprofile",$data);
	}
	/* 
	权限管理方法
	 */
	public function roleprivilege(){

		$data["privilegesign"]=$this->router;
		
		if($_POST){
			
			$this->db->where("role_id",$_POST["role_id"])->delete("roleprivilege");
			$menuids=explode(",", $_POST["menuid"]);
// 			print_r($menuids);
			foreach($menuids as $v){
				$this->db->set(array("role_id"=>$_POST["role_id"],"menu_id"=>$v))->insert("roleprivilege");
			}
			redirect("admin/rolelist");
		}
		
		$id=($this->uri->segment(3));
		if(!$id){die("非法操作");}
		$data["roleprivilege"]=$this->db->where("role_id",$id)->get("roleprivilege")->result_array();
		
		$menuidarray=$this->db->where("role_id",$id)->select("menu_id")->get("roleprivilege")->result();
		$data["menuarray"]=array();
		if($menuidarray){
			foreach($menuidarray as $v){
// 				print_r($v);
				$data["menuarray"][]=$v->menu_id;
			}
			
		}
// 		print_r($data["menuarray"]);
		$data["term"]["id"]=$id;
		$this->load->view("admin/roleprivilege",$data);
	}
	public function adminuserlist(){
		$data["privilegesign"]=$this->router;
		
		$data["term"]=$this->db->select("user.*,role.role_name as rolename")->join("role","user.role_id=role.role_id")->get("user")->result();
		$this->load->view("admin/adminuserlist",$data);	
	}
	public function adminuserprofile(){
		$data["privilegesign"]=$this->router;
		
		$data["action"]=$_GET["action"];
		
		if($_POST){
			$postdata=isset($_POST)?$_POST:showInfo("非法操作");
// 			print_r($postdata);die;
			$pwd=isset($postdata["pwd"])?$postdata["pwd"]:"";
			if($pwd){
				$postdata["pwd"]=md5($postdata["pwd"]);
			}
			else{
				unset($postdata["pwd"]);
			}
			$this->db->set($postdata);
			switch ($_GET["action"]){
				case "new":$this->db->insert("user");$id=mysql_insert_id();break;
				case "edit":$id=$_POST["id"];$this->db->where("id",$id);$this->db->update("user");break;
				default:showInfo("非法操作");break;
			}
// 					die($this->db->last_query());
			redirect("admin/adminuserlist");
		}
		if($this->uri->segment(3)=="del"){
			$id=($this->uri->segment(4));
			if(!$id){
				showInfo("非法错误");
				die;
			}
			$this->db->where("id",$id)-> delete("user");
			redirect("admin/adminuserlist");
			die();
		}
		
		
		if($data["action"]=="edit"){
	
			$id=isset($_GET["id"])?($_GET["id"]):0;
	
			if($id){
				$this->db->where("id",$id);
				$data["term"]=$this->db->get("user")->row_array();
				// 				print_r($data["term"]);;
			}
			else{
				showInfo("非法ID闯入");
				die("");
			}
		}
		$data["role"]=$this->db->get("role")->result();
		$this->load->view('admin/adminuserprofile',$data);
	
	}
	
	public function del(){
	    $id=isset($_GET["id"])?$_GET["id"]:redirect("admin");
	    $table=isset($_GET["table"])?$_GET["table"]:redirect("admin");
	     
	
	    $this->db->where("id",$id);
	
	    $this->db->delete($table);
	     
	     
	    $this->showInfo("删除成功", $_SERVER["HTTP_REFERER"]);
	}
}
