<?php
	ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL);
	error_reporting(E_WARNING | E_ERROR);
	require_once('lib.inc.php');
	$GLOBAL_SESSION=returnsession();
	validateMenuPriv("生产组装单");
	if($_GET['action']=="edit_default2")			
	{
		$storeid=returntablefield("productzuzhuang","billid",$_GET['billid'],"outstoreid");
		print "<script>location='DataQuery/productFrame.php?tablename=productzuzhuang_detail&deelname=产品组装单出库录入&rowid=".$_GET['billid']."&storeid=".$storeid."'</script>";
		exit;
	}
	if($_GET['action']=="edit_default3")			
	{
		$storeid=returntablefield("productzuzhuang","billid",$_GET['billid'],"instoreid");
		print "<script>location='DataQuery/productFrame.php?tablename=productzuzhuang2_detail&deelname=产品组装单入库录入&rowid=".$_GET['billid']."&storeid=".$storeid."'</script>";
		exit;
	}
	
	$filetablename		=	'productzuzhuang';
	$parse_filename		=	'productzuzhuang';
	addShortCutByDate("createtime","创建时间");
	require_once('include.inc.php');
	systemhelpContent("生产组装单说明",'100%');
	?>