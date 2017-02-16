<?php

	require_once('lib.inc.php');



	$GLOBAL_SESSION=returnsession();
$SYSTEM_PRIV_STOP = 1;

	require_once("systemprivateinc.php");

	CheckSystemPrivate("人力资源-人事管理-调动");


	if($_GET['action']=="add_default_data")		{
	//	print_R($_GET);print_R($_POST);
		global $db;
		$工号 = $_POST['员工工号'];
		$在职状况 = $_POST['在职状况'];
        $调后部门 = $_POST['调后部门'];
		$调后岗位 = $_POST['调后岗位'];
		$sql = "update hrms_file set 工作状态='".$在职状况."',所属部门='".$调后部门."',岗位类别='".$调后岗位."' where 工号='".$工号."'";
		$rs = $db->Execute($sql);
	}






	$filetablename='hrms_transfer';

	require_once('include.inc.php');

	?>