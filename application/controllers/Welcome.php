<?php

/**
 * @Filename: Welcome.php
 * @Author: assad
 * @Date:   2017-08-21 11:38:48
 * @Synopsis: Welcome
 * @Version: 1.0
 * @Last Modified by:   assad
 * @Last Modified time: 2019-11-14 14:50:55
 * @Email: rlk002@gmail.com
 */

defined('BASEPATH') or exit('No direct script access allowed');

class Welcome extends Unlogined_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model("postsm");
	}

	public function index() {
		$post = $this->postsm->one(2);
		$this->view->assign("post", $post);
		$this->view->assign("welcome", "Welcome CodeIgniter");
		$this->view->display("main.html");
	}
}
