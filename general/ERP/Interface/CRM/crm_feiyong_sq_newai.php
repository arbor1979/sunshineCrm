<?php
	ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL);
	error_reporting(E_WARNING | E_ERROR);
	require_once('lib.inc.php');
	$GLOBAL_SESSION=returnsession();
	$SYSTEM_PRIV_STOP = "1";
	validateMenuPriv("��������");	
	//$SYSTEM_PRINT_SQL = 1;
	//print_r($_GET);exit;
	$customerid=$_GET['�ͻ�����'];
	if($customerid!='' && $_GET['action']=='add_default')
	{
		$ADDINIT=array("�ͻ�����"=>$customerid);
	}
	if($_GET['action']=="edit_TongYi")		{

		page_css();
		$billid = $_GET['����'];
		$sql = "update crm_feiyong_sq set �Ƿ����='2',�����='".$_SESSION['LOGIN_USER_ID']."',�������=now() where ����='$billid'";
		$rs = $db->Execute($sql);
		$billinfo=returntablefield("crm_feiyong_sq","����",$billid,"��������,���,¼��Ա");
		$feiyongname=returntablefield("v_feiyongbaoxiao","id",$billinfo['��������'],"typename");
		newMessage($billinfo['¼��Ա'],$feiyongname.'(���:'.$billinfo['���'].')--��ͨ����','��������','../CRM/crm_feiyong_sq_newai.php?'.base64_encode('action=view_default&����='.$billid),$billid);
		$return=FormPageAction("action","init_default");
		print_infor("<b>���ͨ��</b>",'trip',"location='?$return'","?".$return,1);
		exit;
	}
	if($_GET['action']=="edit_FouJue")		{
		page_css();
		$billid = $_GET['����'];
		$sql = "update crm_feiyong_sq set �Ƿ����='3',�����='".$_SESSION['LOGIN_USER_ID']."',�������=now() where ����='$billid'";
		$rs = $db->Execute($sql);
		$return=FormPageAction("action","init_default");
		print_infor("<b>��˷��</b>",'trip',"location='?$return'","?".$return,1);
		exit;
		
	}
	$SYSTEM_ADD_SQL =getRoleByUser($SYSTEM_ADD_SQL,"¼��Ա");
	addShortCutByDate("����ʱ��","����ʱ��");
	$filetablename		=	'crm_feiyong_sq';
	$parse_filename		=	'crm_feiyong_sq';
	require_once('include.inc.php');

	
	?>