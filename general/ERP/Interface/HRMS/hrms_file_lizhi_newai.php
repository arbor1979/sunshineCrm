<?php

	require_once('lib.inc.php');



	$GLOBAL_SESSION=returnsession();
$SYSTEM_PRIV_STOP = 1;

	require_once("systemprivateinc.php");

	CheckSystemPrivate("������Դ-���¹���-��ְ");


	if($_GET['action']=="add_default_data")		{

		//print_R($_GET);print_R($_POST);//exit;

		global $db;

		$���� = $_POST['����'];

		//$�̲ı�� = $_POST['�̲ı��'];

		$sql = "update hrms_file set ����״̬='��ְ' where ����='".$����."'";

		$rs = $db->Execute($sql);

		//print $sql;exit;





	}








	$filetablename='hrms_file_lizhi';
   // $parse_filename='hrms_file_lizhi';
	require_once('include.inc.php');

	?>