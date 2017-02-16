<?php
require_once("lib.inc.php");

$GLOBAL_SESSION=returnsession();
if($_GET['action']=="add_default_data" || $_GET['action']=="add_default")
	validateMenuPriv("办公用品清单");
else
	validateMenuPriv("报废记录");



if($_GET['action']=="add_default_data")		{
	page_css('办公用品');
	$办公用品编号 = $_POST['办公用品编号'];
	$办公用品名称 = $_POST['办公用品名称'];
	$所属仓库 = $_POST['所属仓库'];
	$报废数量 =$_POST['报废数量'];

	$kucun=returntablefield("officeproduct", "办公用品编号", $办公用品编号, "数量","存放地点",$所属仓库);
	if($kucun<$报废数量)
	{
		print "<script language=javascript>alert('此编号的办公用品库存不足');window.history.back(-1);</script>";
		exit;	
	}
	
	$sql = "update officeproduct set 数量=数量-$报废数量,合计金额=round(数量*单价,2) where 办公用品编号='$办公用品编号' and 存放地点='$所属仓库'";
	$db->Execute($sql);
	
}



$filetablename='officeproductbaofei';
require_once('include.inc.php');
?>