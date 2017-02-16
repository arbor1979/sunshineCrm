<?php
 
	require_once('lib.inc.php');

	

	$GLOBAL_SESSION=returnsession();
$SYSTEM_PRIV_STOP = 1;

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
	

	

	

	$filetablename='edu_xingzheng_paiban';

	require_once('include.inc.php');

	?>