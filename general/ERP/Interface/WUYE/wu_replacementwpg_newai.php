<?php
	ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL);
	error_reporting(E_WARNING | E_ERROR);
	require_once('lib.inc.php');
	$GLOBAL_SESSION=returnsession();
	

	if($_GET['action']=="add_default_data")		{

     // print_r($_POST);

	  $单元编号 = $_POST['单元房间号'];

	  $sql = "select 业主姓名,业主电话 from wu_housingresources where 房间号码='$单元编号'";
	  $rs = $db->Execute($sql);
	  $rs_a = $rs->GetArray();
	  
	  $业主姓名 = $rs_a[0]['业主姓名'];
	  $联系电话 = $rs_a[0]['业主电话'];

      $_POST['业主姓名']=$业主姓名; //插入的数据应该存入POST数组中；
	  $_POST['联系电话']=$联系电话;

	  //$upd_sql = "update wu_replacementwpg set 业主姓名='$业主姓名',联系电话='$联系电话' where 单元房间号='$单元编号'";

	  //echo $upd_sql;

	  //$ins_sql = "";

	 //$db->Execute($upd_sql);

      //exit;

		
	}

	$filetablename		=	'wu_replacementwpg';
	$parse_filename		=	'wu_replacementwpg';
	require_once('include.inc.php');
	?>