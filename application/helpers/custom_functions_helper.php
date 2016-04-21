<?php

/**
* @file functions_helper.php
* @synopsis  自定义函数
* @author Yee, <rlk002@gmail.com>
* @version 1.0
* @date 2012-10-14 00:18:41
*/

	if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	function debug($var = null,$type = 2) 
	{
		if($var === NULL)
		{
			$var = $GLOBALS;
		}
		header("Content-type:text/html;charset=utf-8");
		echo '<pre style="word-wrap: break-word;background-color:black;color:white;font-size:13px; border: 2px solid green;padding: 5px;">变量跟踪信息：'."\n";
		if($type == 1)
		{
			var_dump($var);
		}elseif($type == 2)
		{
			print_r($var);
		}
		echo '</pre>';
		exit();
	}

	function valid_phonenumber($phonenumber)
	{
		if(strlen($phonenumber) != 11)
		{
			return False;
		}
		if(preg_match("/^13[0-9]{1}[0-9]{8}$|15[0189]{1}[0-9]{8}$|18[0-9]{9}|17[0-9]{9}$/",$phonenumber))
		{
			return True;
		}else
		{    
			return False;  
		}
	}

	function random($length, $numeric = 0) 
	{
		PHP_VERSION < '4.2.0' ? mt_srand((double)microtime() * 1000000) : mt_srand();
		$seed = base_convert(md5(print_r($_SERVER, 1).microtime()), 16, $numeric ? 10 : 35);
		$seed = $numeric ? (str_replace('0', '', $seed).'012340567890') : ($seed.'zZ'.strtoupper($seed));
		$hash = '';
		$max = strlen($seed) - 1;
		for($i = 0; $i < $length; $i++)
		{
			$hash .= $seed[mt_rand(0, $max)];
		}
		return $hash;
	}

	function ffile_get_contents($url)
	{
		$ctx = stream_context_create(
		array(   
        'http' => array(   
				'timeout' => 1 //设置一个超时时间，单位为秒   
				)   
			)
		);   
		$r = file_get_contents($url, 0, $ctx);
		unset($ctx);
		return $r;
	}

	function w_log($string,$t = 'day')
	{
		if(is_array($string))
		{
			$string = json_encode($string);
		}
		$timestamp = time();
		if($t == 'day')
		{
			$f = date('Ymd',$timestamp);
			$filename = BASEDIRS . 'data/logs/wlog/trace' . $f . '.log';
		}elseif($t == 'month')
		{
			$f = date('Ym',$timestamp);
			$filename = BASEDIRS . 'data/logs/wlog/trace' . $f . '.log';
		}
		$logtime = date('Y/m/d H:i:s',$timestamp);
		$record = $logtime.' - '.$string . "\n";
		writelog($filename, $record, 'ab');
	}

	function noticelog($string)
	{
		$f = date("Ymd");
		$filename = BASEDIRS . 'data/logs/calllog/notice' . $f . '.log';
		$logtime = date('Y/m/d H:i:s');
		$record = $logtime.' - '.$string . "\n";
		writelog($filename, $record, 'ab');
	}

	function writelog($filename, $data, $method = 'wb+', $iflock = 1, $check = 1, $chmod = 1)
	{
		if (empty($filename))
		{
			return false;
		}

		if ($check && strpos($filename, '..') !== false)
		{
			return false;
		}
		if (!is_dir(dirname($filename)) && !mkdir_recursive(dirname($filename), 0777))
		{
			return false;
 	 	}
		if (false == ($handle = fopen($filename, $method)))
		{
			return false;
		}
		if($iflock)
		{
			flock($handle, LOCK_EX);
		}
		fwrite($handle, $data);
		touch($filename);

		if($method == "wb+")
		{
		ftruncate($handle, strlen($data));
		}
		fclose($handle);
		$chmod && @chmod($filename,0777);
		return true;
	}

	function mkdir_recursive($pathname, $mode)
	{
		if (strpos( $pathname, '..' ) !== false)
		{
			return false;
		}
		$pathname = rtrim(preg_replace(array('/\\{1,}/', '/\/{2,}/'), '/', $pathname), '/');
  	if (is_dir($pathname))
 	 	{
  		return true;
 		}
	
		is_dir(dirname($pathname)) || mkdir_recursive(dirname($pathname), $mode);
		return is_dir($pathname) || @mkdir($pathname, $mode);
	}

	function create_guidq() 
	{
		$charid = md5(uniqid(mt_rand(), true));
		$hyphen = chr(45);
		$uuid = substr($charid, 0, 8).$hyphen
		.substr($charid, 8, 4).$hyphen
		.substr($charid,12, 4).$hyphen
		.substr($charid,16, 4).$hyphen
		.substr($charid,20,12);
		return $uuid;
	}

	function uuid($url)
	{
		include BASEDIRS . 'application/libraries/Uuid.php';
		return genUuid::gen($url);
	}

	function get_pwd_salt()
	{
		$sort = substr(uniqid(rand()), -6);
		return $sort;
	}

	function get_password_salt($pwd,$salt)
	{
		return md5(md5($pwd) . $salt);
	}

	function exitjson($array = array())
	{
		if(is_array($array))
		{
			exit(json_encode($array));
		}else
		{
			exit(json_encode(array('code' => -1,'tips' => 'type is error')));
		}
	}

	function get_sql_total($obj)
	{
		if($obj->dbdriver == 'mysqli' || $obj->dbdriver == 'mysql')
		{
			return $obj->query("SELECT FOUND_ROWS() AS rows")->row()->rows;
		}else
		{
			return 'this database is not support';
		}
	}

	function diffmac($mac)
	{
		return implode('',explode(':',strtoupper($mac)));
	}

	function get_charset()
	{
		return '0123456789abcdefghijklmnopqrstuvwxyz-';
	}

	function stringtoint($string)
	{
		$chars = get_charset();
		$integer = 0;
		$string = strrev($string);
		$baselen = strlen($chars);
		$inputlen = strlen( $string);
		for ($i = 0; $i < $inputlen; $i++)
 		{
			$index = strpos($chars, $string[$i]);
			$integer = bcadd($integer, bcmul($index, bcpow($baselen, $i)));
		}
		$integer = explode('.',$integer)[0];
		return $integer;
	}

	function inttostring($num)
	{
		$chars = get_charset();
		$string = '';
		$len = strlen($chars);
		while( $num >= $len )
 		{
			$mod = bcmod($num, $len);
			$num = bcdiv($num, $len);
			$string = $chars[$mod] . $string;
		}
		$string = $chars[$num] . $string;
		return $string;
	}

	function gensign($tokenLen = 60) 
	{
		if (file_exists('/dev/urandom'))
		{
			$randomData = file_get_contents('/dev/urandom', false, null, 0, 100) . uniqid(mt_rand(), true);
		}else
		{
			$randomData = mt_rand() . mt_rand() . mt_rand() . mt_rand() . microtime(true) . uniqid(mt_rand(), true);
		}
		return substr(hash('sha512', $randomData), 0, $tokenLen);
	}

	function enrsa($keypath,$text)  //2048位 私钥加密
	{
		include_once BASEDIRS . 'application/libraries/Rsalib.php';
		$rsa = new Rsalib(2048);
		$rsa->setupPrivKey($keypath);
		return $rsa->privEncrypt($text);	
	}

	function dersa($keypath,$text)  //2048位 公钥解密
	{
		include_once BASEDIRS . 'application/libraries/Rsalib.php';
		$rsa = new Rsalib(2048);
		$rsa->setupPubKey($keypath);
		return $rsa->pubDecrypt($text);	
	}
