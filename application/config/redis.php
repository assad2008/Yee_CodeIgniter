<?php
/**
* @file redis.php
* @synopsis  Redis配置文件
* @author Yee, <rlk002@gmail.com>
* @version 1.0
* @date 2015-11-26 17:52:33
*/

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// Default connection group
$config['redis_default']['host'] = 'localhost';		// IP address or host
$config['redis_default']['port'] = '6379';			// Default Redis port is 6379
$config['redis_default']['password'] = '';			// Can be left empty when the server does not require AUTH

$config['redis_slave']['host'] = '';
$config['redis_slave']['port'] = '6379';
$config['redis_slave']['password'] = '';
