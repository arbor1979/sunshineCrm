<?php

	require_once('lib.inc.php');



	$GLOBAL_SESSION=returnsession();
$SYSTEM_PRIV_STOP = 1;
	require_once("systemprivateinc.php");
	CheckSystemPrivate("人力资源-干部测评-查看我的测评");


	$评测人员 = $_SESSION['LOGIN_USER_NAME'];


	$测评名称 = returntablefield("edu_zhongcengceping","是否有效",1,"测评名称");
	$参与评测人员 = returntablefield("edu_zhongcengceping","测评名称",$测评名称,"参与评测人员");
	$参与评测人员Array = explode(',',$参与评测人员);

	page_css("中层测评");

	//较难是否可以参与测评
	if(!in_array($评测人员,$参与评测人员Array))		{
		print_infor("您没有在可以参与测评的人员之列!",'',"location='?'");
		exit;
	}

	$_GET['评价人'] = $评测人员;
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






	$filetablename='edu_zhongcengmingxi';
	$parse_filename='edu_zhongcengviewceping';

	require_once('include.inc.php');

	?>