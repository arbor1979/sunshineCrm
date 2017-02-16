<?php

	require_once('lib.inc.php');//



	$GLOBAL_SESSION=returnsession();
$SYSTEM_PRIV_STOP = 1;
	require_once("systemprivateinc.php");
	CheckSystemPrivate("人力资源-招聘管理-招聘录用");


	if($_GET['action']=="add_default_data")		{

		//print_R($_GET);print_R($_POST);//exit;

		global $db;

		$身份证号 = $_POST['身份证号'];



		$sql = "update hrms_zprencaiku set 录用状态='录用' where 身份证号='".$身份证号."'";

		$rs = $db->Execute($sql);

		//print $sql;exit;




	}








	$filetablename='hrms_file_luyong';


	require_once('include.inc.php');

	?>