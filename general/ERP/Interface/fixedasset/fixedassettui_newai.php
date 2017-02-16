<?php
require_once("lib.inc.php");

$GLOBAL_SESSION=returnsession();
	require_once("systemprivateinc.php");

	CheckSystemPrivate("后勤管理-固定资产-操作明细");



if($_GET['action']=="add_default_data")		{
	page_css('归还');
	$资产编号 = $_POST['资产编号'];
	$资产名称 = $_POST['资产名称'];
	$借领人 = $_POST['借领人'];
	if($_POST['批准人']!="")	{
		$_POST['单价'] = returntablefield("fixedasset","资产编号",$资产编号,"单价");
		$_POST['数量'] = returntablefield("fixedasset","资产编号",$资产编号,"数量");
		$_POST['金额'] = returntablefield("fixedasset","资产编号",$资产编号,"金额");
		$sql = "update fixedasset set 使用人员='',所属状态='资产已归还' where 资产编号='$资产编号'";
		$db->Execute($sql);
	}
	else			{
		$SYSTEM_SECOND = 1;
		print_infor("批准人为空,您的操作没有执行成功!",$infor='该参数新版本没有被使用',$return="location='fixedasset_newai.php'",$indexto='fixedasset_newai.php');
		exit;
	}
}



$filetablename='fixedassettui';
require_once('include.inc.php');
?>