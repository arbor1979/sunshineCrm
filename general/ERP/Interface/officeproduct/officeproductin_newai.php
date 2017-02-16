<?php
require_once("lib.inc.php");

$GLOBAL_SESSION=returnsession();

	require_once("systemprivateinc.php");
if($_GET['action']=="add_default_data" || $_GET['action']=="add_default")
	validateMenuPriv("办公用品清单");
else
	validateMenuPriv("入库记录");


if($_GET['action']=="add_default_data")		{
	page_css();
	$办公用品编号 = $_POST['办公用品编号'];
	$入库仓库 = $_POST['入库仓库'];
	$sql = "update officeproduct set 数量=数量+".$_POST['入库数量'].",合计金额=round(数量*单价,2) where 办公用品编号='$办公用品编号' and 存放地点='$入库仓库'";
	$db->Execute($sql);
	
}


$filetablename='officeproductin';
require_once('include.inc.php');
?>