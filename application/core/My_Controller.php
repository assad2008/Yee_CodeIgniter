<?php

/**
 * @Filename: My_Controller.php
 * @Author: assad
 * @Date:   2017-08-21 11:31:03
 * @Synopsis: 核心控制器
 * @Version: 1.0
 * @Last Modified by:   assad
 * @Last Modified time: 2019-11-11 16:36:04
 * @Email: rlk002@gmail.com
 */

defined('BASEPATH') or exit('No direct script access allowed');

class My_Controller extends CI_Controller {

	public $db;
	public $baseUrl;
	public $view;

	public function __construct() {
		parent::__construct();
		$this->__init__();
	}

	private function __init__() {
		$this->db = $this->load->database('default', true);
		$this->load->driver('cache', array('adapter' => 'file'));
		$this->_view();
		$this->baseUrl = base_url();
		$this->view->assign('base_url', $this->baseUrl);
		$this->view->assign('systime', date('r'));
		$this->ismobile = $this->ua->is_mobile;
	}

	private function _view() {
		$this->config->load("twig");
		$view_config = $this->config->item("twig");
		$view_dir = $view_config["view_dir"];
		$options = [
			"cache" => $view_config["view_cache"],
			"debug" => true,
			"charset" => "UTF-8",
		];
		$params = ["view" => $view_dir, "options" => $options];
		$this->load->library('twig', $params);
		$this->view = $this->twig;
	}

	public function showmsg($messages, $urlForward = '', $second = 3) {
		if ($urlForward && empty($second)) {
			header("HTTP/1.1 301 Moved Permanently");
			header("Location: {$urlForward}");
		} else {
			if ($urlForward) {
				$message = "<font color=\"red\" size=\"5\"><b>{$messages}</b></font><script>setTimeout(\"window.location.href ='{$urlForward}';\", " . ($second * 1000) . ");</script>";
			}
			$this->view->assign('msg', $message);
			$this->view->assign('second', $second);
			$this->view->assign('message', $messages);
			$this->view->assign('content', "<a href=\"$urlForward\">" . $messages . "</a>");
			$this->view->assign('gourl', $urlForward);
			$this->view->display('message.html');
		}
		exit();
	}
}

/**
 * belongsto My_Controller.php
 * 登录前控制器
 *
 * @author     assad
 * @since      2019-11-11T16:33
 */
class Unlogined_Controller extends My_Controller {

	public $userInfo = [];

	public function __construct() {
		parent::__construct();
		$this->loginStatus();
		$this->userInfo && $this->view->assign("loginedUserInfo", $this->userInfo);
	}

	private function loginStatus() {
		if (!$this->session->userdata('loginedUserId')) {
			$this->userInfo = [];
		} else {
			$userId = $this->session->userdata('loginedUserId');
			$this->userInfo = $this->userm->one($userId);
		}
	}
}

/**
 * belongsto My_Controller.php
 * 登录后控制器
 *
 * @author     assad
 * @since      2019-11-11T16:33
 */
class Logined_Controller extends My_Controller {

	public $userInfo;

	public function __construct() {
		parent::__construct();
		$this->_checkLogin();
		$this->userInfo && $this->view->assign("loginedUserInfo", $this->userInfo);
	}

	private function _checkLogin() {
		if (!$this->session->userdata('loginedUserId')) { //未登录
			#TODO
		} else {
			$userId = $this->session->userdata('loginedUserId');
			$userInfo = $this->userm->one($userId);
			if (!$userInfo) {
				//未找到该用户
				$this->session->unset_userdata('loginedUserId');
				#TODO
			}
			$this->userInfo = $userInfo;
		}
	}
}
