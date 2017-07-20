<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Userm extends CI_Model
{
    public $table;

    public function __construct()
    {
        parent::__construct();
        $this->table = "user";
    }

    public function get_user_by_id($uid)
    {
        $user = $this->db->select()->from($this->table)->where("id", $uid)->get()->row_array();
        return $user ?: [];
    }
}
