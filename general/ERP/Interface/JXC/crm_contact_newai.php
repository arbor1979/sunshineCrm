<?php
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);
error_reporting(E_WARNING | E_ERROR);
require_once('lib.inc.php');
$GLOBAL_SESSION=returnsession();
$SYSTEM_PRIV_STOP = "1";
validateMenuPriv("���ټ�¼");

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
	//ͬ���޸Ļ����
	
	if($_POST[chance]!='')
	{
			
		$sql="update crm_chance set `�����ϵʱ��`='".$_POST[contacttime]."',`��ǰ�׶�`='".$_POST[stage]."' where `���`=".$_POST[chance];
		$rs=$db->Execute($sql);
	}

	//��������
	if(!empty($_POST[nextcontacttime])){
		$custName=returntablefield("customer", "rowid", $_POST[customerid], "supplyname");
		$url='../JXC/crm_contact_newai.php?'.base64_encode('action=view_default&id='.$id);
		newMessage($_POST[createman],'��ϵ�ͻ� '.$custName,'�ͻ���ϵ����',$url,$id,$_POST[nextcontacttime]);
		$EndTime=strtotime("$_POST[nextcontacttime] +1 hour");
		$EndTime=date("Y-m-d H:i:s",$EndTime);
		$url='../'.$url;
		newCalendar($_POST[createman],$_POST[nextcontacttime],$EndTime,'��ϵ�ͻ�','1',$custName.":".$_POST[nextissue],$url,$id);
	}
	
	$db->CompleteTrans();
	if ($db->HasFailedTrans()){
		print "<script language=javascript>alert('����".str_replace("'",  "\'", $db->ErrorMsg())."');window.history.back(-1);</script>";
		exit;
	}
	updateLastTrace($_POST[customerid]);
	$return=FormPageAction("action","init_default");
	print_infor("�½��ɹ�",'trip',"location='?$return'","?$return",1);
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
	//ͬ���޸Ļ����
	
	if($_POST[chance]!='')
	{
				
		$sql="update crm_chance set `�����ϵʱ��`='".$_POST[contacttime]."',`��ǰ�׶�`='".$_POST[stage]."'  where `���`='".$_POST[chance]."'";
		$rs=$db->Execute($sql);
	}

	deleteMessage('�ͻ���ϵ����',$id);
	deleteCalendar('��ϵ�ͻ�',$id);
	//��������
	if($_POST[nextcontacttime]!='')
	{
		$custName=returntablefield("customer", "rowid", $_POST[customerid], "supplyname");
		$url='../JXC/crm_contact_newai.php?'.base64_encode('action=view_default&id='.$id);
		newMessage($_POST[createman],'��ϵ�ͻ� '.$custName,'�ͻ���ϵ����',$url,$id,$_POST[nextcontacttime]);
		
		$EndTime=strtotime("$_POST[nextcontacttime] +1 hour");
		$EndTime=date("Y-m-d H:i:s",$EndTime);
		$url='../'.$url;
		newCalendar($_POST[createman],$_POST[nextcontacttime],$EndTime,'��ϵ�ͻ�','1',$custName.":".$_POST[nextissue],$url,$id);
	}
	$db->CompleteTrans();
	if ($db->HasFailedTrans()){
		print "<script language=javascript>alert('����".str_replace("'",  "\'", $db->ErrorMsg())."');window.history.back(-1);</script>";
		exit;
	}
	updateLastTrace($_POST[customerid]);
	$return=FormPageAction("action","init_default");
	print_infor("�޸ĳɹ�",'trip',"location='?$return'","?$return",1);
	exit;
}
if($_GET['action']=="delete_array"){
	$selectid=$_GET['selectid'];
	$selectid=explode(",", $selectid);
	for($i=0;$i<sizeof($selectid);$i++)
	{
		if($selectid[$i]!="")
		{
			deleteMessage('�ͻ���ϵ����',$selectid[$i]);
			deleteCalendar('��ϵ�ͻ� ',$selectid[$i]);
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
addShortCutByDate("contacttime","��ϵʱ��");
$SYSTEM_ADD_SQL =getCustomerRoleByCustID($SYSTEM_ADD_SQL,"customerid");
$limitEditDelCust='customerid';
//���ݱ�ģ���ļ�,��ӦModelĿ¼�����crm_contact_newai.ini�ļ�
//�������Ҫ���ƴ�ģ��,����Ҫ�޸�$parse_filename������ֵ,Ȼ���Ӧ��ModelĿ¼ ���ļ���_newai.ini�ļ�
$filetablename		=	'crm_contact';
$parse_filename		=	'crm_contact';
require_once('include.inc.php');

?>