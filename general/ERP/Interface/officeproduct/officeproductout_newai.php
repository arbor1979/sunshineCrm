<?php
require_once("lib.inc.php");

$GLOBAL_SESSION=returnsession();

require_once("systemprivateinc.php");

if($_GET['action']=="add_default_data" || $_GET['action']=="add_default")
	validateMenuPriv("�칫��Ʒ�嵥");
else
	validateMenuPriv("�����¼");
if($_GET['action']=="yes")		{
	global $db;
	$billinfo=returntablefield("officeproductout", "���", $_GET['���'], "�칫��Ʒ���,��������,����ֿ�");
	$num=$billinfo['��������'];
	$prodid=$billinfo['�칫��Ʒ���'];
	$storeid=$billinfo['����ֿ�'];
	$kucun=returntablefield("officeproduct", "�칫��Ʒ���", $prodid, "����","��ŵص�",$storeid);
	if($kucun<$num)
	{
		print "<script language=javascript>alert('�˱�ŵİ칫��Ʒ��治��');window.history.back(-1);</script>";
		exit;	
	}
	$sql="update officeproduct set ����=����-$num,�ϼƽ��=round(����*����,2) where �칫��Ʒ���='$prodid' and ��ŵص�='$storeid'";
	$db->Execute($sql);
	$sql="update officeproductout set `�������`=2,`���ʱ��`='".date('Y-m-d H:m:s')."' where `���`='".$_GET['���']."'";
	$db->Execute($sql);
	page_css();
	$return=FormPageAction("action","init_default");
	print_infor("���������",'trip',"location='?$return'","?$return",0);
	exit;
}
if($_GET['action']=="no")		{
	global $db;
	$sql="update officeproductout set `�������`=3,`���ʱ��`='".date('Y-m-d H:m:s')."' where `���`='".$_GET['���']."'";
	$db->Execute($sql);
	page_css();
	$return=FormPageAction("action","init_default");
	print_infor("�����ѷ��",'trip',"location='?$return'","?$return",0);
	exit;
}
if($_GET['action']=="guihuan")		{
	global $db;
	$billinfo=returntablefield("officeproductout", "���", $_GET['���'], "�칫��Ʒ���,��������,����ֿ�");
	$num=$billinfo['��������'];
	$prodid=$billinfo['�칫��Ʒ���'];
	$storeid=$billinfo['����ֿ�'];
	$sql="update officeproduct set ����=����+$num,�ϼƽ��=round(����*����,2) where �칫��Ʒ���='$prodid' and ��ŵص�='$storeid'";
	$db->Execute($sql);
	$sql="update officeproductout set `�Ƿ�黹`=2,`�黹������`='".$_SESSION['LOGIN_USER_ID']."',`ʵ�ʹ黹����`='".date('Y-m-d H:m:s')."' where `���`='".$_GET['���']."'";
	$db->Execute($sql);
	page_css();
	$return=FormPageAction("action","init_default");
	print_infor("������Ϊ�黹",'trip',"location='?$return'","?$return",0);
	exit;
}
if($_GET['action']=="add_default_data")		
{
	if($_POST['��׼��']=='')
	{
		print "<script language=javascript>alert('����˲���Ϊ��');window.history.back(-1);</script>";
		exit;	
	}
	if($_POST['�黹����']=='')
	{
		$_POST['�Ƿ�黹']='0';
	}
	else
		$_POST['�Ƿ�黹']='1';
	$username=returntablefield("user","user_id", $_POST['������'],"user_name");
	$title="���� $username �Ľ�������,��칫��Ʒ ".$_POST['�칫��Ʒ����']." ������".$_POST['��������'];
	$messagetitle="��������";
	$guanlianid=$_POST['���'];
	$url="../officeproduct/officeproductout_newai.php?".base64_encode("action=init_default_search&searchfield=���&searchvalue=$guanlianid");
	newMessage($_POST['��׼��'],$title,$messagetitle,$url,$guanlianid);
}
$filetablename='officeproductout';
require_once('include.inc.php');
?>