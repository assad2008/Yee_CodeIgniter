<?php

/**
 * @Author: assad
 * @Date:   2018-09-07 16:51:20
 * @Last Modified by:   assad
 * @Last Modified time: 2019-11-11 12:26:25
 */

defined('BASEPATH') or exit('No direct script access allowed');

class Postsm extends My_Model {

	public function __construct() {
		parent::__construct();
		$this->tableName = "wp_posts";
		$this->dbConnect = $this->db;
	}

	public function get_posts_by_id($id) {
		$posts = $this->db->select()->from($this->_tableName)->where("ID", $id)->get()->row_array();
		return $posts ?: [];
	}
}
