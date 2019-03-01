<?php

/**
 * @Author: assad
 * @Date:   2018-09-07 16:51:20
 * @Last Modified by:   assad
 * @Last Modified time: 2018-09-07 16:52:31
 */

defined('BASEPATH') or exit('No direct script access allowed');

class Postsm extends CI_Model
{
    public $table;

    public function __construct()
    {
        parent::__construct();
        $this->table = "wp_posts";
    }

    public function get_posts_by_id($id)
    {
        $posts = $this->db->select()->from($this->table)->where("ID", $id)->get()->row_array();
        return $posts ?: [];
    }
}
