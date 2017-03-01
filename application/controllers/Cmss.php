<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class cmss extends MY_Controller {

	var $router;
	
	public function __construct() {
		parent::__construct();
// 		echo $this->router->class.$this->router->method;
		if($this->user->checkPrivilege($this->router->class,$this->router->method) == false)
		{
			show_error("你没有权限进入");
			return ;
		}
		$this->router=array($this->router->class,$this->router->method);
	}
    public function channellist()
	{
		
	    $data["privilegesign"]=$this->router;
	    $this->load->view("admin/menulist",$data);
	}
}