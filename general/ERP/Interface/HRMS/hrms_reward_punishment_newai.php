<?php

	require_once('lib.inc.php');



	$GLOBAL_SESSION=returnsession();
$SYSTEM_PRIV_STOP = 1;

	require_once("systemprivateinc.php");

	CheckSystemPrivate("人力资源-人事管理-奖惩");

/*
	if($_GET['action']=="add_default_data")		{
		print_R($_GET);print_R($_POST);
		global $db;
		$工号 = $_POST['工号'];
		$sql = "update hrms_file set 工作状态='离职' where 工号='".$工号."'";
		$rs = $db->Execute($sql);
	}


	*/





	$filetablename='hrms_reward_punishment';

	require_once('include.inc.php');

	?>