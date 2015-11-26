<?php /* Smarty version 3.1.27, created on 2015-11-26 21:53:33
         compiled from "/data/wwwroot/passport/application/views/templates/welcome.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:21194662856570edd8e46f4_26055749%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'cec91b1d950b434468dcc011828c328abf932bd7' => 
    array (
      0 => '/data/wwwroot/passport/application/views/templates/welcome.tpl',
      1 => 1448546011,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '21194662856570edd8e46f4_26055749',
  'variables' => 
  array (
    'time' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_56570edd9079c9_10103635',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_56570edd9079c9_10103635')) {
function content_56570edd9079c9_10103635 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '21194662856570edd8e46f4_26055749';
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>PASSPORT</title>

	<style type="text/css">

	::selection { background-color: #E13300; color: white; }
	::-moz-selection { background-color: #E13300; color: white; }

	body {
		background-color: #fff;
		margin: 40px;
		font: 13px/20px normal Helvetica, Arial, sans-serif;
		color: #4F5155;
	}

	a {
		color: #003399;
		background-color: transparent;
		font-weight: normal;
	}

	h1 {
		color: #444;
		background-color: transparent;
		font-size: 19px;
		font-weight: normal;
		text-align:center;
	}

	code {
		font-family: Consolas, Monaco, Courier New, Courier, monospace;
		font-size: 12px;
		background-color: #f9f9f9;
		border: 1px solid #D0D0D0;
		color: #002166;
		display: block;
		margin: 14px 0 14px 0;
		padding: 12px 10px 12px 10px;
	}

	#body {
		margin: 0 15px 0 15px;
	}

	p.footer {
		text-align: right;
		font-size: 11px;
		border-top: 1px solid #D0D0D0;
		line-height: 32px;
		padding: 0 10px 0 10px;
		margin: 20px 0 0 0;
	}

	#container {
		margin: 10px;
		border: 1px solid #D0D0D0;
	}
	</style>
</head>
<body>

<div id="container">
	<h1>SKYLINE PASSPORT <?php echo $_smarty_tpl->tpl_vars['time']->value;?>
</h1>
</div>
</body>
</html><?php }
}
?>