<?php

/**
 * @Filename: My_Controller.php
 * @Author: assad
 * @Date:   2019-11-10 22:28:58
 * @Synopsis: 核心Model
 * @Version: 1.0
 * @Last Modified by:   assad
 * @Last Modified time: 2019-11-14 22:47:41
 * @Email: rlk002@gmail.com
 */

defined('BASEPATH') or exit('No direct script access allowed');

class My_Model extends CI_Model {

	public $timeStamp;

	protected $tableName;
	protected $primaryKey = 'id';
	protected $returnType = 'array';
	protected $dbConnect = 'default';

	private $dataBase;

	public function __construct() {
		parent::__construct();
		$this->getDbConnect();
		$this->fetchPrimaryKey();
		$this->timeStamp = time();
	}

	/**
	 * belongsto My_Model.php
	 * 根据主键查询一条数据
	 *
	 * @param      integer  $id     主键值
	 *
	 * @return     array|boolean  查询数据
	 *
	 * @author     assad
	 * @since      2019-11-11T11:49
	 */
	public function one($id) {
		if (!$id) {
			return false;
		}
		return $this->_getBy($this->primaryKey, $id);
	}

	/**
	 * belongsto My_Model.php
	 * 根据条件得到一条数据
	 *
	 * @param      array    $where  The where
	 *
	 * @return     array|boolean  查询数据
	 *
	 * @author     assad
	 * @since      2019-11-11T11:49
	 */
	public function first($where = []) {
		if (!$where) {
			return false;
		}
		return $this->_getBy($where);
	}

	/**
	 * belongsto My_Model.php
	 * 查询逻辑
	 *
	 * @return     array  结果
	 *
	 * @author     assad
	 * @since      2019-11-11T11:51
	 */
	protected function _getBy() {
		$where = func_get_args();
		$this->_setWhere($where);
		$row = $this->dataBase->get($this->tableName)
			->{$this->_returnType()}();
		return $row;
	}

	/**
	 * belongsto My_Model.php
	 * 查询多条数据
	 *
	 * @return     array  查询结果
	 *
	 * @author     assad
	 * @since      2019-11-11T11:51
	 */
	public function gets() {
		$where = func_get_args();
		$this->_setWhere($where);
		return $this->_getAll();
	}

	/**
	 * belongsto My_Model.php
	 * 查询全部
	 *
	 * @return     array  查询结果
	 *
	 * @author     assad
	 * @since      2019-11-11T11:52
	 */
	protected function _getAll() {
		$result = $this->dataBase->get($this->tableName)
			->{$this->_returnType(1)}();
		return $result;
	}

	/**
	 * belongsto My_Model.php
	 * 插入一条数据
	 *
	 * @param      array    $data   The data
	 *
	 * @return     boolean  ( description_of_the_return_value )
	 *
	 * @author     assad
	 * @since      2019-11-11T11:53
	 */
	public function insert($data = []) {
		if (!$data) {
			return false;
		}
		$this->dataBase->insert($this->tableName, $data);
		$insertId = $this->dataBase->insert_id();
		if ($insertId) {
			return $insertId;
		} else {
			return false;
		}
	}

	/**
	 * belongsto My_Model.php
	 * 根据主键ID更新数据
	 *
	 * @param      integer  $id    主键值
	 * @param      array   $data   The data
	 *
	 * @author     assad
	 * @since      2019-11-11T11:53
	 */
	public function update($id, $data = []) {
		if (!$data) {
			return false;
		}
		$result = $this->dataBase->where($this->primaryKey, $id)
			->set($data)->update($this->tableName);
		return $result;
	}

	/**
	 * belongsto My_Model.php
	 * 根据条件更新记录
	 *
	 * @param      array    $where  更新条件
	 * @param      array    $data   要更新的数据
	 *
	 * @return     boolean  ( description_of_the_return_value )
	 *
	 * @author     assad
	 * @since      2019-11-11T12:03
	 */
	public function updateBy($where = [], $data = []) {
		if (!$where || !$data) {
			return false;
		}
		$this->_setWhere($where);
		$result = $this->dataBase->set($data)->update($this->tableName);
		return $result;
	}

	/**
	 * belongsto My_Model.php
	 * 根据主键删除记录
	 *
	 * @param      integer   $id     主键值
	 *
	 * @return     boolean  ( description_of_the_return_value )
	 *
	 * @author     assad
	 * @since      2019-11-11T12:05
	 */
	public function delete($id) {
		if (!$id) {
			return false;
		}
		$this->dataBase->where($this->primaryKey, $id);
		$result = $this->dataBase->delete($this->tableName);
		return $result;
	}

	/**
	 * belongsto My_Model.php
	 * 根据条件删除记录
	 *
	 * @param      array    $where  更新条件
	 *
	 * @return     boolean  ( description_of_the_return_value )
	 *
	 * @author     assad
	 * @since      2019-11-14T22:47
	 */
	public function deleteBy($where = []) {
		if (!$where) {
			return false;
		}
		$this->_setWhere($where);
		$result = $this->dataBase->delete($this->tableName);
		return $result;
	}

