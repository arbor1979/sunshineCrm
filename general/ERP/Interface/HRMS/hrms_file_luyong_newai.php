<?php

	require_once('lib.inc.php');//



	$GLOBAL_SESSION=returnsession();
$SYSTEM_PRIV_STOP = 1;
	require_once("systemprivateinc.php");
	CheckSystemPrivate("������Դ-��Ƹ����-��Ƹ¼��");


	if($_GET['action']=="add_default_data")		{

		//print_R($_GET);print_R($_POST);//exit;

		global $db;

		$���֤�� = $_POST['���֤��'];



		$sql = "update hrms_zprencaiku set ¼��״̬='¼��' where ���֤��='".$���֤��."'";

		$rs = $db->Execute($sql);

		//print $sql;exit;




	}








	$filetablename='hrms_file_luyong';


	require_once('include.inc.php');

	?>