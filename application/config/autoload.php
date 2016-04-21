<?php
/**
* @file autoload.php
* @synopsis  自定义自动加载
* @author Yee, <rlk002@gmail.com>
* @version 1.0
* @date 2016-04-21 11:19:34
*/

defined('BASEPATH') OR exit('No direct script access allowed');

$autoload['packages'] = array();
$autoload['libraries'] = array('session');
$autoload['drivers'] = array();
$autoload['helper'] = array('custom_functions','url');
$autoload['config'] = array();
$autoload['language'] = array();
$autoload['model'] = array('userm');
