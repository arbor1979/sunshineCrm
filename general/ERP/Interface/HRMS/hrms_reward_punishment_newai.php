<?php

	require_once('lib.inc.php');



	$GLOBAL_SESSION=returnsession();
$SYSTEM_PRIV_STOP = 1;

	require_once("systemprivateinc.php");

	CheckSystemPrivate("������Դ-���¹���-����");

/*
	if($_GET['action']=="add_default_data")		{
		print_R($_GET);print_R($_POST);
		global $db;
		$���� = $_POST['����'];
		$sql = "update hrms_file set ����״̬='��ְ' where ����='".$����."'";
		$rs = $db->Execute($sql);
	}


	*/





	$filetablename='hrms_reward_punishment';

	require_once('include.inc.php');

	?>