<?php
/**
* @file My_Controller.php
* @synopsis  核心控制器重写
* @author Yee, <rlk002@gmail.com>
* @version 1.0
* @date 2013-02-18 14:46:29
*/

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{

	public $db;
	public $base_url;
	public $smarty;
	public $ismobile;
	function __construct()
	{
		parent::__construct();
		$this->__init__();
	}

	private function __init__()
	{
		$this->db = $this->load->database('default',true);
		$this->load->driver('cache', array('adapter' => 'file'));
		$this->load->library('cismarty');
		$this->load->library('user_agent');
		$this->smarty = $this->cismarty;
		$this->base_url = base_url();
		$this->smarty->assign('siteurl',$this->base_url);	
		$this->smarty->assign('systime',date('r'));
		$this->ismobile = $this->agent->is_mobile;
	}
}

//未登录
class Unlogin_Controller extends My_Controller
{
	public $_uid;
	public $userinfo;
	function __construct()
  {
		parent::__construct();
		$this->loginstatus();
		$this->smarty->assign('uid',$this->_uid);
		$this->smarty->assign('userinfo',$this->userinfo);
	}

	private function loginstatus()
	{
		if(!$this->session->userdata('user_id'))
		{
			$this->_uid = 0;
		}else
		{
			$this->_uid = $this->session->userdata('user_id');
			$userinfo = $this->userm->get_account_by_uid($this->_uid);
			$this->userinfo = $userinfo;
		}	
	}
}


//登录
class Login_Controller extends My_Controller
{
	public $_uid;
	public $userinfo;
	function __construct()
  {
		parent::__construct();
		$this->_check_login();
		$this->smarty->assign('uid',$this->_uid);
		$this->smarty->assign('userinfo',$this->userinfo);
	}

	private function _check_login()
	{
		if(!$this->session->userdata('user_id'))
		{ 
			$this->_uid = 0;
			redirect($this->base_url . 'login');
		}
		else
		{
			$this->_uid = $this->session->userdata('user_id');
			$userinfo = $this->userm->get_account_by_uid($this->_uid);
			if(!$userinfo)
			{
				$this->session->unset_userdata('user_id');
				redirect(base_url());
			}
			$this->userinfo = $userinfo;
		}
	}	
}
