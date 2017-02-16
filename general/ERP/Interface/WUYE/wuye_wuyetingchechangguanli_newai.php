<?php
	ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL);
	error_reporting(E_WARNING | E_ERROR);
	require_once('lib.inc.php');
	$GLOBAL_SESSION=returnsession();
	

	if($_GET['action']=="edit_default_data")		{

		$编号 = $_GET['编号'];
		$sql = "update wuye_wuyetingchechangguanli set 是否缴费='1' where 编号 = '$编号'";
		$db->Execute($sql);
		
	}


   if($_GET['车位状态'] = "已售出"){
	
	$filetablename		=	'wuye_wuyetingchechangguanli';
	$parse_filename		=	'wuye_wuyetingchechangguanli';
	require_once('include.inc.php');
   }
	?>