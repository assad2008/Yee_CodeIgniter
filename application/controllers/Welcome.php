<?php
/**
* @file Welcome.php
* @synopsis  默认路由
* @author Yee, <rlk002@gmail.com>
* @version 1.0
* @date 2016-04-21 11:18:01
*/

defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends Unlogin_Controller
{
	function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$this->smarty->display('welcome.html');
	}
}
