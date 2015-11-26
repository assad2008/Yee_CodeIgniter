<?php
/**
 * CI Smarty
 *
 * Smarty templating for Codeigniter
 *
 * @package   CI Smarty
 * @author    Dwayne Charrington
 * @copyright 2015 Dwayne Charrington and Github contributors
 * @link      http://ilikekillnerds.com
 * @license   MIT
 * @version   3.0
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config['smarty.cache_status'] = TRUE;
$config['smarty.template_path'] = APPPATH . "views/templates/";
$config['smarty.cache_lifetime'] = 86400;
$config['smarty.compile_directory'] = APPPATH . "views/templates_c/";
$config['smarty.cache_directory'] = APPPATH . "views/cached/";
$config['smarty.config_directory'] = APPPATH . "third_party/Smarty/configs/";
$config['smarty.left_delimiter'] = '<{';
$config['smarty.right_delimiter'] = '}>';
$config['smarty.template_error_reporting'] = E_ALL & ~E_NOTICE;
$config['smarty.smarty_debug'] = FALSE;
