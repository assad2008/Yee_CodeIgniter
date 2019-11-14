<?php

/**
 * @Filename: My_Controller.php
 * @Author: assad
 * @Date:   2017-08-21 11:31:03
 * @Synopsis: 核心控制器
 * @Version: 1.0
 * @Last Modified by:   assad
 * @Last Modified time: 2019-11-14 22:43:20
 * @Email: rlk002@gmail.com
 */

defined('BASEPATH') or exit('No direct script access allowed');

class My_Controller extends CI_Controller {

	public $baseUrl;
	public $view;

	/**
	 * belongsto My_Controller.php
	 * 构造函数
	 *
	 * @author     assad
	 * @since      2019-11-14T22:40
	 */
	public function __construct() {
		parent::__construct();
		$this->__init__();
	}

	/**
	 * belongsto My_Controller.php
	 * 初始化相关参数以及功能
	 *
	 * @author     assad
	 * @since      2019-11-14T22:40
	 */
	private function __init__() {
		$this->baseUrl = base_url();
		$this->ismobile = $this->ua->is_mobile;
		$this->load->driver('cache', array('adapter' => 'file'));
		$this->_view();
		$this->_assign();
	}

	/**
	 * belongsto My_Controller.php
	 * 加载Twig视图
	 *
	 * @author     assad
	 * @since      2019-11-14T22:40
	 */
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

	/**
	 * belongsto My_Controller.php
	 * 输入基础变量到视图
	 *
	 * @author     assad
	 * @since      2019-11-14T22:41
	 */
	protected function _assign() {
		$this->view->assign('base_url', $this->baseUrl);
	}

	/**
	 * belongsto My_Controller.php
	 * 消息提示，公共调用
	 *
	 * @param      string   $messages    The messages
	 * @param      string   $urlForward  The url forward
	 * @param      integer  $second      The second
	 *
	 * @author     assad
	 * @since      2019-11-14T22:41
	 */
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
 * 未登录控制器
 *
 * @author     assad
 * @since      2019-11-11T16:33
 */
class Unlogined_Controller extends My_Controller {

	public $userInfo = [];

	/**
	 * belongsto My_Controller.php
	 * 构造函数
	 *
	 * @author     assad
	 * @since      2019-11-14T22:42
	 */
	public function __construct() {
		parent::__construct();
		$this->loginStatus();
		$this->userInfo && $this->view->assign("loginedUserInfo", $this->userInfo);
	}

	/**
	 * belongsto My_Controller.php
	 * 检查用户登录状态
	 *
	 * @author     assad
	 * @since      2019-11-14T22:42
	 */
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

	/**
	 * belongsto My_Controller.php
	 * 构造函数
	 *
	 * @author     assad
	 * @since      2019-11-14T22:43
	 */
	public function __construct() {
		parent::__construct();
		$this->_checkLogin();
		$this->userInfo && $this->view->assign("loginedUserInfo", $this->userInfo);
	}

	/**
	 * belongsto My_Controller.php
	 * 检查用户是否登录
	 *
	 * @author     assad
	 * @since      2019-11-14T22:43
	 */
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
