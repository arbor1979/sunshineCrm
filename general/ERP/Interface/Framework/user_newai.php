<?php
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);

// display warnings and errors
error_reporting(E_WARNING | E_ERROR);
//######################�������-Ȩ�޽��鲿��##########################
require_once("lib.inc.php");
$GLOBAL_SESSION=returnsession();
$SYSTEM_PRIV_STOP = 1;
require_once("systemprivateinc.php");
validateMenuPriv("�û�����");
//CheckSystemPrivate("ϵͳ��Ϣ����-��֯��������");
//######################�������-Ȩ�޽��鲿��##########################


if($_GET['action']=='operation_sendsms')
{
	validateMenuPriv("�ֻ�����");
	$selectid=$_GET['selectid'];
	print "<script>location.href='../JXC/sms_sendlist_newai.php?action=add_default&fromsrc=user&sendlist=".$selectid."'</script>";
	exit;
	
}
if($_GET['action']=='operation_menubatch')
{
	$_GET['action']="edit_purview";
}

if($_GET['action']=="delete_array")			
{
	$selectid=$_GET['selectid'];
	$selectid=explode(",", $selectid);
	for($i=0;$i<sizeof($selectid);$i++)
	{
		
		if($selectid[$i]!="")
		{
			$userid=returntablefield("user", "uid", $selectid[$i], "user_id");
			$rowid=returntablefield("customer", "sysuser", $userid, "rowid");
			if($rowid!='')
			{
				print "<script language=javascript>alert('�пͻ������ڴ��û��������ƽ��ͻ�����');window.history.back(-1);</script>";
    			exit;
			}
			
		}
	}
}

	if($_GET['action']=="add_default_data")		{
		global $db;
		$_POST['PASSWORD']	= crypt("");
		$_POST['USER_ID']	=trim($_POST['USER_ID']);
		$_POST['USER_NAME']	=trim($_POST['USER_NAME']);
		$_POST['THEME']		= '3';
	}

	if($_GET['action']=="operation_clearpassword"&&$_GET['selectid']!="")				{
		$PASSWORD	= crypt("");
		$selectidArray = explode(',',$_GET['selectid']);
		$TempValue = sizeof($selectidArray)-2;
		for($i=0;$i<sizeof($selectidArray);$i++)			{
			$selectidValue = $selectidArray[$i];
			if($selectidValue!="")				{
				$sql = "update user set PASSWORD='$PASSWORD' where UID='$selectidValue'";
				$db->Execute($sql);
			}
		}
		page_css("���Ĳ������ɹ�");
		print_infor("���Ĳ������ɹ�,�뷵��....",'',"location='?'","?");
		exit;
	}



	//���ݱ�ģ���ļ�,��ӦModelĿ¼�����user_newai.ini�ļ�
	//�������Ҫ���ƴ�ģ��,����Ҫ�޸�$parse_filename������ֵ,Ȼ���Ӧ��ModelĿ¼ ���ļ���_newai.ini�ļ�
	$filetablename		=	'user';
	$parse_filename		=	'user';
	$SYSTEM_ADD_SQL=getRoleByUser($SYSTEM_ADD_SQL,"user_id");
	require_once('include.inc.php');
	systemhelpContent("ϵͳ�û�����",'100%');
	?><?php
/*
	��Ȩ����:֣�ݵ���Ƽ�������޹�˾;
	��ϵ��ʽ:0371-69663266;
	��˾��ַ:����֣�ݾ��ü��������������־�����·ͨ�Ų�ҵ԰��¥����;
	��˾���:֣�ݵ���Ƽ�������޹�˾λ���й��в�����-֣��,������2007��1��,�����ڰѻ����Ƚ���Ϣ����������ͨ�ż���������ѹ�����ҵ��ʵ���ռ���������ҵ�ͻ��Ĺ�����ҵ���»�У�ȫ���ṩ��������֪ʶ��Ȩ�Ľ�����������������������������в�������ĸ�У���������������СѧУ��������ṩ�̡�Ŀǰ�����ж�Ҹ�ְ����ְ��ԺУʹ��ͨ���в��з����Ŀ���������ͷ���;

	�������:����Ƽ�������������Լܹ�ƽ̨,�Լ��������֮����չ���κ��������Ʒ;
	����Э��:���ֻ�У԰��ƷΪ��ҵ���,�������ΪLICENSE��ʽ;����CRMϵͳ��SunshineCRMϵͳΪGPLV3Э�����,GPLV3Э����������뵽�ٶ�����;
	��������:�����ʹ�õ�ADODB��,PHPEXCEL��,SMTARY���ԭ��������,���´���������������;
	*/
?>