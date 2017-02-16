<?php
	require_once("lib.inc.php");

	$GLOBAL_SESSION=returnsession();
	require_once("systemprivateinc.php");
	validateMenuPriv("办公用品清单");
	
	
	$productInfo=returntablefield("officeproduct", "编号", $_GET['编号'], "办公用品编号,办公用品名称,存放地点");
	$办公用品编号=$productInfo['办公用品编号'];
	$办公用品名称=$productInfo['办公用品名称'];
	$仓库=$productInfo['存放地点'];
	if($_GET['action']=="ruku")		{
		
		print "<script>location.href='officeproductin_newai.php?".base64_encode("action=add_default&办公用品编号=$办公用品编号&办公用品编号_disabled=disabled&办公用品名称=$办公用品名称&办公用品名称_disabled=disabled&入库仓库=$仓库&入库仓库_disabled=disabled")."';</script>";
		exit;
	}
	if($_GET['action']=="jieyong")		{

		print "<script>location.href='officeproductout_newai.php?".base64_encode("action=add_default&办公用品编号=$办公用品编号&办公用品编号_disabled=disabled&办公用品名称=$办公用品名称&办公用品名称_disabled=disabled&出库仓库=$仓库&出库仓库_disabled=disabled")."';</script>";
		exit;
	}
	if($_GET['action']=="diaobo")		{

		print "<script>location.href='officeproducttiaoku_newai.php?".base64_encode("action=add_default&办公用品编号=$办公用品编号&办公用品编号_disabled=disabled&办公用品名称=$办公用品名称&办公用品名称_disabled=disabled&调出仓库=$仓库&调出仓库_disabled=disabled")."';</script>";
		exit;
	}
	if($_GET['action']=="baofei")		{

		print "<script>location.href='officeproductbaofei_newai.php?".base64_encode("action=add_default&办公用品编号=$办公用品编号&办公用品编号_disabled=disabled&办公用品名称=$办公用品名称&办公用品名称_disabled=disabled&所属仓库=$仓库&所属仓库_disabled=disabled")."';</script>";
		exit;
	}
	if($_GET['action']=="add_default")
	{
		$sql="select * from officeproductcangku";
		$rs=$db->Execute($sql);
		$rs_a=$rs->GetArray();
		$userlist='';
		foreach ($rs_a as $row)
		{
			$userlist=$userlist.$row['仓库负责人'];
		}
		$userArray=explode(",", $userlist);
		if(!in_array($_SESSION['LOGIN_USER_ID'],$userArray))
		{
			print "<script language=javascript>alert('只有仓库负责人有权限新建，请在【仓库设置】中设置仓库负责人');window.history.go(-1);</script>";
			exit;	
		}
	}
	if($_GET['action']=="add_default_data")		{
		$id=returntablefield("officeproduct", "办公用品编号", $_POST["办公用品编号"], "办公用品编号","存放地点",$_POST["存放地点"]);
		if($id!='')
		{
			print "<script language=javascript>alert('此仓库已存在此编号的办公用品，不能保存');window.history.back(-1);</script>";
			exit;	
		}
	}




$filetablename='officeproduct';
require_once('include.inc.php');
?>