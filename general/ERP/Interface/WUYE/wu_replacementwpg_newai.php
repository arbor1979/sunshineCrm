<?php
	ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL);
	error_reporting(E_WARNING | E_ERROR);
	require_once('lib.inc.php');
	$GLOBAL_SESSION=returnsession();
	

	if($_GET['action']=="add_default_data")		{

     // print_r($_POST);

	  $��Ԫ��� = $_POST['��Ԫ�����'];

	  $sql = "select ҵ������,ҵ���绰 from wu_housingresources where �������='$��Ԫ���'";
	  $rs = $db->Execute($sql);
	  $rs_a = $rs->GetArray();
	  
	  $ҵ������ = $rs_a[0]['ҵ������'];
	  $��ϵ�绰 = $rs_a[0]['ҵ���绰'];

      $_POST['ҵ������']=$ҵ������; //���������Ӧ�ô���POST�����У�
	  $_POST['��ϵ�绰']=$��ϵ�绰;

	  //$upd_sql = "update wu_replacementwpg set ҵ������='$ҵ������',��ϵ�绰='$��ϵ�绰' where ��Ԫ�����='$��Ԫ���'";

	  //echo $upd_sql;

	  //$ins_sql = "";

	 //$db->Execute($upd_sql);

      //exit;

		
	}

	$filetablename		=	'wu_replacementwpg';
	$parse_filename		=	'wu_replacementwpg';
	require_once('include.inc.php');
	?>