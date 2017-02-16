<?php
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);
error_reporting(E_WARNING | E_ERROR);
require_once('lib.inc.php');
$GLOBAL_SESSION=returnsession();
$SYSTEM_PRIV_STOP = "1";
validateMenuPriv("发货单");

if($_GET['action']=="edit_default2")
{
	print "<script>location='fahuodan_queren.php?billid=".$_GET['billid']."&url=".$_SERVER["PHP_SELF"]."'</script>";
	exit;
}
//确认发货
if($_GET['action']=="edit_default2_data")
{
	//print_r($_SESSION);exit;
	$Store=new Store($db);
	$CaiWu=new CaiWu($db);
	$db->StartTrans();

	$return=$_POST['url'];
	$yunfei=floatvalue($_POST['yunfei']);
	$jiesuantype=floatvalue($_POST['jiesuantype']);
	$fahuoinfo=returntablefield("fahuodan", "billid",$_POST['billid'], "outtype,customerid");
	$outtype=$fahuoinfo['outtype'];
	$customerid=$fahuoinfo['customerid'];
	
	if($outtype=="销售出库")	
		$supplyname=returntablefield("customer", "rowid", $customerid, "supplyname");
	else if($outtype=='返厂出库')
		$supplyname=returntablefield("supply", "rowid", $customerid, "supplyname");

	//先付运费生成费用
	if($yunfei!=0 && $jiesuantype==1)
	{
		$CaiWu->insertFeiYongAccount(6,$yunfei,1,$_SESSION['LOGIN_USER_ID'],-1,'','发货单：'.$_POST['billid']."(".$supplyname.")");
	}
	
	//确认发货
	$dingdanid=$Store->confirmFaHuo($_POST['billid'],$_POST['fahuodan'],$_POST['shouhuoren'],$_POST['address'],$_POST['tel'],
	$_POST['mailcode'],$_POST['fahuotype'],floatvalue($_POST['package']),floatvalue($_POST['weight']),$yunfei,$_POST['jiesuantype'],$_POST['beizhu']);
	

	//是否事务出现错误
	if ($db->HasFailedTrans())
	print "<script language=javascript>alert('错误：".str_replace("'",  "\'", $db->ErrorMsg())."');window.history.back(-1);</script>";
	else
	{
		if($_POST[duanxintongzhi] == 'yes'){
			//给客户发送提示短信
			$sql="select a.package,a.weight,b.name as fahuotype,a.tel FROM fahuodan a left join fahuotype b on a.fahuotype=b.id  WHERE a.billid=".trim($_POST['billid']);
			$rs=$db->Execute($sql);
			$rs_a = $rs->GetArray();
			$yunfei = $jiesuantype==2?$yunfei.'元':'0元(包邮)';
			$message = "【发货提醒】".$_SESSION[UNIT_NAME].date("Y-m-d H:i:s")."向你单位发货".$rs_a[0][package]."件,发货人：".$_SESSION[LOGIN_USER_NAME].',物流公司:'.$rs_a[0][fahuotype];
			//$sql = 'INSERT INTO sms_sendlist(msg,nowtime,destcount,userid,destid,result) VALUES("'.$message.'",now(),1,"'.$_SESSION[LOGIN_USER_ID].'","'.$rs_a[0][tel].'","待发")';
			//$rs=$db->Execute($sql);
			
			print "\n<script type=\"text/javascript\" language=\"javascript\" src=\"".ROOT_DIR."general/ERP/Enginee/jquery/jquery.js\"></script>\n";
			print "<script type=\"text/javascript\" language=\"javascript\">
			$.post('../Framework/sms_getContents.php?action=send', {
			    mobiles:'".$rs_a[0][tel]."',
			    msg:'".cutStr($message,70)."'
			}, function(data) {	
			});
		</script>";		
		}
		page_css("确认发货");
		if($return=='')
		{
			$return=FormPageAction("action","init_default");

		}
		print_infor("发货单确认成功",'trip',"location='?$return'","?$return",0);
			
	}
	$db->CompleteTrans();
	exit;
}
//撤销发货
if($_GET['action']=="chexiao")
{

	$Store=new Store($db);
	$CaiWu=new CaiWu($db);
	$db->StartTrans();
	$fahuoinfo=returntablefield("fahuodan", "billid", $_GET['billid'], "yunfei,jiesuantype,dingdanbillid,outtype,customerid");

	$yunfei=$fahuoinfo['yunfei'];
	$jiesuantype=$fahuoinfo['jiesuantype'];
	$dingdanbillid=$fahuoinfo['dingdanbillid'];
	$outtype=$fahuoinfo['outtype'];
	$customerid=$fahuoinfo['customerid'];
	
	if($outtype=="销售出库")	
		$supplyname=returntablefield("customer", "rowid", $customerid, "supplyname");
	else if($outtype=='返厂出库')
		$supplyname=returntablefield("supply", "rowid", $customerid, "supplyname");
		
	//撤销运费
	if($yunfei!=0 && $jiesuantype==1)
	{
		$CaiWu->insertFeiYongAccount(6,-$yunfei,1,$_SESSION['LOGIN_USER_ID'],-1,'','撤销发货单：'.$_GET['billid']."(".$supplyname.")");
	}
	//撤销发货
	$Store->cancelFaHuo($_GET['billid']);



	//是否事务出现错误
	if ($db->HasFailedTrans())
	print "<script language=javascript>alert('错误：".str_replace("'",  "\'", $db->ErrorMsg())."');window.history.back(-1);</script>";
	else
	{
		page_css("撤销发货");
		$return=FormPageAction("action","init_default");
		print_infor("发货单撤销成功",'trip',"location='?$return'","?$return",0);
	}
	$db->CompleteTrans();
	exit;
}
if($_GET['action']=='printKuaiDi')
{
	
	$selectid=$_GET['billid'];
	print "<script>location.href='../CRM/printKuaiDi.php?CustOrSupply=fahuodan&linkmanlist=$selectid',null,'height=600,width=855,status=1,toolbar=no,menubar=no,location=no,scrollbars=yes,resizable=yes';</script>";
	exit;
	
}
addShortCutByDate("fahuodate","发货日期");
$filetablename		=	'fahuodan';
$parse_filename		=	'fahuodan';
require_once('include.inc.php');
?>