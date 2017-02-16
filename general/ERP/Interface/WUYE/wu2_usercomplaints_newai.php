<?php
	ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL);
	error_reporting(E_WARNING | E_ERROR);
	require_once('lib.inc.php');
	$GLOBAL_SESSION=returnsession();
	
	/*
	if($_GET['action']=="add_default_data")		{
		//print_R($_GET);print_R($_POST);//exit;
		global $db;
		$入库数量 = (int)$_POST['入库数量'];$教材编号 = $_POST['教材编号'];
		$sql = "update edu_jiaocai set 现有库存=现有库存+$入库数量 where 教材编号='".$教材编号."'";
		$rs = $db->Execute($sql);//print $sql;exit;
		$_POST['编作者'] = returntablefield("edu_jiaocai","教材编号",$教材编号,"编作者");
		$_POST['出版社'] = returntablefield("edu_jiaocai","教材编号",$教材编号,"出版社");
		//print  "<META HTTP-EQUIV=REFRESH CONTENT='0;URL=?'>";
	}
	*/

	//数据表模型文件,对应Model目录下面的wu_usercomplaints_newai.ini文件
	//如果是需要复制此模块,则需要修改$parse_filename参数的值,然后对应到Model目录 新文件名_newai.ini文件
    




	if($_GET['action']=="add_default_data")		{
	
		//print_r($_POST);
		$投诉序号 = $_POST['投诉序号'];
		$单元编号 = $_POST['单元编号'];
		$投诉人   = $_POST['投诉人'];
        

        $sql = "delete from wu_usercomplaints where 投诉序号='$投诉序号' and 单元编号='$单元编号' and 投诉人='$投诉人' and 是否受理='已受理'";

		$db->Execute($sql);

	}  

    $_GET['是否处理'] = "是";
	$_GET['是否受理'] = "已受理";
	$filetablename		=	'wu_usercomplaints';
	$parse_filename		=	'wu2_usercomplaints';
	require_once('include.inc.php');
	?>