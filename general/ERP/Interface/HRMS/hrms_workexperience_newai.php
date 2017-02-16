<?php
	require_once('lib.inc.php');

	$GLOBAL_SESSION=returnsession();
$SYSTEM_PRIV_STOP = 1;

	require_once("systemprivateinc.php");

	CheckSystemPrivate("人力资源-人事管理-工作经历");
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
		//print  "<META HTTP-EQUIV=REFRESH CONTENT='0;URL=?'>";
	}
	*/

	//数据表模型文件,对应Model目录下面的hrms_workexperience_newai.ini文件

	//如果是需要复制此模块,则需要修改$parse_filename参数的值,然后对应到Model目录 新文件名_newai.ini文件

	$filetablename		=	'hrms_workexperience';

	$parse_filename	=	'hrms_workexperience';

	require_once('include.inc.php');

	?>