	/**
	 * belongsto My_Model.php
	 * 统计数目
	 *
	 * @return     integer  返回统计的数量
	 *
	 * @author     assad
	 * @since      2019-11-11T12:11
	 */
	public function count() {
		$where = func_get_args();
		$where && $this->_setWhere($where);
		return $this->dataBase->count_all_results($this->tableName);
	}

	/**
	 * belongsto My_Model.php
	 * 清空表
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 *
	 * @author     assad
	 * @since      2019-11-11T12:07
	 */
	public function truncate() {
		$result = $this->dataBase->truncate($this->tableName);
		return $result;
	}

	/**
	 * belongsto My_Model.php
	 * 得到下一个ID
	 *
	 * @return     integer  The next identifier.
	 *
	 * @author     assad
	 * @since      2019-11-11T12:14
	 */
	public function getNextId() {
		return (int) $this->dataBase->select('AUTO_INCREMENT')
			->from('information_schema.TABLES')
			->where('TABLE_NAME', $this->tableName)
			->where('TABLE_SCHEMA', $this->dataBase->database)->get()->row()->AUTO_INCREMENT;
	}

	/**
	 * belongsto My_Model.php
	 * 得到主键名称
	 *
	 * @author     assad
	 * @since      2019-11-11T11:54
	 */
	private function fetchPrimaryKey() {
		if ($this->primaryKey == NULl) {
			$this->primaryKey = $this->dataBase->query("SHOW KEYS FROM `" . $this->tableName . "` WHERE Key_name = 'PRIMARY'")->row()->Column_name;
		}
	}

	/**
	 * belongsto My_Model.php
	 * 数据库表名
	 *
	 * @return     string  表名
	 *
	 * @author     assad
	 * @since      2019-11-11T11:54
	 */
	public function tableName() {
		return $this->tableName;
	}

	/**
	 * belongsto My_Model.php
	 * 获得数据库链接
	 *
	 * @return     resouce  The database.
	 *
	 * @author     assad
	 * @since      2019-11-11T12:33
	 */
	private function getDbConnect() {
		if (isset($this->dbConnect) && $this->dbConnect) {
			$this->dataBase = $this->load->database($this->dbConnect, TRUE);
		} else {
			$this->load->database();
			$this->dataBase = $this->db;
		}
		return $this;
	}

	/**
	 * belongsto My_Model.php
	 * 结果类型
	 *
	 * @param      boolean  $multi  The multi
	 *
	 * @return     string   ( description_of_the_return_value )
	 *
	 * @author     assad
	 * @since      2019-11-11T11:55
	 */
	protected function _returnType($multi = false) {
		$method = ($multi) ? 'result' : 'row';
		if ($this->returnType == 'array') {
			return $method . '_array';
		} else {
			return $method;
		}
	}

	/**
	 * belongsto My_Model.php
	 * 执行where逻辑
	 *
	 * @param      <type>  $params  The parameters
	 *
	 * @author     assad
	 * @since      2019-11-11T11:55
	 */
	protected function _setWhere($params) {
		if (count($params) == 1 && is_array($params[0])) {
			foreach ($params[0] as $field => $filter) {
				if (is_array($filter)) {
					$this->dataBase->where_in($field, $filter);
				} else {
					if (is_int($field)) {
						$this->dataBase->where($filter);
					} else {
						$this->dataBase->where($field, $filter);
					}
				}
			}
		} else if (count($params) == 1) {
			$this->dataBase->where($params[0]);
		} else if (count($params) == 2) {
			if (is_array($params[1])) {
				$this->dataBase->where_in($params[0], $params[1]);
			} else {
				$this->dataBase->where($params[0], $params[1]);
			}
		} else if (count($params) == 3) {
			$this->dataBase->where($params[0], $params[1], $params[2]);
		} else {
			if (is_array($params[1])) {
				$this->dataBase->where_in($params[0], $params[1]);
			} else {
				$this->dataBase->where($params[0], $params[1]);
			}
		}
	}

	/**
	 * belongsto My_Model.php
	 * 排序
	 *
	 * @param      <type>  $column  The column
	 * @param      string  $order   The order
	 *
	 * @return     self    ( description_of_the_return_value )
	 *
	 * @author     assad
	 * @since      2019-11-11T11:56
	 */
	public function orderBy($column, $order = 'ASC') {
		if (is_array($column)) {
			foreach ($column as $key => $value) {
				$this->dataBase->order_by($key, $value);
			}
		} else {
			$this->dataBase->order_by($column, $order);
		}
		return $this;
	}

	/**
	 * belongsto My_Model.php
	 * 分页
	 *
	 * @param      integer   $limit   The limit
	 * @param      integer  $offset  The offset
	 *
	 * @return     self     ( description_of_the_return_value )
	 *
	 * @author     assad
	 * @since      2019-11-11T11:56
	 */
	public function limit($limit, $offset = 0) {
		$this->dataBase->limit($limit, $offset);
		return $this;
	}
}