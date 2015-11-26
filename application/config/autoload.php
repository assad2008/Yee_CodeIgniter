<?php
/**
* @file autoload.php
* @synopsis  自动加载
* @author Yee, <rlk002@gmail.com>
* @version 1.0
* @date 2015-11-26 17:45:29
*/

defined('BASEPATH') OR exit('No direct script access allowed');

$autoload['packages'] = array();
$autoload['libraries'] = array('cismarty','curl','session','user_agent','Passwordhash');
$autoload['drivers'] = array();
$autoload['helper'] = array('custom_functions','url');
$autoload['config'] = array();
$autoload['language'] = array();
$autoload['model'] = array();
