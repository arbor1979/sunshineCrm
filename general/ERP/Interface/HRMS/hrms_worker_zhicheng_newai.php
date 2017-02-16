<?php

	require_once('lib.inc.php');



	$GLOBAL_SESSION=returnsession();
$SYSTEM_PRIV_STOP = 1;

	require_once("systemprivateinc.php");

	CheckSystemPrivate("人力资源-人事管理-职称");

	/*
	if($_GET['action']=="add_default_data")		{

		//print_R($_GET);print_R($_POST);//exit;

		global $db;

		$入库数量 = (int)$_POST['入库数量'];

		$教材编号 = $_POST['教材编号'];

		$sql = "update edu_jiaocai set 现有库存=现有库存+$入库数量 where 教材编号='".$教材编号."'";

		$rs = $db->Execute($sql);

		//print $sql;exit;

		$_POST['编作者'] = returntablefield("edu_jiaocai","教材编号",$教材编号,"编作者");

		$_POST['出版社'] = returntablefield("edu_jiaocai","教材编号",$教材编号,"出版社");

		//print  "<META HTTP-EQUIV=REFRESH CONTENT='0;URL=?'>
";

	}

	*/
	if($_GET['action']=="add_default_data")		{

		//print_R($_GET);print_R($_POST);//exit;

		global $db;

		$工号 = $_POST['工号'];
		$职称 = $_POST['职称'];

		//$教材编号 = $_POST['教材编号'];

		$sql = "update hrms_file set 职称='".$职称."' where 工号='".$工号."'";

		$rs = $db->Execute($sql);

		//print $sql;exit;





	}





	$filetablename='hrms_worker_zhicheng';

	require_once('include.inc.php');

	?>