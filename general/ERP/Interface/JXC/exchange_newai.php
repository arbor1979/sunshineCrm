<?php
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);
error_reporting(E_WARNING | E_ERROR);
require_once('lib.inc.php');
$GLOBAL_SESSION=returnsession();
$SYSTEM_PRIV_STOP = "1";
validateMenuPriv("积分兑换");

$customerid=$_GET['customerid'];
if($customerid!='' && $_GET['action']=='add_default')
{
	$ADDINIT=array("customid"=>$customerid);
}

if($_GET['action']=="add_default_data"){
	global $db;
	$sql = "select integral from customer where ROWID='".$_POST[customid]."'";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	$integral = $rs_a[0][integral];
	if($integral<$_POST['integral']){
		print "<script language=javascript>alert('积分不够，不能兑换！');window.history.back(-1);</script>";
		exit;
	}
	if(intval($_POST['exchangenum'])>intval($_POST['integral'])){
		print "<script language=javascript>alert('兑换储值的金额不能大于积分！');window.history.back(-1);</script>";
		exit;
	}
	
	if(intval($_POST[exchangenum]) <= 0){
		print "<script language=javascript>alert('兑换储值必须大于0！');window.history.back(-1);</script>";
		exit;
	}
	if(intval($_POST[integral]) <= 0){
		print "<script language=javascript>alert('兑换积分必须大于0！');window.history.back(-1);</script>";
		exit;
	}
	try {

		// 插入数据
		$db->StartTrans();
		//$db->debug=1;
		$CaiWu =new CaiWu($db);
		$Store =new Store($db);
		$CaiWu->exchangeJifen($_POST);
		$db->CompleteTrans();
		page_css("积分兑换");
		if ($db->HasFailedTrans()){
			throw  new Exception($db->ErrorMsg());
		
		}
		else
		{
			
			$return=FormPageAction("action","init_default");
			print_infor("兑换成功！",'trip',"location='?$return'","?$return",1);
		

		}
	}
	catch (Exception $e)
	{
		print "<script language=javascript>alert('错误：".$e->getMessage()."');window.history.back(-1);</script>";
	}
	exit;
	
}

if($_GET['action']=="delete_array"){
	global $db;

	$db->StartTrans();
	//$db->debug=1;
	$CaiWu =new CaiWu($db);
	$Store =new Store($db);

	$delete_array = array();
	$delete_array = explode(',', trim($_GET[selectid]));
	foreach ($delete_array as $id){

		$CaiWu->cancelExchangeJifen($id);
	}
	$db->CompleteTrans();
	if ($db->HasFailedTrans()){
		print "<script language=javascript>alert('错误：".str_replace("'",  "\'", $db->ErrorMsg())."');window.history.back(-1);</script>";
		exit;
	}
	
	page_css("删除成功");
	$return=FormPageAction("action","init_default");
	print_infor("删除成功！",'trip',"location='?$return'","?$return",1);
	exit;
	
}

//数据表模型文件,对应Model目录下面的exchange_newai.ini文件
//如果是需要复制此模块,则需要修改$parse_filename参数的值,然后对应到Model目录 新文件名_newai.ini文件
addShortCutByDate("createtime","兑换时间");
$SYSTEM_ADD_SQL =getCustomerRoleByCustID($SYSTEM_ADD_SQL,"customid");
$limitEditDelCust='customid';
$filetablename		=	'exchange';
$parse_filename		=	'exchange';
require_once('include.inc.php');
?>