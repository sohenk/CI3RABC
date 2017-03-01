<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * user class
 *
 * Manage logged user information.
 *
 * @package        	CodeIgniter
 * @subpackage    	Library
 * @category    	Library
 * @author        	Charles(xiezhenjiang@foxmail.com)
 * @license         http://www.gnu.org/licenses/gpl.html
 * @link			http://www.oserror.com
 */

class User
{
	
	/**
	 *@access private
	 */
	private $_CI;
	
	/**
	 * construct of user class
	 * @access public
	 */
	function __construct()
	{
		$this->_CI = &get_instance();
	}

	/**
	 * set user session
 	* @access public
 	* @param String $username username
 	*/
	function set_user_session($username)
	{
		$user['username'] = $username;
		$session = array('user'=>$user);
		
		$this->_CI->session->set_userdata($session);
	}
	
	/**
	 * delete user session
	 * @access public
	 */
	function delete_user_session()
	{
		$this->_CI->session->sess_destroy();
	}

	/**
	 * get user name
	 * @return username
	 */
	function getUserName()
	{
		$user = $this->_CI->session->userdata('username');
		$username = $user['username'];
		return $username;
	}

	/**
	 * get user id
	 * @return id
	 */
	function getUserId()
	{
		$user = $this->_CI->session->userdata('uid');
		$uid = $user;
		return $uid;
	}
	/**
	 * get user menu
	 * @access public
	 * @return user menus
	 */
	function getAllMenus()
	{
		$this->_CI->load->model('rbac_model');
		$uid = $this->getUserId();
		$menus = $this->_CI->rbac_model->getMenuList();
		return $menus;
	}
	/**
	 * get user menu
	 * @access public
	 * @return user menus
	 */
	function getUserMenus()
	{
		$this->_CI->load->model('rbac_model');
		$uid = $this->getUserId();
		$menus = $this->_CI->rbac_model->getUserMenuList($uid,0);
		return $menus;
	}
	/**
	 * check user privilege
	 * @access public
	 * @param String $action action
	 * @return true or false
	 */
	function checkPrivilege($controller,$method)
	{
		$this->_CI->load->model('rbac_model');
		$uid = $this->getUserId();
		$privilege = $this->_CI->rbac_model->checkUserPrivilege($uid, $controller,$method);
		
		return $privilege;
	}
	function get_user_ctr(){
	    $uid = $this->getUserId();
	    return $this->_CI->db->where("id",$uid)->get("user")->row(0)->isctrother;
	}
	protected function comm_cms_channel_list(){
	     
	}
}