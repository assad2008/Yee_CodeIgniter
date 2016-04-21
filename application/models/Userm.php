<?php
/**
* @file Userm.php
* @synopsis  用户模型
* @author Yee, <rlk002@gmail.com>
* @version 1.0
* @date 2016-03-30 16:28:27
*/

class Userm extends CI_Model
{
	function __construct()
	{

	}

	public function get_account_by_uid($uid)
	{
		$account = $this->dbr->select()->from('accounts')->where('uid',$uid)->get()->result_array();
		if($account && $a = $account[0])
		{
			return $a;
		}else
		{
			return [];
		}
	}

	public function get_account_by_phone($phone)
	{
		$account = $this->dbr->select()->from('accounts')->where('mobile',$phone)->get()->result_array();
		if($account && $a = $account[0])
		{
			return $a;
		}else
		{
			return [];
		}
	}

	public function get_account_by_name($accountname)
	{
		$account = $this->dbr->select()->from('accounts')->where('accountname',$accountname)->get()->result_array();
		if($account && $a = $account[0])
		{
			return $a;
		}else
		{
			return [];
		}
	}

	public function get_account_by_email($email)
	{
		$account = $this->dbr->select()->from('accounts')->where('email',$email)->get()->result_array();
		if($account && $a = $account[0])
		{
			return $a;
		}else
		{
			return [];
		}
	}

	public function update_account($params = [],$where = [])
	{
		if(!is_array($params))
		{
			return False;
		}
		foreach($params AS $pk => $pv)
		{
			$this->dbw->set($pk,$pv);
		}
		foreach($where AS $wk => $wv)
		{
			$this->dbw->where($wk,$wv);
		}
		$this->dbw->update('accounts');
		return $this->dbw->affected_rows();
	}
}

