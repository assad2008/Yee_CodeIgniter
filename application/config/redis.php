<?php

/**
 * @Author: assad
 * @Date:   2019-11-11 23:30:43
 * @Last Modified by:   assad
 * @Last Modified time: 2019-11-11 23:31:47
 */

if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

$config['redis_default']['host'] = 'localhost';
$config['redis_default']['port'] = '6379';
$config['redis_default']['password'] = '';

$config['redis_slave']['host'] = '';
$config['redis_slave']['port'] = '6379';
$config['redis_slave']['password'] = '';