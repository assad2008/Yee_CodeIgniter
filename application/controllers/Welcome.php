<?php
/**
* @file Welcome.php
* @synopsis  首页
* @author Yee, <rlk002@gmail.com>
* @version 1.0
* @date 2015-11-26 18:02:31
*/

defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends Application
{
	function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$this->cismarty->assign("time",time());
		$this->cismarty->display('welcome.tpl');
	}
}
