<?php
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);
error_reporting(E_WARNING | E_ERROR);
require_once('lib.inc.php');
$GLOBAL_SESSION=returnsession();
$SYSTEM_PRIV_STOP = "1";
validateMenuPriv("跟踪记录");

$customerid=$_GET['customerid'];
if($customerid!='' && $_GET['action']=='add_default')
{
	$ADDINIT=array("customerid"=>$customerid,"linkmanid"=>$_GET['linkmanid'],"chance"=>$_GET['chance']);
}
	
if($_GET['action']=="add_default_data"){	
	
	require_once("../Framework/uploadFile.php");
	uploadFile();
		
	page_css();
	$db->StartTrans();  
	$sql = "select max(id) as max from crm_contact";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	$id = $rs_a[0]['max']+1;
	
	$SQL = "INSERT INTO crm_contact(id,customerid,linkmanid,chance,user_id,createman,contact,stage,describes,createtime,contacttime,nextcontacttime,nextissue,alreadycontact,priority,public) value(".$id.",'".$_POST[customerid]."','".$_POST[linkmanid]."','".$_POST[chance]."','".$_POST[user_id]."','".$_POST[createman]."','".$_POST[contact]."','".$_POST[stage]."','".$_POST[describes]."','".$_POST[createtime]."','".$_POST[contacttime]."','".$_POST[nextcontacttime]."','".$_POST[nextissue]."','".$_POST[alreadycontact]."','".$_POST[priority]."','".$_POST['public']."')";
	$rs=$db->Execute($SQL);
	//同步修改机会表
	
	if($_POST[chance]!='')
	{
			
		$sql="update crm_chance set `最后联系时间`='".$_POST[contacttime]."',`当前阶段`='".$_POST[stage]."' where `编号`=".$_POST[chance];
		$rs=$db->Execute($sql);
	}

	//设置提醒
	if(!empty($_POST[nextcontacttime])){
		$custName=returntablefield("customer", "rowid", $_POST[customerid], "supplyname");
		$url='../JXC/crm_contact_newai.php?'.base64_encode('action=view_default&id='.$id);
		newMessage($_POST[createman],'联系客户 '.$custName,'客户联系提醒',$url,$id,$_POST[nextcontacttime]);
		$EndTime=strtotime("$_POST[nextcontacttime] +1 hour");
		$EndTime=date("Y-m-d H:i:s",$EndTime);
		$url='../'.$url;
		newCalendar($_POST[createman],$_POST[nextcontacttime],$EndTime,'联系客户','1',$custName.":".$_POST[nextissue],$url,$id);
	}
	
	$db->CompleteTrans();
	if ($db->HasFailedTrans()){
		print "<script language=javascript>alert('错误：".str_replace("'",  "\'", $db->ErrorMsg())."');window.history.back(-1);</script>";
		exit;
	}
	updateLastTrace($_POST[customerid]);
	$return=FormPageAction("action","init_default");
	print_infor("新建成功",'trip',"location='?$return'","?$return",1);
	exit;
}
if($_GET['action']=="edit_default_data"){
	
	
	$attachment_old=returntablefield("crm_contact", "id", $_GET[id], "public");
	$attachment_old_array=explode("||",$attachment_old);
	$ATTACHMENT_ID_OLD=$attachment_old_array[1];
	$ATTACHMENT_NAME_OLD=$attachment_old_array[0];
	
	require_once("../Framework/uploadFile.php");
	uploadFile();
	
	page_css();
	$db->StartTrans();  
	$SQL = "update crm_contact set customerid='".$_POST[customerid]."',linkmanid='".$_POST[linkmanid]."',chance='".$_POST[chance]."',user_id='".$_POST[user_id]."',createman='".$_POST[createman]."',contact='".$_POST[contact]."',stage='".$_POST[stage]."',describes='".$_POST[describes]."',createtime='".$_POST[createtime]."',contacttime='".$_POST[contacttime]."',nextcontacttime='".$_POST[nextcontacttime]."',nextissue='".$_POST[nextissue]."',alreadycontact='".$_POST[alreadycontact]."',priority='".$_POST[priority]."',public='".$_POST['public']."' where id=".intval($_GET[id]);
	$rs=$db->Execute($SQL);
	$id = $_GET[id];
	//同步修改机会表
	
	if($_POST[chance]!='')
	{
				
		$sql="update crm_chance set `最后联系时间`='".$_POST[contacttime]."',`当前阶段`='".$_POST[stage]."'  where `编号`='".$_POST[chance]."'";
		$rs=$db->Execute($sql);
	}

	deleteMessage('客户联系提醒',$id);
	deleteCalendar('联系客户',$id);
	//设置提醒
	if($_POST[nextcontacttime]!='')
	{
		$custName=returntablefield("customer", "rowid", $_POST[customerid], "supplyname");
		$url='../JXC/crm_contact_newai.php?'.base64_encode('action=view_default&id='.$id);
		newMessage($_POST[createman],'联系客户 '.$custName,'客户联系提醒',$url,$id,$_POST[nextcontacttime]);
		
		$EndTime=strtotime("$_POST[nextcontacttime] +1 hour");
		$EndTime=date("Y-m-d H:i:s",$EndTime);
		$url='../'.$url;
		newCalendar($_POST[createman],$_POST[nextcontacttime],$EndTime,'联系客户','1',$custName.":".$_POST[nextissue],$url,$id);
	}
	$db->CompleteTrans();
	if ($db->HasFailedTrans()){
		print "<script language=javascript>alert('错误：".str_replace("'",  "\'", $db->ErrorMsg())."');window.history.back(-1);</script>";
		exit;
	}
	updateLastTrace($_POST[customerid]);
	$return=FormPageAction("action","init_default");
	print_infor("修改成功",'trip',"location='?$return'","?$return",1);
	exit;
}
if($_GET['action']=="delete_array"){
	$selectid=$_GET['selectid'];
	$selectid=explode(",", $selectid);
	for($i=0;$i<sizeof($selectid);$i++)
	{
		if($selectid[$i]!="")
		{
			deleteMessage('客户联系提醒',$selectid[$i]);
			deleteCalendar('联系客户 ',$selectid[$i]);
			$getcustomerid=returntablefield("crm_contact", "id",$selectid[$i],"customerid");
			updateLastTrace($getcustomerid);
		}

	}

}
function updateLastTrace($customerid)
{
	global $db;
	$sql="select max(contacttime) as maxtime from crm_contact where customerid='".$customerid."'";
	$rs=$db->Execute($sql);
	$rs_a=$rs->GetArray();
	if($rs_a[0]['maxtime']!='')
		$sql="update customer set `lasttracetime`='".$rs_a[0]['maxtime']."' where (`lasttracetime` is null or `lasttracetime`<'".$rs_a[0]['maxtime']."') and `rowid`=".$customerid;
	else 
		$sql="update customer set `lasttracetime`=null where `rowid`=".$customerid;
	$rs=$db->Execute($sql);
}
addShortCutByDate("contacttime","联系时间");
$SYSTEM_ADD_SQL =getCustomerRoleByCustID($SYSTEM_ADD_SQL,"customerid");
$limitEditDelCust='customerid';
//数据表模型文件,对应Model目录下面的crm_contact_newai.ini文件
//如果是需要复制此模块,则需要修改$parse_filename参数的值,然后对应到Model目录 新文件名_newai.ini文件
$filetablename		=	'crm_contact';
$parse_filename		=	'crm_contact';
require_once('include.inc.php');

?>