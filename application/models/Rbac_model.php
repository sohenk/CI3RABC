<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Rbac model
 *
 * Manage Rbac model related table.
 *
 * @package        	CodeIgniter
 * @subpackage    	Model
 * @category    	Model
 * @author        	Charles(xiezhenjiang@foxmail.com)
 * @license         http://www.gnu.org/licenses/gpl.html
 * @link			http://www.oserror.com
 */

class Rbac_model extends CI_Model
{

	/**
 	 * @access public
 	 * @param String $username username
 	 * @param String $password password
 	 * @return 1:username not match password 2:user has no privilege to login 100:successfully login
 	 */
	function validateUser($username, $password)
	{
		$this->db->where('user_name', $username);
		$this->db->where('user_pass', $password);
	
		$query = $this->db->get('user');
	
		if($query->num_rows() == 0)
		{
			return 1;
		}
		else
		{
			//get the privilege of this user
			$user = $query->first_row();
			$user_shortname = $this->_getUserPriviledge($user->role_id);
		
			if($user_shortname == 'admin' || $user_shortname == 'editor')
			{
				return 100;
			}
			else
			{
				return 2;
			}	
		}
	}

	/**
	 * get user priviledge
	 * @access private
	 * @param Integer $role_id role id
	 * @return role shortname
 	 */
	function _getUserPriviledge($role_id)
	{
		$this->db->where('role_id', $role_id);
	
		$query = $this->db->get('role');
		if($query->num_rows())
		{
			return $query->first_row()->role_shortname;
		}
		else
		{
			return false;
		}
	}
	
	/**
	 * get user information
	 * @param String $username username
	 * @return user information
 	 */
	function getUserByUsername($username)
	{
		$this->db->where('user_name', $username);
		
		$query =  $this->db->get('user');
		if($query->num_rows() > 0)
		{
			return $query->first_row();
		}
		else
		{
			return false;
		}
	}
	
	
	
	/**
	 * check user privilege
	 * @access public
	 * @param String $username username
	 * @param String $action privilege action
	 * @return false or true
	 */
	function checkUserPrivilege($uid, $controller,$method)
	{
		$sql = "SELECT menu.* FROM `user`,`role`,roleprivilege,menu WHERE user.id=$uid AND user.role_id=role.role_id AND role.role_id=roleprivilege.role_id AND roleprivilege.menu_id =menu.menu_id AND menu.menu_controller =  '$controller' and menu.menu_method='$method'";
		
		$query = $this->db->query($sql);
		if($query->num_rows() > 0)
		{
			return true;
		}
		else 
		{
			return false;
		}
	}

	/* 
	获取菜单列表
	 */
	function getMenuList($pid=0){
		
		
		$result=$this->db->where("parent_id",$pid)->order_by("menu_id","asc")->get("menu")->result_array();
		$menu=array();
		if($result){
			foreach($result as $k=>$v){
				$menuchild["item"]=$v;
				if($this->getMenuList($v["menu_id"])){
					$menuchild["children"]=$this->getMenuList($v["menu_id"]);
				}
				else{
					unset($menuchild["children"]);
				}

				$menu[]=$menuchild;
			}
		}
		
		
		return $menu;
	}

	/*
	 获取用户菜单列表
	*/
	function getUserMenuList($uid,$pid){
		
		
		
		$result=$this->db->query("SELECT menu.* FROM `user`,`role`,roleprivilege,menu WHERE user.id=$uid AND user.role_id=role.role_id AND role.role_id=roleprivilege.role_id AND roleprivilege.menu_id =menu.menu_id AND menu.is_show=1 AND menu.parent_id=$pid order by menu.menu_id asc")->result_array();
		$menu=array();
		if($result){
			foreach($result as $k=>$v){
				$menuchild["item"]=$v;
				
				if($v["menu_action"]){
					$menuchild["children"]=$this->tellAction($v["menu_action"]);
				}
				else{
					unset($menuchild["children"]);
					if($this->getMenuList($v["menu_id"])){
						$menuchild["children"]=$this->getUserMenuList($uid,$v["menu_id"]);
					}
					else{
						unset($menuchild["children"]);
					}
				}
		
				$menu[]=$menuchild;
			}
		}
		
		
		return $menu;
		
		
		
// 		$menuresult=$this->db->query("SELECT menu.* FROM `user`,`role`,roleprivilege,menu WHERE user.id=$uid AND user.role_id=role.role_id AND role.role_id=roleprivilege.role_id AND roleprivilege.menu_id =menu.menu_id AND menu.is_show=1")->result();
// 		$menu=$this->sortUserMenu($menuresult);
		// 		$this->db->
	}

	public function comm_cms_channel_list($pid){		
		$result=$this->db->select("cms_channel.id as menu_id,cms_channel.name as menu_title,cms_channel.parentid as parent_id")->where("cms_channel.parentid",$pid)->get("cms_channel")->result_array();
		$menu=array();
		if($result){
			foreach($result as $k=>$v){
				$v["menu_controller"]="cms";
				$v["menu_method"]="contentlist";
				$v["menu_param"]="/".$v["menu_id"];
				
				$menuchild["item"]=$v;
				if($this->comm_cms_channel_list($v["menu_id"])){
					$menuchild["children"]=$this->comm_cms_channel_list($v["menu_id"]);
				}
				else{
					unset($menuchild["children"]);
				}
				
				$menu[]=$menuchild;
			}
		}
		
		return $menu;
		
	}
	public function comm_cms_videotype_list($pid){
	    $result=$this->db->select("yy_videotype.id as menu_id,yy_videotype.name as menu_title,yy_videotype.parentid as parent_id")->where("yy_videotype.parentid",$pid)->get("yy_videotype")->result_array();
	    $menu=array();
	    if($result){
	        foreach($result as $k=>$v){
	            $v["menu_controller"]="video";
	            $v["menu_method"]="contentlist";
	            $v["menu_param"]="/".$v["menu_id"];
	
	            $menuchild["item"]=$v;
	            if($this->comm_cms_videotype_list($v["menu_id"])){
	                $menuchild["children"]=$this->comm_cms_videotype_list($v["menu_id"]);
	            }
	            else{
	                unset($menuchild["children"]);
	            }
	
	            $menu[]=$menuchild;
	        }
	    }
	
	    return $menu;
	
	}
	
	
	private function tellAction($action){		
		$data=$this->$action(0);
		return $data;
	}
	
}