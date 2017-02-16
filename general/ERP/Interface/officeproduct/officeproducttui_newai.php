<?php
require_once("lib.inc.php");

$GLOBAL_SESSION=returnsession();

	require_once("systemprivateinc.php");

	CheckSystemPrivate("后勤管理-办公用品-操作明细");



if($_GET['action']=="add_default_data")		{
	page_css('办公用品');
	$办公用品编号 = $_POST['办公用品编号'];
	$办公用品名称 = $_POST['办公用品名称'];
	$现在所属部门 = $_POST['现在所属部门'];
	if($_POST['批准人']!="")	{
		$_POST['单价'] = returntablefield("officeproduct","办公用品编号",$办公用品编号,"单价");
		$_POST['数量'] = $_POST['退库数量'];
		$_POST['金额'] = $_POST['单价']*$_POST['数量'];
		$sql = "update officeproduct set 库存管理=库存管理+".$_POST['数量']." where 办公用品编号='$办公用品编号'";
		$db->Execute($sql);
		//print $sql."<BR>";exit;
	}
	else			{
		$SYSTEM_SECOND = 1;
		print_infor("批准人为空或现在所属部门为空,您的操作没有执行成功!",$infor='该参数新版本没有被使用',$return="location='officeproduct_newai.php'",$indexto='officeproduct_newai.php');
		exit;
	}
}




$filetablename='officeproducttui';
require_once('include.inc.php');
?>