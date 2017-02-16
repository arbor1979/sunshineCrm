<?php
require_once("lib.inc.php");

$GLOBAL_SESSION=returnsession();
	require_once("systemprivateinc.php");

	CheckSystemPrivate("后勤管理-固定资产-操作明细");



if($_GET['action']=="add_default_data")		{
	page_css('归还');
	$资产编号 = $_POST['资产编号'];
	$资产名称 = $_POST['资产名称'];
	$现在所属部门 = $_POST['现在所属部门'];
	if($现在所属部门!=""&&$_POST['批准人']!="")	{
		$_POST['单价'] = returntablefield("fixedasset","资产编号",$资产编号,"单价");
		$_POST['数量'] = returntablefield("fixedasset","资产编号",$资产编号,"数量");
		$_POST['金额'] = returntablefield("fixedasset","资产编号",$资产编号,"金额");
		$sql = "update fixedasset set 所属部门='$现在所属部门' where 资产编号='$资产编号'";
		$db->Execute($sql);
	}
	else			{
		$SYSTEM_SECOND = 1;
		print_infor("批准人为空或现在所属部门为空,您的操作没有执行成功!",$infor='该参数新版本没有被使用',$return="location='fixedasset_newai.php'",$indexto='fixedasset_newai.php');
		exit;
	}
}

//print_R($_POST);exit;



$filetablename='fixedassettiaoku';
require_once('include.inc.php');
?>