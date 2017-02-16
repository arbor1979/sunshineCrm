<?php
require_once("lib.inc.php");

$GLOBAL_SESSION=returnsession();

require_once("systemprivateinc.php");

if($_GET['action']=="add_default_data" || $_GET['action']=="add_default")
	validateMenuPriv("办公用品清单");
else
	validateMenuPriv("借领记录");
if($_GET['action']=="yes")		{
	global $db;
	$billinfo=returntablefield("officeproductout", "编号", $_GET['编号'], "办公用品编号,出库数量,出库仓库");
	$num=$billinfo['出库数量'];
	$prodid=$billinfo['办公用品编号'];
	$storeid=$billinfo['出库仓库'];
	$kucun=returntablefield("officeproduct", "办公用品编号", $prodid, "数量","存放地点",$storeid);
	if($kucun<$num)
	{
		print "<script language=javascript>alert('此编号的办公用品库存不足');window.history.back(-1);</script>";
		exit;	
	}
	$sql="update officeproduct set 数量=数量-$num,合计金额=round(数量*单价,2) where 办公用品编号='$prodid' and 存放地点='$storeid'";
	$db->Execute($sql);
	$sql="update officeproductout set `否是审核`=2,`审核时间`='".date('Y-m-d H:m:s')."' where `编号`='".$_GET['编号']."'";
	$db->Execute($sql);
	page_css();
	$return=FormPageAction("action","init_default");
	print_infor("申请已审核",'trip',"location='?$return'","?$return",0);
	exit;
}
if($_GET['action']=="no")		{
	global $db;
	$sql="update officeproductout set `否是审核`=3,`审核时间`='".date('Y-m-d H:m:s')."' where `编号`='".$_GET['编号']."'";
	$db->Execute($sql);
	page_css();
	$return=FormPageAction("action","init_default");
	print_infor("申请已否决",'trip',"location='?$return'","?$return",0);
	exit;
}
if($_GET['action']=="guihuan")		{
	global $db;
	$billinfo=returntablefield("officeproductout", "编号", $_GET['编号'], "办公用品编号,出库数量,出库仓库");
	$num=$billinfo['出库数量'];
	$prodid=$billinfo['办公用品编号'];
	$storeid=$billinfo['出库仓库'];
	$sql="update officeproduct set 数量=数量+$num,合计金额=round(数量*单价,2) where 办公用品编号='$prodid' and 存放地点='$storeid'";
	$db->Execute($sql);
	$sql="update officeproductout set `是否归还`=2,`归还接收人`='".$_SESSION['LOGIN_USER_ID']."',`实际归还日期`='".date('Y-m-d H:m:s')."' where `编号`='".$_GET['编号']."'";
	$db->Execute($sql);
	page_css();
	$return=FormPageAction("action","init_default");
	print_infor("已设置为归还",'trip',"location='?$return'","?$return",0);
	exit;
}
if($_GET['action']=="add_default_data")		
{
	if($_POST['批准人']=='')
	{
		print "<script language=javascript>alert('审核人不能为空');window.history.back(-1);</script>";
		exit;	
	}
	if($_POST['归还期限']=='')
	{
		$_POST['是否归还']='0';
	}
	else
		$_POST['是否归还']='1';
	$username=returntablefield("user","user_id", $_POST['申请人'],"user_name");
	$title="来自 $username 的借领申请,需办公用品 ".$_POST['办公用品名称']." 数量：".$_POST['出库数量'];
	$messagetitle="借领申请";
	$guanlianid=$_POST['编号'];
	$url="../officeproduct/officeproductout_newai.php?".base64_encode("action=init_default_search&searchfield=编号&searchvalue=$guanlianid");
	newMessage($_POST['批准人'],$title,$messagetitle,$url,$guanlianid);
}
$filetablename='officeproductout';
require_once('include.inc.php');
?>