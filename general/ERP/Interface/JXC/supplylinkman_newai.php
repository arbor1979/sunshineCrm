<?php
/*
��Ȩ����:֣�ݵ���Ƽ�������޹�˾;
��ϵ��ʽ:0371-69663266;
��˾��ַ:����֣�ݾ��ü��������������־�����·ͨ�Ų�ҵ԰��¥����;
��˾���:֣�ݵ���Ƽ�������޹�˾λ���й��в�����-֣��,������2007��1��,�����ڰѻ����Ƚ���Ϣ����������ͨ�ż���������ѹ�����ҵ��ʵ���ռ���������ҵ�ͻ��Ĺ�����ҵ���»�У�ȫ���ṩ��������֪ʶ��Ȩ�Ľ�����������������������������в�������ĸ�У���������������СѧУ��������ṩ�̡�Ŀǰ�����ж�Ҹ�ְ����ְ��ԺУʹ��ͨ���в��з����Ŀ���������ͷ���;

�������:����Ƽ�������������Լܹ�ƽ̨,�Լ��������֮����չ���κ��������Ʒ;
����Э��:���ֻ�У԰��ƷΪ��ҵ���,�������ΪLICENSE��ʽ;����CRMϵͳ��SunshineCRMϵͳΪGPLV3Э�����,GPLV3Э����������뵽�ٶ�����;
��������:�����ʹ�õ�ADODB��,PHPEXCEL��,SMTARY���ԭ��������,���´���������������;
*/
ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL);
	error_reporting(E_WARNING | E_ERROR);
	require_once('lib.inc.php');
	$GLOBAL_SESSION=returnsession();
validateMenuPriv("��Ӧ����ϵ��");

$supplyid=$_GET['supplyid'];
if($supplyid!='' && $_GET['action']=='add_default')
{
	$ADDINIT=array("supplyid"=>$supplyid);
}

	if($_GET['action']=="edit_default_data"||$_GET['action']=="add_default_data")		{
		$_POST['supplycn'] = ����תƴ������ĸ($_POST['supplyname']);
		
	}
	
	if($_GET['action']=='operation_sendsms')
{
	validateMenuPriv("�ֻ�����");
	$selectid=$_GET['selectid'];
	print "<script>location='sms_sendlist_newai.php?action=add_default&fromsrc=supply&sendlist=".$selectid."'</script>";
	exit;
	
}
if($_GET['action']=='operation_sendemail')
{
	validateMenuPriv("�����ʼ�");
	$selectid=$_GET['selectid'];
	print "<script>location='../CRM/email_newai.php?action=add_default&fromsrc=supply&sendlist=".$selectid."';</script>";
	exit;
	
}
if($_GET['action']=='operation_printKuaiDi')
{
	
	$selectid=$_GET['selectid'];
	print "<script>
	location.href='../CRM/printKuaiDi.php?CustOrSupply=supply&linkmanlist=$selectid',null,'height=500,width=600,status=1,toolbar=no,menubar=no,location=no,scrollbars=no,resizable=yes';
	</script>";
	exit;
	
}
$filetablename = "supplylinkman";
require_once( "include.inc.php" );
?>
