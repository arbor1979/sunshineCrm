<?php
	ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL);
	error_reporting(E_WARNING | E_ERROR);
	require_once('lib.inc.php');
	$GLOBAL_SESSION=returnsession();
	$SYSTEM_PRIV_STOP = "1";
	validateMenuPriv("任务安排");
	//print_r($_POST);exit;
	
	addShortCutByDate("createtime","创建时间");
	$SYSTEM_ADD_SQL=$SYSTEM_ADD_SQL." and (createman<>'".$_SESSION['LOGIN_USER_ID']."')";
	$SYSTEM_ADD_SQL=getRoleByUser($SYSTEM_ADD_SQL,"createman");
	
	$filetablename		=	'workplanmain';
	$parse_filename		=	'workplanmain_xiaji';
	//$SYSTEM_PRINT_SQL=1;
	require_once('include.inc.php');
	?>