<?php
	ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL);
	error_reporting(E_WARNING | E_ERROR);
	require_once('lib.inc.php');
	$GLOBAL_SESSION=returnsession();
	

	if($_GET['action']=="edit_default_data")		{

		$��� = $_GET['���'];
		$sql = "update wuye_wuyetingchechangguanli set �Ƿ�ɷ�='1' where ��� = '$���'";
		$db->Execute($sql);
		
	}


   if($_GET['��λ״̬'] = "���۳�"){
	
	$filetablename		=	'wuye_wuyetingchechangguanli';
	$parse_filename		=	'wuye_wuyetingchechangguanli';
	require_once('include.inc.php');
   }
	?>