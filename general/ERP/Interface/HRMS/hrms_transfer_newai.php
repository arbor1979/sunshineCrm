<?php

	require_once('lib.inc.php');



	$GLOBAL_SESSION=returnsession();
$SYSTEM_PRIV_STOP = 1;

	require_once("systemprivateinc.php");

	CheckSystemPrivate("������Դ-���¹���-����");


	if($_GET['action']=="add_default_data")		{
	//	print_R($_GET);print_R($_POST);
		global $db;
		$���� = $_POST['Ա������'];
		$��ְ״�� = $_POST['��ְ״��'];
        $������ = $_POST['������'];
		$�����λ = $_POST['�����λ'];
		$sql = "update hrms_file set ����״̬='".$��ְ״��."',��������='".$������."',��λ���='".$�����λ."' where ����='".$����."'";
		$rs = $db->Execute($sql);
	}






	$filetablename='hrms_transfer';

	require_once('include.inc.php');

	?>