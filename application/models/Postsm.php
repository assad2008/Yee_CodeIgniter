<?php

/**
 * @Author: assad
 * @Date:   2018-09-07 16:51:20
 * @Last Modified by:   assad
 * @Last Modified time: 2019-11-14 14:44:20
 */

defined('BASEPATH') or exit('No direct script access allowed');

class Postsm extends My_Model {

	protected $tableName = "wp_posts";

	public function __construct() {
		parent::__construct();
	}
}
