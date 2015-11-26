<?php
/**
* @file MY_Controller.php
* @synopsis  自定义控制器
* @author Yee, <rlk002@gmail.com>
* @version 1.0
* @date 2015-11-26 17:38:22
*/

defined('BASEPATH') OR exit('No direct script access allowed');

class Application extends CI_Controller 
{

	function __construct()
	{
		parent::__construct();
		$this->load->driver('cache', array('adapter' => 'file'));
	}

}
