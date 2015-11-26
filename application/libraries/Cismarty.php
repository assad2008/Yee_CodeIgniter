<?php
/**
* @file Cismarty.php
* @synopsis  支持Smarty
* @author Yee, <rlk002@gmail.com>
* @version 1.0
* @date 2015-11-26 21:51:57
*/

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH."third_party/Smarty/Smarty.class.php";

class Cismarty extends Smarty 
{
	function __construct()
	{
		parent::__construct();
		$CI = get_instance();
		$CI->load->config('smarty');
		$this->debugging = $CI->config->item('smarty.smarty_debug');
		$this->setTemplateDir($CI->config->item('smarty.template_path'));
		$this->setCompileDir($CI->config->item('smarty.compile_directory'));
		$this->setCacheDir($CI->config->item('smarty.cache_directory'));
		$this->setLeftDelimiter($CI->config->item('smarty.left_delimiter'));
		$this->setRightDelimiter($CI->config->item('smarty.right_delimiter'));
		$this->cache_lifetime = $CI->config->item('smarty.cache_lifetime');
		$this->disableSecurity();
		self::config($this);
		if ( method_exists( $this, 'assignByRef') )
		{
			$ci =& get_instance();
			$this->assignByRef("ci", $ci);
		}
		log_message('debug', "Smarty Class Initialized");
	}

	public static function config($s)
	{
		$s->assign('date_format', '%Y-%m-%d %H:%M:%S');
		$s->assign('date_format_ymd_hm', '%Y-%m-%d %H:%M');
		$s->assign('date_format_md_hm', '%m-%d %H:%M');
		$s->assign('date_format_yymd_hm', '%y-%m-%d %H:%M');
		$s->assign('date_format_ymd', '%Y-%m-%d');
		$s->assign('date_format_ym', '%Y-%m');	
	}
}
