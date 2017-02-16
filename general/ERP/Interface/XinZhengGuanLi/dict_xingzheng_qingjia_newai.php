<?php
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);
error_reporting(E_WARNING | E_ERROR);

//######################教育组件-权限较验部分##########################
require_once("lib.inc.php");
$GLOBAL_SESSION=returnsession();
$SYSTEM_PRIV_STOP = 1;
require_once("../EDU/systemprivateinc.php");
CheckSystemPrivate("数字化校园系统设置-数据字典");
//######################教育组件-权限较验部分##########################


	//数据表模型文件,对应Model目录下面的dict_xingzheng_qingjia_newai.ini文件
	//如果是需要复制此模块,则需要修改$parse_filename参数的值,然后对应到Model目录 新文件名_newai.ini文件
	$filetablename		=	'dict_xingzheng_qingjia';
	$parse_filename		=	'dict_xingzheng_qingjia';
	require_once('include.inc.php');
	?>