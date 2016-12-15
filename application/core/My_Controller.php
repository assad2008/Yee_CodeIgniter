<?php
/**
* @file My_Controller.php
* @synopsis  核心控制器重写
* @author Yee, <rlk002@gmail.com>
* @version 1.0
* @date 2013-02-18 14:46:29
*/

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class My_Controller extends CI_Controller
{

	public $db;
	public $base_url;
	public $smarty;

	function __construct()
	{
		parent::__construct();
		$this->__init__();
	}

	private function __init__()
	{
		$this->db = $this->load->database('default',true);
		$this->load->driver('cache', array('adapter' => 'file'));
		$this->smarty = new Cismarty();
		$this->base_url = base_url();
		$this->smarty->assign('base_url',$this->base_url);	
		$this->smarty->assign('systime',date('r'));
		$this->ismobile = $this->agent->is_mobile;
	}
}
